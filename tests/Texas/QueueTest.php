<?php

/**
 * Test suite for Queue class
 */

namespace App\Texas;
use PHPUnit\Framework\TestCase;

class QueueTest extends TestCase
{
    /**
     * Verify that Queue enqueues player.
     */
    public function testEnqueue() : void
    {
        $player = [new TexasPlayer("Martin", 20, 20)];

        $queue = new Queue($player);

        $playerCom1 = new ComputerStu("Stu", 20);
        // $playerCom2 = new ComputerStu("Stu2", 20);

        $queue->enqueue($playerCom1);

        $exp = 2;

        $res = count($queue->getQueue());

        $this->assertEquals($exp, $res);

        $players = $queue->getQueue();

        $exp = "Stu";

        $res = $players[1]->getName();

        $this->assertEquals($exp, $res);
    }

    /**
     * Verify that Queue dequeues player.
     */
    public function testDequeue() : void
    {
        $player = [new TexasPlayer("Martin", 20, 20)];

        $queue = new Queue($player);

        $playerCom1 = new ComputerStu("Stu", 20);
        $queue->enqueue($playerCom1);

        $player = $queue->dequeue();

        $exp = 1;

        $res = count($queue->getQueue());

        $this->assertEquals($exp, $res);

        $exp = "Martin";

        $res = $player->getName();

        $this->assertEquals($exp, $res);
    }

    /**
     * Verify that Queue dequeues player and throws exception on the second dequeue.
     */
    public function testDequeueException() : void
    {
        $player = [new TexasPlayer("Martin", 20, 20)];

        $queue = new Queue($player);

        $queue->dequeue();

        $exp = 0;

        $res = count($queue->getQueue());

        $this->assertEquals($exp, $res);

        $this->expectException(\Exception::class);

        $queue->dequeue();
    }

    /**
     * Verify that Queue peek returns correct player.
     */
    public function testPeek() : void
    {
        $player = [new TexasPlayer("Martin", 20, 20)];

        $queue = new Queue($player);

        $player = $queue->peek();

        $exp = "Martin";

        $res = $player->getName();

        $this->assertEquals($exp, $res);
    }
}