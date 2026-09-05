<?php
namespace Control;

defined( 'ABSPATH' ) || exit;

/**
 * Yano Checkbox Pill Control.
 *
 * @since   1.0.0
 * @version 1.0.0
 */
final class Yano_Checkbox_Pill_Control extends \WP_Customize_Control {


	/**
	 * Set of choices.
	 *
	 * @since 1.0.0
	 * 
	 * @var array
	 */
	public $choices;


	/**
	 * The style view.
	 *
	 * @since 1.0.0
	 * 
	 * @var string
	 */
	public $style;


	/**
	 * Returns the value of choices with sanitize.
	 *
	 * @since 1.0.0
	 * 
	 * @return
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
	 * @return array 
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
	 * Return style with validation.
	 *
	 * @since 1.0.0
	 * 
	 * @return string
	 */
	private function get_style() {
		$output = 'list';
		if ( ! empty( $this->style ) ) {
			if ( in_array( $this->style, [ 'inline', 'list' ] ) ) {
				$output = esc_attr( $this->style );
			}
		}
		return $output;
	}


	/**
	 * Render the checkbox pill controller and display in frontend.
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

		<div id="yano-checkbox-pill-parent-<?php echo esc_attr( $this->id ) ?>" class="yano-checkbox-pill-parent">
			<input type="hidden" 
				   class="yano-checkbox-pill-input"
				   id="<?php echo esc_attr( $this->id ); ?>" 
				   name="<?php echo esc_attr( $this->id ); ?>" 
				   value="<?php echo esc_attr( $this->imploded_value() ); ?>" 
				   <?php $this->link(); ?>>
			
			<ul id="yano-checbox-pill-list-<?php echo esc_attr( $this->id ); ?>" class="yano-checbox-pill-list <?php echo $this->get_style(); ?>">
				<?php foreach ( $this->choices_value() as $key => $value ): ?>
						<li>
							<input type="checkbox"
							  	   class="yano-checkbox-pill"
							  	   id="yano-checkbox-pill-<?php echo esc_attr( $this->id ) .'-'. esc_attr( $key ); ?>"
							  	   name="<?php echo esc_attr( $this->id ); ?>" 
						   	   	   value="<?php echo esc_attr( $key ); ?>"
						   	       <?php checked( in_array( esc_attr( $key ), $this->checked_values() ), 1 ) ?>>
						   	       
							<label for="yano-checkbox-pill-<?php echo esc_attr( $this->id ) .'-'. esc_attr( $key ); ?>" 
								   class="yano-checkbox-pill-label">
								   <i class="dashicons dashicons-yes"></i>
								   <?php echo esc_attr( $value ) ?>
							</label>
						</li>
				<?php endforeach; ?>
			</ul>
		
		</div>
	<?php
	}
}