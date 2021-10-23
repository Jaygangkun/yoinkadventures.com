<?php
/**
 * The template for displaying all single locations.
 *
 * @author jay
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

get_header(); ?>

	<div id="primary" <?php astra_primary_class(); ?>>

		<?php astra_primary_content_top(); ?>

		<?php astra_content_loop(); ?>

		<section class="elementor-section elementor-top-section elementor-element elementor-section-boxed elementor-section-height-default elementor-section-height-default">
			<div class="elementor-container elementor-column-gap-default">
				<div class="elementor-widget-wrap elementor-element-populated">
					<div class="elementor-element">
						<?php echo do_shortcode('[yoinkform]');?>
					</div>
				</div>
			</div>
		</section>

		<?php astra_primary_content_bottom(); ?>

	</div><!-- #primary -->

<?php get_footer('single-location'); ?>
