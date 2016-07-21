<?php
/*
Author: Eddie Machado
URL: htp://themble.com/bones/

This is where you can drop your custom functions or
just edit things like thumbnail sizes, header images,
sidebars, comments, ect.
*/

// LOAD BONES CORE (if you remove this, the theme will break)
require_once( 'library/bones.php' );

// USE THIS TEMPLATE TO CREATE CUSTOM POST TYPES EASILY
require_once( 'library/custom-post-type.php' );

// CUSTOMIZE THE WORDPRESS ADMIN (off by default)
// require_once( 'library/admin.php' );

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

  // enqueue base scripts and styles
  add_action( 'wp_enqueue_scripts', 'bones_scripts_and_styles', 999 );
  // ie conditional wrapper

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

	/*
	to add more sidebars or widgetized areas, just copy
	and edit the above sidebar code. In order to call
	your new sidebar just use the following code:

	Just change the name to whatever your new
	sidebar's id is, for example:

	register_sidebar(array(
		'id' => 'sidebar2',
		'name' => __( 'Sidebar 2', 'bonestheme' ),
		'description' => __( 'The second (secondary) sidebar.', 'bonestheme' ),
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h4 class="widgettitle">',
		'after_title' => '</h4>',
	));

	To call the sidebar in your template, you can just copy
	the sidebar.php file and rename it to your sidebar's name.
	So using the above example, it would be:
	sidebar-sidebar2.php

	*/
} // don't remove this bracket!


/************* COMMENT LAYOUT *********************/

// Comment Layout
function bones_comments( $comment, $args, $depth ) {
   $GLOBALS['comment'] = $comment; ?>
  <div id="comment-<?php comment_ID(); ?>" <?php comment_class('cf'); ?>>
    <article  class="cf">
      <header class="comment-author vcard">
        <?php
        /*
          this is the new responsive optimized comment image. It used the new HTML5 data-attribute to display comment gravatars on larger screens only. What this means is that on larger posts, mobile sites don't have a ton of requests for comment images. This makes load time incredibly fast! If you'd like to change it back, just replace it with the regular wordpress gravatar call:
          echo get_avatar($comment,$size='32',$default='<path_to_url>' );
        */
        ?>
        <?php // custom gravatar call ?>
        <?php
          // create variable
          $bgauthemail = get_comment_author_email();
        ?>
        <img data-gravatar="http://www.gravatar.com/avatar/<?php echo md5( $bgauthemail ); ?>?s=40" class="load-gravatar avatar avatar-48 photo" height="40" width="40" src="<?php echo get_template_directory_uri(); ?>/library/images/nothing.gif" />
        <?php // end custom gravatar call ?>
        <?php printf(__( '<cite class="fn">%1$s</cite> %2$s', 'bonestheme' ), get_comment_author_link(), edit_comment_link(__( '(Edit)', 'bonestheme' ),'  ','') ) ?>
        <time datetime="<?php echo comment_time('Y-m-j'); ?>"><a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ) ?>"><?php comment_time(__( 'F jS, Y', 'bonestheme' )); ?> </a></time>

      </header>
      <?php if ($comment->comment_approved == '0') : ?>
        <div class="alert alert-info">
          <p><?php _e( 'Your comment is awaiting moderation.', 'bonestheme' ) ?></p>
        </div>
      <?php endif; ?>
      <section class="comment_content cf">
        <?php comment_text() ?>
      </section>
      <?php comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
    </article>
  <?php // </li> is added by WordPress automatically ?>
<?php
} // don't remove this bracket!


/*
This is a modification of a function found in the
twentythirteen theme where we can declare some
external fonts. If you're using Google Fonts, you
can replace these fonts, change it in your scss files
and be up and running in seconds.
*/
function bones_fonts() {
  wp_register_style('googleFonts', 'http://fonts.googleapis.com/css?family=Lato:400,700,400italic,700italic');
  wp_enqueue_style( 'googleFonts');
  wp_register_style('route_icons', get_template_directory_uri().'/library/css/route-icons.css');
  wp_enqueue_style( 'route_icons');
}

add_action('wp_print_styles', 'bones_fonts');





function register_my_menus() {
  register_nav_menus(
    array(
      'secondary-link-right-menu' => __( 'Secondary Links Right Menu' )
    )
  );
  
  
  register_nav_menus(
    array(
      'footer-secondary' => __( 'Footer secondary menu' )
    )
  );
  
  
  register_nav_menus(
    array(
      'sidebar-secondary' => __( 'sidebar secondary menu' )
    )
  );
}

add_action( 'init', 'register_my_menus' );


function the_breadcrumb($id = -1) {
    global $post;
    echo '<ul id="breadcrumbs">';
   /* if (!is_home()) {
        echo '<li><a href="';
        echo get_option('home');
        echo '">';
        echo 'Home';
        echo '</a></li><li class="separator"> > </li>';
        if (is_category() || is_single()) {
            echo '<li>';
            the_category(' </li><li class="separator"> > </li><li> ');
            if (is_single()) {
                echo '</li><li class="separator"> > </li><li>';
                the_title();
                echo '</li>';
            }
        } elseif('route' == get_post_type() ) {
       	
                echo '<li><a href="/routes-and-schedules/">Routes & Schedules</a></li><li class="separator">></li><li><strong> '.get_the_title().'</strong></li>';
            
        
        }
        
        elseif('timetable' == get_post_type() ) {
        
        
        }
        
        elseif('alert' == get_post_type() ) {
        	
        	echo 'alert';
        
        }
        
        elseif('route' == get_post_type() ) {
        
        
        }
        elseif (is_page()) {
            if($post->post_parent){
                $anc = get_post_ancestors( $post->ID );
                $title = get_the_title();
                foreach ( $anc as $ancestor ) {
                    $output = '<li><a href="'.get_permalink($ancestor).'" title="'.get_the_title($ancestor).'">'.get_the_title($ancestor).'</a></li> <li class="separator">/</li>';
                }
                echo $output;
                echo '<strong title="'.$title.'"> '.$title.'</strong>';
            } else {
                echo '<li><strong> '.get_the_title().'</strong></li>';
            }
        } 
    }
    elseif (is_tag()) {single_tag_title();}
    elseif (is_day()) {echo"<li>Archive for "; the_time('F jS, Y'); echo'</li>';}
    elseif (is_month()) {echo"<li>Archive for "; the_time('F, Y'); echo'</li>';}
    elseif (is_year()) {echo"<li>Archive for "; the_time('Y'); echo'</li>';}
    elseif (is_author()) {echo"<li>Author Archive"; echo'</li>';}
    elseif (isset($_GET['paged']) && !empty($_GET['paged'])) {echo "<li>Blog Archives"; echo'</li>';}
    elseif (is_search()) {echo"<li>Search Results"; echo'</li>';}
    
    */
    
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


function route_inclusive_wp_title	($title) {
	
	
	//echo $title;
	
	if( is_single() && get_post_type_object(get_query_var( 'post_type' ))->rewrite[slug] == 'routes-and-schedules') {
	
		$titlePieces = explode('|', $title);
		return $titlePieces[0].' | Route '.get_field('route_number').' :'.$titlePieces[1] ;
	
	} else {
	
	return $title;
	
	}
	
	
	
	
    		
			

}

add_filter( 'wp_title', 'route_inclusive_wp_title' );





add_action( 'init', 'codex_route_init' );
/**
 * Register a route post type.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_post_type
 */
function codex_route_init() {
	$labels = array(
		'name'               => _x( 'Routes &amp; Schedules', 'post type general name' ),
		'singular_name'      => _x( 'route', 'post type singular name' ),
		'menu_name'          => _x( 'Routes', 'admin menu'),
		'name_admin_bar'     => _x( 'Route', 'add new on admin bar'),
		'add_new'            => _x( 'Add New', 'route'),
		'add_new_item'       => __( 'Add New route'),
		'new_item'           => __( 'New route'),
		'edit_item'          => __( 'Edit Route'),
		'view_item'          => __( 'View Route'),
		'all_items'          => __( 'All Routes'),
		'search_items'       => __( 'Search Routes'),
		'parent_item_colon'  => __( 'Parent Routes:'),
		'not_found'          => __( 'No routes found.'),
		'not_found_in_trash' => __( 'No routes found in Trash.')
	);

	$args = array(
		'menu_icon' => '',
		'labels'             => $labels,
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'capability_type'    => 'post',
		'has_archive'        => true,
		'hierarchical'       => false,
		'menu_position'      => null,
		'supports'           => array( 'title', 'revisions' , 'thumbnail')
	);

	register_post_type( 'route', $args );
	
	$dar_labels = array(
		'name'               => _x( 'Dail-A-Ride', 'post type general name' ),
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
		'name'               => _x( 'Timetables', 'post type general name' ),
		'singular_name'      => _x( 'timetable', 'post type singular name' ),
		'menu_name'          => _x( 'Timetables', 'admin menu'),
		'name_admin_bar'     => _x( 'Timetable', 'add new on admin bar'),
		'add_new'            => _x( 'Add New', 'timetable'),
		'add_new_item'       => __( 'Add New Timetable'),
		'new_item'           => __( 'New timetable'),
		'edit_item'          => __( 'Edit timetable'),
		'view_item'          => __( 'View timetable '),
		'all_items'          => __( 'All timetables'),
		'search_items'       => __( 'Search timetables'),
		'parent_item_colon'  => __( 'Parent timetable:'),
		'not_found'          => __( 'No timetables found.'),
		'not_found_in_trash' => __( 'No timetables found in Trash.')
	);

	$args = array(
		'menu_icon' => '',
		'labels'             => $labels,
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'rewrite'            => array( 'slug' => 'timetables' ),
		'capability_type'    => 'post',
		'has_archive'        => false,
		'hierarchical'       => false,
		'menu_position'      => null,
		'supports'           => array( 'title', 'editor', 'revisions','page-attributes' )
		
	);

	register_post_type( 'timetable', $args );
	
	
	$labels = array(
		'name'               => _x( 'Road Conditions and Alerts', 'post type general name' ),
		'singular_name'      => _x( 'alert', 'post type singular name' ),
		'menu_name'          => _x( 'Alerts', 'admin menu'),
		'name_admin_bar'     => _x( 'Alert', 'add new on admin bar'),
		'add_new'            => _x( 'Add New', 'alert'),
		'add_new_item'       => __( 'Add New Alert'),
		'new_item'           => __( 'New Alert'),
		'edit_item'          => __( 'Edit Alert'),
		'view_item'          => __( 'View Alert '),
		'all_items'          => __( 'All Alerts'),
		'search_items'       => __( 'Search Alerts'),
		'parent_item_colon'  => __( 'Parent Alert:'),
		'not_found'          => __( 'No alerts found.'),
		'not_found_in_trash' => __( 'No alerts found in Trash.')
	);

	$args = array(
		'menu_icon' => '',
		'labels'             => $labels,
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => false,
		'show_in_menu'       => true,
		'query_var'          => true,
		'rewrite'            => array( 'slug' => 'road-conditions-and-alerts' ),
		'capability_type'    => 'post',
		'has_archive'        => true,
		'hierarchical'       => true,
		'menu_position'      => null,
		'supports'           => array( 'title', 'editor', 'revisions' )
	);

	register_post_type( 'alert', $args );
	
	$labels = array(
		'name'               => _x( 'News', 'post type general name' ),
		'singular_name'      => _x( 'News', 'post type singular name' ),
		'menu_name'          => _x( 'News', 'admin menu'),
		'name_admin_bar'     => _x( 'News', 'add new on admin bar'),
		'add_new'            => _x( 'Add New', 'news'),
		'add_new_item'       => __( 'Add New News'),
		'new_item'           => __( 'New news'),
		'edit_item'          => __( 'Edit news'),
		'view_item'          => __( 'View news '),
		'all_items'          => __( 'All news'),
		'search_items'       => __( 'Search news'),
		'parent_item_colon'  => __( 'Parent news:'),
		'not_found'          => __( 'No news found.'),
		'not_found_in_trash' => __( 'No news found in Trash.')
	);

	$args = array(
		'menu_icon' => '',
		'labels'             => $labels,
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'rewrite'            => array( 'slug' => 'news' ),
		'capability_type'    => 'post',
		'has_archive'        => true,
		'hierarchical'       => true,
		'menu_position'      => null,
		'supports'           => array( 'title', 'editor', 'revisions' )
	);

	register_post_type( 'news', $args );
	
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
		'menu_icon' => '',
		'labels'             => $labels,
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'rewrite'            => array( 'slug' => 'board-meeting' ),
		'capability_type'    => 'post',
		'has_archive'        => true,
		'hierarchical'       => true,
		'menu_position'      => null,
		'supports'           => array( 'title', 'revisions', 'thumbnail' )
	);

	register_post_type( 'board-meeting', $args );
	
	
	
	add_image_size( 'transit-page-600', 600, 400, true );
}

add_action( 'init', 'create_area_tax' );


/* Hook meta box to just the 'timetable' post type. */

 
function add_menu_icons_styles(){
?>
 
<style>
#adminmenu .menu-icon-alert div.wp-menu-image:before {
  content: '\f227';
}
#adminmenu .menu-icon-timetable div.wp-menu-image:before {
 content: "\f311";
}
#adminmenu .menu-icon-dar div.wp-menu-image:before {
content: "\f507";
}
#adminmenu .menu-icon-route div.wp-menu-image:before {
content: "\f237";
}

#adminmenu .menu-icon-news div.wp-menu-image:before {
content: "\f488";
}
#adminmenu .menu-icon-contact-profile div.wp-menu-image:before {
content: "\f484";
}
</style>
 
<?php
}
add_action( 'admin_head', 'add_menu_icons_styles' );



function namespace_add_custom_types( $query ) {
  if( is_post_type_archive('alert'))  {
  
  $taxonomy = 'alert-zone';
$taxonomy_terms = get_terms( $taxonomy, array(
    'hide_empty' => 0,
    'fields' => 'ids'
) );
  
  
    $query->set( 'post_type', array(
     'alert', 'news'
		));
		$query->set( 'tax_query', 
		array(
			array(
				'taxonomy' => 'alert-zone',
				'field' => 'id',
            	'terms' => $taxonomy_terms,
			),
		));
	  return $query;
	} else {
		return $query;
	}
}
add_filter( 'pre_get_posts', 'namespace_add_custom_types' );


function get_alertCount() {

	$taxonomy = 'alert-zone';
	$taxonomy_terms = get_terms( $taxonomy, array(
		'hide_empty' => 0,
		'fields' => 'ids'
	) );

	$args = array(
				'numberposts' => -1,
				'post_type' => array('alert','news'),
				'tax_query' =>
							array(
								array(
									'taxonomy' => 'alert-zone',
									'field' => 'id',
									'terms' => $taxonomy_terms,
								),
							)
				
			);
 
	// get results
	$the_query = new WP_Query( $args );



	$size = sizeof($the_query->posts);

	wp_reset_query();
	return $size;

}


function alert_zone_delete_terms() {
     if ( is_admin() ) {
          $terms = get_terms( 'alert-zone', array( 'fields' => 'ids', 'hide_empty' => false ) );
          foreach ( $terms as $value ) {
               wp_delete_term( $value, 'alert-zone' );
          }
     }
}
//add_action( 'init', 'alert_zone_delete_terms' );



function create_area_tax() {
	register_taxonomy(
		'service_area',
		array( 'route','dar' ),
		array(
			'label' => __( 'Service Area' ),
			'rewrite' => array( 'slug' => 'service_area'),
			'hierarchical' => false,
		)
	);
	
$service_areas = array('Rim','Big Bear','Weekend Trolley');
$service_areas_safe = array('rim','big-bear','weekend-trolley');
$ind = 0;
foreach($service_areas as &$service_area) {
	wp_insert_term(
	 $service_area, // the term 
	  'service_area', // the taxonomy
	  array(
	  	'description'=> '',
		'slug' => $service_areas_safe[ind]
	  )
	);
	$ind  += 1;
}

	
	register_taxonomy(
		'alert-zone',
		array( 'alert', 'news' ),
		array(
			'label' => __( 'Alert Zone' ),
			'description' => 'Use this to properly associate the alert with the route.',
			'rewrite' => array( 'slug' => 'alert-zone' ),
			'hierarchical' => false,
		)
	);
	
	
	$route_names = array(
				"Big Bear Route 1A",
"RIM Route 2",
"RIM Route 4",
"RIM Off the Mountain",
"Big Bear Off the Mountain",
"Big Bear Route 1",
"Big Bear Weekend Trolley");
	foreach($route_names as &$route_name) {
		$clean_name = str_replace(' ','_', $route_name);
		wp_insert_term(
		 $route_name, // the term 
		  'alert-zone', // the taxonomy
		  array(
			'description'=> '',
			'slug' => $clean_name
		  )
		);
	}
	wp_insert_term(
		 'All Routes', // the term 
		  'alert-zone', // the taxonomy
		  array(
			'description'=> '',
			'slug' => 'all-routes'
		  )
		);
		wp_insert_term(
		 'All Routes and Dail-A-Ride', // the term 
		  'alert-zone', // the taxonomy
		  array(
			'description'=> '',
			'slug' => 'all'
		  )
		);
		wp_insert_term(
		 'Dial-A-Ride Only', // the term 
		  'alert-zone', // the taxonomy
		  array(
			'description'=> '',
			'slug' => 'all-dial'
		  )
		);

}




add_filter( 'manage_edit-route_columns', 'my_edit_route_columns' ) ;

function my_edit_route_columns( $columns ) {

	$columns = array(
		'cb' => '<input type="checkbox" />',
		'route_id' => __( 'Route ID' ),
		'title' => __( 'Route Name' ),
		'schedules' => __( 'Route timetables' ),
		
	);

	return $columns;
}

add_action( 'manage_route_posts_custom_column', 'my_manage_route_columns', 10, 2 );

function my_manage_route_columns( $column, $post_id ) {
	global $post;

	switch( $column ) {

		/* If displaying the 'duration' column. */
		case 'route_id' :

			/* Get the post meta. */
			$route_id = get_field( 'route_short_name', $post_id );
			
			
			/* If no duration is found, output a default message. */
			if ( empty( $route_id ) )
				echo __( 'Unknown' );

			/* If there is a duration, append 'minutes' to the text string. */
			else
				echo  __('<i class="route-icon" style="float: left; margin-right: 10px;  border-radius: 3px;  color: white; padding: 10px;background-color: #'.get_field("route_color").';" >'.(string)$route_id.'</i> ')  ;
				

			break;
			
		case 'schedules' :
		
			// find schedules
			get_field( 'shared_class', $post_id );
			$args = array(
				'numberposts' => -1,
				'post_type' => 'timetable',
				'meta_key' => 'shared_class',
				'meta_value' => get_field( 'shared_class', $post_id )
			);
 
			// get results
			$the_query = new WP_Query( $args );
 
			// The Loop
			?>
			<?php if( $the_query->have_posts() ): ?>
				<ul>
				<?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
					<li>
						- <a href="<?php echo get_edit_post_link($post->ID); ?>"><?php the_title(); ?></a>
					</li>
				<?php endwhile; ?>
				</ul>
			<?php endif; 
			
			wp_reset_query();
		
			break;

		
		/* Just break out of the switch statement for everything else. */
		default :
			break;
	}
}

add_filter( 'manage_edit-route_sortable_columns', 'my_route_sortable_columns' );

function my_route_sortable_columns( $columns ) {

	$columns['route_number'] = 'route_number';

	return $columns;
}


add_action( 'load-edit.php', 'my_edit_route_load' );

function my_edit_route_load() {
	add_filter( 'request', 'my_sort_route' );
}

/* Sorts the movies. */
function my_sort_route( $vars ) {

	/* Check if we're viewing the 'movie' post type. */
	if ( isset( $vars['post_type'] ) && 'route' == $vars['post_type'] ) {

		/* Check if 'orderby' is set to 'duration'. */
		if ( isset( $vars['orderby'] ) && 'route_number' == $vars['orderby'] ) {

			/* Merge the query vars with our custom variables. */
			$vars = array_merge(
				$vars,
				array(
					'meta_key' => 'route_number',
					'orderby' => 'meta_value'
				)
			);
		}
	}

	return $vars;
}



function my_admin_enqueue_css() {
	echo '<link rel="stylesheet" id="route_icons-css"  href="http://kerntransit.trilliumtransit.com/wp-content/themes/kern/library/css/route-icons.css" type="text/css" media="all" />';
}

add_action( 'admin_enqueue_scripts', 'my_admin_enqueue_css' );


function register_footer_menu() {
	register_nav_menu('footer-menu', __('Footer Menu'));
}
add_action('init', 'register_footer_menu');



function tsv_site_update() {

	echo "<h1>Update site with a TSV (Tab separated values)</h1>If you want to update the site, you need to add &update=true to the end of the url.  <br /> This is found in wp-content/transit-data/route_data.tsv<br/><strong>DO NOT DO THIS IF YOU ARE UNSURE YOU?RE DOING THE RIGHT THING!!</strong>";
	
	if($_GET["update"] == "true") {
		echo "<br />updated site. <br />";
		
		// read in the csv
		
		$existing_routes = get_posts(array(
			'numberposts' => -1,
			'post_type' => 'route',
		));
		$existing_dars = get_posts(array(
			'numberposts' => -1,
			'post_type' => 'dar',
		));
		
		$existing_timetables = get_posts(array(
			'numberposts' => -1,
			'post_type' => 'timetable',
			
		));
		
		
		//echo 'number of routes: '.strval(sizeof($existing_routes)).'<br />';
		
		
	if(false){	
				foreach($existing_routes as &$route) {
					echo "route  <br />";
					print_r($route);
					echo "<br /><br />";
					 //wp_delete_post( $route->ID, true ); 
			
				}
		
				foreach($existing_dars as &$dar) {
					echo "dar !<br />";
		echo "<br /><br />";
			
				}
		
				foreach($existing_timetables as &$timetable) {
					echo "timetable !<br />";
		echo "<br /><br />"; 
			
				}
		}
		
		if(sizeof($existing_routes) >= 7){
		
		
		
		

		//echo 'number of routes to delete: '.
 
		
		foreach($existing_routes as &$route) {
			echo "route delete!<br />";
			 wp_delete_post( $route->ID, true );
	
		}
		
		foreach($existing_timetables as &$timetable) {
			echo "timetable delete!<br />";
			wp_delete_post( $timetable->ID, true );  
		}
		
		
		foreach($existing_dars as &$dar) {
			echo "dar delete!<br />";
			 wp_delete_post( $dar->ID, true ); 		
		}
		
		
		
		
		$handle = fopen(get_site_url()."/wp-content/transit-data/route_data.tsv", "r");
		if ($handle) {
		$lineCount = 0; 
   		 while (($line = fgets($handle)) !== false) {
        	
        	$existing_routes = get_posts(array(
			'numberposts' => -1,
			'post_type' => 'route',
		));
		
		$existing_dars = get_posts(array(
			'numberposts' => -1,
			'post_type' => 'dar',
		));
        	
        	if($lineCount > 0) {  // ignore the header of the route data table
        	
				//echo $line;
				echo "<br/>";
				
				
				/*
				0 Trillium agency_id
				1 Trillium route_id
				2 route_short_name
				3 route_long_name
				4 route_color
				5 route_text_color
				6 timetable_file_name
				7 service_description
				8 pdf_service_area
				9 route_url
				10 display_order
				*/
		
		
			
				$splitLine = explode("\t", $line);
				$tril_agency_id = $splitLine[0];
				$tril_route_id = $splitLine[1];
				$route_short_name = str_replace(' ', '_',$splitLine[2]);
				$route_medium_name = $splitLine[3];
				$route_long_name = $splitLine[4];
				$route_color  = $splitLine[5];
				$route_text_color  = $splitLine[6]; 
				$timetable_file_names = $splitLine[7]; 
				$service_description  = $splitLine[8];
				$pdf_service_area = $splitLine[9];
				$route_url = $splitLine[10];
				$display_order = $splitLine[11];
				$days_of_service = $splitLine[12];
				
			
				echo "name: ".$route_short_name;
				
				
				$post_to_update_id = -1;
			
				// if has route number
				// 	check if route already exists
				
				
				
				
				$is_route = ($route_number != 'd');
				
				
				
				
				
				
				// if doesn't exist
				// create new route post
				
				//else update the values of the existing
				
				
				
					
				// create new post
				$my_post = array(
			  'post_title'    => $route_long_name,
			  'post_name' => $route_medium_name,
			  'post_status'   => 'publish',
			  'post_type'      => 'route',
			  'post_author'   => 1
			  );

				// Insert the post into the database
				$post_to_update_id = wp_insert_post( $my_post );
				
				// create schedule pages here
				$explodedTimetableNames = explode(',',$timetable_file_names);
				$schedule_ids = array();
				foreach($explodedTimetableNames as &$timetable) {
				
					//$handle = fopen(get_site_url()."/wp-content/transit-data/".$timetable, "r");
					$timetableHTML = file_get_contents(get_site_url()."/wp-content/transit-data/timetables/".$timetable);
					echo 'html:'.$timetableHTML.'<br />';
					$my_post = array(
						  'post_title'    =>   explode('.', $timetable)[0],
						  'post_name' =>     explode('.', $timetable)[0],
						  'post_status'   => 'publish',
						  'post_type'      => 'timetable',
						  'post_author'   => 1,
						  'post_content' => $timetableHTML 
					);

					// Insert the post into the database
				
					$schedule_id =  wp_insert_post( $my_post );
					$schedule_ids[] = $schedule_id;
					
					update_field('field_542b02a195a25', $route_short_name, $schedule_id );
					
					
			
				}
						
					update_field('field_54298f3cb8b71', $route_short_name, $post_to_update_id );
					update_field('field_54298f4db8b72', $route_long_name, $post_to_update_id );
					update_field('field_542ae4573f310', $route_medium_name, $post_to_update_id );
					update_field('field_54298f54b8b73', $route_color, $post_to_update_id );
					update_field('field_54298f5eb8b74', $route_text_color, $post_to_update_id );
					update_field('field_54298f78b8b75', $timetable_file_names, $post_to_update_id ); 	
					update_field('field_54298f9eb8b76', $service_description, $post_to_update_id );
					update_field('field_54298facb8b77', $pdf_service_area, $post_to_update_id );
					update_field('field_54298fbcb8b79', $display_order, $post_to_update_id );
					update_field('field_543b1f7c499dd', $days_of_service, $post_to_update_id ); 
					
					
					$schedule_id_string = "";
					$i = 0;
					foreach($schedule_ids as &$schedule_id) {
						$schedule_id_string .= $schedule_id."";
						if($i<(sizeof($schedule_ids) - 1) ) {
							$schedule_id_string .= ",";
						}
						$i++;
					}
					
					update_field('field_5429912c7da7e', $timetable_ids, $post_to_update_id );

				
				
					 $my_post = array(
					  'ID'           => $post_to_update_id,
					  'post_title' => $route_long_name
					  );

					// Update the post into the database
					  wp_update_post( $my_post );
				  
					
				
				
				// data for both dial-a-ride and routes
				
			
				wp_set_post_terms($post_to_update_id, $pdf_service_area, 'service_area' );
				
			
			
        	}
        	$lineCount ++;
        	
        	
  		  }
		} else {
  		  // error opening the file.
		} 
		fclose($handle);
		
		
		
		// check if routes exist
			// go through add lines, ch
		
		// create any routes if doesn not exist
		
		// update existing routes
		
		// check if DAR pages exist
		
		// update DAR pages with data
		
		//update_field($field_key, $value, $post_id)
		
		echo "<br>Update complete!";
		}
	} 
	
}

add_action( 'admin_menu', 'add_data_import_menu' );
function add_data_import_menu() {
	add_management_page( 'TSV Site Update', 'TSV Site Update', 'manage_options', 'tsv-site-update', 'tsv_site_update' );
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
  
 
  //remove_menu_page( 'edit.php' );                   //Posts


  remove_menu_page( 'edit-comments.php' );          //Comments
  //remove_menu_page( 'themes.php' );                 //Appearance  
  remove_menu_page( 'edit.php?post_type=custom_type' );

}
add_action( 'admin_menu', 'remove_menus' );



add_action( 'rewrite_rules_array', 'add_route_url_rules' ); 
add_action( 'wp_loaded','my_flush_rules' ); 

function add_route_url_rules($rules) {   
  global $wp_rewrite;  
  $new_rules = array();
  $new_rules["rim-routes-and-schedules/([^/]+)/?$"] = "index.php?route=".$wp_rewrite->preg_index(1);
  $new_rules["rim-routes-and-schedules/?$"] = "index.php?post_type=route&service_area=rim&meta_key=display_order&orderby=meta_value&order=asc";
  $new_rules["big-bear-routes-and-schedules/([^/]+)/?$"] = "index.php?route=".$wp_rewrite->preg_index(1);
  $new_rules["big-bear-routes-and-schedules/?$"] = "index.php?post_type=route&service_area=big-bear&meta_key=display_order&orderby=meta_value&order=asc";
 return  $new_rules + $rules; 
}  

// flush_rules() if our rules are not yet included
function my_flush_rules(){
	$rules = get_option( 'rewrite_rules' );
	
	if ( ! isset( $rules['rim-routes-and-schedules/?$'] ) ) {
		global $wp_rewrite;
	   	$wp_rewrite->flush_rules();
	}
	if ( ! isset( $rules["rim-routes-and-schedules/([^/]+)/?$"] ) ) {
		global $wp_rewrite;
	   	$wp_rewrite->flush_rules();
	}
	if ( ! isset( $rules["rim-routes-and-schedules/page/([0-9]{1,})/?$"] ) ) {
		global $wp_rewrite;
	   	$wp_rewrite->flush_rules();
	}
	global $wp_rewrite;
	//$wp_rewrite->flush_rules(); 
}

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







/* DON'T DELETE THIS CLOSING TAG */ ?>
