<?php

class Linkedin_Testimonials_Model_Resource_Testimonials_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{
    protected function _construct()
    {
        parent::_construct();
        $this->_init('testimonials/testimonials');
    }

    public function bindCustomerToCollection(){
        $this->getSelect()
            ->join( array('ce1' => 'customer_entity'), 'ce1.entity_id=main_table.customer_id', array('customer_email' => 'email'));

        $fn = Mage::getModel('eav/entity_attribute')->loadByCode('1', 'firstname');
        $ln = Mage::getModel('eav/entity_attribute')->loadByCode('1', 'lastname');
        $this->getSelect()
            ->join(array('ce2' => 'customer_entity_varchar'), 'ce2.entity_id=main_table.customer_id', array('firstname' => 'value'))
            ->where('ce2.attribute_id='.$fn->getAttributeId())
            ->join(array('ce3' => 'customer_entity_varchar'), 'ce3.entity_id=main_table.customer_id', array('lastname' => 'value'))
            ->where('ce3.attribute_id='.$ln->getAttributeId())
            ->columns(new Zend_Db_Expr("CONCAT(`ce2`.`value`, ' ',`ce3`.`value`) AS customer_name"));


        return $this;
    }
}
