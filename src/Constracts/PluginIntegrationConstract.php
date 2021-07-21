<?php
namespace Jankx\Abstractions\Constracts;

interface PluginIntegrationConstract
{
    public function getName();

    public function integrate();
}
