<?php
namespace Jankx\Abstractions;

class AbstractionManager {
    /**
     * @var \Jankx\Abstractions\AbstractionManager[]
     */
    protected static $instances = [
        'default' => new static()
    ];

    protected $id;

    protected function __construct($instanceId)
    {
        $this->id = $instanceId;
    }

    public static function getInstance($instanceId = null) {
        if (is_null($instanceId)) {
            $instanceId = 'default';
        }

        if (!isset(static::$instances[$instanceId])) {
            static::$instances[$instanceId] = new static($instanceId);
        }
        return static::$instances[$instanceId];
    }

    public function __callStatic($name, $arguments)
    {
        $instanceId = end($arguments);
        if (empty($instanceId) || !isset(static::$instances[$instanceId])) {
            $instanceId = 'default';
        }
        $instance = static::$instances[$instanceId];
        if (method_exists($instance, $name)) {
            return call_user_func_array([$instance, $name], $arguments);
        }
    }

    public function registerModule($moduleName, $instanceId = null) {
    }

    public function getModule($moduleName, $instanceId) {
    }
}
