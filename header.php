<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package KIT_Theme
 */

$kit_theme_operating_systems = get_terms( array( 'taxonomy' => 'operating-systems' ) );
$kit_theme_site_url          = get_bloginfo( 'url' );
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
<div id="page" class="site py-5">
	<!-- Container -->
	<div class="container">
		<div class="row">
			<!-- Left side -->
			<div class="col-md-3">
				<header id="masthead" class="site-header">
					<div class="site-branding">
						<?php
						the_custom_logo();

						$kit_theme_description = get_bloginfo( 'description', 'display' );
						if ( $kit_theme_description || is_customize_preview() ) :
							?>
							<p class="kit-theme-site-description"><?php echo $kit_theme_description; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?></p>
						<?php endif; ?>
					</div><!-- .site-branding -->

					<?php if ( ! is_wp_error( $kit_theme_operating_systems ) && ! empty( $kit_theme_operating_systems ) ) { ?>
					<div id="operatingSystemsFilters" class="side-nav mt-5">
						<ul class="list-group">
							<li class="list-group-item border-0 <?php echo ( is_front_page() && ! isset( $_GET['operating_systems'] ) ) ? 'current-menu-item' : ''; ?>">
								<a href="<?php echo esc_url( $kit_theme_site_url ); ?>" data-slug=""><?php esc_html_e( 'All apps', 'kit_theme' ); ?></a>
							</li>
						<?php 
							$kit_theme_i = 0;
						foreach ( $kit_theme_operating_systems as $kit_theme_os ) {
							$kit_theme_os_url  = add_query_arg( 'operating_systems', esc_html( $kit_theme_os->slug ), $kit_theme_site_url );
							$kit_theme_active_menu_class = '';
							if ( isset( $_GET['operating_systems'] ) && esc_html( $kit_theme_os->slug ) === esc_html( $_GET['operating_systems'] ) ) {
								$kit_theme_active_menu_class = 'current-menu-item';
							}
							?>
							<li class="list-group-item border-0 <?php echo esc_html( $kit_theme_active_menu_class ); ?>">
								<a href="<?php echo esc_url( $kit_theme_os_url ); ?>" data-slug="<?php echo esc_html( $kit_theme_os->slug ); ?>"><?php echo esc_html( $kit_theme_os->name ); ?></a>
							</li>
							<?php
								$kit_theme_i++; 
						}
						?>
						</ul>
					</div>
					<?php } ?>

					<nav id="site-navigation" class="main-navigation">
						<button class="menu-toggle d-none" aria-controls="primary-menu" aria-expanded="false"><?php esc_html_e( 'Primary Menu', 'kit_theme' ); ?></button>
						<?php
						wp_nav_menu(
							array(
								'theme_location' => 'menu-1',
								'menu_id'        => 'primary-menu',
							)
						);
						?>
					</nav><!-- #site-navigation -->
				</header>
			</div>
			<!-- EOF Left side -->

			<!-- Right side -->
			<div class="col-md-9">