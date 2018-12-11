<?php

if (!defined('ABSPATH')) {
    exit;
}

do_action('woocommerce_before_checkout_form', $checkout);

// If checkout registration is disabled and not logged in, the user cannot checkout
if (!$checkout->is_registration_enabled() && $checkout->is_registration_required() && !is_user_logged_in()) {
    echo apply_filters('woocommerce_checkout_must_be_logged_in_message', __('You must be logged in to checkout.', 'woocommerce'));
    return;
}

?>

<form name="checkout" method="post" class="checkout woocommerce-checkout"
      action="<?php echo esc_url(wc_get_checkout_url()); ?>" enctype="multipart/form-data">
    <div class="row flex-column-reverse flex-md-row">
        <div class="col-md-6">
            <?php if ($checkout->get_checkout_fields()) : ?>

                <?php do_action('woocommerce_checkout_before_customer_details'); ?>

                <div class="col2-set d-none" id="customer_details">
                    <div class="col-12">
                        <?php do_action('woocommerce_checkout_billing'); ?>
                    </div>

                    <div class="col-12">
                        <?php// do_action('woocommerce_checkout_shipping'); ?>
                    </div>
                </div>

                <?php do_action('woocommerce_checkout_after_customer_details'); ?>

            <?php endif; ?>
            <div>
                <div class="title mt-3 mt-md-0">Оформлення замовлення</div>
                <div class="form-group">
                    <label class="label-form">Ваше ім'я: <span class="text-danger">*</span></label>
                    <input type="text" class="control-form" name="billing_first_name">
                </div>
                <div class="form-group">
                    <label class="label-form">Ваш телефон: <span class="text-danger">*</span></label>
                    <input type="text" class="control-form" name="billing_phone">
                </div>
                <div class="form-group">
                    <label class="label-form">Email:</label>
                    <input type="email" class="control-form" name="billing_email">
                </div>
                <div class="form-group">
                    <label class="label-form">Виберіть магазин: <span class="text-danger">*</span></label>
                    <?
                    $i = 1;
                    while (have_rows('магазини')):the_row()
                        ?>
                        <div class="custom-control custom-radio">
                            <input type="radio" id="shop-<?= $i ?>" value="<? the_sub_field('адреса') ?>"
                                   name="billing_address_1"
                                   class="custom-control-input">
                            <label class="custom-control-label" for="shop-<?= $i ?>"><i
                                        class="fa fa-map-marker-alt"></i> <? the_sub_field('адреса') ?></label>
                        </div>
                    <?
                    $i++;
                    endwhile; ?>
                </div>
                <div class="form-group text-center">
                    <input type="submit" value="Замовити" class="btn-orange pr-3 pl-3">
                </div>
            </div>
            <span class="text-danger">*</span> - поля обов'язкові для заповнення
        </div>
        <div class="col-md-6 mt-4 mt-md-0">
            <div class="cart-collaterals">
                <div class="cart_totals ">
                    <div class="title">Загальна вартість</div>
                    <?php do_action('woocommerce_checkout_order_review'); ?>
                </div>
            </div>
        </div>
    </div>
</form>

<?php do_action('woocommerce_after_checkout_form', $checkout); ?>
