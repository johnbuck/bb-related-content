<?php

class BBRelatedContentModuleClass extends FLBuilderModule {

    public function __construct()
    {
        parent::__construct(array(
            'name'            => __( 'Related Content Module', 'fl-builder' ),
            'description'     => __( 'Related Content Module', 'fl-builder' ),
            'category'        => __( 'Advanced Modules', 'fl-builder' ),
            'dir'             => BBRC_MODULES_DIR .'bb-related-content-module/',
            'url'             => BBRC_MODULES_URL .'bb-related-content-module/',
            'editor_export'   => true, // Defaults to true and can be omitted.
            'enabled'         => true, // Defaults to true and can be omitted.
            'partial_refresh' => false, // Defaults to false and can be omitted.
        ));

        $this->add_css( 'bbrc-css', $this->url .'css/frontend.css' );
        $this->add_js( 'brcc-js', $this->url .'js/frontend.js', array(), '', true );
    }

    public function load_posts( $settings )
    {

        $tax_query = array();

        if ( !empty($settings->rc_category_filters) ) {
            $tax_query[] = array(
                'taxonomy' => 'category',
                'field' => 'term_id',
                'terms' => $settings->rc_category_filters
            );
        }

        if ( !empty($settings->rc_tags_filters) ) {
            $tax_query[] = array(
                'taxonomy' => 'post_tag',
                'field' => 'term_id',
                'terms' => $settings->rc_tags_filters
            );
        }

        if ( count($tax_query) > 1 ) $tax_query['relation'] = 'AND';
        if ( count($tax_query) ) {
            $args['tax_query'] = $tax_query;
        }

        return get_posts( $args );
    }
}

function bbrc_get_acf_fields() {
	$groups = $fields = array();
	$groups = apply_filters('acf/get_field_groups', $groups);

	$fields[''] = '';

	if (!empty($groups)) {
		foreach( $groups as $group ) {
			$group_fields = apply_filters( 'acf/field_group/get_fields', array(), $group['id'] );
			if ( !empty($group_fields) ) {
				foreach( $group_fields as $group_field ) {
					$fields[ $group_field['name'] ] = $group_field['label'] . ' [ ACF ]';
				}
			}
		}
	}

	global $wpdb;

	$custom_keys = $wpdb->get_results("SELECT DISTINCT meta_key FROM {$wpdb->postmeta} ORDER BY meta_key", ARRAY_A);

	if ( !empty($custom_keys) ) {
		foreach( $custom_keys as $key ) {
			$key = $key['meta_key'];
			if ($key[0] == '_') continue;
			$fields[ $key ] = ucwords( str_replace('_', ' ', $key) );
		}
	}

	return $fields;
}


FLBuilder::register_module( 'BBRelatedContentModuleClass', array(
    'rc-tab-1' => array(
        'title' => __('Layout', 'fl-builder'),
        'sections' => array(
            'rc-section-1' => array(
                'fields' => array(
                    'rc_title' => array(
                        'type' => 'text',
                        'default' => __( 'Related Articles', 'fl-builder'),
                        'label' => __( 'Title', 'fl-builder')
                    ),
                    'rc_content_type' => array(
                        'type' => 'select',
                        'label' => __( 'Related Content Type', 'fl-builder'),
                        'default' => 'list',
                        'options' => array(
                            'list' => __( 'List', 'fl-builder' ),
                            'dropdown' => __( 'Dropdown', 'fl-builder' )
                        )
                    ),
                    'cta_type' => array(
	                    'type' => 'select',
	                    'default' => 'url',
	                    'label' => __( 'Target', 'fl-builder' ),
	                    'options' => array(
		                    'url' => __( 'Single Post', 'fl-builder' ),
		                    'custom' => __( 'Custom Field', 'fl-builder' ),
	                    ),
	                    'toggle' => array(
		                    'custom' => array(
			                    'fields' => array('cta_custom_field')
		                    )
	                    )
                    ),
                    'cta_custom_field' => array(
	                    'type' => 'select',
	                    'label' => __( 'Custom Field Link', 'fl-builder' ),
	                    'default' => '',
	                    'options' => bbrc_get_acf_fields()
                    ),
                    'posts_per_page' => array(
                        'type' => 'text',
                        'label' => __('Posts Per Page', 'fl-builder'),
                        'default' => '10',
                        'size' => '4'
                    ),
                    'rc_show_border' => array(
                        'type' => 'select',
                        'default' => '0',
                        'label' => __( 'Show border ?', 'fl-builder'),
                        'options' => array(
                            '0' => __( 'No', 'fl-builder' ),
                            '1' => __( 'Yes', 'fl-builder' )
                        )
                    ),
                    'rc_border_color' => array(
                        'type' => 'color',
                        'default' => '333333',
                        'label' => __( 'Border Color', 'fl-builder')
                    ),
                    'rc_border_width' => array(
                        'type' => 'text',
                        'default' => '0',
                        'label' => __( 'Border Width', 'fl-builder')
                    )
                )
            )
        )
    ),
    'content' => array(
        'title' => __('Content', 'fl-builder'),
        'file' => FL_BUILDER_DIR . 'includes/loop-settings.php',
    )
) );