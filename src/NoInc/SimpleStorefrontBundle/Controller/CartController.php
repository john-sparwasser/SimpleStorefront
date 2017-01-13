<?php

namespace NoInc\SimpleStorefrontBundle\Controller;

use NoInc\SimpleStorefrontBundle\Entity\Recipe;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use NoInc\SimpleStorefrontBundle\Entity\Product;
use NoInc\SimpleStorefrontBundle\Entity\CartItem;
use NoInc\SimpleStorefrontBundle\Objects\RedirectResponseWithCartCookie;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;

class CartController extends BaseController
{
    /**
     * @Route("/add_to_cart/{recipe_id}", name="add_to_cart")
     * @Method("POST")
     * @ParamConverter("recipe", class="NoIncSimpleStorefrontBundle:Recipe", options={"mapping": {"recipe_id": "id"}})
     */
    public function PostAddToCart(Recipe $recipe, Request $request)
    {
        if ( $recipe->getProducts()->count() === 0 ) {
            return $this->redirectToRoute('guest_home');
        }
        $cartHelper = $this->getCartHelper($request);
        $cart = $cartHelper->getOrCreateCart();
        $manager = $this->getDoctrine()->getEntityManager();
        $products = $recipe->getProducts();
        foreach($products as $product) {
            if ($product->getCartItem() === null) {
                $cartItem = new CartItem();
                $cartItem->setProduct($product);
                $cartItem->setCart($cart);
                $manager->persist($cartItem);
                break;
            }
        }
        $cart->setTotal($cart->getTotal() + $recipe->getPrice());
        $manager->persist($cart);
        $manager->flush();
        if ($cartHelper->newCart()) {
            return new RedirectResponseWithCartCookie($this->generateUrl('guest_home'), $cart);
        }
        return $this->redirectToRoute('guest_home');
    }
}



