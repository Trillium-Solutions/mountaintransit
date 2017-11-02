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
						<div id="google_translate_element"></div>
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
							<form action="<?php echo get_site_url();?>/" method="get">
								<input type="text" name="s" id="search" placeholder="Search" value="<?php the_search_query(); ?>" />
								<input type="image" alt="Search" src="<?php echo get_template_directory_uri(); ?>/library/images/clear.png" id="header-search-icon-submit" />
							</form>
						</div><!-- end #search-wrap-->
					
						<div id="fares-and-tickets-container">
							<a href="<?php echo get_permalink(320) ?>"><i></i>Fares and Tickets</a>
						</div>
						
					</div> <!-- end number-and-search-wrap -->

					<a href="<?php echo home_url(); ?>" rel="nofollow"><div id="logo"></div></a>
					
					<nav id="main-nav">
						<ul>
							<li id="rim-routes-link" class="<?php if( is_post_type_archive('route') && get_query_var('service_area') == 'rim'){echo 'current';}else if ( ('route' == get_post_type() ||  'timetable' == get_post_type()) && get_field('pdf_service_area')=='rim') {echo "parent-active"; }?>"><a href="<?php echo get_site_url() ?>/rim-routes-and-schedules/"><span>RIM <br />Routes &amp; <br />Schedules</span></a></li>
							<li class="divider"></li>
							<li id="big-bear-link" class="<?php if( is_post_type_archive('route') && get_query_var('service_area') == 'big-bear'){echo 'current';}else if ( ('route' == get_post_type() ||  'timetable' == get_post_type()) && get_field('pdf_service_area')=='big-bear') {echo "parent-active"; }?>"><a href="<?php echo get_site_url() ?>/big-bear-routes-and-schedules/"><span>Big Bear <br/>Routes &amp;<br /> Schedules</span></a></li>
							<li class="divider"></li>
							<li id="dial-a-ride-link">
								
									<span><i id="dial-a-ride-icon"></i>
										Dial-A-Ride
									</span>
										<ul>
											<li class="first">
												<a href="<?php echo get_the_permalink(552);?>">How to Use Dial-A-Ride</a>
											</li>
											<li >
												<a href="<?php echo get_the_permalink(20);?>">Big Bear Valley</a>
											</li>
											<li class="last">
												<a href="<?php echo get_the_permalink(27); ?>">Rim Area</a>
											</li>
										</ul>
							</li>
							<li class="divider"></li>  
							<li id="weekend-trolley-link"><a href="<?php echo get_site_url(); ?>/route/big-bear-weekend-trolley" ><span>Weekend Trolley</span></a></li>
						</ul>
					</nav>

					<nav role="navigation">
						<?php wp_nav_menu(array(
    					'container' => false,                           // remove nav container
    					'container_class' => 'menu cf',                 // class of container (should you choose to use it)
    					'menu' => __( 'The Main Menu', 'bonestheme' ),  // nav name
    					'menu_class' => 'nav top-nav cf',               // adding custom nav class
    					'theme_location' => 'main-nav',                 // where it's located in the theme
    					'before' => '',                                 // before the menu
        			'after' => '',                                  // after the menu
        			'link_before' => '',                            // before each link
        			'link_after' => '',                             // after each link
        			'depth' => 0,                                   // limit the depth of the nav
    					'fallback_cb' => ''                             // fallback function (if there is one)
						)); ?>

					</nav>
				</div>
			</header>
			
			<div id="content">
				<div id="inner-content" class="wrap cf">
