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


