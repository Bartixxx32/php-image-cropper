<?php

require_once './vendor/autoload.php';

use Imagine\Image\Point;
use Imagine\Image\Box;

$file = $_FILES['file'];
$post = $_POST;
$targ_w = (int) $post['crop_img_width'];
$targ_h = (int) $post['crop_img_height'];
$croppedX = (int) $post['horizonatal_pos'];
$croppedY = (int) $post['vertical_pos'];

if (is_array($file) && isset($file['name'])) {
    $uniqueFileName = uniqid('ff') . $file['name'];
    $destination = './storage/' . $uniqueFileName;

    if ($file['error'] == 0) {
        move_uploaded_file($file['tmp_name'], $destination);
        $croppeedImg = 'cropped-' . $uniqueFileName;
        $croppedDestination = './storage/' . $croppeedImg;

        $image = new \Imagine\Gd\Imagine();
        $img = $image->open($destination);
        $img->crop(new Point($croppedX, $croppedY), new Box($targ_w, $targ_h))
                ->save($croppedDestination);
    }
} else {
    
}
header('Location:index.php');


