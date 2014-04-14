<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />

	<!-- Set the viewport width to device width for mobile -->
	<meta name="viewport" content="width=device-width" />


	<!-- Grid CSS File (only needed for demo page) -->
	<link rel="stylesheet" href="css/paragridma.css">

	<!-- Core CSS File. The CSS code needed to make eventCalendar works -->
	<link rel="stylesheet" href="css/eventCalendar.css">

	<!-- Theme CSS file: it makes eventCalendar nicer -->
	<link rel="stylesheet" href="css/eventCalendar_theme_responsive.css">

	<!--<script src="js/jquery.js" type="text/javascript"></script>-->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js" type="text/javascript"></script>
	<script src="js/jquery.eventCalendar.js" type="text/javascript"></script>

</head>
<body id="responsiveDemo">
	<hr />
	<div class="container">
	
	
		<div class="row">
			<div class="g6">
				<h2 class="h4">Human Date Format</h2>
				<p class="demoDesc">Most of you don't like timestamp date format, so now you can use another formats</p>
				<div id="eventCalendarHumanDate"></div>
				<script>
					$(document).ready(function() {
						$("#eventCalendarHumanDate").eventCalendar({
							eventsjson: 'json/event.humanDate.json.php',
							jsonDateFormat: 'human'  // 'YYYY-MM-DD HH:MM:SS'
							
							
						});
					});
				</script>
			</div>
		</div>
		
		
		
		<div class="row">
			<div class="g4">
				<h2 class="h4">Default Demo</h2>
				<p class="demoDesc">Example of jQuery Events Calendar with default parameters</p>
				<div id="eventCalendarDefault"></div>
				<script>
					$(document).ready(function() {
						$("#eventCalendarDefault").eventCalendar({
							eventsjson: 'json/events.json.php' // link to events json
						});
					});
				</script>
			</div>
		</div>
		
		
	</div>