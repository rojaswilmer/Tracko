<?php

namespace Tracko\EventBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Tracko\BaseBundle\Controller\BaseController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Tracko\EventBundle\Entity\Event;
use Tracko\EventBundle\Form\EventType;

/**
 * Event controller.
 *
 * @Route("/event")
 */
class EventController extends BaseController
{
    
    /**
     * Lists all Event entities.
     *
     * @Route("/", name="event")
     * @Method("GET")
     * @Template()
     *
     * @return array
     */
    public function indexAction()
    {
    $events = $this->getRepo('TrackoEventBundle:Event')->findAll();

        return array(
            'events' => $events,
            'page_title'=>"Events"
        );
    }



    /**
     * Finds and displays a Event entity.
     *
     * @param Event $event
     * @Route("/{id}", name="event_show", requirements={"id" = "\d+"})
     * @Method("GET")
     * @ParamConverter("event")
     * @Template()
     *
     * @return array
     */
    public function showAction(Event $event)
    {
        $deleteForm = $this->createDeleteForm($event->getId());

        return array(
            'event'      => $event,
            'delete_form' => $deleteForm->createView(),
        );
    }


    /**
     * Finds and displays a Event entity.
     *
     * @param Event $event
     * @Route("/{id}/secured/join", name="event_join", requirements={"id" = "\d+"})
     * @Method("GET")
     * @ParamConverter("event")
     * @Template()
     *
     * @return array
     */
    public function joinAction(Event $event)
    {
        $user=$this->getUser();
        $event->addMember($user);


        return array(
            'event'      => $event,
        );
    }

    /**
     * Creates a new Event entity.
     *
     * @param Request $request
     *
     * @Route("/new", name="event_create")
     * @Template()
     *
     * @return array
     */
    public function newAction(Request $request)
    {
        $event = new Event();
        $form = $this->createForm(new EventType(), $event, array(
            'action' => $this->generateUrl('event_create'),
        ));
        $form->add('submit', 'submit', array('label' => 'Create'));

        if($request->isMethod('POST')){
            $form->handleRequest($request);

            if ($form->isValid()) {
                $em = $this->getEntityManager();
                $em->persist($event);
                $em->flush();

                return $this->redirect($this->generateUrl('event_show', array('id' => $event->getId())));
            }
        }

        return array(
            'event' => $event,
            'form'   => $form->createView(),
        );
    }


    /**
     * Displays a form to edit an existing Event entity.
     *
     * @param Request $request
     * @param Event $event
     * @Route("/{id}/edit", name="event_edit", requirements={"id" = "\d+"})
     * @ParamConverter("event")
     * @Template()
     *
     * @return array
     */
    public function editAction(Request $request, Event $event)
    {

        $editForm = $this->createForm(new EventType(), $event, array(
            'action' => $this->generateUrl('event_edit', array('id' => $event->getId())),
        ));
        $editForm->add('submit', 'submit', array('label' => 'form.update'));

        $deleteForm = $this->createDeleteForm($event->getId());

        if($request->isMethod('POST')){
            $editForm->handleRequest($request);

            if ($editForm->isValid()) {
                $em=$this->getEntityManager();
                $em->persist($event);
                $em->flush();
            }
        }

        return array(
            'event'      => $event,
            'form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Event entity.
     *
     * @param Request $request
     * @param Event $event
     * @Route("/{id}/remove", name="event_delete", requirements={"id" = "\d+"})
     * @ParamConverter("event")
     *
     * @return array
     */
    public function deleteAction(Request $request, Event $event)
    {
        $form = $this->createDeleteForm($event->getId());
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getEntityManager();

            $em->remove($event);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('event'));
    }

    /**
     * Creates a form to delete a Event entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('event_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
