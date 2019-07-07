<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

/**
 * Class Category
 * @package App\Entity
 */
class Category
{
    /**
     * @var string
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var int|null
     */
    private $maxTasks;

    /**
     * @var Event
     */
    private $event;

    /**
     * @var Collection|Task[]
     */
    private $tasks;

    /**
     * @var bool
     */
    private $public;

    public function __construct()
    {
        $this->tasks = new ArrayCollection();
        $this->public = true;
    }

    public function __toString()
    {
        return $this->name;
    }

    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Category
     */
    public function setName(string $name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return Event
     */
    public function getEvent()
    {
        return $this->event;
    }

    /**
     * @param Event $event
     * @return Category
     */
    public function setEvent(Event $event)
    {
        $this->event = $event;
        $event->addCategory($this);
        return $this;
    }

    /**
     * @return int|null
     */
    public function getMaxTasks()
    {
        return $this->maxTasks;
    }

    /**
     * @param int|null $maxTasks
     * @return Category
     */
    public function setMaxTasks(?int $maxTasks)
    {
        $this->maxTasks = $maxTasks;
        return $this;
    }

    /**
     * @return Task[]|Collection
     */
    public function getTasks()
    {
        return $this->tasks;
    }

    /**
     * @param Task $task
     * @return $this
     */
    public function addTask(Task $task)
    {
        if($this->tasks->contains($task)) {
            return $this;
        }
        $this->tasks->add($task);
        $task->setCategory($this);
        return $this;
    }

    /**
     * @param Task $task
     * @return $this
     */
    public function removeTask(Task $task)
    {
        if(!$this->tasks->contains($task)) {
            return $this;
        }
        $this->tasks->removeElement($task);
        return $this;
    }

    /**
     * @return bool
     */
    public function isPublic(): bool
    {
        return $this->public;
    }

    /**
     * @param bool $public
     * @return Category
     */
    public function setPublic(bool $public)
    {
        $this->public = $public;
        return $this;
    }
}
