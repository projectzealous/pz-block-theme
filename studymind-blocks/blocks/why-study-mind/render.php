<?php
/**
 * Why Study Mind (design T06): stats row, CTA and testimonial carousel.
 *
 * @var array $block ACF block settings.
 */

$eyebrow = sm_get( 'eyebrow', 'Why choose us' );
$h_lead  = sm_get( 'heading_lead', 'Why' );
$h_mark  = sm_get( 'heading_highlight', 'Study Mind?' );
$lede    = sm_get( 'lede', "Twenty years of teaching, thousands of hours taught and a tutor team drawn from the UK's top universities. Here is what that adds up to." );
$button  = sm_link( sm_get( 'button' ), 'Book a free consultation', '#enquire' );

$stats = sm_get( 'stats', array(
	array( 'number' => 98.9, 'decimals' => 1, 'suffix' => '%', 'label' => 'Satisfaction rate' ),
	array( 'number' => 134000, 'decimals' => 0, 'suffix' => '+', 'label' => 'Hours taught' ),
	array( 'number' => 57.3, 'decimals' => 1, 'suffix' => '%', 'label' => 'Avg. improvement' ),
	array( 'number' => 93.4, 'decimals' => 1, 'suffix' => '%', 'label' => 'University success' ),
	array( 'number' => 99, 'decimals' => 0, 'suffix' => '%', 'label' => 'Recommended' ),
) );

$body_text = 'Learn from students who have been there before. Our tutors have successfully gained admission to medical school.';
$cards     = sm_get( 'cards', array(
	array( 'style' => 'body', 'title' => 'Excellent interview preparation', 'text' => $body_text, 'video' => '#', 'asset' => 'testimonial-video-1.jpg' ),
	array( 'style' => 'quote', 'title' => '"I got into my first choice because of my incredible Study Mind tutor"', 'attribution' => 'Student', 'video' => '#', 'asset' => 'testimonial-video-2.jpg' ),
	array( 'style' => 'body', 'title' => 'Received an offer from Dundee', 'text' => $body_text, 'light' => true, 'asset' => 'whatsapp-screenshot-1.png' ),
	array( 'style' => 'body', 'title' => 'Excellent interview preparation', 'text' => $body_text, 'video' => '#', 'asset' => 'testimonial-video-3.jpg' ),
	array( 'style' => 'body', 'title' => 'Offer from Surrey University', 'text' => $body_text, 'video' => '#', 'asset' => 'testimonial-video-4.jpg' ),
) );
?>
<div <?php echo sm_block_attrs( $block ); ?>>
<section class="why" data-lay="why">
  <div class="wrap">
    <p class="eyebrow"><?php echo esc_html( $eyebrow ); ?></p>
    <h2 class="h2"><span style="color:var(--ink)"><?php echo esc_html( $h_lead ); ?></span> <span><?php echo esc_html( $h_mark ); ?></span></h2>
    <p class="lede"><?php echo esc_html( $lede ); ?></p>
    <div class="stats5">
<?php foreach ( (array) $stats as $s ) :
	$num = (float) sm_row( $s, 'number', 0 );
	$dec = (int) sm_row( $s, 'decimals', 0 );
	$suf = (string) sm_row( $s, 'suffix', '' );
	?>
      <div><b data-count="<?php echo esc_attr( $num ); ?>" data-suffix="<?php echo esc_attr( $suf ); ?>"<?php echo $dec ? ' data-dec="' . (int) $dec . '"' : ''; ?>><?php echo esc_html( number_format( $num, $dec ) . $suf ); ?></b><span><?php echo esc_html( sm_row( $s, 'label' ) ); ?></span></div>
<?php endforeach; ?>
    </div>
    <div class="head-cta"><a <?php echo sm_href( $button ); ?> class="btn btn-primary"><?php echo esc_html( $button['title'] ); ?></a></div>
  </div>

  <div class="carousel" data-lay="carousel">
    <div class="wrap" style="position:relative">
      <div class="carousel-nav">
        <button class="cbtn" id="cPrev" aria-label="Previous">‹</button>
        <button class="cbtn" id="cNext" aria-label="Next">›</button>
      </div>
    </div>
    <div class="rail" id="rail">
<?php foreach ( (array) $cards as $i => $c ) :
	$video = sm_row( $c, 'video' );
	$title = sm_row( $c, 'title' );
	?>
      <article class="tcard"><div class="media"><?php sm_ph( sm_row( $c, 'light', false ) ? 'ph light' : 'ph', sm_row( $c, 'image' ), sm_row( $c, 'asset', 'testimonial-' . ( $i + 1 ) . '.jpg' ), $title ); ?><?php echo $video ? '<span class="play"></span>' : ''; ?><?php echo ( $video && '#' !== $video ) ? '<a class="sm-media-link" href="' . esc_url( $video ) . '" target="_blank" rel="noopener" aria-label="' . esc_attr__( 'Play video', 'studymind' ) . '"></a>' : ''; ?></div>
<?php if ( 'quote' === sm_row( $c, 'style', 'body' ) ) : ?>
        <div class="quote"><span class="stars">★★★★★</span><b><?php echo esc_html( $title ); ?></b><span><?php echo esc_html( sm_row( $c, 'attribution' ) ); ?></span></div></article>
<?php else : ?>
        <div class="body"><b><?php echo esc_html( $title ); ?></b><p><?php echo esc_html( sm_row( $c, 'text' ) ); ?></p></div></article>
<?php endif; ?>
<?php endforeach; ?>
    </div>
  </div>
</section>
</div>
