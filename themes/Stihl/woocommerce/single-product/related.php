<?
define('DONOTCACHEPAGE', true);
if (!defined('ABSPATH')) {
    exit;
}
global $Stihl, $post, $product;
if ($product->get_type() == 'variable'):?>
    <div class="product-modification">
    <div class="separator"></div>
    <div class="d-flex justify-content-between mt-2 mb-3">
        <div class="mod-title">Модель</div>
        <div class="mod-title">Ціна:</div>
    </div>
    <?
    $variations = [];
    $variations = $product->get_available_variations();
    //pre($variations);
    foreach ($variations as $variation): ?>
        <form class="product-mod-item d-flex justify-content-between align-items-center" method="post">
            <?// pre($variation) ?>
            <div class="mod-description w-50"><?= $variation['variation_description'] ?></div>
            <?
            $salePrice = $variation['display_price'];
            if ($variation['display_regular_price'] != $variation['display_price']) {
            //    $regularPrice = $variation['display_regular_price'];
            }
            if (!$salePrice) {
                $salePrice = $regularPrice;
                $regularPrice = false;
            }
            ?>
            <div class="mod-price w-50"><?= wc_price($salePrice) ?> *
                <? if ($regularPrice): ?>
                    <span class="old-price"><?= wc_price($regularPrice) ?> *</span>
                <? endif; ?>
            </div>
            <div>
                <button type="submit" class="add-to-cart text-center">В резерв</button>
                <input type="hidden" name="add-to-cart" value="<?= absint($product->get_id()); ?>"/>
                <input type="hidden" name="product_id" value="<?= absint($product->get_id()); ?>"/>
                <input type="hidden" name="variation_id" class="variation_id"
                       value="<?= $variation['variation_id'] ?>"/>
            </div>
        </form>
    <?
    endforeach;
    ?>
    </div>
<?
endif;
$modifications = get_field('інші_модифікації');
if ($modifications):?>
    <!--product mod-->
    <div class="product-modification">
        <div class="separator"></div>
        <div class="product-title">Інші модифікації</div>
        <div class="d-flex justify-content-between mt-2 mb-3">
            <div class="mod-title">Порівняти</div>
            <div class="mod-title">Модель</div>
            <div class="mod-title">Ціна:</div>
        </div>
        <? foreach ($modifications as $post):
            $product = wc_get_product($post->ID);
            ?>
            <div class="product-mod-item d-flex justify-content-between align-items-center">
                <div class="mod-control">
                    <div class="product-compare custom-control custom-checkbox">
                        <?
                        $checked = $Stihl->compare->inCompare(get_the_ID()) ? 'checked' : '';
                        ?>
                        <input type="checkbox" class="custom-control-input" name="<? the_ID() ?>"
                               id="compareProduct<? the_ID() ?>" <?= $checked ?>>
                        <label class="custom-control-label " for="compareProduct<? the_ID() ?>"></label>
                    </div>
                </div>
                <a href="<? the_permalink() ?>" class="mod-name"><? the_title() ?></a>
                <div class="mod-desc"><?= get_the_excerpt() ?></div>
                <?
                $salePrice = $product->get_sale_price();
                $regularPrice = $product->get_regular_price();
                if (!$salePrice) {
                    $salePrice = $regularPrice;
                    $regularPrice = false;
                }
                if ($product->get_type() == 'variable') {
                    $salePrice = $product->get_price();
                }
                ?>
                <div class="mod-price"><?= wc_price($salePrice) ?> *
                    <? if ($regularPrice): ?>
                        <span class="old-price"><?= wc_price($regularPrice) ?> *</span>
                    <? endif; ?>
                </div>
                <div>
                    <a href="<?= $product->add_to_cart_url() ?>" class="add-to-cart btn-ajax text-center">В резерв</a>
                </div>
            </div>
        <? endforeach;
        wp_reset_query();
        ?>
        <? the_field('роздрібна_ціна') ?>
        <? the_field('товар_текст', 'option') ?>
    </div>
<? endif; ?>