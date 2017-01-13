<?php

namespace NoInc\SimpleStorefrontBundle\Controller;

use NoInc\SimpleStorefrontBundle\Entity\Recipe;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use NoInc\SimpleStorefrontBundle\Entity\Ingredient;
use NoInc\SimpleStorefrontBundle\Entity\Product;
use NoInc\SimpleStorefrontBundle\Entity\Order;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;
use NoInc\SimpleStorefrontBundle\Objects\RedirectResponseWithDeletingCartCookie;

class CheckoutController extends BaseController
{
    /**
     * @Route("/checkout", name="checkout")
     * @Method("GET")
     */
    public function displayCheckoutView(Request $request)
    {
        $renderData = [
            'header' => $this->getHeaderHelper(),
            'cart_helper' => $this->getCartHelper($request),
        ];
        return $this->render('NoIncSimpleStorefrontBundle:Default:checkout.html.twig', $renderData);
    }

    /**
     * @Route("/thank_you", name="thank_you")
     * @Method("GET")
     */
    public function displayThankYouView(Request $request)
    {
        $renderData = [
            'header' => $this->getHeaderHelper(),
            'cart_helper' => false,
        ];
        return $this->render('NoIncSimpleStorefrontBundle:Default:thank_you.html.twig', $renderData);
    }

    /**
     * @Route("/declined", name="declined")
     * @Method("GET")
     */
    public function displayDeclinedView(Request $request)
    {
        $renderData = [
            'header' => $this->getHeaderHelper(),
            'cart_helper' => false,
        ];
        return $this->render('NoIncSimpleStorefrontBundle:Default:declined.html.twig', $renderData);
    }

    /**
     * @Route("/checkout_error", name="checkout_error")
     * @Method("GET")
     */
    public function displayErrorView(Request $request)
    {
        $renderData = [
            'header' => $this->getHeaderHelper(),
            'cart_helper' => false,
        ];
        return $this->render('NoIncSimpleStorefrontBundle:Default:checkout_error.html.twig', $renderData);
    }

    /**
     * @Route("/perform_checkout", name="perform_checkout")
     * @Method("POST")
     */
    public function performCheckout(Request $request)
    {
        $email = $request->get('email');
        $customer_token = $request->get('customer_token');

        if (!$email || !$customer_token) {
            return $this->redirectToRoute('checkout_error');
        }

        $cart = $this->getCart($request);
        $cartId = $cart->getId();
        $total = $cart->getTotal();
        if ($total == 0) {
            return $this->redirectToRoute('checkout_error');
        }

        $stripeTotal = $total * 100;

        \Stripe\Stripe::setApiKey($this->container->getParameter('stripe_secret'));

        // Try charging the card
        try {
            $charge = \Stripe\Charge::create(array(
              "amount" => $stripeTotal,
              "currency" => "usd",
              "description" => "Simple Store Front",
              "source" => $customer_token,
            ));
        } catch(\Stripe\Error\Card $e) {
$body = $e->getJsonBody();
            return $this->redirectToRoute('declined');
        } catch (\Stripe\Error\RateLimit $e) {
            return $this->redirectToRoute('checkout_error');
        } catch (\Stripe\Error\InvalidRequest $e) {
            return $this->redirectToRoute('checkout_error');
        } catch (\Stripe\Error\Authentication $e) {
            return $this->redirectToRoute('checkout_error');
        } catch (\Stripe\Error\ApiConnection $e) {
            return $this->redirectToRoute('checkout_error');
        } catch (\Stripe\Error\Base $e) {
            return $this->redirectToRoute('checkout_error');
        } catch (Exception $e) {
            return $this->redirectToRoute('checkout_error');
        }

        // Stripe was successful so create order and...
        $order = new Order();
        $order->setEmail($email);
        $order->setAmount($total);
        $order->setCreatedAt(time());
        $order->setCart($cart);
        $this->getDoctrine()->getEntityManager()->persist($order);

        // Remove the products from stock
        foreach($cart->getCartItems() as $cartItem) {
            $product = $cartItem->getProduct();
            $product->setAsSold();
            $this->getDoctrine()->getEntityManager()->persist($product);
        }
        $this->getDoctrine()->getEntityManager()->flush();

        return new RedirectResponseWithDeletingCartCookie($this->generateUrl('thank_you'));
    }
}


