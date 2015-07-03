


<!-- THE FOLLOWING CODE GOES IN THE BODY OF THE HTML DOCUMENT WHERE THE TRIP PLANNER FORM SHOULD APPEAR -->

<div id="trip_planner">

<h2>Plan Your Trip</h2>



<form name="f" action="http://www.trilliumtransit.com/redirect/google_redirect.php"><input type="hidden" name="ie" value="UTF8"/><input type="hidden" name="f" value="d"/>
    <table>
        <tr class="min-hide">
            <td style="font-size:14px;" class="planner-title" ><strong>Start</strong></td>
 </tr>
 
 <tr class="minimized-visible">
            <td valign="top"><input  type="text" alt="Start address"  name="saddr" tabindex="1" maxlength="2048" id="saddr" placeholder="Enter your start location"/>
            <span class="min-hide"><font size="-2">e.g. North D Street, San Bernardino, CA</font></td></span>
</tr>

<tr class="min-hide">
<td style="font-size:14px;" class="planner-title" ><strong>End</strong>&nbsp;&nbsp;</td></tr>
<tr class="min-hide">
<td><input  type="text" alt="Destination address" placeholder="Enter your destination" name="daddr" id="daddr" tabindex="1" maxlength="2048"/><input type="hidden" name="sll" value="35.372915,-119.018819" />
<font size="-2">e.g. Bear Valley Community Hospital</font></td></tr> 


<tr class="min-hide">
<td><font size="-1"><input type="radio" id="leave" alt="Leave at" name="ttype" value="dep" checked="checked" tabindex="1"/><label for="leave">Depart at</label> &nbsp;or <input type="radio" alt="Arrive by at" id="arrive" name="ttype" value="arr" tabindex="1"/><label for="arrive">Arrive by</label></font></td></tr>
<tr class="min-hide">
<td><font size="-1"><input type="text" alt="Date" id="fdate" size="10" name="date" value="" tabindex="1" maxlength="100"/>  <input type="text" id="ftime" alt="Time" size="10" name="time" value="" tabindex="1" maxlength="100"/></font></td>
</tr>
<tr class="min-hide">
<td valign="top"><input type="submit" value="Get Directions" tabindex="1"/></td>
</tr>
<tr >
<td>
<span style="font-size:10px;" class="min-hide">
Read <a href="<?php echo get_site_url()?>/planner-info-and-terms-conditions/">info and terms &amp; conditions</a>.  Trip planning is provided using <a href="http://www.google.com/transit">Google Maps</a>.
</span>
</td>
</tr>
</table>

<input type="hidden" value="194" name="agency"/>


</form>

<script type="text/javascript">
var thisdate = new Date();

	
 
function formatDate(date) { 



var d = new Date(date); 
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
 
return h+':'+m+' '+dd 
}
 
document.getElementById('ftime').value=formatDate(thisdate); 


var d = new Date(),
month = d.getMonth() + 1,
day = d.getDate(),
year = d.getFullYear();

document.getElementById('fdate').value = month + '/' + day + '/' +  year ;

var format = 'g:i A';
var step = 1;

function parseTime(time, format, step) {
 
 var hour, minute, stepMinute,
 defaultFormat = 'g:ia',
 pm = time.match(/p/i) !== null,
 num = time.replace(/[^0-9]/g, '');
 
 // Parse for hour and minute
 switch(num.length) {
 case 4:
 hour = parseInt(num[0] + num[1], 10);
 minute = parseInt(num[2] + num[3], 10);
 break;
 case 3:
 hour = parseInt(num[0], 10);
 minute = parseInt(num[1] + num[2], 10);
 break;
 case 2:
 case 1:
 hour = parseInt(num[0] + (num[1] || ''), 10);
 minute = 0;
 break;
 default:
 return '';
 }
 
 if( pm === true && hour > 0 && hour < 12 ) hour += 12;
 
 if( hour >= 13 && hour <= 23 ) pm = true;
 
 if( step ) {
 if( step === 0 ) step = 60;
 stepMinute = (Math.round(minute / step) * step) % 60;
 if( stepMinute === 0 && minute >= 30 ) {
 hour++;
 if( hour === 12 || hour === 24 ) pm = !pm;
 }
 minute = stepMinute;
 }
 
 if( hour <= 0 || hour >= 24 ) hour = 0;
 if( minute < 0 || minute > 59 ) minute = 0;
 
 return (format || defaultFormat)
        .replace(/g/g, hour === 0 ? '12' : 'g')
 .replace(/g/g, hour > 12 ? hour - 12 : hour)
 .replace(/G/g, hour)
 .replace(/h/g, hour.toString().length > 1 ? (hour > 12 ? hour - 12 : hour) : '0' + (hour > 12 ? hour - 12 : hour))
 .replace(/H/g, hour.toString().length > 1 ? hour : '0' + hour)
 .replace(/i/g, minute.toString().length > 1 ? minute : '0' + minute)
 .replace(/s/g, '00')
 .replace(/a/g, pm ? 'pm' : 'am')
 .replace(/A/g, pm ? 'PM' : 'AM');
 
}


function update() {
    $('#ftime').val(parseTime($('#ftime').val(), format, step));   
}

$(document).ready( function() {
    
    $('#ftime').blur(update);

 $(function() {
    $( "#fdate" ).datepicker({dateFormat: "mm/dd/yy"});
    
  });
    

});

</script>


</div>

