<?php
namespace Linder\Controller;

use Anax\DI\DIFactoryConfig;
use PHPUnit\Framework\TestCase;

/**
 * Test the IpVerifierToJson class.
 */
class IpVerifierAPIControllerTest extends TestCase
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
        $this->di = new DIFactoryConfig();
        $this->di->loadServices(ANAX_INSTALL_PATH . "/config/di");
        $this->di->loadServices(ANAX_INSTALL_PATH . "/test/config/di");

        // Mock Ipverifier
        $this->di->setShared("ipverifier", "\Linder\Mock\IpVerifierMock");

        // View helpers uses the global $di so it needs its value
        $di = $this->di;

        // Setup the controller
        $this->controller = new IpVerifierAPIController();
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
        $this->assertArrayHasKey("domain", $res[0]);
        $this->assertContains("dbwebb", $res[0]["domain"]);

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
}
