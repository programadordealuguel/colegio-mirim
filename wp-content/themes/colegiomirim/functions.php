<?php
/**
 * Tema Colégio Mirim: carrega só o CSS e o JS do site e tira o que o front não usa.
 */

require __DIR__ . '/inc/defaults.php';
require __DIR__ . '/inc/helpers.php';
require __DIR__ . '/inc/admin.php';
require __DIR__ . '/inc/sobre.php';
require __DIR__ . '/inc/galeria.php';
require __DIR__ . '/inc/contato.php';
require __DIR__ . '/inc/servico.php';

function mirim_setup() {
	add_theme_support( 'title-tag' );
	add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script' ) );
	add_filter( 'show_admin_bar', '__return_false' );
}
add_action( 'after_setup_theme', 'mirim_setup' );

function mirim_register_servicos() {
	register_post_type(
		'servicos',
		array(
			'labels'              => array(
				'name'               => 'Serviços',
				'singular_name'      => 'Serviço',
				'menu_name'          => 'Serviços',
				'add_new'            => 'Adicionar serviço',
				'add_new_item'       => 'Adicionar serviço',
				'edit_item'          => 'Editar serviço',
				'new_item'           => 'Novo serviço',
				'view_item'          => 'Ver serviço',
				'search_items'       => 'Buscar serviços',
				'not_found'          => 'Nenhum serviço encontrado',
				'not_found_in_trash' => 'Nenhum serviço na lixeira',
			),
			'public'              => true,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'show_in_rest'        => true,
			'menu_position'       => 20,
			'menu_icon'           => 'dashicons-welcome-learn-more',
			'has_archive'         => false,
			'rewrite'             => array(
				'slug'       => 'servico',
				'with_front' => false,
			),
			'supports'            => array( 'title', 'editor', 'thumbnail', 'excerpt', 'revisions' ),
			'exclude_from_search' => false,
		)
	);
}
add_action( 'init', 'mirim_register_servicos' );

function mirim_register_depoimentos() {
	register_post_type(
		'depoimentos',
		array(
			'labels'              => array(
				'name'               => 'Depoimentos',
				'singular_name'      => 'Depoimento',
				'menu_name'          => 'Depoimentos',
				'add_new'            => 'Adicionar depoimento',
				'add_new_item'       => 'Adicionar depoimento',
				'edit_item'          => 'Editar depoimento',
				'new_item'           => 'Novo depoimento',
				'view_item'          => 'Ver depoimento',
				'search_items'       => 'Buscar depoimentos',
				'not_found'          => 'Nenhum depoimento encontrado',
				'not_found_in_trash' => 'Nenhum depoimento na lixeira',
			),
			'public'              => false,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'show_in_rest'        => false,
			'menu_position'       => 21,
			'menu_icon'           => 'dashicons-format-quote',
			'has_archive'         => false,
			'rewrite'             => false,
			'query_var'           => false,
			'supports'            => array( 'title' ),
			'exclude_from_search' => true,
		)
	);
}
add_action( 'init', 'mirim_register_depoimentos' );

function mirim_register_duvidas() {
	register_post_type(
		'duvidas',
		array(
			'labels'              => array(
				'name'               => 'Dúvidas',
				'singular_name'      => 'Dúvida',
				'menu_name'          => 'Dúvidas',
				'add_new'            => 'Adicionar dúvida',
				'add_new_item'       => 'Adicionar dúvida',
				'edit_item'          => 'Editar dúvida',
				'new_item'           => 'Nova dúvida',
				'view_item'          => 'Ver dúvida',
				'search_items'       => 'Buscar dúvidas',
				'not_found'          => 'Nenhuma dúvida encontrada',
				'not_found_in_trash' => 'Nenhuma dúvida na lixeira',
			),
			'public'              => false,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'show_in_rest'        => false,
			'menu_position'       => 22,
			'menu_icon'           => 'dashicons-editor-help',
			'has_archive'         => false,
			'rewrite'             => false,
			'query_var'           => false,
			'supports'            => array( 'title' ),
			'exclude_from_search' => true,
		)
	);
}
add_action( 'init', 'mirim_register_duvidas' );

function mirim_seed_depoimentos() {
	if ( get_option( 'colegiomirim_depoimentos_seed' ) ) {
		return;
	}
	$existing = get_posts(
		array(
			'post_type'      => 'depoimentos',
			'post_status'    => 'any',
			'posts_per_page' => 1,
			'fields'         => 'ids',
		)
	);
	if ( $existing ) {
		update_option( 'colegiomirim_depoimentos_seed', 1 );
		return;
	}
	$itens = array(
		array(
			'nome'   => 'Talita S.',
			'ordem'  => 1,
			'locais' => array( 'home', 'sobre', 'ensino-infantil' ),
			'texto'  => 'Vocês me surpreenderam muito, nunca fomos tão bem acolhidos, amados. Ryan nunca viveu uma experiência tão legal quanto escola, aprendizado, amizades e respeito. Que alegria ler essa mensagem, pois Deus sabe que o colégio Mirim foi um sonho realizado. Para muitos pode ser bobagem, besteira, mas para mim tem um significado muito grande e vendo que o Senhor não falha e ele não muda.',
		),
		array(
			'nome'   => 'Anna M.',
			'ordem'  => 2,
			'locais' => array( 'home', 'sobre', 'ensino-fundamental' ),
			'texto'  => 'Hoje moro em Balneário Camboriú e coloquei meu filho em um dos colégios onde me disseram ser da melhor rede de ensino e percebi o quanto a Mirim está à frente em relação ao app que usa, os profissionais que estão à frente da escola…',
		),
		array(
			'nome'   => 'Maria S.',
			'ordem'  => 3,
			'locais' => array( 'home', 'sobre', 'ensino-infantil', 'ensino-fundamental' ),
			'texto'  => 'A equipe do Colégio é incrível! Meu filho ama cada dia na escola.',
		),
		array(
			'nome'   => 'Aline S.',
			'ordem'  => 4,
			'locais' => array( 'home', 'sobre', 'ensino-fundamental' ),
			'texto'  => 'Escolher o Colégio Mirim foi uma das melhores decisões que tomamos. Desde o primeiro contato, sentimos o acolhimento, carinho e profissionalismo em cada detalhe. A equipe sempre é atenciosa, dedicada e realmente se preocupa com o bem-estar do aluno. É gratificante ver quanto meus filhos cresceram em um lugar que une educação de qualidade com valores humanos.',
		),
		array(
			'nome'   => 'Érica A.',
			'ordem'  => 5,
			'locais' => array( 'home', 'sobre', 'ensino-infantil' ),
			'texto'  => 'O Mirim vai além do só sentar e aprender, proporcionam diversas vivências que as crianças vão levar os aprendizados e as memórias ao longo da vida. Normalmente as crianças choram para ir pra escola, no Mirim é diferente, as crianças choram se ficarem sem ir pra escola.',
		),
	);
	foreach ( $itens as $item ) {
		$id = wp_insert_post(
			array(
				'post_type'    => 'depoimentos',
				'post_status'  => 'publish',
				'post_title'   => $item['nome'],
				'post_content' => $item['texto'],
				'menu_order'   => $item['ordem'],
			)
		);
		if ( $id && ! is_wp_error( $id ) ) {
			update_post_meta( $id, '_mirim_locais', $item['locais'] );
		}
	}
	update_option( 'colegiomirim_depoimentos_seed', 1 );
}
add_action( 'init', 'mirim_seed_depoimentos', 20 );

function mirim_seed_duvidas() {
	if ( get_option( 'colegiomirim_duvidas_seed' ) ) {
		return;
	}
	$existing = get_posts(
		array(
			'post_type'      => 'duvidas',
			'post_status'    => 'any',
			'posts_per_page' => 1,
			'fields'         => 'ids',
		)
	);
	if ( $existing ) {
		update_option( 'colegiomirim_duvidas_seed', 1 );
		return;
	}
	$itens = array(
		array(
			'ordem'    => 1,
			'pergunta' => 'Quais níveis de ensino o Colégio Mirim oferece e a partir de qual idade?',
			'resposta' => 'O Colégio Mirim oferece desde a Educação Infantil (a partir de 2 anos), passando pelo Ensino Fundamental I (1º ao 5º ano), até o Ensino Fundamental II (6º ao 9º ano). Nossa proposta é acompanhar o desenvolvimento do aluno em todas as fases, do G2 ao 9º ano, tecendo aprendizagens com amor e conhecimento.',
		),
		array(
			'ordem'    => 2,
			'pergunta' => 'Qual a metodologia de ensino adotada pela escola?',
			'resposta' => 'Adotamos uma proposta pedagógica onde a criança é protagonista e aprende em interação com o mundo e com o outro. Inspirados por Piaget, Vygotsky, Montessori e Reggio Emilia, nosso currículo é vivo e utiliza projetos, experiências, brincadeiras, investigação e criação para desenvolver competências cognitivas, emocionais, sociais e éticas. Promovemos a aprendizagem ativa, a resolução de problemas e a leitura do mundo em múltiplas linguagens.',
		),
		array(
			'ordem'    => 3,
			'pergunta' => 'Como posso matricular meu filho(a) e quais os documentos necessários?',
			'resposta' => 'As matrículas no Colégio Mirim podem ser iniciadas agendando uma visita para conhecer a escola ou pelo WhatsApp com atendimento imediato. Os documentos necessários são: Certidão de nascimento ou RG da criança; RG e CPF do responsável; Comprovante de residência; Atestado de transferência (para Ensino Fundamental); e Cartão do SUS ou plano de saúde da criança.',
		),
		array(
			'ordem'    => 4,
			'pergunta' => 'O Colégio Mirim oferece atividades extracurriculares ou aulas de idiomas?',
			'resposta' => 'Sim! Além do ensino bilíngue desde os 2 anos (Educação Infantil) até o 9º ano, oferecemos diversas atividades extracurriculares que ampliam repertórios e desenvolvem talentos, como Balé, Capoeira, Teatro e Projetos de cultura e bem-estar. Cada vivência é um convite à expressão, à imaginação e à convivência.',
		),
		array(
			'ordem'    => 5,
			'pergunta' => 'Como a escola garante a segurança e qual a infraestrutura disponível?',
			'resposta' => 'No Colégio Mirim, segurança é uma cultura. Garantimos a tranquilidade de nossos alunos com monitoramento por câmeras em toda a escola, equipe de segurança e portaria reforçada. Além disso, contamos com professores-auxiliares nas turmas da Educação Infantil e do Ciclo I do Fundamental, e cultivamos relações orientadas por respeito, afeto e escuta ativa, garantindo um ambiente acolhedor e de confiança. Nossa infraestrutura inclui salas de aula, quadras, pátio e refeitório, projetados para o bem-estar e o aprendizado.',
		),
	);
	foreach ( $itens as $item ) {
		wp_insert_post(
			array(
				'post_type'    => 'duvidas',
				'post_status'  => 'publish',
				'post_title'   => $item['pergunta'],
				'post_content' => $item['resposta'],
				'menu_order'   => $item['ordem'],
			)
		);
	}
	update_option( 'colegiomirim_duvidas_seed', 1 );
}
add_action( 'init', 'mirim_seed_duvidas', 20 );

function mirim_servico_url( $slug ) {
	return home_url( '/servico/' . trim( $slug, '/' ) . '/' );
}

function mirim_current( $slug ) {
	if ( 'home' === $slug ) {
		return is_front_page() ? ' aria-current="page"' : '';
	}
	$current = (string) get_post_field( 'post_name', get_queried_object_id() );
	if ( is_singular( 'servicos' ) && $current === $slug ) {
		return ' aria-current="page"';
	}
	return is_page( $slug ) ? ' aria-current="page"' : '';
}

function mirim_asset_version( $relative ) {
	$file = ABSPATH . ltrim( $relative, '/' );
	return file_exists( $file ) ? (string) filemtime( $file ) : '1';
}

function mirim_enqueue() {
	wp_enqueue_style(
		'mirim-fonts',
		'https://fonts.googleapis.com/css2?family=Fredoka:wght@400;500;600;700&family=Jost:wght@400;500;600&display=swap',
		array(),
		null
	);
	wp_enqueue_style(
		'mirim',
		home_url( '/assets/css/pda.css' ),
		array( 'mirim-fonts' ),
		mirim_asset_version( 'assets/css/pda.css' )
	);
	wp_enqueue_script(
		'mirim',
		home_url( '/assets/js/pda.js' ),
		array(),
		mirim_asset_version( 'assets/js/pda.js' ),
		true
	);

	wp_dequeue_style( 'wp-block-library' );
	wp_dequeue_style( 'wp-block-library-theme' );
	wp_dequeue_style( 'classic-theme-styles' );
	wp_dequeue_style( 'global-styles' );
	wp_deregister_script( 'jquery' );
}
add_action( 'wp_enqueue_scripts', 'mirim_enqueue', 100 );

function mirim_resource_hints( $urls, $relation ) {
	if ( 'preconnect' === $relation ) {
		$urls[] = array(
			'href' => 'https://fonts.googleapis.com',
		);
		$urls[] = array(
			'href'        => 'https://fonts.gstatic.com',
			'crossorigin' => 'anonymous',
		);
	}
	return $urls;
}
add_filter( 'wp_resource_hints', 'mirim_resource_hints', 10, 2 );

function mirim_description() {
	$descriptions = array(
		'home'               => 'Colégio Mirim - Matriculas Abertas. Educação de excelência há mais de 30 anos, do G2 ao 9º ano, em Salvador.',
		'sobre'              => 'Há trinta anos o Colégio Mirim conecta amor e conhecimento. Conheça nossa história, missão e visão.',
		'galeria'            => 'Galeria de fotos e projetos do Colégio Mirim.',
		'contato'            => 'Entre em contato com o Colégio Mirim. Telefone ' . mirim_geral()['telefone'] . '. ' . mirim_geral()['endereco'],
		'ensino-infantil'    => 'Ensino Infantil do Colégio Mirim, do G2 ao G5, a partir de 2 anos. Conheça a proposta, a metodologia e agende a matrícula.',
		'ensino-fundamental' => 'Ensino Fundamental do Colégio Mirim, do 1º ao 9º ano. Conheça a proposta, a metodologia e agende a matrícula.',
	);
	$key = is_front_page() ? 'home' : (string) get_post_field( 'post_name', get_queried_object_id() );
	if ( isset( $descriptions[ $key ] ) ) {
		echo '<meta name="description" content="' . esc_attr( $descriptions[ $key ] ) . '">' . "\n";
	}
	echo '<link rel="icon" href="' . esc_url( home_url( '/assets/images/favicon.ico' ) ) . '">' . "\n";
}
add_action( 'wp_head', 'mirim_description', 1 );

function mirim_document_title( $parts ) {
	if ( is_front_page() ) {
		$parts['title'] = 'Colégio Mirim - Matrículas Abertas';
		unset( $parts['tagline'], $parts['site'] );
	}
	return $parts;
}
add_filter( 'document_title_parts', 'mirim_document_title' );

function mirim_cleanup() {
	remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
	remove_action( 'wp_print_styles', 'print_emoji_styles' );
	remove_action( 'wp_head', 'wp_generator' );
	remove_action( 'wp_head', 'rsd_link' );
	remove_action( 'wp_head', 'wlwmanifest_link' );
	remove_action( 'wp_head', 'wp_shortlink_wp_head' );
	remove_action( 'wp_head', 'wp_oembed_add_discovery_links' );
	remove_action( 'wp_head', 'rest_output_link_wp_head' );
	remove_action( 'wp_head', 'feed_links', 2 );
	remove_action( 'wp_head', 'feed_links_extra', 3 );
	add_filter( 'emoji_svg_url', '__return_false' );
	add_filter( 'comments_open', '__return_false', 20, 2 );
	add_filter( 'pings_open', '__return_false', 20, 2 );
}
add_action( 'init', 'mirim_cleanup' );
