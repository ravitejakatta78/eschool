<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "school_fee".
 *
 * @property int $id
 * @property int $school_id
 * @property int $class_id
 * @property int $fee_type
 * @property float $fee_amount
 * @property int $fee_status
 * @property string|null $created_by
 * @property string $created_on
 * @property string|null $updated_by
 * @property string|null $updated_on
 */
class SchoolFee extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'school_fee';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['school_id', 'class_id', 'fee_type', 'fee_amount', 'created_on'], 'required'],
            [['school_id', 'class_id', 'fee_type', 'fee_status'], 'integer'],
            [['fee_amount'], 'number'],
            [['created_on', 'updated_on'], 'safe'],
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
            'school_id' => 'School ID',
            'class_id' => 'Class ID',
            'fee_type' => 'Fee Type',
            'fee_amount' => 'Fee Amount',
            'fee_status' => 'Fee Status',
            'created_by' => 'Created By',
            'created_on' => 'Created On',
            'updated_by' => 'Updated By',
            'updated_on' => 'Updated On',
        ];
    }
}
