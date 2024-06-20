<?php

defined( 'ABSPATH' ) || die();

class LQD_Elementor_Render_Background {

	/**
	 * Thanks to https://github.com/vibbio/css-gradient-angle-to-svg-gradient-coordinates
	 */
	function angleToCoordinates( $angleInDegrees, $sizeOfSquare = 1 ) {

		$constrainedAngle = $angleInDegrees % 360;

		if ( $constrainedAngle < 0 ) $constrainedAngle += 360;

		$angleBetween0and45deg = $constrainedAngle % 45;
		$angle45InRadians = pi() / 180 * $angleBetween0and45deg;

		$delta = 1 / cos($angle45InRadians) * sin($angle45InRadians);

		$angleUnder180 = $constrainedAngle % 180;

		$xBase = $delta;
		$yBase = 1;

		$x1;
		$y1;

		if ( $angleUnder180 < 45 ) {
			$x1 = $xBase;
			$y1 = $yBase;
		} else if ( $angleUnder180 < 90 ) {
			$x1 = $yBase;
			$y1 = 1 - $xBase;
		} else if ( $angleUnder180 < 135 ) {
			$x1 = $yBase;
			$y1 = -$xBase;
		} else if ( $angleUnder180 < 180 ) {
			$x1 = 1 - $xBase;
			$y1 = -$yBase;
		}

		if ( $constrainedAngle < 180 ) {
			$x1 = -$x1;
			$y1 = -$y1;
		}

		$x2 = -$x1;
		$y2 = -$y1;

		$x1 = ($x1 + 1) / 2 * $sizeOfSquare;
		$y1 = (-$y1 + 1) / 2 * $sizeOfSquare;
		$x2 = ($x2 + 1) / 2 * $sizeOfSquare;
		$y2 = (-$y2 + 1) / 2 * $sizeOfSquare;

		return [
			'x1' => $x1,
			'y1' => $y1,
			'x2' => $x2,
			'y2' => $y2
		];

	}

	function get_wrapper_base_classnames( $widget, $item, $i = 0, $type = 'color', $layers_class = '' ) {

		if ( ! $item ) return [];

		$classnames = [
			'lqd-bg-layer',
			'lqd-' . $type . '-wrap',
			'lqd-bg-' . $type . '-wrap',
			'block',
			'w-full',
			'h-full',
			'rounded-inherit',
			'overflow-hidden',
			'elementor-repeater-item-' . $item['_id'] . '-' . $widget->get_id()
		];

		if ( !empty( $layers_class ) ) {
			$classnames[] = 'lqd-bg-layer-' . $layers_class;
		}

		if (
			$this->all_absolute ||
			$i > 0 ||
			(
				$i === 0 &&
				$type !== 'image' &&
				$type !== 'video' &&
				$type !== 'slideshow'
			)
		) {
			$classnames = array_merge( $classnames, [
				'absolute',
				'top-0',
				'start-0',
				'z-0',
			] );
		}

		return $classnames;
	}

	function color( $widget, $settings, $item, $i, $layers_class ) {

		$id = $item['_id'] . '_';
		$wrapper_classnames = array_merge(
			$this->get_wrapper_base_classnames( $widget, $item, $i, 'color', $layers_class )
		);
		$wrapper_attrs = [
			'class' => $wrapper_classnames
		];

		$widget->add_render_attribute( $id . 'bg_color_wrap', $wrapper_attrs );

		?><span <?php $widget->print_render_attribute_string( $id . 'bg_color_wrap' ); ?>></span><?php

	}

	function image( $widget, $settings, $item, $i, $layers_class ) {

		$id = $item['_id'] . '_';
		$image_width = 0;
		$image_height = 0;
		$aspect_ratio = 0;
		$has_image = !empty( $item['image']['url'] );
		$wraper_classnames = array_merge(
			$this->get_wrapper_base_classnames( $widget, $item, $i, 'image', $layers_class )
		);
		$wrapper_attrs = [
			'class' => $wraper_classnames
		];

		if (
			$has_image &&
			(
				$i === 0 &&
				! $this->all_absolute
			)
		) {
			$image = wp_get_attachment_image_src( $item['image']['id'], "full" );
			if ( $image ) {
				$image_width = $image[1];
				$image_height = $image[2];
				$aspect_ratio = $image_height / $image_width * 100;
			}
			$wrapper_attrs['style'] = '--lqd-bg-layer-pt:' . $aspect_ratio . '%';
		}

		$widget->add_render_attribute( $id . 'bg_image_wrap', $wrapper_attrs );

		?><span <?php $widget->print_render_attribute_string( $id . 'bg_image_wrap' ) ?>><?php
			echo wp_get_attachment_image(
				$item['image']['id'],
				'full',
				false,
				[
					'class' => 'hidden',
					'alt' => esc_html( !empty($item['image']['alt']) ? $item['image']['alt'] : '' )
				]
			);
		?></span><?php

	}

	function video( $widget, $settings, $item, $i, $layers_class ) {

		if ( ! $item['video_link'] ) return '';

		$id = $item['_id'] . '_';

		$video_id = 'lqd-bg-video-' . $widget->get_id() . $id;
		$wrapper_classnames = array_merge(
			$this->get_wrapper_base_classnames( $widget, $item, $i, 'video', $layers_class )
		);
		$wrapper_attrs = [];
		$video_attrs = [
			'id' => $video_id,
			'class' => 'lqd-bg-video block rounded-inherit overflow-hidden',
			// 'class' => 'lqd-bg-video block overflow-hidden',
			'data-vbg' => $item['video_link'],
			'data-vbg-loop' => $item['play_once'] !== 'yes' ? 'true' : 'false',
			'data-vbg-mobile' => $item['play_on_mobile'] === 'yes' ? 'true' : 'false',
			'data-vbg-start-at' => !empty( $item['video_start'] ) ? $item['video_start'] : 0,
			'data-vbg-end-at' => !empty( $item['video_end'] ) ? $item['video_end'] : 0,
		];

		if ( ! $item['play_on_mobile'] ) {
			$wrapper_classnames[] = 'mobile:hidden';
		}

		$wrapper_attrs['class'] = $wrapper_classnames;

		$widget->add_render_attribute( $id . 'bg-video-wrap', $wrapper_attrs );
		$widget->add_render_attribute( $id . 'bg-video', $video_attrs );

		?><span <?php $widget->print_render_attribute_string( $id . 'bg-video-wrap' ); ?>>
			<span <?php $widget->print_render_attribute_string( $id . 'bg-video' ); ?>></span>
			<script>
				(() => {
					function run() {
						new VideoBackgrounds('#<?php echo $video_id ?>');
					}
					if ( typeof VideoBackgrounds === 'function' ) {
						run();
					} else {
						document.addEventListener('DOMContentLoaded', function () {
							run();
						}, false);
					}
				})();
			</script>
		</span><?php

	}

	function slideshow( $widget, $settings, $item, $i, $layers_class ) {

		$id = $item['_id'] . '_';
		$gallery = $item['slideshow_gallery'];
		$wrapper_classnames = array_merge(
			$this->get_wrapper_base_classnames( $widget, $item, $i, 'slideshow', $layers_class )
		);
		$wrapper_attrs = [
			'class' => $wrapper_classnames
		];

		if ( count( $gallery ) <= 0 ) return '';

		$widget->add_render_attribute( $id . 'bg_slideshow_wrap', $wrapper_attrs );

		?><span <?php $widget->print_render_attribute_string( $id . 'bg_slideshow_wrap' ); ?>><?php
		foreach ($gallery as $key => $img) :
			$image_alt = esc_html( !empty($img['alt']) ? $img['alt'] : __('Slideshow image', 'aihub-core') );
		?>
			<span class="lqd-slideshow-item lqd-bg-slideshow-item block"><?php
				echo wp_get_attachment_image( $img['id'], 'full', false, [ 'alt' => $image_alt ] );
			?></span>
		<?php endforeach; ?>
		</span><?php

	}

	function particles( $widget, $settings, $item, $i, $layers_class ) {

		$id = $item['_id'] . '_';
		$particles_config = json_decode( $item['particles_config'], true );
		$wrapper_id = 'lqd-bg-particles-' . $widget->get_id() . $id;
		$wrapper_classnames = array_merge(
			$this->get_wrapper_base_classnames( $widget, $item, $i, 'particles', $layers_class )
		);
		$wrapper_attrs = [
			'id' => $wrapper_id,
			'class' => $wrapper_classnames
		];

		$particles_config['fullScreen'] = false;
		$particles_config['zIndex'] = '';

		$widget->add_render_attribute( $id . 'bg_particles_wrap', $wrapper_attrs );

		?><span <?php $widget->print_render_attribute_string( $id . 'bg_particles_wrap' ) ?>>
			<script>
				(() => {
					async function run() {
						const el = document.querySelector('.elementor-element-<?php echo $widget->get_id() ?>');
						const particles = await tsParticles.load('<?php echo $wrapper_id ?>', <?php echo json_encode( $particles_config ); ?>);
						particles.pause();
						new IntersectionObserver(([entry]) => {
							if ( entry.isIntersecting ) {
								particles.play();
							} else {
								particles.pause();
							}
						}).observe(el);
					}
					if ( typeof tsParticles === 'object' ) {
						run();
					} else {
						document.addEventListener('DOMContentLoaded', function () {
							run();
						}, false);
					}
				})();
			</script>
		</span><?php

	}

	function animated_gradient( $widget, $settings, $item, $i, $layers_class ) {

		$colors = $item['animated_gradient_colors'];

		if ( empty( $colors ) ) return '';

		$id = $item['_id'] . '_';
		$gradient_id = 'lqd-bg-gradient-' . $widget->get_id();
		$duration = isset( $item['animated_gradient_duration']['size'] ) ? $item['animated_gradient_duration']['size'] : 4;
		$wrapper_classnames = array_merge(
			$this->get_wrapper_base_classnames( $widget, $item, $i, 'animated-gradient', $layers_class )
		);
		$wrapper_attrs = [
			'class' => $wrapper_classnames
		];
		$colors_parts = explode( ',', $colors );
		$angle = floatval( explode( '(', array_shift( $colors_parts ) )[1] );
		$colors_array = array_map( function( $color ) {
			$color_parts = explode( ' ', trim( $color ) );
			return $color_parts[0];
		},  $colors_parts);
		$coords = $this->angleToCoordinates( $angle );

		$colorstops_a = [];
		$colorstops_b = [];

		foreach ( $colors_array as $i => $value ) {
			if ( $i % 2 === 0 ) {
				$colorstops_b[] = $value;
			} else {
				$colorstops_a[] = $value;
			}
		}

		if ( count( $colorstops_a ) < count( $colorstops_b ) ) {
			array_push( $colorstops_a, end( $colorstops_b ) );
		} else if ( count( $colorstops_a ) > count( $colorstops_b ) ) {
			array_push( $colorstops_b, end( $colorstops_a ) );
		}

		// for smoother loop
		array_push( $colorstops_a, $colorstops_a[0] );
		array_push( $colorstops_b, $colorstops_b[0] );

		$animate_attrs = [
			'dur' => $duration,
			'repeatCount' => 'indefinite',
			'attributeName' => 'stop-color'
		];

		$widget->add_render_attribute( $id . 'linearGradient', [
			'id' => $gradient_id,
			'x1' => $coords['x1'],
			'y1' => $coords['y1'],
			'x2' => $coords['x2'],
			'y2' => $coords['y2'],
		] );

		$widget->add_render_attribute( $id . 'animate_1', array_merge( $animate_attrs, [ 'values' => implode( ';', $colorstops_a ) ] ) );
		$widget->add_render_attribute( $id . 'animate_2', array_merge( $animate_attrs, [ 'values' => implode( ';', $colorstops_b ) ] ) );

		$widget->add_render_attribute( $id . 'bg_animated_gradient_wrap', $wrapper_attrs );

		?><span <?php $widget->print_render_attribute_string( $id . 'bg_animated_gradient_wrap' ); ?>>
			<svg width="100" height="100" class="absolute top-0 start-0 w-full h-full" preserveAspectRatio="none">
				<defs>
					<linearGradient <?php $widget->print_render_attribute_string( $id . 'linearGradient' )?>>
						<stop offset="0%" stop-color="<?php echo $colorstops_a[0] ?>">
							<animate <?php $widget->print_render_attribute_string( $id . 'animate_1' )?>></animate>
						</stop>
						<stop offset="100%" stop-color="<?php echo $colorstops_b[0] ?>">
							<animate <?php $widget->print_render_attribute_string( $id . 'animate_2' )?>></animate>
						</stop>
					</linearGradient>
				</defs>
				<rect width="100%" height="100%" class="w-full h-full" fill="url(#<?php echo $gradient_id; ?>)" />
			</svg>
		</span><?php

	}

	function render( $widget, $settings, $option_name, $all_absolute = false, $layers_class = '' ) {

		$media = '';
		$this->all_absolute = $all_absolute;
		$option_name = $option_name . '_liquid_background_items';
		$background_items = isset( $settings[ $option_name ] ) ? $settings[ $option_name ] : '';

		// check button options from other widget settings, it need 'ib_' prefix.
		if ( empty( $background_items ) ) {
			$background_items = isset( $settings[ 'ib_' . $option_name ] ) ? $settings[ 'ib_' . $option_name ] : '';
		}

		if ( $background_items ) {
			for ( $i = 0; $i < count( $background_items ); $i++ ) {
				$item = $background_items[ $i ];
				$media_type = $item['background'];

				switch ( $media_type ) {
					case 'color':
						$media .= $this->color( $widget, $settings, $item, $i, $layers_class );
						break;
					case 'image':
						$media .= $this->image( $widget, $settings, $item, $i, $layers_class );
						break;
					case 'video':
						$media .= $this->video( $widget, $settings, $item, $i, $layers_class );
						break;
					case 'slideshow':
						$media .= $this->slideshow( $widget, $settings, $item, $i, $layers_class );
						break;
					case 'particles':
						$media .= $this->particles( $widget, $settings, $item, $i, $layers_class );
						break;
					case 'animated-gradient':
						$media .= $this->animated_gradient( $widget, $settings, $item, $i, $layers_class );
						break;
				}
			}
		}

		return $media;

	}

	function render_template( $layers_class = '' ) {

		$template = '

		const layersCLass = "' . $layers_class . '";

		function get_liquid_background( option_name ) {
			return render( option_name + "_liquid_background_items" );
		}

		function angleToCoordinates( angleInDegrees, sizeOfSquare = 1 ) {

			let constrainedAngle = angleInDegrees % 360;

			if ( constrainedAngle < 0 ) constrainedAngle += 360;

			const angleBetween0and45deg = constrainedAngle % 45;
			const angle45InRadians = Math.PI / 180 * angleBetween0and45deg;

			const delta = 1 / Math.cos(angle45InRadians) * Math.sin(angle45InRadians);

			const angleUnder180 = constrainedAngle % 180;

			let xBase = delta;
			let yBase = 1;

			let x1;
			let y1;

			if ( angleUnder180 < 45 ) {
				x1 = xBase;
				y1 = yBase;
			} else if ( angleUnder180 < 90 ) {
				x1 = yBase;
				y1 = 1 - xBase;
			} else if ( angleUnder180 < 135 ) {
				x1 = yBase;
				y1 = -xBase;
			} else if ( angleUnder180 < 180 ) {
				x1 = 1 - xBase;
				y1 = -yBase;
			}

			if ( constrainedAngle < 180 ) {
				x1 = -x1;
				y1 = -y1;
			}

			let x2 = -x1;
			let y2 = -y1;

			x1 = (x1 + 1) / 2 * sizeOfSquare;
			y1 = (-y1 + 1) / 2 * sizeOfSquare;
			x2 = (x2 + 1) / 2 * sizeOfSquare;
			y2 = (-y2 + 1) / 2 * sizeOfSquare;

			var coords = [];
			coords["x1"]= x1;
			coords["y1"]= y1;
			coords["x2"]= x2;
			coords["y2"]= y2;

			return coords;

		}

		function get_wrapper_base_classnames( item, i = 0, type = "color", all_absolute ) {
			var classnames = [
				"lqd-bg-layer",
				"lqd-"  + type + "-wrap",
				"lqd-bg-" + type + "-wrap",
				"block",
				"w-full",
				"h-full",
				"rounded-inherit",
				"overflow-hidden",
				"elementor-repeater-item-" + item._id + "-" + view.model.get("id")
			];

			if ( layersCLass !== "" ) {
				classnames.push( `lqd-bg-layer-${layersClass}` );
			}

			if (
				all_absolute ||
				i > 0 ||
				(
					i === 0 &&
					type !== "image" &&
					type !== "video" &&
					type !== "slideshow"
				)
			) {
				classnames.push(
					"absolute",
					"top-0",
					"start-0",
					"z-0",
				);
			}

			return classnames;
		}

		function color( item, i, get_id, all_absolute ) {

			var id = item._id + "_",
			out = "";

			view.addRenderAttribute( id + "bg_color_wrap", {
				"class": get_wrapper_base_classnames( item, i, "color", all_absolute),
			});

			out = "<span " + view.getRenderAttributeString( id + "bg_color_wrap" ) + "></span>";
			return out;

		}

		function image( item, i, get_id, all_absolute ) {

			var id = item._id + "_",
			image_width = 0,
			image_height = 0,
			aspect_ratio = 0;

			if ( item.image.url ) {
				var image = {
					id: item.image.id,
					url: item.image.url,
					size: item.image_size,
					dimension: item.image_custom_dimension,
					model: view.getEditModel()
				};

				var image_url = elementor.imagesManager.getImageUrl( image );

				if ( image_url ) {
					const img = new Image();
					img.src = image_url;

					img.onload = () => {
						var image_width = img.width,
						image_height = img.height,
						aspect_ratio = image_width / image_height * 100;

					};

					if ( !aspect_ratio ){
						aspect_ratio = "50";
					}

					view.addRenderAttribute( id + "bg_image_wrap", {
						"class": get_wrapper_base_classnames( item, i, "image", all_absolute),
						"style":"--lqd-bg-layer-pt:" + aspect_ratio + "%",
					 } );

					return "<span " + view.getRenderAttributeString( id + "bg_image_wrap" ) + "><img src=" + image_url + " class=\"hidden\"></span>";

				}
			}

		}

		function video( item, i, get_id, all_absolute ) {

			if ( item.video_link === "" ) {
				return "";
			}

			var id = item._id + "_",
			video_id = "lqd-bg-video-" + get_id + id,
			wrapper_attrs = [];

			wrapper_attrs = get_wrapper_base_classnames( item, i, "video", all_absolute);

			if ( item.play_on_mobile === "yes" ) {
				wrapper_attrs.push("mobile:hidden");
			}

			view.addRenderAttribute( id + "bg-video-wrap", {
				"class": wrapper_attrs,
			 } );

			view.addRenderAttribute( id + "bg-video", {
				"id": video_id,
				"class": "lqd-bg-video block rounded-inherit overflow-hidden",
				// "class": "lqd-bg-video block overflow-hidden",
				"data-vbg": item.video_link,
				"data-vbg-loop": item.play_once !== "yes" ? "true" : "false",
				"data-vbg-mobile": item.play_on_mobile === "yes" ? "true" : "false",
				"data-vbg-start-at": item.video_start !== "" ? item.video_start : 0,
				"data-vbg-end-at": item.video_end !== "" ? item.video_end : 0,
			} );


			var out = "<span " + view.getRenderAttributeString( id + "bg-video-wrap" ) + ">";
			out += "<span " + view.getRenderAttributeString( id + "bg-video" ) + "></span>";
			out += "</span>";

			(() => {
				function run() {
					new VideoBackgrounds("#" + video_bg);
				}
				if ( typeof VideoBackgrounds === "function" ) {
					run();
				} else {
					document.addEventListener("DOMContentLoaded", function () {
						run();
					}, false);
				}
			})();

			return out;

		}

		function slideshow( item, i, get_id, all_absolute ) {

			var id = item._id + "_",
			gallery = item.slideshow_gallery;

			if ( gallery === "" ){
				return "";
			}

			view.addRenderAttribute( id + "bg_slideshow_wrap", {
				"class": get_wrapper_base_classnames( item, i, "slideshow", all_absolute),
			} );

			var out = "<span " + view.getRenderAttributeString( id + "bg_slideshow_wrap" ) + ">";
			_.each( gallery, function( img ) {
				out += "<span class=\"lqd-slideshow-item lqd-bg-slideshow-item block\"><img src=\"" + img.url +"\" alt=\"Slideshow image\"></span>";
			});
			out += "</span>";

			return out;

		}

		function particles( item, i, get_id, all_absolute ) {

			var id = item._id,
			particles_config = JSON.parse( item.particles_config ),
			wrapper_id = "lqd-bg-particles-" + get_id + id;

			particles_config["fullScreen"] = false;
			particles_config["zIndex"] = "";

			view.addRenderAttribute( id + "bg_particles_wrap", {
				"id": wrapper_id,
				"class": get_wrapper_base_classnames( item, i, "particles", all_absolute),
			 } );

			(() => {
				async function run() {
					const el = document.querySelector(`.elementor-element-${ get_id }`);
					const particles = await tsParticles.load(\'wrapper_id\', JSON.parse( particles_config ));
					particles.pause();
					new IntersectionObserver(([entry]) => {
						if ( entry.isIntersecting ) {
							particles.play();
						} else {
							particles.pause();
						}
					}).observe(el);
				}
				if ( typeof tsParticles === "object" ) {
					run();
				} else {
					document.addEventListener("DOMContentLoaded", function () {
						run();
					}, false);
				}
			})();

			return "<span " + view.getRenderAttributeString( id + "bg_particles_wrap" ) + "></span>";


		}

		function animated_gradient( item, i, get_id, all_absolute ) {

			var colors = item.animated_gradient_colors;

			if ( colors === "" ){
				return "";
			}

			var id = item._id + "_",
			gradient_id = "lqd-bg-gradient-" + get_id,
			duration = item.animated_gradient_duration.size ? item.animated_gradient_duration.size : 4;

			var colors_parts = colors.split(","),
			angle = colors_parts.shift();
			angle = angle.split("(");
			angle = parseFloat(angle[1]);

			var colors_array = colors_parts.map(function(element) {
				var color_parts = element.trim();
				color_parts = color_parts.split(" ");
				return color_parts[0];
			});

			var coords = angleToCoordinates( angle );

			var colorstops_a = [],
			colorstops_b = [];

			colors_array.forEach((element, index) => {
				if (index % 2 === 0) {
					colorstops_b.push(element);
				} else {
					colorstops_a.push(element);
				}
			});

			if ( colorstops_a.lenght < colorstops_b.lenght ) {
				colorstops_a.push(colorstops_b);
			} else if ( colorstops_a.lenght > colorstops_b.lenght ) {
				colorstops_b.push(colorstops_a);
			}

			// for smoother loop
			colorstops_a.push(colorstops_a[0]);
			colorstops_b.push(colorstops_b[0]);

			view.addRenderAttribute( id + "linearGradient", {
				"id": gradient_id,
				"x1": coords["x1"],
				"x2": coords["x2"],
				"y1": coords["y1"],
				"y2": coords["y2"]
			});

			view.addRenderAttribute( id + "animate_1", {
				"dur": duration,
				"repeatCount": "indefinite",
				"attributeName": "stop-color",
				"values": colorstops_a.join(";")
			});

			view.addRenderAttribute( id + "animate_2", {
				"dur": duration,
				"repeatCount": "indefinite",
				"attributeName": "stop-color",
				"values": colorstops_b.join(";")
			});

			view.addRenderAttribute( id + "bg_animated_gradient_wrap", {
				"class": get_wrapper_base_classnames( item, i, "animated-gradient", all_absolute )
			});

			var out =  "<span " + view.getRenderAttributeString( id + "bg_animated_gradient_wrap" ) + ">";
			out += "<svg width=\"100\" height=\"100\" class=\"absolute top-0 start-0 w-full h-full\" preserveAspectRatio=\"none\"><defs>";
			out += "<linearGradient " + view.getRenderAttributeString( id + "linearGradient" ) + ">";
			out += "<stop offset=\"0%\" stop-color=" + colorstops_a[0] + "><animate " + view.getRenderAttributeString( id + "animate_1" ) + "></animate></stop>";
			out += "<stop offset=\"100%\" stop-color=" + colorstops_b[0] + "><animate " + view.getRenderAttributeString( id + "animate_2" ) + "></animate></stop></linearGradient></defs>";
			out += "<rect width=\"100%\" height=\"100%\" class=\"w-full h-full\" fill=\"url(#" + gradient_id+ ")\" /></svg></span>";

			return out;

		}

		function render( option_name, all_absolute = false ) {
			var media = "",
			i = 0;
			if ( settings[option_name].length ) {
				_.each( settings[option_name], function( item ) {
					var media_type = item.background;
					var get_id = Date.now();

					switch ( media_type ){
						case "color":
							media += color( item, i, get_id, all_absolute );
							break;
						case "image":
							media += image( item, i, get_id, all_absolute );
							break;
						case "video":
							media += video( item, i, get_id, all_absolute );
							break;
						case "slideshow":
							media += slideshow( item, i, get_id, all_absolute );
							break;
						case "particles":
							media += particles( item, i, get_id, all_absolute );
							break;
						case "animated-gradient":
							media += animated_gradient( item, i, get_id, all_absolute );
							break;
					}
					i++;
				});
			}

			return media;
		}
		';

		echo $template;


	}

}