<?php
namespace Jankx\Abstractions;

use Jankx\Abstractions\Constracts\PluginIntegrationConstract;

class PluginIntegrations
{
    protected $integrations = array();

    public function __construct($integrationClasses = array())
    {
        $this->addIntegrationClasses($integrationClasses);
    }

    public function addIntegrationClasses($integrationClasses)
    {
        foreach ($integrationClasses as $integrationClass) {
            $this->addIntegration(new $integrationClass());
        }
    }

    public function addIntegration($integration)
    {
        if (is_a($integration, PluginIntegrationConstract::class)) {
            $this->integrations[$integration->getName()] = $integration;
        }
    }

    public function load()
    {
        foreach ($this->integrations as $integration) {
            $integration->integrate();
        }
    }
}
