<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "student_paid_fee".
 *
 * @property int $id
 * @property int|null $class_id
 * @property int|null $section_id
 * @property int|null $student_id
 * @property int|null $amount
 * @property string|null $paid_date
 * @property string|null $status
 * @property string|null $created_on
 * @property string|null $created_by
 * @property string|null $updated_on
 * @property string|null $updated_by
 */
class StudentPaidFee extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'student_paid_fee';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['class_id', 'section_id', 'student_id', 'amount'], 'integer'],
            [['paid_date', 'created_on', 'updated_on'], 'safe'],
            [['status', 'created_by', 'updated_by'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'class_id' => 'Class ID',
            'section_id' => 'Section ID',
            'student_id' => 'Student ID',
            'amount' => 'Amount',
            'paid_date' => 'Paid Date',
            'status' => 'Status',
            'created_on' => 'Created On',
            'created_by' => 'Created By',
            'updated_on' => 'Updated On',
            'updated_by' => 'Updated By',
        ];
    }
}
