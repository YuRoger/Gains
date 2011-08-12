<?php
class Gains_Catalog_Block_Product_View extends Mage_Catalog_Block_Product_View 
{
	public function isQuiltPromotion()
	{
		$product = $this->getProduct();
		$value = $product->getData('isquiltpromotion');
		return $value;
	}
	
	public function isComingSoon()
	{
		$product = $this->getProduct();
		$value = $product->getData('iscomingsoon');
		return $value;
	}
	
	/* 
	 * get Quilt cover product object from the current product.
	 * if id is "", return null
	 * */
	public function fetchQuiltCoverProduct()
	{
		$product = $this->getProduct();
		$quiltcoverid = $product->getData('pillowcoverid');
		if(strcmp($quiltcoverid,"")==0)
		{
			return null;
		}
		else
		{
			$quilt_product_model = Mage::getModel('catalog/product')->load($quiltcoverid);
			return $quilt_product_model;
		}
	}
	
	/*
	 * get Cushion product object from the current product.
	 * if id is "", return null
	 * */
	public function fetchCushionProduct()
	{
		$product = $this->getProduct();
		$cushionid = $product->getData('cushionid');
		if(strcmp($cushionid,"")==0)
		{
			return null;
		}
		else
		{
			$cushion_product_model = Mage::getModel('catalog/product')->load($cushionid);
			return $cushion_product_model;
		}
	}
}