<?php /* Start loop */ ?>
<?php while (have_posts()) : the_post(); ?>
	<article <?php post_class() ?> id="post-<?php the_ID(); ?>">
		<div class="post-image"><?php the_post_thumbnail( $post->ID, 'large'); ?></div>
		<div class="entry-content">
			<header class="article-header">
				<h1 class="entry-title"><?php the_title(); ?></h1>
			</header>
			<?php the_content(); ?>
		</div>
		<footer>
			<div class="byline">
				<h4 class="alignleft">Om <?php echo the_author_meta('first_name'); ?></h4>
				<a href="<?php echo get_author_posts_url(get_the_author_meta( 'ID' )); ?>" class="img">
    				<?php echo get_avatar( get_the_author_meta( 'user_email' ), 90, '', get_the_author_meta( 'display_name', $id )); ?>
  				</a>
				<div class="byline-text">
					<p><?php echo get_the_author_meta( 'description' );?></p>
				</div>
			</div>
		</footer>
		<?php comments_template(); ?>
	</article>
<?php endwhile; // End the loop ?>