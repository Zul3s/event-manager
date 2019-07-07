<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Event;
use App\Entity\Task;
use App\Form\TaskType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class EventController extends AbstractController
{
    /**
     * @param Event $event
     * @param SessionInterface $session
     * @return Response
     */
    public function display(Event $event, SessionInterface $session): Response
    {
        $session->set('event_id', $event->getId());
        return $this->render('event/index.html.twig', array(
            'event' => $event,
        ));
    }

    /**
     * @param Category $category
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @return Response
     */
    public function addTask(Category $category, Request $request, EntityManagerInterface $entityManager): Response
    {
        $task = new Task();
        $task->setCategory($category);
        $form = $this->createForm(TaskType::class, $task, array(
            'action' => $this->generateUrl('event_add_task', array(
                'id' => $category->getEvent()->getId(),
                'category' => $category->getId()
            ))
        ));
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($task);
            $entityManager->flush();
            return new Response('OK');
        }
        return $this->render('event/_add-task.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @param Task $task
     * @param Request $request
     * @param EntityManagerInterface $entityManager
     * @return RedirectResponse|Response
     */
    public function editTask(Task $task, Request $request, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(TaskType::class, $task, array(
            'action' => $this->generateUrl('event_edit_task', array(
                'id' => $task->getCategory()->getEvent()->getId(),
                'category' => $task->getCategory()->getId(),
                'task' => $task->getId()
            )),
            'method' => 'PUT'
        ));
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            return new Response('OK');
        }
        return $this->render('event/_add-task.html.twig', array(
            'form' => $form->createView(),
        ));
    }
}
