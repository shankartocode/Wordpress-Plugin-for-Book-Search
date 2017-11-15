<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://www.krgowrisankar.in/
 * @since      1.0.0
 *
 * @package    Library_Plugin
 * @subpackage Library_Plugin/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Library_Plugin
 * @subpackage Library_Plugin/admin
 * @author     Gowri Shankar K R <contact@krgowrisankar.in>
 */
class Library_Plugin_Admin {

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

	//library plugin metabox values
	private $screen = array(
		'library_books',
	);

	//custom meta box fields
	private $meta_fields = array(
		array(
			'label' => 'Price',
			'id' => 'book_market_price',
			'type' => 'text',
		),
		array(
			'label' => 'ISBN Number',
			'id' => 'isbn_number',
			'type' => 'text',
		),
		array(
			'label' => 'Date added to library',
			'id' => 'added_date',
			'type' => 'date',
		),
		array(
			'label' => 'Source',
			'id' => 'book_accquired_form',
			'type' => 'text',
		),
		array(
			'label' => 'Rights',
			'id' => 'copy_rights',
			'type' => 'text',
		),
		array(
			'label' => 'Published Year',
			'id' => 'published_year',
			'type' => 'text',
		),
		array(
			'label' => 'Rating',
			'id' => 'rating',
			'type' => 'text',
		),
		array(
			'label' => 'Language',
			'id' => 'language',
			'type' => 'select',
			'options' => array(
				'Tamil',
				'Hindi',
				'English',
				'Malayalam',
				'Telugu',
				'Kannada',
				'Marathi',
				'Odia',
				'Gujarathi',
				'Rajasthani',
				'Assames',
			),
		),
	);

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

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/library-plugin-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/library-plugin-admin.js', array( 'jquery' ), $this->version, false );

	}

	//function to create library post type at the backend
	public function library_post_action(){
		$labels = array(
			'name'                  => _x( 'Library Books Collections', 'Post Type General Name', 'text_domain' ),
			'singular_name'         => _x( 'Library Books Collection', 'Post Type Singular Name', 'text_domain' ),
			'menu_name'             => __( 'Library Books', 'text_domain' ),
			'name_admin_bar'        => __( 'Library Book', 'text_domain' ),
			'archives'              => __( 'Book Archives', 'text_domain' ),
			'attributes'            => __( 'Book Attributes', 'text_domain' ),
			'parent_item_colon'     => __( 'Parent Book:', 'text_domain' ),
			'all_items'             => __( 'All Books', 'text_domain' ),
			'add_new_item'          => __( 'Add New Book', 'text_domain' ),
			'add_new'               => __( 'Add New Book', 'text_domain' ),
			'new_item'              => __( 'New Book', 'text_domain' ),
			'edit_item'             => __( 'Edit Book', 'text_domain' ),
			'update_item'           => __( 'Update Book', 'text_domain' ),
			'view_item'             => __( 'View Book', 'text_domain' ),
			'view_items'            => __( 'View Books', 'text_domain' ),
			'search_items'          => __( 'Search Book', 'text_domain' ),
			'not_found'             => __( 'Not found', 'text_domain' ),
			'not_found_in_trash'    => __( 'Not found in Trash', 'text_domain' ),
			'featured_image'        => __( 'Featured Image', 'text_domain' ),
			'set_featured_image'    => __( 'Set featured image', 'text_domain' ),
			'remove_featured_image' => __( 'Remove featured image', 'text_domain' ),
			'use_featured_image'    => __( 'Use as featured image', 'text_domain' ),
			'insert_into_item'      => __( 'Insert into Book', 'text_domain' ),
			'uploaded_to_this_item' => __( 'Uploaded to this Book', 'text_domain' ),
			'items_list'            => __( 'Books list', 'text_domain' ),
			'items_list_navigation' => __( 'Books list navigation', 'text_domain' ),
			'filter_items_list'     => __( 'Filter Books list', 'text_domain' ),
		);
		$args = array(
			'label'                 => __( 'Library Books Collection', 'text_domain' ),
			'description'           => __( 'Library Books Collection', 'text_domain' ),
			'labels'                => $labels,
			'supports'              => array( 'title', 'editor', 'excerpt', 'thumbnail', 'revisions', 'page-attributes' ),
			//'taxonomies'            => array( 'category', 'post_tag' ),
			'hierarchical'          => false,
			'public'                => true,
			'show_ui'               => true,
			'show_in_menu'          => true,
			'menu_position'         => 5,
			'show_in_admin_bar'     => true,
			'show_in_nav_menus'     => true,
			'can_export'            => true,
			'has_archive'           => true,		
			'exclude_from_search'   => false,
			'publicly_queryable'    => true,
			'capability_type'       => 'page',
		);
		// Register Custom Post Type
		register_post_type( 'library_books', $args );

		//genre taxonomy for book post type
		$labels = array(
			'name'                       => _x( 'Genres', 'Taxonomy General Name', 'text_domain' ),
			'singular_name'              => _x( 'Genre', 'Taxonomy Singular Name', 'text_domain' ),
			'menu_name'                  => __( 'Genre', 'text_domain' ),
			'all_items'                  => __( 'All Genres', 'text_domain' ),
			'parent_item'                => __( 'Parent Genre', 'text_domain' ),
			'parent_item_colon'          => __( 'Parent Genre:', 'text_domain' ),
			'new_item_name'              => __( 'New Genre Name', 'text_domain' ),
			'add_new_item'               => __( 'Add New Genre', 'text_domain' ),
			'edit_item'                  => __( 'Edit Genre', 'text_domain' ),
			'update_item'                => __( 'Update Genre', 'text_domain' ),
			'view_item'                  => __( 'View Genre', 'text_domain' ),
			'separate_items_with_commas' => __( 'Separate Genres with commas', 'text_domain' ),
			'add_or_remove_items'        => __( 'Add or remove Genres', 'text_domain' ),
			'choose_from_most_used'      => __( 'Choose from the most used', 'text_domain' ),
			'popular_items'              => __( 'Popular Genres', 'text_domain' ),
			'search_items'               => __( 'Search Genres', 'text_domain' ),
			'not_found'                  => __( 'Not Found', 'text_domain' ),
			'no_terms'                   => __( 'No Genres', 'text_domain' ),
			'items_list'                 => __( 'Genres list', 'text_domain' ),
			'items_list_navigation'      => __( 'Genres list navigation', 'text_domain' ),
		);
		$args = array(
			'labels'                     => $labels,
			'hierarchical'               => false,
			'public'                     => true,
			'show_ui'                    => true,
			'show_admin_column'          => true,
			'show_in_nav_menus'          => true,
			'show_tagcloud'              => true,
		);
		//Register genre taxonomy for Custom Post Type
		register_taxonomy( 'genre', array( 'library_books' ), $args );

		//author taxonomy for book post type
		$labels = array(
			'name'                       => _x( 'Authors', 'Taxonomy General Name', 'text_domain' ),
			'singular_name'              => _x( 'Author', 'Taxonomy Singular Name', 'text_domain' ),
			'menu_name'                  => __( 'Author', 'text_domain' ),
			'all_items'                  => __( 'All Authors', 'text_domain' ),
			'parent_item'                => __( 'Parent Author', 'text_domain' ),
			'parent_item_colon'          => __( 'Parent Author:', 'text_domain' ),
			'new_item_name'              => __( 'New Author Name', 'text_domain' ),
			'add_new_item'               => __( 'Add New Author', 'text_domain' ),
			'edit_item'                  => __( 'Edit Author', 'text_domain' ),
			'update_item'                => __( 'Update Author', 'text_domain' ),
			'view_item'                  => __( 'View Author', 'text_domain' ),
			'separate_items_with_commas' => __( 'Separate Authors with commas', 'text_domain' ),
			'add_or_remove_items'        => __( 'Add or remove Authors', 'text_domain' ),
			'choose_from_most_used'      => __( 'Choose from the most used', 'text_domain' ),
			'popular_items'              => __( 'Popular Authors', 'text_domain' ),
			'search_items'               => __( 'Search Authors', 'text_domain' ),
			'not_found'                  => __( 'Not Found', 'text_domain' ),
			'no_terms'                   => __( 'No Authors', 'text_domain' ),
			'items_list'                 => __( 'Authors list', 'text_domain' ),
			'items_list_navigation'      => __( 'Authors list navigation', 'text_domain' ),
		);
		$args = array(
			'labels'                     => $labels,
			'hierarchical'               => false,
			'public'                     => true,
			'show_ui'                    => true,
			'show_admin_column'          => true,
			'show_in_nav_menus'          => true,
			'show_tagcloud'              => true,
		);
		//Register author taxonomy for Custom Post Type
		register_taxonomy( 'author', array( 'library_books' ), $args );

		//publisher taxonomy for book post type	
		$labels = array(
			'name'                       => _x( 'publishers', 'Taxonomy General Name', 'text_domain' ),
			'singular_name'              => _x( 'publisher', 'Taxonomy Singular Name', 'text_domain' ),
			'menu_name'                  => __( 'Publisher', 'text_domain' ),
			'all_items'                  => __( 'All Publishers', 'text_domain' ),
			'parent_item'                => __( 'Parent Publisher', 'text_domain' ),
			'parent_item_colon'          => __( 'Parent Publisher:', 'text_domain' ),
			'new_item_name'              => __( 'New Publisher Name', 'text_domain' ),
			'add_new_item'               => __( 'Add New Publisher', 'text_domain' ),
			'edit_item'                  => __( 'Edit Publisher', 'text_domain' ),
			'update_item'                => __( 'Update Publisher', 'text_domain' ),
			'view_item'                  => __( 'View Publisher', 'text_domain' ),
			'separate_items_with_commas' => __( 'Separate Publishers with commas', 'text_domain' ),
			'add_or_remove_items'        => __( 'Add or remove Publishers', 'text_domain' ),
			'choose_from_most_used'      => __( 'Choose from the most used', 'text_domain' ),
			'popular_items'              => __( 'Popular Publishers', 'text_domain' ),
			'search_items'               => __( 'Search Items', 'text_domain' ),
			'not_found'                  => __( 'Not Found', 'text_domain' ),
			'no_terms'                   => __( 'No Publishers', 'text_domain' ),
			'items_list'                 => __( 'Publishers list', 'text_domain' ),
			'items_list_navigation'      => __( 'Publishers list navigation', 'text_domain' ),
		);
		$args = array(
			'labels'                     => $labels,
			'hierarchical'               => false,
			'public'                     => true,
			'show_ui'                    => true,
			'show_admin_column'          => true,
			'show_in_nav_menus'          => true,
			'show_tagcloud'              => true,
		);
		//Register publisher taxonomy for Custom Post Type
		register_taxonomy( 'publisher', array( 'library_books' ), $args );

	}


	//library books plugin custom meta box
	public function add_meta_boxes() {
		foreach ( $this->screen as $single_screen ) {
			add_meta_box(
				'librarybooks',
				__( 'Library Book Detail', 'textdomain' ),
				array( $this, 'meta_box_callback' ),
				$single_screen,
				'advanced',
				'high'
			);
		}
	}

	//metabox callback
	public function meta_box_callback( $post ) {
		wp_nonce_field( 'librarybooks_data', 'librarybooks_nonce' );
		echo 'Attribute for library books ';
		$this->field_generator( $post );
	}

	//metabox field generator
	public function field_generator( $post ) {
		$output = '';
		foreach ( $this->meta_fields as $meta_field ) {
			$label = '<label for="' . $meta_field['id'] . '">' . $meta_field['label'] . '</label>';
			$meta_value = get_post_meta( $post->ID, $meta_field['id'], true );
			if ( empty( $meta_value ) ) {
				$meta_value = $meta_field['default']; }
			switch ( $meta_field['type'] ) {
				case 'select':
					$input = sprintf(
						'<select id="%s" name="%s">',
						$meta_field['id'],
						$meta_field['id']
					);
					foreach ( $meta_field['options'] as $key => $value ) {
						$meta_field_value = !is_numeric( $key ) ? $key : $value;
						$input .= sprintf(
							'<option %s value="%s">%s</option>',
							$meta_value === $meta_field_value ? 'selected' : '',
							$meta_field_value,
							$value
						);
					}
					$input .= '</select>';
					break;
				default:
					$input = sprintf(
						'<input %s id="%s" name="%s" type="%s" value="%s">',
						$meta_field['type'] !== 'color' ? 'style="width: 100%"' : '',
						$meta_field['id'],
						$meta_field['id'],
						$meta_field['type'],
						$meta_value
					);
			}
			$output .= $this->format_rows( $label, $input );
		}
		echo '<table class="form-table"><tbody>' . $output . '</tbody></table>';
	}
	public function format_rows( $label, $input ) {
		return '<tr><th>'.$label.'</th><td>'.$input.'</td></tr>';
	}
	public function save_fields( $post_id ) {
		if ( ! isset( $_POST['librarybooks_nonce'] ) )
			return $post_id;
		$nonce = $_POST['librarybooks_nonce'];
		if ( !wp_verify_nonce( $nonce, 'librarybooks_data' ) )
			return $post_id;
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
			return $post_id;
		foreach ( $this->meta_fields as $meta_field ) {
			if ( isset( $_POST[ $meta_field['id'] ] ) ) {
				switch ( $meta_field['type'] ) {
					case 'email':
						$_POST[ $meta_field['id'] ] = sanitize_email( $_POST[ $meta_field['id'] ] );
						break;
					case 'text':
						$_POST[ $meta_field['id'] ] = sanitize_text_field( $_POST[ $meta_field['id'] ] );
						break;
				}
				update_post_meta( $post_id, $meta_field['id'], $_POST[ $meta_field['id'] ] );
			} else if ( $meta_field['type'] === 'checkbox' ) {
				update_post_meta( $post_id, $meta_field['id'], '0' );
			}
		}
	}

}
