<?php
/**
 * The template for displaying archive pages
 *
 * @package shopping
 */

get_header();
?>

<main id="primary" class="site-main container mx-auto px-4 py-8">

	<?php if ( have_posts() ) : ?>

		<header class="page-header mb-8">
			<?php
			the_archive_title( '<h1 class="page-title text-3xl font-bold mb-4">', '</h1>' );
			the_archive_description( '<div class="archive-description text-gray-600">', '</div>' );
			?>
		</header><!-- .page-header -->

		<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
			<?php
			/* Start the Loop */
			while ( have_posts() ) :
				the_post();

				get_template_part( 'template-parts/content', get_post_type() );

			endwhile;
			?>
		</div>

		<div class="mt-8">
			<?php
			the_posts_navigation();
			?>
		</div>

	<?php else :

		get_template_part( 'template-parts/content', 'none' );

	endif;
	?>

</main><!-- #main -->

<?php
get_footer();
