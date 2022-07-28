<?php
/*
Plugin Name: Custom Registration Fields
Plugin URI:
Description: Adding age to UserWP
Version: 0.1
Author: AsmaaFaried
Author URI:
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/

/**
 * Front end registration
 */

add_action( 'register_form', 'crf_registration_form' );
function crf_registration_form() {

	$age = ! empty( $_POST['age'] ) ? intval( $_POST['age'] ) : '';

	?>
	<p>
		<label for="age"><?php esc_html_e( 'age', 'crf' ) ?><br/>
			<input type="number"
			       id="age"
				   min="15"
				   step="1"
			       name="age"
			       value="<?php echo esc_attr( $age ); ?>"
			       class="input"
			/>
		</label>
	</p>
	<?php
}

add_filter( 'registration_errors', 'crf_registration_errors', 10, 3 );
function crf_registration_errors( $errors, $sanitized_user_login, $user_email ) {

	if ( empty( $_POST['age'] ) ) {
		$errors->add( 'age_error', __( '<strong>ERROR</strong>: Please enter your age.', 'crf' ) );
	}

	if ( ! empty( $_POST['age'] ) && intval( $_POST['age'] ) < 15 ) {
		$errors->add( 'age_error', __( '<strong>ERROR</strong>: Your age must be 15 years or more.', 'crf' ) );
	}

	return $errors;
}

add_action( 'user_register', 'crf_user_register' );
function crf_user_register( $user_id ) {
	if ( ! empty( $_POST['age'] ) ) {
		update_user_meta( $user_id, 'age', intval( $_POST['age'] ) );
	}
}

?>