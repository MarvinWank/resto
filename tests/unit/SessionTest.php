<?php

namespace unit;

use App\Factories\SessionFactory;
use App\Models\Session;
use App\Models\User;
use PHPUnit\Framework\TestCase;

class SessionTest extends TestCase
{
    /** @var SessionFactory $sessionFactory */
    private $sessionFactory;
    /** @var Session $session */
    private $session;

    public function setUp(): void
    {
        $this->sessionFactory = app(SessionFactory::class);
        $this->session = $this->sessionFactory->retrieve(null);
    }

    public function testSetPrimitiveType()
    {
        $this->session->set("testNumber", 123);
        $this->assertEquals(123, $this->session->get("testNumber"));

        $this->session->set("testString", "foobar");
        $this->assertEquals("foobar", $this->session->get("testString"));
    }

    public function testSetObject()
    {
        $user = new User(-1, "test", "test@test.de");
        $this->session->set("testUser", $user);
        /** @var User $user_retrieved */
        $user_retrieved = $this->session->get("testUser");

        $this->assertEquals("test@test.de", $user_retrieved->get_email());
    }

    public function testSetArray()
    {
        $data = ["foo", "bar"];
        $this->session->set("testArray", $data);

        $this->assertEquals("bar", $this->session->get("testArray")[1]);
    }
}
