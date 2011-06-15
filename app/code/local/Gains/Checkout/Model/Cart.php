<?php
/**
 * Gains Shoping cart model
 *
 * @category    Gains
 * @package     Gains_Checkout
 * @author      zy
 */
class Gains_Checkout_Model_Cart extends Mage_Checkout_Model_Cart
{
	public function getBedlinenProduct ()
	{
		return  array("BlackBerry 8100 Pearl","HTC Touch Diamond","Samsung MM-A900M Ace","AT&T 8525 PDA","Sony Ericsson W810i");
	}
	public function getQuiltProduct ()
	{
		return  array("ECCO Womens Golf Flexor Golf Shoe","Nine West Women's Lucero Pump","Steven by Steve Madden Pryme Pump");
	}
	public function getCushionProduct ()
	{
		return  array("Chair");
	}
	public function getPillowProduct ()
	{
		return  array("Couch");
	}
	//$product can be 
	//quilt
	//bedlinen 
	//cushion
	//pillow

	public function getSpecialQty($product)
	{	
		$specialProduct;
		if($product=="bedlinen"){
			$specialProduct=$this->getBedlinenProduct();
		}else if($product=="quilt"){
			$specialProduct=$this->getQuiltProduct();
		}else if($product=="cushion"){
			$specialProduct=$this->getCushionProduct();
		}else if($product=="pillow"){
			$specialProduct=$this->getPillowProduct();
		}
		$num=0;
		Mage::log("containsCategory invoke");
		foreach ($this->getItems() as $item){
			Mage::log("containsCategory invoke foreach");
			if ($this->isItemInArray($item,$specialProduct)){
				Mage::log("item->getQty()");
				Mage::log($item->getQty());
				Mage::log($item->getProduct()->getName());
				$num+=$item->getQty();
			}
		}
		return $num;
	}
	private function isItemInArray($item, $productArr)
	{
		for($i=0; $i< count($productArr);$i++)
		{
			if(strcmp($item->getProduct()->getName(),$productArr[$i])==0)
			{
				return true;
			}			
		}
		return false;
	}

}
