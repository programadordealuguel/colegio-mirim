<?php

function mirim_editing_servico() {
	if ( ! is_admin() ) {
		return false;
	}
	if ( isset( $_GET['post_type'] ) && 'servicos' === sanitize_key( wp_unslash( $_GET['post_type'] ) ) ) {
		return true;
	}
	$post_id = isset( $_GET['post'] ) ? absint( $_GET['post'] ) : 0;
	if ( ! $post_id && isset( $_POST['post_ID'] ) ) {
		$post_id = absint( $_POST['post_ID'] );
	}
	if ( ! $post_id ) {
		return false;
	}
	return 'servicos' === get_post_type( $post_id );
}

add_filter( 'use_block_editor_for_post', 'mirim_servico_classic_editor', 10, 2 );

function mirim_servico_classic_editor( $use, $post ) {
	if ( $post instanceof WP_Post && 'servicos' === $post->post_type ) {
		return false;
	}
	return $use;
}

add_action( 'edit_form_after_title', 'mirim_servico_editor_note' );

function mirim_servico_editor_note( $post ) {
	if ( ! $post instanceof WP_Post || 'servicos' !== $post->post_type ) {
		return;
	}
	echo '<p class="description">Este texto fica ao lado da foto, abaixo do título da apresentação. O título da página é o título da capa. As mensagens de WhatsApp ficam nas Configurações, e as famílias em Depoimentos.</p>';
}

add_action( 'add_meta_boxes', 'mirim_servico_metabox' );

function mirim_servico_metabox() {
	add_meta_box( 'mirim-servico', 'Página do serviço', 'mirim_servico_metabox_html', 'servicos', 'normal', 'high' );
}

function mirim_servico_metabox_html( $post ) {
	wp_nonce_field( 'mirim_servico_save', 'mirim_servico_nonce' );
	$dados = mirim_servico( $post->ID );
	$abas  = array(
		'capa'         => 'Capa',
		'apresentacao' => 'Apresentação',
		'metodologia'  => 'Metodologia',
		'fotos'        => 'Fotos',
		'familias'     => 'Famílias',
		'faixa'        => 'Faixa',
		'matricula'    => 'Matrícula',
	);
	echo '<div class="mirim-box">';
	echo '<nav class="mirim-tabs">';
	$first = true;
	foreach ( $abas as $slug => $label ) {
		$classes = array();
		if ( $first ) {
			$classes[] = 'is-active';
		}
		if ( ! empty( $dados[ $slug ]['ocultar'] ) ) {
			$classes[] = 'is-off';
		}
		echo '<button type="button" data-mirim-tab="' . esc_attr( $slug ) . '"' . ( $classes ? ' class="' . esc_attr( implode( ' ', $classes ) ) . '"' : '' ) . '>' . esc_html( $label ) . '</button>';
		$first = false;
	}
	echo '</nav>';

	echo '<div class="mirim-pane is-on" data-mirim-pane="capa">';
	mirim_servico_switch( 'capa', $dados['capa'] );
	echo '<table class="form-table" role="presentation">';
	mirim_servico_input( 'capa', 'texto', 'Texto', $dados['capa']['texto'] );
	echo '<tr><th scope="row">Imagem</th><td>';
	mirim_media_field( 'servico_campos[capa]', $dados['capa']['imagem'], $dados['capa']['arquivo'] );
	echo '</td></tr></table></div>';

	$bloco = $dados['apresentacao'];
	echo '<div class="mirim-pane" data-mirim-pane="apresentacao">';
	mirim_servico_switch( 'apresentacao', $bloco );
	echo '<table class="form-table" role="presentation">';
	echo '<tr><td colspan="2"><p>O texto longo fica no editor acima. Os botões abrem o WhatsApp deste segmento.</p></td></tr>';
	mirim_servico_input( 'apresentacao', 'kicker', 'Linha de apoio', $bloco['kicker'] );
	mirim_servico_input( 'apresentacao', 'titulo', 'Título', $bloco['titulo'] );
	mirim_servico_input( 'apresentacao', 'alt', 'Texto alternativo da foto', $bloco['alt'] );
	mirim_servico_input( 'apresentacao', 'botao', 'Botão de matrícula', $bloco['botao'] );
	mirim_servico_input( 'apresentacao', 'botao_visita', 'Botão de visita', $bloco['botao_visita'] );
	echo '<tr><th scope="row">Foto</th><td>';
	mirim_media_field( 'servico_campos[apresentacao]', $bloco['imagem'], $bloco['arquivo'] );
	echo '</td></tr><tr><th scope="row">Etapas</th><td>';
	mirim_render_repeater( 'servico_campos[apresentacao][etapas]', $bloco['etapas'], array( 'selo' => 'Selo', 'linha' => 'Texto' ), 'Etapa', 'Adicionar etapa' );
	echo '</td></tr></table></div>';

	$bloco = $dados['metodologia'];
	echo '<div class="mirim-pane" data-mirim-pane="metodologia">';
	mirim_servico_switch( 'metodologia', $bloco );
	echo '<table class="form-table" role="presentation">';
	mirim_servico_input( 'metodologia', 'kicker', 'Linha de apoio', $bloco['kicker'] );
	mirim_servico_input( 'metodologia', 'titulo', 'Título', $bloco['titulo'] );
	mirim_servico_input( 'metodologia', 'texto', 'Texto', $bloco['texto'] );
	echo '<tr><th scope="row">Cards</th><td>';
	mirim_render_repeater( 'servico_campos[metodologia][itens]', $bloco['itens'], array( 'titulo' => 'Título', 'texto' => 'Texto' ), 'Card', 'Adicionar card' );
	echo '</td></tr></table></div>';

	$bloco = $dados['fotos'];
	echo '<div class="mirim-pane" data-mirim-pane="fotos">';
	mirim_servico_switch( 'fotos', $bloco );
	echo '<table class="form-table" role="presentation">';
	mirim_servico_input( 'fotos', 'kicker', 'Linha de apoio', $bloco['kicker'] );
	mirim_servico_input( 'fotos', 'titulo', 'Título', $bloco['titulo'] );
	echo '<tr><th scope="row">Fotos</th><td>';
	mirim_render_fotos( 'servico_campos[fotos][fotos]', $bloco['fotos'] );
	echo '</td></tr></table></div>';

	echo '<div class="mirim-pane" data-mirim-pane="familias">';
	mirim_servico_switch( 'familias', $dados['familias'] );
	echo '<table class="form-table" role="presentation">';
	echo '<tr><td colspan="2"><p>Os depoimentos são os publicados em <a href="' . esc_url( admin_url( 'edit.php?post_type=depoimentos' ) ) . '">Depoimentos</a> com este segmento marcado.</p></td></tr>';
	mirim_servico_input( 'familias', 'kicker', 'Linha de apoio', $dados['familias']['kicker'] );
	mirim_servico_input( 'familias', 'titulo', 'Título', $dados['familias']['titulo'] );
	echo '</table></div>';

	echo '<div class="mirim-pane" data-mirim-pane="faixa">';
	mirim_servico_switch( 'faixa', $dados['faixa'] );
	echo '<table class="form-table" role="presentation">';
	echo '<tr><td colspan="2"><p>O botão usa o texto de matrícula da apresentação.</p></td></tr>';
	mirim_servico_input( 'faixa', 'kicker', 'Linha de apoio', $dados['faixa']['kicker'] );
	mirim_servico_input( 'faixa', 'titulo', 'Título', $dados['faixa']['titulo'] );
	mirim_servico_input( 'faixa', 'texto', 'Texto', $dados['faixa']['texto'] );
	echo '</table></div>';

	echo '<div class="mirim-pane" data-mirim-pane="matricula">';
	mirim_servico_switch( 'matricula', $dados['matricula'] );
	echo '<table class="form-table" role="presentation">';
	echo '<tr><td colspan="2"><p>O botão usa o texto da matrícula da página inicial e a mensagem de visita deste segmento.</p></td></tr>';
	mirim_servico_input( 'matricula', 'titulo', 'Título', $dados['matricula']['titulo'] );
	mirim_servico_input( 'matricula', 'texto', 'Texto', $dados['matricula']['texto'] );
	echo '</table></div>';

	echo '</div>';
}

function mirim_servico_switch( $group, $dados ) {
	$off  = ! empty( $dados['ocultar'] );
	$name = 'servico_campos[' . $group . '][ocultar]';
	echo '<p class="mirim-switch">';
	echo '<input class="mirim-ocultar" type="hidden" name="' . esc_attr( $name ) . '" value="' . ( $off ? '1' : '' ) . '">';
	echo '<button type="button" class="button mirim-toggle' . ( $off ? ' is-off' : '' ) . '" aria-pressed="' . ( $off ? 'true' : 'false' ) . '">' . ( $off ? 'Ativar seção' : 'Desativar seção' ) . '</button>';
	echo '</p>';
}

function mirim_servico_input( $group, $key, $label, $value ) {
	$name = 'servico_campos[' . $group . '][' . $key . ']';
	echo '<tr><th scope="row"><label for="' . esc_attr( $name ) . '">' . esc_html( $label ) . '</label></th><td>';
	echo '<input class="regular-text" type="text" id="' . esc_attr( $name ) . '" name="' . esc_attr( $name ) . '" value="' . esc_attr( $value ) . '">';
	echo '</td></tr>';
}

add_action( 'save_post_servicos', 'mirim_servico_save' );

function mirim_servico_save( $post_id ) {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	if ( ! isset( $_POST['mirim_servico_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['mirim_servico_nonce'] ) ), 'mirim_servico_save' ) ) {
		return;
	}
	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}
	$posted = isset( $_POST['servico_campos'] ) ? wp_unslash( $_POST['servico_campos'] ) : array();
	if ( ! is_array( $posted ) ) {
		return;
	}
	update_post_meta( $post_id, '_mirim_servico', mirim_sanitize_servico( $posted ) );
}

function mirim_sanitize_servico( $posted ) {
	return array(
		'capa'         => array(
			'ocultar' => empty( $posted['capa']['ocultar'] ) ? '' : '1',
			'texto'   => sanitize_text_field( $posted['capa']['texto'] ?? '' ),
			'imagem'  => absint( $posted['capa']['imagem'] ?? 0 ),
			'arquivo' => mirim_sanitize_value( 'file', $posted['capa']['arquivo'] ?? '' ),
		),
		'apresentacao' => array(
			'ocultar'      => empty( $posted['apresentacao']['ocultar'] ) ? '' : '1',
			'kicker'       => sanitize_text_field( $posted['apresentacao']['kicker'] ?? '' ),
			'titulo'       => sanitize_text_field( $posted['apresentacao']['titulo'] ?? '' ),
			'alt'          => sanitize_text_field( $posted['apresentacao']['alt'] ?? '' ),
			'imagem'       => absint( $posted['apresentacao']['imagem'] ?? 0 ),
			'arquivo'      => mirim_sanitize_value( 'file', $posted['apresentacao']['arquivo'] ?? '' ),
			'botao'        => sanitize_text_field( $posted['apresentacao']['botao'] ?? '' ),
			'botao_visita' => sanitize_text_field( $posted['apresentacao']['botao_visita'] ?? '' ),
			'etapas'       => mirim_sanitize_rows(
				$posted['apresentacao']['etapas'] ?? array(),
				array(
					'selo'  => 'text',
					'linha' => 'text',
				),
				array( 'selo', 'linha' )
			),
		),
		'metodologia'  => array(
			'ocultar' => empty( $posted['metodologia']['ocultar'] ) ? '' : '1',
			'kicker' => sanitize_text_field( $posted['metodologia']['kicker'] ?? '' ),
			'titulo' => sanitize_text_field( $posted['metodologia']['titulo'] ?? '' ),
			'texto'  => sanitize_text_field( $posted['metodologia']['texto'] ?? '' ),
			'itens'  => mirim_sanitize_rows(
				$posted['metodologia']['itens'] ?? array(),
				array(
					'titulo' => 'text',
					'texto'  => 'long',
				),
				array( 'titulo', 'texto' )
			),
		),
		'fotos'        => array(
			'ocultar' => empty( $posted['fotos']['ocultar'] ) ? '' : '1',
			'kicker' => sanitize_text_field( $posted['fotos']['kicker'] ?? '' ),
			'titulo' => sanitize_text_field( $posted['fotos']['titulo'] ?? '' ),
			'fotos'  => mirim_sanitize_rows(
				$posted['fotos']['fotos'] ?? array(),
				array(
					'imagem'  => 'image',
					'arquivo' => 'file',
					'alt'     => 'text',
				),
				array( 'imagem', 'arquivo' )
			),
		),
		'familias'     => array(
			'ocultar' => empty( $posted['familias']['ocultar'] ) ? '' : '1',
			'kicker' => sanitize_text_field( $posted['familias']['kicker'] ?? '' ),
			'titulo' => sanitize_text_field( $posted['familias']['titulo'] ?? '' ),
		),
		'faixa'        => array(
			'ocultar' => empty( $posted['faixa']['ocultar'] ) ? '' : '1',
			'kicker' => sanitize_text_field( $posted['faixa']['kicker'] ?? '' ),
			'titulo' => sanitize_text_field( $posted['faixa']['titulo'] ?? '' ),
			'texto'  => sanitize_text_field( $posted['faixa']['texto'] ?? '' ),
		),
		'matricula'    => array(
			'ocultar' => empty( $posted['matricula']['ocultar'] ) ? '' : '1',
			'titulo' => sanitize_text_field( $posted['matricula']['titulo'] ?? '' ),
			'texto'  => sanitize_text_field( $posted['matricula']['texto'] ?? '' ),
		),
	);
}

add_action( 'init', 'mirim_seed_servico_content', 20 );

function mirim_seed_servico_content() {
	if ( get_option( 'colegiomirim_servico_seed' ) ) {
		return;
	}
	$textos = array(
		'ensino-infantil'    => '<p>O Colégio Mirim oferece a Educação Infantil a partir de 2 anos. O percurso vai do G2 ao G5: o G2 e o G3 são a pré-escola, e o G4 e o G5 seguem no Ensino Infantil.</p>' . "\n"
			. '<p>A criança é protagonista e aprende em interação com o mundo e com o outro. O currículo é vivo e usa projetos, experiências, brincadeiras, investigação e criação para desenvolver competências cognitivas, emocionais, sociais e éticas.</p>' . "\n"
			. '<p>O ensino é bilíngue desde os 2 anos. Nas turmas da Educação Infantil há professores-auxiliares, e o cuidado com a segurança inclui monitoramento por câmeras, equipe de segurança e portaria reforçada.</p>',
		'ensino-fundamental' => '<p>O Ensino Fundamental vai do 1º ao 9º ano: Fundamental I, do 1º ao 5º ano, e Fundamental II, do 6º ao 9º ano. A proposta é acompanhar o desenvolvimento do aluno em todas as fases, tecendo aprendizagens com amor e conhecimento.</p>' . "\n"
			. '<p>A criança segue protagonista e aprende em interação com o mundo e com o outro. O currículo continua vivo, com projetos, experiências, investigação e criação para desenvolver competências cognitivas, emocionais, sociais e éticas.</p>' . "\n"
			. '<p>O ensino bilíngue segue até o 9º ano. No Ciclo I do Fundamental há professores-auxiliares. Na matrícula dessa etapa, o atestado de transferência entra entre os documentos.</p>',
	);
	$pronto = true;
	foreach ( $textos as $slug => $html ) {
		$post = get_page_by_path( $slug, OBJECT, 'servicos' );
		if ( ! $post instanceof WP_Post ) {
			$pronto = false;
			continue;
		}
		if ( '' === trim( $post->post_content ) ) {
			wp_update_post(
				array(
					'ID'           => $post->ID,
					'post_content' => $html,
				)
			);
		}
	}
	if ( $pronto ) {
		update_option( 'colegiomirim_servico_seed', 1 );
	}
}
