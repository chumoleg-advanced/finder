<?php

namespace common\models\user;

use common\components\Status;
use common\models\auth\Oauth;
use common\models\company\Company;
use common\models\company\CompanyRubric;
use common\models\request\Request;
use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * User model
 *
 * @property integer   $id
 * @property string    $email
 * @property string    $password_hash
 * @property string    $password_reset_token
 * @property string    $phone
 * @property string    $fio
 * @property string    $birthday
 * @property string    $auth_key
 * @property integer   $status
 * @property string    $created_at
 * @property string    $updated_at
 *
 * @property Company[] $companies
 * @property Oauth[]   $oauths
 * @property Request[] $requests
 */
class User extends ActiveRecord implements IdentityInterface
{
    const STATUS_ACTIVE = 1;
    const STATUS_BLOCKED = 2;

    public static $statusList
        = [
            self::STATUS_ACTIVE  => 'Активный',
            self::STATUS_BLOCKED => 'Заблокирован'
        ];

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className()
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['email', 'auth_key'], 'required'],
            [['status'], 'integer'],
            [['created_at', 'updated_at', 'birthday'], 'safe'],
            [['email'], 'string', 'max' => 64],
            [['password_hash'], 'string', 'max' => 60],
            [['password_reset_token'], 'string', 'max' => 44],
            [['phone'], 'string', 'max' => 14],
            [['fio'], 'string', 'max' => 200],
            [['auth_key'], 'string', 'max' => 32]
        ];
    }

    public function attributeLabels()
    {
        return [
            'id'                   => 'ID',
            'email'                => 'Email',
            'password_hash'        => 'Password Hash',
            'password_reset_token' => 'Password Reset Token',
            'phone'                => 'Телефон',
            'fio'                  => 'ФИО',
            'birthday'             => 'Дата рождения',
            'auth_key'             => 'Auth Key',
            'status'               => 'Статус',
            'created_at'           => 'Дата создания',
            'updated_at'           => 'Updated At',
        ];
    }

    /**
     * @inheritdoc
     * @return UserQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new UserQuery(get_called_class());
    }

    public function beforeSave($insert)
    {
        if ($this->isNewRecord) {
            $this->status = Status::STATUS_ACTIVE;
        }

        return parent::beforeSave($insert);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return self::find()->whereId($id)->isActive()->one();
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * @param string $email
     *
     * @return static|null
     */
    public static function findByEmail($email)
    {
        return self::find()->whereEmail($email)->isActive()->one();
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     *
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return self::find()->wherePasswordResetToken($token)->isActive()->one();
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     *
     * @return boolean
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int)substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];

        return $timestamp + $expire >= time();
    }

    /**
     * @param null $userId
     *
     * @return mixed|null
     */
    public static function getUserRole($userId = null)
    {
        if (empty($userId)) {
            $userId = Yii::$app->user->getId();
        }

        $roles = Yii::$app->authManager->getRolesByUser($userId);
        if (empty($roles)) {
            return null;
        }

        $obj = current($roles);

        return $obj->name;
    }

    /**
     * @param int $rubricId
     *
     * @return array|User[]
     */
    public static function getListByRubric($rubricId)
    {
        $companies = array_keys(CompanyRubric::getCompaniesByRubric($rubricId, false));
        if (empty($companies)) {
            return [];
        }

        return self::find()
            ->joinWith('companies')
            ->andWhere(['company.id' => $companies])
            ->andWhere(['company.status' => Company::STATUS_ACTIVE])
            ->andWhere(['user.status' => self::STATUS_ACTIVE])
            ->groupBy('user.id')
            ->all();
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     *
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCompanies()
    {
        return $this->hasMany(Company::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOauths()
    {
        return $this->hasMany(Oauth::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRequests()
    {
        return $this->hasMany(Request::className(), ['user_id' => 'id']);
    }

    /**
     * @param int $userId
     *
     * @return User|null
     */
    public static function findById($userId)
    {
        return self::find()->whereId($userId)->one();
    }

    /**
     * @param string $role
     *
     * @return array|User[]
     */
    public static function getUsersByRole($role)
    {
        return self::find()->where('id IN (SELECT user_id FROM auth_assignment
            WHERE item_name = "' . $role . '"')->all();
    }
}
