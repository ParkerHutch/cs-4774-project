<?php
$file = 'img/pokeball.png';
header('Content-type: image/png');
readfile($file);
?>