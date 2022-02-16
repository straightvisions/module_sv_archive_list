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