<?php get_header(); ?>

	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
    <div id="categories-single"><?php the_category(", "); ?></div>
    <div id="headline-single"><?php the_title(); ?> <?php edit_post_link(__('Edit', 'gray_white_black'), '', ''); ?></div>
    <div class="full-post">
    
    <p class="post-meta"><span class="date"><a href="/<?php the_author_meta('user_login'); ?>"><?php the_author(); ?></a><br /><?php the_time( get_option( 'date_format' ) ) ?></span> <?php if ( comments_open() ) : ?>, <span class="comments"><?php comments_popup_link( _x( '0', 'comments number', 'gray_white_black' ), _x( '1', 'comments number', 'gray_white_black' ), _x( '%', 'comments number', 'gray_white_black' ) ); ?></span> <?php endif; ?> </p>
    </div>
    <div class="main">
	<div class="box full-post">
		
		
		
		<?php the_content(); ?>
		<?php wp_link_pages(array('before' => '<p class="pages"><strong>'.__('Pages', 'gray_white_black').':</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>
	</div>
	<?php if(has_tag()): ?>
	<div class="box tags">
		<p class="tags"><span><?php the_tags(""); ?></span></p>
	</div>
	<?php endif; ?>
		<p><?php posts_nav_link(); ?></p>

				

			<div id="comments" class="box comments"><?php comments_template();?></div>
	<?php endwhile; endif; ?>
</div>
<?php get_sidebar(); ?>
<?php get_footer(); ?>
