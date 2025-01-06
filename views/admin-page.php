<?php if (!defined('ABSPATH')) exit; ?>

<div class="wrap server-website-info">
    <h1><?php echo esc_html(get_admin_page_title()); ?></h1>

    <div class="swi-intro">
        <p><?php esc_html_e('Welcome to Server & Website Info! This tool provides comprehensive information about your server configuration, WordPress installation, database settings, and active plugins. All information is presented in an easy-to-read format and can be copied to clipboard with a single click.', 'server-website-info'); ?></p>
    </div>

    <div class="swi-grid">
        <!-- Server Information -->
        <div class="swi-card">
            <div class="swi-card-header">
                <h2><span class="dashicons dashicons-desktop"></span><?php esc_html_e('Server Information', 'server-website-info'); ?></h2>
            </div>
            <div class="swi-card-content">
                <div class="swi-info-item">
                    <span class="swi-label"><?php esc_html_e('Operating System', 'server-website-info'); ?></span>
                    <span class="swi-value" data-clipboard><?php echo esc_html($system_info['operating_system']); ?></span>
                </div>
                <div class="swi-info-item">
                    <span class="swi-label"><?php esc_html_e('Server IP', 'server-website-info'); ?></span>
                    <span class="swi-value" data-clipboard><?php echo esc_html($system_info['server_ip']); ?></span>
                </div>
                <div class="swi-info-item">
                    <span class="swi-label"><?php esc_html_e('Server Protocol', 'server-website-info'); ?></span>
                    <span class="swi-value" data-clipboard><?php echo esc_html($system_info['server_protocol']); ?></span>
                </div>
                <div class="swi-info-item">
                    <span class="swi-label"><?php esc_html_e('Server Port', 'server-website-info'); ?></span>
                    <span class="swi-value" data-clipboard><?php echo esc_html($system_info['server_port']); ?></span>
                </div>
                <div class="swi-info-item">
                    <span class="swi-label"><?php esc_html_e('Web Server', 'server-website-info'); ?></span>
                    <span class="swi-value" data-clipboard><?php echo esc_html($system_info['web_server']); ?></span>
                </div>
                <div class="swi-info-item">
                    <span class="swi-label"><?php esc_html_e('PHP Version', 'server-website-info'); ?></span>
                    <span class="swi-value" data-clipboard><?php echo esc_html($system_info['php_version']); ?></span>
                </div>
                <div class="swi-info-item">
                    <span class="swi-label"><?php esc_html_e('PHP Memory Limit', 'server-website-info'); ?></span>
                    <span class="swi-value" data-clipboard><?php echo esc_html($system_info['php_memory_limit']); ?></span>
                </div>
                <div class="swi-info-item">
                    <span class="swi-label"><?php esc_html_e('System Uptime', 'server-website-info'); ?></span>
                    <span class="swi-value" data-clipboard><?php echo esc_html($system_info['system_uptime']); ?></span>
                </div>
            </div>
        </div>

        <!-- Database Information -->
        <div class="swi-card">
            <div class="swi-card-header">
                <h2><span class="dashicons dashicons-database"></span><?php esc_html_e('Database Information', 'server-website-info'); ?></h2>
            </div>
            <div class="swi-card-content">
                <div class="swi-info-item">
                    <span class="swi-label"><?php esc_html_e('Server Version', 'server-website-info'); ?></span>
                    <span class="swi-value" data-clipboard><?php echo esc_html($system_info['db_info']['server_version']); ?></span>
                </div>
                <div class="swi-info-item">
                    <span class="swi-label"><?php esc_html_e('Client Version', 'server-website-info'); ?></span>
                    <span class="swi-value" data-clipboard><?php echo esc_html($system_info['db_info']['client_version']); ?></span>
                </div>
                <div class="swi-info-item">
                    <span class="swi-label"><?php esc_html_e('Database Name', 'server-website-info'); ?></span>
                    <span class="swi-value" data-clipboard><?php echo esc_html($system_info['db_info']['database_name']); ?></span>
                </div>
                <div class="swi-info-item">
                    <span class="swi-label"><?php esc_html_e('Database User', 'server-website-info'); ?></span>
                    <span class="swi-value" data-clipboard><?php echo esc_html($system_info['db_info']['database_user']); ?></span>
                </div>
                <div class="swi-info-item">
                    <span class="swi-label"><?php esc_html_e('Database Host', 'server-website-info'); ?></span>
                    <span class="swi-value" data-clipboard><?php echo esc_html($system_info['db_info']['database_host']); ?></span>
                </div>
                <div class="swi-info-item">
                    <span class="swi-label"><?php esc_html_e('Table Prefix', 'server-website-info'); ?></span>
                    <span class="swi-value" data-clipboard><?php echo esc_html($system_info['db_info']['table_prefix']); ?></span>
                </div>
                <div class="swi-info-item">
                    <span class="swi-label"><?php esc_html_e('Database Charset', 'server-website-info'); ?></span>
                    <span class="swi-value" data-clipboard><?php echo esc_html($system_info['db_info']['database_charset']); ?></span>
                </div>
                <div class="swi-info-item">
                    <span class="swi-label"><?php esc_html_e('Database Collation', 'server-website-info'); ?></span>
                    <span class="swi-value" data-clipboard><?php echo esc_html($system_info['db_info']['database_collate']); ?></span>
                </div>
            </div>
        </div>

        <!-- WordPress Information -->
        <div class="swi-card">
            <div class="swi-card-header">
                <h2><span class="dashicons dashicons-wordpress"></span><?php esc_html_e('WordPress Information', 'server-website-info'); ?></h2>
            </div>
            <div class="swi-card-content">
                <div class="swi-info-item">
                    <span class="swi-label"><?php esc_html_e('WordPress Version', 'server-website-info'); ?></span>
                    <span class="swi-value" data-clipboard><?php echo esc_html($system_info['wp_version']); ?></span>
                </div>
                <div class="swi-info-item">
                    <span class="swi-label"><?php esc_html_e('Active Theme', 'server-website-info'); ?></span>
                    <span class="swi-value" data-clipboard><?php echo esc_html($system_info['active_theme']); ?></span>
                </div>
                <div class="swi-info-item">
                    <span class="swi-label"><?php esc_html_e('Debug Mode', 'server-website-info'); ?></span>
                    <span class="swi-value" data-clipboard><?php echo esc_html($system_info['debug_mode']); ?></span>
                </div>
            </div>
        </div>
    </div>
</div>
