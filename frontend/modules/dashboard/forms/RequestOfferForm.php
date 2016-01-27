<?php

namespace frontend\modules\dashboard\forms;

use common\models\requestOffer\RequestOfferAttribute;
use common\models\requestOffer\RequestOfferImage;
use Yii;
use yii\base\Model;
use common\models\requestOffer\RequestOffer;
use Imagine\Image\ManipulatorInterface;
use yii\base\Exception;
use yii\helpers\BaseFileHelper;
use yii\imagine\Image;

class RequestOfferForm extends Model
{
    public $id;
    public $description;
    public $comment;
    public $price;
    public $companyId;
    public $imageData = [];

    public $availability;
    public $deliveryDayFrom;
    public $deliveryDayTo;

    public $partsCondition;
    public $partsOriginal;
    public $discType;
    public $tireType;
    public $tireTypeWinter;

    /**
     * @var \common\models\requestOffer\MainRequestOffer
     */
    public $mainRequestOffer;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['description', 'companyId', 'price', 'partsOriginal', 'partsCondition', 'availability'], 'required'],
            [['price'], 'double'],
            [['deliveryDayFrom', 'deliveryDayTo'], 'integer'],
            [['companyId'], 'integer'],
            [['imageData'], 'safe'],
            [['imageData'], 'file', 'skipOnEmpty' => true, 'extensions' => 'jpg, jpeg, gif, png', 'maxFiles' => 5],
            [['id', 'comment'], 'safe'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'description'     => 'Описание',
            'comment'         => 'Комментарий',
            'price'           => 'Цена',
            'companyId'       => 'Компания',
            'partsCondition'  => 'Состояние',
            'partsOriginal'   => 'Оригинальность',
            'availability'    => 'Наличие',
            'deliveryDayFrom' => 'Срок доставки от',
            'deliveryDayTo'   => 'Срок доставки до',
        ];
    }

    public function beforeValidate()
    {
        $attributes = $this->_getAttributeListForSave();
        foreach ($attributes as $name) {
            if (empty($this->{$name})) {
                $this->{$name} = null;
            }
        }

        if ($this->availability == 1) {
            $this->deliveryDayFrom = null;
            $this->deliveryDayTo = null;
        }

        if ($this->partsCondition != 1) {
            $this->partsOriginal = null;
        }

        return parent::beforeValidate();
    }

    /**
     * @return array
     */
    private function _getAttributeListForSave()
    {
        return [
            'availability',
            'deliveryDayFrom',
            'deliveryDayTo',
            'partsCondition',
            'partsOriginal',
            'discType',
            'tireType',
            'tireTypeWinter'
        ];
    }

    public function create()
    {
        if (!$requestOffer = $this->_createNewRequestOffer()) {
            return;
        }

        $this->_saveFiles($requestOffer->id);
        $this->_saveRequestOfferAttributes($requestOffer->id);
    }

    /**
     * @return RequestOffer
     */
    private function _createNewRequestOffer()
    {
        $requestOffer = new RequestOffer();
        return $this->_saveMainAttributes($requestOffer);
    }

    /**
     * @param int $requestOfferId
     */
    private function _saveFiles($requestOfferId)
    {
        if (empty($this->imageData)) {
            return;
        }

        $dir = 'uploads/offer/' . $requestOfferId;
        if (!is_dir($dir)) {
            BaseFileHelper::createDirectory($dir);
        } else {
            BaseFileHelper::removeDirectory($dir);
            BaseFileHelper::createDirectory($dir);
        }

        /** @var \yii\web\UploadedFile $fileObj */
        foreach ($this->imageData as $fileObj) {
            try {
                $baseName = md5($fileObj->name . '_' . mktime()) . '.' . $fileObj->extension;
                $fileName = $dir . '/' . $baseName;
                if (!$fileObj->saveAs($fileName)) {
                    continue;
                }

                $thumbName = $dir . '/thumb_' . $baseName;
                Image::thumbnail($fileName, 200, 200, ManipulatorInterface::THUMBNAIL_INSET)
                    ->save($thumbName);

                $img = new RequestOfferImage();
                $img->request_offer_id = $requestOfferId;
                $img->name = $fileName;
                $img->thumb_name = $thumbName;
                $img->save();

            } catch (Exception $e) {
                continue;
            }
        }
    }

    /**
     * @param $requestOfferId
     */
    private function _saveRequestOfferAttributes($requestOfferId)
    {
        $attributes = $this->_getAttributeListForSave();

        RequestOfferAttribute::deleteAll('request_offer_id = ' . $requestOfferId);
        foreach ($attributes as $attribute) {
            if (is_null($this->{$attribute})) {
                continue;
            }

            $model = new RequestOfferAttribute();
            $model->request_offer_id = $requestOfferId;
            $model->attribute_name = $attribute;
            $model->value = $this->{$attribute};
            $model->save();
        }
    }

    /**
     * @param $requestOffer
     */
    private function _saveMainAttributes($requestOffer)
    {
        $requestOffer->main_request_offer_id = $this->mainRequestOffer->id;
        $requestOffer->user_id = Yii::$app->user->id;
        $requestOffer->request_id = $this->mainRequestOffer->request_id;
        $requestOffer->company_id = $this->companyId;
        $requestOffer->description = $this->description;
        $requestOffer->comment = $this->comment;
        $requestOffer->price = $this->price;
        $requestOffer->status = RequestOffer::STATUS_ACTIVE;
        $requestOffer->save();

        return $requestOffer;
    }

    public function update()
    {
        $requestOffer = RequestOffer::findById($this->id);
        $this->_saveMainAttributes($requestOffer);
        $this->_saveFiles($requestOffer->id);
        $this->_saveRequestOfferAttributes($requestOffer->id);
    }
}