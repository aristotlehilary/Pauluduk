jQuery(document).ready(function($) {

    jQuery(".mb_elegantModalclose").bind("click", function() {
        jQuery(".mb_elegantModal div").addClass("zoomOutDown");
        setTimeout(function() {
            jQuery(".mb_elegantModal").fadeOut("slow", function() {
                jQuery(this).css({
                    "display": "none"
                });
            })
        }, 1000);
    });
	
	
	function validateEmail($email) {
        var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
        if(emailReg.test($email)) {
            return true;
        } else {
            return false;
        }
    }


    jQuery('.mb_elegantpopupbutton').bind("click",function () {

        if( validateEmail(jQuery("#esp_email").val()) == true && jQuery("#esp_email").val() != "") {
            
            jQuery(".mb_elegantModal div").addClass("zoomOutDown");
            setTimeout(function() {
                jQuery(".mb_elegantModal").fadeOut("slow", function() {
                    jQuery(this).css({
                        "display": "none"
                    });
                })
            }, 1000);

        }
    });

});
