<?php
 
/*
 * A RedirectResponse object with cookie sending
 * Stole from http://blog.alterphp.com/2011/08/redirection-with-cookie-sending-in.html
 */
 
namespace NoInc\SimpleStorefrontBundle\Objects;
 
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\RedirectResponse;
use NoInc\SimpleStorefrontBundle\Entity\Cart;
 
/**
 * RedirectResponseWithCookie represents an HTTP response doing a redirect and sending cookies.
 */
class RedirectResponseWithCartCookie extends RedirectResponse
{
    /**
    * Creates a redirect response so that it conforms to the rules defined for a redirect status code.
    *
    * @param string  $url    The URL to redirect to
    * @param integer $status The status code (302 by default)
    * @param Symfony\Component\HttpFoundation\Cookie[] $cookies An array of Cookie objects
    */
    public function __construct($url, Cart $cart)
    {
        parent::__construct($url, 302);
        $cookie = new Cookie('SIMPLE_CART_TOKEN', $cart->getToken(), time() + 3600 * 24 * 7);
        $this->headers->setCookie($cookie);
    }
}
