<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('testChannel', function () {
    return true; // Allow anyone to connect to this channel
});
