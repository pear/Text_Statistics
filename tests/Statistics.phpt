<?php
/* vim: set expandtab tabstop=4 softtabstop=4 shiftwidth=4: */
// +----------------------------------------------------------------------+
// | PHP version 4ÊÊÊÊÊÊÊÊÊÊÊÊÊÊÊÊÊÊÊÊÊÊÊÊÊÊÊÊÊÊÊÊÊÊÊÊÊÊÊÊÊÊÊÊÊÊÊÊÊÊÊÊÊÊÊÊ|
// +----------------------------------------------------------------------+
// | Copyright (c) 1997-2002 The PHP GroupÊÊÊÊÊÊÊÊÊÊÊÊÊÊÊÊÊÊÊÊÊÊÊÊÊÊÊÊÊÊÊÊ|
// +----------------------------------------------------------------------+
// | This source file is subject to version 2.0 of the PHP license,ÊÊÊÊÊÊÊ|
// | that is bundled with this package in the file LICENSE, and isÊÊÊÊÊÊÊÊ|
// | available at through the world-wide-web atÊÊÊÊÊÊÊÊÊÊÊÊÊÊÊÊÊÊÊÊÊÊÊÊÊÊÊ|
// | http://www.php.net/license/2_02.txt.ÊÊÊÊÊÊÊÊÊÊÊÊÊÊÊÊÊÊÊÊÊÊÊÊÊÊÊÊÊÊÊÊÊ|
// | If you did not receive a copy of the PHP license and are unable toÊÊÊ|
// | obtain it through the world-wide-web, please send a note toÊÊÊÊÊÊÊÊÊÊ|
// | license@php.net so we can mail you a copy immediately.ÊÊÊÊÊÊÊÊÊÊÊÊÊÊÊ|
// +----------------------------------------------------------------------+
// | Author: George Schlossnagle <george@omniti.com>                      | 
// +----------------------------------------------------------------------+
//
// $Id$

require_once "PHPUnit.php";
require_once "Text/Statistics.php";

class TextTestCase extends PHPUnit_TestCase {
  var $sample;
  var $sampleAbbr;
  var $object;
  
  function setUp() 
  {
    $this->sample = "
Returns the number of words in the analysed text file or block. A word must     
consist of letters a-z with at least one vowel sound, and optionally an         
apostrophe or hyphen.";
    $this->object = new Text_Statistics($this->sample);
    $this->sampleAbbr = "
Dear Mr. Schlossnagle,
  
Your request for a leave of absense has been approved.  Enjoy your vacation.
";
  }  
  function TextTestCase($name) 
  {
    $this->PHPUnit_TestCase($name);
  }
  function testNumSentences() 
  {
    $this->assertEquals(2, $this->object->numSentences);
  }
  function testNumWords() 
  {
    $this->assertEquals(31, $this->object->numWords);
  }
  function testNumSyllables() 
  {
    $this->assertEquals(45, $this->object->numSyllables);
  }
  function testNumSentencesAbbr() 
  {
    $this->assertEquals(2, $this->object->numSentences);
  }
}
$suite = new PHPUnit_TestSuite('TextTestCase');
$result = PHPUnit::run($suite);
echo $result->toString();
?>
