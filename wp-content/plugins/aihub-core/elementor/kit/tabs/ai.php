<?php

use Elementor\Controls_Manager;
use Elementor\Core\Kits\Documents\Kit;
use Elementor\Core\Kits\Documents\Tabs\Tab_Base;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Liquid_Global_AI extends Tab_Base {

	public function __construct( $parent ) {
		parent::__construct( $parent );

		Controls_Manager::add_tab( $this->get_id(), $this->get_title() );
	}

	public function get_id() {
		return 'liquid-ai-kit';
	}

	public function get_title() {
		return __( 'Liquid AI', 'aihub-core' );
	}

	public function get_group() {
		return 'settings';
	}

	public function get_icon() {
		return 'eicon-ai';
	}

	public function get_help_url() {
		return 'https://docs.liquid-themes.com/';
	}

	protected function register_tab_controls() {

		$this->start_controls_section(
			'section_' . $this->get_id() . '_general',
			[
				'label' => esc_html__('Liquid AI', 'aihub-core'),
				'tab' => $this->get_id(),
			]
		);

		$this->add_control(
			'liquid_ai',
			[
				'label' => esc_html__( 'Enable Liquid AI', 'aihub-core' ),
				'description' => esc_html__( 'Enable the Power of AI with Liquid AI: Enhance Your ChatGPT Experience to New Heights.', 'aihub-core' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => esc_html__( 'On', 'aihub-core' ),
				'label_off' => esc_html__( 'Off', 'aihub-core' ),
				'return_value' => 'yes',
			]
		);

		$this->add_control(
			'liquid_ai_api_key',
			[
				'label' => esc_html__( 'OpenAI API Key', 'aihub-core' ),
				'description' => wp_kses_post( sprintf( '%s <a href="https://platform.openai.com/account/api-keys" target="_blank">https://platform.openai.com/account/api-keys</a>', __( 'You can find your API key at', 'aihub-core' ) ) ),
				'type' => Controls_Manager::TEXT,
				'label_block' => true,
				'ai' => [
					'active' => false,
				],
				'condition' => [
					'liquid_ai' => 'yes'
				]
			]
		);

		$this->add_control(
			'liquid_ai_api_key_unsplash',
			[
				'label' => esc_html__( 'Unsplash API Key', 'aihub-core' ),
				'description' => wp_kses_post( sprintf( '%s <a href="https://unsplash.com/oauth/applications" target="_blank">https://unsplash.com/oauth/applications</a>', __( 'You can find your API key at', 'aihub-core' ) ) ),
				'type' => Controls_Manager::TEXT,
				'label_block' => true,
				'ai' => [
					'active' => false,
				],
				'condition' => [
					'liquid_ai' => 'yes'
				]
			]
		);

		$this->add_control(
			'liquid_ai_model',
			[
				'label' => esc_html__( 'Model', 'aihub-core' ),
				'description' => wp_kses_post( sprintf( 'GPT models can understand and generate natural language. <a href="https://platform.openai.com/docs/models" target="_blank">%s</a>', __( 'More info', 'aihub-core' ) ) ),
				'type' => Controls_Manager::SELECT,
				'label_block' => true,
				'default' => 'solid',
				'options' => [
					'gpt-4-vision-preview' => esc_html__( 'gpt-4-vision-preview', 'aihub-core' ),
					'gpt-4-32k-0613' => esc_html__( 'gpt-4-32k-0613', 'aihub-core' ),
					'gpt-4-0613' => esc_html__( 'gpt-4-0613', 'aihub-core' ),
					'gpt-4-32k' => esc_html__( 'gpt-4-32k', 'aihub-core' ),
					'gpt-4' => esc_html__( 'gpt-4', 'aihub-core' ),
					'gpt-3.5-turbo-1106' => esc_html__( 'gpt-3.5-turbo-1106', 'aihub-core' ),
					'gpt-3.5-turbo' => esc_html__( 'gpt-3.5-turbo', 'aihub-core' ),
					'gpt-3.5-turbo-instruct' => esc_html__( 'gpt-3.5-turbo-instruct (Similar capabilities as text-davinci-003)', 'aihub-core' ),
					'text-davinci-003' => esc_html__( 'text-davinci-003', 'aihub-core' ),
					'text-curie-001' => esc_html__( 'text-curie-001', 'aihub-core' ),
					'text-babbage-001' => esc_html__( 'text-babbage-001', 'aihub-core' ),
					'text-ada-001' => esc_html__( 'text-ada-001', 'aihub-core' ),
				],
				'default' => 'text-davinci-003',
				'condition' => [
					'liquid_ai' => 'yes'
				]
			]
		);

		$this->add_control(
			'liquid_ai_image_model',
			[
				'label' => esc_html__( 'Image Model', 'aihub-core' ),
				'description' => wp_kses_post( sprintf( 'GPT models can understand and generate natural language. <a href="https://platform.openai.com/docs/models/dall-e" target="_blank">%s</a>', __( 'More info', 'aihub-core' ) ) ),
				'type' => Controls_Manager::SELECT,
				'label_block' => true,
				'default' => 'solid',
				'options' => [
					'dall-e-2' => esc_html__( 'dall-e-2', 'aihub-core' ),
					'dall-e-3' => esc_html__( 'dall-e-3', 'aihub-core' ),
				],
				'default' => 'dall-e-3',
				'condition' => [
					'liquid_ai' => 'yes'
				]
			]
		);

		$this->add_control(
			'liquid_ai_max_tokens',
			[
				'label' => esc_html__( 'Max Tokens', 'aihub-core' ),
				'description' => esc_html__( 'Limits the maximum number of tokens a language model can process at once in OpenAI', 'aihub-core' ),
				'type' => Controls_Manager::TEXT,
				'label_block' => true,
				'default' => '2048',
				'placeholder' => '2048',
				'ai' => [
					'active' => false,
				],
				'condition' => [
					'liquid_ai' => 'yes'
				]
			]
		);

		$this->add_control(
			'liquid_ai_api_key_sd',
			[
				'label' => esc_html__( 'Stable Diffusion API Key', 'aihub-core' ),
				'description' => wp_kses_post( sprintf( '%s <a href="https://stablediffusionapi.com/" target="_blank">https://stablediffusionapi.com/</a>', __( 'You can find your API key at', 'aihub-core' ) ) ),
				'type' => Controls_Manager::TEXT,
				'label_block' => true,
				'ai' => [
					'active' => false,
				],
				'condition' => [
					'liquid_ai' => 'yes'
				],
				'separator' => 'before'
			]
		);

		$this->end_controls_section();

	}

}

new Liquid_Global_AI( Kit::class );

add_action(
	'elementor/kit/register_tabs',
	function( $kit ) {
		$kit->register_tab( 'liquid-ai-kit', Liquid_Global_AI::class );
	}
);
