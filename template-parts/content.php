<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Beauty_Studio
 */
$beauty_studio_layout        = beauty_studio_blog_layout();
$beauty_studio_read_more     = get_theme_mod('read_more_text', __('Read more', 'beauty-studio'));
$beauty_studio_hide_thumb    = get_theme_mod('index_hide_thumb');
$beauty_studio_hide_date     = get_theme_mod('index_hide_date');
$beauty_studio_hide_cats     = get_theme_mod('index_hide_cats');
$beauty_studio_hide_author   = get_theme_mod('index_hide_author');
$beauty_studio_hide_comments = get_theme_mod('index_hide_comments');
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <div class="post-inner">
        <div class="flex">
            <?php if ($beauty_studio_hide_thumb == '') : ?>
                <div class="<?php echo esc_attr($beauty_studio_layout['item_inner_cols']); ?>">
                    <?php beauty_studio_post_thumbnail(); ?>
                </div>
            <?php endif; ?>
            <div class="post-info <?php echo esc_attr($beauty_studio_layout['item_inner_cols']); ?>">
                <header class="entry-header">
                    <?php
                    if ($beauty_studio_hide_date == '') {
                        beauty_studio_posted_on();
                    }
                    the_title('<h2 class="entry-title"><a href="' . esc_url(get_permalink()) . '" rel="bookmark">', '</a></h2>');
                    if ('post' === get_post_type()) : ?>
                        <div class="entry-meta">
                            <?php
                            if ($beauty_studio_hide_cats == '') {
                                echo '<span>';
                                beauty_studio_all_categories();
                                echo '</span>';
                            }
                            if ($beauty_studio_layout['type'] != 'layout-grid' && $beauty_studio_layout['type'] != 'layout-masonry' && $beauty_studio_hide_author == '') {
                                beauty_studio_posted_by();
                            }
                            if ($beauty_studio_hide_comments == '') {
                                beauty_studio_get_comments_number();
                            }
                            ?>
                        </div><!-- .entry-meta -->
                    <?php
                    endif; ?>
                </header><!-- .entry-header -->
                <?php if ($beauty_studio_layout['type'] != 'layout-grid' && $beauty_studio_layout['type'] != 'layout-masonry') : ?>
                    <div class="entry-content"><?php the_excerpt(); ?></div><!-- .entry-content -->
                    <?php if ($beauty_studio_read_more != '') : ?>
                        <footer class="entry-footer">
                            <a class="read-more-link" href="<?php the_permalink(); ?>"><?php echo esc_html($beauty_studio_read_more); ?><span class="gt">&gt;&gt;</span></a>
                        </footer><!-- .entry-footer -->
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</article>
