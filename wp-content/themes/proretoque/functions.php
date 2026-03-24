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
