<?php
$lines = file('.env');
foreach ($lines as $i => $l) {
    echo ($i + 1) . ': ' . bin2hex($l) . PHP_EOL;
}
