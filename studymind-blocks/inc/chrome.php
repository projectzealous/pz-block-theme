<?php
/**
 * Site header and footer ("site chrome").
 *
 * Content lives on one ACF options page (Appearance > Header & Footer) because it
 * is shared by every page. Output it with either:
 *   - the "Site Header" / "Site Footer" blocks (block themes, template parts), or
 *   - studymind_header() / studymind_footer() in header.php / footer.php (classic themes).
 */

defined( 'ABSPATH' ) || exit;

add_action( 'acf/init', function () {
	if ( function_exists( 'acf_add_options_page' ) ) {
		acf_add_options_page( array(
			'page_title'  => 'Header & Footer',
			'menu_title'  => 'Header & Footer',
			'menu_slug'   => 'sm-header-footer',
			'parent_slug' => 'themes.php',
			'capability'  => 'edit_theme_options',
			'post_id'     => 'option',
		) );
	}
} );

add_action( 'admin_notices', function () {
	if ( ! function_exists( 'acf_add_options_page' ) && current_user_can( 'activate_plugins' ) ) {
		echo '<div class="notice notice-error"><p><strong>Study Mind Blocks</strong> needs Advanced Custom Fields PRO (repeaters, options page and ACF blocks).</p></div>';
	}
} );

/** Icon keys the design's dropdown icons support (.di[data-ic]). */
function sm_nav_icons() {
	return array(
		'tutor'    => '1:1 tutoring (person)',
		'course'   => 'Online course (screen)',
		'notes'    => 'Revision notes (document)',
		'paper'    => 'Past paper (page)',
		'resource' => 'Resources (book)',
		'guide'    => 'Study guide (book)',
		'camp'     => 'Camp (tent)',
		'ap'       => 'Alternative provision (shield)',
		'bespoke'  => 'Bespoke (star outline)',
		'group'    => 'Group (people)',
		'event'    => 'Event (calendar)',
		'who'      => 'About (info)',
		'team'     => 'Team (two people)',
		'star'     => 'Success (star)',
	);
}

/** Design default for the main menu. */
function sm_default_menu() {
	$l = function ( $title, $url ) {
		return array( 'title' => $title, 'url' => $url, 'target' => '' );
	};
	$c = function ( $title, $url, $icon ) use ( $l ) {
		return array( 'link' => $l( $title, $url ), 'icon' => $icon );
	};
	return array(
		array( 'link' => $l( 'Our Services', '/our-services' ), 'children' => array(
			$c( 'Alternative Provision', '/our-services/alternative-provision', 'ap' ),
			$c( 'Summer Career Camps', '/our-services/summer-career-camps', 'camp' ),
			$c( '1:1 Tutoring', '/our-services/1-1-tutoring', 'tutor' ),
			$c( 'Online Courses', '/our-services/online-courses', 'course' ),
			$c( 'Resources', '/our-services/resources', 'resource' ),
		) ),
		array( 'link' => $l( 'GCSE', '/gcse' ), 'children' => array(
			$c( '1:1 Tutoring', '/gcse/1-1-tutoring', 'tutor' ),
			$c( 'Online Courses', '/gcse/online-courses', 'course' ),
			$c( 'Revision Notes', '/gcse/revision-notes', 'notes' ),
			$c( 'Past Papers', '/gcse/past-papers', 'paper' ),
		) ),
		array( 'link' => $l( 'A-level', '/a-level' ), 'children' => array(
			$c( '1:1 Tutoring', '/a-level/1-1-tutoring', 'tutor' ),
			$c( 'Online Courses', '/a-level/online-courses', 'course' ),
			$c( 'Revision Notes', '/a-level/revision-notes', 'notes' ),
			$c( 'Past Papers', '/a-level/past-papers', 'paper' ),
		) ),
		array( 'link' => $l( 'Summer Career Camps', '/summer-career-camps' ), 'children' => array() ),
		array( 'link' => $l( 'Alternative Provision', '/alternative-provision' ), 'children' => array(
			$c( 'Bespoke Solutions', '/alternative-provision/bespoke-solutions', 'bespoke' ),
			$c( '1:1 Tutoring', '/alternative-provision/1-1-tutoring', 'tutor' ),
			$c( 'Group Settings', '/alternative-provision/group-settings', 'group' ),
		) ),
		array( 'link' => $l( 'Resources', '/resources' ), 'children' => array(
			$c( 'The Study Guide', '/resources/study-guide', 'guide' ),
			$c( 'Revision Notes', '/resources/revision-notes', 'notes' ),
			$c( 'Past Papers', '/resources/past-papers', 'paper' ),
			$c( 'Free Events', '/resources/free-events', 'event' ),
		) ),
		array( 'link' => $l( 'About Us', '/about-us' ), 'children' => array(
			$c( 'Who is Study Mind', '/about-us/who-is-study-mind', 'who' ),
			$c( 'Meet the Team', '/about-us/meet-the-team', 'team' ),
			$c( 'Success Stories', '/about-us/success-stories', 'star' ),
		) ),
	);
}

/** True when the menu link is the current section (its path starts the current URL path). */
function sm_is_current_section( $url ) {
	$path = wp_parse_url( $url, PHP_URL_PATH );
	if ( ! $path || '/' === $path || 0 === strpos( (string) $url, '#' ) ) {
		return false;
	}
	$req = isset( $_SERVER['REQUEST_URI'] ) ? wp_parse_url( wp_unslash( $_SERVER['REQUEST_URI'] ), PHP_URL_PATH ) : '';
	$path = untrailingslashit( $path );
	$req  = untrailingslashit( (string) $req );
	return $req === $path || 0 === strpos( $req, $path . '/' );
}

/** The design's dropdown caret. */
function sm_caret() {
	return '<svg class="caret" viewBox="0 0 10 6"><path d="M1 1l4 4 4-4" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"></path></svg>';
}

/** Header markup (design block F01 "Navigation"). */
function studymind_header_markup() {
	$logo = sm_get( 'header_logo', null, 'option' );
	$menu = sm_get( 'header_menu', sm_default_menu(), 'option' );
	$cta  = sm_link( sm_get( 'header_cta', null, 'option' ), 'Contact Us', '#enquire' );

	wp_enqueue_script( 'sm-site-header', SM_BLOCKS_URL . 'blocks/site-header/view.js', array(), SM_BLOCKS_VERSION, true );

	ob_start();
	?>
<div class="sm-shared">
<header class="nav" id="nav">
  <div class="wrap nav-in">
    <a class="nav-logo" href="<?php echo esc_url( home_url( '/' ) ); ?>"><img src="<?php echo esc_url( sm_img_url( $logo, 'medium' ) ?: sm_asset( 'img/study-mind-logo-white.png' ) ); ?>" alt="<?php echo esc_attr( sm_img_alt( $logo, 'Study Mind' ) ); ?>" width="111" height="34"></a>
    <nav class="nav-links">
<?php foreach ( (array) $menu as $item ) :
	$link     = sm_link( sm_row( $item, 'link' ), '', '#' );
	$children = (array) sm_row( $item, 'children', array() );
	$current  = sm_is_current_section( $link['url'] );
	?>
      <div class="navitem<?php echo $current ? ' current' : ''; ?>">
        <a <?php echo sm_href( $link ); ?> class="navlink"<?php echo $current ? ' aria-current="page"' : ''; ?>><?php echo esc_html( $link['title'] ); ?><?php echo $children ? ' ' . sm_caret() : ''; ?></a>
<?php if ( $children ) : ?>
        <div class="dropdown" role="menu">
<?php foreach ( $children as $child ) :
	$cl = sm_link( sm_row( $child, 'link' ), '', '#' ); ?>
          <a <?php echo sm_href( $cl ); ?> role="menuitem"><span class="di" data-ic="<?php echo esc_attr( sm_row( $child, 'icon', 'tutor' ) ); ?>"></span><?php echo esc_html( $cl['title'] ); ?></a>
<?php endforeach; ?>
        </div>
<?php endif; ?>
      </div>
<?php endforeach; ?>
    </nav>
    <div class="nav-right">
      <a <?php echo sm_href( $cta ); ?> class="nav-cta"><?php echo esc_html( $cta['title'] ); ?></a>
    </div>
    <button class="burger" id="burger" aria-label="Open menu" aria-expanded="false">☰</button>
  </div>
</header>
</div>
	<?php
	return ob_get_clean();
}

/** Footer markup (design block F05 "Footer"). */
function studymind_footer_markup() {
	$logo    = sm_get( 'footer_logo', null, 'option' );
	$blurb   = sm_get( 'footer_blurb', 'Award-winning tuition, online courses and free resources for students aged 11 to 18.', 'option' );
	$columns = sm_get( 'footer_columns', sm_default_footer_columns(), 'option' );
	$legal   = sm_get( 'footer_legal', '© {year} Study Mind Limited. Registered in England and Wales, company no. 10871191.', 'option' );
	$also    = sm_get( 'footer_also', 'Also from us: Medic Mind · Oxbridge Mind · Law Mind', 'option' );
	$legal   = str_replace( '{year}', gmdate( 'Y' ), $legal );

	ob_start();
	?>
<div class="sm-shared">
<footer class="ft">
  <div class="wrap">
    <div class="ft-grid">
      <div class="ft-brand"><img src="<?php echo esc_url( sm_img_url( $logo, 'medium' ) ?: sm_asset( 'img/study-mind-logo-white.png' ) ); ?>" alt="<?php echo esc_attr( sm_img_alt( $logo, 'Study Mind' ) ); ?>" width="143" height="44"><p><?php echo esc_html( $blurb ); ?></p></div>
<?php foreach ( (array) $columns as $col ) : ?>
      <div><h4><?php echo esc_html( sm_row( $col, 'heading' ) ); ?></h4><ul><?php foreach ( (array) sm_row( $col, 'links', array() ) as $row ) : $fl = sm_link( sm_row( $row, 'link' ), '', '#' ); ?><li><a <?php echo sm_href( $fl ); ?>><?php echo esc_html( $fl['title'] ); ?></a></li><?php endforeach; ?></ul></div>
<?php endforeach; ?>
    </div>
    <div class="ft-base"><span><?php echo esc_html( $legal ); ?></span><span><?php echo esc_html( $also ); ?></span></div>
  </div>
</footer>
</div>
	<?php
	return ob_get_clean();
}

/** Design default footer columns. */
function sm_default_footer_columns() {
	$r = function ( $title, $url ) {
		return array( 'link' => array( 'title' => $title, 'url' => $url, 'target' => '' ) );
	};
	return array(
		array( 'heading' => 'GCSE', 'links' => array( $r( '1:1 Tuition', '#tuition' ), $r( 'Online Courses', '#courses' ), $r( 'Revision Notes', '#resources' ), $r( 'Past Papers', '#resources' ) ) ),
		array( 'heading' => 'Services', 'links' => array( $r( 'Our Services Explained', '#' ), $r( 'Summer Career Camps', '#' ), $r( 'Alternative Provision', '#' ), $r( 'University Admissions', '#' ) ) ),
		array( 'heading' => 'Company', 'links' => array( $r( 'About Us', '#' ), $r( 'The Study Guide', '#' ), $r( 'Careers', '#' ), $r( 'Privacy Policy', '#' ) ) ),
		array( 'heading' => 'Contact', 'links' => array( $r( '020 3305 9593', 'tel:+442033059593' ), $r( 'info@studymind.co.uk', 'mailto:info@studymind.co.uk' ), $r( 'Book a free consultation', '#enquire' ) ) ),
	);
}

/** Classic-theme template tags. */
function studymind_header() {
	echo studymind_header_markup(); // phpcs:ignore WordPress.Security.EscapeOutput -- escaped above.
}
function studymind_footer() {
	echo studymind_footer_markup(); // phpcs:ignore WordPress.Security.EscapeOutput -- escaped above.
}
