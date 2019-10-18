<?php

namespace Elementor;


if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.

class Client_Owl_Slider extends Widget_Base {

    public function get_name() {
        return 'post-owl-slider';
    }

    public function get_title() {
        return esc_html__( 'Post Slider', 'client-custom-elementor-plugin-textdomain' );
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

        $this->add_control(
            'number_of_words',
            [
                'label'         => esc_html__('Number of words to show', 'client-custom-elementor-plugin-textdomain'),
                'type'          => Controls_Manager::NUMBER,
                'min'           => 1,
                'step'          => 2,
                'default'       => 10,
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

        $this->add_control(
            'slider_overlay_color',
            [
                'label'         => esc_html__( 'Slider Overlay Color', 'client-custom-elementor-plugin-textdomain' ),
                'type'          => \Elementor\Controls_Manager::COLOR,             
                'selectors'     => [
                    '{{WRAPPER}} .js_hero_thumb .slide-table' => 'background-color: {{VALUE}};'
                ]            
            ]
        );

        $this->end_controls_section();      
       
    }

    protected function render() {
        $settings         = $this->get_settings();        
        $tottal_post      = $settings['number_of_posts']['size'];
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

    ?>
        <div class="<?php echo esc_attr($x_class); ?>js_hero_thumb owl-carousel">
            <?php 
                while ($wp_query->have_posts()) : $wp_query->the_post(); 
                global $post;
                $gallery_large = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'full' );
                $blog_small_content = get_the_content();
            ?>
                <div class="item" data-thumb="<a href='<?php the_permalink(); ?>'></a>
                    <div class='post-title'>
                        <h4><a href='#'><?php the_title(); ?></a></h4>
                        <?php echo wpautop( wp_kses_post( wp_trim_words( $blog_small_content , $number_of_words, '&hellip;' ) ) ); ?>
                    </div>">
                    <div style="background-image:url(<?php echo esc_url( $gallery_large[0] ); ?>)" class="xt-main-slider-item">
                        <div class="slide-table">
                            <div class="slide-tablecell">
                                <div class="container">
                                    <div class="row">
                                        <div class="col-md-7 col-sm-12">
                                            <div class="slide-text">
                                                <?php the_title('<h2>', '</h2>'); ?>
                                                <?php echo wpautop( wp_kses_post( wp_trim_words( $blog_small_content , $number_of_words, '&hellip;' ) ) ); ?>
                                                <div class="theme-main-slide-buttons">
                                                    <a class="btn btn-lg" href="<?php echo the_permalink(); ?>"><?php echo __('READ MORE', 'client-custom-elementor-plugin-textdomain'); ?></a> 
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endwhile;
            wp_reset_postdata();  ?>
        </div>

    <?php endif; ?>
        <script>
            jQuery(document).ready( function($) {
                $(document).ready(function () {
                    // thumbnail slier
                    $('.js_hero_thumb').owlCarousel({
                        loop: true,
                        items: 1,
                        thumbs: true,
                        autoplay: true,
                        nav: true,
                        navText : ['<i class="fa fa-angle-left"></i>','<i class="fa fa-angle-right"></i>']
                    });
                });
            });
        </script>
        <?php
    }
}

Plugin::instance()->widgets_manager->register_widget_type( new Client_Owl_Slider() );