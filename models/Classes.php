<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "classes".
 *
 * @property int $id
 * @property string|null $class_name
 * @property int $teacher_id
 * @property int $school_id
 * @property int $status
 * @property string|null $created_by
 * @property string|null $created_on
 * @property string|null $updated_by
 * @property string|null $updated_on
 */
class Classes extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'classes';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['teacher_id', 'school_id', 'status'], 'required'],
            [['teacher_id', 'school_id', 'status'], 'integer'],
            [['created_on', 'updated_on'], 'safe'],
            [['class_name', 'created_by', 'updated_by'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'class_name' => 'Class Name',
            'teacher_id' => 'Teacher ID',
            'school_id' => 'School ID',
            'status' => 'Status',
            'created_by' => 'Created By',
            'created_on' => 'Created On',
            'updated_by' => 'Updated By',
            'updated_on' => 'Updated On',
        ];
    }
}
