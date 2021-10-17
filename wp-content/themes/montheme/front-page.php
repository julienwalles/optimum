<?php echo 'front-page.php' ?>


<?php get_header(); ?>

<div class="container">
	<h1><?php the_title(); ?></h1>
	<?php the_content(); ?>

	<aside class="col-md-3 bg-light">	
			<?php get_sidebar('homepage'); ?>	
	</aside>
</div>
<?php get_footer(); ?>