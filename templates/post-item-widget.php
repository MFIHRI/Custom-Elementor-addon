<?php

namespace Elementor;


if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.

class Client_Widget_Post extends Widget_Base {

    public function get_name() {
        return 'post-item-widget';
    }

    public function get_title() {
        return esc_html__( 'Post', 'client-custom-elementor-plugin-textdomain' );
    }

    public function get_icon() {
        return 'eicon-posts-grid';
    }

    public function get_categories() {
        return [ 'client_widgets' ];
    }

    protected function _register_controls() {


        $this->start_controls_section(
            'client_post_content',
            [
                'label'         => esc_html__( 'Posts', 'client-custom-elementor-plugin-textdomain' )
            ]
        );

        $this->add_control(
            'post_style_type',
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

        // post tottal number
        $this->add_control(
            'number_of_posts',
            [
                'label'         => esc_html__('Number Of Posts', 'client-custom-elementor-plugin-textdomain'),
                'type'          => Controls_Manager::SLIDER,
                'range'         => [
                    'px'        => [
                        'min'   => 1,
                        'max'   => 50
                    ],
                ],
                'default'       => [
                    'size'      => 3
                ]
            ]
        );     

        // post item grid column
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

        $this->add_control(
            'number_of_words',
            [
                'label'         => esc_html__('Number of words to show', 'client-custom-elementor-plugin-textdomain'),
                'type'          => Controls_Manager::NUMBER,
                'min'           => 1,
                'step'          => 2,
                'default'       => 20,
            ]
        );

        $this->add_group_control(
            Group_Control_Image_Size::get_type(),
            [
                'name'          => 'image',
                'default'       => 'medium_large'
            ]
        );

        // order
        $this->add_control(
            'order',
            [
                'type'          => Controls_Manager::SELECT,
                'label'         => esc_html__( 'Order', 'client-custom-elementor-plugin-textdomain' ),
                'default'       => 'DESC',
                'options'       => [
                    'ASC'       => esc_html__( 'Ascending', 'client-custom-elementor-plugin-textdomain' ),
                    'DESC'      => esc_html__( 'Descending', 'client-custom-elementor-plugin-textdomain' )
                ]
            ]
        );   

        // order by
        $this->add_control(
            'orderby',
            [
                'type'          => Controls_Manager::SELECT,
                'label'         => esc_html__( 'Order By', 'client-custom-elementor-plugin-textdomain' ),
                'default'       => 'date',
                'options'       => [
                    'none'          => esc_html__('No order', 'client-custom-elementor-plugin-textdomain' ),
                    'ID'            => esc_html__('Post ID', 'client-custom-elementor-plugin-textdomain' ),
                    'author'        => esc_html__('Author', 'client-custom-elementor-plugin-textdomain' ),
                    'title'         => esc_html__('Title', 'client-custom-elementor-plugin-textdomain' ),
                    'date'          => esc_html__('Published date', 'client-custom-elementor-plugin-textdomain' ),
                    'modified'      => esc_html__('Modified date', 'client-custom-elementor-plugin-textdomain' ),
                    'parent'        => esc_html__('By parent', 'client-custom-elementor-plugin-textdomain' ),
                    'rand'          => esc_html__('Random order', 'client-custom-elementor-plugin-textdomain' ),
                    'comment_count' => esc_html__('Comment count', 'client-custom-elementor-plugin-textdomain' ),
                    'menu_order'    => esc_html__('Menu order', 'client-custom-elementor-plugin-textdomain' ),
                    'post__in'      => esc_html__('By include order', 'client-custom-elementor-plugin-textdomain' )
                ]
            ]
        );

        // specific post include
        $this->add_control(
            'post_in_ids',
            [   
                'label'         => esc_html__( 'Include', 'client-custom-elementor-plugin-textdomain' ),
                'type'          => Controls_Manager::TEXT,
                'description'   => __(' You can put comma separated post id for showing those specific post only.', 'client-custom-elementor-plugin-textdomain')
            ]
        );   

        // specific post exclude
        $this->add_control(
            'post_not_in_ids',
            [   
                'label'         => esc_html__( 'Exclude', 'client-custom-elementor-plugin-textdomain' ),
                'type'          => Controls_Manager::TEXT,
                'description'   => __('You can put comma separated post id for excluding those post.', 'client-custom-elementor-plugin-textdomain')
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
       
    }

    protected function render() {
        $settings         = $this->get_settings();        
        $tottal_post      = $settings['number_of_posts']['size'];
        $style            = $settings['post_style_type'];
        $column           = $settings['column_settings'];
        $number_of_words  = $settings['number_of_words'];
        $order            = $settings['order'];
        $orderby          = $settings['orderby'];
        $post_in_ids      = $settings['post_in_ids'] ? explode( ',', $settings['post_in_ids'] ) : null;
        $post_not_in_ids  = $settings['post_not_in_ids'] ? explode( ',', $settings['post_not_in_ids'] ) : null;
        $x_class          = $settings['x_class'];


        if($x_class){
            $x_class = $x_class.' ';
        }

        $args = array(
            'post_type'                 => 'post', 
            'orderby'                   => $orderby,
            'order'                     => $order,
            'posts_per_page'            => $tottal_post,
            'post__in'                  => $post_in_ids,
            'post__not_in'              => $post_not_in_ids
        );

        $wp_query = new \WP_Query( $args );
        if ( $wp_query->have_posts() ):      
            $column = 12/$column;
            $column = 'col-md-'.esc_attr( $column ). ' col-sm-6 col-xs-12';

            echo '<div class="'.esc_attr($x_class).'my-custom-blog-post-items '.esc_attr($style).'">';
                echo '<div class="row">';
                    while ($wp_query->have_posts()) : $wp_query->the_post();
                        global $post;
                        $post_large_image = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'full' );
                        $blog_small_content = get_the_content();
                        echo '<div class="'.esc_attr($column).' blog-item">';
                            echo '<div class="blog-item-wrapper">';

                                echo '<div class="blog-item-top-section">';
                                    echo '<h3>';
                                        echo '<a href="'.esc_url(get_the_permalink()).'">'.get_the_title().'</a>';
                                    echo '</h3>';
                                    if(function_exists('client_get_post_first_category')){
                                        echo client_get_post_first_category( get_the_id() );
                                    }
                                echo '</div>';

                                if( has_post_thumbnail() ) :  
                                    echo '<div class="post-thumbnail">';
                                        echo '<a class="thumbnail-permalink" href="'.esc_url(get_the_permalink()).'">';
                                            echo '<img src="'.esc_url(wp_get_attachment_image_url(get_post_thumbnail_id(), $settings['image_size'])).'">';
                                        echo '</a>';
                                        echo '<div class="block_hover">';
                                            echo '<div class="links">';
                                                echo '<a href="'.esc_url( $post_large_image[0] ).'" class="elementor-clickable">';
                                                    echo '<i class="fa fa-search"></i>';
                                                echo '</a>';
                                            echo '</div>';
                                        echo '</div>';
                                        if($style == 'style-2') :
                                            echo '<div class="meta-tags">';
                                                echo '<span class="date"><i class="fa fa-clock-o"></i>'.esc_html('on ', 'client-custom-elementor-plugin-textdomain').get_the_date( 'M d, Y' ).' </span>';
                                                echo '<span class="comments"><i class="fa fa-comment"></i>';
                                                    comments_popup_link( '0 Comment', '1 Comment', '% Comments', 'custom-cmnt-class-name', 'Comments Disabled' );
                                                echo '</span>';
                                            echo '</div>';
                                        endif;
                                    echo '</div>';
                                endif;

                                if($style == 'style-1') :
                                    echo '<div class="post-main-content">';
                                        echo '<div class="meta-tags">';
                                            echo '<span class="date"><i class="fa fa-clock-o"></i>'.esc_html('on ', 'client-custom-elementor-plugin-textdomain').get_the_date( 'M d, Y' ).' </span>';
                                            echo '<span class="comments"><i class="fa fa-comment"></i>';
                                                comments_popup_link( '0 Comment', '1 Comment', '% Comments', 'custom-cmnt-class-name', 'Comments Disabled' );
                                            echo '</span>';
                                        echo '</div>';

                                        echo '<div class="blog-item-text">'; 
                                            echo wpautop( wp_kses_post( wp_trim_words( $blog_small_content , $number_of_words, '&hellip;' ) ) );
                                        echo '</div>';
                                    echo '</div>';
                                endif;
                            echo '</div>';
                        echo '</div>';
                    endwhile;
                    wp_reset_postdata(); 
                echo '</div>';
            echo '</div>';
                
        endif;
        
    }
}

Plugin::instance()->widgets_manager->register_widget_type( new Client_Widget_Post() );