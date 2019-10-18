<?php
/**
 * Elementor Frontend Scripts
 */
/**
 * Enqueue CSS & JS files
 */
function client_project_register_scripts(){
    wp_enqueue_style('bootstrap', plugins_url('../assets/css/bootstrap.min.css', __FILE__ ), '', '4.1.0', false);  
    wp_enqueue_style('owl-carousel', plugins_url('../assets/css/owl.carousel.min.css', __FILE__ ), '', '2.2.0', false);  
    wp_enqueue_style('owl-carousel-theme-default', plugins_url('../assets/css/owl.theme.default.css', __FILE__ ), '', '2.2.0', false);  
    wp_enqueue_style( 'fontawesome', plugins_url('../assets/css/font-awesome.min.css', __FILE__) , '', '4.7.0', false );
    wp_enqueue_style('client-project-css', plugins_url('../assets/css/dwsp-project.css', __FILE__ ), '', '1.0', false);  
    wp_enqueue_script( 'bootstrap', plugins_url('../assets/js/bootstrap.min.js', __FILE__ ), array('jquery'), '4.1.0', true );
    wp_enqueue_script( 'owl-carousel-js', plugins_url('../assets/js/owl.carousel.min.js', __FILE__ ), array('jquery'), '2.2.0', true );
    wp_enqueue_script( 'owl-carousel-thumbs-js', plugins_url('../assets/js/owl.carousel2.thumbs.js', __FILE__ ), array('jquery'), '2.2.0', true );
    wp_enqueue_script( 'main-js', plugins_url('../assets/js/main.js', __FILE__ ), array('jquery'), '1.0', true );
}
add_action( 'wp_enqueue_scripts', 'client_project_register_scripts' ); 


add_action('admin_enqueue_scripts', 'client_project_color_picker' );
    function client_project_color_picker() {
    wp_enqueue_style('my-client-project-admin-css', plugins_url('../assets/css/dwsp-project-admin.css', __FILE__ ), '', '1.0', false);
    wp_enqueue_script( 'iris', plugins_url('../assets/js/iris.min.js', __FILE__ ), array('jquery'), '1.0.7', true );    
    wp_enqueue_script( 'iris-init', plugins_url('../assets/js/iris-init.js', __FILE__ ), array('jquery'), '1.0', true );

}

/**
 * Add a New Elementor Widegt Category
 */

add_action( 'elementor/init', 'client_add_elementor_category' );

if( !function_exists('client_add_elementor_category') ){
    function client_add_elementor_category(){
        \Elementor\Plugin::instance()->elements_manager->add_category(
'client_widgets',
array('title' => esc_html__( 'DWSP', 'client-custom-elementor-plugin-textdomain' ),
            ),
            1
        );
    }
}

/**
 * get all types of posts
 */
function wpb_ea_get_all_post_type_options() {

    $post_types = get_post_types(array('public' => true), 'objects');

    $options = array();

    foreach ($post_types as $post_type) {
        $options[$post_type->name] = $post_type->label;
    }

    return $options;
}

/**
 * get only first post category
 */

if(!function_exists('client_get_post_first_category')){
    function client_get_post_first_category( $post_id ) {

        $output = '';
        
        if($post_id == ''){
            $post_id = get_the_id();
        }

        $categories = get_the_category( $post_id );

        if( $categories && !empty($categories) ){
            $output = '<a href="'. esc_url(get_category_link($categories[0]->term_id ) ) .'" class="crystal-single-cat">'. esc_html( $categories[0]->cat_name ) .'</a>';
        }

        return $output;
    }
}

/**
 * Add Elementor Widegts
 */

add_action( 'elementor/widgets/widgets_registered', 'client_project_add_elementor_widgets' );

if( !function_exists('client_project_add_elementor_widgets') ){
	function client_project_add_elementor_widgets(){
        include client_project_Plugin_Template_Path . 'slider-widget.php';
        include client_project_Plugin_Template_Path . 'fancy-list-widget.php';
        include client_project_Plugin_Template_Path . 'post-item-widget.php';
        include client_project_Plugin_Template_Path . 'call-to-action.php';
        include client_project_Plugin_Template_Path . 'post-owl-slider.php';
        include client_project_Plugin_Template_Path . 'service.php';
        include client_project_Plugin_Template_Path . 'service-two.php';
	}
}


if( !function_exists('wpb_ea_owl_carousel_data_attr_implode') ){
    function wpb_ea_owl_carousel_data_attr_implode( $array ){
        
        foreach ($array as $key => $value) {

            if( isset($value) &&  $value != '' ){
                $output[] = $key . '=' . '"'. esc_attr( $value ) . '"' ;
            }
        }

        return implode( ' ', $output );
    }
}
function astra_child_main_header_bar_top(){
    global $post;
    $my_options = get_option( 'astra_settings' );
    $disable_header_top =         get_option( 'astra_child_checkbox_field_top_bar' );
    $disable_facebook = get_option('disable_facebook' );
    $disable_instagram = get_option('disable_instagram' );
    $disable_youtube = get_option('disable_youtube' );
    $phone = $my_options['astra_text_field_phone'];
    $email = $my_options['astra_text_field_1'];
    $address = $my_options['astra_text_field_2'];
    $fb_url = $my_options['astra_text_field_3'];
    $instagram_url = $my_options['astra_text_field_instagram'];
    $youtube_url = $my_options['astra_text_field_youtube'];
    $show_header_top_per_page = get_post_meta($post->ID, 'astra_custom_header_top', true);
    if ( $show_header_top_per_page != 'yes' && $disable_header_top != 1 ) :
    ?>
        <div class="astra-child-header-top">
            <div class="astra-child-header-top-elements ast-container">
                <?php
                    echo $disable_header_top;
                    $phone ? printf('<div class="astr-child-top-item header-top-phone"><span class="astra-child-header-phone"><i class="fa fa-phone"></i><a href="%s"> %s</a></span></div>', 'tel:' . esc_attr( $phone ), esc_html($phone)) : '';
                    $email ? printf('<div class="astr-child-top-item header-top-email"><span class="astra-child-header-mail"><i class="fa fa-envelope-o"></i><a href="%s"> %s</a></span></div>', 'mailto:' . antispambot( $email, 1 ), antispambot( $email ) ) : '';
                    $address ? printf('<div class="astr-child-top-item header-top-address"><span class="astra-child-header-address"><p><i class="fa fa-location-arrow"></i> %s</p></span></div>', esc_html( $address ) ) : '';
                ?>
                <div class="astr-child-top-item header-top-fb-search">
                    <?php 
                        if( $instagram_url && ($disable_instagram != 1) ){
                            echo '<span class="astra-child-header-facebook-url instagram">';
                                echo '<a href="'.esc_url($instagram_url).'">';
                                    echo '<i class="fa fa-instagram"></i>';
                                echo '</a>';
                            echo '</span>';                             
                        }  
                        if($fb_url && ($disable_facebook != 1) ){
                            echo '<span class="astra-child-header-facebook-url">';
                                echo '<a href="'.esc_url($fb_url).'">';
                                    echo '<i class="fa fa-facebook"></i>';
                                echo '</a>';
                            echo '</span>';                             
                        } 
if($youtube_url && ($disable_youtube != 1) ){
echo '<span class="astra-child-header-facebook-url youtube">';
echo '<a href="'.esc_url($youtube_url).'">';
echo '<i class="fa fa-youtube"></i>';
                                echo '</a>';
                            echo '</span>';                             
                        }                       
                     ?>
                    <form class="full-search" role="search" method="get" action="<?php echo home_url( '/' ); ?>">
                        <input class="form-control" type="search" placeholder="Search" value="<?php echo esc_html( get_search_query() ); ?>" name="s">
                    </form> 
                </div>
            </div>
        </div>
    <?php
    endif;
}
add_action('astra_main_header_bar_top', 'astra_child_main_header_bar_top');

/**
 * my sample shortcode
 */

if( !function_exists('my_test_shortcode') ){
    function my_test_shortcode( $atts ) {

        extract( shortcode_atts(
            array(
                'hero_title' => 'the quick brown fox jumps over the lazy dog'
            ), $atts )
        );

        ob_start();
        ?>
            <div class="my-shortcode-content">
                <p>the quick brown fox</p>
            </div>
        <?php
        return ob_get_clean();
    }
}
add_shortcode( 'my_sample_shortcode', 'my_test_shortcode' );
