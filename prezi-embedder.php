<?php
/*
Plugin Name: Prezi Embedder
Plugin URI: http://wordpress.org/extend/plugins/prezi-embedder/
Description: Allows for embedding the newest iframe-based Prezis from <a href="http://www.prezi.com/recommend/qv1ms7qvtplw">prezi.com</a> using a simple shortcode [prezi id="&lt;your id here&gt;"].
Version: 1.2
Author: Dan Rossiter
Author URI: http://danrossiter.org/
*/

  function prezi_shortcode( $atts ){
    extract( shortcode_atts( array(
      'id' => null,
      'width' => 500,
      'height' => 400,
      'lock_to_path' => 0
    ), $atts ) );

    $err = '';

    // VALIDATE INPUT
    if(!is_numeric( $width ))
      $err .= "Error: width attribute must be numeric. You entered width=$width. ";
    if(!is_numeric( $height ))
      $err .= "Error: height attribute must be numeric. You entered height=$height. ";
    if($lock_to_path != 0 && $lock_to_path != 1)
      $err .= "Error: lock_to_path may only be 0 or 1. You entered lock_to_path=$lock_to_path. ";
    if(!$id)
      $err .= "Error: You must, at minimum include an id attribute: [prezi id='&lt;Prezi ID&gt;'] ";
    // END VALIDATION

    if($err){
      return $err;
    } else {
      $ptn = '#.*prezi.com/([^/]+).*#';
      $rpl = "$1";
      $id = preg_replace( $ptn, $rpl, $id );
      return '<!-- Prezi Embedder -->'.PHP_EOL.
             "<iframe src='http://prezi.com/embed/{$id}/?bgcolor=ffffff&amp;lock_to_path={$lock_to_path}&amp;autoplay=no&amp;autohide_ctrls=0' ".
             "width='{$width}' height='{$height}' frameBorder='0'></iframe>".PHP_EOL.
             '<!-- / Prezi Embedder -->'.PHP_EOL;
    }
  }
  add_shortcode( 'prezi', 'prezi_shortcode' );

?>
