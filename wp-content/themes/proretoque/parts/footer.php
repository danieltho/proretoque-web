<?php
$theme_uri = get_stylesheet_directory_uri();
$icons_uri = $theme_uri . '/assets/images/icons';
?>
<footer class="site-footer">
  <div class="site-footer__inner">

    <hr class="site-footer__separator" />

    <div class="site-footer__main">
      <div class="site-footer__left">
        <div class="site-footer__logo">
          <a href="<?php echo esc_url( home_url( '/' ) ); ?>">
            <img src="<?php echo esc_url( $theme_uri . '/assets/images/proretoque-logo.svg' ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>" />
          </a>
        </div>

        <div class="site-footer__newsletter">
          <h3 class="site-footer__newsletter-title">Suscríbete a nuestra newsletter</h3>
          <form class="site-footer__newsletter-form">
            <input type="email" class="site-footer__newsletter-input" placeholder="Introduce tu dirección de correo" />
            <button type="submit" class="site-footer__newsletter-btn">Suscribirse</button>
          </form>
        </div>
      </div>

      <div class="site-footer__columns">
        <div class="site-footer__col">
          <?php
          wp_nav_menu( [
              'theme_location' => 'footer-col-1',
              'container'      => false,
              'menu_class'     => 'site-footer__menu',
              'fallback_cb'    => false,
              'depth'          => 1,
          ] );
          ?>
        </div>
        <div class="site-footer__col">
          <?php
          wp_nav_menu( [
              'theme_location' => 'footer-col-2',
              'container'      => false,
              'menu_class'     => 'site-footer__menu',
              'fallback_cb'    => false,
              'depth'          => 1,
          ] );
          ?>
        </div>
      </div>
    </div>

    <hr class="site-footer__separator" />

    <div class="site-footer__bottom">
      <nav class="site-footer__legal">
        <?php
        wp_nav_menu( [
            'theme_location' => 'footer-legal',
            'container'      => false,
            'menu_class'     => 'site-footer__legal-menu',
            'fallback_cb'    => false,
            'depth'          => 1,
        ] );
        ?>
      </nav>
      <div class="site-footer__social">
        <a href="#" aria-label="Email"><img src="<?php echo esc_url( $icons_uri . '/email.svg' ); ?>" alt="Email" /></a>
        <a href="#" aria-label="WhatsApp"><img src="<?php echo esc_url( $icons_uri . '/whatsapp.svg' ); ?>" alt="WhatsApp" /></a>
        <a href="#" aria-label="Facebook"><img src="<?php echo esc_url( $icons_uri . '/facebook.svg' ); ?>" alt="Facebook" /></a>
        <a href="#" aria-label="Instagram"><img src="<?php echo esc_url( $icons_uri . '/instagram.svg' ); ?>" alt="Instagram" /></a>
        <a href="#" aria-label="LinkedIn"><img src="<?php echo esc_url( $icons_uri . '/linkedin.svg' ); ?>" alt="LinkedIn" /></a>
      </div>
    </div>

  </div>
</footer>
