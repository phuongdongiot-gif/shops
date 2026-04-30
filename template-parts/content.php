<?php
/**
 * Template part for displaying posts
 *
 * @package shopping
 */

$is_hero = isset( $args['is_hero'] ) ? $args['is_hero'] : false;

// Nếu là trang chi tiết (Single post) thì vẫn giữ layout đọc báo
if ( is_singular() ) :
?>
<article id="post-<?php the_ID(); ?>" <?php post_class('mb-10'); ?>>
	<header class="entry-header mb-6">
		<?php the_title( '<h1 class="entry-title text-3xl md:text-4xl font-heading font-extrabold mb-3 text-dark leading-tight">', '</h1>' ); ?>
		
		<?php if ( 'post' === get_post_type() ) : ?>
			<div class="entry-meta flex items-center gap-4 text-[13px] text-gray-500 font-medium mb-6 pb-6 border-b border-gray-100">
				<?php
				$time_string = '<time class="entry-date published updated flex items-center gap-1.5" datetime="%1$s"><svg class="w-4 h-4 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>%2$s</time>';
				printf( $time_string, esc_attr( get_the_date( DATE_W3C ) ), esc_html( get_the_date() ) );
				?>
			</div>
		<?php endif; ?>
	</header>

	<?php get_the_post_thumbnail( null, 'large', array( 'class' => 'w-full h-auto mb-8 rounded-xl shadow-sm' ) ); ?>

	<div class="entry-content text-gray-800 leading-relaxed text-[16px] md:text-[17px]">
		<?php
		the_content();
		wp_link_pages( array( 'before' => '<div class="page-links mt-6 font-bold">' . esc_html__( 'Pages:', 'shopping' ), 'after'  => '</div>' ) );
		?>
	</div>
</article>

<?php else : // NẾU LÀ TRANG ARCHIVE / DANH SÁCH ?>

<article id="post-<?php the_ID(); ?>" <?php post_class( array( 'bg-white border border-gray-100 rounded-2xl overflow-hidden hover:shadow-[0_8px_30px_rgb(0,0,0,0.08)] transition-all duration-300 flex flex-col group h-full transform hover:-translate-y-1', $is_hero ? 'md:col-span-2 lg:col-span-3 lg:flex-row' : '' ) ); ?>>
	
	<!-- Hình ảnh đại diện -->
	<div class="relative overflow-hidden w-full shrink-0 <?php echo $is_hero ? 'lg:w-[60%] aspect-[16/9] lg:aspect-auto' : 'aspect-[4/3] border-b border-gray-50'; ?>">
		<a href="<?php echo esc_url( get_permalink() ); ?>" class="block w-full h-full">
			<?php 
			if ( has_post_thumbnail() ) {
				$image_size = $is_hero ? 'full' : 'medium_large';
				the_post_thumbnail( $image_size, array( 'class' => 'w-full h-full object-cover group-hover:scale-105 transition-transform duration-700 ease-out' ) );
			} else {
				echo '<div class="w-full h-full bg-gray-50 flex items-center justify-center text-gray-400 text-xs">Không có ảnh</div>';
			}
			?>
			<div class="absolute inset-0 bg-gradient-to-t from-black/40 via-black/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
		</a>
		
		<!-- Category Badge -->
		<?php
		$categories = get_the_category();
		if ( ! empty( $categories ) ) {
			echo '<a href="' . esc_url( get_category_link( $categories[0]->term_id ) ) . '" class="absolute top-4 left-4 bg-primary text-white text-[11px] font-bold uppercase px-3 py-1.5 rounded-md shadow-sm hover:bg-primary-hover">' . esc_html( $categories[0]->name ) . '</a>';
		}
		?>
	</div>
	
	<!-- Nội dung text -->
	<div class="p-6 flex flex-col flex-1 bg-white relative z-10 <?php echo $is_hero ? 'lg:justify-center' : ''; ?>">
		<div class="text-[12px] text-gray-400 font-semibold mb-3 flex items-center gap-1.5 uppercase tracking-wider">
			<svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
			<?php echo get_the_date(); ?>
		</div>
		
		<h2 class="entry-title font-heading font-extrabold mb-3 leading-snug <?php echo $is_hero ? 'text-[24px] md:text-[32px] line-clamp-3' : 'text-[18px] line-clamp-2'; ?>">
			<a href="<?php echo esc_url( get_permalink() ); ?>" rel="bookmark" class="text-dark hover:text-primary transition-colors"><?php the_title(); ?></a>
		</h2>
		
		<div class="text-[14px] text-gray-500 mb-5 leading-relaxed <?php echo $is_hero ? 'line-clamp-4' : 'line-clamp-3'; ?> flex-1">
			<?php echo wp_trim_words( wp_strip_all_tags( get_the_excerpt() ), $is_hero ? 40 : 20, '...' ); ?>
		</div>
		
		<div class="mt-auto pt-4 border-t border-gray-100 flex items-center justify-between">
			<a href="<?php echo esc_url( get_permalink() ); ?>" class="text-primary font-bold text-[13px] hover:text-primary-hover inline-flex items-center gap-1.5 uppercase tracking-wider">
				Xem Chi Tiết
				<svg class="w-4 h-4 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
			</a>
		</div>
	</div>

</article>

<?php endif; ?>
