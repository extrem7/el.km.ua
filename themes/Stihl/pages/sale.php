<?php
/* Template Name: Акції */
defined('ABSPATH') || exit;
get_header();
global $salePage;
$salePage = true;
?>
<main role="main" class="content content-page container">
    <!--Box manufactured-->
    <div class="box-background right"
         style="background: transparent url('<? the_post_thumbnail_url() ?>') no-repeat center">
        <div class="box-linear-bg d-flex align-items-end">
            <h2 class="box-title box-title-simple-page"><? the_title() ?></h2>
        </div>
    </div>
    <!--category-->
    <div class="second-title mt-2 mb-2">Акційні товари</div>
    <div class="notices-area">
        <? wc_print_notices() ?>
    </div>
    <?= str_replace('products', 'row', do_shortcode('[sale_products per_page="8" paginate="true" orderby="popularity" class="list-product"]')) ?>
</main>
<?
$Stihl->servicesBanner();
$Stihl->seoText();
get_footer() ?>
