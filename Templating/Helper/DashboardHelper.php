<?php

namespace App\CommonBundle\Templating\Helper;

use Symfony\Component\Templating\Helper\Helper;

class DashboardHelper extends Helper
{
  /**
   * @method renderLastItems
   * @param integer $num
   * @return template
   */
  public function renderLastItems($num = 2)
  {
    return '<ul><li>Templating Helper #1</li><li>Templating Helper #2</li></ul>';

    $items = $this->container->get('stepcart.item.manager')->last($num);
    return $this->container->get('templating')->render('StepCartAdminBundle:Helper:last_items.html.twig', array(
      'items' => $items,
      'num' => $num,
      ));
  }

  public function getName()
  {
    return 'dashboard';
  }
}
