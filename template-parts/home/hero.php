<?php
// Template Part: Hero Slider (Trang chủ)
?>
<section class="hero-section relative overflow-hidden">
    <!-- Swiper Container -->
    <div class="swiper heroSwiper w-full h-[350px] lg:h-[450px] rounded-xl overflow-hidden shadow-sm">
        <div class="swiper-wrapper">

            <!-- Slide 1 -->
            <div class="swiper-slide relative w-full h-full">
                <!-- Full Width Background Image -->
                <?php $hero_img_1 = get_theme_mod('hero_img_1', 'https://phugiagiocha.vn/wp-content/uploads/2026/04/logo-3em.png'); // Meat / Sausage / Food ?>
                <img src="<?php echo esc_url($hero_img_1); ?>" alt="Phụ Gia Giò Chả Chất Lượng"
                    class="absolute inset-0 w-full h-full object-cover">
                <!-- Overlay for text readability -->
                <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/40 to-black/10"></div>
                <!-- Content positioned at bottom center -->
                <div class="absolute inset-0 flex flex-col justify-end items-center pb-20 z-10 w-full">
                    <div class="container mx-auto px-6 text-center text-white">
                        <h2
                            class="text-3xl md:text-4xl lg:text-5xl font-heading font-extrabold text-white leading-tight mb-4 tracking-tight drop-shadow-lg">
                            <?php echo esc_html(get_theme_mod('hero_title_1', 'Phụ Gia Giò Chả Chuyên Nghiệp')); ?>
                        </h2>
                        <p class="text-base md:text-lg text-gray-100 mb-8 max-w-3xl mx-auto drop-shadow-md">
                            <?php echo esc_html(get_theme_mod('hero_desc_1', 'Cung cấp giải pháp phụ gia tạo giòn dai, bảo quản và hương liệu tự nhiên. Giúp giò chả thơm ngon, an toàn và đạt chuẩn y tế.')); ?>
                        </p>
                        <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                            <?php
                            $btn_text_1 = get_theme_mod('hero_btn_text_1', 'Nhận Báo Giá Ngay');
                            $btn_link_1 = get_theme_mod('hero_btn_link_1', '#');
                            if (!empty($btn_text_1)):
                                ?>
                                <a href="<?php echo esc_url($btn_link_1); ?>"
                                    class="btn inline-flex justify-center items-center px-8 py-3 bg-primary hover:bg-primary-hover text-white rounded-lg font-semibold shadow border border-primary transition-all duration-300 hover:-translate-y-1"><?php echo esc_html($btn_text_1); ?></a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div><!-- End Slide 1 -->

            <!-- Slide 2 -->
            <div class="swiper-slide relative w-full h-full">
                <!-- Full Width Background Image -->
                <?php $hero_img_2 = get_theme_mod('hero_img_2', 'https://images.unsplash.com/photo-1596040033229-a9821ebd058d?auto=format&fit=crop&w=1920&q=80'); // Spices / Ingredients ?>
                <img src="<?php echo esc_url($hero_img_2); ?>" alt="Hương Liệu Tự Nhiên" loading="lazy"
                    class="absolute inset-0 w-full h-full object-cover">
                <!-- Overlay for text readability -->
                <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/40 to-black/10"></div>
                <!-- Content positioned at bottom center -->
                <div class="absolute inset-0 flex flex-col justify-end items-center pb-20 z-10 w-full">
                    <div class="container mx-auto px-6 text-center text-white">
                        <h2
                            class="text-3xl md:text-4xl lg:text-5xl font-heading font-extrabold text-white leading-tight mb-4 tracking-tight drop-shadow-lg">
                            <?php echo esc_html(get_theme_mod('hero_title_2', 'Hương Liệu & Gia Vị Hoàn Hảo')); ?>
                        </h2>
                        <p class="text-base md:text-lg text-gray-100 mb-8 max-w-3xl mx-auto drop-shadow-md">
                            <?php echo esc_html(get_theme_mod('hero_desc_2', 'Tăng cường hương vị đặc trưng, giữ màu sắc tự nhiên và kéo dài thời gian bảo quản cho các sản phẩm chế biến từ thịt.')); ?>
                        </p>
                        <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                            <?php
                            $btn_text_2 = get_theme_mod('hero_btn_text_2', 'Xem Danh Mục Sản Phẩm');
                            $btn_link_2 = get_theme_mod('hero_btn_link_2', '#');
                            if (!empty($btn_text_2)):
                                ?>
                                <a href="<?php echo esc_url($btn_link_2); ?>"
                                    class="btn inline-flex justify-center items-center px-8 py-3 bg-white text-primary border border-white hover:bg-gray-100 rounded-lg font-semibold shadow transition-all duration-300 hover:-translate-y-1"><?php echo esc_html($btn_text_2); ?></a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div><!-- End Slide 2 -->

        </div>
        <!-- Add Pagination -->
        <div class="swiper-pagination"></div>
    </div>
</section>