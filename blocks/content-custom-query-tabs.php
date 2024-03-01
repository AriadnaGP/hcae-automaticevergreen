<?php
/**
 * Here you have an example of block type, you can remplace the example name with if you need it
 * Don't forget to create this block and in ACF Wordpress
 *
 * @package HeyCreator Theme
 */
$id_block = '';
$class_name = 'custom-query-tabs';
if ( ! empty( $block['className'] ) ) {
	$class_name .= ' ' . $block['className'];
}
if ( ! empty( $block['anchor'] ) ) {
	$id_block = $block['anchor'];
}

/** Create align class ("alignwide") from block setting ("wide")  */

$align_class = $block['align'] ? 'align' . $block['align'] : '';?>
<section id="<?php echo esc_html( $id_block ); ?>" class="<?php echo esc_attr( $class_name ); ?> <?php echo esc_html( $align_class ); ?>" >
  
<?php
/**
 * Get the selected custom post type
 */

$custom_post_type = get_field( 'custom_post_type' );
$custom_post_type_category = get_field( 'custom_post_type_category' );
$value_cpt = $custom_post_type['value'];
$value_cpt_ctg = $custom_post_type_category['value'];
$image_podcast = '';

/** Check if the custom post type is 'podcast' to get the specific image  */

if ( 'podcast' == $value_cpt ) {
	$image_podcast = get_field( 'podcast_featured_image', 'options' );
}

/**  Step 1: Get all categories for the selected custom post type */

$categories = get_terms(
	array(
		'taxonomy' => $value_cpt_ctg,
		'hide_empty' => false,
	)
);

/** Step 2: Display "All" button */

global $wp;
$current_url = home_url( $wp->request );
$current_url = preg_replace( '/\/page\/\d+/', '', $current_url );

/** Get the current category slug from the query parameters */

$current_category_list = isset( $_GET['cat'] ) ? sanitize_text_field( wp_unslash( $_GET['cat'] ) ) : '';

echo '<div class="tabs">';


/** Output the "All" tab */

echo '<a class="tab ' . ( empty( $current_category_list ) ? 'active' : '' ) . '" href="' . esc_url( $current_url ) . '">All</a>';

/** Output the category tabs */
if (!empty($categories)) {
	foreach ( $categories as $category ) {
		/** Check if the current category is an object and has the required properties */

		   /** Check if the current category has posts */
		$category_has_posts = get_posts(
			array(
				'post_type' => $value_cpt,
				'posts_per_page' => 1,
				'tax_query' => array(
					array(
						'taxonomy' => $value_cpt_ctg,
						'field' => 'slug',
						'terms' => $category->slug,
					),
				),
			)
		);

		if ( $category_has_posts ) {
			$is_active = ( $category->slug === $current_category_list );

			echo '<a class="tab ' . ( $is_active ? 'active' : '' ) . '" href="' . esc_url( add_query_arg( 'cat', esc_attr( $category->slug ), $current_url ) ) . '">' . esc_html( $category->name ) . '</a>';

		}
	}
}
echo '</div>';



/**  Step 3: Inside each tab, run a query for posts in that category or all categories */

	$posts_per_page = get_field( 'posts_per_page' );
	$paged_custom = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
	$args = array(
		'post_type' => $value_cpt,
		'posts_per_page' => $posts_per_page ? $posts_per_page : -1,
		'paged'          => $paged_custom,
	);

	$category = isset( $_GET['cat'] ) ? sanitize_text_field( wp_unslash( $_GET['cat'] ) ) : null;


	if ( isset( $category ) && $category ) {
		$args['tax_query'] = array(
			array(
				'taxonomy' => $value_cpt_ctg,
				'field' => 'slug',
				'terms' => $category,
			),
		);
	}

	$query = new WP_Query( $args );

	if ( $query->have_posts() ) {
		
		echo '<div class="tab-content">';
		while ( $query->have_posts() ) :
			$query->the_post();
			?>
			<div class="block-post"> 
			<?php
				/** Display custom fields associated with the post */

				$episode_number = get_field( 'episode_number', get_the_ID() );
				$podcast_length = get_field( 'podcast_length', get_the_ID() );
				$replay_length = get_field( 'video_length', get_the_ID() );

				/** Display the featured image with a link to the post */

				echo '<a class="box-image" href="' . esc_url( get_permalink() ) . '">';
			if ( 'podcast' === $value_cpt && ! empty( $image_podcast ) ) {
				echo '<figure class="featured-image podcast-img"><img src="' . esc_url( $image_podcast['url'] ) . '" alt="' . esc_attr( $image_podcast['alt'] ) . '" /></figure>';
			} elseif ( has_post_thumbnail() ) {
				echo '<figure class="featured-image">' . get_the_post_thumbnail() . '</figure>';
			}
			if ( $podcast_length ) {
				echo '<span class="length">' . esc_html( $podcast_length ) . '</span>';
			}
			if ( $replay_length ) {
				echo '<span class="length">' . esc_html( $replay_length ) . '</span>';
			}
				echo '</a>';


				echo '<div class="info-post">';
			if ( $episode_number ) {
				echo '<span class="episode-no">Episode #' . esc_html( $episode_number ) . '</span>';
			}

				/** Display the category name with a link to the category archive */

				$categories = get_the_terms( get_the_ID(), $value_cpt_ctg );
			if ( $categories && ! is_wp_error( $categories ) ) {
				$category_names = array_map(
					function ( $cat ) {
						return '<a href="' . esc_url( get_term_link( $cat->term_id ) ) . '">' . esc_html( $cat->name ) . '</a>';
					},
					$categories
				);
				echo '<div class="category-name">' . wp_kses_post( implode( ', ', $category_names ) ) . '</div>';
			}
				echo '</div>';

				/** Display the post title with a link to the post */

				echo '<h3><a href="' . esc_url( get_permalink() ) . '">' . esc_html( get_the_title() ) . '</a></h3>';
			?>
			</div>
			<?php
		endwhile;

		echo '</div>';
	  
		$total_pages = $query->max_num_pages;
		if ( $total_pages > 1 ) {
			echo '<div class="pagination">';
			echo wp_kses_post(
				paginate_links(
					array(
						'current'   => max( 1, get_query_var( 'paged' ) ),
						'total'     => esc_html( $total_pages ),
						'prev_text' => '<i class="fa-solid fa-arrow-left"></i> Previous',
						'next_text' => 'Next <i class="fa-solid fa-arrow-right"></i>',
					)
				)
			);
			echo '</div>';
		}
		wp_reset_postdata();

	} else {
		echo esc_html('No posts found');
	}



	?>
</section>
