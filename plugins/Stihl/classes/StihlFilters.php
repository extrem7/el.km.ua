<?php

class StihlFilters
{
    public function price()
    {

        $min = $this->minMaxPrice()->min_price;
        $max = $this->minMaxPrice()->max_price;

        $min_price = isset($_GET['min_price']) ? wc_clean(wp_unslash($_GET['min_price'])) : apply_filters('woocommerce_price_filter_widget_min_amount', $min);
        $max_price = isset($_GET['max_price']) ? wc_clean(wp_unslash($_GET['max_price'])) : apply_filters('woocommerce_price_filter_widget_max_amount', $max);
        echo "<div class=\"d-flex mb-4 justify-content-between\">";
        echo "<input type=\"text\" name=\"min_price\" class=\"filter-control\" value=\"$min_price\" data-min=\"$min\" id=\"input-with-keypress-0\" disabled>";
        echo "<input type=\"text\" name=\"max_price\" class=\"filter-control\" value=\"$max_price\" data-max=\"$max\" id=\"input-with-keypress-1\" disabled>";
        echo "</div>";
        echo "<div id=\"range\"></div>";
    }

    public function attributes()
    {
        $attributes = $this::currentAttributes();
        $currentAttributes = $attributes[0];
        $attributeCount = $attributes[1];
        $chosenAttributes = WC_Query::get_layered_nav_chosen_attributes();

        foreach ($currentAttributes as $key => $terms) {
            $attribute = get_taxonomy($key);
            if ($attribute) {
                $attrName = $attribute->labels->singular_name;
                $attrSlug = preg_replace('/pa/', 'filter', $attribute->name);
                $attrQueryType = preg_replace('/pa/', 'query_type', $attribute->name);
                $result = '';
                if (isset($_REQUEST[$attrSlug])) {
                    $result = $_REQUEST[$attrSlug];
                }
                echo "<div class='filter-group'>";
                echo "<div class='title'>$attrName</div>";
                echo "<input type='hidden' class='result' name='$attrSlug' value='$result'>";
                echo "<input type='hidden' class='queryType' name='$attrQueryType' value='or'>";
                $options = [];
                foreach ($terms as $term) {
                    $term = get_term($term, $key);
                    $termValue = urldecode($term->slug);
                    $termName = $term->name;
                    $termId = $term->term_id;
                    $termChecked = '';
                    $count = $attributeCount[$key][$termId];
                    if (isset($chosenAttributes[$attribute->name]) && !empty($chosenAttributes[$attribute->name]['terms'])) {
                        $termChecked = in_array(mb_strtolower(urlencode_deep($termValue)), $chosenAttributes[$attribute->name]['terms']) ? 'checked' : '';
                    }
                    $options[] = ['termId' => $termId, 'termValue' => $termValue, 'termChecked' => $termChecked, 'termName' => $termName, 'count' => $count];
                }
                $options = sort_by_key($options, 'termName');
                foreach ($options as $option) {
                    $termValue = $option['termValue'];
                    $termName = $option['termName'];
                    $termId = $option['termId'];
                    $termChecked = $option['termChecked'];
                    $count = $option['count'];

                    echo " <div class='custom-control custom-checkbox'>";
                    echo "<input type='checkbox' class='custom-control-input' id='$termId' value='$termValue' $termChecked>";
                    echo " <label class='custom-control-label' for='$termId'>";
                    echo "<span class='title-option'>$termName</span>";
                    echo "<span class='title-count'>($count)</span></label></div>";
                }
                echo "</div>";
            }
        }
    }

    public static function currentAttributes($posts = null)
    {

        if (is_null($posts)) {
            $category = get_queried_object();

            $posts = get_posts([
                'post_type' => 'product',
                'post_status' => 'publish',
                'tax_query' => [
                    [
                        'taxonomy' => 'product_cat',
                        'field' => 'id',
                        'terms' => $category->term_id,
                        'operator' => 'IN'
                    ]
                ],
                'meta_query' => [
                    [
                        'key' => '_stock_status',
                        'value' => 'instock'
                    ]
                ]
            ]);
        }

        $currentAttributes = [];
        $uniqueAttributes = [];

        foreach ($posts as $post) {
            $attributes = wc_get_product($post->ID)->get_attributes();

            foreach ($attributes as $attr) {
                $key = $attr->get_name();

                if (!in_array($key, $uniqueAttributes) && $attr->is_taxonomy()) {
                    array_push($uniqueAttributes, $key);
                }
            }
        }
        $currentAttributes = array_fill_keys($uniqueAttributes, []);
        $attributeCount = $currentAttributes;

        foreach ($posts as $post) {
            $attrs = wc_get_product($post->ID)->get_attributes();
            foreach ($attrs as $attr) {
                if ($attr->is_taxonomy()) {
                    $key = $attr->get_name();
                    foreach ($attr->get_options() as $option) {
                        if (!in_array($option, $currentAttributes[$key])) {
                            array_push($currentAttributes[$key], $option);
                        }
                        $attributeCount[$key][$option]++;
                    }
                }
            }
        }


        return [$currentAttributes, $attributeCount];
    }

    public function minMaxPrice()
    {
        global $wpdb;
        $category = get_queried_object();

        $categoryQuery = new WP_Query([
            'tax_query' => [
                [
                    'taxonomy' => 'product_cat',
                    'field' => 'id',
                    'terms' => $category->term_id,
                    'operator' => 'IN'
                ]
            ],
            'meta_query' => [
                [
                    'key' => '_stock_status',
                    'value' => 'instock'
                ]
            ]
        ]);
        $args = $categoryQuery->query_vars;
        $tax_query = isset($args['tax_query']) ? $args['tax_query'] : array();
        $meta_query = isset($args['meta_query']) ? $args['meta_query'] : array();

        if (!is_post_type_archive('product') && !empty($args['taxonomy']) && !empty($args['term'])) {
            $tax_query[] = array(
                'taxonomy' => $args['taxonomy'],
                'terms' => array($args['term']),
                'field' => 'slug',
            );
        }

        foreach ($meta_query + $tax_query as $key => $query) {
            if (!empty($query['price_filter']) || !empty($query['rating_filter'])) {
                unset($meta_query[$key]);
            }
        }

        $meta_query = new WP_Meta_Query($meta_query);
        $tax_query = new WP_Tax_Query($tax_query);

        $meta_query_sql = $meta_query->get_sql('post', $wpdb->posts, 'ID');
        $tax_query_sql = $tax_query->get_sql($wpdb->posts, 'ID');

        $sql = "SELECT min( FLOOR( price_meta.meta_value ) ) as min_price, max( CEILING( price_meta.meta_value ) ) as max_price FROM {$wpdb->posts} ";
        $sql .= " LEFT JOIN {$wpdb->postmeta} as price_meta ON {$wpdb->posts}.ID = price_meta.post_id " . $tax_query_sql['join'] . $meta_query_sql['join'];
        $sql .= " 	WHERE {$wpdb->posts}.post_type IN ('" . implode("','", array_map('esc_sql', apply_filters('woocommerce_price_filter_post_type', array('product')))) . "')
			AND {$wpdb->posts}.post_status = 'publish'
			AND price_meta.meta_key IN ('" . implode("','", array_map('esc_sql', apply_filters('woocommerce_price_filter_meta_keys', array('_price')))) . "')
			AND price_meta.meta_value > '' ";
        $sql .= $tax_query_sql['where'] . $meta_query_sql['where'];

        $search = WC_Query::get_main_search_query_sql();
        if ($search) {
            $sql .= ' AND ' . $search;
        }

        return $wpdb->get_row($sql); // WPCS: unprepared SQL ok.
    }
}