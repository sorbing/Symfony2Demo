<?php

namespace App\CommonBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
// Annotations
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
// Models
use App\CommonBundle\Model\Task;
use App\CommonBundle\Model\TaskQuery;
use App\CommonBundle\Form\Type\TaskType;
use App\CommonBundle\Model\Tag;
// Other
#use Symfony\Component\HttpFoundation\Session\Session;


/**
 * @Route("/task") set a prefix routes
 */
class TaskController extends Controller
{
  /**
   *
   * @Route("", name="_app_common_task_index")
   * @Template("AppCommonBundle:Task:index.html.twig")
   *
   * @link http://www.propelorm.org/reference/model-criteria.html#column_filter_methods   Column Filter Methods
   * @link http://www.propelorm.org/documentation/03-basic-crud.html#using_custom_sql     Using Custom SQL
   */
  public function indexAction()
  {
    $tasks = TaskQuery::create()
      #->filterByTag(TagQuery::create()->findPk(1))
      #->joinWith('Book.Publisher')
      ->orderByName()
      ->limit(20)
      ->find();                   // findOne(),

    return array(
      'items' => $tasks
    );
  }

  /**
   * Add Entity
   *
   * @Route("/add", name="_app_common_task_add")
   * @Template()
   */
  public function addAction()
  {
    $task = new Task();
    $task->setName('Новая задача');
    $task->setDueDate(new \DateTime('tomorrow'));
    $tag = new Tag();
    $tag->setName('Метка');
    //$task->addTag($tag);

    $form = $this->createForm(new TaskType(), $task);

    return $this->render('AppCommonBundle:Task:form.html.twig', array(
      'form' => $form->createView()
    ));
  }

  /**
   * Edit Entity
   * @param integer $id
   *
   * @Route("/edit/{id}", name="_app_common_task_edit", requirements={"id"="\d+"}, defaults={"id"=0})
   * @Template()
   */
  public function editAction($id)
  {
    $q = new TaskQuery();
    $task = $q->findPk($id);
    // OR // $task = TaskQuery::create()->findPk($id);
    // TaskQuery::create()->findOneByFirstName('Таск')
    if ( ! $task)
    {
      throw $this->createNotFoundException('Task ID=' . $id . ' Not Found.');
    }

    $form = $this->createForm(new TaskType(), $task);

    return $this->render('AppCommonBundle:Task:form.html.twig', array(
      'form'  => $form->createView()
    ));
  }

  /**
   *
   * @Route("/save", name="_app_common_task_save")
   * @Method("GET|POST")
   */
  public function saveAction(Request $request)
  {
    $task = new Task();
    $form = $this->createForm(new TaskType(), $task);
    // $task = $form->getData();
    $form->bindRequest($request);
    if ($form->isValid())
    {
      $task->save();
    }
    return $this->redirect($this->generateUrl('_app_common_task_edit', array('id' => $task->getId())));
  }

  /**
   * @Route("/clone/{id}", name="_app_common_task_clone")
   */
  public function cloneAction($id)
  {

  }

  /**
   * @Route("/delete/{id}", name="_app_common_task_delete", requirements={"id"="\d+"})
   */
  public function deleteAction($id)
  {
    $task = TaskQuery::create()->findOneById($id);
    $task->delete();

    /* @var $session \Symfony\Component\HttpFoundation\Session\Session */
    $session = $this->get('session'); // $this->getRequest()->getSession()
    $session->getFlashBag()->add('success', "Задача $id успешно удалена");
    
    return $this->redirect($this->generateUrl('_app_common_task_index'));
  }

}