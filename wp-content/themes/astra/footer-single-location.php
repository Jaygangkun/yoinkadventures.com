<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Astra
 * @since 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

?>
<?php astra_content_bottom(); ?>
	</div> <!-- ast-container -->
	</div><!-- #content -->
<?php 
	astra_content_after();
		
	astra_footer_before();
		
	astra_footer();
		
	astra_footer_after(); 
?>
	</div><!-- #page -->
<?php 
	astra_body_bottom();    
	wp_footer(); 
?>
<link rel="stylesheet" href="<?php echo get_template_directory_uri()?>/ext/jquery-ui.css" media="all">
<!-- <script src="<?php echo get_template_directory_uri()?>/ext/frm.min.js"></script> -->
<script src="<?php echo get_template_directory_uri()?>/ext/datepicker.min.js"></script>

<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
<link rel="stylesheet" href="<?php echo get_template_directory_uri()?>/ext/image-uploader.min.css">
<script type="text/javascript" src="<?php echo get_template_directory_uri()?>/ext/image-uploader.min.js"></script>

<link rel="stylesheet" href="<?php echo get_template_directory_uri()?>/ext/custom.css">
<script>
	// var frm_js = {
	// 	"ajax_url":"<?php echo admin_url('admin-ajax.php')?>",
	// 	"images_url":"<?php echo site_url()?>/wp-content\/plugins\/formidable\/images",
	// 	"loading":"Loading\u2026",
	// 	"remove":"Remove",
	// 	"offset":"4",
	// 	"nonce":"417073666f",
	// 	"id":"ID",
	// 	"no_results":"No results match",
	// 	"file_spam":"That file looks like Spam.",
	// 	"calc_error":"There is an error in the calculation in the field with key",
	// 	"empty_fields":"Please complete the preceding required fields before uploading a file."
	// };
	
	var yoinkSubmitting = false;
	jQuery(document).ready(function() {
		jQuery('#yoink_date').datepicker({
			// "dateFormat": "mm\/dd\/yy",
			// "changeMonth": "true",
			// "changeYear": "true",
			// "yearRange": "2011:2031",
			// "defaultDate": "",
			// "beforeShowDay": null
		});

		jQuery('#yoink_images').imageUploader({
			label: 'Drag & Drop images or click to browse',
			imagesInputName: 'yoink_images'
		});
		
		jQuery(document).on('click', '#yoink_submit_btn', function() {
			if(yoinkSubmitting) {
				return;
			}

			var btnInstance = this;
			var yoinkFormData = new FormData(jQuery('#yoink_submit_form')[0]);        
			yoinkFormData.append('action', 'yoink_submit');

			yoinkSubmitting = true;
			jQuery(btnInstance).attr('disabled', true);
			jQuery.ajax({
				url: wp_admin_url,
				type: 'post',
				enctype: 'multipart/form-data',
				data: yoinkFormData,
				cache: false,
				contentType: false,
				processData: false,
				success: function(data){
					yoinkSubmitting = false;
					jQuery(btnInstance).attr('disabled', false);
				}
			})        
		})
	})
	
</script>
	</body>
</html>
