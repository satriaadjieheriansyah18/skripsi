<?php

namespace App\Events;

use App\Models\Order;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\ShouldBroadcast; // Import interface ini
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NewOrderCreated implements ShouldBroadcast, ShouldQueue  // Implementasikan interface ini
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $order;

    /**
     * Create a new event instance.
     *
     * @param \App\Models\Order $order
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel
     */
    public function broadcastOn()
    {
        return new Channel('orders');  // Pastikan channel ini sesuai dengan yang didengar oleh Echo di frontend
    }

    /**
     * Tentukan nama event untuk broadcast.
     *
     * @return string
     */
    public function broadcastAs()
    {
        return 'new.order';  // Sesuaikan nama event jika diperlukan
    }
}


