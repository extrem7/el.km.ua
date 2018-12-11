<?
/* Template Name: Сервіс */
get_header(); ?>
    <main role="main" class="content container content-page">
        <!--about-->
        <div class="box-background right mb-3"
             style="background: transparent url('<? the_field('фон') ?>') no-repeat center">
            <div class="box-linear-bg d-flex align-items-end">
                <h2 class="box-title box-title-simple-page"><? the_title() ?></h2>
            </div>
        </div>
        <!--content page-->
        <div class="box-content content-simple-page service-page"><?= get_post_field('post_content') ?></div>
        <!--certificates-->
        <div class="certificates">
            <div class="box-content box-content-small">
                <div class="title">Сертифікати майстрів</div>
            </div>
            <? get_template_part('views/certificates') ?>
        </div>
        <!--instruction-->
        <?
        $instructions = get_posts([
            'post_type' => 'page',
            'posts_per_page' => -1,
            'orderby'=>'menu_order',
            'order'=>'ASC',
            'post_parent' => get_the_ID()
        ]);
        if (!empty($instructions)):
            ?>
            <div class="instruction">
                <div class="box-content box-content-small">
                    <div class="title">Інструкції та паспорти безпеки</div>
                </div>
                <div class="box-content">
                    <? foreach ($instructions as $post): ?>
                        <div class="instruction-item d-flex flex-column flex-md-row justify-content-between">
                            <div class="instruction-img"
                                 style="background-image: url('<? the_post_thumbnail_url() ?>')"></div>
                            <div class="instruction-info">
                                <div class="instruction-title"><? the_title() ?></div>
                                <p><? the_field('коротко_про_сторінку') ?></p>
                                <a href="<? the_permalink() ?>" class="readmore">Читати більше</a>
                            </div>
                        </div>
                    <? endforeach; ?>
                </div>
            </div>
        <? endif; ?>
    </main>
<?
$Stihl->servicesBanner();
$Stihl->seoText();
get_footer() ?>