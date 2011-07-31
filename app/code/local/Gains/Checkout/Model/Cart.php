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
	public function getProductsByCategoryId($id)
	{
		$category=Mage::getModel('catalog/category')->load($id);
		$result = $category->getProductCollection();
		/*
		Mage::Log("getSize");
		Mage::Log($result->getSize());
		Mage::Log("getProductCount");
		Mage::Log($category->getProductCount());
		*/
		return $result;
	}
	public function getQtyByProductName($prodcutName){
		foreach ($this->getItems() as $item){
			Mage::log("getQtyByProductId invoke foreach");
			if ($item->getProduct()->getName()==$prodcutName){
				Mage::log($item->getQty());
				return $item->getQty();
			}
		}
		return 0;
	}
	//$product can be 
	//quilt
	//bedlinen 

	public function getSpecialTotalQtyAmount($categoryID)
	{	
		$specialProduct=$this->getProductsByCategoryId($categoryID);
		$totalNum=0;
		$totalAmount=0.0;
		Mage::log("containsCategory invoke");
		foreach ($this->getItems() as $item){
			Mage::log("containsCategory invoke foreach");
			if ($this->isItemInArray($item,$specialProduct)){
				Mage::log("item->getQty()");
				Mage::log($item->getQty());
				Mage::log($item->getProduct()->getName());
				$totalNum+=$item->getQty();
				$price = $item->getDiscountCalculationPrice();
				if($price == null)
					$price=$item->getCalculationPrice();
				$totalAmount+=$item->getQty()*$price;
			}
		}
		return array($totalNum,$totalAmount);
	}
	public function isItemInArray($item, $productCollection)
	{
//		Mage::Log("isItemInArray");		
		$productArr=$productCollection->getItems();
		return array_key_exists($item->getProduct()->getId(),$productArr);
	}

}
