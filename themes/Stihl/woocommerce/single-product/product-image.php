<?php

defined( 'ABSPATH' ) || exit;

if ( ! function_exists( 'wc_get_gallery_image_html' ) ) {
	return;
}

global $product;
$image = $product->get_gallery_image_ids()[0];
$image = wp_prepare_attachment_for_js($image);
?>
<a data-fancybox="main" href="<?= $image['url'] ?>" class="gallery-fancybox">
    <img src="<?= $image['url'] ?>" class="img-fluid" alt="<?= $image['alt']; ?>" itemprop="image">
</a>
