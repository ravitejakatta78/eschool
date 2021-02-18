<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "exams".
 *
 * @property int $id
 * @property string $exam_name
 * @property string $exam_start_date
 * @property string $exam_end_date
 * @property int $school_id
 * @property int $class_id
 * @property string|null $created_on
 * @property string|null $created_by
 * @property string|null $updated_on
 * @property string|null $updated_by
 */
class Exams extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'exams';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['exam_name', 'exam_start_date', 'exam_end_date', 'school_id', 'class_id'], 'required'],
            [['exam_start_date', 'exam_end_date', 'created_on', 'updated_on'], 'safe'],
            [['school_id', 'class_id'], 'integer'],
            [['exam_name', 'created_by', 'updated_by'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'exam_name' => 'Exam Name',
            'exam_start_date' => 'Exam Start Date',
            'exam_end_date' => 'Exam End Date',
            'school_id' => 'School ID',
            'class_id' => 'Class ID',
            'created_on' => 'Created On',
            'created_by' => 'Created By',
            'updated_on' => 'Updated On',
            'updated_by' => 'Updated By',
        ];
    }
}
