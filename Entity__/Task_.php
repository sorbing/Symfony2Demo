<?php

namespace App\CommonBundle\Entity;

# for Annotation Constraints (Validators)
use Symfony\Component\Validator\Constraints as Assert;
# for a Collection of Forms
use Doctrine\Common\Collections\ArrayCollection;

class Task
{

  /**
   * @Assert\MinLength(3)
   * @Assert\MaxLength(20)
   * #@Size(min=4, max=5)# require `use \???`
   */
  protected $task;
  
  /**
   * @Assert\NotBlank()
   * @Assert\Type("\DateTime")
   */
  protected $dueDate;

  protected $description;
  
  protected $tags;
  
  public function __construct()
  {
    $this->tags = new ArrayCollection();
  }
  
  public function getTask()
  {
    return $this->task;
  }
  
  public function setTask($task)
  {
    $this->task = $task;
  }

  public function getDueDate()
  {
    return $this->dueDate;
  }
  
  public function setDueDate(\DateTime $dueDate = null)
  {
    $this->dueDate = $dueDate;
  }
  
  public function getDescription()
  {
    return $this->description;
  }
  
  public function setDescription($description)
  {
    $this->description = $description;
  }
  
  public function getTags()
  {
    return $this->tags;
  }

  public function setTags(ArrayCollection $tags)
  {
    $this->tags = $tags;
  }
  
}