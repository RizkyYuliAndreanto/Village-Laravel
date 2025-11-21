<?php

namespace App\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SecurityEvent
{
    use Dispatchable, SerializesModels;

    public string $type;
    public string $ip;
    public array $data;
    public string $userAgent;
    public string $timestamp;

    /**
     * Create a new event instance.
     */
    public function __construct(string $type, string $ip, array $data = [])
    {
        $this->type = $type;
        $this->ip = $ip;
        $this->data = $data;
        $this->userAgent = request()->userAgent() ?? 'Unknown';
        $this->timestamp = now()->toDateTimeString();
    }
}
