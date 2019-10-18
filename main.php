<?php
/**
 * Plugin Name:       DWSP Custom Elementor Template
 * Plugin URI:        http://www.dwsp.ca
 * Description:       Custom Elementor template plugin for DWSP.
 * Version:           1.0
 * Author:            Mori Fihri
 * Author URI:        https://www.timmins.ca
 * Text Domain:       client-custom-elementor-plugin-textdomain
 * Domain Path:       /languages
 */
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly 
define( 'MY_CLEINT_PLUGIN_URL', plugins_url( '/', __FILE__ ) );
/**
 * Localization
 */
if( !function_exists('client_project_shortcode_plugin_textdomain') ){
function client_project_shortcode_plugin_textdomain() {
load_plugin_textdomain( 'client-custom-elementor-plugin-textdomain', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
}
}
add_action( 'init', 'client_project_shortcode_plugin_textdomain' );

/* Set constant path to the plugin directory. */

define( 'client_project_Plugin_Path', trailingslashit( plugin_dir_path( __FILE__ ) ) );
define('client_project_Plugin_Template_Path', client_project_Plugin_Path . '/templates/' );

/**
 * Requred files 
 */

$theme = wp_get_theme();

if( defined('ELEMENTOR_VERSION') ) {
require_once dirname( __FILE__ ) . '/inc/el-addons.php';
}


/**
 * Header Top Options
 */

add_action( 'admin_menu', 'astra_add_admin_menu' );
add_action( 'admin_init', 'astra_settings_init' );


function astra_add_admin_menu(  ) {
add_menu_page( 'Contact Details', 'Contact Details', 'manage_options', 'astra_child', 'astra_options_page' );
}

function astra_settings_init(  ) {
register_setting( 'pluginPage', 'astra_settings' );
register_setting( 'pluginPage', 'astra_child_checkbox_field_top_bar' );
register_setting( 'pluginPage', 'disable_facebook' );
register_setting( 'pluginPage', 'disable_instagram' );
register_setting( 'pluginPage', 'disable_youtube' );

	add_settings_section(
		'astra_pluginPage_section', '', '',  
		'pluginPage'
	);

	add_settings_field( 
		'astra_child_checkbox_field_0', 
		__( 'Disable Custom Header For Whole Site', 'client-custom-elementor-plugin-textdomain' ), 
		'astra_child_checkbox_field_0_render', 
		'pluginPage', 
		'astra_pluginPage_section' 
	);	

	add_settings_field( 
		'astra_text_field_4', 
		__( 'Header Top Background Color: ', 'client-custom-elementor-plugin-textdomain' ), 
		'astra_text_field_4_render', 
		'pluginPage', 
		'astra_pluginPage_section' 
	);

	add_settings_field( 
		'astra_text_field_10', 
		__( 'Header Top Text Color: ', 'client-custom-elementor-plugin-textdomain' ), 
		'astra_text_field_10_render', 
		'pluginPage', 
		'astra_pluginPage_section' 
	);

	add_settings_field( 
		'astra_text_field_10', 
		__('Header Top Text Color: ', 'client-custom-elementor-plugin-textdomain' ), 
		'astra_text_field_10_render', 
		'pluginPage', 
		'astra_pluginPage_section' 
	);

	add_settings_field( 
		'astra_text_field_1', 
		__('Email', 'client-custom-elementor-plugin-textdomain' ), 
		'astra_text_field_1_render', 
		'pluginPage', 
		'astra_pluginPage_section' 
	);

	add_settings_field( 
		'astra_text_field_phone', 
		__('Phone', 'client-custom-elementor-plugin-textdomain' ), 
		'astra_text_field_phone_render', 
		'pluginPage', 
		'astra_pluginPage_section' 
	);

	add_settings_field( 
		'astra_text_field_2', 
		__( 'Address', 'client-custom-elementor-plugin-textdomain' ), 
		'astra_text_field_2_render', 
		'pluginPage', 
		'astra_pluginPage_section' 
	);

	add_settings_field( 
		'astra_child_checkbox_field_1', 
		__('Disable Facebook', 'client-custom-elementor-plugin-textdomain' ), 
		'astra_child_checkbox_field_1_render', 
		'pluginPage', 
		'astra_pluginPage_section' 
	);	

	add_settings_field( 
		'astra_text_field_3', 
		__('Facebook Profile Link: ', 'client-custom-elementor-plugin-textdomain' ), 
		'astra_text_field_3_render', 
		'pluginPage', 
		'astra_pluginPage_section' 
	);

	add_settings_field( 
		'astra_text_field_5', 
		__('Facebook Icon Background Color: ', 'client-custom-elementor-plugin-textdomain' ), 
		'astra_text_field_5_render', 
		'pluginPage', 
		'astra_pluginPage_section' 
	);

	add_settings_field( 
		'astra_child_checkbox_field_2', 
		__('Disable Instagram', 'client-custom-elementor-plugin-textdomain' ), 
		'astra_child_checkbox_field_2_render', 
		'pluginPage', 
		'astra_pluginPage_section' 
	);	

	add_settings_field( 
		'astra_text_field_instagram', 
		__('Instagram Profile Link: ', 'client-custom-elementor-plugin-textdomain' ), 
		'astra_text_field_instagram_render', 
		'pluginPage', 
		'astra_pluginPage_section' 
	);

	add_settings_field( 
		'astra_text_field_6', 
		__('Instagram Icon Background Color: ', 'client-custom-elementor-plugin-textdomain' ), 
		'astra_text_field_6_render', 
		'pluginPage', 
		'astra_pluginPage_section' 
	);

	add_settings_field( 
		'astra_child_checkbox_field_3', 
		__('Disable Youtube', 'client-custom-elementor-plugin-textdomain' ), 
		'astra_child_checkbox_field_3_render', 
		'pluginPage', 
		'astra_pluginPage_section' 
	);	

	add_settings_field( 
		'astra_text_field_youtube', 
		__( 'Youtube Profile Link: ', 'client-custom-elementor-plugin-textdomain' ), 
		'astra_text_field_youtube_render', 
		'pluginPage', 
		'astra_pluginPage_section' 
	);

	add_settings_field( 
		'astra_text_field_7', 
		__( 'Youtube Icon Background Color: ', 'client-custom-elementor-plugin-textdomain' ), 
		'astra_text_field_7_render', 
		'pluginPage', 
		'astra_pluginPage_section' 
	);

}


function astra_child_checkbox_field_0_render(  ) { 
	$options = get_option( 'astra_child_checkbox_field_top_bar' );
 	$checked = ( @$options == 1 ? 'checked': '' );
 	echo '<input type="checkbox" id="astra_child_checkbox_field_top_bar" name="astra_child_checkbox_field_top_bar" value="1" '.$checked.'/>';
}

function astra_child_checkbox_field_1_render(  ) { 
	$options = get_option( 'disable_facebook' );
 	$checked = ( @$options == 1 ? 'checked': '' );
 	echo '<input type="checkbox" id="disable_facebook" name="disable_facebook" value="1" '.$checked.'/>';
}

function astra_child_checkbox_field_2_render(  ) { 
	$options = get_option( 'disable_instagram' );
 	$checked = ( @$options == 1 ? 'checked': '' );
 	echo '<input type="checkbox" id="disable_instagram" name="disable_instagram" value="1" '.$checked.'/>';
}

function astra_child_checkbox_field_3_render(  ) { 
	$options = get_option( 'disable_youtube' );
 	$checked = ( @$options == 1 ? 'checked': '' );
 	echo '<input type="checkbox" id="disable_youtube" name="disable_youtube" value="1" '.$checked.'/>';
}

function astra_text_field_1_render(  ) { 

	$options = get_option( 'astra_settings' );
	?>
	<input type='text' class='my-cleint-email' name='astra_settings[astra_text_field_1]' value='<?php echo $options['astra_text_field_1']; ?>'>
	<?php

}


function astra_text_field_phone_render(  ) { 

	$options = get_option( 'astra_settings' );
	?>
	<input type='text' class='my-cleint-email' name='astra_settings[astra_text_field_phone]' value='<?php echo $options['astra_text_field_phone']; ?>'>
	<?php

}


function astra_text_field_2_render(  ) { 

	$options = get_option( 'astra_settings' );
	?>
	<input type='text' class='my-cleint-address' name='astra_settings[astra_text_field_2]' value='<?php echo $options['astra_text_field_2']; ?>'>
	<?php

}

function astra_text_field_3_render(  ) { 

	$options = get_option( 'astra_settings' );
	?>
	<input type='text' class='my-cleint-fb-url' name='astra_settings[astra_text_field_3]' value='<?php echo $options['astra_text_field_3']; ?>'>
	<?php

}

function astra_text_field_instagram_render(  ) { 

	$options = get_option( 'astra_settings' );
	?>
	<input type='text' class='my-cleint-fb-url' name='astra_settings[astra_text_field_instagram]' value='<?php echo $options['astra_text_field_instagram']; ?>'>
	<?php

}

function astra_text_field_youtube_render(  ) { 

	$options = get_option( 'astra_settings' );
	?>
	<input type='text' class='my-cleint-fb-url' name='astra_settings[astra_text_field_youtube]' value='<?php echo $options['astra_text_field_youtube']; ?>'>
	<?php

}

function astra_text_field_4_render(  ) { 

	$options = get_option( 'astra_settings' );
	$options['astra_text_field_4'] = $options['astra_text_field_4'] ? $options['astra_text_field_4'] : '#222222';
	?>
	<input type="text" class="color-picker" name="astra_settings[astra_text_field_4]" id='color-picker' value='<?php echo $options['astra_text_field_4']; ?>' />
	<?php

}

function astra_text_field_10_render(  ) { 

	$options = get_option( 'astra_settings' );
	$options['astra_text_field_10'] = $options['astra_text_field_10'] ? $options['astra_text_field_10'] : '#ffffff';
	?>
	<input type="text" class="color-picker" name="astra_settings[astra_text_field_10]" id='color-picker' value='<?php echo $options['astra_text_field_10']; ?>' />
	<?php

}

function astra_text_field_5_render(  ) { 

	$options = get_option( 'astra_settings' );
	$options['astra_text_field_5'] = $options['astra_text_field_5'] ? $options['astra_text_field_5'] : '#3A559F';
	?>
	<input type="text" class="color-picker" name="astra_settings[astra_text_field_5]" id='color-picker' value='<?php echo $options['astra_text_field_5']; ?>' />
	<?php

}

function astra_text_field_6_render(  ) { 

	$options = get_option( 'astra_settings' );
	$options['astra_text_field_6'] = $options['astra_text_field_6'] ? $options['astra_text_field_6'] : '#E82637';
	?>
	<input type="text" class="color-picker" name="astra_settings[astra_text_field_6]" id='color-picker' value='<?php echo $options['astra_text_field_6']; ?>' />
	<?php

}

function astra_text_field_7_render(  ) { 

	$options = get_option( 'astra_settings' );
	$options['astra_text_field_7'] = $options['astra_text_field_7'] ? $options['astra_text_field_7'] : '#F80000';
	?>
	<input type="text" class="color-picker" name="astra_settings[astra_text_field_7]" id='color-picker' value='<?php echo $options['astra_text_field_7']; ?>' />
	<?php

}

function astra_options_page(  ) { 

	?>
	<form class="my-child-header-top-options-form" action='options.php' method='post'>

		<h2>Contact Details</h2>

		<?php
		settings_fields( 'pluginPage' );
		do_settings_sections( 'pluginPage' );
		submit_button();
		?>

	</form>
	<?php

}

function my_client_styles_method() {
	wp_enqueue_style(
		'custom-style',
		MY_CLEINT_PLUGIN_URL . '/assets/css/custom_script.css'
	);
        $my_options = get_option( 'astra_settings' );
        $bg_color = $my_options['astra_text_field_4'];
        $color = $my_options['astra_text_field_10'];
        $fb_bg_color = $my_options['astra_text_field_5'];
        $instagram_bg_color = $my_options['astra_text_field_6'];
        $youtube_bg_color = $my_options['astra_text_field_7'];
        $custom_css = "
                .astra-child-header-top {
                        background-color: {$bg_color};
                }
                .astra-child-header-top,
                .astra-child-header-top a,
                .astra-child-header-top i.fa-phone,
                .astra-child-header-top i.fa-location-arrow,
                .astra-child-header-top i.fa-envelope-o {
                        color: {$color};                	
                }
                .astra-child-header-top .astra-child-header-facebook-url a {
                        background-color: {$fb_bg_color};
                }
                .astra-child-header-top .astra-child-header-facebook-url.instagram a {
                        background-color: {$instagram_bg_color};
                }
                .astra-child-header-top .astra-child-header-facebook-url.youtube a {
                        background-color: {$youtube_bg_color};
                }";
        wp_add_inline_style( 'custom-style', $custom_css );
}
add_action( 'wp_enqueue_scripts', 'my_client_styles_method' );



// Checkbox Meta
add_action("admin_init", "astra_child_header_top_checkbox_init");

function astra_child_header_top_checkbox_init(){
  add_meta_box("checkbox", "Contact Details", "astra_child_header_top_checkbox", "page", "normal", "high");
}

function astra_child_header_top_checkbox(){
  global $post;
  $custom = get_post_custom($post->ID);
  // $astra_custom_header_top = $custom["astra_custom_header_top"][0];
 ?>

  <?php $astra_custom_header_top_value = get_post_meta($post->ID, 'astra_custom_header_top', true);
  if($astra_custom_header_top_value == "yes") {
  	$astra_custom_header_top_checked = 'checked="checked"'; 
  } else {
  	$astra_custom_header_top_checked = '';   	
  }
  ?>
    <input type="checkbox" id="astra_custom_header_top_id" name="astra_custom_header_top" value="yes" <?php echo $astra_custom_header_top_checked; ?> />
  <?php
  echo __('<label for="astra_custom_header_top_id">Disable Header Top For This Page</label>', 'client-custom-elementor-plugin-textdomain');

}

// Save Meta Details
add_action('save_post', 'save_details');

function save_details(){
  global $post;

if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
    return $post->ID;
}

  update_post_meta($post->ID, "astra_custom_header_top", $_POST["astra_custom_header_top"]);
}
