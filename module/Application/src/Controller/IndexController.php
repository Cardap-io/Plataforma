<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractActionController
{
    public function indexAction()
    {
        die('1');
        // require_once  __DIR__ .'/../../../../vendor/autoload.php';
        
        // $loader = new \Twig\Loader\FilesystemLoader(__DIR__ .'/../../view/layout');
        // $twig = new \Twig\Environment($loader, []);
        // $layout = $twig->load('layout.phtml');
        // echo $layout->render();
      
        // return new ViewModel();
    }
}
