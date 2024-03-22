<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $full_name
 * @property string $username
 * @property string $email
 * @property string $password
 * @property int $role
 */
class User extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{
    public $password2;
    public $check;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['full_name', 'username', 'email', 'password','password2','check'], 'required'],
            [['full_name'], 'string', 'max' => 50],
            [['username', 'email'], 'string', 'max' => 30],
            [['password2'], 'compare','compareAttribute' =>'password'],
            ['check', 'compare', 'compareValue' => 1, 'message' => 'Обязательно!'],
            [['email'],'email'],
            [['username'], 'unique'],
            ['full_name','match', 'pattern'=> '/^[А-яЁe -]*$/u', 'message' => 'Только кирилица' ],
            ['username', 'match', 'pattern'=> '/^[A-z]\w*$/i', 'message' => 'Только латиница' ],
            [['password'], 'string', 'max' => 32],
            [['role'], 'string', 'max' => 20],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'full_name' => 'ФИО',
            'username' => 'Логин',
            'email' => 'Email',
            'password' => 'Пароль',
            'password2' => 'Повтор пароля',
            'check' => 'Согласие на обработку данных',
        ];
    }
    public static function findIdentity($id)
    {
        return static::findOne($id);
    }
    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return null;
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return User::findOne(['username'=> $username]);
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return null;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return false;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return $this->password === md5($password);
    }

    public function beforeSave($insert)
    {
        $this->password = md5($this->password);
        return parent::beforeSave($insert);
    }

    public function isAdmin()
    {
        return $this-> role == 1;
    }
}
