<?php
get_header();
if ( have_posts() ) {
	the_post();
}
$sobre    = mirim_sobre();
$capa     = $sobre['capa'];
$hero     = mirim_image_url( $capa['imagem'], $capa['arquivo'] );
$historia = $sobre['historia'];
$missao   = $sobre['missao'];
$faixa    = $sobre['faixa'];
$ativ     = $sobre['atividades'];
$visao    = $sobre['visao'];
$galeria  = $sobre['galeria'];
$familias = $sobre['familias'];
$meio     = (int) ceil( count( $ativ['itens'] ) / 2 );
?>
<section class="page-hero" style="background-image: linear-gradient(rgba(255,255,255,.45), rgba(255,255,255,.45)), url('<?php echo esc_url( $hero ); ?>');">
    <div class="container">
      <h1><?php the_title(); ?></h1>
      <p><?php echo esc_html( $capa['subtitulo'] ); ?></p>
      <ul class="crumbs">
        <li><a href="<?php echo esc_url( home_url( '/' ) ); ?>">Início</a></li>
        <li><?php the_title(); ?></li>
      </ul>
    </div>
  </section>

  <section class="section">
    <div class="container">
      <h2 class="sec-title center"><?php echo esc_html( $historia['titulo'] ); ?></h2>
      <div class="story">
        <?php echo mirim_img( $historia ); ?>
        <div class="entry">
          <?php the_content(); ?>
        </div>
      </div>
    </div>
  </section>

  <section class="section-sm">
    <div class="container mission">
      <?php echo mirim_img( $missao ); ?>
      <div>
        <h2 class="sec-title"><?php echo esc_html( $missao['titulo'] ); ?></h2>
        <p class="sec-text"><?php echo mirim_text( $missao['texto'] ); ?></p>
      </div>
    </div>
  </section>

  <section class="section">
    <div class="container">
      <div class="enroll-banner">
        <div>
          <span class="sec-kicker"><?php echo esc_html( $faixa['kicker'] ); ?></span>
          <h2 class="sec-title"><?php echo esc_html( $faixa['titulo'] ); ?></h2>
        </div>
        <a class="btn" href="<?php echo esc_url( mirim_wa( 'matricula' ) ); ?>" target="_blank" rel="noopener"><?php echo esc_html( mirim_geral()['cta_matricula'] ); ?></a>
      </div>
    </div>
  </section>

  <section class="section-sm">
    <div class="container">
      <div class="center">
        <div class="bubbles" aria-hidden="true"><span></span><span></span><span></span></div>
        <h2 class="sec-title"><?php echo esc_html( $ativ['titulo'] ); ?></h2>
        <p class="sec-text"><?php echo mirim_text( $ativ['texto'] ); ?></p>
      </div>
      <div class="features" style="margin-top: 40px;">
        <div>
          <?php foreach ( array_slice( $ativ['itens'], 0, $meio ) as $item ) { mirim_sobre_feature( $item ); } ?>
        </div>
        <?php echo mirim_img( $ativ, $ativ['alt'], array( 'class' => 'features-photo' ) ); ?>
        <div>
          <?php foreach ( array_slice( $ativ['itens'], $meio ) as $item ) { mirim_sobre_feature( $item ); } ?>
        </div>
      </div>
    </div>
  </section>

  <section class="vision section">
    <div class="container">
      <span class="sec-kicker"><?php echo esc_html( $visao['kicker'] ); ?></span>
      <h2 class="sec-title"><?php echo esc_html( $visao['titulo'] ); ?></h2>
      <p class="sec-text"><?php echo mirim_text( $visao['texto'] ); ?></p>
      <div class="vision-grid">
        <?php foreach ( $visao['itens'] as $item ) { ?>
        <article class="vision-card">
          <?php echo mirim_img( $item, $item['titulo'] ); ?>
          <div>
            <h3><?php echo esc_html( $item['titulo'] ); ?></h3>
            <p><?php echo mirim_text( $item['texto'] ); ?></p>
          </div>
        </article>
        <?php } ?>
      </div>
    </div>
  </section>

  <section class="section">
    <div class="container">
      <div class="center">
        <div class="bubbles" aria-hidden="true"><span></span><span></span><span></span></div>
        <h2 class="sec-title"><?php echo esc_html( $galeria['titulo'] ); ?></h2>
        <p class="sec-text"><?php echo mirim_text( $galeria['texto'] ); ?></p>
      </div>
      <div class="photo-grid" style="margin-top: 32px;">
        <?php foreach ( $galeria['fotos'] as $foto ) { echo mirim_shot( $foto ); } ?>
      </div>
    </div>
  </section>

  <section class="section-sm">
    <div class="container">
      <div class="slider" data-slider data-lg="2" data-md="1" data-xs="1">
        <div class="slider-head">
          <h2 class="sec-title"><?php echo esc_html( $familias['titulo'] ); ?></h2>
          <div class="slider-nav">
            <button class="round-btn" type="button" data-prev aria-label="Depoimento anterior">
              <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2"><path d="M15 6l-6 6 6 6"/></svg>
            </button>
            <button class="round-btn" type="button" data-next aria-label="Próximo depoimento">
              <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 6l6 6-6 6"/></svg>
            </button>
          </div>
        </div>
        <div class="slider-viewport">
          <div class="slider-track">
            <?php foreach ( mirim_depoimentos( 'sobre' ) as $depoimento ) { ?>
            <article class="slide"><div class="info-card" style="text-align:left;"><p><?php echo mirim_text( $depoimento->post_content ); ?></p><h3><?php echo esc_html( $depoimento->post_title ); ?></h3><div class="stars">★★★★★</div></div></article>
            <?php } ?>
          </div>
        </div>
      </div>
    </div>
  </section>

  <?php mirim_instagram_cta(); ?>
<?php
get_footer();

function mirim_sobre_feature( $item ) {
	if ( '' === trim( $item['titulo'] ) && '' === trim( $item['itens'] ) ) {
		return;
	}
	echo '<article class="feature">';
	echo mirim_img( $item, $item['titulo'] );
	echo '<h3>' . esc_html( $item['titulo'] ) . '</h3><ul class="checks">';
	foreach ( mirim_lines( $item['itens'] ) as $linha ) {
		echo '<li>' . esc_html( $linha ) . '</li>';
	}
	echo '</ul></article>';
}
