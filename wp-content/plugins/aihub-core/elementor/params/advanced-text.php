<?php

use Elementor\Controls_Manager;
use Elementor\Repeater;

defined( 'ABSPATH' ) || die();

function lqd_elementor_add_advanced_text_controls( $prefix, $condition = '' ){

    $prefix->add_control(
        'advanced_text_enable',
        [
            'label' => esc_html__( 'Enable the advanced text?', 'aihub-core' ),
            'type' => Controls_Manager::SWITCHER,
            'label_on' => esc_html__( 'On', 'aihub-core' ),
            'label_off' => esc_html__( 'Off', 'aihub-core' ),
            'return_value' => 'yes',
            'default' => '',
        ]
    );

    $repeater_advanced_text = new Repeater();

    $repeater_advanced_text->add_control(
        'text', [
            'label' => esc_html__( 'Title', 'aihub-core' ),
            'type' => Controls_Manager::TEXT,
            'default' => esc_html__( 'Title' , 'aihub-core' ),
            'label_block' => true,
        ]
    );

    $repeater_advanced_text->add_control(
        'image',
        [
            'label' => esc_html__( 'Choose Image', 'aihub-core' ),
            'type' => Controls_Manager::MEDIA,
        ]
    );

    $repeater_advanced_text->add_responsive_control(
        'img_width',
        [
            'label' => esc_html__( 'Width', 'aihub-core' ),
            'type' => Controls_Manager::SLIDER,
            'size_units' => [ 'px', 'vw' ],
            'range' => [
                'px' => [
                    'min' => 1,
                    'max' => 1000,
                ],
                'vw' => [
                    'min' => 1,
                    'max' => 100,
                ],
            ],
            'selectors' => [
                '{{WRAPPER}} {{CURRENT_ITEM}} img' => 'width: {{SIZE}}{{UNIT}};',
            ],
            'condition' => [
                'image[url]!' => ''
            ]
        ]
    );

    $repeater_advanced_text->add_control(
        'image_align',
        [
            'label' => esc_html__( 'Image placement', 'aihub-core' ),
            'type' => Controls_Manager::CHOOSE,
            'options' => [
                'left' => [
                    'title' => esc_html__( 'Left', 'aihub-core' ),
                    'icon' => 'eicon-h-align-left',
                ],
                'right' => [
                    'title' => esc_html__( 'Right', 'aihub-core' ),
                    'icon' => 'eicon-h-align-right',
                ],
            ],
            'default' => 'left',
            'toggle' => false,
            'condition' => [
                'image[url]!' => ''
            ]
        ]
    );

    $repeater_advanced_text->add_control(
        'image_v_align',
        [
            'label' => esc_html__( 'Vertical align', 'aihub-core' ),
            'type' => Controls_Manager::SELECT,
            'options' => [
                'baseline' => 'Baseline',
                'sub' => 'Subscript',
                'sup' => 'Superscript',
                'top' => 'Top',
                'text-top' => 'Text top',
                'middle' => 'Middle',
                'bottom' => 'Bottom',
                'text-bottom' => 'Text bottom',
            ],
            'default' => 'bottom',
            'selectors' => [
                '{{WRAPPER}} {{CURRENT_ITEM}} figure' => 'vertical-align: {{VALUE}};',
            ],
            'condition' => [
                'image[url]!' => ''
            ]
        ]
    );


    $repeater_advanced_text->add_responsive_control(
        'border',
        [
            'label' => esc_html__( 'Border', 'aihub-core' ),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => [ 'px', '%', 'em' ],
            'selectors' => [
                '{{WRAPPER}} {{CURRENT_ITEM}} img' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};border-style: solid;',
            ],
            'condition' => [
                'image[url]!' => ''
            ]
        ]
    );

    $repeater_advanced_text->add_responsive_control(
        'border_radius',
        [
            'label' => esc_html__( 'Border Radius', 'aihub-core' ),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => [ 'px', '%', 'em' ],
            'selectors' => [
                '{{WRAPPER}} {{CURRENT_ITEM}} img, {{WRAPPER}} {{CURRENT_ITEM}} figure' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
            'condition' => [
                'image[url]!' => ''
            ]
        ]
    );

    $repeater_advanced_text->add_control(
        'border_color',
        [
            'label' => esc_html__( 'Border Color', 'aihub-core' ),
            'type' => Controls_Manager::COLOR,
            'selectors' => [
                '{{WRAPPER}} {{CURRENT_ITEM}} img' => 'border-color: {{VALUE}}',
            ],
            'condition' => [
                'image[url]!' => ''
            ]
        ]
    );

    $repeater_advanced_text->add_responsive_control(
        'margin',
        [
            'label' => esc_html__( 'Margin', 'aihub-core' ),
            'type' => Controls_Manager::DIMENSIONS,
            'size_units' => [ 'px', '%', 'em' ],
            'selectors' => [
                '{{WRAPPER}} {{CURRENT_ITEM}} figure' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            ],
            'condition' => [
                'image[url]!' => ''
            ]
        ]
    );


    $repeater_advanced_text->add_responsive_control(
        'item_z_index',
        [
            'label' => esc_html__( 'Z-Index', 'aihub-core' ),
            'type' => Controls_Manager::NUMBER,
            'selectors' => [
                '{{WRAPPER}} {{CURRENT_ITEM}}' => 'position: relative; z-index: {{VALUE}};',
            ],
            'condition' => [
                'image[url]!' => ''
            ]
        ]
    );

    $prefix->add_control(
        'advanced_text_content',
        [
            'label' => esc_html__( 'Items', 'aihub-core' ),
            'type' => Controls_Manager::REPEATER,
            'fields' => $repeater_advanced_text->get_controls(),
            'default' => [
                [
                    'text' => esc_html__( 'Title #1', 'aihub-core' ),
                ],
                [
                    'text' => esc_html__( 'Title #2', 'aihub-core' ),
                ],
            ],
            'title_field' => '{{{ text }}}',
            'condition' => [
                'advanced_text_enable' => 'yes'
            ]
        ]
    );

}

function lqd_elementor_get_advanced_text_controls( $widget ){

    $items = $widget->get_settings_for_display('advanced_text_content');
    $content = '';

    if ( $items ){
        foreach( $items as $item ){

            $content .= sprintf( '<span class="lqd-adv-txt-item elementor-repeater-item-%s">', $item['_id'] );

            if ( !empty($item['image']['url']) ){
                $img_html = '<figure class="lqd-adv-txt-fig relative d-inline-flex">' . wp_get_attachment_image( $item['image']['id'], 'full', false ) . '</figure>';
                $content = $item['image_align'] === 'left' ? $content . $img_html . $item['text'] : $content . $item['text'] . $img_html;
            } else {
                $content .= $item['text'];
            }

            $content .= "</span>";

        }
    }

    return $content;

}