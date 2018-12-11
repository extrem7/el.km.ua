<?php


if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

wc_print_notices();

/**
 * @hooked wc_empty_cart_message - 10
 */
//do_action( 'woocommerce_cart_is_empty' );

if ( wc_get_page_id( 'shop' ) > 0 ) : ?>
    <div class="title">Ваш резерв пустий</div>
	<p class="return-to-shop">
		<a class="button wc-backward btn-orange" href="<?php echo esc_url( apply_filters( 'woocommerce_return_to_shop_redirect', wc_get_page_permalink( 'shop' ) ) ); ?>">
			<?php _e( 'Return to shop', 'woocommerce' ) ?>
		</a>
	</p>
<?php endif; ?>
