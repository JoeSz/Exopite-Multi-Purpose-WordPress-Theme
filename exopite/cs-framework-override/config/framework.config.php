<?php
/**
 * CodeStar Framework Settings file
 *
 * If you do not want to touch framework files, you can use override method.
 * Create a folder /cs-framework-override/ on your theme directory and copy any orginal config file here.
 * Also you can use this method for child theme. create same folder on child theme and modify your copies.
 *
 * @link http://codestarframework.com/documentation/#configuration
 */

if ( ! defined( 'ABSPATH' ) ) die; // Cannot access pages directly.

require_once( 'cs-functions.php' );

// ===============================================================================================
// -----------------------------------------------------------------------------------------------
// FRAMEWORK SETTINGS
// -----------------------------------------------------------------------------------------------
// ===============================================================================================
$exopite_settings           = array(
  'menu_title'      => 'Theme Options',
  'menu_type'       => 'theme', // menu, submenu, options, theme, etc.
  'menu_slug'       => 'cs-framework',
  'menu_capability' => 'manage_options',
  'ajax_save'       => true,
  'show_reset_all'  => true,
  'framework_title' => 'Exopite One - Options <small style="color: #999;">by <a target="_blank" href="//www.joeszalai.org">www.joeszalai.org</a> - Version ' . EXOPITE_VERSION . '</small>',
);

// ===============================================================================================
// -----------------------------------------------------------------------------------------------
// FRAMEWORK OPTIONS
// -----------------------------------------------------------------------------------------------
// ===============================================================================================
$exopite_options    = array();

// ----------------------------------------
// general                                -
// ----------------------------------------
$exopite_options[]      = array(
  'name'        => 'general_section',
  'title'       => esc_attr__( 'General', 'exopite' ),
  'icon'        => 'fa fa-star',

  // begin: fields
  'fields'      => array(

    array(
      'type'    => 'notice',
      'class'   => 'danger',
      'content' => 'NO WARRANTY OF ANY KIND! USE THIS SOFTWARES AND INFORMATIONS AT YOUR OWN RISK! <a href="//www.joeszalai.org/disclaimer/" target="_blank">READ DISCLAMER</a>, <a href="//www.gnu.org/licenses/gpl-3.0.html" target="_blank">License: GNU General Public License v3</a>',
    ),


///http://localhost/wp/wp-admin/customize.php?autofocus[section]=title_tagline

    array(
      'id'           => 'exopite-content-layout',
      'type'         => 'image_select',
      'title'        => esc_attr__( 'Content layout', 'exopite' ),
      'options'      => array(
        'wide'        => CS_URI . '/assets/images/full.jpg',
        'boxed'       => CS_URI . '/assets/images/boxed-2.jpg',
      ),
      'radio'        => true,
      'default'      => 'wide',
    ),

    /*
     * Link to specific Customizer section
     *
     * http://wordpress.stackexchange.com/questions/214473/link-to-specific-customizer-section
     */
    array(
      'type'    => 'notice',
      'class'   => 'default',
      'content' => __( 'To set the site icon, please click here:', 'exopite' ) . ' <a href="' . get_site_url() . '/wp-admin/customize.php?autofocus[section]=title_tagline" target="_blank">favicon.ico</a>',
    ),

    array(
      'id'       => 'exopite-content-width',
      'type'     => 'number',
      'title'    => esc_attr__( 'Content width', 'exopite' ),
      'default'  => '1050',
      'validate' => 'numeric',
      'desc'     => esc_attr__( 'Default:', 'exopite' ) . ' 1050 px',
    ),

    array(
      'id'       => 'exopite-mobile-width',
      'type'     => 'number',
      'title'    => esc_attr__( 'Mobile width', 'exopite' ),
      'default'  => '767',
      'validate' => 'numeric',
      'desc'     => esc_attr__( 'Default:', 'exopite' ) . ' 767 px',
    ),

    array(
      'id'      => 'exopite-show-comments',
      'type'    => 'switcher',
      'title'   => esc_attr__( 'Show comments', 'exopite' ),
      'default' => false,
      'label'   => esc_attr__( 'Enable or disable comments everywhere on the site.', 'exopite' ),
    ),

    array(
      'id'      => 'exopite-enable-revisions-limit',
      'type'    => 'switcher',
      'title'   => esc_attr__( 'Limit revisions', 'exopite' ),
      'default' => false,
      'label'   => esc_attr__( 'If you enable this, you can override amount on every post and page.', 'exopite' ) . '<br>' . sprintf( esc_attr__( 'Read more about %1$swhy limit post revisions%2$s.', 'exopite' ), ' <a href="http://www.wpstuffs.com/how-to-limit-post-revisions-in-wordpress-without-plugin/" target="_blank">', '</a>' ),
      'desc'    => '<span style="color:#E52745;">' . esc_attr__( 'Before activate this, please make sure that you know what you doing!', 'exopite' ) . '</span>',
    ),

    array(
      'type'    => 'notice',
      'class'   => 'danger',
      'dependency' => array( 'exopite-enable-revisions-limit', '==', 'true' ),
      'content' => '<b>' . esc_attr__( 'Caution:', 'exopite' ) . '</b> ' . esc_attr__( 'If revisions amount is smaller then the revision count on the post or page, extra revisions will be removed on next modification and save!', 'exopite' ),
    ),

    array(
        'id'         => 'exopite-revisions-limit-to-keep',
        'type'       => 'slider',
        'title'      => esc_attr__( 'Number of revisions to keep', 'exopite' ),
        'validate'   => 'numeric',
        'default'    => 9,
        'options'    => array(
            'step'     => 1,
            'min'      => 0,
            'max'      => 100,
            'unit'     => ''
        ),
        'dependency' => array( 'exopite-enable-revisions-limit', '==', 'true' ),
    ),

    array(
      'id'           => 'exopite-body-backgorund',
      'type'         => 'background_preview',
      'title'        => esc_attr__( 'Body background image and/or color', 'exopite' ),
      'default'      => array(
        'image'      => '',
        'repeat'     => 'no-repeat',
        'position'   => 'center center',
        'attachment' => 'scroll',
        'color'      => '#ffffff',
      ),
      'dependency'  => array( 'exopite-content-layout_boxed', '==', 'true' ),
    ),

    array(
        'id'        => 'exopite-boxed-padding-top',
        'type'      => 'slider',
        'title'     => esc_attr__( 'Content top padding', 'exopite' ),
        'validate'  => 'numeric',
        'default'   => 0,
        'options'   => array(
            'step'    => 1,
            'min'     => 0,
            'max'     => 100,
            'unit'    => ''
        ),
        'dependency'  => array( 'exopite-content-layout_boxed', '==', 'true' ),
    ),

    array(
        'id'        => 'exopite-boxed-padding-bottom',
        'type'      => 'slider',
        'title'     => esc_attr__( 'Content bottom padding', 'exopite' ),
        'validate'  => 'numeric',
        'default'   => 0,
        'options'   => array(
            'step'    => 1,
            'min'     => 0,
            'max'     => 100,
            'unit'    => ''
        ),
        'dependency'  => array( 'exopite-content-layout_boxed', '==', 'true' ),
    ),

    array(
      'id'           => 'exopite-content-backgorund',
      'type'         => 'background_preview',
      'title'        => esc_attr__( 'Content background image and/or color', 'exopite' ),
      'default'      => array(
        'image'      => '',
        'repeat'     => 'no-repeat',
        'position'   => 'center center',
        'attachment' => 'scroll',
        'color'      => '#ffffff',
      ),
    ),

  ), // end: fields
);

// ----------------------------------------
// CSS                                    -
// ----------------------------------------
$exopite_options[]      = array(
  'name'        => 'css_section',
  'title'       => esc_attr__( 'CSS', 'exopite' ),
  'icon'        => 'fa fa-code',

  // begin: fields
  'fields'      => array(

    array(
      'id'     => 'exopite-css',
      'type'   => 'aceeditor',
      'attributes'  => array(
        'data-theme'    => 'chrome',
        'data-mode'     => 'css',
      ),
      'before' => '<div class="cs-title"><h4>' . esc_attr__( 'Add your CSS here', 'exopite' ) . ' <i class="cs-text-muted"> - ' . esc_html__( 'without the &lt;style&gt; tag', 'exopite' ) . '</i></h4></div>',
      'after' => 'ACE JavaScript Editor <i class="fa fa-arrow-right" aria-hidden="true"></i> <a href="https://github.com/ajaxorg/ace/wiki/Default-Keyboard-Shortcuts" target="_blank">Info</a>',
    ),

  ), // end: fields
);

// ----------------------------------------
// JavaScript                             -
// ----------------------------------------
$exopite_options[]      = array(
  'name'        => 'js_section',
  'title'       => esc_attr__( 'JavaScript', 'exopite' ),
  'icon'        => 'fa fa-code',

  // begin: fields
  'fields'      => array(

    array(
      'id'     => 'exopite-js',
      'type'   => 'aceeditor',
      'attributes'  => array(
        'data-theme'    => 'chrome',
        'data-mode'     => 'javascript',
      ),
      'before' => '<div class="cs-title"><h4>' . esc_attr__( 'Add your JavaScript here', 'exopite' ) . ' <i class="cs-text-muted"> - ' . esc_html__( 'without the &lt;srcipt&gt; tag', 'exopite' ) . '</i></h4></div>',
      'after' => 'ACE JavaScript Editor <i class="fa fa-arrow-right" aria-hidden="true"></i> <a href="https://github.com/ajaxorg/ace/wiki/Default-Keyboard-Shortcuts" target="_blank">Info</a>',
    ),

  ), // end: fields
);

// ------------------------------
// header accordion sections    -
// ------------------------------
$exopite_options[]   = array(
  'name'     => 'header_section',
  'title'    => esc_attr__( 'Header & Menus', 'exopite' ),
  'icon'     => 'fa fa-bars',
  'sections' => array(

    // sub section Header
    array(
      'name'     => 'header_sub_section',
      'title'    => esc_attr__( 'Header', 'exopite' ),
      'icon'     => 'fa fa-minus',
      'fields'   => array(

        array(
          'id'           => 'exopite-menu-alignment',
          'type'         => 'image_select',
          'title'        => esc_attr__( 'Menu alignment', 'exopite' ),
          'options'      => array(
            'top'        => CS_URI . '/assets/images/top.jpg',
            'left'       => CS_URI . '/assets/images/left.jpg',
            // 'overlay'    => CS_URI . '/assets/images/menu-overlay.jpg',
          ),
          'radio'        => true,
          'default'      => 'top'
        ),

        array(
          'id'           => 'exopite-preheader-content',
          'type'         => 'image_select',
          'title'        => esc_attr__( 'Preheader content', 'exopite' ),
          'options'      => array(
            'widget'        => CS_URI . '/assets/images/widget.jpg',
            'page'          => CS_URI . '/assets/images/img-top.jpg',
          ),
          'radio'        => true,
          'default'      => 'widget',
        ),

        array(
          'id'      => 'exopite-preheader-from-page',
          'type'    => 'select',
          'title'   => esc_attr__( 'Display page as preheader', 'exopite' ),
          'options' => 'posts',
          'class'   => 'chosen',
          'query_args'  => array(
            'post_type' => 'exopite-sections',  // Your post_type name
            'orderby'   => 'title',
            'order'     => 'ASC',
            'posts_per_page' => -1,
          ),
          'attributes' => array(
            'data-placeholder' => esc_attr__( 'Page(s)', 'exopite' ),
            'style' => 'width: 320px',
          ),
          'dependency'  => array( 'exopite-preheader-content_page', '==', 'true' ),
          'desc'        => sprintf( esc_attr__( 'First you have to add a sections %1$shere%2$s.', 'exopite' ), '<a href="edit.php?post_type=exopite-sections">', '</a>' ),
        ),

        array(
            'id'        => 'exopite-sidebar-preheader-count',
            'type'      => 'slider',
            'title'     => esc_attr__( 'Preheader widget columns', 'exopite' ),
            'validate'  => 'numeric',
            'default'   => 0,
            'options'   => array(
                'step'    => 1,
                'min'     => 0,
                'max'     => 4,
                'unit'    => ''
            ),
            'dependency'  => array( 'exopite-preheader-content_widget', '==', 'true' ),
            'desc'        => sprintf( esc_attr__( 'Go to Appearance -> %1$sWidgets%2$s to add widgets to sidebar.', 'exopite' ), '<a href="widgets.php">', '</a>' ),
        ),

        array(
          'id'          => 'exopite-menu-full-width',
          'type'        => 'switcher',
          'title'       => esc_attr__( 'Menu full width', 'exopite' ),
          'default'     => false,
          'dependency'  => array( 'exopite-menu-alignment_left', '==', 'false' ),
          //'dependency'  => array( 'exopite-menu-alignment_top|exopite-menu-alignment_overlay', '==|==', 'true|true' ),
        ),

        array(
          'id'          => 'exopite-sidebar-preheader-full-width',
          'type'        => 'switcher',
          'title'       => esc_attr__( 'Preheader widget full width', 'exopite' ),
          'default'     => false,
          'dependency'  => array( 'exopite-menu-alignment_left', '==', 'false' ),
        ),

        array(
          'id'           => 'exopite-sidebar-preheader-backgorund',
          'type'         => 'background_preview',
          'title'        => esc_attr__( 'Preheader image and/or color', 'exopite' ),
          'default'      => array(
            'image'      => '',
            'repeat'     => 'no-repeat',
            'position'   => 'center center',
            'attachment' => 'scroll',
            'color'      => '#ffffff',
          ),
          'dependency' => array( 'exopite-sidebar-preheader-count|exopite-preheader-content_widget', '>|==', '0|true' ),
        ),

        array(
            'id'        => 'exopite-sidebar-after-header-count',
            'type'      => 'slider',
            'title'     => esc_attr__( 'After the header widget columns', 'exopite' ),
            'validate'  => 'numeric',
            'default'   => 0,
            'options'   => array(
                'step'    => 1,
                'min'     => 0,
                'max'     => 4,
                'unit'    => ''
            ),
            'desc'      => sprintf( esc_attr__( 'Go to Appearance -> %1$s to add widgets to sidebar.', 'exopite' ), '<a href="widgets.php">Widgets</a>' ),
        ),

      )
    ),

    // sub section Hero header
    array(
      'name'     => 'hero_header_sub_section',
      'title'    => esc_attr__( 'Hero Header', 'exopite' ),
      'icon'     => 'fa fa-minus',
      'fields'   => array(

        array(
          'type'    => 'notice',
          'class'   => 'info',
          'content' => esc_attr__( 'To use hero header on individual pages, enable it here.', 'exopite' ),
        ),

        array(
          'id'          => 'exopite-enable-hero-header',
          'type'        => 'switcher',
          'title'       => esc_attr__( 'Enable hero header', 'exopite' ),
          'default'     => true,
        ),

        array(
          'id'          => 'exopite-enable-hero-header-front-page',
          'type'        => 'switcher',
          'title'       => esc_attr__( 'Display on front page', 'exopite' ),
          'default'     => true,
          'desc'        => esc_attr__( 'You can turn on hero header on individual page or posts too.', 'exopite' ),
          'dependency'  => array( 'exopite-enable-hero-header', '==', 'true' ),
        ),

        array(
          'id'          => 'exopite-enable-hero-header-fixed',
          'type'        => 'switcher',
          'title'       => esc_attr__( 'Fixed hero header', 'exopite' ),
          'default'     => true,
          'dependency'  => array( 'exopite-enable-hero-header', '==', 'true' ),
        ),

        array(
          'id'          => 'exopite-enable-hero-header-parallax',
          'type'        => 'switcher',
          'title'       => esc_attr__( 'Enable hero header parallax', 'exopite' ),
          'default'     => true,
          'dependency'  => array( 'exopite-enable-hero-header|exopite-enable-hero-header-fixed', '==|==', 'true|true' ),
        ),

        array(
          'id'          => 'exopite-enable-hero-header-show-menu-below',
          'type'        => 'switcher',
          'title'       => esc_attr__( 'Hero header show menu below', 'exopite' ),
          'default'     => false,
          'dependency'  => array( 'exopite-enable-hero-header|exopite-menu-alignment_left', '==|==', 'true|false' ),
        ),

        array(
          'type'    => 'notice',
          'class'   => 'info',
          'content' => esc_attr__( 'Height is calculated automatically. Disabled on fixed menu.', 'exopite' ),
          'dependency' => array( 'exopite-enable-hero-header|exopite-enable-hero-header-show-menu-below', '==|==', 'true|true' ),
        ),

        array(
            'id'        => 'exopite-hero-header-show-menu-below-color',
            'type'      => 'color_picker_menu',
            'title'     => esc_attr__( 'Menu below color', 'exopite' ),
            'default'   =>  array(
                'background' => array(
                    'value' => '#5379BA',
                    'name'  => esc_attr__( 'Background color', 'exopite' ),
                ),
                'background-active-hover' => array(
                    'value' => '#5379BA',
                    'name'  => esc_attr__( 'Background active and hover color', 'exopite' ),
                ),
                'link' => array(
                    'value' => '#ffffff',
                    'name'  => esc_attr__( 'Link color', 'exopite' ),
                ),
                'link-active-hover' => array(
                    'value' => '#FFDD00',
                    'name'  => esc_attr__( 'Link active and hover color', 'exopite' ),
                ),
            ),
            'dependency' => array( 'exopite-enable-hero-header|exopite-enable-hero-header-show-menu-below', '==|==', 'true|true' ),
        ),

        array(
          'id'           => 'exopite-hero-header-show-menu-below-backgorund',
          'type'         => 'background_preview',
          'title'        => esc_attr__( 'Menu below background image and/or color', 'exopite' ),
          'default'      => array(
            'image'      => '',
            'repeat'     => 'no-repeat',
            'position'   => 'center center',
            'attachment' => 'scroll',
            'color'      => '#ffffff',
          ),
          'dependency' => array( 'exopite-enable-hero-header|exopite-enable-hero-header-show-menu-below', '==|==', 'true|true' ),
        ),

        array(
            'id'         => 'exopite-hero-header-height',
            'type'       => 'slider',
            'title'      => esc_attr__( 'Hero header height in %', 'exopite' ),
            'validate'   => 'numeric',
            'default'    => 100,
            'options'    => array(
                'step'     => 1,
                'min'      => 1,
                'max'      => 100,
                'unit'     => ''
            ),
            'dependency' => array( 'exopite-enable-hero-header|exopite-enable-hero-header-show-menu-below', '==|==', 'true|false' ),
        ),

        array(
            'id'         => 'exopite-hero-header-min-height',
            'type'       => 'slider',
            'title'      => esc_attr__( 'Hero header minimum height in px', 'exopite' ),
            'validate'   => 'numeric',
            'default'    => 1,
            'options'    => array(
                'step'     => 1,
                'min'      => 1,
                'max'      => 1000,
                'unit'     => ''
            ),
            'dependency' => array( 'exopite-enable-hero-header', '==', 'true' ),
        ),

        array(
          'id'          => 'exopite-hero-header-type',
          'type'        => 'image_select',
          'title'       => esc_attr__( 'Hero header type', 'exopite' ),
          'options'     => array(
            'image'         => CS_URI . '/assets/images/image.jpg',
            'video'         => CS_URI . '/assets/images/video.jpg',
            'youtube'       => CS_URI . '/assets/images/youtube.jpg',
            'googledrive'  => CS_URI . '/assets/images/googledrive.jpg',
          ),
          'radio'       => true,
          'default'     => 'image',
          'dependency'  => array( 'exopite-enable-hero-header', '==', 'true' ),
        ),

        array(
          'id'         => 'exopite-hero-header-image',
          'type'       => 'image',
          'title'      => esc_attr__( 'Hero header image', 'exopite' ),
          'add_title'  => esc_attr__( 'Add Image', 'exopite' ),
          'dependency' => array( 'exopite-enable-hero-header|exopite-hero-header-type_image', '==|==', 'true|true' ),
        ),

        array(
          'id'          => 'exopite-hero-header-video',
          'type'        => esc_attr__( 'upload', 'exopite' ),
          'title'       => esc_attr__( 'Hero header mp4 video', 'exopite' ),
          'settings'    => array(
            'upload_type'  => 'video/mp4', // or video
            'button_title' => esc_attr__( 'Upload', 'exopite' ),
            'frame_title'  => esc_attr__( 'Select .mp4 video file', 'exopite' ),
            'insert_title' => esc_attr__( 'Use this file', 'exopite' ),
          ),
          'after'       => '<br><i style="color:#888">' . esc_attr__( "Upload .mp4 video file. Recommended max. size is 2MB.", 'exopite' ) . '</i>',
          'dependency' => array( 'exopite-enable-hero-header|exopite-hero-header-type_video', '==|==', 'true|true' ),
        ),

        array(
          'id'         => 'exopite-hero-header-overlay-color',
          'type'       => 'color_picker',
          'title'      => esc_attr__('Hero header overlay color', 'exopite'),
          'rgba'       => true,
          'default'    => 'rgba(0,0,0,0)',
          'dependency' => array( 'exopite-enable-hero-header|exopite-hero-header-type_youtube|exopite-hero-header-type_googledrive', '==|==|==', 'true|false|false' ),

        ),

        array(
          'id'         => 'exopite-hero-header-youtube-id', // another unique id
          'type'       => 'text',
          'title'      => 'Hero header Youtube video ID',
          'desc'       => esc_attr__( "The height of the video will be 100%.", 'exopite' ) . '<br>' . esc_attr__( "Video will be not muted.", 'exopite' ),
          'after'      => '<br><i style="color:#888">' . esc_attr__( "Please insert your Youtube video ID.", 'exopite' ) . '<br>https://www.youtube.com/watch?v=<b>XXXXXXXXXXX</b></i>',
          'dependency' => array( 'exopite-enable-hero-header|exopite-hero-header-type_youtube', '==|==', 'true|true' ),
        ),

        array(
          'id'         => 'exopite-hero-header-google-video-id', // another unique id
          'type'       => 'text',
          'title'      => 'Hero header Google video ID',
          'desc'       => esc_attr__( "The height of the video will be 100%.", 'exopite' ) . '<br>' . esc_attr__( "Video will be not muted.", 'exopite' ),
          'after'      => '<br><i style="color:#888">' . esc_attr__( "Make sure, you share Google Video via link to everyone. Please insert your Google video ID.", 'exopite' ) . '<br>https://drive.google.com/file/d/<b>XXXXXXXXXXX</b>/preview</i>',
          'dependency' => array( 'exopite-enable-hero-header|exopite-hero-header-type_googledrive', '==|==', 'true|true' ),
        ),

        array(
          'id'          => 'exopite-hero-header-site-branding-type',
          'type'        => 'image_select',
          'title'       => esc_attr__( 'Site branding type', 'exopite' ),
          'options'     => array(
            'image'     => CS_URI . '/assets/images/image.jpg',
            'widget'    => CS_URI . '/assets/images/widget.jpg',
          ),
          'radio'       => true,
          'default'     => 'widget',
          'dependency'  => array( 'exopite-enable-hero-header', '==', 'true' ),
          'desc'        => sprintf( esc_attr__( 'Go to Appearance -> %1$sWidgets%2$s to add widgets to sidebar.', 'exopite' ), '<a href="widgets.php">', '</a>' ),
        ),

        array(
          'id'         => 'exopite-hero-header-site-branding-image',
          'type'       => 'image',
          'title'      => esc_attr__( 'Site branding image', 'exopite' ),
          'add_title'  => esc_attr__( 'Add Image', 'exopite' ),
          'dependency' => array( 'exopite-enable-hero-header|exopite-hero-header-site-branding-type_image', '==|==', 'true|true' ),
          'after'     => '<br><i style="color:#888">' . esc_attr__( "Leave it empty, if you don't want to display anything here.", 'exopite' ) . '</i>',
        ),

        array(
          'id'          => 'exopite-hero-header-site-branding-horizontal',
          'type'        => 'image_select',
          'title'       => esc_attr__( 'Site branding horizontal alignment', 'exopite' ),
          'options'     => array(
            'left'      => CS_URI . '/assets/images/s-top-left.jpg',
            'center'    => CS_URI . '/assets/images/s-center.jpg',
            'right'     => CS_URI . '/assets/images/s-right.jpg',
          ),
          'radio'       => true,
          'default'     => 'center',
          'dependency'  => array( 'exopite-enable-hero-header', '==', 'true' ),
        ),

        array(
          'id'           => 'exopite-hero-header-site-branding-vertical',
          'type'         => 'image_select',
          'title'        => esc_attr__( 'Site branding vertical alignment', 'exopite' ),
          'options'      => array(
            'top'        => CS_URI . '/assets/images/s-top-left.jpg',
            'middle'     => CS_URI . '/assets/images/s-middle.jpg',
            'bottom'     => CS_URI . '/assets/images/s-bottom.jpg',
          ),
          'radio'        => true,
          'default'      => 'middle',
          'dependency'   => array( 'exopite-enable-hero-header', '==', 'true' ),
        ),

      )
    ),

    // sub section Logo menu
    array(
      'name'     => 'logo_menu_sub_section',
      'title'    => esc_attr__( 'Logo', 'exopite' ),
      'icon'     => 'fa fa-minus',
      'fields'   => array(


        array(
          'type'    => 'notice',
          'class'   => 'info',
          'content' => esc_attr__( 'Desktop logo', 'exopite' ),
        ),

        array(
          'id'        => 'exopite-desktop-logo',
          'type'      => 'image',
          'title'     => esc_attr__( 'Logo', 'exopite' ),
          'add_title' => esc_attr__( 'Add Logo', 'exopite' ),
        ),

        array(
          'id'           => 'exopite-desktop-logo-position',
          'type'         => 'image_select',
          'title'        => esc_attr__( 'Logo position', 'exopite' ),
          'options'      => array(
            'left'          => CS_URI . '/assets/images/logo-left-menu.jpg',
            'center'        => CS_URI . '/assets/images/logo-menu-center.jpg',
            'right'         => CS_URI . '/assets/images/logo-right-menu.jpg',
            'top'           => CS_URI . '/assets/images/logo-top.jpg',
            'top-in-menu'   => CS_URI . '/assets/images/logo-top-with-menu.jpg',
          ),
          'radio'        => true,
          'default'      => 'top',
        ),

        array(
          'id'           => 'exopite-desktop-logo-alignment',
          'type'         => 'image_select',
          'title'        => esc_attr__( 'Logo alignement', 'exopite' ),
          'options'      => array(
            'text-left flex-left'    => CS_URI . '/assets/images/logo-left.jpg',
            'text-center flex-center'  => CS_URI . '/assets/images/logo-center.jpg',
            'text-right flex-right'   => CS_URI . '/assets/images/logo-right.jpg',
          ),
          'radio'        => true,
          'default'      => 'text-center flex-center'
        ),

        array(
            'id'        => 'exopite-logo-ratio',
            'type'      => 'slider',
            'title'     => esc_attr__( 'Logo - menu ratio', 'exopite' ),
            'desc'      => esc_attr__( 'Logo - menu ratio in large screen.', 'exopite' ) . '<br>' . esc_attr__( 'Medium screen calculated from large screen.', 'exopite' ),
            'validate'  => 'numeric',
            'default'   => 3,
            'options'   => array(
                'step'    => 1,
                'min'     => 1,
                'max'     => 6,
                'unit'    => ''
            ),
            'dependency'  => array( 'exopite-desktop-logo-position_center', '==', 'false' ),
        ),

        array(
            'id'        => 'exopite-logo-width',
            'type'      => 'slider',
            'title'     => esc_attr__( 'Logo max-width', 'exopite' ),
            'validate'  => 'numeric',
            'default'   => 80,
            'options'   => array(
                'step'    => 1,
                'min'     => 20,
                'max'     => 510,
                'unit'    => ''
            )
        ),

        array(
            'id'        => 'exopite-logo-padding-top',
            'type'      => 'slider',
            'title'     => esc_attr__( 'Logo padding top', 'exopite' ),
            'validate'  => 'numeric',
            'default'   => 0,
            'options'   => array(
                'step'    => 1,
                'min'     => 0,
                'max'     => 100,
                'unit'    => ''
            )
        ),

        array(
            'id'        => 'exopite-logo-padding-bottom',
            'type'      => 'slider',
            'title'     => esc_attr__( 'Logo padding bottom', 'exopite' ),
            'validate'  => 'numeric',
            'default'   => 0,
            'options'   => array(
                'step'    => 1,
                'min'     => 0,
                'max'     => 100,
                'unit'    => ''
            )
        ),

        array(
          'id'      => 'exopite-floating-menu-logo',
          'type'    => 'switcher',
          'title'   => esc_attr__( 'Show floating menu logo', 'exopite' ),
          'default' => true,
          'label'   => '',
          'dependency'  => array( 'exopite-menu-alignment_left', '==', 'false' ),
        ),

        array(
          'type'    => 'notice',
          'class'   => 'info',
          'content' => esc_attr__( 'Mobile logo', 'exopite' ),
        ),

        array(
          'type'    => 'notice',
          'class'   => 'warning',
          'content' => esc_attr__( 'This options available only on top menu.', 'exopite' ),
          'dependency'  => array( 'exopite-menu-alignment_left', '==', 'true' ),
        ),

        array(
          'id'        => 'exopite-mobile-menu-logo',
          'type'      => 'image',
          'title'     => esc_attr__( 'Logo', 'exopite' ),
          'add_title' => esc_attr__( 'Add Logo', 'exopite' ),
          'dependency'  => array( 'exopite-menu-alignment_left', '==', 'false' ),
        ),

        array(
            'id'        => 'exopite-mobile-logo-width',
            'type'      => 'slider',
            'title'     => esc_attr__( 'Logo width', 'exopite' ),
            'validate'  => 'numeric',
            'default'   => 42,
            'options'   => array(
                'step'    => 1,
                'min'     => 20,
                'max'     => 300,
                'unit'    => ''
            )
        ),

        array(
            'id'        => 'exopite-mobile-logo-padding-top',
            'type'      => 'slider',
            'title'     => esc_attr__( 'Logo padding top', 'exopite' ),
            'validate'  => 'numeric',
            'default'   => 0,
            'options'   => array(
                'step'    => 1,
                'min'     => 0,
                'max'     => 100,
                'unit'    => ''
            )
        ),

        array(
            'id'        => 'exopite-mobile-logo-padding-bottom',
            'type'      => 'slider',
            'title'     => esc_attr__( 'Logo padding bottom', 'exopite' ),
            'validate'  => 'numeric',
            'default'   => 0,
            'options'   => array(
                'step'    => 1,
                'min'     => 0,
                'max'     => 100,
                'unit'    => ''
            )
        ),

      ),
    ),

    // sub section Desktop menu
    array(
      'name'     => 'desktop_menu_sub_section',
      'title'    => esc_attr__( 'Desktop menu', 'exopite' ),
      'icon'     => 'fa fa-minus',
      'fields'   => array(

        array(
          'id'           => 'exopite-desktop-menu-horizontal-alignment',
          'type'         => 'image_select',
          'title'        => esc_attr__( 'Menu horizontal alignment', 'exopite' ),
          'options'      => array(
            'menu-left'    => CS_URI . '/assets/images/menu-left.jpg',
            'menu-center'  => CS_URI . '/assets/images/menu-center.jpg',
            'menu-right'   => CS_URI . '/assets/images/menu-right.jpg',
          ),
          'radio'        => true,
          'default'      => 'menu-center',
          'dependency'  => array( 'exopite-menu-alignment_left', '==', 'false' ),
        ),

        array(
          'id'           => 'exopite-desktop-menu-vertical-alignment',
          'type'         => 'image_select',
          'title'        => esc_attr__( 'Menu vertical alignment', 'exopite' ),
          'options'      => array(
            'menu-top'    => CS_URI . '/assets/images/menu-top.jpg',
            'menu-middle'  => CS_URI . '/assets/images/menu-center.jpg',
            'menu-bottom'   => CS_URI . '/assets/images/menu-bottom.jpg',
          ),
          'radio'        => true,
          'default'      => 'menu-middle',
          'dependency'  => array( 'exopite-menu-alignment_left', '==', 'false' ),
        ),

        array(
          'id'      => 'exopite-desktop-menu-search',
          'type'    => 'switcher',
          'title'   => esc_attr__( 'Enable search in menu', 'exopite' ),
          'default' => true,
          'label'   => '',
          'dependency'  => array( 'exopite-menu-alignment_left', '==', 'false' ),
        ),


        array(
          'id'      => 'exopite-desktop-menu-font-uppercase',
          'type'    => 'switcher',
          'title'   => esc_attr__( 'Font uppercase', 'exopite' ),
          'default' => false,
        ),

        array(
          'id'      => 'exopite-enable-desktop-menu-toggle',
          'type'    => 'switcher',
          'title'   => esc_attr__( 'Enable menu toggle on desktop', 'exopite' ),
          'default' => false,
          'dependency'  => array( 'exopite-menu-alignment_left', '==', 'true' ),
        ),


        array(
            'id'        => 'exopite-sidebar-menu-top-count',
            'type'      => 'slider',
            'title'     => esc_attr__( 'Menu top widget columns', 'exopite' ),
            'validate'  => 'numeric',
            'default'   => 0,
            'options'   => array(
                'step'    => 1,
                'min'     => 0,
                'max'     => 4,
                'unit'    => ''
            ),
            'desc'        => sprintf( esc_attr__( 'Go to Appearance -> %1$sWidgets%2$s to add widgets to sidebar.', 'exopite' ), '<a href="widgets.php">', '</a>' ),
        ),


        array(
            'id'        => 'exopite-desktop-menu-padding-top',
            'type'      => 'slider',
            'title'     => esc_attr__( 'Menu padding top', 'exopite' ),
            'validate'  => 'numeric',
            'default'   => 12,
            'options'   => array(
                'step'    => 1,
                'min'     => 0,
                'max'     => 20,
                'unit'    => ''
            )
        ),

        array(
            'id'        => 'exopite-desktop-menu-padding-bottom',
            'type'      => 'slider',
            'title'     => esc_attr__( 'Menu padding bottom', 'exopite' ),
            'validate'  => 'numeric',
            'default'   => 12,
            'options'   => array(
                'step'    => 1,
                'min'     => 0,
                'max'     => 20,
                'unit'    => ''
            )
        ),

        array(
          'id'           => 'exopite-desktop-menu-backgorund',
          'type'         => 'background_preview',
          'title'        => esc_attr__( 'Header background image and/or color', 'exopite' ),
          'default'      => array(
            'image'      => '',
            'repeat'     => 'no-repeat',
            'position'   => 'center center',
            'attachment' => 'scroll',
            'color'      => '#ffffff',
          ),
        ),

        array(
          'id'      => 'exopite-desktop-menu-nav-background',
          'type'    => 'color_picker',
          'title'   => esc_attr__('Navbar background color', 'exopite'),
          'rgba'    => true,
          'default' => '#5379BA',
          'dependency'  => array( 'exopite-menu-alignment_left', '==', 'false' ),
        ),

        array(
            'id'        => 'exopite-desktop-menu-shadow',
            'type'      => 'shadow',
            'title'     => esc_attr__( 'Shadow', 'exopite' ),
            'preview'   => true,
            'default'   =>  array(
                'horizontal-length' => array(
                    'step'  => 1,
                    'min'   => 0,
                    'max'   => 10,
                    'value' => 0,
                    'name'  => 'Horizontal',
                ),
                'vertical-length'   =>  array(
                    'step'  => 1,
                    'min'   => 0,
                    'max'   => 10,
                    'value' => 0,
                    'name'  => 'Vertical',
                ),
                'blur-radius'       =>  array(
                    'step'  => 1,
                    'min'   => 0,
                    'max'   => 10,
                    'value' => 0,
                    'name'  => 'Blur radius',
                ),
                'spread-radius'     =>  array(
                    'step'  => 1,
                    'min'   => 0,
                    'max'   => 10,
                    'value' => 0,
                    'name'  => 'Spread radius',
                ),
                'color' => array(
                    'value'  => 'rgba(0, 0, 0, 0.6)',
                    'name'   => 'Color',
                ),
            ),
        ),

        array(
            'id'        => 'exopite-desktop-menu-border',
            'type'      => 'border',
            'title'     => esc_attr__( 'Border', 'exopite' ),
            'preview'   => true,
            'default'   =>  array(
                'width' => array(
                    'step'  => 1,
                    'min'   => 0,
                    'max'   => 10,
                    'value' => 0,
                    'name'  => 'Width',
                ),
                'style' => array(
                    'value' => 'none',
                    'name'  => 'Style',
                ),
                'color' => array(
                    'value'  => 'rgba(0, 0, 0, 0.6)',
                    'name'   => 'Color',
                ),
            ),
        ),

        array(
            'id'        => 'exopite-desktop-menu-link-border-effect',
            'type'      => 'border',
            'title'     => esc_attr__( 'Link border effect', 'exopite' ),
            'preview'   => true,
            'default'   =>  array(
                'width' => array(
                    'step'  => 1,
                    'min'   => 0,
                    'max'   => 10,
                    'value' => 0,
                    'name'  => 'Width',
                ),
                'style' => array(
                    'value' => 'none',
                    'name'  => 'Style',
                ),
                'color' => array(
                    'value'  => 'rgba(0, 0, 0, 0.6)',
                    'name'   => 'Color',
                ),
            ),
            'dependency'  => array( 'exopite-menu-alignment_left', '==', 'false' ),
        ),

      )
    ),

    // sub section Desktop submenu
    array(
      'name'     => 'desktop_submenu_sub_section',
      'title'    => esc_attr__( 'Desktop submenu', 'exopite' ),
      'icon'     => 'fa fa-minus',
      'fields'   => array(

        array(
            'id'        => 'exopite-submenu-padding-top',
            'type'      => 'slider',
            'title'     => esc_attr__( 'Padding top', 'exopite' ),
            'validate'  => 'numeric',
            'default'   => 4,
            'options'   => array(
                'step'    => 1,
                'min'     => 0,
                'max'     => 8,
                'unit'    => ''
            )
        ),

        array(
            'id'        => 'exopite-submenu-padding-bottom',
            'type'      => 'slider',
            'title'     => esc_attr__( 'Padding bottom', 'exopite' ),
            'validate'  => 'numeric',
            'default'   => 4,
            'options'   => array(
                'step'    => 1,
                'min'     => 0,
                'max'     => 8,
                'unit'    => ''
            )
        ),

      )
    ),

    // sub section Desktop floating menu
    array(
      'name'     => 'desktop_floating_menu_sub_section',
      'title'    => esc_attr__( 'Desktop sticky menu', 'exopite' ),
      'icon'     => 'fa fa-minus',
      'fields'   => array(


        array(
          'type'    => 'notice',
          'class'   => 'warning',
          'content' => esc_attr__( 'This options available only on top menu.', 'exopite' ),
          'dependency'  => array( 'exopite-menu-alignment_left', '==', 'true' ),
        ),

        array(
          'id'      => 'exopite-floation-menu-enabled',
          'type'    => 'switcher',
          'title'   => esc_attr__( 'Enable sticky menu', 'exopite' ),
          'default' => true,
          'label'   => '',
          'dependency'  => array( 'exopite-menu-alignment_left', '==', 'false' ),
        ),

        array(
            'id'        => 'exopite-floating-menu-padding-top',
            'type'      => 'slider',
            'title'     => esc_attr__( 'Padding top', 'exopite' ),
            'validate'  => 'numeric',
            'default'   => 9,
            'options'   => array(
                'step'    => 1,
                'min'     => 0,
                'max'     => 20,
                'unit'    => ''
            ),
            'dependency'  => array( 'exopite-menu-alignment_left|exopite-floation-menu-enabled', '==|==', 'false|true' ),
        ),

        array(
            'id'        => 'exopite-floating-menu-padding-bottom',
            'type'      => 'slider',
            'title'     => esc_attr__( 'Padding bottom', 'exopite' ),
            'validate'  => 'numeric',
            'default'   => 9,
            'options'   => array(
                'step'    => 1,
                'min'     => 0,
                'max'     => 20,
                'unit'    => ''
            ),
            'dependency'  => array( 'exopite-menu-alignment_left|exopite-floation-menu-enabled', '==|==', 'false|true' ),
        ),

        array(
            'id'        => 'exopite-floating-menu-opacity',
            'type'      => 'slider',
            'title'     => esc_attr__( 'Opacity', 'exopite' ),
            'validate'  => 'numeric',
            'default'   => 0.8,
            'options'   => array(
                'step'    => 0.1,
                'min'     => 0,
                'max'     => 1,
                'unit'    => ''
            ),
            'dependency'  => array( 'exopite-menu-alignment_left|exopite-floation-menu-enabled', '==|==', 'false|true' ),
        ),

        array(
            'id'        => 'exopite-floating-menu-shadow',
            'type'      => 'shadow',
            'title'     => esc_attr__( 'Shadow', 'exopite' ),
            'preview'   => true,
            'default'   =>  array(
                'horizontal-length' => array(
                    'step'  => 1,
                    'min'   => 0,
                    'max'   => 10,
                    'value' => 0,
                    'name'  => 'Horizontal',
                ),
                'vertical-length'   =>  array(
                    'step'  => 1,
                    'min'   => 0,
                    'max'   => 10,
                    'value' => 0,
                    'name'  => 'Vertical',
                ),
                'blur-radius'       =>  array(
                    'step'  => 1,
                    'min'   => 0,
                    'max'   => 10,
                    'value' => 0,
                    'name'  => 'Blur radius',
                ),
                'spread-radius'     =>  array(
                    'step'  => 1,
                    'min'   => 0,
                    'max'   => 10,
                    'value' => 0,
                    'name'  => 'Spread radius',
                ),
                'color' => array(
                    'value'  => 'rgba(0, 0, 0, 0.3)',
                    'name'   => 'Color',
                ),
            ),
            'dependency'  => array( 'exopite-menu-alignment_left|exopite-floation-menu-enabled', '==|==', 'false|true' ),
        ),

        array(
            'id'        => 'exopite-floating-menu-border',
            'type'      => 'border',
            'title'     => esc_attr__( 'Border', 'exopite' ),
            'preview'   => true,
            'default'   =>  array(
                'width' => array(
                    'step'  => 1,
                    'min'   => 0,
                    'max'   => 10,
                    'value' => 0,
                    'name'  => 'Width',
                ),
                'style' => array(
                    'value' => 'none',
                    'name'  => 'Style',
                ),
                'color' => array(
                    'value'  => 'rgba(0, 0, 0, 0.6)',
                    'name'   => 'Color',
                ),
            ),
            'dependency'  => array( 'exopite-menu-alignment_left|exopite-floation-menu-enabled', '==|==', 'false|true' ),
        ),

      )
    ),

    // sub section Desktop/Mobile fixed menu
    array(
      'name'     => 'desktop_mobile_fixed_menu_sub_section',
      'title'    => esc_attr__( 'Fixed menu', 'exopite' ),
      'icon'     => 'fa fa-minus',
      'fields'   => array(

        array(
          'type'    => 'notice',
          'class'   => 'warning',
          'content' => esc_attr__( 'This options available only on top menu.', 'exopite' ),
          'dependency'  => array( 'exopite-menu-alignment_left', '==', 'true' ),
        ),

        array(
          'type'    => 'notice',
          'class'   => 'info',
          'content' => esc_attr__( 'You can activate this menu on individual page or post settings.', 'exopite' ),
          'dependency'  => array( 'exopite-menu-alignment_left', '==', 'false' ),
        ),

        array(
          'id'      => 'exopite-fixed-nav-background',
          'type'    => 'color_picker',
          'title'   => esc_attr__('Navbar background color', 'exopite'),
          'rgba'    => true,
          'default' => 'rgba(255, 255, 255, 0)',
          'dependency'  => array( 'exopite-menu-alignment_left', '==', 'false' ),
        ),

      )
    ),
    // sub section Mobile menu
    array(
      'name'     => 'mobile_menu_sub_section',
      'title'    => esc_attr__( 'Mobile menu', 'exopite' ),
      'icon'     => 'fa fa-minus',
      'fields'   => array(

        array(
          'id'      => 'exopite-mobile-menu-floation-enabled',
          'type'    => 'switcher',
          'title'   => esc_attr__( 'Enable floating menu', 'exopite' ),
          'default' => true,
          'label'   => '',
          'dependency'  => array( 'exopite-menu-alignment_left', '==', 'false' ),
        ),

        array(
          'id'      => 'exopite-mobile-menu-search',
          'type'    => 'switcher',
          'title'   => esc_attr__( 'Enable search in menu', 'exopite' ),
          'default' => true,
          'label'   => '',
          'dependency'  => array( 'exopite-menu-alignment_left', '==', 'false' ),
        ),

        array(
          'id'           => 'exopite-mobile-menu-position',
          'type'         => 'image_select',
          'title'        => esc_attr__( 'Menu alignement', 'exopite' ),
          'options'      => array(
            'left'    => CS_URI . '/assets/images/logo-left.jpg',
            'right'  => CS_URI . '/assets/images/logo-right.jpg',
          ),
          'radio'        => true,
          'default'      => 'left',
          'dependency'  => array( 'exopite-menu-alignment_left', '==', 'false' ),
        ),

        array(
          'id'      => 'exopite-mobile-menu-background-color',
          'type'    => 'color_picker',
          'title'   => esc_attr__('Navigation background color', 'exopite' ),
          'default' => '#ffffff',
          'rgba'    => true,
        ),

      )
    ),

  ),
);

// ------------------------------
// footer                       -
// ------------------------------
$exopite_options[]   = array(
  'name'     => 'footer_section',
  'title'    => esc_attr__( 'Footer', 'exopite' ),
  'icon'     => 'fa fa-bars',
  'sections' => array(

    // sub section footer menu
    array(
      'name'     => 'footer_footer_sub_section',
      'title'    => esc_attr__( 'Footer', 'exopite' ),
      'icon'     => 'fa fa-minus',
      'fields'   => array(

        array(
          'id'          => 'exopite-sidebar-footer-enable-slide-up',
          'type'        => 'switcher',
          'title'       => esc_attr__( 'Slide up animation', 'exopite' ),
          'default'     => true,
          'label'       => '',
          'dependency'  => array( 'exopite-content-layout_wide', '==', 'true' ),
        ),

        array(
          'id'          => 'exopite-sidebar-footer-enable-slide-up-mobile',
          'type'        => 'switcher',
          'title'       => esc_attr__( 'Slide up animation for mobile', 'exopite' ),
          'default'     => false,
          'label'       => '',
          'dependency'  => array( 'exopite-content-layout_wide', '==', 'true' ),
        ),

        array(
          'id'           => 'exopite-footer-background',
          'type'         => 'background_preview',
          'title'        => esc_attr__( 'Footer background image and/or color', 'exopite' ),
          'default'      => array(
            'image'      => '',
            'repeat'     => 'no-repeat',
            'position'   => 'center center',
            'attachment' => 'scroll',
            'color'      => '#2B2E33',
          ),
        ),

        array(
          'id'           => 'exopite-footer-content',
          'type'         => 'image_select',
          'title'        => esc_attr__( 'Footer content', 'exopite' ),
          'options'      => array(
            'widget'        => CS_URI . '/assets/images/widget.jpg',
            'page'          => CS_URI . '/assets/images/img-top.jpg',
          ),
          'radio'        => true,
          'default'      => 'widget',
        ),

        array(
          'id'      => 'exopite-footer-from-page',
          'type'    => 'select',
          'title'   => esc_attr__( 'Display page as footer', 'exopite' ),
          'options' => 'posts',
          'class'   => 'chosen',
          'query_args'  => array(
            'post_type' => 'exopite-sections',  // Your post_type name
            'orderby'   => 'title',
            'order'     => 'ASC',
            'posts_per_page' => -1,
          ),
          'attributes' => array(
            'data-placeholder' => esc_attr__( 'Page(s)', 'exopite' ),
            'style' => 'width: 320px'
          ),
          'dependency'  => array( 'exopite-footer-content_page', '==', 'true' ),
          'desc'        => sprintf( esc_attr__( 'First you have to add a sections %1$shere%2$s.', 'exopite' ), '<a href="edit.php?post_type=exopite-sections">', '</a>' ),
        ),

        array(
          'id'          => 'exopite-footer-from-page-full-width',
          'type'        => 'switcher',
          'title'       => esc_attr__( 'Full width content', 'exopite' ),
          'default'     => false,
          'label'       => '',
          'dependency'  => array( 'exopite-footer-content_page|exopite-content-layout_wide', '==|==', 'true|true' ),
        ),

        array(
          'id'              => 'exopite-footer-sidebar-areas',
          'type'            => 'group',
          'title'           => esc_attr__( 'Footer sidebars', 'exopite' ),
          'desc'            => sprintf( esc_attr__( 'Go to Appearance -> %1$sWidgets%2$s to add widgets to sidebar.', 'exopite' ), '<a href="widgets.php">', '</a>' ),
          'button_title'    => esc_attr__( 'Add new footer sidebar', 'exopite' ),
          'accordion_title' => esc_attr__( 'Adding new footer sidebar', 'exopite' ),
          'fields'          => array(

            array(
              'id'          => 'exopite-footer-sidebar-area-name',
              'type'        => 'text',
              'title'       => esc_attr__( 'Footer sidebar name', 'exopite' ),
            ),

            array(
              'id'           => 'exopite-footer-sidebar-area-preset',
              'type'         => 'image_select',
              'title'        => esc_attr__( 'Footer widget columns', 'exopite' ),
              'options'      => array(
                'equal'      => CS_URI . '/assets/images/footer-sidebar-equal.jpg',
                '12'         => CS_URI . '/assets/images/footer-sidebar-1-2.jpg',
                '21'         => CS_URI . '/assets/images/footer-sidebar-2-1.jpg',
                '112'        => CS_URI . '/assets/images/footer-sidebar-1-1-2.jpg',
                '121'        => CS_URI . '/assets/images/footer-sidebar-1-2-1.jpg',
                '211'        => CS_URI . '/assets/images/footer-sidebar-2-1-1.jpg',
              ),
              'radio'        => true,
              'default'      => 'equal'
            ),

            array(
                'id'        => 'exopite-footer-sidebar-area-count',
                'type'      => 'slider',
                'title'     => esc_attr__( 'Footer widget columns amount', 'exopite' ),
                'validate'  => 'numeric',
                'default'   => 4,
                'options'   => array(
                    'step'    => 1,
                    'min'     => 0,
                    'max'     => 4,
                    'unit'    => ''
                ),
                'dependency'  => array( 'exopite-footer-sidebar-area-preset_equal', '==', 'true' ),
            ),

          ),
          'dependency'  => array( 'exopite-footer-content_widget', '==', 'true' ),
        ),


      ),
    ),

    // sub section copyright menu
    array(
      'name'     => 'footer_copyright_sub_section',
      'title'    => esc_attr__( 'Copyright', 'exopite' ),
      'icon'     => 'fa fa-minus',
      'fields'   => array(

        array(
            'id'        => 'exopite-sidebar-copyright-count',
            'type'      => 'slider',
            'title'     => esc_attr__( 'Copyright widget columns', 'exopite' ),
            'validate'  => 'numeric',
            'default'   => 2,
            'options'   => array(
                'step'    => 1,
                'min'     => 0,
                'max'     => 2,
                'unit'    => ''
            ),
            'desc'      => sprintf( esc_attr__( 'Go to Appearance -> %1$sWidgets%2$s to add widgets to sidebar.', 'exopite' ), '<a href="widgets.php">', '</a>' ),
        ),

        array(
          'id'      => 'exopite-copyright-background',
          'type'    => 'color_picker',
          'title'   => esc_attr__('Copyright background color', 'exopite' ),
          'default' => '#25282D',
          'rgba'    => true,
        ),

      ),
    ),

  ),

);

// ------------------------------
// typography                   -
// ------------------------------

$exopite_options[]   = array(
  'name'     => 'typography_section',
  'title'    => esc_attr__( 'Typography', 'exopite' ),
  'icon'     => 'fa fa-font',
  'sections' => array(

    // sub section Header
    array(
      'name'     => 'font_uploader_typography_sub_section',
      'title'    => esc_attr__( 'Font Management', 'exopite' ),
      'icon'     => 'fa fa-minus',
      'fields'   => array(

        array(
          'id'          => 'exopite-download-google-fonts',
          'type'        => 'switcher',
          'title'       => esc_attr__( 'Download Google Fonts', 'exopite' ),
          'after'       => ' <i class="cs-text-muted">' . esc_html__( 'Maybe slower but GDPR compliant.', 'exopite' ) . '</i>',
          'default'     => true,
        ),

        array(
          'id'          => 'exopite-load-google-fonts-async',
          'type'        => 'switcher',
          'title'       => esc_attr__( 'Load Google Fonts async', 'exopite' ),
          'default'     => false,
          'dependency'  => array( 'exopite-download-google-fonts', '==', 'false' ),
        ),

        array(
          'id'              => 'exopite-custom-fonts',
          'type'            => 'group',
          'title'           => esc_attr__( 'Custom fonts', 'exopite' ),
        //   'desc'            => sprintf( esc_attr__( 'Go to Appearance -> %1$sWidgets%2$s to add widgets to sidebar.', 'exopite' ), '<a href="widgets.php">', '</a>' ),
          'button_title'    => esc_attr__( 'Add new font', 'exopite' ),
          'accordion_title' => esc_attr__( 'Local font', 'exopite' ),
          'fields'          => array(

            array(
              'id'          => 'exopite-local-font-name',
              'type'        => 'text',
              'title'       => esc_attr__( 'Font name', 'exopite' ),
            ),

            array(
                'id'            => 'exopite-local-font-ttf',
                'type'          => 'upload',
                'title'         => 'TTF Font',
                'settings'      => array(
                    // 'upload_type'  => 'image',
                    'button_title' => 'Upload',
                ),
            ),

            array(
                'id'            => 'exopite-local-font-woff',
                'type'          => 'upload',
                'title'         => 'WOFF Font',
                'settings'      => array(
                    // 'upload_type'  => 'image',
                    'button_title' => 'Upload',
                ),
            ),

            array(
                'id'            => 'exopite-local-font-woff2',
                'type'          => 'upload',
                'title'         => 'WOFF2 Font',
                'settings'      => array(
                    // 'upload_type'  => 'image',
                    'button_title' => 'Upload',
                ),
            ),

          ),

        ),

      ),
    ),

    // sub section Menu
    array(
      'name'     => 'menu_typography_sub_section',
      'title'    => esc_attr__( 'Header & Menu', 'exopite' ),
      'icon'     => 'fa fa-minus',
      'fields'   => array(

        array(
          'id'      => 'exopite-sidebar-preheader-font-color',
          'type'    => 'color_picker',
          'title'   => esc_attr__('Preheader font color', 'exopite'),
          'rgba'    => false,
          'default' => '#5C5C5C',
          'dependency' => array( 'exopite-sidebar-preheader-count|exopite-preheader-content_widget', '>|==', '0|true' ),
        ),

        array(
          'id'        => 'menu-font',
          'type'      => 'typography_advanced',
          'title'     => esc_attr__('Menu font', 'exopite'),
          'default'   => array(
            'family'  => 'Roboto',
            'variant' => '300',
            'font'    => 'google',
            'size'    => '18',
            'height'  => '22',
            'color'   => '#5c5c5c'
          ),
          'preview'   => true, //Enable or disable preview box
        ),

        array(
            'id'        => 'exopite-desktop-menu-color',
            'type'      => 'color_picker_menu',
            'title'     => esc_attr__( 'Menu font color', 'exopite' ),
            'default'   =>  array(
                'background' => array(
                    'value' => '#5379BA',
                    'name'  => esc_attr__( 'Background color', 'exopite' ),
                ),
                'background-active-hover' => array(
                    'value' => '#5379BA',
                    'name'  => esc_attr__( 'Background active and hover color', 'exopite' ),
                ),
                'link' => array(
                    'value' => '#ffffff',
                    'name'  => esc_attr__( 'Link color', 'exopite' ),
                ),
                'link-active-hover' => array(
                    'value' => '#FFDD00',
                    'name'  => esc_attr__( 'Link active and hover color', 'exopite' ),
                ),
            ),
        ),

        array(
            'id'        => 'exopite-fixed-menu-color',
            'type'      => 'color_picker_menu',
            'title'     => esc_attr__( 'Fixed menu font color', 'exopite' ),
            'default'   =>  array(
                'background' => array(
                    'value' => 'rgba( 0, 0, 0, 0 )',
                    'name'  => esc_attr__( 'Background color', 'exopite' ),
                ),
                'background-active-hover' => array(
                    'value' => 'rgba( 0, 0, 0, 0 )',
                    'name'  => esc_attr__( 'Background active and hover color', 'exopite' ),
                ),
                'link' => array(
                    'value' => '#777',
                    'name'  => esc_attr__( 'Link color', 'exopite' ),
                ),
                'link-active-hover' => array(
                    'value' => '#888',
                    'name'  => esc_attr__( 'Link active and hover color', 'exopite' ),
                ),
            ),
            'desc'    => esc_attr__( 'Only for desktop menu', 'exopite' ),
            'dependency'  => array( 'exopite-menu-alignment_left', '==', 'false' ),
        ),

        array(
            'id'        => 'exopite-desktop-submenu-color',
            'type'      => 'color_picker_menu',
            'title'     => esc_attr__( 'Submenu font color', 'exopite' ),
            'default'   =>  array(
                'background' => array(
                    'value' => '#5379BA',
                    'name'  => esc_attr__( 'Background color', 'exopite' ),
                ),
                'background-active-hover' => array(
                    'value' => '#5379BA',
                    'name'  => esc_attr__( 'Background active and hover color', 'exopite' ),
                ),
                'link' => array(
                    'value' => '#ffffff',
                    'name'  => esc_attr__( 'Link color', 'exopite' ),
                ),
                'link-active-hover' => array(
                    'value' => '#FFDD00',
                    'name'  => esc_attr__( 'Link active and hover color', 'exopite' ),
                ),
            ),
        ),

        array(
          'id'        => 'exopite-desktop-submenu-font-size',
          'type'      => 'number',
          'title'     => esc_attr__( 'Submenu font size', 'exopite' ),
          'validate'  => 'numeric',
          'default'   => '14',
        ),

        array(
            'id'        => 'exopite-floating-menu-color',
            'type'      => 'color_picker_menu',
            'title'     => esc_attr__( 'Floating menu font color', 'exopite' ),
            'default'   =>  array(
                'background' => array(
                    'value' => '#5379BA',
                    'name'  => esc_attr__( 'Background color', 'exopite' ),
                ),
                'background-active-hover' => array(
                    'value' => '#5379BA',
                    'name'  => esc_attr__( 'Background active and hover color', 'exopite' ),
                ),
                'link' => array(
                    'value' => '#ffffff',
                    'name'  => esc_attr__( 'Link color', 'exopite' ),
                ),
                'link-active-hover' => array(
                    'value' => '#FFDD00',
                    'name'  => esc_attr__( 'Link active and hover color', 'exopite' ),
                ),
            ),
            'dependency'  => array( 'exopite-menu-alignment_left', '==', 'false' ),
        ),

        array(
            'id'        => 'exopite-mobile-menu-color',
            'type'      => 'color_picker_menu',
            'title'     => esc_attr__( 'Mobile menu color', 'exopite' ),
            'default'   =>  array(
                'background' => array(
                    'value' => '#5379BA',
                    'name'  => esc_attr__( 'Background color', 'exopite' ),
                ),
                'background-active-hover' => array(
                    'value' => '#5379BA',
                    'name'  => esc_attr__( 'Background active and hover color', 'exopite' ),
                ),
                'link' => array(
                    'value' => '#ffffff',
                    'name'  => esc_attr__( 'Link color', 'exopite' ),
                ),
                'link-active-hover' => array(
                    'value' => '#FFDD00',
                    'name'  => esc_attr__( 'Link active and hover color', 'exopite' ),
                ),
            ),
            'dependency'  => array( 'exopite-menu-alignment_left', '==', 'false' ),
        ),


      ),
    ),

    // sub section Header
    array(
      'name'     => 'heading_typography_sub_section',
      'title'    => esc_attr__( 'Heading', 'exopite' ),
      'icon'     => 'fa fa-minus',
      'fields'   => array(

        array(
          'id'        => 'exopite-font-h1',
          'type'      => 'typography_advanced',
          'title'     => 'H1',
          'default'   => array(
            'family'  => 'Roboto',
            'variant' => '300',
            'font'    => 'google',
            'size'    => '40',
            'height'  => '44',
            'color'   => '#5c5c5c'
          ),
          'preview'   => true, //Enable or disable preview box
        //   'dependency'  => array( 'exopite-use-google-fonts', '==', 'true' ),
        ),

        array(
          'id'        => 'exopite-font-h2',
          'type'      => 'typography_attribute',
          'title'     => 'H2',
          'default'   => array(
            'size'    => '32',
            'height'  => '36',
            'color'   => '#5c5c5c'
          ),
          'preview'   => true, //Enable or disable preview box
        ),

        array(
          'id'        => 'exopite-font-h3',
          'type'      => 'typography_attribute',
          'title'     => 'H3',
          'default'   => array(
            'size'    => '28',
            'height'  => '32',
            'color'   => '#5c5c5c'
          ),
          'preview'   => true, //Enable or disable preview box
        ),

        array(
          'id'        => 'exopite-font-h4',
          'type'      => 'typography_attribute',
          'title'     => 'H4',
          'default'   => array(
            'size'    => '24',
            'height'  => '26',
            'color'   => '#5c5c5c'
          ),
          'preview'   => true, //Enable or disable preview box
        ),

        array(
          'id'        => 'exopite-font-h5',
          'type'      => 'typography_attribute',
          'title'     => 'H5',
          'default'   => array(
            'size'    => '20',
            'height'  => '22',
            'color'   => '#5c5c5c'
          ),
          'preview'   => true, //Enable or disable preview box
        ),

        array(
          'id'        => 'exopite-font-h6',
          'type'      => 'typography_attribute',
          'title'     => 'H6',
          'default'   => array(
            'size'    => '16',
            'height'  => '18',
            'color'   => '#5c5c5c'
          ),
          'preview'   => true, //Enable or disable preview box
        ),

      ),
    ),

    // sub section Content
    array(
      'name'     => 'content_typography_sub_section',
      'title'    => esc_attr__( 'Content', 'exopite' ),
      'icon'     => 'fa fa-minus',
      'fields'   => array(

        array(
          'id'        => 'exopite-font-content',
          'type'      => 'typography_advanced',
          'title'     => esc_attr__('Content font', 'exopite'),
          'default'   => array(
            'family'  => 'Roboto',
            'variant' => '300',
            'font'    => 'google',
            'size'    => '18',
            'height'  => '28',
            'color'   => '#5c5c5c'
          ),
          'preview'   => true, //Enable or disable preview box
        ),

        array(
          'id'      => 'exopite-font-content-link',
          'type'    => 'color_picker',
          'title'   => esc_attr__('Link color', 'exopite'),
          'rgba'    => false,
          'default' => '#5379BA',
        ),

        array(
          'id'      => 'exopite-font-content-link-hover',
          'type'    => 'color_picker',
          'title'   => esc_attr__('Link hover color', 'exopite'),
          'rgba'    => false,
          'default' => '#5379BA',
        ),

        array(
          'id'      => 'exopite-font-content-alternative',
          'type'    => 'color_picker',
          'title'   => esc_attr__('Secondary color', 'exopite'),
          'rgba'    => false,
          'default' => '#5379BA',
        ),

        array(
          'id'          => 'exopite-font-content-link-underline',
          'type'        => 'switcher',
          'title'       => esc_attr__( 'Link underline', 'exopite' ),
          'default'     => false,
        ),

        array(
          'id'          => 'exopite-font-content-link-hover-underline',
          'type'        => 'switcher',
          'title'       => esc_attr__( 'Link hover underline', 'exopite' ),
          'default'     => false,
        ),

      ),
    ),

    // sub section Footer
    array(
      'name'     => 'footer_typography_sub_section',
      'title'    => esc_attr__( 'Footer & Copyright', 'exopite' ),
      'icon'     => 'fa fa-minus',
      'fields'   => array(

        array(
          'id'        => 'exopite-font-footer',
          'type'      => 'typography_advanced',
          'title'     => 'Footer font',
          'default'   => array(
            'family'  => 'Roboto',
            'variant' => '300',
            'font'    => 'google',
            'size'    => '16',
            'height'  => '24',
            'color'   => '#ddd'
          ),
          'preview'   => true, //Enable or disable preview box
        //   'dependency'  => array( 'exopite-use-google-fonts', '==', 'true' ),
        ),

        array(
          'id'      => 'exopite-font-footer-link',
          'type'    => 'color_picker',
          'title'   => esc_attr__('Link color', 'exopite'),
          'rgba'    => false,
          'default' => '#5379BA',
        ),

        array(
          'id'      => 'exopite-font-footer-link-hover',
          'type'    => 'color_picker',
          'title'   => esc_attr__('Link hover color', 'exopite'),
          'rgba'    => false,
          'default' => '#5379BA',
        ),


        array(
          'id'        => 'exopite-font-copyright',
          'type'      => 'typography_advanced',
          'title'     => 'Copyright font',
          'default'   => array(
            'family'  => 'Roboto',
            'variant' => '300',
            'font'    => 'google',
            'size'    => '14',
            'height'  => '20',
            'color'   => '#888'
          ),
          'preview'   => true, //Enable or disable preview box
        //   'dependency'  => array( 'exopite-use-google-fonts', '==', 'true' ),
        ),

        array(
          'id'      => 'exopite-font-copyright-link',
          'type'    => 'color_picker',
          'title'   => esc_attr__('Link color', 'exopite'),
          'rgba'    => false,
          'default' => '#5379BA',
        ),

        array(
          'id'      => 'exopite-font-copyright-link-hover',
          'type'    => 'color_picker',
          'title'   => esc_attr__('Link hover color', 'exopite'),
          'rgba'    => false,
          'default' => '#5379BA',
        ),

      ),
    ),


  ),

);

// ------------------------------
// blog list                   -
// ------------------------------
$exopite_options[]   = array(
  'name'     => 'blog_list_section',
  'title'    => esc_attr__( 'Blog, Search & Archives', 'exopite' ),
  'icon'     => 'fa fa-files-o',
  'sections' => array(

    // sub section Header
    array(
      'name'     => 'blog_list_sub_section_regular',
      'title'    => esc_attr__( 'Layout & Design', 'exopite' ),
      'icon'     => 'fa fa-minus',
      'fields'   => array(

            array(
              'id'           => 'exopite-blog-layout',
              'type'         => 'image_select',
              'title'        => esc_attr__( 'Blog item layout', 'exopite' ),
              'options'      => array(
                'image-left'    => CS_URI . '/assets/images/img-left.jpg',
                'image-top'     => CS_URI . '/assets/images/img-top.jpg',
                'image-right'   => CS_URI . '/assets/images/img-right.jpg',
                'image-zigzag'  => CS_URI . '/assets/images/img-zigzag.jpg',
                'image-none'    => CS_URI . '/assets/images/content-center.jpg',
              ),
              'radio'        => true,
              'default'      => 'image-left'
            ),

            array(
              'id'           => 'exopite-blog-list-layout',
              'type'         => 'image_select',
              'title'        => esc_attr__( 'Blog list layout', 'exopite' ),
              'options'      => array(
                'blog-list-left-sidebar'    => CS_URI . '/assets/images/blog-left.jpg',
                'blog-list-without-sidebar' => CS_URI . '/assets/images/blog-none.jpg',
                'blog-list-right-sidebar'   => CS_URI . '/assets/images/blog-right.jpg',
              ),
              'radio'        => true,
              'default'      => 'blog-list-right-sidebar'
            ),

            array(
              'id'             => 'exopite-blog-list-thumbnail-size-medium',
              'type'           => 'select',
              'class'          => 'chosen',
              'title'          => esc_attr__( 'Select multi-row thumbnail size', 'exopite' ),
              'options'        => exopite_get_image_sizes(),
              //'default'        => 5,
              'default'        => exopite_get_image_sizes( 'blog-list-multiple' ),
              'attributes' => array(
                'style' => 'width: 260px'
              ),
            ),

            array(
              'id'             => 'exopite-blog-list-thumbnail-size-large',
              'type'           => 'select',
              'title'          => esc_attr__( 'Select single-row thumbnail size', 'exopite' ),
              'options'        => exopite_get_image_sizes(),
              //'default'        => 4,
              'default'        => exopite_get_image_sizes( 'blog-list-full' ),
              'class'          => 'chosen',
              'attributes'     => array(
                'style' => 'width: 260px'
              ),
            ),

            array(
              'id'       => 'exopite-image-hover-effect',
              'type'     => 'select',
              'title'    => esc_attr__( 'Image hover effect', 'exopite' ),
              'options'  => array(
                'none'      => 'None',
                'apollo'    => 'Apollo',
                'lexi'      => 'Lexi',
                'goliath'   => 'Goliath',
                'julia'     => 'Julia',
                'steve'     => 'Steve',
                'ming'      => 'Ming',
                'duke'      => 'Duke',
              ),
              'default'  => 'apollo',
              'class'    => 'chosen',
              'attributes' => array(
                'style' => 'width: 260px'
              ),
            ),

            array(
              'id'             => 'exopite-blog-sidebar-id',
              'type'           => 'select',
              'class'          => 'chosen',
              'title'          => esc_attr__('Select Blog Sidebar', 'exopite' ),
              'options'        => get_sidebars(),
              'attributes' => array(
                'style' => 'width: 260px'
              ),
            ),

            array(
              'id'        => 'exopite-blog-post-content-lenght',
              'type'      => 'image_select',
              'title'     => esc_attr__( 'Blog item content length', 'exopite' ),
              'options'   => array(
                'full'      => CS_URI . '/assets/images/content-center.jpg',
                'excerpt'   => CS_URI . '/assets/images/except.jpg',
                'none'      => CS_URI . '/assets/images/img-center.jpg',
              ),
              'radio'     => true,
              'default'   => 'excerpt'
            ),
/*
            array(
              'id'      => 'exopite-infiniteload-add-page-number',
              'type'    => 'switcher',
              'title'   => esc_attr__( 'Add number between pages', 'exopite' ),
              'default' => true,
              'dependency'  => array( 'exopite-infiniteload-pagination-type|exopite-ajax-load', 'any|==', 'more,infinite|true' ),
              'label'   => '<i style="font-size: 0.8em;"><strong>' . esc_attr__('Note:', 'exopite') . '</strong> ' . esc_attr__('If you turn this on, mansory will disabled. You can use column layout intead.', 'exopite') . '</i>',
            ),
*/
            array(
              'id'      => 'exopite-blog-display-title',
              'type'    => 'switcher',
              'title'   => esc_attr__( 'Display blog title', 'exopite' ),
              'default' => true,
              'label'   => '',
            ),

            array(
              'id'          => 'exopite-blog-title',
              'type'        => 'text',
              'title'       => esc_attr__( 'Blog title', 'exopite' ),
              'default'     => esc_attr__( 'Blog', 'exopite' ),
              'dependency'  => array( 'exopite-blog-display-title', '==', 'true' ),
            ),

            array(
              'id'      => 'exopite-blog-display-breadcrumbs',
              'type'    => 'switcher',
              'title'   => esc_attr__( 'Display breadcrumb', 'exopite' ),
              'default' => true,
              'label'   => '<i style="font-size: 0.8em;"><strong>' . esc_attr__('Note:', 'exopite') . '</strong> ' . sprintf( esc_attr__('You can display the breadcrumbs everywhere via %1$s shortcode.', 'exopite'), '</i><code style="font-size: 0.8em;">[exopite-breadcrumbs]</code><i style="font-size: 0.8em;">' ) . '</i>',
            ),

            array(
              'id'      => 'exopite-blog-first-full',
              'type'    => 'switcher',
              'title'   => esc_attr__( 'Display first post in full width', 'exopite' ),
              'default' => true,
            ),

            array(
              'id'      => 'exopite-blog-display-thumbnail',
              'type'    => 'switcher',
              'title'   => esc_attr__( 'Display post thumbnail', 'exopite' ),
              'default' => true,
              'label'   => '',
            ),

            array(
              'id'      => 'exopite-blog-display-post-title',
              'type'    => 'switcher',
              'title'   => esc_attr__( 'Display post title', 'exopite' ),
              'default' => true,
              'label'   => '',
            ),

            array(
              'id'      => 'exopite-blog-display-tags_categories',
              'type'    => 'switcher',
              'title'   => esc_attr__( 'Display post categories and tags', 'exopite' ),
              'default' => true,
              'label'   => '',
            ),

            array(
              'id'      => 'exopite-blog-display-post-meta',
              'type'    => 'switcher',
              'title'   => esc_attr__( 'Display post meta', 'exopite' ),
              'default' => true,
              'label'   => '',
            ),

            array(
              'id'          => 'exopite-custom-excerpt-more-enabled',
              'type'        => 'switcher',
              'title'       => esc_attr__( 'Custom excerpt more', 'exopite' ),
              'default'     => false,
            ),

            array(
              'id'         => 'exopite-custom-excerpt-more',
              'type'       => 'textarea',
              'title'      => 'Custom excerpt more',
              'dependency' => array( 'exopite-custom-excerpt-more-enabled', '==', 'true' ),
            ),

            array(
                'id'        => 'exopite-blog-except-length',
                'type'      => 'slider',
                'title'     => esc_attr__( 'Excerpt length', 'exopite' ),
                'validate'  => 'numeric',
                'default'   => 55,
                'options'   => array(
                    'step'    => 1,
                    'min'     => 1,
                    'max'     => 100,
                    'unit'    => ''
                )
            ),

            array(
                'id'        => 'exopite-blog-top-padding',
                'type'      => 'slider',
                'title'     => esc_attr__( 'Top padding for blog, search and archives', 'exopite' ),
                'validate'  => 'numeric',
                'default'   => 20,
                'options'   => array(
                    'step'    => 1,
                    'min'     => 0,
                    'max'     => 50,
                    'unit'    => ''
                )
            ),

            array(
                'id'        => 'exopite-blog-post-per-row',
                'type'      => 'slider',
                'title'     => esc_attr__( 'Posts per row', 'exopite' ),
                'validate'  => 'numeric',
                'options'   => array(
                    'step'    => 1,
                    'min'     => 1,
                    'max'     => 4,
                    'unit'    => ''
                ),
                'default'   => 1,
            ),

            array(
              'id'         => 'exopite-blog-multi-column-layout-type',
              'type'       => 'image_select',
              'title'      => esc_attr__( 'Multi-column layout type', 'exopite' ),
              'options'    => array(
                'normal'      => CS_URI . '/assets/images/layout-regular.jpg',
                'masonry'     => CS_URI . '/assets/images/layout-masonry.jpg',
                'column'      => CS_URI . '/assets/images/layout-column.jpg',
              ),
              'radio'      => true,
              'default'    => 'normal',
              'dependency' => array( 'exopite-blog-post-per-row', '>', '1' ),
            ),

            array(
              'id'      => 'exopite-blog-same-height',
              'type'    => 'switcher',
              'title'   => esc_attr__( 'Items same height', 'exopite' ),
              'default' => false,
              'label'   => '',
              'dependency'  => array( 'exopite-blog-post-per-row|exopite-blog-multi-column-layout-type_normal', '>|==', '1|true' ),
            ),

            array(
              'id'      => 'exopite-blog-no-gap',
              'type'    => 'switcher',
              'title'   => esc_attr__( 'No gap between posts', 'exopite' ),
              'default' => false,
              'label'   => esc_attr__( 'Only effect multiple post in one row', 'exopite' ),
              'dependency'  => array( 'exopite-blog-post-per-row', '>', '1' ),
            ),
      ),
    ),


    // sub section Single post
    array(
      'name'     => 'blog_list_single_post_sub_section',
      'title'    => esc_attr__( 'Single post', 'exopite' ),
      'icon'     => 'fa fa-minus',
      'fields'   => array(

        array(
          'id'      => 'exopite-single-display-breadcumbs',
          'type'    => 'switcher',
          'title'   => esc_attr__( 'Display breadcumbs', 'exopite' ),
          'default' => true,
          'label'   => '<i style="font-size: 0.8em;"><strong>' . esc_attr__('Note:', 'exopite') . '</strong> ' . sprintf( esc_attr__('You can display the breadcrumbs everywhere via %1$s shortcode.', 'exopite'), '</i><code style="font-size: 0.8em;">[exopite-breadcrumbs]</code><i style="font-size: 0.8em;">' ) . '</i>',
        ),

        array(
          'id'      => 'exopite-single-display-post-navigation',
          'type'    => 'switcher',
          'title'   => esc_attr__( 'Display post navigation', 'exopite' ),
          'default' => true,
          'label'   => '',
        ),

        array(
          'id'          => 'exopite-single-navigation-same-term',
          'type'        => 'switcher',
          'title'       => esc_attr__( 'Navigation in same term', 'exopite' ),
          'default'     => true,
          'label'       => '',
          'dependency'  => array( 'exopite-single-display-post-navigation', '==', 'true' ),
        ),

        array(
          'id'          => 'exopite-single-navigation-inifnite',
          'type'        => 'switcher',
          'title'       => esc_attr__( 'Infinite navigation', 'exopite' ),
          'default'     => true,
          'label'       => '',
          'dependency'  => array( 'exopite-single-display-post-navigation', '==', 'true' ),
        ),

        array(
          'id'      => 'exopite-single-display-author-bio',
          'type'    => 'switcher',
          'title'   => esc_attr__( 'Display author bio', 'exopite' ),
          'default' => true,
          'label'   => '',
        ),

        array(
          'id'      => 'exopite-single-display-post-tags_categories',
          'type'    => 'switcher',
          'title'   => esc_attr__( 'Display categories and tags', 'exopite' ),
          'default' => true,
          'label'   => '',
        ),

        array(
          'id'      => 'exopite-single-display-post-meta',
          'type'    => 'switcher',
          'title'   => esc_attr__( 'Display meta', 'exopite' ),
          'default' => true,
          'label'   => '',
        ),

        array(
          'id'             => 'exopite-single-display-releated',
          'type'           => 'sorter',
          'title'          => esc_attr__( 'Display releated on', 'exopite' ),
          'default'        => array(
            'enabled'      => array(
              //'page'        => esc_attr__( 'Pages', 'exopite' ),
              'post'        => esc_attr__( 'Posts', 'exopite' ),
            ),
            'disabled'     => array(
            ),
          ),
        ),

        array(
            'id'        => 'exopite-single-releated-posts-categories-amount',
            'type'      => 'slider',
            'title'     => esc_attr__( 'Releated posts by categories', 'exopite' ),
            'validate'  => 'numeric',
            'default'   => 3,
            'options'   => array(
                'step'    => 1,
                'min'     => 0,
                'max'     => 4,
                'unit'    => ''
            )
        ),

        array(
            'id'        => 'exopite-single-releated-posts-categories-per-row',
            'type'      => 'slider',
            'title'     => esc_attr__( 'Releated posts by categories in one row', 'exopite' ),
            'validate'  => 'numeric',
            'default'   => 3,
            'options'   => array(
                'step'    => 1,
                'min'     => 0,
                'max'     => 4,
                'unit'    => ''
            )
        ),

        array(
            'id'        => 'exopite-single-releated-posts-tags-amount',
            'type'      => 'slider',
            'title'     => esc_attr__( 'Releated posts by tags', 'exopite' ),
            'validate'  => 'numeric',
            'default'   => 0,
            'options'   => array(
                'step'    => 1,
                'min'     => 0,
                'max'     => 4,
                'unit'    => ''
            )
        ),

        array(
            'id'        => 'exopite-single-releated-posts-tags-per-row',
            'type'      => 'slider',
            'title'     => esc_attr__( 'Releated posts by tags in one row', 'exopite' ),
            'validate'  => 'numeric',
            'default'   => 0,
            'options'   => array(
                'step'    => 1,
                'min'     => 0,
                'max'     => 4,
                'unit'    => ''
            )
        ),


      ),

    ),

    // sub section Meta tags
    array(
      'name'     => 'blog_list_meta_tags_sub_section',
      'title'    => esc_attr__( 'Meta tags', 'exopite' ),
      'icon'     => 'fa fa-minus',
      'fields'   => array(

        array(
          'id'             => 'exopite-single-meta-tags-to-display',
          'type'           => 'sorter',
          'title'          => esc_attr__( 'Meta tags to display on blog and single post', 'exopite' ),
          'default'        => array(
            'enabled'      => array(
              'author'        => esc_attr__( 'Author', 'exopite' ),
              'date'          => esc_attr__( 'Date', 'exopite' ),
              'commentcount'  => esc_attr__( 'Comment count', 'exopite' ),
              'lastmodified'  => esc_attr__( 'Last modified', 'exopite' ),
              //'badge'         => esc_attr__( 'Badge', 'exopite' ),
              'categories'    => esc_attr__( 'Categories', 'exopite' ),
              'tags'          => esc_attr__( 'Tags', 'exopite' ),
            ),
            'disabled'     => array(
            ),
          ),
          'dependency'  => array( 'exopite-single-display-post-meta', '==', 'true' ),
        ),

      ),

    ),

    // sub section Custom pages
    array(
      'name'     => 'blog_list_sub_section_custom_pages',
      'title'    => esc_attr__( 'Custom pages', 'exopite' ),
      'icon'     => 'fa fa-minus',
      'fields'   => array(

        array(
          'type'    => 'notice',
          'class'   => 'info',
          'content' => esc_attr__( 'After set the page, just add [exopite-loop] shortcode in the selected page content, where you want to display the loop. It will take care of the rest.', 'exopite' ),
        ),

        // Categories
        array(
          'id'          => 'exopite-archive-page-category',
          'type'        => 'switcher',
          'title'       => esc_attr__( 'Category archive as page', 'exopite' ),
          'default'     => false,
        ),

        array(
          'id'      => 'exopite-archive-page-category-id',
          'type'    => 'select',
          'title'   => esc_attr__( 'Page ID for category archive', 'exopite' ),
          'options' => 'posts',
          'class'   => 'chosen',
          'query_args'  => array(
            'post_type' => 'page',  // Your post_type name
            'orderby'   => 'title',
            'order'     => 'ASC',
            'posts_per_page' => -1,
          ),
          'attributes' => array(
            'data-placeholder' => esc_attr__( 'Page(s)', 'exopite' ),
            'style' => 'width: 320px',
          ),
          'dependency'  => array( 'exopite-archive-page-category', '==', 'true' ),
        ),

        // Tags
        array(
          'id'          => 'exopite-archive-page-tag',
          'type'        => 'switcher',
          'title'       => esc_attr__( 'Tag archive as page', 'exopite' ),
          'default'     => false,
        ),

        array(
          'id'      => 'exopite-archive-page-tag-id',
          'type'    => 'select',
          'title'   => esc_attr__( 'Page ID for tag archive', 'exopite' ),
          'options' => 'posts',
          'class'   => 'chosen',
          'query_args'  => array(
            'post_type' => 'page',  // Your post_type name
            'orderby'   => 'title',
            'order'     => 'ASC',
            'posts_per_page' => -1,
          ),
          'attributes' => array(
            'data-placeholder' => esc_attr__( 'Page(s)', 'exopite' ),
            'style' => 'width: 320px',
          ),
          'dependency'  => array( 'exopite-archive-page-tag', '==', 'true' ),
        ),

        // Author
        array(
          'id'          => 'exopite-archive-page-author',
          'type'        => 'switcher',
          'title'       => esc_attr__( 'Author archive as page', 'exopite' ),
          'default'     => false,
        ),

        array(
          'id'      => 'exopite-archive-page-author-id',
          'type'    => 'select',
          'title'   => esc_attr__( 'Page ID for author archive', 'exopite' ),
          'options' => 'posts',
          'class'   => 'chosen',
          'query_args'  => array(
            'post_type' => 'page',  // Your post_type name
            'orderby'   => 'title',
            'order'     => 'ASC',
            'posts_per_page' => -1,
          ),
          'attributes' => array(
            'data-placeholder' => esc_attr__( 'Page(s)', 'exopite' ),
            'style' => 'width: 320px',
          ),
          'dependency'  => array( 'exopite-archive-page-author', '==', 'true' ),
        ),

        // Daily
        array(
          'id'          => 'exopite-archive-page-daily',
          'type'        => 'switcher',
          'title'       => esc_attr__( 'Daily archive as page', 'exopite' ),
          'default'     => false,
        ),

        array(
          'id'      => 'exopite-archive-page-daily-id',
          'type'    => 'select',
          'title'   => esc_attr__( 'Page ID for daily archive', 'exopite' ),
          'options' => 'posts',
          'class'   => 'chosen',
          'query_args'  => array(
            'post_type' => 'page',  // Your post_type name
            'orderby'   => 'title',
            'order'     => 'ASC',
            'posts_per_page' => -1,
          ),
          'attributes' => array(
            'data-placeholder' => esc_attr__( 'Page(s)', 'exopite' ),
            'style' => 'width: 320px',
          ),
          'dependency'  => array( 'exopite-archive-page-daily', '==', 'true' ),
        ),

        // Monthly
        array(
          'id'          => 'exopite-archive-page-monthly',
          'type'        => 'switcher',
          'title'       => esc_attr__( 'Monthly archive as page', 'exopite' ),
          'default'     => false,
        ),

        array(
          'id'      => 'exopite-archive-page-monthly-id',
          'type'    => 'select',
          'title'   => esc_attr__( 'Page ID for monthly archive', 'exopite' ),
          'options' => 'posts',
          'class'   => 'chosen',
          'query_args'  => array(
            'post_type' => 'page',  // Your post_type name
            'orderby'   => 'title',
            'order'     => 'ASC',
            'posts_per_page' => -1,
          ),
          'attributes' => array(
            'data-placeholder' => esc_attr__( 'Page(s)', 'exopite' ),
            'style' => 'width: 320px',
          ),
          'dependency'  => array( 'exopite-archive-page-monthly', '==', 'true' ),
        ),

        // Yearly
        array(
          'id'          => 'exopite-archive-page-yearly',
          'type'        => 'switcher',
          'title'       => esc_attr__( 'Yearly archive as page', 'exopite' ),
          'default'     => false,
        ),

        array(
          'id'      => 'exopite-archive-page-yearly-id',
          'type'    => 'select',
          'title'   => esc_attr__( 'Page ID for yearly archive', 'exopite' ),
          'options' => 'posts',
          'class'   => 'chosen',
          'query_args'  => array(
            'post_type' => 'page',  // Your post_type name
            'orderby'   => 'title',
            'order'     => 'ASC',
            'posts_per_page' => -1,
          ),
          'attributes' => array(
            'data-placeholder' => esc_attr__( 'Page(s)', 'exopite' ),
            'style' => 'width: 320px',
          ),
          'dependency'  => array( 'exopite-archive-page-yearly', '==', 'true' ),
        ),

        // Yearly
        array(
          'id'          => 'exopite-archive-page-other',
          'type'        => 'switcher',
          'title'       => esc_attr__( 'Every othen archive as page', 'exopite' ),
          'default'     => false,
        ),

        array(
          'id'      => 'exopite-archive-page-other-id',
          'type'    => 'select',
          'title'   => esc_attr__( 'Page ID for every other archive', 'exopite' ),
          'options' => 'posts',
          'class'   => 'chosen',
          'query_args'  => array(
            'post_type' => 'page',  // Your post_type name
            'orderby'   => 'title',
            'order'     => 'ASC',
            'posts_per_page' => -1,
          ),
          'attributes' => array(
            'data-placeholder' => esc_attr__( 'Page(s)', 'exopite' ),
            'style' => 'width: 320px',
          ),
          'dependency'  => array( 'exopite-archive-page-other', '==', 'true' ),
        ),


      ),
    ),


  ),

);

// ------------------------------
// media                        -
// ------------------------------
$exopite_options[]   = array(
  'id'       => 'media_section',
  'name'     => 'media_section',
  'title'    => esc_attr__( 'Media', 'exopite' ),
  'icon'     => 'fa fa-picture-o',
  'fields'   => array(

    array(
      'id'          => 'exopite-remove-emojicons',
      'type'        => 'switcher',
      'title'       => esc_attr__( 'Remove emojicons', 'exopite' ),
      'default'     => false,
    ),

    array(
      'id'          => 'exopite-disable-media-comments',
      'type'        => 'switcher',
      'title'       => esc_attr__( 'Disable Comments on Media Attachments', 'exopite' ),
      'default'     => true,
    ),

    array(
      'id'          => 'exopite-enable-xgallerify',
      'type'        => 'switcher',
      'title'       => esc_attr__( 'Enable WordPress xGallerify', 'exopite' ),
      'default'     => true,
      'desc'        => esc_attr__( 'More info', 'exopite' ) . ': <a href="https://github.com/JohnnyTheTank/angular-xGallerify" target="_blank">xGallerify GitHub</a>.',
      'after'       => ' <i class="cs-text-muted">' . esc_html__( 'You can override WordPress gallery olumn settings an make it responsive if you add to the gallery shortcode', 'exopite' ) . ':<br> <code>[gallery ... data-mode="bootstrapv4" ...]</code></i>',
    ),

    array(
      'id'              => 'exopite-thumbnail-sizes',
      'type'            => 'group',
      'title'           => 'Thumbnail sizes',
      'button_title'    => esc_attr__( 'Add new thumbnail size', 'exopite' ),
      'accordion_title' => esc_attr__( 'Add new thumbnail size', 'exopite' ),
      'desc'            => '<p style="color:#E52745;">' . sprintf( esc_attr__( 'After creating new thumbnail or modify an old one, you have to regenerate the thumbnail for old images and refresh page.%1$sYou can use a plugin like', 'exopite' ), '</p>' ) . '<br><a href="https://wordpress.org/plugins/regenerate-thumbnails/" target="_blank">Regenerate Thumbnails</a>.',
      'fields'          => array(

        array(
          'id'          => 'exopite-thumbnail-size-title',
          'type'        => 'text',
          'title'       => esc_attr__( 'Size name', 'exopite' ),
        ),

        array(
          'id'          => 'exopite-thumbnail-size-dimention',
          'type'        => 'dimention',
          'title'       => esc_attr__( 'Dimensions', 'exopite' ),
        ),

        array(
          'id'          => 'exopite-thumbnail-size-crop',
          'type'        => 'switcher',
          'title'       => esc_attr__( 'Crop', 'exopite' ),
          'default'     => true,
        ),

      ),

    ),

  )
);

// ------------------------------
// sidebars                     -
// ------------------------------
$exopite_options[]   = array(
  'name'     => 'sidebar_section',
  'title'    => esc_attr__( 'Sidebars', 'exopite' ),
  'icon'     => 'fa fa-th-list',
  'fields'   => array(

    array(
      'id'              => 'exopite-sidebars',
      'type'            => 'group',
      'title'           => esc_attr__( 'Sidebars', 'exopite' ),
      'desc'            => sprintf( esc_attr__( 'Go to Appearance -> %1$sWidgets%2$s to add widgets to sidebar.', 'exopite' ), '<a href="widgets.php">', '</a>' ),
      'button_title'    => esc_attr__( 'Add new sidebar', 'exopite' ),
      'accordion_title' => esc_attr__( 'Adding new sidebar', 'exopite' ),
      'fields'          => array(

        array(
          'id'          => 'exopite-sidebar-name',
          'type'        => 'text',
          'title'       => esc_attr__( 'Sidebar name', 'exopite' ),
        ),

        array(
          'id'          => 'exopite-sidebar-description',
          'type'        => 'text',
          'title'       => esc_attr__( 'Description', 'exopite' ),
        ),

      )
    ),

  )
);

// ------------------------------
// extensions                   -
// ------------------------------
$exopite_options[]   = array(
  'name'     => 'extensions_section',
  'title'    => esc_attr__( 'Extensions', 'exopite' ),
  'icon'     => 'fa fa-puzzle-piece',
  'fields'   => array(

    array(
      'id'      => 'exopite-page-display-breadcrumbs',
      'type'    => 'switcher',
      'title'   => esc_attr__( 'Display breadcrumbs on pages', 'exopite' ),
      'default' => true,
      'label'   => '<i><strong>' . esc_attr__('Note:', 'exopite') . '</strong> ' . sprintf( esc_attr__('You can display the breadcrumbs everywhere via %1$s shortcode.', 'exopite'), '</i><code>[exopite-breadcrumbs]</code><i>' ) . '</i>',
    ),

    array(
      'id'      => 'exopite-enable-category-sticky',
      'type'    => 'switcher',
      'title'   => esc_attr__( 'Sticky post by category', 'exopite' ),
      'default' => true,
      'label'   => esc_attr__( 'Display options on posts to mark it as sticky by category.', 'exopite' ),
    ),

/*
    array(
      'id'      => 'exopite-enable-duplicate-pages-posts',
      'type'    => 'switcher',
      'title'   => esc_attr__( 'Duplicate posts and pages', 'exopite' ),
      'default' => true,
      'label'   => 'Display options to duplicate posts and pages.',
    ),
*/
/*
    array(
      'id'      => 'exopite-ajax-load',
      'type'    => 'switcher',
      'title'   => esc_attr__( 'Ajax load', 'exopite' ),
      'default' => true,
    ),
*/
    array(
      'id'      => 'exopite-display-shortcode-list',
      'type'    => 'switcher',
      'title'   => esc_attr__( 'Display shortcode list', 'exopite' ),
      'default' => true,
      'label'   => '',
    ),

    array(
      'id'      => 'exopite-shortcodes',
      'type'    => 'shortcodes',
      'title'   => esc_attr__( 'Available shortcodes', 'exopite' ),
      'default' => true,
      'label'   => esc_attr__( 'All of the available shortcodes that you can use on your WordPress blog.', 'exopite' ),
      'dependency'  => array( 'exopite-display-shortcode-list', '==', 'true' ),
    ),

  )
);

// ------------------------------
// seo                          -
// ------------------------------
$exopite_options[]   = array(
  'name'     => 'seo_section',
  'title'    => esc_attr__( 'SEO', 'exopite' ),
  'icon'     => 'fa fa-search',
  'fields'   => array(

    array(
      'type'    => 'notice',
      'class'   => 'info',
      'content' => esc_attr__( 'We recommend to use ', 'exopite' ) . ' <a href="https://wordpress.org/plugins/wordpress-seo/" target="_blank">Yoast SEO</a>.',
    ),

    array(
      'id'      => 'exopite-seo-gzip-enabled',
      'type'    => 'switcher',
      'title'   => esc_attr__( 'Enable GZip compression', 'exopite' ),
      'default' => true,
      'label'   => '',
    ),

    array(
      'id'      => 'exopite-noidex-archives-enabled',
      'type'    => 'switcher',
      'title'   => esc_attr__( 'No index archive and search pages', 'exopite' ),
      'default' => true,
      'label'   => '',
    ),

    array(
      'id'      => 'exopite-minify-html',
      'type'    => 'switcher',
      'title'   => esc_attr__( 'Minify HTML', 'exopite' ),
      'default' => true,
      'label'   => '',
    ),

    array(
      'id'      => 'exopite-seo-mark-external-links',
      'type'    => 'switcher',
      'title'   => esc_attr__( 'Mark external links', 'exopite' ),
      'default' => false,
      'label'   => '',
    ),

    array(
      'id'      => 'exopite-seo-use_cdns',
      'type'    => 'switcher',
      'title'   => esc_attr__( 'Use CDNs', 'exopite' ),
      'after'   => ' <i class="cs-text-muted">' . esc_html__( 'Maybe faster but not GDPR compliant. Save options take longer! Be patient.', 'exopite' ) . '</i>',
      'default' => false,
      'label'   => '',
    ),

    // array(
    //   'id'     => 'exopite-js-analytics',
    //   'type'   => 'textarea',
    //   'attributes' => array(
    //     'rows'     => 8,
    //   ),
    //   'before' => '<div class="cs-title"><h4 style="padding-bottom: 20px;">' . esc_attr__( 'Add your Google Analytics code here', 'exopite' ) . '</h4></div>',
    //   'after' => '<b><i class="cs-text-muted">' . esc_html__( 'without the &lt;srcipt&gt; tag', 'exopite' ) . '</i></b>',
    // ),

    array(
      'id'     => 'exopite-js-analytics',
      'type'   => 'aceeditor',
      'attributes'  => array(
        'data-theme'    => 'chrome',
        'data-mode'     => 'javascript',
      ),
      'before' => '<div class="cs-title"><h4 style="padding-bottom: 20px;">' . esc_attr__( 'Add your Google Analytics code here', 'exopite' ) . '</h4></div>',
      'after' => '<b><i class="cs-text-muted">' . esc_html__( 'without the &lt;srcipt&gt; tag', 'exopite' ) . '</i></b>',
    ),

  )
);

// ----------------------------------------
// Security                               -
// ----------------------------------------
$exopite_options[]      = array(
  'name'        => 'security',
  'title'       => esc_attr__( 'Security', 'exopite' ),
  'icon'        => 'fa fa-shield',

  // begin: fields
  'fields'      => array(

    array(
      'type'    => 'notice',
      'class'   => 'danger',
      'content' => 'NO WARRANTY OF ANY KIND! USE THIS SOFTWARES AND INFORMATIONS AT YOUR OWN RISK! <a href="https://www.joeszalai.org/disclamer_pre.txt" target="_blank">READ DISCLAMER</a>, <a href="http://www.gnu.org/licenses/gpl-2.0.html" target="_blank">License: GNU General Public License v2</a>',
    ),

    array(
      'type'    => 'notice',
      'class'   => 'info',
      'content' => esc_attr__( 'You can turn on/off build in security features here. We recommend to turn off and use ', 'exopite' ) . ' <a href="https://wordpress.org/plugins/wordfence/" target="_blank">Wordfence Security</a>.',
      'dependency'  => array( 'exopite-security-enabled', '==', 'true' ),
    ),

    array(
      'id'      => 'exopite-security-enabled',
      'type'    => 'switcher',
      'title'   => esc_attr__( 'Enable security featuers.', 'exopite' ),
      'default' => true,
      'label'   => esc_attr__( "Check out Offensive Security's Exploit Database Archive. ", 'exopite' ) . '<a href="https://www.exploit-db.com/search/?action=search&q=wordpress" target="_blank">' . esc_attr__( 'More...', 'exopite' ) . '</a>',
    ),

    array(
      'id'      => 'security_check_switch',
      'type'    => 'switcher',
      'title'   => esc_attr__( 'Enable quick security check', 'exopite' ),
      'default' => true,
      'label'   => '',
      'dependency'  => array( 'exopite-security-enabled', '==', 'true' ),
    ),

    array(
      'id'          => 'security_check',
      'type'        => 'security',
      'title'       => esc_attr__( 'Quick security check', 'exopite' ),
      'dependency'  => array( 'security_check_switch|exopite-security-enabled', '==|==', 'true|true' ),
    ),

    array(
      'id'      => 'exopite-security-limit-login-attempts',
      'type'    => 'switcher',
      'title'   => esc_attr__( 'Limit login attempts', 'exopite' ),
      'default' => true,
      'label'   => esc_attr__( 'Limit login attempts for protect site from brute force attacks.', 'exopite' ) . ' <a href="http://www.wpbeginner.com/plugins/how-and-why-you-should-limit-login-attempts-in-your-wordpress/" target="_blank">' . esc_attr__( 'More...', 'exopite' ) . '</a>',
      'dependency'  => array( 'exopite-security-enabled', '==', 'true' ),
    ),

    array(
      'id'          => 'exopite-security-lockout-threshold',
      'type'        => 'number',
      'title'       => esc_attr__( 'Lockout threshold', 'exopite' ),
      'default'     => 10,
      'after'       => ' <span class="cs-text-desc">' . esc_attr__( 'After a number of failed sign-in attempts, user ip will be blocked.', 'exopite' ) . '</span>',
      'dependency'  => array( 'exopite-security-enabled|exopite-security-limit-login-attempts', '==|==', 'true|true' ),
    ),

    array(
      'id'          => 'exopite-security-lockout-duration',
      'type'        => 'number',
      'title'       => esc_attr__( 'Lockout duration', 'exopite' ),
      'default'     => 600,
      'after'       => ' <i class="cs-text-muted">(sec)</i> <span class="cs-text-desc">' . esc_attr__( 'Number of seconds that account remains locked out.', 'exopite' ) . '</span>',
      'dependency'  => array( 'exopite-security-enabled|exopite-security-limit-login-attempts', '==|==', 'true|true' ),
    ),

    array(
      'id'      => 'exopite-security-turn-off-login-errors',
      'type'    => 'switcher',
      'title'   => esc_attr__( 'Do not display login error details', 'exopite' ),
      'default' => true,
      'label'   => esc_attr__( 'Login error messages can be used to guess a username and/or password', 'exopite' ) . ' <a href="http://www.wpbeginner.com/wp-tutorials/how-to-disable-login-hints-in-wordpress-login-error-messages/" target="_blank">' . esc_attr__( 'More...', 'exopite' ) . '</a>',
      'dependency'  => array( 'exopite-security-enabled', '==', 'true' ),
    ),

    array(
      'id'      => 'exopite-security-disable-file-editor-in-admin',
      'type'    => 'switcher',
      'title'   => esc_attr__( 'Disable the plugin and theme file editors', 'exopite' ),
      'default' => true,
      'label'   => esc_attr__( 'Protect the site from tinkering', 'exopite' ) . ' <a href="https://codex.wordpress.org/Hardening_WordPress" target="_blank">' . esc_attr__( 'More...', 'exopite' ) . '</a>',
      'dependency'  => array( 'exopite-security-enabled', '==', 'true' ),
    ),

    array(
      'id'      => 'exopite-security-stop-user-enumeration',
      'type'    => 'switcher',
      'title'   => esc_attr__( 'Stop user enumeration', 'exopite' ),
      'default' => true,
      'label'   => esc_attr__( 'User Enumeration is a hacking method to get your username', 'exopite' ) . ' <a href="http://www.acunetix.com/blog/articles/wordpress-username-enumeration-using-http-fuzzer/" target="_blank">' . esc_attr__( 'More...', 'exopite' ) . '</a>',
      'dependency'  => array( 'exopite-security-enabled', '==', 'true' ),
    ),

    array(
      'id'      => 'exopite-security-disable-xmlrpc',
      'type'    => 'switcher',
      'title'   => esc_attr__( 'Disable xmlrpc', 'exopite' ),
      'default' => true,
      'label'   => esc_attr__( 'Prevent XML-RPC brute force, guessing authentication and DDoS attacks.', 'exopite' ) . ' <a href="https://www.wordfence.com/blog/2015/10/should-you-disable-xml-rpc-on-wordpress/" target="_blank">' . esc_attr__( 'More...', 'exopite' ) . '</a>',
      'dependency'  => array( 'exopite-security-enabled', '==', 'true' ),
    ),


    array(
      'id'      => 'exopite-security-disable-rest-api',
      'type'    => 'switcher',
      'title'   => esc_attr__( 'Disable JSON Rest API', 'exopite' ),
      'default' => false,
      'label'   => esc_attr__( 'For WordPress 4.7+ only. Return 405 error code with <code>"REST-API services are disabled on this site."</code>.', 'exopite' ),
      'dependency'  => array( 'exopite-security-enabled', '==', 'true' ),
    ),

    array(
      'id'      => 'exopite-security-rest-api-only-authenticated',
      'type'    => 'switcher',
      'title'   => esc_attr__( 'Limit JSON Rest API for authenticated users only', 'exopite' ),
      'default' => false,
      'label'   => esc_attr__( 'For WordPress versions 4.4 - 4.6, makes use of the rest_enabled filter provided by the API to disable the API functionality. For WordPress 4.7+, the plugin will return an authentication error for any user not logged into the website.', 'exopite' ) . ' <a href="https://wordpress.org/plugins/disable-json-api/" target="_blank">' . esc_attr__( 'More...', 'exopite' ) . '</a>',
      'dependency'  => array( 'exopite-security-enabled|exopite-security-disable-rest-api', '==|==', 'true|false' ),
    ),

    array(
      'id'      => 'exopite-security-prevent-script-injection',
      'type'    => 'switcher',
      'title'   => esc_attr__( 'Prevent malicious URL requests', 'exopite' ),
      'default' => true,
      'label'   => esc_attr__( 'Prevent attackers to use malicious queries to find and attack.', 'exopite' ) . ' <a href="https://perishablepress.com/block-bad-queries/" target="_blank">' . esc_attr__( 'More...', 'exopite' ) . '</a>',
      'dependency'  => array( 'exopite-security-enabled', '==', 'true' ),
    ),

    array(
      'id'      => 'exopite-security-comment-flood-check-referer',
      'type'    => 'switcher',
      'title'   => esc_attr__( 'Check comment referer', 'exopite' ),
      'default' => true,
      'label'   => esc_attr__( 'Prevent spam comments by checking the page referer.', 'exopite' ) . ' <a href="http://themefuse.com/why-and-how-to-detect-referrer-information-in-wordpress/" target="_blank">' . esc_attr__( 'More...', 'exopite' ) . '</a>',
      'dependency'  => array( 'exopite-security-enabled', '==', 'true' ),
    ),

    array(
      'id'      => 'exopite-security-email-on-failed-login',
      'type'    => 'switcher',
      'title'   => esc_attr__( 'Email alert for failed login attempts.', 'exopite' ),
      'default' => false,
      'dependency'  => array( 'exopite-security-enabled', '==', 'true' ),
    ),

    array(
      'type'    => 'notice',
      'class'   => 'info',
      'content' => esc_attr__( 'Make sure email sending service has been set properly and working on your computer.', 'exopite' ) . is_localhost(),
      'dependency'  => array( 'exopite-security-email-on-failed-login|exopite-security-enabled', '==|==', 'true|true' ),
    ),

    array(
      'id'          => 'exopite-security-email',
      'type'        => 'text',
      'title'       => esc_attr__( 'Email', 'exopite' ),
      'dependency'  => array( 'exopite-security-email-on-failed-login|exopite-security-enabled', '==|==', 'true|true' ),
      'desc'        => esc_attr__( 'If empty, admin email will be used.', 'exopite' ),
    ),

  ), // end: fields
);

// ------------------------------
// seo                          -
// ------------------------------
$exopite_options[]   = array(
  'name'     => 'maintenance_section',
  'title'    => esc_attr__( 'Maintenance', 'exopite' ),
  'icon'     => 'fa fa-exclamation-triangle',
  'fields'   => array(

    array(
      'id'      => 'exopite-activate_maintenance',
      'type'    => 'switcher',
      'title'   => esc_attr__( 'Activate maintenance mode', 'exopite' ),
      'default' => false,
    ),

    array(
      'id'         => 'exopite-maintenance-text', // another unique id
      'type'       => 'wysiwyg',
      'title'      => 'Content',
      'dependency'  => array( 'exopite-activate_maintenance', '==', 'true' ),
    ),

    array(
      'id'           => 'exopite-maintenance-backgorund',
      'type'         => 'background_preview',
      'title'        => esc_attr__( 'Background image and/or color', 'exopite' ),
      'default'      => array(
        'image'      => '',
        'repeat'     => 'no-repeat',
        'position'   => 'center center',
        'attachment' => 'scroll',
        'color'      => '#ffffff',
      ),
      'dependency'  => array( 'exopite-activate_maintenance', '==', 'true' ),
    ),

    array(
      'id'      => 'exopite-maintenance-font-color',
      'type'    => 'color_picker',
      'title'   => esc_attr__('Font color', 'exopite'),
      'rgba'    => true,
      'default' => '#000000',
      'dependency'  => array( 'exopite-activate_maintenance', '==', 'true' ),
    ),

  )
);

if ( ExopiteSettings::getValue( 'woocommerce-activated' ) ) {
// ------------------------------
// seo                          -
// ------------------------------
    $exopite_options[]   = array(
  'name'     => 'woocommerce_section',
  'title'    => esc_attr__( 'WooCommerce', 'exopite' ),
  'icon'     => 'fa fa-shopping-cart',
  'fields'   => array(

    array(
      'id'      => 'exopite-woocommerce-show-cart-in-menu',
      'type'    => 'switcher',
      'title'   => esc_attr__( 'Show cart in menu', 'exopite' ),
      'default' => true,
    ),

    array(
      'id'      => 'exopite-woocommerce-categories-product-shop',
      'type'    => 'switcher',
      'title'   => esc_attr__( 'Add categories to products in shop', 'exopite' ),
      'default' => true,
    ),

    array(
      'id'      => 'exopite-woocommerce-remove-add-to-cart-shop',
      'type'    => 'switcher',
      'title'   => esc_attr__( 'Remove add to cart button from grid', 'exopite' ),
      'default' => false,
    ),

    array(
      'id'      => 'exopite-woocommerce-remove-product-image',
      'type'    => 'switcher',
      'title'   => esc_attr__( 'Remove product image', 'exopite' ),
      'default' => false,
    ),

    array(
      'id'      => 'exopite-woocommerce-remove-ratings',
      'type'    => 'switcher',
      'title'   => esc_attr__( 'Remove ratings', 'exopite' ),
      'default' => false,
    ),

    array(
        'id'        => 'exopite-woocommerce-shop-product-per-row',
        'type'      => 'slider',
        'title'     => esc_attr__( 'Product per row in shop', 'exopite' ),
        'validate'  => 'numeric',
        'default'   => 3,
        'options'   => array(
            'step'    => 1,
            'min'     => 1,
            'max'     => 4,
            'unit'    => ''
        ),
    ),

    array(
        'id'        => 'exopite-woocommerce-shop-product-per-page',
        'type'      => 'slider',
        'title'     => esc_attr__( 'Product per page in shop', 'exopite' ),
        'validate'  => 'numeric',
        'default'   => 9,
        'options'   => array(
            'step'    => 1,
            'min'     => 1,
            'max'     => 24,
            'unit'    => ''
        ),
    ),

    array(
        'id'        => 'exopite-woocommerce-releated-columns',
        'type'      => 'slider',
        'title'     => esc_attr__( 'Releated columns', 'exopite' ),
        'validate'  => 'numeric',
        'default'   => 4,
        'options'   => array(
            'step'    => 1,
            'min'     => 1,
            'max'     => 4,
            'unit'    => ''
        ),
    ),

    array(
        'id'        => 'exopite-woocommerce-releated-per-page',
        'type'      => 'slider',
        'title'     => esc_attr__( 'Related products per page', 'exopite' ),
        'validate'  => 'numeric',
        'default'   => 4,
        'options'   => array(
            'step'    => 1,
            'min'     => 0,
            'max'     => 4,
            'unit'    => ''
        ),
    ),

    array(
        'id'        => 'exopite-woocommerce-new-badge-days',
        'type'      => 'slider',
        'title'     => esc_attr__( 'Display new badge for:', 'exopite' ),
        'validate'  => 'numeric',
        'default'   => 7,
        'options'   => array(
            'step'    => 1,
            'min'     => 0,
            'max'     => 100,
            'unit'    => ''
        ),
        'desc'      => esc_html__( 'Display the new badge for the amount of days. Disable: 0', 'exopite' ),
    ),

    array(
      'id'             => 'exopite-shop-sidebar-id',
      'type'           => 'select',
      'class'          => 'chosen',
      'title'          => esc_attr__('Shop sidebar', 'exopite' ),
      'options'        => get_sidebars( true ),
      'default'        => 'shop',
      'attributes' => array(
        'style' => 'width: 260px'
      ),
    ),

    array(
      'id'             => 'exopite-product-sidebar-id',
      'type'           => 'select',
      'class'          => 'chosen',
      'title'          => esc_attr__('Product sidebar', 'exopite' ),
      'options'        => get_sidebars( true ),
      'default'        => 'shop',
      'attributes' => array(
        'style' => 'width: 260px'
      ),
    ),

    array(
      'id'          => 'exopite-shop-title',
      'type'        => 'text',
      'title'       => esc_attr__( 'Shop title', 'exopite' ),

    ),

  )
);
}


// ------------------------------
// backup                       -
// ------------------------------
$exopite_options[]   = array(
  'name'     => 'backup_section',
  'title'    => esc_attr__( 'Backup & Restore', 'exopite' ),
  'icon'     => 'fa fa-floppy-o',
  'fields'   => array(

    array(
      'type'    => 'notice',
      'class'   => 'warning',
      'content' => esc_attr__( 'You can save your current options. Download a Backup and Import.', 'exopite' ),
    ),

    array(
      'before' => '<div class="cs-title"><h4>' . esc_attr__( 'Backup & Restore', 'exopite' ) . '</h4></div>',
      'type'    => 'backup',
    ),

  )
);

CSFramework::instance( $exopite_settings, $exopite_options );
