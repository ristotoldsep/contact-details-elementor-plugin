<?php
// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

class Custom_Contact_Widget extends \Elementor\Widget_Base {

    // Widget Name
    public function get_name() {
        return 'custom-contact-widget';
    }

    // Widget Title
    public function get_title() {
        return 'Custom Contact Widget';
    }

    // Widget Icon
    public function get_icon() {
        return 'eicon-mail';
    }

    // Widget Categories
    public function get_categories() {
        return ['general'];
    }

    // Widget Controls
    protected function _register_controls() {
        $this->start_controls_section(
            'section_content',
            [
                'label' => __('Content', 'custom-contact-plugin'),
            ]
        );

        $this->add_control(
            'phone_number',
            [
                'label' => __('Phone Number', 'custom-contact-plugin'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => get_option('custom_contact_phone'), // Populate with saved value
            ]
        );

        $this->add_control(
            'email',
            [
                'label' => __('Email', 'custom-contact-plugin'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => get_option('custom_contact_email'), // Populate with saved value
            ]
        );

        $this->end_controls_section();
    }

    // Widget Display
    protected function render() {
        $settings = $this->get_settings_for_display();
        $phone_number = $settings['phone_number'];
        $email = $settings['email'];

        echo '<div class="custom-contact-widget">';
        echo '<p><strong>Phone Number:</strong> ' . $phone_number . '</p>';
        echo '<p><strong>Email:</strong> <a href="mailto:' . $email . '">' . $email . '</a></p>';
        echo '</div>';
    }

}

