<?php
/**
 * Template part for displaying phone app in template-home.php
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package KIT_Theme
 */

/* List of all apps */
$kit_theme_paged = ( get_query_var( 'page' ) ) ? get_query_var( 'page' ) : 1;
$kit_theme_args  = array(
	'post_type'  => 'phone-apps',
	'paged'      => $kit_theme_paged,
	'order'      => 'DESC',
	'orderby'    => 'ID',
);
if ( isset( $_REQUEST['operating_system'] ) && '' !== $_REQUEST['operating_system'] ) {
	$kit_theme_args['tax_query'] = array(
		array(
			'taxonomy' => 'operating-systems',
			'field'    => 'slug',
			'terms'    => wp_unslash( $_REQUEST['operating_system'] ),
		),
	);
}
$kit_theme_phone_apps = new WP_Query( $kit_theme_args );
if ( $kit_theme_phone_apps->have_posts() ) { 
	?>
<div id="phoneAppsList" class="row g-0 mb-3">
	<?php 
	while ( $kit_theme_phone_apps->have_posts() ) :
		$kit_theme_phone_apps->the_post();
		get_template_part( 'template-parts/content', 'phone-app' );
	endwhile;

	/* pagination */
	$kit_theme_big                 = 999999999; // need an unlikely integer.
	$kit_theme_paginate_links_args = array(
		'base'      => str_replace( 
			$kit_theme_big, 
			'%#%', 
			esc_url( get_pagenum_link( $kit_theme_big ) )
		),
		'format'    => '?paged=%#%',
		'current'   => max( 1, $kit_theme_paged ),
		'total'     => $kit_theme_phone_apps->max_num_pages,
	);
	echo paginate_links( $kit_theme_paginate_links_args );
	/* EOF pagination */

	wp_reset_postdata();
	?>
</div>
<?php } /* EOF List of all apps */ else { ?>
	<div class="alert alert-warning" role="alert">
		<?php esc_html_e( 'Phone Apps Not Found', 'kit_theme' ); ?>
	</div>
	<?php 
} 
