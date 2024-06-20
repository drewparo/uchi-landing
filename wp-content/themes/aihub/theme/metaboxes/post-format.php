<?php

if( !defined( 'ABSPATH' ) ) 
	exit; // Exit if accessed directly

// How to use: $meta_value = get_post_meta( $post_id, $field_id, true );
// Example: get_post_meta( get_the_ID(), "my_metabox_field", true );

class Liquid_PostFormat_Metabox {
    private $screens = array('post');

    private $fields = array(
      // audio
      array(
        'label' => 'Audio URL',
        'description' => 'Audio file URL in format: mp3, ogg, wav.',
        'id' => 'post-audio',
        'type' => 'url',
      ),
      // url
      array(
        'label' => 'URL',
        'description' => 'Enter the URL',
        'id' => 'post-link-url',
        'type' => 'url',
      ),
      // quote
      array(
        'label' => 'Cite',
        'description' => 'Define the title of a work with the cite tag:',
        'id' => 'post-quote-url',
        'type' => 'text',
      ),
      // video 
      array(
        'label' => 'Video URL',
        'description' => 'YouTube or Vimeo video URL',
        'id' => 'post-video-url',
        'type' => 'url',
      ),
      array(
        'label' => 'Video Upload',
        'description' => 'Upload video file',
        'id' => 'post-video-file',
        'type' => 'wysiwyg',
      ),
    );
  
    public function __construct() {
      add_action( 'add_meta_boxes', array( $this, 'add_meta_boxes' ) );
      add_action( 'save_post', array( $this, 'save_fields' ) );
  
      add_action( 'admin_footer', function(){
        ?>
          <script>
            jQuery( document ).ready( function($){
                  // Starts by hiding the meta box and inputs
                  
                  //$( "#LiquidPostMeta" ).addClass( "hidden" );

                  //$( 'label[for=post-audio]' ).parent().parent().hide();
                  //$( 'label[for=post-link-url]' ).parent().parent().hide();

                  // Hide metabox if post format is not standard
                  $( 'input[name="post_format"]' ).bind( 'load change', function() {
                    var val = $(this).val();

                    console.log(val);
                    if( '0' != val ) {
                      $( "#LiquidPostMeta" ).removeClass( "hidden" );


                      // show input for post format
                      switch (val){
                        case 'audio':
                            $( 'label[for=post-audio]' ).parent().parent().show();
                            $( 'label[for=post-link-url]' ).parent().parent().hide();
                            $( 'label[for=post-quote-url]' ).parent().parent().hide();
                            $( 'label[for=post-video-url]' ).parent().parent().hide();
                            $( 'label[for=post-video-file]' ).parent().parent().hide();
                          break;
                        case 'link':
                          $( 'label[for=post-link-url]' ).parent().parent().show();
                          $( 'label[for=post-audio]' ).parent().parent().hide();
                          $( 'label[for=post-quote-url]' ).parent().parent().hide();
                          $( 'label[for=post-video-url]' ).parent().parent().hide();
                          $( 'label[for=post-video-file]' ).parent().parent().hide();
                          break;
                        case 'quote':
                          $( 'label[for=post-quote-url]' ).parent().parent().show();
                          $( 'label[for=post-link-url]' ).parent().parent().hide();
                          $( 'label[for=post-audio]' ).parent().parent().hide();
                          $( 'label[for=post-video-url]' ).parent().parent().hide();
                          $( 'label[for=post-video-file]' ).parent().parent().hide();
                          break;
                        case 'video':
                          $( 'label[for=post-video-url]' ).parent().parent().show();
                          $( 'label[for=post-video-file]' ).parent().parent().show();
                          $( 'label[for=post-quote-url]' ).parent().parent().hide();
                          $( 'label[for=post-link-url]' ).parent().parent().hide();
                          $( 'label[for=post-audio]' ).parent().parent().hide();
                          break;
                      }
                    } else {
                      $( "#LiquidPostMeta" ).addClass( "hidden" );
                    }
                  });
            
              }
          );
          </script>
        <?php
      } );
    }
  
    public function add_meta_boxes() {
      foreach ( $this->screens as $s ) {
        add_meta_box(
          'LiquidPostMeta',
          __( 'Liquid Post Format Options', 'aihub' ),
          array( $this, 'meta_box_callback' ),
          $s,
          'normal',
				  'high'
        );
      }
    }
  
    public function meta_box_callback( $post ) {
      wp_nonce_field( 'LiquidPostMeta_data', 'LiquidPostMeta_nonce' ); 
      $this->field_generator( $post );
    }
  
    public function field_generator( $post ) {
      foreach ( $this->fields as $field ) {
        $label = '<label for="' . $field['id'] . '">' . $field['label'] . '</label>';
        $description = isset( $field['description'] ) ? $field['description'] : '';
        $meta_value = get_post_meta( $post->ID, $field['id'], true );
  
        if ( empty( $meta_value ) ) {
          if ( isset( $field['default'] ) ) {
            $meta_value = $field['default'];
          }
        }
  
        switch ( $field['type'] ) {
          case 'select':
          $input = sprintf(
            '<select id="%s" name="%s">',
            $field['id'],
            $field['id']
          );
          foreach ( $field['options'] as $key => $value ) {
            $field_value = strval($key);
            $input .= sprintf(
              '<option %s value="%s">%s</option>',
              $meta_value === $field_value ? 'selected' : '',
              $field_value,
              $value
            );
          }
          $input .= '</select>';
          break;
  
          case 'pages':
            $pagesargs = array(
              'selected' => $meta_value,
              'echo' => 0,
              'name' => $field['id'],
              'id' => $field['id'],
              'post_type' => $field['post_type'],
              'show_option_none' => 'Select a template',
            );
            
            $input = wp_dropdown_pages($pagesargs);
            break;

          case 'wysiwyg':
            ob_start();
            wp_editor($meta_value, $field['id'], array( 'media_buttons' => true ) );
            $input = ob_get_contents();
            ob_end_clean();
            break;
    
          default:
            $input = sprintf(
            '<input %s id="%s" name="%s" type="%s" value="%s">',
            $field['type'] !== 'color' ? 'style="width: 100%"' : '',
            $field['id'],
            $field['id'],
            $field['type'],
            $meta_value
          );
        }
        $this->format_rows( $label, $description, $input );
      }
    }
  
    public function format_rows( $label, $description, $input ) {
      printf( '
      <div style="margin-top: 10px;">
        <strong>%s</strong>
        <p>%s</p>
        <div>%s</div>
      </div>',
      $label, $description, $input );
    }  
  
    public function save_fields( $post_id ) {
      if ( !isset( $_POST['LiquidPostMeta_nonce'] ) ) {
        return $post_id;
      }
      $nonce = $_POST['LiquidPostMeta_nonce'];
      if ( !wp_verify_nonce( $nonce, 'LiquidPostMeta_data' ) ) {
        return $post_id;
      }
      if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return $post_id;
      }
      foreach ( $this->fields as $field ) {
        if ( isset( $_POST[ $field['id'] ] ) ) {
          switch ( $field['type'] ) {
            case 'email':
              $_POST[ $field['id'] ] = sanitize_email( $_POST[ $field['id'] ] );
              break;
            case 'text':
              $_POST[ $field['id'] ] = sanitize_text_field( $_POST[ $field['id'] ] );
              break;
          }
          update_post_meta( $post_id, $field['id'], $_POST[ $field['id'] ] );
        } else if ( $field['type'] === 'checkbox' ) {
          update_post_meta( $post_id, $field['id'], '0' );
        }
      }
    }

}

if ( class_exists('Liquid_PostFormat_Metabox') ) {
    new Liquid_PostFormat_Metabox;
};