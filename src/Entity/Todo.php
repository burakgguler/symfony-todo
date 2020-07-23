<?php

namespace App\Entity;

use App\Repository\TodoRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TodoRepository::class)
 */
class Todo
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text", length = 50)
     */
    private $title;

    /**
     * @ORM\Column(type="text", nullable = true)
     */
    private $description;

    /**
     * @ORM\Column(type="datetime", nullable = true)
     */
    private $duedate;

    /**
     * @ORM\Column(type="boolean")
     */
    private $completed = false;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle() {
        return $this->title;
    }

    public function setTitle($title) {
        $this->title = $title;
    }

    public function getDescription() {
        return $this->description;
    }

    public function setDescription($description) {
        $this->description = $description;
    }

    public function getDueDate() {
        return $this->duedate;
    }

    public function setDueDate($duedate) {
        $this->duedate = $duedate;
    }

    public function getCompleted() {
        return $this->completed;
    }

    public function setCompleted($completed) {
        $this->completed = $completed;
    }

    


}
