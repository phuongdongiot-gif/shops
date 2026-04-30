<?php
// Template Part: Benefits (Trang chủ)
?>
<section class="benefits grid grid-cols-1 md:grid-cols-3 gap-6 mb-10 lg:mb-16">
    <!-- Benefit 1 -->
    <div
        class="bg-white border border-gray-100 p-6 rounded-2xl text-center hover:shadow-[0_8px_30px_rgb(0,0,0,0.06)] transition-all duration-300 transform hover:-translate-y-1">
        <div
            class="w-14 h-14 bg-orange-50 text-primary rounded-full flex items-center justify-center mx-auto mb-4">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path>
            </svg>
        </div>
        <h3 class="text-[15px] font-heading font-extrabold text-dark mb-2 uppercase tracking-wide">
            <?php echo esc_html(get_theme_mod('home_benefit_1_title', 'Chất Lượng Cao Cấp')); ?>
        </h3>
        <p class="text-[13px] text-gray-500 leading-relaxed max-w-[200px] mx-auto">
            <?php echo esc_html(get_theme_mod('home_benefit_1_desc', 'Từng sản phẩm đều được kiểm định khắt khe và đạt chuẩn.')); ?>
        </p>
    </div>
    <!-- Benefit 2 -->
    <div
        class="bg-white border border-gray-100 p-6 rounded-2xl text-center hover:shadow-[0_8px_30px_rgb(0,0,0,0.06)] transition-all duration-300 transform hover:-translate-y-1">
        <div
            class="w-14 h-14 bg-orange-50 text-primary rounded-full flex items-center justify-center mx-auto mb-4">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>
            </svg>
        </div>
        <h3 class="text-[15px] font-heading font-extrabold text-dark mb-2 uppercase tracking-wide">
            <?php echo esc_html(get_theme_mod('home_benefit_2_title', 'Thanh Toán An Toàn')); ?>
        </h3>
        <p class="text-[13px] text-gray-500 leading-relaxed max-w-[200px] mx-auto">
            <?php echo esc_html(get_theme_mod('home_benefit_2_desc', 'Hệ thống bảo mật thông tin tuyệt đối qua mã hóa.')); ?>
        </p>
    </div>
    <!-- Benefit 3 -->
    <div
        class="bg-white border border-gray-100 p-6 rounded-2xl text-center hover:shadow-[0_8px_30px_rgb(0,0,0,0.06)] transition-all duration-300 transform hover:-translate-y-1">
        <div
            class="w-14 h-14 bg-orange-50 text-primary rounded-full flex items-center justify-center mx-auto mb-4">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M10 21h4v-2h-4v2zm5-11c0-2.76-2.24-5-5-5S5 7.24 5 10c0 1.95 1.13 3.63 2.8 4.41V16c0 .55.45 1 1 1h2.4c.55 0 1-.45 1-1v-1.59c1.67-.78 2.8-2.46 2.8-4.41z">
                </path>
            </svg>
        </div>
        <h3 class="text-[15px] font-heading font-extrabold text-dark mb-2 uppercase tracking-wide">
            <?php echo esc_html(get_theme_mod('home_benefit_3_title', 'Giao Hàng Nhanh')); ?>
        </h3>
        <p class="text-[13px] text-gray-500 leading-relaxed max-w-[200px] mx-auto">
            <?php echo esc_html(get_theme_mod('home_benefit_3_desc', 'Xử lý đơn linh hoạt, giao hàng siêu tốc toàn quốc.')); ?>
        </p>
    </div>
</section>
