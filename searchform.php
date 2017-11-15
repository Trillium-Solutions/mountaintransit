<?php
/*
 * Template for the header search form
 */
?>

<form role="search" method="get" id="searchform"
    class="searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>">
    <div>
        <label class="screen-reader-text" for="s">Search for</label>
        <input type="text" value="<?php echo get_search_query(); ?>" name="s" id="s" placeholder="Search"/>
		<input type="image" id="header-search-icon-submit" class="icon" src="<?php echo get_template_directory_uri() . "/library/images/clear.png"; ?>" alt="Submit Form" />
    </div>
</form>