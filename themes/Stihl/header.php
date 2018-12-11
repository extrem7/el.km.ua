<?
global $Stihl;
?>
<!doctype html>
<html lang="<? bloginfo('language') ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="format-detection" content="telephone=no"/>
    <title><?= wp_get_document_title() ?></title>
    <? wp_head() ?>
</head>
<body <? body_class() ?>>
<div class="preloader d-none">
    <div class="sk-circle">
        <div class="sk-circle1 sk-child"></div>
        <div class="sk-circle2 sk-child"></div>
        <div class="sk-circle3 sk-child"></div>
        <div class="sk-circle4 sk-child"></div>
        <div class="sk-circle5 sk-child"></div>
        <div class="sk-circle6 sk-child"></div>
        <div class="sk-circle7 sk-child"></div>
        <div class="sk-circle8 sk-child"></div>
        <div class="sk-circle9 sk-child"></div>
        <div class="sk-circle10 sk-child"></div>
        <div class="sk-circle11 sk-child"></div>
        <div class="sk-circle12 sk-child"></div>
    </div>
</div>
<style>
    .preloader {
        position: fixed;
        top: 0;
        right: 0;
        bottom: 0;
        left: 0;
        z-index: 999999;
        display: block;
        background: #f37500;
    }

    .sk-circle {
        margin: auto;
        top: 0;
        bottom: 0;
        left: 0;
        right: 0;
        width: 80px;
        height: 80px;
        position: absolute;
    }

    .sk-circle .sk-child {
        width: 100%;
        height: 100%;
        position: absolute;
        left: 0;
        top: 0;
    }

    .sk-circle .sk-child:before {
        content: '';
        display: block;
        margin: 0 auto;
        width: 15%;
        height: 15%;
        background-color: #fff;
        border-radius: 100%;
        -webkit-animation: sk-circleBounceDelay 1.2s infinite ease-in-out both;
        animation: sk-circleBounceDelay 1.2s infinite ease-in-out both;
    }

    .sk-circle .sk-circle2 {
        -webkit-transform: rotate(30deg);
        -ms-transform: rotate(30deg);
        transform: rotate(30deg);
    }

    .sk-circle .sk-circle3 {
        -webkit-transform: rotate(60deg);
        -ms-transform: rotate(60deg);
        transform: rotate(60deg);
    }

    .sk-circle .sk-circle4 {
        -webkit-transform: rotate(90deg);
        -ms-transform: rotate(90deg);
        transform: rotate(90deg);
    }

    .sk-circle .sk-circle5 {
        -webkit-transform: rotate(120deg);
        -ms-transform: rotate(120deg);
        transform: rotate(120deg);
    }

    .sk-circle .sk-circle6 {
        -webkit-transform: rotate(150deg);
        -ms-transform: rotate(150deg);
        transform: rotate(150deg);
    }

    .sk-circle .sk-circle7 {
        -webkit-transform: rotate(180deg);
        -ms-transform: rotate(180deg);
        transform: rotate(180deg);
    }

    .sk-circle .sk-circle8 {
        -webkit-transform: rotate(210deg);
        -ms-transform: rotate(210deg);
        transform: rotate(210deg);
    }

    .sk-circle .sk-circle9 {
        -webkit-transform: rotate(240deg);
        -ms-transform: rotate(240deg);
        transform: rotate(240deg);
    }

    .sk-circle .sk-circle10 {
        -webkit-transform: rotate(270deg);
        -ms-transform: rotate(270deg);
        transform: rotate(270deg);
    }

    .sk-circle .sk-circle11 {
        -webkit-transform: rotate(300deg);
        -ms-transform: rotate(300deg);
        transform: rotate(300deg);
    }

    .sk-circle .sk-circle12 {
        -webkit-transform: rotate(330deg);
        -ms-transform: rotate(330deg);
        transform: rotate(330deg);
    }

    .sk-circle .sk-circle2:before {
        -webkit-animation-delay: -1.1s;
        animation-delay: -1.1s;
    }

    .sk-circle .sk-circle3:before {
        -webkit-animation-delay: -1s;
        animation-delay: -1s;
    }

    .sk-circle .sk-circle4:before {
        -webkit-animation-delay: -0.9s;
        animation-delay: -0.9s;
    }

    .sk-circle .sk-circle5:before {
        -webkit-animation-delay: -0.8s;
        animation-delay: -0.8s;
    }

    .sk-circle .sk-circle6:before {
        -webkit-animation-delay: -0.7s;
        animation-delay: -0.7s;
    }

    .sk-circle .sk-circle7:before {
        -webkit-animation-delay: -0.6s;
        animation-delay: -0.6s;
    }

    .sk-circle .sk-circle8:before {
        -webkit-animation-delay: -0.5s;
        animation-delay: -0.5s;
    }

    .sk-circle .sk-circle9:before {
        -webkit-animation-delay: -0.4s;
        animation-delay: -0.4s;
    }

    .sk-circle .sk-circle10:before {
        -webkit-animation-delay: -0.3s;
        animation-delay: -0.3s;
    }

    .sk-circle .sk-circle11:before {
        -webkit-animation-delay: -0.2s;
        animation-delay: -0.2s;
    }

    .sk-circle .sk-circle12:before {
        -webkit-animation-delay: -0.1s;
        animation-delay: -0.1s;
    }

    @-webkit-keyframes sk-circleBounceDelay {
        0%, 80%, 100% {
            -webkit-transform: scale(0);
            transform: scale(0);
        }
        40% {
            -webkit-transform: scale(1);
            transform: scale(1);
        }
    }

    @keyframes sk-circleBounceDelay {
        0%, 80%, 100% {
            -webkit-transform: scale(0);
            transform: scale(0);
        }
        40% {
            -webkit-transform: scale(1);
            transform: scale(1);
        }
    }
</style>
<!--Header-->
<header class="header <?= !is_front_page() ? 'header-page' : '' ?>">
    <div class="container">
        <!--top bar-->
        <div class="header-top-bar text-right">
            <?
            $compare = count($Stihl->compare->get());
            $cart = WC()->cart->get_cart_contents_count();
            ?>
            <a href="<? the_permalink(143) ?>"
               class="btn-product-control">Порівняти <?= $compare > 1 ? '(' . $compare . ')' : '' ?></a>
            <a href="<?= wc_get_cart_url() ?>" class="btn-product-control"><i class="fas fa-cart-arrow-down mr-2"></i>
                Мій резерв <?= $cart ? '(' . $cart . ')' : '' ?>
            </a>
        </div>
        <!--main bar-->
        <div class="header-main-bar d-flex justify-content-between align-items-center">
            <a href="<? bloginfo('url') ?>" class="logo">
                <img <? the_image('хедер_лого', 'option') ?>>
            </a>
            <button class="mobile-btn" id="mobile-menu">
                <span></span><span></span><span></span>
            </button>
            <? get_search_form() ?>
            <div class="shop-contact d-flex align-items-center">
                <div class="btn-group-choice">
                    <button class="btn-reset btn-phone active"></button>
                    <button class="btn-reset btn-mail"></button>
                </div>
                <div class="header-contact">
                    <span class="header-phone active">
                        <?
                        while (have_rows('хедер_телефони', 'option')) : the_row(); ?>
                            <a href="<? phoneLink(get_sub_field('телефон')) ?>"><?
                                the_sub_field('телефон'); ?></a>
                        <?endwhile;
                        ?>
                    </span>
                    <span class="header-email">
                      <?
                      while (have_rows('хедер_пошта', 'option')) : the_row(); ?>
                          <a href="mailto:<? the_sub_field('пошта') ?>"><?
                              the_sub_field('пошта'); ?></a>
                      <? endwhile; ?>
                    </span>
                </div>
            </div>
        </div>
        <!--nav bar-->
        <div class="header-nav-bar">
            <?php wp_nav_menu(array(
                'menu' => 'Хедер',
                'container' => null,
                'items_wrap' => '<nav itemscope itemtype="http://schema.org/SiteNavigationElement"><ul  class="menu d-flex justify-content-between">%3$s</ul></nav>',
                'walker' => new WP_Bootstrap_Navwalker,
            )); ?>
            <div class="mobile-phone-block">
                <?
                while (have_rows('хедер_телефони', 'option')) : the_row(); ?>
                    <a href="<? phoneLink(get_sub_field('телефон')) ?>"><?
                        the_sub_field('телефон'); ?></a>
                <?endwhile;
                ?>
                <?
                while (have_rows('хедер_пошта', 'option')) : the_row(); ?>
                    <a href="mailto:<? the_sub_field('пошта') ?>"><?
                        the_sub_field('пошта'); ?></a>
                <? endwhile; ?>
            </div>
        </div>
        <? if (is_front_page()): ?>
            <!--main banner-->
            <div class="header-banner">
                <div id="main-carousel" class="carousel slide" data-ride="carousel">
                    <ol class="carousel-indicators">
                        <?
                        $i = 0;
                        while (have_rows('банери')) : the_row(); ?>
                            <li data-target="#main-carousel" data-slide-to="<?= $i ?>" class="<?=
                            $i == 0 ? 'active' : '' ?>"></li>
                            <?
                            $i++;
                        endwhile;
                        ?>
                    </ol>
                    <div class="carousel-inner">
                        <?
                        $active = 'active';
                        while (have_rows('банери')) : the_row();
                            $image = get_sub_field('картинка');
                            ?>
                            <div class="carousel-item <?= $active ?>">
                                <a href="<? the_sub_field('посилання') ?>">
                                    <img class="d-block w-100" src="<?= $image['url'] ?>"
                                         alt="<?= $image['alt'] ?>">
                                </a>
                            </div>
                            <?
                            $active = '';
                        endwhile;
                        ?>
                    </div>
                    <a class="carousel-control-prev" href="#main-carousel" role="button" data-slide="prev">
                        <span class="carousel-icon"><i class="fa fa-chevron-left"></i></span>
                    </a>
                    <a class="carousel-control-next" href="#main-carousel" role="button" data-slide="next">
                        <span class="carousel-icon"><i class="fa fa-chevron-right"></i></span>
                    </a>
                </div>
            </div>
        <? endif; ?>
    </div>
    <? if (!is_front_page()): ?>
        <!--breadcrumb-->
        <div class="container breadcrumbs">
            <? woocommerce_breadcrumb([
                'delimiter' => '<span class="breadcrumb-separator"> &gt; </span>',
                'wrap_before' => '<nav class="woocommerce-breadcrumb" itemscope itemtype="http://schema.org/BreadcrumbList">'
            ]) ?>
        </div>
    <? endif; ?>
</header>
<!--/Header-->