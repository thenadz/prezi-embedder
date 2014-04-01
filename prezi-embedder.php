<?php
defined('WPINC') OR exit;

/*
  Plugin Name: Prezi Embedder
  Plugin URI: http://wordpress.org/extend/plugins/prezi-embedder/
  Description: Allows for embedding the newest iframe-based Prezis from <a href="http://www.prezi.com/recommend/qv1ms7qvtplw">prezi.com</a> using a simple shortcode [prezi id="&lt;your id here&gt;"].
  Version: 1.3
  Author: Dan Rossiter
  Author URI: http://danrossiter.org/
  License: GPLv2
  Text Domain: prezi-embedder
 */

// shortcode
add_shortcode('prezi', array('PreziEmbedder', 'doShortcode'));

// I18n
add_action('plugins_loaded', array('PreziEmbedder', 'loadTextDomain'));

class PreziEmbedder {
   private $bool_err, $comment, $int_err, $id_err, $min_req;
   
   public function __construct() {
      $this->comment =
         '<!-- ' .
         __('Generated using Prezi Embedder. Get yours here:', 'prezi-embedder') .
         ' http://wordpress.org/plugins/prezi-embedder/ -->' . PHP_EOL;
      $this->bool_err =
         __('Error: The %1$s attribute may only be %2$s or %3$s. You entered %1$s=%4$s', 'prezi-embedder');
      $this->int_err = 
         __('Error: The %1$s attribute must be an integer. You entered %1$s=%2$s. ', 'prezi-embedder');
      $this->attr_err  =
         __('Error: The %1$s attribute provided does not look right. You entered %1$s=%2$s. ', 'prezi-embedder');
      $this->min_req =
         __('Error: You must, at minimum include an id attribute:', 'prezi-embedder');
   }
   
   /**
    * Does the shortcode.
    * @param array $atts
    * @return string The embed code on success or error string(s) on failure.
    */
   public static function doShortcode($atts) {
      extract(shortcode_atts(
         array(
             'id' => null,
             'width' => 500,
             'height' => 400,
             'lock_to_path' => 0),
         $atts));

      $ptn = '#.*prezi.com/([^/]+).*#';
      $err = '';

      // VALIDATE INPUT
      if (!($id = preg_replace($ptn, '$1', $id))) {
         $err .= sprintf($this->attr_err, 'id', $id);
      }
      
      if ((int) $width != $width || (int) $width < 1) {
         $err .= sprintf($this->int_err, 'width', $width);
      }
      
      if ((int) $height != $height || (int) $height < 1) {
         $err .= sprintf($this->int_err, 'height', $height);
      }
      
      if ($lock_to_path != 0 && $lock_to_path != 1) {
         $err .= sprintf($this->bool_err, 'lock_to_path', 0, 1, $lock_to_path);
      }
      
      if (!$id) {
         $err .= $this->min_req . ' [prezi id=\'&lt;Prezi ID&gt;\'] ';
      }
      // END VALIDATION

      // tell user what they did wrong
      if ($err) return $err;
      
      return
         "<iframe src='http://prezi.com/embed/{$id}/?bgcolor=ffffff&amp;" .
         "lock_to_path={$lock_to_path}&amp;autoplay=0&amp;autohide_ctrls=0&amp;" .
         "features=undefined&amp;disabled_features=undefined' " .
         "width='{$width}' height='{$height}' frameBorder='0' " .
         "webkitAllowFullScreen mozAllowFullscreen allowfullscreen></iframe>";
   }
   
   public static function loadTextDomain() {
      load_plugin_textdomain('prezi-embedder', false, dirname(plugin_basename(__FILE__ )) . '/languages/');
   }
}