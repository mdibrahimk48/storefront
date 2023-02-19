
<?php

//Such: an example
$product_id = $id;

echo get_post_meta( $product_id, 'discount_custom_field', true );



function input_for_new_shortcode($_device_name, $column_settings){
    $text = isset( $column_settings['new_shortcode']['text'] ) ? $column_settings['new_shortcode']['text'] : false;
    ?>
<input class="ua_input" name="column_settings<?php echo esc_attr( $_device_name ); ?>[new_shortcode]" value="<?php echo esc_attr( $text ); ?>">
<?php 
}
add_action( 'wpto_column_setting_form_new_shortcode', 'input_for_new_shortcode', 10, 2 );




$my_shortcode = isset( $settings['text'] ) ? $settings['text'] : '';
 
echo do_shortcode( $settings['text'] );

function wpt_custom_extra_label_change( $label, $id ){
    $label = get_post_meta($id, 'my_custom_label', true);
    return $label;
}
add_filter( 'wpt_extra_label_text', 'wpt_custom_extra_label_change', 10, 2 );