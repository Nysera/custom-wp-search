<?php

/**
 *  search form template
 *
 */
?>

<!-- figure out how to set the action to the current page URL -->
<form action="" method="GET">
    <div style="padding: 10px;">
        <?php
            $suburb_list = getMultipleFieldValues(get_query_var("term"), "suburb");
            $filtered_suburb_list = array_unique($suburb_list);
            sort($filtered_suburb_list);
        ?>
        Suburb:
        <select name="suburb">
            <option value>All Suburbs</option>
            <?php foreach($filtered_suburb_list as $suburb) : ?>
                <option value="<?php echo $suburb; ?>" <?php if (getSingleFieldValue("suburb") == $suburb) echo 'selected="selected"'; ?>><?php echo $suburb; ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div style="padding: 10px;">
        Bedrooms:
        <select name="bedrooms">
            <?php for ($i = 1; $i <= 10; $i++) { ?>
                <option value="<?php echo $i; ?>" <?php if (getSingleFieldValue("bedrooms") == $i) echo 'selected="selected"'; ?>><?php echo $i; ?>+</option>
            <?php } ?>
        </select>
    </div>
    <div style="padding: 10px;">
        Bathrooms:
        <select name="bathrooms">
            <?php for ($i = 1; $i <= 10; $i++) { ?>
                <option value="<?php echo $i; ?>" <?php if (getSingleFieldValue("bathrooms") == $i) echo 'selected="selected"'; ?>><?php echo $i; ?>+</option>
            <?php } ?>
        </select>
    </div>
    <div style="padding: 10px;">
        Car Spaces:
        <select name="carspaces">
            <?php for ($i = 1; $i <= 10; $i++) { ?>
                <option value="<?php echo $i; ?>" <?php if (getSingleFieldValue("carspaces") == $i) echo 'selected="selected"'; ?>><?php echo $i; ?>+</option>
            <?php } ?>
        </select>
    </div>
    <div style="padding: 10px;">
        <?php
            $price_min = 50000;
            $price_max = 10000000;

            function setPriceInputValue($min, $max) {
                return empty($_GET["price"]) ? $min."-".$max : getSingleFieldValue("price");
            };
        ?>
        <div>
            <div id="rangeSlider" data-min="<?php echo $price_min; ?>" data-max="<?php echo $price_max; ?>"></div>
            <div id="rangeSliderValue" style="padding: 15px"></div>
        </div>
        <input type="visible" name="price" id="rangeSliderPriceRange" value="<?php echo setPriceInputValue($price_min, $price_max); ?>"></input>
    </div>
    <div style="padding: 10px;">
        Sort:
        <select name="sort" style="display: block; margin: 10px 0;">
            <option value="newest-oldest" <?php if (getSingleFieldValue("sort") == "newest-oldest") echo 'selected="selected"'; ?>>Date (Newest - Oldest)</option>
            <option value="oldest-newest" <?php if (getSingleFieldValue("sort") == "oldest-newest") echo 'selected="selected"'; ?>>Date (Oldest - Newest)</option>
            <option value="low-high" <?php if (getSingleFieldValue("sort") == "low-high") echo 'selected="selected"'; ?>>Price (Lowest - Highest)</option>
            <option value="high-low" <?php if (getSingleFieldValue("sort") == "high-low") echo 'selected="selected"'; ?>>Price (Highest - Lowest)</option>
        </select>
    </div>
    <div style="padding: 10px;">
        <button type="submit">Submit</button>
    </div>
</form>