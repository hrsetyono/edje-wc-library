<?php

add_filter('woocommerce_add_to_cart_fragments', '_h_cart_button_fragment');

/**
 * Cart widget
 */
class H_Widget_Cart extends H_Widget {
  function __construct() {
    parent::__construct('h_cart', __('- WC Cart'), [
      'description' => __('Create a Cart dropdown menu')
    ]);
  }

  function widget($args, $instance) {
    $content = $args['before_widget'] . $this->render($args) . $args['after_widget'];
    echo $content;
  }

  private function render($args) {
    $id = $args['widget_id'];
    $style = get_field('style', "widget_$id");

    ob_start();
    ?>
    <div class="h-cart is-style-<?php echo $style ?>">
      <?php echo _h_cart_button(); ?>
      <?php the_widget('WC_Widget_Cart'); ?>
    </div>
    <?php

    $content = ob_get_clean();
    return $content;
  }
}

/**
 * Create the cart button
 */
function _h_cart_button() {
  global $woocommerce;
  $count = $woocommerce->cart->get_cart_contents_count();
  $count = $count > 0 ? "<b>{$count}</b>" : '';

  $extra_class = $woocommerce->cart->is_empty() ? 'is-cart-empty' : 'is-cart-filled';

  $args = apply_filters('h_cart_button_args', [
    'label' => '<span>' . __('Cart') . '</span>',
    'icon' => '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" width="50" height="50"><path d="M528.12 301.319l47.273-208C578.806 78.301 567.391 64 551.99 64H159.208l-9.166-44.81C147.758 8.021 137.93 0 126.529 0H24C10.745 0 0 10.745 0 24v16c0 13.255 10.745 24 24 24h69.883l70.248 343.435C147.325 417.1 136 435.222 136 456c0 30.928 25.072 56 56 56s56-25.072 56-56c0-15.674-6.447-29.835-16.824-40h209.647C430.447 426.165 424 440.326 424 456c0 30.928 25.072 56 56 56s56-25.072 56-56c0-22.172-12.888-41.332-31.579-50.405l5.517-24.276c3.413-15.018-8.002-29.319-23.403-29.319H218.117l-6.545-32h293.145c11.206 0 20.92-7.754 23.403-18.681z"/></svg>',
  ]);

  $button = "<a href='#' class='h-widget-button is-cart-button {$extra_class}'>
    {$args['icon']} {$count} {$args['label']}
  </a>";
  return $button;
}

/**
 * @filter woocommerce_add_to_cart_fragments
 */
function _h_cart_button_fragment($fragments) {
  $fragments['.is-cart-button'] = _h_cart_button();
  return $fragments;
}