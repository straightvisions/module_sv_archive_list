<header class="page-header">
	<?php
		$featured_image		= get_term_meta( get_queried_object()->term_id, 'sv100_companion_sv_categories_featured_image', true );

		if($featured_image) {
			echo '<div class="'.$this->get_prefix('featured_image').'">'.wp_get_attachment_image($featured_image, 'large').'</div>';
		}

		if(is_search()){
			echo '<h1 class="page-title">'; printf( esc_html__( 'Search Results for: %s', 'sv100' ), '<span>' . get_search_query() . '</span>' ); echo '</h1>';
		}else {
			the_archive_title('<h1 class="page-title">', '</h1>');
		}

		if ( get_the_archive_description() ) {
			echo '<div class="archive-description">'. wp_kses_post( wpautop( get_the_archive_description() ) ).'</div>';
		}
		?>
</header>