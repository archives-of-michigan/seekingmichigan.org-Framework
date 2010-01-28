<?php
require_once('helpers.php');

class Application {
  define('DEFAULT', '_default_partial_directory');
  private $helpers = array();
  private $partial_roots = array(DEFAULT => dirname(__FILE__).'/../include/partials');

  public add_partial_root($name, $value) {
    $partial_roots[$name] = $value;
  }

  public function helper($name) {
    return $this->helper_object($name.'_helper');
  }

  public function helper_object($name) {
    if(!$helpers[$name]) {
      $helpers[$name] = eval("return new ".$this->camelize($name).';');
    }

    return $helpers[$name];
  }

  public partial_path($name) {
    $paths = preg_split('/\//', $name);
    if(count($paths) > 1) {
      $file = array_pop($name);
      $partial_root = join('/',$name);
      return $partial_roots[$partial_root].$file.'.php';
    } else {
      return $partial_roots[DEFAULT].$name.'.php';
    }
  }

  public function partial() {
    $args = func_get_args();
    $name = array_shift($args);
    $vars = array_shift($args);
    foreach($vars as $var => $value) {
      $$var = $value;
    }
    include(partial_path($name));
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
