<?php

namespace BristolSU\Tests\ApiToolkit\Unit;

use BristolSU\ApiToolkit\Response;
use BristolSU\Tests\ApiToolkit\TestCase;
use http\Client;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

class ResponseTest extends TestCase
{

    /** @test */
    public function it_can_be_created_using_a_response_interface(){
        $responseInterface = $this->prophesize(ResponseInterface::class);
        $response = new Response($responseInterface->reveal());
        $this->assertInstanceOf(Response::class, $response);
    }

    /** @test */
    public function getResponse_returns_the_response(){
        $responseInterface = $this->prophesize(ResponseInterface::class);
        $response = new Response($responseInterface->reveal());

        $this->assertEquals($responseInterface->reveal(), $response->getResponse());
    }

    /** @test */
    public function getResponseBody_returns_the_response_body()
    {
        $stream = $this->prophesize(StreamInterface::class);
        $stream->__toString()->shouldBeCalled()->willReturn('test_body');

        $responseInterface = $this->prophesize(ResponseInterface::class);
        $responseInterface->getBody()->shouldBeCalled()->willReturn($stream->reveal());

        $response = new Response($responseInterface->reveal());
        $this->assertEquals('test_body', $response->getResponseBody());
    }

    /** @test */
    public function setBody_and_get_body_retrieve_the_body_of_the_response(){
        $responseInterface = $this->prophesize(ResponseInterface::class);
        $response = new Response($responseInterface->reveal());

        $this->assertNull($response->getBody());

        $response->setBody(['this is a test']);
        $this->assertEquals(['this is a test'], $response->getBody());

        $response->setBody('this is a test string');
        $this->assertEquals('this is a test string', $response->getBody());
    }

    /** @test */
    public function attributes_can_be_set_and_got_dynamically()
    {
        $responseInterface = $this->prophesize(ResponseInterface::class);
        $response = new Response($responseInterface->reveal());

        $response->test_attribute = 'This is a test';
        $this->assertEquals('This is a test', $response->test_attribute);

        $response->test_attribute_two = 'This is a test';
        $this->assertEquals('This is a test', $response->test_attribute_two);
    }

    /** @test */
    public function if_an_attribute_is_not_set_it_will_throw_an_exception(){
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Property test_attribute does not exist on the response class BristolSU\ApiToolkit\Response');

        $responseInterface = $this->prophesize(ResponseInterface::class);
        $response = new Response($responseInterface->reveal());

        $response->test_attribute;
    }

}
