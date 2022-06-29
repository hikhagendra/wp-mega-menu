<?php
/**
 * mega menu functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package mega_menu
 */

if ( ! defined( '_S_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( '_S_VERSION', '1.0.0' );
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function mega_menu_setup() {
	/*
		* Make theme available for translation.
		* Translations can be filed in the /languages/ directory.
		* If you're building a theme based on mega menu, use a find and replace
		* to change 'mega-menu' to the name of your theme in all the template files.
		*/
	load_theme_textdomain( 'mega-menu', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
		* Let WordPress manage the document title.
		* By adding theme support, we declare that this theme does not use a
		* hard-coded <title> tag in the document head, and expect WordPress to
		* provide it for us.
		*/
	add_theme_support( 'title-tag' );

	/*
		* Enable support for Post Thumbnails on posts and pages.
		*
		* @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		*/
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus(
		array(
			'menu-1' => esc_html__( 'Primary', 'mega-menu' ),
		)
	);

	/*
		* Switch default core markup for search form, comment form, and comments
		* to output valid HTML5.
		*/
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);

	// Set up the WordPress core custom background feature.
	add_theme_support(
		'custom-background',
		apply_filters(
			'mega_menu_custom_background_args',
			array(
				'default-color' => 'ffffff',
				'default-image' => '',
			)
		)
	);

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );

	/**
	 * Add support for core custom logo.
	 *
	 * @link https://codex.wordpress.org/Theme_Logo
	 */
	add_theme_support(
		'custom-logo',
		array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		)
	);
}
add_action( 'after_setup_theme', 'mega_menu_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function mega_menu_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'mega_menu_content_width', 640 );
}
add_action( 'after_setup_theme', 'mega_menu_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function mega_menu_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'mega-menu' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'mega-menu' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'mega_menu_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function mega_menu_scripts() {
	wp_enqueue_style( 'mega-menu-style', get_stylesheet_uri(), array(), _S_VERSION );
	wp_style_add_data( 'mega-menu-style', 'rtl', 'replace' );
	wp_enqueue_style( 'bootstrap', 'https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css', 'jquery', '5.2.0', 'all' );
	wp_enqueue_style( 'megamenu', get_template_directory_uri() . '/css/megamenu.css', array(), '1.0.0', 'all' );

	wp_enqueue_script( 'mega-menu-navigation', get_template_directory_uri() . '/js/navigation.js', array(), _S_VERSION, true );
	wp_enqueue_script( 'bootstrapjs', 'https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js', 'jquery', '5.2.0', true );
	wp_deregister_script( 'jquery' );
	wp_enqueue_script( 'jquery', get_template_directory_uri() . '/js/jquery.js', false, '3.6.0', true );
	wp_enqueue_script( 'megamenu', get_template_directory_uri() . '/js/megamenu.js', array('jquery'), '1.0.0', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'mega_menu_scripts' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}

/**
 * Walker Nav file.
 */
require get_template_directory() . '/inc/WalkerNav.php';

// MEGA MENU CUSTOM FIELDS SECTION

// Create fields
function fields_list() {
	return array(
		'mm-megamenu'		=>	'Activate MegaMenu',
		'mm-column-divider'=>	'Column Divider',
		'mm-divider'		=>	'Inline Divider',
		'mm-featured-image'=>	'Featured Image',
		'mm-description'	=>	'Description'
	);
}

// Setup fields
function megamenu_fields( $id, $item, $depth, $args ) {

	$fields = fields_list();

	foreach ( $fields as $_key => $label ) :

		$key = sprintf( 'menu-item-%s', $_key );
		$id = sprintf( 'edit-%s-%s', $key, $item->ID );
		$name = sprintf( '%s[%s]', $key, $item->ID );
		$value = get_post_meta( $item->ID, $key, true );
		$class = sprintf( 'field-%s', $_key );

		?>

		<p class="description description-wide <?php echo esc_attr( $class ); ?>">
			<label for="<?php echo esc_attr( $id ); ?>">
				<input type="checkbox" name="<?php echo esc_attr( $name ); ?>" id="<?php echo esc_attr( $id ); ?>" value="1" <?php echo ( $value == 1 ) ? 'checked: checked' : ''; ?>>
				<?php echo esc_attr( $label ); ?>
			</label>
		</p>

		<?php

	endforeach;

}

add_action( 'wp_nav_menu_item_custom_fields', 'megamenu_fields', 10, 4 );

// Show columns
function megamenu_columns( $columns ) {
	$fields = fields_list();

	$columns = array_merge( $columns, $fields );

	return $columns;
}

add_filter( 'manage_nav-menus_columns', 'megamenu_columns', 99 );

// Save/Update fields
function megamenu_save( $menu_id, $menu_item_db_id, $menu_item_args ) {
	if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) {
		return;
	}

	check_admin_referer( 'update-nav_menu', 'update-nav-menu-nonce' );

	$fields = fields_list();

	foreach( $fields as $_key => $label ) :

		$key = sprintf( 'menu-item-%s', $_key );

		// Sanitize
		if ( ! empty( $_POST[ $key ][$menu_item_db_id] ) ) {
			$value = $_POST[ $key ][$menu_item_db_id];
		} else {
			$value = null;
		}

		// Save or Update
		if ( ! is_null( $value ) ) {
			update_post_meta( $menu_item_db_id, $key, $value );
		} else {
			delete_post_meta( $menu_item_db_id, $key );
		}

	endforeach;
}

add_action( 'wp_update_nav_menu_item', 'megamenu_save', 10, 3 );

// Update the Walker Nav Class
function megamenu_walkernav( $walker ) {
	$walker = 'MegaMenu_Walker_Edit';
	if ( ! class_exists( $walker ) ) {
		require_once dirname( __FILE__ ) . '/inc/walker-nav-menu-edit.php';
	}

	return $walker;
}

add_filter( 'wp_edit_nav_menu_walker', 'megamenu_walkernav', 99 );










