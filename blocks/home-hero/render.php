<?php
/**
 * Homepage Hero (design H01).
 * Markup copied from the design; text and images swapped for fields.
 *
 * @var array $block ACF block settings.
 */

$video      = sm_get( 'background_video' );
$poster     = sm_get( 'video_poster' );
$heading    = sm_get( 'heading', 'Personalised education support for every student' );
$tag_before = sm_get( 'tagline_before', 'Your' );
$tag_mark   = sm_get( 'tagline_highlight', 'complete education toolkit' );
$tag_after  = sm_get( 'tagline_after', ', from ages 11 to 18' );

$services = sm_get( 'services', array(
	array( 'link' => array( 'title' => 'Summer Career Camps', 'url' => '#' ) ),
	array( 'link' => array( 'title' => '1:1 Tutoring', 'url' => '#' ) ),
	array( 'link' => array( 'title' => 'Online Courses', 'url' => '#' ) ),
	array( 'link' => array( 'title' => 'Alternative Provision', 'url' => '#' ) ),
	array( 'link' => array( 'title' => 'Free Resources', 'url' => '#' ) ),
) );

$tab_search  = sm_get( 'tab_search_label', 'Search our services' );
$tab_quiz    = sm_get( 'tab_quiz_label', 'Find your perfect product' );
$placeholder = sm_get( 'search_placeholder', 'Search a subject, exam or goal. Try "UCAT" or "11+"' );
$foot_link   = sm_link( sm_get( 'finder_link' ), 'Or view all services →', '#products' );

$gov_img  = sm_get( 'gov_badge_image' );
$gov_text = sm_get( 'gov_badge_text', 'Official UK Government Partner' );
$avatars  = sm_get( 'proof_avatars', array() );
$proof    = sm_get( 'proof_text', 'Trusted by 12,000+ students' );

/* Finder data (search suggestions and quiz). Defaults are starter content: replace with real products. */
$products = sm_get( 'finder_products', require __DIR__ . '/default-products.php' );
$quiz     = sm_get( 'quiz_questions', require __DIR__ . '/default-quiz.php' );

$finder = array(
	'products' => array(),
	'quiz'     => array(),
	'labels'   => array(
		'pick'     => sm_get( 'result_tagline', 'Our pick for you' ),
		'button'   => sm_get( 'result_button', 'Find out more' ),
		'restart'  => sm_get( 'restart_label', 'Start again' ),
		'back'     => '← Back',
		'of'       => 'Question %1$s of %2$s',
		'noResult' => 'No exact match. View all services',
	),
	'allUrl'    => $foot_link['url'],
	'searchUrl' => home_url( '/?s=' ),
);
foreach ( (array) $products as $p ) {
	$pl                   = sm_link( sm_row( $p, 'link' ), '', '#' );
	$finder['products'][] = array(
		'title'    => sm_row( $p, 'title' ),
		'desc'     => sm_row( $p, 'description' ),
		'kind'     => sm_row( $p, 'kind' ),
		'url'      => $pl['url'],
		'keywords' => sm_row( $p, 'keywords' ),
		'tags'     => array_values( array_filter( array_map( 'trim', explode( ',', (string) sm_row( $p, 'tags' ) ) ) ) ),
	);
}
foreach ( (array) $quiz as $q ) {
	$opts = array();
	foreach ( (array) sm_row( $q, 'options', array() ) as $o ) {
		$opts[] = array( 'label' => sm_row( $o, 'label' ), 'tag' => trim( (string) sm_row( $o, 'tag' ) ) );
	}
	$finder['quiz'][] = array( 'q' => sm_row( $q, 'question' ), 'options' => $opts );
}
$first  = isset( $finder['quiz'][0] ) ? $finder['quiz'][0] : array( 'q' => '', 'options' => array() );
$qcount = count( $finder['quiz'] );

$poster_url = sm_img_url( $poster, 'full' ) ?: sm_asset( 'img/placeholder.svg' );
$video_url  = is_array( $video ) ? ( isset( $video['url'] ) ? $video['url'] : '' ) : (string) $video;
?>
<div <?php echo sm_block_attrs( $block ); ?>>
<section class="hero" data-lay="hero">
  <video class="hero-video" muted="" loop="" playsinline="" preload="metadata" aria-hidden="true" poster="<?php echo esc_url( $poster_url ); ?>"<?php echo $video_url ? ' autoplay=""' : ''; ?>>
    <?php if ( $video_url ) : ?><source src="<?php echo esc_url( $video_url ); ?>" type="video/mp4"><?php endif; ?>
  </video>
  <div class="hero-bg"></div>
    <span class="hero-blob a"></span><span class="hero-blob b"></span>
  <div class="hero-scrim"></div>
  <div class="wrap hero-in centred">
    <h1><?php echo esc_html( $heading ); ?></h1>
    <p class="hero-tagline"><span><?php echo esc_html( $tag_before ); ?></span> <mark><?php echo esc_html( $tag_mark ); ?></mark><span><?php echo esc_html( $tag_after ); ?></span></p>

    <nav class="servicerail" aria-label="Our services">
<?php foreach ( (array) $services as $s ) : $sl = sm_link( sm_row( $s, 'link' ) ); ?>
      <a <?php echo sm_href( $sl ); ?>><?php echo esc_html( $sl['title'] ); ?></a>
<?php endforeach; ?>
    </nav>

    <!-- PRODUCT FINDER -->
    <div class="finder" id="finder">
      <div class="finder-tabs" role="tablist">
        <button role="tab" aria-selected="true" id="tabSearch"><?php echo esc_html( $tab_search ); ?></button>
        <button role="tab" aria-selected="false" id="tabQuiz"><?php echo esc_html( $tab_quiz ); ?></button>
      </div>

      <div id="paneSearch">
        <div class="searchbox">
          <input id="fq" type="search" placeholder="<?php echo esc_attr( $placeholder ); ?>" autocomplete="off" aria-label="Search Study Mind products" style="">
          <button class="go" id="fgo" aria-label="Search">→</button>
        </div>
        <ul class="suggest" id="fsug"></ul>
      </div>

      <div id="paneQuiz" hidden="">
        <div class="quiz-prog"><i id="qbar" style="width: 0%;"></i></div>
        <div id="qsteps"><div class="qstep on"><b><?php echo esc_html( $first['q'] ); ?></b><div class="qopts"><?php foreach ( $first['options'] as $o ) : ?><button data-tag="<?php echo esc_attr( $o['tag'] ); ?>"><?php echo esc_html( $o['label'] ); ?></button><?php endforeach; ?></div><div class="qnav"><span></span><span><?php echo esc_html( sprintf( $finder['labels']['of'], 1, $qcount ) ); ?></span></div></div></div>
        <div class="result" id="qresult"></div>
      </div>

      <div class="finder-foot"><a <?php echo sm_href( $foot_link ); ?>><?php echo esc_html( $foot_link['title'] ); ?></a></div>
      <script type="application/json" class="sm-finder-data"><?php echo wp_json_encode( $finder, JSON_HEX_TAG | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE ); ?></script>
    </div>

    <div class="herofoot">
      <div class="govbadge">
      <img src="<?php echo esc_url( sm_img_url( $gov_img, 'medium' ) ?: sm_asset( 'img/dfe-badge-white.png' ) ); ?>" alt="<?php echo esc_attr( sm_img_alt( $gov_img, 'Department for Education' ) ); ?>">
      <span><?php echo esc_html( $gov_text ); ?></span>
    </div>
      <i class="hf-div"></i>
      <div class="proof">
      <span class="avis"><?php
	if ( $avatars ) {
		foreach ( array_slice( (array) $avatars, 0, 5 ) as $a ) {
			echo '<img src="' . esc_url( sm_img_url( $a, 'thumbnail' ) ) . '" alt="">';
		}
	} else {
		echo str_repeat( '<img src="' . esc_url( sm_asset( 'img/placeholder.svg' ) ) . '" alt="">', 5 );
	}
	?></span>
      <span class="stars">★★★★★</span>
      <span><?php echo esc_html( $proof ); ?></span>
    </div>
    </div>
  </div>
</section>
</div>
