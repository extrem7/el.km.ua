<?php
define('DONOTCACHEPAGE', true);
defined('ABSPATH') || exit;

global $product, $Stihl;

// Ensure visibility.
if (empty($product) || !$product->is_visible()) {
    return;
}

$salePrice = $product->get_sale_price();

$regularPrice = $product->get_regular_price();
if ($salePrice) {
    $regularPrice = $salePrice;
    $salePrice = $product->get_regular_price();

}

if ($product->get_type() == 'variable') {
    $regularPrice = $product->get_price();
}

$category = '';
$allTax = get_the_terms($product->get_id(), 'product_cat');
if (!is_wp_error($allTax)) {
    $category = array_reverse($allTax)[0]->description;
    if (!$category) {
        $category = array_reverse($allTax)[0]->name;
    }
}

global $salePage;

if ($salePage):?>
    <div class="col-xl-3 col-lg-4 col-md-6">
<? endif; ?>
    <div <?php wc_product_class("card-product d-flex flex-column justify-content-between"); ?> >
        <div class="product-compare d-flex justify-content-end">
            <div class="custom-control custom-checkbox d-flex align-items-center justify-content-center">
                <?
                $checked = $Stihl->compare->inCompare(get_the_ID()) ? 'checked' : '';
                ?>
                <input type="checkbox" class="custom-control-input" name="<? the_ID() ?>"
                       id="compareProduct<? the_ID() ?>" <?= $checked ?>>
                <label class="custom-control-label d-flex align-items-center" for="compareProduct<? the_ID() ?>">Порівняти</label>
            </div>
        </div>
        <a href="<? the_permalink() ?>" class="product-image">
            <? $img = wp_prepare_attachment_for_js(get_post_thumbnail_id()); ?>
            <img src="<?= $img['url'] ?>" alt="<?= $img['alt'] ?>">
        </a>
        <div class="product-body">
            <? if ($salePrice): ?>
                <div class="sale-product d-flex align-items-center justify-content-center">Акція</div>
            <? endif; ?>
            <a href="<? the_permalink() ?>" class="d-flex justify-content-between flex-wrap flex-row product-info">
                <div class="model-name"><? the_title() ?></div>
                <div class="product-price"><?= wc_price($regularPrice) ?></div>
                <div class="product-name"><?= $category ?></div>
                <? if ($salePrice): ?>
                    <div class="product-old-price"><?= wc_price($salePrice) ?></div>
                <? endif; ?>
            </a>
            <div class="d-flex justify-content-between align-items-center mt-1">
                <div class="product-settings"><?= get_the_excerpt() ?></div>
                <a href="<?= $product->add_to_cart_url() ?>" class="btn-add-to-cart btn-ajax">В резерв</a>
            </div>
        </div>
    </div>
<? if ($salePage): ?>
    </div>
<? endif; ?>