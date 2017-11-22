<?php
/* Trip planner template */
?>

    <div id="planner-header">
		<h1>Plan Your Trip</h1>
	</div>
	<div id="planner-body" class="clear">
		<form name="f" action="http://jump.trilliumtransit.com/redirect.php">
            <input type="hidden" name="sort" value="walk"/>
			<div class="form-row">
                <div class="err-msg" tabindex="-1">Please enter a valid starting address.</div>
				<label for="saddr">From</label>
				<input type="text" name="saddr" id="saddr" placeholder="Address, landmark, or intersection" required="required">
				<button class="crosshair-icon" type="button" value="saddr"><?php echo file_get_contents(get_theme_file_path("library/images/crosshair.svg")); ?><span>Use current location</span></button>
			</div>
			<button type="button" class="switch-icon tooltip"><span class="screen-reader-text">Switch Start and End Locations</span><?php echo file_get_contents(get_theme_file_path("library/images/sort.svg")); ?></button>
			<div class="form-row">
                <div class="err-msg" tabindex="-1">Please enter a valid destination address.</div>
				<label for="daddr">To</label>
				<input type="text" name="daddr" id="daddr" placeholder="Address, landmark, or intersection" required="required">
				<button class="crosshair-icon" type="button" value="daddr"><?php echo file_get_contents(get_theme_file_path("library/images/crosshair.svg")); ?><span>Use current location</span></button>
			</div>
			<div id="default-settings">
				<div class="form-row clear">
					<div>Departing: <strong>Now</strong></div>
					<button type="button" class="btn btn-default">Edit</button>
				</div>
			</div>
			<div id="additional-settings" class="hidden">
				<div class="form-row">
					<select class="form-control" name="ttype">
						<option value="dep">Leave at</option>
						<option value="arr">Arrive by</option>
					</select>
				</div>
				<div class="form-row">
	                <div class="err-msg" tabindex="-1">Please enter a valid time.</div>
					<label for="ftime" class="obscure screen-reader-text">Time</label>
					<input type="text" id="ftime" name="time" value="">
					<label for="fdate" class="obscure screen-reader-text">Date</label>
					<input type="text" id="fdate" name="date" value="">
				</div>
			</div>

			<button type="submit" class="btn btn-default">Get Directions</button>
		</form>
	</div>

