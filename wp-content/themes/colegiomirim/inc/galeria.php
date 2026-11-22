<?php

function mirim_editing_galeria() {
	if ( ! is_admin() ) {
		return false;
	}
	$post_id = isset( $_GET['post'] ) ? absint( $_GET['post'] ) : 0;
	if ( ! $post_id && isset( $_POST['post_ID'] ) ) {
		$post_id = absint( $_POST['post_ID'] );
	}
	if ( ! $post_id ) {
		return false;
	}
	return 'galeria' === get_post_field( 'post_name', $post_id );
}

add_filter( 'use_block_editor_for_post', 'mirim_galeria_classic_editor', 10, 2 );

function mirim_galeria_classic_editor( $use, $post ) {
	if ( $post instanceof WP_Post && 'galeria' === $post->post_name ) {
		return false;
	}
	return $use;
}

add_action( 'admin_head', 'mirim_galeria_hide_editor' );

function mirim_galeria_hide_editor() {
	if ( ! mirim_editing_galeria() ) {
		return;
	}
	echo '<style>#postdivrich{display:none}</style>';
}

add_action( 'edit_form_after_title', 'mirim_galeria_editor_note' );

function mirim_galeria_editor_note( $post ) {
	if ( ! $post instanceof WP_Post || 'galeria' !== $post->post_name ) {
		return;
	}
	echo '<p class="description">O título acima é o nome da página. Os textos e as fotos de cada bloco ficam nas seções abaixo.</p>';
}

add_action( 'add_meta_boxes', 'mirim_galeria_metabox' );

function mirim_galeria_metabox() {
	if ( ! mirim_editing_galeria() ) {
		return;
	}
	add_meta_box( 'mirim-galeria', 'Página Galeria', 'mirim_galeria_metabox_html', 'page', 'normal', 'high' );
}

function mirim_galeria_metabox_html( $post ) {
	wp_nonce_field( 'mirim_galeria_save', 'mirim_galeria_nonce' );
	$dados = mirim_galeria( $post->ID );
	$abas  = array(
		'capa'       => 'Capa',
		'projetos'   => 'Projetos',
		'atividades' => 'Atividades',
		'momentos'   => 'Momentos',
	);
	echo '<div class="mirim-box">';
	echo '<nav class="mirim-tabs">';
	$first = true;
	foreach ( $abas as $slug => $label ) {
		echo '<button type="button" data-mirim-tab="' . esc_attr( $slug ) . '"' . ( $first ? ' class="is-active"' : '' ) . '>' . esc_html( $label ) . '</button>';
		$first = false;
	}
	echo '</nav>';

	echo '<div class="mirim-pane is-on" data-mirim-pane="capa"><table class="form-table" role="presentation">';
	mirim_galeria_input( 'capa', 'titulo', 'Título', $dados['capa']['titulo'] );
	echo '<tr><th scope="row"><label for="galeria_campos[capa][texto]">Texto</label></th><td><textarea class="large-text" rows="6" id="galeria_campos[capa][texto]" name="galeria_campos[capa][texto]">' . esc_textarea( $dados['capa']['texto'] ) . '</textarea></td></tr>';
	echo '<tr><th scope="row">Imagem</th><td>';
	mirim_media_field( 'galeria_campos[capa]', $dados['capa']['imagem'], $dados['capa']['arquivo'] );
	echo '</td></tr></table></div>';

	echo '<div class="mirim-pane" data-mirim-pane="projetos"><table class="form-table" role="presentation">';
	echo '<tr><td colspan="2"><p>Estas fotos ficam na grade logo abaixo da capa.</p></td></tr>';
	echo '<tr><th scope="row">Fotos</th><td>';
	mirim_render_fotos( 'galeria_campos[projetos][fotos]', $dados['projetos']['fotos'] );
	echo '</td></tr></table></div>';

	echo '<div class="mirim-pane" data-mirim-pane="atividades"><table class="form-table" role="presentation">';
	mirim_galeria_input( 'atividades', 'titulo', 'Título', $dados['atividades']['titulo'] );
	mirim_galeria_input( 'atividades', 'texto', 'Texto', $dados['atividades']['texto'] );
	echo '<tr><th scope="row">Fotos</th><td>';
	mirim_render_fotos( 'galeria_campos[atividades][fotos]', $dados['atividades']['fotos'] );
	echo '</td></tr></table></div>';

	echo '<div class="mirim-pane" data-mirim-pane="momentos"><table class="form-table" role="presentation">';
	echo '<tr><td colspan="2"><p>A mesma lista aparece no slide e nas miniaturas.</p></td></tr>';
	mirim_galeria_input( 'momentos', 'titulo', 'Título', $dados['momentos']['titulo'] );
	mirim_galeria_input( 'momentos', 'texto', 'Texto', $dados['momentos']['texto'] );
	echo '<tr><th scope="row">Fotos</th><td>';
	mirim_render_fotos( 'galeria_campos[momentos][fotos]', $dados['momentos']['fotos'] );
	echo '</td></tr></table></div>';

	echo '</div>';
}

function mirim_galeria_input( $group, $key, $label, $value ) {
	$name = 'galeria_campos[' . $group . '][' . $key . ']';
	echo '<tr><th scope="row"><label for="' . esc_attr( $name ) . '">' . esc_html( $label ) . '</label></th><td>';
	echo '<input class="regular-text" type="text" id="' . esc_attr( $name ) . '" name="' . esc_attr( $name ) . '" value="' . esc_attr( $value ) . '">';
	echo '</td></tr>';
}

add_action( 'save_post_page', 'mirim_galeria_save' );

function mirim_galeria_save( $post_id ) {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	if ( ! isset( $_POST['mirim_galeria_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['mirim_galeria_nonce'] ) ), 'mirim_galeria_save' ) ) {
		return;
	}
	if ( ! current_user_can( 'edit_page', $post_id ) ) {
		return;
	}
	$posted = isset( $_POST['galeria_campos'] ) ? wp_unslash( $_POST['galeria_campos'] ) : array();
	if ( ! is_array( $posted ) ) {
		return;
	}
	update_post_meta( $post_id, '_mirim_galeria', mirim_sanitize_galeria( $posted ) );
}

function mirim_galeria_fotos( $rows ) {
	return mirim_sanitize_rows(
		$rows,
		array(
			'imagem'  => 'image',
			'arquivo' => 'file',
			'alt'     => 'text',
		),
		array( 'imagem', 'arquivo' )
	);
}

function mirim_sanitize_galeria( $posted ) {
	return array(
		'capa'       => array(
			'titulo'  => sanitize_text_field( $posted['capa']['titulo'] ?? '' ),
			'texto'   => sanitize_textarea_field( $posted['capa']['texto'] ?? '' ),
			'imagem'  => absint( $posted['capa']['imagem'] ?? 0 ),
			'arquivo' => mirim_sanitize_value( 'file', $posted['capa']['arquivo'] ?? '' ),
		),
		'projetos'   => array(
			'fotos' => mirim_galeria_fotos( $posted['projetos']['fotos'] ?? array() ),
		),
		'atividades' => array(
			'titulo' => sanitize_text_field( $posted['atividades']['titulo'] ?? '' ),
			'texto'  => sanitize_text_field( $posted['atividades']['texto'] ?? '' ),
			'fotos'  => mirim_galeria_fotos( $posted['atividades']['fotos'] ?? array() ),
		),
		'momentos'   => array(
			'titulo' => sanitize_text_field( $posted['momentos']['titulo'] ?? '' ),
			'texto'  => sanitize_text_field( $posted['momentos']['texto'] ?? '' ),
			'fotos'  => mirim_galeria_fotos( $posted['momentos']['fotos'] ?? array() ),
		),
	);
}
