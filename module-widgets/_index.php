<?php

add_action( 'widgets_init', '_hwc_unregister_widgets', 100 );


function _hwc_unregister_widgets() {
  $disabled_widgets = apply_filters( 'hwc_disabled_widgets', [
    'WC_Widget_Product_Tag_Cloud',
  ] );

  foreach( $disabled_widgets as $w ) { 
    unregister_widget( $w );
  }
}