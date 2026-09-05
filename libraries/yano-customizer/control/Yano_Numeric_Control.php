<?php
namespace Control;

defined( 'ABSPATH' ) || exit;

/**
 * Yano Numeric Control.
 *
 * @since   1.0.0
 * @version 1.0.0
 */
final class Yano_Numeric_Control extends \WP_Customize_Control {


	/**
	 * The configuration option.
	 *
	 * @since 1.0.0
	 * 
	 * @var string
	 */
	public $options;


	/**
	 * Render the numeric controller and display in frontend.
	 *
	 * @since 1.0.0
	 * 
	 * @return html
	 */
	public function render_content() { 
	?>
		<div class="yano-numeric-parent">
			<label>
				<?php if ( ! empty( $this->label ) ): ?>
					<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
				<?php endif; ?>

				<?php if ( ! empty( $this->description ) ): ?>
					<span class="description customize-control-description"><?php echo wp_kses_post( $this->description ); ?></span>
				<?php endif; ?>
			</label>

			<input type="text"
					class="yano-numeric-real"
					id="<?php echo esc_attr( $this->id ) ?>"
					name="<?php echo esc_attr( $this->id ) ?>"
					value="<?php echo esc_attr( $this->value() ) ?>"
					<?php echo $this->link() ?>>
			<div class="yano-numeric-container">
				<div class="col-1">
					<div class="yano-numeric-btn enabled"
						 id="<?php echo esc_attr( $this->id ) . '-btn-minus' ?>"
						 data-role="minus" 
						 data-target_id="<?php echo esc_attr( $this->id ) ?>">-</div>
				</div>
				<div class="col-2">
					<input type="text"
							class="yano-numeric"
							id="<?php echo esc_attr( $this->id ) ?>-mirror"
							name="<?php echo esc_attr( $this->id ) ?>"
							value="<?php echo esc_attr( $this->value() ) ?>"
							data-min="<?php echo esc_attr( $this->options['min'] ) ?>"
							data-max="<?php echo esc_attr( $this->options['max'] ) ?>"
							data-step="<?php echo esc_attr( $this->options['step'] ) ?>">
				</div>
				<div class="col-3">
					<div class="yano-numeric-btn enabled" 
						  id="<?php echo esc_attr( $this->id ) . '-btn-plus' ?>"
						 data-role="plus" 
						 data-target_id="<?php echo esc_attr( $this->id ) ?>">+</div>
				</div>
			</div>
		</div>
	<?php
	}
}
