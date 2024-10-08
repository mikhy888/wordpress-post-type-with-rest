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
			<?php wp_reset_postdata(); ?>
		<?php endif; ?>




/*
Removing p tag from wp contact form 7
add_filter( 'wpcf7_autop_or_not', '__return_false' );
//Goes to wp-config.php file
*/






// adding multiple post type
function codex_custom_init() {

  register_post_type(
    'testimonials', array(
      'labels' => array('name' => __( 'Books' ), 'singular_name' => __( 'Book' ) ),
      'public' => true,
      'has_archive' => true,
      'supports' => array('title', 'editor', 'thumbnail')
    )
  );

  register_post_type(
    'home-messages', array(
      'labels' => array('name' => __( 'Cars' ), 'singular_name' => __( 'Car' ) ),
      'public' => true,
      'has_archive' => true,
      'supports' => array('title', 'editor', 'thumbnail')
    )
  );

}
add_action( 'init', 'codex_custom_init' );




//adding trim, truncate
<?php echo $excerpt = wp_trim_words( get_field('service_detail_content' ), $num_words = 50, $more = '...' ); ?>






//registration random posts - in single post page or template
<?php
// Function to get and display random posts
function display_random_posts($number_of_posts = 4) {
    $args = array(
        'post_type' => 'post', // Change to your custom post type if needed
        'posts_per_page' => $number_of_posts,
        'orderby' => 'rand', // Order posts randomly
        'no_found_rows' => true, // Optimize query when pagination is not needed
    );

    $random_posts_query = new WP_Query($args);

    // Check if there are posts
    if ($random_posts_query->have_posts()) : ?>
        <div class="random-posts">
            <h2>Random Posts</h2>
            <ul>
                <?php while ($random_posts_query->have_posts()) : $random_posts_query->the_post(); ?>
                    <li>
                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                    </li>
                <?php endwhile; ?>
            </ul>
        </div>
        <?php wp_reset_postdata(); // Reset the post data after the custom query ?>
    <?php endif;
}

// Call the function wherever you want to display random posts
display_random_posts(); // You can pass the number of posts you want to display
?>







//disable edit and trash
add_filter( 'page_row_actions', 'remove_row_actions', 10, 1 );
function remove_row_actions( $actions )
{
    if( get_post_type() === 'page' )
        //unset( $actions['edit'] );
        //unset( $actions['view'] );
        unset( $actions['trash'] );
        unset( $actions['inline hide-if-no-js'] );
    return $actions;
}



//load faster with acf
define('WP_POST_REVISIONS', false );



//acf custom post type archive code for function.php
function mindbase_create_acf_pages() {
  if(function_exists('acf_add_options_page')) {
    acf_add_options_sub_page(array(
      'page_title'      => 'Program Archive Settings', /* Use whatever title you want */
      
      'parent_slug'     => 'edit.php?post_type=programs', /* Change "services" to fit your situation */
      'capability' => 'manage_options'
    ));
  }
}
add_action( 'init', 'mindbase_create_acf_pages' );



// list all category and subcategory
<?php
   $args = array(
	       'post_type' => 'courses',
               'taxonomy' => 'category', /*taxonomy name specified in post declaration*/
               'orderby' => 'name',
               'order'   => 'ASC'
           );
   $cats = get_categories($args);
   foreach($cats as $cat) {
?>
  <a href="<?php echo get_category_link( $cat->term_id ) ?>">
           <?php echo $cat->name; ?>
      </a>
<?php
   }
?>

// Get category names based on ID - from post type
<?php 
	$category_detail=get_the_category($id);
		foreach($category_detail as $cd){
		echo $cd->cat_name;
	}
?>


<!-- get data from single category id outside of post loop -->
<?php
$args = array( 'category' => 3, 'post_type' =>  'projects' ); 
$postslist = get_posts( $args );    
foreach ($postslist as $post) :  setup_postdata($post); 
?>  
<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2> 
<?php the_excerpt(); ?>  
<?php endforeach; ?> 
	




<<<<<<<<< auto expiry
	     
	     $today = date("d/m/Y");
		//echo $today;
		$orderdate=$today;
		$orderdate = explode('/', $orderdate);
		$day = $orderdate[0];
		$month   = $orderdate[1];
		$year  = $orderdate[2];
		/*echo $day."<br>";
		echo $month."<br>";
		echo $year;*/
		if( $month == 5 ) {
			require_once $_template_file;
		}

>>>> wp-inc>>template.php>> last condition
	
	
	
//adding google map iframe from textarea - acf
	<div class="map-wrapper">
   <?php 
    $iframe_string = get_field("google_map"); 
    preg_match('/src="([^"]+)"/', $iframe_string, $match);
    $url = $match[1];
   ?>
   <iframe src="<?php echo $url ?>" frameborder="0" width="100%" height="340px"></iframe>
 </div>
	
	
	
	
	
// Calling menu from menu name
<?php wp_nav_menu( array( 'menu' => 'Header Menu')); ?>

	
	
	
// custom menu set up
<?php $items = wp_get_nav_menu_items( "Menu 1", $args ); ?> 
<?php
echo '<ul>';
foreach($items as $item)
{
    echo '<li>'.$item->title.'</li>'; // $item->url  -   to get menu url
}
echo '</ul>';
?>

	
	

// youtube video id ; checking whether its short or main video
function extractVideoId($url) {
	if (preg_match('/youtube\.com\/shorts\/([a-zA-Z0-9_-]+)/', $url, $matches)) {
	    return $matches[1];
	}
	if (preg_match('/youtube\.com\/watch\?v=([a-zA-Z0-9_-]+)/', $url, $matches)) {
	    return $matches[1];
	}
	return null;
}
$videoId1 = extractVideoId(get_sub_field('url')); // output come in this function

	
//listing the available category of a post type
  <?php
    $args = array(
		'post_type' => 'works', /*Post type name*/
		'taxonomy' => 'category', /*taxonomy name*/
		'orderby' => 'name',
		'order' => 'ASC'
	    );
    $cats = get_categories($args);
      foreach($cats as $cat) {
    ?>
    <a href="<?php echo get_category_link( $cat->term_id ) ?>">
	<?php echo $cat->name; ?>
    </a>
  <?php
    }
  ?>
	
	
// adding category list from post type declaration -  this code goes inside post content fetch loop
$category_detail=get_the_category($post->ID);
<?php foreach($category_detail as $cd){echo " ".str_replace(' ', '-', strtolower($cd->cat_name));} ?>

	

// custom menu with submenu
	<?php 
	function wp_get_menu_array($current_menu) {
    $array_menu = wp_get_nav_menu_items($current_menu);
    $menu = array();
    foreach ($array_menu as $m) {
        if (empty($m->menu_item_parent)) {
            $menu[$m->ID] = array();
            $menu[$m->ID]['ID']          =   $m->ID;
            $menu[$m->ID]['title']       =   $m->title;
            $menu[$m->ID]['url']         =   $m->url;
            $menu[$m->ID]['children']    =   array();
        }
    }
    $submenu = array();
    foreach ($array_menu as $m) {
        if ($m->menu_item_parent) {
            $submenu[$m->ID] = array();
            $submenu[$m->ID]['ID']       =   $m->ID;
            $submenu[$m->ID]['title']    =   $m->title;
            $submenu[$m->ID]['url']      =   $m->url;
            $menu[$m->menu_item_parent]['children'][$m->ID] = $submenu[$m->ID];
        }
    }
    return $menu;
}
	$menu_items = wp_get_menu_array('Main Menu');  // get menu name created here
 ?>
   <nav>
      <ul>
        <?php foreach ($menu_items as $item) : ?>
          <li>
            <a href="<?= $item['url'] ?>" title="<?= $item['title'] ?>"><?= $item['title'] ?></a>
            <?php if( !empty($item['children']) ):?>
            <ul class="sub-menu">
              <?php foreach($item['children'] as $child): ?>
                <li class="b-main-header__sub-menu__nav-item">
                  <a href="<?= $child['url'] ?>" title="<?= $child['title'] ?>"><?= $child['title'] ?></a>
                </li>
              <?php endforeach; ?>
            </ul>
            <?php endif; ?>
          </li>
        <?php endforeach; ?>
     <ul>
</nav>

	      
	    
	     
// Custom taxonomy registration
/*custom taxonomy*/
function add_custom_taxonomies() {
  register_taxonomy('brand', 'products', array(  //Taxonomy name "brands"
    'hierarchical' => true,
    'labels' => array(
      'name' => _x( 'Brands', 'taxonomy general name' ),
      'singular_name' => _x( 'Brand', 'taxonomy singular name' ),
      'search_items' =>  __( 'Search Brands' ),
      'all_items' => __( 'All Brands' ),
      'parent_item' => __( 'Parent Brand' ),
      'parent_item_colon' => __( 'Parent Brand:' ),
      'edit_item' => __( 'Edit Brand' ),
      'update_item' => __( 'Update Brand' ),
      'add_new_item' => __( 'Add New Brand' ),
      'new_item_name' => __( 'New Brand Name' ),
      'menu_name' => __( 'Brands' ),
    ),
    'rewrite' => array(
      'slug' => 'brands', 
      'with_front' => true, 
      'hierarchical' => true 
    ),
  ));
}
add_action( 'init', 'add_custom_taxonomies', 0 );


// getting the selected value in post declaration
$term_obj_list = get_the_terms( $post->ID, 'brand' );
foreach($term_obj_list as $termitem){echo str_replace(' ', '-', strtolower($termitem->name)).' ';}





