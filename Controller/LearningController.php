<?php

namespace App\CommonBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
// import annotations classes
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
//use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
// use HttpFoundation classes
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
// use Entity & Form classes
#use App\CommonBundle\Entity\Task;
use App\CommonBundle\Model\Task;
use App\CommonBundle\Model\Tag;
use App\CommonBundle\Form\Type\TaskType;

use App\CommonBundle\Model\TaskQuery;
use App\CommonBundle\Model\TagQuery;
//use App\CommonBundle\Model\TaskTag;

class LearningController extends Controller
{
  protected $form_new = 'create';

  /**
   * @Route("/", name="_app_common_learning_index")
   * @Template()
   */
  public function indexAction()
  {
    $router = $this->container->get('router');
    $router->generate($route, $parameters, $absolute);
    $routeCollection = $this->container->get('router')->getRouteCollection();
    //return new Response($routeCollection->get('')); // print_r($routes)
    $routes = $routeCollection->all();
    //return new Response("<pre>" . print_r(($routes), 1) . "</pre>"); // print_r($routes)
    //return new Response(get_class($this->container->get('router')->getRouteCollection())); // print_r($routes)
    return $this->render('AppCommonBundle:Learning:index.html.twig', array(
      'routes' => $routes
    ));
  }

  /**
   * Редактировать запись
   * @param type $id
   *
   * @Route("/edit/{id}", name="_app_common_learning_edit", requirements={"id" = "\d+"}, defaults={"id" = "1"})
   * @Template()
   */
  public function editAction($id)
  {
    $q = new TaskQuery();
    $task = $q->findPK($id);
    if ( ! $task)
    {
      throw $this->createNotFoundException('Entity "' . $id . '" not found.');
    }

    $form = $this->createForm(new TaskType(), $task);

    return $this->render('AppCommonBundle:Learning:form.html.twig', array(
      'debug' => '',
      'form'  => $form->createView()
    ));
  }


  /**
   * @Route("/form/{id}", name="_app_common_learning_form", requirements={"id" = "\d+"}, defaults={"id" = "1"})
   * --@Method({"GET", "POST"})
   * @Template()
   * 
   * @link http://symfony-gu.ru/documentation/ru/html/book/forms.html#book-forms-type-reference Встроенные типы полей
   * @link http://symfony.com/doc/current/book/validation.html#basic-constraints Supported Constraints
   * @link http://symfony.com/doc/current/cookbook/form/form_collections.html Collection of Forms
   */
  public function formAction(Request $request, $id)
  {
    $debug = '';
    $task = new Task();

    if ($request->getMethod() == 'GET')
    {
      $task->setName('Новая задача');
      $task->setDueDate(new \DateTime('tomorrow'));
      
      $tag_list = array('PHP 5.3', 'Symfony 2.1', 'Propel 1.6');
      foreach ($tag_list as $tag_name)
      {
        $tag = new Tag();
        $tag->setName($tag_name);
        $task->addTag($tag);
      }
    }
    
    /*$form = $this->createFormBuilder($task)
            ->add('task', 'text')
            ->add('description', 'textarea', array('required' => false))
            ->add('dueDate') // , 'date' Если не указывать тип поля явно - симфони попытается его угадать по правилам валидации
            ->getForm();*/
    $form = $this->createForm(new TaskType(), $task); // , array('id' => $id ) можно передать параметры (кому?)
    // $task = $form->getData(); // Можно получить объект Task из формы
    
    if ('POST' == $request->getMethod())
    {
      $form->bindRequest($request);
      if ($form->isValid())
      {
        // Save Task
        //$task = $form->getData();
        $task->save();
//        $tags = $form->get('name'); //
//        $tags = $form->get
//        $debug = $tags[0]->get('name');
        
        $this->get('session')->getFlashBag()->set('success', 'Запись успешно передана.'); // ->set(), ->add()
        // $this->get('session')->getFlash('info', '??? value');
        //return $this->redirect($this->generateUrl('_app_common_learning_success'));
      }
    }
    
    return $this->render('AppCommonBundle:Learning:form.html.twig', array(
        'debug' => $debug,
        'form'  => $form->createView()
    ));
  }
  
  public function propelAction()
  {
    //$task->toJSON(false);

    // $task = TaskQuery::create()->findPk($id);
    // $task->delete();
    // $users = $group->getUsers();
    // $nbUsers = $group->countUsers();
  }
  
  
  /**
   * @Route("/success", name="_app_common_learning_success")
   */
  public function successAction()
  {
    return $this->render('AppCommonBundle:Learning:empty.html.twig', array(
      
    ));
  }
  
  /**
   * @Route("/simpleform/{id}", name="_app_common_learning_simple_form")
   */
  public function simpleformAction($id)
  {
    $task = new Task(); // getById($id)
    
    if ($this->getRequest()->getMethod() == 'GET')
    {
      $task->setTask('Simple Task');
      $task->setDescription('Enter a long description task...');
      $task->setDueDate(new \DateTime('today'));
    }

    // $form = $this->createForm('TaskType', $task);  //@todo How to set a form type parameter as string?
    $form = $this->createForm(new TaskType(), $task);
    
    $content = $this->renderView('AppCommonBundle:Learning:form.html.twig', array(
      'id'    => $id,
      'form'  => $form->createView()
    ));
    return new Response($content);
    
    // return new Response('<h1>Success!</h1>');
  }

  /**
   * @Route("/twig", name="_app_common_learning_twig")
   * @Template()
   */
  public function twigAction()
  {
    return $this->render('AppCommonBundle:Learning:twig.html.twig', array(
      'html'    => '<b>Bold text</b>',
      'img_url' => 'http://i.imgur.com/zzGy1.png'
    ));
  }

  /**
   * @Route("/assetic", name="_app_common_learning_assetic")
   * @Template()
   */
  public function asseticAction()
  {
    return $this->render('AppCommonBundle:Learning:assetic.html.twig', array('param' => 'Assetic'));
  }

  public function routeAction($param)
  {
    $path = $this->get('kernel')->getRootDir() . '/../web';

    $container->get('request')->server->get('DOCUMENT_ROOT');
    // in controller:
    $this->getRequest()->server->get('DOCUMENT_ROOT');

    $container()->get('request')->getBasePath();
    // in controller:
    $this->getRequest()->getBasePath();
    
  }

}