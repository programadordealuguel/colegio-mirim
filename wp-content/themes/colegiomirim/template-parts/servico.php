<?php
get_header();
if ( have_posts() ) {
	the_post();
}
$post_id = get_the_ID();
$slug    = (string) get_post_field( 'post_name', $post_id );
$dados   = mirim_servico( $post_id );
$capa    = $dados['capa'];
$bloco   = $dados['apresentacao'];
$metodo  = $dados['metodologia'];
$fotos   = $dados['fotos'];
$familias = $dados['familias'];
$faixa   = $dados['faixa'];
$matricula = $dados['matricula'];
$hero    = mirim_image_url( $capa['imagem'], $capa['arquivo'] );
$lugar   = in_array( $slug, array( 'ensino-infantil', 'ensino-fundamental' ), true ) ? $slug : '';
$infantil = get_page_by_path( 'ensino-infantil', OBJECT, 'servicos' );
$fundamental = get_page_by_path( 'ensino-fundamental', OBJECT, 'servicos' );
?>
<?php if ( empty( $capa['ocultar'] ) ) { ?>
<section class="page-hero" style="background-image: linear-gradient(rgba(255,255,255,.45), rgba(255,255,255,.45)), url('<?php echo esc_url( $hero ); ?>');">
    <div class="container">
      <h1><?php the_title(); ?></h1>
      <p><?php echo esc_html( $capa['texto'] ); ?></p>
      <ul class="crumbs">
        <li><a href="<?php echo esc_url( home_url( '/' ) ); ?>">Início</a></li>
        <li><?php the_title(); ?></li>
      </ul>
      <nav class="segment-switch" aria-label="Segmentos">
        <a href="<?php echo esc_url( mirim_servico_url( 'ensino-infantil' ) ); ?>"<?php echo 'ensino-infantil' === $slug ? ' aria-current="page"' : ''; ?>><?php echo esc_html( $infantil instanceof WP_Post ? $infantil->post_title : 'Ensino Infantil' ); ?></a>
        <a href="<?php echo esc_url( mirim_servico_url( 'ensino-fundamental' ) ); ?>"<?php echo 'ensino-fundamental' === $slug ? ' aria-current="page"' : ''; ?>><?php echo esc_html( $fundamental instanceof WP_Post ? $fundamental->post_title : 'Ensino Fundamental' ); ?></a>
      </nav>
    </div>
  </section>
<?php } ?>

  <?php if ( empty( $bloco['ocultar'] ) ) { ?>
  <section class="section">
    <div class="container story">
      <?php echo mirim_img( $bloco, $bloco['alt'] ); ?>
      <div>
        <span class="sec-kicker"><?php echo esc_html( $bloco['kicker'] ); ?></span>
        <h2 class="sec-title"><?php echo esc_html( $bloco['titulo'] ); ?></h2>
        <div class="entry">
          <?php the_content(); ?>
        </div>
        <?php if ( $bloco['etapas'] ) { ?>
        <ul class="stage-row">
          <?php foreach ( $bloco['etapas'] as $etapa ) { ?>
          <li><span><?php echo esc_html( $etapa['selo'] ); ?></span> <?php echo esc_html( $etapa['linha'] ); ?></li>
          <?php } ?>
        </ul>
        <?php } ?>
        <div class="segment-actions">
          <a class="btn" href="<?php echo esc_url( mirim_wa( mirim_servico_mensagem( $slug ) ) ); ?>" target="_blank" rel="noopener"><?php echo esc_html( $bloco['botao'] ); ?></a>
          <a class="btn nav-cta" href="<?php echo esc_url( mirim_wa( mirim_servico_mensagem( $slug, true ) ) ); ?>" target="_blank" rel="noopener"><?php echo esc_html( $bloco['botao_visita'] ); ?></a>
        </div>
      </div>
    </div>
  </section>
  <?php } ?>

  <?php if ( empty( $metodo['ocultar'] ) ) { ?>
  <section class="section-sm" style="background: var(--smoke);">
    <div class="container">
      <div class="center">
        <span class="sec-kicker"><?php echo esc_html( $metodo['kicker'] ); ?></span>
        <h2 class="sec-title"><?php echo esc_html( $metodo['titulo'] ); ?></h2>
        <p class="sec-text"><?php echo mirim_text( $metodo['texto'] ); ?></p>
      </div>
      <div class="method-grid">
        <?php
        $numero = 1;
        foreach ( $metodo['itens'] as $item ) {
        	?>
        <article class="method-card">
          <span><?php echo esc_html( (string) $numero ); ?></span>
          <h3><?php echo esc_html( $item['titulo'] ); ?></h3>
          <p><?php echo mirim_text( $item['texto'] ); ?></p>
        </article>
        	<?php
        	$numero++;
        }
        ?>
      </div>
    </div>
  </section>
  <?php } ?>

  <?php if ( empty( $fotos['ocultar'] ) ) { ?>
  <section class="section">
    <div class="container">
      <div class="center">
        <span class="sec-kicker"><?php echo esc_html( $fotos['kicker'] ); ?></span>
        <h2 class="sec-title"><?php echo esc_html( $fotos['titulo'] ); ?></h2>
      </div>
      <div class="photo-grid cols-3" style="margin-top: 28px;">
        <?php foreach ( $fotos['fotos'] as $foto ) { echo mirim_shot( $foto ); } ?>
      </div>
    </div>
  </section>
  <?php } ?>

  <?php if ( $lugar && empty( $familias['ocultar'] ) ) { ?>
  <section class="reviews section">
    <div class="container">
      <div class="center">
        <span class="sec-kicker"><?php echo esc_html( $familias['kicker'] ); ?></span>
        <h2 class="sec-title"><?php echo esc_html( $familias['titulo'] ); ?></h2>
      </div>
      <div class="quote-grid">
        <?php foreach ( mirim_depoimentos( $lugar ) as $depoimento ) { ?>
        <article class="quote">
          <div class="quote-mark" aria-hidden="true">“</div>
          <h3><?php echo esc_html( $depoimento->post_title ); ?></h3>
          <div class="stars" aria-label="5 estrelas">★★★★★</div>
          <p><?php echo mirim_text( $depoimento->post_content ); ?></p>
        </article>
        <?php } ?>
      </div>
    </div>
  </section>
  <?php } ?>

  <?php if ( empty( $faixa['ocultar'] ) ) { ?>
  <section class="segment-cta">
    <div class="container segment-cta-inner">
      <div>
        <span class="sec-kicker"><?php echo esc_html( $faixa['kicker'] ); ?></span>
        <h2 class="sec-title"><?php echo esc_html( $faixa['titulo'] ); ?></h2>
        <p><?php echo esc_html( $faixa['texto'] ); ?></p>
      </div>
      <a class="btn" href="<?php echo esc_url( mirim_wa( mirim_servico_mensagem( $slug ) ) ); ?>" target="_blank" rel="noopener"><?php echo esc_html( $bloco['botao'] ); ?></a>
    </div>
  </section>
  <?php } ?>

  <?php if ( empty( $matricula['ocultar'] ) ) { ?>
  <section class="band">
    <div class="container">
      <div class="enroll">
        <div class="enroll-icon" aria-hidden="true">
          <svg viewBox="0 0 24 24" width="32" height="32" fill="none" stroke="currentColor" stroke-width="2"><rect x="4" y="5" width="16" height="15" rx="2"/><path d="M8 3v4M16 3v4M4 10h16"/></svg>
        </div>
        <h2 class="sec-title"><?php echo esc_html( $matricula['titulo'] ); ?></h2>
        <p class="sec-text"><?php echo esc_html( $matricula['texto'] ); ?></p>
        <a class="enroll-cta" href="<?php echo esc_url( mirim_wa( mirim_servico_mensagem( $slug, true ) ) ); ?>" target="_blank" rel="noopener"><?php echo mirim_wa_icon(); ?><?php echo esc_html( mirim_home( 'matricula' )['botao'] ); ?></a>
      </div>
    </div>
  </section>
  <?php } ?>
<?php
get_footer();
