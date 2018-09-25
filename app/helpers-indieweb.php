<?php

namespace App;

if ( ! function_exists( 'indieweb_single_author_site' ) ) :
/**
 * Prints HTML with meta information for the categories, tags.
 *
 * Create your own indieweb_single_author_site() function to override in a child theme.
 *
 */
function indieweb_single_author_site() {
    if ( ! is_multi_author() && class_exists( 'IndieWeb_Plugin' ) ) {
        $author_avatar_size = apply_filters( 'sage_author_avatar_size', 49 );
        printf(
            '<span class="byline"><span class="author vcard h-card">%1$s<span class="screen-reader-text">%2$s </span> <a class="url fn n u-url" href="%3$s">%4$s</a></span></span>',
            get_avatar( get_option( 'iw_default_author' ), $author_avatar_size ),
            _x( 'Author', 'Used before post author name.', 'sage' ),
            esc_url( get_author_posts_url( get_option( 'iw_default_author' ) ) ),
            get_the_author()
        );
    }
}
endif;

if ( ! function_exists( 'sage_entry_meta' ) ) :
/**
 * Prints HTML with meta information for the categories, tags.
 *
 * Create your own sage_entry_meta() function to override in a child theme.
 *
 */
function sage_entry_meta() {
    if ( 'post' === get_post_type() ) {
        if ( is_multi_author() && ! is_singular() ) {
            $author_avatar_size = apply_filters( 'sage_author_avatar_size', 49 );
            printf(
                '<span class="byline"><span class="author vcard h-card">%1$s<span class="screen-reader-text">%2$s </span> <a class="url fn n u-url" href="%3$s">%4$s</a></span></span>',
                get_avatar( get_the_author_meta( 'user_email' ), $author_avatar_size ),
                _x( 'Author', 'Used before post author name.', 'sage' ),
                esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
                get_the_author()
            );
        }
    }

	if ( in_array( get_post_type(), array( 'post', 'attachment' ) ) ) {
		sage_entry_date();
	}

    // Kinds links
    //if ( class_exists( 'Kind_Taxonomy' ) ) {
	// 	$kind = get_post_kind();
	// 	printf( '<div class="entry-kind">%1$s<a href="%2$s">%3$s</a></div>',
	// 		sprintf( '<span class="screen-reader-text">%s </span>', _x( 'Kind', 'Used before post kind.', 'sage' ) ),
	// 		esc_url( get_post_kind_link( $kind ) ),
	// 		get_post_kind_string( $kind )
	// 	);
	// }

    if ( 'post' === get_post_type() ) {
		sage_entry_taxonomies();
	}

    if ( function_exists( 'get_simple_location' ) && is_singular() ) {
		echo Loc_View::get_location();
	}

    if ( ! is_singular() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
		echo '<span class="comments-link">';
		comments_popup_link( sprintf( __( 'Leave a response<span class="screen-reader-text"> on %s</span>', 'sage' ), get_the_title() ) );
		echo '</span>';
	}

    if ( function_exists( 'get_syndication_links' ) ) {
		sage_syndication_links();
	}
}
endif;

/*
 * Syndication Links
 */
function sage_syndication_links() {
	$args = array(
		'text' => false,
		'icons' => true,
		'show_text_before' => false
	);
	echo get_syndication_links( get_the_ID(), $args );
}


if ( ! function_exists( 'sage_entry_date' ) ) :
/**
 * Prints HTML with date information for current post.
 *
 * Create your own sage_entry_date() function to override in a child theme.
 *
 */
function sage_entry_date() {
	$time_string = '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 32 32"><title>link</title><path fill="#ccc" d="M13.757 19.868a1.62 1.62 0 0 1-1.149-.476c-2.973-2.973-2.973-7.81 0-10.783l6-6C20.048 1.169 21.963.376 24 .376s3.951.793 5.392 2.233c2.973 2.973 2.973 7.81 0 10.783l-2.743 2.743a1.624 1.624 0 1 1-2.298-2.298l2.743-2.743a4.38 4.38 0 0 0 0-6.187c-.826-.826-1.925-1.281-3.094-1.281s-2.267.455-3.094 1.281l-6 6a4.38 4.38 0 0 0 0 6.187 1.624 1.624 0 0 1-1.149 2.774z"/><path fill="#ccc" d="M8 31.625a7.575 7.575 0 0 1-5.392-2.233c-2.973-2.973-2.973-7.81 0-10.783l2.743-2.743a1.624 1.624 0 1 1 2.298 2.298l-2.743 2.743a4.38 4.38 0 0 0 0 6.187c.826.826 1.925 1.281 3.094 1.281s2.267-.455 3.094-1.281l6-6a4.38 4.38 0 0 0 0-6.187 1.624 1.624 0 1 1 2.298-2.298c2.973 2.973 2.973 7.81 0 10.783l-6 6A7.575 7.575 0 0 1 8 31.625z"/></svg><time class="entry-date published updated dt-published dt-updated" datetime="%1$s">%2$s</time>';
	if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
		$time_string = '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 32 32"><title>link</title><path fill="#ccc" d="M13.757 19.868a1.62 1.62 0 0 1-1.149-.476c-2.973-2.973-2.973-7.81 0-10.783l6-6C20.048 1.169 21.963.376 24 .376s3.951.793 5.392 2.233c2.973 2.973 2.973 7.81 0 10.783l-2.743 2.743a1.624 1.624 0 1 1-2.298-2.298l2.743-2.743a4.38 4.38 0 0 0 0-6.187c-.826-.826-1.925-1.281-3.094-1.281s-2.267.455-3.094 1.281l-6 6a4.38 4.38 0 0 0 0 6.187 1.624 1.624 0 0 1-1.149 2.774z"/><path fill="#ccc" d="M8 31.625a7.575 7.575 0 0 1-5.392-2.233c-2.973-2.973-2.973-7.81 0-10.783l2.743-2.743a1.624 1.624 0 1 1 2.298 2.298l-2.743 2.743a4.38 4.38 0 0 0 0 6.187c.826.826 1.925 1.281 3.094 1.281s2.267-.455 3.094-1.281l6-6a4.38 4.38 0 0 0 0-6.187 1.624 1.624 0 1 1 2.298-2.298c2.973 2.973 2.973 7.81 0 10.783l-6 6A7.575 7.575 0 0 1 8 31.625z"/></svg><time class="entry-date published dt-published" datetime="%1$s">%2$s</time><time class="updated dt-updated" datetime="%3$s">%4$s</time>';
	}
    $time_string = sprintf(
        $time_string,
        esc_attr( get_the_date( DATE_W3C ) ),
        get_the_date(),
        esc_attr( get_the_modified_date( DATE_W3C ) ),
        get_the_modified_date()
    );
	printf( '<div class="posted-on"><span class="screen-reader-text">%1$s </span><a href="%2$s" rel="bookmark" class="u-url">%3$s</a></div>',
		_x( 'Posted on', 'Used before publish date.', 'sage' ),
		esc_url( get_permalink() ),
		$time_string
	);
}
endif;

if ( ! function_exists( 'sage_entry_taxonomies' ) ) :
/**
 * Prints HTML with category and tags for current post.
 *
 * Create your own sage_entry_taxonomies() function to override in a child theme.
 *
 */
function sage_entry_taxonomies() {
    // Categories links
    //  $categories_list = get_the_category_list( _x( ', ', 'Used between list items, there is a space after the comma.', 'sage' ) );
    //  if ( $categories_list ) {
    //      printf( '<span class="cat-links"><span class="screen-reader-text">%1$s </span>%2$s</span>',
    //          _x( 'Categories', 'Used before category names.', 'sage' ),
    //          $categories_list
    //      );
    // }
	if ( taxonomy_exists( 'series' ) ) {
		$series_list = get_the_term_list( get_the_ID(), 'series', '', _x( ', ', 'Used between list items, there is a space after the comma.', 'sage' ) );
		if ( $series_list ) {
			printf( '<span class="series-links"><span class="screen-reader-text">%1$s </span>%2$s</span>',
				_x( 'Series', 'Used before series names.', 'sage' ),
				$series_list
			);
		}
	}
	$tags_list = get_the_tag_list( '', _x( ', ', 'Used between list items, there is a space after the comma.', 'sage' ) );
	if ( $tags_list ) {
		printf( '<div class="tags-links">%1$s %2$s</div>',
			_x( 'Tags:', 'Used before tag names.', 'sage' ),
			$tags_list
		);
	}
}
endif;
