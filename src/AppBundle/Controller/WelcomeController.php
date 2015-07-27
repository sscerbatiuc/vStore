<?php
/* 
 * The Author: Stanislav Scerbatiuc.
 */

//src/AppBundle/Controller/WelcomeController

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use \Symfony\Bundle\FrameworkBundle\Controller\Controller;

class WelcomeController extends Controller{
    
    
    /**
     * @Route("/",name="welcome")
     */
    public function indexAction(){
//        $this->addFlash('notice', 'You\'ve been redirected');
        return $this->redirectToRoute('homepage');
//        throw new \Exception("Something went wrong", 500);
    }
    
}