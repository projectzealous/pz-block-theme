<?php
/**
 * Awards and Enquiry (design T09).
 * The enquiry form: paste a form plugin shortcode (Gravity Forms, Contact Form 7, HubSpot...)
 * in "Form shortcode" and it replaces the design's static form fields inside the same dark card.
 * Without a shortcode the design's form is shown, but it does not submit anywhere.
 *
 * @var array $block ACF block settings.
 */

$eyebrow = sm_get( 'eyebrow', 'Awards' );
$h_lead  = sm_get( 'heading_lead', 'Recognised for' );
$h_mark  = sm_get( 'heading_highlight', 'excellence in EdTech' );
$lede    = sm_get( 'lede', 'Independently rated, government backed and voted for by the students and parents we work with.' );
$awards  = sm_get( 'awards', array(
	array( 'label' => 'Official UK Government Partner', 'asset' => '/assets/brand/official-uk-govt.png' ),
	array( 'label' => 'Best Online Tuition 2024', 'asset' => '/assets/brand/trustpilot.png' ),
	array( 'label' => 'Top 5 Educational Institutions', 'asset' => '/assets/brand/trustpilot.png' ),
) );
$form_heading = sm_get( 'form_heading', 'Book a commitment-free call to see how we can help today' );
$shortcode    = sm_get( 'form_shortcode', '' );
$button_label = sm_get( 'form_button', 'Book a free consultation' );
?>
<div <?php echo sm_block_attrs( $block ); ?>>
<section class="awards" id="enquire" data-lay="awards">
  <div class="wrap awards-grid">
    <div>
      <p class="eyebrow"><?php echo esc_html( $eyebrow ); ?></p>
      <h2><?php echo esc_html( $h_lead ); ?> <span><?php echo esc_html( $h_mark ); ?></span></h2>
      <p class="lede"><?php echo esc_html( $lede ); ?></p>
      <div class="awardgrid">
<?php foreach ( (array) $awards as $a ) : ?>
        <div class="award"><?php sm_ph( 'ph light', sm_row( $a, 'image' ), sm_row( $a, 'asset', 'award.png' ), sm_row( $a, 'label' ) ); ?><b><?php echo esc_html( sm_row( $a, 'label' ) ); ?></b></div>
<?php endforeach; ?>
      </div>
    </div>

<?php if ( $shortcode ) : ?>
    <div class="form-card">
      <h3><?php echo esc_html( $form_heading ); ?></h3>
      <?php echo do_shortcode( $shortcode ); // phpcs:ignore -- form plugin output. ?>
    </div>
<?php else : ?>
    <form class="form-card" onsubmit="return false">
      <h3><?php echo esc_html( $form_heading ); ?></h3>
      <div class="field"><label>Who are you?</label>
        <select><option>Parent</option><option>Student</option><option>School</option><option>Local authority</option></select></div>
      <div class="field"><label>Your full name</label><input placeholder="e.g. Kunal Dasani" style=""></div>
      <div class="field"><label>Mobile number</label>
        <div class="phone"><select><option>UK +44</option><option>US +1</option><option>IE +353</option></select><input placeholder="Mobile number" style=""></div></div>
      <div class="field"><label>Your email address</label><input placeholder="e.g. hello@studymind.co.uk" style=""></div>
      <button class="btn btn-primary"><?php echo esc_html( $button_label ); ?></button>
    </form>
<?php endif; ?>
  </div>
</section>
</div>
