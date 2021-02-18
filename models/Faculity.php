<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "faculity".
 *
 * @property string $faculity_name
 * @property string|null $address
 * @property string $qualification
 * @property int $subject_id
 * @property int $school_id
 * @property int $status
 * @property string|null $email
 * @property string $mobile
 * @property string|null $created_by
 * @property string $created_on
 * @property string|null $updated_by
 * @property string $updated_on
 * @property int $gender
 * @property int $id
 */
class Faculity extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'faculity';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['faculity_name', 'qualification', 'subject_id', 'school_id', 'mobile', 'gender'], 'required'],
            [['address'], 'string'],
            [['subject_id', 'school_id', 'status', 'gender'], 'integer'],
            [['created_on', 'updated_on'], 'safe'],
            [['faculity_name', 'email', 'created_by', 'updated_by'], 'string', 'max' => 100],
            [['qualification'], 'string', 'max' => 255],
            [['mobile'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'faculity_name' => 'Faculity Name',
            'address' => 'Address',
            'qualification' => 'Qualification',
            'subject_id' => 'Subject ID',
            'school_id' => 'School ID',
            'status' => 'Status',
            'email' => 'Email',
            'mobile' => 'Mobile',
            'created_by' => 'Created By',
            'created_on' => 'Created On',
            'updated_by' => 'Updated By',
            'updated_on' => 'Updated On',
            'gender' => 'Gender',
            'id' => 'ID',
        ];
    }
}
