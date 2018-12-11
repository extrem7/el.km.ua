<?php

defined('ABSPATH') || exit;


global $product;

$gallery = $product->get_gallery_image_ids();
if (count($gallery) <= 1) return;
?>
<div class="previews owl-carousel owl-theme" id="product-carousel">
    <? foreach ($gallery as $image):
        $src = wp_get_attachment_url($image);
        ?>
        <div class="item">
            <div class="activate thumbs" data-full="<?= $src ?>" style="background-image: url('<?= $src ?>')"></div>
        </div>
    <? endforeach; ?>
</div>
