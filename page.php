<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package [theme name]
 */

get_header();
?>

	<div class="container" style="padding:70px 0px;">
		<div class="row">
			<div class="col-md-12">
			<img src="<?php echo get_the_post_thumbnail_url(); ?>" alt="" style="width:100%">
			<h2 style="margin-top:30px"><?php the_title(); ?></h2>
			<br>
			<?php the_content(); ?>
			</div>
		</div>
	</div>

<?php
get_footer();
