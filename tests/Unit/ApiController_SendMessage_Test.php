<?php

namespace Tests\Unit;

use App\Brokers\SmsGlobalSendSmsBroker;
use Exception;
use Mockery;
use Tests\TestCase;
use function app;
use function route;

class ApiController_SendMessage_Test extends TestCase
{


    public function test_message_send_success(): void
    {
        $broker = Mockery::mock(SmsGlobalSendSmsBroker::class);
        $broker
            ->shouldReceive('setApiKeyPublic')->with('user_name')->times(1)->andReturn($broker)
            ->shouldReceive('setApiKeySecret')->with('secure_password')->times(1)->andReturn($broker)
            ->shouldReceive('addDestinationNumber')->with('+61000000000')->times(1)->andReturn($broker)
            ->shouldReceive('setMessage')->with('Good morning!')->times(1)->andReturn($broker)
            ->shouldReceive('send')->with()->times(1)->andReturn($broker)
            ->shouldReceive('wasException')->with()->times(1)->andReturn(false)
        ;
        app()->instance(SmsGlobalSendSmsBroker::class, $broker);

        $headers  = [
            'HTTP_Authorization' => 'Basic ' . base64_encode('user_name:secure_password'),
        ];
        $content  = [
            'destination_number' => '+61000000000',
            'message'            => 'Good morning!',
        ];
        $route    = route('api.message-post');
        $response = $this->withHeaders($headers)->json('POST', $route, $content);
        $response->assertStatus(200);

        $this->assertTrue(true);
    }


    public function test_message_send__authentication_failed(): void
    {
        $broker = Mockery::mock(SmsGlobalSendSmsBroker::class);
        app()->instance(SmsGlobalSendSmsBroker::class, $broker);

        $headers  = [
        ];
        $content  = [
            'destination_number' => '+61000000000',
            'message'            => 'Good morning!',
        ];
        $route    = route('api.message-post');
        $response = $this->withHeaders($headers)->json('POST', $route, $content);
        $response->assertStatus(401);

        $this->assertTrue(true);
    }


    public function test_message_send__validation_failed(): void
    {
        $broker = Mockery::mock(SmsGlobalSendSmsBroker::class);
        app()->instance(SmsGlobalSendSmsBroker::class, $broker);

        $headers  = [
            'HTTP_Authorization' => 'Basic ' . base64_encode('user_name:secure_password'),
        ];
        $content  = [
        ];
        $route    = route('api.message-post');
        $response = $this->withHeaders($headers)->json('POST', $route, $content);
        $response->assertStatus(422);

        $this->assertTrue(true);
    }


    public function test_message_send__authorization_failed(): void
    {
        $broker = Mockery::mock(SmsGlobalSendSmsBroker::class);
        $broker
            ->shouldReceive('setApiKeyPublic')->with('user_name')->times(1)->andReturn($broker)
            ->shouldReceive('setApiKeySecret')->with('secure_password')->times(1)->andReturn($broker)
            ->shouldReceive('addDestinationNumber')->with('+61000000000')->times(1)->andReturn($broker)
            ->shouldReceive('setMessage')->with('Good morning!')->times(1)->andReturn($broker)
            ->shouldReceive('send')->with()->times(1)->andReturn($broker)
            ->shouldReceive('wasException')->with()->times(1)->andReturn(true)
            ->shouldReceive('getException')->with()->times(1)->andReturn(new Exception())
            ->shouldReceive('wasAuthenticationException')->with()->times(1)->andReturn(true)
        ;
        app()->instance(SmsGlobalSendSmsBroker::class, $broker);

        $headers  = [
            'HTTP_Authorization' => 'Basic ' . base64_encode('user_name:secure_password'),
        ];
        $content  = [
            'destination_number' => '+61000000000',
            'message'            => 'Good morning!',
        ];
        $route    = route('api.message-post');
        $response = $this->withHeaders($headers)->json('POST', $route, $content);
        $response->assertStatus(403);

        $this->assertTrue(true);
    }


    public function test_message_send__something_else_failed(): void
    {
        $broker = Mockery::mock(SmsGlobalSendSmsBroker::class);
        $broker
            ->shouldReceive('setApiKeyPublic')->with('user_name')->times(1)->andReturn($broker)
            ->shouldReceive('setApiKeySecret')->with('secure_password')->times(1)->andReturn($broker)
            ->shouldReceive('addDestinationNumber')->with('+61000000000')->times(1)->andReturn($broker)
            ->shouldReceive('setMessage')->with('Good morning!')->times(1)->andReturn($broker)
            ->shouldReceive('send')->with()->times(1)->andReturn($broker)
            ->shouldReceive('wasException')->with()->times(1)->andReturn(true)
            ->shouldReceive('getException')->with()->times(1)->andReturn(new Exception())
            ->shouldReceive('wasAuthenticationException')->with()->times(1)->andReturn(false)
        ;
        app()->instance(SmsGlobalSendSmsBroker::class, $broker);

        $headers  = [
            'HTTP_Authorization' => 'Basic ' . base64_encode('user_name:secure_password'),
        ];
        $content  = [
            'destination_number' => '+61000000000',
            'message'            => 'Good morning!',
        ];
        $route    = route('api.message-post');
        $response = $this->withHeaders($headers)->json('POST', $route, $content);
        $response->assertStatus(400);

        $this->assertTrue(true);
    }


}
