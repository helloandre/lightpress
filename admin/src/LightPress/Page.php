<?php

namespace LightPress;

/**
 * A way to store and fetch pages that LightPress understands
 */
class Page {
    /**
     * location of disk of the pages folder
     * @var String
     */
    private $dir;

    /**
     * @param String $dir
     */
    public function __construct($dir) {
        $this->dir = rtrim($dir, '/') . '/';

        if (!file_exists($this->dir)) {
            if (!mkdir($this->dir, 0777, true)) {
                throw new \Exception("could not write to pages");
            }
        }
    }

    public function create($metadata, $content) {
        $id = preg_replace("/\./", "", microtime(true));
        $this->save($id, $metadata, $content);

        return $id;
    }

    /**
     * return all available pages
     */
    public function get_all_metadata() {
        $data = array();
        foreach (scandir($this->dir) as $file) {
            if ($file === '.' || $file === '..') {
                continue;
            }

            $file = $this->read($file);
            $data[] = $file['metadata'];
        }

        return $data;
    }

    /**
     * read this page's data from disk
     */
    public function get($id) {
        if (!file_exists($this->dir . $id)) {
            return false;
        }

        return $this->read($id);
    }

    /**
     * output our data to disk
     *
     * @param String $id,
     * @param Array $metadata
     * @param String $content - JSON String
     */
    public function save($id, $metadata, $content) {
        $data = compact('metadata', 'content');
        if (!file_put_contents($this->dir . $id, serialize($data))) {
            throw new \Exception("could not write " . $this->dir . $id . " to pages");
        }
    }

    /**
     * remove this page
     */
    public function delete($id) {
        unlink($this->dir . $id);
    }

    /**
     * populate our data array with the on-disk data
     */
    private function read($id) {
        return unserialize(file_get_contents($this->dir . $id));
    }
}