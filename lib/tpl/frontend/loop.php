<?php
	$has_sidebar		= array(
		'top'			=> $this->has_sidebar('top')    ? $this->get_prefix('has_sidebar_top') : '',
		'right'			=> $this->has_sidebar('right')  ? $this->get_prefix('has_sidebar_right') : '',
		'bottom'		=> $this->has_sidebar('bottom') ? $this->get_prefix('has_sidebar_bottom') : '',
		'left'			=> $this->has_sidebar('left')   ? $this->get_prefix('has_sidebar_left') : ''
	);

	echo $this->get_part('header');
	echo '<div class="'.$this->get_prefix('wrapper').' '.implode(' ', $has_sidebar).'">';
	do_action('loop_start', $wp_query);
	echo $this->get_part('sidebar_top');
	echo $this->get_part('sidebar_left');
	echo '<div class="'.$this->get_prefix('content').'">';

	if ( have_posts() ) {
		while ( have_posts() ) {
			the_post();

			echo '<article id="post-'.get_the_ID().'" '.$this->get_post_class().'>';
				echo $this->get_part('featured_image');
				echo $this->get_part('title');
				echo $this->get_part('excerpt');
				echo $this->get_part('read_more');
				echo $this->get_part('author');
				echo $this->get_part('date');
				echo $this->get_part('date_modified');
				echo $this->get_part('categories');
			echo '</article>';

			wp_reset_postdata();
		}
	}else{
		echo $this->get_part('empty');
	}

	echo '</div>';
	echo $this->get_part('sidebar_right');
	echo $this->get_part('sidebar_bottom');
	echo '</div>';
	echo $this->get_part('footer');