<?php
/**
 * The template for displaying all pages, single posts and attachments
 *
 * This is a new template file that WordPress introduced in
 * version 4.3.
 *
 * @package OceanWP WordPress theme
 */

get_header(); ?>

	<?php do_action( 'ocean_before_content_wrap' ); ?>

	<div id="content-wrap" class="container clr">

		<?php do_action( 'ocean_before_primary' ); ?>

		<div id="primary" class="content-area clr">

			<?php do_action( 'ocean_before_content' ); ?>

			<div id="content" class="site-content clr">


				<?php do_action( 'ocean_before_content_inner' ); ?>

				<?php
				// Elementor `single` location
				if ( ! function_exists( 'elementor_theme_do_location' ) || ! elementor_theme_do_location( 'single' ) ) {
					
					?>

					<div class="projets">

						<?php 
						// Start loop
						while ( have_posts() ) : the_post();

								// EDD Page
								if ( is_singular( 'download') ) {
									get_template_part( 'partials/edd/single' );
								}

								// Single Page
								elseif ( is_singular( 'page' ) ) {

									get_template_part( 'partials/page/layout' );

								}

								// Library post types
								elseif ( is_singular( 'oceanwp_library' )
										|| is_singular( 'elementor_library' ) ) {

									get_template_part( 'partials/library/layout' );

								}

								// All other post types.
								else {
									// Templates realisations
									?> 
									<div class="projet">
										<a href="<?php the_permalink(); ?>">
											<?php the_post_thumbnail() ?>
											<p><?php the_title() ?></p>
										</a>
										<br>
									</div>
									<?php
								} 
						endwhile;
						?>
					</div>
				<?php
				}

				do_action( 'ocean_after_content_inner' ); ?>

			</div><!-- #content -->

			<?php do_action( 'ocean_after_content' ); ?>

		</div><!-- #primary -->

		<?php do_action( 'ocean_after_primary' ); ?>

		<?php do_action( 'ocean_display_sidebar' ); ?>

	</div><!-- #content-wrap -->

	<?php do_action( 'ocean_after_content_wrap' ); ?>

<?php get_footer(); ?>