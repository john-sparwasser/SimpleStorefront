<?php

namespace NoInc\SimpleStorefrontBundle\Controller;

use NoInc\SimpleStorefrontBundle\Entity\Recipe;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use NoInc\SimpleStorefrontBundle\Entity\Ingredient;
use NoInc\SimpleStorefrontBundle\Entity\Product;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Security("has_role('ROLE_ADMIN')")
 * @Route("/admin")
 */
class AdminIngredientController extends BaseController
{
    /**
     * @Route("/update_ingredients", name="update_ingredients")
     * @Method("POST")
     */
    public function updateIngredients(Request $request)
    {
        return $this->redirectToRoute('admin_home');
    }

    /**
     * @Route("/buy/{ingredient_id}", name="buy_ingredient")
     * @Method("POST")
     * @ParamConverter("ingredient", class="NoIncSimpleStorefrontBundle:Ingredient", options={"mapping": {"ingredient_id": "id"}})
     */
    public function postBuyIngredientAction(Ingredient $ingredient)
    {
        return $this->redirectToRoute('admin_home');
    }
}

