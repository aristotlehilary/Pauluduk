jQuery( document ).ready(function($) {
	var el = document.getElementById('getting-started');
	var count_down = el.getAttribute("data-count-down");

    $('#getting-started').countdown(count_down, function(event) {
   		var $this = $(this).html(event.strftime(''
     	+ '<div class="col-xs-12 col-sm-6 col-md-3"><div class="countdown-item-container"><span class="countdown-amount">%D</span><span class="countdown-period">days</span></div></div>'
     	+ '<div class="col-xs-12 col-sm-6 col-md-3"><div class="countdown-item-container"><span class="countdown-amount">%H</span><span class="countdown-period">hour</span></div></div>'
     	+ '<div class="col-xs-12 col-sm-6 col-md-3"><div class="countdown-item-container"><span class="countdown-amount">%M</span><span class="countdown-period">minutes</span></div></div>'
     	+ '<div class="col-xs-12 col-sm-6 col-md-3"><div class="countdown-item-container"><span class="countdown-amount">%S</span><span class="countdown-period">seconds</span></div></div>'));
 	});

});