<?php

function mirim_editing_contato() {
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
	return 'contato' === get_post_field( 'post_name', $post_id );
}

add_filter( 'use_block_editor_for_post', 'mirim_contato_classic_editor', 10, 2 );

function mirim_contato_classic_editor( $use, $post ) {
	if ( $post instanceof WP_Post && 'contato' === $post->post_name ) {
		return false;
	}
	return $use;
}

add_action( 'admin_head', 'mirim_contato_hide_editor' );

function mirim_contato_hide_editor() {
	if ( ! mirim_editing_contato() ) {
		return;
	}
	echo '<style>#postdivrich{display:none}</style>';
}

add_action( 'edit_form_after_title', 'mirim_contato_editor_note' );

function mirim_contato_editor_note( $post ) {
	if ( ! $post instanceof WP_Post || 'contato' !== $post->post_name ) {
		return;
	}
	echo '<p class="description">O título acima é o título da capa. Os outros textos ficam nas seções abaixo. Telefone, e-mail, endereço, mapa e WhatsApp continuam nas Configurações.</p>';
}

add_action( 'add_meta_boxes', 'mirim_contato_metabox' );

function mirim_contato_metabox() {
	if ( ! mirim_editing_contato() ) {
		return;
	}
	add_meta_box( 'mirim-contato', 'Página Contato', 'mirim_contato_metabox_html', 'page', 'normal', 'high' );
}

function mirim_contato_metabox_html( $post ) {
	wp_nonce_field( 'mirim_contato_save', 'mirim_contato_nonce' );
	$dados = mirim_contato( $post->ID );
	$abas  = array(
		'capa'       => 'Capa',
		'dados'      => 'Dados',
		'formulario' => 'Formulário',
		'mapa'       => 'Mapa',
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
	mirim_contato_input( 'capa', 'texto', 'Texto', $dados['capa']['texto'] );
	echo '<tr><th scope="row">Imagem</th><td>';
	mirim_media_field( 'contato_campos[capa]', $dados['capa']['imagem'], $dados['capa']['arquivo'] );
	echo '</td></tr></table></div>';

	echo '<div class="mirim-pane" data-mirim-pane="dados"><table class="form-table" role="presentation">';
	echo '<tr><td colspan="2"><p>Os valores de telefone, e-mail e endereço vêm das Configurações. Aqui ficam só os títulos dos cards.</p></td></tr>';
	mirim_contato_input( 'dados', 'telefone', 'Título do telefone', $dados['dados']['telefone'] );
	mirim_contato_input( 'dados', 'email', 'Título do e-mail', $dados['dados']['email'] );
	mirim_contato_input( 'dados', 'endereco', 'Título do endereço', $dados['dados']['endereco'] );
	echo '</table></div>';

	echo '<div class="mirim-pane" data-mirim-pane="formulario"><table class="form-table" role="presentation">';
	echo '<tr><td colspan="2"><p>O botão Matricule-se abre o WhatsApp de matrícula das Configurações. O formulário envia a mensagem para o número de WhatsApp.</p></td></tr>';
	mirim_contato_input( 'formulario', 'kicker', 'Linha de apoio', $dados['formulario']['kicker'] );
	mirim_contato_input( 'formulario', 'titulo', 'Título', $dados['formulario']['titulo'] );
	mirim_contato_input( 'formulario', 'botao', 'Texto do botão', $dados['formulario']['botao'] );
	mirim_contato_input( 'formulario', 'alt', 'Texto alternativo da foto', $dados['formulario']['alt'] );
	echo '<tr><th scope="row">Foto</th><td>';
	mirim_media_field( 'contato_campos[formulario]', $dados['formulario']['imagem'], $dados['formulario']['arquivo'] );
	echo '</td></tr></table></div>';

	echo '<div class="mirim-pane" data-mirim-pane="mapa"><table class="form-table" role="presentation">';
	echo '<tr><td colspan="2"><p>O mapa usa o endereço incorporado das Configurações.</p></td></tr>';
	mirim_contato_input( 'mapa', 'titulo', 'Título', $dados['mapa']['titulo'] );
	echo '</table></div>';

	echo '</div>';
}

function mirim_contato_input( $group, $key, $label, $value ) {
	$name = 'contato_campos[' . $group . '][' . $key . ']';
	echo '<tr><th scope="row"><label for="' . esc_attr( $name ) . '">' . esc_html( $label ) . '</label></th><td>';
	echo '<input class="regular-text" type="text" id="' . esc_attr( $name ) . '" name="' . esc_attr( $name ) . '" value="' . esc_attr( $value ) . '">';
	echo '</td></tr>';
}

add_action( 'save_post_page', 'mirim_contato_save' );

function mirim_contato_save( $post_id ) {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	if ( ! isset( $_POST['mirim_contato_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['mirim_contato_nonce'] ) ), 'mirim_contato_save' ) ) {
		return;
	}
	if ( ! current_user_can( 'edit_page', $post_id ) ) {
		return;
	}
	$posted = isset( $_POST['contato_campos'] ) ? wp_unslash( $_POST['contato_campos'] ) : array();
	if ( ! is_array( $posted ) ) {
		return;
	}
	update_post_meta( $post_id, '_mirim_contato', mirim_sanitize_contato( $posted ) );
}

function mirim_sanitize_contato( $posted ) {
	return array(
		'capa'       => array(
			'texto'   => sanitize_text_field( $posted['capa']['texto'] ?? '' ),
			'imagem'  => absint( $posted['capa']['imagem'] ?? 0 ),
			'arquivo' => mirim_sanitize_value( 'file', $posted['capa']['arquivo'] ?? '' ),
		),
		'dados'      => array(
			'telefone' => sanitize_text_field( $posted['dados']['telefone'] ?? '' ),
			'email'    => sanitize_text_field( $posted['dados']['email'] ?? '' ),
			'endereco' => sanitize_text_field( $posted['dados']['endereco'] ?? '' ),
		),
		'formulario' => array(
			'kicker'  => sanitize_text_field( $posted['formulario']['kicker'] ?? '' ),
			'titulo'  => sanitize_text_field( $posted['formulario']['titulo'] ?? '' ),
			'botao'   => sanitize_text_field( $posted['formulario']['botao'] ?? '' ),
			'alt'     => sanitize_text_field( $posted['formulario']['alt'] ?? '' ),
			'imagem'  => absint( $posted['formulario']['imagem'] ?? 0 ),
			'arquivo' => mirim_sanitize_value( 'file', $posted['formulario']['arquivo'] ?? '' ),
		),
		'mapa'       => array(
			'titulo' => sanitize_text_field( $posted['mapa']['titulo'] ?? '' ),
		),
	);
}
