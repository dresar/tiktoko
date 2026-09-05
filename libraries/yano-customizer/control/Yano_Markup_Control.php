<?php
namespace Control;

defined( 'ABSPATH' ) || exit;

/**
 * Yano Markup Control.
 *
 * @since   1.0.0
 * @version 1.0.0
 */
final class Yano_Markup_Control extends \WP_Customize_Control {


	/**
	 * HTML code to be displayed in front-end.
	 *
	 * @since 1.0.0
	 * 
	 * @var string
	 */
	public $html;


	/**
	 * Render the markup controller and display in frontend.
	 *
	 * @since 1.0.0
	 * 
	 * @return html
	 */
	public function render_content() {
	?>
		<div class="yano-markup-parent">
			<?php echo $this->html; ?>
		</div>
	<?php
	}
}