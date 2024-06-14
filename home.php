<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Beauty Studio
 */

get_header();
$layout = beauty_studio_blog_layout();
?>
    <div id="primary"
         class="content-area <?php echo esc_attr($layout['type']); ?> <?php echo esc_attr($layout['cols']); ?>">
        <main id="main" class="site-main">
            <?php
            if (have_posts()) :
                if (is_home() && !is_front_page()) : ?>
                    <header><h1 class="page-title screen-reader-text"><?php single_post_title(); ?></h1></header>
                <?php
                endif;
                ?>
                <div class="blog-loop" <?php echo beauty_studio_masonry_data(); ?>>
                    <div id="beauty-studio-list" class="row">
                        <div class="grid-sizer"></div>
                        <?php
                        /* Start the Loop */
                        $index = 0;
                        while (have_posts()) :
                            $index++;

                            if ($index === 1) {
                                echo '<div id="post-section-1" class="post-section-1"></div>';
                            } elseif ($index === 4) {
                                echo '<div id="post-section-2" class="post-section-2"></div>';
                            } elseif ($index === 7) {
                                echo '<div id="post-section-3" class="post-section-3"></div>';
                            } elseif ($index === 10) {
                                echo '<div id="post-section-4" class="post-section-4"></div>';
                            } elseif ($index === 13) {
                                echo '<div id="post-section-5" class="post-section-5"></div>';
                            } else {
                                echo '';
                            }

                            the_post();
                            /*
                             * Include the Post-Type-specific template for the content.
                             * If you want to override this in a child theme, then include a file
                             * called content-___.php (where ___ is the Post Type name) and that will be used instead.
                             */
                            if ('layout-list-2' == $layout['type']) {
                                get_template_part('template-parts/content-list', '2');
                            } elseif ('layout-two-columns' == $layout['type']) {
                                get_template_part('template-parts/content-two', 'columns');
                            } else {
                                get_template_part('template-parts/content', get_post_type());
                            }

                        endwhile;

                        $pagination = beauty_studio_show_pagination();
                        echo $pagination;
                        ?>
                    </div>
                </div>
                <?php
                the_posts_navigation();
            else :
                get_template_part('template-parts/content', 'none');
            endif;
            ?>
        </main><!-- #main -->
    </div><!-- #primary -->
<?php

if ($layout['sidebar']) {
    get_sidebar();
}

get_footer();
