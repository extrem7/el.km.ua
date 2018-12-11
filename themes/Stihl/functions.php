<?php

add_action('admin_notices', function () {
    if (!function_exists('StihlActivation'))
        echo '<div class="error"><p>' . 'Увага: для роботи сайту потрібно увімкнути плагін Stihl' . '</p></div>';
});