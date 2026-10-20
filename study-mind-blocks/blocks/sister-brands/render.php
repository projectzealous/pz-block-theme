<?php
/**
 * Sister Brands (design R08).
 * Each card's colour theme (medic / oxbridge / law) is a design class; pick it per card.
 *
 * @var array $block ACF block settings.
 */

$h_lead = sm_get( 'heading_lead', 'We do even' );
$h_mark = sm_get( 'heading_highlight', 'more' );
$lede   = sm_get( 'lede', 'Three specialist sister brands, built for students aiming at medicine, Oxbridge and law.' );

$st = function ( $v, $l ) {
	return array( 'value' => $v, 'label' => $l );
};
$li = function ( ...$items ) {
	return array_map( function ( $t ) {
		return array( 'item' => $t );
	}, $items );
};
$brands = sm_get( 'brands', array(
	array( 'theme' => 'medic', 'name' => 'Medic Mind', 'stats' => array( $st( '200,000', 'Hours taught' ), $st( '92%', 'Success rate' ), $st( '2810', 'Avg UCAT score' ) ), 'text' => 'Our award-winning company of working doctors and medical students has helped 92% of our students achieve a place in medical school.', 'list' => $li( 'Full application tutoring', 'UCAT and GAMSAT courses', 'Personal statement support', 'MMI interview courses', 'Medical work experience' ), 'button' => array( 'title' => 'Find out more', 'url' => 'https://www.medicmind.co.uk' ) ),
	array( 'theme' => 'oxbridge', 'name' => 'Oxbridge Mind', 'stats' => array( $st( '30+', 'Programmes' ), $st( '1000+', 'Questions' ), $st( '7850', 'Hours taught' ) ), 'text' => 'Our Oxbridge tutors are specialists in preparing students for the rigorous demands of the Oxford and Cambridge applications.', 'list' => $li( 'Personalised 1:1 tutoring', 'Interview and exam courses', 'Course-specific work experience', 'Bespoke online courses', 'Personal statement support' ), 'button' => array( 'title' => 'Find out more', 'url' => 'https://www.oxbridgemind.co.uk' ) ),
	array( 'theme' => 'law', 'name' => 'Law Mind', 'stats' => array( $st( '200,000', 'Hours taught' ), $st( '92%', 'Success rate' ), $st( 'Top 20%', 'LNAT score' ) ), 'text' => 'Taught by experienced lawyers and law students, Law Mind is designed to help students secure their place in the competitive landscape of law.', 'list' => $li( 'Bespoke tutoring', 'Interview tutoring', 'Hands-on work experience', 'LNAT courses', 'Personal statement support' ), 'button' => array( 'title' => 'Find out more', 'url' => 'https://www.lawmind.co.uk' ) ),
) );

/* The design's brand marks, used when no logo image is uploaded. */
$marks = array(
	'medic'    => '<svg class="bmark" viewBox="0 0 40 40" aria-hidden="true"><circle cx="20" cy="20" r="18" fill="none" stroke="#fff" stroke-width="1.6"></circle><text x="20" y="27" text-anchor="middle" font-family="Montserrat,sans-serif" font-weight="800" font-size="20" fill="#fff">M</text></svg>',
	'oxbridge' => '<svg class="bmark" viewBox="0 0 40 40" aria-hidden="true"><circle cx="20" cy="20" r="18" fill="none" stroke="#fff" stroke-width="1.6"></circle><path d="M14 24.5v-6l6-3 6 3v6" fill="none" stroke="#fff" stroke-width="1.5" stroke-linejoin="round"></path><path d="M11 15.5l9-4 9 4-9 4z" fill="#fff"></path><path d="M20 19.5v3" stroke="#fff" stroke-width="1.3"></path><circle cx="20" cy="23" r="1" fill="#fff"></circle></svg>',
	'law'      => '<svg class="bmark" viewBox="0 0 40 40" aria-hidden="true"><circle cx="20" cy="20" r="18" fill="none" stroke="#fff" stroke-width="1.6"></circle><text x="20" y="27" text-anchor="middle" font-family="Montserrat,sans-serif" font-weight="800" font-size="20" fill="#fff">L</text></svg>',
);
?>
<div <?php echo sm_block_attrs( $block ); ?>>
<section class="siblings" data-lay="siblings">
  <div class="wrap">
    <h2 class="h2"><span style="color:#fff"><?php echo esc_html( $h_lead ); ?></span> <span><?php echo esc_html( $h_mark ); ?></span></h2>
    <p class="lede"><?php echo esc_html( $lede ); ?></p>
    <div class="brands">
<?php foreach ( (array) $brands as $b ) :
	$theme = sm_row( $b, 'theme', 'medic' );
	$theme = isset( $marks[ $theme ] ) ? $theme : 'medic';
	$logo  = sm_row( $b, 'logo' );
	$btn   = sm_link( sm_row( $b, 'button' ), 'Find out more', '#' );
	?>
      <article class="brand <?php echo esc_attr( $theme ); ?>">
        <div class="brand-h">
          <?php echo $logo ? '<img class="bmark" src="' . esc_url( sm_img_url( $logo, 'thumbnail' ) ) . '" alt="">' : $marks[ $theme ]; // phpcs:ignore -- static SVG. ?>
          <span><?php echo esc_html( sm_row( $b, 'name' ) ); ?></span></div>
        <div class="bstats"><?php foreach ( (array) sm_row( $b, 'stats', array() ) as $s ) : ?><div><b><?php echo esc_html( sm_row( $s, 'value' ) ); ?></b><span><?php echo esc_html( sm_row( $s, 'label' ) ); ?></span></div><?php endforeach; ?></div>
        <p><?php echo esc_html( sm_row( $b, 'text' ) ); ?></p>
        <ul class="blist"><?php foreach ( (array) sm_row( $b, 'list', array() ) as $l ) : ?><li><?php echo esc_html( sm_row( $l, 'item' ) ); ?></li><?php endforeach; ?></ul>
        <a class="btn" <?php echo sm_href( $btn ); ?>><?php echo esc_html( $btn['title'] ); ?></a>
      </article>
<?php endforeach; ?>
    </div>
  </div>
</section>
</div>
