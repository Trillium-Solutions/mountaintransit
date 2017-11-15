( function($) { 

$(document).ready(function() {
	
	// Trip planner functionality
	function getLocation(e) {
		var fieldId = e.target.parentElement.value;
		var field = document.getElementById(fieldId);
		var placeholder = field.placeholder;
		field.value = "";
		field.placeholder = "Getting current coordinates...";
		navigator.geolocation.getCurrentPosition( function(position) {
			field.value = position.coords.latitude + ', ' + position.coords.longitude;
			field.placeholder = placeholder;
		});
	}
	
	function formatTime(d) {
		var hh = d.getHours(); 
		var m = d.getMinutes(); 
		var dd = "AM"; 
		var h = hh; 
		if (h >= 12) { 
			h = hh-12; 
			dd = "PM"; 
		} 
		if (h == 0) { 
			h = 12; 
		} 
		m = m<10?"0"+m:m; 

		return h+':'+m+' '+dd;
	}
	
	if ($('body').hasClass('home')) {
		// Geolocation Buttons
		var locationButtons = document.querySelectorAll('#planner .crosshair-icon');
		if ( !navigator.geolocation ) {
			for (i = 0; i < locationButtons.length; i++) {
				locationButtons[i].classList.add('hidden');
			}
		} else {
			for (var i = 0; i < locationButtons.length; i++) {
				locationButtons[i].addEventListener('click', getLocation, false);
			}
		}
		
		var switchButton = document.querySelectorAll('#planner .switch-icon')[0];
		switchButton.addEventListener('click', function() {
			var start = document.getElementById('saddr');
			var end = document.getElementById('daddr');
			var startval = start.value;
			start.value = end.value;
			end.value = startval;
		}, false);
	
		var editButton = document.querySelectorAll('#default-settings button')[0];
		editButton.addEventListener('click', function() {
			document.getElementById('default-settings').classList.add('hidden');
			document.getElementById('additional-settings').classList.remove('hidden');
		}, false);
		
		var timeField = document.getElementById('ftime');
		var dateField = document.getElementById('fdate');
		var now = new Date();
		mm = now.getMonth() + 1;
		dateField.value = mm + '/' + now.getDate() + '/' + now.getFullYear();
		timeField.value = formatTime(now);
		
	}
	
	if ($('body').hasClass('single-route')) {
		$('#route-select-dropdown button').on('click tap', function() {
			$('#route-select-dropdown .dropdown-menu').slideToggle('fast');
			var exp = $(this).attr('aria-expanded');
			$(this).attr('aria-expanded', exp == 'true' ? 
			'false' : 'true');
		});
		
	}
	
});


})(jQuery);