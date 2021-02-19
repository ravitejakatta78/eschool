<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "marks".
 *
 * @property int $id
 * @property int|null $exam_id
 * @property int|null $student_id
 * @property int|null $subject_id
 * @property int|null $marks
 * @property int|null $school_id
 * @property string|null $created_by
 * @property string|null $created_on
 * @property string|null $updated_by
 * @property string|null $updated_on
 */
class Marks extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'marks';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['exam_id', 'student_id', 'subject_id', 'marks', 'school_id'], 'integer'],
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
            'exam_id' => 'Exam ID',
            'student_id' => 'Student ID',
            'subject_id' => 'Subject ID',
            'marks' => 'Marks',
            'school_id' => 'School ID',
            'created_by' => 'Created By',
            'created_on' => 'Created On',
            'updated_by' => 'Updated By',
            'updated_on' => 'Updated On',
        ];
    }
}
