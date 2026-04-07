<?php
/**
 * The template for the sidebar containing the main widget area
 *
 * @package shopping
 */

if ( ! is_active_sidebar( 'sidebar-1' ) ) {
	return;
}
?>

<aside id="secondary" class="widget-area p-6 bg-gray-50 rounded-lg">
	<?php dynamic_sidebar( 'sidebar-1' ); ?>
</aside><!-- #secondary -->
