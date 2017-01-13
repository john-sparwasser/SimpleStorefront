<?php

namespace NoInc\SimpleStorefrontBundle\Objects;

class HeaderHelper
{
    private $_showHeader = true;
    private $_showLogin = true;
    private $_showLogout =false;
    private $_showDashboardButton = false;

    public function __construct($loggedIn = false, $isAdmin = false)
    {
        if ($loggedIn) {
            $this->_showHeader = true;
            $this->_showLogin = false;
            $this->_showLogout = true;
            if ($isAdmin) {
                $this->_showDashboardButton = true;
            }
        }
    }

    public function hideHeader()
    {
        $this->_showHeader = false;
    }

    public function hideDashboardButton()
    {
        $this->_showDashboardButton = false;
    }

    public function hideLoginLogout()
    {
        $this->_showLogin = false;
        $this->_showLogout = false;
    }

    public function show()
    {
        return $this->_showHeader;
    }
    public function showLogin()
    {
        return $this->_showLogin;
    }
    public function showLogout()
    {
        return $this->_showLogout;
    }
    public function showDashboardButton()
    {
        return $this->_showDashboardButton;
    }
}
