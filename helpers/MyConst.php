<?php
namespace app\helpers;

use yii;
class MyConst 
{
	/* ROLE CONSTANTS */
	const _SUPER_ADMIN = '1';
	const _SCHOOL_ADMIN = '2';
	const _TEACHER = '3';
	const _STUDENT = '4';
	const _PARENT = '5';	
	
	/* STATUS CONSTANTS */
	const _ACTIVE = '1';
	const _INACTIVE = '2';

	/* Responce CONSTANTS */
	const _SUCCESS = '1';
	const _FAIL = '2';

	/* Gender CONSTANTS */
	const _MALE = '1';
	const _FEMALE = '2';
	const _OTHER = '3';
	const _GENDER = [self::_MALE => 'Male',self::_FEMALE => 'Female',self::_OTHER => 'Other'];

	const PARENT_TYPE = [self::_MALE => 'Father',self::_FEMALE => 'Mother',self::_OTHER => 'Gurdian'];
	const _RELIGION = ['1' => 'Hindu','2' => 'Christian','3' => 'Islam','4' => 'Buddish','5' => 'Other'];
	const _DEFAULT_PASSWORD = 'Admin@123'; // default password

	// date format constants
	const _D_M_Y = 1;
	const _Y_M_D = 2;
	const _Y_M_D_H = 3; 

	

}

?>
