<?php
    $icon_name = $iconClass = $hover_effect = $fancy_style = '';
    $icon_name = "icon_" . $atts['icon_type'];
    $iconClass = isset($atts[$icon_name]) ? $atts[$icon_name] : '';
    $fancy_style = isset($atts['fancy_style']) ? $atts['fancy_style'] : 'style1';
    $hover_effect = isset($atts['hover_effect']) ? $atts['hover_effect'] : '';

    $animate_class = isset($atts['css_animation']) ? $atts['css_animation'] : '';
    $css_animation_delay = isset($atts['css_animation_delay']) ? $atts['css_animation_delay'] : '0ms';
    $css_duration = isset($atts['css_duration']) ? $atts['css_duration'] : '0ms';
?>

<div class="cms-fancyboxes-wraper <?php echo esc_attr($atts['template'].' fancy-'.$fancy_style);?> <?php echo esc_attr($animate_class); ?> clearfix" id="<?php echo esc_attr($atts['html_id']);?>" data-wow-delay="<?php echo esc_attr($css_animation_delay); ?>" data-wow-duration="<?php echo esc_attr($css_duration); ?>">
    <div class="cms-fancyboxes-body">
        <div class="cms-fancybox-item <?php echo ($hover_effect == true) ? 'has-hover-effect' : ''; ?> <?php echo esc_attr($fancy_style); ?>" onclick="">
            <?php if ($fancy_style == 'style6') : ?>
                <?php if (!empty($iconClass)) : ?>
                    <div class="fancy-box-icon-wrap">
                        <div class="fancy-box-icon-inner">
                            <div class="fancy-box-icon <?php echo ($fancy_style == 'style3') ? 'wow zoomIn animated': ''; ?>">
                                <i class="<?php echo esc_attr($iconClass);?>"></i>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
                <div class="fancy-content">
                    <?php if($atts['title_item']):?>
                        <h2 class="fancy-title"><?php echo apply_filters('the_title',$atts['title_item']);?></h2>
                    <?php endif;?>
                    <?php if($atts['description_item']): ?>
                    <div class="fancy-box-content">
                        <?php echo apply_filters('the_content',$atts['description_item']);?>
                    </div>
                    <?php endif; ?>    
                </div>
            <?php else : ?>
                <?php if (!empty($iconClass)) : ?>
                    <div class="fancy-box-icon <?php echo ($fancy_style == 'style3') ? 'wow zoomIn animated': ''; ?>">
                        <i class="<?php echo esc_attr($iconClass);?>"></i>
                    </div>
                <?php endif; ?>
                <div class="fancy-content">
                    <?php if($atts['title_item']):?>
                        <h2 class="fancy-title"><?php echo apply_filters('the_title',$atts['title_item']);?></h2>
                    <?php endif;?>
                    <?php if($atts['description_item']): ?>
                    <div class="fancy-box-content">
                        <?php echo apply_filters('the_content',$atts['description_item']);?>
                    </div>
                    <?php endif; ?>    
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>