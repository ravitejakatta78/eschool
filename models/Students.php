<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "students".
 *
 * @property int $id
 * @property int $school_id
 * @property int $role_id
 * @property int $status
 * @property string $first_name
 * @property string|null $last_name
 * @property int $gender
 * @property string $dob
 * @property string $address
 * @property string|null $roll_number
 * @property string|null $blood_group
 * @property int|null $religion
 * @property int $student_class
 * @property int|null $student_section
 * @property string $admission_id
 * @property string|null $student_img
 * @property int|null $parent_id
 * @property string|null $created_by
 * @property string $created_on
 * @property string|null $updated_by
 * @property string $updated_on
 * @property string $reg_date
 */
class Students extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'students';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['school_id', 'role_id', 'status', 'first_name', 'gender', 'dob', 'address', 'student_class', 'admission_id', 'reg_date'], 'required'],
            [['school_id', 'role_id', 'status', 'gender', 'religion', 'student_class', 'student_section', 'parent_id'], 'integer'],
            [['dob', 'created_on', 'updated_on', 'reg_date'], 'safe'],
            [['address'], 'string'],
            [['student_img'], 'file', 'extensions' => 'png, jpg, jpeg'],
            [['first_name', 'last_name'], 'string', 'max' => 255],
            [['roll_number', 'created_by', 'updated_by'], 'string', 'max' => 100],
            [['blood_group', 'admission_id'], 'string', 'max' => 50],
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
            'role_id' => 'Role ID',
            'status' => 'Status',
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'gender' => 'Gender',
            'dob' => 'Dob',
            'address' => 'Address',
            'roll_number' => 'Roll Number',
            'blood_group' => 'Blood Group',
            'religion' => 'Religion',
            'student_class' => 'Student Class',
            'student_section' => 'Student Section',
            'admission_id' => 'Admission ID',
            'student_img' => 'Student Img',
            'parent_id' => 'Parent ID',
            'created_by' => 'Created By',
            'created_on' => 'Created On',
            'updated_by' => 'Updated By',
            'updated_on' => 'Updated On',
            'reg_date' => 'Reg Date',
        ];
    }
}
