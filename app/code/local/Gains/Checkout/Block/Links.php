<?php
class Gains_Checkout_Block_Links extends Mage_Checkout_Block_Links
{
 	public function addCartLink()
    {
        $parentBlock = $this->getParentBlock();
        
        if ($parentBlock && Mage::helper('core')->isModuleOutputEnabled('Mage_Checkout')) 
        {
            $count = $this->helper('checkout/cart')->getSummaryCount();

			$totalAmount  = $this->helper('checkout/cart')->getQuote()->getGrandTotal();
            if( $count >0 ) 
            {
                $text = $this->__('My Cart ($%.2f)',$totalAmount  );
            } 
            else 
            {
                $text = $this->__('My Cart');
            }

            $parentBlock->addLink($text, 'checkout/cart', $text, true, array(), 50, null, 'class="top-link-cart"');
        }
        return $this;
    }
}