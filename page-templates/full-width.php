<?php
/**
 * Template Name: Full Width Page
 *
 * @package shopping
 */

get_header();
?>

<main id="primary" class="site-main w-full py-8">

	<?php
	while ( have_posts() ) :
		the_post();

		get_template_part( 'template-parts/content', 'page' );

		if ( comments_open() || get_comments_number() ) :
			comments_template();
		endif;

	endwhile;
	?>

</main><!-- #main -->

<?php
get_footer();
