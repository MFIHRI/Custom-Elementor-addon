<?php
/**
 * @author  WpBean
 * @version 1.0
 */

namespace Elementor;


if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.

class Client_Fancy_List extends Widget_Base {

    public function get_name() {
        return 'fany-list-item';
    }

    public function get_title() {
        return esc_html__( 'Fancy List', 'client-custom-elementor-plugin-textdomain' );
    }

    public function get_icon() {
        return 'eicon-editor-list-ul';
    }

    public function get_categories() {
        return [ 'client_widgets' ];
    }

    protected function _register_controls() {

        $this->start_controls_section(
            'wpb_ea_fancy_list_details',
            [
                'label' => esc_html__( 'Fancy List', 'client-custom-elementor-plugin-textdomain' )
            ]
        );

        $this->add_control(
            'wpb_ea_fancy_lists',
            [
                'label'       => esc_html__( 'Lists', 'client-custom-elementor-plugin-textdomain' ),
                'type'        => \Elementor\Controls_Manager::REPEATER,
                'default'     => [
                    [ 'title' => esc_html__( 'Travel and Aviation Consulting', 'client-custom-elementor-plugin-textdomain' ) ],
                    [ 'title' => esc_html__( 'Business Services Consulting', 'client-custom-elementor-plugin-textdomain' ) ],
                    [ 'title' => esc_html__( 'Consumer Products Consulting', 'client-custom-elementor-plugin-textdomain' ) ]
                ],
                'fields'      => [
                    [
                        'type'          => \Elementor\Controls_Manager::TEXT,
                        'name'          => 'title',
                        'label_block'   => true,
                        'label'         => esc_html__( 'Content', 'client-custom-elementor-plugin-textdomain' ),
                        'default'       => esc_html__( 'List title', 'client-custom-elementor-plugin-textdomain' )
                    ],                  
                    [
                        'type'          => \Elementor\Controls_Manager::URL,
                        'name'          => 'link',
                        'label'         => esc_html__( 'Link', 'client-custom-elementor-plugin-textdomain' ),
                        'placeholder'   => esc_html__( 'https://yoursite.com', 'client-custom-elementor-plugin-textdomain' )
                    ]
                ],
                'title_field' => '{{title}}',
            ]
        );

        // extra CSS class
        $this->add_control(
            'extra_css',
            [   
                'label'         => esc_html__( 'Extra CSS clss', 'client-custom-elementor-plugin-textdomain' ),
                'type'          => Controls_Manager::TEXT,
                'description'   => esc_html__('Put your extra CSS class if you need.', 'client-custom-elementor-plugin-textdomain'),
                'placeholder'   => esc_html__( 'your-extra-css-class', 'client-custom-elementor-plugin-textdomain' )
            ]
        );       

        $this->end_controls_section();  

    }

    protected function render() {
        $settings  = $this->get_settings();
        $extra_css = $settings['extra_css'];
        if($extra_css){
            $extra_css = $extra_css.' ';
        }

        if( is_array( $settings['wpb_ea_fancy_lists'] ) ) : 
            echo '<ul class="'.esc_attr( $extra_css ).'wpb_ea_fancy_lists">'; 
                foreach ( $settings['wpb_ea_fancy_lists'] as $list ) : 

                    if ( $list['link']['url'] ) :
                        if ( $list['link']['is_external'] === 'on' ) {
                            $target = 'target= _blank';
                        } else {
                            $target = '';
                        }
                        if ( $list['link']['nofollow'] === 'on' ) {
                            $target .= ' rel= nofollow ';
                        }      
                        echo '<li class="single-list-item"><span class="wpb-ea-fancy-list-text"><a href="'. esc_url( $list['link']['url'] ) .'" '. esc_attr( $target ) .'>'. esc_html( $list['title'] ) .'</span></a></li>';
                    else :
                        echo '<li class="single-list-item"><span class="wpb-ea-fancy-list-text">'.esc_html( $list['title'] ) .'</span></li>';
                    endif;               
                endforeach; 
            echo '</ul>';
        endif; 
    }
}

Plugin::instance()->widgets_manager->register_widget_type( new Client_Fancy_List() );

