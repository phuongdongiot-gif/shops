<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @package shopping
 */

get_header();
?>

<main id="primary" class="site-main container mx-auto px-4 py-16 text-center">

	<section class="error-404 not-found max-w-2xl mx-auto">
		<header class="page-header mb-8">
			<h1 class="page-title text-6xl font-bold text-gray-800 mb-4"><?php esc_html_e( 'Oops! That page can&rsquo;t be found.', 'shopping' ); ?></h1>
		</header><!-- .page-header -->

		<div class="page-content">
			<p class="text-xl text-gray-600 mb-8"><?php esc_html_e( 'It looks like nothing was found at this location. Maybe try one of the links below or a search?', 'shopping' ); ?></p>

			<div class="max-w-md mx-auto">
				<?php get_search_form(); ?>
			</div>

		</div><!-- .page-content -->
	</section><!-- .error-404 -->

</main><!-- #main -->

<?php
get_footer();
