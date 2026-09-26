<?php
/**
 * Plugin Name: Example Widget
 * Description: Example Widget ontwikkeld voor WordPress en gemakkelijke support voor Elementor.
 * Version: 1.0.0
 * Author: Aaron Weggemans
 */

if (!defined('ABSPATH')) {
  exit;
}

/**
 * Registreer de Angular JavaScript- en CSS-bestanden.
 */
function build_widget_assets(): void
{
  $handle = 'ewfwp-example-app';

  $script_path = plugin_dir_path(__FILE__) . 'web-component/web-component.js';
  $style_path = plugin_dir_path(__FILE__) . 'web-component/assets/styles.css';

  $script_url = plugins_url('web-component/web-component.js', __FILE__);
  $style_url = plugins_url('web-component/assets/styles.css', __FILE__);

  if (file_exists($script_path)) {
    wp_register_script($handle . '-script', $script_url, [], (string) filemtime($script_path), true);
  }

  if (file_exists($style_path)) {
    wp_register_style($handle . '-style', $style_url, [], (string) filemtime($style_path));
  }
}

add_action('wp_enqueue_scripts', 'build_widget_assets');
add_action('elementor/frontend/after_register_scripts', 'build_widget_assets');
add_action('elementor/frontend/after_register_styles', 'build_widget_assets');

/**
 * Voeg een eigen JWZ-categorie toe aan de Elementor-zijbalk.
 */
function register_category($elements_manager): void {
  $elements_manager->add_category(
    'EWFWP Widgets',
    ['title' => esc_html__('EWFWP Widgets', 'ewfwp-example-app'), 'icon' => 'fa fa-plug']
  );
}

add_action('elementor/elements/categories_registered', 'register_category');

/**
 * Registreer de Elementor-widget.
 */
function register_widget($widgets_manager): void {
  require_once plugin_dir_path(__FILE__) . 'widgets/widget-config.php';
  $widgets_manager->register(new \EWFWP_Example_Widget());
}

add_action('elementor/widgets/register', 'register_widget');
