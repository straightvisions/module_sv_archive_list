<?php
	$categories = get_the_category();
	$separator  = ',&nbsp;';
	$output	 = '';

	if ( ! empty( $categories ) ) {
		foreach ( $categories as $category ) {
			$output .= '<a href="' . esc_url( get_category_link( $category->term_id ) ) . '" title="'
				. esc_attr( sprintf( __( 'View all posts in %s', 'template_sv_archive_list' ), $category->name ) ) .
				'" class="' . $this->get_prefix( 'category' ) .'">'
				. esc_html( $category->name ) . '</a>' . $separator;
		}

		echo trim( $output, $separator );
	}