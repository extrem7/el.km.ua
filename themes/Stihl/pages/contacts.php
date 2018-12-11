<?
/* Template Name: Контакти */
get_header(); ?>
    <main role="main" class="content container content-page contact-page">
        <!--contact-->
        <?
        while (have_rows('магазини')):the_row() ?>
            <address class="box-background right">
                <div class="row">
                    <div class="col-xl-7 col-lg-12 col-md-12 nopr">
                        <? get_template_part('views/shop-contact') ?>
                    </div>
                    <div class="col-xl-5 col-lg-12 col-md-12 shop-slider nopl">
                        <div class="owl-carousel owl-theme shop-carousel">
                            <?
                            $gallery = get_sub_field('галерея');
                            foreach ($gallery as $photo):
                                ?>
                                <div class="item"><a href="<?= $photo['url'] ?>"><img src="<?= $photo['url'] ?>"
                                                                                      alt="<?= $photo['alt'] ?>"></a>
                                </div>
                            <? endforeach; ?>
                        </div>
                    </div>
                </div>
            </address>
        <? endwhile; ?>
        <!--map-->
        <div class="box-background map mt-4"><?= do_shortcode('[google_map_easy id="1"]') ?></div>
    </main>
<?
$Stihl->servicesBanner();
$Stihl->seoText();
get_footer() ?>