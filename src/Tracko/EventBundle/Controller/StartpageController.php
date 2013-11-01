<?php

namespace Tracko\EventBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Tracko\BaseBundle\Controller\BaseController;

class StartpageController extends BaseController
{
    /**
     * @Route("/", name="_index")
     * @Template()
     */
    public function startpageAction(Request $request)
    {
        if($request->isMethod('POST')){
            return $this->redirect($this->generateUrl('event'));
        }

        return array();
    }
}
