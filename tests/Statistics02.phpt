<?php
// +----------------------------------------------------------------------+
// | PHP Version 4                                                        |
// +----------------------------------------------------------------------+
// | Copyright (c) 1997-2003 The PHP Group                                |
// +----------------------------------------------------------------------+
// | This source file is subject to version 2.02 of the PHP license,      |
// | that is bundled with this package in the file LICENSE, and is        |
// | available at through the world-wide-web at                           |
// | http://www.php.net/license/2_02.txt.                                 |
// | If you did not receive a copy of the PHP license and are unable to   |
// | obtain it through the world-wide-web, please send a note to          |
// | license@php.net so we can mail you a copy immediately.               |
// +----------------------------------------------------------------------+
// | Author: George Schlossnagle <george@omniti.com>                      | 
// +----------------------------------------------------------------------+
//
// $Id$

require_once "PHPUnit.php";
require_once "Text/Statistics.php";

class ParagraphTestCase extends PHPUnit_TestCase {
  var $sample;
  var $sampleAbbr;
  var $object;
  
  function setUp() 
  {
    $this->sample = "
This is a test of the multi paragraph support.


We'll try to be a bit clever.

Hopefully clever enough.

";
    $this->object = new Text_Statistics($this->sample);
  }  
  function TextTestCase($name) 
  {
    $this->PHPUnit_TestCase($name);
  }
  function testNumParagraphs() 
  {
    $this->assertEquals(3, $this->object->getNumParagraphs());
  }
}
$suite = new PHPUnit_TestSuite('ParagraphTestCase');
$result = PHPUnit::run($suite);
echo $result->toString();
?>
