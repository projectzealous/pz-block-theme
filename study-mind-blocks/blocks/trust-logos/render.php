<?php
/**
 * Trust Logos (design T08): row of partner logos.
 *
 * @var array $block ACF block settings.
 */

$heading = sm_get( 'heading', 'Trusted by schools, councils and universities' );
$logos   = sm_get( 'logos', array() );
?>
<div <?php echo sm_block_attrs( $block ); ?>>
<section class="trust" data-lay="trust">
  <div class="wrap">
    <div class="trust-rail-h"><i></i><span><?php echo esc_html( $heading ); ?></span><i></i></div>
    <div class="logos">
<?php
if ( $logos ) {
	foreach ( (array) $logos as $logo ) {
		echo '      ';
		sm_ph( 'ph light', $logo, '', sm_img_alt( $logo ) );
		echo "\n";
	}
} else {
	for ( $i = 1; $i <= 7; $i++ ) {
		echo '      <div class="ph light" data-asset="logo-' . (int) $i . '.png"></div>' . "\n";
	}
}
?>
    </div>
  </div>
</section>
</div>
