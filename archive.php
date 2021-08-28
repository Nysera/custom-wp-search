<?php 
/**
* The template for displaying archive pages
*
*/

get_header();
?>
<div style="max-width: 500px;">
     <?php get_template_part("/template-parts/forms/searchFormShortcode"); ?>
</div>
<div>
    <?php if ( have_posts() ) : ?>
        <!-- code if posts are available -->
        <div>
            <?php while ( have_posts() ) : the_post(); ?>
                <!-- code for each post -->
                <div style="background-color: #ccc; padding: 40px; margin-bottom: 14px;">
                    <h3 style="margin: 0 0 10px 0;"><?php echo get_the_title(); ?></h3>
                    <div style="margin-bottom: 4px;">Bedrooms: <?php echo get_field("bedrooms"); ?></div>
                    <div style="margin-bottom: 4px;">Bathrooms: <?php echo get_field("bathrooms"); ?></div>
                    <div style="margin-bottom: 4px;">Car Spaces: <?php echo get_field("carspaces"); ?></div>
                    <div>Price: $<?php echo number_format(get_field("price")); ?></div>
                </div>
            <?php endwhile; ?>
            <!-- ** Add pagination here! ** -->
        </div>
    <?php else : ?>
        <!-- code for if no posts -->
        <div>No listings were found. Please broaden your search terms.</div>
    <?php endif; ?>
</div>

<?php get_footer(); ?>