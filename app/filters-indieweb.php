<?php

namespace App;

/**
 * Add <body> classes, extending body_class filter from /app/filters.php
 */
add_filter('body_class', function (array $classes) {
    /** Add class if sidebar is inactive */
    if ( !is_active_sidebar( 'sidebar-primary' ) ) {
        $classes[] = 'no-sidebar';
    }

    /** Add class to sites with a custom background image */
    if ( get_background_image() ) {
        $classes[] = 'custom-background-image';
    }

    /** Add class to sites with more than 1 published author */
    if ( is_multi_author() ) {
        $classes[] = 'group-blog';
    }

    /** Add class to non-singular pages */
    if ( !is_singular() ) {
        $classes[] = 'hfeed';
        $classes[] = 'h-feed';
    } elseif ( 'page' !== get_post_type() ) {
        $classes[] = 'hentry';
        $classes[] = 'h-entry';
    }

    return array_filter($classes);
});

/**
 * Adds custom classes to the array of post classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
add_filter('post_class', function($classes) {
	$classes = array_diff( $classes, array( 'hentry' ) );
	if ( ! is_singular() ) {
		if ( 'page' !== get_post_type() ) {
			// Adds a class for microformats v2
			$classes[] = 'h-entry';
			// add hentry to the same tag as h-entry
			$classes[] = 'hentry';
		}
	}
	return $classes;
});

/**
 * Adds mf2 to avatar
 *
 * @param array $args Arguments passed to get_avatar_data(), after processing.
 * @param int|string|object $id_or_email A user ID, email address, or comment object
 * @return array $args
 */
add_filter('get_avatar_data', function($args, $id_or_email) {
	if ( ! isset( $args['class'] ) ) {
		$args['class'] = array( 'u-photo' );
	} else {
		$args['class'][] = 'u-photo';
	}
	return $args;
}, 11, 2);

/**
 * Adds custom classes to the array of comment classes.
 */
add_filter('comment_class', function($classes) {
	$classes[] = 'u-comment';
	$classes[] = 'h-cite';
	return array_unique( $classes );
}, 11);

/**
 * Wraps the_content in e-content
 */
// add_filter('the_content', function($content) {
// 	$wrap = '<div class="e-content">';
// 	if ( empty( $content ) ) {
// 		return $content;
// 	}
// 	return $wrap . $content . '</div>';
// }, 1 );

/**
 * Wraps the_excerpt in p-summary
 */
// add_filter('the_excerpt', function($content) {
// 	$wrap = '<div class="p-summary">';
// 	if ($content!="") {
// 		return $wrap . $content . '</div>';
// 	}
// 	return $content;
// }, 1);

/**
 * Add Formats dropdown to WordPress visual editor
 * http://www.wpbeginner.com/wp-tutorials/how-to-add-custom-styles-to-wordpress-visual-editor/
 */
add_filter('mce_buttons_2', function($buttons) {
    array_unshift($buttons, 'styleselect');
    return $buttons;
});

/**
 * Callback function to filter the MCE Format settings above
 */
add_filter( 'tiny_mce_before_init', function( $init_array ) {

    $style_formats = array(
        array(
            'title' => 'Lead Paragraph',
            'block' => 'p',
            'classes' => 'lead-paragraph',
            'wrapper' => false,
        ),
    );
    $init_array['style_formats'] = json_encode( $style_formats );

    return $init_array;
});
