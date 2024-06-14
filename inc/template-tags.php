<?php
/**
 * Custom template tags for this theme
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Beauty_Studio
 */

if ( ! function_exists( 'beauty_studio_posted_on' ) ) :
	/**
	 * Prints HTML with meta information for the current post-date/time.
	 */
	function beauty_studio_posted_on() {
        $time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
        if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
            $time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
        }

        $time_string = sprintf( $time_string,
            esc_attr( get_the_date( 'c' ) ),
            esc_html( get_the_date() ),
            esc_attr( get_the_modified_date( 'c' ) ),
            esc_html( get_the_modified_date() )
        );

        $posted_on = '<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>';

        echo '<span class="posted-on">' . $posted_on . '</span>'; // WPCS: XSS OK.
	}
endif;

if ( ! function_exists( 'beauty_studio_posted_by' ) ) :
	/**
	 * Prints HTML with meta information for the current author.
	 */
	function beauty_studio_posted_by() {
		$byline = sprintf(
			/* translators: %s: post author. */
			esc_html_x( 'by %s', 'post author', 'beauty-studio' ),
			'<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
		);

		echo '<span class="byline"> ' . $byline . '</span>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped

	}
endif;

if ( ! function_exists( 'beauty_studio_entry_footer' ) ) :
	/**
	 * Prints HTML with meta information for the categories, tags and comments.
	 */
	function beauty_studio_entry_footer() {
		// Hide category and tag text for pages.
		if ( 'post' === get_post_type() ) {
			/* translators: used between list items, there is a space after the comma */
			$categories_list = get_the_category_list( esc_html__( ', ', 'beauty-studio' ) );
			if ( $categories_list ) {
				/* translators: 1: list of categories. */
				printf( '<span class="cat-links">' . esc_html__( 'Posted in %1$s', 'beauty-studio' ) . '</span>', $categories_list ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			}

			/* translators: used between list items, there is a space after the comma */
			$tags_list = get_the_tag_list( '', esc_html_x( ', ', 'list item separator', 'beauty-studio' ) );
			if ( $tags_list ) {
				/* translators: 1: list of tags. */
				printf( '<span class="tags-links">' . esc_html__( 'Tagged %1$s', 'beauty-studio' ) . '</span>', $tags_list ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			}
		}

		if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
			echo '<span class="comments-link">';
			comments_popup_link(
				sprintf(
					wp_kses(
						/* translators: %s: post title */
						__( 'Leave a Comment<span class="screen-reader-text"> on %s</span>', 'beauty-studio' ),
						array(
							'span' => array(
								'class' => array(),
							),
						)
					),
					wp_kses_post( get_the_title() )
				)
			);
			echo '</span>';
		}

		edit_post_link(
			sprintf(
				wp_kses(
					/* translators: %s: Name of current post. Only visible to screen readers */
					__( 'Edit <span class="screen-reader-text">%s</span>', 'beauty-studio' ),
					array(
						'span' => array(
							'class' => array(),
						),
					)
				),
				wp_kses_post( get_the_title() )
			),
			'<span class="edit-link">',
			'</span>'
		);
	}
endif;

if ( ! function_exists( 'beauty_studio_post_thumbnail' ) ) :
	/**
	 * Displays an optional post thumbnail.
	 *
	 * Wraps the post thumbnail in an anchor element on index views, or a div
	 * element when on single views.
	 */
	function beauty_studio_post_thumbnail() {
        if ( post_password_required() || is_attachment() || ! has_post_thumbnail() ) {
            return;
        }
        $layout = get_theme_mod( 'blog_layout', 'layout-default' );

        if ( is_singular() ) :
            ?>

            <div class="post-thumbnail">
                <?php
                $image_size = 'beauty-studio-720';

                if ( 'layout-two-columns' == $layout )
                {
                    $image_size = 'beauty-studio-969-485';
                }
                elseif ( 'layout-list-box' == $layout )
                {
                    $image_size = 'beauty-studio-870-384';
                }
                ?>
                <?php the_post_thumbnail( $image_size ); ?>
            </div><!-- .post-thumbnail -->

        <?php else : ?>

            <a class="post-thumbnail" href="<?php the_permalink(); ?>" aria-hidden="true">
                <?php
                $image_size = 'beauty-studio-720';
                if ( 'layout-list-2' == $layout )
                {
                    $image_size = 'beauty-studio-850-485';
                }
                elseif ( 'layout-two-columns' == $layout )
                {
                    $image_size = 'beauty-studio-390-280';
                }
                elseif ( 'layout-list-box' == $layout )
                {
                    $image_size = 'beauty-studio-870-384';
                }
                the_post_thumbnail( $image_size, array(
                    'alt' => the_title_attribute( array(
                        'echo' => false,
                    ) ),
                ) );
                ?>
            </a>

        <?php endif; // End is_singular().
	}
endif;

if ( ! function_exists( 'wp_body_open' ) ) :
	/**
	 * Shim for sites older than 5.2.
	 *
	 * @link https://core.trac.wordpress.org/ticket/12563
	 */
	function wp_body_open() {
		do_action( 'wp_body_open' );
	}
endif;

/**
 * Get the first category of the post
 */
function beauty_studio_first_category() {
    $categories = get_the_category();
    if ( ! empty( $categories ) ) {
        echo '<a class="first-cat post-cat" href="' . esc_url( get_category_link( $categories[0]->term_id ) ) . '">' . esc_html( $categories[0]->name ) . '</a>';
    }
}

/**
 * Get the number of the comment
 */
function beauty_studio_get_comments_number() {
    echo '<span class="comments-number">';
    $comment_count = get_comments_number();
    if ( '1' === $comment_count ) {
        esc_html_e( '1 comment', 'beauty-studio' );
    } else {
        printf( // WPCS: XSS OK.
        /* translators: 1: comment count number, 2: title. */
            esc_html( _nx( '%1$s comment', '%1$s comments', $comment_count, 'comments title', 'beauty-studio' ) ),
            number_format_i18n( $comment_count )
        );
    }
    echo '</span>';
}

/**
 * All categories
 */
function beauty_studio_all_categories() {
    /* translators: used between list items, there is a space after the comma */
    $categories_list = get_the_category_list( ' ' );
    if ( $categories_list ) {
        echo '<span class="cat-links">' . $categories_list . '</span>';
    }
}