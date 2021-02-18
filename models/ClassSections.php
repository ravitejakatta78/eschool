<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "class_sections".
 *
 * @property int $id
 * @property int $class_id
 * @property int $school_id
 * @property string $section_name
 * @property int $section_status
 * @property string|null $created_by
 * @property string|null $created_on
 * @property string|null $updated_on
 * @property string|null $updated_by
 * @property int $teacher_id
 */
class ClassSections extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'class_sections';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['class_id', 'school_id', 'section_name', 'section_status', 'teacher_id'], 'required'],
            [['class_id', 'school_id', 'section_status', 'teacher_id'], 'integer'],
            [['created_on'], 'safe'],
            [['section_name', 'created_by', 'updated_on', 'updated_by'], 'string', 'max' => 100],
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
            'school_id' => 'School ID',
            'section_name' => 'Section Name',
            'section_status' => 'Section Status',
            'created_by' => 'Created By',
            'created_on' => 'Created On',
            'updated_on' => 'Updated On',
            'updated_by' => 'Updated By',
            'teacher_id' => 'Teacher ID',
        ];
    }
}
