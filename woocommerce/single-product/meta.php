<?php
/**
 * Single Product Meta
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/meta.php.
 *
 * @see         https://woocommerce.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     3.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $product;
?>
<div class="product_meta mt-6 pt-5 border-t border-gray-100 flex flex-col gap-4 text-[14px]">

	<?php do_action( 'woocommerce_product_meta_start' ); ?>

	<?php if ( wc_product_sku_enabled() && ( $product->get_sku() || $product->is_type( 'variable' ) ) ) : ?>
		<div class="sku_wrapper font-semibold text-gray-700 flex items-center gap-2">
			<span><?php esc_html_e( 'Mã sản phẩm:', 'shopping' ); ?></span> 
			<span class="sku font-bold text-dark"><?php echo ( $sku = $product->get_sku() ) ? $sku : esc_html__( 'N/A', 'shopping' ); ?></span>
		</div>
	<?php endif; ?>

	<?php 
	$cat_count = sizeof( get_the_terms( $product->get_id(), 'product_cat' ) ?: array() );
	echo wc_get_product_category_list( 
		$product->get_id(), 
		'', 
		'<div class="posted_in font-semibold text-gray-700 flex flex-wrap items-center gap-2"><span class="mr-2">' . _n( 'Danh mục:', 'Danh mục:', $cat_count, 'shopping' ) . '</span>', 
		'</div>' 
	); 
	?>

	<?php 
	$tag_count = sizeof( get_the_terms( $product->get_id(), 'product_tag' ) ?: array() );
	echo wc_get_product_tag_list( 
		$product->get_id(), 
		'', 
		'<div class="tagged_as font-semibold text-gray-700 flex flex-wrap items-center gap-2"><span class="mr-2">' . _n( 'Từ khóa:', 'Từ khóa:', $tag_count, 'shopping' ) . '</span>', 
		'</div>' 
	); 
	?>

	<?php do_action( 'woocommerce_product_meta_end' ); ?>

</div>
