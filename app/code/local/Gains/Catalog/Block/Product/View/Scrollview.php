<?php
class Gains_Catalog_Block_Product_View_Scrollview extends Mage_Catalog_Block_Product_Abstract
{
	public function getCategory()
	{
		$_currentCategory = $this->getCurrentCategory();
		//$categoryModel = Mage::getModel('catalog/category');
		if($_currentCategory == null)
		{
			return "sdds";
		}
		else
			return $_currentCategory->getName();	
	}
	
    /**
     * Retrieve current category model object
     *
     * @return Mage_Catalog_Model_Category
     */
    private function getCurrentCategory()
    {
        if (!$this->hasData('current_category')) {
            $this->setData('current_category', Mage::registry('current_category'));
        }
        return $this->getData('current_category');
    }
	
    /*
     * return product list in current category, sort by name
     */
    public function getProductlistinCurrentCategory()
    {
    	 $product = Mage::getModel('catalog/product');
    	 $currentCategory = $this->getCurrentCategory();
   		 if($currentCategory == null)
   		 {
   		 	return null;
   		 }
   		 else 
   		 {
   		 	$collection = $product->getCollection()
                ->addAttributeToSelect('name')
                ->addAttributeToSelect('small_image')
                ->addAttributeToSelect('status')
                ->addAttributeToSort('name','asc');
              
       		return  $collection->addCategoryFilter($currentCategory);	
   		 }
    }
}
