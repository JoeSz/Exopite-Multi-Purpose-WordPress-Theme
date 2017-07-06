<?php if ( ! defined( 'ABSPATH' ) ) die; // Cannot access pages directly.

require_once( 'cs-functions.php' );

// ===============================================================================================
// -----------------------------------------------------------------------------------------------
// METABOX OPTIONS
// -----------------------------------------------------------------------------------------------
// ===============================================================================================
$options      = array();

$exopite_settings = get_option( 'exopite_options' );

$exopite_meta_section_general = array(
  'name'  => 'exopite_section_general',
  'title' => esc_attr__( 'General', 'exopite' ),
  'icon'  => 'fa fa-cog',

  // begin: fields
  'fields' => array(

    // begin: a field
    array(
      'id'    => 'exopite-meta-extra-body-classes',
      'type'  => 'text',
    'title' => esc_attr__( 'Extra Body Class(es)', 'exopite' ),
      'label' => 'label',
      'attributes' => array(
         'placeholder' => 'class1 class2',
       )
    ),
    // end: a field

    array(
      'id'      => 'exopite-meta-enable-title',
      'type'    => 'switcher',
      'title'   => esc_attr__( 'Enable Title', 'exopite' ),
      'default' => true,
    ),

    array(
      'id'      => 'exopite-meta-enable-thumbnail',
      'type'    => 'switcher',
      'title'   => esc_attr__( 'Enable Thumbnail', 'exopite' ),
      'default' => true,
    ),

    array(
      'id'      => 'exopite-meta-enable-footer',
      'type'    => 'switcher',
      'title'   => esc_attr__( 'Enable footer', 'exopite' ),
      'default' => true,
    ),

    array(
      'id'      => 'exopite-meta-enable-breadcrumbs',
      'type'    => 'switcher',
      'title'   => esc_attr__( 'Enable Breadcrumbs', 'exopite' ),
      'label'   => esc_attr__( 'Note: You can display the breadcrumbs everywhere via [exopite-breadcrumbs] shortcode. If Yoast SEO is installed, please enable breadcrumbs in Yoast SEO options.', 'exopite' ),
      'default' => true,
    ),

  ), // end: fields
);

$exopite_meta_section_header = array(
  'name'  => 'exopite_section_header',
  'title' => esc_attr__( 'Header', 'exopite' ),
  'icon'  => 'fa fa-window-maximize',

  // begin: fields
  'fields' => array(

    array(
      'id'      => 'exopite-meta-enable-header',
      'type'    => 'switcher',
      'title'   => esc_attr__( 'Enable Header Area', 'exopite' ),
      'default' => true,
    ),

    array(
      'id'      => 'exopite-meta-enable-preheader-sidebar',
      'type'    => 'switcher',
      'title'   => esc_attr__( 'Enable Preheader Sidebar', 'exopite' ),
      'default' => true,
      'dependency'  => array( 'exopite-meta-enable-header', '==', 'true' ),
    ),

    array(
      'id'      => 'exopite-meta-enable-menu',
      'type'    => 'switcher',
      'title'   => esc_attr__( 'Enable Menu', 'exopite' ),
      'default' => true,
      'dependency'  => array( 'exopite-meta-enable-header', '==', 'true' ),
    ),

    array(
      'id'      => 'exopite-meta-above-menu-content-full',
      'type'    => 'switcher',
      'title'   => esc_attr__( 'Content above menu full width', 'exopite' ),
      'default' => true,
      'dependency'  => array( 'exopite-meta-enable-header|exopite-meta-enable-menu', '==|==', 'true|true' ),
    ),

    array(
      'id'         => 'exopite-meta-above-menu-content',
      //'shortcode'  => true,
      //'type'       => 'textarea',
      'type'       => 'wysiwyg',
      'title'      => 'Content above menu',
      'dependency'  => array( 'exopite-meta-enable-header|exopite-meta-enable-menu', '==|==', 'true|true' ),
    ),

   ), // end: fields
);

$exopite_meta_section_sidebar = array(
  'name'  => 'exopite_section_sidebar',
  'title' => esc_attr__( 'Sidebar', 'exopite' ),
  'icon'  => 'fa fa-th-list',
  'fields' => array(

    array(
      'id'             => 'exopite-meta-before-content-sidebar-id',
      'type'           => 'select',
      'title'          => esc_attr__( 'Select before content sidebar', 'exopite' ),
      'options'        => get_sidebars( true ),
      'class'          => 'chosen',
      'attributes'     => array(
        'style' => 'width: 260px'
      ),
    ),

    array(
      'id'      => 'exopite-meta-before-content-sidebar-full-width',
      'type'    => 'switcher',
      'title'   => esc_attr__( 'Before content sidebar full width', 'exopite' ),
      'default' => true,
    ),

    array(
      'id'           => 'exopite-meta-sidebar-layout',
      'type'         => 'image_select',
      'title'        => esc_attr__( 'Sidebar position', 'exopite' ),
      'options'      => array(
        'exopite-meta-sidebar-left'    => CS_URI . '/assets/images/blog-left.jpg',
        'exopite-meta-sidebar-none' => CS_URI . '/assets/images/blog-none.jpg',
        'exopite-meta-sidebar-right'   => CS_URI . '/assets/images/blog-right.jpg',
      ),
      'radio'        => true,
      'default'      => 'exopite-meta-sidebar-none'
    ),

    array(
      'id'             => 'exopite-meta-sidebar-id',
      'type'           => 'select',
      'title'          => esc_attr__( 'Select sidebar', 'exopite' ),
      'options'        => get_sidebars(),
      'class'          => 'chosen',
      'attributes'     => array(
        'style' => 'width: 260px'
      ),
      'dependency' => array( 'exopite-meta-sidebar-layout_exopite-meta-sidebar-none', '==', 'false' ),
    ),

  ),
);

$exopite_meta_section_seo_yoast = array(
  'name'  => 'exopite_section_seo_yoast',
  'title' => esc_attr__( 'SEO', 'exopite' ),
  'icon'  => 'fa fa-search',
  'fields' => array(

    array(
      'type'    => 'notice',
      'class'   => 'info',
      'content' => esc_attr__( 'Yoast SEO is active. Please use Yoast SEO metabox for SEO settings.', 'exopite' ),
    ),

  ),
);

$exopite_meta_section_seo = array(
  'name'  => 'exopite_section_seo',
  'title' => esc_attr__( 'SEO', 'exopite' ),
  'icon'  => 'fa fa-search',

  // begin: fields
  'fields' => array(

    array(
      'id'      => 'exopite-meta-seo-allow-index',
      'type'    => 'switcher',
      'title'   => esc_attr__( 'Allow search engines robots to index the page.', 'exopite' ),
      'default' => true,
      'after'   => '&nbsp;&nbsp;<a href="https://en.wikipedia.org/wiki/Noindex" target="_blank">' . esc_attr__( 'What is this?', 'exopite' ) . '</a>',
    ),

    array(
      'id'      => 'exopite-meta-seo-allow-follow',
      'type'    => 'switcher',
      'title'   => esc_attr__( 'Allow search engines robots to follow the links on the page.', 'exopite' ),
      'default' => true,
    ),

    array(
      'id'         => 'exopite-meta-description',
      'type'       => 'textarea',
      'attributes' => array(
        'rows'     => 3,
      ),
      'before'     => '<div class="cs-title"><h4 style="padding-bottom: 20px;">' . esc_attr__( 'Site description', 'exopite' ) . '</h4></div>',
      'after'     => '<small>' . esc_attr__( 'If you leave it empty, meta description will generate from content.', 'exopite' ) . '</small>',
    ),

    array(
      'id'    => 'exopite-meta-keywords',
      'type'  => 'text',
      'title' => esc_attr__( 'Meta keywords', 'exopite' ),
      'desc'     => '<small>' . esc_attr__( 'If you leave it empty, will be ignored.', 'exopite' ) . '</small>',
    ),


   ), // end: fields
);

$exopite_meta_section_post = array(
  'name'  => 'exopite_section_post',
  'title' => esc_attr__( 'Post', 'exopite' ),
  'icon'  => 'fa fa-search',

  // begin: fields
  'fields' => array(

    array(
      'id'      => 'exopite-meta-enable-meta',
      'type'    => 'switcher',
      'title'   => esc_attr__( 'Enable meta', 'exopite' ),
      'default' => true,
    ),

    array(
      'id'      => 'exopite-meta-enable-author',
      'type'    => 'switcher',
      'title'   => esc_attr__( 'Enable author', 'exopite' ),
      'default' => true,
    ),

    array(
      'id'      => 'exopite-meta-enable-post-nav',
      'type'    => 'switcher',
      'title'   => esc_attr__( 'Enable post navigation', 'exopite' ),
      'default' => true,
    ),

    array(
      'id'      => 'exopite-meta-enable-releated-posts',
      'type'    => 'switcher',
      'title'   => esc_attr__( 'Enable releated posts', 'exopite' ),
      'default' => true,
    ),


   ), // end: fields
);

$exopite_meta_section_hero_header_front_page = array(
  'name'  => 'exopite_section_hero_header',
  'title' => esc_attr__( 'Hero header', 'exopite' ),
  'icon'  => 'fa fa-film',
  'fields' => array(

    array(
      'type'    => 'notice',
      'class'   => 'info',
      'content' => esc_attr__( 'Please set Hero header in options for front page.', 'exopite' ),
    ),

  ),
);

$exopite_meta_section_hero_header =     // begin: a section
array(
  'name'  => 'exopite_section_hero_header',
  'title' => esc_attr__( 'Hero header', 'exopite' ),
  'icon'  => 'fa fa-film',
  'fields' => array(

    array(
      'id'          => 'exopite-enable-hero-header',
      'type'        => 'switcher',
      'title'       => esc_attr__( 'Enable hero header', 'exopite' ),
      'default'     => false,
    ),


    array(
      'id'          => 'exopite-hero-header-type',
      'type'        => 'image_select',
      'title'       => esc_attr__( 'Hero header type', 'exopite' ),
      'options'     => array(
        'image'         => CS_URI . '/assets/images/image.jpg',
        'video'         => CS_URI . '/assets/images/video.jpg',
        'youtube'       => CS_URI . '/assets/images/youtube.jpg',
        'googledrive'   => CS_URI . '/assets/images/googledrive.jpg',
      ),
      'radio'       => true,
      'default'     => 'image',
      'dependency'  => array( 'exopite-enable-hero-header', '==', 'true' ),
    ),

    array(
        'id'         => 'exopite-hero-header-height',
        'type'       => 'slider',
        'title'      => esc_attr__( 'Hero header height in %', 'exopite' ),
        'validate'   => 'numeric',
        'default'    => 0,
        'options'    => array(
            'step'     => 1,
            'min'      => 0,
            'max'      => 100,
            'unit'     => ''
        ),
        'dependency' => array( 'exopite-enable-hero-header', '==', 'true' ),
        'desc'       => '<i>' . esc_attr__( 'Zero for default option.', 'exopite' ) . '</i>',
    ),

    array(
      'id'         => 'exopite-hero-header-image',
      'type'       => 'image',
      'title'      => esc_attr__( 'Hero header image', 'exopite' ),
      'add_title'  => esc_attr__( 'Add Image', 'exopite' ),
      'dependency' => array( 'exopite-enable-hero-header|exopite-hero-header-type_image', '==|==', 'true|true' ),
    ),

    array(
      'id'         => 'exopite-hero-header-overlay-color',
      'type'       => 'color_picker',
      'title'      => esc_attr__('Hero header overlay color', 'exopite'),
      'rgba'       => true,
      'default'    => 'rgba(0,0,0,0)',
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
      'id'         => 'exopite-hero-header-youtube-id', // another unique id
      'type'       => 'text',
      'title'      => 'Hero header youtube video ID',
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
        'text'      => CS_URI . '/assets/images/text.jpg',
      ),
      'radio'       => true,
      'default'     => 'text',
      'dependency'  => array( 'exopite-enable-hero-header', '==', 'true' ),
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
      'id'         => 'exopite-hero-header-site-branding-text', // another unique id
      'type'       => 'textarea',
      'title'      => 'Hero header text',
      'dependency' => array( 'exopite-enable-hero-header|exopite-hero-header-site-branding-type_text', '==|==', 'true|true' ),
    ),

    array(
      'type'    => 'notice',
      'class'   => 'info',
      'content' => '<div style="text-align:center;">'. esc_attr__( 'This will display the widget. To use this, You have to set widget in settings as well.', 'exopite' ) . '</div>',
      'dependency' => array( 'exopite-enable-hero-header|exopite-hero-header-site-branding-type_widget', '==|==', 'true|true' ),
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


  ),
);

// -----------------------------------------
// Page Metabox Options                    -
// -----------------------------------------
$options[]    = array(
  'id'        => 'exopite_custom_page_options',
  'title'     => 'Exopite One - Page Options',
  'post_type' => apply_filters( 'exopite-post-types-pages-to-display-metabox', array( 'page' ) ),
  'context'   => 'normal',
  'priority'  => 'default',
  'sections'  => array(
  ),
);

$options[]    = array(
  'id'        => 'exopite_custom_post_options',
  'title'     => 'Exopite One - Post Options',
  'post_type' => apply_filters( 'exopite-post-types-posts-to-display-metabox', array( 'post' ) ),
  'context'   => 'normal',
  'priority'  => 'default',
  'sections'  => array(
  ),
);

$options[0]['sections'][] = $exopite_meta_section_general;
$options[0]['sections'][] = $exopite_meta_section_header;
$options[0]['sections'][] = $exopite_meta_section_sidebar;
$options[0]['sections'][] = ( function_exists( 'yoast_breadcrumb' ) ) ? $exopite_meta_section_seo_yoast : $exopite_meta_section_seo;

$options[1]['sections'][] = $exopite_meta_section_general;
$options[1]['sections'][] = $exopite_meta_section_header;
$options[1]['sections'][] = $exopite_meta_section_sidebar;
$options[1]['sections'][] = $exopite_meta_section_post;
$options[1]['sections'][] = ( function_exists( 'yoast_breadcrumb' ) ) ? $exopite_meta_section_seo_yoast : $exopite_meta_section_seo;

/*
 * Option to disable logo.
 * Only available, if logo on top of the menu (and menu is on top)
 */
$meta_enable_desktop_logo = array(
  'id'      => 'exopite-meta-desktop-logo',
  'type'    => 'switcher',
  'title'   => esc_attr__( 'Enable desktop logo', 'exopite' ),
  'default' => true,
  'dependency'  => array( 'exopite-meta-enable-header', '==', 'true' ),
);

if ( ! isset( $exopite_settings['exopite-desktop-logo-position'] ) || $exopite_settings['exopite-desktop-logo-position'] == 'top' ) {

    $options[0]['sections'][0]['fields'][] = $meta_enable_desktop_logo;
}

/*
 * Show fixed top menu esettings only if menu in top (not for side menu)
 */
$meta_enable_fixed_top_menu_settings = array(
  'id'      => 'exopite-enable-fixed-header',
  'type'    => 'switcher',
  'title'   => esc_attr__( 'Enable fixed menu', 'exopite' ),
  'default' => false,
  'dependency'  => array( 'exopite-meta-enable-header|exopite-meta-enable-menu', '==|==', 'true|true' ),
);

if ( ! isset( $exopite_settings['exopite-menu-alignment'] ) || $exopite_settings['exopite-menu-alignment'] == 'top' ) {

    $options[0]['sections'][1]['fields'][] = $meta_enable_fixed_top_menu_settings;
    $options[1]['sections'][1]['fields'][] = $meta_enable_fixed_top_menu_settings;
}

/*
 * Hero header
 */
// Hero header conditional
if ( ! isset( $exopite_settings['exopite-enable-hero-header'] ) || ( $exopite_settings['exopite-enable-hero-header'] ) && ( isset( $_GET['post'] ) && $_GET['post'] != get_option( 'page_on_front' ) ) ) {

    // Add hero header section only, if hero header is enabled in settings and this is not a fron page.
    $options[0]['sections'][] = $exopite_meta_section_hero_header;
    $options[1]['sections'][] = $exopite_meta_section_hero_header;

} elseif ( isset( $_GET['post'] ) && $_GET['post'] == get_option( 'page_on_front' ) ) {

    // Hero header for front page need to be set in options
    $options[0]['sections'][] = $exopite_meta_section_hero_header_front_page;
}

/*
 * Enable content for Blog page
 */
$meta_enable_blog_content = array(
  'id'      => 'exopite-enable-blog-content',
  'type'    => 'switcher',
  'title'   => esc_attr__( 'Display blog content', 'exopite' ),
  'default' => false,
);

if ( isset( $_GET['post'] ) && $_GET['post'] == get_option('page_for_posts') ) {
    // Only on "Blog" page
    $options[0]['sections'][1]['fields'][] = $meta_enable_blog_content;
}

CSFramework_Metabox::instance( $options );

