<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "parents".
 *
 * @property int $id
 * @property string $parent_name
 * @property int $parent_type
 * @property string $occupation
 * @property string|null $email
 * @property string|null $phone
 * @property int $status
 * @property string|null $created_by
 * @property string $created_on
 * @property string|null $updated_by
 * @property string $updated_on
 * @property string $reg_date
 */
class Parents extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'parents';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['parent_name', 'parent_type', 'occupation', 'status', 'reg_date'], 'required'],
            [['parent_type', 'status'], 'integer'],
            [['created_on', 'updated_on', 'reg_date'], 'safe'],
            [['parent_name', 'occupation', 'email'], 'string', 'max' => 255],
            [['phone'], 'string', 'max' => 50],
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
            'parent_name' => 'Parent Name',
            'parent_type' => 'Parent Type',
            'occupation' => 'Occupation',
            'email' => 'Email',
            'phone' => 'Phone',
            'status' => 'Status',
            'created_by' => 'Created By',
            'created_on' => 'Created On',
            'updated_by' => 'Updated By',
            'updated_on' => 'Updated On',
            'reg_date' => 'Reg Date',
        ];
    }
}
