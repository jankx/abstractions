<?php
namespace Jankx\Abstractions;

/**
 * default abstract loader class
 */
class Jankx_Abstractions_Bootstrap {
    /**
     * @var \Jankx\Abstractions\AbstractionManager
     */
    protected $manager;

    /**
     * @var string
     */
    protected $loadHook = null;

    protected function __construct() {
        $this->manager  = AbstractionManager::getInstance('default');
        $this->loadHook = $this->resolveLoadHook();
    }

    protected function resolveLoadHook() {
        if (!did_action('after_setup_theme')) {
            return 'after_setup_theme';
        }

        if (!did_action('init')) {
            return 'init';
        }

        if (!did_action('wp')) {
            return 'wp';
        }

        return null;
    }

    public function getLoadHook() {
        return $this->loadHook;
    }

    public function run() {
    }
}

$bootstrap = new Jankx_Abstractions_Bootstrap();
if (is_null($bootstrap->getLoadHook())) {
    $bootstrap->run();
} else {
    add_action($bootstrap->getLoadHook(), [$bootstrap, 'run']);
}
