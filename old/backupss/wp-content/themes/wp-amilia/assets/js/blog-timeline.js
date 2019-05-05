(function($){
	"use strict";
	$(document).ready(function(){
		if(timeline_obj.masonry == 'masonry'){
			$('.blog-timeline').each(function(){
				var $this = $(this);
				$this.imagesLoaded(function(){
					$this.shuffle({
		               itemSelector:'.timeline-blog-item'
		            });
				})
			})
		}
		
	})
	$(document).ready(function($) {
		"use strict"; 
		var pageNum = parseInt(timeline_obj.startPage) + 1;
	 	var total = parseInt(timeline_obj.total);
		var max = parseInt(timeline_obj.maxPages);
	 	var perpage = parseInt(timeline_obj.perpage);
		var nextLink = timeline_obj.nextLink;
		var masonry = timeline_obj.masonry;
		if(nextLink == null){
			return;
		}
		setInterval(function(){
			jQuery('#content').find('audio,video').mediaelementplayer();
		},3000);
		$.countPost = function(total,perpage,pageNum){
			var cposts = total-perpage*pageNum;
			if(cposts>perpage){
				return 'Load More('+perpage+' Of '+cposts+')';
			}
			else{
				return 'Load More('+cposts+')';
			}
		}
		$.loadData = function(){
			"use strict";
			
			$.get(nextLink,function(data){
				// Update page number and nextLink.
				if(masonry == 'masonry'){
					var items = $(data).find('#content .blog-timeline > .timeline-blog-item');
					$("#content").find('.blog-timeline').append(items);
					$(items).imagesLoaded(function(){
						$('#content').find(".blog-timeline").shuffle('appended',items);
					})
					
				}else{
					var items = $(data).find('#content .blog-timeline > .cms-blog-item');
					$("#content").find('.blog-timeline').append(items);
				}
				
				pageNum++;
				if(nextLink.indexOf('/page/')>-1){
					nextLink = nextLink.replace(/\/page\/[0-9]?/, '/page/'+ pageNum);
				}
				else{
					nextLink = nextLink.replace(/paged=[0-9]?/, 'paged='+ pageNum);
				}
				// Add a new placeholder, for when user clicks again.
				$('#cms-load-posts')
					.before('<div class="cms-placeholder-'+ pageNum +'"></div>')
		 		$('#cms-load-posts').find('a').text('');
				$('#cms-load-posts').find('a').data('loading',0);
				$('.cms_pagination').removeClass('cms-loading');
			});
		}
		if(pageNum <= max) {
			var text=$.countPost(total,perpage,1);
			$('.cms_pagination').append('<div class="cms-placeholder-'+ pageNum +'"></div><p id="cms-load-posts"><a data-loading="0" href="#"></a></p>');
			
		}
		loadAjax();
		jQuery(document, window).scroll(function() {
			loadAjax();
		});

		function loadAjax(){
			var bottomElm = ($('#content').offset().top + $('#content').height()) - jQuery(document).scrollTop();
			if (jQuery(window).height()>bottomElm){
				if(pageNum > max){
					$('.cms_pagination').addClass('cms-loaded-all').removeClass('cms-loading');
				} else {
					$('.cms_pagination').addClass('cms-loading');
				}

				if(pageNum <= max  && $('#cms-load-posts').find('a').data('loading') == 0){
					if($('#cms-load-posts').find('a').data('loading')!=1){
						$('#cms-load-posts').find('a').text('Loading posts...');
						$('#cms-load-posts').find('a').data('loading',1);
						$.loadData();
					}
				}
			}
		}

	})
	
})(jQuery)