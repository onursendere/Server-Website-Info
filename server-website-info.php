<?php
/**
 * Plugin Name: Server & Website Info
 * Plugin URI: 
 * Description: A modern, minimalist WordPress plugin that provides comprehensive information about your server and WordPress installation in a beautiful, user-friendly interface.
 * Version: 1.0.0
 * Requires at least: 5.0
 * Requires PHP: 7.2
 * Author: Onur Şendere
 * Author URI: https://onursendere.com
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: server-website-info
 * Domain Path: /languages
 */

if (!defined('ABSPATH')) {
    exit;
}

class ServerWebsiteInfo {
    private static $instance = null;

    public static function getInstance() {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __construct() {
        add_action('plugins_loaded', array($this, 'load_plugin_textdomain'));
        add_action('admin_menu', array($this, 'add_admin_menu'));
        add_action('admin_enqueue_scripts', array($this, 'enqueue_admin_assets'));
    }

    public function load_plugin_textdomain() {
        load_plugin_textdomain(
            'server-website-info',
            false,
            dirname(plugin_basename(__FILE__)) . '/languages/'
        );
    }

    public function add_admin_menu() {
        add_menu_page(
            __('Server & Website Info', 'server-website-info'),
            __('Server & Website Info', 'server-website-info'),
            'manage_options',
            'server-website-info',
            array($this, 'render_admin_page'),
            'dashicons-info',
            100
        );
    }

    public function enqueue_admin_assets($hook) {
        if ('toplevel_page_server-website-info' !== $hook) {
            return;
        }

        wp_enqueue_style(
            'server-website-info-admin',
            plugins_url('assets/css/admin.css', __FILE__),
            array(),
            '1.0.0'
        );

        wp_enqueue_script(
            'server-website-info-admin',
            plugins_url('assets/js/admin.js', __FILE__),
            array('jquery'),
            '1.0.0',
            true
        );

        wp_localize_script('server-website-info-admin', 'serverWebsiteInfo', array(
            'copied' => __('Copied!', 'server-website-info'),
            'copyToClipboard' => __('Copy to clipboard', 'server-website-info')
        ));
    }

    public function render_admin_page() {
        try {
            $system_info = $this->get_system_info();

            include plugin_dir_path(__FILE__) . 'views/admin-page.php';
        } catch (Exception $e) {
            echo '<div class="notice notice-error"><p>' . 
                 esc_html__('An error occurred while gathering server information. Please try again later or contact support if the problem persists.', 'server-website-info') . 
                 '</p></div>';
        }
    }

    private function get_system_info() {
        global $wpdb;

        return array(
            'operating_system' => php_uname(),
            'server_ip' => isset($_SERVER['SERVER_ADDR']) ? sanitize_text_field(wp_unslash($_SERVER['SERVER_ADDR'])) : '',
            'server_protocol' => isset($_SERVER['SERVER_PROTOCOL']) ? sanitize_text_field(wp_unslash($_SERVER['SERVER_PROTOCOL'])) : '',
            'server_port' => isset($_SERVER['SERVER_PORT']) ? sanitize_text_field(wp_unslash($_SERVER['SERVER_PORT'])) : '',
            'web_server' => isset($_SERVER['SERVER_SOFTWARE']) ? sanitize_text_field(wp_unslash($_SERVER['SERVER_SOFTWARE'])) : '',
            'php_version' => phpversion() . (PHP_INT_SIZE == 8 ? ' (Supports 64bit values)' : ''),
            'php_memory_limit' => ini_get('memory_limit'),
            'system_uptime' => $this->get_system_uptime(),
            'wp_version' => get_bloginfo('version'),
            'active_theme' => $this->get_active_theme(),
            'debug_mode' => WP_DEBUG ? __('Enabled', 'server-website-info') : __('Disabled', 'server-website-info'),
            'db_info' => $this->get_db_info()
        );
    }

    private function get_db_info() {
        global $wpdb;
        
        // Cache key for database information
        $cache_key = 'swi_database_info';
        
        // Try to get cached database info
        $db_info = wp_cache_get($cache_key);
        
        if (false === $db_info) {
            // Get server version using WordPress methods
            $server_version = $wpdb->db_version();
            
            $db_info = array(
                'server_version' => $server_version,
                'client_version' => $wpdb->db_version(),
                'database_name' => $wpdb->dbname,
                'database_user' => $wpdb->dbuser,
                'database_host' => $wpdb->dbhost,
                'table_prefix' => $wpdb->prefix,
                'database_charset' => $wpdb->charset,
                'database_collate' => $wpdb->collate
            );
            
            // Cache the database info for 1 hour
            wp_cache_set($cache_key, $db_info, '', HOUR_IN_SECONDS);
        }
        
        return $db_info;
    }

    private function get_system_uptime() {
        if (!function_exists('shell_exec')) {
            return __('Not available', 'server-website-info');
        }

        $uptime = @shell_exec('uptime');
        if (empty($uptime)) {
            return __('Not available', 'server-website-info');
        }

        return sanitize_text_field($uptime);
    }

    private function get_active_plugins() {
        $active_plugins = array();
        $plugins = get_option('active_plugins');

        if (empty($plugins)) {
            return array(__('No active plugins found', 'server-website-info'));
        }

        if (!function_exists('get_plugin_data')) {
            require_once(ABSPATH . 'wp-admin/includes/plugin.php');
        }

        foreach ($plugins as $plugin) {
            if (file_exists(WP_PLUGIN_DIR . '/' . $plugin)) {
                $plugin_data = get_plugin_data(WP_PLUGIN_DIR . '/' . $plugin);
                if (!empty($plugin_data['Name'])) {
                    $plugin_info = $plugin_data['Name'];
                    if (!empty($plugin_data['Version'])) {
                        $plugin_info .= ' (v' . $plugin_data['Version'] . ')';
                    }
                    if (!empty($plugin_data['Author'])) {
                        $plugin_info .= ' by ' . wp_strip_all_tags($plugin_data['Author']);
                    }
                    $active_plugins[] = $plugin_info;
                }
            }
        }

        return !empty($active_plugins) ? $active_plugins : array(__('No active plugins found', 'server-website-info'));
    }

    private function get_active_theme() {
        $theme = wp_get_theme();
        return sprintf('%s (%s)', $theme->get('Name'), $theme->get('Version'));
    }
}

// Initialize the plugin
ServerWebsiteInfo::getInstance();
