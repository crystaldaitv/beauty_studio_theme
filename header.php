<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Beauty_Studio
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<?php wp_head(); ?>
</head>

<body id="wp_beautiful_themes" <?php body_class(); ?>>
<?php wp_body_open(); ?>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'beauty-studio' ); ?></a>

	<?php $menu_layout = beauty_studio_menu_layout(); ?>
    <?php get_template_part('template-parts/menus/menu', $menu_layout['type']); ?>

    <div id="content" class="site-content">

        <?php
            if ( !is_page_template( 'page-templates/template_page-builder.php') ) {
                echo '<div class="container">';
                echo 	'<div class="row">';
            }
        ?>
