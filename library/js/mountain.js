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

	function hideHighlights() {
		$('#route-highlights > g').css('opacity', '0');
	}
	function showHighlight(routeId) {
		$('#route-highlights g[data-name="' + routeId + '"]').css('opacity', '1');
	}
	function loadRoutePage(routeId) {
		$('#route-legend a[data-name="' + routeId + '"]')[0].click();
	}

	function initialize() {
		var defaultBounds = new google.maps.LatLngBounds(
			new google.maps.LatLng(34.074043,  -117.332459),
	        new google.maps.LatLng(34.311914, -116.794426)
		);

		var origin_input = document.getElementById('saddr');
		var destination_input = document.getElementById('daddr');
		var options = {
			bounds: defaultBounds,
			componentRestrictions: {country: 'us'}
		};

		var autocomplete_origin = new google.maps.places.Autocomplete(origin_input, options);
		var autocomplete_destination = new google.maps.places.Autocomplete(destination_input, options);
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

		// Stylized Interactive Map
		$('#hovers polygon').on('mouseenter', function() {
			hideHighlights();
			showHighlight(this.id.split('-')[0]);
		}).on('mouseleave', function() {
			hideHighlights();
		}).on('click', function() {
			loadRoutePage(this.id.split('-')[0]);
		});

		$('#route-legend a').on('mouseenter', function() {
			hideHighlights();
			showHighlight(this.dataset.name);
		}).on('mouseleave', function() {
			hideHighlights();
		});

		google.maps.event.addDomListener(window, 'load', initialize);

	}

	Array.prototype.contains = function(val) {
		for(var i = 0; i < this.length; i++) {
			if(this[i] === v) return true;
		}
		return false;
	}

	Array.prototype.uniq = function() {
		var arr = [];
		for (var i = 0; i < this.length; i++) {
			if(!arr.includes(this[i])) {
				arr.push(this[i]);
			}
		}
		return arr;
	}

	function getButton(attr) {
		return $('<button/>', {
			text: attr,
			'data-target': attr
		});
	}

	function swapTimetables() {
		var dir = $('#timetables .button-group.dir .active').data('target');
		var days = $('#timetables .button-group.days .active').data('target');
        $('#timetables .timetable-holder').hide();
		$('#timetables .timetable-holder[data-days="'+days+'"][data-dir="'+dir+'"]').show();
	}

	function addTimetableButtons(dataclass) {
		var btn_group = $('#timetables .button-group.' + dataclass);
		var timetables = $('#timetables .timetable-holder');
		var attrs = timetables.map(function() {
			return $(this).data(dataclass);
		}).get();
		attrs = attrs.uniq();

		// Add a button for each unique value
		for (var i = 0; i < attrs.length; i++) {
			var btn = getButton(attrs[i]);
			btn.appendTo(btn_group);
			btn.on('click tap', function() {
				btn_group.children('button').removeClass('active');
				$(this).addClass('active');
				swapTimetables();
			});
		}
		btn_group.children('button').first().addClass('active');
	}

	if ($('body').hasClass('single-route')) {
		$('#route-select-dropdown button').on('click tap', function() {
			$('#route-select-dropdown .dropdown-menu').slideToggle('fast');
			var exp = $(this).attr('aria-expanded');
			$(this).attr('aria-expanded', exp == 'true' ?
			'false' : 'true');
		});

		if ( $('#timetables .timetable-holder').length > 0 )  {
			// Add timetable selection
			addTimetableButtons('dir');
			addTimetableButtons('days');
			swapTimetables();
		} else {
			$('#timetables').hide();
		}

		// Fixed column timetables
	    $('.table').each(function() {
	        var $tableClass = $(this);
	        // Clone the first column, and absolutely position over table.
	        var $fixedColumn = $tableClass.clone().insertBefore($tableClass).addClass('fixed-column');
	        $fixedColumn.find('th:not(:first-child),td:not(:first-child)').remove();
	    });
	}

});


})(jQuery);
