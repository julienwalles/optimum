<?php echo 'front-page.php' ?>


<?php get_header(); ?>

<div class="container">
	<h1><?php the_title(); ?></h1>
	<?php the_content(); ?>

	<aside class="col-md-4 sidebar">
		<ul>
			<?php dynamic_sidebar('homepage'); ?>
		</ul>
	</aside>
</div>
<?php get_footer(); ?>