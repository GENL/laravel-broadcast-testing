<?php

namespace Genl\TestBroadcaster\Tests;

use PHPUnit\Framework\ExpectationFailedException;

class CanTestBroadcastingTest extends TestCase
{
    /**
     * @test
     */
    public function it_can_assert_when_an_event_is_broadcast()
    {
        try {
            $this->assertEventWasBroadcast(TestEvent::class);
            $this->fail("assertEventWasBroadcast asserted that an event was broadcast when it wasn't");
        } catch (ExpectationFailedException $e) {
        }

        event(new TestEvent());

        $this->assertEventWasBroadcast(TestEvent::class);
    }

    /**
     * @test
     */
    public function it_can_assert_if_an_event_was_broadcast_a_given_amount_of_times()
    {
        try {
            $this->assertEventWasBroadcast(TestEvent::class, 1);
            $this->fail("assertEventWasBroadcast asserted that an event was broadcast once when it wasn't");
        } catch (ExpectationFailedException $e) {
        }

        event(new TestEvent());
        $this->assertEventWasBroadcast(TestEvent::class, 1);

        try {
            $this->assertEventWasBroadcast(TestEvent::class, 2);
            $this->fail("assertEventWasBroadcast asserted that an event was broadcast twice when only was broadcast once");
        } catch (ExpectationFailedException $e) {
        }

        event(new TestEvent());
        $this->assertEventWasBroadcast(TestEvent::class, 2);
    }

    /**
     * @test
     */
    public function it_can_assert_if_an_event_was_broadcast_on_a_single_channel()
    {
        event(new TestEvent());

        $this->assertEventWasBroadcast(TestEvent::class, 'private-channel-name');

        try {
            $this->assertEventWasBroadcast(TestEvent::class, 'somethingelse-fake-channel');
            $this->fail("assertEventWasBroadcast asserted that an event was broadcast on a given channel when it wasn't");
        } catch (ExpectationFailedException $e) {
        }
    }

    /**
     * @test
     */
    public function it_can_assert_if_an_event_was_broadcast_on_multiple_channels()
    {
        event(new TestEvent());

        $this->assertEventWasBroadcast(TestEvent::class, ['private-channel-name', 'private-another-channel-name']);

        try {
            $this->assertEventWasBroadcast(TestEvent::class, [
                'private-channel-name',
                'somethingelse-fake-channel',
            ]);
            $this->fail("assertEventWasBroadcast asserted that an event was broadcast on given channels when it wasn't");
        } catch (ExpectationFailedException $e) {
        }
    }
}
