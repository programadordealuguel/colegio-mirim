<?php $mirim_geral = mirim_geral(); ?>
<footer class="site-footer">
	<div class="container footer-grid">
		<div>
			<h3><?php echo esc_html( $mirim_geral['rodape_titulo'] ); ?></h3>
			<p><?php echo esc_html( $mirim_geral['endereco'] ); ?></p>
			<a class="btn" href="<?php echo esc_url( mirim_wa( 'visita' ) ); ?>" target="_blank" rel="noopener"><?php echo esc_html( $mirim_geral['rodape_botao'] ); ?></a>
		</div>
		<div class="footer-contact">
			<h3>Entre em Contato</h3>
			<p>Email: <a href="mailto:<?php echo esc_attr( $mirim_geral['email'] ); ?>"><?php echo esc_html( $mirim_geral['email'] ); ?></a></p>
			<p>Telefone: <a href="<?php echo esc_url( mirim_tel() ); ?>"><?php echo esc_html( $mirim_geral['telefone'] ); ?></a></p>
		</div>
		<div>
			<h3>Navegação</h3>
			<ul class="footer-menu">
				<li><a href="<?php echo esc_url( home_url( '/' ) ); ?>">Home</a></li>
				<li><a href="<?php echo esc_url( home_url( '/sobre/' ) ); ?>">Sobre Nós</a></li>
				<li><a href="<?php echo esc_url( home_url( '/galeria/' ) ); ?>">Galeria</a></li>
				<li><a href="<?php echo esc_url( mirim_servico_url( 'ensino-infantil' ) ); ?>">Ensino Infantil</a></li>
				<li><a href="<?php echo esc_url( mirim_servico_url( 'ensino-fundamental' ) ); ?>">Ensino Fundamental</a></li>
				<li><a href="<?php echo esc_url( home_url( '/contato/' ) ); ?>">Contato</a></li>
			</ul>
		</div>
	</div>
	<div class="footer-bottom">
		<div class="container footer-bottom-inner">
			<p class="copyright"><?php echo esc_html( $mirim_geral['copyright'] ); ?></p>
			<div class="socials">
				<?php if ( $mirim_geral['facebook'] ) { ?><a href="<?php echo esc_url( $mirim_geral['facebook'] ); ?>" target="_blank" rel="noopener" aria-label="Facebook"><img src="<?php echo esc_url( home_url( '/assets/images/facebook.svg' ) ); ?>" alt="" width="18" height="18"></a><?php } ?>
				<?php if ( $mirim_geral['instagram'] ) { ?><a href="<?php echo esc_url( $mirim_geral['instagram'] ); ?>" target="_blank" rel="noopener" aria-label="Instagram"><img src="<?php echo esc_url( home_url( '/assets/images/instagram.svg' ) ); ?>" alt="" width="18" height="18"></a><?php } ?>
				<?php if ( $mirim_geral['whatsapp'] ) { ?><a href="<?php echo esc_url( mirim_wa( 'rede' ) ); ?>" target="_blank" rel="noopener" aria-label="WhatsApp"><img src="<?php echo esc_url( home_url( '/assets/images/whatsapp.svg' ) ); ?>" alt="" width="18" height="18"></a><?php } ?>
				<?php if ( $mirim_geral['youtube'] ) { ?><a href="<?php echo esc_url( $mirim_geral['youtube'] ); ?>" target="_blank" rel="noopener" aria-label="YouTube"><img src="<?php echo esc_url( home_url( '/assets/images/youtube.svg' ) ); ?>" alt="" width="18" height="18"></a><?php } ?>
			</div>
		</div>
	</div>
</footer>

<a class="wa-float" href="<?php echo esc_url( mirim_wa( 'info' ) ); ?>" target="_blank" rel="noopener" aria-label="WhatsApp">
	<img src="<?php echo esc_url( home_url( '/assets/images/whatsapp.svg' ) ); ?>" alt="" width="30" height="30">
</a>
<button class="to-top" type="button" aria-label="Voltar ao topo">
	<svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 14l6-6 6 6"/></svg>
</button>

<div class="mobile-nav" data-mobile>
	<div class="backdrop" data-close></div>
	<nav class="mobile-nav-panel" aria-label="Menu móvel">
		<button class="burger" type="button" data-close aria-label="Fechar menu">×</button>
		<a href="<?php echo esc_url( home_url( '/' ) ); ?>"<?php echo mirim_current( 'home' ); ?>>Home</a>
		<a href="<?php echo esc_url( home_url( '/sobre/' ) ); ?>"<?php echo mirim_current( 'sobre' ); ?>>Sobre Nós</a>
		<span class="mobile-label">Serviços</span>
		<a class="mobile-sub" href="<?php echo esc_url( mirim_servico_url( 'ensino-infantil' ) ); ?>"<?php echo mirim_current( 'ensino-infantil' ); ?>>Ensino Infantil</a>
		<a class="mobile-sub" href="<?php echo esc_url( mirim_servico_url( 'ensino-fundamental' ) ); ?>"<?php echo mirim_current( 'ensino-fundamental' ); ?>>Ensino Fundamental</a>
		<a href="<?php echo esc_url( home_url( '/galeria/' ) ); ?>"<?php echo mirim_current( 'galeria' ); ?>>Galeria</a>
		<a href="<?php echo esc_url( home_url( '/contato/' ) ); ?>"<?php echo mirim_current( 'contato' ); ?>>Contato</a>
	</nav>
</div>

<div class="lightbox" data-lightbox-root>
	<div class="backdrop" data-close></div>
	<button class="lightbox-close" type="button" data-close aria-label="Fechar imagem">×</button>
	<figure class="lightbox-figure"><img alt=""></figure>
</div>
<?php wp_footer(); ?>
</body>
</html>
