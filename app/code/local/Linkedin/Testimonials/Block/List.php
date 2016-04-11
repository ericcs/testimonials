<?php

class Linkedin_Testimonials_Block_List extends Mage_Core_Block_Template{

    protected $_collection = false;

    public function _construct(){
        $this->setTemplate('testimonials/testimonials/list.phtml');
        parent::_construct();

    }

    /**
     * @return Linkedin_Testimonials_Model_Testimonials[]
     */
    public function getTestimonials(){
        $collection = $this->_getCollection();
        return $collection->count() ? $collection->getItems() : false;
    }

    public function _prepareLayout(){
        if ($breadcrumbs = $this->getLayout()->getBlock('breadcrumbs')) {
            $helper = Mage::helper('testimonials');
            $breadcrumbs->addCrumb('home', array('label'=>$helper->__('Home'), 'title'=>$helper->__('Go to Home Page'), 'link'=>Mage::getBaseUrl()));
            $breadcrumbs->addCrumb('testimonials_list', array('label'=>$helper->__('Testimonials'), 'title'=>$helper->__('Testimonials')));
        }

        /** @var Mage_Page_Block_Html_Pager $pager */
        $pager = $this->getLayout()->createBlock('page/html_pager', 'testimonials_list.pager');
        $pager->setAvailableLimit(array(5=>5,10=>10,20=>20,'all'=>'all'));
        $pager->setCollection($this->_getCollection());
        $this->setChild('pager', $pager);
        $this->_getCollection()->load();

        return parent::_prepareLayout();
    }

    public function getPagerHtml()
    {
        return $this->getChildHtml('pager');
    }


    protected function _getCollection(){
        if(!$this->_collection){
            /** @var Linkedin_Testimonials_Model_Resource_Testimonials_Collection $collection */
            $collection = Mage::getModel('testimonials/testimonials')->getCollection();
            $collection->bindCustomerToCollection();
            $collection->getSelect()->where("main_table.approved = '1'");
            $this->_collection = $collection;
        }

        return $this->_collection;
    }
}