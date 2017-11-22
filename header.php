<?php
/* Header for all pages */

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	
	<?php wp_head(); ?>
	
	<script>
	  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
	  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
	  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
	  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

	  ga('create', 'UA-54148164-1', 'auto');
	  ga('send', 'pageview');

	</script>

	<meta name="google-translate-customization" content="f25af25643c7b829-5e44eb73351882d9-gcc7ef8ab8e200b71-13"></meta>
</head>

<body <?php body_class(); ?>>
	<div id="container">
		<header class="header" role="banner">
			<div id="inner-header" class="wrap cf">
				<div id="number-and-search-wrap">
					<div id="google_translate_element">
					</div>
					
					<script type="text/javascript">
					function googleTranslateElementInit() {
					  new google.translate.TranslateElement({pageLanguage: 'en', layout: google.translate.TranslateElement.InlineLayout.SIMPLE}, 'google_translate_element');
				  	}
					</script>
					<script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
						
					<div id="service-phone">
						<a href="tel:9098785200">Info: 909-878-5200</a>  
					</div>
				
					<div id="search-wrap">
						
						<?php get_search_form(); ?>
						
					</div><!-- end #search-wrap-->
				</div> <!-- end number-and-search-wrap -->

				<a href="<?php echo home_url(); ?>" rel="nofollow"><div id="logo"></div></a>
				<br style="clear:both" />
				<nav id="main-nav">
					<ul id="top-level-nav">
						<li><a>Routes &amp; Schedules</a>
							<div class="dropdown">
								
								<?php marta_organized_routes(); ?>
								
							</div>
						</li>
						<li><a href="fares-and-tickets">Fares &amp; Passes</a></li>
						<li><a>How to Ride</a>
							<div class="dropdown">
								
								<?php get_template_part( 'secondary-icon-links'); ?>
								
							</div>
						</li>
					</ul>
				</nav>
			</div>
		</header>
			
		<div id="content">
			<div id="inner-content" class="wrap cf">
