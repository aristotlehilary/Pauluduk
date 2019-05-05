jQuery(document).ready(function($){
    $('#popup_color').wpColorPicker();

    //Logo upload for backend
    jQuery('#popup_logo_submit').click(function() {
        formfield = jQuery('#popup_logo').attr('name');
        tb_show('', 'media-upload.php?type=image&TB_iframe=true');


        window.send_to_editor = function(html) {
            imgurl = jQuery('img',html).attr('src');
            jQuery('#popup_logo').val(imgurl);
            tb_remove();

            jQuery('#popuplogo_thumb').html("<img height='65' src='"+imgurl+"'/>");
        }

        return false;
    });

	$('.smoothscroll').click(function(){ 
	$('html, body').animate({ scrollTop: $( $.attr(this, 'href') ).offset().top}, 1200); 
	return false;});
	
});
