<?php

if (!defined('ABSPATH')) {
  exit;
}

class EWFWP_Example_Widget extends \Elementor\Widget_Base {
  public function get_name(): string {
    return 'ewfwp-example-app';
  }

  public function get_title(): string {
    return esc_html__('Hypotheekcalculator', 'ewfwp-example-app');
  }

  public function get_icon(): string {
    return 'eicon-site-identity';
  }

  public function get_categories(): array {
    return ['ewfwp-widgets'];
  }

  protected function register_controls(): void {
    $this->end_controls_section();
  }

  protected function render(): void {
    // printf('<ewfwp-example-app option="%s"></ewfwp-example-app>', $option)
    printf('<ewfwp-example-app></ewfwp-example-app>',);
  }

  /**
   * Preview die Elementor direct in de editor kan renderen.
   */
  protected function content_template(): void
  {
    ?>
      <ewfwp-example-app>Loading...</ewfwp-example-app>
    <?php
  }
}
