<?php

function mirim_is_list( $value ) {
	if ( ! is_array( $value ) ) {
		return false;
	}
	if ( array() === $value ) {
		return true;
	}
	return array_keys( $value ) === range( 0, count( $value ) - 1 );
}

function mirim_merge_section( $saved, $defaults ) {
	foreach ( $defaults as $key => $value ) {
		if ( mirim_is_list( $value ) ) {
			if ( ! isset( $saved[ $key ] ) || ! is_array( $saved[ $key ] ) ) {
				$saved[ $key ] = $value;
			} else {
				$template = ( isset( $value[0] ) && is_array( $value[0] ) ) ? $value[0] : array();
				foreach ( $saved[ $key ] as $index => $item ) {
					$saved[ $key ][ $index ] = mirim_merge_section( is_array( $item ) ? $item : array(), $template );
				}
			}
			continue;
		}
		if ( is_array( $value ) ) {
			$current       = ( isset( $saved[ $key ] ) && is_array( $saved[ $key ] ) ) ? $saved[ $key ] : array();
			$saved[ $key ] = mirim_merge_section( $current, $value );
			continue;
		}
		if ( ! array_key_exists( $key, $saved ) ) {
			$saved[ $key ] = $value;
		}
	}
	return $saved;
}

function mirim_home( $tab = null ) {
	$saved    = get_option( 'colegiomirim_home', array() );
	$defaults = mirim_home_defaults();
	$data     = array();
	if ( ! is_array( $saved ) ) {
		$saved = array();
	}
	foreach ( $defaults as $key => $value ) {
		$current    = ( isset( $saved[ $key ] ) && is_array( $saved[ $key ] ) ) ? $saved[ $key ] : array();
		$data[ $key ] = mirim_merge_section( $current, $value );
	}
	if ( $tab ) {
		return $data[ $tab ] ?? array();
	}
	return $data;
}

function mirim_geral() {
	$saved = get_option( 'colegiomirim_geral', array() );
	return mirim_merge_section( is_array( $saved ) ? $saved : array(), mirim_geral_defaults() );
}

function mirim_show( $tab ) {
	$data = mirim_home( $tab );
	return empty( $data['ocultar'] );
}

function mirim_lines( $text ) {
	$lines = preg_split( '/\r\n|\r|\n/', (string) $text );
	return array_values( array_filter( array_map( 'trim', $lines ), 'strlen' ) );
}

function mirim_image_url( $id, $arquivo = '' ) {
	$id = (int) $id;
	if ( $id ) {
		$url = wp_get_attachment_image_url( $id, 'full' );
		if ( $url ) {
			return $url;
		}
	}
	$arquivo = ltrim( (string) $arquivo, '/' );
	if ( '' === $arquivo ) {
		return '';
	}
	return home_url( '/assets/images/' . $arquivo );
}

function mirim_img( $item, $alt = '', $extra = array() ) {
	$url = mirim_image_url( $item['imagem'] ?? 0, $item['arquivo'] ?? '' );
	if ( ! $url ) {
		return '';
	}
	if ( '' === $alt ) {
		$alt = $item['alt'] ?? '';
	}
	$attrs = '';
	foreach ( $extra as $name => $value ) {
		$attrs .= ' ' . esc_attr( $name ) . '="' . esc_attr( $value ) . '"';
	}
	return '<img loading="lazy" decoding="async" src="' . esc_url( $url ) . '" alt="' . esc_attr( $alt ) . '"' . $attrs . '>';
}

function mirim_text( $text ) {
	return nl2br( esc_html( (string) $text ), false );
}

function mirim_digits( $value ) {
	return preg_replace( '/\D/', '', (string) $value );
}

function mirim_wa_icon() {
	return '<svg viewBox="0 0 24 24" width="20" height="20" aria-hidden="true" fill="currentColor"><path d="M12 3a9 9 0 00-7.8 13.5L3 21l4.7-1.2A9 9 0 1012 3zm4.9 12.7c-.2.6-1.2 1.1-1.7 1.2-.4.1-.9.2-2.9-.6-2.4-1-4-3.4-4.1-3.6-.1-.2-1.2-1.6-1.2-3s.7-2.1 1-2.4c.2-.3.5-.3.7-.3h.5c.2 0 .4 0 .6.5.2.6.7 2 .8 2.1.1.2.1.3 0 .5-.1.2-.2.3-.3.5l-.2.3c-.1.1-.2.3-.1.5.1.2.6 1 1.3 1.6.9.8 1.6 1 1.8 1.2.2.1.4.1.5 0l.7-.8c.2-.2.3-.2.5-.1l1.6.8c.2.1.4.2.4.3.1.2.1.9-.1 1.5z"/></svg>';
}

function mirim_wa( $kind = 'matricula' ) {
	$geral = mirim_geral();
	$map   = array(
		'visita'             => 'mensagem_visita',
		'matricula'          => 'mensagem_matricula',
		'infantil'           => 'mensagem_infantil',
		'fundamental'        => 'mensagem_fundamental',
		'visita_infantil'    => 'mensagem_visita_infantil',
		'visita_fundamental' => 'mensagem_visita_fundamental',
		'info'               => 'mensagem_info',
		'rede'               => 'mensagem_rede',
	);
	$key  = $map[ $kind ] ?? 'mensagem_matricula';
	$text = $geral[ $key ] ?? $geral['mensagem_matricula'];
	return 'https://wa.me/' . mirim_digits( $geral['whatsapp'] ) . '?text=' . rawurlencode( $text );
}

function mirim_tel() {
	$geral = mirim_geral();
	$phone = mirim_digits( $geral['telefone'] );
	$wa    = mirim_digits( $geral['whatsapp'] );
	if ( $wa && $phone && strlen( $wa ) >= strlen( $phone ) && substr( $wa, -strlen( $phone ) ) === $phone ) {
		return 'tel:+' . $wa;
	}
	if ( $phone && 0 !== strpos( $phone, '55' ) && strlen( $phone ) <= 11 ) {
		$phone = '55' . $phone;
	}
	return 'tel:+' . $phone;
}

function mirim_logo() {
	$geral = mirim_geral();
	$url   = mirim_image_url( $geral['logo'], $geral['logo_arquivo'] );
	if ( ! $url ) {
		$url = home_url( '/assets/images/colegiomirimlogo.webp' );
	}
	return '<img src="' . esc_url( $url ) . '" alt="' . esc_attr( $geral['logo_alt'] ) . '" width="160" height="72">';
}

function mirim_servico( $post_id = 0 ) {
	if ( ! $post_id ) {
		$post_id = get_queried_object_id();
	}
	$slug  = (string) get_post_field( 'post_name', $post_id );
	$saved = get_post_meta( $post_id, '_mirim_servico', true );
	return mirim_merge_section( is_array( $saved ) ? $saved : array(), mirim_servico_defaults( $slug ) );
}

function mirim_servico_mensagem( $slug, $visita = false ) {
	if ( 'ensino-fundamental' === $slug ) {
		return $visita ? 'visita_fundamental' : 'fundamental';
	}
	return $visita ? 'visita_infantil' : 'infantil';
}

function mirim_contato( $post_id = 0 ) {
	if ( ! $post_id ) {
		$post_id = get_queried_object_id();
	}
	$saved = get_post_meta( $post_id, '_mirim_contato', true );
	return mirim_merge_section( is_array( $saved ) ? $saved : array(), mirim_contato_defaults() );
}

function mirim_galeria( $post_id = 0 ) {
	if ( ! $post_id ) {
		$post_id = get_queried_object_id();
	}
	$saved = get_post_meta( $post_id, '_mirim_galeria', true );
	return mirim_merge_section( is_array( $saved ) ? $saved : array(), mirim_galeria_defaults() );
}

function mirim_sobre( $post_id = 0 ) {
	if ( ! $post_id ) {
		$post_id = get_queried_object_id();
	}
	$saved = get_post_meta( $post_id, '_mirim_sobre', true );
	return mirim_merge_section( is_array( $saved ) ? $saved : array(), mirim_sobre_defaults() );
}

function mirim_instagram_cta() {
	$geral = mirim_geral();
	if ( '' === $geral['instagram'] || '' === trim( $geral['cta_instagram'] ) ) {
		return;
	}
	echo '<section class="section-sm"><div class="container insta-cta">';
	echo '<a class="btn" href="' . esc_url( $geral['instagram'] ) . '" target="_blank" rel="noopener">';
	echo '<img src="' . esc_url( home_url( '/assets/images/instagram.svg' ) ) . '" alt="" width="18" height="18">';
	echo esc_html( $geral['cta_instagram'] );
	echo '</a></div></section>';
}

function mirim_shot( $item, $alt = '' ) {
	$url = mirim_image_url( $item['imagem'] ?? 0, $item['arquivo'] ?? '' );
	if ( ! $url ) {
		return '';
	}
	if ( '' === $alt ) {
		$alt = $item['alt'] ?? '';
	}
	return '<a class="shot" href="' . esc_url( $url ) . '" data-lightbox><img loading="lazy" decoding="async" src="' . esc_url( $url ) . '" alt="' . esc_attr( $alt ) . '"><span class="shot-zoom">+</span></a>';
}

function mirim_duvidas() {
	$posts = get_posts(
		array(
			'post_type'      => 'duvidas',
			'post_status'    => 'publish',
			'posts_per_page' => -1,
			'orderby'        => array(
				'menu_order' => 'ASC',
				'date'       => 'ASC',
			),
		)
	);
	return is_array( $posts ) ? $posts : array();
}

function mirim_depoimentos( $lugar ) {
	$lugares = array( 'home', 'sobre', 'ensino-infantil', 'ensino-fundamental' );
	if ( ! in_array( $lugar, $lugares, true ) ) {
		return array();
	}
	$posts = get_posts(
		array(
			'post_type'      => 'depoimentos',
			'post_status'    => 'publish',
			'posts_per_page' => -1,
			'orderby'        => array(
				'menu_order' => 'ASC',
				'date'       => 'ASC',
			),
			'meta_query'     => array(
				array(
					'key'     => '_mirim_locais',
					'value'   => '"' . $lugar . '"',
					'compare' => 'LIKE',
				),
			),
		)
	);
	return is_array( $posts ) ? $posts : array();
}

function mirim_path_url( $path ) {
	$path = trim( (string) $path );
	if ( '' === $path ) {
		return home_url( '/sobre/' );
	}
	if ( 0 === strpos( $path, 'http://' ) || 0 === strpos( $path, 'https://' ) ) {
		return $path;
	}
	return home_url( '/' . ltrim( $path, '/' ) );
}
