js>>>>>>>>>>>>>>>>>>>>>>>>>>
/* fetching data from api */
function catFilter(val) {
	
         // adding rest api path
	const api_url = "http://localhost/[sitename]/wp-json/wp/v2/[posttype_name]/?categories="+val+"&_embed&per_page=100";
	
	// function to get the data from api
	async function getapi(url) {
		const response = await fetch(url);
		var data = await response.json();
		//console.log(data);
		if (response) {
			hideloader();
		}
		show(data);
	}
	
         // api call functio calling
	getapi(api_url);
	
        // managing preloader
	function hideloader() {
		document.getElementById('loading').style.display = 'none';
	}
	
	// function to show the date into html
	function show(data) {
		document.getElementById("results").innerHTML = "";
		for (let i = 0; i < data.length; i++) {
			title = data[i].title.rendered;
			thumb = data[i]._embedded['wp:featuredmedia']['0'].media_details.sizes.full.source_url;
			link = data[i].link;
			
			tab = `<a href='${data[i].link}'>
			<div class='thumb-inner'><img src='${data[i]._embedded['wp:featuredmedia']['0'].media_details.sizes.full.source_url}' alt='${data[i].title.rendered}'></div>
			<div class='title-inner'>${data[i].title.rendered}</div>
			</a>`;
			document.getElementById("results").innerHTML += tab;
		}
  }

}

// managing tabbed category filter in frontend - fetching category id
$(".cat-selector").on("click",function(){
	//calling function for fetching data from api
	var attVal = $(this).attr("data-value");
	catFilter(attVal);

	$(".cat-selector").removeClass("active");
	$(this).addClass("active");
});




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



