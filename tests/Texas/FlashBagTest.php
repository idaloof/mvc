<?php

/**
 * Test suite for FlashBag class
 */

namespace App\Texas;
use PHPUnit\Framework\TestCase;

class FlashBagTest extends TestCase
{
    /**
     * @var FlashBag $bag
     */
    private FlashBag $bag;

    /**
     * Set up runs before every test case.
     */
    protected function setUp(): void
    {
        $this->bag = new FlashBag();
    }

    /**
     * Verify set and get method for bag name.
     */
    public function testSetAndGetName() : void
    {
        $this->bag->setName("Martin");

        $exp = "Martin";

        $res = $this->bag->getName();

        $this->assertEquals($exp, $res);
    }

    /**
     * Verify initialize method sets flashes correctly.
     */
    public function testInitialize() : void
    {
        $flash1 = ["nn", "nn"];
        $flash2 = ["ss", "ss"];
        $flashes = [$flash1, $flash2];

        $this->bag->initialize($flashes);

        $res = $this->bag->peekAll();

        $this->assertIsArray($res);
    }

    /**
     * Verify peek method returns array correctly.
     */
    public function testAddAndPeek() : void
    {
        $this->bag->add("nn", "nn");

        $res = $this->bag->peek("nn");

        $this->assertIsArray($res);
    }

    /**
     * Verify get method returns empty array.
     */
    public function testAddAndGetEmpty() : void
    {
        $this->bag->add("nn", "nn");

        $res = $this->bag->get("nx");

        $this->assertEmpty($res);
    }

    /**
     * Verify get method returns not empty array.
     */
    public function testAddAndGetNotEmpty() : void
    {
        $this->bag->add("nn", "nn");

        $res = $this->bag->get("nn");

        $this->assertNotEmpty($res);
    }

    /**
     * Verify all method returns empty array.
     */
    public function testAll() : void
    {
        $res = $this->bag->all();

        $this->assertEmpty($res);
    }

    /**
     * Verify set method returns not empty array.
     */
    public function testSet() : void
    {
        $this->bag->set("mm", ["mm", "mm"]);

        $res = $this->bag->all();

        $this->assertNotEmpty($res);
    }

    /**
     * Verify set all method sets multiple flashes.
     */
    public function testSetAll() : void
    {
        $this->bag->setAll(["mm", "mm"]);

        $res = $this->bag->peekAll();

        $this->assertNotEmpty($res);
    }

    /**
     * Verify key method returns array.
     */
    public function testKeys() : void
    {
        $this->bag->setAll(["mm", "mm"]);

        $res = $this->bag->keys();

        $this->assertIsArray($res);
    }

    /**
     * Verify get storage key method returns correct storage key.
     */
    public function testGetStorageKey() : void
    {
        $exp = '_symfony_flashes';

        $res = $this->bag->getStorageKey();

        $this->assertEquals($exp, $res);
    }

    /**
     * Verify key method returns array.
     */
    public function testClear() : void
    {
        $this->bag->setAll(["mm", "mm"]);

        $this->bag->clear();

        $res = $this->bag->peekAll();

        $this->assertEmpty($res);
    }
}