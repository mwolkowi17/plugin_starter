<?php
/* Plugin name: WordPress Extra Post 
Info Plugin URI: https://example.com/wordpress-extra-post-info 
Description: A simple plugin to add extra info to posts. 
Author: Jacob Nicholson Author 
URI: https://InMotionHosting.com 
Version: 0.5 */


if (!function_exists("extra_post_info")) {
    function extra_post_info($content)
    {
        $extra_info = get_option('extra_post_info');;
        return $content . $extra_info;
    }
    add_filter('the_content', 'extra_post_info');
}

if (!function_exists("extra_post_info_menu")) {
    add_action('admin_menu', 'extra_post_info_menu');
    function extra_post_info_menu()
    {
        $page_title = 'WordPress Extra Post Info';
        $menu_title = 'Extra Post Info';
        $capability = 'manage_options';
        $menu_slug  = 'extra-post-info';
        $function   = 'extra_post_info_page';
        $icon_url   = 'dashicons-media-code';
        $position   = 4;

        add_menu_page($page_title, $menu_title, $capability, $menu_slug, $function, $icon_url, $position);
        add_action('admin_init', 'update_extra_post_info');
        if (!function_exists("update_extra_post_info")) {
            function update_extra_post_info()
            {
                register_setting('extra-post-info-settings', 'extra_post_info');
            }
        }
    }
}

if (!function_exists("extra_post_info_page")) {
    function extra_post_info_page()
    { ?> <h1>WordPress Extra Post Info</h1>
        <form method="post" action="options.php">
            <?php settings_fields('extra-post-info-settings'); ?>
            <?php do_settings_sections('extra-post-info-settings'); ?>
            <table class="form-table">
                <tr valign="top">
                    <th scope="row">Extra post info:</th>
                    <td><input type="text" name="extra_post_info" value="<?php echo get_option('extra_post_info'); ?>" /></td>
                </tr>
            </table>
            <?php submit_button(); ?>
        </form>
<?php }
}
