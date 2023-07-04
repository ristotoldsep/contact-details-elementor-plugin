<?php
/*
Plugin Name: Custom Contact
Plugin URI: https://your-plugin-website.com/
Description: A custom plugin for adding contact details by ristotoldsep.
Version: 1.0
Author: Risto Tõldsep
Author URI: https://your-website.com/
License: GPL2
*/

// Register the option page
function custom_contact_plugin_menu() {
    add_options_page(
        'Custom Contact Settings',
        'Custom Contact',
        'manage_options',
        'custom-contact-settings',
        'custom_contact_plugin_options_page'
    );
}
add_action('admin_menu', 'custom_contact_plugin_menu');

// Display the option page
function custom_contact_plugin_options_page() {
    if (!current_user_can('manage_options')) {
        wp_die('You do not have sufficient permissions to access this page.');
    }
    
    // Save the form data if submitted
    if (isset($_POST['custom_contact_submit'])) {
        $phone_number = sanitize_text_field($_POST['custom_contact_phone']);
        $email = sanitize_email($_POST['custom_contact_email']);
        update_option('custom_contact_phone', $phone_number);
        update_option('custom_contact_email', $email);
        echo '<div class="updated"><p>Contact details saved successfully!</p></div>';
    }
    
    // Retrieve the saved values
    $phone_number = get_option('custom_contact_phone');
    $email = get_option('custom_contact_email');
    
    // Display the option page HTML
    ?>
    <div class="wrap">
        <h1>Custom Contact Settings</h1>
        <form method="post" action="">
            <table class="form-table">
                <tr valign="top">
                    <th scope="row">Phone Number:</th>
                    <td><input type="text" name="custom_contact_phone" value="<?php echo esc_attr($phone_number); ?>"></td>
                </tr>
                <tr valign="top">
                    <th scope="row">Email:</th>
                    <td><input type="email" name="custom_contact_email" value="<?php echo esc_attr($email); ?>"></td>
                </tr>
            </table>
            <p class="submit">
                <input type="submit" name="custom_contact_submit" class="button-primary" value="Save Changes">
            </p>
        </form>
    </div>
    <?php
}

// Define the phone number shortcode
function custom_contact_phone_shortcode() {
    $phone_number = get_option('custom_contact_phone');
    return $phone_number;
}
add_shortcode('custom_contact_phone', 'custom_contact_phone_shortcode');

// Define the email shortcode
function custom_contact_email_shortcode() {
    $email = get_option('custom_contact_email');
    return '<a href="mailto:' . $email . '">' . $email . '</a>';
}
add_shortcode('custom_contact_email', 'custom_contact_email_shortcode');

// Register the Elementor widget
function custom_contact_register_widget() {
    if (class_exists('\Elementor\Widget_Base')) {
        require_once(plugin_dir_path(__FILE__) . 'widgets/custom-contact-widget.php');
        \Elementor\Plugin::instance()->widgets_manager->register_widget_type(new Custom_Contact_Widget());
    }
}
add_action('elementor/widgets/widgets_registered', 'custom_contact_register_widget');
