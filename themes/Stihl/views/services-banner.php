<!--Banner-->
<section class="section-banner-carousel container mb-1">
    <div class="owl-carousel owl-theme banner-carousel" id="banner-carousel">
        <? while (have_rows('банер_сервісів', 'option')) : the_row();
            ?>
            <div class="item"><a href="<? the_sub_field('посилання') ?>"><img <? repeater_image('картинка') ?>></a>
            </div>
        <? endwhile; ?>
    </div>
</section>
<!--/Banner-->