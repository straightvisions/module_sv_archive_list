<?php
	// this class could be part of different products
	if(!class_exists('template_sv_archive_list')) {
		// complete template logic should be here
		class template_sv_archive_list{
			private static $path		= '';
			private static $url			= '';

			private $instance			= false;
			private $setting_prefix		= '';

			private static $parts		= array();

			public function __construct($instance, string $setting_prefix){
				self::$parts		= array(
					'empty'					=> array(
						'loaded'			=> false,
						'label'				=> __('Empty', 'template_sv_archive_list')
					),
					'header'				=> array(
						'loaded'			=> false,
						'label'				=> __('Header', 'template_sv_archive_list')
					),
					'footer'				=> array(
						'loaded'			=> false,
						'label'				=> __('Footer', 'template_sv_archive_list')
					),
					'featured_image'		=> array(
						'loaded'			=> false,
						'label'				=> __('Featured Image', 'template_sv_archive_list')
					),
					'title'					=> array(
						'loaded'			=> false,
						'label'				=> __('Title', 'template_sv_archive_list')
					),
					'excerpt'				=> array(
						'loaded'			=> false,
						'label'				=> __('Excerpt', 'template_sv_archive_list')
					),
					'read_more'				=> array(
						'loaded'			=> false,
						'label'				=> __('Read More', 'template_sv_archive_list')
					),
					'date'					=> array(
						'loaded'			=> false,
						'label'				=> __('Date', 'template_sv_archive_list')
					),
					'date_modified'			=> array(
						'loaded'			=> false,
						'label'				=> __('Date Modified', 'template_sv_archive_list')
					),
					'categories'			=> array(
						'loaded'			=> false,
						'label'				=> __('Categories', 'template_sv_archive_list')
					)
				);

				// $instance is a SV-instance extending the SV core
				$this->set_instance($instance)->set_setting_prefix($setting_prefix)->load_settings();

				// templates are always within this path structure: /path-to-instance/path-to-object/lib/template-dir/
				self::$path				= trailingslashit($this->get_instance()->get_path('lib/'.get_class()));
				self::$url				= trailingslashit($this->get_instance()->get_url('lib/'.get_class()));

				foreach($this->get_parts() as $part => $properties){
					$this->get_instance()->get_script($this->get_prefix($part))
						//->set_is_no_prefix()
						->set_path($this->get_path('lib/common/parts/'.$part.'.css'), true, $this->get_url('lib/common/parts/'.$part.'.css'));
				}
			}
			private function load_settings(): template_sv_archive_list{
				$this->load_Settings_common();

				foreach($this->get_parts() as $part => $properties){
					$this->load_settings_parts($part);
				}

				return $this;
			}
			private function load_settings_common(): template_sv_archive_list{
				$this->get_setting('show_header')
					->set_title( __( 'Show Archive Header', 'sv100' ) )
					->set_description( __( 'Show or Hide this Template Part', 'sv100' ) )
					->set_default_value(1)
					->load_type( 'checkbox' );

				$this->get_setting('show_footer')
					->set_title( __( 'Show Archive Footer', 'sv100' ) )
					->set_description( __( 'Show or Hide this Template Part', 'sv100' ) )
					->set_default_value(1)
					->load_type( 'checkbox' );

				$this->get_setting('show_empty')
					->set_title( __( 'Show Notice when empty', 'sv100' ) )
					->set_description( __( 'Show or Hide this Template Part', 'sv100' ) )
					->set_default_value(1)
					->load_type( 'checkbox' );

				$this->get_setting('show_featured_image')
					->set_title( __( 'Show Featured Image', 'sv100' ) )
					->set_description( __( 'Show or Hide this Template Part', 'sv100' ) )
					->set_default_value(1)
					->load_type( 'checkbox' );

				$this->get_setting('show_title')
					->set_title( __( 'Show Title', 'sv100' ) )
					->set_description( __( 'Show or Hide this Template Part', 'sv100' ) )
					->set_default_value(1)
					->load_type( 'checkbox' );

				$this->get_setting('show_excerpt')
					->set_title( __( 'Show Excerpt', 'sv100' ) )
					->set_description( __( 'Show or Hide this Template Part', 'sv100' ) )
					->set_default_value(1)
					->load_type( 'checkbox' );

				$this->get_setting('show_read_more')
					->set_title( __( 'Show Read More', 'sv100' ) )
					->set_description( __( 'Show or Hide this Template Part', 'sv100' ) )
					->set_default_value(1)
					->load_type( 'checkbox' );

				$this->get_setting('show_date')
					->set_title( __( 'Show Date', 'sv100' ) )
					->set_description( __( 'Show or Hide this Template Part', 'sv100' ) )
					->set_default_value(1)
					->load_type( 'checkbox' );

				$this->get_setting('show_date_modified')
					->set_title( __( 'Show Date Modified', 'sv100' ) )
					->set_description( __( 'Show or Hide this Template Part', 'sv100' ) )
					->set_default_value(0)
					->load_type( 'checkbox' );

				$this->get_setting('show_categories')
					->set_title( __( 'Show Categories', 'sv100' ) )
					->set_description( __( 'Show or Hide this Template Part', 'sv100' ) )
					->set_default_value(1)
					->load_type( 'checkbox' );

				return $this;
			}
			private function load_settings_parts(string $part): template_sv_archive_list{
				$this->get_setting( $part.'_font' )
					->set_title( __( 'Font Family', 'sv100' ) )
					->set_description( __( 'Choose a font for your text.', 'sv100' ) )
					->set_options( $this->get_instance()->get_module( 'sv_webfontloader' ) ? $this->get_instance()->get_module( 'sv_webfontloader' )->get_font_options() : array('' => __('Please activate module SV Webfontloader for this Feature.', 'sv100')) )
					->set_is_responsive(true)
					->load_type( 'select' );

				$this->get_setting( $part.'_font_size' )
					->set_title( __( 'Font Size', 'sv100' ) )
					->set_description( __( 'Font Size in Pixel', 'sv100' ) )
					->set_is_responsive(true)
					->load_type( 'number' );

				$this->get_setting( $part.'_line_height' )
					->set_title( __( 'Line Height', 'sv100' ) )
					->set_description( __( 'Set line height as multiplier or with a unit.', 'sv100' ) )
					->set_is_responsive(true)
					->load_type( 'text' );

				$this->get_setting( $part.'_text_color' )
					->set_title( __( 'Text Color', 'sv100' ) )
					->set_is_responsive(true)
					->load_type( 'color' );

				$this->get_setting( $part.'_margin' )
					->set_title( __( 'Margin', 'sv100' ) )
					->set_is_responsive(true)
					->load_type( 'margin' );

				$this->get_setting( $part.'_padding' )
					->set_title( __( 'Padding', 'sv100' ) )
					->set_is_responsive(true)
					->load_type( 'margin' );

				$this->get_setting( $part.'_border' )
					->set_title( __( 'Border', 'sv100' ) )
					->set_is_responsive(true)
					->load_type( 'border' );

				return $this;
			}
			private function get_instance(){
				return $this->instance;
			}
			private function set_instance($instance): template_sv_archive_list{
				$this->instance	= $instance;

				return $this;
			}
			public function get_setting_prefix( string $suffix = ''): string{
				if( strlen( $suffix ) > 0 ) {
					$suffix = '_' . $suffix;
				}

				return $this->setting_prefix . $suffix;
			}
			private function set_setting_prefix(string $setting_prefix): template_sv_archive_list{
				$this->setting_prefix	= $setting_prefix;

				return $this;
			}
			private function get_setting( string $ID = ''){
				return $this->get_instance()->get_setting($this->get_setting_prefix($ID));
			}
			public function get_parts(): array{
				return self::$parts;
			}
			private function set_part_loaded(string $part): template_sv_archive_list{
				self::$parts[$part]['loaded']	= true;

				return $this;
			}
			private static function get_path( string $suffix = ''): string {
				return self::$path . $suffix;
			}
			private static function get_url( string $suffix = ''): string {
				return self::$url . $suffix;
			}
			private function get_prefix( string $suffix = ''): string {
				if( strlen( $suffix ) > 0 ) {
					$suffix = '_' . $suffix;
				}

				return get_class() . $suffix;
			}
			private function get_post_class( $class = '', $post_id = null ): string{
				// Separates classes with a single space, collates classes for post DIV.
				return 'class="' . esc_attr( implode( ' ', get_post_class( $class, $post_id ) ) ) . '"';
			}
			private function get_html(){
				ob_start();
				require(self::get_path('lib/tpl/frontend/loop.php'));
				return ob_get_clean();
			}
			public function get_output(){
				$output = $this->get_html();

				// register styles for each part in use
				foreach($this->get_parts() as $part => $properties){
					if($properties['loaded'] === true){
						$this->get_instance()->get_script($this->get_prefix($part))->set_is_enqueued();
					}
				}

				return $output;
			}
			private function get_part(string $part): string{
				if(boolval($this->get_setting('show_'.$part)->get_data()) !== true){
					return '';
				}

				$this->set_part_loaded($part);

				ob_start();
				require(self::get_path('lib/tpl/frontend/parts/'.$part.'.php'));
				return '<div class="'.$this->get_prefix($part).'">'.ob_get_clean().'</div>';

			}
		}

		// register template once
		add_filter('sv_core_templates_archive', function (array $archives) {
			// initialize template once
			$archives['template_sv_archive_list'] = array(
				'path'			=> trailingslashit(dirname(__FILE__)),
				'label'			=> __('List')
			);

			return $archives;
		});
	}