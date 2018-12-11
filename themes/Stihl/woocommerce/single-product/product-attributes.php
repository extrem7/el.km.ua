<?php
if (!defined('ABSPATH')) {
    exit;
}
global $Stihl, $product;
$attributes = $product->get_attributes();

if ($attributes):
    ?>
    <div class="tab-pane fade show" id="techSettings">
        <div class="product-title">Технічні характеристики</div>
        <table class="table-technical-settings">
            <? $Stihl->woo->printAttributes($product) ?>
        </table>
        <div class="technical-info mt-3">
            <?
            $i = 1;
            if (have_rows('пояснення_характеристик')): ?>
                <div class="compare-detail">
                    <? while (have_rows('пояснення_характеристик')): the_row() ?>
                        <sup class="top"><?= $i ?></sup> <? the_sub_field('пояснення') ?> <br>
                        <? $i++; endwhile; ?>
                </div><br>
            <? endif; ?>
            <? the_field('товар_текст', 'option') ?>
        </div>
    </div>
<? endif; ?>