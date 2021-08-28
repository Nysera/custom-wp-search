<?php

// enqueue scripts
function enqueue_scripts() {
    // enqueue jquery
    wp_enqueue_script('jquery');
    // jquery ui slider
    wp_enqueue_script( 'jquery-ui-slider' );
    // enuque jquery ui stylesheet
    wp_enqueue_style("jquery-ui-min", get_template_directory_uri() . "/resources/css/vendor/jquery-ui.min.css", array(), false);
    // main stylesheet
    wp_enqueue_style("main", get_template_directory_uri() . "/resources/css/main.css", array(), false);
    // main javascript
    wp_enqueue_script("main", get_template_directory_uri() . "/resources/js/main.js", array(), false, true);
}
add_action("wp_enqueue_scripts", "enqueue_scripts");


// search query variables
$GLOBALS["search_query_filters"] = array (
    "field_6119ddc12d3da" => "bedrooms",
    "field_6119dddf2d3db" => "bathrooms",
    "field_6119ddf52d3dc" => "carspaces",
    "field_6119de7a477d9" => "suburb",
    "field_6119de82477da" => "price",
    "sort" => "sort"
);


// manipulate query
function searchPreGetPosts($query) {
    if (is_admin() || !$query->is_main_query()) {
        return;
    }

    $meta_query = array();

    function createMetaQuery($name, $value, $compare, $type) {
        $arr = array(
            "key" => $name,
            "value" => $value,
            "compare" => $compare,
            "type" => $type
        );
        return $arr;
    };

    foreach($GLOBALS['search_query_filters'] as $key => $name) {
        if (empty($_GET[$name])) {
            continue;
        }

        $value = explode(",", $_GET[$name])[0];

        switch($name) {
            case "bedrooms":
                $meta_query[] = createMetaQuery($name, $value, ">=", "NUMERIC");
                break;
            case "bathrooms":
                $meta_query[] = createMetaQuery($name, $value, ">=", "NUMERIC");
                break;
            case "carspaces":
                $meta_query[] = createMetaQuery($name, $value, ">=", "NUMERIC");
                break;
            case "suburb":
                $meta_query[] = createMetaQuery($name, $value, "=", "CHAR");
                break;
            case "price":
                $get_price_range = explode("-", getSingleFieldValue("price"));
                $selected_range = array();

                foreach($get_price_range as $range) {
                    $selected_range[] = (int) $range;
                }
                
                $meta_query[] = createMetaQuery($name, array($selected_range[0], $selected_range[1]), "BETWEEN", "NUMERIC");
                break;
            case "sort":
                $get_sort_selection = getSingleFieldValue("sort");
                switch($get_sort_selection) {
                    case "newest-oldest";
                        $query->set("orderby", "date");
                        $query->set("order", "DESC");
                    break;
                    case "oldest-newest";
                        $query->set("orderby", "date");
                        $query->set("order", "ASC");
                    break;
                    case "low-high";
                        $query->set("meta_key", "price");
                        $query->set("orderby", "meta_value_num");
                        $query->set("order", "ASC");
                        break;
                    case "high-low";
                        $query->set("meta_key", "price");
                        $query->set("orderby", "meta_value_num");
                        $query->set("order", "DESC");
                        break;
                };
                break;
        };
    }

    if (count($meta_query) > 1) {
        $meta_query["relation"] = "AND";
    }

    $query->set("meta_query", $meta_query);
};
add_action("pre_get_posts", "searchPreGetPosts");

// function returns selected field value
// this function takes the following arguments:
// 1. field name
function getSingleFieldValue($field_name) {
    return explode(",", $_GET[$field_name])[0];
};

// function returns all values for a select field
// this function takes the following arguments:
// 1. taxononmy term
// 2. field name
function getMultipleFieldValues($taxonomy_term, $field_name) {
    $field_value_list = array();
    $args = array(
        "post_type" => "property",
        "tax_query" => array(
            array(
                "taxonomy" => "listing_category",
                "field" => "slug",
                "terms" => $taxonomy_term
            )
        )
    );

    $query = new WP_Query($args);

    while($query->have_posts()) : $query->the_post();
        $field_value_list[] = get_field($field_name);
    endwhile;

    return $field_value_list;
};