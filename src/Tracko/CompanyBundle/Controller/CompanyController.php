<?php

namespace Tracko\CompanyBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Tracko\BaseBundle\Controller\BaseController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Tracko\CompanyBundle\Entity\Company;
use Tracko\CompanyBundle\Form\CompanyType;

/**
 * Company controller.
 *
 * @Route("/company")
 */
class CompanyController extends BaseController
{
    
    /**
     * Lists all Company entities.
     *
     * @Route("/", name="company")
     * @Method("GET")
     * @Template()
     *
     * @return array
     */
    public function indexAction()
    {
    $companys = $this->getRepo('TrackoCompanyBundle:Company')->findAll();

        return array(
            'companys' => $companys,
        );
    }

    /**
     * Finds and displays a Company entity.
     *
     * @param Company $company
     * @Route("/{id}", name="company_show", requirements={"id" = "\d+"})
     * @Method("GET")
     * @ParamConverter("company")
     * @Template()
     *
     * @return array
     */
    public function showAction(Company $company)
    {
        $deleteForm = $this->createDeleteForm($company->getId());

        return array(
            'company'      => $company,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Creates a new Company entity.
     *
     * @param Request $request
     *
     * @Route("/new", name="company_create")
     * @Template()
     *
     * @return array
     */
    public function newAction(Request $request)
    {
        $company = new Company();
        $form = $this->createForm(new CompanyType(), $company, array(
            'action' => $this->generateUrl('company_create'),
        ));
        $form->add('submit', 'submit', array('label' => 'Create'));

        if($request->isMethod('POST')){
            $form->handleRequest($request);

            if ($form->isValid()) {
                $em = $this->getEntityManager();
                $em->persist($company);
                $em->flush();

                return $this->redirect($this->generateUrl('company_show', array('id' => $company->getId())));            }
        }

        return array(
            'company' => $company,
            'form'   => $form->createView(),
        );
    }


    /**
     * Displays a form to edit an existing Company entity.
     *
     * @param Request $request
     * @param Company $company
     * @Route("/{id}/edit", name="company_edit", requirements={"id" = "\d+"})
     * @ParamConverter("company")
     * @Template()
     *
     * @return array
     */
    public function editAction(Request $request, Company $company)
    {

        $editForm = $this->createForm(new CompanyType(), $company, array(
            'action' => $this->generateUrl('company_edit', array('id' => $company->getId())),
        ));
        $editForm->add('submit', 'submit', array('label' => 'form.update'));

        $deleteForm = $this->createDeleteForm($company->getId());

        if($request->isMethod('POST')){
            $editForm->handleRequest($request);

            if ($editForm->isValid()) {
                $em=$this->getEntityManager();
                $em->persist($company);
                $em->flush();
            }
        }

        return array(
            'company'      => $company,
            'form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Company entity.
     *
     * @param Request $request
     * @param Company $company
     * @Route("/{id}/remove", name="company_delete", requirements={"id" = "\d+"})
     * @ParamConverter("company")
     *
     * @return array
     */
    public function deleteAction(Request $request, Company $company)
    {
        $form = $this->createDeleteForm($company->getId());
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getEntityManager();

            $em->remove($company);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('company'));
    }

    /**
     * Creates a form to delete a Company entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('company_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
