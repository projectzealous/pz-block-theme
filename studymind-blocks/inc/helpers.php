<?php
/**
 * Small helpers shared by the block templates.
 *
 * Every field falls back to the design's own copy when it is empty, so a block
 * dropped onto a page looks exactly like the design before anyone edits it.
 */

defined( 'ABSPATH' ) || exit;

/**
 * Get an ACF field, or the design default when the field is empty.
 *
 * @param string     $name    Field name.
 * @param mixed      $default Design default.
 * @param int|string $post_id ACF post id ('option' for the options page).
 */
function sm_get( $name, $default = null, $post_id = false ) {
	$value = function_exists( 'get_field' ) ? get_field( $name, $post_id ) : null;
	if ( null === $value || '' === $value || false === $value || array() === $value ) {
		return $default;
	}
	return $value;
}

/** Read a value from a repeater row, with a default. */
function sm_row( $row, $key, $default = '' ) {
	if ( ! is_array( $row ) || ! isset( $row[ $key ] ) || '' === $row[ $key ] || null === $row[ $key ] || false === $row[ $key ] || array() === $row[ $key ] ) {
		return $default;
	}
	return $row[ $key ];
}

/** Image URL from an ACF image array, attachment id or plain URL. */
function sm_img_url( $img, $size = 'large' ) {
	if ( is_array( $img ) ) {
		if ( ! empty( $img['sizes'][ $size ] ) ) {
			return $img['sizes'][ $size ];
		}
		return isset( $img['url'] ) ? $img['url'] : '';
	}
	if ( is_numeric( $img ) ) {
		$url = wp_get_attachment_image_url( (int) $img, $size );
		return $url ? $url : '';
	}
	return is_string( $img ) ? $img : '';
}

/** Alt text for an ACF image array, falling back to the given text. */
function sm_img_alt( $img, $fallback = '' ) {
	if ( is_array( $img ) && ! empty( $img['alt'] ) ) {
		return $img['alt'];
	}
	return $fallback;
}

/** URL of a bundled asset, e.g. sm_asset( 'img/placeholder.svg' ). */
function sm_asset( $path ) {
	return SM_BLOCKS_URL . 'assets/' . ltrim( $path, '/' );
}

/**
 * The design's image placeholder box (.ph). With an image it holds a real <img>;
 * without one it renders the labelled placeholder exactly as designed.
 *
 * @param string $classes     Classes from the design, e.g. 'ph light shot tall'.
 * @param mixed  $img         ACF image, id or URL. Empty for the placeholder.
 * @param string $asset_label The design's data-asset label for the placeholder.
 * @param string $alt         Fallback alt text.
 */
function sm_ph( $classes, $img, $asset_label, $alt = '' ) {
	$url = sm_img_url( $img );
	if ( $url ) {
		printf(
			'<div class="%1$s has-img"><img src="%2$s" alt="%3$s" loading="lazy" decoding="async"></div>',
			esc_attr( $classes ),
			esc_url( $url ),
			esc_attr( sm_img_alt( $img, $alt ) )
		);
		return;
	}
	printf( '<div class="%1$s" data-asset="%2$s"></div>', esc_attr( $classes ), esc_attr( $asset_label ) );
}

/** Normalise an ACF link field (array) or plain URL into url/title/target. */
function sm_link( $link, $default_title = '', $default_url = '#' ) {
	if ( is_array( $link ) ) {
		return array(
			'url'    => ! empty( $link['url'] ) ? $link['url'] : $default_url,
			'title'  => ! empty( $link['title'] ) ? $link['title'] : $default_title,
			'target' => ! empty( $link['target'] ) ? $link['target'] : '',
		);
	}
	return array(
		'url'    => $link ? (string) $link : $default_url,
		'title'  => $default_title,
		'target' => '',
	);
}

/** href (and target/rel when set) attributes for a link. */
function sm_href( $link ) {
	$out = 'href="' . esc_url( $link['url'] ) . '"';
	if ( ! empty( $link['target'] ) ) {
		$out .= ' target="' . esc_attr( $link['target'] ) . '"';
		if ( '_blank' === $link['target'] ) {
			$out .= ' rel="noopener"';
		}
	}
	return $out;
}

/** Optional anchor id and extra classes set in the editor's Advanced panel. */
function sm_block_attrs( $block, $scope = 'sm-home' ) {
	$classes = array( $scope );
	if ( ! empty( $block['className'] ) ) {
		$classes[] = $block['className'];
	}
	$out = 'class="' . esc_attr( implode( ' ', $classes ) ) . '"';
	if ( ! empty( $block['anchor'] ) ) {
		$out .= ' id="' . esc_attr( $block['anchor'] ) . '"';
	}
	return $out;
}
