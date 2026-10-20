<?php
/**
 * Products Toolkit (design R07).
 * Clicking a product on the left swaps the panel on the right (view.js), as in the design.
 *
 * @var array $block ACF block settings.
 */

$eyebrow   = sm_get( 'eyebrow', 'Our products' );
$h_lead    = sm_get( 'heading_lead', 'Your ultimate' );
$h_mark    = sm_get( 'heading_highlight', 'learning toolkit' );
$lede      = sm_get( 'lede', 'Unlock your full potential with our innovative EdTech solutions. From interactive study tools to AI-powered learning aids, we make studying smarter, easier and more engaging for students everywhere.' );
$head_btn  = sm_link( sm_get( 'button' ), 'View all products', '#' );

$chip = function ( $t, $wide = false ) {
	return array( 'text' => $t, 'wide' => $wide );
};
/* Product 1 is from the design. Products 2 to 5: summaries are from the design; chips, CTA labels and links are starter content. */
$products = sm_get( 'products', array(
	array( 'title' => '1:1 Tutoring', 'summary' => 'Personalised tutoring to fill the gaps and help you achieve your target grades.', 'chips' => array( $chip( 'Ages 11-18' ), $chip( 'Weekly or intensive' ), $chip( '1:1 online or in person' ), $chip( 'All exam boards' ) ), 'cta' => array( 'title' => 'Find me a tutor', 'url' => '#enquire' ) ),
	array( 'title' => 'Summer Career Camps', 'summary' => 'For ages 15-18: an immersive experience in your dream career, available in top competitive industries.', 'chips' => array( $chip( 'Ages 15-18' ), $chip( 'One-week programmes' ), $chip( 'Top competitive industries' ), $chip( 'Certificate on completion' ) ), 'cta' => array( 'title' => 'Explore camps', 'url' => '/summer-career-camps' ) ),
	array( 'title' => 'SEND and Alternative Provision', 'summary' => 'Specialist SEND and AP tutors creating personalised learning plans tailored to your needs.', 'chips' => array( $chip( 'Specialist SEND tutors' ), $chip( 'Personalised learning plans' ), $chip( 'For schools, trusts and councils', true ) ), 'cta' => array( 'title' => 'Talk to our team', 'url' => '#enquire' ) ),
	array( 'title' => 'Online Courses', 'summary' => 'Self-paced online courses designed for in-depth subject learning.', 'chips' => array( $chip( 'Self-paced' ), $chip( 'GCSE and A-level' ), $chip( 'Video lessons' ), $chip( 'Practice questions' ) ), 'cta' => array( 'title' => 'Browse courses', 'url' => '/our-services/online-courses' ) ),
	array( 'title' => 'Resources for Schools', 'summary' => 'Free resources for students and teachers to support success in education and beyond.', 'chips' => array( $chip( 'Free to use' ), $chip( 'Revision notes' ), $chip( 'Past papers' ), $chip( 'Study guides' ) ), 'cta' => array( 'title' => 'Explore resources', 'url' => '/resources' ) ),
) );

$stats = sm_get( 'stats', array(
	array( 'value' => '12,000', 'label' => 'Happy alumni' ),
	array( 'value' => '20 years', 'label' => 'Of excellence' ),
	array( 'value' => '175+', 'label' => 'Nations represented' ),
	array( 'value' => '99%', 'label' => 'Recommended' ),
) );

/* Panel data for each product, for view.js. */
$panels = array();
foreach ( (array) $products as $p ) {
	$cta   = sm_link( sm_row( $p, 'cta' ), 'Find out more', '#' );
	$chips = array();
	foreach ( (array) sm_row( $p, 'chips', array() ) as $c ) {
		$chips[] = array( 'text' => sm_row( $c, 'text' ), 'wide' => (bool) sm_row( $c, 'wide', false ) );
	}
	$badges = array();
	foreach ( (array) sm_row( $p, 'badges', array() ) as $b ) {
		$badges[] = array( 'img' => sm_img_url( sm_row( $b, 'image' ), 'thumbnail' ), 'label' => sm_row( $b, 'label' ) );
	}
	$img      = sm_row( $p, 'image' );
	$panels[] = array(
		'title'  => sm_row( $p, 'title' ),
		'chips'  => $chips,
		'badges' => $badges,
		'cta'    => $cta,
		'img'    => sm_img_url( $img, 'large' ) ?: sm_asset( 'img/placeholder.svg' ),
		'alt'    => sm_img_alt( $img, sm_row( $p, 'title' ) ),
	);
}
$first = $panels ? $panels[0] : null;

$chips_html = function ( $chips ) {
	$out = '';
	foreach ( $chips as $c ) {
		$out .= '<span class="chip' . ( $c['wide'] ? ' wide' : '' ) . '"><i></i>' . esc_html( $c['text'] ) . '</span>';
	}
	return $out;
};
$badges_html = function ( $badges ) {
	$out = '';
	foreach ( $badges as $b ) {
		$ph   = $b['img'] ? '<div class="ph light has-img"><img src="' . esc_url( $b['img'] ) . '" alt=""></div>' : '<div class="ph light" data-asset="badge"></div>';
		$out .= '<div class="tbadge">' . $ph . '<span>' . esc_html( $b['label'] ) . '</span></div>';
	}
	return $out;
};
?>
<div <?php echo sm_block_attrs( $block ); ?>>
<section class="products" id="products" data-lay="products">
  <div class="wrap">
    <p class="eyebrow"><?php echo esc_html( $eyebrow ); ?></p>
    <h2 class="h2"><span style="color:var(--ink)"><?php echo esc_html( $h_lead ); ?></span> <span><?php echo esc_html( $h_mark ); ?></span></h2>
    <p class="lede"><?php echo esc_html( $lede ); ?></p>
    <div class="head-cta"><a <?php echo sm_href( $head_btn ); ?> class="btn btn-outline"><?php echo esc_html( $head_btn['title'] ); ?></a></div>

    <div class="toolkit">
      <div class="prodlist" role="tablist" aria-label="Study Mind products">
<?php foreach ( (array) $products as $i => $p ) : ?>
        <button class="prod" role="tab" aria-selected="<?php echo 0 === $i ? 'true' : 'false'; ?>" data-p="<?php echo (int) $i; ?>">
          <b><?php echo esc_html( sm_row( $p, 'title' ) ); ?></b>
          <p><?php echo esc_html( sm_row( $p, 'summary' ) ); ?></p>
          <span class="more"><?php echo esc_html( sm_row( $p, 'more_label', 'Learn more ↗' ) ); ?></span>
        </button>
<?php endforeach; ?>
      </div>

<?php if ( $first ) : ?>
      <div class="panel" id="panel">
        <div class="panel-copy">
          <h3 id="pTitle"><?php echo esc_html( $first['title'] ); ?></h3>
          <div class="chips" id="pChips"><?php echo $chips_html( $first['chips'] ); // phpcs:ignore -- escaped in closure. ?></div>
          <div class="badgepair" id="pBadges"><?php echo $badges_html( $first['badges'] ); // phpcs:ignore -- escaped in closure. ?></div>
          <div class="stats4">
<?php foreach ( (array) $stats as $s ) : ?>
            <div class="stat"><b><?php echo esc_html( sm_row( $s, 'value' ) ); ?></b><span><?php echo esc_html( sm_row( $s, 'label' ) ); ?></span></div>
<?php endforeach; ?>
          </div>
          <a <?php echo sm_href( $first['cta'] ); ?> class="btn btn-primary" id="pCta"><?php echo esc_html( $first['cta']['title'] ); ?></a>
        </div>
        <div class="panel-art"><img id="pArt" alt="<?php echo esc_attr( $first['alt'] ); ?>" src="<?php echo esc_url( $first['img'] ); ?>"></div>
      </div>
<?php endif; ?>
    </div>
  </div>
  <script type="application/json" class="sm-toolkit-data"><?php echo wp_json_encode( $panels, JSON_HEX_TAG | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE ); ?></script>
</section>
</div>
