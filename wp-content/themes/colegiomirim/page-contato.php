<?php
get_header();
if ( have_posts() ) {
	the_post();
}
$contato = mirim_contato();
$capa    = $contato['capa'];
$dados   = $contato['dados'];
$form    = $contato['formulario'];
$mapa    = $contato['mapa'];
$geral   = mirim_geral();
$hero    = mirim_image_url( $capa['imagem'], $capa['arquivo'] );
?>
<section class="page-hero" style="background-image: linear-gradient(rgba(255,255,255,.45), rgba(255,255,255,.45)), url('<?php echo esc_url( $hero ); ?>');">
    <div class="container">
      <h1><?php the_title(); ?></h1>
      <p><?php echo esc_html( $capa['texto'] ); ?></p>
      <ul class="crumbs">
        <li><a href="<?php echo esc_url( home_url( '/' ) ); ?>">Início</a></li>
        <li><?php the_title(); ?></li>
      </ul>
    </div>
  </section>

  <section class="section">
    <div class="container info-grid">
      <article class="info-card">
        <div class="info-icon" aria-hidden="true">
          <svg viewBox="0 0 24 24" width="30" height="30" fill="currentColor"><path d="M6.6 10.8a15 15 0 006.6 6.6l2.2-2.2a1 1 0 011-.25 11 11 0 003.6.57 1 1 0 011 1V20a1 1 0 01-1 1A17 17 0 013 7a1 1 0 011-1h3.5a1 1 0 011 1 11 11 0 00.57 3.6 1 1 0 01-.25 1L6.6 10.8z"/></svg>
        </div>
        <h3><?php echo esc_html( $dados['telefone'] ); ?></h3>
        <p><a href="<?php echo esc_url( mirim_tel() ); ?>"><?php echo esc_html( $geral['telefone'] ); ?></a></p>
      </article>
      <article class="info-card">
        <div class="info-icon" aria-hidden="true">
          <svg viewBox="0 0 24 24" width="30" height="30" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 6h16v12H4z"/><path d="M4 7l8 6 8-6"/></svg>
        </div>
        <h3><?php echo esc_html( $dados['email'] ); ?></h3>
        <p><a href="mailto:<?php echo esc_attr( $geral['email'] ); ?>"><?php echo esc_html( $geral['email'] ); ?></a></p>
      </article>
      <article class="info-card">
        <div class="info-icon" aria-hidden="true">
          <svg viewBox="0 0 24 24" width="30" height="30" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 21s7-6.2 7-11a7 7 0 10-14 0c0 4.8 7 11 7 11z"/><circle cx="12" cy="10" r="2.5"/></svg>
        </div>
        <h3><?php echo esc_html( $dados['endereco'] ); ?></h3>
        <p><?php echo esc_html( $geral['endereco'] ); ?></p>
      </article>
    </div>
  </section>

  <section class="section-sm">
    <div class="container contact-layout">
      <div>
        <span class="sec-kicker"><?php echo esc_html( $form['kicker'] ); ?></span>
        <h2 class="sec-title"><?php echo esc_html( $form['titulo'] ); ?></h2>
        <form class="form-grid" data-contact-form data-wa="<?php echo esc_attr( mirim_digits( $geral['whatsapp'] ) ); ?>">
          <label class="field">Primeiro Nome <span>(Obrigatório)</span><input name="firstname" type="text" required></label>
          <label class="field">Sobrenome <span>(Obrigatório)</span><input name="lastname" type="text" required></label>
          <label class="field">Endereço de Email <span>(Obrigatório)</span><input name="email" type="email" required></label>
          <label class="field">Número de Telefone <span>(Obrigatório)</span><input name="number" type="tel" required></label>
          <label class="field full">Mensagem <span>(Obrigatório)</span><textarea name="message" rows="7" placeholder="Digite sua mensagem" required></textarea></label>
          <div class="field full">
            <div class="form-actions">
              <button class="btn" type="submit"><?php echo esc_html( $form['botao'] ); ?></button>
              <a class="btn nav-cta" href="<?php echo esc_url( mirim_wa( 'matricula' ) ); ?>" target="_blank" rel="noopener"><?php echo esc_html( $geral['cta_matricula'] ); ?></a>
            </div>
            <p class="form-note" role="status"></p>
          </div>
        </form>
      </div>
      <?php echo mirim_img( $form, $form['alt'] ); ?>
    </div>
  </section>

  <section class="section-sm">
    <div class="container">
      <h2 class="sec-title"><?php echo esc_html( $mapa['titulo'] ); ?></h2>
      <div class="map-style">
        <iframe src="<?php echo esc_url( $geral['mapa'] ); ?>" title="<?php echo esc_attr( $mapa['titulo'] ); ?>" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
      </div>
    </div>
  </section>
<?php
get_footer();
