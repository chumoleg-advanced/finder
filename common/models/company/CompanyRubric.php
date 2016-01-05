<?php

namespace common\models\company;

use Yii;
use common\components\ActiveRecord;
use common\models\rubric\Rubric;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "company_rubric".
 *
 * @property integer $id
 * @property integer $company_id
 * @property integer $rubric_id
 * @property string  $date_create
 *
 * @property Company $company
 * @property Rubric  $rubric
 */
class CompanyRubric extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'company_rubric';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['company_id', 'rubric_id'], 'required'],
            [['company_id', 'rubric_id'], 'integer'],
            [['date_create'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'          => 'ID',
            'company_id'  => 'Company ID',
            'rubric_id'   => 'Rubric ID',
            'date_create' => 'Date Create',
        ];
    }

    /**
     * @inheritdoc
     * @return CompanyRubricQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CompanyRubricQuery(get_called_class());
    }

    /**
     * @param $companyId
     * @param $rubricId
     */
    public static function create($companyId, $rubricId)
    {
        $rel = new self();
        $rel->company_id = $companyId;
        $rel->rubric_id = $rubricId;
        $rel->save();
    }

    /**
     * @param int  $rubricId
     * @param bool $user
     *
     * @return array
     */
    public static function getCompaniesByRubric($rubricId, $user = true)
    {
        $data = self::find()
            ->joinWith('company')
            ->andWhere(['company_rubric.rubric_id' => $rubricId]);

        if ($user) {
            $data->andWhere(['company.user_id' => Yii::$app->user->id]);
        }

        return ArrayHelper::map($data->all(), 'company.id', 'company.legal_name');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCompany()
    {
        return $this->hasOne(Company::className(), ['id' => 'company_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRubric()
    {
        return $this->hasOne(Rubric::className(), ['id' => 'rubric_id']);
    }
}
