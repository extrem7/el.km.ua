<?
global $category;
$category = get_term($category);
$categoryImage = categoryImage($category->term_id)['url'];
?>
<a href="<?= get_term_link($category) ?>"
   class="card-category-product d-flex align-items-end">
    <div class="category-img" style="background-image: url(<?= $categoryImage ?>)"></div>
    <div class="category-box-title"><?= $category->name ?></div>
</a>