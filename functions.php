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

  // adding sidebars to Wordpress (these are created in functions.php)
  add_action( 'widgets_init', 'bones_register_sidebars' );

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

/*
The function above adds the ability to use the dropdown menu to select
the new images sizes you have just created from within the media manager
when you add media to your content blocks. If you add more image sizes,
duplicate one of the lines in the array and name it according to your
new image size.
*/

/************* ACTIVE SIDEBARS ********************/

// Sidebars & Widgetizes Areas
function bones_register_sidebars() {
	register_sidebar(array(
		'id' => 'sidebar1',
		'name' => __( 'Sidebar 1', 'bonestheme' ),
		'description' => __( 'The first (primary) sidebar.', 'bonestheme' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h4 class="widgettitle">',
		'after_title' => '</h4>',
	));
}

/* Enqueue Styles and Scripts */
function marta_scripts() {
	wp_enqueue_style( 'googleFonts', 'https://fonts.googleapis.com/css?family=Lato:400,700,400italic,700italic' );
	
	wp_enqueue_style( 'marta-style', get_stylesheet_uri() );
	
	wp_enqueue_script( 'mountain-script', get_template_directory_uri() . '/library/js/mountain.js', array('jquery'), false, true );

}
add_action( 'wp_enqueue_scripts', 'marta_scripts' );


function register_my_menus() {
  register_nav_menus(
    array(
      'secondary-link-right-menu' 	=> __( 'Secondary Links Right Menu' ),
	  'footer-menu' 				=> __('Footer Menu'),
	  'footer-secondary' 			=> __( 'Footer secondary menu' ),
	  'sidebar-secondary' 			=> __( 'sidebar secondary menu' )
    )
  );
}

add_action( 'init', 'register_my_menus' );


function the_breadcrumb($id = -1) {
    global $post;
    echo '<ul id="breadcrumbs">';
   
    if (!is_home()) {
        echo '<li><a href="';
        echo get_option('home');
        echo '">';
        echo 'Home';
        echo '</a></li><li class="separator"> > </li>';
    	
    	if(is_archive()) {
    		$post_type = get_post_type();
    		
			if ( $post_type )
			{
			
				$taxonomy = 'alert-zone';
				$taxonomy_terms = get_terms( $taxonomy, array(
					'hide_empty' => 0,
					'fields' => 'ids'
				) );
		
				if(has_term($taxonomy_terms, 'alert-zone')) {
					
					echo 'Alerts';
					
				}	else {
				
					$post_type_data = get_post_type_object( $post_type );
					$post_type_slug = $post_type_data->rewrite['slug'];
					echo ucwords(str_replace('-',' ',get_query_var('service_area'))).' '.$post_type_data->label;

				
				}
			}
    	}
    	
    	elseif (is_single()) {
    	
    		$post_type = get_post_type();
    		
			if ( $post_type == 'route')
			{
				// need to split this up for rim and big bear
				
				if(get_field('pdf_service_area') != "trolley") {
				$post_type_data = get_post_type_object( $post_type );
				$post_type_slug = $post_type_data->rewrite['slug'];
				echo '<li><a href="'.get_site_url().'/'.get_field('pdf_service_area').'-routes-and-schedules/">';
				 echo ucwords(str_replace('-',' ',get_field('pdf_service_area'))).' '.$post_type_data->label;
				echo '</a></li>';
				} else {
					$post_type_data = get_post_type_object( $post_type );
					$post_type_slug = $post_type_data->rewrite['slug'];
					echo '<li><a href="'.get_site_url().'/big-bear-routes-and-schedules/">';
					 echo ucwords(str_replace('-',' ','big-bear')).' '.$post_type_data->label;
					echo '</a></li>';
				}
				
			} else {
			$post_type_data = get_post_type_object( $post_type );
				$post_type_slug = $post_type_data->rewrite['slug'];
				echo '<li><a href="'.get_post_type_archive_link( $post_type ).'">';
				 echo $post_type_data->label;
				echo '</a></li>';
			}
            
            if (is_single()) {
            
                echo '</li><li class="separator"> > </li><li>';
                if( $post_type_data = get_post_type_object( $post_type )->rewrite['slug'] == 'routes-and-schedules') {
                
                	echo 'Route '.get_field('route_number').'&nbsp; : &nbsp;';
                }
				
                the_field('route_medium_name');
                echo '</li>';
            }
        }
        
        elseif (is_page()) {
        	 echo '</li><li>';
                the_title();
                echo '</li>';
        
        }
    
    echo '</ul>';
    
    }
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
		'menu_icon' => '',
		'labels'             => $labels,
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'rewrite'            => array( 'slug' => 'contact-profile' ),
		'capability_type'    => 'post',
		'has_archive'        => true,
		'hierarchical'       => true,
		'menu_position'      => null,
		'supports'           => array( 'title', 'editor', 'revisions','thumbnail' )
	);

	register_post_type( 'contact-profile', $args );

	add_image_size( 'transit-page-600', 600, 400, true );
}

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

function get_route_map( $long_name ) {
	$base_url = 'https://marta.doublemap.com/map/embed?key=s3283xKQfwfunfcNPM2KJPNBwo0X17Zt&inactive=true&name=';
	$route = rawurlencode( $long_name );
	$url = $base_url . $route;
	printf('<iframe src="%s"></iframe>', $url);	
}
