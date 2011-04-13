<?php
 
class Gains_Catalog_Block_Product_Featured extends Mage_Catalog_Block_Product_Abstract
{
	/*
	public function getProductFeatured()
	{            
        $product = Mage::getModel('catalog/product');
        if($this->getCategoryId())
            $category = Mage::getModel('catalog/category')->load($this->getCategoryId());
        
        $collection = $product->getCollection()
                ->addAttributeToSelect('name')
                ->addAttributeToSelect('price')
                ->addAttributeToSelect('special_price')
                ->addAttributeToSelect('small_image')
                ->addAttributeToFilter('featured',array('yes'=>true))
                ->addAttributeToSelect('status')
                ->addAttributeToSort('priority','asc');
    
        if(isset($category)) {
            $collection->addCategoryFilter($category);
        }
    
        $collection ->addStoreFilter();        
            
        if($this->getOrderby())    
            $collection->getSelect()->order($this->getOrderby());
        if($this->getNumProducts())
            $collection->getSelect()->limit($this->getNumProducts());
    
        Mage::getSingleton('catalog/product_status')->addSaleableFilterToCollection($collection);
        Mage::getSingleton('catalog/product_visibility')->addVisibleInCatalogFilterToCollection($collection);
    
        return $collection;
    
    }
    */
}
