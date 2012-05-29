<?php

require_once '../../bootstrap.php';

use Kaloa\Image\ImageFactory;

$if = new ImageFactory();

$image = $if->createNewImage()->createFromPath('../assets/autumn-still-life.jpg');

$start = microtime(true);

$image->rescaleOp(array(4, 5, 6), array(15, 10, 5));
     #->contrast(100)
     #->brightness(-100)
     #->resize(400, 400)
     #->rotate(340, 0x00)

error_log('Rescaled in: ' . (microtime(true) - $start));

     $image->output();

// pseudo todo list:
// 
// clip
// scale
// rescaleop
// lazy loading of the gd resource
