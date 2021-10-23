<?php

// custom shortcodes
function yoinkform_function($atts = array(), $content = null) {
    extract(shortcode_atts(array(
        'rating' => '5'
    ), $atts));
    ob_start();
    ?>
    <h3>Add New Yoink</h3>
    <div class="frm_forms  with_frm_style frm_style_formidable-style">
        <div class="frm_form_fields">
            <form id="yoink_submit_form">
                <div class="frm_fields_container">
                    <input type="hidden" name="location_id" value="<?php echo get_the_ID()?>">
                    <div class="frm_form_field form-field frm_required_field frm_top_container">
                        <label for="yoink_notes" class="frm_primary_label">Title</label>
                        <input type="text" id="yoink_title" name="yoink_title">
                    </div>
                    <div class="frm_form_field form-field frm_required_field frm_top_container">
                        <label for="yoink_notes" class="frm_primary_label">Notes</label>
                        <textarea id="yoink_notes" name="yoink_notes" rows="5"></textarea>
                    </div>
                    <div class="frm_form_field form-field frm_required_field frm_top_container">
                        <label for="yoink_date_label" class="frm_primary_label">Date</label>
                        <input type="text" id="yoink_date" name="yoink_date" class="datepicker">
                    </div>
                    <div class="frm_form_field form-field frm_required_field frm_top_container">
                        <div class="input-images" id="yoink_images"></div>
                    </div>
                    <div class="frm_submit">
                        <div class="frm_form_submit_style" id="yoink_submit_btn">Submit</div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <?php
    return ob_get_clean();
}

add_shortcode('yoinkform', 'yoinkform_function');

function yoinkSubmit() {

    // Count total files
    $countfiles = count($_FILES['yoink_images']['name']);

    // Upload directory
    $wp_upload_dir = wp_upload_dir();
    $upload_location = $wp_upload_dir['path'] . '/';
    // $upload_location = "uploads/";
    // echo $upload_location;

    // To store uploaded files path
    $files_arr = array();
    $gallery = [];
    // Loop all files
    for($index = 0;$index < $countfiles;$index++){

        if(isset($_FILES['yoink_images']['name'][$index]) && $_FILES['yoink_images']['name'][$index] != ''){
            // File yoink_images
            $filename = $_FILES['yoink_images']['name'][$index];

            // Get extension
            $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

            // Valid image extension
            $valid_ext = array("png","jpeg","jpg");

            // Check extension
            if(in_array($ext, $valid_ext)){

                // File path
                $path = $upload_location.$filename;

                // Upload file
                if(move_uploaded_file($_FILES['yoink_images']['tmp_name'][$index],$path)){
                    $files_arr[] = $path;
                    $guids[] = $wp_upload_dir['url'].'/'.$filename;

                    $attachment = array(
                        'guid'=> $wp_upload_dir['url'].'/'.$filename, 
                        'post_mime_type' => 'image/'.$ext,
                        'post_title' => 'Yoink Image Submitted-'.$filename,
                        'post_content' => 'Yoink Image Description',
                        'post_status' => 'inherit'
                    );
                    $image_id = wp_insert_attachment($attachment, $wp_upload_dir['url'].'/'.$filename);
                    // Make sure that this file is included, as wp_generate_attachment_metadata() depends on it.
                    require_once( ABSPATH . 'wp-admin/includes/image.php' ); 
                    // Generate the metadata for the attachment, and update the database record.
                    $attach_data = wp_generate_attachment_metadata( $image_id, $filename );
                    wp_update_attachment_metadata( $image_id, $attach_data );
                    $gallery[] = $image_id;   
                }
            }
        }
    }

    $yoink_id = wp_insert_post(array (
        'post_type' => 'yoink',
        'post_title' => isset($_POST['yoink_title']) ? $_POST['yoink_title'] : 'Created',
        // 'post_content' => $your_content,
        'post_status' => 'draft',
        'comment_status' => 'closed',   // if you prefer
        'ping_status' => 'closed',      // if you prefer
    ));
    
    if ($yoink_id) {
        // insert post meta
        add_post_meta($yoink_id, 'notes', isset($_POST['yoink_notes']) ? $_POST['yoink_notes'] : '');
        add_post_meta($yoink_id, 'date', isset($_POST['yoink_date']) ? $_POST['yoink_date'] : '');
        add_post_meta($yoink_id, 'location', isset($_POST['location_id']) ? $_POST['location_id'] : '');
        add_post_meta($yoink_id, 'gallery', $gallery);
    }

    echo json_encode(array(
        'files_arr' => $files_arr,
        'guids' => $guids,
        'yoink_id' => $yoink_id
    ));
    die;
}

add_action('wp_ajax_yoink_submit', 'yoinkSubmit');
add_action('wp_ajax_nopriv_yoink_submit', 'yoinkSubmit');