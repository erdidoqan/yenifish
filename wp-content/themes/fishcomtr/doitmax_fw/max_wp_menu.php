<?php
/**
 * Max_WP_Menu File
 *
 * File to create the WordPress menus in the theme
 *
 * @version: 1.0.0
 * @package  Maxframe / Max_WP_Menu
 * @author   doitmax
 * @link     http://doitmax.de
 */

/*--------------------------------------------------------------------------*/
/*	Register WP3.0+ Menus
/*--------------------------------------------------------------------------*/

register_nav_menus( array(
	'primary'           => __( 'Primary Navigation', MAX_SHORTNAME ),
	'footer-navigation' => __( 'Footer Navigation', MAX_SHORTNAME ),
) );

/*--------------------------------------------------------------------------*/
/*	Get our wp_nav_menu() fallback, wp_page_menu(), to show a home link.
/*--------------------------------------------------------------------------*/

function max_page_menu_args($args) {
	$args['show_home'] = true;
	return $args;
}
add_filter( 'wp_page_menu_args', 'max_page_menu_args' );

/*--------------------------------------------------------------------------*/
/*	Build the WP Navigation Menues
/*--------------------------------------------------------------------------*/
$max_show_mega_menus = get_option_max('menu_mega_menu', false);
$max_navigation_type = get_option_max('header_type', false);

if( $max_show_mega_menus === 'true' && $max_navigation_type !== 'full-height' ) {

	// Initialize the new mega menu
	require_once( MAX_FW_PATH . '/mega_menu/max_mega_menu_framework.php' );

	function max_create_theme_menu() {

		global $max_main_menu;

		if ( has_nav_menu( 'primary' ) ) :

			$max_main_menu = wp_nav_menu(array(
				'theme_location' => 'primary',
				'menu_class'     => 'nav max-navbar-nav sf-menu',
				'container'      => false,
				'items_wrap'     => '%3$s',
				'fallback_cb'    => 'MaxFrameFrontendWalker::fallback',
				'walker'         => new MaxFrameFrontendWalker(),
				'echo'           => false,
			));

		endif;

	}

} else {

	// Get the old menu instead
	function max_create_theme_menu() {

		global $max_main_menu;

		if ( has_nav_menu( 'primary' ) ) :

			$max_main_menu = wp_nav_menu( array(
				'theme_location' => 'primary',
				'menu_class'     => 'sf-menu',
				'container'      => false,
				'items_wrap'     => '%3$s',
				'walker'         => new MaxFrameDefaultWalker(),
				'echo'           => false,
			));

		endif;

	}

}

add_action( 'template_redirect', 'max_create_theme_menu' );

/*-----------------------------------------------------------------------------------*/
/*	Menu walker for the nav_menu menu
/*-----------------------------------------------------------------------------------*/
/* Special Thanks to kriesi for his tutorial about walker http://www.kriesi.at/archives/improve-your-wordpress-navigation-menu-output
*/

class MaxFrameDefaultWalker extends Walker_Nav_Menu {

	function start_el( &$content, $item, $depth = 0, $args = array(), $id = 0 ) {
		global $wp_query;
		$indent = ( $depth ) ? str_repeat( "", $depth ) : '';

		$css_classes = $value = '';
		$classes = empty( $item->classes ) ? array() : (array) $item->classes;

		$css_classes = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item ) );
		$css_classes = ' class="'. esc_attr( $css_classes ) . '"';

		$content .= $indent . '<li id="menu-item-'. $item->ID . '"' . $value . $css_classes .'>';

		$attr  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
		$attr .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
		$attr .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
		$attr .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';

		if(!empty($args->has_children)) :
  		$attr .= $args->has_children ? ' class="has-submenu"' : '';
    endif;

	    //print_r($args);

		$prep = ''; $app = '';
		$desc = ! empty( $item->description ) ? '<span>'.esc_attr( $item->description ).'</span>' : '';

		$item_output = $args->before;
		$item_output .= '<a'. $attr . '><span>';
		$item_output .= $args->link_before .apply_filters( 'the_title', $item->title, $item->ID );
		$item_output .= '</span></a>';
		$item_output .= $args->after;

		$content .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
	}
}

class Max_Mobile_Menu_Walker extends Walker_Nav_Menu {

	function start_el( &$content, $item, $depth = 0, $args = array(), $id = 0 ) {
		global $wp_query;
		$indent = ( $depth ) ? str_repeat( "", $depth ) : '';

		$css_classes = $value = '';
		$classes = empty( $item->classes ) ? array() : (array) $item->classes;

		$css_classes = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item ) );
		$css_classes = ' class="'. esc_attr( $css_classes ) . '"';

		$content .= $indent . '<li id="mobile-menu-item-'. $item->ID . '"' . $value . $css_classes .'>';

		$attr  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
		$attr .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
		$attr .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
		$attr .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';

		if(!empty($args->has_children)) :
  		$attr .= $args->has_children ? ' class="has-submenu"' : '';
    endif;

    //print_r($args);

		$prep = ''; $app = '';
		$desc = ! empty( $item->description ) ? '<span>'.esc_attr( $item->description ).'</span>' : '';



		$item_output = $args->before;
		$item_output .= '<a'. $attr . '><span>';
		$item_output .= $args->link_before .apply_filters( 'the_title', $item->title, $item->ID );
		$item_output .= '</span></a>';
		$item_output .= $args->after;

		$content .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
	}
}

?>