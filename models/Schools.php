<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "schools".
 *
 * @property int $id
 * @property string $school_name
 * @property string $address
 * @property int $status
 * @property string|null $registration_number
 * @property string|null $landline
 * @property string|null $updated_by
 * @property string|null $updated_on
 * @property string $created_by
 * @property string $created_on
 * @property string|null $email
 * @property string|null $mobile
 */
class Schools extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'schools';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['school_name', 'address', 'status', 'created_by'], 'required'],
            [['address'], 'string'],
            [['status'], 'integer'],
            [['created_on'], 'safe'],
            [['school_name', 'updated_by', 'email'], 'string', 'max' => 255],
            [['registration_number', 'landline', 'updated_on', 'mobile'], 'string', 'max' => 50],
            [['created_by'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'school_name' => 'School Name',
            'address' => 'Address',
            'status' => 'Status',
            'registration_number' => 'Registration Number',
            'landline' => 'Landline',
            'updated_by' => 'Updated By',
            'updated_on' => 'Updated On',
            'created_by' => 'Created By',
            'created_on' => 'Created On',
            'email' => 'Email',
            'mobile' => 'Mobile',
        ];
    }
}
