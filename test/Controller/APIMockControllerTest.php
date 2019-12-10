<?php
namespace Linder\Controller;

use Anax\DI\DIMagic;
use PHPUnit\Framework\TestCase;

/**
 * Test the IpVerifierMock class.
 */
class APIMockControllerTest extends TestCase
{

    // Create the di container.
    protected $di;
    protected $controller;

    /**
     * Prepare before each test.
     */
    protected function setUp()
    {
        global $di;

        // Setup di
        $this->di = new DIMagic();
        $this->di->loadServices(ANAX_INSTALL_PATH . "/config/di");
        $this->di->loadServices(ANAX_INSTALL_PATH . "/test/config/di");

        // View helpers uses the global $di so it needs its value
        $di = $this->di;
        
        // Setup the controller
        $this->controller = new APIMockController();
        $this->controller->setDI($this->di);
    }

    /**
     * Test the route "index".
     */
    public function testIndexAction()
    {
        // test a valid IPv4 (dbwebb)
        $this->di->get("request")->setGet("ip", "194.47.150.9");
        $res = $this->controller->indexAction();
        $this->assertIsArray($res);
        $this->assertArrayHasKey("ip", $res[0]);
        $this->assertEquals("194.47.150.9", $res[0]["ip"]);
        $this->assertArrayHasKey("type", $res[0]);
        $this->assertEquals("ipv4", $res[0]["type"]);

        // testing a false ip
        $ip = "ThisNoIP";
        $this->di->get("request")->setGet("ip", $ip);
        $res = $this->controller->indexAction();
        $this->assertIsArray($res);
        $this->assertArrayHasKey("ip", $res[0]);
        $this->assertEquals($ip, $res[0]["ip"]);
        $this->assertArrayHasKey("type", $res[0]);
        $this->assertEquals(null, $res[0]["type"]);
        $this->assertArrayHasKey("domain", $res[0]);
        $this->assertEquals(null, $res[0]["domain"]);

        // test a valid IPv6 (dns google)
        $ip = "2001:4860:4860::8888";
        $this->di->get("request")->setGet("ip", $ip);
        $res = $this->controller->indexAction();
        $this->assertIsArray($res);
        $this->assertArrayHasKey("ip", $res[0]);
        $this->assertEquals($ip, $res[0]["ip"]);
        $this->assertArrayHasKey("type", $res[0]);
        $this->assertEquals("ipv6", $res[0]["type"]);
        $this->assertArrayHasKey("domain", $res[0]);
        $this->assertEquals("dns.google", $res[0]["domain"]);
    }

    /**
     * Test the route "DarkSkyMock".
     */
    public function testdarkSkyMockAction()
    {
        // Test default, should just return the array from
        // \Linder\Mock\DarkSkyMock->getWeatherComing("");
        $res = $this->controller->darkSkyMockAction();
        $this->assertContains("currently", $res[0]);

        // \Linder\Mock\DarkSkyMock->getWeatherComing("");
        $this->di->get("request")->setGet("type", "past");
        $res = $this->controller->darkSkyMockAction();

        // Test the return type
        $this->assertIsArray($res);

        // as the array only contains a raw JSONstring
        // we check if the only thing we use is in it.
        $this->assertContains("daily", $res[0]);
    }
}
