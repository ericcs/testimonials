<?php

class Linkedin_Testimonials_Block_Adminhtml_Testimonials extends Mage_Adminhtml_Block_Widget_Grid_Container
{

    public function __construct()
    {
        $this->_blockGroup = 'testimonials';
        $this->_controller = 'adminhtml_testimonials';
        $this->_headerText = Mage::helper('testimonials')->__('Testimonials');

        parent::__construct();
        $this->_removeButton('add');
    }

}
