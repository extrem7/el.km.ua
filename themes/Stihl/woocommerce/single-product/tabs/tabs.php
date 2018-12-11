<?php
if (!defined('ABSPATH')) {
    exit;
}
global $product;

$equipment = get_field('серійне_оснащення');
$accessories = get_field('приладдя');
$video = get_field('відео');
$additionalTab = get_field('додаткове_приладдя');
?>
<div class="box-tab">
    <ul class="nav nav-tabs" id="myTab">
        <li class="nav-item">
            <a class="nav-link active" data-toggle="tab" href="#general">Загальні відомості</a>
        </li>
        <? if ($product->get_attributes()): ?>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#techSettings">Технічні
                    характеристики</a>
            </li>
        <?
        endif;
        if ($equipment): ?>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#equipment">Оснащення</a>
            </li>
        <? endif;
        if (!empty($additionalTab['список'])): ?>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#accessories-additional"><?= $additionalTab['назва'] ?></a>
            </li>
        <?
        endif;
        if ($accessories):?>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#accessories">Приладдя</a>
            </li>
        <? endif;
        if ($video): ?>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#video">Відео</a>
            </li>
        <? endif; ?>
        <li class="nav-item">
            <a class="nav-link" data-toggle="tab" href="#reviews">Відгуки</a>
        </li>
    </ul>
</div>
