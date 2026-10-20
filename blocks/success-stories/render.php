<?php
/**
 * Success Stories (design T07): masonry of photo and video story cards.
 *
 * @var array $block ACF block settings.
 */

$eyebrow = sm_get( 'eyebrow', 'Success stories' );
$heading = sm_get( 'heading', 'Testimonials and success stories' );
$lede    = sm_get( 'lede', 'Study Mind is an official UK Government education partner with a 93% success rate. It is no wonder thousands of students have chosen us to ace their admissions.' );

$t     = 'Learn from students who have been there before. Our tutors have successfully gained admission to medical school.';
$c     = function ( $title, $text, $asset, $tall = false, $light = true ) {
	return array( 'title' => $title, 'text' => $text, 'asset' => $asset, 'tall' => $tall, 'light' => $light );
};
$cards = sm_get( 'cards', array(
	$c( 'Offer from University of Dundee', $t, 'story-01.png' ),
	$c( 'Excellent interview preparation', $t, 'story-02.png', true ),
	$c( 'Offer from Surrey University', $t, 'story-03.png' ),
	$c( 'Excellent interview preparation', $t, 'story-04.png', true ),
	$c( 'Offer received from Liverpool', $t, 'story-05.png' ),
	$c( 'Excellent interview preparation', $t, 'story-video-1.jpg', false, false ),
	$c( 'Offer from 3 universities', 'Edinburgh, Glasgow and Dundee, all with strong offers in hand.', 'story-06.png' ),
	$c( 'Excellent interview preparation', $t, 'story-07.png' ),
	$c( 'Received an offer from Dundee', $t, 'story-video-2.jpg', false, false ),
	$c( 'Enrolled in first week', 'Visual theory as a concept was covered. After testing many tools, I chose Study Mind.', 'story-08.png' ),
) );
?>
<div <?php echo sm_block_attrs( $block ); ?>>
<section class="stories" data-lay="stories">
  <div class="wrap">
    <p class="eyebrow"><?php echo esc_html( $eyebrow ); ?></p>
    <h2 class="h2"><span style="color:var(--ink)"><?php echo esc_html( $heading ); ?></span></h2>
    <p class="lede"><?php echo esc_html( $lede ); ?></p>
    <div class="masonry">
<?php foreach ( (array) $cards as $i => $card ) :
	$cls   = 'ph' . ( sm_row( $card, 'light', false ) ? ' light' : '' ) . ' shot' . ( sm_row( $card, 'tall', false ) ? ' tall' : '' );
	$video = sm_row( $card, 'video' );
	$title = sm_row( $card, 'title' );
	?>
      <div class="mcard"><?php if ( $video ) : ?><div style="position:relative"><?php endif; ?><?php sm_ph( $cls, sm_row( $card, 'image' ), sm_row( $card, 'asset', sprintf( 'story-%02d.png', $i + 1 ) ), $title ); ?><?php if ( $video ) : ?><a class="sm-media-link" href="<?php echo esc_url( $video ); ?>" target="_blank" rel="noopener" aria-label="<?php echo esc_attr( 'Watch: ' . $title ); ?>"></a></div><?php endif; ?><div class="body"><b><?php echo esc_html( $title ); ?></b><p><?php echo esc_html( sm_row( $card, 'text' ) ); ?></p></div></div>
<?php endforeach; ?>
    </div>
  </div>
</section>
</div>
