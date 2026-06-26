<?php

function createMwIcon(string $path, int $size): void
{
    $image = imagecreatetruecolor($size, $size);
    imagealphablending($image, true);
    imagesavealpha($image, true);

    $background = imagecolorallocate($image, 44, 41, 38);
    $foreground = imagecolorallocate($image, 249, 248, 246);
    $ring = imagecolorallocatealpha($image, 249, 248, 246, 98);

    imagefilledrectangle($image, 0, 0, $size, $size, $background);

    $ringMargin = (int) round($size * 0.16);
    imagesetthickness($image, max(4, (int) round($size * 0.035)));
    imageellipse(
        $image,
        (int) round($size / 2),
        (int) round($size / 2),
        $size - ($ringMargin * 2),
        $size - ($ringMargin * 2),
        $ring,
    );

    $font = '/System/Library/Fonts/Supplemental/Georgia Bold Italic.ttf';
    $fontSize = $size * 0.33;
    $text = 'MW';
    $box = imagettfbbox($fontSize, 0, $font, $text);
    $textWidth = $box[2] - $box[0];
    $textHeight = $box[1] - $box[7];
    $x = (int) round(($size - $textWidth) / 2 - $box[0]);
    $y = (int) round(($size + $textHeight) / 2 - ($size * 0.03));

    imagettftext($image, $fontSize, 0, $x, $y, $foreground, $font, $text);

    imagepng($image, $path);
    imagedestroy($image);
}

createMwIcon(__DIR__ . '/../../public/icon-192.png', 192);
createMwIcon(__DIR__ . '/../../public/icon-512.png', 512);
createMwIcon(__DIR__ . '/../../public/apple-touch-icon.png', 180);
