<?php
class Gains_Checkout_Block_Cart_Promotion extends Mage_Checkout_Block_Cart_Abstract
{
	
	private function _getCheckoutCart()
	{
		return Mage::getSingleton('checkout/cart');
	}
	
	/**
	Decide is there any bedlinen product in cart, based on BEDLINEN_CATEGORY_ID
	*/
	public function containsBedlinen()
	{
		$cartModel=$this->_getCheckoutCart();
		$bedlinenAmount=$cartModel->getSpecialTotalQtyAmount(11);
		return 	$bedlinenAmount[0]>0;
	}
		/**
	Decide is there any bedlinen product in cart, based on QUILT_CATEGORY_ID
	*/
	public function containsQuilt()
	{
		$cartModel=$this->_getCheckoutCart();
		$quiltAmount=$cartModel->getSpecialTotalQtyAmount(4);
		return $quiltAmount[0]>0;
	}

    	/**
	Decide is there buy bedlinen product more than 300
	*/
	public function overThresholdBedlinen()
	{
		$cartModel=$this->_getCheckoutCart();
		$bedlinenAmount=$cartModel->getSpecialTotalQtyAmount(11);
		return 	$bedlinenAmount[1]>300;
	}
		/**
	Decide is there buy quilt product more than 300
	*/
	public function overThresholdQuilt()
	{
		$cartModel=$this->_getCheckoutCart();
		$quiltAmount=$cartModel->getSpecialTotalQtyAmount(4);
		return $quiltAmount[1]>300;
	}
    /**
	Decide is there any Gift Cushion
	*/
	public function containsGiftCushion()
	{
		$cartModel=$this->_getCheckoutCart();
		$bedlinenAmount=$cartModel->getSpecialTotalQtyAmount(34);
		return 	$bedlinenAmount[0]>0;
	}
    /**
	Decide is there any Gift Cushion
	*/
    public function containsGiftPillow()
	{
		$cartModel=$this->_getCheckoutCart();
		$bedlinenAmount=$cartModel->getSpecialTotalQtyAmount(35);
		return 	$bedlinenAmount[0]>0;
	}
}