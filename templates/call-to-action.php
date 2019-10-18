<?php
/**
 * @author  WpBean
 * @version 1.0
 */

namespace Elementor;


if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.

class Client_Call_To_Action_A extends Widget_Base {

    public function get_name() {
        return 'wpb-ea-video-popup';
    }

    public function get_title() {
        return esc_html__( 'Call to action', 'client-custom-elementor-plugin-textdomain' );
    }

    public function get_icon() {
        return 'eicon-call-to-action';
    }

    public function get_categories() {
        return [ 'client_widgets' ];
    }

    protected function _register_controls() {

        // video popup section
        $this->start_controls_section(
            'client_video_popup_widget',
            [
                'label' => esc_html__( 'Call to Action', 'client-custom-elementor-plugin-textdomain' )
            ]
        );

        $this->add_control(
            'call_to_action_style_type',
            [
                'label'             => esc_html__( 'Style Type', 'xt-muscletech-cpt-shortcode' ),
                'type'              => Controls_Manager::SELECT,
                'default'           => 'style-1',
                'options'           => [
                    'style-1'        => esc_html__( 'Style 1', 'xt-muscletech-cpt-shortcode' ),
                    'style-2'        => esc_html__( 'Style 2', 'xt-muscletech-cpt-shortcode' )
                ]
            ]
        );

        // video popup background image
        $this->add_control(
            'image',
            [
                'label'     => esc_html__( 'Choose Background Image', 'client-custom-elementor-plugin-textdomain' ),
                'type'      => Controls_Manager::MEDIA,
                'condition'     => [
                    '.call_to_action_style_type' => 'style-1'
                ],
                'default'   => [
                    'url'   => Utils::get_placeholder_image_src()
                ]
            ]
        );
        




        $this->add_control(
            'call_to_action_text',
            [   
                'label'         => esc_html__( 'Content', 'client-custom-elementor-plugin-textdomain' ),
                'type'          => Controls_Manager::WYSIWYG,
                'default'       => esc_html__( 'Lorem ipsum dolor sit amet conse ctetur adipisi cing elit eiusmod</strong> Lorem ipsum dolor sit amet conse ctetur adipisicing elit, sed do eiusmod tempor incididunt. Lorem ipsum dolor sit amet conse.', 'client-custom-elementor-plugin-textdomain' )
            ]
        );

        $this->add_control(
            'button_text',
            [
                'type'        => \Elementor\Controls_Manager::TEXT,
                'label'       => esc_html__( 'Button Text', 'client-custom-elementor-plugin-textdomain' ),
                'placeholder' => esc_html__( 'Read More', 'client-custom-elementor-plugin-textdomain' ),
                'default'     => esc_html__( 'Read More', 'client-custom-elementor-plugin-textdomain' )
            ]
        );

        $this->add_control( 
            'btn_url',
            [
                'label'         => esc_html__( 'Button Link', 'client-custom-elementor-plugin-textdomain' ),
                'type'          => Controls_Manager::URL,
                'label_block'   => true,
                'default'       => [
                    'url'       => '#',
                    'is_external' => ''
                ],
                'show_external' => true
            ]
        );

        $this->add_control(
            'extra_css',
            [   
                'label'         => esc_html__( 'Extra CSS clss', 'client-custom-elementor-plugin-textdomain' ),
                'type'          => Controls_Manager::TEXT,
                'description'   => esc_html__( 'Put your extra CSS class if you need.', 'client-custom-elementor-plugin-textdomain' ),
                'placeholder'   => esc_html__( 'your-extra-css-class', 'client-custom-elementor-plugin-textdomain' )
            ]
        );   

        $this->end_controls_section();  

        $this->start_controls_section(
            'wpb_ea_pricing_table_style_section',
            [
                'label'         => esc_html__('Pricing Table Style', 'wpb-elementor-addons'),
                'tab'           => Controls_Manager::TAB_STYLE
            ]
        );  

        // video popup background image size
        $this->add_group_control(
            Group_Control_Image_Size::get_type(),
            [
                'name'      => 'image', // Actually its `image_size`.
                'default'   => 'medium_large',
                'condition'     => [
                    '.call_to_action_style_type' => 'style-1'
                ]
            ]
        );

        $this->add_control(
            'call_to_action_bg_overlay_color',
            [
                'label'         => esc_html__( 'Background Overlay Color', 'client-custom-elementor-plugin-textdomain' ),
                'type'          => \Elementor\Controls_Manager::COLOR,             
                'default'       => 'rgba(0,0,0,.1)',
                'condition'     => [
                    '.call_to_action_style_type' => 'style-1'
                ],
                'selectors'     => [
                    '{{WRAPPER}} .banner-wrap.extra .featured-thumbnail .about-us-main-image:before' => 'background-color: {{VALUE}};'
                ]            
            ]
        );

        $this->add_control(
            'call_to_action_padding',
            [
                'label'         => esc_html__( 'Padding', 'wpb-elementor-addons' ),
                'type'          => \Elementor\Controls_Manager::DIMENSIONS,
                'selectors'     => [
                    '{{WRAPPER}} .banner-wrap.extra' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $this->end_controls_section();      
    }


    protected function render() {
        $settings  = $this->get_settings();
        $style = $settings['call_to_action_style_type'];
        $content = $settings['call_to_action_text'];
        $extra_css = $settings['extra_css'];
        if($extra_css){
            $extra_css = $extra_css.' ';
        }

        if ( $settings['btn_url']['is_external'] === 'on' ) {
            $target = 'target= _blank';
        } else {
            $target = '';
        }
        if ( $settings['btn_url']['nofollow'] === 'on' ) {
            $target .= ' rel= nofollow ';
        }   

        echo '<div class="'.esc_attr( $extra_css ).'banner-wrap extra '.esc_attr($style).'">';
            if ( ! empty( $settings['image']['url'] ) && ( $style == 'style-1' ) ) {
                echo '<figure class="featured-thumbnail">';
                    echo '<div class="about-us-main-image">';
                        echo Group_Control_Image_Size::get_attachment_image_html( $settings );
                    echo '</div>';
                echo '</figure>';
            }    
            echo '<div class="call-to-action-content">';
                echo '<div class="call-to-action-content">';
                    echo wp_kses_post($content);
                echo '</div>';
                if ( ! empty( $settings['button_text'] ) ) :
                    echo '<div class="link-align banner-btn">';
                        echo '<a href="'.esc_url($settings['btn_url']['url']).'" '.esc_attr($target).'>'.esc_html($settings['button_text']).'</a>';
                    echo '</div>';
                endif;
            echo '</div>';
        echo '</div>';

    }
}

Plugin::instance()->widgets_manager->register_widget_type( new Client_Call_To_Action_A() );

