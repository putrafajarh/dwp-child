<?php
/*  ----------------------------------------------------------------------------
    Newspaper V6.3+ Child theme - Please do not use this child theme with older versions of Newspaper Theme

    What can be overwritten via the child theme:
     - everything from /parts folder
     - all the loops (loop.php loop-single-1.php) etc
	 - please read the child theme documentation: http://forum.tagdiv.com/the-child-theme-support-tutorial/


     - the rest of the theme has to be modified via the theme api:
       http://forum.tagdiv.com/the-theme-api/

 */




/*  ----------------------------------------------------------------------------
    add the parent style + style.css from this folder
 */
add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles', 1001);
function theme_enqueue_styles() {
    wp_enqueue_style('td-theme', get_template_directory_uri() . '/style.css', '', TD_THEME_VERSION, 'all' );
    wp_enqueue_style('td-theme-child', get_stylesheet_directory_uri() . '/style.css', array('td-theme'), TD_THEME_VERSION . 'c', 'all' );

}


/*disable self pingback*/
function no_self_ping( &$links ) {
    $home = get_option( 'home' );
    foreach ( $links as $l => $link )
        if ( 0 === strpos( $link, $home ) )
            unset($links[$l]);
}
 
add_action( 'pre_ping', 'no_self_ping' );

// Remove Structured Data Yoast
function bybe_remove_yoast_json($data){
    $data = array();
    return $data;
  }
add_filter('wpseo_json_ld_output', 'bybe_remove_yoast_json', 10, 1);

function putra_meta_robots_noindex_follow() {
	if ( is_paged() ) {
		echo '<meta name="robots" content="noindex, follow" />';
	}
}
add_action( 'wp_head', 'putra_meta_robots_noindex_follow' );

add_filter( 'locale', function() {
    return 'id_ID';
});

function putra_yoast_canonical_pagination( $canonical ) {
	if ( is_paged() ) {

		return preg_replace("/page\/([0-9]+)\//", "", $canonical);
	}
	return $canonical;
}
add_filter( 'wpseo_canonical', 'putra_yoast_canonical_pagination' );

function add_author_meta() {
	echo "<meta name=\"publisher\" content=\"PT. Dewaweb\">";
    if ( is_single() ) {
        global $post;
        $author = get_the_author_meta('display_name', $post->post_author);
        echo '<meta name="author" content="'.$author.'" />';
    }
    if ( is_page() ) {
    	echo "<meta name=\"author\" content=\"Dewaweb Tech Team\" />";
    }
    if ( is_home() ) {
    	echo "<meta name=\"author\" content=\"Dewaweb Tech Team\" />";
    }
}
add_action( 'wp_enqueue_scripts', 'add_author_meta' );