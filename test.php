<?php

require_once 'class.TinyHtml.php';

$html = file_get_contents('test.html');

$tiny = new TinyHtml($html);

echo $tiny;

?>
