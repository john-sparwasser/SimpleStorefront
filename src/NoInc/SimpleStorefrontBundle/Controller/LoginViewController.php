<?php

namespace NoInc\SimpleStorefrontBundle\Controller;

use NoInc\SimpleStorefrontBundle\Entity\Recipe;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\UserBundle\Controller\SecurityController;
use Symfony\Component\HttpFoundation\Request;
use NoInc\SimpleStorefrontBundle\Objects\HeaderHelper;

class LoginViewController extends SecurityController
{
     /**
     * @Route("login", name="login")
     * @Method("GET")
     */
    public function extendedLoginAction(Request $request)
    {
        return $this->loginAction($request);
    }

    public function renderLogin(array $data)
    {
        // We have to instantiated directly because we're not extending from BaseController
        $helper = new HeaderHelper();
        $helper->hideLoginLogout();
        $data['header'] = $helper;
        $data['cart_helper'] = false;
        return $this->render('NoIncSimpleStorefrontBundle:Default:login.html.twig', $data);
    }
}

