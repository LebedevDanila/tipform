<?php
// GENERATED CODE -- DO NOT EDIT!

namespace Endpoints\Helloworld;

/**
 * The greeting service definition.
 */
class GreeterClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * Sends a greeting
     * @param \Endpoints\Helloworld\HelloRequest $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     * @return \Endpoints\Helloworld\HelloReply
     */
    public function SayHello(\Endpoints\Helloworld\HelloRequest $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/endpoints.helloworld.Greeter/SayHello',
        $argument,
        ['\Endpoints\Helloworld\HelloReply', 'decode'],
        $metadata, $options);
    }

}
