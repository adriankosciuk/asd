<?php

namespace Air\AdminBundle\Twig\Extension;


class AdminExtension extends \Twig_Extension {
    
    
    public function getName() {
        return 'air_admin_extension';
    }
        
    public function getFilters() {
        return array(
            'admin_format_date' => new \Twig_Filter_Method($this, 'adminFormatDate')
        );
    }
    
    public function adminFormatDate(\DateTime $datetime) {
        return $datetime->format('d.m.Y, H:i:s');
    }

}
