<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://www.krgowrisankar.in/
 * @since      1.0.0
 *
 * @package    Library_Plugin
 * @subpackage Library_Plugin/public
 */

/**
 * The public-facing functionality of the library books plugin.
 *
 *
 * @package    Library_Plugin
 * @subpackage Library_Plugin/public
 * @author     Gowri Shankar K R <contact@krgowrisankar.in>
 */
class Library_Plugin_Public {

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

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/library-plugin-public.css', array(), $this->version, 'all' );
		wp_enqueue_style( 'prism', plugin_dir_url( __FILE__ ) . 'css/prism.css', array(), $this->version, 'all' );
		wp_enqueue_style( 'jquery-range', plugin_dir_url( __FILE__ ) . 'css/jquery.range.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/library-plugin-public.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script( 'prism-js', plugin_dir_url( __FILE__ ) . 'js/prism.js', array( 'jquery' ), $this->version, true );
		wp_enqueue_script( 'jquery-range', plugin_dir_url( __FILE__ ) . 'js/jquery.range-min.js', array( 'jquery' ), $this->version, true );
		wp_enqueue_script( 'jquery-paginate', plugin_dir_url( __FILE__ ) . 'js/jPages.min.js', array( 'jquery' ), $this->version, true );
		

	}

	/**
	 * Registers the shortcode for frontend search form 
	 *
	 * @since    1.0.0
	 */
	public function book_filter(){
		function book_filter_html(){
			include 'partials/library-plugin-public-display.php';
		}
		add_shortcode( 'book_display_and_filter', 'book_filter_html' );
	}

	/**
	 * Function to filter the books according to the user values in the search form
	 *
	 * @since    1.0.0
	 */
	public function book_filter_function(){
		$keyword = $_POST['book_name'];

		//arg construct begins
		$args = array(
			's' => $keyword,
			'post_type' => 'library_books',
			'orderby' => 'date', 
			'order'	=> 'DESC'
		);

		//genre category arg
		if( isset( $_POST['categoryfilterOne'] ) && $_POST['categoryfilterOne'] ){
			$filter_one = array(
				'taxonomy' => 'genre',
				'field' => 'id',
				'terms' => $_POST['categoryfilterOne']
			);
		} else {
			$filter_one = '';
		}

		//author category arg
		if( isset( $_POST['categoryfilterTwo'] ) && $_POST['categoryfilterTwo'] ){
			$filter_two = array(
				'taxonomy' => 'author',
				'field' => 'id',
				'terms' => $_POST['categoryfilterTwo']
			);
		} else {
			$filter_two = '';
		}

		//publisher category arg
		if( isset( $_POST['categoryfilterThree'] ) && $_POST['categoryfilterThree'] ){
			$filter_three = array(
				'taxonomy' => 'publisher',
				'field' => 'id',
				'terms' => $_POST['categoryfilterThree']
			);
		} else {
			$filter_three = '';
		}
	 
		// for taxonomies / categories
		$args['tax_query'] = array($filter_one, $filter_two, $filter_three);

		// if both minimum price and maximum price are specified we will use BETWEEN comparison
		if( isset( $_POST['price_min_max'] ) && $_POST['price_min_max']) {
			$exploded_min_max = explode(',', $_POST['price_min_max']);
			$args['meta_query'][] = array(
				'key' => 'book_market_price',
				'value' => array( $exploded_min_max[0], $exploded_min_max[1] ),
				'type' => 'numeric',
				'compare' => 'between'
			);
		}

		// gets the books based on specified year we will use BETWEEN comparison
		if( isset( $_POST['publish_year_from_to'] ) && $_POST['publish_year_from_to'] ) {
			$exploded_from_to = explode(',', $_POST['publish_year_from_to']);
			$args['meta_query'][] = array(
				'key' => 'published_year',
				'value' => array( $exploded_from_to[0], $exploded_from_to[1] ),
				'type' => 'numeric',
				'compare' => 'between'
			);
		}

		// gets the books based on specified rating we will use BETWEEN comparison
		if( isset( $_POST['rating_range_fr_to'] ) && $_POST['rating_range_fr_to'] ) {
			$exploded_from_to = explode(',', $_POST['rating_range_fr_to']);
			$args['meta_query'][] = array(
				'key' => 'rating',
				'value' => array( $exploded_from_to[0], $exploded_from_to[1] ),
				'type' => 'numeric',
				'compare' => 'between'
			);
		}
		
		//WP_Query to get the results from the database
		$query = new WP_Query( $args );
	 
		//return echo and die to the ajax response, returns an html
		if( $query->have_posts() ) :
			while( $query->have_posts() ): $query->the_post();
				echo '<div class="books"><a href="'.get_permalink($query->post_ID).'"><div class="book-image"><img src="'.get_the_post_thumbnail_url($query->post_ID).'" width="400" height="300"></div><h3>' . $query->post->post_title . '</h3></a></div>';
			endwhile;
			wp_reset_postdata();
		else :
			echo 'No posts found';
		endif;
		die();
	}
}
