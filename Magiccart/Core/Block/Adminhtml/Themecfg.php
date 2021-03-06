<?php
/**
 * Magiccart 
 * @category 	Magiccart 
 * @copyright 	Copyright (c) 2014 Magiccart (http://www.magiccart.net/) 
 * @license 	http://www.magiccart.net/license-agreement.html
 * @Author: DOng NGuyen<nguyen@dvn.com>
 * @@Create Date: 2017-01-25 00:34:11
 * @@Modify Date: 2018-06-11 16:52:51
 * @@Function:
 */

namespace Magiccart\Core\Block\Adminhtml;
use Magiccart\Core\Model\System\Boole;
use Magiccart\Core\Model\System\Col;
use Magiccart\Core\Model\System\Row;
use Magiccart\Core\Model\System\Post;
use Magiccart\Core\Model\System\Theme\Option;

/**
 * ReduxFramework Barebones Sample Config File
 * For full documentation, please visit: http://docs.reduxframework.com/
 */
global $redux_demo;
$redux_demo = null;

if ( ! class_exists( 'Redux' ) ) {
	return;
}

class Themecfg{
	public 	$_opt;
	public 	$_objOptions;
	public 	$post;
	public 	$_url        = MAGICCART_URL . 'Core/view/adminhtml/web/images/';
	public 	$_templateDir;
	public 	$_templateUri;
	public 	$_redux;
	private $_optionsValue;
	private $_bool;
	private $_col;
	private $_row;
	private $_page_slug = 'magiccart_options';
	private $_static = '/Magiccart/Core/view/adminhtml/web/';
	public function __construct(){

		$this->_bool = new Boole();
		$this->_col  = new Col();
		$this->_row  = new Row();
		$this->_redux = new \Redux();
		$this->_objOptions = new Option();
		$this->post  = new Post();
		$this->_opt = $this->_objOptions->getName();
		$this->_optionsValue = $this->get_option($this->_opt);
		$this->_templateDir = get_template_directory();
		$this->_templateUri = get_template_directory_uri();
		/**
		 * ---> SET ARGUMENTS
		 * All the possible arguments for Redux.
		 * For full documentation on arguments, please refer to: https://github.com/ReduxFramework/ReduxFramework/wiki/Arguments
		 * */
		$this->_redux->setArgs( $this->_opt, $this->settings());

		if( !isset($_GET['page']) || $_GET['page'] != $this->_page_slug ) return;

		add_action('admin_init', array($this, 'addStatic'));

		$this->_redux->setHelpTab( $this->_opt, $this->helptabs() );
		$this->_redux->setHelpSidebar( $this->_opt, $this->helpSidebar() );
		$this->_redux->setSection( $this->_opt, $this->optionConfigTheme());
		$this->_redux->setSection( $this->_opt, $this->general());
		$this->_redux->setSection( $this->_opt, $this->design());
		$this->_redux->setSection( $this->_opt, $this->font());
		//$this->_redux->setSection( $this->_opt, $this->background());
		$this->_redux->setSection( $this->_opt,$this->color());
		// $this->_redux->setSection( $this->_opt,$this->skin());
		// $this->_redux->setSection( $this->_opt, $this->header());
		// $this->_redux->setSection( $this->_opt, $this->product());
		$this->_redux->setSection( $this->_opt, $this->product_shop());
		$this->_redux->setSection( $this->_opt, $this->product_category());
		$this->_redux->setSection( $this->_opt, $this->page_cart());
		$this->_redux->setSection( $this->_opt, $this->blog());
		$this->_redux->setSection( $this->_opt, $this->portfolio());
		$this->_redux->setSection( $this->_opt, $this->portfolio_related());
		// $this->_redux->setSection( $this->_opt, $this->instagram());
		//$this->_redux->setSection( $this->_opt, $this->sidebar());
		$this->_redux->setSection( $this->_opt, $this->single_page());
		$this->_redux->setSection( $this->_opt, $this->single_page_blog());
		$this->_redux->setSection( $this->_opt, $this->post_related());
		$this->_redux->setSection( $this->_opt, $this->single_page_product());
		$this->_redux->setSection( $this->_opt, $this->product_thumbnail());
		$this->_redux->setSection( $this->_opt, $this->product_related());
		$this->_redux->setSection( $this->_opt, $this->product_up_sells());
		// $this->_redux->setSection( $this->_opt, $this->footer());
		$this->_redux->setSection( $this->_opt, $this->newsletter());
		$this->_redux->setSection( $this->_opt, $this->customCss());
		$this->_redux->setSection( $this->_opt, $this->customJs());
		$this->_redux->setSection( $this->_opt, $this->developer());
		//$this->_redux->setSection( $this->_opt, $this->changeTheme());
		// $this->add_option_to_page();
	}

	private function get_option($opt)
	{
		return get_option($opt);
	}

	public function addStatic(){

	    $plugin = plugins_url();
	    wp_register_style('boxes', $plugin .  $this->_static . 'css/boxes.css', array(), '1.0');
	    wp_enqueue_style('boxes');
	    wp_register_script('mcolorpicker',  $plugin .  $this->_static . 'js/mcolorpicker/mcolorpicker.js', array('jquery') ,'1.0');
	    wp_enqueue_script('mcolorpicker');
	    wp_register_script('jquery-alothemes',  $plugin .  $this->_static . 'js/jquery.alothemes.js', array('jquery', 'mcolorpicker') ,'1.0');
	    wp_enqueue_script('jquery-alothemes');
	}
	
	public function settings(){
		
		$theme = wp_get_theme(); // For use with some settings. Not necessary.
		$args = array(
				// TYPICAL -> Change these values as you need/desire
				'opt_name'             => $this->_opt ,
				// This is where your data is stored in the database and also becomes your global variable name.
				'display_name'         => $theme->get( 'Name' ),
				// Name that appears at the top of your panel
				'display_version'      => $theme->get( 'Version' ),
				// Version that appears at the top of your panel
				'menu_type'            => 'submenu', // menu Or submenu
				//Specify if the admin menu should appear or not. Options: menu or submenu (Under appearance only)
				'allow_sub_menu'       => true,
				// Show the sections below the admin menu item or not
				'menu_title'           => __( 'Theme Options', 'alothemes' ),
				'page_title'           => __( 'Theme Options', 'alothemes' ),
				// You will need to generate a Google API key to use this feature.
				// Please visit: https://developers.google.com/fonts/docs/developer_api#Auth
				'google_api_key'       => '',
				// Set it you want google fonts to update weekly. A google_api_key value is required.
				'google_update_weekly' => true,
				// Must be defined to add google fonts to the typography module
				'async_typography'     => true,
				// Use a asynchronous font on the front end or font string
				//'disable_google_fonts_link' => true,                    // Disable this in case you want to create your own google fonts loader
				'admin_bar'            => true,
				// Show the panel pages on the admin bar
				'admin_bar_icon'       => 'dashicons-portfolio',
				// Choose an icon for the admin bar menu
				'admin_bar_priority'   => 50,
				// Choose an priority for the admin bar menu
				'global_variable'      => '',
				// Set a different name for your global variable other than the opt_name
				'dev_mode'             => true,
				// Show the time the page took to load, etc
				'update_notice'        => true,
				// If dev_mode is enabled, will notify developer of updated versions available in the GitHub Repo
				'customizer'           => true,
				// Enable basic customizer support
				//'open_expanded'     => true,                    // Allow you to start the panel in an expanded way initially.
				//'disable_save_warn' => true,                    // Disable the save warning when a user changes a field
		
				// OPTIONAL -> Give you extra features
				'page_priority'        => null,
				// Order where the menu appears in the admin area. If there is any conflict, something will not show. Warning.
				'page_parent'          => 'magiccart', // parent slug
				// For a full list of options, visit: http://codex.wordpress.org/Function_Reference/add_submenu_page#Parameters
				'page_permissions'     => 'manage_options',
				// Permissions needed to access the options panel.
				'menu_icon'            => '',
				// Specify a custom URL to an icon
				'last_tab'             => '',
				// Force your panel to always open to a specific tab (by id)
				'page_icon'            => 'icon-themes',
				// Icon displayed in the admin panel next to your menu_title
				'page_slug'            => $this->_page_slug,
				// Page slug used to denote the panel
				'save_defaults'        => true,
				// On load save the defaults to DB before user clicks save or not
				'default_show'         => false,
				// If true, shows the default value next to each field that is not the default value.
				'default_mark'         => '',
				// What to print by the field's title if the value shown is default. Suggested: *
				'show_import_export'   => true,
				// Shows the Import/Export panel when not used as a field.
		
				// CAREFUL -> These options are for advanced use only
				'transient_time'       => 60 * MINUTE_IN_SECONDS,
				'output'               => true,
				// Global shut-off for dynamic CSS output by the framework. Will also disable google fonts output
				'output_tag'           => true,
				// Allows dynamic CSS to be generated for customizer and google fonts, but stops the dynamic CSS from going to the head
				// 'footer_credit'     => '',                   // Disable the footer credit of Redux. Please leave if you can help it.
		
				// FUTURE -> Not in use yet, but reserved or partially implemented. Use at your own risk.
				'database'             => '',
				// possible: options, theme_mods, theme_mods_expanded, transient. Not fully functional, warning!
		
				'use_cdn'              => true,
					
				// Ajax
				'ajax_save'                 => false,
		
				// If you prefer not to use the CDN for Select2, Ace Editor, and others, you may download the Redux Vendor Support plugin yourself and run locally or embed it in your code.
		
				//'compiler'             => true,
		
				// HINTS
				'hints'                => array(
						'icon'          => 'el el-question-sign',
						'icon_position' => 'right',
						'icon_color'    => 'lightgray',
						'icon_size'     => 'normal',
						'tip_style'     => array(
								'color'   => 'light',
								'shadow'  => true,
								'rounded' => false,
								'style'   => '',
						),
						'tip_position'  => array(
								'my' => 'top left',
								'at' => 'bottom right',
						),
						'tip_effect'    => array(
								'show' => array(
										'effect'   => 'slide',
										'duration' => '500',
										'event'    => 'mouseover',
								),
								'hide' => array(
										'effect'   => 'slide',
										'duration' => '500',
										'event'    => 'click mouseleave',
								),
						),
				)
		);
		// ADMIN BAR LINKS -> Setup custom links in the admin bar menu as external items.
		$args['admin_bar_links'][] = array(
				'id'    => 'redux-docs',
				'href'  => 'http://docs.reduxframework.com/',
				'title' => __( 'Documentation', 'alothemes' ),
		);
		
		$args['admin_bar_links'][] = array(
				//'id'    => 'redux-support',
				'href'  => 'https://github.com/ReduxFramework/redux-framework/issues',
				'title' => __( 'Support', 'alothemes' ),
		);
		
		$args['admin_bar_links'][] = array(
				'id'    => 'redux-extensions',
				'href'  => 'reduxframework.com/extensions',
				'title' => __( 'Extensions', 'alothemes' ),
		);
		
		// SOCIAL ICONS -> Setup custom links in the footer for quick links in your panel footer icons.
		$args['share_icons'][] = array(
				'url'   => 'https://github.com/ReduxFramework/ReduxFramework',
				'title' => 'Visit us on GitHub',
				'icon'  => 'el el-github'
				//'img'   => '', // You can use icon OR img. IMG needs to be a full URL.
		);
		$args['share_icons'][] = array(
				'url'   => 'https://www.facebook.com/pages/Redux-Framework/243141545850368',
				'title' => 'Like us on Facebook',
				'icon'  => 'el el-facebook'
		);
		$args['share_icons'][] = array(
				'url'   => 'http://twitter.com/reduxframework',
				'title' => 'Follow us on Twitter',
				'icon'  => 'el el-twitter'
		);
		$args['share_icons'][] = array(
				'url'   => 'http://www.linkedin.com/company/redux-framework',
				'title' => 'Find us on LinkedIn',
				'icon'  => 'el el-linkedin'
		);
		
		// Panel Intro text -> before the form
		if ( ! isset( $args['global_variable'] ) || $args['global_variable'] !== false ) {
			if ( ! empty( $args['global_variable'] ) ) {
				$v = $args['global_variable'];
			} else {
				$v = str_replace( '-', '_', $args['opt_name'] );
			}
			$args['intro_text'] = sprintf( __( '<p>Did you know that Redux sets a global variable for you? To access any of your saved options from within your code you can use your global variable: <strong>$%1$s</strong></p>', 'alothemes' ), $v );
		} else {
			$args['intro_text'] = __( '<p>This text is displayed above the options panel. It isn\'t required, but more info is always better! The intro_text field accepts all HTML.</p>', 'alothemes' );
		}
		
		// Add content after the form.
		$args['footer_text'] = __( '<p>This text is displayed below the options panel. It isn\'t required, but more info is always better! The footer_text field accepts all HTML.</p>', 'alothemes' );
		return $args;
		
	}
	
	/*
	 * ---> START HELP TABS
	 */
	public function helptabs(){
		
		$tabs = array(
				array(
					'id'      => 'redux-help-tab-1',
					'title'   => __( 'Theme Information 1', 'alothemes' ),
					'content' => __( '<p>This is the tab content, HTML is allowed.</p>', 'alothemes' )
				),
				array(
					'id'      => 'redux-help-tab-2',
					'title'   => __( 'Theme Information 2', 'alothemes' ),
					'content' => __( '<p>This is the tab content, HTML is allowed.</p>', 'alothemes' )
				)
		);

		return $tabs;
	}
	
	public function helpSidebar(){
		// Set the help sidebar
		return $content = __( '<p>This is the sidebar content, HTML is allowed.</p>', 'alothemes' );
	}
	
	public function optionConfigTheme()
	{
		$optionsTheme 	= $this->_objOptions->option_styles();
		$current_option	= $this->_objOptions->getName();
		$current 		= $optionsTheme[$current_option];

		$args = array(
				'title' => __( 'Switch Theme', 'alothemes' ),
				'id'    => 'switch_theme',
				'desc'  => __( 'Change option theme', 'alothemes' ),
				'icon'  => 'el el-cogs',
				'fields'=> array(
					array(
						'id'       => 'theme_options',
						'type'     => 'select',
						'title'    => __( 'Switch Options Theme', 'alothemes' ),
						'desc' 	   => "<span style='color:red'>Current : " . $current . "</span>",
						'options'  => $optionsTheme,							
					),
				)
			);
		return $args;
	}

	public function general()
	{
		// -> START General
		$pages = array('0' => __('Default Page', 'alothemes'));
		// $pages_option = wp_list_pluck( get_pages(), 'post_title', 'ID'  );
		$pages_option = wp_list_pluck( get_pages(), 'post_title', 'post_name'  );
		// $pages_option = $this->post->getPost('page');
		$pages_option = array_merge($pages,$pages_option);
		$args = array(
					'title' => __( 'General', 'alothemes' ),
					'id'    => 'general',
					'desc'  => __( 'General theme options', 'alothemes' ),
					'icon'  => 'el el-globe',
					'fields'=> array(
							// array(
							// 	'id'       => 'rtl',
							// 	'type'     => 'switch',
							// 	'title'    => __( 'RTL language', 'alothemes' ),
							// 	'compiler' => 'bool',
							// 	'on' 		=> __( 'Enabled', 'alothemes' ),
							// 	'off' 		=> __('Disabled', 'alothemes' ),
							// ),
							array(
								'id'       => 'preload',
								'type'     => 'switch',
								'title'    => __( 'Pre loading', 'alothemes' ),
								'compiler' => 'bool',
								'default'  => true,
								'on' 		=> __( 'Enabled', 'alothemes' ),
								'off' 		=> __('Disabled', 'alothemes' ),
							),
							array(
								'id'       => 'lazy-load',
								'type'     => 'switch',
								'title'    => __( 'Lazy load', 'alothemes' ),
								'compiler' => 'bool',
								'on' 		=> __( 'Enabled', 'alothemes' ),
								'off' 		=> __('Disabled', 'alothemes' ),
							),
							array(
								'id'       => 'hover-image',
								'type'     => 'switch',
								'title'    => __( 'Hover Image', 'alothemes' ),
								'compiler' => 'bool',
								'on' 		=> __( 'Enabled', 'alothemes' ),
								'off' 		=> __('Disabled', 'alothemes' ),
							),
							
					)
			);
		return $args;
	}

	public function design()
	{
		$pages = array('0' => __('Default Page', 'alothemes'));
		// $pages_option = wp_list_pluck( get_pages(), 'post_title', 'ID'  );
		$pages_option = wp_list_pluck( get_pages(), 'post_title', 'post_name'  );
		// $pages_option = $this->post->getPost('page');
		$pages_option = array_merge($pages,$pages_option);
		$headers = $this->post->getPost('header');
        $edit_header = '';
        $options    = $this->_optionsValue;
        if($headers){
	        if(isset($options['header']) && $options['header']){
	        	if(array_key_exists ($options['header'], $headers)){
      				$post_edit = $options['header'];
	        	}else {
	        		reset($headers);
	        		$post_edit = key($headers);
	        	}
	        	$edit_header = '<a href="' . admin_url( 'post.php?post=' . $post_edit ) . '&action=edit' . '">' . __('Click to Edit Footer', 'alothemes') . '</a><br/>';  
	          ;
	        }        	
        }else {
        	$edit_header .= '<a href="' . admin_url( 'post-new.php?post_type=header' ) . '">' . __('Create new one Footer', 'alothemes') . '</a>';	
        }

		$footers = $this->post->getPost('footer');
        $edit_footer = '';
        $options    = $this->_optionsValue;
        if($footers){
	        if(isset($options['footer']) && $options['footer']){
	        	if(array_key_exists ($options['footer'], $footers)){
      				$post_edit = $options['footer'];
	        	}else {
	        		reset($footers);
	        		$post_edit = key($footers);
	        	}
	        	$edit_footer = '<a href="' . admin_url( 'post.php?post=' . $post_edit ) . '&action=edit' . '">' . __('Click to Edit Footer', 'alothemes') . '</a><br/>';  
	          ;
	        }        	
        }else {
        	$edit_footer .= '<a href="' . admin_url( 'post-new.php?post_type=footer' ) . '">' . __('Create new one Footer', 'alothemes') . '</a>';	
        }

		$files = $this->_objOptions->_option_files;
		$styles = array();
		foreach ($files as $file) {
			$styles[$file] = $file;
		}

		$args = array(
					'title' => __( 'Design', 'alothemes' ),
					'id'    => 'design',
					'desc'  => __( 'Design', 'alothemes' ),
					'icon'  => 'el el-globe',
					'fields'=> array(
							// array(
							// 		'id'       => 'header',
							// 		'type'     => 'select',
							// 		'title'    => __( 'Header', 'alothemes' ),
							// 		'desc'     => $edit_header,
							// 		'options'  => $headers,
							// ),
							array(
									'id'       => 'header',
									'type'     => 'select',
									'title'    => __( 'Header', 'alothemes' ),
									'desc'     => 'Directory file theme/header/',
									'options'  => $this->get_header(),
							),
							array(
								'id'       => 'logo-image',
								'type'     => 'media',
								'title'    => __( 'Logo Image', 'alothemes' ),
								'desc'     => __( 'Image that you want to use as logo', 'alothemes' ),
							),
							array(
		                        'id'        => 'logo_alt',
		                        'type'      => 'text',
		                        'title'     => __('Logo Image Alt', 'alothemes'),
		                    ),
							// array(
							// 	'id'       => 'mode-layout',
							// 	'type'     => 'select',
							// 	'title'    => __( 'Mode Layout', 'alothemes' ),
							// 	'options'  => array(
							// 		'0' => 'Full Width',
							// 		'1' => 'Box',
							// 	),
							// 	'default'  => '0'
							// ),
							array(
								'id'       => 'home_layout',
								'type'     => 'image_select',
								'title'    => __('Home Page Layout', 'alothemes'),
								'options'  => array(
										'col1-layout'      => array(
								            'alt'   => '1 Column', 
								            'img'   => $this->_url . '1col.png'
								        ),
								        'col2-left-layout'      => array(
								            'alt'   => '2 Column Left', 
								            'img'   => $this->_url . '2cl.png'
								        ),
								        'col2-right-layout'      => array(
								            'alt'   => '2 Column Right', 
								            'img'  => $this->_url . '2cr.png'
								        ),
								        'col3-layout'      => array(
								            'alt'   => '3 Column Middle', 
								            'img'   => $this->_url . '3cm.png'
								        ),
							        ),
								'default'  => 'col1-layout',
							),
							array(
								'id'       => 'default_layout',
								'type'     => 'image_select',
								'title'    => __('Default Page Layout', 'alothemes'),
								'options'  => array(
										'col1-layout'      => array(
								            'alt'   => '1 Column', 
								            'img'   => $this->_url . '1col.png'
								        ),
								        'col2-left-layout'      => array(
								            'alt'   => '2 Column Left', 
								            'img'   => $this->_url . '2cl.png'
								        ),
								        'col2-right-layout'      => array(
								            'alt'   => '2 Column Right', 
								            'img'  => $this->_url . '2cr.png'
								        ),
								        'col3-layout'      => array(
								            'alt'   => '3 Column Middle', 
								            'img'   => $this->_url . '3cm.png'
								        ),
							        ),
								'default'  => 'col2-left-layout',
							),
							array(
									'id'       => 'page_on_front',
									'type'     => 'select',
									'title'    => __( 'Front page:', 'alothemes' ),
									'options'  => $pages_option
							),
							array(
								'id'       => 'footer',
								'type'     => 'select',
								'title'    => __( 'Footer', 'alothemes' ),
								'desc'	   => $edit_footer,
								'options'  => $footers,
							),	
							array(
									'id'       => 'style',
									'type'     => 'select',
									'title'    => __( 'Style', 'alothemes' ),
									'options'  => $styles,
							),						
					)
			);
		return $args;
	}

	public function get_header()
	{
        $templates = array();
        $templatesDirs = array(
                get_stylesheet_directory(),
                get_template_directory()
            );
        foreach ($templatesDirs as $dir) {
            $templateDir = $dir . '/header/';
            if (file_exists($templateDir) && is_dir($templateDir)) {
                $regexr     = '/^header.*.php$/';
                $tmps  = preg_grep($regexr,  scandir($templateDir, 1));
                if($templates){
                    foreach ($tmps as $fileName) {
                        $templates[] = $fileName;
                    }
                } else {
                    $templates = $tmps;
                }
            }
        }
        $templates = array_unique($templates);
        $headers = array();
        foreach ($templates as $file) {
        	$headers[$file] = $file;
        }
		asort($headers);
        return $headers;
	}
	
	public function background()
	{
		// -> START Background
		$args = array(
				'title' => __( 'Background', 'alothemes' ),
				'id'    => 'background',
				'desc'  => __( 'Body background', 'alothemes' ),
				'icon'  => 'el el-picture',
				'fields'=> array(
						array(
								'id'       => 'body-background',
								'type'     => 'background',
								'output'   => array( '#container' ),
								'title'    => __('Body Background', 'alothemes'),
								'default'  => array(
										'background-color' => '#999999',
								)
						),
						array(
								'id'       => 'bottom-top-background',
								'type'     => 'background',
								'output'   => array( '#footer-top' ),
								'title'    => __('Footer Top Background', 'alothemes'),
								'subtitle' => __( 'Default: #F5F5F6.', 'alothemes' ),
								'default'  => array(
										'background-color' => '#F5F5F6',
								)
						),
						array(
								'id'       => 'bottom-bottom-background',
								'type'     => 'background',
								'output'   => array( '#footer-bottom' ),
								'title'    => __('Footer Bottom Background', 'alothemes'),
								'subtitle' => __( 'Default: #d1d1d1.', 'alothemes' ),
								'default'  => array(
										'background-color' => 'red',
								)
						),
		
				)
		);
		return $args;
	}

	public function product()
	{  
		// -> START Shop
		$group 		= 'product';
		$args = array(
				'title' => __( 'Product', 'alothemes' ),
				'id'    => 'product',
				'desc'  => __( 'Use this section to select options for general Product', 'alothemes' ),
				'icon'  => 'el el-shopping-cart-sign',
				'fields'=> array(
						array(
							'id'       => $group . '_lazyload',
							'type'     => 'switch',
							'title'    => __( 'Lazy load', 'alothemes' ),
							'compiler' => 'bool',
							'on' 		=> __( 'Enabled', 'alothemes' ),
							'off' 		=> __('Disabled', 'alothemes' ),
						),
						array(
							'id'       => $group . '_hoverimage',
							'type'     => 'switch',
							'title'    => __( 'Hover Image', 'alothemes' ),
							'compiler' => 'bool',
							'on' 		=> __( 'Enabled', 'alothemes' ),
							'off' 		=> __('Disabled', 'alothemes' ),
						),
						array(
							'id'       => $group . '_placeholderimage',
							'type'     => 'media',
							'title'    => __( 'Placeholder image', 'alothemes' ),
							'desc'     => __( 'Image that you want to use as default image product', 'alothemes' ),
						),

					),
		);
		return $args;
	}

	public function product_shop()
	{  
		// -> START Shop
		$group 		= 'product_shop';
		$args = array(
				'title' => __( 'Product Shop', 'alothemes' ),
				'id'    => 'shop',
				'desc'  => __( 'Use this section to select options for shop', 'alothemes' ),
				'icon'  => 'el el-shopping-cart-sign',
				'fields'=> array(
	                    array(
							'id'       => $group . '_layout',
							'type'     => 'image_select',
							'title'    => __('Shop Layout', 'alothemes'),
							'subtitle' => __('Layout Page Product Shop', 'alothemes'),
							'options'  => array(
									'col1-layout'      => array(
							            'alt'   => '1 Column', 
							            'img'   => $this->_url . '1col.png'
							        ),
							        'col2-left-layout'      => array(
							            'alt'   => '2 Column Left', 
							            'img'   => $this->_url . '2cl.png'
							        ),
							        'col2-right-layout'      => array(
							            'alt'   => '2 Column Right', 
							            'img'   => $this->_url . '2cr.png'
							        ),
							        'col3-layout'      => array(
							            'alt'   => '3 Column Middle', 
							            'img'   => $this->_url . '3cm.png'
							        ),
						        ),
							'default'  => 'col2-right-layout',
						),
						array(
	                        'id'        => $group . '_default_view',
	                        'type'      => 'select',
	                        'title'     => __('Shop default view', 'alothemes'),
	                        'options'   => array(
								'grid-view' => 'Grid View',
	                            'list-view' => 'List View',
	                        ),
	                        'default'   => 'grid-view'
	                    ),
						array(
							'id'        => $group . '_per_page',
							'type'      => 'slider',
							'title'     => __('Products per page', 'alothemes'),
							'subtitle'  => __('Amount of products per page on category page', 'alothemes'),
							"default"   => 12,
							"min"       => 4,
							"step"      => 1,
							"max"       => 48,
							'display_value' => 'text'
						),
					),
		);
		
		$args['fields'] =  array_merge($args['fields'], $this->getConfigGrid($group));

		return $args;
	}

	public function product_category()
	{ 		
		// -> START Category
		$group 		= 'product_category';
		$args = array(
			'title' => __( 'Product Category', 'alothemes' ),
			'id'    => 'product_category',
			'desc'  => __( 'Use this section to select options for product', 'alothemes' ),
			'icon'  => 'el el-qrcode',
			'fields'=> array(
                    array(
						'id'       => $group . '_layout',
						'type'     => 'image_select',
						'title'    => __('Layout Product Category', 'alothemes'),
						'subtitle' => __('Layout Page Product Category', 'alothemes'),
						'options'  => array(
								'col1-layout'      => array(
						            'alt'   => '1 Column', 
						            'img'   => $this->_url . '1col.png'
						        ),
						        'col2-left-layout'      => array(
						            'alt'   => '2 Column Left', 
						            'img'   => $this->_url . '2cl.png'
						        ),
						        'col2-right-layout'      => array(
						            'alt'   => '2 Column Right', 
						            'img'   => $this->_url . '2cr.png'
						        ),
						        'col3-layout'      => array(
						            'alt'   => '3 Column Middle', 
						            'img'   => $this->_url . '3cm.png'
						        ),
					        ),
						'default'  => 'col1-layout',
					),
					array(
                        'id'        => $group . '_default_view',
                        'type'      => 'select',
                        'title'     => __('Shop default view', 'alothemes'),
                        'options'   => array(
							'grid-view' => 'Grid View',
                            'list-view' => 'List View',
                        ),
                        'default'   => 'grid-view'
                    ),
					array(
						'id'        => $group . '_per_page',
						'type'      => 'slider',
						'title'     => __('Products per page', 'alothemes'),
						'subtitle'  => __('Amount of products per page on category page', 'alothemes'),
						"default"   => 12,
						"min"       => 4,
						"step"      => 1,
						"max"       => 48,
						'display_value' => 'text'
					),
                ),
		);

		$args['fields'] =  array_merge($args['fields'], $this->getConfigGrid($group));

		return $args;
	}

	public function page_cart()
	{ 	
		// -> START Page Cart
		$group 		= 'page_cart';
		$args = array(
				'title' => __( 'Page Cart', 'alothemes' ),
				'id'    => 'page-cart',
				'icon'  => 'el el-shopping-cart',
				'fields'=> array(
						array(
                            'id'       => $group . '_crollsell',
                            'type'     => 'raw',
	                        'content'  => '<p><b>Crollsell Products</b></p>',
                        ),
	                ),
		);

		$args['fields'] =  array_merge($args['fields'], $this->getConfigSlider($group));

		return $args;
	}

	public function single_page(){ // -> START Single Post
		$group 		= 'single';
		$args = array(
                'title'     => __('Single Page', 'alothemes'),
                'desc'  	=> __( 'Config single Page', 'alothemes' ),
                'icon'      => 'el el-caret-down',
                'fields'    => array(
					
                ),
            );
		return $args;
	}

	public function single_page_blog(){ 		// -> START Single Post
		$group 		= 'single_blog';
		 $args = array(
                'title'     	=> __('Single Page Blog', 'alothemes'),
                'desc'  		=> __( 'Config single Blog Page', 'alothemes' ),
                'subsection' 	=> true,
                'icon'      	=> 'el el-blogger',
                'fields'    => array(
                    array(
						'id'       => $group . '_layout',
						'type'     => 'image_select',
						'title'    => __('Single Blog Layout', 'alothemes'),
						'subtitle' => __('Layout Single Page Blog', 'alothemes'),
						'options'  => array(
								'col1-layout'      => array(
						            'alt'   => '1 Column', 
						            'img'   => $this->_url . '1col.png'
						        ),
						        'col2-left-layout'      => array(
						            'alt'   => '2 Column Left', 
						            'img'   => $this->_url . '2cl.png'
						        ),
						        'col2-right-layout'      => array(
						            'alt'   => '2 Column Right', 
						            'img'   => $this->_url . '2cr.png'
						        ),
						        'col3-layout'      => array(
						            'alt'   => '3 Column Middle', 
						            'img'   => $this->_url . '3cm.png'
						        ),
					        ),
						'default'  => 'col2-left-layout',
					),
					
                ),
            );
		return $args;
	}

	public function post_related()
	{
		$group 		= 'post_related';
		$args = array(
                'title'     	=> __('Post Relateds ', 'alothemes'),
                'desc'  		=> __( 'Config Related Post', 'alothemes' ),
                'icon'      	=> 'el el-smiley',
                'subsection' 	=> true,
                'fields'    => array(
					array(
						'id'        => $group . '_limit',
						'type'      => 'slider',
						'title'     => __('Limit Related Post', 'alothemes'),
						"default"   => 12,
						"min"       => 1,
						"step"      => 1,
						"max"       => 40,
						'display_value' => 'text'
					),

                ),
			);

		$args['fields'] =  array_merge($args['fields'], $this->getConfigSlider($group));

		return $args;
	}

	public function single_page_product(){
		$group 		= 'single_product';
		$mobile 	= "mobile";
		$portrait  	= 'portrait';
		$landscape  = 'landscape';
		$tablet  	= 'tablet';
		$notebook  	= 'notebook';
		$desktop  	= 'desktop';
		$visible  	= 'visible';
		$args = array(
                'title'     	=> __('Single Page Product', 'alothemes'),
                'desc'  		=> __( 'Config single Product Page', 'alothemes' ),
                'icon'      	=> 'el el-smiley',
                'subsection' 	=> true,
                'fields'    => array(
                    array(
						'id'       => $group . '_layout',
						
						'type'     => 'image_select',
						'title'    => __('Product Single Layout', 'alothemes'),
						'subtitle'      => __('Layout Page Product Single', 'alothemes'),
						'options'  => array(
								'col1-layout'      => array(
						            'alt'   => '1 Column', 
						            'img'   => $this->_url . '1col.png'
						        ),
						        'col2-left-layout'      => array(
						            'alt'   => '2 Column Left', 
						            'img'   => $this->_url . '2cl.png'
						        ),
						        'col2-right-layout'      => array(
						            'alt'   => '2 Column Right', 
						            'img'   => $this->_url . '2cr.png'
						        ),
						        'col3-layout'      => array(
						            'alt'   => '3 Column Middle', 
						            'img'   => $this->_url . '3cm.png'
						        ),
				        ),
						'default'  => 'col2-left-layout',
					),
								
				),
            );

		return $args;
	}

	public function product_related()
	{
		$group 		= 'product_related';
		$args = array(
                'title'     	=> __('Product Relateds ', 'alothemes'),
                'desc'  		=> __( 'Config Related Product', 'alothemes' ),
                'icon'      	=> 'el el-smiley',
                'subsection' 	=> true,
                'fields'    => array(
					array(
						'id'        => $group . '_limit',
						'type'      => 'slider',
						'title'     => __('Limit Related Product', 'alothemes'),
						"default"   => 12,
						"min"       => 1,
						"step"      => 1,
						"max"       => 40,
						'display_value' => 'text'
					),

                ),
			);

		$args['fields'] =  array_merge($args['fields'], $this->getConfigSlider($group));

		return $args;
	}

	public function product_up_sells()
	{
		$group 		= 'product_up_sells';
		$args = array(
                'title'     	=> __('Product Up Sells ', 'alothemes'),
                'desc'  		=> __( 'Config Up Sells Product', 'alothemes' ),
                'icon'      	=> 'el el-smiley',
                'subsection' 	=> true,
                'fields'    => array(
					array(
						'id'        => $group . '_limit',
						'type'      => 'slider',
						'title'     => __('Limit Related Product', 'alothemes'),
						"default"   => 12,
						"min"       => 1,
						"step"      => 1,
						"max"       => 40,
						'display_value' => 'text'
					),

                ),
			);

		$args['fields'] =  array_merge($args['fields'], $this->getConfigSlider($group));

		return $args;
	}

	public function product_thumbnail()
	{
		// -> START Thumbnail Product
		$group 		= 'product_thumnail';
		$args = array(
                'title'     	=> __('Product Thumbnails ', 'alothemes'),
                'desc'  		=> __( 'Config Thumbnails Product', 'alothemes' ),
                'icon'      	=> 'el el-smiley',
                'subsection' 	=> true,
                'fields'    => $this->getConfigSlider($group),
			);
		return $args;
	}

	public function blog()
	{
		// -> START Blog
		$group 		= 'blog';
		$args = array(
                'title'     => __('Blog', 'alothemes'),
                'desc'      => __('Use this section to select options for blog', 'alothemes'),
                'icon'      => 'el el-blogger',
                'fields'    => array(
					array(
                        'id'        => 'blog_header_text',
                        'type'      => 'text',
                        'title'     => __('Blog header text', 'alothemes'),
                        'default'   => 'Blog post'
                    ),
					array(
                        'id'        => $group .  '_layout',
                        'type'      => 'select',
                        'title'     => __('Blog Layout', 'alothemes'),
                        'options'   => array(
							'sidebar'   => 'Sidebar',
                            'fullwidth' => 'Full Width',
                        ),
                        'default'   => 'fullwidth'
                    ),
                    array(
						'id'       => $group . '_layout',
						'type'     => 'image_select',
						'title'    => __('Blog Layout', 'alothemes'),
						'subtitle' => __('Layout Page Blog', 'alothemes'),
						'options'  => array(
								'col1-layout'      => array(
						            'alt'   => '1 Column', 
						            'img'   => $this->_url . '1col.png'
						        ),
						        'col2-left-layout'      => array(
						            'alt'   => '2 Column Left', 
						            'img'   => $this->_url . '2cl.png'
						        ),
						        'col2-right-layout'      => array(
						            'alt'   => '2 Column Right', 
						            'img'  => $this->_url . '2cr.png'
						        ),
						        'col3-layout'      => array(
						            'alt'   => '3 Column Middle', 
						            'img'   => $this->_url . '3cm.png'
						        ),
					        ),
						'default'  => 'col2-left-layout',
					),
					array(
                        'id'        => $group . '_view',
                        'type'      => 'select',
                        'title'     => __('Blog view', 'alothemes'),
                        'options'   => array(
							'grid-view' => 'Grid View',
                            'list-view' => 'List View',
                        ),
                        'default'   => 'list-view'
                    ),
					// array(
					// 	'id'        => 'excerpt_length_grid',
					// 	'type'      => 'slider',
					// 	'title'     => __('Excerpt length on blog page Grid', 'alothemes'),
					// 	"default"   => 15,
					// 	"min"       => 10,
					// 	"step"      => 1,
					// 	"max"       => 50,
					// 	'display_value' => 'text'
					// ),
					// array(
					// 	'id'        => 'excerpt_length_list',
					// 	'type'      => 'slider',
					// 	'title'     => __('Excerpt length on blog page List', 'alothemes'),
					// 	"default"   => 20,
					// 	"min"       => 10,
					// 	"step"      => 1,
					// 	"max"       => 50,
					// 	'display_value' => 'text'
					// ),
                ),
            );
		$args['fields'] =  array_merge($args['fields'], $this->getConfigGrid($group));
		return $args;
	}

	public function portfolio()
	{
		// -> START Portfolio
		$group 		= 'portfolio';
		$args = array(
                'title'     => __('Portfolio', 'alothemes'),
                'desc'      => __('Use this section to select options for portfolio', 'alothemes'),
                'icon'      => 'el el-group-alt',
                'fields'    => array(
					array(
                        'id'        => 'portfolio_header_text',
                        'type'      => 'text',
                        'title'     => __('Portfolio header text', 'alothemes'),
                        'default'   => 'Our projects'
                    ),
					array(
                        'id'        => $group .  '_layout',
                        'type'      => 'select',
                        'title'     => __('Portfolio Layout', 'alothemes'),
                        'options'   => array(
							'sidebar'   => 'Sidebar',
                            'fullwidth' => 'Full Width',
                        ),
                        'default'   => 'fullwidth'
                    ),
                    array(
						'id'       => $group . '_layout',
						'type'     => 'image_select',
						'title'    => __('Portfolio Layout', 'alothemes'),
						'subtitle' => __('Layout Page Portfolio', 'alothemes'),
						'options'  => array(
								'col1-layout'      => array(
						            'alt'   => '1 Column', 
						            'img'   => $this->_url . '1col.png'
						        ),
						        'col2-left-layout'      => array(
						            'alt'   => '2 Column Left', 
						            'img'   => $this->_url . '2cl.png'
						        ),
						        'col2-right-layout'      => array(
						            'alt'   => '2 Column Right', 
						            'img'  => $this->_url . '2cr.png'
						        ),
						        'col3-layout'      => array(
						            'alt'   => '3 Column Middle', 
						            'img'   => $this->_url . '3cm.png'
						        ),
					        ),
						'default'  => 'col2-left-layout',
					),
					array(
                        'id'        => $group . '_view',
                        'type'      => 'select',
                        'title'     => __('Portfolio view', 'alothemes'),
                        'options'   => array(
							'grid-view' => __('Grid view', 'alothemes'),
                            'list-view' => __('List view', 'alothemes'),
                        ),
                        'default'   => 'list-view'
                    ),

                ),
            );
		$args['fields'] =  array_merge($args['fields'], $this->getConfigGrid($group));
		return $args;
	}
	public function portfolio_related()
	{
		// -> START Portfolio
		$group 		= 'portfolio_related';
		$args = array(
                'title'     => __('Portfolio Related', 'alothemes'),
                'desc'      => __('Use this section to select options for related portfolio', 'alothemes'),
                'icon'      => 'el el-group-alt',
                'fields'    => array(

					// Related Project
					// array(
                    //     'id'        => $group . '_title',
                    //     'type'      => 'text',
                    //     'title'     => __('Related projects title', 'alothemes'),
                    //     'default'   => 'Related Projects'
                    // ),

					array(
						'id'        => $group . '_limit',
						'type'      => 'slider',
						'title'     => __('Limit Related portfolio', 'alothemes'),
						"default"   => 12,
						"min"       => 1,
						"step"      => 1,
						"max"       => 40,
						'display_value' => 'text'
					),

                ),
            );
		
		$args['fields'] =  array_merge($args['fields'], $this->getConfigSlider($group));

		return $args;		
	}

	public function instagram()
	{
		// -> START Instagram
		$group 		= 'instagram';
		$args = array(
                'title'     => __('Instagram', 'alothemes'),
                'desc'      => __('Use this section to select options for instagram', 'alothemes'),
                'icon'      => 'el el-instagram',
                'fields'    => array(
					array(
                        'id'        => 'instagram_username',
                        'type'      => 'text',
                        'title'     => __('User Name :', 'alothemes'),
                        'subtitle'  => __('User Name', 'alothemes'),
                        'default'   => 'Mishanonoo'
                    ),
                    array(
                        'id'        => 'instagram_token',
                        'type'      => 'text',
                        'title'     => __('Access Token : ', 'alothemes'),
                        'subtitle'  => __('Get accsess Token follow guide here : http://jelled.com/instagram/accsess-token', 'alothemes'),
                        'default'   => 'EAAAAAYsX7TsBANMCAgDjCkHcqHfRPMn43mNSRZCKKjZBZA4IFtLqqbRMkhzWDzCxt4S'
                    ),
                    array(
                        'id'        => 'instagram_speed',
                        'type'      => 'text',
                        'title'     => __('Speed', 'alothemes'),
                        'subtitle'  => __('Speed', 'alothemes'),
                        'default'   => '10'
                    ),
					array(
                        'id'        => $group .  '_layout',
                        'type'      => 'select',
                        'title'     => __('Instagram Layout', 'alothemes'),
                        'options'   => array(
							'sidebar'   => 'Sidebar',
                            'fullwidth' => 'Full Width',
                        ),
                        'default'   => 'fullwidth'
                    ),
                    array(
						'id'       => $group . '_layout',
						'type'     => 'image_select',
						'title'    => __('Instagram Layout', 'alothemes'),
						'subtitle' => __('Layout Page Instagram', 'alothemes'),
						'options'  => array(
								'col1-layout'      => array(
						            'alt'   => '1 Column', 
						            'img'   => $this->_url . '1col.png'
						        ),
						        'col2-left-layout'      => array(
						            'alt'   => '2 Column Left', 
						            'img'   => $this->_url . '2cl.png'
						        ),
						        'col2-right-layout'      => array(
						            'alt'   => '2 Column Right', 
						            'img'  => $this->_url . '2cr.png'
						        ),
						        'col3-layout'      => array(
						            'alt'   => '3 Column Middle', 
						            'img'   => $this->_url . '3cm.png'
						        ),
					        ),
						'default'  => 'col2-left-layout',
					),
					array(
                        'id'        => $group . '_view',
                        'type'      => 'select',
                        'title'     => __('Instagram view', 'alothemes'),
                        'options'   => array(
							'grid-view' => 'Grid View',
                            'list-view' => 'List View',
                        ),
                        'default'   => 'list-view'
                    ),
					array(
						'id'        => 'excerpt_length_grid',
						'type'      => 'slider',
						'title'     => __('Excerpt length on blog page Grid', 'alothemes'),
						"default"   => 15,
						"min"       => 10,
						"step"      => 1,
						"max"       => 50,
						'display_value' => 'text'
					),
					array(
						'id'        => 'excerpt_length_list',
						'type'      => 'slider',
						'title'     => __('Excerpt length on blog page List', 'alothemes'),
						"default"   => 20,
						"min"       => 10,
						"step"      => 1,
						"max"       => 50,
						'display_value' => 'text'
					),
                ),
            );

		$args['fields'] =  array_merge($args['fields'], $this->getConfigSlider($group));

		return $args;
	}

	public function customCss()
	{
		// -> START Css
		 $args = array(
				'title' => __( 'Custom CSS', 'alothemes' ),
				'id'    => 'css',
				'desc'  => __( 'Add your Custom CSS code', 'alothemes' ),
				'icon'  => 'el el-css',
				'fields'=> array(
						array(
							'id'       => 'custom_css',
							'type'     => 'ace_editor',
							'title'    => __('CSS Code', 'alothemes'),
							'subtitle' => __('Paste your CSS code here.', 'alothemes'),
							'mode'     => 'css',
							'theme'    => 'monokai', //chrome
							'default'  => "",
							'options'  => array('minLines'=> 25, 'maxLines' => 30),
						),
				),
			);
		return $args;
	}
	
	public function customJs()
	{
		$args = array(
					'title' => __( 'Custom Javascript', 'alothemes' ),
					'id'    => 'js',
					'desc'  => __( 'Add your Custom Javascript code', 'alothemes' ),
					'icon'  => 'el el-edit',
					'fields'=> array(
						array(
			        		'name' => __( 'Code JS', 'alothemes' ),
			        		'desc' => __( 'Add js in your site', 'alothemes' ),
			        		'id'   => 'add_js',
			        		'mode'     => 'javascript',
							'theme'    => 'monokai', //chrome
							'default'  => "",
							'type'     => 'ace_editor',
							'options'  => array('minLines'=> 25, 'maxLines' => 30),
			        	)
					),
			);
		return $args;
	}

	public function font()
	{
		$args = array(
				'title' => __( 'Fonts', 'alothemes' ),
				'id'    => 'fonts',
				'desc'  => __( 'Fonts options', 'alothemes' ),
				'icon'  => 'el el-font',
				'text-transform' => true,
				'fields'=> array(
					array(
						'id' 		=> 'font-body',
						'type' 		=> 'typography',
						'title' 	=> 'Body Font',
						'output' 	=> array( 'body' ),
						'google'    => true, 
						'text-transform' => true,
						'default' => array(
							'font-size' 	=> '12px',
							'font-family' 	=> 'Helvetica Neue, Arial, sans-serif',
							'font-color' 	=> '#757575',
							'google'        => true, 
						),
					),
					array(
						'id' 		=> 'menu-theme',
						'type' 		=> 'typography',
						'title' 	=> 'Menu Font',
						'output' 	=> array( '.vmagicmenu, .magicmenu, .nav-mobile' ),
						'google'    => true, 
						'text-transform' => true,
						'default' => array(
							'font-size' 	=> '12px',
							'font-family' 	=> 'Helvetica Neue, Arial, sans-serif',
							'google'      	=> true, 
						),
					),
					
					array(
						'id' 		=> 'footer-theme',
						'type' 		=> 'typography',
						'title' 	=> 'Footer Font',
						'output' 	=> array( '#footer-bottom' ),
						'google'    => true, 
						'text-transform' => true,
						'default' => array(
							'font-size' 	=> '12px',
							'font-family' 	=> 'Helvetica Neue, Arial, sans-serif',
							'line-height'	=> '12px',
							'google'      	=> true, 
						),
					),
				),
			);
		return $args;
	}
	
	public function color()
	{
	    $options    = $this->_optionsValue;
	    $base_id    = 'base_color';
	    $header_id  = 'header_color';
	    $left_id    = 'left_color';
	    $right_id   = 'right_color';
	    $content_id = 'content_color';
	    $footer_id  = 'footer_color';
		$args = array(
	        'title' => __( 'Color Theme', 'alothemes' ),
	        'id'    =>  'colors',
	        // 'desc'   => __( 'Colors options', 'alothemes' ),
	        'icon'  =>  'el el-tint',
	        'fields'=>  array(
                    array(
                        'id'       => 'color_developer',
                        'type'     => 'switch',
                        'title'    => __( 'Enable Mode Developer', 'alothemes' ),
                        'compiler' => 'bool',
                        'desc'     => __( 'Add new selector for config color', 'alothemes' ),
                        'on'  => __( 'Enabled', 'alothemes' ),
                        'off' => __('Disabled', 'alothemes')
                    ),
                    array( 
                        'id'       => $base_id,
                        'type'     => 'raw',
                        'title'    => __('Base Color: ', 'alothemes'),
                        'content'  => $this->getColorHtml($base_id, $options),

                    ),

                    array( 
                        'id'       => $header_id,
                        'type'     => 'raw',
                        'title'    => __('Header Color: ', 'alothemes'),
                        'content'  => $this->getColorHtml($header_id, $options),
                    ),

                    array( 
                        'id'       => $left_id,
                        'type'     => 'raw',
                        'title'    => __('Sidebar Left Color: ', 'alothemes'),
                        'content'  => $this->getColorHtml($left_id, $options),
                    ),
                    array( 
                        'id'       => $right_id,
                        'type'     => 'raw',
                        'title'    => __('Sidebar Right Color: ', 'alothemes'),
                        'content'  => $this->getColorHtml($right_id, $options),
                    ),
                    array( 
                        'id'       => $content_id,
                        'type'     => 'raw',
                        'title'    => __('Content Color: ', 'alothemes'),
                        'content'  => $this->getColorHtml($content_id, $options),
                    ),
                    array( 
                        'id'       => $footer_id,
                        'type'     => 'raw',
                        'title'    => __('Footer Color: ', 'alothemes'),
                        'content'  => $this->getColorHtml($footer_id, $options),
                    ),
                )
		    );

		return $args;
	}

    public function getColorHtml($_htmlId, $opt_value){
     	$opt_name 	= $this->_opt;
        $_name = $opt_name . '[color][' . $_htmlId . '][';
        $addscript = $readonly = $optons= '';
        $is_developer = isset($opt_value['color_developer']) ? $opt_value['color_developer'] : '';
        if(isset($opt_value['color'])){
        	$opt_value = $opt_value['color'];
        	$readonly = $is_developer ? '' : 'alo-readonly';
        	$optons= isset($opt_value["$_htmlId"]) ? $opt_value["$_htmlId"] : '';
        }
        if(is_array($optons)){
        	$optons = array_reverse($optons);
            foreach ($optons as $key => $value) {
                if( !$value['selector'] || (!$value['color'] && !$value['background'] && !$value['border'])) continue;
                $value['_id'] = $key;
                $addscript .= "arrayRow$_htmlId.add(" .json_encode($value). ", 'headings$_htmlId'); \n";
            }            
        }

        return $html =
                <<<EndHTML
<table class="form-list" cellspacing="0">
    <tbody>
        <tr class="alodesign $readonly" id="row_alodesign_$_htmlId">
            <td class="value">
                <div class="grid" id="grid_$_htmlId">
                    <table cellpadding="0" cellspacing="0" class="border">
                        <tbody>
                            <tr class="headings" id="headings$_htmlId">
                                <th>Title</th>
                                <th class="$readonly">Selector</th>
                                <th>Color :</th>
                                <th>background-color :</th>
                                <th>border-color :</th>
                                <th colspan="2"></th>
                            </tr>
                            <tr id="addRow$_htmlId">
                                <td colspan="5"></td>
                                <td colspan="2">
                                    <button style="" onclick="" class="scalable add $readonly" type="button" id="addToEndBtn$_htmlId">
                                        <span><span><span>Add Config Color</span></span></span>
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <!-- <input type="hidden" name="$_name [__empty]" value="" /> -->
                </div>
                <div id="empty$_htmlId">
                    <button style="" onclick="" class="scalable add" type="button" id="emptyAddBtn$_htmlId">
                        <span><span><span>Add Config Color</span></span></span>
                    </button>
                </div>
            </td>
        </tr>
    </tbody>
</table>


<script type="text/javascript">
//<![CDATA[
jQuery( document ).ready(function($) {
// create row creator
    arrayRow$_htmlId = {
    template : function(data)
    {
        return '<tr id="' + data._id + '">'
            +'<td>'
                +'<input type="text" name="$_name' + data._id + '][title]" value="' + data.title + '"  class="title $readonly" style="width:150px"/>'
            +'<\/td>'
            +'<td class="$readonly">'
                +'<input type="text" name="$_name' + data._id + '][selector]" value="' + data.selector + '"  class="selector" style="width:150px;"/>'
            +'<\/td>'
            +'<td>'
                +'<input type="text" name="$_name' + data._id + '][color]" value="' + data.color + '"  class="alo-color" style="width:116px"/>'
            +'<\/td>'
            +'<td>'
                +'<input type="text" name="$_name' + data._id + '][background]" value="' + data.background + '"  class="alo-color" style="width:116px"/>'
            +'<\/td>'
            +'<td>'
                +'<input type="text" name="$_name' + data._id + '][border]" value="' + data.border + '"  class="alo-color" style="width:116px"/>'
            +'<\/td>'
            +'<td><button onclick="" class="scalable add $readonly" type="button" id="addAfterBtn' + data._id + '"><span><span><span>Add after<\/span><\/span><\/span><\/button><\/td>'
            +'<td><button onclick="arrayRow$_htmlId.del(\'' + data._id + '\')" class="scalable delete $readonly" type="button"><span><span><span>Delete<\/span><\/span><\/span><\/button><\/td>'
        +'<\/tr>';    
    },

    rowsCount : 0,

    add : function(templateData, insertAfterId)
    {
        // generate default template data
        if ('' == templateData) {
            var d = new Date();
            var templateData = {
                title : '',
                selector : '',
                color : '',
                background : '',
                border : '',
                _id : '_' + d.getTime() + '_' + d.getMilliseconds()
            };
        }

        // insert before last row
        if ('' == insertAfterId) {
            $(this.template(templateData)).insertBefore('#addRow$_htmlId');
        }
        // insert after specified row
        else {
            $(this.template(templateData)).insertAfter('#'+insertAfterId);
        }

        $( "#addAfterBtn"+  templateData._id).on( "click", this.add.bind(this, '', templateData._id));

        // Add color ColorPicker
        this.rowsCount += 1;
        
        // End add color ColorPicker
    },

    del : function(rowId)
    {
        $('#'+rowId).remove();
        this.rowsCount -= 1;
        if (0 == this.rowsCount) {
            this.showButtonOnly();
        }
    },

    showButtonOnly : function()
    {
        $('#grid_$_htmlId').hide();
        $('#empty$_htmlId').show();
    }
}

// bind add action to "Add" button in last row
$( "#addToEndBtn$_htmlId" ).on( "click", arrayRow$_htmlId.add.bind(arrayRow$_htmlId, '', ''));

// add existing rows
$addscript
var alodesign =  $('#row_alodesign_$_htmlId');
if(alodesign.hasClass("alo-readonly")){
	alodesign.find("input.title").each(function( index ) {
		$(this).after('<p style="width: 200px; padding-left:10px;">' + $(this).val() + '</p>');
	});
	
    $(".color, .alo-color").not(".mColorPicker").attr("data-hex", true).width("178px").mColorPicker();
} else {
	$(".color, .alo-color").not(".mColorPicker").attr("data-hex", true).width("100px").mColorPicker();
}
// initialize standalone button
$('#empty$_htmlId').hide();

$( "#emptyAddBtn$_htmlId" ).on( "click", function () {
    $('#grid_$_htmlId').show();
    $('#empty$_htmlId').hide();
    arrayRow$_htmlId.add('', '');
});
// if no rows, hide grid and show button only

// toggle the grid, if element is disabled (depending on scope)
});
//]]>
</script>
EndHTML;

    }
	
	function getInputSliderHtml($title, $_Id, $group, $options, $default = 1, $min = 1, $max = 8, $step = 1)
	{
		$opt_name 	= $this->_opt;
		$value 		= isset($options[$group][$_Id]) ? $options[$group][$_Id] : $default;
    	$name 		= $opt_name . '[' . $group . '][' . $_Id . ']';
    	$_Id 		= $group . "_$_Id";
    	return $html =
                <<<EndHTML
<tr>
	<th scope="row">
		<div class="redux_field_th">$title</div>
	</th>
	<td>
		<fieldset id="$opt_name-$_Id" class="redux-field-container redux-field redux-field-init redux-container-slider " data-id="$_Id"  data-type="slider">
			<input type="text"  name="$name" id="$_Id" value="$value"
                         class="redux-slider-input redux-slider-input-one-$_Id "/>
         	<div
                class="redux-slider-container "
                id="$_Id"
                data-id="$_Id"
                data-min="$min"
                data-max="$max"
                data-step="$step"
                data-handles="1"
                data-display="2"
                data-rtl=""
                data-forced="1"
                data-float-mark="."
                data-resolution="1" data-default-one="$value">
            </div>
        </fieldset>
    </td>
</tr>
EndHTML;
        }

    function getSelectGroupHtml($title, $_id, $group, $options, $optionsValue, $default = 'true')
	{
		$opt_name 	= $this->_opt;
		$value 		= isset($options[$group][$_id]) ? $options[$group][$_id] : $default;
    	$name 		= $opt_name . '[' . $group . '][' . $_id . ']';
    	$_id 		= $group . "_$_id";
    	$xhtml 		= "";
    	foreach ($optionsValue as $val => $label) {
    		if($val == $value){
    			$xhtml .= '<option selected="selected" value="'. $val .'">'. $label .'</option>';
    		}else{
    			$xhtml .= '<option value="'. $val .'">'. $label .'</option>';
    		}
    		
    	}
    	return $html =
                <<<EndHTML
<tr>
	<th scope="row">
		<div class="redux_field_th">$title</div>
	</th>
	<td>
		<fieldset id="$opt_name-$_id" class="redux-field-container redux-field redux-field-init redux-container-select " data-id="$opt_name-$_id" data-type="select">
			<select id="$group-$_id-select" data-placeholder="Select an item" name="$name" class="redux-select-item " style="width: 40%;" $_id="6">
				$xhtml
			</select>
		</fieldset>
	</td>
</tr>
EndHTML;
    }


	public function skin(){

		$files = $this->_objOptions->_option_files;
		$styles = array();
		foreach ($files as $file) {
			$styles[$file] = $file;
		}
		$args = array(
					'title' => __( 'Skin', 'alothemes' ),
					'id'    => 'skin',
					'desc'  => __( 'Skin Options', 'alothemes' ),
					'icon' => 'el-icon-broom',
					'fields'=> array(
							array(
									'id'       => 'style',
									'type'     => 'select',
									'title'    => __( 'Style Type', 'alothemes' ),
									'options'  => $styles,
							),
					)
				);
		return $args;		
	}

	public function header(){
		$headers = $this->post->getPost('header');
        $edit_header = '';
        $options    = $this->_optionsValue;
        if($headers){
	        if(isset($options['header']) && $options['header']){
	        	if(array_key_exists ($options['header'], $headers)){
      				$post_edit = $options['header'];
	        	}else {
	        		reset($headers);
	        		$post_edit = key($headers);
	        	}
	        	$edit_header = '<a href="' . admin_url( 'post.php?post=' . $post_edit ) . '&action=edit' . '">' . __('Click to Edit Footer', 'alothemes') . '</a><br/>';  
	          ;
	        }        	
        }else {
        	$edit_header .= '<a href="' . admin_url( 'post-new.php?post_type=header' ) . '">' . __('Create new one Footer', 'alothemes') . '</a>';	
        }
		$args = array(
					'title' => __( 'Header', 'alothemes' ),
					'id'    => 'header',
					'desc'  => __( 'Header Options', 'alothemes' ),
					'icon'  => 'el el-tasks',
					'fields'=> array(
							array(
									'id'       => 'header',
									'type'     => 'select',
									'title'    => __( 'Header Type', 'alothemes' ),
									'desc'     => $edit_header,
									'options'  => $headers,
							)

					)
				);
		return $args;
	}

	public function newsletter(){
		
		 $args = array(
				'title' => __( 'Newsletter Popup', 'alothemes' ),
				'id'    => 'newsletter',
				'icon'  => 'el el-screen',
				'fields'=> array(
						array(
							'id'       => 'popup-action',
							'type'     => 'switch',
							'title'    => __( 'Enable', 'alothemes' ),
							'compiler' => 'bool',
							'on' 		=> __( 'Enabled', 'alothemes' ),
							'off' 		=> __('Disabled', 'alothemes' ),
						),
						array(
	                        'id'        => 'popup-delay',
	                        'type'      => 'text',
	                        'title'     => __('Time delay (s)', 'alothemes'),
	                        'default'   => '5'
	                    ),
	                    array(
	                        'id'        => 'popup-cookie',
	                        'type'      => 'text',
	                        'title'     => __('Time cookie (s)', 'alothemes'),
	                        'default'   => '600'
	                    ),
						array(
	                        'id'        => 'popup-maxwidth',
	                        'type'      => 'text',
	                        'title'     => __('Popup max width', 'alothemes'),
	                        'default'   => '780'
	                    ),
						array(
	                        'id'        => 'popup-maxheight',
	                        'type'      => 'text',
	                        'title'     => __('Popup max height', 'alothemes'),
	                        'default'   => '360'
	                    ),
	                    array(
							'id'       => 'popup-background',
							'type'     => 'media',
							'title'    => __( 'Popup Background', 'alothemes' ),
						),
	                    array(
	                        'id'        => 'popup-content',
	                        'type'      => 'editor',
	                        'title'     => __('Popup Content', 'alothemes'),
	                        'args'   => array(
									        'textarea_rows'    => 15
									    )
	                    ),
					)
			);
		return $args;
	}

	public function footer(){

		$footers = $this->post->getPost('footer');
        $edit_footer = '';
        $options    = $this->_optionsValue;
        if($footers){
	        if(isset($options['footer']) && $options['footer']){
	        	if(array_key_exists ($options['footer'], $footers)){
      				$post_edit = $options['footer'];
	        	}else {
	        		reset($footers);
	        		$post_edit = key($footers);
	        	}
	        	$edit_footer = '<a href="' . admin_url( 'post.php?post=' . $post_edit ) . '&action=edit' . '">' . __('Click to Edit Footer', 'alothemes') . '</a><br/>';  
	          ;
	        }        	
        }else {
        	$edit_footer .= '<a href="' . admin_url( 'post-new.php?post_type=footer' ) . '">' . __('Create new one Footer', 'alothemes') . '</a>';	
        }

		$args = array(
				'title' => __( 'Footer', 'alothemes' ),
				'id'    => 'footer',
				'desc'  => __( 'Footer Options', 'alothemes' ),
				'icon'  => 'el el-website icon',
				'fields'=> array(
						array(
							'id'       => 'footer',
							'type'     => 'select',
							'title'    => __( 'Footer Type', 'alothemes' ),
							'desc'	   => $edit_footer,
							'options'  => $footers,
						),

	                    // array(
	                    //     'id'=>'footer-logo',
	                    //     'type' => 'media',
	                    //     'url'=> true,
	                    //     'readonly' => false,
	                    //     'title' => __('Footer Logo', 'alothemes'),
	                    //     'default' => array(
	                    //         'url' => $this->_templateUri . '/images/logo/logo_footer.png'
	                    //     )
	                    // ),

						// array(
						// 	'id'    => 'footer_widget_columns',
						// 	'title'   => __( 'Footer Widget Columns', 'alothemes' ),
						// 	'desc'    => __( 'How many sidebar you want to show on footer', 'alothemes' ),
						// 	'type'    => 'image_select',
						// 	'default' => 5,
						// 	'options' => array(
						// 		1 => $this->_url . 'one-column.png',
						// 		2 => $this->_url . 'two-columns.png',
						// 		3 => $this->_url . 'three-columns.png',
						// 		4 => $this->_url . 'four-columns.png',
						// 		5 => $this->_url . 'five-columns.png',
						// 	)
						// ),

	                    // array(
	                    //     'id' => "footer-copyright",
	                    //     'type' => 'textarea',
	                    //     'title' => __('Copyright', 'alothemes'),
	                    //     'default' => __('&copy; Copyright 2017. All Rights Reserved.', 'alothemes')
	                    // ),

						// array(
						// 	'id'               => 'content',
						// 	'type'             => 'editor',
						// 	'title'    => esc_html__('Content', 'alothemes'),
						// 	'subtitle'         => esc_html__('HTML tags allowed: a, br, em, strong', 'alothemes'),
						// 	'default'          => '&copy; Copyright 2017. All Rights Reserved.',
						// 	'args'   => array(
						// 		'teeny'            => true,
						// 		'textarea_rows'    => 5,
						// 		'media_buttons'	=> true,
						// 	)
						// ),

				)
			);

		return $args;
	}

	public function developer()
	{
		$args = array(
				'title' => __( 'Developer', 'alothemes' ),
				'id'    => 'developer',
				'icon'  => 'el el-cogs',
				'fields'=> array(
						array(
							'id'       => 'templatehints',
							'type'     => 'switch',
							'title'    => __( 'Enabled Template Path Hints', 'alothemes' ),
							'compiler' => 'bool',
							'on' 		=> __( 'Enabled', 'alothemes' ),
							'off' 		=> __('Disabled', 'alothemes' ),
						),
					)
			);
		return $args;
	}

	public function getConfigGrid($group)
	{
		$options    = $this->_optionsValue;
		$mobile 	= "mobile";
		$portrait  	= 'portrait';
		$landscape  = 'landscape';
		$tablet  	= 'tablet';
		$notebook  	= 'notebook';
		$desktop  	= 'desktop';
		$visible  	= 'visible';
		$args = array(
					array( 
                        'id'       => $group . '_padding',
                        'type'     => 'raw',
                        'content'  => $this->getInputSliderHtml('Padding :', 'padding', $group, $options, 15, 0, 50),
					),
					array( 
                        'id'       => $group . '_' . $mobile,
                        'type'     => 'raw',
                        'content'  => $this->getInputSliderHtml('Max-Width 360 :', $mobile, $group, $options),

                    ),
					array( 
                        'id'       => $group . '_' . $portrait,
                        'type'     => 'raw',
                        'content'  => $this->getInputSliderHtml('Max-Width 480 :', $portrait, $group, $options),

                    ),
					array( 
                        'id'       => $group . '_' . $landscape,
                        'type'     => 'raw',
                        'content'  => $this->getInputSliderHtml('Max-Width 640 :', $landscape, $group, $options, 1),

                    ),
					array( 
                        'id'       => $group . '_' . $tablet,
                        'type'     => 'raw',
                        'content'  => $this->getInputSliderHtml('Max-Width 767 :', $tablet, $group, $options, 2),
					),
					array( 
                        'id'       => $group . '_' . $notebook,
                        'type'     => 'raw',
                        'content'  => $this->getInputSliderHtml('Max-Width 991 :', $notebook, $group, $options, 2),
					),
					array( 
                        'id'       => $group . '_' . $desktop,
                        'type'     => 'raw',
                        'content'  => $this->getInputSliderHtml('Max-Width 1199 :', $desktop, $group, $options, 3),
					),
					array( 
                        'id'       => $group . '_' . $visible,
                        'type'     => 'raw',
                        'content'  => $this->getInputSliderHtml('Min-Width 1200 :', $visible, $group, $options, 3),
					),
            );
		return $args;	
	}

	public function getConfigSlider($group)
	{
		$options    = $this->_optionsValue;
		$mobile 	= "mobile";
		$portrait  	= 'portrait';
		$landscape  = 'landscape';
		$tablet  	= 'tablet';
		$notebook  	= 'notebook';
		$desktop  	= 'desktop';
		$visible  	= 'visible';
		$optionTF 	= $this->_bool->getOptions('tf', false);
		$optionRows = $this->_bool->getOptions();

		$args = array(
					array(
	                    'id'       => $group . '_vertical',
	                    'type'     => 'raw',
	                    'content'  => $this->getSelectGroupHtml('Slider Vertical :', 'vertical', $group, $options, $optionTF, 'false'),
	                ),
	                /*array(
	                    'id'       => $group . '_infinite',
	                    'type'     => 'raw',
	                    'content'  => $this->getSelectGroupHtml('Infinite :', 'infinite', $group, $options, $optionTF, 'true'),
	                ),*/
	                array(
	                    'id'       => $group . '_autoplay',
	                    'type'     => 'raw',
	                    'content'  => $this->getSelectGroupHtml('Auto Play :', 'autoplay', $group, $options, $optionTF, 'true'),
	                ),
	                array(
	                    'id'       => $group . '_arrows',
	                    'type'     => 'raw',
	                    'content'  => $this->getSelectGroupHtml('Arrows :', 'arrows', $group, $options, $optionTF, 'true'),
	                ),
	                array(
	                    'id'       => $group . '_dots',
	                    'type'     => 'raw',
	                    'content'  => $this->getSelectGroupHtml('Dots :', 'dots', $group, $options, $optionTF, 'false'),
	                ),
					array( 
						'id'       => $group . '_rows',
						'type'     => 'raw',
						'content'  => $this->getInputSliderHtml('Rows :', 'rows', $group, $options, 1, 1, 5),
					),
					array( 
						'id'       => $group . '_padding',
						'type'     => 'raw',
						'content'  => $this->getInputSliderHtml('Padding :', 'padding', $group, $options, 10, 0, 30),
					),

					array( 
						'id'       => $group . '_speed',
						'type'     => 'raw',
						'content'  => $this->getInputSliderHtml('Speed :', 'speed', $group, $options, 300, 0, 5000, 1),

					),
					array( 
						'id'       => $group . "_autoplay-speed",
						'type'     => 'raw',
						'content'  => $this->getInputSliderHtml('Autoplay Speed :', 'autoplay-speed', $group, $options, 3000, 0, 9000, 1),

					),

					array( 
						'id'       => $group . '_' . $mobile,
						'type'     => 'raw',
						'content'  => $this->getInputSliderHtml('Max-Width 360 :', $mobile, $group, $options),

					),
					array( 
						'id'       => $group . '_' . $portrait,
						'type'     => 'raw',
						'content'  => $this->getInputSliderHtml('Max-Width 480 :', $portrait, $group, $options),

					),
					array( 
						'id'       => $group . '_' . $landscape,
						'type'     => 'raw',
						'content'  => $this->getInputSliderHtml('Max-Width 640 :', $landscape, $group, $options, 2),

					),
					array( 
						'id'       => $group . '_' . $tablet,
						'type'     => 'raw',
						'content'  => $this->getInputSliderHtml('Max-Width 767 :', $tablet, $group, $options, 3),
					),
					array( 
						'id'       => $group . '_' . $notebook,
						'type'     => 'raw',
						'content'  => $this->getInputSliderHtml('Max-Width 991 :', $notebook, $group, $options, 3),
					),
					array( 
						'id'       => $group . '_' . $desktop,
						'type'     => 'raw',
						'content'  => $this->getInputSliderHtml('Max-Width 1199 :', $desktop, $group, $options, 4),
					),
					array( 
						'id'       => $group . '_' . $visible,
						'type'     => 'raw',
						'content'  => $this->getInputSliderHtml('Min-Width 1200 :', $visible, $group, $options, 4),
					),
            );
		return $args;	
	}

}
