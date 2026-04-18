<?php
/**
 * ProRetoque Blocks — Registro y carga de assets
 *
 * Copiar este código dentro del functions.php del tema,
 * o hacer require_once desde functions.php:
 *
 *   require_once get_template_directory() . '/functions-snippet.php';
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Registro de categoría propia en el inserter de Gutenberg.
 */
add_filter( 'block_categories_all', function ( $categories ) {
	return array_merge(
		[
			[
				'slug'  => 'proretoque',
				'title' => __( 'ProRetoque', 'proretoque' ),
				'icon'  => null,
			],
		],
		$categories
	);
}, 10, 1 );

/**
 * Registro de los 7 bloques ACF mediante block.json.
 * Requiere ACF PRO 6.0+ (soporte nativo de block.json).
 */
add_action( 'init', function () {
	$blocks_dir = get_template_directory() . '/blocks';

	$blocks = [
		'hero-section',
		'dual-tabs',
		'value-cards',
		'text-with-accordion',
		'accordion',
		'logo-carousel',
		'stats-bar',
	];

	foreach ( $blocks as $block ) {
		$path = $blocks_dir . '/' . $block;
		if ( file_exists( $path . '/block.json' ) ) {
			register_block_type( $path );
		}
	}
} );

/**
 * CSS global de bloques (front + editor).
 */
add_action( 'wp_enqueue_scripts', function () {
	$css_rel = '/assets/css/blocks.css';
	$css_abs = get_template_directory() . $css_rel;
	if ( ! file_exists( $css_abs ) ) {
		return;
	}
	wp_enqueue_style(
		'proretoque-blocks',
		get_template_directory_uri() . $css_rel,
		[],
		filemtime( $css_abs )
	);
} );

add_action( 'enqueue_block_editor_assets', function () {
	$css_rel = '/assets/css/blocks.css';
	$css_abs = get_template_directory() . $css_rel;
	if ( ! file_exists( $css_abs ) ) {
		return;
	}
	wp_enqueue_style(
		'proretoque-blocks-editor',
		get_template_directory_uri() . $css_rel,
		[],
		filemtime( $css_abs )
	);
} );

/**
 * Encolado condicional de JS por bloque.
 * Sólo se carga si el bloque está presente en la página renderizada.
 */
add_action( 'wp_enqueue_scripts', function () {
	if ( ! is_singular() ) {
		return;
	}

	$post = get_post();
	if ( ! $post ) {
		return;
	}

	$js_map = [
		'proretoque/dual-tabs'           => 'dual-tabs.js',
		'proretoque/accordion'           => 'accordion.js',
		'proretoque/text-with-accordion' => 'accordion.js',
		'proretoque/logo-carousel'       => 'logo-carousel.js',
	];

	$already = [];

	foreach ( $js_map as $block_name => $js_file ) {
		if ( has_block( $block_name, $post ) && ! isset( $already[ $js_file ] ) ) {
			$js_rel = '/assets/js/' . $js_file;
			$js_abs = get_template_directory() . $js_rel;
			if ( file_exists( $js_abs ) ) {
				$handle = 'proretoque-' . str_replace( '.js', '', $js_file );
				wp_enqueue_script(
					$handle,
					get_template_directory_uri() . $js_rel,
					[],
					filemtime( $js_abs ),
					true
				);
				$already[ $js_file ] = true;
			}
		}
	}
} );
