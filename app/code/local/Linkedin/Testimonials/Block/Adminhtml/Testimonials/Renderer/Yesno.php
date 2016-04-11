<?php

class Linkedin_Testimonials_Block_Adminhtml_Testimonials_Renderer_Yesno extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract {

    public function render(Varien_Object $row) {
        $helper = Mage::helper('testimonials');
        return $row->getApproved() ? $helper->__('Yes') : $helper->__('No');
    }
}