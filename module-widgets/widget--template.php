<?php
/**
 * This is a template to create new widget
 */
class HWC_WidgetName extends HWC_Widget { 
  function __construct() {
    parent::__construct('h_name', __('- Name'), [
      'description' => __('Short description here')
    ]);
  }

  function widget($args, $instance) {
    $widget_id = 'widget_' . $args['widget_id'];
    $data = [
      'acf_field' => get_field('acf_field', $widget_id),
    ];

    $custom_render = apply_filters('h_widget_name', '', $data);

    echo $args['before_widget'];
    echo $custom_render ? $custom_render : $this->render_widget($data);
    echo $args['after_widget'];
  }

  function render_widget($data) {
    [
      'acf_field' => $acf_field,
    ] = $data;
    ob_start(); ?>

    <div>
      <?= $acf_field ?>
    </div>

    <?php return ob_get_clean();
  }
}