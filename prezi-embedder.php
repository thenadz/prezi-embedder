<?php
/*
Plugin Name: Prezi Embedder
Plugin URI: http://dan.rossiters.org/projects/program-development/prezi-embedder-plugin/
Description: Allows for embedding the newest iframe-based Prezis from prezi.com using a simple shortcode [prezi id="<your id here>"].
Version: 1.0
Author: Dan Rossiter
Author URI: http://danrossiter.org/
*/

  function prezi_shortcode( $atts ){
    extract( shortcode_atts( array(
      'id' => false,
      'width' => 500,
      'height' => 400,
      'lock_to_path' => 0
    ), $atts ) );
    if($id){
      return "<iframe src='http://prezi.com/embed/{$id}/?bgcolor=ffffff&amp;lock_to_path={$lock_to_path}&amp;autoplay=no&amp;autohide_ctrls=0' width='{$width}' height='{$height}' frameBorder='0'></iframe>";
    }
    return;
  }
  add_shortcode( 'prezi', 'prezi_shortcode' );

?>
