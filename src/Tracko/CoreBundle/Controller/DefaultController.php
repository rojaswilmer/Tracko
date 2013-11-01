<?php

namespace Tracko\CoreBundle\Controller;

use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\Security\Core\Exception\AuthenticationCredentialsNotFoundException;

// these import the "@Route" and "@Template" annotations
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Tracko\BaseBundle\Controller\BaseController;

/**
 *
 */
class DefaultController extends BaseController
{

    /**
     * This is the about page
     *
     * @Route("/about", name="_about")
     * @Template()
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function indexAction()
    {
        return array();
    }

}
