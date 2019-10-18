<?php
/**
 * @author  WpBean
 * @version 1.0
 */
namespace Elementor;
if (!defined('ABSPATH') ) exit; // If this file is called directly, abort.
class Client_Service_Box_Two extends Widget_Base {
public function get_name() {
return 'wpb-ea-service-box-two';
    }

public function get_title() {
return esc_html__('Service Box 2', 'client-custom-elementor-plugin-textdomain' );
    }

    public function get_icon() {
        return 'eicon-info-box';
    }

    public function get_categories() {
        return [ 'client_widgets' ];
    }

    protected function _register_controls() {

        // video popup section
        $this->start_controls_section(
            'client_video_popup_widget',
            [
                'label' => esc_html__( 'Service Box 2', 'client-custom-elementor-plugin-textdomain' )
            ]
        );

        $this->add_control(
            'title',
            [
                'type'        => \Elementor\Controls_Manager::TEXT,
                'label'       => esc_html__( 'Title', 'client-custom-elementor-plugin-textdomain' ),
                'default'     => esc_html__( 'COMMERCIAL', 'client-custom-elementor-plugin-textdomain' )
            ]
        );

        // video popup background image
        $this->add_control(
            'image',
            [
                'label'     => esc_html__( 'Image', 'client-custom-elementor-plugin-textdomain' ),
                'type'      => Controls_Manager::MEDIA,
                'default'   => [
                    'url'   => Utils::get_placeholder_image_src()
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Image_Size::get_type(),
            [
                'name'      => 'image', // Actually its `image_size`.
                'default'   => 'full'
            ]
        );

        $this->add_control(
            'content',
            [
                'type'        => \Elementor\Controls_Manager::WYSIWYG,
                'label'       => esc_html__( 'Content', 'client-custom-elementor-plugin-textdomain' ),
            ]
        );

        $this->add_control(
            'shortcode',
            [
                'type'        => \Elementor\Controls_Manager::TEXT,
                'label'       => esc_html__('ShortCode', 'client-custom-elementor-plugin-textdomain' ),
                'placeholder' => esc_html__( '[products]', 'client-custom-elementor-plugin-textdomain' ),
                'description' => esc_html__( 'Put your shortcode here. Example: [products]', 'client-custom-elementor-plugin-textdomain' )
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
                'label'         => esc_html__('Button Link', 'client-custom-elementor-plugin-textdomain' ),
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
                'label'         => esc_html__('Extra CSS clss', 'client-custom-elementor-plugin-textdomain' ),
                'type'          => Controls_Manager::TEXT,
                'description'   => esc_html__( 'Put your extra CSS class if you need.', 'client-custom-elementor-plugin-textdomain' ),
                'placeholder'   => esc_html__('your-extra-css-class', 'client-custom-elementor-plugin-textdomain' )
            ]
        );   

        $this->end_controls_section();    
    }


    protected function render() {
        $settings  = $this->get_settings();
        $title = $settings['title'];
        $content = $settings['content'];
        $sCode = $settings['shortcode'];
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

        echo '<div class="'.esc_attr( $extra_css ).'crystal-service-items service-box-2">';
            echo '<div class="wd-section-blog-services text-center style-3">';
                echo '<div class="wd-blog-post nohover">';
                    $title ? printf( '<h4 class="wd-title-element">%s</h4>', esc_html( $title ) ) : '';
                    if ( ! empty( $settings['image']['url'] ) ) {
                        echo '<figure class="featured-thumbnail">';
                            echo '<div class="about-us-main-image">';
                                echo Group_Control_Image_Size::get_attachment_image_html( $settings );
                            echo '</div>';
                        echo '</figure>';
                    }   
                    echo $content;
                    // echo do_shortcode('[my_sample_shortcode]');
                    if ($sCode) {
                        echo do_shortcode($sCode);
                    } 
                    echo '<a class="learn-more-btn" href="'.esc_url($settings['btn_url']['url']).'" '.esc_attr($target).'>'.esc_html($settings['button_text']).'</a>';
                echo '</div>';
            echo '</div>';
        echo '</div>';

    }
}

Plugin::instance()->widgets_manager->register_widget_type( new Client_Service_Box_Two() );
