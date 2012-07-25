<?php
// 本类由系统自动生成，仅供测试用途

import("ORG.Util.Session");

class IndexAction extends Action {
	public function index(){
		if (Session::get('is_adminlogin')) {
			$this->display('index');
		}
		else {
			$this->display('login');
		}
	}
	
	public function login() {
		$userName = $this->_post('user_name');
		$password = $this->_post('password');
		
		$adminUserModel = D('AdminUser');
		$adminUser = $adminUserModel->where("user_name='{$userName}'")->select();
		if ($adminUser && count($adminUser) > 0) {
			if ($adminUser[0]['password'] === $password) {
				Session::set("is_adminlogin", true);
				$this->redirect('index');
			}
			else {
				echo "密码错误";
			}
		}
		else {
			echo "用户名错误";
		}
	}
	 
	public function logout() {
		Session::clear();
		Session::destroy();
		$this->redirect('index');
	}
	 
	public function launchSchedule() {
		$file_name = './task_schedule.conf';
		$file_pointer = fopen($file_name, 'w+');
		fseek($file_pointer, 0);
		fwrite($file_pointer, 'true');
		fclose($file_pointer);
		$this->performTask();
	}
	
	public function stopSchedule() {
		$file_name = './task_schedule.conf';
		$file_pointer = fopen($file_name, 'w+');
		fseek($file_pointer, 0);
		fwrite($file_pointer, 'false');
		fclose($file_pointer);
		
	}
	
	protected function _canPerformTask() {
		$file_name = './task_schedule.conf';
		$file_pointer = fopen($file_name, 'r+');
		$file_read = fread($file_pointer, filesize($file_name));
		$ret = false;
		if ($file_read === 'true') {
			$ret = true;
		}
		fclose($file_pointer);
		return $ret;
	}
	
	public function performTask() {
		while ($this->_canPerformTask()) {
			$file_name = './count.txt';
			$file_pointer = fopen($file_name, 'r+');
			$file_read = fread($file_pointer, filesize($file_name));
			$file_read = $file_read + 1;
			fseek($file_pointer, 0);
			fwrite($file_pointer, $file_read);
			fclose($file_pointer);
			sleep(5);
		}
	}
}