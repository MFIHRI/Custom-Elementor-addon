<?php
namespace Elementor;


if ( ! defined( 'ABSPATH' ) ) exit; // If this file is called directly, abort.

class Client_Widget_Item extends Widget_Base {

    public function get_name() {
        return 'slider-item';
    }

    public function get_title() {
        return esc_html__( 'Slider', 'client-custom-elementor-plugin-textdomain' );
    }

    public function get_icon() {
        return 'eicon-slideshow';
    }

    public function get_categories() {
        return [ 'client_widgets' ];
    }

 protected function _register_controls() {
        // slider items
        $this->start_controls_section(
            'static_slider_items',
            [
                'label' => esc_html__( 'Slider Settings', 'client-custom-elementor-plugin-textdomain' )
            ]
        );

        // get all post types
        $this->add_control(
            'post_types',
            [
                'label'    => esc_html__('Post Type', 'client-custom-elementor-plugin-textdomain' ),
                'type'     => Controls_Manager::SELECT,
                'default'  => 'post',
                'options'  => wpb_ea_get_all_post_type_options()
            ]
        );

        // number of posts
        $this->add_control(
            'posts_per_page',
            [
                'label'         => esc_html__('Number of posts to show', 'wpb-elementor-addons'),
                'type'          => Controls_Manager::NUMBER,
                'default'       => 3
            ]
        );  

        // selected id to show post
        $this->add_control(
            'post_in_ids',
            [
                'label'         => esc_html__('Include', 'wpb-elementor-addons' ),
                'description'   => esc_html__('Provide a comma separated list of Post IDs to display spacific post.', 'wpb-elementor-addons' ),
                'type'          => Controls_Manager::TEXT,
                'label_block'   => true
            ]
        );

        // specific id to exclude post
        $this->add_control(
            'post_not_in_ids',
            [   
                'label'         => esc_html__( 'Exclude', 'wpb-elementor-addons' ),
                'type'          => Controls_Manager::TEXT,
                'description'   => esc_html__('Provide a comma separated list of Post IDs to exclude specific post.', 'wpb-elementor-addons' )
            ]
        );   

        // order by
        $this->add_control(
            'wpb_ea_order_by',
            [
                'type'    => Controls_Manager::SELECT,
                'label'   => esc_html__( 'Order by', 'wpb-elementor-addons' ),
                'default' => 'date',
                'options' => [
                    'none'          => esc_html__('No order', 'wpb-elementor-addons' ),
                    'ID'            => esc_html__('Post ID', 'wpb-elementor-addons' ),
                    'author'        => esc_html__('Author', 'wpb-elementor-addons' ),
                    'title'         => esc_html__('Title', 'wpb-elementor-addons' ),
                    'date'          => esc_html__('Published date', 'wpb-elementor-addons' ),
                    'modified'      => esc_html__('Modified date', 'wpb-elementor-addons' ),
                    'parent'        => esc_html__('By parent', 'wpb-elementor-addons' ),
                    'rand'          => esc_html__('Random order', 'wpb-elementor-addons' ),
                    'comment_count' => esc_html__('Comment count', 'wpb-elementor-addons' ),
                    'menu_order'    => esc_html__('Menu order', 'wpb-elementor-addons' ),
                    'post__in'      => esc_html__('By include order', 'wpb-elementor-addons' )
                ]
            ]
        );

        // order
        $this->add_control(
            'wpb_ea_order',
            [
                'type'          => Controls_Manager::SELECT,
                'label'         => esc_html__( 'Order', 'wpb-elementor-addons' ),
                'default'       => 'DESC',
                'options'       => [
                    'ASC'       => esc_html__( 'Ascending', 'wpb-elementor-addons' ),
                    'DESC'      => esc_html__( 'Descending', 'wpb-elementor-addons' )
                ]
            ]
        );

        // post excerpt length
        $this->add_control(
            'wpb_ea_excerpt_length',
            [
                'label'         => esc_html__('Excerpt Length', 'wpb-elementor-addons' ),
                'type'          => Controls_Manager::NUMBER,
                'default'       => 15
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

    // render image function
    private function render_image( $item, $settings ) {
        $image_id   = $item['image']['id'];
        $image_size = $settings['image_size_size'];
        if ( 'custom' === $image_size ) {
            $image_src = Group_Control_Image_Size::get_attachment_image_src( $image_id, 'image_size', $settings );
        } else {
            $image_src = wp_get_attachment_image_src( $image_id, $image_size );
            $image_src = $image_src[0];
        }

        return sprintf( '<img src="%s" alt="%s" />', esc_url($image_src), esc_html($item['custom_widet_title']) );
    }

    protected function render() {
        $settings        = $this->get_settings();        
        $extra_css       =  $settings['extra_css'];
        if($extra_css) {
            $extra_css = $extra_css.' ';
        }
        $orderby                   = $settings['wpb_ea_order_by'];
        $order                     = $settings['wpb_ea_order'];
        $post_type                 = $settings['post_types'];
        $posts_per_page            = $settings['posts_per_page'];
        $post_in_ids               = $settings['post_in_ids'] ? explode( ',', $settings['post_in_ids'] ) : null;
        $post_not_in_ids           = $settings['post_not_in_ids'] ? explode( ',', $settings['post_not_in_ids'] ) : null;
        $wpb_ea_excerpt_length     = $settings['wpb_ea_excerpt_length'];

        $args = array(
            'post_type'          => $post_type,
            'post_status'        => 'publish',
            'orderby'            => $orderby,
            'order'              => $order,
            'posts_per_page'     => $posts_per_page,
            'post__in'           => $post_in_ids,
            'post__not_in'       => $post_not_in_ids
        );

        $rand_id    = rand( 10,1000 );

        $wp_query = new \WP_Query( $args );
        if ( $wp_query->have_posts() ) : 
            echo '<div id="main-slide-'.$rand_id.'" class="'.esc_attr($extra_css).'brittville-static-slider carousel slide" data-ride="carousel">';
                echo '<div class="carousel-inner">';
                    $x = 0;
                    while ( $wp_query->have_posts() ) : $wp_query->the_post();
                        $slider_details          = get_the_content(); 
                        global $post;
                        $x++;

                        $slider_featured_img    = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), array('9999','500') ); 
                        if( $x == 1 ) {
                            $active = ' active';
                        } else {
                            $active = '';
                        }
                        echo '<div class="carousel-item'.esc_attr($active).'">';
                            if( has_post_thumbnail() ){
                                the_post_thumbnail('slider-img');
                            }else{
                                echo '<img src="http://placehold.it/1920x600">';
                            }
                            echo '<div class="carousel-caption d-md-block">';
                                the_title('<h1 class="heading">','</h1>');
                                echo wpautop( wp_kses_post( wp_trim_words( $slider_details , $wpb_ea_excerpt_length ) ) );
                                echo '<a class="read-more-btn" href="'.get_the_permalink().'">Read More</a>';
                            echo '</div>';
                        echo '</div>';  
                    endwhile;
                echo '</div>';

                // indicators
                if( $x > 1 ) :
                    echo '<ol class="carousel-indicators">';
                        for( $y=0; $y<$x; $y++ ){
                            if( $x == 1 ) {
                                $active = 'active';
                            } else {
                                $active = 'not-active';
                            }
                            echo '<li data-target="#main-slide-'.$rand_id.'" data-slide-to="'.$y.'" class="'.esc_attr($active).'"></li>';  
                        }
                    echo '</ol>';           
                endif;

                // carousel     
                if( $x > 1 ) :
                    echo '<a class="carousel-control-prev" href="#main-slide-'.$rand_id.'" role="button" data-slide="prev">';
                        echo '<span class="carousel-control" aria-hidden="true"><i class="fa fa-angle-left"></i></span>';
                        echo '<span class="sr-only">Previous</span>';     
                    echo '</a>';
                    echo '<a class="carousel-control-next" href="#main-slide-'.$rand_id.'" role="button" data-slide="next">';
                        echo '<span class="carousel-control" aria-hidden="true"><i class="fa fa-angle-right"></i></span>';
                        echo '<span class="sr-only">Next</span>';          
                    echo '</a>';
                endif;
            echo '</div>';
        endif;
        wp_reset_postdata();

    }
}

Plugin::instance()->widgets_manager->register_widget_type( new Client_Widget_Item() );
