<?php
/*
Author: Eddie Machado
URL: http://themble.com/bones/

This is where you can drop your custom functions or
just edit things like thumbnail sizes, header images,
sidebars, comments, ect.
*/

// LOAD BONES CORE (if you remove this, the theme will break)
require_once( 'library/bones.php' );

/*********************
LAUNCH BONES
Let's get everything up and running.
*********************/

function bones_ahoy() {

  // let's get language support going, if you need it
  load_theme_textdomain( 'bonestheme', get_template_directory() . '/library/translation' );

  // launching operation cleanup
  add_action( 'init', 'bones_head_cleanup' );
  // A better title
  add_filter( 'wp_title', 'rw_title', 10, 3 );
  // remove WP version from RSS
  add_filter( 'the_generator', 'bones_rss_version' );
  // remove pesky injected css for recent comments widget
  add_filter( 'wp_head', 'bones_remove_wp_widget_recent_comments_style', 1 );
  // clean up comment styles in the head
  add_action( 'wp_head', 'bones_remove_recent_comments_style', 1 );
  // clean up gallery output in wp
  add_filter( 'gallery_style', 'bones_gallery_style' );

  // launching this stuff after theme setup
  bones_theme_support();

  // cleaning up random code around images
  add_filter( 'the_content', 'bones_filter_ptags_on_images' );
  // cleaning up excerpt
  add_filter( 'excerpt_more', 'bones_excerpt_more' );

} /* end bones ahoy */

// let's get this party started
add_action( 'after_setup_theme', 'bones_ahoy' );


/************* OEMBED SIZE OPTIONS *************/

if ( ! isset( $content_width ) ) {
	$content_width = 640;
}

/************* THUMBNAIL SIZE OPTIONS *************/

// Thumbnail sizes
add_image_size( 'bones-thumb-600', 600, 150, true );
add_image_size( 'bones-thumb-300', 300, 100, true );

/*
to add more sizes, simply copy a line from above
and change the dimensions & name. As long as you
upload a "featured image" as large as the biggest
set width or height, all the other sizes will be
auto-cropped.

To call a different size, simply change the text
inside the thumbnail function.

For example, to call the 300 x 300 sized image,
we would use the function:
<?php the_post_thumbnail( 'bones-thumb-300' ); ?>
for the 600 x 100 image:
<?php the_post_thumbnail( 'bones-thumb-600' ); ?>

You can change the names and dimensions to whatever
you like. Enjoy!
*/

add_filter( 'image_size_names_choose', 'bones_custom_image_sizes' );

function bones_custom_image_sizes( $sizes ) {
    return array_merge( $sizes, array(
        'bones-thumb-600' => __('600px by 150px'),
        'bones-thumb-300' => __('300px by 100px'),
    ) );
}

/* Enqueue Styles and Scripts */
function marta_scripts() {
	wp_enqueue_style( 'googleFonts', 'https://fonts.googleapis.com/css?family=Lato:400,700,400italic,700italic' );
	
	wp_enqueue_style( 'marta-style', get_stylesheet_uri() );
	
	wp_enqueue_script( 'mountain-script', get_template_directory_uri() . '/library/js/mountain.js', array('jquery', 'google-maps'), false, true );
	
	wp_enqueue_script('google-maps', "https://maps.googleapis.com/maps/api/js?key=AIzaSyDHKFNwRvNc7054bFn6LKGKAQ0tm-6VgRI&libraries=places", array(), false, true );

}
add_action( 'wp_enqueue_scripts', 'marta_scripts' );


function register_my_menus() {
  register_nav_menus(
    array(
      'secondary-link-right-menu' 	=> __( 'More Menu Links' ),
	  'footer-menu' 				=> __( 'Footer Left Menu' ),
	  'footer-secondary' 			=> __( 'Footer Right Menu' ),
    )
  );
}

add_action( 'init', 'register_my_menus' );


function the_breadcrumb() {
    global $post;
    echo '<ul id="breadcrumbs">';
	printf('<li><a href="%s">Home</a></li>', get_site_url() );
	echo '<li class="separator"> > </li>';
    if ( is_single() ) {
		$post_type = get_post_type_object( get_post_type() );
		$archive = get_post_type_archive_link( get_post_type() );
		$content = $archive ? sprintf('<a href="%s">%s</a>', $archive, $post_type->label) : $post_type->label; 
		printf('<li>%s</li>', $content );
		echo '<li class="separator"> > </li>';
    } elseif ( is_page() ) {
    	if ( $post->post_parent ) {
    		$parents = get_post_ancestors( $post->ID );
			foreach( $parents as $prev ) {
				printf('<li><a href="%s">%s</a></li>', get_permalink($prev), get_the_title($prev));
				echo '<li class="separator"> > </li>';
			}
    	}
    }
	if (get_post_type() == 'route') {
		printf('<li>%s</li>', marta_route_menu_name($post->ID));
	} elseif ( is_search() ) {
		printf('<li>Search: %s</li>', get_search_query() ); 
	} elseif ( is_404() ) {
		echo '<li>404 Not Found</li>';
	} elseif ( is_archive() ) {
		printf('<li>Archive: %s</li>', get_post_type() );
	} else {
		printf('<li>%s</li>', get_the_title() );
	}
    echo '</ul>';
}

add_action( 'init', 'codex_route_init' );
/**
 * Register a route post type.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_post_type
 */
function codex_route_init() {
	
	$dar_labels = array(
		'name'               => _x( 'Dial-A-Ride', 'post type general name' ),
		'singular_name'      => _x( 'dar', 'post type singular name' ),
		'menu_name'          => _x( 'Dial-A-Ride', 'admin menu'),
		'name_admin_bar'     => _x( 'Dial-A-Ride', 'add new on admin bar'),
		'add_new'            => _x( 'Add New', 'dar'),
		'add_new_item'       => __( 'Add New Page'),
		'new_item'           => __( 'New Dial-A-Ride Page'),
		'edit_item'          => __( 'Edit Dial-A-Ride Page'),
		'view_item'          => __( 'View Dial-A-Ride Page'),
		'all_items'          => __( 'All Dial-A-Ride Pages'),
		'search_items'       => __( 'Search Dial-A-Ride Pages'),
		'parent_item_colon'  => __( 'Parent Dial-A-Ride Pages:'),
		'not_found'          => __( 'No Dial-A-Ride Pages found.'),
		'not_found_in_trash' => __( 'No Dial-A-Ride Pages found in Trash.')
	);

	$args = array(
		'menu_icon' => '',
		'labels'             => $dar_labels,
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => false,
		'show_in_menu'       => true,
		'query_var'          => true,
		'rewrite'            => array( 'slug' => 'dial-a-ride' ),
		'capability_type'    => 'post',
		'has_archive'        => true,
		'hierarchical'       => true,
		'menu_position'      => null,
		'supports'           => array( 'title', 'revisions' )
	);

	register_post_type( 'dar', $args );
	
	$labels = array(
		'name'               => _x( 'Contact Profiles', 'post type general name' ),
		'singular_name'      => _x( 'Staff Contact Profile', 'post type singular name' ),
		'menu_name'          => _x( 'Staff Contacts', 'admin menu'),
		'name_admin_bar'     => _x( 'Contact Profile', 'add new on admin bar'),
		'add_new'            => _x( 'Add New Profile', 'contact-profile'),
		'add_new_item'       => __( 'Add New profile'),
		'new_item'           => __( 'New profile'),
		'edit_item'          => __( 'Edit profile'),
		'view_item'          => __( 'View profile '),
		'all_items'          => __( 'All profiles'),
		'search_items'       => __( 'Search profiles'),
		'parent_item_colon'  => __( 'Parent profile:'),
		'not_found'          => __( 'No contact-profiles found.'),
		'not_found_in_trash' => __( 'No contact-profiles found in Trash.')
	);

	$args = array(
		'menu_icon' => 'dashicons-groups',
		'labels'             => $labels,
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'rewrite'            => array( 'slug' => 'contact-profile' ),
		'capability_type'    => 'post',
		'has_archive'        => false,
		'hierarchical'       => true,
		'menu_position'      => null,
		'supports'           => array( 'title', 'editor', 'revisions','thumbnail' )
	);

	register_post_type( 'contact-profile', $args );
	
	$labels = array(
		'name'               => _x( 'Board Meetings', 'post type general name' ),
		'singular_name'      => _x( 'board-meeting', 'post type singular name' ),
		'menu_name'          => _x( 'Board Meetings', 'admin menu'),
		'name_admin_bar'     => _x( 'Board Meeting', 'add new on admin bar'),
		'add_new'            => _x( 'Add New meeting', 'board-meeting'),
		'add_new_item'       => __( 'Add New meeting'),
		'new_item'           => __( 'New meeting'),
		'edit_item'          => __( 'Edit meeting'),
		'view_item'          => __( 'View meeting '),
		'all_items'          => __( 'All meetings'),
		'search_items'       => __( 'Search meetings'),
		'parent_item_colon'  => __( 'Parent meeting:'),
		'not_found'          => __( 'No meetings found.'),
		'not_found_in_trash' => __( 'No meetings found in Trash.')
	);

	$args = array(
		'menu_icon' => 'dashicons-clipboard',
		'labels'             => $labels,
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'rewrite'            => array( 'slug' => 'board-meeting' ),
		'capability_type'    => 'post',
		'has_archive'        => false,
		'hierarchical'       => true,
		'menu_position'      => null,
		'supports'           => array( 'title', 'revisions', 'thumbnail' )
	);

	register_post_type( 'board-meeting', $args );

	add_image_size( 'transit-page-600', 600, 400, true );
}

function revcon_change_post_label() {
    global $menu;
    global $submenu;
    $menu[5][0] = 'News';
    $submenu['edit.php'][5][0] = 'News';
    $submenu['edit.php'][10][0] = 'Add News';
    $submenu['edit.php'][16][0] = 'News Tags';
}
function revcon_change_post_object() {
    global $wp_post_types;
    $labels = &$wp_post_types['post']->labels;
    $labels->name = 'News';
    $labels->singular_name = 'News';
    $labels->add_new = 'Add News';
    $labels->add_new_item = 'Add News';
    $labels->edit_item = 'Edit News';
    $labels->new_item = 'News';
    $labels->view_item = 'View News';
    $labels->search_items = 'Search News';
    $labels->not_found = 'No News found';
    $labels->not_found_in_trash = 'No News found in Trash';
    $labels->all_items = 'All News';
    $labels->menu_name = 'News';
    $labels->name_admin_bar = 'News';
}
 
add_action( 'admin_menu', 'revcon_change_post_label' );
add_action( 'init', 'revcon_change_post_object' );

function slugify($text)
{
    // Swap out Non "Letters" with a -
    $text = preg_replace('/[^\\pL\d]+/u', '-', $text); 

    // Trim out extra -'s
    $text = trim($text, '-');

    // Convert letters that we have left to the closest ASCII representation
    $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

    // Make text lowercase
    $text = strtolower($text);

    // Strip out anything we haven't been able to convert
    $text = preg_replace('/[^-\w]+/', '', $text);

    return $text;
}


function remove_menus(){
  remove_menu_page( 'edit-comments.php' );          //Comments
}
add_action( 'admin_menu', 'remove_menus' );

function the_agency_name() {
 echo "Mountain Transit";
}

function get_metrolink_link() {
		echo "http://www.metrolinktrains.com/stations/detail/station_id/122.html";
}
function get_omnitrans_link() {
	echo "http://www.omnitrans.org/schedules/cities/";
}
function get_amtrak_link() {
	echo "http://www.amtrakcalifornia.com";
}

function get_map_name( $route_id ) {
	if ($short = get_post_meta($route_id, 'route_short_name', true) ) {
		$s_2_name = array(
			'1'	=> 'Route 1 Boulder',
			'11' => 'Route 11',
			'3' => 'Route 3',
			'2' => 'Route 2',
			'4' => 'Route 4',
			'Big Bear OTM' => 'BB OTM',
			'RIM OTM' => 'RIM Off'
		);
		return $s_2_name[$short];
	} else {
		return get_post_meta($route_id, 'route_long_name', true);
	}
}

function get_route_map( $route_id ) {
	$base_url = 'https://marta.doublemap.com/map/embed?key=s3283xKQfwfunfcNPM2KJPNBwo0X17Zt&inactive=true&name=';
	$route = rawurlencode( get_map_name($route_id) );
	$url = $base_url . $route;
	printf('<iframe src="%s"></iframe>', $url);	
}

function marta_organized_routes() {
	if ( !post_type_exists( 'route' ) ) {
		return;
	}
	echo '<ul class="grouped-route-list">';
	// Echo an organized menu
	$args = array(
		'post_type' 	=> 'route',
		'numberposts'	=> -1,
		'meta_key'		=> 'route_sort_order',
		'orderby'		=> array('meta_value_num' => 'ASC'),
	);
	$all_routes = get_posts( $args );
	$sorted_routes = array();
	foreach( $all_routes as $route ) {
		$group = get_field( 'route_group', $route->ID );
		if ( ! array_key_exists( $group, $sorted_routes ) ) {
			$sorted_routes[$group] = array();
		} 
		$sorted_routes[$group][] = $route;
	}
	foreach ( $sorted_routes as $group => $routes ) {
		printf('<li class="route_group"><div class="submenu-title">%s</div><ul>', $group );
		foreach ( $routes as $route ) {
			printf('<li class="route-%s"><a href="%s">%s %s</a></li>',
				get_post_meta( $route->ID, 'route_id', true),
				get_the_permalink($route->ID),
				get_route_circle($route->ID, "small"),
				get_post_meta($route->ID, 'route_long_name', true)
		    );
		}
		echo '</ul></li>';
	}
	echo '<li class="route_group dar"><div class="submenu-title">Dial-a-Ride</div><ul><li class="route"><a href="big-bear-dial-a-ride/">Big Bear Valley</a></li><li class="route"><a href="rim-area-dial-a-ride/">RIM Area</a></li></ul></li>';
	echo '</ul>';
}

function marta_custom_route_title() {
	global $post;
	$short_name = get_post_meta( $post->ID, 'route_short_name', true);
	$long_name = get_post_meta( $post->ID, 'route_long_name', true);
	$color = '#' . get_post_meta( $post->ID, 'route_color', true);
	$text = '#' . get_post_meta( $post->ID, 'route_text_color', true);
	$region = get_field('route_group', $post->ID);
	$days = get_field('days_of_week', $post->ID);
	echo '<header class="page-header">';
	printf('<h1 style="background-color:%s; color:%s;" class="route-title">%s</h1>', $color, $text, marta_route_menu_name($post->ID) );
	
	if ( !empty( $short_name) ) {
		printf('<p class="subtitle">%s</p>', $long_name);
	}
	printf('<p class="route-meta">%s</p>', $days);
	echo '</header>';
}

function marta_route_menu_name( $id ) {
	$short_name = get_post_meta( $id, 'route_short_name', true);
	$long_name = get_post_meta( $id, 'route_long_name', true);
	$custom_name = get_post_meta( $id, 'route_custom_name', true);
	$region = get_field('route_group', $id);
	if ( !empty( $custom_name ) ) {
		return $custom_name;
	} elseif ( empty( $short_name) ) {
		return $long_name;
	} else {
		return $region . ' Route ' . $short_name;
	}
}

function marta_overwrite_affected( $the_affected ) {
	return array_map( 'marta_name_link', $the_affected );
}
add_filter('tcp_display_affected', 'marta_overwrite_affected');

function marta_name_link( $route_tag = null, $post_id = null ) {
	if ( empty($route_tag) && empty($post_id) ) {
		return '';
	}
	if ( empty($post_id) ) {
		$r_post = get_page_by_path( $route_tag, OBJECT, 'route' );
		if ( empty( $r_post) ) {
			return $route_tag;
		}
		$post_id = $r_post->ID;
	}
	return sprintf('<a href="%s" style="background-color: #%s;color: #%s;" class="rte-btn-link" data-name="%s">%s</a>', get_the_permalink($post_id), get_post_meta($post_id, 'route_color', true), get_post_meta($post_id, 'route_text_color', true), marta_get_imap_name(get_post_meta($post_id, 'route_short_name', true)), marta_route_menu_name($post_id));
}

function marta_get_imap_name( $shortname ) {
	if ( !empty( $shortname ) ) {
		$s_2_name = array(
			'1'	=> 'route_1',
			'11' => 'route_11',
			'3' => 'route_3',
			'2' => 'route_2',
			'4' => 'route_4',
			'Big Bear OTM' => 'big_bear_otm',
			'RIM OTM' => 'rim_otm'
		);
		return $s_2_name[$shortname];
	}
	return '';
}

function marta_route_select() {
	echo '<div id="route-select-dropdown">';
	echo '<button type="button" class="dropdown-toggle" aria-haspopup="true" aria-expanded="false">';
	echo 'View a different route <span class="triangle-down"></span></button>';
	echo '<ul class="dropdown-menu">';
	$args = array(
		'numberposts'	=> -1,
		'post_type'		=> 'route',
		'meta_key'		=> 'route_sort_order',
		'orderby'		=> array('meta_value_num' => 'ASC'),
	);
	$routes = get_posts( $args );
	foreach ( $routes as $route ) {
		printf('<li>%s</li>', marta_name_link(null, $route->ID) );
	}
	echo '</ul></div>';
}
