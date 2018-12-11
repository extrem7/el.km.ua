<?php


if (!defined('ABSPATH')) {
    exit;
}
global $product;
?>
<? if ( $product->get_sale_price()): ?>
    <div class="sale-product"><span>Акція</span></div>
<? endif; ?>
