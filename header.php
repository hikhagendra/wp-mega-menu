<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package mega_menu
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

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e( 'Skip to content', 'mega-menu' ); ?></a>

	<header id="masthead" class="site-header">
		<div class="container">
			<nav id="site-navigation" class="main-navigation navbar navbar-expand-lg navbar-default p-0 navbar-megamenu">
				<div class="container-fluid px-0">
					<a class="navbar-brand px-2" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a>
					<?php
						wp_nav_menu(
							array(
								'theme_location' 	=> 	'menu-1',
								'container'		 	=> 	false,
								'menu_class'		=> 	'navbar-nav ms-auto mb-2 mb-lg-0',
								'menu_id'			=>	'primary-menu',
								'walker'			=>	new Walker_Nav_Primary(),
							)
						);
					?>
				</div>
			</nav><!-- #site-navigation -->
		</div><!-- .container -->
	</header><!-- #masthead -->
