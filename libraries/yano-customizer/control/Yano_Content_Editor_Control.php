<?php
namespace Control;

defined( 'ABSPATH' ) || exit;

/**
 * Yano Content Editor Control.
 *
 * @since   1.0.0
 * @version 1.0.0
 */
final class Yano_Content_Editor_Control extends \WP_Customize_Control {


	/**
	 * Set if allowed media uploader.
	 *
	 * @since 1.0.0
	 * 
	 * @var boolean
	 */
	public $uploader;


	/**
	 * Set of toolbars to be used.
	 *
	 * @since 1.0.0
	 * 
	 * @var array
	 */
	public $toolbars;


	/**
	 * Returns the toolbar in imploded.
	 *
	 * @since 1.0.0
	 * 
	 * @return string
	 */
	private function get_toolbars() {
		$toolbars = '';
		if ( ! empty( $this->toolbars ) ) {
			$toolbars = implode( ',', $this->toolbars );
		}
		return $toolbars;
	}


	/**
	 * Render the content editor controller and display in frontend.
	 *
	 * @since 1.0.0
	 * 
	 * @return html
	 */
	public function render_content() {
	?>
		<div class="yano-content-editor-parent">
			<label>
				<?php if ( ! empty( $this->label ) ): ?>
					<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
				<?php endif; ?>

				<?php if ( ! empty( $this->description ) ): ?>
				<span class="description customize-control-description"><?php echo wp_kses_post( $this->description ); ?></span>
				<?php endif; ?>
			</label>
		
			<textarea id="yano-content-editor-textarea-<?php echo esc_attr( $this->id ); ?>" 
					  class="yano-content-editor-textarea" 
					  data-toolbars="<?php echo esc_attr( $this->get_toolbars() ); ?>"
					  data-uploader="<?php echo esc_attr( $this->uploader ); ?>"
					  <?php $this->link(); ?>><?php echo esc_attr( $this->value() ); ?></textarea>
		</div>

	<?php
	}
}