<header class="page-header alignwide">
	<?php the_archive_title( '<h1 class="page-title">', '</h1>' ); ?>
	<?php if ( get_the_archive_description() ) { ?>
		<div class="archive-description"><?php echo wp_kses_post( wpautop( get_the_archive_description() ) ); ?></div>
	<?php } ?>
</header>