<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://www.fiverr.com/junaidzx90
 * @since      1.0.0
 *
 * @package    Quiz_Post
 * @subpackage Quiz_Post/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Quiz_Post
 * @subpackage Quiz_Post/admin
 * @author     Developer Junayed <admin@easeare.com>
 */
class Quiz_Post_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/quiz-post-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/quiz-post-admin.js', array( 'jquery' ), $this->version, false );

	}

	function quiz_post_type(){
		$labels = array(
			'name'                => _x( 'Quiz Posts', 'Post Type General Name', 'quiz-post' ),
			'singular_name'       => _x( 'Quiz', 'Post Type Singular Name', 'quiz-post' ),
			'menu_name'           => __( 'Quiz Posts', 'quiz-post' ),
			'parent_item_colon'   => __( 'Parent Quiz', 'quiz-post' ),
			'all_items'           => __( 'All Quiz Posts', 'quiz-post' ),
			'view_item'           => __( 'View Quiz', 'quiz-post' ),
			'add_new_item'        => __( 'Add New Quiz', 'quiz-post' ),
			'add_new'             => __( 'Add New', 'quiz-post' ),
			'edit_item'           => __( 'Edit Quiz', 'quiz-post' ),
			'update_item'         => __( 'Update Quiz', 'quiz-post' ),
			'search_items'        => __( 'Search Quiz', 'quiz-post' ),
			'not_found'           => __( 'Not Found', 'quiz-post' ),
			'not_found_in_trash'  => __( 'Not found in Trash', 'quiz-post' ),
		);
		
		$args = array(
			'label'               => __( 'Quiz Posts', 'quiz-post' ),
			'description'         => __( 'Quiz news and reviews', 'quiz-post' ),
			'labels'              => $labels,
			'supports'            => array( 'title', 'editor', 'thumbnail', 'comments' ),
			'taxonomies'          => array( 'qcats' ),
			'hierarchical'        => false,
			'public'              => true,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'show_in_nav_menus'   => false,
			'show_in_admin_bar'   => false,
			'menu_position'       => 5,
			'menu_icon'       	  => 'dashicons-randomize',
			'can_export'          => false,
			'has_archive'         => false,
			'exclude_from_search' => false,
			'publicly_queryable'  => true,
			'capability_type'     => 'post',
			'show_in_rest' => true
		);
		  
		// Registering your Custom Post Type
		register_post_type( 'quiz-posts', $args );

		$catlabels = array(
			'name' => _x( 'Categories', 'taxonomy general name' ),
			'singular_name' => _x( 'Category', 'taxonomy singular name' ),
			'search_items' =>  __( 'Search Categories', 'quiz-post' ),
			'all_items' => __( 'All Categories', 'quiz-post' ),
			'parent_item' => __( 'Parent Category', 'quiz-post' ),
			'parent_item_colon' => __( 'Parent Category:', 'quiz-post' ),
			'edit_item' => __( 'Edit Category', 'quiz-post' ), 
			'update_item' => __( 'Update Category', 'quiz-post' ),
			'add_new_item' => __( 'Add New Category', 'quiz-post' ),
			'new_item_name' => __( 'New Category Name', 'quiz-post' ),
			'menu_name' => __( 'Categories', 'quiz-post' ),
		  );
		// Now register the taxonomy
		register_taxonomy('qcats', array('quiz-posts'), array(
			'hierarchical' => true,
			'labels' => $catlabels,
			'show_ui' => true,
			'show_in_rest' => true,
			'show_admin_column' => true,
			'query_var' => true,
			'rewrite' => array( 'slug' => 'qcats' ),
		));

		$taglabels = array(
			'name' => _x( 'Tags', 'taxonomy general name' ),
			'singular_name' => _x( 'Tag', 'taxonomy singular name' ),
			'search_items' =>  __( 'Search Tags', 'quiz-post' ),
			'all_items' => __( 'All Tags', 'quiz-post' ),
			'parent_item' => __( 'Parent Tag', 'quiz-post' ),
			'parent_item_colon' => __( 'Parent Tag:', 'quiz-post' ),
			'edit_item' => __( 'Edit Tag', 'quiz-post' ), 
			'update_item' => __( 'Update Tag', 'quiz-post' ),
			'add_new_item' => __( 'Add New Tag', 'quiz-post' ),
			'new_item_name' => __( 'New Tag Name', 'quiz-post' ),
			'menu_name' => __( 'Tags', 'quiz-post' ),
		  );
		// Now register the taxonomy
		register_taxonomy('qtags', array('quiz-posts'), array(
			'hierarchical' => false,
			'labels' => $taglabels,
			'show_ui' => true,
			'show_in_rest' => true,
			'show_admin_column' => true,
			'query_var' => true,
			'rewrite' => array( 'slug' => 'qtags' ),
		));

		if(get_option( 'quiz_post_permalinks_flush' ) !== $this->version ){
			flush_rewrite_rules(false);
			update_option( 'quiz_post_permalinks_flush', $this->version );
		}
	}

	function quiz_post_admin_menu(){
		add_submenu_page( "edit.php?post_type=quiz-posts", "Shortcode", "Shortcode", "manage_options", "quiz-sh", [$this, "quiz_post_sh"], null );
	}

	function quiz_post_sh(){
		?>
		<h3>Shortcode</h3>
		<hr>
		<input type="text" readonly value='[random_quiz cat="" tag=""]'>
		<?php
	}

}
