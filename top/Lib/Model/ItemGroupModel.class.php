<?php

class ItemGroupModel extends Model {
	protected $userId = null;
	
	public function __construct($userId = null) {
		parent::__construct();
		$this->userId = $userId;
	}
	
	public function setUserId($userId) {
		$this->userId = $userId;
	}
	
	public function getUserId() {
		return $this->userId;
	}
	
	public function isGroupNameExist($groupName, $userId=null) {
		if (!$userId) {
			$userId = $this->userId;
		}
		$group = $this->where("name='{$groupName}' and user_id={$userId}")->select();
		if ($group) {
			return true;
		}
		return false;
	}
	
	public function createGroup($groupName, $remark, $userId=null) {
		if (!$userId) {
			$userId = $this->userId;
		}
		if (!$this->isGroupNameExist($groupName, $userId)) {
			$data = Array();
			$data['name'] = $groupName;
			$data['remark'] = $remark;
			if ($this->create($data)) {
				if ($this->add()) {
					$group = $this->where("name='{$groupName}'")->select();
					return $group[0]['id'];
				}
			}
		}
		return false;
	}
	
	public function deleteGroupById($groupId, $userId=null) {
		$this->startTrans();
		$isCommit = true;
		while (true) {
			$itemModel = D('Item');
			$data['group_id'] = null;
			$ret = $itemModel->where("group_id='{$groupId}' and user_id={$userId}")->select();
			if ($ret) {
				$isCommit = $itemModel->where("group_id='{$groupId}' and user_id={$userId}")->save($data);
				if (!$isCommit) {
					break;
				}
			}
			$isCommit = $this->where("id='{$groupId}' and user_id={$userId}")->delete();
			break;
		}
		if ($isCommit) {
			$this->commit();
			return true;
		}
		else {
			$this->rollback();
			return false;
		}
	}
	
	public function deleteGroupByName($groupName, $userId=null) {
		$group = $this->where("name='{$groupName}' and user_id={$userId}")->select();
		if ($group) {
			$ret = $this->deleteItemGroupById($group['id'], $userId);
			return $ret;
		}
		else {
			return false;
		}
	}
	
	public function getGroupById($groupId, $userId=null) {
		$ret = $this->where("id={$groupId} and user_id={$userId}")->select();
		if ($ret) {
			$group = $ret[0];
			$itemModel = D('Item');
			$ret = $itemModel->where("group_id={$group['id']} and user_id={$userId}")->count();
			$group['item_count'] = $ret;
			return $group;
		}
		return false;
	}
	
	public function getGroupByName($groupName, $userId=null) {
		$groupModel = D('ItemGroup');
		$ret = $groupModel->where("name='{$groupName}' and user_id={$userId}")->select();
		if ($ret) {
			$group = $this->getItemGroupById($ret[0]['id'], $userId);
			return $group;
		}
		return false;
	}
	
	public function addItem() {
		
	}
	
}