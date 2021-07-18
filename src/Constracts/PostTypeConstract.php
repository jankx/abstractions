<?php
namespace Jankx\Module\Constracts;

interface PostTypeConstract
{
    public function get_post_type();

    public function get_args();

    public function register();
}
