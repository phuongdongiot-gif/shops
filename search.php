<?php
/**
 * The template for displaying search results pages
 *
 * @package shopping
 */

get_header();
?>

<main id="primary" class="site-main container mx-auto px-4 py-8">

	<?php if ( have_posts() ) : ?>

		<header class="page-header mb-8">
			<h1 class="page-title text-3xl font-bold">
				<?php
				/* translators: %s: search query. */
				printf( esc_html__( 'Search Results for: %s', 'shopping' ), '<span>' . get_search_query() . '</span>' );
				?>
			</h1>
		</header><!-- .page-header -->

		<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
			<?php
			/* Start the Loop */
			while ( have_posts() ) :
				the_post();

				get_template_part( 'template-parts/content', 'search' );

			endwhile;
			?>
		</div>

		<div class="mt-8">
			<?php
			the_posts_navigation();
			?>
		</div>

	<?php
	else :

		get_template_part( 'template-parts/content', 'none' );

	endif;
	?>

</main><!-- #main -->

<?php
get_footer();
