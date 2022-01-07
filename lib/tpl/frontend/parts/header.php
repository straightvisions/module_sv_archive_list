<header class="page-header">
	<?php
		if(is_search()){
			echo '<h1 class="page-title">'; printf( esc_html__( 'Search Results for: %s', 'sv100' ), '<span>' . get_search_query() . '</span>' ); echo '</h1>';
		}else {
			the_archive_title('<h1 class="page-title">', '</h1>');
		}
		?>
	<?php if ( get_the_archive_description() ) { ?>
		<div class="archive-description"><?php echo wp_kses_post( wpautop( get_the_archive_description() ) ); ?></div>
	<?php } ?>
</header>