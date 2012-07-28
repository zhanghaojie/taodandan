<?php

class ScheduleAction 
{
	protected $userModel = null;
	
	public function __construct() {
		//$this->userModel = new UserModel();
	}
	
	protected function performUserSchedule($userId) {
		$this->userModel = new UserModel($userId);
	}
	
	protected function performAllUserSchedule() {
		$userModel = D('User');
		$usersId = $userModel->field('user_id')->where('is_start_mission<>0')->select();
		foreach($usersId as $userId) {
			$this->performUserSchedule($userId);
		}
	}
	
	public function tick() {
		$this->performAllUserSchedule();
	}

}
