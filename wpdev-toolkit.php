<?php
/*
Plugin Name: WP Developers Toolkit
Plugin URI: http://wpdevelopers.com
Description: Load WordPress faster with special, optimized settings and improve the backend of WordPress.
Version: 2.3.1
Author: Tyler Johnson
Author URI: http://tylerjohnsondesign.com/
Copyright: Tyler Johnson
Text Domain: wpdevrock
*/


/**
 * Plugin Updates
 */
require 'plugin-update-checker-3.0/plugin-update-checker.php';
$wpdevtoolsClassName = PucFactory::getLatestClassVersion('PucGitHubChecker');
$wpdevtoolsUpdateChecker = new $wpdevtoolsClassName(
    'https://github.com/LibertyAllianceGit/wpdev-toolkit',
    __FILE__,
    'master'
);


/**
 * Plugin CSS
 */
function wpdev_tools_plugin_files() {
        wp_enqueue_style( 'wpdev-tools-plugin-css', plugin_dir_url(__FILE__) . 'inc/wpdev-tools-plugin-css.css' );
}
add_action('admin_enqueue_scripts', 'wpdev_tools_plugin_files', 20);


/*--------------------
PLUGIN OPTIONS
--------------------*/

class WPDevToolkit { 
    private $wpdev_toolkit_options; 
    
    public function __construct() { 
        add_action( 'admin_menu', array( $this, 'wpdev_toolkit_add_plugin_page' ) ); 
        add_action( 'admin_init', array( $this, 'wpdev_toolkit_page_init' ) ); 
    } 
    
    public function wpdev_toolkit_add_plugin_page() { 
        add_menu_page( 'WPDev Toolkit', // page_title
                      'WPDev Toolkit', // menu_title
                      'manage_options', // capability
                      'wpdev-toolkit', // menu_slug
                      array( $this, 'wpdev_toolkit_create_admin_page' ), // function
                      'dashicons-hammer', // icon_url
                      100 // position 
                     ); 
    } 
    
    public function wpdev_toolkit_create_admin_page() { 
        $this->wpdev_toolkit_options = get_option( 'wpdev_toolkit_option_name' ); ?>

        <div class="wrap wpdev-toolkit-wrap">
            <h2 class="wpdev-toolkit-logo"><img src="<?php echo plugin_dir_url(__FILE__) . 'inc/toolkit-logo.png'; ?>" /></h2>
            <p></p>
            <?php settings_errors(); ?>

                <form method="post" action="options.php">
                    <?php
                            settings_fields( 'wpdev_toolkit_option_group' );
                            do_settings_sections( 'wpdev-toolkit-admin' );
                            submit_button();
                        ?>
                </form>
        </div>
<?php }

	public function wpdev_toolkit_page_init() {
		register_setting(
			'wpdev_toolkit_option_group', // option_group
			'wpdev_toolkit_option_name', // option_name
			array( $this, 'wpdev_toolkit_sanitize' ) // sanitize_callback
		);

		add_settings_section(
			'wpdev_toolkit_setting_section_frontend', // id
			'Frontend', // title
			array( $this, 'wpdev_toolkit_section_info' ), // callback
			'wpdev-toolkit-admin' // page
		);

		add_settings_field(
			'enqueue_css_files_0', // id
			'Enqueue CSS Files', // title
			array( $this, 'enqueue_css_files_0_callback' ), // callback
			'wpdev-toolkit-admin', // page
			'wpdev_toolkit_setting_section_frontend' // section
		);

		add_settings_field(
			'enqueue_js_files_1', // id
			'Enqueue JS Files', // title
			array( $this, 'enqueue_js_files_1_callback' ), // callback
			'wpdev-toolkit-admin', // page
			'wpdev_toolkit_setting_section_frontend' // section
		);

		add_settings_field(
			'load_js_via_async_2', // id
			'Load JS via Async', // title
			array( $this, 'load_js_via_async_2_callback' ), // callback
			'wpdev-toolkit-admin', // page
			'wpdev_toolkit_setting_section_frontend' // section
		);

		add_settings_field(
			'load_jquery_from_google_3', // id
			'Load jQuery from Google', // title
			array( $this, 'load_jquery_from_google_3_callback' ), // callback
			'wpdev-toolkit-admin', // page
			'wpdev_toolkit_setting_section_frontend' // section
		);

		add_settings_field(
			'remove_query_strings_4', // id
			'Remove Query Strings', // title
			array( $this, 'remove_query_strings_4_callback' ), // callback
			'wpdev-toolkit-admin', // page
			'wpdev_toolkit_setting_section_frontend' // section
		);

		add_settings_field(
			'remove_emoji_scripts_5', // id
			'Remove Emoji Scripts', // title
			array( $this, 'remove_emoji_scripts_5_callback' ), // callback
			'wpdev-toolkit-admin', // page
			'wpdev_toolkit_setting_section_frontend' // section
		);
        
        add_settings_section(
			'wpdev_toolkit_setting_section_backend', // id
			'Backend', // title
			array( $this, 'wpdev_toolkit_section_info' ), // callback
			'wpdev-toolkit-admin' // page
		);
        
        add_settings_field(
			'enable_newwindow_bydefault_6', // id
			'Enable New Window Checkbox Checked by Default', // title
			array( $this, 'enable_newwindow_bydefault_6_callback' ), // callback
			'wpdev-toolkit-admin', // page
			'wpdev_toolkit_setting_section_backend' // section
		);
        
        add_settings_field(
			'remove_dashboard_widgets_6', // id
			'Remove Dashboard Widgets', // title
			array( $this, 'remove_dashboard_widgets_6_callback' ), // callback
			'wpdev-toolkit-admin', // page
			'wpdev_toolkit_setting_section_backend' // section
		);

		add_settings_field(
			'restrict_important_access_6', // id
			'Restrict Important Access', // title
			array( $this, 'restrict_important_access_6_callback' ), // callback
			'wpdev-toolkit-admin', // page
			'wpdev_toolkit_setting_section_backend' // section
		);

		add_settings_field(
			'allow_access_7', // id
			'Allow Access', // title
			array( $this, 'allow_access_7_callback' ), // callback
			'wpdev-toolkit-admin', // page
			'wpdev_toolkit_setting_section_backend' // section
		);

		add_settings_field(
			'liberty_alliance_theme_8', // id
			'Liberty Alliance Theme', // title
			array( $this, 'liberty_alliance_theme_8_callback' ), // callback
			'wpdev-toolkit-admin', // page
			'wpdev_toolkit_setting_section_backend' // section
		);

		add_settings_field(
			'replace_howdy_name_with_welcome_name_9', // id
			'Replace Howdy', // title
			array( $this, 'replace_howdy_name_with_welcome_name_9_callback' ), // callback
			'wpdev-toolkit-admin', // page
			'wpdev_toolkit_setting_section_backend' // section
		);

		add_settings_field(
			'add_support_widget_to_dashboard_10', // id
			'Add Support Widget to Dashboard', // title
			array( $this, 'add_support_widget_to_dashboard_10_callback' ), // callback
			'wpdev-toolkit-admin', // page
			'wpdev_toolkit_setting_section_backend' // section
		);

		add_settings_field(
			'add_support_widget_message_on_dashboard_11', // id
			'Add Support Widget Message on Dashboard', // title
			array( $this, 'add_support_widget_message_on_dashboard_11_callback' ), // callback
			'wpdev-toolkit-admin', // page
			'wpdev_toolkit_setting_section_backend' // section
		);

		add_settings_field(
			'add_support_widget_support_contact_12', // id
			'Add Support Widget Support Contact', // title
			array( $this, 'add_support_widget_support_contact_12_callback' ), // callback
			'wpdev-toolkit-admin', // page
			'wpdev_toolkit_setting_section_backend' // section
		);

		add_settings_field(
			'support_name_13', // id
			'Support Name', // title
			array( $this, 'support_name_13_callback' ), // callback
			'wpdev-toolkit-admin', // page
			'wpdev_toolkit_setting_section_backend' // section
		);

		add_settings_field(
			'support_email_14', // id
			'Support Email', // title
			array( $this, 'support_email_14_callback' ), // callback
			'wpdev-toolkit-admin', // page
			'wpdev_toolkit_setting_section_backend' // section
		);
	}

	public function wpdev_toolkit_sanitize($input) {
		$sanitary_values = array();
		if ( isset( $input['enqueue_css_files_0'] ) ) {
			$sanitary_values['enqueue_css_files_0'] = esc_textarea( $input['enqueue_css_files_0'] );
		}

		if ( isset( $input['enqueue_js_files_1'] ) ) {
			$sanitary_values['enqueue_js_files_1'] = esc_textarea( $input['enqueue_js_files_1'] );
		}

		if ( isset( $input['load_js_via_async_2'] ) ) {
			$sanitary_values['load_js_via_async_2'] = esc_textarea( $input['load_js_via_async_2'] );
		}

		if ( isset( $input['load_jquery_from_google_3'] ) ) {
			$sanitary_values['load_jquery_from_google_3'] = $input['load_jquery_from_google_3'];
		}

		if ( isset( $input['remove_query_strings_4'] ) ) {
			$sanitary_values['remove_query_strings_4'] = $input['remove_query_strings_4'];
		}

		if ( isset( $input['remove_emoji_scripts_5'] ) ) {
			$sanitary_values['remove_emoji_scripts_5'] = $input['remove_emoji_scripts_5'];
		}
        
        if ( isset( $input['enable_newwindow_bydefault_6'] ) ) {
            $sanitary_values['enable_newwindow_bydefault_6'] = $input['enable_newwindow_bydefault_6'];
        }
        
        if ( isset( $input['remove_dashboard_widgets_6'] ) ) {
			$sanitary_values['remove_dashboard_widgets_6'] = $input['remove_dashboard_widgets_6'];
		}

		if ( isset( $input['restrict_important_access_6'] ) ) {
			$sanitary_values['restrict_important_access_6'] = $input['restrict_important_access_6'];
		}

		if ( isset( $input['allow_access_7'] ) ) {
			$sanitary_values['allow_access_7'] = esc_textarea( $input['allow_access_7'] );
		}

		if ( isset( $input['liberty_alliance_theme_8'] ) ) {
			$sanitary_values['liberty_alliance_theme_8'] = $input['liberty_alliance_theme_8'];
		}

		if ( isset( $input['replace_howdy_name_with_welcome_name_9'] ) ) {
			$sanitary_values['replace_howdy_name_with_welcome_name_9'] = $input['replace_howdy_name_with_welcome_name_9'];
		}

		if ( isset( $input['add_support_widget_to_dashboard_10'] ) ) {
			$sanitary_values['add_support_widget_to_dashboard_10'] = $input['add_support_widget_to_dashboard_10'];
		}

		if ( isset( $input['add_support_widget_message_on_dashboard_11'] ) ) {
			$sanitary_values['add_support_widget_message_on_dashboard_11'] = esc_textarea( $input['add_support_widget_message_on_dashboard_11'] );
		}

		if ( isset( $input['add_support_widget_support_contact_12'] ) ) {
			$sanitary_values['add_support_widget_support_contact_12'] = $input['add_support_widget_support_contact_12'];
		}

		if ( isset( $input['support_name_13'] ) ) {
			$sanitary_values['support_name_13'] = sanitize_text_field( $input['support_name_13'] );
		}

		if ( isset( $input['support_email_14'] ) ) {
			$sanitary_values['support_email_14'] = sanitize_text_field( $input['support_email_14'] );
		}

		return $sanitary_values;
	}

	public function wpdev_toolkit_section_info() {
		
	}

	public function enqueue_css_files_0_callback() {
		printf(
			'<textarea class="large-text" rows="5" placeholder="http://sitename.com/wp-content/theme/style.css,https://fonts.googleapis.com/css?family=Open+Sans" name="wpdev_toolkit_option_name[enqueue_css_files_0]" id="enqueue_css_files_0">%s</textarea><label class="wpdev-toolkit-description wpdev-toolkit-description-textarea for="enqueue_css_files_0">Load internal or external CSS files via the enqueue action for faster loading and proper ordering of styles. Enter a comma separated list.</label>',
			isset( $this->wpdev_toolkit_options['enqueue_css_files_0'] ) ? esc_attr( $this->wpdev_toolkit_options['enqueue_css_files_0']) : ''
		);
	}

	public function enqueue_js_files_1_callback() {
		printf(
			'<textarea class="large-text" rows="5" placeholder="http://sitename.com/wp-content/theme/script.js,https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" name="wpdev_toolkit_option_name[enqueue_js_files_1]" id="enqueue_js_files_1">%s</textarea><label class="wpdev-toolkit-description wpdev-toolkit-description-textarea for="enqueue_js_files_1">Load internal or external JS files via the enqueue action for faster loading and proper ordering of scripts. Enter a comma separated list.</label>',
			isset( $this->wpdev_toolkit_options['enqueue_js_files_1'] ) ? esc_attr( $this->wpdev_toolkit_options['enqueue_js_files_1']) : ''
		);
	}

	public function load_js_via_async_2_callback() {
		printf(
			'<textarea class="large-text" rows="5" placeholder="jquery.js,jquery-migrate.js,bootstrap.js" name="wpdev_toolkit_option_name[load_js_via_async_2]" id="load_js_via_async_2">%s</textarea><label class="wpdev-toolkit-description wpdev-toolkit-description-textarea for="load_js_via_async_2">Load enqueued JavaScript via Async for faster loading. Enter comma separated list of file names.</label>',
			isset( $this->wpdev_toolkit_options['load_js_via_async_2'] ) ? esc_attr( $this->wpdev_toolkit_options['load_js_via_async_2']) : ''
		);
	}

	public function load_jquery_from_google_3_callback() {
		printf(
			'<input type="checkbox" name="wpdev_toolkit_option_name[load_jquery_from_google_3]" id="load_jquery_from_google_3" value="load_jquery_from_google_3" %s><label class="wpdev-toolkit-description wpdev-toolkit-description-checkbox" for="load_jquery_from_google_3">Load jQuery from Google for faster loading.</label>',
			( isset( $this->wpdev_toolkit_options['load_jquery_from_google_3'] ) && $this->wpdev_toolkit_options['load_jquery_from_google_3'] === 'load_jquery_from_google_3' ) ? 'checked' : ''
		);
	}

	public function remove_query_strings_4_callback() {
		printf(
			'<input type="checkbox" name="wpdev_toolkit_option_name[remove_query_strings_4]" id="remove_query_strings_4" value="remove_query_strings_4" %s><label class="wpdev-toolkit-description wpdev-toolkit-description-checkbox" for="remove_query_strings_4">Remove query strings from static resources for better caching.</label>',
			( isset( $this->wpdev_toolkit_options['remove_query_strings_4'] ) && $this->wpdev_toolkit_options['remove_query_strings_4'] === 'remove_query_strings_4' ) ? 'checked' : ''
		);
	}

	public function remove_emoji_scripts_5_callback() {
		printf(
			'<input type="checkbox" name="wpdev_toolkit_option_name[remove_emoji_scripts_5]" id="remove_emoji_scripts_5" value="remove_emoji_scripts_5" %s><label class="wpdev-toolkit-description wpdev-toolkit-description-checkbox" for="remove_emoji_scripts_5">Remove unnecessary Emoji JavaScript included with WordPress for emoji support.</label>',
			( isset( $this->wpdev_toolkit_options['remove_emoji_scripts_5'] ) && $this->wpdev_toolkit_options['remove_emoji_scripts_5'] === 'remove_emoji_scripts_5' ) ? 'checked' : ''
		);
	}
    
    public function enable_newwindow_bydefault_6_callback() {
        printf(
            '<input type="checkbox" name="wpdev_toolkit_option_name[enable_newwindow_bydefault_6]" id="enable_newwindow_bydefault_6" value="enable_newwindow_bydefault_6" %s><label class="wpdev-toolkit-description wpdev-toolkit-description-checkbox" for="enable_newwindow_bydefault_6">Enable New Window Checkbox Checked by Default on Backend.</label>',
            ( isset( $this->wpdev_toolkit_options['enable_newwindow_bydefault_6'] ) && $this->wpdev_toolkit_options['enable_newwindow_bydefault_6'] === 'enable_newwindow_bydefault_6' ) ? 'checked' : ''
        );
    }
    
    public function remove_dashboard_widgets_6_callback() {
		printf(
			'<input type="checkbox" name="wpdev_toolkit_option_name[remove_dashboard_widgets_6]" id="remove_dashboard_widgets_6" value="remove_dashboard_widgets_6" %s><label class="wpdev-toolkit-description wpdev-toolkit-description-checkbox" for="remove_dashboard_widgets_6">Remove superfluous dashboard widgets for a faster backend.</label>',
			( isset( $this->wpdev_toolkit_options['remove_dashboard_widgets_6'] ) && $this->wpdev_toolkit_options['remove_dashboard_widgets_6'] === 'remove_dashboard_widgets_6' ) ? 'checked' : ''
		);
	}

	public function restrict_important_access_6_callback() {
		printf(
			'<input type="checkbox" name="wpdev_toolkit_option_name[restrict_important_access_6]" id="restrict_important_access_6" value="restrict_important_access_6" %s><label class="wpdev-toolkit-description wpdev-toolkit-description-checkbox" for="restrict_important_access_6">Remove access to important areas of the site (settings, plugins, updates, etc.) for users. Default excluded users are wpengine, tedslater, tylerjohnson, and billyengler.</label>',
			( isset( $this->wpdev_toolkit_options['restrict_important_access_6'] ) && $this->wpdev_toolkit_options['restrict_important_access_6'] === 'restrict_important_access_6' ) ? 'checked' : ''
		);
	}

	public function allow_access_7_callback() {
		printf(
			'<textarea class="large-text" rows="5" placeholder="username,username,username" name="wpdev_toolkit_option_name[allow_access_7]" id="allow_access_7">%s</textarea><label class="wpdev-toolkit-description wpdev-toolkit-description-textarea for="allow_access_7">Grant access to important areas of the site for additional users. Enter usernames in a comma separated list.</label>',
			isset( $this->wpdev_toolkit_options['allow_access_7'] ) ? esc_attr( $this->wpdev_toolkit_options['allow_access_7']) : ''
		);
	}

	public function liberty_alliance_theme_8_callback() {
		printf(
			'<input type="checkbox" name="wpdev_toolkit_option_name[liberty_alliance_theme_8]" id="liberty_alliance_theme_8" value="liberty_alliance_theme_8" %s><label class="wpdev-toolkit-description wpdev-toolkit-description-checkbox" for="liberty_alliance_theme_8">Enable the custom Liberty Alliance Dashboard theme, which removes all references to WordPress.</label>',
			( isset( $this->wpdev_toolkit_options['liberty_alliance_theme_8'] ) && $this->wpdev_toolkit_options['liberty_alliance_theme_8'] === 'liberty_alliance_theme_8' ) ? 'checked' : ''
		);
	}

	public function replace_howdy_name_with_welcome_name_9_callback() {
		printf(
			'<input type="checkbox" name="wpdev_toolkit_option_name[replace_howdy_name_with_welcome_name_9]" id="replace_howdy_name_with_welcome_name_9" value="replace_howdy_name_with_welcome_name_9" %s><label class="wpdev-toolkit-description wpdev-toolkit-description-checkbox" for="replace_howdy_name_with_welcome_name_9">Replace "Howdy, Username" with "Welcome, Username", for a more professional site.</label>',
			( isset( $this->wpdev_toolkit_options['replace_howdy_name_with_welcome_name_9'] ) && $this->wpdev_toolkit_options['replace_howdy_name_with_welcome_name_9'] === 'replace_howdy_name_with_welcome_name_9' ) ? 'checked' : ''
		);
	}

	public function add_support_widget_to_dashboard_10_callback() {
		printf(
			'<input type="checkbox" name="wpdev_toolkit_option_name[add_support_widget_to_dashboard_10]" id="add_support_widget_to_dashboard_10" value="add_support_widget_to_dashboard_10" %s><label class="wpdev-toolkit-description wpdev-toolkit-description-checkbox" for="add_support_widget_to_dashboard_10">Enable the support message dashboard widget.</label>',
			( isset( $this->wpdev_toolkit_options['add_support_widget_to_dashboard_10'] ) && $this->wpdev_toolkit_options['add_support_widget_to_dashboard_10'] === 'add_support_widget_to_dashboard_10' ) ? 'checked' : ''
		);
	}

	public function add_support_widget_message_on_dashboard_11_callback() {
		printf(
			'<textarea class="large-text" rows="5" placeholder="Welcome to the site, which is partnered with Liberty Alliance..." name="wpdev_toolkit_option_name[add_support_widget_message_on_dashboard_11]" id="add_support_widget_message_on_dashboard_11">%s</textarea><label class="wpdev-toolkit-description wpdev-toolkit-description-textarea for="add_support_widget_message_on_dashboard_11">Create a custom support message for the support dashboard widget. Leave empty for default message.</label>',
			isset( $this->wpdev_toolkit_options['add_support_widget_message_on_dashboard_11'] ) ? esc_attr( $this->wpdev_toolkit_options['add_support_widget_message_on_dashboard_11']) : ''
		);
	}

	public function add_support_widget_support_contact_12_callback() {
		printf(
			'<input type="checkbox" name="wpdev_toolkit_option_name[add_support_widget_support_contact_12]" id="add_support_widget_support_contact_12" value="add_support_widget_support_contact_12" %s><label class="wpdev-toolkit-description wpdev-toolkit-description-checkbox" for="add_support_widget_support_contact_12">Add support contact email link to support dashboard widget. Adds message, "For support, please contact Name". Message is only viewable to administrator users.</label>',
			( isset( $this->wpdev_toolkit_options['add_support_widget_support_contact_12'] ) && $this->wpdev_toolkit_options['add_support_widget_support_contact_12'] === 'add_support_widget_support_contact_12' ) ? 'checked' : ''
		);
	}

	public function support_name_13_callback() {
		printf(
			'<input class="regular-text" type="text" placeholder="Support Name" name="wpdev_toolkit_option_name[support_name_13]" id="support_name_13" value="%s"><label class="wpdev-toolkit-description wpdev-toolkit-description-text" for="support_name_13">Add support contact name.</label>',
			isset( $this->wpdev_toolkit_options['support_name_13'] ) ? esc_attr( $this->wpdev_toolkit_options['support_name_13']) : ''
		);
	}

	public function support_email_14_callback() {
		printf(
			'<input class="regular-text" type="text" placeholder="Support Email" name="wpdev_toolkit_option_name[support_email_14]" id="support_email_14" value="%s"><label class="wpdev-toolkit-description wpdev-toolkit-description-text" for="support_email_14">Add support contact email.</label>',
			isset( $this->wpdev_toolkit_options['support_email_14'] ) ? esc_attr( $this->wpdev_toolkit_options['support_email_14']) : ''
		);
	}

}
if ( is_admin() )
	$wpdev_toolkit = new WPDevToolkit();


/*--------------------
LOAD OPTIONS
--------------------*/

// Load Main Options
$tools = get_option( 'wpdev_toolkit_option_name' );

// Load Sub-Options
$enqueuecss     = $tools['enqueue_css_files_0'];
$enqueuejs      = $tools['enqueue_js_files_1'];
$asyncjs        = $tools['load_js_via_async_2'];
$googlejs       = $tools['load_jquery_from_google_3'];
$removestrings  = $tools['remove_query_strings_4'];
$removeemoji    = $tools['remove_emoji_scripts_5'];
$enablenewwin   = $tools['enable_newwindow_bydefault_6'];
$removedash     = $tools['remove_dashboard_widgets_6'];
$restrictaccess = $tools['restrict_important_access_6'];
$allowaccess    = $tools['allow_access_7'];
$enabletheme    = $tools['liberty_alliance_theme_8'];
$replacehowdy   = $tools['replace_howdy_name_with_welcome_name_9'];
$supportwidget  = $tools['add_support_widget_to_dashboard_10'];
$supportmessage = $tools['add_support_widget_message_on_dashboard_11'];
$supportcontact = $tools['add_support_widget_support_contact_12'];
$supportname    = $tools['support_name_13'];
$supportemail   = $tools['support_email_14'];


/*--------------------
SPEED ENHANCEMENTS
--------------------*/

/**
 * Speed Up JS & CSS via wp_enqueue
 */
function wpdev_external_scripts() {
    
    // Enqueue CSS
    global $enqueuecss;
    if(!empty($enqueuecss)) {
        $stylearray = explode(",", $enqueuecss);
        $stylecount = 0;
        foreach($stylearray as $style) {
            $stylecount++;
            wp_enqueue_style('wpdev-tools-style-' . $stylecount, $style);
        }
    }
    
    // Enqueue JS
    global $enqueuejs;
    if(!empty($enqueuejs)) {
        $scriptarray = explode(",", $enqueuejs);
        $scriptcount = 0;
        foreach($scriptarray as $script) {
            $scriptcount++;
            wp_enqueue_script('wpdev-tools-script-' . $scriptcount, $script, array('jquery'));
        }
    }
}
add_action('wp_enqueue_scripts', 'wpdev_external_scripts', 20);


/**
 * Speed Up JS - Load via async
 */
function wpdev_tools_async($tag) {
    global $asyncjs;
    if(!empty($asyncjs)) {
        $asyncscript = explode(",", $asyncjs);
        $asynccount = 0;
    
        // Add Async Attribute
        foreach($asyncscript as $script) {
            if(true == @strpos($tag, $script)) {
                return str_replace(' src', ' async="async" src', $tag);
            }
	    }
        return $tag;
    } else {
        return $tag;
    }
}
add_filter('script_loader_tag', 'wpdev_tools_async');


/**
 * Speed Up JS - Load jQuery via Google Servers
 */
function wpdev_tools_modify_jquery() {
    global $googlejs;
    if(!empty($googlejs)) {
        wp_deregister_script('jquery');
        wp_register_script('jquery', '//ajax.googleapis.com/ajax/libs/jquery/1.12.3/jquery.min.js', false, '1.12.3');
        wp_enqueue_script('jquery');
    } else {
        // Nothing.
    }
}
add_action('init', 'wpdev_tools_modify_jquery');


/**
 * Speed Up Caching - Remove Query Strings from Static Resources
 */
function wpdev_remove_query_strings( $src ) {
    global $removestrings;
    if(!empty($removestrings)) {
        if( strpos( $src, '?ver=' ) )
        $src = remove_query_arg( 'ver', $src );
        return $src;
    } else {
        return $src;
    }
}
add_filter( 'style_loader_src', 'wpdev_remove_query_strings', 10, 2 );
add_filter( 'script_loader_src', 'wpdev_remove_query_strings', 10, 2 );


/**
 * Remove Emoji Scripts - Remove Emoji Script in Head
 */
global $removeemoji;
if(!empty($removeemoji)) {
    remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
    remove_action( 'wp_print_styles', 'print_emoji_styles' );
}


/**
 * Enable New Window Checked by Default
 */
function wpdev_tools_newwindow_js() {
    global $enablenewwin;
    if(!empty($enablenewwin)) {
        wp_enqueue_script( 'wpdev-tools-newwindow-js', plugin_dir_url( __FILE__ ) . 'inc/wpdev-tools-newwindow.js' );
    }
}
add_action('admin_enqueue_scripts', 'wpdev_tools_newwindow_js', 20);


/**
 * Speed Up Backend
 */

// Remove Dashboard Widgets
function wpdev_tools_dashboard_setup() {
    global $removedash;
    if(!empty($removedash)) {
        remove_meta_box( 'dashboard_plugins', 'dashboard', 'normal' );
        remove_meta_box( 'dashboard_primary', 'dashboard', 'normal' );
        remove_meta_box( 'dashboard_primary', 'dashboard', 'side' );
        remove_meta_box( 'dashboard_activity', 'dashboard', 'normal' );
        remove_meta_box( 'dashboard_right_now', 'dashboard', 'normal' );
        remove_meta_box( 'dashboard_secondary', 'dashboard', 'normal' );
        remove_meta_box( 'dashboard_quick_press', 'dashboard', 'side' );
        remove_meta_box( 'dashboard_browser_nag', 'dashboard', 'normal' );
        remove_meta_box( 'dashboard_recent_drafts', 'dashboard', 'side' );
        remove_meta_box( 'dashboard_incoming_links', 'dashboard', 'normal' );
        remove_meta_box( 'dashboard_incoming_links', 'dashboard', 'normal' );
        remove_meta_box( 'dashboard_recent_comments', 'dashboard', 'normal' );
    }
}
add_action('wp_dashboard_setup', 'wpdev_tools_dashboard_setup');


/**
 * Restrict Access
 */

// Hide Menu Items from All But Selected
function wpdev_tools_hide_items() {
    global $restrictaccess;
    global $allowaccess;
    if(!empty($restrictaccess)) {
        if(!empty($allowaccess)) {
            $userlist = array('tylerjohnson', 'tedslater', 'billyengler', 'wpengine');
            $optionlist = explode(",", $allowaccess);
            $combinelist = array_merge($userlist, $optionlist);
        } else {
            $combinelist = array('tylerjohnson', 'tedslater', 'billyengler', 'wpengine');
        }

        $idarray = array();
        foreach($combinelist as $list) {
            $userid = get_userdatabylogin($list);
            $idarray[] = $userid->id;
        }

        $current_user = wp_get_current_user();
        if(!in_array($current_user->ID, $idarray)) {

        remove_menu_page( 'themes.php' );                        // Appearance
        remove_menu_page( 'plugins.php' );                       // Plugins
        remove_menu_page( 'tools.php' );                         // Tools
        remove_menu_page( 'options-general.php' );               // Settings
        remove_menu_page( 'wpdev-toolkit' );                     // WPDev Tools Settings
        add_action( 'admin_init', 'wpdev_remove_wpengine' );     // WP Engine

        } else {
            // Nothing to see here.
        }
    } else {
        // Nothing at all.
    }
    
}
add_action('admin_menu', 'wpdev_tools_hide_items');

// Remove Update Notices
function wpdev_tools_hide_update_notice() {
    global $restrictaccess;
    global $allowaccess;
    
    if(!empty($restrictaccess)) {
        if(!empty($allowaccess)) {
            $userlist = array('tylerjohnson', 'tedslater', 'billyengler', 'wpengine');
            $optionlist = explode(",", $allowaccess);
            $combinelist = array_merge($userlist, $optionlist);
        } else {
            $combinelist = array('tylerjohnson', 'tedslater', 'billyengler', 'wpengine');
        }

        $idarray = array();
        foreach($combinelist as $list) {
            $userid = get_userdatabylogin($list);
            $idarray[] = $userid->id;
        }

        $current_user = wp_get_current_user();
        if(!in_array($current_user->ID, $idarray)) {
            remove_action( 'admin_notices', 'update_nag', 3 );
        }
    } else {
        // Nothing at all.
    }
}
add_action( 'admin_head', 'wpdev_tools_hide_update_notice', 1 );


// Remove Update Notices from Admin Bar
function wpdev_tools_hide_update_adminbar() {
    global $restrictaccess;
    global $allowaccess;
    global $wp_admin_bar;
    
    if(!empty($restrictaccess)) {
        if(!empty($allowaccess)) {
            $userlist = array('tylerjohnson', 'tedslater', 'billyengler', 'wpengine');
            $optionlist = explode(",", $allowaccess);
            $combinelist = array_merge($userlist, $optionlist);
        } else {
            $combinelist = array('tylerjohnson', 'tedslater', 'billyengler', 'wpengine');
        }

        $idarray = array();
        foreach($combinelist as $list) {
            $userid = get_userdatabylogin($list);
            $idarray[] = $userid->id;
        }

        $current_user = wp_get_current_user();
        if(!in_array($current_user->ID, $idarray)) {
            $wp_admin_bar->remove_menu('updates');
            $wp_admin_bar->remove_menu('wpengine_adminbar');
            $wp_admin_bar->remove_menu('customize');
        }
    } else {
        // Nothing at all.
    }
}
add_action( 'wp_before_admin_bar_render', 'wpdev_tools_hide_update_adminbar', 1 );


// Remove WP Engine Tab
function wpdev_remove_wpengine() {
    remove_menu_page( 'wpengine-common' );
}


/**
 * Custom Dashboard Theme
 */

// Remove Menu Bar Items
function wpdev_tools_remove_admin_bar_links() {
    global $enabletheme;
    global $wp_admin_bar;
    if(!empty($enabletheme)) {
        $wp_admin_bar->remove_menu('wp-logo');          // Remove the WordPress logo
        $wp_admin_bar->remove_menu('about');            // Remove the about WordPress link
        $wp_admin_bar->remove_menu('wporg');            // Remove the WordPress.org link
        $wp_admin_bar->remove_menu('documentation');    // Remove the WordPress documentation link
        $wp_admin_bar->remove_menu('support-forums');   // Remove the support forums link
        $wp_admin_bar->remove_menu('feedback');         // Remove the feedback link
        $wp_admin_bar->remove_menu('updates');          // Remove the updates link
        $wp_admin_bar->remove_menu('new-content');      // Remove the content link
    }
}
add_action( 'wp_before_admin_bar_render', 'wpdev_tools_remove_admin_bar_links' );


// Custom WordPress Link
function wpdevtools_custom_toolbar_link( $wp_admin_bar ) {
    global $enabletheme;
    if(!empty($enabletheme)) {
        $args = array(
            'id'    => 'libertyalliance-menu',
            'title' => '<img src="' . plugin_dir_url(__FILE__) . 'inc/dashboard-la-logo.png"/>',
            'href'  => '//libertyalliance.com/',
            'meta'  => array( 'class' => 'libertyalliance-menu', 'target' => '_blank' )
        );
        $wp_admin_bar->add_node( $args );
    }
}
add_action( 'admin_bar_menu', 'wpdevtools_custom_toolbar_link', 0 );


// Custom Admin Dashboard CSS
function wpdev_tools_admin_css() {
    global $enabletheme;
    if(!empty($enabletheme)) {
        wp_register_style( 'wpdev-tools-admin-css', plugin_dir_url(__FILE__) . 'inc/wpdev-tools-admin-css.css' );
        wp_enqueue_style( 'wpdev-tools-admin-css' );
    }
}
add_action('admin_enqueue_scripts', 'wpdev_tools_admin_css', 20);


// Custom Admin Footer Message
function wpdev_tools_custom_footer_dash_mess() {
    global $enabletheme;
    if(!empty($enabletheme)) {
        echo 'Developed & Maintained by <a href="http://libertyalliance.com" target="_blank">Liberty Alliance</a>, an Inc. 5000 Company.';
    }
}
add_filter('admin_footer_text', 'wpdev_tools_custom_footer_dash_mess');


// Replace Howdy
function wpdev_tools_replace_howdy($wp_admin_bar) {
    global $replacehowdy; 
    if(!empty($replacehowdy)) {
        $my_account = $wp_admin_bar->get_node('my-account');
        $newtitle = str_replace('Howdy', 'Welcome', $my_account->title);
        $wp_admin_bar->add_node(array(
            'id'    =>  'my-account',
            'title' =>  $newtitle,
        ));
    }
}
add_filter('admin_bar_menu', 'wpdev_tools_replace_howdy', 25);


// Add Custom Dashboard Widget
function wpdev_tools_custom_dashboard_widget() {
    global $supportwidget;
    global $wp_meta_boxes;
    
    if(!empty($supportwidget)) {
        wp_add_dashboard_widget('custom message widget', 'Welcome to Liberty Alliance', 'wpdev_tools_welcome_widget');
    }
}
add_action('wp_dashboard_setup', 'wpdev_tools_custom_dashboard_widget', 1);

function wpdev_tools_welcome_widget() {
    global $supportwidget;
    global $supportmessage;
    global $supportcontact;
    global $supportname;
    global $supportemail;
    
    if(!empty($supportwidget)) {
        if(!empty($supportmessage)) {
            $message .= '<p>' . $supportmessage . '</p>';
        } else {
            $message .= '<p>Liberty Alliance is a network of web sites dedicated to advancing Life, Liberty, and the Pursuit of Happiness. Our members and strategic partners leverage the power of new media to promote traditional values and generate millions of page views each day. We\'re glad you\'ve joined us.</p>';
        }
        
        if(!empty($supportcontact) && current_user_can('manage_options')) {
            if(!empty($supportname) && !empty($supportemail)) {
                $message .= '<p>Do you need help? Contact your developer, ' . $supportname . ', via email <a href="mailto:' . $supportemail . '">HERE</a>.</p>';
            } else {
                $message .= '<p>Do you need help? You can access Liberty Alliance\'s support site <a href="//help.libertyalliance.com" target="_blank">HERE</a>. The password to login is <strong>HelpLiberty</strong>.</p>';
            }
        }
        
        $message .= '<p>Have a wonderful day!</p>';
        
        echo $message;
    }
}
