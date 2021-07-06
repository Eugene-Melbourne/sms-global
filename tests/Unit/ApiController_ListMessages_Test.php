<?php

namespace Tests\Unit;

use App\Brokers\SmsGlobalListMessagesBroker;
use Exception;
use Mockery;
use Tests\TestCase;
use function app;
use function route;

class ApiController_ListMessages_Test extends TestCase
{


    public function test_message_list_success(): void
    {
        $broker = Mockery::mock(SmsGlobalListMessagesBroker::class);
        $broker
            ->shouldReceive('setApiKeyPublic')->with('user_name')->times(1)->andReturn($broker)
            ->shouldReceive('setApiKeySecret')->with('secure_password')->times(1)->andReturn($broker)
            ->shouldReceive('setDestinationNumber')->with('+61000000000')->times(1)->andReturn($broker)
            ->shouldReceive('requestMessages')->with()->times(1)->andReturn($broker)
            ->shouldReceive('wasException')->with()->times(1)->andReturn(false)
            ->shouldReceive('getResponse')->with()->times(1)->andReturn(['some result array'])
        ;
        app()->instance(SmsGlobalListMessagesBroker::class, $broker);

        $headers  = [
            'HTTP_Authorization' => 'Basic ' . base64_encode('user_name:secure_password'),
        ];
        $content  = [
            'destination_number' => '+61000000000',
        ];
        $route    = route('api.message-get');
        $response = $this->withHeaders($headers)->json('GET', $route, $content);
        $response->assertStatus(200);

        $this->assertTrue(true);
    }


    public function test_message_list__authentication_failed(): void
    {
        $broker = Mockery::mock(SmsGlobalListMessagesBroker::class);
        app()->instance(SmsGlobalListMessagesBroker::class, $broker);

        $headers  = [
        ];
        $content  = [
            'destination_number' => '+61000000000',
        ];
        $route    = route('api.message-get');
        $response = $this->withHeaders($headers)->json('GET', $route, $content);
        $response->assertStatus(401);

        $this->assertTrue(true);
    }


    public function test_message_list__validation_failed(): void
    {
        $broker = Mockery::mock(SmsGlobalListMessagesBroker::class);
        app()->instance(SmsGlobalListMessagesBroker::class, $broker);

        $headers  = [
            'HTTP_Authorization' => 'Basic ' . base64_encode('user_name:secure_password'),
        ];
        $content  = [
        ];
        $route    = route('api.message-get');
        $response = $this->withHeaders($headers)->json('GET', $route, $content);
        $response->assertStatus(422);

        $this->assertTrue(true);
    }


    public function test_message_list__authorization_failed(): void
    {
        $broker = Mockery::mock(SmsGlobalListMessagesBroker::class);
        $broker
            ->shouldReceive('setApiKeyPublic')->with('user_name')->times(1)->andReturn($broker)
            ->shouldReceive('setApiKeySecret')->with('secure_password')->times(1)->andReturn($broker)
            ->shouldReceive('setDestinationNumber')->with('+61000000000')->times(1)->andReturn($broker)
            ->shouldReceive('requestMessages')->with()->times(1)->andReturn($broker)
            ->shouldReceive('wasException')->with()->times(1)->andReturn(true)
            ->shouldReceive('getException')->with()->times(1)->andReturn(new Exception())
            ->shouldReceive('wasAuthenticationException')->with()->times(1)->andReturn(true)
        ;
        app()->instance(SmsGlobalListMessagesBroker::class, $broker);

        $headers  = [
            'HTTP_Authorization' => 'Basic ' . base64_encode('user_name:secure_password'),
        ];
        $content  = [
            'destination_number' => '+61000000000',
        ];
        $route    = route('api.message-get');
        $response = $this->withHeaders($headers)->json('GET', $route, $content);
        $response->assertStatus(403);

        $this->assertTrue(true);
    }


    public function test_message_list__something_else_failed(): void
    {
        $broker = Mockery::mock(SmsGlobalListMessagesBroker::class);
        $broker
            ->shouldReceive('setApiKeyPublic')->with('user_name')->times(1)->andReturn($broker)
            ->shouldReceive('setApiKeySecret')->with('secure_password')->times(1)->andReturn($broker)
            ->shouldReceive('setDestinationNumber')->with('+61000000000')->times(1)->andReturn($broker)
            ->shouldReceive('requestMessages')->with()->times(1)->andReturn($broker)
            ->shouldReceive('wasException')->with()->times(1)->andReturn(true)
            ->shouldReceive('getException')->with()->times(1)->andReturn(new Exception())
            ->shouldReceive('wasAuthenticationException')->with()->times(1)->andReturn(false)
        ;
        app()->instance(SmsGlobalListMessagesBroker::class, $broker);

        $headers  = [
            'HTTP_Authorization' => 'Basic ' . base64_encode('user_name:secure_password'),
        ];
        $content  = [
            'destination_number' => '+61000000000',
        ];
        $route    = route('api.message-get');
        $response = $this->withHeaders($headers)->json('GET', $route, $content);
        $response->assertStatus(400);

        $this->assertTrue(true);
    }


}
