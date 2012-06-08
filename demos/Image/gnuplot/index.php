<?php

require_once '../../bootstrap.php';

use Kaloa\Image\ImageFactory;

function renderGnuplot($gnuplotScript, &$returnValue = null)
{
    $data = '';

    ob_start();

    passthru('echo ' . escapeshellarg($gnuplotScript) . ' | gnuplot', $returnValue);

    $data = ob_get_clean();

    return $data;
}

function createImgSrc($rawData)
{
    return 'data:image/png;base64,' . base64_encode($rawData);
}



$gnuplotCommands = file_get_contents(__DIR__ . '/sinx.gp');

$returnValue = 0;
$data = renderGnuplot($gnuplotCommands, $returnValue);


if ($returnValue !== 0) {
    echo 'gnuplot returned an error code: ';
    echo $returnValue;
}




$if = new ImageFactory();

$imgData = $if->createNewImage()
        ->createFromString($data)
        ->outputRaw();

echo '<h1>Test</h1>';

echo '<img src="' . createImgSrc($imgData) . '">';





$gnuplotCommands = file_get_contents(__DIR__ . '/sawtooth.gp');

$from = -12.0;
$to   =  12.0;
$step =   0.01;

$gnuplotCommands = str_replace(array('<from>', '<to>'), array($from, $to), $gnuplotCommands);

$sawtooth = function ($t) {
    return $t - floor($t);
};

for ($t = $from; $t <= $to; $t += $step) {
    $gnuplotCommands .= $t . "\t" . $sawtooth($t) . "\n";
}

$returnValue = 0;
$data = renderGnuplot($gnuplotCommands, $returnValue);


if ($returnValue !== 0) {
    echo 'gnuplot returned an error code: ';
    echo $returnValue;
}




$if = new ImageFactory();

$imgData = $if->createNewImage()
        ->createFromString($data)
        ->outputRaw();

echo '<h1>Test</h1>';

echo '<img src="' . createImgSrc($imgData) . '">';
