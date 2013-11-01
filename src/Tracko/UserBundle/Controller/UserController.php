<?php

namespace Tracko\UserBundle\Controller;


use Tracko\BaseBundle\Controller\BaseController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Tracko\UserBundle\Entity\User;
use Symfony\Component\HttpFoundation\Request;

/**
 * User controller.
 *
 * @Route("/user")
 */
class UserController extends BaseController
{
    
    /**
     * Lists all User entities.
     *
     * @Route("/", name="user")
     * @Method("GET")
     * @Template()
     *
     * @return array
     */
    public function indexAction()
    {
    $users = $this->getRepo('TrackoUserBundle:User')->findAll();

        return array(
            'users' => $users,
        );
    }

    /**
     * Finds and displays a User entity.
     *
     * @param User $user
     * @Route("/{id}", name="user_show", requirements={"id" = "\d+"})
     * @Method("GET")
     * @ParamConverter("user")
     * @Template()
     *
     * @return array
     */
    public function showAction(User $user)
    {

        return array(
            'user'      => $user,
        );
    }

    /**
     * Login of User entity.
     *
     * @Route("/login", name="login")
     * @Template()
     *
     * @return 
     */
    public function loginAction(Request $request)
    {

	if($request->isMethod('POST')){

        $hull = new \Hull_Client(array( 'hull' => array(
            'host' => 'https://3d5c0a42.hullapp.io',
            'appId' => '526f90af33a1593cde000041',
            'appSecret' => '8bc93efe471a92eaa3fef3468e250245'
        )));

        //$hull->get();//??
        $loginService=$this->get('tracko.user_security');
	 }
   }
}
