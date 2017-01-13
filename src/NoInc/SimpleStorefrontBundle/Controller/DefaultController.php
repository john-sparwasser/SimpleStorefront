<?php

namespace NoInc\SimpleStorefrontBundle\Controller;

use NoInc\SimpleStorefrontBundle\Entity\Recipe;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends BaseController
{
    /**
     * @Route("/", name="guest_home")
     * @Method("GET")
     */
    public function getAction(Request $request)
    {
        $recipes = $this->getDoctrine()->getRepository('NoIncSimpleStorefrontBundle:Recipe')->getRecipesAndIngredients();

        $renderData = [];
        $renderData['title'] = 'A Simple Storefront';
        $renderData['recipes'] = $recipes;
        $renderData['header'] = $this->getHeaderHelper();
        $renderData['cart_helper'] = $this->getCartHelper($request);

        return $this->render('NoIncSimpleStorefrontBundle:Default:index.html.twig', $renderData);
    }

}
