<?php
namespace Jankx\Module\Abstracts;

use Jankx\Module\Constracts\PostTypeConstract;
use Jankx\Module\Constracts\ModuleConstract;

abstract class Module implements ModuleConstract
{
    protected $post_type;

    public function init()
    {
        $module = new \ReflectionClass($this);

        // Regsiser post type
        $postTypeCls = sprintf('%s\PostType', $module->getNamespaceName());
        if (class_exists($postTypeCls, true)) {
            $post_type = new $postTypeCls();
            if (is_a($post_type, PostTypeConstract::class)) {
                $this->post_type = $post_type;
                $this->post_type->set_module($this);
                $this->post_type->register();
            }
        }
    }
}
