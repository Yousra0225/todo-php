<?php

namespace App\Entity;

use App\Repository\TaskRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TaskRepository::class)]
class Task
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 255)]
    private string $title;

     #[ORM\Column(type: 'boolean')]
     private bool $completed = false;

    // Getters
     public function getId(): ?int{return $this->id;}
    public function getTitle() : string { return $this->title; }
    public function getStatus(): boolean { return $this->completed; }

    //  and Setters
    public function setTitle(string $title): void { $this->title = $title;}
    public function setStatus(bool $completed): void {$this->completed = $completed;}


}
