<?php
require_once('helpers.php');

define("APP_DEFAULT_PARTIAL_PATH", "_default_partial_directory");
class Application {
  private $helpers;
  private $partial_roots;

  function __construct() {
    $this->helpers = array();
    $this->partial_roots = array(APP_DEFAULT_PARTIAL_PATH => dirname(__FILE__).'/../include/partials');
  }

  public function add_partial_root($name, $value) {
    $partial_roots[$name] = $value;
  }

  public function helper($name) {
    return $this->helper_object($name.'_helper');
  }

  public function helper_object($name) {
    if(!$this->helpers[$name]) {
      $this->helpers[$name] = eval("return new ".$this->camelize($name).';');
    }

    return $this->helpers[$name];
  }

  public function partial_path($name) {
    foreach($partial_roots as $root => $path) {
      $partial_path = join('/',array($path,$name));
      if(file_exists($partial_path)) {
        return $partial_path;
      }
    }
    echo "<!-- WARNING could not find partial $name in partial paths ";
    var_dump($partial_roots);
    echo "-->";
    return '';
  }

  public function partial() {
    $args = func_get_args();
    $name = array_shift($args);
    $vars = array_shift($args);
    foreach($vars as $var => $value) {
      $$var = $value;
    }
    include($this->partial_path($name));
  }

  public function camelize($str) {
    return preg_replace('/(?:^|_)(.?)/e',"strtoupper('$1')",$str);
  }

  public function category() {
    preg_match('/category\/([^\/]+)/', $this->uri(), $path);
    if(!$path[1]) {
      preg_match('/([^\/\?]+)/', $this->uri(), $path);
    }

    return $path[1];
  }

  public function uri() {
    return $_SERVER['REQUEST_URI'];
  }
}
