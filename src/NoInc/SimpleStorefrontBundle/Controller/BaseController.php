<?php

namespace NoInc\SimpleStorefrontBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use NoInc\SimpleStorefrontBundle\Objects\HeaderHelper;
use NoInc\SimpleStorefrontBundle\Objects\CartHelper;
use Symfony\Component\HttpFoundation\Request;

class BaseController extends Controller
{
    protected function loggedIn()
    {
        if ($this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            return true;
        }
        return false;
    }

    protected function isAdmin()
    {
        if ($this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
            return true;
        }
        return false;
    }

    protected function getHeaderHelper()
    {
        return new HeaderHelper($this->loggedIn(), $this->isAdmin());
    }

    protected function getCartHelper(Request $request)
    {
        $orm = $this->getDoctrine();
        $repo = $orm->getRepository('NoIncSimpleStorefrontBundle:Cart');
        return new CartHelper($request->cookies, $repo);
    }

    protected function getCart(Request $request)
    {
        $helper = $this->getCartHelper($request);
        return $helper->getOrCreateCart();
    }
}

