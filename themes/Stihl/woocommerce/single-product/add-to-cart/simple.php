<?php

defined('ABSPATH') || exit;

global $product;

if (!$product->is_purchasable()) {
    return;
}

echo wc_get_stock_html($product); // WPCS: XSS ok.

if ($product->is_in_stock()) : ?>

    <?php do_action('woocommerce_before_add_to_cart_form'); ?>
    <!--
	<form class="cart" action="<?php echo esc_url(apply_filters('woocommerce_add_to_cart_form_action', $product->get_permalink())); ?>" method="post" enctype='multipart/form-data'>
		<?php do_action('woocommerce_before_add_to_cart_button'); ?>

		<?php
    do_action('woocommerce_before_add_to_cart_quantity');

    /*woocommerce_quantity_input( array(
        'min_value'   => apply_filters( 'woocommerce_quantity_input_min', $product->get_min_purchase_quantity(), $product ),
        'max_value'   => apply_filters( 'woocommerce_quantity_input_max', $product->get_max_purchase_quantity(), $product ),
        'input_value' => isset( $_POST['quantity'] ) ? wc_stock_amount( wp_unslash( $_POST['quantity'] ) ) : $product->get_min_purchase_quantity(), // WPCS: CSRF ok, input var ok.
    ) );*/

    do_action('woocommerce_after_add_to_cart_quantity');
    ?>

		<button type="submit" name="add-to-cart" value="<?php echo esc_attr($product->get_id()); ?>" class="add-to-cart mt-3 single_add_to_cart_button button alt">В резерв</button>

		<?php do_action('woocommerce_after_add_to_cart_button'); ?>
	</form>
   -->
    <?
    if ($product->get_type() == 'variable') {
        $default_attributes = $product->get_default_attributes();
        $default_variation = null;
        foreach ($product->get_available_variations() as $variation_values) {
            foreach ($variation_values['attributes'] as $key => $attribute_value) {
                $attribute_name = str_replace('attribute_', '', $key);
                $default_value = $product->get_variation_default_attribute($attribute_name);
                if ($default_value == $attribute_value) {
                    $is_default_variation = true;
                } else {
                    $is_default_variation = false;
                    break; // Stop this loop to start next main lopp
                }
            }
            if ($is_default_variation) {
                $variation_id = $variation_values['variation_id'];
                break; // Stop the main loop
            }
        }

        // Now we get the default variation data
        if ($is_default_variation) {
            // Raw output of available "default" variation details data
            echo '<pre>';
            //print_r($variation_values);
            echo '</pre>';

            // Get the "default" WC_Product_Variation object to use available methods
            $default_variation = wc_get_product($variation_id);

            // Get The active price
            $price = $default_variation->get_price();
        }
        ?>
        <form method="post">
            <button type="submit" class="mt-3 single_add_to_cart_button button alt add-to-cart">В резерв</button>
            <input type="hidden" name="add-to-cart" value="<?= $product->get_id(); ?>"/>
            <input type="hidden" name="product_id" value="<?= $product->get_id(); ?>"/>
            <input type="hidden" name="variation_id" class="variation_id"
                   value="<?= $default_variation->variation_id ?>"/>
        </form>
        <?
    } else {
        ?>
        <a href="<?= $product->add_to_cart_url() ?>"
           class="mt-3 single_add_to_cart_button button alt add-to-cart  btn-ajax">В резерв</a>
        <?php do_action('woocommerce_after_add_to_cart_form');
    }
    ?>

<?php endif; ?>
