<?php
/* @var $this yii\web\View */
use yii\imagine\Image;
use Imagine\Gd;
use Imagine\Image\Box;
use Imagine\Image\BoxInterface;
use yii\bootstrap\Html;

?>
<h1>ex-image/index</h1>


<h3>Yii 2.0: How to use imagine ( crop, thumb, effects for images ) on Yii2</h3>
<?php


//Crop
Image::crop('@webroot/img/images.png',200,200)
    ->save(Yii::getAlias('@webroot/img/result/crop-photo.jpg'), ['quality' => 80]);


//Thumbnail
Image::thumbnail('@webroot/img/images.png', 120, 120)
    ->save(Yii::getAlias('@webroot/img/result/thumb-photo.jpg'), ['quality' => 80]);


// frame, rotate and save an image
Image::frame('@webroot/img/images.png', 5, '666', 0)
    ->rotate(-8)
    ->save(Yii::getAlias('@webroot/img/result/frame-rolate-photo.jpg'), ['quality' => 80]);






//Resizing and Preserving Aspect Ratio
$fileName = Yii::getAlias('@webroot/img/images.png');
$newWidth = 50;
$newHeight = 50;
$savePath = Yii::getAlias('@webroot/img/result/resize-aspect-ratio-photo.jpg');
Image::getImagine()
    ->open($fileName)
    ->thumbnail(new Box($newWidth, $newHeight))
    ->save($savePath , ['quality' => 90]);



/*****************************************
 * Effect
 */




//Grayscale
$image = yii\imagine\Image::getImagine();
$newImage = $image->open(Yii::getAlias('@webroot/img/images.png'));
$newImage->effects()->grayscale();
$newImage->save(Yii::getAlias('@webroot/img/result/grayscale-photo.jpg'), ['quality' => 80]);


// negative
$image = yii\imagine\Image::getImagine();
$newImage = $image->open(Yii::getAlias('@webroot/img/images.png'));
$newImage->effects()->negative();
$newImage->save(Yii::getAlias('@webroot/img/result/negative-photo.jpg'), ['quality' => 80]);

//sharpen
$image = yii\imagine\Image::getImagine();
$newImage = $image->open(Yii::getAlias('@webroot/img/images.png'));
$newImage->effects()->sharpen();
$newImage->save(Yii::getAlias('@webroot/img/result/sharpen-photo.jpg'), ['quality' => 80]);


//sharpen
$image = yii\imagine\Image::getImagine();
$newImage = $image->open(Yii::getAlias('@webroot/img/images.png'));
$newImage->effects()->gamma(222);
$newImage->save(Yii::getAlias('@webroot/img/result/gamma-photo.jpg'), ['quality' => 80]);


//Colorize


?>

<div class="row">
    <div class="col-md-3"><?=Html::img(Yii::getAlias('@web/img/images.png'))?></div>
    <div class="col-md-3">รูปต้นฉบับ</div>
</div>
<div class="row">
    <div class="col-md-3"><?=Html::img(Yii::getAlias('@web/img/result/crop-photo.jpg'))?></div>
    <div class="col-md-3">Crop ตัดรูป</div>
</div>
<div class="row">
    <div class="col-md-3"><?=Html::img(Yii::getAlias('@web/img/result/thumb-photo.jpg'))?></div>
    <div class="col-md-3">Thumbnail</div>
</div>

 <div class="row">
  <div class="col-md-3"><?=Html::img(Yii::getAlias('@web/img/result/resize-aspect-ratio-photo.jpg'))?></div>
     <div class="col-md-3">Resizing and Preserving Aspect Ratio</div>
</div>
<div class="row">
    <div class="col-md-3"><?=Html::img(Yii::getAlias('@web/img/result/grayscale-photo.jpg'))?></div>
    <div class="col-md-3">Grayscale ภาพขาวดำ</div>
</div>
<div class="row">
    <div class="col-md-3"><?=Html::img(Yii::getAlias('@web/img/result/negative-photo.jpg'))?></div>
    <div class="col-md-3">Negative</div>
</div>

<div class="row">
    <div class="col-md-3"><?=Html::img(Yii::getAlias('@web/img/result/sharpen-photo.jpg'))?></div>
    <div class="col-md-3">Sharpen</div>
</div>
<div class="row">
    <div class="col-md-3"><?=Html::img(Yii::getAlias('@web/img/result/gamma-photo.jpg'))?></div>
    <div class="col-md-3">Gamma</div>
</div>

<div class="row">
    <div class="col-md-3"><?=Html::img(Yii::getAlias('@web/img/result/frame-rolate-photo.jpg'))?></div>
    <div class="col-md-3">Frame and Rolate</div>
</div>



