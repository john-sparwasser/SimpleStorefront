<?php

namespace NoInc\SimpleStorefrontBundle\Objects;

use NoInc\SimpleStorefrontBundle\Entity\Cart;
use NoInc\SimpleStorefrontBundle\Repository\CartRepository;
use Symfony\Component\HttpFoundation\Cookie;

class CartHelper
{
    private $_cartToken = '';
    private $_cart = null;
    private $_newCart = false;

    // I don't know if passing the repo in here is best practices?
    public function __construct($cookies, CartRepository $repo)
    {
        // If the cart cookie exists, lets get the cart by the token
        if ($cookies->has('SIMPLE_CART_TOKEN')) {
            $this->_cartToken = $cookies->get('SIMPLE_CART_TOKEN');
            $this->_cart = $repo->getCartByToken($this->_cartToken);
        }
    }

    public function getCartItemCount()
    {
        if ($this->hasCart()) {
            return $this->_cart->getItemCount();
        }
        return 0;
    }

    public function getCartTotal()
    {
        if ($this->hasCart()) {
            return $this->_cart->getTotal();
        }
        return 0;
    }

    public function hasOneItem()
    {
        if ($this->getCartItemCount() === 1) {
            return true;
        }
        return false;
    }

    public function hasCart()
    {
        return $this->_cart !== null;
    }

    public function getOrCreateCart()
    {
        if ($this->hasCart()) {
            return $this->_cart;
        }

        return $this->createCart();
    }

    public function createCart()
    {
        $this->_cart = new Cart();
        $this->_cartToken = $this->_cart->getToken();
        $this->_newCart = true;
        return $this->_cart;
    }

    public function getCartItems()
    {
        if ($this->hasCart()) {
            return $this->_cart->getItems();
        }
        return [];
    }

    public function getCartToken()
    {
        return $this->cartToken;
    }

    public function newCart()
    {
        return $this->_newCart;
    }
}

