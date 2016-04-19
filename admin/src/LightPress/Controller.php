<?php

namespace LightPress;

class Controller {
    /**
     * @var ContainerInterface
     */
    private $ci;

    /**
     * @param String $file
     */
    public function __construct(\Slim\Container $ci) {
        $this->ci = $ci;
    }

    public function __get($prop) {
        return $this->ci->{$prop};
    }

    public function index($request, $response, $args) {
        // Sample log message
        $this->logger->info("Slim-Skeleton '/' route");

        // Render index view
        return $this->renderer->render($response, 'index.phtml', $args);
    }
}