<?php
require 'Text/Statistics.php';

$lorem = <<<EOT
Lorem ipsum dolor sit amet, consectetur adipisici elit,
sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi
ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit
in voluptate velit esse cillum dolore eu fugiat nulla pariatur.
Excepteur sint occaecat cupidatat non proident,
sunt in culpa qui officia deserunt mollit anim id est laborum.
EOT;

$block = new Text_Statistics($lorem);
echo 'Flesch score: ' . $block->flesch . "\n";
echo 'Flesch-Kincaid grade level: ' . $block->gradeLevel . "\n";
?>