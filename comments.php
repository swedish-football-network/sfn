
<?php
	/* This variable is for alternating comment background */
	$oddcomment = 'class="alt" ';
?>

<!-- You can start editing here. -->
<div class="comments">
	<?php if ( ! comments_open() & is_single() )  : ?><p><?php _e( 'Comments are disabled.', 'gray_white_black' ); ?></p><?php endif; ?>

	<?php if ($comments) : ?>
		<?php printf( _n( 'One thought on &ldquo;%2$s&rdquo;', '%1$s thoughts on &ldquo;%2$s&rdquo;', get_comments_number(), 'gray_white_black' ),
	number_format_i18n( get_comments_number() ), '<span>' . get_the_title() . '</span>' );?>
		<ul class="commentlist">
		<?php wp_list_comments(); ?>
		</ul>
	<?php endif; ?>

	<p><?php paginate_comments_links(); ?></p>
	<?php comment_form(); ?>
</div>