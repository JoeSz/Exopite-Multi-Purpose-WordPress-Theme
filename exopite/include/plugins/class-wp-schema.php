<?php
/**
 * Schema microdata
 *
 * This file incorporates code from Stargazer WordPress Theme,
 * Copyright (c) 2013 - 2016, Justin Tadlock https://themehybrid.com/themes/stargazer.
 * Stargazer WordPress Theme is distributed under the terms of the GNU GPL.
 *
 * This file incorporates code from Manta WordPress Theme,
 * Copyright (c) 2013 - 2016, PremiumWP https://wordpress.org/themes/manta.
 * Stargazer WordPress Theme is distributed under the terms of the GNU GPL.
 *
 * @link https://schema.org/docs/gs.html
 *
 * @package Exopite
 * @since 20171010
 */

/**
 * Returns scehma microdata in element attributes.
 *
 * @since 20171010
 */
class WP_Schema {
	/**
	 * Constructor method intentionally left blank.
	 */
	private function __construct() {}

	/**
	 * Add filter hooks for schema attributes.
	 *
	 * @since 1.0.0
	 *
	 * @see manta_get_attr()
	 */
	public static function initiate() {
		add_filter( 'schema_get_attr_head'                 , array( __CLASS__, 'head' ) );
		add_filter( 'schema_get_attr_body'                 , array( __CLASS__, 'body' ) );
		add_filter( 'schema_get_attr_site-header'          , array( __CLASS__, 'site_header' ) );
		add_filter( 'schema_get_attr_site-title'           , array( __CLASS__, 'site_title' ) );
		add_filter( 'schema_get_attr_site-description'     , array( __CLASS__, 'site_description' ) );
		add_filter( 'schema_get_attr_main-navigation'      , array( __CLASS__, 'main_navigation' ) );
		add_filter( 'schema_get_attr_header-menu'          , array( __CLASS__, 'main_navigation' ) );
		add_filter( 'schema_get_attr_footer-menu'          , array( __CLASS__, 'main_navigation' ) );
		add_filter( 'schema_get_attr_social-menu'          , array( __CLASS__, 'main_navigation' ) );
		add_filter( 'schema_get_attr_content-area'         , array( __CLASS__, 'content_area' ) );
		add_filter( 'schema_get_attr_site-main'            , array( __CLASS__, 'site_main' ) );
		add_filter( 'schema_get_attr_post'                 , array( __CLASS__, 'post' ) );
		add_filter( 'schema_get_attr_sidebar'              , array( __CLASS__, 'sidebar' ) );
		add_filter( 'schema_get_attr_site-footer'          , array( __CLASS__, 'site_footer' ) );
		add_filter( 'schema_get_attr_entry-title'          , array( __CLASS__, 'entry_title' ) );
		add_filter( 'schema_get_attr_entry-content'        , array( __CLASS__, 'entry_content' ) );
		add_filter( 'schema_get_attr_entry-date'           , array( __CLASS__, 'entry_date' ) );
		add_filter( 'schema_get_attr_modified-entry-date'  , array( __CLASS__, 'modified_entry_date' ) );
		add_filter( 'schema_get_attr_author'               , array( __CLASS__, 'author' ) );
		add_filter( 'schema_get_attr_url'                  , array( __CLASS__, 'url' ) );
		add_filter( 'schema_get_attr_name'                 , array( __CLASS__, 'name' ) );
		add_filter( 'schema_get_attr_tags-links'           , array( __CLASS__, 'tags_links' ) );
		add_filter( 'schema_get_attr_comment-inner'        , array( __CLASS__, 'comment_inner' ) );
		add_filter( 'schema_get_attr_comment-author'       , array( __CLASS__, 'comment_author' ) );
		add_filter( 'schema_get_attr_comment-time'         , array( __CLASS__, 'comment_time' ) );
		add_filter( 'schema_get_attr_comment-content'      , array( __CLASS__, 'comment_content' ) );
		add_filter( 'schema_get_attr_page-header'          , array( __CLASS__, 'page_header' ) );
		add_filter( 'schema_get_attr_page-title'           , array( __CLASS__, 'site_title' ) );
		add_filter( 'schema_get_attr_taxonomy-description' , array( __CLASS__, 'site_description' ) );
		add_filter( 'schema_get_attr_search-form'          , array( __CLASS__, 'search_form' ) );
		add_filter( 'schema_get_attr_search-field'         , array( __CLASS__, 'search_field' ) );
		add_filter( 'nav_menu_link_attributes'            , array( __CLASS__, 'nav_menu_links' ) );
		add_filter( 'wp_nav_menu_args'                    , array( __CLASS__, 'nav_menu_link_text' ) );
	}

    /**
     * Gets an HTML element's attributes.
     *
     * @since  1.0.0
     *
     * @param  str   $slug The slug/ID of the element (e.g., 'sidebar').
     * @param  array $attr Array of attributes to pass in (overwrites filters).
     * @return string
     */
    public static function get_attribute( $slug, $echo = true, $attr = array() ) {

        /**
         * Filter element's attributes.
         *
         * @since 1.0.0
         */
        $attr = apply_filters( "schema_get_attr_{$slug}", $attr, $slug );

        $out    = '';

        if ( ! empty( $attr ) ) {
            foreach ( $attr as $name => $value ) {
                $out .= sprintf( ' %s="%s"', esc_html( $name ), esc_attr( $value ) );
            }
        }

        if ( $echo ) {
            echo $out;
        } else {
            return $out;
        }
    }

	/**
	 * Head element attributes.
	 *
	 * @since 1.0.0
	 *
	 * @param array $attr attribute values array.
	 * @return array
	 */
	public static function head( $attr ) {
		$attr['itemscope'] = 'itemscope';
		$attr['itemtype']  = 'https://schema.org/WebSite';
		return $attr;
	}

	/**
	 * Body element attributes.
	 *
	 * @since 1.0.0
	 *
	 * @param array $attr attribute values array.
	 * @return array
	 */
	public static function body( $attr ) {
		$attr['itemscope'] = 'itemscope';
		$attr['itemtype']  = 'https://schema.org/WebPage';
		return $attr;
	}

	/**
	 * Site header element attributes.
	 *
	 * @since 1.0.0
	 *
	 * @param array $attr attribute values array.
	 * @return array
	 */
	public static function site_header( $attr ) {
		$attr['itemscope'] = 'itemscope';
		$attr['itemtype']  = 'https://schema.org/WPHeader';
		return $attr;
	}

	/**
	 * Site title attributes.
	 *
	 * @since 1.0.0
	 *
	 * @param array $attr attribute values array.
	 * @return array
	 */
	public static function site_title( $attr ) {
		$attr['itemprop'] = 'headline';
		return $attr;
	}

	/**
	 * Site description attributes.
	 *
	 * @since 1.0.0
	 *
	 * @param array $attr attribute values array.
	 * @return array
	 */
	public static function site_description( $attr ) {
		$attr['itemprop'] = 'description';
		return $attr;
	}

	/**
	 * Nav menu attributes.
	 *
	 * @since 1.0.0
	 *
	 * @param array $attr attribute values array.
	 * @return array
	 */
	public static function main_navigation( $attr ) {
		$attr['itemscope'] = 'itemscope';
		$attr['itemtype']  = 'https://schema.org/SiteNavigationElement';
		return $attr;
	}

	/**
	 * Content area attributes.
	 *
	 * @since 1.0.0
	 *
	 * @param array $attr attribute values array.
	 * @return array
	 */
	public static function content_area( $attr ) {
		if ( ! is_page() && ! is_404() ) {
			$attr['itemprop'] = 'mainContentOfPage';
		}
		return $attr;
	}

	/**
	 * Site main attributes.
	 *
	 * @since 1.0.0
	 *
	 * @param array $attr attribute values array.
	 * @return array
	 */
	public static function site_main( $attr ) {
		if ( ! is_page() && ! is_404() ) {
			$attr['itemscope'] = 'itemscope';
			$attr['itemtype']  = 'https://schema.org/Blog';
		} else {
			$attr['itemprop']  = 'mainContentOfPage';
		}

		if ( is_search() ) {
			$attr['itemscope'] = 'itemscope';
			$attr['itemtype']  = 'https://schema.org/SearchResultsPage';
		}

		return $attr;
	}

	/**
	 * Post article element attributes.
	 *
	 * @since 1.0.0
	 *
	 * @param array $attr attribute values array.
	 * @return array
	 */
	public static function post( $attr ) {
		$attr['itemscope'] = 'itemscope';
		$attr['itemtype']  = 'https://schema.org/CreativeWork';
		return $attr;
	}

	/**
	 * Primary sidebar attributes.
	 *
	 * @since 1.0.0
	 *
	 * @param array $attr attribute values array.
	 * @return array
	 */
	public static function sidebar( $attr ) {
		$attr['itemscope'] = 'itemscope';
		$attr['itemtype']  = 'https://schema.org/WPSideBar';
		return $attr;
	}

	/**
	 * Site footer attributes.
	 *
	 * @since 1.0.0
	 *
	 * @param array $attr attribute values array.
	 * @return array
	 */
	public static function site_footer( $attr ) {
		$attr['itemscope'] = 'itemscope';
		$attr['itemtype']  = 'https://schema.org/WPFooter';
		return $attr;
	}

	/**
	 * Entry title attributes.
	 *
	 * @since 1.0.0
	 *
	 * @param array $attr attribute values array.
	 * @return array
	 */
	public static function entry_title( $attr ) {
		$attr['itemprop'] = 'headline';
		return $attr;
	}

	/**
	 * Entry content attributes.
	 *
	 * @since 1.0.0
	 *
	 * @param array $attr attribute values array.
	 * @return array
	 */
	public static function entry_content( $attr ) {
		$attr['itemprop'] = 'text';
		return $attr;
	}

	/**
	 * Post entry date attributes.
	 *
	 * @since 1.0.0
	 *
	 * @param array $attr attribute values array.
	 * @return array
	 */
	public static function entry_date( $attr ) {
		$attr['itemprop'] = 'datePublished';
		return $attr;
	}

	/**
	 * Post modified entry date attributes.
	 *
	 * @since 1.0.0
	 *
	 * @param array $attr attribute values array.
	 * @return array
	 */
	public static function modified_entry_date( $attr ) {
		$attr['itemprop'] = 'dateModified';
		return $attr;
	}

	/**
	 * Post author attributes.
	 *
	 * @since 1.0.0
	 *
	 * @param array $attr attribute values array.
	 * @return array
	 */
	public static function author( $attr ) {
		$attr['itemscope'] = 'itemscope';
		$attr['itemtype']  = 'https://schema.org/Person';
		$attr['itemprop']  = 'author';
		return $attr;
	}

	/**
	 * URL attributes.
	 *
	 * @since 1.0.0
	 *
	 * @param array $attr attribute values array.
	 * @return array
	 */
	public static function url( $attr ) {
		$attr['itemprop']  = 'url';
		return $attr;
	}

	/**
	 * Name attributes.
	 *
	 * @since 1.0.0
	 *
	 * @param array $attr attribute values array.
	 * @return array
	 */
	public static function name( $attr ) {
		$attr['itemprop']  = 'name';
		return $attr;
	}

	/**
	 * Tag links attributes.
	 *
	 * @since 1.0.0
	 *
	 * @param array $attr attribute values array.
	 * @return array
	 */
	public static function tags_links( $attr ) {
		$attr['itemprop']  = 'keywords';
		return $attr;
	}

	/**
	 * Comments attributes.
	 *
	 * @since 1.0.0
	 *
	 * @param array $attr attribute values array.
	 * @return array
	 */
	public static function comment_inner( $attr ) {
		$attr['itemscope'] = 'itemscope';
		$attr['itemtype']  = 'https://schema.org/Comment';
		$attr['itemprop']  = 'comment';
		return $attr;
	}

	/**
	 * Comment author attributes.
	 *
	 * @since 1.0.0
	 *
	 * @param array $attr attribute values array.
	 * @return array
	 */
	public static function comment_author( $attr ) {
		$attr['itemscope'] = 'itemscope';
		$attr['itemtype']  = 'https://schema.org/Person';
		$attr['itemprop']  = 'author';
		return $attr;
	}

	/**
	 * Comment time attributes.
	 *
	 * @since 1.0.0
	 *
	 * @param array $attr attribute values array.
	 * @return array
	 */
	public static function comment_time( $attr ) {
		$attr['itemprop']  = 'datePublished';
		return $attr;
	}

	/**
	 * Comment content attributes.
	 *
	 * @since 1.0.0
	 *
	 * @param array $attr attribute values array.
	 * @return array
	 */
	public static function comment_content( $attr ) {
		$attr['itemprop']  = 'Text';
		return $attr;
	}

	/**
	 * Page-header element attributes.
	 *
	 * @since 1.0.0
	 *
	 * @param array $attr attribute values array.
	 * @return array
	 */
	public static function page_header( $attr ) {
		$attr['itemscope'] = 'itemscope';
		$attr['itemtype']  = 'https://schema.org/WebPageElement';
		return $attr;
	}

	/**
	 * Search-form element attributes.
	 *
	 * @since 1.0.0
	 *
	 * @param array $attr attribute values array.
	 * @return array
	 */
	public static function search_form( $attr ) {
		$attr['itemprop']  = 'potentialAction';
		$attr['itemscope'] = 'itemscope';
		$attr['itemtype']  = 'https://schema.org/SearchAction';
		return $attr;
	}

	/**
	 * Search field attributes.
	 *
	 * @since 1.0.0
	 *
	 * @param array $attr attribute values array.
	 * @return array
	 */
	public static function search_field( $attr ) {
		$attr['itemprop']  = 'query-input';
		return $attr;
	}

	/**
	 * Navigation menu links attributes.
	 *
	 * @since 1.0.0
	 *
	 * @param array $attr attribute values array.
	 * @return array
	 */
	public static function nav_menu_links( $attr ) {
		$attr['itemprop']  = 'url';
		return $attr;
	}

	/**
	 * Navigation menu link text attributes.
	 *
	 * @since 1.0.0
	 *
	 * @param array $attr attribute values array.
	 * @return array
	 */
	public static function nav_menu_link_text( $attr ) {
		if ( '' === $attr['link_before'] ) {
			$attr['link_before']  = '<span itemprop="name">';
			$attr['link_after']   = '</span>';
		}
		return $attr;
	}
}

WP_Schema::initiate();
