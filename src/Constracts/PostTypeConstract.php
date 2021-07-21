<?php
namespace Jankx\Abstractions\Constracts;

interface PostTypeConstract
{
    public function get_post_type();

    public function get_args();

    public function register();
}
