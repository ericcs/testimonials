<?php

$installer = $this;
/* @var $installer Mage_Core_Model_Resource_Setup */

$installer->startSetup();

$tableTestimonials = $installer->getTable('testimonials/testimonials');
if(!$installer->tableExists($tableTestimonials)){
    $table = $installer->getConnection()
        ->newTable($tableTestimonials)
        ->addColumn('id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
            'identity'  => true,
            'unsigned'  => true,
            'nullable'  => false,
            'primary'   => true,
        ), 'ID')
        ->addColumn('customer_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
            'unsigned'  => true,
            'nullable'  => true,
            'default'   => '0',
        ), 'Customer ID')
        ->addColumn('message', Varien_Db_Ddl_Table::TYPE_TEXT, null, array(
            'nullable'  => false,
        ), 'Testimonial Message')
        ->addColumn('approved', Varien_Db_Ddl_Table::TYPE_BOOLEAN, null, array(
            'nullable'  => false,
            'default'   => false
        ), 'Approved Flag')
        ->addColumn('created_at', Varien_Db_Ddl_Table::TYPE_DATETIME, null, array())
        ->addIndex(
            $installer->getConnection()->getIndexName($tableTestimonials, array('customer_id')),
            array('customer_id'),
            array('type' => 'index')
        );
    $installer->getConnection()->createTable($table);
}
$installer->endSetup();

