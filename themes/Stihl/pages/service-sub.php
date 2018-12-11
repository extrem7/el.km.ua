<?
/* Template Name: Інструкції та паспорти */
get_header(); ?>
    <main role="main" class="content container content-page">
        <!--about-->
        <div class="box-background right mb-3"
             style="background: transparent url('<? the_field('фон', 193) ?>') no-repeat center">
            <div class="box-linear-bg d-flex align-items-end">
                <h2 class="box-title box-title-simple-page"><?= get_the_title(193) ?></h2>
            </div>
        </div>
        <!--content page-->
        <div class="box-content content-simple-page service-page">
            <?= get_post_field('post_content'); ?>
            <?
            while (have_rows('список')) {
                the_row();
                get_template_part('views/file');
            }
            $i = 0;
            while (have_rows('акордіон')):the_row(); ?>
                <div class="service-title mb-3 mt-3"><? the_sub_field('заголовок') ?></div>
                <? while (have_rows('група')): the_row() ?>
                    <a class="btn-service-toggle" data-toggle="collapse"
                       href="#files-tab-<?= $i ?>"><? the_sub_field('назва') ?>
                        <i class="fa fa-chevron-down"></i></a>
                    <div class="collapse multi-collapse" id="files-tab-<?= $i ?>">
                        <?
                        while (have_rows('список')) {
                            the_row();
                            get_template_part('views/file');
                        }
                        ?>
                    </div>
                    <?
                    $i++;
                endwhile;
            endwhile; ?>
        </div>
    </main>
<?
$Stihl->servicesBanner();
$Stihl->seoText();
get_footer() ?>