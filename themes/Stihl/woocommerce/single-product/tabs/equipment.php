<?
global $post;
?>
<div class="tab-pane fade show" id="equipment">
    <div class="equipment">
        <div class="title">Серійне оснащення</div>
        <?
        $serial = get_field('серійне_оснащення');
        if (!empty($serial)):
            $mergePoint = count($serial);
            $additional = get_field('додаткове_оснащення');
            if (!empty($additional)) {
                $equipment = array_merge($serial, $additional);
            } else {
                $equipment = $serial;
            }
            $i = 0;
            foreach ($equipment as $post):
                if ($i == $mergePoint): ?>
                    <div class="title">Додаткове оснащення</div>
                <? endif; ?>
                <div class="equipment-item d-flex justify-content-between align-items-center">
                    <a class="equipment-img gallery-fancybox" data-fancybox="equipment"
                       href="<? the_post_thumbnail_url() ?>"
                       style="background-image: url('<? the_post_thumbnail_url() ?>')"></a>
                    <div>
                        <div class="equipment-title"><? the_title() ?></div>
                        <div class="equipment-text"><?= apply_filters('the_content', wpautop(get_post_field('post_content', $id), true)); ?></div>
                    </div>
                </div>
                <?
                $i++;
            endforeach;
            wp_reset_query();
        endif;
        ?>
    </div>
</div>