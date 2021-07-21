<?php
namespace Jankx\Abstractions;

use Jankx\Abstractions\Constracts\ModuleConstract;

class ModuleLoader
{
    protected $module;
    protected $load_module_hook;

    public function __construct($class_name, $load_hook = false)
    {
        $this->load_module_hook = $load_hook;
        if (class_exists($class_name)) {
            $module = new $class_name();
            if (is_a($module, ModuleConstract::class)) {
                $this->module = $module;

                if (!$this->load_module_hook) {
                    $this->load_module();
                } else {
                    add_action($this->load_module_hook, array($this, 'load_module'));
                }
            }
        }
    }

    public function load_module()
    {
        if (!did_action('init')) {
            add_action('init', array($this->module, 'init'));
        }
    }

    public function get_module()
    {
        return $this->module;
    }
}
