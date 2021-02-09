<?php
	// this class could be part of different products
	if(!class_exists('template_sv_archive_list')) {
		// complete template logic should be here
		class template_sv_archive_list{
			private static $path		= '';
			private static $url			= '';

			private $instance			= false;
			private $settings			= array(
				'show_featured_image'	=> true,
				'show_title'			=> true,
				'show_excerpt'			=> true,
				'show_read_more'		=> true,
				'show_date'				=> true,
				'show_date_modified'	=> false,
				'show_categories'		=> true
			);
			private static $parts		= array(
				'featured_image'		=> false,
				'title'					=> false,
				'excerpt'				=> false,
				'read_more'				=> false,
				'date'					=> false,
				'date_modified'			=> false,
				'categories'			=> false
			);

			public function __construct($instance, array $settings = array()){
				// $instance is a SV-instance extending the SV core
				$this->set_instance($instance);

				// templates are always within this path structure: /path-to-instance/path-to-object/lib/template-dir/
				self::$path				= trailingslashit($this->get_instance()->get_path('lib/'.get_class()));
				self::$url				= trailingslashit($this->get_instance()->get_url('lib/'.get_class()));

				$this->settings			= array_merge($this->get_settings(),$settings);

				foreach($this->get_parts() as $part => $status){
					$this->get_instance()->get_script($this->get_prefix($part))
						//->set_is_no_prefix()
						->set_path($this->get_path('lib/common/parts/'.$part.'.css'), true, $this->get_url('lib/common/parts/'.$part.'.css'));
				}
			}
			private function get_instance(){
				return $this->instance;
			}
			private function set_instance($instance): template_sv_archive_list{
				$this->instance	= $instance;

				return $this;
			}
			private function get_settings(): array{
				return $this->settings;
			}
			private function get_setting(string $setting){
				return $this->get_settings()[$setting];
			}
			private function get_parts(): array{
				return self::$parts;
			}
			private function set_part(string $part): template_sv_archive_list{
				self::$parts[$part]	= true;

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
				foreach($this->get_parts() as $part => $status){
					if($status === true){
						$this->get_instance()->get_script($this->get_prefix($part))->set_is_enqueued();
					}
				}

				return $output;
			}
			private function get_part(string $part): string{
				if($this->get_setting('show_'.$part) !== true){
					return '';
				}

				$this->set_part($part);

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