<?php

namespace frontend\components;

use common\models\Dictionary;
use Yii;

class CaptchaAction extends \yii\captcha\CaptchaAction
{
    public $fontFile = '@frontend/components/captcha/Fragile_Decay.ttf';

    /**
     * Generates a new verification code.
     *
     * @return string the generated verification code
     */
    protected function generateVerifyCode()
    {
        return Dictionary::getRandWord();
    }

    /**
     * Renders the CAPTCHA image based on the code using GD library.
     *
     * @param string $code the verification code
     *
     * @return string image contents in PNG format.
     */
    protected function renderImageByGD($code)
    {
        $image = imagecreatetruecolor($this->width, $this->height);

        $backColor = imagecolorallocate(
            $image,
            (int)($this->backColor % 0x1000000 / 0x10000),
            (int)($this->backColor % 0x10000 / 0x100),
            $this->backColor % 0x100
        );
        imagefilledrectangle($image, 0, 0, $this->width, $this->height, $backColor);
        imagecolordeallocate($image, $backColor);

        if ($this->transparent) {
            imagecolortransparent($image, $backColor);
        }

        $foreColor = imagecolorallocate(
            $image,
            (int)($this->foreColor % 0x1000000 / 0x10000),
            (int)($this->foreColor % 0x10000 / 0x100),
            $this->foreColor % 0x100
        );

        $length = mb_strlen($code, 'UTF-8');
        $box = imagettfbbox(30, 0, $this->fontFile, $code);
        $w = $box[4] - $box[0] + $this->offset * ($length - 1);
        $h = $box[1] - $box[5];
        $scale = min(($this->width - $this->padding * 2) / $w, ($this->height - $this->padding * 2) / $h);
        $x = 10;
        $y = round($this->height * 27 / 40);
        for ($i = 0; $i < $length; ++$i) {
            $fontSize = (int)(rand(26, 32) * $scale * 0.8);
            $angle = rand(-10, 10);
            $letter = mb_substr($code, $i, 1, 'UTF-8');
            $box = imagettftext($image, $fontSize, $angle, $x, $y, $foreColor, $this->fontFile, $letter);
            $x = $box[2] + $this->offset;
        }

        imagecolordeallocate($image, $foreColor);

        ob_start();
        imagepng($image);
        imagedestroy($image);

        return ob_get_clean();
    }

    /**
     * Renders the CAPTCHA image based on the code using ImageMagick library.
     *
     * @param string $code the verification code
     *
     * @return string image contents in PNG format.
     */
    protected function renderImageByImagick($code)
    {
        $backColor = $this->transparent ? new \ImagickPixel('transparent')
            : new \ImagickPixel('#' . dechex($this->backColor));
        $foreColor = new \ImagickPixel('#' . dechex($this->foreColor));

        $image = new \Imagick();
        $image->newImage($this->width, $this->height, $backColor);

        $draw = new \ImagickDraw();
        $draw->setFont($this->fontFile);
        $draw->setFontSize(30);
        $fontMetrics = $image->queryFontMetrics($draw, $code);

        $length = mb_strlen($code, 'UTF-8');
        $w = (int)($fontMetrics['textWidth']) - 8 + $this->offset * ($length - 1);
        $h = (int)($fontMetrics['textHeight']) - 8;
        $scale = min(($this->width - $this->padding * 2) / $w, ($this->height - $this->padding * 2) / $h);
        $x = 10;
        $y = round($this->height * 27 / 40);
        for ($i = 0; $i < $length; ++$i) {
            $draw = new \ImagickDraw();
            $draw->setFont($this->fontFile);
            $draw->setFontSize((int)(rand(26, 32) * $scale * 0.8));
            $draw->setFillColor($foreColor);
            $image->annotateImage($draw, $x, $y, rand(-10, 10), mb_substr($code, $i, 1, 'UTF-8'));
            $fontMetrics = $image->queryFontMetrics($draw, mb_substr($code, $i, 1, 'UTF-8'));
            $x += (int)($fontMetrics['textWidth']) + $this->offset;
        }

        $image->setImageFormat('png');
        return $image->getImageBlob();
    }

    /**
     * Generates a hash code that can be used for client side validation.
     *
     * @param string $code the CAPTCHA code
     *
     * @return string a hash code generated from the CAPTCHA code
     */
    public function generateValidationHash($code)
    {
        for ($h = 0, $i = mb_strlen($code, 'UTF-8') - 1; $i >= 0; --$i) {
            $h += ord(mb_substr($code, $i, 1, 'UTF-8'));
        }

        return $h;
    }

    /**
     * Validates the input to see if it matches the generated code.
     *
     * @param string  $input         user input
     * @param boolean $caseSensitive whether the comparison should be case-sensitive
     *
     * @return boolean whether the input is valid
     */
    public function validate($input, $caseSensitive)
    {
        $code = $this->getVerifyCode();
        $valid = $caseSensitive ? ($input === $code) : strcasecmp($input, $code) === 0;
        $session = Yii::$app->getSession();
        $session->open();

        $name = $this->getSessionKey() . 'count';
        $session[$name] = $session[$name] + 1;
        if (\Yii::$app->request->isAjax === false && $valid || $session[$name] > $this->testLimit && $this->testLimit > 0) {
            $this->getVerifyCode(true);
        }

        return $valid;
    }
}