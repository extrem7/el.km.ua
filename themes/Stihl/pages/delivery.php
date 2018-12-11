<?
/* Template Name: Як придбати */
get_header(); ?>
    <main role="main" class="content container content-page">
        <!--about-->
        <div class="box-background right mb-3"
             style="background: transparent url('<? the_field('фон') ?>') no-repeat center">
            <div class="box-linear-bg d-flex align-items-end">
                <h2 class="box-title box-title-simple-page"><? the_field('заголовок') ?></h2>
            </div>
        </div>
        <!--content page-->
        <div class="box-content content-simple-page"><?= get_post_field('post_content') ?></div>
        <!--contact shop-->
        <div class="row delivery-contact contact-page mt-4">
            <?
            while (have_rows('магазини',152)):the_row() ?>
                <div class="col-lg-12 col-xl-6">
                    <address>
                        <? get_template_part('views/shop-contact') ?>
                    </address>
                </div>
            <? endwhile; ?>
        </div>
        <!--map-->
        <div class="box-background map mt-4"><?= do_shortcode('[google_map_easy id="1"]') ?></div>
    </main>
<?
$Stihl->servicesBanner();
//$Stihl->seoText();
get_footer() ?>