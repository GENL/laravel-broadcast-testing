<?php

namespace Genl\TestBroadcaster;

use Illuminate\Support\Str;

trait CanTestBroadcasting
{
    public function assertEventWasBroadcast($event, $channels = null, $count = null)
    {
        $broadcaster = resolve(TestBroadcaster::class);

        $message = "Failed asserting that event '$event' was broadcast";

        if (is_integer($channels)) {
            $count = $channels;
            $channels = null;
        }

        if ($channels != null) {
            $message .= " on channel ";
            if (is_array($channels)) {
                $message .= "s '" . implode(', ', $channels) . "'";
            } else {
                $message .= "'" . $channels . "'";
            }
        }

        if ($count != null) {
            $message .= " " . $count . " times";
        }

        $broadcasts = $broadcaster->getBroadcasts();
        $broadcastCount = count($broadcasts);
        $evtStr = Str::plural('event', $broadcastCount);
        $message .= "\n$broadcastCount $evtStr was broadcast: " . json_encode($broadcasts);

        $this->assertTrue($broadcaster->contains($event, $channels, $count), $message);
    }
}
