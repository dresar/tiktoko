<?php
namespace Control;

defined( 'ABSPATH' ) || exit;

/**
 * Yano Image Checkbox Control.
 *
 * @since   1.0.0
 * @version 1.0.0
 */
final class Yano_Image_Checkbox_Control extends \WP_Customize_Control {


	/**
	 * List of choices.
	 *
	 * @since 1.0.0
	 * 
	 * @var array
	 */
	public $choices;


	/**
	 * The direction display "row" | "column".
	 *
	 * @since 1.0.0
	 * 
	 * @var string
	 */
	public $direction;


	/**
	 * The size for the list.
	 *
	 * @since 1.0.0
	 * 
	 * @var array
	 */
	public $size;


	/**
	 * Validate the $this->style and get default value also.
	 *
	 * @since 1.0.0
	 * 
	 * @return string
	 */
	private function get_direction() {
		if ( ! empty( $this->direction ) ) {
			return $this->direction;
		}
		return 'row';
	}


	/**
	 * Validate $this->size and return its default value if empty.
	 *
	 * @since 1.0.0
	 * 
	 * @param  string  $type  The return type choices "width" | "height".
	 * @return string
	 */
	private function get_size( $type ) {
		$sizes = [
			'width' 	=> '100%',
			'height'	=> 'auto'
		];
		if ( ! empty( $this->size ) ) {
			$sizes = $this->size;
		}

		if ( $type == 'width' ) {
			$output = $sizes['width'];
		} else {
			$output = $sizes['height'];
		}
		return $output;
	}


	/**
	 * Encode the $this->value when type is array.
	 *
	 * @since 1.0.0
	 * 
	 * @return string 
	 */
	private function encoded_value() {
		$value = $this->value();
		if ( ! empty( $this->value() ) ) {
			if ( is_array( $this->value() ) ) {
				$value = json_encode( $this->value() );
			}
		}
		return $value;
	}


	/**
	 * Decode the $this->value when type is string.
	 *
	 * @since 1.0.0
	 * 
	 * @return array
	 */
	private function decoded_value() {
		$value = [];
		if ( ! empty( $this->value() ) ) {
			$value = $this->value();
			if ( gettype( $this->value() ) == 'string' ) {
				$value = json_decode( $this->value() );
			}
		}
		return $value;
	}


	/**
	 * Render the image checkbox controller and display in frontend.
	 *
	 * @since 1.0.0
	 * 
	 * @return html
	 */
	public function render_content() {
	?>
		<div class="yano-image-checkbox-parent">	
			<label>
				<?php if ( ! empty( $this->label ) ): ?>
					<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
				<?php endif; ?>

				<?php if ( ! empty( $this->description ) ): ?>
					<span class="description customize-control-description"><?php echo wp_kses_post( $this->description ); ?></span>
				<?php endif; ?>
			</label>

			<input type="hidden" 
				   id="yano-image-checkbox-main-input-<?php echo esc_attr( $this->id ); ?>"
				   name="<?php echo esc_attr( $this->id ); ?>"
				   value="<?php echo esc_attr( $this->encoded_value() ); ?>"
				   <?php echo $this->link(); ?>>

            <?php if ( ! empty( $this->choices ) ): ?>
		
					<ul id="yano-image-checkbox-ul-<?php echo esc_attr( $this->id ); ?>" class="yano-image-checkbox-ul <?php echo esc_attr( $this->get_direction() ); ?>">
						<?php foreach ( $this->choices as $key => $value ): ?>
								<li>
									<input type="checkbox" 
										   id="yano-image-checkbox-input-<?php echo esc_attr( $this->id ) .'-'. esc_attr( $key ); ?>"
										   class="yano-image-checkbox-input"
										   value="<?php echo esc_attr( $key ); ?>"
										   data-id="<?php echo esc_attr( $this->id ); ?>"
										   <?php checked( in_array( $key, $this->decoded_value() ), 1 ) ?>>

									<label for="yano-image-checkbox-input-<?php echo esc_attr( $this->id ) .'-'. esc_attr( $key ); ?>" 
										   class="yano-image-checkbox-label"
										   style="width: <?php echo esc_attr( $this->get_size('width') ); ?>; height: <?php echo esc_attr( $this->get_size('height') ); ?>;">

										<img src="<?php echo esc_attr( $value['image'] ); ?>" 
											 alt="<?php echo esc_attr( $value['title'] ); ?>" 
											 title="<?php echo esc_attr( $value['title'] ); ?>">
									</label>
								</li>
						<?php endforeach; ?>
					</ul>

            <?php endif; ?>
		</div>
	<?php
	}
}