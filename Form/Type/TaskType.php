<?php

namespace App\CommonBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class TaskType extends AbstractType
{

  public function buildForm(FormBuilderInterface $builder, array $options)
  {
    //@why Если не указать явно тип "text" - ошибка: Expected argument of type "\PropelObjectCollection", "string" given 
    $builder->add('name', 'text');
    $builder->add('dueDate', 'date', array(
      // 'mapped' => false // метка "дополнительное поле" - поле не отображается в общей форме
    ));
    $builder->add('description', 'textarea', array('required' => false));
    $builder->add('tags', 'collection', array('type' => new TagType(), 
      'allow_add'    => true,
      'allow_delete' => true,
      'by_reference' => false,
    ));/**/
    //$builder->add('collTags', 'collection', array('type' => new TagType()));
    
    /*$builder->add('category', 'entity', array(
        'class' => 'DEMO\DemoBundle\Entity\Product\ProductCategory',
        'query_builder' => function(EntityRepository $er) {
            return $er->createQueryBuilder('u')
                ->where('u.section = :id')
                ->setParameter('id', ***ID VARIABLE NEEDS TO GO HERE***)
                ->orderBy('u.root', 'ASC')
                ->addOrderBy('u.lft', 'ASC');
        },
        'empty_value' => 'Choose an option',
        'property' => 'indentedName',
    )); # Example # */
  }
  
  /**
   * Set a class that holds the underlying form data (класс с данными формы)
   * @param \Symfony\Component\OptionsResolver\OptionsResolverInterface $resolver
   */
  public function setDefaultOptions(OptionsResolverInterface $resolver)
  {
    $resolver->setDefaults(array(
      //'data_class' => 'App\CommonBundle\Entity\Task',
      'data_class' => 'App\CommonBundle\Model\Task',
    ));
  }

  public function getName()
  {
    return 'task'; // Вернуть уникальный идентификатор формы
  }
}