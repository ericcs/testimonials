<?php

class Linkedin_Testimonials_Block_Create extends Mage_Core_Block_Template{

    public function _construct(){
        $this->setTemplate('testimonials/testimonials/create.phtml');
        parent::_construct();

    }

    public function getPostActionUrl(){
        return Mage::helper('testimonials')->getSaveTestimonialsUrl();
    }

    public function getBackUrl(){
        return Mage::helper('testimonials')->getListTestimonialsUrl();
    }

    /**
     * Retrieve form data
     *
     * @return Varien_Object
     */
    public function getFormData()
    {
        $data = $this->getData('form_data');
        if (is_null($data)){
            /** @var Mage_Customer_Model_Session $customerSession */
            $customerSession = Mage::getSingleton('customer/session');
            $formData = $customerSession->getTestimonialFormData();
            $data = new Varien_Object();
            if ($formData) {
                $data->addData($formData);
            }
            $this->setData('form_data', $data);
        }
        return $data;
    }

    public function _prepareLayout(){
        if ($breadcrumbs = $this->getLayout()->getBlock('breadcrumbs')) {
            /** @var Linkedin_Testimonials_Helper_Data $helper */
            $helper = Mage::helper('testimonials');
            $breadcrumbs->addCrumb('home', array('label'=>$helper->__('Home'), 'title'=>$helper->__('Go to Home Page'), 'link'=>Mage::getBaseUrl()));
            $breadcrumbs->addCrumb('testimonials_list', array('label'=>$helper->__('Testimonials'), 'title'=>$helper->__('Testimonials'), 'link'=> $helper->getListTestimonialsUrl()));
            $breadcrumbs->addCrumb('testimonials_create', array('label'=>$helper->__('Post Your Testimonial'), 'title'=>$helper->__('Testimonials')));
        }
        parent::_prepareLayout();
    }

}