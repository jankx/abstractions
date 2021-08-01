<?php
namespace Jankx\Abstractions\Constracts;

interface ModuleConstract
{
    public function get_name();

    public function bootstrap();

    public function init();

    public function frontend_init();

    public function load_template();
}
