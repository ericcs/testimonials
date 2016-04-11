<?php

class Linkedin_Testimonials_Adminhtml_TestimonialsController extends Mage_Adminhtml_Controller_Action
{

    public function indexAction(){
        $this->_title($this->__('Testimonails'));
        $this->loadLayout();
        $this->_setActiveMenu('customer/testimonials/testimonials');
        $this->_addBreadcrumb(Mage::helper('testimonials')->__('Testimonials'), Mage::helper('adminhtml')->__('Testimonials'));
        $this->_addBreadcrumb(Mage::helper('testimonials')->__('Manage Testimonials'), Mage::helper('adminhtml')->__('Manage Testimonials'));
        $this->renderLayout();
    }


    public function newAction(){
        $this->_forward('edit');
    }


    /** @return Linkedin_Testimonials_Model_Testimonials */
    protected function _initTestimonial($idFieldName = 'id')
    {
        $this->_title($this->__('Testimonials'));

        $id = (int) $this->getRequest()->getParam($idFieldName);
        $entity = Mage::getModel('testimonials/testimonials');

        if ($id) {
            $entity->load($id);
        }

        Mage::register('current_testimonial', $entity);
        return $entity;
    }


    public function editAction() {
        $this->loadLayout();
        $model = $this->_initTestimonial();
        if($model->getId()){
            $data = Mage::getSingleton('adminhtml/session')->getFormData(true);
            if (!empty($data)) {
                $model->setData($data);
            }
            Mage::register('testimonial_data', $model);
        }
        $this->renderLayout();
    }


    public function saveAction() {

        if ($data = $this->getRequest()->getPost()) {

            $model = Mage::getModel('testimonials/testimonials');
            $model->setData($data)->setId($this->getRequest()->getParam('id'));

            try {
                $model->save();
                if($this->getRequest()->getParam('id')){
                    Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('testimonials')->__('Saved successfully'));
                } else {
                    Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('testimonials')->__('New data saved successfully'));
                }
                Mage::getSingleton('adminhtml/session')->setFormData(false);

                if ($this->getRequest()->getParam('back')) {
                    $this->_redirect('*/*/edit', array('id' => $model->getId()));
                    return;
                }
                $this->_redirect('*/*/');
                return;
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                Mage::getSingleton('adminhtml/session')->setFormData($data);
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('testimonials')->__('Registry not found'));
        $this->_redirect('*/*/');
    }

    public function deleteAction() {
        if ($this->getRequest()->getParam('id') > 0) {
            try {
                $model = Mage::getModel('testimonials/testimonials')->load($this->getRequest()->getParam('id'));
                $model->delete();
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('Testimonial removed'));
                $this->_redirect('*/*/');
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
            }
        }
        $this->_redirect('*/*/');
    }

    public function massDeleteAction() {
        $ids = $this->getRequest()->getParam('testimonials');
        if (!is_array($ids)) {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('Please, select an item'));
        } else {
            try {
                $removed = array();
                foreach ($ids as $id) {
                    $model = Mage::getModel('testimonials/testimonials')->load($id);
                    if($model->getId()){
                        $removed[] = $model->getId();
                        $model->delete();
                    }

                }

                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('%d item(s) removed', count($removed)));
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/index');
    }


    /**
     * Export customer grid to CSV format
     */
    public function exportCsvAction(){
        $fileName   = 'customers.csv';
        $content    = $this->getLayout()->createBlock('testimonials/adminhtml_testimonials_grid')
            ->getCsvFile();

        $this->_prepareDownloadResponse($fileName, $content);
    }

    /**
     * Export customer grid to XML format
     */
    public function exportXmlAction()
    {
        $fileName   = 'customers.xml';
        $content    = $this->getLayout()->createBlock('testimonials/adminhtml_testimonials_grid')
            ->getExcelFile();

        $this->_prepareDownloadResponse($fileName, $content);
    }


}
