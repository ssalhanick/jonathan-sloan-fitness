<?php

/**
  ReduxFramework Sample Config File
  For full documentation, please visit: https://docs.reduxframework.com
 * */

if (!class_exists('Redux_Framework_sample_config')) {

    class Redux_Framework_sample_config {

        public $args        = array();
        public $sections    = array();
        public $theme;
        public $ReduxFramework;

        public function __construct() {

            if (!class_exists('ReduxFramework')) {
                return;
            }

            // This is needed. Bah WordPress bugs.  ;)
            if (  true == Redux_Helpers::isTheme(__FILE__) ) {
                $this->initSettings();
            } else {
                add_action('plugins_loaded', array($this, 'initSettings'), 10);
            }

        }

        public function initSettings() {

            // Just for demo purposes. Not needed per say.
            $this->theme = wp_get_theme();

            // Set the default arguments
            $this->setArguments();

            // Set a few help tabs so you can see how it's done
            $this->setHelpTabs();

            // Create the sections and fields
            $this->setSections();

            if (!isset($this->args['opt_name'])) { // No errors please
                return;
            }

            // If Redux is running as a plugin, this will remove the demo notice and links
            //add_action( 'redux/loaded', array( $this, 'remove_demo' ) );
            
            // Function to test the compiler hook and demo CSS output.
            // Above 10 is a priority, but 2 in necessary to include the dynamically generated CSS to be sent to the function.
            //add_filter('redux/options/'.$this->args['opt_name'].'/compiler', array( $this, 'compiler_action' ), 10, 3);
            
            // Change the arguments after they've been declared, but before the panel is created
            //add_filter('redux/options/'.$this->args['opt_name'].'/args', array( $this, 'change_arguments' ) );
            
            // Change the default value of a field after it's been set, but before it's been useds
            //add_filter('redux/options/'.$this->args['opt_name'].'/defaults', array( $this,'change_defaults' ) );
            
            // Dynamically add a section. Can be also used to modify sections/fields
            //add_filter('redux/options/' . $this->args['opt_name'] . '/sections', array($this, 'dynamic_section'));

            $this->ReduxFramework = new ReduxFramework($this->sections, $this->args);
        }

        /**

          This is a test function that will let you see when the compiler hook occurs.
          It only runs if a field	set with compiler=>true is changed.

         * */
        function compiler_action($options, $css, $changed_values) {
            echo '<h1>The compiler hook has run!</h1>';
            echo "<pre>";
            print_r($changed_values); // Values that have changed since the last save
            echo "</pre>";
            //print_r($options); //Option values
            //print_r($css); // Compiler selector CSS values  compiler => array( CSS SELECTORS )

            /*
              // Demo of how to use the dynamic CSS and write your own static CSS file
              $filename = dirname(__FILE__) . '/style' . '.css';
              global $wp_filesystem;
              if( empty( $wp_filesystem ) ) {
                require_once( ABSPATH .'/wp-admin/includes/file.php' );
              WP_Filesystem();
              }

              if( $wp_filesystem ) {
                $wp_filesystem->put_contents(
                    $filename,
                    $css,
                    FS_CHMOD_FILE // predefined mode settings for WP files
                );
              }
             */
        }

        /**

          Custom function for filtering the sections array. Good for child themes to override or add to the sections.
          Simply include this function in the child themes functions.php file.

          NOTE: the defined constants for URLs, and directories will NOT be available at this point in a child theme,
          so you must use get_template_directory_uri() if you want to use any of the built in icons

         * */
        function dynamic_section($sections) {
            //$sections = array();
            $sections[] = array(
                'title' => __('Section via hook', 'oshin'),
                'desc' => __('<p class="description">This is a section created by adding a filter to the sections array. Can be used by child themes to add/remove sections from the options.</p>', 'oshin'),
                'icon' => 'el-icon-paper-clip',
                // Leave this as a blank section, no options just some intro text set above.
                'fields' => array()
            );

            return $sections;
        }

        /**

          Filter hook for filtering the args. Good for child themes to override or add to the args array. Can also be used in other functions.

         * */
        function change_arguments($args) {
            //$args['dev_mode'] = true;

            return $args;
        }

        /**

          Filter hook for filtering the default value of any given field. Very useful in development mode.

         * */
        function change_defaults($defaults) {
            $defaults['str_replace'] = 'Testing filter hook!';

            return $defaults;
        }

        // Remove the demo link and the notice of integrated demo from the redux-framework plugin
        function remove_demo() {

            // Used to hide the demo mode link from the plugin page. Only used when Redux is a plugin.
            if (class_exists('ReduxFrameworkPlugin')) {
                remove_filter('plugin_row_meta', array(ReduxFrameworkPlugin::instance(), 'plugin_metalinks'), null, 2);

                // Used to hide the activation notice informing users of the demo panel. Only used when Redux is a plugin.
                remove_action('admin_notices', array(ReduxFrameworkPlugin::instance(), 'admin_notices'));
            }
        }

        public function setSections() {

            /**
              Used within different fields. Simply examples. Search for ACTUAL DECLARATION for field examples
             * */
            // Background Patterns Reader
               
            $sample_patterns_path   = get_template_directory().'/img/headers/'; //ReduxFramework::$_dir . '../img/headers/';
            $sample_patterns_url    = get_template_directory_uri().'/img/headers/'; //ReduxFramework::$_url . '../sample/patterns/';
            $header_patterns        = array();
            
            //if (is_dir($sample_patterns_path) || is_dir($sample_patterns_path) ) :
               if ($sample_patterns_dir = opendir($sample_patterns_path)) :
                    $header_patterns = array();

                    while (( $sample_patterns_file = readdir($sample_patterns_dir) ) !== false) {

                        if (stristr($sample_patterns_file, '.png') !== false || stristr($sample_patterns_file, '.jpg') !== false) {
                            $name = explode('.', $sample_patterns_file);
                            $name = str_replace('.' . end($name), '', $sample_patterns_file);
                            //echo $sample_patterns_url . $sample_patterns_file;
                            $header_patterns[]  = array('alt' => $name, 'img' => $sample_patterns_url . $sample_patterns_file);
                        }
                    }
                endif;
            // endif;

            ob_start();

            $ct             = wp_get_theme();
            $this->theme    = $ct;
            $item_name      = $this->theme->get('Name');
            $tags           = $this->theme->Tags;
            $screenshot     = $this->theme->get_screenshot();
            $class          = $screenshot ? 'has-screenshot' : '';

            $customize_title = sprintf(__('Customize &#8220;%s&#8221;', 'oshin'), $this->theme->display('Name'));
            
            ?>
            <div id="current-theme" class="<?php echo esc_attr($class); ?>">
            <?php if ($screenshot) : ?>
                <?php if (current_user_can('edit_theme_options')) : ?>
                        <a href="<?php echo wp_customize_url(); ?>" class="load-customize hide-if-no-customize" title="<?php echo esc_attr($customize_title); ?>">
                            <img src="<?php echo esc_url($screenshot); ?>" alt="<?php esc_attr_e('Current theme preview', 'oshin'); ?>" />
                        </a>
                <?php endif; ?>
                    <img class="hide-if-customize" src="<?php echo esc_url($screenshot); ?>" alt="<?php esc_attr_e('Current theme preview','oshin'); ?>" />
                <?php endif; ?>

                <h4><?php echo $this->theme->display('Name'); ?></h4>

                <div>
                    <ul class="theme-info">
                        <li><?php printf(__('By %s', 'oshin'), $this->theme->display('Author')); ?></li>
                        <li><?php printf(__('Version %s', 'oshin'), $this->theme->display('Version')); ?></li>
                        <li><?php echo '<strong>' . __('Tags', 'oshin') . ':</strong> '; ?><?php printf($this->theme->display('Tags')); ?></li>
                    </ul>
                    <p class="theme-description"><?php echo $this->theme->display('Description'); ?></p>
            <?php
            if ($this->theme->parent()) {
                
                _e('<p class="howto">This <a href="http://codex.wordpress.org/Child_Themes">child theme</a> requires its parent theme</p>', 'oshin' );
            }
            ?>

                </div>
            </div>

            <?php
            $item_info = ob_get_contents();

            ob_end_clean();

            $sampleHTML = '';
            if (file_exists(dirname(__FILE__) . '/info-html.html')) {
                Redux_Functions::initWpFilesystem();
                
                global $wp_filesystem;

                $sampleHTML = $wp_filesystem->get_contents(dirname(__FILE__) . '/info-html.html');
            }

            $title_font = "Lato";
            $body_font = "Open Sans:regular";

            $be_std_font_arr = array(
                
                "Arial, Helvetica, sans-serif"                     => "Arial, Helvetica, sans-serif",
                "Arial Black, Gadget, sans-serif"                  => "Arial Black, Gadget, sans-serif",
                "Bookman Old Style, serif"                         => "Bookman Old Style, serif",
                "Comic Sans MS, cursive"                           => "Comic Sans MS, cursive",
                "Courier, monospace"                               => "Courier, monospace",
                "Garamond, serif"                                  => "Garamond, serif",
                "Georgia, serif"                                   => "Georgia, serif",
                "Impact, Charcoal, sans-serif"                     => "Impact, Charcoal, sans-serif",
                "Lucida Console, Monaco, monospace"                => "Lucida Console, Monaco, monospace",
                "Lucida Sans Unicode, Lucida Grande, sans-serif"   => "Lucida Sans Unicode, Lucida Grande, sans-serif",
                "MS Sans Serif, Geneva, sans-serif"                => "MS Sans Serif, Geneva, sans-serif",
                "MS Serif, New York, sans-serif"                   => "MS Serif, New York, sans-serif",
                "Palatino Linotype, Book Antiqua, Palatino, serif" => "Palatino Linotype, Book Antiqua, Palatino, serif",
                "Tahoma,Geneva, sans-serif"                        => "Tahoma, Geneva, sans-serif",
                "Times New Roman, Times,serif"                     => "Times New Roman, Times, serif",
                "Trebuchet MS, Helvetica, sans-serif"              => "Trebuchet MS, Helvetica, sans-serif",
                "Verdana, Geneva, sans-serif"                      => "Verdana, Geneva, sans-serif",
            );

            $be_custom_font_arr = array(
                "Hans Kendrick Light"                                  => "Hans Kendrick Light",
                "Hans Kendrick Regular"                                => "Hans Kendrick Regular",
                "Hans Kendrick Medium"                                 => "Hans Kendrick Medium",
                "Hans Kendrick Heavy"                                  => "Hans Kendrick Heavy",
            );

            $be_fonts_arr = array_merge($be_std_font_arr, apply_filters('be_themes_custom_font_filter', $be_custom_font_arr) );

            // General Settings
            $this->sections[] = array(
                'title'     => __('General Settings', 'oshin'),
                'desc'      => __('General Settings of the site including the favicon and google analytics.', 'oshin'),
                'icon'      => 'el-icon-adjust-alt',
                'fields'    => array(

                    array (
                        'id' => 'site_status',
                        'type' => 'switch',
                        'title' => __('Cache Options Panel Settings ?', 'oshin'), 
                        //'subtitle' => __('Option\'s panel cache ', 'oshin'),
                        'desc' => __('Turn on Cache once you have completed setting up all the Options here. Turning on cache, will save the options panel settings and that will help us optimize performance of the website. However, any changes to the Options while cache is ON will NOT be saved. So make sure you turn OFF cache before making changes in the Options Panel', 'oshin'),
                        'default' => false
                    ),
                    array (
                        'id' => 'enable_pb',
                        'type' => 'checkbox',
                        'title' => __('Enable Pagebuilder ?', 'oshin'),
                        'subtitle' => __('Check this box if you would like to use the page builder for constructing your pages and portfolio posts. You can still disable the page builder per page if you would like to use the default wordpress content editor', 'oshin'),
                        
                        'default' => 1,
                    ),
                    // array (
                    //     'id' => 'favicon',
                    //     'type' => 'media',
                    //     'title' => __('Your Favicon', 'oshin'), 
                    //     
                    //     'desc' => __('Please upload a favicon here.', 'oshin')
                    // ),
                    array (
                        'id' => 'google_analytics_code',
                        'type' => 'text',
                        'title' => __('Google Analytics Code', 'oshin'), 
                        'desc' => __('Please enter your Google analytics tracking ID here.', 'oshin'),
                        'default' => ''
                    ),
                    array (
                        'id' => 'custom_css',
                        'type' => 'ace_editor',
                        'title' => __('Custom CSS', 'oshin'), 
                        'desc' => __('Please add your custom CSS here.', 'oshin'),
                        'validate' => 'html', 
                        'default' => ''
                    ),
                    array (
                        'id' => 'custom_js',
                        'type' => 'ace_editor',
                        'title' => __('Custom Javascript', 'oshin'), 
                        'desc' => __('Please add your custom js code here.', 'oshin'),
                        'validate' => 'html', 
                        'default' => ''
                    )
                    
                ),
            );
            //Logo
            $this->sections[] = array(
                'title' => __('Logo', 'oshin'),
                
                'icon' => 'el-icon-star',
                'fields' => array ( 
                        array (
                            'id' => 'disable_logo',
                            'type' => 'checkbox',
                            'title' => __('Disable Logo', 'oshin'),
                            'subtitle' => __('Check this is you do not wish to have a logo in your site', 'oshin'),
                            
                            'default' => 0,
                        ),
                        array (
                            'id' => 'logo',
                            'type' => 'media',
                            'title' => __('Logo', 'oshin'), 
                            'subtitle' => __('Upload your logo here.', 'oshin'),
                            'required' => array('disable_logo','equals','0')
                        ),
                        array (
                            'id' => 'logo_sticky',
                            'type' => 'media',
                            'title' => __('Logo on Sticky Header', 'oshin'), 
                            'subtitle' => __('Upload the logo that needs to be displayed in sticky header', 'oshin'),
                            'required' => array('disable_logo','equals','0')
                        ),
                        array (
                            'id' => 'logo_transparent',
                            'type' => 'media',
                            'title' => __('Dark Logo', 'oshin'), 
                            'subtitle' => __('Upload the logo that needs to be displayed in transparent header sections.', 'oshin'),
                            'required' => array('disable_logo','equals','0')
                        ),
                        array (
                            'id' => 'logo_transparent_light',
                            'type' => 'media',
                            'title' => __('Light Logo', 'oshin'), 
                            'subtitle' => __('Upload the logo that needs to be displayed in transparent header sections with dark backgrounds.', 'oshin'),
                            'required' => array('disable_logo','equals','0')
                        ),
                        array (
                            'id' => 'logo_sidebar',
                            'type' => 'media',
                            'title' => __('Logo on Sidebar', 'oshin'), 
                            'subtitle' => __('Upload the logo that needs to be displayed in the slidebar', 'oshin'),
                            'required' => array('disable_logo','equals','0')
                        ),  
                        array(
                            'id'        => 'opt-logo-padding',
                            'type'      => 'text',
                            'title'     => __('Top Header Logo Padding', 'oshin'),
                            'subtitle'  => __('Enter only Numbers (in pixels)', 'oshin'),
                            'default' => '25',
                         ), 
                    )
                );
            //Background
            $this->sections[] = array(
                'title' => __('Background', 'oshin'),
                'desc' => __('Background settings for all the individual elements of the site.', 'oshin'),
                'icon' => 'el-icon-picture',
                'fields' => array (    

                    array(
                        'id'        => 'opt-header-color',
                        'type'      => 'background',
                        'title'     => __('Header', 'oshin'),
                        'default'   => array(
                            'background-color' => '#f2f3f8'
                            )
                    ),   
                    array (
                        'id' => 'header_title_module',
                        'type' => 'background',
                        'title' => __('Page Title Module', 'oshin'), 
                        
                        'default' => array(
                            'background-color' => '#f2f3f8',
                        )
                    ),             
                    array (
                        'id' => 'body',
                        'type' => 'background',
                        'title' => __('Body', 'oshin'), 
                        'default' => array(
                            'background-color' => '#FFFFFF',
                        )
                    ),
                    array (
                        'id' => 'content',
                        'type' => 'background',
                        'title' => __('Content Area', 'oshin'), 
                        
                        
                        'default' => array(
                            'background-color' => '#FFFFFF',
                        )
                    ),
                    array (
                        'id' => 'bottom_widgets',
                        'type' => 'background',
                        'title' => __('Footer Widget Area', 'oshin'), 
                        
                        
                        'default' => array(
                            'background-color' => '#f2f3f8',
                        )
                    ),  
                    array(
                        'id' => 'footer_background',
                        'type' => 'background',
                        'title' => __('Footer', 'oshin'), 
                        
                        
                        'default' => (
                            array ('background-color' => '#ffffff')
                            )
                    ),           
                )
            );
            // Typography
            $this->sections[] = array(
                'title' => __('Typography', 'oshin'),
                
                'icon' => 'el-icon-fontsize',
            );
            // Headings
            $this->sections[] = array(
                'title' => __('Headings', 'oshin'),
                
                'icon' => '',
                'subsection' => 'true',
                'fields' => array (
                    array (
                        'id' => 'h1',
                        'type' => 'typography',
                        'title' => __('H1', 'oshin'), 
                        'subtitle' => __('Heading Tag 1', 'oshin'),
                        'fonts' => $be_fonts_arr,
                        'ext-font-css' => get_stylesheet_directory_uri() . '/fonts/fonts.css',
                        
                        'default'   => array(
                            'color'         => '#222222',
                            'font-size'     => '55px',
                            'line-height'   => '70px',
                            'font-family'   => 'Montserrat',
                            'font-style'    => '',
                            'font-weight'   => '700',
                            'text-transform' => 'none',
                            'letter-spacing' => '0px'
                        ),
                    ),
                    array (
                        'id' => 'h2',
                        'type' => 'typography',
                        'title' => __('H2', 'oshin'), 
                        'subtitle' => __('Heading Tag 2', 'oshin'),
                        'fonts' => $be_fonts_arr,
                        'ext-font-css' => get_stylesheet_directory_uri() . '/fonts/fonts.css',
                        
                        'default'   => array(
                            'color'         => '#222222',
                            'font-size'     => '42px',
                            'line-height'   => '63px',
                            'font-family'   => 'Montserrat',
                            'font-style'    => '',
                            'font-weight'   => '700',
                            'text-transform' => 'none',
                            'letter-spacing' => '0px'
                        ),
                    ),
                    array (
                        'id' => 'h3',
                        'type' => 'typography',
                        'title' => __('H3', 'oshin'), 
                        'subtitle' => __('Heading Tag 3', 'oshin'),
                        'fonts' => $be_fonts_arr,
                        'ext-font-css' => get_stylesheet_directory_uri() . '/fonts/fonts.css',
                        
                        'default'   => array(
                            'color'         => '#222222',
                            'font-size'     => '35px',
                            'line-height'   => '52px',
                            'font-family'   => 'Montserrat',
                            'font-style'    => '',
                            'font-weight'   => '700',
                            'text-transform' => 'none',
                            'letter-spacing' => '1px'
                        ),
                    ),
                    array (
                        'id' => 'h4',
                        'type' => 'typography',
                        'title' => __('H4', 'oshin'), 
                        'subtitle' => __('Heading Tag 4', 'oshin'),
                        'fonts' => $be_fonts_arr,
                        'ext-font-css' => get_stylesheet_directory_uri() . '/fonts/fonts.css',
                        
                        'default'   => array(
                            'color'         => '#222222',
                            'font-size'     => '26px',
                            'line-height'   => '42px',
                            'font-family'   => 'Montserrat',
                            'font-style'    => '',
                            'font-weight'   => '400',
                            'text-transform' => 'none',
                            'letter-spacing' => '0px'
                        ),
                    ),
                    array (
                        'id' => 'h5',
                        'type' => 'typography',
                        'title' => __('H5', 'oshin'), 
                        'subtitle' => __('Heading Tag 5', 'oshin'),
                        'fonts' => $be_fonts_arr,
                        'ext-font-css' => get_stylesheet_directory_uri() . '/fonts/fonts.css',
                        
                        'default'   => array(
                            'color'         => '#222222',
                            'font-size'     => '20px',
                            'line-height'   => '36px',
                            'font-family'   => 'Montserrat',
                            'font-style'    => '',
                            'font-weight'   => '400',
                            'text-transform' => 'none',
                            'letter-spacing' => '0px'
                        ),
                    ),
                    array (
                        'id' => 'h6',
                        'type' => 'typography',
                        'title' => __('H6', 'oshin'), 
                        'subtitle' => __('Heading Tag 6', 'oshin'), 
                        'fonts' => $be_fonts_arr,
                        'ext-font-css' => get_stylesheet_directory_uri() . '/fonts/fonts.css',
                        
                        'default'   => array(
                            'color'         => '#222222',
                            'font-size'     => '15px',
                            'line-height'   => '32px',
                            'font-family'   => 'Montserrat',
                            'font-style'    => '',
                            'font-weight'   => '400',
                            'text-transform' => 'none',
                            'letter-spacing' => '0px'
                        ),
                    ),           
                )
            );
            // Content Area
            $this->sections[] = array(
                'title' => __('Content Area', 'oshin'),
                
                'icon' => '',
                'subsection' => 'true',
                'fields' => array (
                    array (
                        'id' => 'page_title_module_typo',
                        'type' => 'typography',
                        'title' => __('Page Title Module', 'oshin'), 
                        
                        'fonts' => $be_fonts_arr,
                        'ext-font-css' => get_stylesheet_directory_uri() . '/fonts/fonts.css',
                        
                        'default'   => array(
                            'color'         => '#000000',
                            'font-size'     => '18px',
                            'line-height'   => '36px',
                            'font-family'   => 'Montserrat',
                            'font-style'    => '',
                            'font-weight'   => '400',
                            'text-transform' => 'uppercase',
                            'letter-spacing' => '3px'
                        ),
                    ),
                    array (
                        'id' => 'sub_title',
                        'type' => 'typography',
                        'title' => __('Sub Title', 'oshin'), 
                        'subtitle' => __('Font that will be used by the Sub Title Module in Page Builder', 'oshin'), 
                        'fonts' => $be_fonts_arr,
                        'ext-font-css' => get_stylesheet_directory_uri() . '/fonts/fonts.css',
                        
                        'default'   => array(
                            'font-family'   => 'Crimson Text',
                            'font-style'    => 'Italic',
                            'font-weight'   => '400',
                            'text-transform' => 'none',
                            'font-size' => '15px',
                            'letter-spacing' => '0px'
                        ),
                        'color' => false,
                        'letter-spacing' => false,
                        'line-height' => false,                        
                    ),
                    array (
                        'id' => 'body_text',
                        'type' => 'typography',
                        'title' => __('Body Text', 'oshin'), 
                        'fonts' => $be_fonts_arr,
                        'ext-font-css' => get_stylesheet_directory_uri() . '/fonts/fonts.css',
                        
                        
                        'default'   => array(
                            'color'         => '#5f6263',
                            'font-size'     => '13px',
                            'line-height'   => '26px',
                            'font-family'   => 'Raleway',
                            'font-style'    => '',
                            'font-weight'   => '400',
                            'text-transform' => 'none',
                            'letter-spacing' => '0px'
                        ),
                    ),
                    array (
                        'id' => 'sidebar_widget_title',
                        'type' => 'typography',
                        'title' => __('Sidebar Widget Title', 'oshin'), 
                        'fonts' => $be_fonts_arr,
                        'ext-font-css' => get_stylesheet_directory_uri() . '/fonts/fonts.css',
                         
                        
                        'default'   => array(
                            'color'         => '#333333',
                            'font-size'     => '12px',
                            'line-height'   => '22px',
                            'font-family'   => 'Montserrat',
                            'font-style'    => '',
                            'font-weight'   => '400',
                            'text-transform' => 'uppercase',
                            'letter-spacing' => '1px'
                        ),
                    ),
                    array (
                        'id' => 'sidebar_widget_text',
                        'type' => 'typography',
                        'title' => __('Sidebar Widget Text', 'oshin'), 
                         
                        'fonts' => $be_fonts_arr,
                        'ext-font-css' => get_stylesheet_directory_uri() . '/fonts/fonts.css',
                        
                        'default'   => array(
                            'color'         => '#606060',
                            'font-size'     => '13px',
                            'line-height'   => '24px',
                            'font-family'   => 'Raleway',
                            'font-style'    => '',
                            'font-weight'   => '400',
                            'text-transform' => 'none',
                            'letter-spacing' => '0px'
                        ),
                    ),  
                )
            );
            // Main Navigation
            $this->sections[] = array(
                'title' => __('Main Navigation Menu', 'oshin'),
                
                'icon' => '',
                'subsection' => 'true',
                'fields' => array (                   
                    array (
                        'id' => 'navigation_text',
                        'type' => 'typography',
                        'title' => __('Navigation Menu', 'oshin'), 
                         
                        'fonts' => $be_fonts_arr,
                        'ext-font-css' => get_stylesheet_directory_uri() . '/fonts/fonts.css',
                        
                        'default'   => array(
                            'color'         => '#232323',
                            'font-size'     => '12px',
                            'line-height'   => '51px',
                            'font-family'   => 'Montserrat',
                            'font-style'    => '',
                            'font-weight'   => '400',
                            'text-transform' => 'uppercase',
                            'letter-spacing' => '1px'
                        ),
                    ),
                    array (
                        'id' => 'submenu_text',
                        'type' => 'typography',
                        'title' => __('Navigation Submenu', 'oshin'), 
                        
                        'fonts' => $be_fonts_arr,
                        'ext-font-css' => get_stylesheet_directory_uri() . '/fonts/fonts.css',
                        
                        'default'   => array(
                            'color'         => '#bbbbbb',
                            'font-size'     => '13px',
                            'line-height'   => '28px',
                            'font-family'   => 'Raleway',
                            'font-style'    => '',
                            'font-weight'   => '400',
                            'text-transform' => 'none',
                            'letter-spacing' => '0px'
                        ),
                    ),
                )
            );
            // Mobile Menu
            $this->sections[] = array(
                'title' => __('Mobile Menu', 'oshin'),
                
                'icon' => '',
                'subsection' => 'true',
                'fields' => array (  
                    array (
                        'id' => 'mobile_menu_text',
                        'type' => 'typography',
                        'title' => __('Mobile Menu', 'oshin'), 
                         
                        'fonts' => $be_fonts_arr,
                        'ext-font-css' => get_stylesheet_directory_uri() . '/fonts/fonts.css',
                        
                        'default'   => array(
                            'color'         => '#232323',
                            'font-size'     => '12px',
                            'line-height'   => '40px',
                            'font-family'   => 'Montserrat',
                            'font-style'    => '',
                            'font-weight'   => '400',
                            'text-transform' => 'uppercase',
                            'letter-spacing' => '1px'
                        ),
                    ),
                    array (
                        'id' => 'mobile_submenu_text',
                        'type' => 'typography',
                        'title' => __('Mobile Submenu', 'oshin'), 
                        
                        'fonts' => $be_fonts_arr,
                        'ext-font-css' => get_stylesheet_directory_uri() . '/fonts/fonts.css',
                        
                        'default'   => array(
                            'color'         => '#bbbbbb',
                            'font-size'     => '13px',
                            'line-height'   => '27px',
                            'font-family'   => 'Raleway',
                            'font-style'    => '',
                            'font-weight'   => '400',
                            'text-transform' => 'none',
                            'letter-spacing' => '0px'
                        ),
                    ),
                )
            );
            // Slidebar
            $this->sections[] = array(
                'title' => __('Slidebar', 'oshin'),
                'desc' => __('Typography Options for Elements in the Slidebar', 'oshin'),
                'icon' => '',
                'subsection' => 'true',
                'fields' => array (
                    array (
                        'id' => 'sidebar_menu_text',
                        'type' => 'typography',
                        'title' => __('Sidebar Menu Text', 'oshin'), 
                        'subtitle' => __('This typography setting will apply on the Optional Right Sidebar Menu', 'oshin'),
                        'fonts' => $be_fonts_arr,
                        'ext-font-css' => get_stylesheet_directory_uri() . '/fonts/fonts.css',
                        
                        'default'   => array(
                            'color'         => '#ffffff',
                            'font-size'     => '12px',
                            'line-height'   => '50px',
                            'font-family'   => 'Raleway',
                            'font-style'    => '',
                            'font-weight'   => '400',
                            'text-transform' => 'uppercase',
                            'letter-spacing' => '1px'
                        ),
                    ),
                    array (
                        'id' => 'sidebar_submenu_text',
                        'type' => 'typography',
                        'title' => __('Sidebar Sub Menu Text', 'oshin'), 
                        'subtitle' => __('This typography setting will apply on the Optional Right Sidebar Sub-Menu', 'oshin'),
                        'fonts' => $be_fonts_arr,
                        'ext-font-css' => get_stylesheet_directory_uri() . '/fonts/fonts.css',
                        
                        'default'   => array(
                            'color'         => '#ffffff',
                            'font-size'     => '13px',
                            'line-height'   => '25px',
                            'font-family'   => 'Raleway',
                            'font-style'    => '',
                            'font-weight'   => '400',
                            'text-transform' => 'none',
                            'letter-spacing' => ''
                        ),
                    ),
                    array (
                        'id' => 'slidebar_widget_title',
                        'type' => 'typography',
                        'title' => __('Slidebar Widget Title', 'oshin'), 
                         
                        'fonts' => $be_fonts_arr,
                        'ext-font-css' => get_stylesheet_directory_uri() . '/fonts/fonts.css',
                        
                        'default'   => array(
                            'color'         => '#ffffff',
                            'font-size'     => '12px',
                            'line-height'   => '22px',
                            'font-family'   => 'Montserrat',
                            'font-style'    => '',
                            'font-weight'   => '400',
                            'text-transform' => 'none',
                            'letter-spacing' => '1px'
                        ),
                    ),
                    array (
                        'id' => 'slidebar_widget_text',
                        'type' => 'typography',
                        'title' => __('Slidebar Widget Text', 'oshin'), 
                         
                        'fonts' => $be_fonts_arr,
                        'ext-font-css' => get_stylesheet_directory_uri() . '/fonts/fonts.css',
                        
                        'default'   => array(
                            'color'         => '#a2a2a2',
                            'font-size'     => '13px',
                            'line-height'   => '25px',
                            'font-family'   => 'Raleway',
                            'font-style'    => '',
                            'font-weight'   => '400',
                            'text-transform' => 'none',
                            'letter-spacing' => '0px'
                        ),
                    ),

                )
            );  
            // Blog 
            $this->sections[] = array(
                'title' => __('Blog Posts', 'oshin'),
                
                'icon' => '',
                'subsection' => 'true',
                'fields' => array (  
                    array (
                        'id' => 'post_title',
                        'type' => 'typography',
                        'title' => __('Blog Post Title', 'oshin'), 
                        'fonts' => $be_fonts_arr,
                        'ext-font-css' => get_stylesheet_directory_uri() . '/fonts/fonts.css',
                        
                        'default'   => array(
                            'color'         => '#000000',
                            'font-size'     => '20px',
                            'line-height'   => '40px',
                            'font-family'   => 'Montserrat',
                            'font-style'    => '',
                            'font-weight'   => '400',
                            'text-transform' => 'none',
                            'letter-spacing' => '0px'
                        ),
                    ),
                    array (
                        'id' => 'masonry_post_title',
                        'type' => 'typography',
                        'title' => __('Masonry Style Blog Post Title', 'oshin'), 
                        'fonts' => $be_fonts_arr,
                        'ext-font-css' => get_stylesheet_directory_uri() . '/fonts/fonts.css',
                        
                        'default'   => array(
                            'color'         => '#363c3b',
                            'font-size'     => '16px',
                            'line-height'   => '28px',
                            'font-family'   => 'Source Sans Pro',
                            'font-style'    => '',
                            'font-weight'   => '400',
                            'text-transform' => 'none',
                            'letter-spacing' => '0px'
                        ),
                    ),
                    array (
                        'id' => 'post_meta_options',
                        'type' => 'typography',
                        'title' => __('Blog Post Meta Options', 'oshin'), 
                        'fonts' => $be_fonts_arr,
                        'ext-font-css' => get_stylesheet_directory_uri() . '/fonts/fonts.css',
                        
                        'default'   => array(
                            'color'         => '#757575',
                            'font-size'     => '12px',
                            'line-height'   => '24px',
                            'font-family'   => 'Raleway',
                            'font-style'    =>  '',
                            'font-weight'   => '',
                            'text-transform' => 'uppercase',
                            'letter-spacing' => '0px'
                        ),
                    ),
                    array (
                        'id' => 'post_top_meta_options',
                        'type' => 'typography',
                        'title' => __('Blog Post Top Meta Options', 'oshin'), 
                        'subtitle' => __('This typography is used for Meta (Category) in Blog Style with Meta on Top', 'oshin'),
                        'fonts' => $be_fonts_arr,
                        'ext-font-css' => get_stylesheet_directory_uri() . '/fonts/fonts.css',
                        'default'   => array(
                            'color'         => '#757575',
                            'font-size'     => '12px',
                            'line-height'   => '24px',
                            'font-family'   => 'Raleway',
                            'font-style'    =>  '',
                            'font-weight'   => '',
                            'text-transform' => 'uppercase',
                            'letter-spacing' => '0px'
                        ),
                    ),
                )
            );
            // Portfolio
            $this->sections[] = array (
                'icon' => '',
                'subsection' => 'true',
                'title' => __('Portfolio', 'oshin'),
                
                'fields' => array (
                        array (
                            'id' => 'portfolio_caption_typo',
                            'type' => 'typography',
                            'title' => __('Caption in Sliders', 'oshin'), 
                            'subtitle' => __('Applied on Slider Type Portfolios', 'oshin'), 
                            'fonts' => $be_fonts_arr,
                            'ext-font-css' => get_stylesheet_directory_uri() . '/fonts/fonts.css',
                            
                            'default'   => array(
                                'font-family'   => 'Crimson Text',
                                'font-style'    => 'Italic',
                                'font-weight'   => '400',
                                'text-transform' => 'none',
                                'font-size' => '15px',
                                'letter-spacing' => '0px'
                            ),
                            'text-align'    => false,
                        ),
                        array (
                            'id' => 'portfolio_title_count_typo',
                            'type' => 'typography',
                            'title' => __('Title in Portfolio Navigation Module', 'oshin'), 
                            'subtitle' => __('Applied on Slider Type Portfolios', 'oshin'), 
                            'fonts' => $be_fonts_arr,
                            'ext-font-css' => get_stylesheet_directory_uri() . '/fonts/fonts.css',
                            
                            'text-align'    => false,
                            'color' => false,
                            'line-height' => false,
                            'default'   => array(
                                'font-size'     => '15px',
                                'font-family'   => 'Montserrat',
                                'font-style'    => '',
                                'font-weight'   => '400',
                                'text-transform' => 'none',
                                'letter-spacing' => '0px',
                                'line-height' => '40px'
                            )
                        ),
                        array (
                            'id' => 'portfolio_filter_typo',
                            'type' => 'typography',
                            'title' => __('Portfolio Filters', 'oshin'), 
                             
                            'fonts' => $be_fonts_arr,
                            'ext-font-css' => get_stylesheet_directory_uri() . '/fonts/fonts.css',
                            
                            'default'   => array(
                                'color'         => '#222222',
                                'font-size'     => '12px',
                                'line-height'   => '32px',
                                'font-family'   => 'Montserrat',
                                'font-style'    => '',
                                'font-weight'   => '400',
                                'text-transform' => 'uppercase',
                                'letter-spacing' => '1px'
                            ),
                        ), 
                        array (
                            'id' => 'portfolio_title',
                            'type' => 'typography',
                            'title' => __('Title on Portfolio Grid', 'oshin'), 
                             
                            'fonts' => $be_fonts_arr,
                            'ext-font-css' => get_stylesheet_directory_uri() . '/fonts/fonts.css',
                            
                            'default'   => array(
                                'font-size'     => '14px',
                                'line-height'   => '30px',
                                'font-family'   => 'Montserrat',
                                'font-style'    => '',
                                'font-weight'   => '400',
                                'text-transform' => 'uppercase',
                                'letter-spacing' => '0px'
                            ),
                            'color'         => false,
                        ),
                        array (
                            'id' => 'portfolio_meta_typo',
                            'type' => 'typography',
                            'title' => __('Meta on Portfolio Grid', 'oshin'), 
                            'subtitle' => __('Body font will be used for this.', 'oshin'), 
                            'fonts' => $be_fonts_arr,
                            'ext-font-css' => get_stylesheet_directory_uri() . '/fonts/fonts.css',
                            
                            'default'   => array(
                                'font-size'     => '12px',
                                'line-height'   => '17px',
                                'text-transform' => 'none',
                                'letter-spacing'   => 0,
                            ),
                            'color'         => false,
                            'font-family'   => false,
                            'font-weight'   => false,
                            'font-style'    => false,
                            'text-align'    => false,
                        ),
                    )
                );
            // Shop 
            $this->sections[] = array (
                'icon' => '',
                'subsection' => 'true',
                'title' => __('Shop', 'oshin'),
                
                'fields' => array (
                        array (
                            'id' => 'shop_page_title',
                            'type' => 'typography',
                            'title' => __('Product Thumbnail Title', 'oshin'), 
                             
                            'fonts' => $be_fonts_arr,
                            'ext-font-css' => get_stylesheet_directory_uri() . '/fonts/fonts.css',
                            
                            'default'   => array(
                                'color'         => '#222222',
                                'font-size'     => '13px',
                                'line-height'   => '27px',
                                'font-family'   => 'Montserrat',
                                'font-style'    => '',
                                'font-weight'   => '400',
                                'text-transform' => 'uppercase',
                                'letter-spacing' => '1px'
                            ),
                        ),
                        array (
                            'id' => 'shop_single_page_title',
                            'type' => 'typography',
                            'title' => __('Product Single page Title', 'oshin'), 
                             
                            'fonts' => $be_fonts_arr,
                            'ext-font-css' => get_stylesheet_directory_uri() . '/fonts/fonts.css',
                            
                            'default'   => array(
                                'color'         => '#222222',
                                'font-size'     => '25px',
                                'line-height'   => '27px',
                                'font-family'   => 'Montserrat',
                                'font-style'    => '',
                                'font-weight'   => '400',
                                'text-transform' => 'none',
                                'letter-spacing' => '0px'
                            ),
                        ),
                    )
                );
            // Contact Form
            $this->sections[] = array (
                'icon' => '',
                'subsection' => 'true',
                'title' => __('Contact Form', 'oshin'),
                
                'fields' => array (
                        array (
                            'id' => 'contact_form_typo',
                            'type' => 'typography',
                            'title' => __('Contact Form Typography', 'oshin'), 
                            
                            'fonts' => $be_fonts_arr,
                            'ext-font-css' => get_stylesheet_directory_uri() . '/fonts/fonts.css',
                            
                            'default'   => array (
                                'color'         => '#222222',
                                'font-size'     => '13px',
                                'line-height'   => '26px',
                                'font-family'   => 'Montserrat',
                                'font-style'    => '',
                                'font-weight'   => '400',
                                'text-transform' => 'none',
                                'letter-spacing' => '0px'
                            ),
                        ),
                    )
                );
            // Footer
            $this->sections[] = array(
                'title' => __('Footer and Footer Widgets', 'oshin'),
                
                'icon' => '',
                'subsection' => 'true',
                'fields' => array (
                    array (
                        'id' => 'footer_text', 
                        'type' => 'typography',
                        'title' => __('Footer Text', 'oshin'), 
                        
                        'fonts' => $be_fonts_arr,
                        'ext-font-css' => get_stylesheet_directory_uri() . '/fonts/fonts.css',
                        
                        'default'   => array(
                            'color'         => '#888888',
                            'font-size'     => '13px',
                            'line-height'   => '14px',
                            'font-family'   => 'Raleway',
                            'font-style'    => '',
                            'font-weight'   => '400',
                            'text-transform' => 'none',
                            'letter-spacing' => '0px'
                        ),
                    ),
                    array (
                        'id' => 'bottom_widget_title',
                        'type' => 'typography',
                        'title' => __('Footer Widget Title', 'oshin'), 
                         
                        'fonts' => $be_fonts_arr,
                        'ext-font-css' => get_stylesheet_directory_uri() . '/fonts/fonts.css',
                        
                        'default'   => array(
                            'color'         => '#474747',
                            'font-size'     => '12px',
                            'line-height'   => '22px',
                            'font-family'   => 'Montserrat',
                            'font-style'    => '',
                            'font-weight'   => '400',
                            'text-transform' => 'uppercase',
                            'letter-spacing' => '1px'
                        ),
                    ),
                    array (
                        'id' => 'bottom_widget_text',
                        'type' => 'typography',
                        'title' => __('Footer Widget Text', 'oshin'), 
                         
                        'fonts' => $be_fonts_arr,
                        'ext-font-css' => get_stylesheet_directory_uri() . '/fonts/fonts.css',
                        
                        'default'   => array(
                            'color'         => '#757575',
                            'font-size'     => '13px',
                            'line-height'   => '24px',
                            'font-family'   => 'Raleway',
                            'font-style'    => '',
                            'font-weight'   => '400',
                            'text-transform' => 'none',
                            'letter-spacing' => '0px'
                        ),
                    ),
                )
            );
            // Page Builder Typography Settings
            $this->sections[] = array (
                'icon' => '',
                'subsection' => 'true',
                'title' => __('BE Page Builder', 'oshin'),
                'desc' => __('Typography settings for specific modules in BE Page Builder', 'oshin'),
                'fields' => array (
                    array (
                        'id' => 'pb_module_title',
                        'type' => 'typography',
                        'title' => __('Title Font Family', 'oshin'), 
                        'subtitle' => __('The title font will be applied to the Title section of selected modules that includes - Tabs, Accordion, Animated Charts and Skills', 'oshin'), 
                        'fonts' => $be_fonts_arr,
                        'ext-font-css' => get_stylesheet_directory_uri() . '/fonts/fonts.css',
                        
                        'default'   => array(
                            'font-family'   => 'Raleway',
                            'letter-spacing' => '0px',
                            'font-weight'   => '600',
                            'font-style'    => '',
                        ),
                        'color'         => false,
                        'font-size'     => false,
                        'line-height'   => false,
                        'text-align'    => false,
                        'text-transform' => false,
                    ),
                    array (
                        'id' => 'pb_tab_font_size',
                        'type' => 'typography',
                        'title' => __('Tab Module Title Size', 'oshin'), 
                        'subtitle' => __('The font size for Tab module title', 'oshin'), 
                        'fonts' => $be_fonts_arr,
                        'ext-font-css' => get_stylesheet_directory_uri() . '/fonts/fonts.css',
                        
                        'default'   => array(
                            'font-size'     => '13px',
                            'line-height'   => '17px',
                            'text-transform' => 'uppercase',
                        ),
                        'color'         => false,
                        'font-family'   => false,
                        'font-weight'   => false,
                        'font-style'    => false,
                        'letter-spacing'   => false,
                        'text-align'    => false,
                    ),
                    array (
                        'id' => 'pb_acc_font_size',
                        'type' => 'typography',
                        'title' => __('Accordion Module Title Size', 'oshin'), 
                        'subtitle' => __('The font size for Accordion module title', 'oshin'), 
                        'fonts' => $be_fonts_arr,
                        'ext-font-css' => get_stylesheet_directory_uri() . '/fonts/fonts.css',
                        
                        'default'   => array(
                            'font-size'     => '13px',
                            'line-height'   => '17px',
                            'text-transform' => 'uppercase',
                        ),
                        'color'         => false,
                        'font-family'   => false,
                        'font-weight'   => false,
                        'font-style'    => false,
                        'letter-spacing'   => false,
                        'text-align'    => false,
                    ),
                    array (
                        'id' => 'pb_skill_font_size',
                        'type' => 'typography',
                        'title' => __('Skills Module Title Size', 'oshin'), 
                        'subtitle' => __('The font size for Skills module title', 'oshin'), 
                        'fonts' => $be_fonts_arr,
                        'ext-font-css' => get_stylesheet_directory_uri() . '/fonts/fonts.css',
                        
                        'default'   => array(
                            'font-size'     => '12px',
                            'line-height'   => '17px',
                            'text-transform' => 'uppercase',
                        ),
                        'color'         => false,
                        'font-family'   => false,
                        'font-weight'   => false,
                        'font-style'    => false,
                        'letter-spacing'   => false,
                        'text-align'    => false,
                    ),
                    array (
                        'id' => 'pb_countdown_number_font_size',
                        'type' => 'typography',
                        'title' => __('Countdown Number Font Size', 'oshin'), 
                        'subtitle' => __('The font size for Countdown module number', 'oshin'), 
                        'fonts' => $be_fonts_arr,
                        'ext-font-css' => get_stylesheet_directory_uri() . '/fonts/fonts.css',
                        
                        'default'   => array(
                            'font-size'     => '55px',
                            'line-height'   => '95px',
                            'text-transform' => 'uppercase',
                        ),
                        'color'         => false,
                        'font-family'   => false,
                        'font-weight'   => false,
                        'font-style'    => false,
                        'letter-spacing'   => false,
                        'text-align'    => false,
                    ),  
                    array (
                        'id' => 'pb_countdown_caption_font_size',
                        'type' => 'typography',
                        'title' => __('Countdown Caption Font Size', 'oshin'), 
                        'subtitle' => __('The font size for Countdown module caption', 'oshin'), 
                        'fonts' => $be_fonts_arr,
                        'ext-font-css' => get_stylesheet_directory_uri() . '/fonts/fonts.css',
                        
                        'default'   => array(
                            'font-size'     => '15px',
                            'line-height'   => '30px',
                            'text-transform' => 'uppercase',
                        ),
                        'color'         => false,
                        'font-family'   => false,
                        'font-weight'   => false,
                        'font-style'    => false,
                        'letter-spacing'   => false,
                        'text-align'    => false,
                    ),                                        
                    array (
                        'id' => 'pb_module_spl_body',
                        'type' => 'typography',
                        'title' => __('Content Font Family', 'oshin'), 
                        'subtitle' => __('This font will be applied to the Content section of selected modules that includes - Blockquote, Testimonials etc', 'oshin'), 
                        'fonts' => $be_fonts_arr,
                        'ext-font-css' => get_stylesheet_directory_uri() . '/fonts/fonts.css',
                        
                        'default'   => array(
                            'font-family'   => 'Crimson Text',
                            'letter-spacing' => '0px',
                            'font-weight'   => '400',
                            'font-style'    => 'Italic',
                            'text-transform' => 'none',
                        ),
                        'color'         => false,
                        'font-size'     => false,
                        'line-height'   => false,
                        'text-align'    => false,
                    ),
                    array (
                        'id' => 'pb_blockquote_font_size',
                        'type' => 'typography',
                        'title' => __('Blockquote Font Size', 'oshin'), 
                        'subtitle' => __('The font size for Blockquote module', 'oshin'), 
                        'fonts' => $be_fonts_arr,
                        'ext-font-css' => get_stylesheet_directory_uri() . '/fonts/fonts.css',
                        
                        'default'   => array(
                            'font-size'     => '26px',                      
                            ),
                        'color'         => false,
                        'font-family'   => false,
                        'font-weight'   => false,
                        'font-style'    => false,
                        'letter-spacing'    => false,
                        'line-height'       => false,
                        'text-transform'    => false,
                        'text-align'        => false,
                    ),
                    array (
                        'id' => 'pb_module_tweet',
                        'type' => 'typography',
                        'title' => __('Tweet Module Font Family', 'oshin'), 
                        'subtitle' => __('This font will be applied to the Content section of the Tweet Module', 'oshin'), 
                        'fonts' => $be_fonts_arr,
                        'ext-font-css' => get_stylesheet_directory_uri() . '/fonts/fonts.css',
                        
                        'default'   => array(
                            'font-family'   => 'Raleway',
                            'letter-spacing' => '0px',
                            'font-weight'   => '',
                            'font-style'    => '',
                            'text-transform' => 'none',
                        ),
                        'color'         => false,
                        'font-size'     => false,
                        'line-height'   => false,
                        'text-align'    => false,
                    ),
                    array (
                        'id' => 'button_font',
                        'type' => 'typography',
                        'title' => __('Buttons Font Family', 'oshin'), 
                        
                        'fonts' => $be_fonts_arr,
                        'ext-font-css' => get_stylesheet_directory_uri() . '/fonts/fonts.css',
                        'desc' => __('' , 'oshin'),
                        'default'   => array(
                            'font-family'   => 'Montserrat',
                            'font-style'    => '',
                            'font-weight'   => '',
                        ),
                        'letter-spacing' => false,
                        'font-size'     => false,
                        'line-height'   => false,
                        'text-transform' => false,
                        'letter-spacing' => false,
                        'color' => false,
                        'text-align'   => false,
                    ),
                )
            );
            //Mobile Device Typography
            $this->sections[] = array(
                'title' => __('Heading Tags on Mobile', 'oshin'),
                
                'icon' => '',
                'subsection' => 'true',
                'fields' => array (
                    array (
                        'id'        => 'mobile_typo_controller',
                        'type'      => 'checkbox',
                        'title'     => __('Set Font Sizes for Mobile Devices', 'oshin'), 
                        'subtitle'  => __('', 'oshin'),
                        'desc'      => __('By default the Sizes set under OSHINE OPTIONS > TYPOGRAPHY will be applied in all devices', 'oshin'),
                        'default'   => 0,
                    ),        
                    array (
                        'id' => 'h1_mobile',
                        'type' => 'typography',
                        'title' => __('H1', 'oshin'), 
                        'subtitle' => __('Heading Tag 1', 'oshin'),
                        'fonts' => $be_fonts_arr,
                        'ext-font-css' => get_stylesheet_directory_uri() . '/fonts/fonts.css',
                        
                        'default'   => array(
                            'font-size'     => '30px',
                            'line-height'   => '40px',
                        ),
                        'required' => array('mobile_typo_controller','equals','1'),
                        'color' => false,
                        'font-family'   => false,
                        'font-style'    => false,
                        'font-weight'   => false,
                        'text-transform' => false,
                        'letter-spacing' => false,
                        'text-align' => false,
                    ),
                    array (
                        'id' => 'h2_mobile',
                        'type' => 'typography',
                        'title' => __('H2', 'oshin'), 
                        'subtitle' => __('Heading Tag 2', 'oshin'),
                        'fonts' => $be_fonts_arr,
                        'ext-font-css' => get_stylesheet_directory_uri() . '/fonts/fonts.css',
                        
                        'default'   => array(
                            'font-size'     => '25px',
                            'line-height'   => '35px',
                        ),
                        'required' => array('mobile_typo_controller','equals','1'),
                        'color' => false,
                        'font-family'   => false,
                        'font-style'    => false,
                        'font-weight'   => false,
                        'text-transform' => false,
                        'letter-spacing' => false,
                        'text-align' => false,
                    ),
                    array (
                        'id' => 'h3_mobile',
                        'type' => 'typography',
                        'title' => __('H3', 'oshin'), 
                        'subtitle' => __('Heading Tag 3', 'oshin'),
                        'fonts' => $be_fonts_arr,
                        'ext-font-css' => get_stylesheet_directory_uri() . '/fonts/fonts.css',
                        
                        'default'   => array(
                            'font-size'     => '20px',
                            'line-height'   => '30px',
                        ),
                        'required' => array('mobile_typo_controller','equals','1'),
                        'color' => false,
                        'font-family'   => false,
                        'font-style'    => false,
                        'font-weight'   => false,
                        'text-transform' => false,
                        'letter-spacing' => false,
                        'text-align' => false,
                    ),
                    array (
                        'id' => 'h4_mobile',
                        'type' => 'typography',
                        'title' => __('H4', 'oshin'), 
                        'subtitle' => __('Heading Tag 4', 'oshin'),
                        'fonts' => $be_fonts_arr,
                        'ext-font-css' => get_stylesheet_directory_uri() . '/fonts/fonts.css',
                        
                        'default'   => array(
                            'font-size'     => '16px',
                            'line-height'   => '30px',
                        ),
                        'required' => array('mobile_typo_controller','equals','1'),
                        'color' => false,
                        'font-family'   => false,
                        'font-style'    => false,
                        'font-weight'   => false,
                        'text-transform' => false,
                        'letter-spacing' => false,
                        'text-align' => false,
                    ),
                    array (
                        'id' => 'h5_mobile',
                        'type' => 'typography',
                        'title' => __('H5', 'oshin'), 
                        'subtitle' => __('Heading Tag 5', 'oshin'),
                        'fonts' => $be_fonts_arr,
                        'ext-font-css' => get_stylesheet_directory_uri() . '/fonts/fonts.css',
                        
                        'default'   => array(
                            'font-size'     => '16px',
                            'line-height'   => '30px',
                        ),
                        'required' => array('mobile_typo_controller','equals','1'),
                        'color' => false,
                        'font-family'   => false,
                        'font-style'    => false,
                        'font-weight'   => false,
                        'text-transform' => false,
                        'letter-spacing' => false,
                        'text-align' => false,
                    ),
                    array (
                        'id' => 'h6_mobile',
                        'type' => 'typography',
                        'title' => __('H6', 'oshin'), 
                        'subtitle' => __('Heading Tag 6', 'oshin'), 
                        'fonts' => $be_fonts_arr,
                        'ext-font-css' => get_stylesheet_directory_uri() . '/fonts/fonts.css',
                        
                        'default'   => array(
                            'font-size'     => '15px',
                            'line-height'   => '32px',
                        ),
                        'required' => array('mobile_typo_controller','equals','1'),
                        'color' => false,
                        'font-family'   => false,
                        'font-style'    => false,
                        'font-weight'   => false,
                        'text-transform' => false,
                        'letter-spacing' => false,
                        'text-align' => false,
                    ),           
                )
            );

            //Site Layout
            $this->sections[] = array(
                'icon' => 'el-icon-website',
                'title' => __('Global Site Layout and Settings', 'oshin'),
                'desc' => __('This Panel has all the settings related to the Global Settings and Layout of your Website', 'oshin'),
                'fields' => array (
                    array(
                        'id'        => 'opt-header-type',
                        'type'      => 'select',
                        'title'     => __('Header Layout', 'oshin'),
                        'options'   => array('top' => 'Top Header' , 'left' => 'Left Header'), 
                        'default'   => 'top',
                    ), 
                    array (
                        'id' => 'layout',
                        'type'  => 'select',
                        'title' => __('Site Layout', 'oshin'), 
                        
                        
                        'options'=> array (
                            'layout-box'=>'Boxed Layout', 
                            'layout-wide'=>'Wide Layout',
                            'layout-border'=>'Border Layout',
                            'layout-border-header-top'=>'Header Top Border Layout',
                        ),
                        'default' => 'layout-wide'
                    ),  
                    array(
                        'id'        => 'border-settings-start',
                        'type'      => 'section',
                        'title'     => 'Border Layout Settings',
                        'subtitle'  => __('These settings will be applicable if you choose Border Layout in the above option. This is not required for other layouts','oshin'),
                        'indent'    => true, // Indent all options below until the next 'section' option is set.
                    ),                    
                    array(
                        'id'        => 'border-bg-setting',
                        'type'      => 'background',
                        'title'     => __('Border BG', 'oshin'), 
                        'subtitle'  => __('', 'oshin'),
                        'desc'      => __('', 'oshin'),
                        'default'   => array(
                            'background-color' => '#d3d3d3',
                        )
                    ),                     
                    array(
                        'id'        => 'border-width',
                        'type'      => 'text',
                        'title'     => __('Border Width(in px)', 'oshin'), 
                        'subtitle'  => __('Enter Value Only', 'oshin'),
                        'desc'      => __('', 'oshin'),
                        'default'   => '30'
                    ),  
                    array(
                        'id'        => 'border-settings-end',
                        'type'      => 'section',
                        'indent'    => false, // End of Indentation.
                    ),
                    
                    array (
                        'id' => 'all_ajax',
                        'type' => 'checkbox',
                        'title' => __('Enable Ajax Transitions', 'oshin'),
                        
                        'desc' => __('NOTE - Ajax Transitions is not compatible with Slider Revolution and Masterslider plugin currently. Hence, Ajax loading will be Hard-Disabled if any of these Plugins are activated. This option will not take effect for now and will be added once the plugin authors provide compatibility.', 'oshin'),
                        'default' => 0
                    ),
                    array (
                        'id' => 'all_ajax_exclude_links',
                        'type' => 'textarea',
                        'title' => __('Exclude Ajax Loading on pages', 'oshin'),
                        'subtitle' => __('Seperate by ,', 'oshin'),
                        'desc' => __('', 'oshin')
                    ),  
                    array (
                        'id' => 'page_loader_style',
                        'type' => 'select',
                        'title' => __('Loader Style', 'oshin'),
                        
                        
                        'options'=> array (
                            'style1-loader'=>'Style1 Loader', 
                            'style2-loader'=>'Style2 Loader',
                            'style3-loader'=>'Style3 Loader',
                            'style4-loader'=>'Style4 Loader',
                            'style5-loader'=>'Style5 Loader',
                            'style6-loader'=>'Style6 Loader',
                        ),
                        'default' => 'style1-loader'
                    ), 
                    array (
                        'id' => 'comments_on_page',
                        'type' => 'checkbox',
                        'title' => __('Display Comments on Pages', 'oshin'),
                        
                        
                        'default' => 1
                    ), 
                    array (
                        'id' => 'rev_slider_bg_check',
                        'type' => 'checkbox',
                        'title' => __('Disable Dynamic Menu Color Change on Slider Revolution', 'oshin'),
                        
                        
                        'default' => 0
                    ),
                    array (
                        'id' => 'disable_css_animation_mobile',
                        'type' => 'checkbox',
                        'title' => __('Disable CSS Animtion in mobile devices', 'oshin'),
                        
                        
                        'default' => 0
                    ),
                    array (
                        'id' => 'disable_back_top_btn',
                        'type' => 'checkbox',
                        'title' => __('Disable Back to top Button', 'oshin'),
                        
                        
                        'default' => 0
                    ),
                    
                    array (
                        'id' => 'textbox_style',
                        'type' => 'select',
                        'title' => __('Form Field Style', 'oshin'),
                        
                        
                        'options'=> array (
                            'style1'=>'Transparent', 
                            'style2'=>'With Background',
                        ),
                        'default' => 'style1'
                    ),
                    array (
                        'id' => 'button_shape',
                        'type' => 'select',
                        'title' => __('Button Shape', 'oshin'), 
                        'subtitle' => __('Not Applicable for Button Style - TEXT UNDERLINE', 'oshin'),
                        'desc' => __('The Button Shape will be applied on Blog Read More, Portfolio View Project, Commnets Submit, Shop Pages and Contact Form Buttons' , 'oshin'),
                        'options'=> array('rounded' => 'Rounded', 'circular'=>'Circular', 'none'=>'Default'),
                        'default' => 'none'
                    ),                        
                    array (
                        'id' => 'custom_sidebars',
                        'type' => 'multi_text',
                        'title' => __('Custom Sidebars', 'oshin'),
                        
                        
                        'default' => ''
                    ),
                    array (
                        'id' => 'bottom_widgets_layout',
                        'type' => 'select',
                        'title' => __('Number of Columns in Footer Widget Area', 'oshin'), 
                        
                        
                        'options'   => array('three-col' => 'Three Column' , 'four-col' => 'Four Column'), 
                        'default' => 'four-col'
                    ),  
                    array (
                        'id' => 'show_bottom_widgets',
                        'type' => 'select',
                        'title' => __('Show Footer Widget Area in Archive and Search Pages', 'oshin'), 
                        
                        'desc' => __('' , 'oshin'),
                        'options'=> array('yes'=>'Yes', 'no'=>'No'),
                        'default' => 'yes'
                    ),
                    array (
                        'id' => 'instagram_access_token',
                        'type' => 'text',
                        'title' => __('Instagram Access Token', 'oshin'), 
                        'subtitle' => __("<a href='http://instagram.pixelunion.net/' target='_blank'>Generate Access Token</a>", 'oshin'),
                        'desc' => __('' , 'oshin'),
                        'default' => ''
                    ), 
                    array (
                        'id' => 'google_map_api_key',
                        'type' => 'text',
                        'title' => __('Google Map API Key', 'oshin'), 
                        'subtitle' => __("<a href='https://developers.google.com/maps/documentation/javascript/get-api-key/' target='_blank'>Generate your API Key</a>", 'oshin'),
                        'desc' => __('' , 'oshin'),
                        'default' => ''
                    ),  
                )
            );
            //Top Header Settings
            $this->sections[] = array(
                'title'     => __('Top Header Settings', 'oshin'),
                'desc'      => __('This Panel has all the settings related to the Top Header Style', 'oshin'),
                'icon'      => 'el-icon-hand-up',
                'subsection' => false
            );
            //Top Header Style
            $this->sections[] = array(
                'title'     => __('Header Style', 'oshin'),
                'desc'      => __('', 'oshin'),
                'icon'      => '',
                'subsection' => true,
                'fields'    => array(
                    array(
                        'id'        => 'opt-header-wrap',
                        'type'      => 'switch',
                        'title'     => __('Header Wrap', 'oshin'),
                        'subtitle'  => __('Turn this off if you want a Full Screen Width Header', 'oshin'),
                        'default'   => false,
                    ),
                    array(
                        'id'        => 'opt-header-style',
                        'type'      => 'select_image',
                        'tiles'     => true,
                        'title'     => __('Top Header Style', 'oshin'),
                        'subtitle'  => __('', 'oshin'),
                        'options'   => $header_patterns  ,
                        'default' => 'style3',//get_template_directory_uri().'/img/headers/style3.png',
                    ),   
                    array (
                        'id' => 'sticky_header',
                        'type' => 'checkbox',
                        'title' => __('Enable Sticky Header', 'oshin'),
                        
                        
                        'default' => 0
                    ),  
                    array(
                        'id'        => 'semi-transparent-header-color',
                        'type'      => 'color_rgba',
                        'title'     => __('Semi Transparent Background Color', 'oshin'), 
                        'subtitle'  => __('This color will apply as BG for the Top Header in pages where you choose Semi Transparent Header' , 'oshin'),
                        'desc'      => __('', 'oshin'),
                        'default'   =>  array('color' => '#000000', 'alpha' => '0.4'),
                    ),
                    array(
                        'id'        => 'opt-header-border-color',
                        'type'      => 'border',
                        'title'     => __('Header Border Color', 'oshin'),
                        'subtitle'  => __('Border Bottom','oshin'),
                        'default'   => array(
                            'border-color'  => '', 
                            'border-style'  => 'none', 
                            'bottom' => '0px'
                        ),
                        'all'    => false,
                        'top'    => false,
                        'left'   => false,
                        'right'  => false
                    ),              
                    array(
                        'id'        => 'opt-header-border-wrap',
                        'type'      => 'switch',
                        'title'     => __('Header Border Wrap', 'oshin'),
                        'subtitle'  => __('Turn this on if you want a wrapped border', 'oshin'),
                        'default'   => false,
                    ),
                )
            );
            //Header Menu Settings
            $this->sections[] = array(
                'title'     => __('Menu and Sub Menu', 'oshin'),
                'desc'      => __('This Panel has all the settings related to the Header', 'oshin'),
                'icon'      => '',
                'subsection' => true,
                'fields'    => array(
                    array (
                        'id'        => 'top-menu-style',
                        'type'      => 'select',
                        'title'     => __('Special Menu Type', 'oshin'),
                        'subtitle'  => __('Choose the type of Special Menu for navigation. This is possible in any of the Header Styles choosen above. ','oshin'),
                        'options'   => array (
                                        'top-overlay-menu' => 'Overlay Menu', 
                                        'menu-animate-fall' => 'Animate Falling',
                                        'none' => 'None'
                                    ) ,
                        'default'   => 'none',
                    ),
                    array (
                        'id' => 'nav_link_style',
                        'type' => 'select',
                        'title' => __('Navigation Link Hover Style', 'oshin'), 
                        'subtitle' => __('Does not apply for Overlay Menu Style', 'oshin'),
                        
                        'options'   => array('none' => 'None', 'be-nav-link-effect-1' => 'Bottom Line Fades In' , 'be-nav-link-effect-2' => 'Bottom Line Diverges out upto the Edge' , 'be-nav-link-effect-3' => 'Bottom Line Diverges out'), 
                        'default' => 'none'
                    ),  
                    array (
                        'id'        => 'nav_link_hover_color_controller',
                        'type'      => 'checkbox',
                        'title'     => __('Set Navigation Link Hover Color', 'oshin'), 
                        'subtitle'  => __('', 'oshin'),
                        'desc'      => __('By default the Color Scheme set under OSHINE OPTIONS > COLORS will be applied for Menu Links on Hover State', 'oshin'),
                        'default'   => 0,
                    ),              
                    array (
                        'id'        => 'nav_link_hover_color',
                        'type'      => 'color',
                        'title'     => __('Navigation Link Hover Color', 'oshin'), 
                        'subtitle'  => __('', 'oshin'),
                        'desc'      => __('', 'oshin'),
                        'default'   => '',
                        'required' => array('nav_link_hover_color_controller','equals','1')
                    ), 
                    array (
                        'id'        => 'sidebar_menu_bg_color',
                        'type'      => 'color_rgba',
                        'title'     => __('Right Slidebar/Overlay Menu Background Color', 'oshin'), 
                        'subtitle'  => __('', 'oshin'),
                        'desc'      => __('', 'oshin'),
                        'default'   =>  array('color' => '#1a1a1a', 'alpha' => '1'),
                    ),  
                    array(
                        'id'        => 'right_side_menu_border',
                        'type'      => 'color',
                        'title'     => __('Right Slidebar/Overlay Menu Border Color', 'oshin'), 
                        'subtitle'  => __('', 'oshin'),
                        'desc'      => __('', 'oshin'),
                        'default'   => '#2d2d2d'
                    ), 
                    array(
                        'id'        => 'submenu_bg_color',
                        'type'      => 'color_rgba',
                        'title'     => __('Submenu Background Color', 'oshin'), 
                        'subtitle'  => __('', 'oshin'),
                        'desc'      => __('', 'oshin'),
                        'default'   =>  array('color' => '#1f1f1f', 'alpha' => '1'),
                    ),  
                    array(
                        'id'        => 'sub_menu_border',
                        'type'      => 'color',
                        'title'     => __('Submenu Border Color', 'oshin'), 
                        'subtitle'  => __('', 'oshin'),
                        'desc'      => __('', 'oshin'),
                        'default'   => '#3d3d3d'
                    ),   
                )
            );
            //Header Widget Settings
            $this->sections[] = array(
                'title'     => __('Header Widgets', 'oshin'),
                'desc'      => __('This Panel has all the settings related to the Header', 'oshin'),
                'icon'      => '',
                'subsection' => true,
                'fields'    => array(
                    array(
                        'id'        => 'opt-header-pos',
                        'type'      => 'sorter',
                        'title'     => __('Position of widgets in Header','oshin'),
                        'compiler'  => 'true',
                        'options'   => array(
                            'unused'  => array(
                                'phone' => 'Text 1',
                                'email' => 'Text 2',
                                'smenu' => 'Sliding Menu',
                                'menu'  => 'Menu Links',
                                'socialmedia' => 'Code Content',
                                'search' => 'Search Wdiget',
                                'cart'   => 'Cart',
                            ),
                            'left'   => array(
                            ),
                            'right'    => array(
                            ),
                        ),
                        'default'  => false
                    ),
                    array(
                        'id'        => 'opt-header-widgets-left',
                        'type'      => 'section',
                        'title'     => 'Text and Code Widget Settings',
                        'indent'    => true, // Indent all options below until the next 'section' option is set.
                    ),
                        array(
                            'id'        => 'opt-phone-header',
                            'type'      => 'text',
                            'title'     => __('Text Area 1', 'oshin'),
                            'default'   => '',
                        ),
                        array(
                            'id'        => 'opt-email-header',
                            'type'      => 'text',
                            'title'     => __('Text Area 2', 'oshin'),
                            'default'   => '',
                        ),
                        array(
                            'id'        => 'opt-header-social-media',
                            'type'      => 'ace_editor',
                            'multi'     => true,
                            'title'     => __('Content using Code/Shortcode', 'oshin'),
                            'subtitle'  => __('For Example Social Media Icons', 'oshin'),
                        ),
                    array(
                        'id'        => 'opt-header-widgets-left-end',
                        'type'      => 'section',
                        'indent'    => false, // End of Indentation.
                    ), 
                    array (
                        'id'        => 'search-settings-start',
                        'type'      => 'section',
                        'title'     => 'Search Widget Settings',
                        'indent'    => true, // Indent all options below until the next 'section' option is set.
                    ), 
                        array (
                            'id' => 'seach_widget_style',
                            'type' => 'select',
                            'title' => __('Header Search Widget Style', 'oshin'),
                            
                            
                            'options'=> array (
                                'style1-header-search-widget' => 'Search Bar', 
                                'style2-header-search-widget' => 'Overlay Search'
                            ),
                            'default' => 'style2-header-search-widget'
                        ),                   
                        array(
                            'id'        => 'search_bg',
                            'type'      => 'color_rgba',
                            'title'     => __('Search Screen BG', 'oshin'), 
                            'subtitle'  => __('', 'oshin'),
                            'desc'      => __('', 'oshin'),
                            'default'   => array('color' => '#ffffff', 'alpha' => '0.85'),
                        ),                
                        array(
                            'id'        => 'search_font_color',
                            'type'      => 'color',
                            'title'     => __('Search Text Color', 'oshin'), 
                            'subtitle'  => __('', 'oshin'),
                            'desc'      => __('', 'oshin'),
                            'default'   => '#000000'
                        ),
                    array(
                        'id'        => 'search-settings-end',
                        'type'      => 'section',
                        'indent'    => false, // Indent all options below until the next 'section' option is set.
                    ), 
                    array (
                        'id'        => 'cart-settings-start',
                        'type'      => 'section',
                        'title'     => 'Cart Widget Settings',
                        'indent'    => true, // Indent all options below until the next 'section' option is set.
                    ),
                        array(
                            'id'        => 'header_cart_count_background',
                            'type'      => 'color',
                            'title'     => __('Header Cart Number Background Color', 'oshin'), 
                            'subtitle'  => __('', 'oshin'),
                            'desc'      => __('', 'oshin'),
                            'default'   => '#646464'
                        ),
                        array(
                            'id'        => 'header_cart_count_color',
                            'type'      => 'color',
                            'title'     => __('Header Cart Number Text Color', 'oshin'), 
                            'subtitle'  => __('', 'oshin'),
                            'desc'      => __('', 'oshin'),
                            'default'   => '#f5f5f5'
                        ), 
                    array(
                        'id'        => 'cart-settings-end',
                        'type'      => 'section',
                        'indent'    => false, // Indent all options below until the next 'section' option is set.
                    ), 
                )
            );
            //Header Top Bar
            $this->sections[] = array(
                'title'     => __('Header Top Bar', 'oshin'),
                'desc'      => __('Top Bar will apply only on TOP header style and not on Left Header', 'oshin'),
                'icon'      => '',
                'subsection' => true,
                'fields'    => array(
                    array(
                        'id'        => 'opt-noshow-topbar',
                        'type'      => 'checkbox',
                        'title'     => __('Enable Header Top Bar', 'oshin'),
                        'desc'      => __('', 'oshin'),
                        'default'   => 0// 1 = on | 0 = off
                    ),
                    array(
                        'id'        => 'opt-topbar-color',
                        'type'      => 'color_rgba',
                        'title'     => __('Top Bar Background Color', 'oshin'),
                        'default'   => array('color' => '#323232', 'alpha' => '0.85'),
                    ),
                    array(
                        'id'        => 'opt-topbar-text-color',
                        'type'      => 'color',
                        'title'     => __('TopBar Text Color', 'oshin'),
                        'default'   => '#ffffff',
                    ),
                    array(
                        'id'        => 'opt-topbar-border-color',
                        'type'      => 'border',
                        'title'     => __('Top Bar Border (bottom) Color', 'oshin'),
                        'default'   => array(
                            'border-color'  => '#323232', 
                            'border-style'  => 'none', 
                            'bottom'        => '0px', 
                        ),
                        'all'   => false,
                        'left'  =>  false,
                        'right' =>  false,
                        'top'   =>  false
                    ),
                    array(
                        'id'        => 'opt-topbar-widgets-pos',
                        'type'      => 'sorter',
                        'title'     => 'Position of widgets in the Top Bar',
                        'compiler'  => 'true',
                        'options'   => array(
                            'unused'  => array(
                                'phone' => 'Text 1',
                                'email' => 'Text 2',
                                'menu'  => 'Menu Links',
                                'socialmedia' => 'Code Content',
                                'search' => 'Search Wdiget',
                                'cart'   => 'Cart',
                            ),
                            'left'   => array(
                            ),
                            'right'    => array(
                            ),
                        ),
                        'default'  => false
                    ),
                    array(
                        'id'        => 'opt-phone-topbar',
                        'type'      => 'text',
                        'title'     => __('Text Area 1', 'oshin'),
                        'default'   => '',
                    ),
                    array(
                        'id'        => 'opt-email-topbar',
                        'type'      => 'text',
                        'title'     => __('Text Area 2', 'oshin'),
                        'default'   => '',
                    ),
                    array(
                        'id'        => 'opt-smedia-topbar',
                        'type'      => 'ace_editor',
                        'multi'     => true,
                        'title'     => __('Content using Code/Shortcode', 'oshin'),
                    ),
                )
            );
            //Header Bottom Bar Settings
            $this->sections[] = array(
                'title'     => __('Header Bottom Bar', 'oshin'),
                'desc'      => __('This is appicable only if you choose a Header Style with Menu at the Bottom (i.e. style2)', 'oshin'),
                'icon'      => '',
                'subsection' => true,
                'fields'    => array(
                    array(
                        'id'        => 'opt-bottombar-color',
                        'type'      => 'color_rgba',
                        'title'     => __('Bottom Bar Background Color', 'oshin'),
                        'subtitle'  => __('','oshin'),
                        'default'   => array('color' => '#ffffff', 'alpha' => '1'),
                    ),
                    array(
                        'id'        => 'opt-bottombar-border-color',
                        'type'      => 'border',
                        'title'     => __('Bottom Bar Border Color', 'oshin'),
                        'subtitle'  => __('','oshin'),
                        'default'   => array(
                            'border-color'  => '#323232', 
                            'border-style'  => 'none', 
                            'top'    => '0px', 
                            'bottom' => '0px'
                        ),
                        'all' => false,
                        'left' => false,
                        'right' => false
                    ),
                )
            );
            //Left Header Settings
            $this->sections[] = array(
                'title'     => __('Left Header Settings', 'oshin'),
                'desc'      => __('This Panel has all the settings related to the Left Header Style', 'oshin'),
                'icon'      => 'el-icon-hand-left',
                'subsection' => false,
                'fields'    => array(

                    array(
                        'id'        => 'left-header-style',
                        'type'      => 'select',
                        'tiles'     => true,
                        'title'     => __('Left Header Style', 'oshin'),
                        'subtitle'  => __('', 'oshin'),
                        'options'   => array('static' => 'Static Left Menu', 'strip' => 'Strip with Left Menu', 'overlay' => 'Strip with Overlay Menu') ,
                        'default' => 'static',
                    ),     
                    array(
                        'id'        => 'left-strip-animation',
                        'type'      => 'select',
                        'title'     => __('Left Strip Animation', 'oshin'),
                        'subtitle'  => __('', 'oshin'),
                        'options'   => array('menu_push_main' => 'Push Main', 'menu_over_main' => 'Over Main') ,
                        'required' => array('left-header-style','equals','strip'),
                        'default'  => 'menu_push_main'
                    ),        
                    array(
                        'id'        => 'left-static-overlay',
                        'type'      => 'color_rgba',
                        'title'     => __('Overlay Color on Left Menu', 'oshin'), 
                        'subtitle'  => __('Will apply on the menu that has a BG image. This will not be applied on "Strip with Overlay Menu" style', 'oshin'),
                        'desc'      => __('', 'oshin'),
                        'default'   =>  array('color' => '#ffffff', 'alpha' => '0.85'),
                    ),
                    array(
                        'id' => 'left-strip-logo',
                        'type' => 'media',
                        'title' => __('Image that should appear on the Strip', 'oshin'), 
                        'subtitle' => __('This image is required if you choose Sliding Left Menu style', 'oshin'),
                    ),
                    array(
                        'id'        => 'left_overlay_menu_bg_color',
                        'type'      => 'color_rgba',
                        'title'     => __('Left Overlay Menu Background Color', 'oshin'), 
                        'subtitle'  => __('', 'oshin'),
                        'desc'      => __('', 'oshin'),
                        'default'   =>  array('color' => '#080808', 'alpha' => '0.90'),
                    ),   
                    array(
                        'id'        => 'left_side_menu_border',
                        'type'      => 'color',
                        'title'     => __('Left Menu Border Color', 'oshin'), 
                        'subtitle'  => __('', 'oshin'),
                        'desc'      => __('', 'oshin'),
                        'default'   => '#3d3d3d'
                    ), 
                )
            );
            //Footer Settings
            $this->sections[] = array(
                'title'     => __('Footer Settings', 'oshin'),
                'desc'      => __('This Panel has all the settings required for the footer', 'oshin'),
                'icon'      => 'el-icon-hand-down',
                'subsection' => false,
                'fields'    => array(

                    array(
                        'id'        => 'opt-footer-wrap',
                        'type'      => 'switch',
                        'title'     => __('Footer Wrap', 'oshin'),
                        'subtitle'  => __('Turn this off if you want a Full Screen Width Footer', 'oshin'),
                        'default'   => true,
                    ),
                    array(
                        'id'        => 'footer-style',
                        'type'      => 'select',
                        'title'     => __('Footer Style', 'oshin'),
                        'subtitle'  => __('', 'oshin'),
                        'options'   => array('style1' => 'Horizontal', 'style2' => 'Vertical') ,
                        'default' => 'style1',
                    ),       
                    array(
                        'id'        => 'footer-border-color',
                        'type'      => 'border',
                        'title'     => __('Footer border(Top) color', 'oshin'),
                        'subtitle'  => __('','oshin'),
                        'default'   => array(
                            'border-color'  => '', 
                            'border-style'  => 'none', 
                            'top' => '0px'
                        ),
                        'all'    => false,
                        'bottom'    => false,
                        'left'   => false,
                        'right'  => false
                    ),              
                    array(
                        'id'        => 'footer-border-wrap',
                        'type'      => 'switch',
                        'title'     => __('Footer Border Wrap', 'oshin'),
                        'subtitle'  => __('Turn this on if you want a wrapped border', 'oshin'),
                        'default'   => false,
                    ),
                    array(
                        'id'        => 'footer_padding',
                        'type'      => 'text',
                        'title'     => __('Footer Padding Value (in pixels)', 'oshin'),
                        'default'   => '25',
                    ),
                    array(
                        'id'        => 'footer_text1',
                        'type'      => 'ace_editor',
                        'title'     => __('Primary Text on Footer', 'oshin'),
                        'default'   => 'Copyright Brand Exponents 2016. All Rights Reserved',
                    ),     
                    array(
                        'id'        => 'footer_text2',
                        'type'      => 'ace_editor',
                        'title'     => __('Secondary Text on Footer', 'oshin'),
                        'default'   => '',
                    ),  
                    array(
                        'id'        => 'footer_text3',
                        'type'      => 'ace_editor',
                        'title'     => __('Tertiary Text on Footer', 'oshin'),
                        'default'   => '',
                    ),                     
                    array(
                        'id'        => 'footer-content-pos-left',
                        'type'      => 'radio',
                        'title'     => __('Footer - Widget 1','oshin'),
                        'compiler'  => 'true',
                        'options'   => array('none' => 'None', 'text1' => 'Primary content', 'text2' => 'Secondary content', 'text3' => 'Tertiary content', 'menu'  => 'Menu Links'),
                        'default'   => 'none'
                    ),                     
                    array(
                        'id'        => 'footer-content-pos-center',
                        'type'      => 'radio',
                        'title'     => __('Footer - Widget 2','oshin'),
                        'compiler'  => 'true',
                        'options'   => array('none' => 'None', 'text1' => 'Primary content', 'text2' => 'Secondary content', 'text3' => 'Tertiary content', 'menu'  => 'Menu Links'),
                        'default'   =>  'text1'
                    ),                     
                    array(
                        'id'        => 'footer-content-pos-right',
                        'type'      => 'radio',
                        'title'     => __('Footer - Widget 3','oshin'),
                        'compiler'  => 'true',
                        'options'   => array('none' => 'None', 'text1' => 'Primary content', 'text2' => 'Secondary content', 'text3' => 'Tertiary content', 'menu'  => 'Menu Links'),
                        'default'   => 'none'
                    ),
                )
            );
            //Mobile Menu Settings
            $this->sections[] = array(
                'title'     => __('Mobile Menu Settings', 'oshin'),
                'desc'      => __('This Panel has all the settings related to the Mobile Menu', 'oshin'),
                'icon'      => 'el-icon-lines',
                'subsection' => false,
                // 'submenu' => false, // Setting submenu to false on a given section will hide it from the WordPress sidebar menu!
                'fields'    => array(

                    array(
                        'id'        => 'mobile_menu_bg',
                        'type'      => 'color_rgba',
                        'title'     => __('Mobile Menu Background Color', 'oshin'), 
                        'subtitle'  => __('', 'oshin'),
                        'desc'      => __('', 'oshin'),
                        'default'   => array('color' => '#ffffff', 'alpha' => '1'),
                    ),  
                    array(
                        'id'        => 'mobile_menu_border',
                        'type'      => 'color',
                        'title'     => __('Mobile Menu Border Color', 'oshin'), 
                        'subtitle'  => __('', 'oshin'),
                        'desc'      => __('', 'oshin'),
                        'default'   => '#efefef'
                    ),  
                    array (
                            'id' => 'mobile_bg_controller',
                            'type' => 'checkbox',
                            'title' => __('Apply Background Color', 'oshin'),
                            'subtitle' => __('Check this if you want to apply a BG to the Menu Icon', 'oshin'),
                            
                            'default' => 0,
                    ),
                    array(
                        'id'        => 'mobile_bg_controller_start',
                        'type'      => 'section',
                        'title'     => '',
                        'subtitle'  => '',
                        'indent'    => true, // Indent all options below until the next 'section' option is set.
                    ),
                        array(
                            'id'        => 'mobile_menu_icon_bg',
                            'type'      => 'color_rgba',
                            'title'     => __('Mobile Menu Icon Background', 'oshin'), 
                            'subtitle'  => __('', 'oshin'),
                            'desc'      => __('', 'oshin'),
                            'default'   => array('color' => '#ffffff', 'alpha' => '0'),
                            'required' => array('mobile_bg_controller','equals','1')
                        ),
                        array(
                            'id'        => 'mobile_menu_icon_color',
                            'type'      => 'color',
                            'title'     => __('Mobile Menu Icon Color', 'oshin'), 
                            'subtitle'  => __('', 'oshin'),
                            'desc'      => __('', 'oshin'),
                            'default'   => '#323232',
                            'required' => array('mobile_bg_controller','equals','1')
                        ), 
                    array(
                        'id'        => 'mobile_bg_controller_end',
                        'type'      => 'section',
                        'title'     => '',
                        'subtitle'  => '',
                        'indent'    => false, // Indent all options below until the next 'section' option is set.
                    ),
                    array(
                        'id'        => 'mobile_menu_width',
                        'type'      => 'text',
                        'title'     => __('Mobile Menu Icon Width', 'oshin'), 
                        'subtitle'  => __('', 'oshin'),
                        'desc'      => __('', 'oshin'),
                        'default'   => '18',
                    ),  
                    array(
                        'id'        => 'mobile_menu_thickness',
                        'type'      => 'text',
                        'title'     => __('Mobile Menu Icon Thickness', 'oshin'), 
                        'subtitle'  => __('', 'oshin'),
                        'desc'      => __('', 'oshin'),
                        'default'   => '2',
                    ),  
                    array(
                        'id'        => 'mobile_menu_gap',
                        'type'      => 'text',
                        'title'     => __('Mobile Menu Icon Gap', 'oshin'), 
                        'subtitle'  => __('', 'oshin'),
                        'desc'      => __('', 'oshin'),
                        'default'   => '5',
                    ),  
                )
            );
            //Color Settings
            $this->sections[] = array(
                'icon' => 'el-icon-brush',
                'title' => __('Colors', 'oshin'),
                
                'fields' => array (
                    array (
                        'id' => 'color_scheme',
                        'type' => 'color',
                        'title' => __('Color Scheme', 'oshin'), 
                        
                        
                        'default' => '#e0a240'
                    ),   
                    array (
                        'id' => 'alt_bg_text_color',
                        'type' => 'color',
                        'title' => __('Text Color on BG with Color Scheme', 'oshin'), 
                        
                        
                        'default' => '#ffffff'
                    ),
                    array (
                        'id' => 'sec_bg',
                        'type' => 'color',
                        'title' => __('Secondary Background Color', 'oshin'), 
                        
                        
                        'default' => '#fafbfd'
                    ),
                    array (
                        'id' => 'sec_color',
                        'type' => 'color',
                        'title' => __('Secondary Text Color', 'oshin'), 
                        
                        
                        'default' => '#7a7a7a'
                    ),
                    array (
                        'id' => 'sec_border',
                        'type' => 'color',
                        'title' => __('Secondary Border Color', 'oshin'), 
                        
                        
                        'default' => '#eeeeee'
                    ),
                    array (
                        'id' => 'tert_bg',
                        'type' => 'color',
                        'title' => __('Tertiary Background Color', 'oshin'), 
                        'subtitle' => __('This color will be applied to the content area in Fixed Sidebar Portfolio Pages', 'oshin'),
                        
                        'default' => '#ffffff'
                    ),  
                )
            );
            // Blog Settings
            $this->sections[] = array (
                'icon' => 'el-icon-blogger',
                'title' => __('Blog Settings', 'oshin'),
                
                'fields' => array (
                    array (
                        'id' => 'open_to_lightbox',
                        'type' => 'checkbox',
                        'title' => __('Open Thumbnail image in Lighbox', 'oshin'),
                        'subtitle' => __('By default the thumbnail will be linked to the Blog Post page', 'oshin'),
                        
                        'default' => 1
                    ),
                    array (
                        'id' => 'blog_style',
                        'type' => 'select',
                        'title' => __('Blog Style', 'oshin'), 
                        
                        'desc' => __('' , 'oshin'),
                        'options'=> array (
                                    'style5'=>'Large Thumbnail',
                                    'style1'=>'Large Thumbnail - Date in box', 
                                    'style6'=>'Large Thumbnail - Date above Title',
                                    'style4'=>'Large Thumbnail - Content in Box',
                                    'style7'=>'Large Thumbnail - Category above Title',
                                    'style2'=>'Small Thumbnail', 
                                    'style3'=>'Masonry', 
                                ),
                        'default' => 'style6'
                    ),
                    array (
                        'id' => 'blog_page_show_page_title_module',
                        'type' => 'checkbox',
                        'title' => __('Show Page Title Module in Blog Page', 'oshin'),
                        
                        
                        'default' => 1
                    ),
                    array (
                        'id' => 'blog_sidebar',
                        'type' => 'select',
                        'title' => __('Blog Sidebar Position', 'oshin'), 
                        
                        'desc' => __('' , 'oshin'),
                        'options'=> array('left'=>'Left Sidebar', 'right'=>'Right Sidebar', 'no'=>'No Sidebar'),
                        'default' => 'right'
                    ),
                    array (
                        'id' => 'blog_read_more_style',
                        'type' => 'select',
                        'title' => __('Blog Read More Button Style', 'oshin'), 
                        
                        'desc' => __('' , 'oshin'),
                        'options'=> array('style1' => 'Text Underline', 'style2'=>'Border', 'style3'=>'Block'),
                        'default' => 'style1'
                    ),
                    array(
                        'id'        => 'blog-masonry-setting-start',
                        'type'      => 'section',
                        'title'     => 'Blog Masonry Style Settings',
                        'subtitle'  => 'Affects only Masonry Layout',
                        'indent'    => true, // Indent all options below until the next 'section' option is set.
                    ),
                        array (
                            'id' => 'blog_column',
                            'type' => 'select',
                            'title' => __('Blog Column', 'oshin'), 
                            
                            'desc' => __('' , 'oshin'),
                            'options'=> array('two-col'=>'Two Column', 'three-col'=>'Three Column', 'four-col'=>'Four Column'),
                            'default' => 'three-col'
                        ),
                        array (
                            'id' => 'blog_grid_style',
                            'type' => 'select',
                            'title' => __('Blog Grid Style', 'oshin'), 
                            
                            'desc' => __('' , 'oshin'),
                            'options'=> array('wrapped'=>'Wrapped', 'full'=>'Full Width'),
                            'default' => 'wrapped'
                        ),
                        array (
                            'id' => 'blog_gutter_style',
                            'type' => 'select',
                            'title' => __('Blog Gutter Style', 'oshin'), 
                            
                            'desc' => __('' , 'oshin'),
                            'options'=> array('style1'=>'No Margin on edges', 'style2'=>'With Margin on edges'),
                            'default' => 'style1'
                        ),
                        array (
                            'id' => 'blog_pagination_style',
                            'type' => 'select',
                            'title' => __('Blog Pagination Style', 'oshin'), 
                            
                            'desc' => __('' , 'oshin'),
                            'options'=> array('normal'=>'Normal', 'loadmore'=>'Load More', 'infinite' => 'Infinite Scroll'),
                            'default' => 'normal'
                        ),
                        array (
                            'id' => 'blog_gutter_width',
                            'type' => 'text',
                            'title' => __('Blog Gutter Width', 'oshin'), 
                            
                            'desc' => __('' , 'oshin'),
                            'default' => 40
                        ),
                    array(
                        'id'        => 'blog-masonry-setting-end',
                        'type'      => 'section',
                        'indent'    => false, // Indent all options below until the next 'section' option is set.
                    ),
                    array(
                        'id'        => 'single-post-setting-start',
                        'type'      => 'section',
                        'title'     => 'Blog Single Post Settings',
                        'subtitle'  => '',
                        'indent'    => true, // Indent all options below until the next 'section' option is set.
                    ),
                        array (
                            'id' => 'enable_pb_blog_posts',
                            'type' => 'checkbox',
                            'title' => __('Enable BE Page Builder in Single Posts', 'oshin'),
                            
                            
                            'default' => 0,
                        ),
                        array (
                            'id' => 'blog_single_sidebar',
                            'type' => 'checkbox',
                            'title' => __('Enable Sidebar in Single Posts', 'oshin'), 
                            
                            'desc' => __('' , 'oshin'),
                            'default' => '1'
                        ),
                        array (
                            'id' => 'enable_breadcrumb',
                            'type' => 'checkbox',
                            'title' => __('Enable Breadcrumb in Single Posts', 'oshin'), 
                            
                            'desc' => __('' , 'oshin'),
                            'default' => 0
                        ),
                    array(
                        'id'        => 'single-post-setting-end',
                        'type'      => 'section',
                        'indent'    => false, // Indent all options below until the next 'section' option is set.
                    ),
                )                   
            );
            // Portfolio Settings
            $this->sections[] = array (
                'icon' => 'el-icon-film',
                'title' => __('Portfolio Settings', 'oshin'),
                
                'fields' => array (  
                    array (
                        'id' => 'portfolio_aspect_ratio',
                        'type' => 'text',
                        'title' => __('Portfolio Images Aspect Ratio', 'oshin'), 
                        
                        'desc' => __('' , 'oshin'),
                        'default' => '1.6',
                    ),
                    array (
                        'id' => 'portfolio_slug',
                        'type' => 'text',
                        'title' => __('Portfolio Post Slug', 'oshin'), 
                        'subtitle' => __('This option is to modify the slug of the portfolio post items. Default will be /portfolio/', 'oshin'),
                        'desc' => __('' , 'oshin'),
                        'default' => '',
                    ),

                    array (
                        'id' => 'portfolio_home_page',
                        'type' => 'text',
                        'title' => __('Portfolio Home Page', 'oshin'), 
                        'subtitle' => __('The grid icons in the single portfolio page will be linked to this URL.', 'oshin'),
                        'desc' => __('' , 'oshin'),
                        'default' => get_home_url(),
                    ),
                    array (
                        'id'        => 'navigation-settings-start',
                        'type'      => 'section',
                        'title'     => 'Slider Navigation Arrow Settings',
                        'indent'    => true, // Indent all options below until the next 'section' option is set.
                    ),   
                        array (
                            'id' => 'slider_navigation_style',
                            'type' => 'select',
                            'title' => __('Navigation Arrow Style', 'oshin'),
                            
                            
                            'options'=> array(
                                    'style1-arrow'=>'Large Sqaure Block', 
                                    'style2-arrow'=>'Large Sqaure Border',
                                    'style3-arrow'=>'Small Sqaure Block',
                                    'style4-arrow'=>'Small Sqaure Border',
                                    'style5-arrow'=>'Circle Block',
                                    'style6-arrow'=>'Circle Border',
                            ),
                            'default' => 'style1-arrow'
                        ),
                        array(
                            'id'        => 'slider_nav_bg',
                            'type'      => 'color_rgba',
                            'title'     => __('Background/Border Color', 'oshin'), 
                            'subtitle'  => __('The color will be applied as the BG or border of the slider arrow , depending on the style choosen', 'oshin'),
                            'desc'      => __('', 'oshin'),
                            'default'   =>  array('color' => '#000000', 'alpha' => '1'),
                        ), 
                        array(
                            'id'        => 'slider_nav_hover_bg',
                            'type'      => 'color_rgba',
                            'title'     => __('Background/Border Hover Color', 'oshin'), 
                            'subtitle'  => __('', 'oshin'),
                            'desc'      => __('', 'oshin'),
                            'default'   =>  array('color' => '#000000', 'alpha' => '1'),
                        ),  
                        array(
                            'id'        => 'slider_nav_color',
                            'type'      => 'color',
                            'title'     => __('Arrow Color', 'oshin'), 
                            'subtitle'  => __('', 'oshin'),
                            'desc'      => __('', 'oshin'),
                            'default'   =>  '#ffffff'
                        ),
                        array(
                            'id'        => 'slider_nav_hover_color',
                            'type'      => 'color',
                            'title'     => __('Arrow Hover Color', 'oshin'), 
                            'subtitle'  => __('', 'oshin'),
                            'desc'      => __('', 'oshin'),
                            'default'   =>  '#ffffff'
                        ),
                    array(
                        'id'        => 'navigation-settings-end',
                        'type'      => 'section',
                        'indent'    => false, // Indent all options below until the next 'section' option is set.
                    ), 
                    array(
                        'id'        => 'portfolio-nav-top-start',
                        'type'      => 'section',
                        'title'     => 'Portfolio Title and Navigation - Top Bar Settings',
                        'subtitle'  => 'The settings will be applied on the Portfolio Styles with Portfolio Title and Navigation in Top bar',
                        'indent'    => true, // Indent all options below until the next 'section' option is set.
                    ),
                        array (
                            'id' => 'portfolio_title_nav_color',
                            'type' => 'color',
                            'title' => __('Background Color', 'oshin'), 
                            
                            'desc' => __('' , 'oshin'),
                            'default' => '#ededed'
                        ), 
                        array (
                            'id' => 'portfolio_nav_color',
                            'type' => 'color',
                            'title' => __('Navigation Icons color', 'oshin'), 
                            
                            
                            'default' => '#d2d2d2'
                        ),  
                        array (
                            'id' => 'portfolio_nav_hover_color',
                            'type' => 'color',
                            'title' => __('Navigation Icons Hover color', 'oshin'), 
                            
                            
                            'default' => '#000000'
                        ), 
                        array (
                            'id'        => 'portfolio_title_bar_padding',
                            'type'      => 'text',
                            'title'     => __('Padding', 'oshin'),
                            'subtitle'  => __('Enter only Numbers (in pixels)', 'oshin'),
                            'default'   =>  '15'
                        ),
                        array(
                            'id'        => 'portfolio_title_bar_border',
                            'type'      => 'border',
                            'title'     => __('Bottom Border Color', 'oshin'),
                            'subtitle'  => __('','oshin'),
                            'default'   => array(
                                'border-color'  => '#e8e8e8', 
                                'border-style'  => 'solid', 
                                'bottom'    => '1px', 
                            ),
                            'top'       => false,
                            'left'      => false,
                            'right'     => false,
                            'all'       => false
                        ),
                        array (
                            'id' => 'portfolio_title_nav_style',
                            'type' => 'select',
                            'title' => __('Bar Style', 'oshin'), 
                            
                            'desc' => __('' , 'oshin'),
                            'options'=> array('style1' => 'Center Title - Right (Wrap) Navigation', 'style2'=>'Center Title - Right (Edge) Navigation', 'style3'=>'Left Title - Right (Wrap) Navigation'),
                            'default' => 'style1'
                        ),
                    array(
                        'id'        => 'portfolio-nav-top-end',
                        'type'      => 'section',
                        'indent'    => false, // Indent all options below until the next 'section' option is set.
                    ),

                    array(
                        'id'        => 'portfolio-nav-bottom-start',
                        'type'      => 'section',
                        'title'     => 'Portfolio Title and Navigation - Bottom Bar Settings',
                        'subtitle'  => 'The settings will be applied on the Portfolio Styles with Portfolio Title and Navigation in the bottom. This includes all the Slider styles',
                        'indent'    => true, // Indent all options below until the next 'section' option is set.
                    ),
                        array (
                            'id' => 'portfolio_title_nav_bg',
                            'type' => 'color_rgba',
                            'title' => __('Background Color', 'oshin'), 
                            
                            'desc' => __('' , 'oshin'),
                            'default'   =>  array('color' => '#ffffff', 'alpha' => '0'),
                        ),
                        array (
                            'id' => 'portfolio_title_nav_text_color',
                            'type' => 'color',
                            'title' => __('Text Color', 'oshin'), 
                            'desc' => __('' , 'oshin'),
                            'default' => '#2b2b2b'
                        ),
                        array (
                            'id' => 'portfolio_title_nav_hover_bg_color',
                            'type' => 'color_rgba',
                            'title' => __('Hover Background Color', 'oshin'), 
                            'desc' => __('' , 'oshin'),
                            'default'   =>  array('color' => '#eb4949', 'alpha' => '0.85'),
                        ),
                        array (
                            'id' => 'portfolio_title_nav_text_hover_color',
                            'type' => 'color',
                            'title' => __('Text Hover Color', 'oshin'), 
                            'desc' => __('' , 'oshin'),
                            'default' => '#ffffff'
                        ),
                        
                        array (
                            'id' => 'portfolio_caption_bg',
                            'type' => 'color_rgba',
                            'title' => __('Caption Background Color', 'oshin'), 
                            
                            'desc' => __('' , 'oshin'),
                            'default'   =>  array('color' => '#000000', 'alpha' => '1'),
                        ),
                        // array (
                        //     'id' => 'portfolio_caption_typo',
                        //     'type' => 'typography',
                        //     'title' => __('Caption Typography', 'oshin'), 
                        //      
                        //     'fonts' => $be_fonts_arr,
                        //     'ext-font-css' => get_stylesheet_directory_uri() . '/fonts/fonts.css',
                        //     
                        //     'default'   => array(
                        //         'font-family'   => 'Crimson Text',
                        //         'font-style'    => 'Italic',
                        //         'font-weight'   => '400',
                        //         'text-transform' => 'none',
                        //         'font-size' => '15px',
                        //         'letter-spacing' => '0px'
                        //     ),
                        //     'text-align'    => false,
                        // ),
                        array (
                            'id' => 'thumbnail_bar_color',
                            'type' => 'color_rgba',
                            'title' => __('Thumbnail Background Color', 'oshin'), 
                            
                            'desc' => __('' , 'oshin'),
                            'default'   =>  array('color' => '#ffffff', 'alpha' => '0.5'),
                        ),
                    array(
                        'id'        => 'portfolio-nav-bottom-end',
                        'type'      => 'section',
                        'indent'    => false, // Indent all options below until the next 'section' option is set.
                    ),
                    array (
                        'id' => 'portfolio_visit_site_style',
                        'type' => 'select',
                        'title' => __('Portfolio View Project Button Style', 'oshin'), 
                        
                        'desc' => __('' , 'oshin'),
                        'options'=> array('style1' => 'Text Underline', 'style2'=>'Border', 'style3'=>'Block'),
                        'default' => 'style1'
                    ),
                    array(
                        'id'        => 'portfolio-filter-settings-start',
                        'type'      => 'section',
                        'title'     => 'Portfolio Filter Settings',
                        'subtitle'  => '',
                        'indent'    => true, // Indent all options below until the next 'section' option is set.
                    ),
                        array (
                            'id' => 'portfolio_filter_style',
                            'type' => 'image_select',
                            'title' => __('Portfolio Filter Style', 'oshin'), 
                            
                            'desc' => __('' , 'oshin'),
                            'options'  => array(
                                'border'      => array(
                                    'alt'   => 'Border', 
                                    'img'   => get_template_directory_uri().'/img/filters/border.png'
                                ),
                                'rounded'      => array(
                                    'alt'   => 'Rounded', 
                                    'img'   => get_template_directory_uri().'/img/filters/rounded.png'
                                ),
                                'single_border'      => array(
                                    'alt'   => 'One Side Border', 
                                    'img'  => get_template_directory_uri().'/img/filters/single_border.png'
                                )
                            ),
                            'default' => 'border'
                        ),
                        array (
                            'id' => 'portfolio_filter_alignment',
                            'type' => 'select',
                            'title' => __('Portfolio Filter Alignment', 'oshin'), 
                            
                            'desc' => __('' , 'oshin'),
                            'options'=> array('left' => 'Left', 'center'=>'Center'),
                            'default' => 'center'
                         ),
                    array(
                        'id'        => 'portfolio-filter-settings-end',
                        'type'      => 'section',
                        'indent'    => false, // Indent all options below until the next 'section' option is set.
                    ),

                    array(
                        'id'        => 'portfolio-taxonomy-settings-start',
                        'type'      => 'section',
                        'title'     => 'Portfolio Taxonomy Page Settings',
                        'subtitle'  => 'The settings will be applied on the Portfolio Category and Tag Archive Pages',
                        'indent'    => true, // Indent all options below until the next 'section' option is set.
                    ),
                        // array (
                        //     'id' => 'portfolio_style',
                        //     'type' => 'select',
                        //     'title' => __('Page Style', 'oshin'), 
                        //     
                        //     'desc' => __('' , 'oshin'),
                        //     'options'=> array('portfolio_full_screen'=>'Full Screen Portfolio', 'portfolio_full_screen_with_gutter'=>'Full Screen With Gutter', 'portfolio'=>'Normal Portfolio'),
                        //     'default' => 'portfolio'
                        // ),
                        array (
                            'id' => 'hide_breadcrumbs',
                            'type' => 'checkbox',
                            'title' => __('Disable Title and Breadcrumbs Bar in Taxonomy Page', 'oshin'),
                            
                            
                            'default' => 0
                        ),
                        array (
                            'id' => 'portfolio_grid_style',
                            'type' => 'select',
                            'title' => __('Portfolio Grid Style', 'oshin'), 
                            
                            'desc' => __('' , 'oshin'),
                            'options'=> array('wrapped'=>'Wrapped', 'full'=>'Full Width'),
                            'default' => 'wrapped'
                        ),
                        array (
                            'id' => 'portfolio_col',
                            'type' => 'select',
                            'title' => __('Number of Columns', 'oshin'), 
                            
                            'desc' => __('' , 'oshin'),
                            'options'=> array('two'=>'Two Column', 'three'=>'Three Column', 'four'=>'Four Column', 'five'=>'Five Column'),
                            'default' => 'three'
                        ),  
                        array (
                            'id' => 'portfolio_grid_gutter',
                            'type' => 'text',
                            'title' => __('Portfolio Gutter Width', 'oshin'), 
                            
                            'desc' => __('' , 'oshin'),
                            'default' => '30'
                        ),                  
                        array (
                            'id' => 'portfolio_hover',
                            'type' => 'color_rgba',
                            'title' => __('Grid hover Color', 'oshin'), 
                            
                            
                            'default' => array('color' => '#e0a240', 'alpha' => '0.85') ,    
                        ),
                    array(
                        'id'        => 'portfolio-taxonomy-settings-end',
                        'type'      => 'section',
                        'indent'    => false, // Indent all options below until the next 'section' option is set.
                    ),

                )                   
            );
            // Shop Settings
            $this ->sections[] = array (
                'icon' => 'el-icon-shopping-cart',
                'title' => __('Shop', 'oshin'),
                
                'fields' => array (
                    array (
                        'id' => 'shop_products_column',
                        'type' => 'select',
                        'title' => __('Shop Page Column', 'oshin'), 
                        
                        'desc' => __('' , 'oshin'),
                        'options'=> array('four'=>'Four', 'three'=>'Three'),
                        'default' => 'three'
                    ),
                    array (
                        'id' => 'show_sidebar_on_shop_page',
                        'type' => 'checkbox',
                        'title' => __('Enable Sidebar in Shop Page', 'oshin'),
                        
                        
                        'default' => 0
                    ),
                    array (
                        'id' => 'number_of_products_per_page',
                        'type' => 'text',
                        'title' => __('Number of products per page', 'oshin'),
                        
                        
                        'default' => 9
                    ),
                    // array (
                    //     'id' => 'shop_page_title',
                    //     'type' => 'typography',
                    //     'title' => __('Product Thumbnail Title', 'oshin'), 
                    //      
                    //     'fonts' => $be_fonts_arr,
                    //     'ext-font-css' => get_stylesheet_directory_uri() . '/fonts/fonts.css',
                    //     
                    //     'default'   => array(
                    //         'color'         => '#222222',
                    //         'font-size'     => '13px',
                    //         'line-height'   => '27px',
                    //         'font-family'   => 'Montserrat',
                    //         'font-style'    => '',
                    //         'font-weight'   => '400',
                    //         'text-transform' => 'uppercase',
                    //         'letter-spacing' => '1px'
                    //     ),
                    // ),
                    // array (
                    //     'id' => 'shop_single_page_title',
                    //     'type' => 'typography',
                    //     'title' => __('Product Single page Title', 'oshin'), 
                    //      
                    //     'fonts' => $be_fonts_arr,
                    //     'ext-font-css' => get_stylesheet_directory_uri() . '/fonts/fonts.css',
                    //     
                    //     'default'   => array(
                    //         'color'         => '#222222',
                    //         'font-size'     => '25px',
                    //         'line-height'   => '27px',
                    //         'font-family'   => 'Montserrat',
                    //         'font-style'    => '',
                    //         'font-weight'   => '400',
                    //         'text-transform' => 'none',
                    //         'letter-spacing' => '0px'
                    //     ),
                    // ),
                    array (
                        'id' => 'sigle_page_woo_tabs_position',
                        'type' => 'select',
                        'title' => __('Single Page Tabs Position', 'oshin'), 
                        
                        'desc' => __('' , 'oshin'),
                        'options'=> array('right_side'=>'Beside Product Image', 'full_width'=>'Below Product Image'),
                        'default' => 'right_side'
                    ),
                    array(
                        'id'        => 'shop_page_button_section_start',
                        'type'      => 'section',
                        'title'     => __('Shop Page Primary Button Styling', 'oshin'), 
                        'indent'    => true
                    ),
                        array (
                            'id' => 'shop_page_button_bg_color',
                            'type' => 'color',
                            'title' => __('Background', 'oshin'), 
                            
                            'desc' => __('' , 'oshin'),
                            'default' => 'transparent',
                        ),
                        array (
                            'id' => 'shop_page_button_color',
                            'type' => 'color',
                            'title' => __('Text', 'oshin'), 
                            
                            'desc' => __('' , 'oshin'),
                            'default' => '#000000'
                        ),
                        array (
                            'id' => 'shop_page_button_border_color',
                            'type' => 'color',
                            'title' => __('Border', 'oshin'), 
                            
                            'desc' => __('' , 'oshin'),
                            'default' => '#000000'
                        ),
                        array (
                            'id' => 'shop_page_button_hover_bg_color',
                            'type' => 'color',
                            'title' => __('Hover Background', 'oshin'), 
                            
                            'desc' => __('' , 'oshin'),
                            'default' => '#e0a240'
                        ),
                        array (
                            'id' => 'shop_page_button_hover_color',
                            'type' => 'color',
                            'title' => __('Hover Text', 'oshin'), 
                            
                            'desc' => __('' , 'oshin'),
                            'default' => '#ffffff'
                        ),
                        array (
                            'id' => 'shop_page_button_border_hover_color',
                            'type' => 'color',
                            'title' => __('Hover Border', 'oshin'), 
                            
                            'desc' => __('' , 'oshin'),
                            'default' => '#e0a240'
                        ),
                        array (
                            'id' => 'shop_page_button_border_width',
                            'type' => 'text',
                            'title' => __('Border Width', 'oshin'), 
                            
                            'desc' => __('' , 'oshin'),
                            'default' => '2'
                        ),
                    array(
                        'id'        => 'shop_page_button_section_end',
                        'type'      => 'section',
                        'indent'    => false
                    ),
                    array(
                        'id'        => 'shop_page_alt_button_section_start',
                        'type'      => 'section',
                        'title'     => __('Shop Page Secondary Button Styling', 'oshin'), 
                        'indent'    => true
                    ),
                        array (
                            'id' => 'shop_page_alt_button_bg_color',
                            'type' => 'color',
                            'title' => __('Background', 'oshin'), 
                            
                            'desc' => __('' , 'oshin'),
                            'default' => '#e0a240',
                        ),
                        array (
                            'id' => 'shop_page_alt_button_color',
                            'type' => 'color',
                            'title' => __('Text', 'oshin'), 
                            
                            'desc' => __('' , 'oshin'),
                            'default' => '#fff'
                        ),
                        array (
                            'id' => 'shop_page_alt_button_border_color',
                            'type' => 'color',
                            'title' => __('Border', 'oshin'), 
                            
                            'desc' => __('' , 'oshin'),
                            'default' => '#e0a240'
                        ),
                        array (
                            'id' => 'shop_page_alt_button_hover_bg_color',
                            'type' => 'color',
                            'title' => __('Hover Background', 'oshin'), 
                            
                            'desc' => __('' , 'oshin'),
                            'default' => 'transparent'
                        ),
                        array (
                            'id' => 'shop_page_alt_button_hover_color',
                            'type' => 'color',
                            'title' => __('Hover Text', 'oshin'), 
                            
                            'desc' => __('' , 'oshin'),
                            'default' => '#000'
                        ),
                        array (
                            'id' => 'shop_page_alt_button_border_hover_color',
                            'type' => 'color',
                            'title' => __('Hover Border', 'oshin'), 
                            
                            'desc' => __('' , 'oshin'),
                            'default' => '#000'
                        ),
                        array (
                            'id' => 'shop_page_alt_button_border_width',
                            'type' => 'text',
                            'title' => __('Border Width', 'oshin'), 
                            
                            'desc' => __('' , 'oshin'),
                            'default' => '2'
                        ),
                    array(
                        'id'        => 'shop_page_alt_button_section_end',
                        'type'      => 'section',
                        'indent'    => false
                    )
                )
            );
            //Contact Settings
            $this->sections[] = array(
                'icon' => 'el-icon-envelope',
                'title' => __('Contact Settings', 'oshin'),
                'desc' => __('Contact information that will be used in the Contact form', 'oshin'),
                'fields' => array (
                    array (
                        'id' => 'mail_id',
                        'type' => 'text',
                        'title' => __('Email Address', 'oshin'),
                        
                        'subtitle' => __('Enter your email address.', 'oshin'),
                        // 'validate' => 'email',
                        'default' => ''
                    ),
                    // array (
                    //     'id' => 'contact_form_typo',
                    //     'type' => 'typography',
                    //     'title' => __('Contact Form Typography', 'oshin'), 
                    //     
                    //     'fonts' => $be_fonts_arr,
                    //     'ext-font-css' => get_stylesheet_directory_uri() . '/fonts/fonts.css',
                    //     
                    //     'default'   => array (
                    //         'color'         => '#222222',
                    //         'font-size'     => '13px',
                    //         'line-height'   => '26px',
                    //         'font-family'   => 'Montserrat',
                    //         'font-style'    => '',
                    //         'font-weight'   => '400',
                    //         'text-transform' => 'none',
                    //         'letter-spacing' => '0px'
                    //     ),
                    // ),
                )
            );
            // Single Blog - Hero Section
            $this->sections[] = array (
                'icon' => 'el-icon-magic',
                'title' => __('Single Blog Hero Section', 'oshin'),
                'desc' => __('Single Blog Hero Section Setting</p>', 'oshin'),
                'fields' => array (
                    array (
                        'id' => 'single_blog_hero_section_from',
                        'type' => 'radio',
                        'title' => __('Source of Hero Section in Single posts page', 'oshin'), 
                        
                        'desc' => __('' , 'oshin'),
                        'options'=> array('inherit_option_panel'=>'Options Panel (Here)', 'single_page'=>'Single Posts Page', 'none' => 'None'),
                        'default' => 'inherit_option_panel'
                    ),
                    array (
                        'id' => 'single_blog_hero_section',
                        'type' => 'radio',
                        'title' => __('Hero Section Type', 'oshin'), 
                        
                        'desc' => __('' , 'oshin'),
                        'options'=> array('slider'=>'Slider', 'custom'=>'Image/Video', 'none' => 'None'),
                        'default' => 'none'
                    ),
                    array (
                        'id' => 'single_blog_hero_section_slider_shortcode',
                        'type' => 'textarea',
                        'title' => __('Add Slider Shortcode', 'oshin'), 
                        
                        'desc' => __('' , 'oshin'),
                        'validate' => 'html',
                        'default' => ''
                    ),
                    array (
                        'id' => 'single_blog_header_transparent',
                        'type' => 'radio',
                        'title' => __('Enable Transparent Header', 'oshin'),
                        
                        
                        'options' => array('none' => 'Default', 'transparent'=>'Transparent', 'semitransparent'=>'Semi-Transparent'),
                        'default' => 'none'
                    ),
                    array (
                        'id' => 'single_blog_header_sticky',
                        'type' => 'select',
                        'title' => __('Sticky Header', 'oshin'), 
                        
                        'desc' => __('' , 'oshin'),
                        'options'=> array('inherit' => 'Inherit From Options panel (Under Layout)', 'yes' => 'Yes', 'no' => 'No'),
                        'default' => 'inherit'
                    ),
                    array (
                        'id' => 'single_blog_header_transparent_color_scheme',
                        'type' => 'radio',
                        'title' => __('Transparent Header Navigation Color Scheme', 'oshin'), 
                        'subtitle' => __('Applicable only for Transparent header', 'oshin'),
                        'desc' => __('' , 'oshin'),
                        'options'=>  array('none' => 'Default', 'dark' => 'Dark', 'light' => 'Light'),
                        'default' => 'dark'
                    ),
                    array (
                        'id' => 'single_blog_hero_section_position',
                        'type' => 'radio',
                        'title' => __('Hero Section Position', 'oshin'), 
                        'subtitle' => __('Applicable only for non-transparent header', 'oshin'),
                        'desc' => __('' , 'oshin'),
                        'options'=> array('before' => 'Before Header', 'after' => 'After Header'),
                        'default' => 'after'
                    ),
                    array (
                        'id' => 'single_blog_hero_section_custom_height',
                        'type' => 'text',
                        'title' => __('Hero Section Custom Height', 'oshin'), 
                        
                        'desc' => __('' , 'oshin'),
                        'default' => ''
                    ),
                    array (
                        'id' => 'single_blog_hero_section_with_header',
                        'type' => 'radio',
                        'title' => __('Hero Section With Header', 'oshin'), 
                        'subtitle' => __('Applicable only if header is non-transparent, Hero Section position is Before Header and no Custom Height is defined', 'oshin'),
                        'desc' => __('' , 'oshin'),
                        'options'=> array('yes' => 'Yes', 'no' => 'No'),
                        'default' => 'no'
                    ),
                    array (
                        'id' => 'single_blog_hero_section_bg_color',
                        'type' => 'color',
                        'title' => __('Hero Section Background Color', 'oshin'), 
                        
                        'desc' => __('' , 'oshin'),
                        'default' => ''
                    ),
                    array (
                        'id' => 'single_blog_hero_section_bg_image',
                        'type' => 'background',
                        'title' => __('Hero Section Background Image', 'oshin'), 
                        
                        'desc' => __('' , 'oshin'),
                        'background-color' => false
                    ),
                    array (
                        'id' => 'single_blog_hero_video_options',
                        'type' => 'section',
                        'title' => __('Video Settings','oshin'),
                        'indent' => true,
                    ),
                        array (
                            'id' => 'single_blog_hero_section_bg_video',
                            'type' => 'checkbox',
                            'title' => __('Enable Background Video', 'oshin'),
                            
                            
                            'default' => 0
                        ),
                        array (
                            'id' => 'single_blog_hero_section_bg_video_format',
                            'type' => 'radio',
                            'title' => __('Background Video format', 'oshin'),
                            
                            
                            'options' => array('mp4'=>'MP4', 'ogg'=>'OGG' , 'webm'=>'WebM'),
                            'default' => 'mp4'
                        ),
                        array (
                            'id' => 'single_blog_hero_section_bg_video_url',
                            'type' => 'text',
                            'title' => __('Video .MP4 Video File', 'oshin'),
                            'subtitle' => __('Self host the video and enter the URL of the media file', 'oshin'),
                            
                            'validate' => 'url',
                            'default' => ''
                        ),
                        array (
                            'id' => 'single_blog_hero_section_video_mute',
                            'type' => 'checkbox',
                            'title' => __('Unmute Video', 'oshin'),
                            'subtitle' => __('By default, the video in the BG will be muted', 'oshin'),
                            
                            'default' => 0
                        ),
                    array (
                        'id' => 'single_blog_hero_video_options_end',
                        'type' => 'section',
                        'indent' => false,
                    ),
                    array (
                        'id' => 'single_blog_hero_section_bg_animation',
                        'type' => 'select',
                        'title' => __('Background Animation', 'oshin'), 
                        
                        'desc' => __('' , 'oshin'),
                        'options'=> array(
                            'none' => 'None', 
                            'be-bg-parallax' => 'Parallax',
                            //'be-bg-mousemove-parallax' => 'Mouse Move', 
                            'background-horizontal-animation' => 
                            'Horizontal Loop Animation', 
                            'background-vertical-animation' => 
                            'Vertical Loop Animation'
                        ),
                        'default' => 'none'
                    ),
                    array (
                        'id' => 'single_blog_hero_section_overlay',
                        'type' => 'checkbox',
                        'title' => __('Hero Section Enable Background Overlay', 'oshin'),
                        
                        
                        'default' => 0
                    ),
                    array (
                        'id' => 'single_blog_hero_section_bg_overlay',
                        'type' => 'color_rgba',
                        'title' => __('Background Overlay Color', 'oshin'),
                        
                        
                        'default' => array('color' => '#e0a240', 'alpha' => '0.85')
                    ),
                    array (
                        'id' => 'single_blog_hero_section_container_wrap',
                        'type' => 'radio',
                        'title' => __('Wrap Content', 'oshin'), 
                        
                        'desc' => __('' , 'oshin'),
                        'options'=> array('yes' => 'Yes', 'no' => 'No'),
                        'default' => 'yes'
                    ),
                    array (
                        'id' => 'single_blog_hero_section_content',
                        'type' => 'editor',
                        'title' => __('Hero Section content', 'oshin'),
                        
                        
                        'default' => ''
                    ),
                )                   
            );
            // Single Shop - Hero Section
            $this->sections[] = array (
                'icon' => 'el-icon-magic',
                'title' => __('Single Shop Hero Section', 'oshin'),
                'desc' => __('Single Shop Hero Section Setting</p>', 'oshin'),
                'fields' => array (
                    array (
                        'id' => 'single_shop_hero_section_from',
                        'type' => 'radio',
                        'title' => __('Source of Hero Section in Single Products page', 'oshin'), 
                        
                        'desc' => __('' , 'oshin'),
                        'options'=> array('inherit_option_panel'=>'Options Panel (Here)', 'single_page'=>'Single Posts Page', 'none' => 'None'),
                        'default' => 'inherit_option_panel'
                    ),
                    array (
                        'id' => 'single_shop_hero_section',
                        'type' => 'radio',
                        'title' => __('Hero Section Type', 'oshin'), 
                        
                        'desc' => __('' , 'oshin'),
                        'options'=> array('slider'=>'Slider', 'custom'=>'Image/Video', 'none' => 'None'),
                        'default' => 'none'
                    ),
                    array (
                        'id' => 'single_shop_hero_section_slider_shortcode',
                        'type' => 'textarea',
                        'title' => __('Add Slider Shortcode', 'oshin'), 
                        
                        'desc' => __('' , 'oshin'),
                        'validate' => 'html',
                        'default' => ''
                    ),
                    array (
                        'id' => 'single_shop_header_transparent',
                        'type' => 'radio',
                        'title' => __('Header Style', 'oshin'),
                        
                        
                        'options' => array('none' => 'Default', 'transparent'=>'Transparent', 'semitransparent'=>'Semi-Transparent'),
                        'default' => 'none'
                    ),
                    array (
                        'id' => 'single_shop_header_sticky',
                        'type' => 'select',
                        'title' => __('Sticky Header', 'oshin'), 
                        
                        'desc' => __('' , 'oshin'),
                        'options'=> array('inherit' => 'Inherit From Options panel (Under Layout)', 'yes' => 'Yes', 'no' => 'No'),
                        'default' => 'inherit'
                    ),
                    array (
                        'id' => 'single_shop_header_transparent_color_scheme',
                        'type' => 'radio',
                        'title' => __('Transparent Header Navigation Color Scheme', 'oshin'), 
                        'subtitle' => __('Applicable only for Transparent header', 'oshin'),
                        'desc' => __('' , 'oshin'),
                        'options'=>  array('none' => 'Default', 'dark' => 'Dark', 'light' => 'Light'),
                        'default' => 'dark'
                    ),
                    array (
                        'id' => 'single_shop_hero_section_position',
                        'type' => 'radio',
                        'title' => __('Hero Section Position', 'oshin'), 
                        'subtitle' => __('Applicable only for non-transparent header', 'oshin'),
                        'desc' => __('' , 'oshin'),
                        'options'=> array('before' => 'Before Header', 'after' => 'After Header'),
                        'default' => 'after'
                    ),
                    array (
                        'id' => 'single_shop_hero_section_custom_height',
                        'type' => 'text',
                        'title' => __('Hero Section Custom Height', 'oshin'), 
                        
                        'desc' => __('' , 'oshin'),
                        'default' => ''
                    ),
                    array (
                        'id' => 'single_shop_hero_section_with_header',
                        'type' => 'radio',
                        'title' => __('Hero Section With Header', 'oshin'), 
                        'subtitle' => __('Applicable only if header is non-transparent, Hero Section position is Before Header and no Custom Height is defined', 'oshin'),
                        'desc' => __('' , 'oshin'),
                        'options'=> array('yes' => 'Yes', 'no' => 'No'),
                        'default' => 'no'
                    ),
                    array (
                        'id' => 'single_shop_hero_section_bg_color',
                        'type' => 'color',
                        'title' => __('Hero Section Background Color', 'oshin'), 
                        
                        'desc' => __('' , 'oshin'),
                        'default' => ''
                    ),
                    array (
                        'id' => 'single_shop_hero_section_bg_image',
                        'type' => 'background',
                        'title' => __('Hero Section Background Image', 'oshin'), 
                        
                        'desc' => __('' , 'oshin'),
                        'background-color' => false,
                    ),
                    array (
                        'id' => 'single_shop_hero_video_options',
                        'type' => 'section',
                        'title' => __('Video Settings','oshin'),
                        'indent' => true,
                    ),
                        array (
                            'id' => 'single_shop_hero_section_bg_video',
                            'type' => 'checkbox',
                            'title' => __('Enable Background Video', 'oshin'),
                            
                            
                            'default' => 0
                        ),
                        array (
                            'id' => 'single_shop_hero_section_bg_video_format',
                            'type' => 'radio',
                            'title' => __('Background Video format', 'oshin'),
                            
                            
                            'options' => array('mp4'=>'MP4', 'ogg'=>'OGG' , 'webm'=>'WebM'),
                            'default' => 'mp4'
                        ),
                        array (
                            'id' => 'single_shop_hero_section_bg_video_url',
                            'type' => 'text',
                            'title' => __('Video .MP4 Video File', 'oshin'),
                            'subtitle' => __('Self host the video and enter the URL of the media file', 'oshin'),
                            
                            'validate' => 'url',
                            'default' => ''
                        ),
                        array (
                            'id' => 'single_shop_hero_section_video_mute',
                            'type' => 'checkbox',
                            'title' => __('Unmute Video', 'oshin'),
                            'subtitle' => __('By default, the video in the BG will be muted', 'oshin'),
                            
                            'default' => 0
                        ),
                    array (
                        'id' => 'single_shop_hero_video_options_end',
                        'type' => 'section',
                        'indent' => false,
                    ),
                    array (
                        'id' => 'single_shop_hero_section_bg_parallax',
                        'type' => 'checkbox',
                        'title' => __('Enable Parallax', 'oshin'),
                        
                        
                        'default' => 0
                    ),
                    array (
                        'id' => 'single_shop_hero_section_bg_mouse_move_parallax',
                        'type' => 'checkbox',
                        'title' => __('Enable Mouse Move Parallax', 'oshin'),
                        
                        
                        'default' => 0
                    ),
                    array (
                        'id' => 'single_shop_hero_section_overlay',
                        'type' => 'checkbox',
                        'title' => __('Hero Section Enable Background Overlay', 'oshin'),
                        
                        
                        'default' => 0
                    ),
                    array (
                        'id' => 'single_shop_hero_section_bg_overlay',
                        'type' => 'color_rgba',
                        'title' => __('Background Overlay Color', 'oshin'),
                        
                        
                        'default' => array('color' => '#e0a240', 'alpha' => '0.85')
                    ),
                    array (
                        'id' => 'single_shop_hero_section_container_wrap',
                        'type' => 'radio',
                        'title' => __('Wrap Content', 'oshin'), 
                        
                        'desc' => __('' , 'oshin'),
                        'options'=> array('yes' => 'Yes', 'no' => 'No'),
                        'default' => 'yes'
                    ),
                    array (
                        'id' => 'single_shop_hero_section_content',
                        'type' => 'editor',
                        'title' => __('Hero Section content', 'oshin'),
                        
                        
                        'default' => ''
                    ),
                )                   
            );     
            $this->sections[] = array(
                'type' => 'divide',
            );       
            // Import Export
            $this->sections[] = array(
                'title'     => __('Import / Export', 'oshin'),
                'desc'      => __('Import and Export your Redux Framework settings from file, text or URL.', 'oshin'),
                'icon'      => 'el-icon-refresh',
                'fields'    => array(
                    array(
                        'id'            => 'opt-import-export',
                        'type'          => 'import_export',
                        'title'         => 'Import Export',
                        'subtitle'      => 'Save and restore your Redux options',
                        'full_width'    => false,
                    ),
                ),
            );
            $this->sections[] = array(
                'icon'      => 'el-icon-info-sign',
                'title'     => __('Theme Information', 'oshin'),
                'desc'      => __('<p class="description">This is the Description. Again HTML is allowed</p>', 'oshin'),
                'fields'    => array(
                    array(
                        'id'        => 'opt-raw-info',
                        'type'      => 'raw',
                        'content'   => $item_info,
                    )
                ),
            );
        }

        public function setHelpTabs() {

            // Custom page help tabs, displayed using the help API. Tabs are shown in order of definition.
            $this->args['help_tabs'][] = array(
                'id'        => 'redux-help-tab-1',
                'title'     => __('Theme Information 1', 'oshin'),
                'content'   => __('<p>This is the tab content, HTML is allowed.</p>', 'oshin')
            );

            $this->args['help_tabs'][] = array(
                'id'        => 'redux-help-tab-2',
                'title'     => __('Theme Information 2', 'oshin'),
                'content'   => __('<p>This is the tab content, HTML is allowed.</p>', 'oshin')
            );

            // Set the help sidebar
            $this->args['help_sidebar'] = __('<p>This is the sidebar content, HTML is allowed.</p>', 'oshin');
        }

        /**

          All the possible arguments for Redux.
          For full documentation on arguments, please refer to: https://github.com/ReduxFramework/ReduxFramework/wiki/Arguments

         * */
        public function setArguments() {

            $theme = wp_get_theme(); // For use with some settings. Not necessary.

            $this->args = array(
                // TYPICAL -> Change these values as you need/desire
                'opt_name'          => 'be_themes_data',            // This is where your data is stored in the database and also becomes your global variable name.
                'disable_tracking'  => true,
                'display_name'      => $theme->get('Name'),     // Name that appears at the top of your panel
                'display_version'   => $theme->get('Version'),  // Version that appears at the top of your panel
                'menu_type'         => 'menu',                  //Specify if the admin menu should appear or not. Options: menu or submenu (Under appearance only)
                'allow_sub_menu'    => true,                    // Show the sections below the admin menu item or not
                'menu_title'        => __('Oshine Options', 'oshin'),
                'page_title'        => __('Oshine Options', 'oshin'),
                
                // You will need to generate a Google API key to use this feature.
                // Please visit: https://developers.google.com/fonts/docs/developer_api#Auth
                'google_api_key' => 'AIzaSyCzccjpnf0TJHkjR3K5IMsF3rALDKMDzuk', // Must be defined to add google fonts to the typography module
                'google_update_weekly' => 'true',
                'async_typography'  => false,                    // Use a asynchronous font on the front end or font string
                'admin_bar'         => true,                    // Show the panel pages on the admin bar
                'global_variable'   => '',                      // Set a different name for your global variable other than the opt_name
                'dev_mode'          => false,                    // Show the time the page took to load, etc
                'customizer'        => true,                    // Enable basic customizer support
                //'open_expanded'     => true,                    // Allow you to start the panel in an expanded way initially.
                //'disable_save_warn' => true,                    // Disable the save warning when a user changes a field

                // OPTIONAL -> Give you extra features
                'page_priority'     => null,                    // Order where the menu appears in the admin area. If there is any conflict, something will not show. Warning.
                'page_parent'       => 'themes.php',            // For a full list of options, visit: http://codex.wordpress.org/Function_Reference/add_submenu_page#Parameters
                'page_permissions'  => 'manage_options',        // Permissions needed to access the options panel.
                'menu_icon'         => '',                      // Specify a custom URL to an icon
                'last_tab'          => '',                      // Force your panel to always open to a specific tab (by id)
                'page_icon'         => 'icon-themes',           // Icon displayed in the admin panel next to your menu_title
                'page_slug'         => '_options',              // Page slug used to denote the panel
                'save_defaults'     => true,                    // On load save the defaults to DB before user clicks save or not
                'default_show'      => false,                   // If true, shows the default value next to each field that is not the default value.
                'default_mark'      => '',                      // What to print by the field's title if the value shown is default. Suggested: *
                'show_import_export' => true,                   // Shows the Import/Export panel when not used as a field.
                
                // CAREFUL -> These options are for advanced use only
                'transient_time'    => 60 * MINUTE_IN_SECONDS,
                'output'            => true,                    // Global shut-off for dynamic CSS output by the framework. Will also disable google fonts output
                'output_tag'        => true,                    // Allows dynamic CSS to be generated for customizer and google fonts, but stops the dynamic CSS from going to the head
                // 'footer_credit'     => '',                   // Disable the footer credit of Redux. Please leave if you can help it.
                
                // FUTURE -> Not in use yet, but reserved or partially implemented. Use at your own risk.
                'database'              => '', // possible: options, theme_mods, theme_mods_expanded, transient. Not fully functional, warning!
                'system_info'           => false, // REMOVE

                // HINTS
                'hints' => array(
                    'icon'          => 'icon-question-sign',
                    'icon_position' => 'right',
                    'icon_color'    => 'lightgray',
                    'icon_size'     => 'normal',
                    'tip_style'     => array(
                        'color'         => 'light',
                        'shadow'        => true,
                        'rounded'       => false,
                        'style'         => '',
                    ),
                    'tip_position'  => array(
                        'my' => 'top left',
                        'at' => 'bottom right',
                    ),
                    'tip_effect'    => array(
                        'show'          => array(
                            'effect'        => 'slide',
                            'duration'      => '500',
                            'event'         => 'mouseover',
                        ),
                        'hide'      => array(
                            'effect'    => 'slide',
                            'duration'  => '500',
                            'event'     => 'click mouseleave',
                        ),
                    ),
                )
            );


            // SOCIAL ICONS -> Setup custom links in the footer for quick links in your panel footer icons.
            // $this->args['share_icons'][] = array(
            //     'url'   => 'https://github.com/ReduxFramework/ReduxFramework',
            //     'title' => 'Visit us on GitHub',
            //     'icon'  => 'el-icon-github'
            //     //'img'   => '', // You can use icon OR img. IMG needs to be a full URL.
            // );
            // $this->args['share_icons'][] = array(
            //     'url'   => 'https://www.facebook.com/pages/Redux-Framework/243141545850368',
            //     'title' => 'Like us on Facebook',
            //     'icon'  => 'el-icon-facebook'
            // );
            // $this->args['share_icons'][] = array(
            //     'url'   => 'http://twitter.com/reduxframework',
            //     'title' => 'Follow us on Twitter',
            //     'icon'  => 'el-icon-twitter'
            // );
            // $this->args['share_icons'][] = array(
            //     'url'   => 'http://www.linkedin.com/company/redux-framework',
            //     'title' => 'Find us on LinkedIn',
            //     'icon'  => 'el-icon-linkedin'
            // );

            // Panel Intro text -> before the form
            if (!isset($this->args['global_variable']) || $this->args['global_variable'] !== false) {
                if (!empty($this->args['global_variable'])) {
                    $v = $this->args['global_variable'];
                } else {
                    $v = str_replace('-', '_', $this->args['opt_name']);
                }
                $this->args['intro_text'] = sprintf(__('<p>Did you know that Redux sets a global variable for you? To access any of your saved options from within your code you can use your global variable: <strong>$%1$s</strong></p>', 'oshin'), $v);
            } else {
                $this->args['intro_text'] = __('<p>This text is displayed above the options panel. It isn\'t required, but more info is always better! The intro_text field accepts all HTML.</p>', 'oshin');
            }

            // Add content after the form.
            $this->args['footer_text'] = __('<p>This text is displayed below the options panel. It isn\'t required, but more info is always better! The footer_text field accepts all HTML.</p>', 'oshin');
        }

    }
    
    global $reduxConfig;
    $reduxConfig = new Redux_Framework_sample_config();
}

/**
  Custom function for the callback referenced above
 */
if (!function_exists('redux_my_custom_field')):
    function redux_my_custom_field($field, $value) {
        print_r($field);
        echo '<br/>';
        print_r($value);
    }
endif;

/**
  Custom function for the callback validation referenced above
 * */
if (!function_exists('redux_validate_callback_function')):
    function redux_validate_callback_function($field, $value, $existing_value) {
        $error = false;
        $value = 'just testing';

        /*
          do your validation

          if(something) {
            $value = $value;
          } elseif(something else) {
            $error = true;
            $value = $existing_value;
            $field['msg'] = 'your custom error message';
          }
         */

        $return['value'] = $value;
        if ($error == true) {
            $return['error'] = $field;
        }
        return $return;
    }
endif;