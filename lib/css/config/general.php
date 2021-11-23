<?php

	// Common
	$settings = $this->get_settings();
	$settings = reset($settings);


	echo $settings->build_css(
		'.sv100_sv_archive',
		array_merge(
			$this->get_setting('max_width_wrapper_outer')->get_css_data('max-width')
		)
	);

	// maybe stack
	$stack_active					= $this->get_setting('stack_active');
	$properties						= array();

	// column or row
	$stack							= array_map(function ($val) { return $val ? 'column' : 'row'; }, $stack_active->get_data());
	$properties['flex-direction']	= $stack_active->prepare_css_property_responsive($stack,'','');

	echo $settings->build_css(
		'.template_sv_archive_list_wrapper',
		$properties
	);

	// maybe stack
	$column_spacing					= intval($this->get_setting( 'column_spacing' )->get_data());
	$properties						= array();

	// column or row
	$stack							= array_map(function ($val) { return $val ? 'column' : 'row'; }, $stack_active->get_data());
	$properties['flex-direction']	= $stack_active->prepare_css_property_responsive($stack,'','');

	// max width
	$stack							= array_map(function ($val) use($column_spacing) { return $val ? 'calc(100%)' : 'calc(70% - '.$column_spacing.'px)'; }, $stack_active->get_data());
	$properties['flex-basis']		= $stack_active->prepare_css_property_responsive($stack,'','');

	echo $settings->build_css(
		'.template_sv_archive_list_content',
		$properties
	);

	// max width
	$stack							= array_map(function ($val) use($column_spacing) { return $val ? 'calc(100% - '.$column_spacing.'px)' : 'calc(50% - '.ceil($column_spacing / 2).'px)'; }, $stack_active->get_data());
	$properties['flex-basis']		= $stack_active->prepare_css_property_responsive($stack,'','');

	echo $settings->build_css(
		'.template_sv_archive_list_entry',
		$properties
	);

	echo $settings->build_css(
		'.template_sv_archive_list_wrapper',
		array_merge(
			$this->get_setting('font')->get_css_data('font-family'),
			$this->get_setting('font_size')->get_css_data('font-size','','px'),
			$this->get_setting('line_height')->get_css_data('line-height'),
			$this->get_setting('text_color')->get_css_data(),
			$this->get_setting('bg_color')->get_css_data('background-color'),
			$this->get_setting('padding')->get_css_data('padding'),
			$this->get_setting('border')->get_css_data(),
			$this->get_setting('margin')->get_css_data()
		)
	);

	echo $settings->build_css(
		'.template_sv_archive_list_wrapper, .template_sv_archive_list_header > header',
		array_merge(
			$this->get_setting('max_width_wrapper_inner')->get_css_data('max-width')
		)
	);

	echo $settings->build_css(
		'.template_sv_archive_list_entry',
		array_merge(
			$this->get_setting('entry_bg_color')->get_css_data('background-color'),
			$this->get_setting('entry_padding')->get_css_data('padding'),
			$this->get_setting('entry_margin')->get_css_data(),
			$this->get_setting('entry_border')->get_css_data()
		)
	);

	// Header
	echo $settings->build_css(
		'.template_sv_archive_list_header',
		array_merge(
			$this->get_setting('header_bg_color')->get_css_data('background-color'),
			$this->get_setting('header_padding')->get_css_data('padding'),
			$this->get_setting('header_border')->get_css_data()
		)
	);
	echo $settings->build_css(
		'.template_sv_archive_list_header header',
		array_merge(
			$this->get_setting('header_margin')->get_css_data()
		)
	);
	echo $settings->build_css(
		'.template_sv_archive_list_header header > *',
		array_merge(
			$this->get_setting('header_font')->get_css_data('font-family'),
			$this->get_setting('header_font_size')->get_css_data('font-size','','px'),
			$this->get_setting('header_line_height')->get_css_data('line-height'),
			$this->get_setting('header_text_color')->get_css_data()
		)
	);

	// Parts
	foreach($this->get_parts() as $part => $properties){
		if($part == 'common' || $part == 'entry'  || $part == 'header'){
			continue;
		}

		if($properties['loaded'] === false){
			continue;
		}

		// Common
		echo $settings->build_css(
			'.template_sv_archive_list_'.$part.','.
			'.template_sv_archive_list_'.$part.' *',
			array_merge(
				$this->get_setting($part.'_font')->get_css_data('font-family'),
				$this->get_setting($part.'_font_size')->get_css_data('font-size','','px'),
				$this->get_setting($part.'_line_height')->get_css_data('line-height'),
				$this->get_setting($part.'_text_color')->get_css_data()
			)
		);

		// Common - Hover
		echo $settings->build_css(
			'.template_sv_archive_list_'.$part.':hover,'.
			'.template_sv_archive_list_'.$part.':hover *',
			array_merge(
				$this->get_setting($part.'_text_color_hover')->get_css_data()
			)
		);

		// Wrapper
		echo $settings->build_css(
			'.template_sv_archive_list_'.$part,
			array_merge(
				$this->get_setting($part.'_order')->get_css_data('order'),
				$this->get_setting($part.'_margin')->get_css_data()
			)
		);

		// First Level Child
		echo $settings->build_css(
			'.template_sv_archive_list_'.$part.' > *',
			array_merge(
				$this->get_setting($part.'_padding')->get_css_data('padding'),
				$this->get_setting($part.'_border')->get_css_data(),
				$this->get_setting($part.'_bg_color')->get_css_data('background-color')
			)
		);

		// First Level Child - Hover
		echo $settings->build_css(
			'.template_sv_archive_list_'.$part.':hover > *',
			array_merge(
				$this->get_setting($part.'_bg_color_hover')->get_css_data('background-color')
			)
		);
	}