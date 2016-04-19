<?php

namespace LightPress;

/**
 * allow getting and setting of user-configurable data
 */
class Configure {
    /**
     * location of disk of the file
     * @var String
     */
    private $file;

    /**
     * unserialized data
     * @var Array
     */
    private $data;

    /**
     * @param String $file
     */
    public function __construct($file) {
        $this->file = $file;

        if (!file_exists($this->file)) {
            $this->data = array();
            $this->write();
        }

        $this->read();
    }

    public function get($key) {
        return $this->data[$key];
    }

    public function set($key, $value) {
        $this->data[$key] = $value;
        $this->write();
    }

    /**
     * output our data to disk
     */
    private function write() {
        if (!file_put_contents($this->file, serialize($this->data))) {
            throw new \Exception("could not write to config_file");
        }
    }

    /**
     * populate our data array with the on-disk data
     */
    private function read() {
        $this->data = unserialize(file_get_contents($this->file));
    }
}