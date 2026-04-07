<?php
/**
 * Template part for displaying footer columns/widgets
 *
 * @package shopping
 */
?>
<div class="footer-widgets grid grid-cols-1 md:grid-cols-3 md:gap-8 gap-4 container mx-auto px-4 py-8">
	<div class="footer-col-1">
		<?php if ( is_active_sidebar( 'footer-1' ) ) { dynamic_sidebar( 'footer-1' ); } ?>
	</div>
	<div class="footer-col-2">
		<?php if ( is_active_sidebar( 'footer-2' ) ) { dynamic_sidebar( 'footer-2' ); } ?>
	</div>
	<div class="footer-col-3">
		<?php if ( is_active_sidebar( 'footer-3' ) ) { dynamic_sidebar( 'footer-3' ); } ?>
	</div>
</div>
