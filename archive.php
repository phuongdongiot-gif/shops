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

		<header class="page-header mb-10 border-b border-gray-100 pb-6 text-center">
			<?php
			the_archive_title( '<h1 class="page-title text-3xl md:text-4xl font-heading font-extrabold mb-4 uppercase text-dark tracking-tight">', '</h1>' );
			the_archive_description( '<div class="archive-description text-gray-500 max-w-2xl mx-auto">', '</div>' );
			?>
		</header><!-- .page-header -->

		<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
			<?php
			/* Start the Loop */
			$post_count = 0;
			while ( have_posts() ) :
				the_post();
				$post_count++;
				$is_hero = ( $post_count === 1 && ! is_paged() ); // Bài đầu tiên của trang 1 sẽ là Hero

				get_template_part( 'template-parts/content', get_post_type(), array( 'is_hero' => $is_hero ) );

			endwhile;
			?>
		</div>

		<div class="mt-12 flex justify-center">
			<?php
			the_posts_pagination( array(
				'prev_text' => '&laquo; Trước',
				'next_text' => 'Sau &raquo;',
				'class'     => 'pagination-links flex gap-2',
			) );
			?>
		</div>

	<?php else :

		get_template_part( 'template-parts/content', 'none' );

	endif;
	?>

</main><!-- #main -->

<?php
get_footer();
