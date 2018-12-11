<?php

if (!defined('ABSPATH')) {
    exit;
}
global $Stihl, $post;

?>
<div class="tab-pane fade show" id="reviews">
    <div class="reviews-container">
        <?
        $comments = get_comments([
            'parent' => 0,
            'post_id' => get_the_ID(),
            'status'=>'approve'
        ]);
        if (!empty($comments)):?>
            <div class="title">Відгуки про модель</div>
            <? $Stihl->woo->comments($comments);
        else: ?>
            <div class="title">Відгуків немає</div>
            <div class="separator"></div>
        <? endif; ?>
        <div class="title">Додати відгук</div>
        <div class="separator"></div>
        <form action="<? bloginfo('url') ?>/wp-comments-post.php" method="post">
            <div class="form-group">
                <label class="label-form">Ваше ім’я*</label>
                <input type="text" name="author" class="control-form">
            </div>
            <div class="form-group">
                <label class="label-form">Ваш відгук*</label>
                <textarea name="comment" class="control-form" id="" cols="30"
                          rows="10"></textarea>
            </div>
            <div class="form-group">
                <button type="submit" name="submit" class="btn-orange w-100" value="">Додати
                    коментар
                </button>
                <input type="hidden" name="comment_post_ID" value="<? the_ID() ?>"
                       id="comment_post_ID">
                <input type="hidden" name="comment_parent" id="comment_parent" value="0">
            </div>
        </form>
    </div>
</div>