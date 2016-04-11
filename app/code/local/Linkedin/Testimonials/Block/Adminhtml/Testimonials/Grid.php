<?php

class Linkedin_Testimonials_Block_Adminhtml_Testimonials_Grid extends Mage_Adminhtml_Block_Widget_Grid
{

    public function __construct()
    {
        parent::__construct();
        $this->setId('testimonialsGrid');
        $this->setDefaultSort('id');
        $this->setSaveParametersInSession(true);
    }


    protected function _prepareCollection()
    {
        /** @var Linkedin_Testimonials_Model_Resource_Testimonials_Collection $collection */
        $collection = Mage::getModel('testimonials/testimonials')->getCollection();
        $collection->bindCustomerToCollection();
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {
        $this->addColumn('id', array(
            'header'    => Mage::helper('testimonials')->__('ID'),
            'width'     => '50px',
            'index'     => 'id',
            'type'  => 'number',
        ));

        $this->addColumn('customer_name', array(
            'header'    => Mage::helper('testimonials')->__('Customer'),
            'width'     => '150',
            'index'     => 'customer_name',
            'filter_index' => new Zend_Db_Expr("CONCAT(`ce2`.`value`, ' ',`ce3`.`value`)"),
        ));

        $this->addColumn('customer_email', array(
            'header'    => Mage::helper('testimonials')->__('Customer E-mail'),
            'width'     => '150',
            'index'     => 'customer_email',
            'filter_index' => "ce1.email",
        ));

        $this->addColumn('message', array(
            'header'    => Mage::helper('testimonials')->__('Message'),
            'width'     => '150',
            'index'     => 'message'
        ));


        $this->addColumn('approved', array(
            'header'    => Mage::helper('testimonials')->__('Approved'),
            'width'     => '150',
            'index'     => 'approved',
            'renderer' => 'testimonials/adminhtml_testimonials_renderer_yesno',
            'type' => 'options',
            'options' => Mage::getModel('adminhtml/system_config_source_yesno')->toArray(),
        ));


        $this->addExportType('*/*/exportCsv', Mage::helper('testimonials')->__('CSV'));
        $this->addExportType('*/*/exportXml', Mage::helper('testimonials')->__('Excel XML'));
        return parent::_prepareColumns();
    }


    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('id');
        $this->getMassactionBlock()->setFormFieldName('testimonials');

        $this->getMassactionBlock()->addItem('delete', array(
             'label'    => Mage::helper('testimonials')->__('Delete'),
             'url'      => $this->getUrl('*/*/massDelete'),
             'confirm'  => Mage::helper('testimonials')->__('Are you sure?')
        ));
        return $this;
    }


    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array('id'=>$row->getId()));
    }
}
