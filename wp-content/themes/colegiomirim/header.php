<?php
$mirim_geral = mirim_geral();
if ( is_page( 'contato' ) ) {
	$mirim_cta     = $mirim_geral['cta_contato'];
	$mirim_cta_url = mirim_wa( 'visita' );
} elseif ( is_front_page() ) {
	$mirim_cta     = $mirim_geral['cta_home'];
	$mirim_cta_url = mirim_wa( 'visita' );
} else {
	$mirim_cta     = $mirim_geral['cta_matricula'];
	$mirim_cta_url = mirim_wa( 'matricula' );
}
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<header class="site-header">
	<div class="topbar">
		<div class="container topbar-inner">
			<strong class="topbar-tag"><?php echo esc_html( $mirim_geral['faixa'] ); ?></strong>
			<ul class="topbar-contacts">
				<li>
					<svg viewBox="0 0 24 24" width="16" height="16" aria-hidden="true" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 6h16v12H4z"/><path d="M4 7l8 6 8-6"/></svg>
					Email: <a href="mailto:<?php echo esc_attr( $mirim_geral['email'] ); ?>"><?php echo esc_html( $mirim_geral['email'] ); ?></a>
				</li>
				<li>
					<svg viewBox="0 0 24 24" width="16" height="16" aria-hidden="true" fill="currentColor"><path d="M6.6 10.8a15 15 0 006.6 6.6l2.2-2.2a1 1 0 011-.25 11 11 0 003.6.57 1 1 0 011 1V20a1 1 0 01-1 1A17 17 0 013 7a1 1 0 011-1h3.5a1 1 0 011 1 11 11 0 00.57 3.6 1 1 0 01-.25 1L6.6 10.8z"/></svg>
					Telefone: <a href="<?php echo esc_url( mirim_tel() ); ?>"><?php echo esc_html( $mirim_geral['telefone'] ); ?></a>
				</li>
			</ul>
		</div>
	</div>
	<div class="navbar">
		<div class="container nav-inner">
			<a class="logo" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php echo mirim_logo(); ?></a>
			<nav aria-label="Principal">
				<ul class="menu">
					<li><a href="<?php echo esc_url( home_url( '/' ) ); ?>"<?php echo mirim_current( 'home' ); ?>>Home</a></li>
					<li><a href="<?php echo esc_url( home_url( '/sobre/' ) ); ?>"<?php echo mirim_current( 'sobre' ); ?>>Sobre Nós</a></li>
					<li class="has-sub">
						<button class="menu-parent" type="button" aria-haspopup="true" aria-expanded="false">Serviços</button>
						<ul class="submenu">
							<li><a href="<?php echo esc_url( mirim_servico_url( 'ensino-infantil' ) ); ?>"<?php echo mirim_current( 'ensino-infantil' ); ?>>Ensino Infantil</a></li>
							<li><a href="<?php echo esc_url( mirim_servico_url( 'ensino-fundamental' ) ); ?>"<?php echo mirim_current( 'ensino-fundamental' ); ?>>Ensino Fundamental</a></li>
						</ul>
					</li>
					<li><a href="<?php echo esc_url( home_url( '/galeria/' ) ); ?>"<?php echo mirim_current( 'galeria' ); ?>>Galeria</a></li>
					<li><a href="<?php echo esc_url( home_url( '/contato/' ) ); ?>"<?php echo mirim_current( 'contato' ); ?>>Contato</a></li>
				</ul>
			</nav>
			<div class="nav-actions">
				<a class="btn nav-cta" href="<?php echo esc_url( $mirim_cta_url ); ?>" target="_blank" rel="noopener"><?php echo esc_html( $mirim_cta ); ?></a>
				<button class="burger" type="button" data-open-mobile aria-label="Abrir menu">
					<svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 7h16M4 12h16M4 17h16"/></svg>
				</button>
			</div>
		</div>
	</div>
</header>
