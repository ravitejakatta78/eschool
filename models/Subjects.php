<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "subjects".
 *
 * @property int $id
 * @property int $school_id
 * @property string $subject_name
 * @property int $status
 * @property string|null $created_on
 * @property string|null $created_by
 * @property string|null $updated_on
 * @property string|null $updated_by
 */
class Subjects extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'subjects';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['school_id', 'subject_name', 'status'], 'required'],
            [['school_id', 'status'], 'integer'],
            [['created_on', 'updated_on'], 'safe'],
            [['subject_name', 'created_by', 'updated_by'], 'string', 'max' => 100],
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
            'subject_name' => 'Subject Name',
            'status' => 'Status',
            'created_on' => 'Created On',
            'created_by' => 'Created By',
            'updated_on' => 'Updated On',
            'updated_by' => 'Updated By',
        ];
    }
}
