<?
/* Template Name: Резерв */
get_header();
?>
<main role="main" class="content content-page container">
    <div class="cart-container box-content woocommerce-cart">
        <?= do_shortcode('[woocommerce_cart]') ?>
        <?= do_shortcode( '[woocommerce_checkout]' ) ?>
    </div>
</main>
<?
$Stihl->servicesBanner();
$Stihl->seoText();
get_footer('shop');