$( window ).resize(function() {
  
  	swapPlanners();
  
});


function swapPlanners() {

if($(window).width() < 768) {
	$('#mobile-planner-container').html($('#trip-planner-container').html());
	$('#mobile-planner-container').addClass('swappedPlanner');
} else if($('#mobile-planner-container').hasClass('swappedPlanner')) {
	$('#trip-planner-container').html($('#mobile-planner-container').html());
	$('#mobile-planner-container').removeClass('swappedPlanner');
}




		
}

$(document).ready(function(){


	swapPlanners();

	/**** timetable support **/
	// get width of number cell and stop name cell.
	
	//for each row in a table
	/// find the max width of the th cell plus the number cell
	/// set padding of 3rd cell to that width
	

	
	//$('#fake-scroll').jScrollPane();
	//$('.timetable-holder2').jScrollPane();
	

	// trying to fix td/th per row issue.
	/*$('.single-route table').each(function(i, table) {
		var tdThCount = 0;
		var tdCount = $(table).find('tr:first td').length;
		var thCount = $(table).find('tr:first tr').length;
		tdThCount = $(table).find;
		
		$(table).find('tr').each( function(i, tr) {
			alert($(tr).find('td,th').length);
			if(   $(tr).find('td,th').length < tdThCount ) {
				$(tr).append($('<td></td>'));
			}
			
			});
		
		
		});


	*/
	
	
	$('.single-route table tr').each(function() {
	
		if( ($(this).find('th.days-of-week').length > 0) || ($(this).find('th.weekday-only').length > 0 )  ) {
			$(this).addClass('days-of-week-row');
		}
	
	});
	
	
	$('.single-route #timetable-holder table').wrap('<div class="timetable-holder2"></div><!-- end #timetable-holder2-->');
	
	
	
	
	

	
	var headerWidth = 30;
	var maxWidth = -99999;
	// clean up route tables stuff //
	$('.single-route table').each(function(i, tbody) {
		
		
		var captionHeight = $(tbody).find('caption').height();
			$(tbody).find('tbody').css('margin-top', captionHeight + 10);
		
		 $(tbody).find('tr').each(function(j, tr) {
			
			var th = $(tr).find('th')
			var trWidth = $(th).width() + parseFloat($(th).css('padding-right'), 10) + parseFloat($(th).css('padding-left'), 10) + 20;
			if(trWidth > maxWidth) maxWidth = trWidth ;
			
		
		});
		
		
		
		
		
		 $(tbody).find('tr').each(function(j, tr) {
		 	if($(tr).find('.timepoint-number').length != 0) {
		 	
		 		$(tr).find('.timepoint-number').height($(tr).find('th').height());
		 	
		 	// has timepoint
		 		$(tr).find('th').width(maxWidth - 30 + 10);
		 		$(tr).children().each(function(p, child) {
		 			if(p == 2) {
		 				$(child).css('padding-left', maxWidth + 20 + 30 + 15);
		 			}
		 		
		 		});
		 	} else {
		 	if(!$(tr).hasClass('days-of-week-row')) {
		 		$(tr).find('th').width(maxWidth +10); 
		 	} else {
		 		$(tr).find('th:first').css('height',$(tr).find('th:first')).css('padding-left', maxWidth + 60);
		 		$(tr).find('td:first').css('height',$(tr).find('th:first').height() + 10 ).width(maxWidth + 19);
		 	}
		 	
		 	}
		 	
		 
		 	
		 
		 });
		 
		  $(tbody).find('tr').not(':first').each(function(j, tr) {
		 
		 			$(tr).height($(tr).find('th:first').height() );
		 		
		 	});
		 	
		
		
		
		
	
	});
	
	$('.timetable-holder2 table tr:first th.weekday-only').each(function () {
    	$('.timetable-holder2 table tbody td:nth-child(' + ($(this).index() - 1 ) + ')').addClass('weekday-only-td');
})
	
	
	
	$('.timetable-holder2').each(function(index, element)  {
		
		//find if table is wider
		if($(this).find('tbody').width() > $(this).width()) {
			
		}
	
	});
	$('table').each(function(i, tbody) {
		$(tbody).parent().find('#left-side-clicker').css('left', maxWidth + 30 );
	});
	
	$('.timetable-holder2').each(function(index1) {
			$(this).addClass('scroller'+index1);
			$(this).before(function(index, tableholder) {
				var width = $(this).find('table').width();	
				return '<div id="fake-scroll" class="scroller'+index1+'"><div id="fake-width" style="width:'+width+'px;">&nbsp;</div></div>';
	
			});
	});
	
	
	$('#fake-scroll').each(function(index, scroll) {
	//	$(this).find('#fake-width').width($(this).next().find('table').width( ) ) ;
	});
	
	
	var fakeScroll = $('#fake-scroll.scroller0').jScrollPane({/* ...settings... */});
	var fakeScrollAPI1 = $('#fake-scroll.scroller0').data('jsp');
	
	$('#fake-scroll.scroller0')
			.bind(
				'jsp-scroll-x',
				function(event, scrollPositionX, isAtLeft, isAtRight)
				{
					
				
					$(".timetable-holder2.scroller0").scrollLeft((fakeScrollAPI1.getPercentScrolledX()) * 
												($(".timetable-holder2.scroller0").find('tbody').width()+1-$(".timetable-holder2.scroller0").width() )  );
					
					
					if(isAtRight) {
						$(this).siblings('.scroller0').find('#right-side-clicker').removeClass('show');
					} else {
						$(this).siblings('.scroller0').find('#right-side-clicker').addClass('show');
					}
					
					
					if(isAtLeft) {
						$(this).siblings('.scroller0').find('#left-side-clicker').removeClass('show');
					} else {
						$(this).siblings('.scroller0').find('#left-side-clicker').addClass('show');
					}
				
				});
		
		$(".timetable-holder2.scroller0").scroll(function(){
			
			
		  var fakeScrollAPI = $('#fake-scroll.scroller0').data('jsp');
    	//  fakeScrollAPI.scrollTo ($(this).scrollLeft()/1.6,0,false);
    	  fakeScrollAPI.scrollToPercentX( 
    	  			$(".timetable-holder2.scroller0").scrollLeft()/
    	  			($(".timetable-holder2.scroller0").find('tbody').width()-$(".timetable-holder2.scroller0").width() )
    	  			);
    	  
    	  
  		});
  		
  		var fakeScroll = $('#fake-scroll.scroller1').jScrollPane({/* ...settings... */});
	var fakeScrollAPI2 = $('#fake-scroll.scroller1').data('jsp');
	
	$('#fake-scroll.scroller1')
			.bind(
				'jsp-scroll-x',
				function(event, scrollPositionX, isAtLeft, isAtRight)
				{
					
				
					$(".timetable-holder2.scroller1").scrollLeft(fakeScrollAPI2.getPercentScrolledX() * 
												($(".timetable-holder2.scroller1").find('tbody').width()+1-$(".timetable-holder2.scroller1").width() )  );
					
					
					if(isAtRight) {
						$(this).siblings('.scroller1').find('#right-side-clicker').removeClass('show');
					} else {
						$(this).siblings('.scroller1').find('#right-side-clicker').addClass('show');
					}
					
					
					if(isAtLeft) {
						$(this).siblings('.scroller1').find('#left-side-clicker').removeClass('show');
					} else {
						$(this).siblings('.scroller1').find('#left-side-clicker').addClass('show');
					}
				
				});
		
		$(".timetable-holder2.scroller1").scroll(function(){
			
			
		  var fakeScrollAPI22 = $('#fake-scroll.scroller1').data('jsp');
    	//  fakeScrollAPI.scrollTo ($(this).scrollLeft()/1.6,0,false);
    	  fakeScrollAPI22.scrollToPercentX( 
    	  			$(".timetable-holder2.scroller1").scrollLeft()/
    	  			($(".timetable-holder2.scroller1").find('tbody').width()-$(".timetable-holder2.scroller1").width() )
    	  			);
    	  
    	  
  		});
  		
  		
  		
  		
  		
  		
  		
		
	
	
	$('.timetable-holder2').each(function(index, element)  {
		
		//find if table is wider
		if($(this).find('tbody').width() > $(this).width()) {
			$(this).prepend('<div id="left-side-clicker" class="side-clicker"> </div> <div id="right-side-clicker" class="side-clicker show"></div>');
			$(this).prev().before('<div id="scroll-text">Scroll to see entire timetable</div>');
		}
	
	});
	
	
	
	
	
	

	$('li#dial-a-ride-link>ul>li').click( function(event) {
		window.location=$(this).find("a").attr("href"); 
		return false;
	});


/* HOME */


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


$('#map-hovers area').hover (function() {
	$('#generic-route-list ul li.'+$(this).attr('alt')).addClass('hover');

}, function() {

$('#generic-route-list ul li.'+$(this).attr('alt')).removeClass('hover');
});



 $('path').click(function() {
 
 	alert($(this).attr('fill'));
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
    if (_count == 0) {$anchorLinks.parent().css('display', 'none'); $anchorLinks.css('border-bottom', '0');}
    
    


	$('a').click( function() {
    
    	highlightAnchorH2($(this).attr("href"));
    });
    
    
    // make schedules li click work for link
    $('#schedule-links li').click(function() {
    	window.location.href = $(this).find('a').attr('href');
    
    });
    
   
    // make generic columns the same height:
    if( $("#main").height() < $('#sidebar1').height()) {
    	$("#main").height($('#sidebar1').height() - $("#main").css('margin-top') - $("#main").css('margin-bottom'));
    } else if( $("#main").height() > $('#sidebar1').height()){
   		 $("#sidebar1").height($('#main').height() - 20 );
    }
    
    
    if( $('body').hasClass('single-route') ) {
    	if( $("#route-left-col").height() < $('#route-side-col').height()) {
    	$("#route-left-col").height($('#route-side-col').height() - $("#route-left-col").css('margin-top') - $("#route-left-col").css('margin-bottom'));
    } else if( $("#route-left-col").height() > $('#route-side-col').height()){
   		 $("#route-side-col").height($('#route-left-col').height() - 2 );
    }
    
    }
    
  //  $('#timetable-content').css('background', shadeColor1( $('#timetable-content').css('background-color'), 60);
    
    
    
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
		
			 
	   // 
	});
	
	
	$('.route-alert-header').click(function() {
	
		if($(this).parent().hasClass('minimized')) {
			$(this).parent().find('#alert-content').show();
			$(this).parent().removeClass('minimized').addClass('expanded');
			$(this).parent().find('#alert-click-message').text('Click to Hide');
			
		} else {
			$(this).parent().find('#alert-content').hide();
			$(this).parent().removeClass('expanded').addClass('minimized');
			$(this).parent().find('#alert-click-message').text('Click to Expand');
		
		}
	
	}); 
	
	$("h2:contains('\(FOR SENIORS AND PERSONS WITH DISABILITIES WITH VALID DISCOUNT CARD, AND YOUTHS\)')").html(function(_, html) {
   return html.replace(/(cow)/g, '<span class="discount-text">$1</span>'); 
});
	
	
	
});

$(window).load( function() {

});

function resizeMainCols() {
 // make generic columns the same height:
    if( $("#main").height() < $('#sidebar1').height()) {
    	$("#main").height($('#sidebar1').height() - $("#main").css('margin-top') - $("#main").css('margin-bottom'));
    } else if( $("#main").height() > $('#sidebar1').height()){
   		 $("#sidebar1").height($('#main').height() - 20 );
    } 
    
     if( $('body').hasClass('single-route') ) {
    	if( $("#route-left-col").height() < $('#route-side-col').height()) {
    	$("#route-left-col").height($('#route-side-col').height() - $("#route-left-col").css('margin-top') - $("#route-left-col").css('margin-bottom'));
    } else if( $("#route-left-col").height() > $('#route-side-col').height()){
   		 $("#route-side-col").height($('#route-left-col').height() - 2 );
    }
    
    
    }

}

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