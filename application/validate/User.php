<?php
namespace app\validate;
use think\Validate;

class User extends Validate
{
	protected $rule = [
		'username|用户名'  	=> [
			'require' 	=> 'require',
			'min'		=>	8,
			'max'		=>	20,
		],
		'password|密码'  	=> [
			'require'	=> 'require',
			'min'		=> 6
		],
		'email|邮箱'  		=> [
			'email'		=> 'email',			
		],
		'phone' 			=> [
			// 'mobile'		=> 'mobile',
			'mobile'		=> '1[34578]\d{9}',
		],
	];
}