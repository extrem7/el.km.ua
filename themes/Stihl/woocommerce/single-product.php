<?

if (!defined('ABSPATH')) {
    exit;
}

global $parentCategory, $product;
$product = wc_get_product($post);
$parentCategory = null;
$currentCategory = wp_get_post_terms(get_the_ID(), 'product_cat')[0];

$parentCategory = $Stihl->woo->getParentCategory($currentCategory);

get_header('shop'); ?>
    <main role="main" class="content content-page container">
        <div class="row mt-3">
            <!--filter and sidebar-->
            <? get_sidebar() ?>
            <!--product container-->
            <div class="col-md-12 col-lg-9">
                <button id="showFilter" class="filter-btn mb-4">
                    <i class="fas fa-filter"></i>
                    Виберіть
                </button>
                <article class="product-container box-content" itemscope itemtype="http://schema.org/Product">
                    <div class="notices-area">
                        <? wc_print_notices() ?>
                    </div>
                    <!--general info-->
                    <? wc_get_template('single-product/title.php'); ?>
                    <div class="product-short-description" itemprop="description"><? the_field('короткий_опис') ?></div>
                    <div class="d-flex flex-column-reverse flex-md-column">
                        <!--tabs product-->
                        <? wc_get_template('single-product/tabs/tabs.php'); ?>
                        <!--gallery product-->
                        <div class="product-gallery d-flex flex-column flex-md-row align-items-center align-items-md-start">
                            <div class="full d-flex align-items-center justify-content-center">
                                <? wc_get_template('single-product/stock.php'); ?>
                                <!-- first image is viewable to start -->
                                <? wc_get_template('single-product/product-image.php'); ?>
                            </div>
                            <div class="previews-block">
                                <? wc_get_template('single-product/product-thumbnails.php'); ?>
                                <div class="text-center" itemprop="offers" itemscope itemtype="http://schema.org/Offer">
                                    <? wc_get_template('single-product/price.php'); ?>
                                    <? woocommerce_simple_add_to_cart(); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-content" id="myTabContent">
                        <? wc_get_template('single-product/tabs/description.php'); ?>
                        <? wc_get_template('single-product/product-attributes.php'); ?>
                        <? wc_get_template('single-product/tabs/equipment.php'); ?>
                        <? wc_get_template('single-product/tabs/accessories.php'); ?>
                        <? wc_get_template('single-product/tabs/accessories-additional.php'); ?>
                        <? wc_get_template('single-product/tabs/video.php'); ?>
                        <? wc_get_template('single-product/review.php'); ?>
                    </div>
                    <? wc_get_template('single-product/related.php'); ?>
                </article>
                <?
                $categories = get_field('супутні_категорії');
                if ($categories):
                    ?>
                    <!--same category-->
                    <section class="section-same-category">
                        <div class="box-content box-content-small">
                            <div class="title">Супутні категорії</div>
                        </div>
                        <div class="owl-carousel owl-theme banner-carousel" id="category-carousel">
                            <? foreach ($categories as $category) get_template_part('views/category'); ?>
                        </div>
                    </section>
                <? endif; ?>
            </div>
        </div>
    </main>
<?
$Stihl->servicesBanner();
$Stihl->seoText();
get_footer('shop');
