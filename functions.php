<?php
/**
 * The functions and definitions
 *
 * @link https://codex.wordpress.org/Theme_Development
 * @link https://codex.wordpress.org/Functions_File_Explained
 *
 * @since MinimaX4 1.0.0
 */

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 *
 * @link https://codex.wordpress.org/Plugin_API/Action_Reference/after_setup_theme
 *
 * @since MinimaX4 1.0.0
 */
if ( ! function_exists( 'MinimaX4_setup' ) ) {
	function MinimaX4_setup() {

		/**
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 *
		 * @link https://developer.wordpress.org/reference/functions/add_theme_support/
		 * @link https://codex.wordpress.org/Title_Tag
		 *
		 * @since MinimaX4 1.0.0
		 */
		add_theme_support( 'title-tag' );

		/**
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
		 *
		 * @since MinimaX4 1.0.0
		 */
		add_theme_support( 'post-thumbnails' );

		/**
		 * This theme uses wp_nav_menu() in 1 location.
		 *
		 * @link https://developer.wordpress.org/reference/functions/wp_nav_menu/
		 *
		 * @since MinimaX4 1.0.0
		 */
		register_nav_menus( array(
			'primary' => esc_html__( 'Primary Menu', 'MinimaX4' )
		) );

		/**
	 	 * Declare WooCommerce Support.
	 	 *
	 	 * @link http://docs.woothemes.com/document/third-party-custom-theme-compatibility/
	 	 *
	 	 * @since MinimaX4 1.0.0
	 	 */
	    add_theme_support( 'woocommerce' );

	    /**
	     * Declare Toolset Layouts Support
	     *
	     * @link https://wp-types.com/documentation/user-guides/layouts-theme-integration/ > Telling Layouts your theme is integrated
	     **/
		add_filter( 'ddl-is_integrated_theme', 'MinimaX4_is_integrated_with_layouts' ); 
	}
}
add_action( 'after_setup_theme', 'MinimaX4_setup' );

/**
 * Register widget area.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_sidebar
 */
function MinimaX4_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'MinimaX4' ),
		'id'            => 'sidebar-1',
		'description'   => '',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h4 class="widget-title">',
		'after_title'   => '</h4>',
	) );
}
add_action( 'widgets_init', 'MinimaX4_widgets_init' );

/**
 * Integrate WooCommerce.
 *
 * @link http://docs.woothemes.com/document/third-party-custom-theme-compatibility/
 *
 * @since MinimaX4 1.0.0
 */
	/* 
	 * First unhook the WooCommerce wrappers
	 */
	remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
	remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);

	/* 
	 * Then hook in our own functions to display the wrappers our theme requires:
	 */
	add_action('woocommerce_before_main_content', '<div class="container">', 10);
	add_action('woocommerce_after_main_content', '</div><!-- #container -->', 10);

	
/**
 * Callback function to integrate Toolset Layouts
 *
 * @link https://wp-types.com/documentation/user-guides/layouts-theme-integration/ > Telling Layouts your theme is integrated
 */
function MinimaX4_is_integrated_with_layouts() {
    return true;
}

/**
 * Enqueue CSS styles and Fonts
 *
 * @link https://developer.wordpress.org/reference/functions/wp_enqueue_style/
 *
 * @since MiniMax 1.0.0
 */
function MinimaX4_styles() {        
	//Enqueue Bootstrap CSS
	wp_enqueue_style( 'UndenkTheme-bootstrap-css', get_template_directory_uri() . '/css/bootstrap.css', '4.0.0-alpha.6', 'all' );

	/**
	 * Enqueue FontAwesome
     *
     */
	wp_enqueue_style( 'font-awesome', get_template_directory_uri() . '/css/FontAwesome/font-awesome.min.css', array(), '4.7.0', 'all' );

	//Enqueue MaterialDesign CSS
	wp_enqueue_style( 'UndenkTheme-MaterialDesign-css', get_template_directory_uri() . '/css/mdb.css', '4.3.2', 'all' );

	//Enqueue the UndenkTheme Main Style Sheet
	wp_enqueue_style( 'style', get_stylesheet_uri() );
}
add_action( 'wp_enqueue_scripts', 'MinimaX4_styles' );

/** 
 * Enqueue JS Scripts
 *
 * @link https://developer.wordpress.org/reference/functions/wp_enqueue_script/
 *
 * @since MinimaX4 1.0.0
 */
function MinimaX4_scripts() {
	//Enqueue Bootstrap JS and add jQuery Dependency
	//Deregister native WordPress jQuery version script
	wp_deregister_script('jquery');

	//Register our own version (2.2.3) for later usage
    wp_register_script('jquery', 'http://ajax.googleapis.com/ajax/libs/jquery/2.2.3/jquery.min.js', false, '2.0.s');

    //Enqueue Tether JS and add jQuery Dependency
    wp_enqueue_script('UndenkTheme-tether-js', get_template_directory_uri() . '/js/tether.min.js', array('jquery'), '1.2.0', false);

	//Enqueue GoldBootstrap JS and add jQuery Dependency
	wp_enqueue_script('UndenkTheme-bootstrap-js', get_template_directory_uri() . '/js/bootstrap.min.js', array('jquery'), '4.0.0-alpha.6', false);

	//Enqueue MaterialDesign JS and add jQuery Dependency
	wp_enqueue_script('UndenkTheme-MaterialDesign-js', get_template_directory_uri() . '/js/mdb.min.js', array('jquery'), '4.3.2', true);
}
add_action( 'wp_enqueue_scripts', 'MinimaX4_scripts' );

/** 
 * Require Function for MinimaX4 Classes path 
 *
 * @link http://php.net/manual/en/function.require-once.php
 *
 * @since MinimaX4 1.0.0
 */
function MinimaX4_require_once($MinimaX4_class) {
    require_once(__DIR__ . '/' .'MinimaX4-classes' . '/' . $MinimaX4_class . '.class.php');
}
