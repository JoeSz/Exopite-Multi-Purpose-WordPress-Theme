<?php
/**
 * The menu template for Exopite theme.
 *
 * @package Exopite
 *
 */
defined('ABSPATH') or die( 'You cannot access this page directly.' );

$exopite_menu_left = $exopite_menu_alignment == 'left';
$exopite_menu_container = ( $exopite_menu_full_width ) ? 'container-fluid' : 'container';

// Logo position
$exopite_logo_left_pos = $exopite_logo_right_pos = $exopite_logo_top_pos = $exopite_logo_top_in_menu_pos = $exopite_logo_center_pos = false;
switch ( $exopite_desktop_logo_position ) {
    case 'left':
        $exopite_logo_left_pos = true;
        break;
    case 'right':
        $exopite_logo_right_pos = true;
        break;
    case 'top':
        $exopite_logo_top_pos = true;
        break;
    case 'top-in-menu':
        $exopite_logo_top_in_menu_pos = true;
        break;
    case 'center':
        $exopite_logo_center_pos = true;
        break;
}

// Logo alignment
$exopite_logo_left = $exopite_logo_right = $exopite_logo_center = false;
switch ( $exopite_desktop_logo_alignment ) {
    case 'text-left flex-left':
        $exopite_logo_left = true;
        break;
    case 'text-right flex-right':
        $exopite_logo_right = true;
        break;
    case 'text-center flex-center':
        $exopite_logo_center = true;
        break;
}

// Sidebars
$exopite_left_side_logo_widget_area = is_active_sidebar( 'left-side-logo-widget-area' );
$exopite_right_side_logo_widget_area = is_active_sidebar( 'right-side-logo-widget-area' );

$exopite_logo_top = $exopite_logo_top_pos || $exopite_logo_top_in_menu_pos;
$exopite_logo_menu_center = ( $exopite_desktop_logo_position == 'center' );
$exopite_both = $exopite_left_side_logo_widget_area && $exopite_right_side_logo_widget_area && $exopite_logo_center;
$exopite_left_or_right = $exopite_left_side_logo_widget_area || $exopite_right_side_logo_widget_area;

// Alignment classes
$exopite_logo_alignment_classes = ( $exopite_logo_top || $exopite_menu_left ) ? '' : ' col-md-4 col-lg-3';
$exopite_logo_in_menu = ( $exopite_logo_top || $exopite_menu_left ) ? '' : ' logo-in-menu';
$exopite_logo_alignment_classes .= ( ( $exopite_logo_top && $exopite_logo_center && ( $exopite_left_or_right ) ) ||
                             ( $exopite_logo_left && $exopite_right_side_logo_widget_area ) ||
                             ( $exopite_logo_right && $exopite_left_side_logo_widget_area ) ) ?
                             ' col-md-4' : '';

$exopite_menu_alignment_classes = ( $exopite_logo_top || $exopite_menu_left || $exopite_logo_menu_center ) ? '' : ' col-md-8 col-lg-9';

// Logos
$exopite_desktop_logo = ( isset( $exopite_settings['exopite-desktop-logo'] ) ) ?
    wp_get_attachment_image_src( $exopite_settings['exopite-desktop-logo'], 'full' )[0] :
    '';

$exopite_mobile_logo = ( isset( $exopite_settings['exopite-mobile-menu-logo'] ) ) ?
    wp_get_attachment_image_src( $exopite_settings['exopite-mobile-menu-logo'], 'full' )[0] :
    '';

$exopite_desktop_logo = apply_filters( 'exopite-desktop-logo', $exopite_desktop_logo );
$exopite_mobile_logo = apply_filters( 'exopite-mobile-logo', $exopite_mobile_logo );

$exopite_enable_fixed_header = isset( $exopite_meta_data['exopite-enable-fixed-header'] ) ?
    $exopite_meta_data['exopite-enable-fixed-header'] :
    false;

ExopiteSettings::setValue( 'logo_url', $exopite_desktop_logo );

if ( ! function_exists( 'exopite_create_logo' ) ) {
    function exopite_create_logo() {
        if ( ExopiteSettings::getValue( 'logo_url' ) == "") return;
        return '<a href="' . apply_filters( 'exopite-desktop-logo-url', SITEURL ) . '"><img src="' . ExopiteSettings::getValue( 'logo_url' ) . '" class="logo" alt="Desktop Logo"></a>';
    }
}

/*
 * MAIN MENU
 *
 * Assemble logo image, I put it in a variable, because I may have to display
 * before, after or top of the menu, depends on the logo left or right settings.
 */
$exopite_logo = apply_filters( 'exopite-logo', '<div class="desktop-menu desktop-menu-logo col-12' . $exopite_logo_alignment_classes . ' ' . $exopite_desktop_logo_alignment . $exopite_logo_in_menu . '">' . exopite_create_logo() . '</div>' );

/*
 * MOBILE MENU
 *
 * If there is no mobile logo set, use desktop version
 */
$exopite_mobile_logo_img = ( $exopite_mobile_logo != '' ) ? $exopite_mobile_logo : $exopite_desktop_logo;


$exopite_mobile_logo = ( $exopite_mobile_logo_img == '' ) ? '' : '<a href="' . SITEURL . '">
        <img src="' . $exopite_mobile_logo_img . '" class="logo" alt="Mobile Logo">
    </a>';

    $exopite_mobile_hamburger_icon = apply_filters( 'exopite-mobile-hamburger-icon', '<div id="mobile-trigger" class="mobile-button mobile-button-hamburger">
        <span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span>
        <span class="icon-text">MENU</span>
    </div>' );

if ( $exopite_mobile_menu_search ) {
    add_action( 'expote-extend-mobile-menu', 'add_mobile_menu_search' );
    if ( ! function_exists( 'add_mobile_menu_search' ) ) {
        function add_mobile_menu_search() {
            echo apply_filters( 'exopite-menu-search-icon', '<div class="full-search-menu mobile-button mobile-button-search"><i class="fa fa-search" aria-hidden="true"></i></div>' );
        }
    }
}

/**
 * Add search to menu
 */
if ( ! isset( $exopite_settings['exopite-desktop-menu-search'] ) || ( $exopite_settings['exopite-desktop-menu-search'] && apply_filters( 'exopite-desktop-menu-search', true ) ) ) {
    add_filter( 'wp_nav_menu_items', 'exopite_child_add_top_search_menu', 10, 2 );
}
if ( ! function_exists( 'exopite_child_add_top_search_menu' ) ) {
    function exopite_child_add_top_search_menu( $items, $args ) {
        if ( $args->theme_location == 'primary' ) {
            $items .= '<li class="full-search-menu-wrapper"><a class="full-search-menu" href="#"><i class="fa fa-search" aria-hidden="true"></i></a></li>';
        }
        return $items;
    }
}

if ( $exopite_logo_center_pos ) add_filter( 'exopite_center_nav_menu_item', 'exopite_create_logo' );

?><header id="masthead" class="site-header menu-alignment-<?php echo $exopite_menu_alignment; ?>" itemscope="itemscope" itemtype="https://schema.org/WPHeader">
    <?php tha_header_top();

    /*
     * If desktop logo is on top, then display here.
     */
    if ( $exopite_logo_top_pos ) include( locate_template( 'template-parts/logo-top.php' ) );

    ?>
    <nav id="site-navigation" class="row-menu main-navigation normal-menu<?php if ( $exopite_enable_fixed_header && ! $exopite_menu_left ) echo ' fixed-top'; ?>" itemscope="itemscope" itemtype="https://schema.org/SiteNavigationElement">
        <?php

        // Display contant above menu from page meta
        if ( isset( $exopite_meta_data['exopite-meta-above-menu-content'] ) &&
             ! empty( $exopite_meta_data['exopite-meta-above-menu-content'] ) ) :

            // Add container if not full width
            if ( ! $exopite_meta_data['exopite-meta-above-menu-content-full'] ) : ?>
            <div class="container">
                <div class="row flex">
                   <div class="col-12">
            <?php endif;

                /*
                 * Blog: http://wordpress.stackexchange.com/questions/199308/get-meta-value-when-the-page-is-a-blog-archive
                 * Run shortcode on content
                 */
                echo do_shortcode( $exopite_meta_data['exopite-meta-above-menu-content'] );

            if ( ! $exopite_meta_data['exopite-meta-above-menu-content-full'] ) : ?>
                    </div>
                </div>
            </div>
            <?php endif;

        endif;

        /*
         * If desktop logo is on top but inside the menu, then display here.
         */
        if ( $exopite_logo_top_in_menu_pos ) include( locate_template( 'template-parts/logo-top.php' ) );

        ?>
        <div class="<?php echo $exopite_menu_container; ?> ">
            <div class="row flex">
                <?php

                /*
                 * Hook display:
                 *  - top menu widgets, 10 (include/sidebars.php)
                 */
                exopite_hooks_menu_top();

                /*
                 * If logo is on the left, then display here.
                 */
                if ( $exopite_logo_left_pos ) echo $exopite_logo;

                /*
                 * Mobile menu buttons and search field.
                 */
                ?>
                <div class="flex col-12 <?php echo $exopite_menu_alignment_classes . ' ' . $exopite_desktop_menu_horizontal_alignment . ' ' . $exopite_desktop_menu_vertical_alignment; ?>">
                    <?php

                    /*
                     * Display mobile menu only, if menu on the top.
                     */
                    if ( $exopite_menu_alignment == 'top' ) : ?>
                        <div class="row menu-collapser flex">
                            <?php

                            /*
                             * Display this column only, if mobile search is on and menu is on the right side
                             */
                            if ( $exopite_mobile_menu_search && $exopite_mobile_menu_position === 'right' ) : ?>
                            <div class="col-3 mobile-menu-left">
                                <?php

                                do_action( 'expote-extend-mobile-menu', '' );

                                ?>
                            </div>
                            <?php

                            /*
                             * If menu on the left side
                             */
                            elseif ( $exopite_mobile_menu_position === 'left' ) : ?>
                            <div class="col-3 mobile-menu-left">
                                <?php echo $exopite_mobile_hamburger_icon; ?>
                            </div>
                            <?php endif;

                            ?>
                            <div class="<?php if ( $exopite_mobile_menu_search ) : echo 'col-6 text-center'; else: echo 'col-9'; endif; ?> <?php if ( $exopite_mobile_menu_position === 'left' ) echo 'text-right'; ?>">
                                <?php

                                /*
                                 * If no mobile search is activated, then place logo on the right and use its space too
                                 */
                                if ( $exopite_mobile_logo != '' ) echo $exopite_mobile_logo;

                                ?>
                            </div>
                            <?php

                            /*
                             * Display this column only, if mobile search is on and menu is on the left side
                             */
                            if ( $exopite_mobile_menu_search && $exopite_mobile_menu_position === 'left' ) : ?>
                            <div class="col-3 mobile-menu-right">
                                <?php

                                do_action( 'expote-extend-mobile-menu', '' );

                                ?>
                            </div>
                            <?php

                            /*
                             * If menu on the right side
                             */
                            elseif ( $exopite_mobile_menu_position === 'right' ) : ?>
                            <div class="col-3 mobile-menu-right">
                                <?php echo $exopite_mobile_hamburger_icon; ?>
                            </div>
                            <?php

                            endif;

                            ?>
                        </div>
                        <?php

                        /*
                         * Display mobile menu if exist
                         */
                        if ( has_nav_menu( 'mobile' ) ):
                            wp_nav_menu(
                                array(
                                    'theme_location'    => 'mobile',
                                    'menu_id'           => apply_filters( 'exopite-mobile-menu', 'mobile-menu' ), //using 22658.88 kB memory
                                    'items_wrap'        => apply_filters( 'exopite-mobile-menu-wrap', '<ul id="mobile-menu" class="menu-row row slimmenu">%3$s</ul>' ),
                                    'container'         => false,
                                    )
                                );
                        endif;

                    endif;

                    /*
                     * Display primary menu and if mobile menu not exist, use this menu to mobile menu as well
                     */
                    if ( has_nav_menu( 'primary' ) ):

                        exopite_hooks_before_menu();

                        $exopite_items_wrap = ( has_nav_menu( 'mobile' ) ) ?
                            apply_filters( 'exopite-desktop-mobile-menu-wrap', '<div id="cssmenu" class="menu-row menu-both"><ul id="desktop-menu" class="desktop-menu">%3$s</ul></div>' ) :
                            apply_filters( 'exopite-desktop-menu-wrap', '<ul id="menu" class="desktop-menu slimmenu">%3$s</ul>' );

                        wp_nav_menu(
                            array(
                                'theme_location'    => 'primary',
                                'menu_id'           => apply_filters( 'exopite-primary-menu', 'primary-menu' ), //using 22658.88 kB memory
                                'items_wrap'        => $exopite_items_wrap,
                                'container'         => false,
                                'walker'            => new Exopite_Menu_Walker(),
                            )
                        );

                        exopite_hooks_after_menu();

                    endif;
                    ?>
                </div>
                <?php

                /*
                 * If desktop logo is on the right, then display here
                 */
                if ( $exopite_logo_right_pos ) echo $exopite_logo;

                ?>
            </div>
        </div>
    </nav><!-- #site-navigation -->
    <?php

    // Theme Hook Alliance (include/plugins/tha-theme-hooks.php)
    tha_header_bottom();

    ?>
</header><!-- #masthead -->
<?php
