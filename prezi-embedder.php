<?php
defined('WPINC') OR exit;

/*
  Plugin Name: Prezi Embedder
  Plugin URI: http://wordpress.org/extend/plugins/prezi-embedder/
  Description: Allows for embedding the newest iframe-based Prezis from <a href="http://www.prezi.com/recommend/qv1ms7qvtplw">prezi.com</a> using a simple shortcode [prezi id="&lt;your id here&gt;"].
  Version: 1.4
  Author: Dan Rossiter
  Author URI: http://danrossiter.org/
  License: GPLv2
  Text Domain: prezi-embedder
 */

// shortcode
add_shortcode('prezi', array('PreziEmbedder', 'doShortcode'));

// I18n
add_action('plugins_loaded', array('PreziEmbedder', 'loadTextDomain'));

PreziEmbedder::init();

class PreziEmbedder {
   private static $attr_err, $bool_err, $comment, $int_err, $min_req;
   
   /**
    * Initializes static values for PreziEmbedder.
    */
   public static function init() {
      if (!isset(self::$comment)) {
         self::$comment =
            '<!-- ' .
            __('Generated using Prezi Embedder. Get yours here:', 'prezi-embedder') .
            ' http://wordpress.org/plugins/prezi-embedder/ -->' . PHP_EOL;
         self::$attr_err  =
            __('Error: The %1$s attribute provided does not look right. You entered %1$s=%2$s. ', 'prezi-embedder');
         self::$bool_err =
            __('Error: The %1$s attribute may only be %2$s or %3$s. You entered %1$s=%4$s', 'prezi-embedder');
         self::$int_err = 
            __('Error: The %1$s attribute must be an integer. You entered %1$s=%2$s. ', 'prezi-embedder');
         self::$min_req =
            __('Error: You must, at minimum include an id attribute:', 'prezi-embedder');
      }
   }
   
   /**
    * Does the shortcode.
    * @param array $atts
    * @return string The embed code on success or error string(s) on failure.
    */
   public static function doShortcode($atts) {
      static $ptn = '#.*prezi.com/([^/]+).*#';
      
      // get arguments from user
      extract(shortcode_atts(
         array(
             'id'           => null,
             'width'        => 500,
             'height'       => 400,
             'lock_to_path' => 0,
             'html5'        => 1),
         $atts));

      $err = '';

      // validate & sanitize input
      if (!($id = preg_replace($ptn, '$1', $id))) {
         $err .= sprintf(self::$attr_err, 'id', $id);
      }
      
      if ((int) $width != $width || (int) $width < 1) {
         $err .= sprintf(self::$int_err, 'width', $width);
      } else {
         $width = (int)$width;
      }
      
      if ((int) $height != $height || (int) $height < 1) {
         $err .= sprintf(self::$int_err, 'height', $height);
      } else {
         $height = (int)$height;
      }
      
      if ($lock_to_path != 0 && $lock_to_path != 1) {
         $err .= sprintf(self::$bool_err, 'lock_to_path', 0, 1, $lock_to_path);
      } else {
         $lock_to_path = (int)$lock_to_path;
      }
      
      if ($html5 != 0 && $html5 != 1) {
         $err .= sprintf(self::$bool_err, 'html5', 0, 1, $html5);
      } else {
         $html5 = (int)$html5;
      }
      
      if (empty($id)) {
         $err .= self::$min_req . ' [prezi id=\'&lt;Prezi ID&gt;\'] ';
      }

      // tell user what they did wrong
      if ($err) return $err;
      
      return
         self::$comment .
         "<iframe src='//prezi.com/embed/{$id}/?bgcolor=ffffff&amp;" .
         "lock_to_path={$lock_to_path}&amp;autoplay=0&amp;autohide_ctrls=0&amp;" .
         "features=undefined&amp;disabled_features=undefined&amp;html5={$html5}' " .
         "width='{$width}' height='{$height}' frameBorder='0' " .
         "webkitAllowFullScreen mozAllowFullscreen allowfullscreen></iframe>";
   }
   
   /**
    * Load I18n
    */
   public static function loadTextDomain() {
      load_plugin_textdomain('prezi-embedder', false, dirname(plugin_basename(__FILE__ )) . '/languages/');
   }
}