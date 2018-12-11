<?php


if (!defined('ABSPATH')) {
    exit;
}

global $product;

$salePrice = $product->get_sale_price();
$regularPrice = $product->get_regular_price();

$price = $salePrice ? $salePrice : $regularPrice;

if ($product->get_type() == 'variable') {
    $price = $product->get_price();
}
?>
    <div class="product-price"><?= wc_price($price) ?></div><span class="d-none" itemprop="price"><?= $price ?></span>
    <span class="d-none" itemprop="priceCurrency">UAH</span>
<? if ($salePrice): ?>
    <div class="product-old-price"><?= wc_price($regularPrice) ?></div>
<? endif; ?>