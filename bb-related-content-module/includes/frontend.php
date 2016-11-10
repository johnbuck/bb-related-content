<?php

// Get the query data.
$query = FLBuilderLoop::query($settings);

// Render the posts.
if($query->have_posts()) :

?>
<div class="fl-rc-module-container">
    <h2 class="fl-rc-module-title"><?php _e( $settings->rc_title, 'fl-builder'); ?></h2>

<?php
if ( $settings->rc_content_type == 'list') {
        $i = 0;
        while($query->have_posts()) {

            $query->the_post();
            $i++;
            if ( $i > 1 && $settings->rc_show_border == '1') {
                $border_width = $settings->rc_border_width;
                if ( $border_width == 0 ) {
                    $border_width = '100%';
                } else {
                    if ( !preg_match('/(\%|px)/i', $border_width) ) $border_width .= 'px';
                }
?>
                <div class="fl-rc-module-list-border" style="width: <?php echo $border_width; ?>; background: #<?php echo $settings->rc_border_color;?>; height: 1px; "></div>
<?php
            }
?>
            <div class="fl-rc-module-list-item">
	            <?php
	            if ( $settings->cta_custom_field == '' ) {
		            $permalink = get_the_permalink();
	            } else {
		            $permalink = my_get_field( $settings->cta_custom_field );
	            }
	            ?>
                <a href="<?php echo esc_attr($permalink); ?>" class="fl-rc-module-list-link"><?php echo get_the_title(); ?></a>
            </div>
<?php
        }

        wp_reset_postdata();

} else {
?>
<select class="fl-rc-module-dropdown">
    <option>Choose</option>
<?php
    while($query->have_posts()) {

        $query->the_post();
	    if ( $settings->cta_type == 'url' ) {
		    $permalink = get_the_permalink();
	    } else {
		    $permalink = my_get_field( $settings->cta_custom_field );
	    }
	    ?>
        <option value="<?php echo get_the_ID(); ?>"
                data-url="<?php echo esc_attr($permalink); ?>"><?php echo get_the_title(); ?></option>
    <?php
    }
} ?>
</select>
</div>

<?php endif; ?>