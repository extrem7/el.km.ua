<?
get_header(); ?>
<main role="main" class="content container content-page">
    <!--about-->
    <div class="box-background right mb-3"
         style="background: transparent url('<? the_field('фон', 193) ?>') no-repeat center">
        <div class="box-linear-bg d-flex align-items-end">
            <h2 class="box-title box-title-simple-page"><? the_title() ?></h2>
        </div>
    </div>
    <!--content page-->
    <div class="box-content content-simple-page service-page"><?= get_post_field('post_content') ?></div>
</main>
<?
$Stihl->servicesBanner();
$Stihl->seoText();
get_footer() ?>
