<?php
namespace Control;

defined( 'ABSPATH' ) || exit;

/**
 * Yano Checkbox Multiple Control.
 *
 * @since   1.0.0
 * @version 1.0.0
 */
final class Yano_Checkbox_Multiple_Control extends \WP_Customize_Control {


	/**
	 * Set of choices.
	 *
	 * @since 1.0.0
	 * 
	 * @var array
	 */
	public $choices;


	/**
	 * Returns the value of choices with sanitize.
	 *
	 * @since 1.0.0
	 * 
	 * @return array
	 */
	private function choices_value() {
		if ( ! empty( $this->choices ) ) {
			return array_unique( $this->choices );
		}
	}


	/**
	 * Returns the value is either from "default" or "value()".
	 *
	 * @since 1.0.0
	 * 
	 * @return array 	the value 
	 */
	private function checked_values() {
		$output = $this->value();
		if ( ! is_array( $this->value() ) ) {
			$output = explode( ',', esc_attr( $this->value() ) );
		}
		return $output;
	}


	/**
	 * Returns the imploded value whether in "array" or string format.
	 *
	 * @since 1.0.0
	 * 
	 * @return string
	 */
	private function imploded_value() {
		$output = $this->value();
		if ( is_array( $this->value() ) ) {
			$output = implode( ',', $this->value() );
		}
		return $output;
	}


	/**
	 * Render the checkbox multiple controller and display in frontend.
	 *
	 * @since 1.0.0
	 * 
	 * @return html
	 */
	public function render_content() {
	?>
		<label>
			<?php if ( ! empty( $this->label ) ): ?>
				<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
			<?php endif; ?>

			<?php if ( ! empty( $this->description ) ): ?>
				<span class="description customize-control-description"><?php echo wp_kses_post( $this->description ); ?></span>
			<?php endif; ?>
		</label>

		<div class="yano-checkbox-multiple-parent-<?php echo esc_attr( $this->id ) ?>">
			<input type="hidden" 
				   class="yano-checkbox-multiple-input"
				   id="<?php echo esc_attr( $this->id ); ?>" 
				   name="<?php echo esc_attr( $this->id ); ?>" 
				   value="<?php echo esc_attr( $this->imploded_value() ); ?>" 
				   <?php $this->link(); ?>>
			
			<?php foreach ( $this->choices_value() as $key => $value ): ?>
					<label class="yano-checkbox-multiple-label">
						<input type="checkbox" 
						   	   class="yano-checkbox-multiple"  
						   	   name="<?php echo esc_attr( $this->id ) ?>" 
						   	   value="<?php echo esc_attr( $key ) ?>"
						   	   <?php checked( in_array( esc_attr( $key ), $this->checked_values() ), 1 ) ?>>
						<?php echo esc_attr( $value ) ?>
					</label>
			<?php endforeach; ?>	
		
		</div>
	<?php
	}
}