<?php

namespace Genl\BroadcastTesting;

use Illuminate\Support\Facades\Facade;

/**
 * @method static void broadcast(array $channels, $event, array $payload = [])
 * @method static bool contains(string $event, $channels = null, $count = null, array $payload = null)
 * @method static bool broadcastContainsAllChannels(array $broadcast, $channels)
 * @method static bool broadcastContainsChannel(array $broadcast, string $channel)
 *
 * @see \Genl\BroadcastTesting\TestBroadcaster
 */
class TestBroadcasterFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'testbroadcaster';
    }
}
