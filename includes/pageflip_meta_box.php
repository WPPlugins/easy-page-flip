<?php
/*
** Register MetaBox - PageFlip
*/

function pageflip_meta_box(){        
    add_meta_box('pageflip_meta_box', __('Configure PageFlip', 'easy-page-flip'), 'create_pageflip_meta_box', 'pageflip', 'advanced', 'high');
}

function create_pageflip_meta_box(){
    
    global $post;
    
    $meta_element_speed = get_post_meta($post->ID, 'custom_element_grid_meta_speed', true);
    $meta_element_starting = get_post_meta($post->ID, 'custom_element_grid_starting', true);
    $meta_element_direction = get_post_meta($post->ID, 'custom_element_grid_meta_direction', true);
    $meta_element_numbers = get_post_meta($post->ID, 'custom_element_grid_meta_numbers', true);
    $meta_element_closed = get_post_meta($post->ID, 'custom_element_grid_meta_closed', true);
?>
    <dl class="epf-admin">
        <dt>
            <h3><span><?php _e('Configure PageFlip', 'easy-page-flip');?></span></h3>
        </dt>
        <dd>
            <label class="label-epf" for="custom_element_grid_speed"><?php _e('Speed:', 'easy-page-flip');?></label>
            <select name="custom_element_grid_speed" id="custom_element_grid_speed" class="input-epf">
                <option value="1000" <?php selected( $meta_element_speed, '1000' ); ?>>1000</option>
                <option value="500" <?php selected( $meta_element_speed, '500' ); ?>>500</option>
                <option value="250" <?php selected( $meta_element_speed, '250' ); ?>>250</option>
            </select>        
        </dd>
        <dd>
            <label class="label-epf" for="custom_element_grid_starting"><?php _e('Starting Page:', 'easy-page-flip');?></label>
            <input type="number" min="1" max="500" name="custom_element_grid_starting" id="custom_element_grid_starting" class="input-epf" value="<?php if($meta_element_starting == null){ echo '1'; }else{echo $meta_element_starting;};?>" />
        </dd>
        <dd>
            <label class="label-epf" for="custom_element_grid_direction"><?php _e('Direction:', 'easy-page-flip');?></label>
            <select name="custom_element_grid_direction" id="custom_element_grid_direction" class="input-epf">
                <option value="LTR" <?php selected( $meta_element_direction, 'LTR' ); ?>><?php _e('Left to Right', 'easy-page-flip');?></option>
                <option value="RTL" <?php selected( $meta_element_direction, 'RTL' ); ?>><?php _e('Right to Left', 'easy-page-flip');?></option>
            </select>
        </dd>
        <dd>
            <label class="label-epf" for="custom_element_grid_numbers"><?php _e('Page Numbers:', 'easy-page-flip');?></label>
            <select name="custom_element_grid_numbers" id="custom_element_grid_numbers" class="input-epf">
                <option value="true" <?php selected( $meta_element_numbers, 'true' ); ?>><?php _e('True', 'easy-page-flip');?></option>
                <option value="false" <?php selected( $meta_element_numbers, 'false' ); ?>><?php _e('False', 'easy-page-flip');?></option>
            </select>
        </dd>
        <dd>
            <label class="label-epf" for="custom_element_grid_closed"><?php _e('Closed Book:', 'easy-page-flip');?></label>
            <select name="custom_element_grid_closed" id="custom_element_grid_closed" class="input-epf">
                <option value="false" <?php selected( $meta_element_closed, 'false' ); ?>><?php _e('False', 'easy-page-flip');?></option>
                <option value="true" <?php selected( $meta_element_closed, 'true' ); ?>><?php _e('True', 'easy-page-flip');?></option>
            </select>
        </dd>
    </dl>
<?php
}

add_action( 'save_post', 'pageflip_save_post', 1, 2 );

function pageflip_save_post( $post_id, $post ) {
    if ( empty( $post_id ) || empty( $post ) || empty( $_POST ) ) return;
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
    if ( is_int( wp_is_post_revision( $post ) ) ) return;
    if ( is_int( wp_is_post_autosave( $post ) ) ) return;
    if ( ! current_user_can( 'edit_post', $post_id ) ) return;
    if ( $post->post_type != 'pageflip' ) return;
    /*
     * Save Speed
     */
    if(isset($_POST["custom_element_grid_speed"])){
        $meta_element_speed = $_POST['custom_element_grid_speed'];
        update_post_meta($post->ID, 'custom_element_grid_meta_speed', $meta_element_speed);
    }
    /*
     * Save Page Starting
     */
    update_post_meta($post->ID, 'custom_element_grid_starting', $_POST['custom_element_grid_starting']);
    /*
     * Save Direction
     */
    if(isset($_POST["custom_element_grid_direction"])){
        $meta_element_direction = $_POST['custom_element_grid_direction'];
        update_post_meta($post->ID, 'custom_element_grid_meta_direction', $meta_element_direction);
    }
    /*
     * Save Numbers
     */
    if(isset($_POST["custom_element_grid_numbers"])){
        $meta_element_numbers = $_POST['custom_element_grid_numbers'];
        update_post_meta($post->ID, 'custom_element_grid_meta_numbers', $meta_element_numbers);
    }
    /*
     * Save Closed
     */
    if(isset($_POST["custom_element_grid_closed"])){
        $meta_element_closed = $_POST['custom_element_grid_closed'];
        update_post_meta($post->ID, 'custom_element_grid_meta_closed', $meta_element_closed);
    }
}