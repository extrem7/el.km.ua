<?php
require_once "StihlFilters.php";

class StihlCompare
{
    private $compare = [];

    public function __construct()
    {
        session_start();
        if (!isset($_SESSION['compare'])) $_SESSION['compare'] = [
            'category' => 0,
            'products' => []
        ];
        $this->compare = &$_SESSION['compare'];
        $this->wpAjax();
    }

    private function wpAjax()
    {
        add_action('wp_ajax_compare_add', [$this, 'toggleItem']);
        add_action('wp_ajax_nopriv_compare_add', [$this, 'toggleItem']);
    }

    public function toggleItem()
    {
        $id = apply_filters('woocommerce_add_to_cart_product_id', absint($_POST['id']));
        $product = wc_get_product($id);
        $response = [];
        $compare = get_permalink(143);
        $category = "";
        if ($product) {
            $category = wp_get_post_terms($id, 'product_cat')[0];
            if ($this->compare['category'] !== $category->term_id) {
                $this->compare['products'] = [];
            }
            $this->compare['category'] = $category->term_id;
            $category = $category->description;
            if(!$category){
                $category = $category->name;
            }
        }

        if (count($this->compare) >= 4) {
            $response = ['status' => 'already'];
            ob_start();
            wc_print_notice('<a href="' . $compare . '" class="button wc-forward">Переглянути</a> Неможливо порівняти більше 4 товарів');
            ob_end_flush();
            $response['html'] = ob_get_contents();
            ob_clean();
        } else if (!in_array($id, $this->compare['products'])) {
            $this->compare['products'][] = $id;
            $response = ['status' => 'success'];
            ob_start();
            wc_print_notice('<a href="' . $compare . '" class="button wc-forward">Переглянути</a> “' . $category . ' ' . get_the_title($id) . '” додано в порівняння.');
            ob_end_flush();
            $response['html'] = ob_get_contents();
            ob_clean();
        } else {
            unset($this->compare['products'][array_search($id, $this->compare['products'])]);
            sort($this->compare['products']);

            $response = ['status' => 'already'];
            ob_start();
            wc_print_notice('<a href="' . $compare . '" class="button wc-forward">Переглянути</a> “' . $category . ' ' . get_the_title($id) . '” видаленно з порівняння');
            ob_end_flush();
            $response['html'] = ob_get_contents();
            ob_clean();
        }
        echo json_encode($response);
        die();
    }

    public function inCompare($id)
    {
        return in_array($id, $this->compare['products']);
    }

    public function get()
    {
        for ($i = 0; $i < count($this->compare['products']); $i++) {
            if (!wc_get_product($this->compare['products'][$i])) {
                unset($this->compare['products'][$i]);
            }
        }
        sort($this->compare['products']);
        return $this->compare['products'];
    }

    public function attributes($posts)
    {

        $currentAttributes = StihlFilters::currentAttributes($posts)[0];

        $attributes = [];

        foreach ($posts as $post) {
            foreach ($currentAttributes as $attribute => $array) {
                for ($i = 0; $i < count($posts); $i++) {
                    $product = wc_get_product($posts[$i]);
                    if ($product->get_attribute($attribute)) {
                        $attributes[$attribute][$i] = $product->get_attribute($attribute);
                    } else {
                        $attributes[$attribute][$i] = '-';
                    }
                }
            }
        }

        return $attributes;
    }

    public function equipment($posts)
    {
        $equipment = [];
        $serialEquipment = [];
        $additionalEquipment = [];
        for ($i = 0; $i < count($posts); $i++) {
            $serial = get_field('серійне_оснащення', $posts[$i]);
            $additional = get_field('додаткове_оснащення', $posts[$i]);
            if (!empty($serial)) {
                foreach ($serial as $item) {
                    $equipment[$item->post_title]['options'][$i] = 'active';
                    $equipment[$item->post_title]['img']=get_the_post_thumbnail_url($item->ID);
                }
            }
            if (!empty($additional)) {
                foreach ($additional as $item) {
                    $equipment[$item->post_title]['options'][$i] = 'no-active';
                    $equipment[$item->post_title]['img']=get_the_post_thumbnail_url($item->ID);
                }
            }
        }

        foreach ($equipment as $key => $field) {
            for ($i = 0; $i < count($posts); $i++) {
                $equipment[$key]['options'][$i] = $equipment[$key]['options'][$i] ? $equipment[$key]['options'][$i] : 'none';
            }
            ksort($equipment[$key]['options']);
        }
        return $equipment;
    }
}