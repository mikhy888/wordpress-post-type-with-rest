<!-- main filter starts -->
<div class="container">
	<ul class="parent category-wrapper">
				        <?php
				            $get_parent_cats = array(
								'taxonomy' => 'category',
								'hierarchical' => true,
								'orderby' => 'term_order',
				                'parent' => '0' //get top level categories only
				            );

				            $all_categories = get_categories( $get_parent_cats );//get parent categories

				            foreach( $all_categories as $single_category ){
				                //for each category, get the ID
				                $catID = $single_category->cat_ID;

								//echo '<li><h1>' . $single_category->name . '</h1>'; 
								echo '<li class="inner-li"><div class="inner-category"><a data-cat="' . strtolower(str_replace(" ","-", $single_category->name)) . '" href="javascript:void(0)">' . $single_category->name . '</a></div>';
								//category name & link
								//echo '<ul class="post-title">';

				                $query = new WP_Query( array(
									'post_type' => 'products',
									'orderby' => 'title',
									'order' => 'ASC',
									'cat'=> $catID,
									'showposts' => -1,
									'category__in' => array($single_category->term_id),
									'caller_get_posts'=>1
								) );
								// Posts for the parent category (should be none)
				                while( $query->have_posts() ):$query->the_post();
								?>
					
								<?php
				                endwhile;
				                wp_reset_postdata();

				                //echo '</ul>';
				                $get_children_cats = array(
				                    'child_of' => $catID //get children of this parent using the catID variable from earlier
				                );

				                $child_cats = get_categories( $get_children_cats );//get children of parent category
				                echo '<ul class="children">';
				                    foreach( $child_cats as $child_cat ){
				                        //for each child category, get the ID
				                        $childID = $child_cat->cat_ID;

				                        //for each child category, give us the name
										if ( ($child_cat->category_parent > 3) ) :
											//echo '<h3>' . $child_cat->name . '</h3>';
											echo '<div class="inner-category inner-cat"><a data-cat="' . strtolower(str_replace(" ","-", $child_cat->name)) . '" href="javascript:void(0)">' . $child_cat->name . '</a></div>';
										else :
											//echo '<h2>' . $child_cat->name . '</h2>';
											echo '<div class="inner-category inner-cat"><a data-cat="' . strtolower(str_replace(" ","-", $child_cat->name)) . '" href="javascript:void(0)">' . $child_cat->name . '</a></div>';
										endif;

				                    }
				                echo '</ul></li>';
				            } //end of categories logic ?>
				</ul>
</div> <br> <br>
<!-- main filter ends -->
