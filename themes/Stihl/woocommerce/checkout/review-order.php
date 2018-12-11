<?php

if (!defined('ABSPATH')) {
    exit;
}
?>
<table class="shop_table woocommerce-checkout-review-order-table">
    <tbody>
    <tr class="order-total">
        <th><?php _e('Total', 'woocommerce'); ?></th>
        <td data-title="Total" class="product-price"><?php wc_cart_totals_subtotal_html() ?></td>
    </tr>
    </tbody>
</table>
