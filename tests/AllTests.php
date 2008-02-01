<?php
if (!defined('PHPUnit_MAIN_METHOD')) {
    define('PHPUnit_MAIN_METHOD', 'Text_Statistics_AllTests::main');
}

require_once 'PHPUnit/Framework/TestSuite.php';
require_once 'PHPUnit/TextUI/TestRunner.php';

chdir(dirname(__FILE__) . '/../');
require_once 'StatisticsTest.php';
require_once 'WordTest.php';


class Text_Statistics_AllTests
{
    public static function main()
    {

        PHPUnit_TextUI_TestRunner::run(self::suite());
    }

    public static function suite()
    {
        $suite = new PHPUnit_Framework_TestSuite('Text_Statistics tests');
        /** Add testsuites, if there is. */
        $suite->addTestSuite('Text_StatisticsTest');
        $suite->addTestSuite('Text_WordTest');

        return $suite;
    }
}

if (PHPUnit_MAIN_METHOD == 'Text_Statistics_AllTests::main') {
    Text_Statistics_AllTests::main();
}
?>