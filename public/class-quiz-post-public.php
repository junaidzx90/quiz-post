<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://www.fiverr.com/junaidzx90
 * @since      1.0.0
 *
 * @package    Quiz_Post
 * @subpackage Quiz_Post/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Quiz_Post
 * @subpackage Quiz_Post/public
 * @author     Developer Junayed <admin@easeare.com>
 */
class Quiz_Post_Public {

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
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

		add_shortcode( "random_quiz", [$this, "random_quiz_callback"] );
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Quiz_Post_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Quiz_Post_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/quiz-post-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Quiz_Post_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Quiz_Post_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/quiz-post-public.js', array( 'jquery' ), $this->version, false );

	}

	function random_quiz_callback($atts){
		ob_start();
		$atts = shortcode_atts( array(
			'cat' => '',
			'tag' => ''
		), $atts, 'random_quiz' );

		$category = $atts['cat'];
		$tag = $atts['tag'];

		$category_id = '';
		$tag_id = '';
		if($category){
			$category = get_term_by('name', $category, 'qcats');
			$category_id = $category->term_id;
		}

		if(!empty($tag)){
			$tag = get_term_by('name', $tag, 'qtags');
			$tag_id = $tag->term_id;
		}
		
		$args = array(
			'post_type' => 'quiz-posts',
			'numberposts' => -1
		);
		
		if(!empty($category_id)){
			$args['tax_query'][] = array(
				'taxonomy' => 'qcats',
				'field' => 'term_id', 
				'terms' => $category_id,
				'include_children' => false
			);
		}

		if(!empty($tag_id)){
			$args['tax_query'][] = array(
				'taxonomy' => 'qtags',
				'field' => 'term_id', 
				'terms' => $tag_id
			);
		}

		$quizes = get_posts($args);

		$quizes_IDS = [];

		if($quizes){
			foreach($quizes as $catQuiz){
				$quizes_IDS[$catQuiz->ID] = $catQuiz->ID;
			}
		}
		
		if(is_array($quizes_IDS) && sizeof($quizes_IDS) > 0){
			shuffle($quizes_IDS);
			$id_key = array_rand($quizes_IDS, 1);
			$quiz_id = $quizes_IDS[$id_key];

			$posts = new WP_Query( [
				'post_type' => 'quiz-posts',
				'p' => $quiz_id,
				'posts_per_page' => 1
			] );

			if ( $posts->have_posts() ) :
				while ( $posts->have_posts() ) : $posts->the_post();
					echo the_content(  );
				endwhile;
			endif;

			wp_reset_postdata(  );
		}
		
		return ob_get_clean();
	}

}
