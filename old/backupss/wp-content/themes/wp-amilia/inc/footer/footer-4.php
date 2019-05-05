<?php
	global $smof_data, $amilia_meta;
	$footer_animate = (isset($amilia_meta->_cms_footer_animate) && $amilia_meta->_cms_footer_animate != '') ? $amilia_meta->_cms_footer_animate : '';
?>
<footer id="main-footer" class="cms-footer-layout4-wrap cms-footer-wrapper">
	<div class="footer-grey-bg title-lines-container">
		<div class="container">
			<div class="row">
				<div class="col-md-4 <?php echo ($footer_animate) ? 'fadeInLeft wow' : '' ?>" <?php echo ($footer_animate) ? 'data-wow-duration="1s"' : '' ?>>
					<?php dynamic_sidebar('footer-41'); ?>
				</div>
				<div class="col-md-4 <?php echo ($footer_animate) ? 'fadeIn wow' : '' ?>" <?php echo ($footer_animate) ? 'data-wow-duration="1s"' : '' ?>>
					<?php dynamic_sidebar('footer-42'); ?>
				</div>
				<div class="col-md-4 <?php echo ($footer_animate) ? 'fadeInRight wow' : '' ?>" <?php echo ($footer_animate) ? 'data-wow-duration="1s"' : '' ?>>
					<?php dynamic_sidebar('footer-43'); ?>
				</div>
			</div>
		</div>
	</div>
	<?php
		$attr = array(
            'menu' => '',
            'menu_class' => 'footer-menu-wrap',
            'container' => 'nav',
            'container_class' => 'clearfix',
            'container_id' => 'footer-menu',
        );
        $menu_locations = get_nav_menu_locations();
        if(!empty($menu_locations['footer-menu'])){
            $attr['theme_location'] = 'footer-menu';
        }
	?>
	<div class="copyright-container title-lines-container">
		<div class="container">
			<div class="row">
				<div class="col-md-8 <?php echo ($footer_animate) ? 'fadeInUp wow' : '' ?>">
					<div class="footer-menu-container">
						<?php wp_nav_menu( $attr ); ?>
					</div>
				</div>
				<div class="col-md-4 <?php echo ($footer_animate) ? 'fadeInUp wow' : '' ?>">
					<div class="footer-copyright-container">
						<div class="mask-footer-copyright-container"></div>
						<div class="footer-copyright-text">
							<?php echo ''.$smof_data['copyright'] ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</footer>