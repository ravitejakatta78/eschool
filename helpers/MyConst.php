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
	const _PARENT = '4';	
	
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

	const _DEFAULT_PASSWORD = 'Admin@123'; // default password

	

}

?>
