<?php
/**
 * Enqueue theme assets
 *
 * @package muslimsticino
 */

namespace Muslimsticino_Theme\Inc;

use Muslimsticino_Theme\Inc\Traits\Singleton;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Assets {

	use Singleton;

	protected function __construct() {
		$this->setup_hooks();
	}

	protected function setup_hooks() {

		/**
		 * Actions.
		 */
//		add_action( 'wp_enqueue_scripts', [ $this, 'register_styles' ] );
		add_action( 'elementor/frontend/after_enqueue_styles', [ $this, 'register_styles' ] ); // enqueue after elementor's styles
		add_action( 'wp_enqueue_scripts', [ $this, 'register_scripts' ] );
	}
	
	public function register_styles() {
		
		wp_enqueue_style( 'muslimsticino-in-wp', get_stylesheet_uri(), [], filemtime(get_stylesheet_directory() . '/style.css') );
		// Register styles.
		wp_register_style( 'muslimsticino', MUSLIMSTICINO_CSS_URI . '/app.min.css', [], filemtime( MUSLIMSTICINO_CSS_PATH . '/app.min.css' ), 'all' );

		// Enqueue Styles.
		wp_enqueue_style( 'muslimsticino' );
	}

	public function register_scripts() {
		// Register scripts.
		wp_register_script( 'muslimsticino',MUSLIMSTICINO_JS_URI . '/app.min.js', [], filemtime( MUSLIMSTICINO_JS_PATH . '/app.min.js' ), true );

		// Enqueue Scripts.
		wp_enqueue_script( 'muslimsticino' );
	}

}
