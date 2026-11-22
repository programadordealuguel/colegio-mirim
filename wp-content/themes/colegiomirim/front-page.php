<?php
get_header();
$visita = mirim_wa( 'visita' );

if ( mirim_show( 'banner' ) ) {
	$banner = mirim_home( 'banner' );
	$url    = mirim_image_url( $banner['imagem'], $banner['arquivo'] );
	$style  = $url ? ' style="background-image:url(' . esc_url( $url ) . ')"' : '';
	echo '<section class="hero" data-reveal="fade" aria-label="Destaque do Colégio Mirim"' . $style . '></section>';
}

if ( mirim_show( 'hashtag' ) ) {
	$hashtag = mirim_home( 'hashtag' );
	if ( '' !== trim( $hashtag['texto'] ) ) {
		echo '<section class="hashtag"><div class="container"><h2 data-reveal="zoom">' . esc_html( $hashtag['texto'] ) . '</h2></div></section>';
	}
}

if ( mirim_show( 'apresentacao' ) ) {
	$bloco = mirim_home( 'apresentacao' );
	?>
	<section class="section">
		<div class="container split">
			<div class="mosaic" data-reveal="left">
				<?php foreach ( $bloco['fotos'] as $foto ) { echo mirim_img( $foto ); } ?>
			</div>
			<div data-reveal="right">
				<?php if ( '' !== trim( $bloco['kicker'] ) ) { echo '<span class="sec-kicker">' . esc_html( $bloco['kicker'] ) . '</span>'; } ?>
				<h2 class="sec-title"><?php echo esc_html( $bloco['titulo'] ); ?></h2>
				<p class="sec-text"><?php echo mirim_text( $bloco['texto'] ); ?></p>
			</div>
		</div>
	</section>
	<?php
}

if ( mirim_show( 'valores' ) ) {
	$bloco = mirim_home( 'valores' );
	?>
	<section class="section-sm">
		<div class="container">
			<div class="center" data-reveal>
				<div class="bubbles" aria-hidden="true"><span></span><span></span><span></span></div>
				<h2 class="sec-title"><?php echo esc_html( $bloco['titulo'] ); ?></h2>
				<p class="sec-text"><?php echo mirim_text( $bloco['texto'] ); ?></p>
			</div>
			<div class="values" style="margin-top: 36px;">
				<?php
				$ordem = 0;
				foreach ( $bloco['itens'] as $item ) {
					if ( '' === trim( $item['titulo'] ) && '' === trim( $item['texto'] ) ) {
						continue;
					}
					?>
					<article class="value-card" data-reveal style="--d:<?php echo esc_attr( (string) $ordem ); ?>">
						<div class="value-icon"><?php echo mirim_img( $item ); ?></div>
						<h3><?php echo esc_html( $item['titulo'] ); ?></h3>
						<p><?php echo mirim_text( $item['texto'] ); ?></p>
					</article>
					<?php
					$ordem++;
				}
				?>
			</div>
		</div>
	</section>
	<?php
}
?>
<?php if ( mirim_show( 'metodologia' ) || mirim_show( 'series' ) ) { ?>
<div class="pattern">
	<?php if ( mirim_show( 'metodologia' ) ) { $bloco = mirim_home( 'metodologia' ); ?>
	<section class="section">
		<div class="container split reverse">
			<div data-reveal="left">
				<h2 class="sec-title"><a href="<?php echo esc_url( mirim_path_url( $bloco['link'] ) ); ?>"><?php echo esc_html( $bloco['titulo'] ); ?></a></h2>
				<p class="sec-text"><?php echo mirim_text( $bloco['texto'] ); ?></p>
				<ul class="checks">
					<?php foreach ( mirim_lines( $bloco['itens'] ) as $linha ) { echo '<li>' . esc_html( $linha ) . '</li>'; } ?>
				</ul>
			</div>
			<div class="frame" data-reveal="right"><?php echo mirim_img( $bloco ); ?></div>
		</div>
	</section>
	<?php } ?>

	<?php if ( mirim_show( 'series' ) ) { $bloco = mirim_home( 'series' ); ?>
	<section class="section-sm">
		<div class="container">
			<div class="slider grade-slider" data-slider data-lg="4" data-md="2" data-xs="1" data-reveal>
				<div class="slider-head">
					<span class="sec-kicker"><?php echo esc_html( $bloco['kicker'] ); ?></span>
					<div class="slider-nav">
						<button class="round-btn" type="button" data-prev aria-label="Séries anteriores">
							<svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2"><path d="M15 6l-6 6 6 6"/></svg>
						</button>
						<button class="round-btn" type="button" data-next aria-label="Próximas séries">
							<svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 6l6 6-6 6"/></svg>
						</button>
					</div>
				</div>
				<div class="slider-viewport">
					<div class="slider-track">
						<?php
						foreach ( $bloco['itens'] as $item ) {
							if ( '' === trim( $item['titulo'] ) && '' === trim( $item['selo'] ) ) {
								continue;
							}
							?>
							<div class="slide"><a class="grade" href="<?php echo esc_url( mirim_servico_url( $item['destino'] ) ); ?>"><div class="grade-badge"><?php echo esc_html( $item['selo'] ); ?></div><h3><?php echo esc_html( $item['titulo'] ); ?></h3><p><?php echo esc_html( $item['subtitulo'] ); ?></p></a></div>
							<?php
						}
						?>
					</div>
				</div>
			</div>
		</div>
	</section>
	<?php } ?>
</div>
<?php } ?>

<?php if ( mirim_show( 'matricula' ) ) { $bloco = mirim_home( 'matricula' ); ?>
<section class="band">
	<div class="container">
		<div class="enroll" data-reveal="zoom">
			<div class="enroll-icon" aria-hidden="true">
				<svg viewBox="0 0 24 24" width="32" height="32" fill="none" stroke="currentColor" stroke-width="2"><rect x="4" y="5" width="16" height="15" rx="2"/><path d="M8 3v4M16 3v4M4 10h16"/></svg>
			</div>
			<h2 class="sec-title"><?php echo esc_html( $bloco['titulo'] ); ?></h2>
			<p class="sec-text"><?php echo mirim_text( $bloco['texto'] ); ?></p>
			<a class="enroll-cta" href="<?php echo esc_url( $visita ); ?>" target="_blank" rel="noopener"><?php echo mirim_wa_icon(); ?><?php echo esc_html( $bloco['botao'] ); ?></a>
		</div>
	</div>
</section>
<?php } ?>

<?php if ( mirim_show( 'atividades' ) ) { $bloco = mirim_home( 'atividades' ); ?>
<section class="section">
	<div class="container">
		<div class="center" data-reveal>
			<div class="bubbles" aria-hidden="true"><span></span><span></span><span></span></div>
			<h2 class="sec-title"><?php echo esc_html( $bloco['titulo'] ); ?></h2>
			<p class="sec-text"><?php echo mirim_text( $bloco['texto'] ); ?></p>
		</div>
		<div class="activity-grid" style="margin-top: 36px;">
			<?php
			$ordem = 0;
			foreach ( $bloco['itens'] as $item ) {
				if ( '' === trim( $item['titulo'] ) ) {
					continue;
				}
				?>
				<article class="card-photo" data-reveal style="--d:<?php echo esc_attr( (string) $ordem ); ?>">
					<?php echo mirim_img( $item, $item['titulo'] ); ?>
					<h3><?php echo esc_html( $item['titulo'] ); ?></h3>
				</article>
				<?php
				$ordem++;
			}
			?>
		</div>
	</div>
</section>
<?php } ?>

<?php if ( mirim_show( 'duvidas' ) ) { $bloco = mirim_home( 'duvidas' ); ?>
<section class="section-sm">
	<div class="container faq-layout">
		<div data-reveal="left">
			<span class="sec-kicker"><?php echo esc_html( $bloco['kicker'] ); ?></span>
			<h2 class="sec-title"><?php echo esc_html( $bloco['titulo'] ); ?></h2>
			<div class="faq">
				<?php
				$aberto = true;
				foreach ( mirim_duvidas() as $duvida ) {
					if ( '' === trim( $duvida->post_title ) ) {
						continue;
					}
					?>
					<article class="faq-item<?php echo $aberto ? ' is-open' : ''; ?>">
						<h3><button type="button" aria-expanded="<?php echo $aberto ? 'true' : 'false'; ?>"><?php echo esc_html( $duvida->post_title ); ?> <span aria-hidden="true"></span></button></h3>
						<div class="faq-panel"><p><?php echo mirim_text( $duvida->post_content ); ?></p></div>
					</article>
					<?php
					$aberto = false;
				}
				?>
			</div>
		</div>
		<div class="portrait" data-reveal="right"><?php echo mirim_img( $bloco ); ?></div>
	</div>
</section>
<?php } ?>

<?php if ( mirim_show( 'depoimentos' ) ) { $bloco = mirim_home( 'depoimentos' ); ?>
<section class="reviews section">
	<div class="container review-layout">
		<?php echo mirim_img( $bloco, '', array( 'data-reveal' => 'left' ) ); ?>
		<div data-reveal="right">
			<h2 class="sec-title center"><?php echo esc_html( $bloco['titulo'] ); ?></h2>
			<div class="slider is-fade" data-slider data-fade data-autoplay="7000" data-lg="1" data-md="1" data-xs="1">
				<div class="slider-viewport">
					<div class="slider-track">
						<?php
						$ativo = true;
						foreach ( mirim_depoimentos( 'home' ) as $depoimento ) {
							if ( '' === trim( $depoimento->post_title ) && '' === trim( $depoimento->post_content ) ) {
								continue;
							}
							?>
							<article class="slide quote<?php echo $ativo ? ' is-on' : ''; ?>">
								<div class="quote-mark" aria-hidden="true">“</div>
								<h3><?php echo esc_html( $depoimento->post_title ); ?></h3>
								<div class="stars" aria-label="5 estrelas">★★★★★</div>
								<p><?php echo mirim_text( $depoimento->post_content ); ?></p>
							</article>
							<?php
							$ativo = false;
						}
						?>
					</div>
				</div>
				<div class="dots"></div>
			</div>
		</div>
	</div>
</section>
<?php } ?>

<?php
if ( mirim_show( 'localizacao' ) ) {
	$bloco = mirim_home( 'localizacao' );
	$mapa  = mirim_geral()['mapa'];
	?>
	<section class="section" style="background:#f8f9fa;">
		<div class="container">
			<div class="center" data-reveal>
				<h2 class="sec-title"><?php echo esc_html( $bloco['titulo'] ); ?></h2>
				<p class="sec-text"><?php echo mirim_text( $bloco['texto'] ); ?></p>
			</div>
			<?php if ( $mapa ) { ?>
			<div class="map-frame" data-reveal style="margin-top: 28px; --d:1">
				<iframe src="<?php echo esc_url( $mapa ); ?>" title="Mapa do Colégio Mirim" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
			</div>
			<?php } ?>
		</div>
	</section>
	<?php
}
get_footer();
