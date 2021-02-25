<?php

	// Common
	$settings = $this->get_settings();
	$settings = reset($settings);

	echo $settings->build_css(
		'.template_sv_archive_list_wrapper',
		array_merge(
			$this->get_setting('font')->get_css_data('font-family'),
			$this->get_setting('font_size')->get_css_data('font-size','','px'),
			$this->get_setting('line_height')->get_css_data('line-height'),
			$this->get_setting('text_color')->get_css_data(),
			$this->get_setting('bg_color')->get_css_data('background-color'),
			$this->get_setting('padding')->get_css_data('padding'),
			$this->get_setting('margin')->get_css_data(),
			$this->get_setting('border')->get_css_data()
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

	// Parts
	foreach($this->get_parts() as $part => $properties){
		if($part == 'common' || $part == 'entry'){
			continue;
		}

		if($properties['loaded'] === false){
			continue;
		}

		echo $settings->build_css(
			'.template_sv_archive_list_'.$part,
			array_merge(
				$this->get_setting($part.'_order')->get_css_data('order'),
				$this->get_setting($part.'_bg_color')->get_css_data('background-color'),
				$this->get_setting($part.'_padding')->get_css_data('padding'),
				$this->get_setting($part.'_margin')->get_css_data(),
				$this->get_setting($part.'_border')->get_css_data()
			)
		);
		echo $settings->build_css(
			'.template_sv_archive_list_'.$part, '.template_sv_archive_list_'.$part.' *, .template_sv_archive_list_'.$part.' *:hover',
			array_merge(
				$this->get_setting($part.'_font')->get_css_data('font-family'),
				$this->get_setting($part.'_font_size')->get_css_data('font-size','','px'),
				$this->get_setting($part.'_line_height')->get_css_data('line-height'),
				$this->get_setting($part.'_text_color')->get_css_data()
			)
		);
	}