<?php

namespace NoInc\SimpleStorefrontBundle\Controller;

use NoInc\SimpleStorefrontBundle\Entity\Order;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\UserBundle\Controller\SecurityController;
use Symfony\Component\HttpFoundation\Request;
use NoInc\SimpleStorefrontBundle\Objects\AWSImageUploader;

// In the controller I can include classes to perform adhoc tests, helpful for
// testing integrations with APIs (like AWS) or for making sure your custom classes
// do what they're supposed to do in an adhoc manner.
class TestController extends BaseController
{
    /**
     * @Route("/test", name="test")
     * @Method("GET")
     */
    public function test()
    {
        $orm = $this->getDoctrine();
        $repo = $orm->getRepository('NoIncSimpleStorefrontBundle:Cart');
        $cart = $repo->findBy(['id' => 1])[0];
        $order = new Order();
        $order->setEmail('johnspar1@gmail.com');
        $order->setAmount(10);
        $order->setCreatedAt(time());
        $order->setCart($cart);
        $this->getDoctrine()->getEntityManager()->persist($order);
        $this->getDoctrine()->getEntityManager()->flush($order);
    }

}


