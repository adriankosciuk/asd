<?php

namespace Air\AdminBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class DashboardController extends Controller
{
    /**
     * @Route(
     *      "/", 
     *      name="admin_dashboard"
     * )
     * 
     * @Template()
     */
    public function indexAction()
    {
        return array();
    }
}
