<?php

/**
 * Cart widget
 */
class H_Widget_MyAccount extends H_Widget {
  function __construct() {
    parent::__construct('h_myaccount', __('- WC My Account'), [
      'description' => __('Create a link to My Account page')
    ]);
  }

  function widget($args, $instance) {
    $content = $args['before_widget'] . $this->render($args) . $args['after_widget'];
    echo $content;
  }

  private function render($args) {
    $id = $args['widget_id'];
    $args = apply_filters('h_myaccount_button_args', [
      'label' => '<span>' . __('Sign In') . '</span>',
      'label_logged_in' => '<span>' . __('My Profile') . '</span>',
      'icon' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" width="50" height="50"><path d="M224 256c70.7 0 128-57.3 128-128S294.7 0 224 0 96 57.3 96 128s57.3 128 128 128zm89.6 32h-16.7c-22.2 10.2-46.9 16-72.9 16s-50.6-5.8-72.9-16h-16.7C60.2 288 0 348.2 0 422.4V464c0 26.5 21.5 48 48 48h352c26.5 0 48-21.5 48-48v-41.6c0-74.2-60.2-134.4-134.4-134.4z"/></svg>',
    ]);

    $label = is_user_logged_in() ? $args['label_logged_in'] : $args['label'];

    ob_start();
    ?>
    <a class="h-widget-button is-myaccount-button" href="<?php echo wc_get_page_permalink('myaccount'); ?>">
      <?php echo $args['icon']; ?>
      <?php echo $label; ?>
    </a>
    <?php

    $content = ob_get_clean();
    return $content;
  }
}