<?php

/**
 * Provide a public-facing view for the plugin
 *
 * This file is used to markup the public-facing aspects of the plugin.
 *
 * @link       http://www.krgowrisankar.in/
 * @since      1.0.0
 *
 * @package    Library_Plugin
 * @subpackage Library_Plugin/public/partials
 */
?>

<!-- consist of HTML search form. -->
<div class="container">
	<div class="row filterpart">
		<!-- form -->
		<form action="<?php echo site_url() ?>/wp-admin/admin-ajax.php" method="POST" id="filter">
			
			<input type="text" name="book_name" class="book_name" id="book_name" placeholder="Book Name..."> 

			<!-- category genre -->
			<?php if( $terms = get_terms( 'genre', 'orderby=name' ) ) : 
				echo '<select name="categoryfilterOne"><option value="">Select Genre...</option>';
				foreach ( $terms as $term ) :
					echo '<option value="' . $term->term_id . '">' . $term->name . '</option>'; 
				endforeach;
				echo '</select>';
			endif; ?>

			<!-- category author -->
			<?php if( $terms = get_terms( 'author', 'orderby=name' ) ) : 
				echo '<select name="categoryfilterTwo"><option value="">Select Author...</option>';
				foreach ( $terms as $term ) :
					echo '<option value="' . $term->term_id . '">' . $term->name . '</option>'; 
				endforeach;
				echo '</select>';
			endif; ?>

			<!-- category publisher -->
			<?php if( $terms = get_terms( 'publisher', 'orderby=name' ) ) : 
				echo '<select name="categoryfilterThree"><option value="">Select Publisher...</option>';
				foreach ( $terms as $term ) :
					echo '<option value="' . $term->term_id . '">' . $term->name . '</option>'; 
				endforeach;
				echo '</select>';
			endif; ?>

			<!-- price range slider -->
			<div class="price-range">
				<p>Select Price Range</p>
				<input type="hidden" id="price_min_max" name="price_min_max" value="0,2000">
			</div>

			<!-- publish year range slider -->
			<div class="publish-range">
				<p>Select Published Year Range</p>
				<input type="hidden" id="publish_year_from_to" name="publish_year_from_to" value="1950,2017">
			</div>

			<!-- rating range slider -->
			<div class="rating-range">
				<p>Select Book Rating</p>
				<input type="hidden" id="rating_range_fr_to" name="rating_range_fr_to" value="1,5">
			</div>

			<input type="hidden" name="action" value="myfilter">

			<button>Search Books</button>
		</form>
	</div>

	<div class="row displaypart">
		<div id="response" class="filter-meta-box">
			<?php 
				$args = array(
					'post_type' => 'library_books',
					'orderby' => 'date', // we will sort posts by date
					'order'	=> 'DESC'
				);
				$query = new WP_Query( $args );
				$return = "";
				if( $query->have_posts() ) :
					while( $query->have_posts() ): $query->the_post();
						$return .= '<div class="books"><a href="'.get_permalink($query->post_ID).'"><div class="book-image"><img src="'.get_the_post_thumbnail_url($query->post_ID).'" width="400" height="300"></div><h3>' . $query->post->post_title . '</h3></a></div>';
					endwhile;
					wp_reset_postdata();
				else :
					$return .= 'No posts found';
				endif;
				echo $return; 
			?>
		</div>
		<div class="holder"></div>
	</div>
</div>