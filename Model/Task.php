<?php

namespace App\CommonBundle\Model;

use App\CommonBundle\Model\om\BaseTask;

# for Annotation Constraints (Validators)
use Symfony\Component\Validator\Constraints as Assert;
# for a Collection of Forms
# use Doctrine\Common\Collections\ArrayCollection;

class Task extends BaseTask
{
  /**
   * @var \PropelObjectCollection
   */
  protected $tags;

  
  /**
   * Gets tags objects
   *
   * @method getHandlersDir()
   * @param  none
   * @return \PropelObjectCollection
   */
  

  /*public function getCollTags()
  {
    return $this->collTags;
  }

  public function setCollTags($tags)
  {
    $this->collTags = $tags;
  }*/
  
/*   
  public function getTags()
  {
    return $this->tags;
  }

  public function setTags($tags)
  {
    $this->tags = $tags;
  }
  */
}
