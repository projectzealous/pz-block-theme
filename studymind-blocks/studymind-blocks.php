<?php
/**
 * Plugin Name:       Study Mind Blocks
 * Description:       ACF blocks for the Study Mind homepage, plus the shared site header and footer, built from the Study Mind Block Library design.
 * Version:           0.1.0
 * Requires at least: 6.4
 * Requires PHP:      7.4
 * Text Domain:       studymind
 */

defined( 'ABSPATH' ) || exit;

define( 'SM_BLOCKS_VERSION', '0.1.0' );
define( 'SM_BLOCKS_DIR', plugin_dir_path( __FILE__ ) );
define( 'SM_BLOCKS_URL', plugin_dir_url( __FILE__ ) );

require_once SM_BLOCKS_DIR . 'inc/helpers.php';
require_once SM_BLOCKS_DIR . 'inc/chrome.php';

/** The blocks in this plugin, one folder each under /blocks. */
function sm_block_names() {
	return array(
		'site-header',
		'home-hero',
		'products-toolkit',
		'sister-brands',
		'why-study-mind',
		'success-stories',
		'trust-logos',
		'awards-enquiry',
		'site-footer',
	);
}

/**
 * Styles and fonts. Registered early so block.json files can reference the handles.
 * - sm-fonts:  the exact Google Fonts request the design uses.
 * - sm-shared: the design's shared stylesheet (header, footer, other pages later).
 * - sm-home:   the design's homepage stylesheet.
 * - sm-wp:     small WordPress integration layer (see the file header).
 */
add_action( 'init', function () {
	wp_register_style( 'sm-fonts', 'https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800&family=Poppins:wght@300;400;500;600;700&display=swap', array(), null );
	wp_register_style( 'sm-shared', SM_BLOCKS_URL . 'assets/css/sm-shared.css', array( 'sm-fonts' ), SM_BLOCKS_VERSION );
	wp_register_style( 'sm-home', SM_BLOCKS_URL . 'assets/css/sm-home.css', array( 'sm-fonts' ), SM_BLOCKS_VERSION );
	wp_register_style( 'sm-wp', SM_BLOCKS_URL . 'assets/css/wp-fixes.css', array( 'sm-shared', 'sm-home' ), SM_BLOCKS_VERSION );

	foreach ( sm_block_names() as $name ) {
		register_block_type( SM_BLOCKS_DIR . 'blocks/' . $name );
	}
}, 5 );

/* Load the CSS on the front end and inside the block editor, so the editor preview is the real design. */
add_action( 'enqueue_block_assets', function () {
	wp_enqueue_style( 'sm-fonts' );
	wp_enqueue_style( 'sm-shared' );
	wp_enqueue_style( 'sm-home' );
	wp_enqueue_style( 'sm-wp' );
} );

add_action( 'wp_head', function () {
	echo '<link rel="preconnect" href="https://fonts.googleapis.com">' . "\n";
	echo '<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>' . "\n";
}, 1 );

/* Block inserter category. */
add_filter( 'block_categories_all', function ( $cats ) {
	array_unshift( $cats, array( 'slug' => 'study-mind', 'title' => 'Study Mind' ) );
	return $cats;
} );

/* ACF field groups live in /acf-json so they can be synced and edited in the ACF UI. */
add_filter( 'acf/settings/load_json', function ( $paths ) {
	$paths[] = SM_BLOCKS_DIR . 'acf-json';
	return $paths;
} );

/* Saving a Study Mind field group in the ACF UI writes it back to this plugin's /acf-json. */
add_filter( 'acf/json/save_paths', function ( $paths, $post ) {
	if ( isset( $post['key'] ) && 0 === strpos( $post['key'], 'group_sm_' ) ) {
		return array( SM_BLOCKS_DIR . 'acf-json' );
	}
	return $paths;
}, 10, 2 );

/* "Homepage" block pattern: every homepage block in design order. */
add_action( 'init', function () {
	$blocks = array( 'home-hero', 'products-toolkit', 'sister-brands', 'why-study-mind', 'success-stories', 'trust-logos', 'awards-enquiry' );
	$content = '';
	foreach ( $blocks as $b ) {
		$content .= '<!-- wp:sm/' . $b . ' {"name":"sm/' . $b . '","data":{},"mode":"preview"} /-->' . "\n\n";
	}
	register_block_pattern_category( 'study-mind', array( 'label' => 'Study Mind' ) );
	register_block_pattern( 'study-mind/homepage', array(
		'title'       => 'Study Mind homepage',
		'description' => 'All homepage blocks in design order.',
		'categories'  => array( 'study-mind' ),
		'content'     => $content,
	) );
} );
