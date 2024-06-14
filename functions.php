<?php
/**
 * Beauty Studio functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Beauty_Studio
 */

if ( ! defined( '_S_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( '_S_VERSION', '1.0.0' );
}

define( 'BEAUTY_STUDIO_DIRECTORY', get_template_directory() );
define( 'BEAUTY_STUDIO_DIRECTORY_URI', get_template_directory_uri() );
define( 'BEAUTY_STUDIO_STYLESHEET_URI', get_stylesheet_uri() );

if (!function_exists('beauty_studio_setup')) :
    /**
     * Sets up theme defaults and registers support for various WordPress features.
     *
     * Note that this function is hooked into the after_setup_theme hook, which
     * runs before the init hook. The init hook is too late for some features, such
     * as indicating support for post thumbnails.
     */
    function beauty_studio_setup() {
        /*
            * Make theme available for translation.
            * Translations can be filed in the /languages/ directory.
            * If you're building a theme based on Beauty Studio, use a find and replace
            * to change 'beauty-studio' to the name of your theme in all the template files.
            */
        load_theme_textdomain( 'beauty-studio', BEAUTY_STUDIO_DIRECTORY . '/languages' );

        // Add default posts and comments RSS feed links to head.
        add_theme_support( 'automatic-feed-links' );

        /*
            * Let WordPress manage the document title.
            * By adding theme support, we declare that this theme does not use a
            * hard-coded <title> tag in the document head, and expect WordPress to
            * provide it for us.
            */
        add_theme_support( 'title-tag' );

        /*
            * Enable support for Post Thumbnails on posts and pages.
            *
            * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
            */
        add_theme_support( 'post-thumbnails' );
        add_image_size( 'beauty-studio-720', 720 );
        add_image_size( 'beauty-studio-360-360', 360, 360, true );
        add_image_size( 'beauty-studio-850-485', 850, 485, true );
        add_image_size( 'beauty-studio-390-280', 390, 280, true );
        add_image_size( 'beauty-studio-969-485', 969, 485, true );

        // This theme uses wp_nav_menu() in one location.
        register_nav_menus(
            array(
                'primary' => esc_html__( 'Primary', 'beauty-studio' ),
            )
        );

        /*
            * Switch default core markup for search form, comment form, and comments
            * to output valid HTML5.
            */
        add_theme_support(
            'html5',
            array(
                'search-form',
                'comment-form',
                'comment-list',
                'gallery',
                'caption',
                'style',
                'script',
            )
        );

        // Set up the WordPress core custom background feature.
        add_theme_support(
            'custom-background',
            apply_filters(
                'beauty_studio_custom_background_args',
                array(
                    'default-color' => 'ffffff',
                    'default-image' => '',
                )
            )
        );

        // Add theme support for selective refresh for widgets.
        add_theme_support( 'customize-selective-refresh-widgets' );

        /**
         * Add support for core custom logo.
         *
         * @link https://codex.wordpress.org/Theme_Logo
         */
        add_theme_support(
            'custom-logo',
            array(
                'height'      => 250,
                'width'       => 250,
                'flex-width'  => true,
                'flex-height' => true,
            )
        );
    }
endif;

add_action( 'after_setup_theme', 'beauty_studio_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function beauty_studio_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'beauty_studio_content_width', 1170 );
}
add_action( 'after_setup_theme', 'beauty_studio_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function beauty_studio_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'beauty-studio' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'beauty-studio' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h4 class="widget-title">',
			'after_title'   => '</h4>',
		)
	);

	// Footer widget areas
    $widget_areas = get_theme_mod( 'footer_widget_areas', '4' );
    for ( $i=1; $i <= $widget_areas; $i++ ) {
        register_sidebar( array(
            'name'          => __( 'Footer ', 'beauty-studio' ) . $i,
            'id'            => 'footer-' . $i,
            'description'   => '',
            'before_widget' => '<section id="%1$s" class="widget %2$s">',
            'after_widget'  => '</section>',
            'before_title'  => '<h3 class="widget-title">',
            'after_title'   => "</h3>"
        ) );
    }

//    register_widget( 'Beauty_Studio_Social' );
//    register_widget( 'Beauty_Studio_Recent_Posts' );
}
add_action( 'widgets_init', 'beauty_studio_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function beauty_studio_scripts() {
	wp_enqueue_style( 'beauty-studio-style', BEAUTY_STUDIO_STYLESHEET_URI );

	wp_enqueue_script( 'beauty-studio-navigation', BEAUTY_STUDIO_DIRECTORY_URI . '/js/navigation.js', array(), '10', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

    wp_enqueue_script( 'wp-beauty-studio-scripts', BEAUTY_STUDIO_DIRECTORY_URI . '/js/script.js', array('jquery'), '1000', true );

    wp_enqueue_style( 'beauty-studio-font-awesome', BEAUTY_STUDIO_DIRECTORY_URI . '/css/font-awesome/css/all.min.css' );

    //Deregister FontAwesome from Elementor
    wp_deregister_style( 'elementor-icons-shared-0' );

    if ( !class_exists( 'Kirki_Fonts' ) ) {
        wp_enqueue_style( 'beauty-studio-fonts', '//fonts.googleapis.com/css?family=Work+Sans:400,500,600', array(), null );
    }
}
add_action( 'wp_enqueue_scripts', 'beauty_studio_scripts' );

/**
 * Enqueue Bootstrap
 */
function beauty_studio_enqueue_bootstrap() {
    wp_enqueue_style( 'beauty-studio-bootstrap', BEAUTY_STUDIO_DIRECTORY_URI . '/css/bootstrap/bootstrap.min.css', array(), true );
}
add_action( 'wp_enqueue_scripts', 'beauty_studio_enqueue_bootstrap', 9 );

/**
 * Implement the Custom Header feature.
 */
require BEAUTY_STUDIO_DIRECTORY . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require BEAUTY_STUDIO_DIRECTORY . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require BEAUTY_STUDIO_DIRECTORY . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require BEAUTY_STUDIO_DIRECTORY . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require BEAUTY_STUDIO_DIRECTORY . '/inc/jetpack.php';
}

/**================================ PLUS FUNCTIONS ==================================*/

if (!function_exists('beauty_studio_pagination_handlers')) {
    function beauty_studio_pagination_handlers () {
        global $wp_query;
        $postPerPage = 3;
        $pageNumber = isset($_POST['page_number']) ? intval($_POST['page_number']) : 1;
        $index = 0;
        $contents = '';
        $paginationContents = '';
        $ajaxUrl = admin_url('admin-ajax.php');
        $maxPages = $wp_query->found_posts ? ceil($wp_query->found_posts / $postPerPage) : 1;
        $postIndex = intval($postPerPage * $pageNumber) + 1;
        $loopIndex = 0;
        $posts = array();
        $args = array(
            'post_type' => 'post',
            'posts_per_page' => -1,
            'numberposts' => -1
        );

        $query = new WP_Query($args);
        $posts2 = get_posts($args);

        /* Start the Loop */
        while ( $query->have_posts() ) :
            $loopIndex = $loopIndex + 1;

            if ($loopIndex < $postIndex) {
                continue;
            }

            $index++;
            ob_start();
            the_post();
            get_template_part( 'template-parts/content', get_post_type() );
            $posts[] = get_template_part( 'template-parts/content', get_post_type() );

            if ($index === $postPerPage)
            {
                break;
            }

        endwhile;

        $paginationContents .= '<div id="beauty-studio-pagination" class="beauty-studio-pagination">';
        $paginationContents .= '<input class="beauty-studio-admin-ajax-url" type="hidden" value="'. esc_url($ajaxUrl) .'" />';
        // Pagination using paginate_links
        $paginationContents .= paginate_links( array(
            'base'      => '#',
            'format'    => '?paged=%#%',
            'current'   => max( 1, $pageNumber ),
            'total'     => $maxPages,
            'mid_size'  => 2,
            'prev_text' => __( 'Back', 'beauty-studio' ),
            'next_text' => __( 'Next', 'beauty-studio' ),
        ) );
        $paginationContents .= '</div>';
        $contents .= $paginationContents;
        echo $contents;

        wp_json_encode(array('success' => true, 'response' => $contents));
        wp_die();
    }
}
add_action('wp_ajax_beauty_studio_pagination_handlers', 'beauty_studio_pagination_handlers');
add_action('wp_ajax_nopriv_beauty_studio_pagination_handlers', 'beauty_studio_pagination_handlers');

if (!function_exists('beauty_studio_show_pagination')) {
    function beauty_studio_show_pagination() {
        global $wp_query;
        $ajaxUrl             = admin_url('admin-ajax.php');
        $postPerPage         = 3;
        $maxPages            = $wp_query->found_posts ? ceil($wp_query->found_posts / $postPerPage) : 1;
        $currentPage         = isset($_POST['paged']) ? $_POST['paged'] : 1;
        $paginationContents  = '';
        $paginationContents .= '<div class="beauty-studio-pagination">';
        $paginationContents .= '<input class="beauty-studio-admin-ajax-url" type="hidden" value="' . esc_url($ajaxUrl) . '" />';
        $paginationContents .= '<input class="beauty-studio-current-page" type="hidden" value="1" />';
        // Pagination using paginate_links
        $paginationContents .= paginate_links(array(
            'base'      => '#',
            'format'    => '?paged=%#%',
            'current'   => max(2, $currentPage),
            'total'     => $maxPages,
            'mid_size'  => 2,
            'prev_text' => __('Back', 'beauty-studio'),
            'next_text' => __('Next', 'beauty-studio'),
        ));
        $paginationContents .= '</div>';

        // Retrieve pagination
        $contents  = '<div class="beauty-studio-pagination">';
        $contents .= '<input class="beauty-studio-admin-ajax-url" type="hidden" value="' . esc_url($ajaxUrl) . '" />';
        $contents .= '<input class="beauty-studio-current-page" type="hidden" value="'. $currentPage .'" />';
        $contents .= '<a class="prev page-numbers" data-page="back" href="#" style="display: none;">'. esc_html__('Back', 'beauty-studio') .'</a>';
        $contents .= '<a class="page-numbers" data-page="1" href="#">1</a>';
        $contents .= '<a class="page-numbers" data-page="2" href="#">2</a>';
        $contents .= '<a class="page-numbers" data-page="3" href="#">3</a>';
        $contents .= '<a class="page-numbers" data-page="4" href="#">4</a>';
        $contents .= '<a class="next page-numbers" data-page="next" href="#" style="display: none;">'. esc_html__('Next', 'beauty-studio') .'</a>';
        $contents .= '</div>';

        if (isset($_POST['paged'])) {
            wp_send_json(array('success' => true, 'contents' => $contents));
        } else {
            return $contents;
        }
    }
}
add_action('wp_ajax_beauty_studio_show_pagination', 'beauty_studio_show_pagination');