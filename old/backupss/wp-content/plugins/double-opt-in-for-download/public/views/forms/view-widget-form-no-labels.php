<div class="<?php if (!empty($this->widgetFormValues['widget_className'])) { echo $this->widgetFormValues['widget_className']; }else{ echo 'widget_doifd_user_reg_form'; }?>">
    
    <h4 class="doifd_widget_h4"><?php echo $this->widgetFormValues[ 'widget_form_text' ]; ?></h4>
    
    <div id="doifd_widget_statusmsg" class="doifd_widget_statusmsg"><?php if (isset($this->widgetFormValues['widget_error'])) echo $this->widgetFormValues['widget_error'] ; ?></div>
    
    <form id="doifd_widget_form" action="" method="post" onsubmit="widgetgetdownload(); return false;">
    
        <input type="hidden" name="widget_download_id" id="widget_download_id" value="<?php echo $this->widgetFormValues[ 'widget_id' ]; ?>"/>
        <input type="hidden" name="form_source" id="form_source" value="widget"/>
        <input type="hidden" name="widget_wpnonce" id="widget_wpnonce" value="<?php echo $this->widgetFormValues['widget_nonce']; ?>"/>
        
        <ul>
        
            <li>
                
                <input type="text" name="doifd_widget_user_name" placeholder="<?php echo $this->widgetFormValues[ 'widget_name' ]; ?>" id="doifd_widget_user_name" value=""/></li>
            
            <li>
                
                <input type="text" name="doifd_widget_user_email" placeholder="<?php echo $this->widgetFormValues[ 'widget_email' ]; ?>" id="doifd_widget_user_email" value=""/></li>
        
        </ul>
        
        <div id="doifd_widget_button_holder">
            <input name="doifd_widget_download_form" type="submit" id="doifd_widget_download_form" value="<?php echo $this->widgetFormValues[ 'widget_button_text' ]; ?>" class="button"><br />
            
            <?php echo $this->widgetFormValues[ 'widget_privacy' ]; ?>
            
            <?php echo $this->widgetFormValues[ 'widget_promo' ]; ?>
            
        </div>
    
    </form>

</div>