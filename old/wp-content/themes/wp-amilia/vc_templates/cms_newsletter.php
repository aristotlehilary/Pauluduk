<?php
/**
 * Shortcode attributes
 * @var $atts
 * @var $content - shortcode content
 * Shortcode class
 * @var $this WPBakeryShortCode_VC_Newsletter
 */

if (class_exists('Newsletter')) {
	?>
	<?php if ( is_active_sidebar('bottom-area') ): ?>
        <div class="title-lines-container cms-newsletter-wrap">
            <div class="container">
                <div class="nl-container nl-lines">
                    <div class="nl-icon-container-bg">
                        <div class="nl-icon-container">
                            <i class="icon_mail_alt main-menu-icon" aria-hidden="true"></i>
                        </div>
                    </div>
                    <div class="nl-main-container-bg">
                        <div class="nl-main-container clearfix">
                            <?php dynamic_sidebar('bottom-area'); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
	<?php
}