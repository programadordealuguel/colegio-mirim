<?php

add_action( 'admin_menu', 'mirim_admin_menu' );

function mirim_admin_menu() {
	add_menu_page( 'Conteúdo do site', 'Conteúdo do site', 'manage_options', 'colegiomirim', 'mirim_admin_home', 'dashicons-layout', 3 );
	add_submenu_page( 'colegiomirim', 'Página inicial', 'Página inicial', 'manage_options', 'colegiomirim', 'mirim_admin_home' );
	add_submenu_page( 'colegiomirim', 'Configurações', 'Configurações', 'manage_options', 'colegiomirim-geral', 'mirim_admin_geral' );
}

add_action( 'admin_enqueue_scripts', 'mirim_admin_assets' );

function mirim_admin_assets( $hook ) {
	unset( $hook );
	$page = isset( $_GET['page'] ) ? sanitize_key( wp_unslash( $_GET['page'] ) ) : '';
	if ( ! in_array( $page, array( 'colegiomirim', 'colegiomirim-geral' ), true ) && ! mirim_editing_sobre() && ! mirim_editing_galeria() && ! mirim_editing_contato() && ! mirim_editing_servico() ) {
		return;
	}
	wp_enqueue_media();
	wp_add_inline_style(
		'wp-admin',
		'.mirim-tabs{display:flex;flex-wrap:wrap;gap:6px;margin:16px 0 20px}.mirim-tabs a,.mirim-tabs button{padding:8px 12px;border:0;border-radius:8px;text-decoration:none;background:#f0f0f1;color:#1d2327;cursor:pointer}.mirim-tabs a.is-active,.mirim-tabs button.is-active{background:#2c4c37;color:#fff}.mirim-media img{display:block;margin:8px 0;border-radius:8px;max-width:280px;height:auto}.mirim-item{margin:0 0 16px;padding:12px 14px 4px;background:#fff;border:1px solid #dcdcde;border-radius:8px}.mirim-group{margin:8px 0 12px}.mirim-pane{display:none}.mirim-pane.is-on{display:block}.mirim-foto-list{counter-reset:mirim-foto}.mirim-foto-list .mirim-item{counter-increment:mirim-foto}.mirim-foto-list .mirim-group strong::after{content:" " counter(mirim-foto)}.mirim-row-list{counter-reset:mirim-row}.mirim-row-list .mirim-item{counter-increment:mirim-row}.mirim-row-list .mirim-group strong::after{content:" " counter(mirim-row)}.mirim-remove-row{margin-left:8px}.mirim-switch{margin:4px 0 8px}.mirim-toggle.is-off{background:#d63638;border-color:#d63638;color:#fff}.mirim-tabs button.is-off{box-shadow:inset 0 0 0 2px #d63638}'
	);
	wp_add_inline_script(
		'jquery',
		"jQuery(function($){var frame;$(document).on('click','.mirim-pick',function(e){e.preventDefault();var wrap=$(this).closest('.mirim-media');frame=wp.media({title:'Selecionar imagem',button:{text:'Usar esta imagem'},multiple:false});frame.on('select',function(){var att=frame.state().get('selection').first().toJSON();var url=(att.sizes&&att.sizes.medium)?att.sizes.medium.url:att.url;wrap.find('input.mirim-id').val(att.id);wrap.find('img').attr('src',url).show();});frame.open();});$(document).on('click','.mirim-clear',function(e){e.preventDefault();var wrap=$(this).closest('.mirim-media');wrap.find('input.mirim-id').val('0');wrap.find('input.mirim-file').val('');wrap.find('img').attr('src','').hide();});$(document).on('click','[data-mirim-tab]',function(e){e.preventDefault();var id=$(this).attr('data-mirim-tab');$(this).closest('.mirim-box').find('[data-mirim-tab]').removeClass('is-active');$(this).addClass('is-active');$(this).closest('.mirim-box').find('[data-mirim-pane]').removeClass('is-on');$(this).closest('.mirim-box').find('[data-mirim-pane=\"'+id+'\"]').addClass('is-on');});$(document).on('click','.mirim-add-foto,.mirim-add-row',function(e){e.preventDefault();var box=$(this).closest('.mirim-fotos,.mirim-repeater');var node=box.find('template').get(0);var html=node?node.innerHTML:'';html=html.replace(/__i__/g,String(Date.now()));box.find('.mirim-foto-list,.mirim-row-list').first().append(html);});$(document).on('click','.mirim-remove-row',function(e){e.preventDefault();$(this).closest('.mirim-item').remove();});$(document).on('click','.mirim-toggle',function(e){e.preventDefault();var btn=$(this);var input=btn.closest('.mirim-switch').find('.mirim-ocultar');var off=input.val()!=='1';input.val(off?'1':'');btn.toggleClass('is-off',off).attr('aria-pressed',off?'true':'false').text(off?'Ativar seção':'Desativar seção');var pane=btn.closest('[data-mirim-pane]');var id=pane.attr('data-mirim-pane');pane.closest('.mirim-box').find('[data-mirim-tab=\"'+id+'\"]').toggleClass('is-off',off);});});"
	);
}

function mirim_admin_home() {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}
	$tabs = array(
		'banner'       => 'Banner',
		'hashtag'      => 'Hashtag',
		'apresentacao' => 'Apresentação',
		'valores'      => 'Valores',
		'metodologia'  => 'Metodologia',
		'series'       => 'Séries',
		'matricula'    => 'Matrícula',
		'atividades'   => 'Extracurriculares',
		'duvidas'      => 'Dúvidas',
		'depoimentos'  => 'Depoimentos',
		'localizacao'  => 'Localização',
	);
	$tab = isset( $_GET['tab'] ) ? sanitize_key( wp_unslash( $_GET['tab'] ) ) : 'banner';
	if ( ! isset( $tabs[ $tab ] ) ) {
		$tab = 'banner';
	}

	if ( isset( $_POST['mirim_home_nonce'] ) && wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['mirim_home_nonce'] ) ), 'mirim_home_save' ) ) {
		$posted = isset( $_POST['home'][ $tab ] ) ? wp_unslash( $_POST['home'][ $tab ] ) : array();
		$all    = get_option( 'colegiomirim_home', array() );
		if ( ! is_array( $all ) ) {
			$all = array();
		}
		$all[ $tab ] = mirim_sanitize_home_tab( $tab, is_array( $posted ) ? $posted : array() );
		update_option( 'colegiomirim_home', $all );
		echo '<div class="updated"><p>Conteúdo salvo.</p></div>';
	}

	echo '<div class="wrap"><h1>Página inicial</h1>';
	echo '<p>Textos e imagens da home. O WhatsApp, o endereço e as redes ficam em <a href="' . esc_url( admin_url( 'admin.php?page=colegiomirim-geral' ) ) . '">Configurações</a>.</p>';
	echo '<nav class="mirim-tabs">';
	foreach ( $tabs as $slug => $label ) {
		$url = admin_url( 'admin.php?page=colegiomirim&tab=' . $slug );
		echo '<a class="' . ( $slug === $tab ? 'is-active' : '' ) . '" href="' . esc_url( $url ) . '">' . esc_html( $label ) . '</a>';
	}
	echo '</nav><form method="post">';
	wp_nonce_field( 'mirim_home_save', 'mirim_home_nonce' );
	echo '<table class="form-table" role="presentation">';
	mirim_hide_row( $tab );
	mirim_render_home_tab( $tab );
	echo '</table>';
	submit_button( 'Salvar' );
	echo '</form></div>';
}

function mirim_hide_row( $tab ) {
	$hidden = ! empty( mirim_home( $tab )['ocultar'] );
	echo '<tr><th scope="row">Exibição</th><td><label><input type="checkbox" name="home[' . esc_attr( $tab ) . '][ocultar]" value="1" ' . checked( $hidden, true, false ) . '> Ocultar esta seção na página inicial</label></td></tr>';
}

function mirim_text_row( $tab, $key, $label, $textarea = false ) {
	$value = mirim_home( $tab )[ $key ] ?? '';
	$name  = 'home[' . $tab . '][' . $key . ']';
	echo '<tr><th scope="row"><label for="' . esc_attr( $name ) . '">' . esc_html( $label ) . '</label></th><td>';
	if ( $textarea ) {
		echo '<textarea class="large-text" rows="5" id="' . esc_attr( $name ) . '" name="' . esc_attr( $name ) . '">' . esc_textarea( $value ) . '</textarea>';
	} else {
		echo '<input class="regular-text" type="text" id="' . esc_attr( $name ) . '" name="' . esc_attr( $name ) . '" value="' . esc_attr( $value ) . '">';
	}
	echo '</td></tr>';
}

function mirim_media_field( $name, $id, $arquivo = '' ) {
	$id  = (int) $id;
	$url = mirim_image_url( $id, $arquivo );
	echo '<div class="mirim-media">';
	echo '<input class="mirim-id" type="hidden" name="' . esc_attr( $name ) . '[imagem]" value="' . esc_attr( (string) $id ) . '">';
	echo '<input class="mirim-file" type="hidden" name="' . esc_attr( $name ) . '[arquivo]" value="' . esc_attr( $arquivo ) . '">';
	echo '<img src="' . esc_url( $url ) . '" alt="" style="' . ( $url ? '' : 'display:none' ) . '">';
	echo '<p><button type="button" class="button mirim-pick">Selecionar imagem</button> <button type="button" class="button mirim-clear">Remover</button></p>';
	echo '</div>';
}

function mirim_media_row( $label, $name, $id, $arquivo = '' ) {
	echo '<tr><th scope="row">' . esc_html( $label ) . '</th><td>';
	mirim_media_field( $name, $id, $arquivo );
	echo '</td></tr>';
}

function mirim_item_field( $name, $value, $label, $textarea = false ) {
	echo '<p><label>' . esc_html( $label ) . '<br>';
	if ( $textarea ) {
		echo '<textarea class="large-text" rows="4" name="' . esc_attr( $name ) . '">' . esc_textarea( $value ) . '</textarea>';
	} else {
		echo '<input class="regular-text" type="text" name="' . esc_attr( $name ) . '" value="' . esc_attr( $value ) . '">';
	}
	echo '</label></p>';
}

function mirim_render_home_tab( $tab ) {
	$data = mirim_home( $tab );
	if ( 'banner' === $tab ) {
		mirim_media_row( 'Imagem do banner', 'home[banner]', $data['imagem'], $data['arquivo'] );
	} elseif ( 'hashtag' === $tab ) {
		mirim_text_row( 'hashtag', 'texto', 'Texto' );
	} elseif ( 'apresentacao' === $tab ) {
		mirim_text_row( 'apresentacao', 'kicker', 'Linha de apoio' );
		mirim_text_row( 'apresentacao', 'titulo', 'Título' );
		mirim_text_row( 'apresentacao', 'texto', 'Texto', true );
		echo '<tr><th scope="row">Fotos</th><td>';
		mirim_render_fotos( 'home[apresentacao][fotos]', $data['fotos'] );
		echo '</td></tr>';
	} elseif ( 'valores' === $tab ) {
		mirim_text_row( 'valores', 'titulo', 'Título' );
		mirim_text_row( 'valores', 'texto', 'Texto', true );
		echo '<tr><th scope="row">Cards</th><td>';
		mirim_render_cards( 'home[valores][itens]', $data['itens'], array( 'titulo' => 'Título', 'texto' => 'Texto' ), true );
		echo '</td></tr>';
	} elseif ( 'metodologia' === $tab ) {
		mirim_text_row( 'metodologia', 'titulo', 'Título' );
		mirim_text_row( 'metodologia', 'texto', 'Texto', true );
		mirim_text_row( 'metodologia', 'itens', 'Itens da lista (um por linha)', true );
		mirim_text_row( 'metodologia', 'link', 'Link do título' );
		echo '<tr><td colspan="2"><p class="description">Use um caminho do site, como /sobre/, ou um endereço completo.</p></td></tr>';
		mirim_text_row( 'metodologia', 'alt', 'Texto alternativo da imagem' );
		mirim_media_row( 'Foto', 'home[metodologia]', $data['imagem'], $data['arquivo'] );
	} elseif ( 'series' === $tab ) {
		mirim_text_row( 'series', 'kicker', 'Linha de apoio' );
		echo '<tr><th scope="row">Séries</th><td>';
		$items   = $data['itens'];
		$items[] = array( 'selo' => '', 'titulo' => '', 'subtitulo' => '', 'destino' => 'ensino-infantil' );
		foreach ( $items as $index => $item ) {
			$name = 'home[series][itens][' . $index . ']';
			$novo = $index === count( $items ) - 1;
			echo '<div class="mirim-item">';
			echo '<p class="mirim-group"><strong>' . ( $novo ? 'Nova série' : 'Série ' . ( $index + 1 ) ) . '</strong></p>';
			mirim_item_field( $name . '[selo]', $item['selo'], 'Selo' );
			mirim_item_field( $name . '[titulo]', $item['titulo'], 'Título' );
			mirim_item_field( $name . '[subtitulo]', $item['subtitulo'], 'Subtítulo' );
			echo '<p><label>Destino<br><select name="' . esc_attr( $name ) . '[destino]">';
			echo '<option value="ensino-infantil"' . selected( $item['destino'], 'ensino-infantil', false ) . '>Ensino Infantil</option>';
			echo '<option value="ensino-fundamental"' . selected( $item['destino'], 'ensino-fundamental', false ) . '>Ensino Fundamental</option>';
			echo '</select></label></p>';
			if ( ! $novo ) {
				echo '<p><label><input type="checkbox" name="' . esc_attr( $name ) . '[remover]" value="1"> Remover esta série</label></p>';
			}
			echo '</div>';
		}
		echo '</td></tr>';
	} elseif ( 'matricula' === $tab ) {
		echo '<tr><td colspan="2"><p>O botão abre o WhatsApp com a mensagem de visita definida em Configurações.</p></td></tr>';
		mirim_text_row( 'matricula', 'titulo', 'Título' );
		mirim_text_row( 'matricula', 'texto', 'Texto' );
		mirim_text_row( 'matricula', 'botao', 'Texto do botão' );
	} elseif ( 'atividades' === $tab ) {
		mirim_text_row( 'atividades', 'titulo', 'Título' );
		mirim_text_row( 'atividades', 'texto', 'Texto' );
		echo '<tr><th scope="row">Cards</th><td>';
		mirim_render_cards( 'home[atividades][itens]', $data['itens'], array( 'titulo' => 'Título' ), true );
		echo '</td></tr>';
	} elseif ( 'duvidas' === $tab ) {
		echo '<tr><td colspan="2"><p>O título e a foto são desta seção. Cada pergunta é cadastrada em <a href="' . esc_url( admin_url( 'edit.php?post_type=duvidas' ) ) . '">Dúvidas</a>.</p></td></tr>';
		mirim_text_row( 'duvidas', 'kicker', 'Linha de apoio' );
		mirim_text_row( 'duvidas', 'titulo', 'Título' );
		mirim_text_row( 'duvidas', 'alt', 'Texto alternativo da foto' );
		mirim_media_row( 'Foto da equipe', 'home[duvidas]', $data['imagem'], $data['arquivo'] );
	} elseif ( 'depoimentos' === $tab ) {
		echo '<tr><td colspan="2"><p>O título e a foto são desta seção. Cada família é cadastrada em <a href="' . esc_url( admin_url( 'edit.php?post_type=depoimentos' ) ) . '">Depoimentos</a>.</p></td></tr>';
		mirim_text_row( 'depoimentos', 'titulo', 'Título' );
		mirim_text_row( 'depoimentos', 'alt', 'Texto alternativo da foto' );
		mirim_media_row( 'Foto', 'home[depoimentos]', $data['imagem'], $data['arquivo'] );
	} elseif ( 'localizacao' === $tab ) {
		echo '<tr><td colspan="2"><p>O mapa usa o endereço incorporado de <a href="' . esc_url( admin_url( 'admin.php?page=colegiomirim-geral' ) ) . '">Configurações</a>.</p></td></tr>';
		mirim_text_row( 'localizacao', 'titulo', 'Título' );
		mirim_text_row( 'localizacao', 'texto', 'Texto' );
	}
}

function mirim_render_fotos( $name, $items ) {
	echo '<div class="mirim-fotos">';
	echo '<div class="mirim-foto-list">';
	foreach ( $items as $index => $item ) {
		mirim_foto_row( $name, $index, $item );
	}
	echo '</div>';
	echo '<template class="mirim-foto-tpl">';
	mirim_foto_row( $name, '__i__', array( 'imagem' => 0, 'arquivo' => '', 'alt' => '' ) );
	echo '</template>';
	echo '<p><button type="button" class="button button-primary mirim-add-foto">Adicionar foto</button></p>';
	echo '</div>';
}

function mirim_foto_row( $name, $index, $item ) {
	echo '<div class="mirim-item">';
	echo '<p class="mirim-group"><strong>Foto</strong> <button type="button" class="button-link-delete mirim-remove-row">Remover</button></p>';
	mirim_media_field( $name . '[' . $index . ']', $item['imagem'] ?? 0, $item['arquivo'] ?? '' );
	mirim_item_field( $name . '[' . $index . '][alt]', $item['alt'] ?? '', 'Texto alternativo' );
	echo '</div>';
}

function mirim_render_repeater( $name, $items, $fields, $noun, $add_label ) {
	echo '<div class="mirim-repeater">';
	echo '<div class="mirim-row-list">';
	foreach ( $items as $index => $item ) {
		mirim_repeater_row( $name, $index, $item, $fields, $noun );
	}
	echo '</div><template class="mirim-row-tpl">';
	$blank = array();
	foreach ( $fields as $key => $label ) {
		unset( $label );
		$blank[ $key ] = '';
	}
	mirim_repeater_row( $name, '__i__', $blank, $fields, $noun );
	echo '</template>';
	echo '<p><button type="button" class="button button-primary mirim-add-row">' . esc_html( $add_label ) . '</button></p>';
	echo '</div>';
}

function mirim_repeater_row( $name, $index, $item, $fields, $noun ) {
	echo '<div class="mirim-item">';
	echo '<p class="mirim-group"><strong>' . esc_html( $noun ) . '</strong> <button type="button" class="button-link-delete mirim-remove-row">Remover</button></p>';
	foreach ( $fields as $key => $label ) {
		mirim_item_field( $name . '[' . $index . '][' . $key . ']', $item[ $key ] ?? '', $label, 'texto' === $key );
	}
	echo '</div>';
}

function mirim_render_cards( $name, $items, $fields, $with_image ) {
	$blank = array( 'imagem' => 0, 'arquivo' => '' );
	foreach ( $fields as $key => $label ) {
		unset( $label );
		$blank[ $key ] = '';
	}
	$items[] = $blank;
	foreach ( $items as $index => $item ) {
		$novo = $index === count( $items ) - 1;
		echo '<div class="mirim-item">';
		echo '<p class="mirim-group"><strong>' . ( $novo ? 'Novo card' : 'Card ' . ( $index + 1 ) ) . '</strong></p>';
		if ( $with_image ) {
			mirim_media_field( $name . '[' . $index . ']', $item['imagem'] ?? 0, $item['arquivo'] ?? '' );
		}
		foreach ( $fields as $key => $label ) {
			mirim_item_field( $name . '[' . $index . '][' . $key . ']', $item[ $key ] ?? '', $label, 'texto' === $key );
		}
		if ( ! $novo ) {
			echo '<p><label><input type="checkbox" name="' . esc_attr( $name . '[' . $index . '][remover]' ) . '" value="1"> Remover este card</label></p>';
		}
		echo '</div>';
	}
}

function mirim_sanitize_value( $type, $value ) {
	if ( 'long' === $type ) {
		return sanitize_textarea_field( (string) $value );
	}
	if ( 'url' === $type ) {
		return esc_url_raw( (string) $value );
	}
	if ( 'image' === $type ) {
		return absint( $value );
	}
	if ( 'file' === $type ) {
		$file = ltrim( sanitize_text_field( (string) $value ), '/' );
		return ( strpos( $file, '..' ) !== false ) ? '' : $file;
	}
	if ( 'destino' === $type ) {
		return in_array( $value, array( 'ensino-infantil', 'ensino-fundamental' ), true ) ? $value : 'ensino-infantil';
	}
	return sanitize_text_field( (string) $value );
}

function mirim_sanitize_rows( $rows, $fields, $content_keys ) {
	$clean = array();
	if ( ! is_array( $rows ) ) {
		return $clean;
	}
	foreach ( $rows as $row ) {
		if ( ! is_array( $row ) || ! empty( $row['remover'] ) ) {
			continue;
		}
		$item = array();
		$keep = false;
		foreach ( $fields as $key => $type ) {
			$item[ $key ] = mirim_sanitize_value( $type, $row[ $key ] ?? '' );
		}
		foreach ( $content_keys as $key ) {
			if ( ! empty( $item[ $key ] ) ) {
				$keep = true;
			}
		}
		if ( $keep ) {
			$clean[] = $item;
		}
	}
	return $clean;
}

function mirim_sanitize_home_tab( $tab, $posted ) {
	$clean = array( 'ocultar' => empty( $posted['ocultar'] ) ? '' : '1' );
	$text  = array();
	$long  = array();
	if ( 'banner' === $tab ) {
		$clean['imagem']  = absint( $posted['imagem'] ?? 0 );
		$clean['arquivo'] = mirim_sanitize_value( 'file', $posted['arquivo'] ?? '' );
	} elseif ( 'hashtag' === $tab ) {
		$text = array( 'texto' );
	} elseif ( 'apresentacao' === $tab ) {
		$text            = array( 'kicker', 'titulo' );
		$long            = array( 'texto' );
		$clean['fotos']  = mirim_sanitize_rows( $posted['fotos'] ?? array(), array( 'imagem' => 'image', 'arquivo' => 'file', 'alt' => 'text' ), array( 'imagem', 'arquivo' ) );
	} elseif ( 'valores' === $tab ) {
		$text           = array( 'titulo' );
		$long           = array( 'texto' );
		$clean['itens'] = mirim_sanitize_rows( $posted['itens'] ?? array(), array( 'imagem' => 'image', 'arquivo' => 'file', 'titulo' => 'text', 'texto' => 'long' ), array( 'titulo', 'texto', 'imagem', 'arquivo' ) );
	} elseif ( 'metodologia' === $tab ) {
		$text = array( 'titulo', 'link', 'alt' );
		$long = array( 'texto', 'itens' );
		$clean['imagem']  = absint( $posted['imagem'] ?? 0 );
		$clean['arquivo'] = mirim_sanitize_value( 'file', $posted['arquivo'] ?? '' );
	} elseif ( 'series' === $tab ) {
		$text           = array( 'kicker' );
		$clean['itens'] = mirim_sanitize_rows( $posted['itens'] ?? array(), array( 'selo' => 'text', 'titulo' => 'text', 'subtitulo' => 'text', 'destino' => 'destino' ), array( 'selo', 'titulo' ) );
	} elseif ( 'matricula' === $tab ) {
		$text = array( 'titulo', 'texto', 'botao' );
	} elseif ( 'atividades' === $tab ) {
		$text           = array( 'titulo', 'texto' );
		$clean['itens'] = mirim_sanitize_rows( $posted['itens'] ?? array(), array( 'imagem' => 'image', 'arquivo' => 'file', 'titulo' => 'text' ), array( 'titulo', 'imagem', 'arquivo' ) );
	} elseif ( 'duvidas' === $tab ) {
		$text             = array( 'kicker', 'titulo', 'alt' );
		$clean['imagem']  = absint( $posted['imagem'] ?? 0 );
		$clean['arquivo'] = mirim_sanitize_value( 'file', $posted['arquivo'] ?? '' );
	} elseif ( 'depoimentos' === $tab ) {
		$text             = array( 'titulo', 'alt' );
		$clean['imagem']  = absint( $posted['imagem'] ?? 0 );
		$clean['arquivo'] = mirim_sanitize_value( 'file', $posted['arquivo'] ?? '' );
	} elseif ( 'localizacao' === $tab ) {
		$text = array( 'titulo', 'texto' );
	}
	foreach ( $text as $key ) {
		$clean[ $key ] = sanitize_text_field( $posted[ $key ] ?? '' );
	}
	foreach ( $long as $key ) {
		$clean[ $key ] = sanitize_textarea_field( $posted[ $key ] ?? '' );
	}
	return $clean;
}

function mirim_admin_geral() {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}
	if ( isset( $_POST['mirim_geral_nonce'] ) && wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['mirim_geral_nonce'] ) ), 'mirim_geral_save' ) ) {
		$posted = isset( $_POST['geral'] ) ? wp_unslash( $_POST['geral'] ) : array();
		update_option( 'colegiomirim_geral', mirim_sanitize_geral( is_array( $posted ) ? $posted : array() ) );
		echo '<div class="updated"><p>Configurações salvas.</p></div>';
	}
	$geral = mirim_geral();
	echo '<div class="wrap"><h1>Configurações</h1>';
	echo '<p>Dados usados no site inteiro: topo, rodapé, WhatsApp, redes e mapa.</p>';
	echo '<form method="post">';
	wp_nonce_field( 'mirim_geral_save', 'mirim_geral_nonce' );
	echo '<table class="form-table" role="presentation">';
	mirim_geral_input( 'faixa', 'Faixa do topo', $geral['faixa'] );
	echo '<tr><th scope="row">Logo</th><td>';
	mirim_media_field( 'geral[logo_midia]', $geral['logo'], $geral['logo_arquivo'] );
	echo '</td></tr>';
	mirim_geral_input( 'logo_alt', 'Texto alternativo da logo', $geral['logo_alt'] );
	mirim_geral_input( 'email', 'E-mail', $geral['email'] );
	mirim_geral_input( 'telefone', 'Telefone', $geral['telefone'], 'Como aparece no site. Exemplo: (71) 99264-5794' );
	mirim_geral_input( 'endereco', 'Endereço', $geral['endereco'] );
	mirim_geral_input( 'mapa', 'Mapa', $geral['mapa'], 'Endereço de incorporação do Google Maps.', true );
	echo '<tr><th scope="row">WhatsApp</th><td><p class="description">O número entra em todos os botões. Cada mensagem abre no contexto indicado.</p></td></tr>';
	mirim_geral_input( 'whatsapp', 'Número do WhatsApp', $geral['whatsapp'], 'Só números, com DDI. Exemplo: 5571992645794' );
	mirim_geral_input( 'mensagem_visita', 'Mensagem de visita', $geral['mensagem_visita'], 'Home, contato e botão de agendar visita.' );
	mirim_geral_input( 'mensagem_matricula', 'Mensagem de matrícula', $geral['mensagem_matricula'], 'Botão Matricule-se das páginas gerais.' );
	mirim_geral_input( 'mensagem_infantil', 'Mensagem do Ensino Infantil', $geral['mensagem_infantil'] );
	mirim_geral_input( 'mensagem_visita_infantil', 'Visita no Ensino Infantil', $geral['mensagem_visita_infantil'] );
	mirim_geral_input( 'mensagem_fundamental', 'Mensagem do Ensino Fundamental', $geral['mensagem_fundamental'] );
	mirim_geral_input( 'mensagem_visita_fundamental', 'Visita no Ensino Fundamental', $geral['mensagem_visita_fundamental'] );
	mirim_geral_input( 'mensagem_info', 'Mensagem do botão flutuante', $geral['mensagem_info'] );
	mirim_geral_input( 'mensagem_rede', 'Mensagem do ícone no rodapé', $geral['mensagem_rede'] );
	mirim_geral_input( 'cta_home', 'Botão do menu na home', $geral['cta_home'] );
	mirim_geral_input( 'cta_contato', 'Botão do menu no contato', $geral['cta_contato'] );
	mirim_geral_input( 'cta_matricula', 'Botão do menu nas outras páginas', $geral['cta_matricula'] );
	mirim_geral_input( 'facebook', 'Facebook', $geral['facebook'] );
	mirim_geral_input( 'instagram', 'Instagram', $geral['instagram'] );
	mirim_geral_input( 'cta_instagram', 'Botão do Instagram', $geral['cta_instagram'], 'Aparece no fim da Sobre e da Galeria. O link é o campo acima.' );
	mirim_geral_input( 'youtube', 'YouTube', $geral['youtube'] );
	mirim_geral_input( 'rodape_titulo', 'Título do rodapé', $geral['rodape_titulo'] );
	mirim_geral_input( 'rodape_botao', 'Botão do rodapé', $geral['rodape_botao'] );
	mirim_geral_input( 'copyright', 'Copyright', $geral['copyright'] );
	echo '</table>';
	submit_button( 'Salvar' );
	echo '</form></div>';
}

function mirim_geral_input( $key, $label, $value, $help = '', $textarea = false ) {
	echo '<tr><th scope="row"><label for="geral-' . esc_attr( $key ) . '">' . esc_html( $label ) . '</label></th><td>';
	if ( $textarea ) {
		echo '<textarea class="large-text" rows="4" id="geral-' . esc_attr( $key ) . '" name="geral[' . esc_attr( $key ) . ']">' . esc_textarea( $value ) . '</textarea>';
	} else {
		echo '<input class="regular-text" type="text" id="geral-' . esc_attr( $key ) . '" name="geral[' . esc_attr( $key ) . ']" value="' . esc_attr( $value ) . '">';
	}
	if ( $help ) {
		echo '<p class="description">' . esc_html( $help ) . '</p>';
	}
	echo '</td></tr>';
}

function mirim_sanitize_geral( $posted ) {
	$current = mirim_geral_defaults();
	$urls    = array( 'mapa', 'facebook', 'instagram', 'youtube' );
	$long    = array( 'mensagem_visita', 'mensagem_matricula', 'mensagem_infantil', 'mensagem_fundamental', 'mensagem_visita_infantil', 'mensagem_visita_fundamental', 'mensagem_info', 'mensagem_rede', 'endereco', 'copyright' );
	foreach ( $current as $key => $value ) {
		unset( $value );
		if ( in_array( $key, array( 'logo', 'logo_arquivo' ), true ) ) {
			continue;
		}
		if ( 'whatsapp' === $key ) {
			$current[ $key ] = mirim_digits( $posted[ $key ] ?? '' );
		} elseif ( in_array( $key, $urls, true ) ) {
			$current[ $key ] = esc_url_raw( $posted[ $key ] ?? '' );
		} elseif ( in_array( $key, $long, true ) ) {
			$current[ $key ] = sanitize_textarea_field( $posted[ $key ] ?? '' );
		} else {
			$current[ $key ] = sanitize_text_field( $posted[ $key ] ?? '' );
		}
	}
	$midia                 = isset( $posted['logo_midia'] ) && is_array( $posted['logo_midia'] ) ? $posted['logo_midia'] : array();
	$current['logo']         = absint( $midia['imagem'] ?? 0 );
	$current['logo_arquivo'] = mirim_sanitize_value( 'file', $midia['arquivo'] ?? '' );
	return $current;
}

function mirim_depoimento_lugares() {
	return array(
		'home'               => 'Página inicial',
		'sobre'              => 'Sobre',
		'ensino-infantil'    => 'Ensino Infantil',
		'ensino-fundamental' => 'Ensino Fundamental',
	);
}

add_filter(
	'enter_title_here',
	function ( $text, $post ) {
		if ( $post instanceof WP_Post && 'depoimentos' === $post->post_type ) {
			return 'Nome, por exemplo Talita S.';
		}
		if ( $post instanceof WP_Post && 'duvidas' === $post->post_type ) {
			return 'Pergunta';
		}
		return $text;
	},
	10,
	2
);

add_action( 'add_meta_boxes', 'mirim_depoimento_metabox' );

function mirim_depoimento_metabox() {
	add_meta_box( 'mirim-depoimento', 'Depoimento', 'mirim_depoimento_metabox_html', 'depoimentos', 'normal', 'high' );
}

function mirim_depoimento_metabox_html( $post ) {
	wp_nonce_field( 'mirim_depoimento_save', 'mirim_depoimento_nonce' );
	$locais = get_post_meta( $post->ID, '_mirim_locais', true );
	if ( ! is_array( $locais ) ) {
		$locais = array( 'home' );
	}
	echo '<p><label for="mirim-depoimento-texto"><strong>Texto</strong></label></p>';
	echo '<textarea class="large-text" rows="8" id="mirim-depoimento-texto" name="mirim_depoimento_texto">' . esc_textarea( $post->post_content ) . '</textarea>';
	echo '<p><strong>Exibir em</strong></p>';
	foreach ( mirim_depoimento_lugares() as $slug => $label ) {
		echo '<p><label><input type="checkbox" name="mirim_depoimento_locais[]" value="' . esc_attr( $slug ) . '" ' . checked( in_array( $slug, $locais, true ), true, false ) . '> ' . esc_html( $label ) . '</label></p>';
	}
	echo '<p><label for="mirim-depoimento-ordem"><strong>Ordem</strong></label><br>';
	echo '<input type="number" id="mirim-depoimento-ordem" name="mirim_depoimento_ordem" value="' . esc_attr( (string) $post->menu_order ) . '" min="0" step="1" class="small-text">';
	echo '<span class="description"> Números menores aparecem primeiro.</span></p>';
}

add_action( 'save_post_depoimentos', 'mirim_depoimento_save' );

function mirim_depoimento_save( $post_id ) {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	if ( ! isset( $_POST['mirim_depoimento_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['mirim_depoimento_nonce'] ) ), 'mirim_depoimento_save' ) ) {
		return;
	}
	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}
	$texto  = sanitize_textarea_field( wp_unslash( $_POST['mirim_depoimento_texto'] ?? '' ) );
	$ordem  = absint( $_POST['mirim_depoimento_ordem'] ?? 0 );
	$locais = array();
	$posted = isset( $_POST['mirim_depoimento_locais'] ) ? wp_unslash( $_POST['mirim_depoimento_locais'] ) : array();
	if ( is_array( $posted ) ) {
		foreach ( $posted as $lugar ) {
			$lugar = sanitize_key( $lugar );
			if ( isset( mirim_depoimento_lugares()[ $lugar ] ) ) {
				$locais[] = $lugar;
			}
		}
	}
	update_post_meta( $post_id, '_mirim_locais', $locais );
	remove_action( 'save_post_depoimentos', 'mirim_depoimento_save' );
	wp_update_post(
		array(
			'ID'           => $post_id,
			'post_content' => $texto,
			'menu_order'   => $ordem,
		)
	);
	add_action( 'save_post_depoimentos', 'mirim_depoimento_save' );
}

add_filter( 'manage_depoimentos_posts_columns', 'mirim_depoimento_columns' );

function mirim_depoimento_columns( $columns ) {
	$novo = array();
	foreach ( $columns as $key => $label ) {
		$novo[ $key ] = $label;
		if ( 'title' === $key ) {
			$novo['mirim_locais'] = 'Exibir em';
			$novo['mirim_ordem']  = 'Ordem';
		}
	}
	return $novo;
}

add_action( 'manage_depoimentos_posts_custom_column', 'mirim_depoimento_column', 10, 2 );

function mirim_depoimento_column( $column, $post_id ) {
	if ( 'mirim_locais' === $column ) {
		$locais = get_post_meta( $post_id, '_mirim_locais', true );
		$nomes  = array();
		if ( is_array( $locais ) ) {
			foreach ( mirim_depoimento_lugares() as $slug => $label ) {
				if ( in_array( $slug, $locais, true ) ) {
					$nomes[] = $label;
				}
			}
		}
		echo esc_html( $nomes ? implode( ', ', $nomes ) : '—' );
	}
	if ( 'mirim_ordem' === $column ) {
		echo esc_html( (string) get_post_field( 'menu_order', $post_id ) );
	}
}

add_action( 'add_meta_boxes', 'mirim_duvida_metabox' );

function mirim_duvida_metabox() {
	add_meta_box( 'mirim-duvida', 'Dúvida', 'mirim_duvida_metabox_html', 'duvidas', 'normal', 'high' );
}

function mirim_duvida_metabox_html( $post ) {
	wp_nonce_field( 'mirim_duvida_save', 'mirim_duvida_nonce' );
	echo '<p><label for="mirim-duvida-resposta"><strong>Resposta</strong></label></p>';
	echo '<textarea class="large-text" rows="8" id="mirim-duvida-resposta" name="mirim_duvida_resposta">' . esc_textarea( $post->post_content ) . '</textarea>';
	echo '<p><label for="mirim-duvida-ordem"><strong>Ordem</strong></label><br>';
	echo '<input type="number" id="mirim-duvida-ordem" name="mirim_duvida_ordem" value="' . esc_attr( (string) $post->menu_order ) . '" min="0" step="1" class="small-text">';
	echo '<span class="description"> Números menores aparecem primeiro.</span></p>';
}

add_action( 'save_post_duvidas', 'mirim_duvida_save' );

function mirim_duvida_save( $post_id ) {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	if ( ! isset( $_POST['mirim_duvida_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['mirim_duvida_nonce'] ) ), 'mirim_duvida_save' ) ) {
		return;
	}
	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}
	$resposta = sanitize_textarea_field( wp_unslash( $_POST['mirim_duvida_resposta'] ?? '' ) );
	$ordem    = absint( $_POST['mirim_duvida_ordem'] ?? 0 );
	remove_action( 'save_post_duvidas', 'mirim_duvida_save' );
	wp_update_post(
		array(
			'ID'           => $post_id,
			'post_content' => $resposta,
			'menu_order'   => $ordem,
		)
	);
	add_action( 'save_post_duvidas', 'mirim_duvida_save' );
}

add_filter( 'manage_duvidas_posts_columns', 'mirim_duvida_columns' );

function mirim_duvida_columns( $columns ) {
	$novo = array();
	foreach ( $columns as $key => $label ) {
		if ( 'date' === $key ) {
			$novo['mirim_ordem'] = 'Ordem';
		}
		$novo[ $key ] = $label;
	}
	return $novo;
}

add_action( 'manage_duvidas_posts_custom_column', 'mirim_duvida_column', 10, 2 );

function mirim_duvida_column( $column, $post_id ) {
	if ( 'mirim_ordem' === $column ) {
		echo esc_html( (string) get_post_field( 'menu_order', $post_id ) );
	}
}
