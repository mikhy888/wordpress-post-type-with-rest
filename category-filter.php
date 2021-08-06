js>>>>>>>>>>>>>>>>>>>>>>>>>>
/* fetching data from api */
/* val is category id  */
function catFilter(val) {
	
	const api_url = "http://localhost/[sitename]/wp-json/wp/v2/products/?categories="+val+"&_embed";
	
	async function getapi(url) {
		const response = await fetch(url);
		var data = await response.json();
		//console.log(data);
		if (response) {
			hideloader();
		}
		show(data);
	}
	
	getapi(api_url);
 
  /*preloader hiding on load of items*/
	function hideloader() {
		document.getElementById('loading').style.display = 'none';
	}
	
	function show(data) {
		for (let r of data) {
			tab = `<div> 
    <div>${r.title.rendered} </div>
    <div><img src='${r._embedded['wp:featuredmedia']['0'].media_details.sizes.full.source_url}' alt='${r.slug}'></div>
    <div>${r.slug}</div>      
		</div>`;
		}
		document.getElementById("results").innerHTML = tab;
	}
}


/* PHP >>  fetching all the category names and ids */
<?php
    $args = array(
                'taxonomy' => 'category',
                'orderby' => 'name',
                'order'   => 'ASC'
            );
    $cats = get_categories($args);
    foreach($cats as $cat) {
  ?>
    <a href="javascript:;" data-value="<?php echo $cat->term_id; ?>" class="cat-selector">
            <?php echo $cat->name; ?>
        </a> <br> 
  <?php
    }
  ?>
<!-- displaying all the output items -->
<div id="results" class="filtered-contents"></div>



