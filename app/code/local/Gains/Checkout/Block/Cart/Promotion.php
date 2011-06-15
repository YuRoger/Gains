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
		return $cartModel->getSpecialQty("bedlinen")>0;
	}
		/**
	Decide is there any bedlinen product in cart, based on QUILT_CATEGORY_ID
	*/
	public function containsQuilt()
	{
		$cartModel=$this->_getCheckoutCart();
		return $cartModel->getSpecialQty("quilt")>0;
	}
}