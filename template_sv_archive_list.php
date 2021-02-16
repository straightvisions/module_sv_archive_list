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
					'common'				=> array(
						'loaded'			=> true,
						'label'				=> __('Common', 'template_sv_archive_list')
					),
					'entry'					=> array(
						'loaded'			=> true,
						'label'				=> __('Entry', 'template_sv_archive_list')
					),
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
					$this->get_script($this->get_prefix($part))
						//->set_is_no_prefix()
						->set_path($this->get_path('lib/css/common/parts/'.$part.'.css'), true, $this->get_url('lib/css/common/parts/'.$part.'.css'));
				}

				$this->get_script('config')
					->set_path($this->get_path('lib/css/config/init.php'));

				$this->get_script('common')
					->set_path($this->get_path('lib/css/common/parts/common.css'));
			}
			private function load_settings(): template_sv_archive_list{
				$this->load_settings_common()
				->load_settings_entry()
				->load_settings_parts()
				->load_settings_extra_styles();

				foreach($this->get_parts() as $part => $properties){
					$this->load_settings_part($part);
				}

				return $this;
			}
			private function load_settings_common(): template_sv_archive_list{
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
			private function load_settings_entry(): template_sv_archive_list{
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
			private function load_settings_extra_styles(): template_sv_archive_list{
				$this->get_setting( 'extra_styles' )
					->set_title( __( 'Extra Styles', 'template_sv_archive_list' ) )
					->load_type( 'group' );

				$this->get_setting('extra_styles')
					->run_type()
					->add_child()
					->set_ID( 'entry_label' )
					->set_title( __( 'Style Label', 'template_sv_archive_list' ) )
					->set_description( __( 'A label to differentiate your Styles.', 'template_sv_archive_list' ) )
					->load_type( 'text' )
					->set_placeholder( __( 'Label', 'template_sv_archive_list' ) );

				$this->get_setting('extra_styles')
					->run_type()
					->add_child()
					->set_ID( 'slug' )
					->set_title( __( 'Slug', 'template_sv_archive_list' ) )
					->set_description( __( 'This slug is used for the helper classes.', 'template_sv_archive_list' ) )
					->load_type( 'text' );

				foreach($this->get_settings() as $setting) {
					if(strpos($setting->get_ID(), 'extra_styles') !== false) {
						continue;
					}
					if(strpos($setting->get_ID(), 'archive_') !== 0) {
						continue;
					}
					if($setting->get_ID() != 'extra_styles') {
						$this->get_setting('extra_styles')
							->run_type()
							->add_child($setting);
					}
				}

				return $this;
			}
			private function load_settings_parts(): template_sv_archive_list{
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
			private function load_settings_part(string $part): template_sv_archive_list{
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
			private function load_settings_part_default_values(string $part): template_sv_archive_list{
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
			private function get_script( string $ID = ''){
				return $this->get_instance()->get_script($this->get_prefix($this->get_setting_prefix($ID)));
			}
			private function get_setting( string $ID = '', string $cluster = ''){
				return $this->get_instance()->get_setting($this->get_setting_prefix($ID), $cluster);
			}
			private function get_settings(){
				return $this->get_instance()->get_settings();
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
				return 'class="'. $this->get_prefix('entry') . ' ' . esc_attr( implode( ' ', get_post_class( $class, $post_id ) ) ) . '"';
			}
			private function get_html(){
				ob_start();
				require(self::get_path('lib/tpl/frontend/loop.php'));
				return ob_get_clean();
			}
			public function get_output(): string{
				$output = $this->get_html();

				// register styles for each part in use
				foreach($this->get_parts() as $part => $properties){
					if($properties['loaded'] === true){
						$this->get_script($this->get_prefix($part))->set_is_enqueued();
					}
				}

				$script		= $this->get_script('config')
					->set_path(
						$this->get_instance()->get_path_cached(get_class().'/'.$this->get_setting_prefix().'/frontend.css'),
						true,
						$this->get_instance()->get_url_cached(get_class().'/'.$this->get_setting_prefix().'/frontend.css')
					)
					->set_is_enqueued();

				add_action( 'wp_footer', function() use($script) {
					$this->cache_config_css($script);
				}, 2 );

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
			// We want to serve cached CSS depending on active configuration
			private function cache_config_css(\sv_core\scripts $script): template_sv_archive_list{
				if ($script->get_css_cache_invalidated()) {
					ob_start();
					require($this->get_path('lib/css/config/init.php'));
					$css = ob_get_clean();

					file_put_contents($this->get_instance()->get_path_cached(get_class() . '/' . $this->get_setting_prefix() . '/frontend.css'), $css);

					$script->set_css_cache_invalidated(false);
				}
				return $this;
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