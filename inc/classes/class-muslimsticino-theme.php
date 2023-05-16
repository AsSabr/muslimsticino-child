<?php
/**
 * Bootstraps the Theme.
 *
 * @package muslimsticino
 */

namespace Muslimsticino_Theme\Inc;

use Muslimsticino_Theme\Inc\Traits\Singleton;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Muslimsticino_Theme {

    use Singleton;

    protected function __construct()
    {

        // Load classes
		Assets::get_instance();
		Customizer::get_instance();

        $this->setup_hooks();

    }

    protected function setup_hooks()
    {

        /**
         * Actions.
         */

        add_action( 'after_setup_theme', [ $this, 'muslimsticino_setup' ] );

    }

    public function muslimsticino_setup()
    {
        /**
         * Make theme available for translation.
         * Translations can be filed in the /languages/ directory.
         * If you're building a theme based on muslimsticino, use a find and replace
         * to change 'muslimsticino' to the name of your theme in all the template files.
         */
        load_theme_textdomain( 'muslimsticino', MUSLIMSTICINO_DIR_PATH . '/languages' );

        // Add default posts and comments RSS feed links to head.
        add_theme_support( 'automatic-feed-links' );

        /**
         * Let WordPress manage the document title.
         * By adding theme support, we declare that this theme does not use a
         * hard-coded <title> tag in the document head, and expect WordPress to
         * provide it for us.
         */
        add_theme_support( 'title-tag' );

        /**
         * Enable support for Post Thumbnails on posts and pages.
         *
         * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
         */
        add_theme_support( 'post-thumbnails' );

        add_theme_support( 'post-formats', array( 'aside', 'gallery' ) );

        /**
         * Register image sizes.
         */
//        add_image_size( 'featured-thumbnail', 800, 430, true );

        /**
         * Switch default core markup for search form, comment form, and comments
         * to output valid HTML5.
         */
        add_theme_support(
            'html5',
            [
                'search-form',
                'comment-form',
                'comment-list',
                'gallery',
                'caption',
                'style',
                'script',
            ]
        );

        // Set up the WordPress core custom background feature.
        add_theme_support(
            'custom-background',
            apply_filters(
                'al_burhan_custom_background_args',
                [
                    'default-color' => 'fcfcfc',
                    'default-image' => '',
                ]
            )
        );

        /**
         * Add support for core custom logo.
         *
         * @link https://codex.wordpress.org/Theme_Logo
         */
        add_theme_support(
            'custom-logo',
            [
                'height'      => 250,
                'width'       => 250,
                'flex-width'  => true,
                'flex-height' => true,
            ]
        );

        /**
         * Add theme support for selective refresh for widgets.
         * WordPress 4.5 includes a new Customizer framework called selective refresh
         *
         * Selective refresh is a hybrid preview mechanism that has the performance benefit of not having to refresh the entire preview window.
         *
         * @link https://make.wordpress.org/core/2016/03/22/implementing-selective-refresh-support-for-widgets/
         */
        add_theme_support( 'customize-selective-refresh-widgets' );

        /**
         * Some blocks such as the image block have the possibility to define
         * a “wide” or “full” alignment by adding the corresponding classname
         * to the block’s wrapper ( alignwide or alignfull ). A theme can opt-in for this feature by calling
         * add_theme_support( 'align-wide' ), like we have done below.
         *
         * @see Wide Alignment
         * @link https://developer.wordpress.org/block-editor/developers/themes/theme-support/#wide-alignment
         */
        add_theme_support( 'align-wide' );

        /**
         * Set the maximum allowed width for any content in the theme,
         * like oEmbeds and images added to posts.
         *
         * @see Content Width
         * @link https://codex.wordpress.org/Content_Width
         */
        global $content_width;
        if ( ! isset( $content_width ) ) {
            $content_width = 1240;
        }
    }
}
