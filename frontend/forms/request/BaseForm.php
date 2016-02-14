<?php

namespace frontend\forms\request;

use common\components\MyImage;
use common\models\notification\Notification;
use Yii;
use yii\base\Model;
use common\models\request\Request;
use common\models\request\MainRequest;
use yii\helpers\ArrayHelper;
use common\models\request\RequestAttribute;
use Imagine\Image\ManipulatorInterface;
use yii\base\Exception;
use yii\helpers\BaseFileHelper;
use yii\imagine\Image;
use common\models\request\RequestImage;

class BaseForm extends Model
{
    public $verifyCode;
    public $delivery;
    public $deliveryAddress;
    public $addressCoordinates;

    private $_commonAttributes = [];

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['verifyCode', 'captcha'],
            [['verifyCode', 'delivery', 'deliveryAddress', 'addressCoordinates'], 'safe'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'description'        => 'Описание',
            'comment'            => 'Комментарий',
            'image'              => 'Фото',
            'partsCondition'     => 'Состояние',
            'partsOriginal'      => 'Оригинальность',
            'verifyCode'         => 'Проверочный код',
            'delivery'           => 'Необходима доставка',
            'deliveryAddress'    => 'Адрес доставки',
            'addressCoordinates' => 'Координаты адреса'
        ];
    }

    /**
     * @param $rubricId
     * @param $queryArrayFormData
     *
     * @return bool
     */
    public function submitForm($rubricId, $queryArrayFormData)
    {
        if (!$this->validate()) {
            return false;
        }

        $this->_commonAttributes = $this->attributes;
        if (empty($this->_commonAttributes['delivery'])) {
            unset($this->_commonAttributes['deliveryAddress']);
            unset($this->_commonAttributes['addressCoordinates']);
        }

        unset($this->_commonAttributes['verifyCode']);
        unset($this->_commonAttributes['delivery']);

        return $this->_createModelFromPost($rubricId, $queryArrayFormData);
    }

    /**
     * @param $rubricId
     * @param $positions
     *
     * @return bool
     */
    private function _createModelFromPost($rubricId, $positions)
    {
        if (!$mainRequestId = MainRequest::create($rubricId)) {
            return false;
        }

        foreach ($positions as $k => $positionAttr) {
            $request = new Request();
            $request->main_request_id = $mainRequestId;
            $request->id_for_client = $mainRequestId . '-' . ($k + 1);
            $request->user_id = Yii::$app->user->id;
            $request->rubric_id = $rubricId;
            $request->description = ArrayHelper::getValue($positionAttr, 'description');
            $request->comment = ArrayHelper::getValue($positionAttr, 'comment');
            $request->status = Request::STATUS_NEW;
            $request->save();

            $this->_saveFiles($positionAttr, $request->id);

            unset($positionAttr['description']);
            unset($positionAttr['comment']);
            unset($positionAttr['image']);

            RequestAttribute::create($request->id,
                ArrayHelper::merge($this->_commonAttributes, $positionAttr));

            Yii::$app->consoleRunner->run('email/send ' . Notification::TYPE_NEW_REQUEST . ' ' . $request->id . ' ""');
        }

        return true;
    }

    /**
     * @param array $posAttr
     * @param int   $requestId
     */
    private function _saveFiles($posAttr, $requestId)
    {
        if (empty($posAttr['image'])) {
            return;
        }

        /** @var \yii\web\UploadedFile $fileObj */
        foreach ($posAttr['image'] as $fileObj) {
            try {
                $dir = 'uploads/request/' . $requestId;
                if (!is_dir($dir)) {
                    BaseFileHelper::createDirectory($dir);
                }

                $baseName = md5($fileObj->name . '_' . mktime()) . '.' . $fileObj->extension;
                $fileName = $dir . '/' . $baseName;
                if (!$fileObj->saveAs($fileName)) {
                    continue;
                }

                $thumbName = $dir . '/thumb_' . $baseName;
                Image::thumbnail($fileName, MyImage::THUMB_SIZE, MyImage::THUMB_SIZE,
                    ManipulatorInterface::THUMBNAIL_INSET)->save($thumbName);

                Image::thumbnail($fileName, MyImage::IMAGE_SIZE, MyImage::IMAGE_SIZE,
                    ManipulatorInterface::THUMBNAIL_INSET)->save($fileName);

                $img = new RequestImage();
                $img->request_id = $requestId;
                $img->name = $fileName;
                $img->thumb_name = $thumbName;
                $img->save();

            } catch (Exception $e) {
                continue;
            }
        }
    }
}