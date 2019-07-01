<?php

namespace App\Entity;

use Symfony\Component\Validator\Context\ExecutionContextInterface;

/**
 * Class Task
 * @package App\Entity
 */
class Task
{
    /**
     * @var string
     */
    private $id;

    /**
     * @var string
     *
     */
    private $name;

    /**
     * @var string
     */
    private $authorName;

    /**
     * @var Category
     */
    private $category;

    public function __toString()
    {
        return $this->getName();
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
     * @return Task
     */
    public function setName(string $name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getAuthorName()
    {
        return $this->authorName;
    }

    /**
     * @param string $authorName
     * @return Task
     */
    public function setAuthorName(string $authorName)
    {
        $this->authorName = $authorName;
        return $this;
    }

    /**
     * @return Category
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @param Category $category
     * @return Task
     */
    public function setCategory(Category $category)
    {
        $this->category = $category;
        $category->addTask($this);
        return $this;
    }

    /**
     * @param ExecutionContextInterface $context
     */
    public function validate(ExecutionContextInterface $context)
    {
        if ($this->getCategory()->getTasks()->count() > $this->getCategory()->getMaxTasks()) {
            $context->buildViolation('Nombre d\'éléments maximum atteint ('
                . $this->getCategory()->getMaxTasks() . ')')
                ->addViolation();
        }
    }
}
