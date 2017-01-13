<?php

namespace NoInc\SimpleStorefrontBundle\Util;

use NoInc\SimpleStorefrontBundle\Objects\HeaderHelper;

class HeaderHelperTest extends \PHPUnit_Framework_TestCase
{
    public function testShow()
    {
        $headerHelper = new HeaderHelper();
        $this->assertEquals($headerHelper->show(), true);
        $headerHelper->hideHeader();
        $this->assertEquals($headerHelper->show(), false);
    }

    public function testShowLogin()
    {
        $headerHelper = new HeaderHelper();
        $this->assertEquals($headerHelper->showLogin(), true);
        $headerHelper->hideLoginLogout();
        $this->assertEquals($headerHelper->showLogin(), false);
        $headerHelper = new HeaderHelper(true);
        $this->assertEquals($headerHelper->showLogin(), false);

    }
    public function testShowLogout()
    {
        $headerHelper = new HeaderHelper();
        $this->assertEquals($headerHelper->showLogout(), false);
        $headerHelper->hideLoginLogout();
        $this->assertEquals($headerHelper->showLogout(), false);
        $headerHelper = new HeaderHelper(true);
        $this->assertEquals($headerHelper->showLogout(), true);
    }
    public function testShowDashboardButton()
    {
        $headerHelper = new HeaderHelper(true, true);
        $this->assertEquals($headerHelper->showDashboardButton(), true);
        $headerHelper->hideDashboardButton();
        $this->assertEquals($headerHelper->showDashboardButton(), false);
        $headerHelper = new HeaderHelper(true, false);
        $this->assertEquals($headerHelper->showDashboardButton(), false);
    }
}
