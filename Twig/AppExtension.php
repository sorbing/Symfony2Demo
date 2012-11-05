<?php

namespace App\CommonBundle\Twig;

use Symfony\Component\DependencyInjection\ContainerInterface;

class AppExtension extends \Twig_Extension
{
  private $container;

  private $root_path;

  /**
   * Constructor.
   *
   * @param ContainerInterface $container
   */
  public function __construct(ContainerInterface $container)
  {
      $this->container = $container;
  }

  /**
   * Этот метод будет вызван при инициализации класса.
   * Это поведение задается в файле регистрации сервиса.
   *
   * @param string $root_path
   */
  public function setRootPath($root_path)
  {
    $this->root_path = $root_path;
  }

  /**
   * Указать используемые фильтры - {{ variable|filter(arg1, argN, ...) }}
   *
   * @return array
   */
  public function getFilters()
  {
    return array(
      'wrapimg'    => new \Twig_Filter_Method($this, 'wrapimgFilter', array('is_safe' => array('html')))
      //'wrapimg'  => new \Twig_Filter_Function('custom_function_name')
    );
  }

  /**
   * Указать используемые ф-ции - {{ function(variable) }}
   * 
   * @return array
   */
  public function getFunctions()
  {
    return array(
      'camelzebra' => new \Twig_Function_Method($this, 'camelzebra')
    );
  }

  public function wrapimgFilter($img_url, $attrs = array())
  {
    // Доступ к сервисам
    // $this->container->get('dashboard.helper')->renderLastItems($num);
    
    $attrs_str = '';
    if (key_exists('class', $attrs)) {
      $attrs_str .= "class='{$attrs['class']}' ";
    }
    $html = "<img src='$img_url' $attrs_str/>";
    return $html;
  }

  public function camelzebra($text)
  {
    return 'CaMeLzEbRa';
  }

  public function createLink($url)
  {
    return 'LINK';
  }

  public function getName()
  {
    return 'app_extension';
  }

}

function camelzebra($text)
{
  return 'CaMeLzEbRa';
}