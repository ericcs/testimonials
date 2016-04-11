<?php

class Linkedin_Testimonials_Block_Adminhtml_Testimonials_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

    public function __construct() {
        parent::__construct();
        $this->setId('tesimonials_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('testimonials')->__('Testimonial Information'));
    }

    protected function _beforeToHtml() {

        $this->addTab('testimonial', array(
            'label' => Mage::helper('testimonials')->__('Information'),
            'alt' => Mage::helper('testimonials')->__('Information'),
            'content' => $this->getLayout()->createBlock('testimonials/adminhtml_testimonials_edit_tab_testimonial')->toHtml(),
        ));

        return parent::_beforeToHtml();
    }
}
