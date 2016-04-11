<?php
class Linkedin_Testimonials_Model_Testimonials extends Mage_Core_Model_Abstract
{

    /**
     * Initialize resource model
     */
    protected function _construct()
    {
        $this->_init('testimonials/testimonials');
    }

    /**
     * @return int
     */
    public function getCustomerId()
    {
        return $this->getData('customer_id');
    }

    /**
     * @return string
     */
    public function getMessage()
    {
        return $this->getData('message');
    }

    /**
     * @return bool
     */
    public function getApproved()
    {
        return $this->getData('approved');
    }

}
