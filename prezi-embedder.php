<?php
/*
Plugin Name: Prezi Embedder
Plugin URI: http://dan.rossiters.org/projects/program-development/prezi-embedder-plugin/
Description: Allows for embedding the newest iframe-based Prezis from prezi.com using a simple shortcode [prezi id="<your id here>"].
Version: 1.1
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
      $err .= "Error: width attribute must be numeric. ";
    if(!is_numeric( $height ))
      $err .= "Error: height attribute must be numeric. ";
    if($lock_to_path !== 0 && $lock_to_path !== 1)
      $err .= "Error: lock_to_path may only be 0 or 1. ";
    if(!$id)
      $err .= "Error: You must, at minimum include an id attribute: [prezi id='&lt;Prezi ID&gt;'] ";
    // END VALIDATION

    if($err){
      return $err;
    } else {
      $ptn = '#.*prezi.com/([^/]+).*#';
      $rpl = "$1";
      $id = preg_replace( $ptn, $rpl, $id );
      return "<iframe src='http://prezi.com/embed/{$id}/?bgcolor=ffffff&amp;lock_to_path={$lock_to_path}&amp;autoplay=no&amp;autohide_ctrls=0' width='{$width}' height='{$height}' frameBorder='0'></iframe>";
    }
  }
  add_shortcode( 'prezi', 'prezi_shortcode' );

?>
