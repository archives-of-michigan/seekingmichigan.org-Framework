<?php
require_once('helpers.php');

class Application {
  private $helpers = array();

  public function helper($name) {
    return $this->helper_object($name.'_helper');
  }

  public function helper_object($name) {
    if(!$helpers[$name]) {
      $helpers[$name] = eval("return new ".$this->camelize($name).';');
    }

    return $helpers[$name];
  }

  public function partial() {
    $args = func_get_args();
    $name = array_shift($args);
    $vars = array_shift($args);
    foreach($vars as $var => $value) {
      $$var = $value;
    }
    include(dirname(__FILE__).'/../include/partials/'.$name.'.php');
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
