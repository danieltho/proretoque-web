<header class="site-header">
  <div class="site-header__inner">
    <div class="site-header__logo">
      <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="site-header__logo-link">
        <img src="<?php echo esc_url( get_stylesheet_directory_uri() . '/assets/images/proretoque-logo.svg' ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>" class="site-header__logo-img" />
      </a>
    </div>

    <nav class="site-header__nav">
      <?php
      wp_nav_menu( [
        'theme_location' => 'header-menu',
        'container'      => false,
        'menu_class'     => 'site-header__menu',
        'fallback_cb'    => false,
        'depth'          => 1,
      ] );
      ?>
    </nav>
  </div>
</header>
