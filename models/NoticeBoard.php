<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "notice_board".
 *
 * @property int $id
 * @property int $school_id
 * @property string $notice_text
 * @property string $notice_start_date
 * @property string $notice_end_date
 * @property int $notice_status
 * @property string $created_on
 * @property string $created_by
 * @property string|null $updated_on
 * @property string|null $updated_by
 */
class NoticeBoard extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'notice_board';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['school_id', 'notice_text', 'notice_start_date', 'notice_end_date', 'created_on', 'created_by'], 'required'],
            [['school_id', 'notice_status'], 'integer'],
            [['notice_text'], 'string'],
            [['notice_start_date', 'notice_end_date', 'created_on', 'updated_on'], 'safe'],
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
            'notice_text' => 'Notice Text',
            'notice_start_date' => 'Notice Start Date',
            'notice_end_date' => 'Notice End Date',
            'notice_status' => 'Notice Status',
            'created_on' => 'Created On',
            'created_by' => 'Created By',
            'updated_on' => 'Updated On',
            'updated_by' => 'Updated By',
        ];
    }
}
