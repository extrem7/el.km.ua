<? /* Template Name: Головна */
get_header(); ?>
    <section class="container home-manufactured">
        <div class="row">
            <?
            $categories = get_field('категорії');
            ?>
            <div class="col-md-6">
                <a href="<?= get_term_link($Stihl->woo->stihlID()) ?>" class="box-background right d-flex align-items-end"
                   style="background: transparent url('<?= $categories['stihl'] ?>') no-repeat center;">
                    <div class="box-linear-bg  h-auto">
                        <h2 class="manufactured-title">Продукція <span>Stihl</span></h2>
                    </div>
                </a>
            </div>
            <div class="col-md-6">
                <a href="<?= get_term_link($Stihl->woo->vikingID()) ?>" class="box-background left d-flex align-items-end"
                   style="background: transparent url('<?= $categories['viking'] ?>') no-repeat center;">
                    <div class="box-linear-bg h-auto">
                        <h2 class="manufactured-title">Продукція <span class="color-green">Viking</span></h2>
                    </div>
                </a>
            </div>
        </div>
    </section>
    <!--Content-->
    <main role="main" class="content container">
        <!--product-->
        <div class="notices-area">
            <? wc_print_notices() ?>
        </div>
        <div class="row mt-3 list-product">
            <?
            $products = $Stihl->woo->getHomeProducts();
            foreach ($products as $post) {
                $product = wc_get_product();
                ?>
                <div class="col-xl-3 col-lg-4 col-md-6">
                    <? wc_get_template_part('content', 'product'); ?>
                </div>
                <?
            }
            wp_reset_query();
            ?>
        </div>
        <!--certificates-->
        <div class="certificates">
            <div class="box-content box-content-small">
                <div class="title">Сертифікати</div>
            </div>
            <? get_template_part('views/certificates') ?>
        </div>
    </main>
    <!--/Content-->
<?
$Stihl->servicesBanner();
$Stihl->seoText();
get_footer() ?>