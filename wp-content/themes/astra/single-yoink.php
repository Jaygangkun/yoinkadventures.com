<?php
/**
 * The template for displaying all single yoink.
 *
 * @author jay
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

get_header(); ?>

	<div id="primary" <?php astra_primary_class(); ?>>
		<?php astra_primary_content_top(); ?>
		<style>
			.yoink-info-row label{
				font-size: 20px;
			}

		</style>
		<h1 class="elementor-heading-title elementor-size-default"><?php the_title()?></h1>
		<div class="yoink-info-container">
			<div class="yoink-info-row">
				<label>Notes</label>
				<div><?php the_field('notes')?></div>
			</div>
			<div class="yoink-info-row">
				<label>Date</label>
				<div><?php the_field('date')?></div>
			</div>
			<div class="yoink-info-row">
				<label>Location</label>
				<?php
				$location_id = get_field('location');
				?>
				<div>
					<a class="" href="<?php echo get_post_permalink($location_id)?>"><?php echo get_the_title($location_id); ?></a>
				</div>
			</div>
			<div class="yoink-info-row">
				<label>Gallery</label>
				<div>
					<?php
					$gallery = get_field('gallery');
					$upload_dir = wp_upload_dir();
					foreach($gallery as $id) {
						$attachment_metadata = wp_get_attachment_metadata($id);
						?>
						<img class="" src="<?php echo wp_get_attachment_image_url($id)?>">
						<?php
					}
					?>
				</div>
			</div>
		</div>
		
	</div><!-- #primary -->

<?php get_footer(); ?>
