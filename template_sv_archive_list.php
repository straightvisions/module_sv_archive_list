<?php
	// this class could be part of different products
	if(!class_exists('template_sv_archive_list')) {
		// complete template logic should be here
		class template_sv_archive_list extends \sv_core\abstract_template_sv_archive{
			protected function load_settings(): \sv_core\abstract_template_sv_archive{
				load_theme_textdomain( 'template_sv_archive_list', $this->get_path( 'languages' ) );

				$this->load_settings_common()
				->load_settings_entry()
				->load_settings_parts()
				->load_settings_extra_styles();

				foreach($this->get_parts() as $part => $properties){
					$this->load_settings_part($part);
				}

				return $this;
			}
			protected function load_settings_common(): template_sv_archive_list{
				$this->get_setting( 'font', __('Common', 'template_sv_archive_list') )
					->set_title( __( 'Font Family', 'template_sv_archive_list' ) )
					->set_description( __( 'Choose a font for your text.', 'template_sv_archive_list' ) )
					->set_options( $this->get_instance()->get_module( 'sv_webfontloader' ) ? $this->get_instance()->get_module( 'sv_webfontloader' )->get_font_options() : array('' => __('Please activate module SV Webfontloader for this Feature.', 'template_sv_archive_list')) )
					->set_is_responsive(true)
					->load_type( 'select' );

				$this->get_setting( 'font_size', __('Common', 'template_sv_archive_list') )
					->set_title( __( 'Font Size', 'template_sv_archive_list' ) )
					->set_description( __( 'Font Size in Pixel', 'template_sv_archive_list' ) )
					->set_is_responsive(true)
					->load_type( 'number' );

				$this->get_setting( 'line_height', __('Common', 'template_sv_archive_list') )
					->set_title( __( 'Line Height', 'template_sv_archive_list' ) )
					->set_description( __( 'Set line height as multiplier or with a unit.', 'template_sv_archive_list' ) )
					->set_is_responsive(true)
					->load_type( 'text' );

				$this->get_setting( 'text_color', __('Common', 'template_sv_archive_list') )
					->set_title( __( 'Text Color', 'template_sv_archive_list' ) )
					->set_is_responsive(true)
					->load_type( 'color' );

				$this->get_setting( 'bg_color', __('Common', 'template_sv_archive_list') )
					->set_title( __( 'Background Color', 'template_sv_archive_list' ) )
					->set_is_responsive(true)
					->load_type( 'color' );

				$this->get_setting( 'margin', __('Common', 'template_sv_archive_list') )
					->set_title( __( 'Margin', 'template_sv_archive_list' ) )
					->set_is_responsive(true)
					->set_default_value(
						array(
							'top'		=> '0',
							'right'		=> 'auto',
							'bottom'	=> '0',
							'left'		=> 'auto'
						)
					)
					->load_type( 'margin' );

				$this->get_setting( 'padding', __('Common', 'template_sv_archive_list') )
					->set_title( __( 'Padding', 'template_sv_archive_list' ) )
					->set_is_responsive(true)
					->set_default_value(
						array(
							'top'		=> '0',
							'right'		=> '22px',
							'bottom'	=> '0',
							'left'		=> '22px'
						)
					)
					->load_type( 'margin' );

				$this->get_setting( 'border', __('Common', 'template_sv_archive_list') )
					->set_title( __( 'Border', 'template_sv_archive_list' ) )
					->set_is_responsive(true)
					->load_type( 'border' );

				return $this;
			}
			protected function load_settings_entry(): template_sv_archive_list{
				$this->get_setting( 'entry_bg_color', __('Entry', 'template_sv_archive_list') )
					->set_title( __( 'Background Color', 'template_sv_archive_list' ) )
					->set_is_responsive(true)
					->load_type( 'color' );

				$this->get_setting( 'entry_margin', __('Entry', 'template_sv_archive_list') )
					->set_title( __( 'Margin', 'template_sv_archive_list' ) )
					->set_is_responsive(true)
					->set_default_value(
						array(
							'top'		=> '0',
							'right'		=> '0',
							'bottom'	=> '40px',
							'left'		=> '0'
						)
					)
					->load_type( 'margin' );

				$this->get_setting( 'entry_padding', __('Entry', 'template_sv_archive_list') )
					->set_title( __( 'Padding', 'template_sv_archive_list' ) )
					->set_is_responsive(true)
					->load_type( 'margin' );

				$this->get_setting( 'entry_border', __('Entry', 'template_sv_archive_list') )
					->set_title( __( 'Border', 'template_sv_archive_list' ) )
					->set_is_responsive(true)
					->load_type( 'border' );

				return $this;
			}
			protected function load_settings_parts(): template_sv_archive_list{
				$this->get_setting('show_header', __('Parts', 'template_sv_archive_list'))
					->set_title( __( 'Show Archive Header', 'template_sv_archive_list' ) )
					->set_description( __( 'Show or Hide this Template Part', 'template_sv_archive_list' ) )
					->set_default_value(1)
					->load_type( 'checkbox' );

				$this->get_setting('show_footer', __('Parts', 'template_sv_archive_list'))
					->set_title( __( 'Show Archive Footer', 'template_sv_archive_list' ) )
					->set_description( __( 'Show or Hide this Template Part', 'template_sv_archive_list' ) )
					->set_default_value(1)
					->load_type( 'checkbox' );

				$this->get_setting('show_empty', __('Parts', 'template_sv_archive_list'))
					->set_title( __( 'Show Notice when empty', 'template_sv_archive_list' ) )
					->set_description( __( 'Show or Hide this Template Part', 'template_sv_archive_list' ) )
					->set_default_value(1)
					->load_type( 'checkbox' );

				$this->get_setting('show_featured_image', __('Parts', 'template_sv_archive_list'))
					->set_title( __( 'Show Featured Image', 'template_sv_archive_list' ) )
					->set_description( __( 'Show or Hide this Template Part', 'template_sv_archive_list' ) )
					->set_default_value(1)
					->load_type( 'checkbox' );

				$this->get_setting('show_title', __('Parts', 'template_sv_archive_list'))
					->set_title( __( 'Show Title', 'template_sv_archive_list' ) )
					->set_description( __( 'Show or Hide this Template Part', 'template_sv_archive_list' ) )
					->set_default_value(1)
					->load_type( 'checkbox' );

				$this->get_setting('show_excerpt', __('Parts', 'template_sv_archive_list'))
					->set_title( __( 'Show Excerpt', 'template_sv_archive_list' ) )
					->set_description( __( 'Show or Hide this Template Part', 'template_sv_archive_list' ) )
					->set_default_value(1)
					->load_type( 'checkbox' );

				$this->get_setting('show_read_more', __('Parts', 'template_sv_archive_list'))
					->set_title( __( 'Show Read More', 'template_sv_archive_list' ) )
					->set_description( __( 'Show or Hide this Template Part', 'template_sv_archive_list' ) )
					->set_default_value(1)
					->load_type( 'checkbox' );

				$this->get_setting('show_author', __('Parts', 'template_sv_archive_pba_default'))
					->set_title( __( 'Show Author', 'template_sv_archive_pba_default' ) )
					->set_description( __( 'Show or Hide this Template Part', 'template_sv_archive_pba_default' ) )
					->set_default_value(1)
					->load_type( 'checkbox' );

				$this->get_setting('show_date', __('Parts', 'template_sv_archive_list'))
					->set_title( __( 'Show Date', 'template_sv_archive_list' ) )
					->set_description( __( 'Show or Hide this Template Part', 'template_sv_archive_list' ) )
					->set_default_value(1)
					->load_type( 'checkbox' );

				$this->get_setting('show_date_modified', __('Parts', 'template_sv_archive_list'))
					->set_title( __( 'Show Date Modified', 'template_sv_archive_list' ) )
					->set_description( __( 'Show or Hide this Template Part', 'template_sv_archive_list' ) )
					->set_default_value(0)
					->load_type( 'checkbox' );

				$this->get_setting('show_categories', __('Parts', 'template_sv_archive_list'))
					->set_title( __( 'Show Categories', 'template_sv_archive_list' ) )
					->set_description( __( 'Show or Hide this Template Part', 'template_sv_archive_list' ) )
					->set_default_value(1)
					->load_type( 'checkbox' );

				return $this;
			}
			protected function load_settings_part(string $part): template_sv_archive_list{
				$this->get_setting( $part.'_order', $part )
					->set_title( __( 'Order', 'template_sv_archive_list' ) )
					->set_description( __( 'Order part', 'template_sv_archive_list' ) )
					->set_options(
						array('' => __('Default', 'template_sv_archive_list'))
						+array_combine(
							range(1, count($this->get_parts())),
							range(1, count($this->get_parts()))
						)
					)
					->set_is_responsive(true)
					->load_type( 'select' );

				$this->get_setting( $part.'_font', $part )
					->set_title( __( 'Font Family', 'template_sv_archive_list' ) )
					->set_description( __( 'Choose a font for your text.', 'template_sv_archive_list' ) )
					->set_options( $this->get_instance()->get_module( 'sv_webfontloader' ) ? $this->get_instance()->get_module( 'sv_webfontloader' )->get_font_options() : array('' => __('Please activate module SV Webfontloader for this Feature.', 'template_sv_archive_list')) )
					->set_is_responsive(true)
					->load_type( 'select' );

				$this->get_setting( $part.'_font_size', $part )
					->set_title( __( 'Font Size', 'template_sv_archive_list' ) )
					->set_description( __( 'Font Size in Pixel', 'template_sv_archive_list' ) )
					->set_is_responsive(true)
					->load_type( 'number' );

				$this->get_setting( $part.'_line_height', $part )
					->set_title( __( 'Line Height', 'template_sv_archive_list' ) )
					->set_description( __( 'Set line height as multiplier or with a unit.', 'template_sv_archive_list' ) )
					->set_is_responsive(true)
					->load_type( 'text' );

				$this->get_setting( $part.'_text_color', $part )
					->set_title( __( 'Text Color', 'template_sv_archive_list' ) )
					->set_is_responsive(true)
					->load_type( 'color' );

				$this->get_setting( $part.'_bg_color', $part )
					->set_title( __( 'Background Color', 'template_sv_archive_list' ) )
					->set_is_responsive(true)
					->load_type( 'color' );

				$this->get_setting( $part.'_margin', $part )
					->set_title( __( 'Margin', 'template_sv_archive_list' ) )
					->set_is_responsive(true)
					->load_type( 'margin' );

				$this->get_setting( $part.'_padding', $part )
					->set_title( __( 'Padding', 'template_sv_archive_list' ) )
					->set_is_responsive(true)
					->load_type( 'margin' );

				$this->get_setting( $part.'_border', $part )
					->set_title( __( 'Border', 'template_sv_archive_list' ) )
					->set_is_responsive(true)
					->load_type( 'border' );

				$this->load_settings_part_default_values($part);

				return $this;
			}
			protected function load_settings_part_default_values(string $part): template_sv_archive_list{
				if(
					$part == 'featured_image'
					|| $part == 'title'
					|| $part == 'excerpt'
				){
					$this->get_setting( $part.'_margin', $part )->set_default_value(
						array(
							'top'		=> '0',
							'right'		=> '0',
							'bottom'	=> '20px',
							'left'		=> '0'
						)
					);
				}

				if($part == 'title'){
					$this->get_setting( $part.'_font_size', $part )->set_default_value(20);
				}

				if(
					$part == 'read_more'
				){
					$this->get_setting( $part.'_padding', $part )->set_default_value(
						array(
							'top'		=> '0',
							'right'		=> '10px',
							'bottom'	=> '0',
							'left'		=> '0'
						)
					);
				}

				if(
					$part == 'date'
				){
					$this->get_setting( $part.'_padding', $part )->set_default_value(
						array(
							'top'		=> '0',
							'right'		=> '10px',
							'bottom'	=> '0',
							'left'		=> '10px'
						)
					);
				}

				if(
					$part == 'categories'
				){
					$this->get_setting( $part.'_padding', $part )->set_default_value(
						array(
							'top'		=> '0',
							'right'		=> '0',
							'bottom'	=> '0',
							'left'		=> '10px'
						)
					);
				}

				return $this;
			}

		}

		// register template once
		add_filter('sv_core_templates_archive', function (array $archives) {
			// initialize template once
			$archives['template_sv_archive_list'] = array(
				'path'			=> trailingslashit(dirname(__FILE__)),
				'label'			=> __('List', 'template_sv_archive_list')
			);

			return $archives;
		});
	}