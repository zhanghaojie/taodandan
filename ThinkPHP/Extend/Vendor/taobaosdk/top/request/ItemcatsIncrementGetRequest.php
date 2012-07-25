<?php
/**
 * TOP API: taobao.itemcats.increment.get request
 * 
 * @author auto create
 * @since 1.0, 2012-07-14 16:31:04
 */
class ItemcatsIncrementGetRequest
{
	/** 
	 * 商品所属类目ID列表，用半角逗号(,)分隔 例如:(16,19562,) 不能超过10个一级类目
	 **/
	private $cids;
	
	/** 
	 * 默认为1，最大值为7，可选值为大于等于1，小于等于7的整数值
	 **/
	private $days;
	
	/** 
	 * 查询此类目的卖家类型。
不传默认值视为C卖家
	 **/
	private $sellerType;
	
	private $apiParas = array();
	
	public function setCids($cids)
	{
		$this->cids = $cids;
		$this->apiParas["cids"] = $cids;
	}

	public function getCids()
	{
		return $this->cids;
	}

	public function setDays($days)
	{
		$this->days = $days;
		$this->apiParas["days"] = $days;
	}

	public function getDays()
	{
		return $this->days;
	}

	public function setSellerType($sellerType)
	{
		$this->sellerType = $sellerType;
		$this->apiParas["seller_type"] = $sellerType;
	}

	public function getSellerType()
	{
		return $this->sellerType;
	}

	public function getApiMethodName()
	{
		return "taobao.itemcats.increment.get";
	}
	
	public function getApiParas()
	{
		return $this->apiParas;
	}
	
	public function check()
	{
		
		RequestCheckUtil::checkNotNull($this->cids,"cids");
		RequestCheckUtil::checkMaxListSize($this->cids,1000,"cids");
		RequestCheckUtil::checkMaxValue($this->days,7,"days");
		RequestCheckUtil::checkMinValue($this->days,1,"days");
	}
}
