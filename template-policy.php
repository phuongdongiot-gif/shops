<?php
/**
 * Template Name: Trang Chính Sách
 *
 * Template tự động nhận diện và liệt kê các trang chính sách khác vào Sidebar trái.
 */

get_header();

// Lấy ID trang hiện tại
$current_page_id = get_the_ID();

// Truy vấn các trang dùng chung template này
$policy_pages = get_pages(array(
    'meta_key' => '_wp_page_template',
    'meta_value' => 'template-policy.php',
    'post_type' => 'page',
    'post_status' => 'publish',
    'sort_column' => 'menu_order, post_title',
));
?>

<div class="bg-gray-50/50 min-h-screen py-10 lg:py-16">
    <div class="container mx-auto px-6">
        
        <!-- Tiêu đề trang -->
        <header class="mb-10 text-center lg:text-left">
            <h1 class="text-3xl lg:text-4xl font-heading font-bold text-dark uppercase tracking-wide">
                <?php the_title(); ?>
            </h1>
            <div class="w-16 h-1.5 bg-primary mt-4 mx-auto lg:mx-0 rounded-full"></div>
        </header>

        <div class="flex flex-col lg:flex-row gap-8 lg:gap-10 items-start">
            
            <!-- Cột Trái: Sidebar Menu Tự Động -->
            <aside class="w-full lg:w-[320px] flex-shrink-0 sticky top-32">
                <div class="bg-white rounded-2xl shadow-[0_10px_40px_rgb(0,0,0,0.06)] border border-gray-100 overflow-hidden">
                    <div class="bg-primary px-6 py-5">
                        <h3 class="text-white font-bold text-[16px] uppercase tracking-wider m-0 flex items-center gap-2">
                            <svg class="w-5 h-5 opacity-90" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            CHÍNH SÁCH & HỖ TRỢ
                        </h3>
                    </div>
                    <ul class="list-none m-0 p-0 bg-white">
                        <?php if ( ! empty($policy_pages) ) : ?>
                            <?php foreach ( $policy_pages as $p_page ) : ?>
                                <?php $is_active = ($current_page_id === $p_page->ID); ?>
                                <li class="border-b border-gray-50 last:border-0 relative">
                                    <a href="<?php echo get_permalink($p_page->ID); ?>" 
                                       class="block px-6 py-4 text-[14.5px] transition-all hover:bg-orange-50/30 <?php echo $is_active ? 'text-primary font-bold bg-orange-50/50' : 'text-gray-600 font-medium hover:text-primary'; ?>">
                                        <?php echo esc_html($p_page->post_title); ?>
                                    </a>
                                    <!-- Thanh báo viền trái cho Tab đang chọn -->
                                    <?php if ($is_active): ?>
                                        <div class="absolute left-0 top-0 bottom-0 w-1 bg-primary"></div>
                                    <?php endif; ?>
                                </li>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <li class="px-6 py-4 text-sm text-gray-400 font-style-italic">Đang cập nhật danh mục...</li>
                        <?php endif; ?>
                    </ul>
                </div>
            </aside>

            <!-- Cột Phải: Nội Dung Chính Sách -->
            <main class="w-full lg:flex-1">
                <div class="bg-white rounded-2xl shadow-[0_10px_40px_rgb(0,0,0,0.06)] border border-gray-100 p-8 lg:p-14 w-full overflow-hidden">
                    <?php while ( have_posts() ) : the_post(); ?>
                        
                        <!-- Policy Content Render Container -->
                        <div class="policy-content-wrapper text-gray-700 leading-relaxed max-w-none">
                            <?php the_content(); ?>
                        </div>

                    <?php endwhile; ?>
                </div>
            </main>

        </div>
    </div>
</div>

<!-- Tối Ưu Hiển Thị Riêng Cho Vùng Chữ Bên Trong Trang Chính Sách (Khỏi cần Tailwind Plugin) -->
<style>
.policy-content-wrapper { font-size: 1.05rem; }
.policy-content-wrapper h2 { font-size: 1.5rem; font-weight: 700; color: #111827; margin-top: 2rem; margin-bottom: 1rem; padding-bottom: 0.5rem; border-bottom: 1px solid #f3f4f6; }
.policy-content-wrapper h3 { font-size: 1.25rem; font-weight: 700; color: #374151; margin-top: 1.5rem; margin-bottom: 0.75rem; }
.policy-content-wrapper p { margin-bottom: 1.25rem; line-height: 1.7; }
.policy-content-wrapper ul { list-style-type: disc; padding-left: 1.5rem; margin-bottom: 1.25rem; }
.policy-content-wrapper ol { list-style-type: decimal; padding-left: 1.5rem; margin-bottom: 1.25rem; }
.policy-content-wrapper li { margin-bottom: 0.5rem; }
.policy-content-wrapper strong { font-weight: 700; color: #111827; }
.policy-content-wrapper a { color: #ea580c; text-decoration: none; font-weight: 500; transition: all 0.2s; }
.policy-content-wrapper a:hover { text-decoration: underline; color: #c2410c; }
.policy-content-wrapper blockquote { border-left: 4px solid #ea580c; background: #fff7ed; padding: 1rem 1.5rem; font-style: italic; margin-bottom: 1.5rem; border-radius: 0 0.5rem 0.5rem 0; }
.policy-content-wrapper img { border-radius: 0.75rem; max-width: 100%; height: auto; margin-bottom: 1.5rem; box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1); }
</style>

<?php get_footer(); ?>
