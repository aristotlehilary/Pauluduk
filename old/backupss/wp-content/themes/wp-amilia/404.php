<?php
/**
 * The template for displaying 404 pages (Not Found)
 * 
 * @package CMSSuperHeroes
 * @subpackage CMS Theme
 * @since 1.0.0
 */

get_header(); ?>
	<div id="primary" class="site-content">
		<div id="content" role="main" class="container">
			<div class="row">
				<article id="post-0" class="post error404 no-results not-found clearfix">
					<div class="col-md-6 text-center img-container-404">
						<img src="<?php echo get_template_directory_uri().'/assets/images/404.png' ?>" alt="">
					</div>
					<div class="col-md-6 m-top-10">
						<h3><?php _e('OOPS! THE PAGE YOU WERE LOOKING FOR, COULDN\'T BE FOUND', 'wp-amilia') ?></h3>
						<p><?php _e('We\'re sorry, but the page you were looking for doesn\'t exist. Here are some useful links', 'wp-amilia'); ?></p>
						<div class="row m-to`p-20">
							<div class="col-md-6">
								<ul class="icon-list">
									<li><i class="fa fa-angle-right"></i><a href="#" class="a-invert">Home</a></li>
									<li><i class="fa fa-angle-right"></i><a href="#" class="a-invert">About Us</a></li>
									<li><i class="fa fa-angle-right"></i><a href="#" class="a-invert">FAQs</a></li>
								</ul>
							</div>
							<div class="col-md-6">
								<ul class="icon-list">
									<li><i class="fa fa-angle-right"></i><a href="#" class="a-invert">Portfolio</a></li>
									<li><i class="fa fa-angle-right"></i><a href="#" class="a-invert">Blog</a></li>
									<li><i class="fa fa-angle-right"></i><a href="#" class="a-invert">Contact</a></li>
								</ul>
							</div>
						</div>
					</div>
				</article><!-- #post-0 -->
			</div>
		</div><!-- #content -->
	</div><!-- #primary -->

<?php get_footer(); ?>