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
  require_once "Text/Word.php";

  class Text_WordTestCase extends PHPUnit_TestCase {
    var $known_words   = array ( 'the' => 1,
                                 'late' => '1',
                                 'hello' => '2',
                                 'frantic' => '2',
                                 'programmer' => '3');
    var $special_words = array ( 'absolutely' => 4,
                                 'alien' => 3,
                                 'ion' => 2,
                                 'tortion' => 2,
                                 'gracious' => 2,
                                 'lien' => 1,
                                 'syllable' => 3);
			       
    function Text_WordTestCase($name) {
      $this->PHPUnit_TestCase($name);
    }
    function testKnownWords() {
      foreach ($this->known_words as $word => $syllables) {
        $obj = new Text_Word($word);
        $this->assertEquals($syllables, $obj->numSyllables(), 
                            "$word has incorrect syllable count");
      }
    }
    function testSpecialWords() {
      foreach ($this->special_words as $word => $syllables) {
        $obj = new Text_Word($word);
        $this->assertEquals($syllables, $obj->numSyllables(), 
                            "$word has incorrect syllable count");
      }
    }
  }
if(realpath($_SERVER[PHP_SELF]) == __FILE__) {
  $suite = new PHPUnit_TestSuite('Text_WordTestCase');
  $result = PHPUnit::run($suite);
  echo $result->toString();
}
?>
