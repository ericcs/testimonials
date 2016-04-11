<?php

class Linkedin_Testimonials_Helper_Data extends Mage_Core_Helper_Abstract
{
    /**
     * Get the Store Config of Testimonials Module
     * @param string $key Key of the config
     * @param string $group Group of the config (tab in admin)
     * @return string|null
     */
    public function getConfig($key, $group = 'settings'){
        return Mage::getStoreConfig('testimonials/'.$group.'/'.$key);
    }

    /**
     * Check if Module is active
     * @return bool
     */
    public function isActive(){
        return $this->getConfig('active');
    }


    public function getStatus(){
        return array(
            1 => 'Enabled',
            0 => 'Disabled',
        );
    }

    public function getListTestimonialsUrl(){
        return $this->_getUrl('testimonials/testimonials/list');
    }

    public function getPostTestimonialsUrl(){
        return $this->_getUrl('testimonials/testimonials/create');
    }

    public function getSaveTestimonialsUrl(){
        return $this->_getUrl('testimonials/testimonials/save');
    }

}
