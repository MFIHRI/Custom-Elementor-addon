<?php
namespace Elementor;
if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.
class Client_Service_Item_Widget extends Widget_Base {
    public function get_name() {
        return 'client_service_item';
    }

    public function get_title() {
        return esc_html__('Service Box', 'client-custom-elementor-plugin-textdomain' );
    }

    public function get_icon() {
        return 'eicon-info-box';
    }

    public function get_categories() {
        return [ 'client_widgets' ];
    }

    protected function _register_controls() {

        $this->start_controls_section(
            'client_service_content',
            [
                'label' => esc_html__('Service Box', 'client-custom-elementor-plugin-textdomain' )
            ]
        );

        // service item grid column
        $this->add_control(
            'column_settings',
            [
                'label'     => esc_html__( 'Columns', 'client-custom-elementor-plugin-textdomain' ),
                'type'      => Controls_Manager::SELECT,
                'default'   => 3,
                'options'   => [
                    6           => esc_html__( '6 Columns', 'client-custom-elementor-plugin-textdomain' ),
                    4           => esc_html__( '4 Columns', 'client-custom-elementor-plugin-textdomain' ),
                    3           => esc_html__( '3 Columns', 'client-custom-elementor-plugin-textdomain' ),
                    2           => esc_html__( '2 Columns', 'client-custom-elementor-plugin-textdomain' ),
                    1           => esc_html__( '1 Columns', 'client-custom-elementor-plugin-textdomain' )
                ]              
            ]
        );         

        $this->add_group_control(
            Group_Control_Image_Size::get_type(),
            [
                'name'          => 'image_size',
                'default'       => 'full',
                'label'         => esc_html__( 'PNG Icon Size', 'xt-donative-core' ),
        
            ]
        );  

        // service item field options
        $this->add_control(
            'service_items',
            [
                'label'         => esc_html__('Service Items', 'client-custom-elementor-plugin-textdomain'),
                'type'          => Controls_Manager::REPEATER,
                'default'       => [
                    [
                        'title'           => esc_html__( 'GOVERNMENT', 'client-custom-elementor-plugin-textdomain' )
                    ],
                    [
                        'title'           => esc_html__( 'RESIDENTIAL', 'client-custom-elementor-plugin-textdomain' )
                    ],
                    [
                        'title'           => esc_html__( 'COMMERCIAL', 'client-custom-elementor-plugin-textdomain' )
                    ]
                ],
                'fields' => [
                    [
                        'type'          => Controls_Manager::CHOOSE,
                        'name'          => 'icon_type',
                        'label_block'   => true,
                        'label'         => esc_html__( 'Type', 'client-custom-elementor-plugin-textdomain' ),
                        'default'       => 'icon',
                        'options'       => [                            
                            'icon'      => [
                                'title' => esc_html__( 'Icon', 'client-custom-elementor-plugin-textdomain' ),
                                'icon'  => 'fa fa-diamond',
                            ],
                            'png_icon'    => [
                                'title' => esc_html__( 'Image', 'client-custom-elementor-plugin-textdomain' ),
                                'icon'  => 'fa fa-photo',
                            ],
                        ]
                    ],
                    [
                        'name'          => 'icon',
                        'label'         => esc_html__( 'Icon', 'client-custom-elementor-plugin-textdomain' ),
                        'type'          => Controls_Manager::ICON,
                        'default'       => 'fa fa-heart',
                        'condition'     => [
                            'icon_type' => 'icon',
                        ],
                    ],                    
                    [
                        'name'          => 'png_icon',
                        'label'         => esc_html__( 'Image', 'xt-donative-core' ),
                        'type'          => Controls_Manager::MEDIA,
                        'condition'     => [
                            'icon_type' => 'png_icon',
                        ],                        
                    ],                    
                    [
                        'name'            => 'title',
                        'label'           => esc_html__( 'Title', 'client-custom-elementor-plugin-textdomain' ),
                        'type'            => Controls_Manager::TEXT,
                        'default'         => esc_html__( 'Lorem Ipsum', 'client-custom-elementor-plugin-textdomain' )           
                    ],                    
                    [
                        'name'            => 'service_content',
                        'label'           => esc_html__( 'Content', 'client-custom-elementor-plugin-textdomain' ),
                        'type'            => Controls_Manager::TEXTAREA,
                        'default'         => esc_html__( 'As the world\'s largest green and clean egerngy specialist of the printing and typesetting industry. Lorem has been the industry.' ),             
                    ],
                    [
                        'name'              => 'client_service_item_button_text',
                        'label'             => esc_html__( 'Button Text', 'client-custom-elementor-plugin-textdomain' ),
                        'type'              => Controls_Manager::TEXT,
                        'default'           => esc_html__( 'LEARN MORE', 'client-custom-elementor-plugin-textdomain' )             
                    ],  
                    [
                        'name'              => 'client_service_item_button_url',
                        'label'             => esc_html__( 'Link', 'client-custom-elementor-plugin-textdomain' ),
                        'type'              => Controls_Manager::URL,
                        'default'       => [
                            'url'           => '#',
                            'is_external'   => '',
                        ],
                        'label_block'       => true,
                        'show_external'     => true,

                        'placeholder'       => esc_html__( 'http://your-link.com', 'client-custom-elementor-plugin-textdomain' )          
                    ]                                                                         
                ],
                'title_field' => '{{{ title }}}'              
            ]
        );

        $this->add_control(
            'x_class',
            [   
                'label'         => esc_html__( 'Extra CSS clss', 'client-custom-elementor-plugin-textdomain' ),
                'type'          => Controls_Manager::TEXT,
                'description'   => esc_html__( 'Put your extra CSS class if you need.', 'client-custom-elementor-plugin-textdomain' ),
                'placeholder'   => esc_html__( 'your-extra-css-class', 'client-custom-elementor-plugin-textdomain' )
            ]
        );     

        $this->end_controls_section();

        $this->start_controls_section(
            'service_items_style_tab',
            [
                'label'         => esc_html__( 'Icon Style', 'wpb-elementor-addons' ),
                'tab'           => Controls_Manager::TAB_STYLE
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name'          => 'service_items_icon_typography',
                'selector'      => '{{WRAPPER}} .wd-section-blog-services i',
                // font_family, font_size, font_weight, text_transform, font_style, text_decoration, line_height, letter_spacing
                'exclude' => [
                    'text_transform', 'font_family', 'font_weight', 'text_decoration'
                ]
            ]
        );

        $this->add_control(
            'service_items_icon_color',
            [
                'label'         => esc_html__( 'Color', 'wpb-elementor-addons' ),
                'type'          => \Elementor\Controls_Manager::COLOR,              
                'default'       => '#92D132',  
                'selectors'     => [
                    '{{WRAPPER}} .wd-section-blog-services i' => 'color: {{VALUE}};'
                ]         
            ]
        );

        $this->add_control(
            'service_items_icon_margin',
            [
                'label'         => esc_html__( 'Margin', 'wpb-elementor-addons' ),
                'type'          => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units'    => [ 'px' ],
                'selectors'     => [
                    '{{WRAPPER}} .wd-section-blog-services i' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $this->end_controls_section();

    }

    private function render_image( $image_id, $settings ) {
        $image_size = $settings['image_size_size'];
        if ( 'custom' === $image_size ) {
            $image_src = Group_Control_Image_Size::get_attachment_image_src( $image_id, 'image_size', $settings );
        } else {
            $image_src = wp_get_attachment_image_src( $image_id, $image_size );
            $image_src = $image_src[0];
        }

        return sprintf( '<img src="%s" alt="%s" />', esc_url($image_src), esc_html( get_post_meta( $image_id, '_wp_attachment_image_alt', true) ) );
    }

    protected function render() {
		$settings        = $this->get_settings();
		$column_settings = $settings['column_settings'];
		$service_items   = $settings['service_items'];
		$column          = 12/$column_settings;
		$column          = ' col-md-'.esc_attr( $column ). ' col-sm-6 col-xs-12';
        $x_class         = $settings['x_class'];

        if($x_class){
            $x_class = $x_class.' ';
        }

		if ( is_array( $service_items ) ) : 			
			echo '<div class="'.esc_attr( $x_class ).'crystal-service-items">';
				echo '<div class="row">';
					foreach( $service_items as $key => $service_item ) :
                        if ( $service_item['client_service_item_button_url']['url'] ) {
                            $href = 'href="'.esc_url($service_item['client_service_item_button_url']['url']).'"';
                        } else {
                            $href = '';
                        }
                        if ( $service_item['client_service_item_button_url']['is_external'] === 'on' ) {
                            $target = ' target= _blank';
                        } else {
                            $target = '';
                        }
                        if ( $service_item['client_service_item_button_url']['nofollow'] === 'on' ) {
                            $target .= ' rel= nofollow ';
                        }  

						echo '<div class="item-boxes'.esc_attr($column).'">';
                            echo '<div class="wd-section-blog-services text-center style-3 anim-on">';
                                echo '<article class="layout-2">';
                                    echo '<div class="wd-blog-post nohover">';
                                        if ( ! empty( $service_item['icon'] ) && ( $service_item['icon_type'] == 'icon' ) ) :
                                            echo '<i class="'.esc_attr( $service_item['icon'] ).'"></i>';
                                        endif;                                        
                                        if( ($service_item['icon_type'] == 'png_icon') && array_key_exists( 'id', $service_item['png_icon'] ) && $service_item['png_icon']['id'] != '' ) {
                                            echo '<div class="svg-wrapper">';
                                                echo '<svg width="172" height="172" xmlns="http://www.w3.org/2000/svg">';
                                                    echo '<rect height="166" width="166" class="shape"></rect>';
                                                echo '</svg>';
                                                echo '<div class="img-wrapper">';
                                                    echo $this->render_image( $service_item['png_icon']['id'], $settings );
                                                echo '</div>';
                                            echo '</div>';
                                        }



                                // if ( ! empty( $list['icon'] ) && ( $list['icon_type'] == 'icon' ) ) :
                                //         echo '<i class="'.esc_attr( $list['icon'] ).'"></i>';
                                // endif;
                                // if ( ! empty( $list['custom'] ) && ( $list['icon_type'] == 'custom' ) ) :
                                //     echo wp_get_attachment_image( $list['custom']['id'], 'thumbnail' );
                                // endif;







                                        $service_item['title'] ? printf( '<h4 class="wd-title-element">%s</h4>', esc_html(  $service_item['title'] ) ) : '';
                                        $service_item['service_content'] ? printf( '<p>%s</p>', wp_kses_post(  $service_item['service_content'] ) ) : '';
                                        if ( ! empty( $service_item['client_service_item_button_text'] ) ) :
                                            echo '<a class="learn-more-btn" '.$href.esc_attr($target).'>'.esc_html($service_item['client_service_item_button_text']).'</a>';
                                        endif;
                                    echo '</div>';
                                echo '</article>';
                            echo '</div>';
						echo '</div>';
                    endforeach;
				echo '</div>';
			echo '</div>';
		endif;
    }

}

Plugin::instance()->widgets_manager->register_widget_type( new Client_Service_Item_Widget() );