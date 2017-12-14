<?php
/**
 * Dida Framework  -- A Rapid Development Framework
 * Copyright (c) Zeupin LLC. (http://zeupin.com)
 *
 * Licensed under The MIT License.
 * Redistributions of files must retain the above copyright notice.
 */

namespace Dida;

use \ArrayAccess;

class Config implements ArrayAccess
{
    protected $items = [];


    public function __construct(array $items = [])
    {
        foreach ($items as $key => $value) {
            $this->checkKey($key);
        }

        $this->items = $items;
    }


    public function offsetExists($key)
    {
        return $this->has($key);
    }


    public function offsetSet($key, $value)
    {
        $this->set($key, $value);
    }


    public function offsetGet($key)
    {
        return $this->get($key);
    }


    public function offsetUnset($key)
    {
        $this->remove($key);
    }


    public function has($key)
    {
        return array_key_exists($key, $this->items);
    }


    public function set($key, $value)
    {
        $this->items[$key] = $value;
    }


    public function get($key, $default = null)
    {
        return $this->has($key) ? $this->items[$key] : $default;
    }


    public function remove($key)
    {
        $this->checkLocked();

        unset($this->items[$key]);
    }


    public function keys()
    {
        return array_keys($this->items);
    }


    public function clear()
    {
        $this->items = [];
    }


    public function getGroupItems($group)
    {
        $find = $group . '.';
        $len = mb_strlen($find);

        $keys = array_keys($this->items, $find, true);

        $return = [];
        foreach ($keys as $key) {
            if (strncmp($find, $key, $len) === 0) {
                $return[$key] = $this->items[$key];
            }
        }
        return $return;
    }


    public function groupUnpack($group, array $items)
    {
        foreach ($items as $key => $value) {
            $this->items[$group . '.' . $key] = $value;
        }
    }


    public function groupPack($group)
    {
        $return = [];

        $items = $this->getGroupItems($group);

        foreach ($items as $key => $value) {
            $newkey = mb_substr($key, mb_strlen($group) + 1);
            $return[$newkey] = $value;
        }

        return $return;
    }


    public function groupClear($group)
    {
        $items = $this->getGroupItems($group);

        foreach ($items as $key => $value) {
            unset($this->items[$key]);
        }
    }


    public function batchSet(array $configs, array $defaults = [])
    {
        $new = array_merge($defaults, $configs);
        $this->items = array_merge($this->items, $new);
    }


    public function sortKeys()
    {
        ksort($this->items);
    }


    public function load($filepath, $group = '')
    {
        $require = function () use ($filepath) {
            if (file_exists($filepath)) {
                return require($filepath);
            } else {
                return false;
            }
        };
        $items = $require();

        if (empty($items)) {
            return false;
        }

        if ($group === '' || !is_string($group)) {
            $groupname = '';
        } else {
            $groupname = $group . '.';
        }

        foreach ($items as $key => $value) {
            $this->items[$groupname . $key] = $value;
        }
        return true;
    }


    public function merge(Config $src)
    {
        $keys = $src->keys();
        foreach ($keys as $key) {
            $this->items[$key] = $src[$key];
        }
    }
}
