<?php
/**
 * TOP API: taobao.sellercenter.rolemembers.get request
 * 
 * @author auto create
 * @since 1.0, 2012-05-27 12:32:14
 */
class SellercenterRolemembersGetRequest
{
	/** 
	 * 角色id
	 **/
	private $roleId;
	
	private $apiParas = array();
	
	public function setRoleId($roleId)
	{
		$this->roleId = $roleId;
		$this->apiParas["role_id"] = $roleId;
	}

	public function getRoleId()
	{
		return $this->roleId;
	}

	public function getApiMethodName()
	{
		return "taobao.sellercenter.rolemembers.get";
	}
	
	public function getApiParas()
	{
		return $this->apiParas;
	}
	
	public function check()
	{
		
		RequestCheckUtil::checkNotNull($this->roleId,"roleId");
	}
}
