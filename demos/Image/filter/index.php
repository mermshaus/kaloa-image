<?php

require_once '../../bootstrap.php';
require_once './helpers.php';

use Kaloa\Image\ImageFactory;

$if = new ImageFactory();
?>

<!DOCTYPE html>

<html lang="en">

    <head>
        <meta charset="UTF-8" />
        <title>Filters</title>
        <link href='http://fonts.googleapis.com/css?family=PT+Sans+Narrow' rel='stylesheet' type='text/css'>
        <link href='./screen.css' rel='stylesheet' type='text/css'>
    </head>

    <body>

<?php

// image original
$io = $if->createNewImage()
        ->createFromPath('../assets/autumn-still-life.jpg')
        ->resize(168, 105);

for ($contrast = -100; $contrast <= 100; $contrast += 25) {
    $ic = clone $io;
    $ic->contrast($contrast);
    box($ic, 'contrast(' . $contrast . ')');
}

for ($brightness = -255; $brightness <= 255; $brightness += 63) {
    $ic = clone $io;
    $ic->brightness($brightness);
    box($ic, 'brightness(' . $brightness . ')');
}

// image clone
$ic = clone $io; $ic->edgeDetect();
box($ic, 'edgeDetect');

$ic = clone $io; $ic->emboss();
box($ic, 'emboss');

$ic = clone $io; $ic->gaussianBlur();
box($ic, 'gaussianBlur');

$ic = clone $io; $ic->gaussianBlur()->gaussianBlur()->gaussianBlur();
box($ic, 'gaussianBlur * 3');

$ic = clone $io; $ic->gaussianBlur()->gaussianBlur()->gaussianBlur()->gaussianBlur()->gaussianBlur();
box($ic, 'gaussianBlur * 5');

$ic = clone $io; $ic->grayscale();
box($ic, 'grayscale');

$ic = clone $io; $ic->grayscale()->contrast(100);
box($ic, 'grayscale + contrast(100)');

$ic = clone $io; $ic->meanRemoval();
box($ic, 'meanRemoval');

$ic = clone $io; $ic->negate();
box($ic, 'negate');

$ic = clone $io; $ic->pixelate(10, true);
box($ic, 'pixelate(10)');

$ic = clone $io; $ic->rescaleOp(array(1, 0, 0), array(0, 0, 0));
box($ic, 'rescaleOp(1,0,0)');

$ic = clone $io; $ic->rescaleOp(array(0, 1, 0), array(0, 0, 0));
box($ic, 'rescaleOp(0,1,0)');

$ic = clone $io; $ic->rescaleOp(array(0, 0, 1), array(0, 0, 0));
box($ic, 'rescaleOp(0,0,1)');

?>

    </body>

</html>
