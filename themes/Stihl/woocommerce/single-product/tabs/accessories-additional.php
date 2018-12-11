<?php
if (!defined('ABSPATH')) {
    exit;
}
global $Stihl, $post;
$accessories = get_field('додаткове_приладдя');
if ($accessories):
    ?>
    <div class="tab-pane fade show" id="accessories-additional">
        <!--accessories-->
        <div class="product-title"><?= $accessories['назва'] ?></div>
        <div class="accessories">
            <?
            foreach ($accessories['список'] as $post):
                setup_postdata($post);
                $product = wc_get_product($post->ID);
                $attributes = $product->get_attributes();
                $additional = [];
                ?>
                <div class="accessories-item">
                    <div class="d-flex justify-content-between mb-4">
                        <a class="accessories-img gallery-fancybox" data-fancybox="accessories"
                           href="<? the_post_thumbnail_url() ?>"
                           style="background-image: url('<? the_post_thumbnail_url() ?>')"></a>
                        <div>
                            <div class="accessories-title title"><?= $product->get_title() ?></div>
                            <div class="accessories-text">
                                <?= apply_filters('the_content', wpautop(get_post_field('post_content', $id), true)); ?>
                            </div>
                        </div>
                    </div>
                    <!--tech settings-->
                    <? if ($attributes): ?>
                        <div class="product-title">Технічні характеристики</div>
                        <table class="table-technical-settings">
                            <? $Stihl->woo->printAttributes($product) ?>
                        </table>
                        <br>
                        <?
                        $i = 1;
                        if (have_rows('пояснення_характеристик')): ?>
                            <div class="compare-detail">
                                <? while (have_rows('пояснення_характеристик')): the_row() ?>
                                    <sup class="top"><?= $i ?></sup> <? the_sub_field('пояснення') ?> <br>
                                    <? $i++; endwhile; ?>
                            </div><br>
                        <? endif; ?>
                    <? endif; ?>
                    <!--product mod-->

                    <div class="product-modification mb-3 mt-3">
                        <div class="d-flex justify-content-between mt-2 mb-3">
                            <div class="mod-title">Порівняти</div>
                            <div class="mod-title">Модель</div>
                            <div class="mod-title">Ціна:</div>
                        </div>
                        <div class="product-mod-item d-flex justify-content-between align-items-center">
                            <div class="mod-control">
                                <div class="product-compare custom-control custom-checkbox">
                                    <?
                                    $checked = $Stihl->compare->inCompare(get_the_ID()) ? 'checked' : '';
                                    ?>
                                    <input type="checkbox" class="custom-control-input" name="<? the_ID() ?>"
                                           id="compareProduct<? the_ID() ?>" <?= $checked ?>>
                                    <label class="custom-control-label "
                                           for="compareProduct<? the_ID() ?>"></label>
                                </div>
                            </div>
                            <div class="mod-desc"><?= $product->get_title() ?></div>
                            <div class="mod-price"><?= $product->get_regular_price() ?> грн. *</div>
                            <div>
                                <a href="<?= $product->add_to_cart_url() ?>" class="add-to-cart btn-ajax text-center">В
                                    резерв</a>
                            </div>
                        </div>
                        <p><? the_field('товар_текст', 'option') ?></p>
                    </div>
                </div>
            <? endforeach;
            wp_reset_query();
            ?>
        </div>
    </div>
<? endif; ?>