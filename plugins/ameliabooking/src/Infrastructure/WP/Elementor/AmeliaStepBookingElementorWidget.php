<?php
/**
 * @copyright © TMS-Plugins. All rights reserved.
 * @licence   See LICENCE.md for license details.
 */

namespace Elementor;

use AmeliaBooking\Infrastructure\WP\GutenbergBlock\GutenbergBlock;
use AmeliaBooking\Infrastructure\WP\Translations\BackendStrings;

/**
 * Class AmeliaStepBookingElementorWidget
 *
 * @package AmeliaBooking\Infrastructure\WP\Elementor
 */
class AmeliaStepBookingElementorWidget extends Widget_Base
{
    protected $controls_data;

    public function get_name() {
        return 'stepbooking';
    }

    public function get_title() {
        return BackendStrings::getWordPressStrings()['step_booking_gutenberg_block']['title'];
    }

    public function get_icon() {
        return 'amelia-logo';
    }

    public function get_categories() {
        return [ 'amelia-elementor' ];
    }

    protected function register_controls() {

        $controls_data = self::amelia_elementor_get_data();

        $this->start_controls_section(
            'amelia_booking_section',
            [
                'label' => '<div class="amelia-elementor-content"><p class="amelia-elementor-content-title">'
                    . BackendStrings::getWordPressStrings()['step_booking_gutenberg_block']['title']
                    . '</p><br><p class="amelia-elementor-content-p">'
                    . BackendStrings::getWordPressStrings()['step_booking_gutenberg_block']['description']
                    . '</p>',
            ]
        );

        $this->add_control(
            'preselect',
            [
                'label' => BackendStrings::getWordPressStrings()['filter'],
                'type' => Controls_Manager::SWITCHER,
                'default' => false,
                'label_on' => BackendStrings::getCommonStrings()['yes'],
                'label_off' => BackendStrings::getCommonStrings()['no'],
            ]
        );

        $this->add_control(
            'select_category',
            [
                'label' => BackendStrings::getWordPressStrings()['select_category'],
                'type' => Controls_Manager::SELECT,
                'options' => $controls_data['categories'],
                'condition' => ['preselect' => 'yes'],
                'default' => '0',
            ]
        );

        $this->add_control(
            'select_service',
            [
                'label' => BackendStrings::getWordPressStrings()['select_service'],
                'type' => Controls_Manager::SELECT,
                'options' => $controls_data['services'],
                'condition' => ['preselect' => 'yes'],
                'default' => '0',
            ]
        );

        $this->add_control(
            'select_employee',
            [
                'label' => BackendStrings::getWordPressStrings()['select_employee'],
                'type' => Controls_Manager::SELECT,
                'options' => $controls_data['employees'],
                'condition' => ['preselect' => 'yes'],
                'default' => '0',
            ]
        );

        $this->add_control(
            'select_location',
            [
                'label' => BackendStrings::getWordPressStrings()['select_location'],
                'type' => Controls_Manager::SELECT,
                'options' => $controls_data['locations'],
                'condition' => ['preselect' => 'yes'],
                'default' => '0',
            ]
        );

        if ($controls_data['show']) {
            $this->add_control(
                'select_package',
                [
                    'label' => BackendStrings::getWordPressStrings()['select_package'],
                    'type' => Controls_Manager::SELECT,
                    'options' => $controls_data['packages'],
                    'condition' => ['preselect' => 'yes'],
                    'default' => '0',
                ]
            );
        }

        if ($controls_data['show']) {
            $this->add_control(
                'select_show',
                [
                    'label' => BackendStrings::getWordPressStrings()['show_all'],
                    'type' => Controls_Manager::SELECT,
                    'options' => $controls_data['show'],
                    'condition' => ['preselect' => 'yes'],
                    'default' => '',
                ]
            );
        }

        $this->add_control(
            'load_manually',
            [
                'label' => BackendStrings::getWordPressStrings()['manually_loading'],
                'label_block' => true,
                'type' => Controls_Manager::TEXT,
                'placeholder' => '',
                'description' => BackendStrings::getWordPressStrings()['manually_loading_description'],
            ]
        );

        $this->add_control(
            'trigger_type',
            [
                'label' => BackendStrings::getWordPressStrings()['trigger_type'],
                'type' => Controls_Manager::SELECT,
                'description' => BackendStrings::getWordPressStrings()['trigger_type_tooltip'],
                'options' => $controls_data['trigger_types'],
                'default' => 'id'
            ]
        );

        $this->add_control(
            'in_dialog',
            [
                'label' => BackendStrings::getWordPressStrings()['in_dialog'],
                'type' => Controls_Manager::SWITCHER,
                'default' => false,
                'label_on' => BackendStrings::getCommonStrings()['yes'],
                'label_off' => BackendStrings::getCommonStrings()['no'],
            ]
        );

        $this->end_controls_section();
    }
    protected function render() {
        $settings = $this->get_settings_for_display();

        $trigger = $settings['load_manually'] !== '' ? ' trigger=' . $settings['load_manually'] : '';
        $trigger_type = $settings['load_manually'] && $settings['trigger_type'] !== '' ? ' trigger_type=' . $settings['trigger_type'] : '';
        $in_dialog = $settings['load_manually'] && $settings['in_dialog'] === 'yes' ? ' in_dialog=1' : '';

        $category = $settings['select_category'] === '0' ? '' : ' category=' . $settings['select_category'];
        $service = $settings['select_service'] === '0' ? '' : ' service=' . $settings['select_service'];
        $category_service = $settings['select_service'] === '0' ? $category : $service;

        $employee = $settings['select_employee'] === '0' ? '' : ' employee=' . $settings['select_employee'];
        $location = $settings['select_location'] === '0' ? '' : ' location=' . $settings['select_location'];
        $package  = empty($settings['select_package']) || $settings['select_package'] === '0' ? '' : ' package=' . $settings['select_package'];

        $show = empty($settings['select_show']) ? '' : ' show=' . $settings['select_show'];

        $shortcode = '[ameliastepbooking' . $trigger . $trigger_type . $in_dialog;
        if ($settings['preselect']) {
            echo $shortcode . $show . $category_service . $employee . $location . $package . ']';
        } else {
            echo $shortcode . ']';
        }
    }


    public static function amelia_elementor_get_data() {
        $data = GutenbergBlock::getEntitiesData()['data'];
        $elementorData = [];

        $elementorData['categories'] = [];
        $elementorData['categories'][0] = BackendStrings::getWordPressStrings()['show_all_categories'];

        foreach ($data['categories'] as $category) {
            $elementorData['categories'][$category['id']] = $category['name'] . ' (id: ' . $category['id'] . ')';
        }

        $elementorData['services'] = [];
        $elementorData['services'][0] = BackendStrings::getWordPressStrings()['show_all_services'];

        foreach ($data['servicesList'] as $service) {
            if ($service) {
                $elementorData['services'][$service['id']] = $service['name'] . ' (id: ' . $service['id'] . ')';
            }
        }

        $elementorData['employees'] = [];
        $elementorData['employees'][0] = BackendStrings::getWordPressStrings()['show_all_employees'];

        foreach ($data['employees'] as $provider) {
            $elementorData['employees'][$provider['id']] = $provider['firstName'] . $provider['lastName'] . ' (id: ' . $provider['id'] . ')';
        }

        $elementorData['locations'] = [];
        $elementorData['locations'][0] = BackendStrings::getWordPressStrings()['show_all_locations'];

        foreach ($data['locations'] as $location) {
            $elementorData['locations'][$location['id']] = $location['name'] . ' (id: ' . $location['id'] . ')';
        }

        $elementorData['packages'] = [];
        $elementorData['packages'][0] = BackendStrings::getWordPressStrings()['show_all_packages'];

        foreach ($data['packages'] as $package) {
            $elementorData['packages'][$package['id']] = $package['name'] . ' (id: ' . $package['id'] . ')';
        }


        $elementorData['show'] = $data['packages'] ? [
            '' => BackendStrings::getWordPressStrings()['show_all'],
            'services' => BackendStrings::getCommonStrings()['services'],
            'packages' => BackendStrings::getCommonStrings()['packages']
        ] : [];

        $elementorData['trigger_types'] = [
            'id' => BackendStrings::getWordPressStrings()['trigger_type_id'],
            'class' => BackendStrings::getWordPressStrings()['trigger_type_class']
        ];

        return $elementorData;
    }
}
