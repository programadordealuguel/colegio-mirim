<?php
get_header();
$galeria    = mirim_galeria();
$capa       = $galeria['capa'];
$hero       = mirim_image_url( $capa['imagem'], $capa['arquivo'] );
$projetos   = $galeria['projetos']['fotos'];
$atividades = $galeria['atividades'];
$momentos   = $galeria['momentos'];
$slides     = array();
foreach ( $momentos['fotos'] as $foto ) {
	$url = mirim_image_url( $foto['imagem'] ?? 0, $foto['arquivo'] ?? '' );
	if ( $url ) {
		$slides[] = array(
			'url' => $url,
			'alt' => $foto['alt'] ?? '',
		);
	}
}
?>
<section class="page-hero" style="background-image: linear-gradient(rgba(255,255,255,.45), rgba(255,255,255,.45)), url('<?php echo esc_url( $hero ); ?>');">
    <div class="container">
      <h1><?php echo esc_html( $capa['titulo'] ); ?></h1>
      <p><?php echo mirim_text( $capa['texto'] ); ?></p>
      <ul class="crumbs">
        <li><a href="<?php echo esc_url( home_url( '/' ) ); ?>">Home</a></li>
        <li><?php echo esc_html( $capa['titulo'] ); ?></li>
      </ul>
    </div>
  </section>

  <?php if ( $projetos ) { ?>
  <section class="section">
    <div class="container photo-grid cols-3">
      <?php foreach ( $projetos as $foto ) { echo mirim_shot( $foto ); } ?>
    </div>
  </section>
  <?php } ?>

  <section class="section-sm">
    <div class="container-wide">
      <div class="center">
        <div class="bubbles" aria-hidden="true"><span></span><span></span><span></span></div>
        <h2 class="sec-title"><?php echo esc_html( $atividades['titulo'] ); ?></h2>
        <p class="sec-text"><?php echo mirim_text( $atividades['texto'] ); ?></p>
      </div>
      <?php if ( $atividades['fotos'] ) { ?>
      <div class="activities-row" style="margin-top: 32px;">
        <?php foreach ( $atividades['fotos'] as $foto ) { echo mirim_shot( $foto ); } ?>
      </div>
      <?php } ?>
    </div>
  </section>

  <section class="section-sm">
    <div class="container">
      <div class="center">
        <div class="bubbles" aria-hidden="true"><span></span><span></span><span></span></div>
        <h2 class="sec-title"><?php echo esc_html( $momentos['titulo'] ); ?></h2>
        <p class="sec-text"><?php echo mirim_text( $momentos['texto'] ); ?></p>
      </div>
      <?php if ( $slides ) { ?>
      <div class="slider is-fade momento" id="momentos" data-slider data-fade data-lg="1" data-md="1" data-xs="1" style="margin-top: 28px;">
        <div class="slider-viewport">
          <div class="slider-track">
            <?php foreach ( $slides as $index => $foto ) { ?>
            <div class="slide<?php echo 0 === $index ? ' is-on' : ''; ?>"><a class="shot" href="<?php echo esc_url( $foto['url'] ); ?>" data-lightbox><img loading="lazy" decoding="async" src="<?php echo esc_url( $foto['url'] ); ?>" alt="<?php echo esc_attr( $foto['alt'] ); ?>"><span class="shot-zoom">+</span></a></div>
            <?php } ?>
          </div>
        </div>
      </div>
      <div class="thumbs" data-thumbs="#momentos">
        <?php foreach ( $slides as $index => $foto ) { ?>
        <button type="button"<?php echo 0 === $index ? ' class="is-on"' : ''; ?>><img loading="lazy" decoding="async" src="<?php echo esc_url( $foto['url'] ); ?>" alt=""></button>
        <?php } ?>
      </div>
      <?php } ?>
    </div>
  </section>

  <?php mirim_instagram_cta(); ?>
<?php
get_footer();
