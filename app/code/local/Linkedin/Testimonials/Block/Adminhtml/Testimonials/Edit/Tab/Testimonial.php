<?php

class Linkedin_Testimonials_Block_Adminhtml_Testimonials_Edit_Tab_Testimonial extends Mage_Adminhtml_Block_Widget_Form
{
    protected function _prepareForm() {

        $form = new Varien_Data_Form();
        $fieldset = $form->addFieldset('testimonial_form', array('legend' => Mage::helper('testimonials')->__('Testimonial Information')));

        //Status
        $fieldset->addField('approved', 'select', array(
            'label' => Mage::helper('testimonials')->__('Approved'),
            'name' => 'approved',
            'class' => '',
            'options' => Mage::getModel('adminhtml/system_config_source_yesno')->toArray()
        ));


        $fieldset->addField('message', 'textarea', array(
            'label' => Mage::helper('testimonials')->__('Message'),
            'name' => 'message',
            'class' => 'required-entry',
            'required' => true,
        ));


        if (Mage::getSingleton('adminhtml/session')->getTestimonialData()) {
            $form->setValues(Mage::getSingleton('adminhtml/session')->getTestimonialData());
            Mage::getSingleton('adminhtml/session')->setTestimonialData(null);
        } elseif (Mage::registry('testimonial_data')) {
            $form->setValues(Mage::registry('testimonial_data')->getData());
        }

        $this->setForm($form);
        return parent::_prepareForm();
    }
}
