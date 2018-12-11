<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
global $post;
?>
<div class="tab-pane fade show active" id="general">
    <div class="separator"></div>
    <div class="product-description">
        <p><?= apply_filters( 'the_content', wpautop( get_post_field( 'post_content', $id ), true ) ); ?></p>
    </div>
</div>

