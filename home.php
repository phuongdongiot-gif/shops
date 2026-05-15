<?php
/**
 * The template for displaying the blog index (home)
 *
 * @package shopping
 */

get_header();
?>

<main id="primary" class="site-main container mx-auto px-4 py-6 md:py-12">

	<?php if ( have_posts() ) : ?>

		<header class="mb-8 md:mb-10 text-center">
			<h1 class="text-xl md:text-3xl font-bold text-gray-900 mb-3"><?php single_post_title(); ?></h1>
			<div class="w-16 md:w-24 h-1 bg-yellow-400 mx-auto rounded-full"></div>
		</header>

		<div class="flex flex-col lg:flex-row gap-8">
			<!-- Cột Danh Mục Bên Trái -->
			<aside class="w-full lg:w-1/4 order-2 lg:order-1">
				<div class="sticky top-28 bg-white border border-gray-100 shadow-sm rounded-xl p-5">
					<h3 class="text-lg font-bold mb-4 uppercase tracking-wide border-b border-gray-100 pb-3 flex items-center gap-2 text-gray-800">
						<svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"></path></svg>
						Danh mục tin tức
					</h3>
					<ul class="space-y-2">
						<?php
						$cats = get_categories(array('hide_empty' => true));
						foreach ($cats as $cat) {
							echo '<li><a href="'.esc_url(get_category_link($cat->term_id)).'" class="text-gray-600 hover:text-primary transition-colors flex justify-between items-center text-sm py-1.5 font-medium group"><span class="group-hover:translate-x-1 transition-transform">'.esc_html($cat->name).'</span> <span class="bg-gray-50 text-gray-400 text-xs px-2 py-0.5 rounded-md border border-gray-100">'.esc_html($cat->count).'</span></a></li>';
						}
						?>
					</ul>
				</div>
			</aside>

			<!-- Cột Nội Dung Bên Phải -->
			<div class="w-full lg:w-3/4 order-1 lg:order-2">
				<!-- Top Carousel (Latest Posts) -->
		<?php
		$carousel_args = array(
			'posts_per_page'      => 5,
			'ignore_sticky_posts' => 1,
			'orderby'             => 'date',
			'order'               => 'DESC',
		);
		$carousel_query = new WP_Query( $carousel_args );
		
		if ( $carousel_query->have_posts() ) :
		?>
			<div class="relative w-full mb-12 md:mb-16 overflow-hidden rounded-2xl md:rounded-3xl shadow-lg group bg-gray-900" id="news-carousel">
				<div class="flex transition-transform duration-700 ease-out h-[350px] md:h-[500px]" id="news-carousel-inner">
					<?php while ( $carousel_query->have_posts() ) : $carousel_query->the_post(); ?>
						<div class="w-full shrink-0 relative">
							<?php if ( has_post_thumbnail() ) : ?>
								<?php the_post_thumbnail( 'full', array( 'class' => 'w-full h-full object-cover opacity-80 mix-blend-overlay' ) ); ?>
							<?php else : ?>
								<div class="w-full h-full bg-gray-800"></div>
							<?php endif; ?>
							<div class="absolute inset-0 bg-gradient-to-t from-gray-900 via-gray-900/50 md:via-gray-900/40 to-transparent flex flex-col justify-end p-6 md:p-14">
								<?php
								$cats = get_the_category();
								if ( $cats ) {
									echo '<a href="' . esc_url( get_category_link( $cats[0]->term_id ) ) . '" class="bg-yellow-400 text-gray-900 text-[10px] md:text-xs font-bold uppercase px-2.5 py-1 md:px-3 md:py-1.5 rounded-md w-max mb-3 inline-block hover:bg-yellow-500 transition-colors">' . esc_html( $cats[0]->name ) . '</a>';
								}
								?>
								<a href="<?php the_permalink(); ?>" class="block max-w-4xl">
									<h2 class="text-xl md:text-3xl font-extrabold text-white mb-3 hover:text-yellow-400 transition-colors line-clamp-3 md:line-clamp-2 leading-snug md:leading-tight"><?php the_title(); ?></h2>
								</a>
								<div class="text-gray-300 line-clamp-2 hidden md:block max-w-3xl mb-6 text-lg">
									<?php echo wp_trim_words( wp_strip_all_tags( get_the_excerpt() ), 25, '...' ); ?>
								</div>
								<div class="text-gray-400 text-xs md:text-sm flex items-center gap-3 md:gap-4 font-medium uppercase tracking-wider">
									<span class="flex items-center gap-1 md:gap-1.5">
										<svg class="w-3.5 h-3.5 md:w-4 md:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
										<?php echo get_the_date(); ?>
									</span>
									<span class="flex items-center gap-1 md:gap-1.5">
										<svg class="w-3.5 h-3.5 md:w-4 md:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
										<?php the_author(); ?>
									</span>
								</div>
							</div>
						</div>
					<?php endwhile; wp_reset_postdata(); ?>
				</div>

				<!-- Controls -->
				<button id="carousel-prev" aria-label="Previous Slide" class="hidden md:flex absolute top-1/2 left-6 -translate-y-1/2 w-12 h-12 bg-white/20 backdrop-blur-md rounded-full items-center justify-center text-white hover:bg-white hover:text-gray-900 transition-all opacity-0 group-hover:opacity-100 disabled:opacity-50 disabled:cursor-not-allowed">
					<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
				</button>
				<button id="carousel-next" aria-label="Next Slide" class="hidden md:flex absolute top-1/2 right-6 -translate-y-1/2 w-12 h-12 bg-white/20 backdrop-blur-md rounded-full items-center justify-center text-white hover:bg-white hover:text-gray-900 transition-all opacity-0 group-hover:opacity-100 disabled:opacity-50 disabled:cursor-not-allowed">
					<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
				</button>
				
				<!-- Indicators -->
				<div class="absolute bottom-4 md:bottom-6 left-1/2 -translate-x-1/2 flex gap-1.5 md:gap-2" id="carousel-indicators">
					<?php for($i = 0; $i < $carousel_query->post_count; $i++) { ?>
						<button aria-label="Go to slide <?php echo $i; ?>" class="w-2 h-2 md:w-2.5 md:h-2.5 rounded-full bg-white/40 hover:bg-white transition-all duration-300" data-index="<?php echo $i; ?>"></button>
					<?php } ?>
				</div>
			</div>

			<script>
				document.addEventListener('DOMContentLoaded', function() {
					const inner = document.getElementById('news-carousel-inner');
					const prev = document.getElementById('carousel-prev');
					const next = document.getElementById('carousel-next');
					const indicators = document.querySelectorAll('#carousel-indicators button');
					let currentIndex = 0;
					const total = inner.children.length;
					let interval;

					function updateIndicators() {
						indicators.forEach((btn, idx) => {
							if(idx === currentIndex) {
								btn.classList.remove('bg-white/40');
								btn.classList.add('bg-white', 'w-4', 'md:w-6');
							} else {
								btn.classList.add('bg-white/40');
								btn.classList.remove('bg-white', 'w-4', 'md:w-6');
							}
						});
					}

					function showSlide(index) {
						if (index < 0) index = total - 1;
						if (index >= total) index = 0;
						currentIndex = index;
						inner.style.transform = `translateX(-${currentIndex * 100}%)`;
						updateIndicators();
					}

					if(prev && next) {
						prev.addEventListener('click', () => { showSlide(currentIndex - 1); resetInterval(); });
						next.addEventListener('click', () => { showSlide(currentIndex + 1); resetInterval(); });
					}
					
					indicators.forEach(btn => {
						btn.addEventListener('click', (e) => {
							showSlide(parseInt(e.target.dataset.index));
							resetInterval();
						});
					});

					// Swipe support for mobile
					let startX = 0;
					let endX = 0;
					inner.addEventListener('touchstart', e => {
						startX = e.changedTouches[0].screenX;
					}, {passive: true});

					inner.addEventListener('touchend', e => {
						endX = e.changedTouches[0].screenX;
						if (startX - endX > 50) {
							showSlide(currentIndex + 1);
							resetInterval();
						} else if (endX - startX > 50) {
							showSlide(currentIndex - 1);
							resetInterval();
						}
					}, {passive: true});

					function startInterval() {
						interval = setInterval(() => { showSlide(currentIndex + 1); }, 5000);
					}
					function resetInterval() {
						clearInterval(interval);
						startInterval();
					}
					
					updateIndicators();
					startInterval();
				});
			</script>
		<?php endif; ?>

		<!-- Category Sections -->
		<?php
		$categories = get_categories( array(
			'orderby'    => 'name',
			'order'      => 'ASC',
			'hide_empty' => true
		) );

		foreach ( $categories as $category ) :
			$cat_args = array(
				'cat'                 => $category->term_id,
				'posts_per_page'      => 3, // Show 3 posts per category for a clean row
				'ignore_sticky_posts' => 1,
				'orderby'             => 'date',
				'order'               => 'DESC',
			);
			$cat_query = new WP_Query( $cat_args );

			if ( $cat_query->have_posts() ) :
		?>
				<section class="mb-12 md:mb-16">
					<div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 border-b border-gray-100 mb-5 md:mb-6 pb-2">
						<h2 class="text-lg md:text-xl font-bold text-gray-900 relative uppercase tracking-wide">
							<?php echo esc_html( $category->name ); ?>
							<span class="absolute -bottom-[1px] left-0 w-12 md:w-1/2 h-0.5 bg-yellow-400"></span>
						</h2>
						<a href="<?php echo esc_url( get_category_link( $category->term_id ) ); ?>" class="w-max text-[13px] md:text-sm font-bold text-gray-500 hover:text-yellow-600 flex items-center gap-1 transition-colors uppercase tracking-wider bg-gray-50 px-3 py-1.5 md:px-4 md:py-2 rounded-full">
							Xem tất cả <svg class="w-3.5 h-3.5 md:w-4 md:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
						</a>
					</div>

					<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 md:gap-8">
						<?php
						while ( $cat_query->have_posts() ) : $cat_query->the_post();
							get_template_part( 'template-parts/content', get_post_type() );
						endwhile;
						wp_reset_postdata();
						?>
					</div>
				</section>
		<?php
			endif;
		endforeach;
		?>
			</div><!-- End Cột Nội Dung Bên Phải -->
		</div><!-- End Flex Layout -->

	<?php else :
		get_template_part( 'template-parts/content', 'none' );
	endif; ?>

</main><!-- #main -->

<?php
get_footer();
