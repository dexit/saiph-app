<?php
/**
 * Template to show when submitting a resume.
 *
 * This template can be overridden by copying it to yourtheme/wp-job-manager-resumes/resume-submit.php.
 *
 * @see         https://wpjobmanager.com/document/template-overrides/
 * @author      Automattic
 * @package     wp-job-manager-resumes
 * @category    Template
 * @version     1.18.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

wp_enqueue_style( 'cariera-wpjm-submissions' );
wp_enqueue_script( 'wp-resume-manager-resume-submission' );
?>
<form action="<?php echo esc_url( $action ); ?>" method="post" id="submit-resume-form" class="job-manager-form" enctype="multipart/form-data">

	<?php do_action( 'submit_resume_form_start' ); ?>

	<?php if ( apply_filters( 'submit_resume_form_show_signin', true ) ) : ?>

		<?php get_job_manager_template( 'account-signin.php', [ 'class' => $class ], 'wp-job-manager-resumes', RESUME_MANAGER_PLUGIN_DIR . '/templates/' ); ?>

	<?php endif; ?>

	<?php if ( resume_manager_user_can_post_resume() ) : ?>

		<!-- Resume Fields -->
		<?php do_action( 'submit_resume_form_resume_fields_start' ); ?>

		<?php foreach ( $resume_fields as $key => $field ) : ?>
			<fieldset class="fieldset-<?php echo esc_attr( $key ); ?>">
				<label for="<?php echo esc_attr( $key ); ?>"><?php echo wp_kses_post( $field['label'] ) . apply_filters( 'submit_resume_form_required_label', $field['required'] ? '' : ' <small>' . esc_html__( '(optional)', 'cariera' ) . '</small>', $field ); ?></label>
				<div class="field">
					<?php $class->get_field_template( $key, $field ); ?>
				</div>
			</fieldset>
		<?php endforeach; ?>

		<?php do_action( 'submit_resume_form_resume_fields_end' ); ?>

		<div class="cariera-listing-submission">
			<div class="submission-progress"></div>
			<input type="hidden" name="resume_manager_form" value="<?php echo esc_attr( $form ); ?>" />
			<input type="hidden" name="resume_id" value="<?php echo esc_attr( $resume_id ); ?>" />
			<input type="hidden" name="job_id" value="<?php echo esc_attr( $job_id ); ?>" />
			<input type="hidden" name="step" value="<?php echo esc_attr( $step ); ?>" />
			<?php do_action( 'cariera_resume_submission_steps' ); ?>
			<input type="submit" name="submit_resume" class="button" value="<?php echo esc_attr( $submit_button_text ); ?>" />
		</div>

	<?php else : ?>

		<?php do_action( 'submit_resume_form_disabled' ); ?>

	<?php endif; ?>

	<?php do_action( 'submit_resume_form_end' ); ?>
</form>
