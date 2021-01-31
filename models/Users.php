<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "users".
 *
 * @property int $id primary key
 * @property string $user_name user name 
 * @property string $first_name
 * @property string $last_name
 * @property string $user_password
 * @property string $user_email
 * @property string $user_mobile
 * @property int $role_id
 * @property string|null $img_url
 * @property int $gender
 * @property int $user_status
 * @property string $created_on
 * @property string $created_by
 * @property string $updated_on
 * @property string $updated_by
 * @property string $reg_date
 */
class Users extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'users';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_name', 'first_name', 'user_password', 'user_email', 'user_mobile', 'role_id', 'gender', 'user_status', 'created_by', 'reg_date'], 'required'],
            [['role_id', 'gender', 'user_status'], 'integer'],
            [['img_url'], 'string'],
            [['created_on', 'updated_on', 'reg_date'], 'safe'],
            [['user_name'], 'string', 'max' => 50],
            [['first_name', 'last_name', 'user_password', 'user_email'], 'string', 'max' => 255],
            [['user_mobile'], 'string', 'max' => 20],
            [['created_by', 'updated_by'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_name' => 'User Name',
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'user_password' => 'User Password',
            'user_email' => 'User Email',
            'user_mobile' => 'User Mobile',
            'role_id' => 'Role ID',
            'img_url' => 'Img Url',
            'gender' => 'Gender',
            'user_status' => 'User Status',
            'created_on' => 'Created On',
            'created_by' => 'Created By',
            'updated_on' => 'Updated On',
            'updated_by' => 'Updated By',
            'reg_date' => 'Reg Date',
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
        foreach (self::$users as $user) {
            if ($user['accessToken'] === $token) {
                return new static($user);
            }
        }

        return null;
    }

    public static function findByUsername($username)
    {       
                return static::findOne(['user_name' => $username]);

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
    //    return $this->authKey;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
      //  return $this->authKey === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
       $md5Password = md5($password);
       return $this->user_password === $md5Password;
    }
}
