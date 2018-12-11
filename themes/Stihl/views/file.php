<? $file = get_sub_field('файл');
$fileSize = intval(filesize(get_attached_file($file['id'])) / 1024);
?>
<div class="box-instruction d-flex justify-content-between align-items-center">
    <div class="name"><? the_sub_field('назва') ?></div>
    <div><? the_sub_field('модель') ?></div>
    <div><?= $fileSize ?> KB</div>
    <a href="<?= $file['url'] ?>" class="btn-orange">Завантажити</a>
</div>