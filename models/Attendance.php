<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "attendance".
 *
 * @property int $id
 * @property int|null $student_id
 * @property int|null $attendance_status
 * @property int|null $class_id
 * @property int|null $school_id
 * @property string $created_on
 * @property string|null $created_by
 * @property string|null $updated_on
 * @property string|null $updated_by
 * @property string|null $attendance_date
 */
class Attendance extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'attendance';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['student_id', 'attendance_status', 'class_id', 'school_id'], 'integer'],
            [['created_on', 'updated_on', 'attendance_date'], 'safe'],
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
            'student_id' => 'Student ID',
            'attendance_status' => 'Attendance Status',
            'class_id' => 'Class ID',
            'school_id' => 'School ID',
            'created_on' => 'Created On',
            'created_by' => 'Created By',
            'updated_on' => 'Updated On',
            'updated_by' => 'Updated By',
            'attendance_date' => 'Attendance Date',
        ];
    }
}
