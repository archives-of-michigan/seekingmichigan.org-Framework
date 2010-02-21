<?php
require_once dirname(__FILE__).'/../lib/application.php';

class ApplicationTest extends PHPUnit_Framework_TestCase {
  public function testCamelize() {
    $app = new Application;
    $this->assertEquals('CamelCase',$app->camelize('camel_case'));
    $this->assertEquals('Camelicious',$app->camelize('camelicious'));
  }

  public function testCategoryWithCategory() {
    $app = $this->getMock('Application', array('uri'));
     
    $app->expects($this->any())
         ->method('uri')
         ->will($this->returnValue('/category/look'));
    $this->assertEquals('look',$app->category());
  }
  public function testCategoryWithoutCategory() {
    $app = $this->getMock('Application', array('uri'));
     
    $app->expects($this->any())
         ->method('uri')
         ->will($this->returnValue('/look'));
    $this->assertEquals('look',$app->category());
  }
  public function testCategoryWithPaging() {
    $app = $this->getMock('Application', array('uri'));
     
    $app->expects($this->any())
         ->method('uri')
         ->will($this->returnValue('/look/page/2'));
    $this->assertEquals('look',$app->category());
  }

  public function testPartialPathWithRoot() {
    $app = $this->getMock('Application', array('partial_exists'));

    $app->add_partial_root('cdm', '/path/to/cdm');

    $app->expects($this->any())
        ->method('partial_exists')
        ->will($this->returnValue(true));

    $this->assertNotEquals('', $app->partial_path('cdm/myfile.php'));
  }
}
