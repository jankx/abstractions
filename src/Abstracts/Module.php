<?php
namespace Jankx\Abstractions\Abstracts;

use Jankx\Abstractions\Constracts\PostTypeConstract;
use Jankx\Abstractions\Constracts\ModuleConstract;

abstract class Module implements ModuleConstract
{
    protected $post_type;

    public function setPostType($postType)
    {
        if (is_a($postType, PostTypeConstract::class)) {
            $this->post_type = $postType;
        }
    }

    public function bootstrap()
    {
    }

    public function init()
    {
    }

    public function frontend_init()
    {
    }

    public function load_template()
    {
    }
}
