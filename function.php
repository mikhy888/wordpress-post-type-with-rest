//adding single post tyle with rest support

function codex_result_init() {
$labels = array(
    'name'               => _x( 'Result', 'post type general name', 'your-plugin-textdomain' ),
    'singular_name'      => _x( 'Result', 'post type singular name', 'your-plugin-textdomain' ),
    'menu_name'          => _x( 'Result', 'admin menu', 'your-plugin-textdomain' ),
    'name_admin_bar'     => _x( 'Result', 'add new on admin bar', 'your-plugin-textdomain' ),
    'add_new'            => _x( 'Add New', 'Result', 'your-plugin-textdomain' ),
    'add_new_item'       => __( 'Add New Result', 'your-plugin-textdomain' ),
    'new_item'           => __( 'New Result', 'your-plugin-textdomain' ),

    'edit_item'          => __( 'Edit Result', 'your-plugin-textdomain' ),

    'view_item'          => __( 'View Result', 'your-plugin-textdomain' ),

    'all_items'          => __( 'All Result', 'your-plugin-textdomain' ),

    'search_items'       => __( 'Search Result', 'your-plugin-textdomain' ),

    'parent_item_colon'  => __( 'Parent Result:', 'your-plugin-textdomain' ),
    'not_found'          => __( 'No Result found.', 'your-plugin-textdomain' ),
    'not_found_in_trash' => __( 'No Result found in Trash.', 'your-plugin-textdomain' )
);

$args = array(
    'labels'             => $labels,
    'description'        => __( 'Description.', 'your-plugin-textdomain' ),
    'public'             => true,
    'publicly_queryable' => true,
    'show_ui'            => true,
    'show_in_menu'       => true,
    'show_in_rest'       => true,
    'query_var'          => true,
    'menu_icon'          => 'dashicons-admin-users',
    'rewrite' => array( 'slug' => __('result', 'result')),
    'capability_type'    => 'post',
    'has_archive'        => true,
    'hierarchical'       => false,
    'rest_base'          => 'result',
    'rest_controller_class' => 'WP_REST_Posts_Controller',
    'menu_position'      => 5,
    'supports'           => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments' ),
    'taxonomies'       => array('result','category', 'post_tag')

);

register_post_type( 'result', $args );
}
  add_action( 'init', 'codex_result_init' );




// making wordpress editor screen full width

function custom_admin_css() {
echo '<style type="text/css">
.wp-block { max-width: 100%; }
</style>';
}
add_action('admin_head', 'custom_admin_css');




// HIDING DEFAULT EDITOR FROM THE PAGE

function reset_editor()
{
     global $_wp_post_type_features;

     $post_type="page";
     $feature = "editor";
     if ( !isset($_wp_post_type_features[$post_type]) )
     {

     }
     elseif ( isset($_wp_post_type_features[$post_type][$feature]) )
     unset($_wp_post_type_features[$post_type][$feature]);
}

add_action("init","reset_editor");




//ACF fetching post - details - as loop
<?php 
		$posts = get_posts(array(
			'posts_per_page'	=> -1,
			'post_type'			=> 'news'  //post name
		));
		if( $posts ): ?>
			<ul class="home-news">
			<?php foreach( $posts as $post ): 
				setup_postdata( $post );
				?>
				<li>
					<a href="<?php the_permalink(); ?>">
						<img src="<?php echo the_field('news_image'); ?>" alt="">
						<div class="inner-bottom">
							<div class="date"><?php the_field('news_date'); ?></div>
							<div class="text"><?php the_field('news_title'); ?></div>
						</div>
					</a>
				</li>
			<?php endforeach; ?>
			</ul>
			<?php wp_reset_postdata(); ?>
		<?php endif; ?>




/*
Removing p tag from wp contact form 7
add_filter( 'wpcf7_autop_or_not', '__return_false' );
//Goes to wp-config.php file
*/
