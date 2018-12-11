<?php

defined('ABSPATH') || exit;

global $Stihl, $parentCategory, $children;

$parentCategory = null;
if (is_shop() && !is_tax()) {
    $parentCategory = $Stihl->woo->stihlID();
} else {
    $currentCategory = get_queried_object();

    $children = get_terms('product_cat', [
        'child_of' => $currentCategory->term_id,
        'parent' => $currentCategory->term_id,
       // 'hierarchical' => false
    ]);
    $parentCategory = $Stihl->woo->getParentCategory($currentCategory);
}
$bannerImage = categoryImage($parentCategory)['url'];

get_header();
?>
<main role="main" class="content content-page container">
    <!--Box manufactured-->
    <div class="catalog-manufactured box-background right"
         style="background: transparent url('<?= $bannerImage ?>') no-repeat center">
        <div class="box-linear-bg d-flex align-items-center">
            <h2 class="box-title">Продукція <span><?= get_term($parentCategory)->name ?></span></h2>
        </div>
    </div>
    <!--catalog list-->
    <div class="row mt-3">
        <!--filter and sidebar-->
        <? get_sidebar() ?>
        <div class="col-md-12 col-lg-9">
            <button id="showFilter" class="filter-btn mb-4">
                <i class="fas fa-filter"></i>
                Виберіть
            </button>
            <!--category-->
            <div class="notices-area">
                <? wc_print_notices() ?>
            </div>
            <div class="row list-product">
                <?
                if (!empty($children) && !is_search()) :
                    global $category;
                    foreach ($children as $category):
                        ?>
                        <div class="col-md-4">
                            <? get_template_part('views/category') ?>
                        </div>
                    <?
                    endforeach;
                elseif (have_posts()):
                    while (have_posts()) {
                        the_post(); ?>
                        <div class="col-xl-4 col-lg-6 col-md-6">
                            <? wc_get_template_part('content', 'product'); ?>
                        </div>
                        <?
                    }
                else: ?>
                    <h1 class="title title-compare text-center w-100">Нічого не знайдено</h1>
                <? endif; ?>
            </div>
            <?
            if (empty($children)) woocommerce_pagination() ?>
        </div>
    </div>
</main>
<?
$Stihl->servicesBanner();
$Stihl->seoText();
get_footer() ?>


