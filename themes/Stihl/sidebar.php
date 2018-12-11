<?
global $Stihl, $parentCategory, $children;
?>
<div class="col-md-12 col-lg-3 aside-content">
    <button class="mobile-filter btn-reset" id="close-filter">
        <span></span><span></span><span></span>
    </button>
    <div class="d-flex justify-content-between mb-3 btn-group-catalog">
        <? if (!is_search()): ?>
            <button class="btn-catalog <?= !is_filtered() ? 'active' : '' ?> <?= !empty($children) || is_product() || is_search() || !is_tax() ? 'w-100' : '' ?>"
                    id="catalog">Каталог
            </button>
        <? endif; ?>
        <? if (empty($children) && !is_product() && !is_search() && is_tax()): ?>
            <button class="btn-catalog ml-1 <?= is_filtered() ? 'active' : '' ?>" id="filter">Фільтр</button>
        <? endif; ?>
    </div>
    <aside class="left-aside">
        <!--filter-->
        <? if (empty($children) && !is_product() && !is_search()): ?>
            <div <?= !is_filtered() ? 'style="display: none"' : '' ?> class="catalog-filter">
                <form action="<? ?>">
                    <div class="filter-group">
                        <div class="title">Ціна</div>
                        <? $Stihl->filter->price(); ?>
                    </div>
                    <? $Stihl->filter->attributes(); ?>
                    <div class="text-center mt-3">
                        <button type="submit" class="btn-submit-filter mb-3">Відфільтрувати</button>
                        <? if (is_filtered()): ?>
                            <a href="<?= parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH) ?>"
                               class="btn-submit-filter d-inline-block">Cкинути фільтр</a>
                        <? endif; ?>
                    </div>
                </form>
            </div>
        <? endif; ?>
        <!--catalog menu-->
        <ul <?= is_filtered() ? 'style="display: none"' : '' ?> class="catalog-menu">
            <?
            if (!is_search()) {
                wp_list_categories(['child_of' => $parentCategory, 'taxonomy' => 'product_cat', 'title_li' => '', 'walker' => new Walker_Catalog(),

                ]);
            }
            ?>
        </ul>
        <div class="box-catalog-link">
            <a href="<?= get_term_link($Stihl->woo->stihlID()) ?>" class="">Продукция Stihl</a>
            <a href="<?= get_term_link($Stihl->woo->vikingID()) ?>" class="">Продукция Viking</a>
        </div>
    </aside>
</div>