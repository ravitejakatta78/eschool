<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "exam_details".
 *
 * @property int $id
 * @property int $exam_id
 * @property string $exam_date
 * @property int $subject_id
 * @property string|null $created_by
 * @property string|null $created_on
 * @property string|null $updated_by
 * @property string|null $updated_on
 */
class ExamDetails extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'exam_details';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['exam_id', 'exam_date', 'subject_id'], 'required'],
            [['exam_id', 'subject_id'], 'integer'],
            [['exam_date', 'created_on', 'updated_on'], 'safe'],
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
            'exam_date' => 'Exam Date',
            'subject_id' => 'Subject ID',
            'created_by' => 'Created By',
            'created_on' => 'Created On',
            'updated_by' => 'Updated By',
            'updated_on' => 'Updated On',
        ];
    }
}
