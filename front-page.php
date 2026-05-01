<?php
/**
 * Template Name: Homepage
 */

get_header();
?>

<main id="primary" class="site-main flex-1">

	<!-- Swiper CSS & JS via CDN (Deferred to improve page load speed) -->
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" media="print" onload="this.media='all'" />
	<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js" defer></script>

	<!-- Product Categories Carousel -->
	<?php get_template_part('template-parts/home/category-carousel'); ?>

	<!-- Brand Products Carousel (2 hàng) -->
	<?php get_template_part('template-parts/home/brand-products-carousel'); ?>

	<!-- Content Wrapper with Sidebar -->
	<div class="container mx-auto px-6 py-12 lg:py-16 flex flex-col lg:flex-row gap-10 items-start">

		<!-- Left Sidebar -->
		<?php get_template_part('template-parts/home/sidebar'); ?>

		<!-- Main Content Right -->
		<div class="w-full lg:w-3/4 flex flex-col gap-12">

			<!-- Hero Section Slider -->
			<?php get_template_part('template-parts/home/hero'); ?>
			<!-- Hero End -->



				<!-- Featured Products Section -->
				<!-- Featured Products Section -->
				<?php if (class_exists('WooCommerce')): ?>
					<?php get_template_part('template-parts/home/featured-categories'); ?>
				<?php endif; ?>


				<!-- Testimonials & Brands Section -->
				<?php get_template_part('template-parts/home/testimonials'); ?>

				<!-- Categories / Benefits Section -->
				<?php get_template_part('template-parts/home/benefits'); ?>

				<!-- Latest News Section -->
				<?php get_template_part('template-parts/home/latest-news'); ?>

		</div><!-- End Main Content -->
	</div><!-- End Content Wrapper -->

</main><!-- #primary -->

<?php
get_footer();
