<!--Footer-->
<footer class="footer">
    <div class="container">
        <?php wp_nav_menu(array(
            'menu' => 'Футер',
            'container' => null,
            'items_wrap' => '<ul  class="footer-menu d-flex justify-content-between">%3$s</ul>',
        )); ?>
        <div class="footer-line mt-2"></div>
        <div class="footer-address-line d-flex align-items-center justify-content-between mt-2">
            <div class="footer-phone d-flex align-items-center">
                <img src="<?= path() ?>assets/img/icons/phone.png" alt="" width="26">
                <div>
                    <?
                    while (have_rows('футер_телефони', 'option')) : the_row(); ?>
                        <span><?
                            the_sub_field('телефон'); ?></span>
                    <?endwhile;
                    ?>
                    <a href="<? the_permalink(152) ?>" class="more-information" target="_blank">більше</a>
                </div>
            </div>
            <div class="footer-mail d-flex align-items-center">
                <img src="<?= path() ?>assets/img/icons/mail.png" alt="" width="28">
                <div>
                    <span><? the_field('футер_пошта', 'option') ?></span>
                    <a href="<? the_permalink(152) ?>" class="more-information" target="_blank">більше</a>
                </div>
            </div>
            <div class="footer-maps d-flex align-items-center">
                <img src="<?= path() ?>assets/img/icons/market.png" alt="" width="20">
                <div>
                    <span><? the_field('футер_адреса', 'option') ?></span>
                    <a href="<? the_permalink(152) ?>" class="more-information" target="_blank">більше</a>
                </div>
            </div>
            <div class="media-block d-flex">
                <? if (get_field('футер_фейсбук', 'option')): ?>
                    <a href="<? the_field('футер_фейсбук', 'option') ?>"
                       class="media-link d-flex align-items-center justify-content-center"><i
                                class="fab fa-facebook-f"></i></a>
                <? endif; ?>
                <? if (get_field('футер_інстаграм', 'option')): ?>
                    <a href="<? the_field('футер_інстаграм', 'option') ?>"
                       class="media-link d-flex align-items-center justify-content-center"><i
                                class="fab fa-instagram"></i></a>
                <? endif; ?>
                <? if (get_field('футер_ютуб', 'option')): ?>
                    <a href="<? the_field('футер_ютуб', 'option') ?>"
                       class="media-link d-flex align-items-center justify-content-center"><i
                                class="fab fa-youtube"></i></a>
                <? endif; ?>
                <? if (get_field('футер_скайп', 'option')): ?>
                    <a href="<? the_field('футер_скайп', 'option') ?>"
                       class="media-link d-flex align-items-center justify-content-center"><i
                                class="fab fa-skype"></i></a>
                <? endif; ?>
            </div>
        </div>
    </div>
</footer>
<!--/Footer-->
<? wp_footer() ?>
</body>
</html>