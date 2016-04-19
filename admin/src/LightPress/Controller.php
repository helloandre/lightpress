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
        $metadata = $this->page->get_all_metadata();

        // Render index view
        return $this->renderer->render($response, 'index.phtml', compact('metadata'));
    }

    public function get($request, $response, $args) {
        $data = $this->page->get($args['id']);
        return $response->withJSON(compact('data'));
    }

    public function create($request, $response, $args) {
        $body = $request->getParsedBody();
        $id = $this->page->create(json_decode($body['metadata'], true), $body['content']);
        
        return $response->withJSON(compact('id'));
    }

    public function save($request, $response, $args) {
        $body = $request->getParsedBody();
        $this->page->save($body['id'], json_decode($body['metadata'], true), $body['content']);

        return $response->withJSON(array('success' => true));
    }

    public function delete($request, $response, $args) {
        $body = $request->getParsedBody();
        $this->page->delete($body['id']);

        return $response->withJSON(array('success' => true));
    }
}