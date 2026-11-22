<?php

function mirim_editing_sobre() {
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
	return 'sobre' === get_post_field( 'post_name', $post_id );
}

add_filter( 'use_block_editor_for_post', 'mirim_sobre_classic_editor', 10, 2 );

function mirim_sobre_classic_editor( $use, $post ) {
	if ( $post instanceof WP_Post && 'sobre' === $post->post_name ) {
		return false;
	}
	return $use;
}

add_action( 'edit_form_after_title', 'mirim_sobre_editor_note' );

function mirim_sobre_editor_note( $post ) {
	if ( ! $post instanceof WP_Post || 'sobre' !== $post->post_name ) {
		return;
	}
	echo '<p class="description">Este texto é a história da escola, ao lado da foto. Título, imagens e os outros blocos ficam nos campos abaixo.</p>';
}

add_action( 'add_meta_boxes', 'mirim_sobre_metabox' );

function mirim_sobre_metabox() {
	if ( ! mirim_editing_sobre() ) {
		return;
	}
	add_meta_box( 'mirim-sobre', 'Página Sobre', 'mirim_sobre_metabox_html', 'page', 'normal', 'high' );
}

function mirim_sobre_pad( $items, $count, $blank ) {
	$items = array_values( $items );
	while ( count( $items ) < $count ) {
		$items[] = $blank;
	}
	return $items;
}

function mirim_sobre_metabox_html( $post ) {
	wp_nonce_field( 'mirim_sobre_save', 'mirim_sobre_nonce' );
	$dados = mirim_sobre( $post->ID );
	$abas  = array(
		'capa'       => 'Capa',
		'historia'   => 'História',
		'missao'     => 'Missão',
		'faixa'      => 'Matrícula',
		'atividades' => 'Atividades',
		'visao'      => 'Visão',
		'galeria'    => 'Galeria',
		'familias'   => 'Famílias',
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
	mirim_sobre_input( 'capa', 'subtitulo', 'Subtítulo', $dados['capa']['subtitulo'] );
	echo '<tr><th scope="row">Imagem</th><td>';
	mirim_media_field( 'sobre[capa]', $dados['capa']['imagem'], $dados['capa']['arquivo'] );
	echo '<p class="description">O título da capa é o título da página.</p></td></tr></table></div>';

	echo '<div class="mirim-pane" data-mirim-pane="historia"><table class="form-table" role="presentation">';
	mirim_sobre_input( 'historia', 'titulo', 'Título', $dados['historia']['titulo'] );
	mirim_sobre_input( 'historia', 'alt', 'Texto alternativo da foto', $dados['historia']['alt'] );
	echo '<tr><th scope="row">Foto</th><td>';
	mirim_media_field( 'sobre[historia]', $dados['historia']['imagem'], $dados['historia']['arquivo'] );
	echo '<p class="description">O texto longo fica no editor acima.</p></td></tr></table></div>';

	echo '<div class="mirim-pane" data-mirim-pane="missao"><table class="form-table" role="presentation">';
	mirim_sobre_input( 'missao', 'titulo', 'Título', $dados['missao']['titulo'] );
	mirim_sobre_input( 'missao', 'texto', 'Texto', $dados['missao']['texto'], true );
	mirim_sobre_input( 'missao', 'alt', 'Texto alternativo da foto', $dados['missao']['alt'] );
	echo '<tr><th scope="row">Foto</th><td>';
	mirim_media_field( 'sobre[missao]', $dados['missao']['imagem'], $dados['missao']['arquivo'] );
	echo '</td></tr></table></div>';

	echo '<div class="mirim-pane" data-mirim-pane="faixa"><table class="form-table" role="presentation">';
	echo '<tr><td colspan="2"><p>O botão usa o WhatsApp de matrícula das Configurações.</p></td></tr>';
	mirim_sobre_input( 'faixa', 'kicker', 'Linha de apoio', $dados['faixa']['kicker'] );
	mirim_sobre_input( 'faixa', 'titulo', 'Título', $dados['faixa']['titulo'] );
	echo '</table></div>';

	echo '<div class="mirim-pane" data-mirim-pane="atividades"><table class="form-table" role="presentation">';
	mirim_sobre_input( 'atividades', 'titulo', 'Título', $dados['atividades']['titulo'] );
	mirim_sobre_input( 'atividades', 'texto', 'Texto', $dados['atividades']['texto'] );
	mirim_sobre_input( 'atividades', 'alt', 'Texto alternativo da foto central', $dados['atividades']['alt'] );
	echo '<tr><th scope="row">Foto central</th><td>';
	mirim_media_field( 'sobre[atividades]', $dados['atividades']['imagem'], $dados['atividades']['arquivo'] );
	echo '</td></tr><tr><th scope="row">Atividades</th><td>';
	$dados['atividades']['itens'] = mirim_sobre_pad(
		$dados['atividades']['itens'],
		4,
		array( 'imagem' => 0, 'arquivo' => '', 'titulo' => '', 'itens' => '' )
	);
	foreach ( $dados['atividades']['itens'] as $index => $item ) {
		$name = 'sobre[atividades][itens][' . $index . ']';
		echo '<div class="mirim-item"><p class="mirim-group"><strong>Atividade ' . ( $index + 1 ) . '</strong></p>';
		mirim_media_field( $name, $item['imagem'], $item['arquivo'] );
		mirim_item_field( $name . '[titulo]', $item['titulo'], 'Título' );
		mirim_item_field( $name . '[itens]', $item['itens'], 'Itens (um por linha)', true );
		echo '</div>';
	}
	echo '</td></tr></table></div>';

	echo '<div class="mirim-pane" data-mirim-pane="visao"><table class="form-table" role="presentation">';
	mirim_sobre_input( 'visao', 'kicker', 'Linha de apoio', $dados['visao']['kicker'] );
	mirim_sobre_input( 'visao', 'titulo', 'Título', $dados['visao']['titulo'] );
	mirim_sobre_input( 'visao', 'texto', 'Texto', $dados['visao']['texto'], true );
	echo '<tr><th scope="row">Cards</th><td>';
	$dados['visao']['itens'] = mirim_sobre_pad(
		$dados['visao']['itens'],
		5,
		array( 'imagem' => 0, 'arquivo' => '', 'titulo' => '', 'texto' => '' )
	);
	foreach ( $dados['visao']['itens'] as $index => $item ) {
		$name = 'sobre[visao][itens][' . $index . ']';
		echo '<div class="mirim-item"><p class="mirim-group"><strong>Card ' . ( $index + 1 ) . '</strong></p>';
		mirim_media_field( $name, $item['imagem'], $item['arquivo'] );
		mirim_item_field( $name . '[titulo]', $item['titulo'], 'Título' );
		mirim_item_field( $name . '[texto]', $item['texto'], 'Texto', true );
		echo '</div>';
	}
	echo '</td></tr></table></div>';

	echo '<div class="mirim-pane" data-mirim-pane="galeria"><table class="form-table" role="presentation">';
	mirim_sobre_input( 'galeria', 'titulo', 'Título', $dados['galeria']['titulo'] );
	mirim_sobre_input( 'galeria', 'texto', 'Texto', $dados['galeria']['texto'] );
	echo '<tr><th scope="row">Fotos</th><td>';
	mirim_render_fotos( 'sobre[galeria][fotos]', $dados['galeria']['fotos'] );
	echo '</td></tr></table></div>';

	echo '<div class="mirim-pane" data-mirim-pane="familias"><table class="form-table" role="presentation">';
	echo '<tr><td colspan="2"><p>Os depoimentos são os publicados em <a href="' . esc_url( admin_url( 'edit.php?post_type=depoimentos' ) ) . '">Depoimentos</a> com a opção Sobre marcada.</p></td></tr>';
	mirim_sobre_input( 'familias', 'titulo', 'Título', $dados['familias']['titulo'] );
	echo '</table></div>';

	echo '</div>';
}

function mirim_sobre_input( $group, $key, $label, $value, $textarea = false ) {
	$name = 'sobre[' . $group . '][' . $key . ']';
	echo '<tr><th scope="row"><label for="' . esc_attr( $name ) . '">' . esc_html( $label ) . '</label></th><td>';
	if ( $textarea ) {
		echo '<textarea class="large-text" rows="4" id="' . esc_attr( $name ) . '" name="' . esc_attr( $name ) . '">' . esc_textarea( $value ) . '</textarea>';
	} else {
		echo '<input class="regular-text" type="text" id="' . esc_attr( $name ) . '" name="' . esc_attr( $name ) . '" value="' . esc_attr( $value ) . '">';
	}
	echo '</td></tr>';
}

add_action( 'save_post_page', 'mirim_sobre_save' );

function mirim_sobre_save( $post_id ) {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	if ( ! isset( $_POST['mirim_sobre_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['mirim_sobre_nonce'] ) ), 'mirim_sobre_save' ) ) {
		return;
	}
	if ( ! current_user_can( 'edit_page', $post_id ) ) {
		return;
	}
	$posted = isset( $_POST['sobre'] ) ? wp_unslash( $_POST['sobre'] ) : array();
	if ( ! is_array( $posted ) ) {
		return;
	}
	update_post_meta( $post_id, '_mirim_sobre', mirim_sanitize_sobre( $posted ) );
}

function mirim_sanitize_sobre( $posted ) {
	$clean = array();
	$clean['capa'] = array(
		'subtitulo' => sanitize_text_field( $posted['capa']['subtitulo'] ?? '' ),
		'imagem'    => absint( $posted['capa']['imagem'] ?? 0 ),
		'arquivo'   => mirim_sanitize_value( 'file', $posted['capa']['arquivo'] ?? '' ),
	);
	$clean['historia'] = array(
		'titulo'  => sanitize_text_field( $posted['historia']['titulo'] ?? '' ),
		'alt'     => sanitize_text_field( $posted['historia']['alt'] ?? '' ),
		'imagem'  => absint( $posted['historia']['imagem'] ?? 0 ),
		'arquivo' => mirim_sanitize_value( 'file', $posted['historia']['arquivo'] ?? '' ),
	);
	$clean['missao'] = array(
		'titulo'  => sanitize_text_field( $posted['missao']['titulo'] ?? '' ),
		'texto'   => sanitize_textarea_field( $posted['missao']['texto'] ?? '' ),
		'alt'     => sanitize_text_field( $posted['missao']['alt'] ?? '' ),
		'imagem'  => absint( $posted['missao']['imagem'] ?? 0 ),
		'arquivo' => mirim_sanitize_value( 'file', $posted['missao']['arquivo'] ?? '' ),
	);
	$clean['faixa'] = array(
		'kicker' => sanitize_text_field( $posted['faixa']['kicker'] ?? '' ),
		'titulo' => sanitize_text_field( $posted['faixa']['titulo'] ?? '' ),
	);
	$clean['atividades'] = array(
		'titulo'  => sanitize_text_field( $posted['atividades']['titulo'] ?? '' ),
		'texto'   => sanitize_text_field( $posted['atividades']['texto'] ?? '' ),
		'alt'     => sanitize_text_field( $posted['atividades']['alt'] ?? '' ),
		'imagem'  => absint( $posted['atividades']['imagem'] ?? 0 ),
		'arquivo' => mirim_sanitize_value( 'file', $posted['atividades']['arquivo'] ?? '' ),
		'itens'   => mirim_sanitize_rows(
			$posted['atividades']['itens'] ?? array(),
			array(
				'imagem'  => 'image',
				'arquivo' => 'file',
				'titulo'  => 'text',
				'itens'   => 'long',
			),
			array( 'titulo', 'itens', 'imagem', 'arquivo' )
		),
	);
	$clean['visao'] = array(
		'kicker' => sanitize_text_field( $posted['visao']['kicker'] ?? '' ),
		'titulo' => sanitize_text_field( $posted['visao']['titulo'] ?? '' ),
		'texto'  => sanitize_textarea_field( $posted['visao']['texto'] ?? '' ),
		'itens'  => mirim_sanitize_rows(
			$posted['visao']['itens'] ?? array(),
			array(
				'imagem'  => 'image',
				'arquivo' => 'file',
				'titulo'  => 'text',
				'texto'   => 'long',
			),
			array( 'titulo', 'texto', 'imagem', 'arquivo' )
		),
	);
	$clean['galeria'] = array(
		'titulo' => sanitize_text_field( $posted['galeria']['titulo'] ?? '' ),
		'texto'  => sanitize_text_field( $posted['galeria']['texto'] ?? '' ),
		'fotos'  => mirim_sanitize_rows(
			$posted['galeria']['fotos'] ?? array(),
			array(
				'imagem'  => 'image',
				'arquivo' => 'file',
				'alt'     => 'text',
			),
			array( 'imagem', 'arquivo' )
		),
	);
	$clean['familias'] = array(
		'titulo' => sanitize_text_field( $posted['familias']['titulo'] ?? '' ),
	);
	return $clean;
}

add_action( 'init', 'mirim_seed_sobre_content', 20 );

function mirim_seed_sobre_content() {
	if ( get_option( 'colegiomirim_sobre_seed' ) ) {
		return;
	}
	$page = get_page_by_path( 'sobre' );
	if ( ! $page instanceof WP_Post ) {
		return;
	}
	if ( '' === trim( $page->post_content ) ) {
		wp_update_post(
			array(
				'ID'           => $page->ID,
				'post_content' => '<p>O Colégio Mirim começou com o sonho de uma professora apaixonada pela educação…</p>' . "\n"
					. '<p>A Pró Mônica já acreditava que cada estudante merece um espaço onde amor e conhecimento se encontram. Começamos com cinco estudantes, mas nossa missão sempre foi grande: criar um ambiente educacional acolhedor e inspirador.</p>' . "\n"
					. '<p>Com o passar do tempo, aquele pequeno grupo cresceu, mas o nosso compromisso em fazer a diferença na vida de cada estudante se manteve. Hoje, somos uma escola reconhecida pela dedicação e inovação.</p>' . "\n"
					. '<p>Celebrar três décadas de história nos enche de orgulho e nos motiva a continuar evoluindo. Aqui, cada criança é única, e nossa missão é oferecer uma educação de excelência que prepare nossos estudantes para o futuro.</p>',
			)
		);
	}
	update_option( 'colegiomirim_sobre_seed', 1 );
}
