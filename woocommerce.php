<?php
/**
 * The template for displaying WooCommerce pages seamlessly.
 */

get_header();
?>

	<main id="primary" class="site-main flex-1 bg-white">
		<div class="container mx-auto px-6 py-12 lg:py-20 flex flex-col lg:flex-row gap-8 lg:gap-12 items-start">
			
			<!-- Goị Sidebar Shop (Left Column) -->
			<?php get_template_part( 'template-parts/sidebar-shop' ); ?>

			<!-- Main WooCommerce Content (Right Column) -->
			<div class="w-full lg:w-3/4 flex-1">
				<?php
				if ( class_exists( 'WooCommerce' ) ) {
					woocommerce_content();
				} else {
					echo '<p class="text-center text-red-500 font-semibold text-lg">WooCommerce is not installed.</p>';
				}
				?>
			</div>

		</div>
	</main><!-- #primary -->

<?php
get_footer();
