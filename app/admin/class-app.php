<?php
/**
 * Main App File
 *
 * @package    WordPress
 * @subpackage Sm_sticky_clicky_star
 */

namespace SM\Sticky_Clicky_Star\Admin;

/**
 * Class App
 */
class App {

	/**
	 * Plugins class object installed directory on the server.
	 *
	 * @var string $installed_dir Installed server directory.
	 */
	public $installed_dir;

	/**
	 * Plugins URL for access to any static files or assets like css, js, or media.
	 *
	 * @var string $installed_url Installed URL.
	 */
	public $installed_url;

	/**
	 * If plugin_data is built, this represents the version number defined the the main plugin file meta.
	 *
	 * @var string $version Version.
	 */
	public $version;

	/**
	 * Add auth'd/admin functionality via new Class() instantiation, add_action() and add_filter() in this method.
	 *
	 * @param string $installed_dir Installed server directory.
	 * @param string $installed_url Installed URL.
	 * @param string $version       Version.
	 */
	public function __construct( $installed_dir, $installed_url, $version ) {
		$this->installed_dir = $installed_dir;
		$this->installed_url = $installed_url;
		$this->version       = $version;

		add_action( 'post_submitbox_misc_actions', [ $this, 'sticky_meta' ] );
		add_filter( 'manage_posts_columns', [ $this, 'add_sticky_column' ] );
		// adds sticky star to appthemes themes.
		if ( defined( 'APP_POST_TYPE' ) ) {
			add_filter( 'manage_edit-' . APP_POST_TYPE . '_columns', [ $this, 'add_sticky_column' ] );
		}
		add_action( 'manage_posts_custom_column', [ $this, 'sticky_column_content' ] );
		add_action( 'wp_ajax_sm_sticky', [ $this, 'sticky_callback' ] );

		// load style and js on pages that need it, note that admin_enqueue_styles does not work as of WP 4.0.0.
		add_action( 'admin_enqueue_scripts', [ $this, 'click_to_stick_styles' ] );
		add_action( 'admin_enqueue_scripts', [ $this, 'click_to_stick_scripts' ] );
	}

	/**
	 * Add column callback for sticky star column.
	 *
	 * @param array $columns Existing columns.
	 *
	 * @return array
	 */
	public function add_sticky_column( $columns ) {
		$columns['sticky'] = 'Sticky';

		return $columns;
	}

	/**
	 * Add admin stylesheet registration
	 *
	 * @param string $hook Hook name.
	 */
	public function click_to_stick_styles( $hook ) {
		if ( 'edit.php' === $hook || 'post.php' === $hook ) {
			wp_enqueue_style( 'sm_click_to_stick_styles', $this->installed_url . 'assets/css/sm-click-to-stick.css', [], '1.0.0', 'all' );
		}
	}

	/**
	 * Add admin javascript.
	 *
	 * @param string $hook Hook name.
	 */
	public function click_to_stick_scripts( $hook ) {
		if ( 'edit.php' === $hook || 'post.php' === $hook ) {
			wp_enqueue_script( 'sm_click_to_stick_scripts', $this->installed_url . 'assets/js/sm-click-to-stick.js', [ 'jquery' ], $this->version, true );
		}
	}

	/**
	 * Sticky meta html form.
	 */
	public function sticky_meta() {
		global $post;
		if ( 'page' !== $post->post_type ) {
			echo '<div id="smSticky" class="misc-pub-section ">Make Sticky: ' . wp_kses( $this->get_sticky_link( $post->ID ), 'post' ) . '</div>';
		}
	}

	/**
	 * Sticky column html content.
	 *
	 * @param string $name Name of the column.
	 */
	public function sticky_column_content( $name ) {
		global $post;
		if ( 'sticky' === $name ) {
			echo wp_kses( $this->get_sticky_link( $post->ID ), 'post' );
		}
	}

	/**
	 * Get sticky link url.
	 *
	 * @param string $the_post_id Related post ID.
	 *
	 * @return string
	 */
	public function get_sticky_link( $the_post_id = '' ) {
		global $post;
		if ( empty( $the_post_id ) ) {
			$the_post_id = $post->ID;
		}
		$sticky_class = '';
		$sticky_title = 'Make Sticky';
		if ( is_sticky( $the_post_id ) ) {
			$sticky_class = 'isSticky';
			$sticky_title = 'Remove Sticky';
		}
		$sticky_link = '<a href="id=' . $the_post_id . '&code=' . wp_create_nonce( 'sm_sticky_nonce' ) . '" id="smClickToStick' . $the_post_id . '" class="smClickToStick ' . $sticky_class . '" title="' . $sticky_title . '"></a>';

		return $sticky_link;
	}

	/**
	 * Sticky click action callback.
	 */
	public function sticky_callback() {
		$code = static::get_server_post_param( 'code', 'code', 'sm_sticky_nonce' );
		if ( empty( $code ) ) {
			// failed nonce validation.
			die( 'Invalid Nonce.' );
		}

		$sticky_posts = get_option( 'sticky_posts' );

		if ( ! is_array( $sticky_posts ) ) {
			$sticky_posts = [];
		}

		$submitted_post_id = static::get_server_post_param( 'id', 'code', 'sm_sticky_nonce' );
		if ( in_array( $submitted_post_id, $sticky_posts, true ) ) {
			$remove_key = array_search( $submitted_post_id, $sticky_posts, true );
			unset( $sticky_posts[ $remove_key ] );
			$sticky_result = 'removed';
		} else {
			array_unshift( $sticky_posts, $submitted_post_id );
			$sticky_result = 'added';
		}

		if ( update_option( 'sticky_posts', $sticky_posts ) ) {
			die( esc_attr( $sticky_result ) );
		} else {
			die( 'An error occured' );
		}
	}

	/**
	 * Utility helper function for sanatizing globals
	 *
	 * @param string $key            $_POST key that you want the value of.
	 *
	 * @param string $nonce_post_key The key of the $_POST which contains the nonce value.
	 * @param string $nonce_action   The action attached to the nonce created value.
	 *
	 * @return string
	 */
	public static function get_server_post_param( $key, $nonce_post_key, $nonce_action ) {
		if ( isset( $_POST[ $key ], $_POST[ $nonce_post_key ] ) && wp_verify_nonce( sanitize_key( $_POST[ $nonce_post_key ] ), $nonce_action ) ) {
			$sanitized_value = sanitize_text_field( wp_unslash( $_POST[ $key ] ) );

			return $sanitized_value;
		} else {
			echo 'Nonce verification failed.';

			return '';
		}
	}

}
