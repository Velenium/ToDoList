<?php

namespace App;


class ResultConst
{
	public const Result = [
		'001' => ['result' => 'Task Created!', 'code' => 200],
		'002' => ['result' => 'Body Updated!', 'code' => 200],
		'003' => ['result' => 'Status Updated!', 'code' => 200],
		'004' => ['result' => 'Task Deleted!', 'code' => 200],
		'005' => ['result' => 'Nothing to do!', 'code' => 204],		
	];

	public const Validator = [
		'101' => ['error' => 'Invalid Name Given', 'code' => 400], 
 		'102' => ['error' => 'Invalid Body Given', 'code' => 400],
 		'103' => ['error' => 'Invalid Task ID Given', 'code' => 400],
		'104' => ['error' => 'Invalid Param Given', 'code' => 400],
	];

	public const Repository = [
		'201' => ['error' => 'Task not found', 'code' => 404]];

	public const Task = [
		'301' => ['error' => 'Minimum name length is 3', 'code' => 411],
		'302' => ['error' => 'Minimum body length is 3', 'code' => 411],
		'303' => ['error' => 'Task Already Completed', 'code' => 409],
		'304' => ['error' => 'Task Already Canceled', 'code' => 409],
		'305' => ['error' => 'Expected status: in progress/completed/canceled', 'code' => 406]
	];
}