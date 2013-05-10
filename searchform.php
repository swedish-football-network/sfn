<form method="get" class="searchform" id="searchform" action="<?php echo home_url(); ?>">
<fieldset>
	<input type="text" value="<?php the_search_query(); ?>" name="s" id="s" /><button type="submit" name="searchsubmit" value="<?php _e('Search', 'gray_white_black') ?>"></button>
</fieldset>
</form>