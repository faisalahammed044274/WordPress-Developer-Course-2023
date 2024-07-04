<?php
if ( !defined( 'ABSPATH' ) ) { exit; }

class EVBBackgroundBlock{
	public function __construct(){
		add_action( 'init', [$this, 'onInit'] );
	}

	function onInit() {
		wp_register_style( 'evb-background-style', EVBB_DIR_URL . 'dist/style.css', [], EVBB_VERSION );
		wp_register_style( 'evb-background-editor-style', EVBB_DIR_URL . 'dist/editor.css', [ 'evb-background-style' ], EVBB_VERSION );

		register_block_type( __DIR__, [
			'editor_style'		=> 'evb-background-editor-style',
			'render_callback'	=> [$this, 'render']
		] ); // Register Block

		wp_set_script_translations( 'evb-background-editor-script', 'background-block', EVBB_DIR_PATH . 'languages' );
	}

	function render( $attributes, $innerContent ){
		extract( $attributes );

		$aniType = $wrapper['animation']['type'] ?? 'none';

		wp_enqueue_style( 'evb-background-style' );
		wp_enqueue_script( 'evb-background-script', EVBB_DIR_URL . 'dist/script.js', [], EVBB_VERSION );
		wp_set_script_translations( 'evb-background-script', 'background-block', EVBB_DIR_PATH . 'languages' );

		$className = $className ?? '';
		$blockClassName = "wp-block-evb-background scroll-$aniType $className align$align";

		global $allowedposttags;
		$allowedHTML = wp_parse_args( [ 'style' => [] ], $allowedposttags );

		ob_start(); ?>
		<div class='<?php echo esc_attr( $blockClassName ); ?>' id='evbBackground-<?php echo esc_attr( $clientId ) ?>' data-attributes='<?php echo esc_attr( wp_json_encode( $attributes ) ); ?>'>
			<?php echo wp_kses( $this->style( $attributes ), [ 'style' => [] ] ); ?>

			<div class='evbBackground'></div>

			<div class='backgroundContent'>
				<?php echo wp_kses( $innerContent, $allowedHTML ); ?>
			</div>
		</div>

		<?php return ob_get_clean();
	}

	function getBoxValues( $val ) {
		return implode( ' ', array_values( $val ) );
	}

	function style( $attributes ) {
		extract( $attributes );
		extract( $background['desktop'] ?? [] );

		$plxSpeed = $wrapper['animation']['parallax']['speed'] ?? 1;
	
		// Selectors
		$mainSl = "#evbBackground-$clientId";
		$backgroundSl = "$mainSl .evbBackground";
		$contentSl = "$mainSl .backgroundContent";

		// Image Destructure
		$url = $image['url'] ?? '';
		$position = $image['position'] ?? '';
		$attachment = $image['attachment'] ?? '';
		$repeat = $image['repeat'] ?? '';
		$size = $image['size'] ?? '';

		// WrapperCSS
		$wMHeight = $wrapper['minHeight'];
		$wDPadding = $this->getBoxValues( $wrapper['padding']['desktop'] ?? [] );
		$wTPadding = $this->getBoxValues( $wrapper['padding']['tablet'] ?? [] );
		$wMPadding = $this->getBoxValues( $wrapper['padding']['mobile'] ?? [] );
	
		// Content CSS
		$contentBG = $content['background'];
		$cVAlign = $content['align']['vertical'];
		$cTAlign = $content['align']['text'];
		$cDPadding = $this->getBoxValues( $content['padding']['desktop'] ?? [] );
		$cTPadding = $this->getBoxValues( $content['padding']['tablet'] ?? [] );
		$cMPadding = $this->getBoxValues( $content['padding']['mobile'] ?? [] );

		$bgStyles = 'image' === $type ? "url($url)" :
			('gradient' === $type ? $gradient : $color);

		$bgImgStyles = 'image' === $type ? "
			background-position: $position;
			background-attachment: $attachment;
			background-repeat: $repeat;
			background-size: $size;
		" : '';

		$styles = "$mainSl {
			min-height: $wMHeight;
			padding: $wDPadding;
		}
		$mainSl.scroll-parallax .evbBackground{
			height: calc( 100% + ( 100% * $plxSpeed ) );
		}
		$backgroundSl {
			background: $bgStyles;
			$bgImgStyles
		}
		$contentSl {
			text-align: $cTAlign;
			justify-content: $cVAlign;
			$contentBG
			padding: $cDPadding;
		}
		@media (min-width: 481px) and (max-width: 960px) {
			$mainSl {
				padding: $wTPadding;
			}
			$contentSl {
				padding: $cTPadding;
			}
		}
		@media (max-width: 480px) {
			$mainSl {
				padding: $wMPadding;
			}
			$contentSl {
				padding: $cMPadding;
			}
		}";
	
		ob_start(); ?>
		<style><?php echo strip_tags( $styles ); ?></style>
		<?php return ob_get_clean();
	}
}
new EVBBackgroundBlock();