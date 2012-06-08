<?php

function createImgSrc($rawData)
{
    return 'data:image/jpeg;base64,' . base64_encode($rawData);
}

function box($gd, $desc)
{
    echo '<div class="box">';
    echo '<p><img src="'.createImgSrc($gd->outputRaw()).'"></p>';
    echo '<p>' . $desc . '</p>';
    echo '</div>';
}
