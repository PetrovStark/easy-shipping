<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class Broker extends Model
{
    use HasFactory;

    /**
     * Perform a basic publish to RabbitMQ service.
     * 
     * @param string $message
     * @param string $queue
     * 
     * @return void
     */
    public function produceBasicPublish(string $message, string $queue)
    {
        $connection = new AMQPStreamConnection(
            env('RABBITMQ_HOST'), 
            env('RABBITMQ_PORT'),
            env('RABBITMQ_USER'),
            env('RABBITMQ_PASS')
        );
        $channel = $connection->channel();
        $channel->queue_declare($queue, false, false, false, false);
    
        $msg = new AMQPMessage($message);
        $channel->basic_publish($msg, '', $queue);
        
        $channel->close();
        $connection->close();
    }
}
