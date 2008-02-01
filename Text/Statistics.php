<?php
/* vim: set expandtab tabstop=4 softtabstop=4 shiftwidth=4: */
// +----------------------------------------------------------------------+
// | PHP version 4                                                        |
// +----------------------------------------------------------------------+
// | Copyright (c) 1997-2002 The PHP Group                                |
// +----------------------------------------------------------------------+
// | This source file is subject to version 2.0 of the PHP license,       |
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

require_once "Text/Word.php";

/**
*  Text_Statistics calculates some basic readability metrics on a
*  block of text.  The number of words, the number of sentences,
*  and the number of total syllables is counted.  These statistics
*  can be used to calculate the Flesch score for a sentence, which
*  is  a number (usually between 0 and 100) that represents the
*  readability of the text.  A basic breakdown of scores is:
*
*  90 to 100  5th grade
*  80 to 90   6th grade
*  70 to 80   7th grade
*  60 to 70   8th and 9th grade
*  50 to 60   10th to 12th grade (high school)
*  30 to 50   college
*  0 to 30    college graduate
*
*  More info can be read up on at
*  http://www.mang.canterbury.ac.nz/courseinfo/AcademicWriting/Flesch.htm
*
*  require 'Text/Statistics.php';
*  $block = Text_Statistics($sometext);
*  $block->flesch; // returns flesch score for $sometext
*
*  see the unit tests for additional examples.
*
*  @package Text_Statistics
*  @author  George Schlossnagle <george@omniti.com>
*/
class Text_Statistics
{
    /**
     * The document text.
     *
     * @access public
     * @var string
     */
    var $text = '';

    /**
     * The number of syllables in the document.
     *
     * @var int
     * @access public
     */
    var $numSyllables = 0;

    /**
     * The number of words in the document.
     *
     * @var int
     * @access public
     */
    var $numWords = 0;

    /**
     * The number of unique words in the document.
     *
     * @var    int
     * @access public
     */
    var $uniqWords = 0;

    /**
     * The number of sentences in the document.
     *
     * @var    int
     * @access public
     */
    var $numSentences = 0;

    /**
     * The Flesch score of the document.
     * It is FALSE if there were no words in the document.
     *
     * @var    float
     * @access public
     */
    var $flesch = 0;

    /**
     * Flesch-Kincaid grade level
     * It is FALSE if there were no words in the document.
     *
     * @var    float
     * @access public
     */
    var $gradeLevel = 0;

    /**
     * Some abbreviations we should expand.  This list could/should
     * be much larger.
     *
     * @var    array
     * @access protected
     */
    var $_abbreviations = array('/Mr\./'   => 'Mister',
                                '/Mrs\./i' => 'Misses', // Phonetic
                                '/etc\./i' => 'etcetera',
                                '/Dr\./i'  => 'Doctor',
                                '/Jr\./i' => 'Junior',
                                '/Sr\./i' => 'Senior',
                               );

    /**
     * List of all words that have been found already.
     * @var array
     */
    var $_uniques = array();



    /**
     * Constructor.
     *
     * @param  string
     * @access public
     */
    function Text_Statistics($block)
    {
        $this->text = trim($block);
        $this->_analyze();
        $this->text = null;
    }



    /**
     * Returns the character frequencies.
     *
     * @return array of frequencies, where the index is the ASCII byte char value
     * @access public
     * @author Jesus M. Castagnetto <jmcastagnetto@php.net>
     */
    function getCharFreq() {
        return $this->_charFreq;
    }



    /**
     * Returns the number of paragaphs.
     * Paragraphs are defined as chunks of text separated by
     * and empty line.
     *
     * @return long
     * @access public
     * @author Jesus M. Castagnetto <jmcastagnetto@php.net>
     */
    function getNumParagraphs() {
        return $this->_numParas;
    }



    /**
     * Compute statistics for the document object.
     *
     * @access protected
     */
    function _analyze()
    {
        // char frequencies
        $this->_charFreq = count_chars($this->text);
        $this->text = preg_replace(array_keys($this->_abbreviations),
                      array_values($this->_abbreviations),
                      $this->text);
        preg_match_all('/[.!?](\s|$)/', $this->text, $matches);
        $this->numSentences = count($matches[0]);
        $lines              = explode("\n", $this->text);
        // Set ourselves as 'out of text block to start
        $intext = 0;
        foreach( $lines as $line ) {
            // A paragraph is when we enter a text line
            // after a line that was all whitespace
            if(preg_match("/\S/", $line)) {
                if($intext == 0) {
                    $this->_numParas++;
                    $intext = 1;
                }
            }
            else {
                $intext = 0;
            }
            $this->_analyze_line($line);
        }

        if ($this->numSentences == 0) {
            $this->numSentences = 1;
        }
        if ($this->numWords == 0) {
            $this->flesch       = false;
            $this->gradeLevel   = false;
            return;
        }

        $wordsPerSent     = $this->numWords / $this->numSentences;
        $syllablesPerWord = $this->numSyllables / $this->numWords;

        $this->flesch = 206.835
                        - 1.015 * $wordsPerSent
                        - 84.6 * $syllablesPerWord;
        $this->gradeLevel = 0.39 * $wordsPerSent
                        + 11.8 * $syllablesPerWord
                        - 15.59;
    }



    /**
     * Helper function, computes statistics on a given line.
     *
     * @param  string
     * @access protected
     */
    function _analyze_line($line)
    {
        // expand abbreviations for counting syllables
        preg_match_all("/\b(\w[\w'-]*)\b/", $line, $words);
        foreach( $words[1] as $word ) {
            $w_obj = new Text_Word($word);
            $this->numSyllables += $w_obj->numSyllables();
            $this->numWords++;
            if(!isset($this->_uniques[$word])) {
                $this->_uniques[$word] = 1;
            } else {
               $this->uniqWords++;
            }
        }
    }
}
?>
