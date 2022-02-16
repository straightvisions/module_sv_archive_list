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

			protected function get_sidebar(string $position): string{
				if(!$this->get_instance()->get_module( 'sv_sidebar' )){
					return '';
				}
				if(strlen($this->get_instance()->get_active_archive_type()) === 0){
					return '';
				}

				return $this->get_instance()->get_module( 'sv_sidebar' )->load(
					$this->get_setting( 'show_sidebar_'.$position )->get_data()
				);
			}
			protected function has_sidebar(string $position): string{
				if(!$this->get_setting('show_sidebar_'.$position)->get_data()){
					return false;
				}

				if(strlen($this->get_sidebar($position)) === 0){
					return false;
				}

				return true;
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