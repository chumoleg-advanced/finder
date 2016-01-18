<?php

namespace frontend\modules\dashboard\forms;

use common\models\requestOffer\RequestOfferImage;
use Yii;
use yii\base\Model;
use common\models\requestOffer\RequestOffer;
use Imagine\Image\ManipulatorInterface;
use yii\base\Exception;
use yii\imagine\Image;

class RequestOfferForm extends Model
{
    public $id;
    public $description;
    public $comment;
    public $price;
    public $companyId;

    public $imageData = [];
    public $partsCondition = [];
    public $partsOriginal = [];

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
            [['description', 'companyId', 'price'], 'required'],
            [['price'], 'double'],
            [['companyId'], 'integer'],
            [['imageData'], 'safe'],
            [['imageData'], 'file', 'skipOnEmpty' => true, 'extensions' => 'jpg, jpeg, gif, png', 'maxFiles' => 5],
            [['comment', 'partsOriginal', 'partsCondition'], 'safe']
        ];
    }

    public function attributeLabels()
    {
        return [
            'description'    => 'Описание',
            'comment'        => 'Комментарий',
            'price'          => 'Цена',
            'companyId'      => 'Компания',
            'partsCondition' => 'Состояние',
            'partsOriginal'  => 'Оригинальность',

        ];
    }

    public function beforeValidate()
    {
        return parent::beforeValidate();
    }

    public function create()
    {
        if (!$requestOffer = $this->_createNewRequestOffer()) {
            return;
        }

        $this->_saveFiles($requestOffer->id);

//        RequestAttribute::create($requestOffer->id, $this->attributes);
    }

    /**
     * @return RequestOffer
     */
    private function _createNewRequestOffer()
    {
        $requestOffer = new RequestOffer();
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

    /**
     * @param int $requestOfferId
     */
    private function _saveFiles($requestOfferId)
    {
        if (empty($this->imageData)) {
            return;
        }

        /** @var \yii\web\UploadedFile $fileObj */
        foreach ($this->imageData as $fileObj) {
            try {
                $dir = 'uploads/offer/' . $requestOfferId;
                if (!is_dir($dir)) {
                    mkdir($dir);
                }

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
}