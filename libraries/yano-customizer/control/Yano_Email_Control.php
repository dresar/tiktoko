<?php
namespace Control;

defined( 'ABSPATH' ) || exit;

/**
 * Yano Email Control.
 *
 * @since   1.0.0
 * @version 1.0.0
 */
final class Yano_Email_Control extends \WP_Customize_Control {


	/**
	 * Holds placeholder.
	 *
	 * @since 1.0.0
	 * 
	 * @var string
	 */
	public $placeholder;


	/**
	 * Render the email controller and display in frontend.
	 *
	 * @since 1.0.0
	 * 
	 * @return html
	 */
	public function render_content() {
	?>
		<div class="yano-email-parent">	
			<label>
				<?php if( ! empty( $this->label ) ): ?>
					<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
				<?php endif; ?>

				<?php if( ! empty( $this->description ) ): ?>
					<span class="description customize-control-description"><?php echo wp_kses_post( $this->description ); ?></span>
				<?php endif; ?>
			</label>

            <input  type="text" 
                    id="yano-email-<?php echo esc_attr( $this->id ); ?>" 
                    class="yano-email"
                    value="<?php echo esc_attr( $this->value() ); ?>" 
                    name="<?php echo esc_attr( $this->id ); ?>"
                    placeholder="<?php echo esc_attr( $this->placeholder ); ?>"
                   <?php echo $this->link(); ?>>
		</div>
	<?php
	}
}