<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package Beauty_Studio
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function beauty_studio_body_classes( $classes ) {
	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	// Adds a class of no-sidebar when there is no sidebar present.
	if ( ! is_active_sidebar( 'sidebar-1' ) ) {
		$classes[] = 'no-sidebar';
	}

	return $classes;
}
add_filter( 'body_class', 'beauty_studio_body_classes' );

/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 */
function beauty_studio_pingback_header() {
	if ( is_singular() && pings_open() ) {
		printf( '<link rel="pingback" href="%s">', esc_url( get_bloginfo( 'pingback_url' ) ) );
	}
}
add_action( 'wp_head', 'beauty_studio_pingback_header' );

/**
 * Blog layout
 */
if ( !function_exists( 'beauty_studio_blog_layout' ) ) {
    function beauty_studio_blog_layout() {

        $layout = get_theme_mod( 'blog_layout', 'layout-default' );

        //Blog archive columns
        if ( $layout == 'layout-grid' || $layout == 'layout-masonry' ) {
            $cols 		= 'col-md-12';
            $sidebar	= false;
        }
        elseif ( $layout == 'layout-list-2' || $layout == 'layout-two-columns' )
        {
            $cols 		= 'col-lg-9';
            $sidebar 	= true;
        }
        else {
            $cols 		= 'col-lg-8';
            $sidebar 	= true;
        }

        //Inner columns for list layout
        if ( $layout == 'layout-list' ) {
            $item_inner_cols = 'col-md-6 col-sm-12';
        }
        elseif ( $layout == 'layout-list-2' )
        {
            $item_inner_cols = '';
        }
        else {
            $item_inner_cols = 'col-md-12';
        }

        $setup = array(
            'type'				=> $layout,
            'sidebar' 			=> $sidebar,
            'cols'	  			=> $cols,
            'item_inner_cols' 	=> $item_inner_cols
        );

        return $setup;

    }
}

/**
 * Masonry data
 */
function beauty_studio_masonry_data() {

    $layout = beauty_studio_blog_layout();

    if ( $layout['type'] == 'layout-masonry' ) {
        return 'data-masonry=\'{ "itemSelector": ".hentry", "columnWidth": ".grid-sizer", "percentPosition": "true"}\'';
    }
}

/**
 * Menu layouts
 */
function beauty_studio_menu_layout() {
    // Type
    $type      = get_theme_mod( 'menu_type', 'menuStyle2' );
    // Contained or stretched
    $contained = get_theme_mod( 'menu_container', 'menuNotContained' );

    $layout    = array(
        'type'      => $type,
        'contained' => $contained
    );

    return $layout;
}

/**
 * Menu container
 */
function beauty_studio_menu_container() {
    $layout = beauty_studio_menu_layout();

    if ( 'menuNotContained' === $layout['contained'] ) {
        $container = 'container-fluid';
    } else {
        $container = 'container';
    }

    return $container;
}

/**
 * Site branding
 */
if ( !function_exists( 'beauty_studio_site_branding' ) ) {
    function beauty_studio_site_branding() {
        if ( has_custom_logo() ) :
            the_custom_logo();
        else :
            if ( is_front_page() && is_home() ) : ?>
                <h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
            <?php else : ?>
                <p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
            <?php
            endif;

            $description = get_bloginfo( 'description', 'display' );
            if ( $description || is_customize_preview() ) : ?>
                <p class="site-description"><?php echo $description; /* WPCS: xss ok. */ ?></p>
            <?php
            endif;
        endif;
    }
}

if ( ! function_exists( 'beauty_studio_header_cart_search' ) ) {
    /**
     * Display Header cart and search icon.
     *
     */
    function beauty_studio_header_cart_search() {

        $disable_search = get_theme_mod( 'disable_header_search' );
        ?>
        <?php if ( !$disable_search ) : ?>
            <div class="header-search-wrapper d-none d-xl-flex">
                <div class="header-search-form">
                    <?php get_search_form(); ?>
                </div>
                <div class="header-search">
                    <div class="header-search-toggle"><a><i class="fas fa-search"></i></a></div>
                </div>
            </div>
        <?php endif; ?> <?php
    }
}

/**
 * Footer credits
 */
function beauty_studio_footer_credits() {

    $credits = get_theme_mod( 'footer_credits' );
    ?>

    <div class="site-info col-md-12">

        <?php if ( $credits == '' ) : ?>
            <a href="<?php echo esc_url( __( 'https://wordpress.org/', 'beauty-studio' ) ); ?>"><?php
                /* translators: %s: CMS name, i.e. WordPress. */
                printf( esc_html__( 'Proudly powered by %s', 'beauty-studio' ), 'WordPress' );
                ?></a>
            <span class="sep"> | </span>
            <?php
            /* translators: 1: Theme name, 2: Theme author. */
            printf( esc_html__( 'Theme: %2$s by %1$s.', 'beauty-studio' ), 'Richard Dai', '<a href="" rel="nofollow">WP Beauty Studio</a>' );
            ?>
        <?php else : ?>
            <?php echo wp_kses_post( $credits ); ?>
        <?php endif; ?>
    </div><!-- .site-info -->

    <?php
}
add_action( 'beauty_studio_footer', 'beauty_studio_footer_credits' );

/**
 * Single post layout
 */
if ( !function_exists( 'beauty_studio_single_layout' ) ) {
    function beauty_studio_single_layout() {

        $layout = get_theme_mod( 'single_post_layout', 'layout-default' );

        //Single post columns
        if ( $layout == 'layout-default' ) {
            $cols 		= 'col-lg-8';
            $sidebar	= true;
        } else {
            $cols 		= 'col-md-12';
            $sidebar 	= false;
        }

        $setup = array(
            'type'		=> $layout,
            'sidebar' 	=> $sidebar,
            'cols'	  	=> $cols,
        );

        return $setup;

    }
}