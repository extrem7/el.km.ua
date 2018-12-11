<div class="owl-carousel owl-theme banner-carousel" id="certificate-carousel">
    <?
    $certificates = get_field('сертифікати', 193);
    foreach ($certificates as $certificate):
        ?>
        <div class="item"><a data-fancybox="gallery" href="<?= $certificate['url'] ?>" class="gallery-fancybox"><img
                        src="<?= $certificate['sizes']['medium'] ?>" alt="<?= $certificate['alt'] ?>"></a></div>
    <? endforeach; ?>
</div>