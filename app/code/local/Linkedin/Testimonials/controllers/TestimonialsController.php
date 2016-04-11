<?php

class Linkedin_Testimonials_TestimonialsController extends Mage_Core_Controller_Front_Action
{

    public function _construct(){
        parent::_construct();
        /** @var Linkedin_Testimonials_Helper_Data $helper */
        $helper = Mage::helper('testimonials');
        if(!$helper->isActive())
            return $this->_redirectUrl(Mage::getBaseUrl());
    }

    public function listAction(){
        $this->_title($this->__('Testimonials'))->_title($this->__('Customers Testimonials'));
        $this->loadLayout();
        $this->renderLayout();
    }

    public function createAction(){
        $this->_onlyToCustomers();
        $this->_title($this->__('Testimonials'))->_title($this->__('Post Your Testimonial'));
        $this->loadLayout();
        $this->renderLayout();
    }

    public function saveAction(){
        $this->_onlyToCustomers();
        $request = $this->getRequest();
        if($request->isPost()){
            /** @var Mage_Core_Model_Session $coreSession */
            $coreSession = Mage::getSingleton('core/session');
            $postedKey = $this->getRequest()->getParam('form_key', null);
            $sessionKey = $coreSession->getFormKey();
            if($postedKey != $sessionKey){
                $coreSession->addError('Invalid Form Key!');
            }else{
                $data = $request->getPost();
                /** @var Mage_Customer_Model_Session $customerSession */
                $customerSession = Mage::getSingleton('customer/session');
                $customerSession->setTestimonialFormData($data);

                /** @var Linkedin_Testimonials_Model_Testimonials $entity */
                $entity = Mage::getModel('testimonials/testimonials');
                $entity->setData('approved', $this->_getTestimonialHelper()->getConfig('default_approved'));
                $entity->setData('customer_id', $customerSession->getCustomerId());
                $entity->setData('message', $data['message']);
                $entity->setData('created_at', Mage::getModel('core/date')->gmtDate());
                $entity->save();

                if($entity->getId()){
                    if($this->_getTestimonialHelper()->getConfig('default_approved'))
                        $coreSession->addSuccess('Your testimonial was sent successfuly! Thank you!');
                    else
                        $coreSession->addSuccess('Your testimonial was sent successfuly and is pending review! Thank you!');

                    $customerSession->setTestimonialFormData(new Varien_Object());
                    return $this->_redirectUrl($this->_getTestimonialHelper()->getPostTestimonialsUrl());
                }else
                    $coreSession->addError("An error occurred while trying to save! Please try again.");
            }
        }
        $this->_redirectReferer();
    }

    protected function _onlyToCustomers(){
        /** @var Mage_Customer_Model_Session $customerSession */
        $customerSession = Mage::getSingleton('customer/session');
        if(!$customerSession->isLoggedIn()){
            $customerSession->setAfterAuthUrl($this->_getTestimonialHelper()->getPostTestimonialsUrl());
            return $this->_redirectUrl(Mage::helper('customer')->getLoginUrl());
        }

    }

    /** @return Linkedin_Testimonials_Helper_Data */
    protected function _getTestimonialHelper(){
        $helper = Mage::helper('testimonials');
        return $helper;
    }

}
