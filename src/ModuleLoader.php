<?php
namespace Jankx\Abstractions;

use Jankx\Abstractions\Constracts\PostTypeConstract;
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

    public function module_init()
    {
        $module = new \ReflectionClass($this->module);

        // Regsiser post type
        $postTypeCls = sprintf('%s\PostType', $module->getNamespaceName());

        if (class_exists($postTypeCls, true)) {
            $post_type = new $postTypeCls();

            if (is_a($post_type, PostTypeConstract::class)) {
                $post_type->set_module($this->module);
                $post_type->register();
                $this->module->setPostType($post_type);
            }
        }

        $this->module->init();
    }

    public function load_module()
    {
        if (!$this->module) {
            return;
        }

        if (!did_action('after_setup_theme')) {
            add_action('after_setup_theme', array($this->module, 'bootstrap'));
        } else {
            $this->module->bootstrap();
        }

        if (!did_action('init')) {
            add_action('init', array($this, 'module_init'));
        } else {
            $this->module_init();
        }

        add_action('wp', array($this->module, 'frontend_init'));
        add_action('template_redirect', array($this->module, 'load_template'));
    }

    public function get_module()
    {
        return $this->module;
    }
}
