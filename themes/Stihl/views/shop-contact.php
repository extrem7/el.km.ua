<div class="shop-info">
    <div class="shop-title mb-4"><? the_sub_field('назва') ?></div>
    <div class="shop-info-text">
        <div class="d-flex align-items-start xs-flex-column">
            <div class="d-flex align-items-center">
                <img src="<?= path() ?>img/icons/makrec-c.png" alt="">
                <div class="pl-3"><? the_sub_field('адреса') ?></div>
            </div>
            <? if (get_sub_field('пошта')): ?>
                <div class="d-flex align-items-center ml-5">
                    <img src="<?= path() ?>img/icons/email-c.png" alt="">
                    <div class="pl-3">
                        <a href="mailto:<? the_sub_field('пошта') ?>"><? the_sub_field('пошта') ?></a>
                    </div>
                </div>
            <? endif; ?>
        </div>
    </div>
    <div class="shop-info-text">
        <div class="d-flex align-items-center xs-justify-center">
            <img src="<?= path() ?>img/icons/phone-c.png" alt="">
            <div class="pl-3">
                <?
                $phones = get_sub_field('телефони');
                $mainPhone = $phones['основний'];
                $servicePhone = $phones['майстерня'];
                ?>
                <a href="<? phoneLink($mainPhone) ?>"><?= $mainPhone ?></a><br/>
                <? if ($servicePhone): ?>
                    <a href="<? phoneLink($servicePhone) ?>"><?= $servicePhone ?></a><span> (Майстерня)</span>
                <? endif; ?>
            </div>
        </div>
    </div>
    <? $time = get_sub_field('графік_роботи') ?>
    <div class="shop-info-text">
        <div class="d-flex xs-flex-column">
            <div>
                <div class="shop-title">Графік роботи:</div>
                <div><span class="white-color">Будні дні</span> <?= $time['будні'] ?></div>
            </div>
            <div class="ml-5">
                <div class="d-flex align-items-end">
                    <div class="mr-1 white-color">Вихідні</div>
                    <div>
                        <div>Сб. <?= $time['субота'] ?></div>
                        <div>Нд. <?= $time['неділя'] ?></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>