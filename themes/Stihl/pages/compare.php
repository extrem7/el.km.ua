<?
/* Template Name: Порівняти */
define('DONOTCACHEPAGE', true);
defined('ABSPATH') || exit;

get_header();
?>
    <main role="main" class="content content-page content-compare container">
        <!--compare product-->
        <?
        $products = $Stihl->compare->get();
        $equipment = [];
        if (!empty($products) && count($products) > 1):
            ?>
            <div class="title title-compare">Порівняння виробів</div>
            <div class="notices-area">
                <? wc_print_notices() ?>
            </div>
            <div class="table-responsive">
                <?
                $posts = [];

                $posts = get_posts([
                    'post_type' => 'product',
                    'post__in' => $products,
                    'posts_per_page' => -1,
                    'post_status' => 'any',
                    'orderby' => 'none'
                ]);
                for ($i = 0; $i < count($products); $i++) {
                    $products[$i] = wc_get_product($products[$i]);
                }

                $attributes = $Stihl->compare->attributes($posts);
                $equipment = $Stihl->compare->equipment($posts);
                $additional = [];
                ?>
                <table class="table table-compare">
                    <tr>
                        <td width="40%"></td>
                        <? foreach ($products as $product):
                            ?>
                            <td class="product-compare">
                                <label for="compareProduct<?= $product->get_id() ?>"><i class="fa fa-times"></i></label>
                                <input type="checkbox" class="custom-control-input reloadAfter d-none"
                                       name="<?= $product->get_id() ?>"
                                       id="compareProduct<?= $product->get_id() ?>" checked>
                            </td>
                        <? endforeach; ?>
                    </tr>
                    <tr>
                        <td></td>
                        <? foreach ($products as $product):
                            $category = '';
                            $allTax = get_the_terms($product->get_id(), 'product_cat');
                            if (!is_wp_error($allTax)) {
                                $category = array_reverse($allTax)[0]->description;
                                if (!$category) {
                                    $category = array_reverse($allTax)[0]->name;
                                }
                            }
                            ?>
                            <td>
                                <a href="<?= $product->get_permalink() ?>" class="compare-name">
                                    <div class="title"><?= $product->get_name() ?></div>
                                    <div class="detail"><?= $category ?></div>
                                </a>
                            </td>
                        <? endforeach; ?>
                    </tr>
                    <tr>
                        <td></td>
                        <? foreach ($products as $product):
                            $img = wp_prepare_attachment_for_js($product->get_image_id())
                            ?>
                            <td>
                                <div class="compare-img d-flex align-items-center justify-content-center">
                                    <img src="<?= $img['url'] ?>" class="img-fluid" alt="<?= $img['alt'] ?>">
                                </div>
                            </td>
                        <? endforeach; ?>
                    </tr>
                    <? foreach ($attributes as $key => $options):
                        $attribute = get_terms($key, ['hide_empty' => false]);
                        $sup = '';
                        foreach ($attribute as $option) {
                            if ($option->description) {
                                $additional[] = $option->description;
                                $sup = count($additional) . ')';
                            }
                        }
                        ?>
                        <tr>
                            <td width="40%"><?= wc_attribute_label($key) ?></td>
                            <? foreach ($options as $option): ?>
                                <td><?= $option ?><sup> <?= $sup ?></sup></td>
                            <? endforeach; ?>
                        </tr>
                    <? endforeach;
                    if (empty($equipment)):?>
                        <tr class="table-margin">
                            <td></td>
                        </tr>
                        <tr>
                            <td>Ціна</td>
                            <? foreach ($products as $product): ?>
                                <td class="price"><?= wc_price($product->get_price()) ?> *</td>
                            <? endforeach; ?>
                        </tr>
                        <tr>
                            <td></td>
                            <? foreach ($products as $product):
                                if ($product->is_visible()):
                                    ?>
                                    <td>
                                        <a href="<?= $product->add_to_cart_url() ?>" class="add-to-cart btn-ajax">В
                                            резерв</a>
                                    </td>
                                <?
                                endif;
                            endforeach; ?>
                        </tr>
                    <? endif; ?>
                </table>
            </div>
            <? if ($additional): ?>
            <div class="compare-detail">
                <? for ($i = 0; $i < count($additional); $i++): ?>
                    <span class="top"><?= $i + 1 ?></span> <?= $additional[$i] ?> <br>
                <? endfor; ?>
            </div>
        <? endif; ?>
            <!--accessories product-->
            <?
            if (!empty($equipment)):
                ?>
                <div class="title title-compare">Серійне і спеціальне оснащення</div>
                <div class="table-responsive">
                    <table class="table table-compare table-compare-accessories">
                        <tr>
                            <td width="40%"></td>
                            <? foreach ($products as $product): ?>
                                <td class="title"><?= $product->get_name() ?></td>
                            <? endforeach; ?>
                        </tr>
                        <? foreach ($equipment as $key => $data): ?>
                            <tr>
                                <td width="40%"><a data-fancybox href="<?= $data['img'];
                                    unset($data['img']) ?>"><?= $key ?></a></td>
                                <? foreach ($data['options'] as $option): ?>
                                    <td class="<?= $option ?>"><span></span></td>
                                <? endforeach; ?>

                            </tr>
                        <? endforeach; ?>
                        <tr class="table-margin">
                            <td></td>
                        </tr>
                        <tr>
                            <td>Ціна</td>
                            <? foreach ($products as $product): ?>
                                <td class="price"><?= wc_price($product->get_price()) ?> *</td>
                            <? endforeach; ?>
                        </tr>
                        <tr>
                            <td></td>
                            <? foreach ($products as $product):
                                if ($product->is_visible()):
                                    ?>
                                    <td>
                                        <a href="<?= $product->add_to_cart_url() ?>" class="add-to-cart btn-ajax">В
                                            резерв</a>
                                    </td>
                                <?
                                endif;
                            endforeach; ?>
                        </tr>
                    </table>
                </div>
                <div class="accessories-detail">
                    <div class="active"><span class="mr-2"></span>Серійне оснащенння</div>
                    <div class="no-active"><span class="mr-2"></span>Додаткове оснащенння</div>
                </div>
            <? endif;
        else: ?>
            <div class="title title-compare">В порівнянні продуктів - <?= count($products) ?>. Порівнювати можна лише
                від 2 до 4
                товарів.
            </div>
            <div class="notices-area">
                <? wc_print_notices() ?>
            </div>
            <p class="return-to-shop">
                <a class="button wc-backward btn-orange"
                   href="<?php echo esc_url(apply_filters('woocommerce_return_to_shop_redirect', wc_get_page_permalink('shop'))); ?>">
                    <?php _e('Return to shop', 'woocommerce') ?>
                </a>
            </p>
        <? endif; ?>
    </main>
<?
$Stihl->servicesBanner();
$Stihl->seoText();
get_footer('shop');