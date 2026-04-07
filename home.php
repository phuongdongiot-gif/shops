<?php
/**
 * The template for displaying the blog index (home)
 *
 * @package shopping
 */

get_header();
?>

<main id="primary" class="site-main container mx-auto px-4 py-8">

	<?php if ( have_posts() ) : ?>

		<header class="mb-8">
			<h1 class="text-4xl font-bold text-gray-800"><?php single_post_title(); ?></h1>
		</header>

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
			<?php the_posts_navigation(); ?>
		</div>

	<?php else :
		get_template_part( 'template-parts/content', 'none' );
	endif; ?>

</main><!-- #main -->

<?php
get_footer();
