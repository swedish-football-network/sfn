<?php get_header(); ?>
<div class="main">
	<?php if (have_posts()) : $first = true; ?>

		<?php $post = $posts[0]; // Hack. Set $post so that the_date() works. ?>
		<?php /* If this is a category archive */ if (is_category()) { ?>
		  <h1><?php single_cat_title(); ?></h1>
		<?php /* If this is a tag archive */ } elseif( is_tag() ) { ?>
		  <h1><?php single_tag_title(); ?></h1>
		<?php /* If this is a daily archive */ } elseif (is_day()) { ?>
		  <h1><?php echo get_the_time('F jS, Y'); ?></h1>
		<?php /* If this is a monthly archive */ } elseif (is_month()) { ?>
		  <h1><?php echo get_the_time('F, Y'); ?></h1>
		<?php /* If this is a yearly archive */ } elseif (is_year()) { ?>
		  <h1><?php echo get_the_time('Y'); ?></h1>
		<?php /* If this is an author archive */ } elseif (is_author()) { ?>
		  <h1><?php _e( 'Author Archive', 'gray_white_black' ); ?></h1>
		<?php /* If this is a paged archive */ } elseif (isset($_GET['paged']) && !empty($_GET['paged'])) { ?>
		  <h1><?php _e( 'Blog Archives', 'gray_white_black' ); ?></h1>
		<?php } ?>

		<ul class="post-list">
		<?php while (have_posts()) : the_post();
			if($first) $class = "first-in-row";
			else $class="";
			$first = !$first;
			?>
			<!-- Start: Post -->
			<li <?php post_class($class); ?>>
				<?php the_post_thumbnail(); ?>
				<p class="categories"><?php the_category(", "); ?></p>
				<h2><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a> <?php edit_post_link(__('Edit', 'gray_white_black'), '', ''); ?></h2>
				<p class="post-meta"><span class="date"><?php the_time( get_option( 'date_format' ) ) ?></span> <?php if ( comments_open() ) : ?>, <span class="comments"><?php comments_popup_link( _x( '0', 'comments number', 'gray_white_black' ), _x( '1', 'comments number', 'gray_white_black' ), _x( '%', 'comments number', 'gray_white_black' ) ); ?></span> <?php endif; ?> <span class="author"><?php the_author() ?></span></p>
				<?php the_excerpt(); ?>
				<p class="more"><a href="<?php the_permalink() ?>"><?php _e( '&raquo;&raquo; ', 'gray_white_black' );?></a></p>
				<?php if(has_tag()): ?><p class="tags"><span><?php the_tags(""); ?></span></p><?php endif; ?>
			</li>
			<!-- End: Post -->
		<?php endwhile; ?>
		</ul>

		<p class="pagination">
			<span class="prev"><?php next_posts_link(__('&laquo; Previous Posts', 'gray_white_black')) ?></span>
			<span class="next"><?php previous_posts_link(__('Next posts &raquo;', 'gray_white_black')) ?></span>
		</p>

	<?php else : ?>
		<h2><?php _e( 'Not found', 'gray_white_black' ); ?></h2>
		<p><?php _e( 'Sorry, but you are looking for something that isn\'t here.', 'gray_white_black' ); ?></p>
		<?php get_search_form(); ?>
	<?php endif; ?>
</div>
<?php get_sidebar(); ?>

<?php get_footer(); ?>
