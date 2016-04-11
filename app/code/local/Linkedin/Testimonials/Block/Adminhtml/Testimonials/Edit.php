<?php

class Linkedin_Testimonials_Block_Adminhtml_Testimonials_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{

    public function __construct() {
        parent::__construct();

        $this->_objectId = 'id';
        $this->_blockGroup = 'testimonials';
        $this->_controller = 'adminhtml_testimonials';

        $this->_updateButton('save', 'label', Mage::helper('testimonials')->__('Save'));
        $this->_updateButton('delete', 'label', Mage::helper('testimonials')->__('Delete'));

        $this->_addButton('saveandcontinue', array(
            'label' => Mage::helper('testimonials')->__('Save and continue'),
            'onclick' => 'saveAndContinueEdit()',
            'class' => 'save',
        ), -100);

        $this->_formScripts[] = "
            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";
    }

    public function getHeaderText() {
        /** @var Linkedin_Testimonials_Model_Testimonials $model */
        $model = Mage::registry('testimonial_data');
        if ($model && $model->getId()) {
            return Mage::helper('testimonials')->__('Edit Testimonial');
        } else {
            return Mage::helper('testimonials')->__('Add New Testimonial');
        }
    }

}
