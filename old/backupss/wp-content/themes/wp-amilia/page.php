<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package CMSSuperHeroes
 * @subpackage CMS Theme
 * @since 1.0.0
 * @author Fox
 */

get_header(); ?>
<div id="page-default" class="<?php amilia_main_class(); ?>">
	<div id="primary">
		<div id="content" role="main">
			<?php if (class_exists('CmssuperheroesCore')) : ?>
				<?php while ( have_posts() ) : the_post(); ?>
					<?php get_template_part( 'single-templates/content', 'page' ); ?>
					<?php comments_template( '', true ); ?>
				<?php endwhile; // end of the loop. ?>	
			<?php else : ?>
				<div class="row">
					<section id="primary" class="col-xs-12 col-md-9">
			            <div id="content" role="main">

			            <?php if ( have_posts() ) : ?>
			            
			                <?php
			                /* Start the Loop */
			                while ( have_posts() ) : the_post();

			                    /* Include the post format-specific template for the content. If you want to
			                     * this in a child theme then include a file called called content-___.php
			                     * (where ___ is the post format) and that will be used instead.
			                     */
			                    get_template_part( 'single-templates/content', 'page' );

			                endwhile;

			                amilia_paging_nav();
			                ?>

			            <?php else : ?>
			                <?php get_template_part( 'single-templates/content', 'none' ); ?>
			            <?php endif; ?>
			            </div><!-- #content -->
			        </section><!-- #primary -->
			        <div class="col-xs-12 col-md-3 right-sidebar-wrap">
		                <?php get_sidebar(); ?>
		            </div>
				</div>
			<?php endif; ?>
		</div><!-- #content -->
	</div><!-- #primary -->
</div>
<?php get_footer(); ?>