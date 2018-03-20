<?php
namespace App\Tasks\Task2;

use ArrayAccess;

class Container implements ArrayAccess
{
    private $container = [];

    public function offsetSet($offset, $value) {
        $this->set($offset, $value);
    }

    public function offsetExists($offset) {
        return $this->has($offset);
    }

    public function offsetUnset($offset) {
        $this->unset($offset);
    }

    public function offsetGet($offset) {
        return $this->get($offset);
    }

    public function get(string $key)
    {
        $value = isset($this->container[$key]) ? $this->container[$key] : null;

        if (is_callable($value)) {
            $value = $this->container[$key] = call_user_func($value);
        }

        return $value;
    }

    public function set(string $key, $value): void
    {
        if (is_null($key)) {
            $this->container[] = $value;
        } else {
            $this->container[$key] = $value;
        }
    }

    public function has(string $key): bool
    {
        return isset($this->container[$key]);
    }

    public function unset(string $key)
    {
        unset($this->container[$key]);
    }

    public function __invoke($key)
    {
        return $this->get($key);
    }

    public function __get($key)
    {
        return $this->get($key);
    }

    public function __set($key, $value)
    {
        $this->set($key, $value);
    }
}