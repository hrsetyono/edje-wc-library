<?php

/**
 * Cart widget
 */
class HWC_Widget_MyAccount extends HWC_Widget {
  function __construct() {
    parent::__construct('hwc_myaccount', __('- WC MyAccount'), [
      'description' => __('Create a link to My Account page')
    ]);
  }

  function widget($args, $instance) {
    $widget_id = 'widget_' . $args['widget_id'];

    $label_logged_out = get_field('label_logged_out', $widget_id);
    $label_logged_in = get_field('label_logged_in', $widget_id);

    $data = apply_filters('hwc_widget_myaccount_args', [
      'label_logged_out' => $label_logged_out ? $label_logged_out : 'Login',
      'label_logged_in' => $label_logged_in ? $label_logged_in : 'View Profile',
      'icon' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" width="50" height="50"><path d="M224 256c70.7 0 128-57.3 128-128S294.7 0 224 0 96 57.3 96 128s57.3 128 128 128zm89.6 32h-16.7c-22.2 10.2-46.9 16-72.9 16s-50.6-5.8-72.9-16h-16.7C60.2 288 0 348.2 0 422.4V464c0 26.5 21.5 48 48 48h352c26.5 0 48-21.5 48-48v-41.6c0-74.2-60.2-134.4-134.4-134.4z"/></svg>',
    ]);
  
    $custom_render = apply_filters('hwc_widget_myaccount', '', $data);

    echo $args['before_widget'];
    echo $custom_render ? $custom_render : $this->render_widget($data);
    echo $args['after_widget'];
  }

  function render_widget($data) {
    [
      'label_logged_out' => $label_logged_out,
      'label_logged_in' => $label_logged_in,
      'icon' => $icon,
    ] = $data;
    ob_start(); ?>

    <a
      class="h-widget-button is-myaccount-button"
      href="<?= wc_get_page_permalink('myaccount'); ?>"
    >
      <?= $icon ?>

      <?php if (is_user_logged_in() && $label_logged_in): ?>
        <span>
          <?= $label_logged_in ?>
        </span>

      <?php elseif ($label_logged_out): ?>
        <span>
          <?= $label_logged_out ?>
        </span>

      <?php endif; ?>
    </a>

    <?php return ob_get_clean();
  }
}