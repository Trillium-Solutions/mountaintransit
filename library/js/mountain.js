( function($) { 

$(document).ready(function() {
	
	
	// MAP HOVER FUNCTIONS
	$('li#dial-a-ride-link>ul>li').click( function(event) {
		window.location=$(this).find("a").attr("href"); 
		return false;
	});

	$('#generic-route-list ul li').click(function() {

		window.location.href = $(this).find('a').attr('href');	

	});

	$('#generic-route-list ul li').hover(function() {
	
		var name = $(this).find('a').text();
		var cleanName = name.replace(/\s+/g, "-");
		var starter = "_";
		var finalStr = starter.concat(cleanName);
		finalStr = finalStr.toLowerCase();
		finalStr =  finalStr.replace("big-bear-weekend", "weekend");
		$('#map-hovers').addClass(finalStr);

	}, function() {

		var name = $(this).find('a').text();
		var cleanName = name.replace(/\s+/g, "-");
		var starter = "_";
		var finalStr = starter.concat(cleanName);
		finalStr = finalStr.toLowerCase();
		finalStr =  finalStr.replace("big-bear-weekend", "weekend");
		$('#map-hovers').removeClass(finalStr);

	});

	// Causing errors on hover for amtrak, omni links
	$('#map-hovers area').hover (function() {
		$('#generic-route-list ul li.'+$(this).attr('alt')).addClass('hover');
	}, function() {
		$('#generic-route-list ul li.'+$(this).attr('alt')).removeClass('hover');
	});

	$('#trip-planner-container').click(function() 
	
	{
		if($('#planner-expand-contract-tab').text() != 'hide') {
			$(this).find('.min-hide').css('display', 'table-row');
			$('#planner-expand-contract-tab').text('hide');
			 $('#trip-planner-container').removeClass('minimized').addClass('expanded');
			  $('#planner-expand-contract-tab').removeClass('minimized').addClass('expanded');
		}
		
	});
	
	$('#planner-expand-contract-tab').click(function() {
		if($(this).text() == 'hide') {
			 $('#trip-planner-container').removeClass('expanded').addClass('minimized');
			 $('#planner-expand-contract-tab').removeClass('expanded').addClass('minimized');
			 $('#trip-planner-container .min-hide').css('display', 'none');
			 $('#planner-expand-contract-tab').text('expand');  
		} else {
			$('#trip-planner-container').find('.min-hide').css('display', 'table-row');
			$('#planner-expand-contract-tab').text('hide');
			$('#trip-planner-container').removeClass('minimized').addClass('expanded');
			$('#planner-expand-contract-tab').removeClass('minimized').addClass('expanded');
		}
	
	});
	
	$('#main-nav li, .area-box li, .route-info-box ul li').click(function() {
	
		window.location.href = $(this).find('a').attr('href');	
	
	});


	$("area").hover( function(){
	 	$("#map-hovers").addClass($(this).attr("alt"));
	 }, function() {
	 	$("#map-hovers").removeClass($(this).attr("alt"));
	});
	 
	$('.area-box li').hover( function() {
		$("#map-hovers").addClass($(this).find('.route-name').attr("alt"));
	
	}, function() {
		$("#map-hovers").removeClass($(this).find('.route-name').attr("alt"));
	
	});


	$(window).scroll(function(e){ 

	$('#routes-left-col').height();
	
	//the height of the floatymap and top margin cannot exceed the height of left column.
	  $el = $('#map-floaty-box'); 
	  if ($(this).scrollTop() > 330){ 
		//$el.css({'position': 'fixed', 'top': '0px'}); 
		var margTop = Math.min($(this).scrollTop()-300, $('#routes-left-col').height()-$('#map-floaty-box').height());
		$el.css('margin-top', margTop);
		$el.css('border-top-right-radius', 0);  
		  
	  }
	  if ($(this).scrollTop() < 330 )
	  {
		//$el.css({'position': 'absolute', 'top': '0px'});
		$el.css('margin-top', 0);
		$el.css('border-top-right-radius', 10);
		
	  } 
	});
	
	
	$('.post-type-archive-route .area-box h2').click(function() {
	
		if($(this).parent().hasClass('minimized')) {
			$(this).parent().find('ul').show();
			$(this).parent().removeClass('minimized').addClass('expanded');
			$(this).parent().find('.open-close-text').text('Click to hide area routes');
		} else {
			$(this).parent().find('ul').hide();
			$(this).parent().removeClass('expanded').addClass('minimized');
			$(this).parent().find('.open-close-text').text('Click to show area routes');
		}
	
	}); 
	
	// auto h2 anchors in generic content 
	
	var $h2s = $('h3,h2,h4,h5');
    var $anchorLinks = $('#page-anchor-links ul');
   // if ($h2s.length > 0) {
   // 	 $('#subpage-anchor-links').addClass('show');
   // }
   
   	var _count = 0;
    $.each($h2s, function() { 
    	var text = $(this).text();
    	$anchorLinks.append($('<li><a href="#'+text+'">'+text+'</a></li>'));
    	$(this).prepend($('<a name="'+text+'"></a>'));
    	_count+=1;
    });
    if (_count == 0) {
		$anchorLinks.parent().css('display', 'none'); 
		$anchorLinks.css('border-bottom', '0');
	}

	$('a').click( function() {
    
    	highlightAnchorH2($(this).attr("href"));
    });
    
    
    // make schedules li click work for link
    $('#schedule-links li').click(function() {
    	window.location.href = $(this).find('a').attr('href');
    
    });
    
     
    // full screen route tables 
    
    $('#fullscreen-table-link').click( function() {
    	if($('.route-info-box.timetables').hasClass('fullscreen')) {
    		    	$('.route-info-box.timetables').removeClass('fullscreen');
    		    	$(this).find('a span').text('Open timetables in full window');
    	} else {
    		$('.route-info-box.timetables').addClass('fullscreen');
    		$(this).find('a span').text('Close timetables window');
    	}

    })
    
    $(document).keyup(function(e) {

 		 if (e.keyCode == 27) { 
 		 	if($('.route-info-box.timetables').hasClass('fullscreen')) { 
 		 		$('.route-info-box.timetables').removeClass('fullscreen');
    		     $('#fullscreen-table-link').find('a span').text('Open timetables in full window');
 		 	}
 		 
 		  }   // esc
	});
    
    $(window).scroll(function(e){  
   		 $('.route-info-box.timetables.fullscreen #timetable-holder ').css('top', 0-$(this).scrollTop()  );

    });
    
    
    $('.side-clicker').each(function(index, clicker) {
  			
  			$(clicker).height($(clicker).parent().find('tbody').height() +$(clicker).parent().find('caption').height() + 10 );
  		
  		});
   
    // expand detail maps

    $('.single-route li.route-detail-holder').click(function(event) {
   	 if($(this).find('span').hasClass('min')) {
			event.preventDefault();
			var image = new Image();

		 //add image path
		 $span = $(this).find('span');
		  image.src = $(this).find('a').attr('href');
			$link = $(this).find('a');
		  //bind load event
		  $(this).append('<div class="detail-loading"></div>');
		  image.onload = function(){
			//now load next image
			$span.addClass('exp');
			$span.removeClass('min');
			$link.find('img.sml').css('display','none');
			$link.parent().find('.detail-loading').remove();
			$link.append('<img class="large" src ="'+image.src+'" />');
			
		
			};
		} else {
			event.preventDefault();
		
			$link = $(this);
			 $span = $(this).find('span');
			 $span.addClass('exp');
			$span.removeClass('min');
		  //bind load event
			
			//now load next image
			$span.addClass('min');
			$span.removeClass('exp');
			$link.find('img.sml').css('display','inherit');
			$link.find('img.large').remove();
			
		}
	});
});

function highlightAnchorH2(name) {
	var origCol =  $('a[name=\''+name.slice(1)+'\']').parent().css('background-color');
	$('a[name=\''+name.slice(1)+'\']').parent().css('background-color', 'yellow');
	$('a[name=\''+name.slice(1)+'\']').parent().animate( { backgroundColor: origCol }, 700);
}

function shadeColor1(color, percent) {  
    var num = parseInt(color,16),
    amt = Math.round(2.55 * percent),
    R = (num >> 16) + amt,
    G = (num >> 8 & 0x00FF) + amt,
    B = (num & 0x0000FF) + amt;
    return (0x1000000 + (R<255?R<1?0:R:255)*0x10000 + (G<255?G<1?0:G:255)*0x100 + (B<255?B<1?0:B:255)).toString(16).slice(1);
}

function LightenDarkenColor(col, amt) {
  
    var usePound = false;
  
    if (col[0] == "#") {
        col = col.slice(1);
        usePound = true;
    }
 
    var num = parseInt(col,16);
 
    var r = (num >> 16) + amt;
 
    if (r > 255) r = 255;
    else if  (r < 0) r = 0;
 
    var b = ((num >> 8) & 0x00FF) + amt;
 
    if (b > 255) b = 255;
    else if  (b < 0) b = 0;
 
    var g = (num & 0x0000FF) + amt;
 
    if (g > 255) g = 255;
    else if (g < 0) g = 0;
 
    return (usePound?"#":"") + (g | (b << 8) | (r << 16)).toString(16);
  
}
})(jQuery);