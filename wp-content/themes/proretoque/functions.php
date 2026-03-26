<?php
/**
 * ProRetoque child theme functions.
 */

// Register header nav menu.
add_action( 'after_setup_theme', function () {
    register_nav_menus( [
        'header-menu'  => __( 'Header Menu', 'proretoque' ),
        'footer-col-1' => __( 'Footer Column 1', 'proretoque' ),
        'footer-col-2' => __( 'Footer Column 2', 'proretoque' ),
        'footer-legal'  => __( 'Footer Legal', 'proretoque' ),
    ] );

    add_theme_support( 'custom-logo', [
        'height'               => 44,
        'width'                => 190,
        'flex-height'          => true,
        'flex-width'           => true,
        'unlink-homepage-logo' => false,
    ] );
} );

// Render custom PHP header via wp_body_open hook.
add_action( 'wp_body_open', function () {
    include get_stylesheet_directory() . '/parts/header.php';
}, 1 );

// Render custom PHP footer via wp_footer hook.
add_action( 'wp_footer', function () {
    include get_stylesheet_directory() . '/parts/footer.php';
}, 1 );

// Allow SVG uploads.
add_filter( 'upload_mimes', function ( $mimes ) {
    $mimes['svg'] = 'image/svg+xml';
    return $mimes;
} );

// Enqueue parent + child styles.
add_action( 'wp_enqueue_scripts', function () {
    wp_enqueue_style(
        'twentytwentyfive-style',
        get_template_directory_uri() . '/style.css',
        [],
        wp_get_theme( 'twentytwentyfive' )->get( 'Version' )
    );
    wp_enqueue_style(
        'proretoque-style',
        get_stylesheet_uri(),
        [ 'twentytwentyfive-style' ],
        wp_get_theme()->get( 'Version' )
    );
} );

// Load Google Fonts (Raleway + Montserrat).
add_action( 'wp_enqueue_scripts', function () {
    wp_enqueue_style(
        'proretoque-google-fonts',
        'https://fonts.googleapis.com/css2?family=Raleway:ital,wght@0,100..900;1,100..900&family=Montserrat:wght@100..900&display=swap',
        [],
        null
    );
} );

// Also load fonts in Elementor editor.
add_action( 'elementor/editor/after_enqueue_styles', function () {
    wp_enqueue_style(
        'proretoque-google-fonts-editor',
        'https://fonts.googleapis.com/css2?family=Raleway:ital,wght@0,100..900;1,100..900&family=Montserrat:wght@100..900&display=swap',
        [],
        null
    );
} );

// Enqueue About page CSS.
add_action( 'wp_enqueue_scripts', function () {
    wp_enqueue_style(
        'proretoque-about',
        get_stylesheet_directory_uri() . '/assets/css/about-page.css',
        [ 'proretoque-style' ],
        '1.0.0'
    );
} );

// Also in Elementor editor preview.
add_action( 'elementor/preview/enqueue_styles', function () {
    wp_enqueue_style(
        'proretoque-about-preview',
        get_stylesheet_directory_uri() . '/assets/css/about-page.css',
        [],
        '1.0.0'
    );
} );

// Register CPT: Marca.
add_action( 'init', function () {
    register_post_type( 'marca', [
        'labels' => [
            'name'               => 'Marcas',
            'singular_name'      => 'Marca',
            'add_new'            => 'Añadir Marca',
            'add_new_item'       => 'Añadir Nueva Marca',
            'edit_item'          => 'Editar Marca',
            'new_item'           => 'Nueva Marca',
            'view_item'          => 'Ver Marca',
            'search_items'       => 'Buscar Marcas',
            'not_found'          => 'No se encontraron marcas',
            'not_found_in_trash' => 'No se encontraron marcas en la papelera',
        ],
        'public'       => false,
        'show_ui'      => true,
        'show_in_rest' => true,
        'has_archive'  => false,
        'rewrite'      => [ 'slug' => 'marcas' ],
        'supports'     => [ 'title', 'editor', 'thumbnail', 'excerpt' ],
        'menu_icon'    => 'dashicons-format-gallery',
    ] );
} );

// Hide page title on pages that use the marcas shortcode.
add_filter( 'the_title', function ( $title, $id ) {
    if ( is_page() && in_the_loop() && is_main_query() && has_shortcode( get_post_field( 'post_content', $id ), 'proretoque_marcas' ) ) {
        return '';
    }
    return $title;
}, 10, 2 );

// Shortcode: [proretoque_marcas].
add_shortcode( 'proretoque_marcas', function () {
    ob_start();
    include get_stylesheet_directory() . '/parts/marcas-grid.php';
    return ob_get_clean();
} );

// Enqueue marcas lightbox JS.
add_action( 'wp_enqueue_scripts', function () {
    if ( ! is_admin() ) {
        wp_enqueue_script(
            'proretoque-marcas-lightbox',
            get_stylesheet_directory_uri() . '/assets/js/marcas-lightbox.js',
            [],
            '1.0.0',
            true
        );
    }
} );

// Register CPT: Before & After.
add_action( 'init', function () {
    register_post_type( 'before_after', [
        'labels' => [
            'name'               => 'Before & After',
            'singular_name'      => 'Before & After',
            'add_new'            => 'Añadir Before & After',
            'add_new_item'       => 'Añadir Nuevo Before & After',
            'edit_item'          => 'Editar Before & After',
            'new_item'           => 'Nuevo Before & After',
            'view_item'          => 'Ver Before & After',
            'search_items'       => 'Buscar Before & After',
            'not_found'          => 'No se encontraron entradas',
            'not_found_in_trash' => 'No se encontraron entradas en la papelera',
        ],
        'public'       => false,
        'show_ui'      => true,
        'show_in_rest' => true,
        'has_archive'  => false,
        'rewrite'      => [ 'slug' => 'before-after' ],
        'supports'     => [ 'title', 'editor', 'thumbnail', 'excerpt' ],
        'menu_icon'    => 'dashicons-image-flip-horizontal',
    ] );
} );

// Hide page title on pages that use the before_after shortcode.
add_filter( 'the_title', function ( $title, $id ) {
    if ( is_page() && in_the_loop() && is_main_query() && has_shortcode( get_post_field( 'post_content', $id ), 'proretoque_before_after' ) ) {
        return '';
    }
    return $title;
}, 10, 2 );

// Shortcode: [proretoque_before_after].
add_shortcode( 'proretoque_before_after', function () {
    ob_start();
    include get_stylesheet_directory() . '/parts/before-after-grid.php';
    return ob_get_clean();
} );

// Enqueue before-after slider JS.
add_action( 'wp_enqueue_scripts', function () {
    if ( ! is_admin() ) {
        wp_enqueue_script(
            'proretoque-before-after-slider',
            get_stylesheet_directory_uri() . '/assets/js/before-after-slider.js',
            [],
            '1.0.0',
            true
        );
    }
} );

// AJAX handler for About page contact form.
add_action( 'wp_ajax_proretoque_contact', 'proretoque_handle_contact_form' );
add_action( 'wp_ajax_nopriv_proretoque_contact', 'proretoque_handle_contact_form' );

function proretoque_handle_contact_form() {
    check_ajax_referer( 'proretoque_contact_nonce', 'nonce' );

    $nombre    = sanitize_text_field( $_POST['nombre'] ?? '' );
    $apellidos = sanitize_text_field( $_POST['apellidos'] ?? '' );
    $correo    = sanitize_email( $_POST['correo'] ?? '' );
    $telefono  = sanitize_text_field( $_POST['telefono'] ?? '' );
    $pais      = sanitize_text_field( $_POST['pais'] ?? '' );
    $tipo      = sanitize_text_field( $_POST['tipo_consulta'] ?? 'General' );
    $mensaje   = sanitize_textarea_field( $_POST['mensaje'] ?? '' );

    if ( empty( $nombre ) || empty( $correo ) ) {
        wp_send_json_error( [ 'message' => 'Nombre y correo son obligatorios.' ] );
    }

    $to      = get_option( 'admin_email' );
    $subject = "[ProRetoque] Nueva consulta: $tipo";
    $body    = "Nombre: $nombre $apellidos\nEmail: $correo\nTeléfono: $telefono\nPaís: $pais\nTipo: $tipo\n\n$mensaje";
    $headers = [ 'Content-Type: text/plain; charset=UTF-8', "Reply-To: $correo" ];

    $sent = wp_mail( $to, $subject, $body, $headers );

    if ( $sent ) {
        wp_send_json_success( [ 'message' => 'Mensaje enviado correctamente.' ] );
    } else {
        wp_send_json_error( [ 'message' => 'Error al enviar el mensaje.' ] );
    }
}

// Pass AJAX URL and nonce to frontend.
add_action( 'wp_enqueue_scripts', function () {
    wp_localize_script( 'jquery', 'proretoque_ajax', [
        'url'   => admin_url( 'admin-ajax.php' ),
        'nonce' => wp_create_nonce( 'proretoque_contact_nonce' ),
    ] );
} );

// Enqueue CF7 radio tabs click handler.
add_action( 'wp_enqueue_scripts', function () {
    if ( ! is_admin() ) {
        wp_enqueue_script(
            'proretoque-cf7-radio-tabs',
            get_stylesheet_directory_uri() . '/assets/js/cf7-radio-tabs.js',
            [],
            '1.0.0',
            true
        );
        wp_enqueue_script(
            'proretoque-cf7-upload-zone',
            get_stylesheet_directory_uri() . '/assets/js/cf7-upload-zone.js',
            [],
            '1.0.0',
            true
        );
    }
} );

// Shortcode: [proretoque_contactanos].
add_shortcode( 'proretoque_contactanos', function () {
    ob_start();
    include get_stylesheet_directory() . '/parts/contactanos.php';
    return ob_get_clean();
} );

// Hide page title on contact page.
add_filter( 'the_title', function ( $title, $id ) {
    if ( is_page() && in_the_loop() && is_main_query() && has_shortcode( get_post_field( 'post_content', $id ), 'proretoque_contactanos' ) ) {
        return '';
    }
    return $title;
}, 10, 2 );

// Shortcode: [proretoque_empieza_proyecto].
add_shortcode( 'proretoque_empieza_proyecto', function () {
    ob_start();
    include get_stylesheet_directory() . '/parts/empieza-proyecto.php';
    return ob_get_clean();
} );

// Hide page title on "Empieza tu proyecto" page.
add_filter( 'the_title', function ( $title, $id ) {
    if ( is_page() && in_the_loop() && is_main_query() && has_shortcode( get_post_field( 'post_content', $id ), 'proretoque_empieza_proyecto' ) ) {
        return '';
    }
    return $title;
}, 10, 2 );

// Shortcode: [proretoque_trabaja].
add_shortcode( 'proretoque_trabaja', function () {
    ob_start();
    include get_stylesheet_directory() . '/parts/trabaja-con-nosotros.php';
    return ob_get_clean();
} );

// Hide page title on "Trabaja con Nosotros" page.
add_filter( 'the_title', function ( $title, $id ) {
    if ( is_page() && in_the_loop() && is_main_query() && has_shortcode( get_post_field( 'post_content', $id ), 'proretoque_trabaja' ) ) {
        return '';
    }
    return $title;
}, 10, 2 );

// Enqueue Trabaja toggle JS.
add_action( 'wp_enqueue_scripts', function () {
    if ( ! is_admin() ) {
        wp_enqueue_script(
            'proretoque-trabaja-toggle',
            get_stylesheet_directory_uri() . '/assets/js/trabaja-toggle.js',
            [],
            '1.0.0',
            true
        );
    }
} );

// Register CPT: FAQ.
add_action( 'init', function () {
    register_post_type( 'faq', [
        'labels' => [
            'name'               => 'Preguntas Frecuentes',
            'singular_name'      => 'Pregunta Frecuente',
            'add_new'            => 'Añadir Pregunta',
            'add_new_item'       => 'Añadir Nueva Pregunta',
            'edit_item'          => 'Editar Pregunta',
            'new_item'           => 'Nueva Pregunta',
            'view_item'          => 'Ver Pregunta',
            'search_items'       => 'Buscar Preguntas',
            'not_found'          => 'No se encontraron preguntas',
            'not_found_in_trash' => 'No se encontraron preguntas en la papelera',
        ],
        'public'       => false,
        'show_ui'      => true,
        'show_in_rest' => true,
        'has_archive'  => false,
        'rewrite'      => [ 'slug' => 'faq' ],
        'supports'     => [ 'title', 'editor', 'page-attributes' ],
        'menu_icon'    => 'dashicons-editor-help',
    ] );
} );

// Shortcode: [proretoque_faq].
add_shortcode( 'proretoque_faq', function () {
    ob_start();
    include get_stylesheet_directory() . '/parts/faq.php';
    return ob_get_clean();
} );

// Hide page title on FAQ page.
add_filter( 'the_title', function ( $title, $id ) {
    if ( is_page() && in_the_loop() && is_main_query() && has_shortcode( get_post_field( 'post_content', $id ), 'proretoque_faq' ) ) {
        return '';
    }
    return $title;
}, 10, 2 );

// Enqueue FAQ accordion JS.
add_action( 'wp_enqueue_scripts', function () {
    if ( ! is_admin() ) {
        wp_enqueue_script(
            'proretoque-faq-accordion',
            get_stylesheet_directory_uri() . '/assets/js/faq-accordion.js',
            [],
            '1.0.0',
            true
        );
    }
} );
