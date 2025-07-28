<?php

namespace App\Controller;

use App\Entity\Task;
use App\Repository\TaskRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api/tasks', name: 'api_tasks')]
class TaskController extends AbstractController
{
    #[Route('', methods: ['GET'])]
    public function list(TaskRepository $repository): \Symfony\Component\HttpFoundation\JsonResponse
    {
        $tasks = $repository->findAll();
        $data = array_map(fn(Task $task) => [
            'id' => $task->getId(),
            'title' => $task->getTitle(),
            'completed' => $task->isCompleted(),
        ], $tasks);

        return $this->json($data);
    }

    #[Route('', methods: ['POST'])]
    public function create(Request $request, EntityManagerInterface $em): \Symfony\Component\HttpFoundation\JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        if (!isset($data['title'])) {
            return $this->json(['error' => 'Missing title'], Response::HTTP_BAD_REQUEST);
        }

        $task = new Task();
        $task->setTitle($data['title']);
        $task->setStatus($data['completed'] ?? false);

        $em->persist($task);
        $em->flush();

        return $this->json(['message' => 'Task created', 'id' => $task->getId()], Response::HTTP_CREATED);
    }
