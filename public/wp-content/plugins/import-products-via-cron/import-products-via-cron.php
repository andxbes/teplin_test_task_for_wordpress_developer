<?php
/*
Plugin Name: Import products via cron
Plugin URI: 
Description: 
Version: 1 
Requires PHP: 8.0.0
Author: 
Author URI: 
License: GPLv2 or later
Text Domain: 
*/

namespace IPVC;

define('IPVC__FILE__', __FILE__);


class ImportProductsViaCron
{
    const EVENT_NAME = 'import_products_via_cron';
    public function __construct()
    {
        add_action(self::EVENT_NAME, [$this, 'run_import_process']);

        register_activation_hook(IPVC__FILE__, [$this, 'register_cron']);
        register_deactivation_hook(IPVC__FILE__, [$this, 'deactivation_cron']);
    }


    public function run_import_process()
    {
        require_once("worker.php");
        if (class_exists('\IPVC\Worker')) {
            error_log('run process');
            new \IPVC\Worker();
        }
    }
    public function register_cron()
    {
        if (!wp_next_scheduled(self::EVENT_NAME)) {
            wp_schedule_event(time(), 'daily', self::EVENT_NAME);
        }
    }
    public function deactivation_cron()
    {
        if (wp_next_scheduled(self::EVENT_NAME)) {
            wp_clear_scheduled_hook(self::EVENT_NAME);
        }
    }
}

new \IPVC\ImportProductsViaCron();
