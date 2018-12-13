<?php

namespace App;

/**
 * Add <body> classes, extending body_class filter from /app/filters.php
 */
add_filter('body_class', function (array $classes) {
    // Add class to sites with a custom background image
    if ( get_background_image() ) {
        $classes[] = 'custom-background-image';
    }

    // Add class to sites with more than 1 published author
    if ( is_multi_author() ) {
        $classes[] = 'group-blog';
    }

    // Add class if sidebar is inactive
    if ( !is_active_sidebar( 'sidebar' ) ) {
        $classes[] = 'no-sidebar';
    }

    // Add class to non-singular pages
    if ( !is_singular() ) {
        $classes[] = 'h-feed';
    } elseif ( 'page' !== get_post_type() ) {
        $classes[] = 'h-entry';
    }

    return $classes;
});

/**
 * Add a pingback url auto-discovery header for singularly identifiable articles
 */
add_action( 'wp_head', function() {
    if ( is_singular() && pings_open() ) {
        printf( '<link rel="pingback" href="%1$s">', esc_url( get_bloginfo( 'pingback_url' ) ) );
    }
});

/**
 * Add default posts and comments RSS feed links to head
 */
add_theme_support( 'automatic-feed-links' );

/**
 * Add a rel-feed if the main page is not a list of posts
 */
add_action( 'wp_head', function() {
    if ( is_front_page() && 0 !== (int) get_option( 'page_for_posts', 0 ) ) {
        printf( '<link rel="feed" type="text/html" href="%1$s" title="%2$s">' . PHP_EOL, esc_url( get_post_type_archive_link( 'post' ) ), __( 'All Posts Feed', 'sage' ) );
    }
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
			// Adds a class for microformats2
			$classes[] = 'h-entry';
		}
	}
	return $classes;
});

/**
 * Adds microformats2 to avatar photo
 *
 * @param array $args Arguments passed to get_avatar_data(), after processing.
 * @param int|string|object $id_or_email A user ID, email address, or comment object
 * @return array $args
 */
add_filter('get_avatar_data', function($args, $id_or_email) {
    if ( ! isset( $args['class'] ) ) {
        $args['class'] = array();
    }
    if ( ! in_array( 'u-featured', $args['class'] ) ) {
        $args['class'][] = 'u-photo';
    }
    return $args;
}, 11, 2);

/**
 * Wraps the_content in e-content
 */
add_filter('the_content', function($content) {
	$wrap = '<div class="e-content">';
	if ( empty( $content ) ) {
		return $content;
	}
	return $wrap . $content . '</div>';
}, 1 );

/**
 * Wraps the_excerpt in p-summary
 */
add_filter('the_excerpt', function($content) {
	$wrap = '<div class="p-summary">';
	if ($content!="") {
		return $wrap . $content . '</div>';
	}
	return $content;
}, 1);

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
            'title'   => 'Lead Paragraph',
            'block'   => 'p',
            'classes' => 'lead-paragraph',
            'wrapper' => false,
        ),
    );
    $init_array['style_formats'] = json_encode( $style_formats );

    return $init_array;
});
