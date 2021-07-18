<?php
namespace Jankx\Module\Abstracts;

use Jankx\Module\Constracts\PostTypeConstract;

abstract class PostTypeAbstract implements PostTypeConstract
{
    protected $module;

    public function set_module(&$module)
    {
        $this->module = $module;
    }

    public function get_labels()
    {
        return array(
        );
    }

    public function get_args()
    {
        return array(
            'labels' => $this->get_labels(),
            'public' => true,
        );
    }

    public function get_taxonomies()
    {
        return array();
    }

    public function register()
    {
        register_post_type(
            $this->get_post_type(),
            apply_filters(
                sprintf(
                    'jankx_module_%s_post_type_%s_args',
                    $this->module ? $this->module->get_name() : 'abstraction',
                    $this->get_post_type(),
                ),
                $this->get_args(),
                $this->module
            )
        );

        $taxonomies = $this->get_taxonomies();
        if (is_array($taxonomies) && count($taxonomies)) {
            foreach ($taxonomies as $taxonomy => $args) {
                $args = wp_parse_args((array)$args, array(
                    'public' => true,
                ));
                register_taxonomy($taxonomy, $this->get_post_type(), $args);
            }
        }
    }
}
