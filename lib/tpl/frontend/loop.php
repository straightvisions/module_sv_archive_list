<?php
	while ( have_posts() ) {
		the_post();

		echo '<article id="post-'.get_the_ID().'" '.$this->get_post_class().'>';
			echo $this->get_part('featured_image');
			echo $this->get_part('title');
			echo $this->get_part('excerpt');
			echo $this->get_part('read_more');
			echo $this->get_part('date');
			echo $this->get_part('date_modified');
			echo $this->get_part('categories');
		echo '</article>';

		wp_reset_postdata();
	}