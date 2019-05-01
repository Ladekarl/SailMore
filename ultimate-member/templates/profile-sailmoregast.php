<?php /* Template: SailMore Gast */ ?>
<div class="um <?php echo $this->get_class( $mode ); ?> um-<?php echo esc_attr( $form_id ); ?> um-role-<?php echo um_user( 'role' ); ?> ">
	<div class="um-form">
		<?php
		sm_profile_header( $args );
		sm_profile_content_main( $args );
		?>
	</div>
</div>

<?php
function sm_profile_header( $args )
{
	$classes = null;

	if ( !$args['cover_enabled'] ) {
		$classes .= ' no-cover';
	}

	$default_size = str_replace( 'px', '', $args['photosize'] );
	?>

	<div class="um-header<?php echo $classes; ?>">
		<div class="um-profile-photo" data-user_id="<?php echo um_profile_id(); ?>">
			<a href="<?php echo um_user_profile_url(); ?>" class="um-profile-photo-img"
			   title="<?php echo um_user( 'display_name' ); ?>"><?php echo get_avatar( um_user( 'ID' ), $default_size ); ?></a>
		</div>

		<div class="um-profile-meta">
			<div class="um-main-meta">
				<div class="um-name">
					<a href="<?php echo um_user_profile_url(); ?>"
					   title="<?php echo um_user( 'display_name' ); ?>"><?php echo um_user( 'display_name', 'html' ); ?></a>
				</div>
				<div class="um-clear"></div>
			</div>
			<div class="um-meta-text">
				<?php
				$description = get_user_meta( um_user( 'ID' ), 'description', true );
				echo esc_html( $description );
				?>
			</div>
		</div>
		<div class="um-clear"></div>
	</div>
	<?php
}

function sm_profile_content_main( $args )
{
	extract( $args );

	if ( !UM()->options()->get( 'profile_tab_main' ) && !isset( $_REQUEST['um_action'] ) )
		return;

	$can_view = apply_filters( 'um_profile_can_view_main', -1, um_profile_id() );

	if ( $can_view == -1 ) {
		sm_add_profile_fields( $args );
	} else { ?>
		<div class="um-profile-note"><span><i class="um-faicon-lock"></i><?php echo $can_view; ?></span></div>
	<?php }
}

function sm_add_profile_fields( $args )
{
	$fields = UM()->fields();
	$fields->viewing = true;
	echo sm_display_view( 'profile', $args );
}

function sm_display_view( $mode, $args )
{
	$output = null;
	$umFields = UM()->fields();

	$umFields->global_args = $args;

	UM()->form()->form_suffix = '-' . $umFields->global_args['form_id'];

	$umFields->set_mode = $mode;
	$umFields->set_id = $umFields->global_args['form_id'];

	$umFields->field_icons = ( isset( $umFields->global_args['icons'] ) ) ? $umFields->global_args['icons'] : 'label';

	// start output here
	$umFields->get_fields = $umFields->get_fields();

	if ( UM()->options()->get( 'profile_empty_text' ) ) {

		$emo = UM()->options()->get( 'profile_empty_text_emo' );
		if ( $emo ) {
			$emo = '<i class="um-faicon-frown-o"></i>';
		} else {
			$emo = false;
		}

		if ( um_is_myprofile() ) {
			$output .= '<p class="um-profile-note">' . $emo . '<span>' . sprintf( __( 'Your profile is looking a little empty. Why not <a href="%s">add</a> some information!', 'ultimate-member' ), um_edit_profile_url() ) . '</span></p>';
		} else {
			$output .= '<p class="um-profile-note">' . $emo . '<span>' . __( 'This user has not added any information to their profile yet.', 'ultimate-member' ) . '</span></p>';
		}
	}

	if ( !empty( $umFields->get_fields ) ) {

		// find rows
		foreach ( $umFields->get_fields as $key => $array ) {
			if ( $array['type'] == 'row' ) {
				$umFields->rows[$key] = $array;
				unset( $umFields->get_fields[$key] ); // not needed anymore
			}
		}

		// rows fallback
		if ( !isset( $umFields->rows ) ) {
			$umFields->rows = array( '_um_row_1' => array(
				'type' => 'row',
				'id' => '_um_row_1',
				'sub_rows' => 1,
				'cols' => 1
			)
			);
		}

		// master rows
		foreach ( $umFields->rows as $row_id => $row_array ) {

			$row_fields = $umFields->get_fields_by_row( $row_id );

			if ( $row_fields ) {

				$output .= $umFields->new_row_output( $row_id, $row_array );

				$sub_rows = ( isset( $row_array['sub_rows'] ) ) ? $row_array['sub_rows'] : 1;
				for ( $c = 0; $c < $sub_rows; $c++ ) {

					// cols
					$cols = ( isset( $row_array['cols'] ) ) ? $row_array['cols'] : 1;
					if ( strstr( $cols, ':' ) ) {
						$col_split = explode( ':', $cols );
					} else {
						$col_split = array( $cols );
					}
					$cols_num = $col_split[$c];

					// sub row fields
					$subrow_fields = null;
					$subrow_fields = $umFields->get_fields_in_subrow( $row_fields, $c );

					if ( is_array( $subrow_fields ) ) {

						$subrow_fields = $umFields->array_sort_by_column( $subrow_fields, 'position' );

						if ( $cols_num == 1 ) {

							$output .= '<div class="um-col-1">';
							$col1_fields = $umFields->get_fields_in_column( $subrow_fields, 1 );
							if ( $col1_fields ) {
								foreach ( $col1_fields as $key => $data ) {

									$data = $umFields->view_field_output( $data );
									$output .= $umFields->view_field( $key, $data );

								}
							}
							$output .= '</div>';

						} elseif ( $cols_num == 2 ) {

							$output .= '<div class="um-col-121">';
							$col1_fields = $umFields->get_fields_in_column( $subrow_fields, 1 );
							if ( $col1_fields ) {
								foreach ( $col1_fields as $key => $data ) {

									$data = $umFields->view_field_output( $data );
									$output .= $umFields->view_field( $key, $data );

								}
							}
							$output .= '</div>';

							$output .= '<div class="um-col-122">';
							$col2_fields = $umFields->get_fields_in_column( $subrow_fields, 2 );
							if ( $col2_fields ) {
								foreach ( $col2_fields as $key => $data ) {

									$data = $umFields->view_field_output( $data );
									$output .= $umFields->view_field( $key, $data );

								}
							}
							$output .= '</div><div class="um-clear"></div>';

						} else {

							$output .= '<div class="um-col-131">';
							$col1_fields = $umFields->get_fields_in_column( $subrow_fields, 1 );
							if ( $col1_fields ) {
								foreach ( $col1_fields as $key => $data ) {

									$data = $umFields->view_field_output( $data );
									$output .= $umFields->view_field( $key, $data );

								}
							}
							$output .= '</div>';

							$output .= '<div class="um-col-132">';
							$col2_fields = $umFields->get_fields_in_column( $subrow_fields, 2 );
							if ( $col2_fields ) {
								foreach ( $col2_fields as $key => $data ) {

									$data = $umFields->view_field_output( $data );
									$output .= $umFields->view_field( $key, $data );

								}
							}
							$output .= '</div>';

							$output .= '<div class="um-col-133">';
							$col3_fields = $umFields->get_fields_in_column( $subrow_fields, 3 );
							if ( $col3_fields ) {
								foreach ( $col3_fields as $key => $data ) {

									$data = $umFields->view_field_output( $data );
									$output .= $umFields->view_field( $key, $data );

								}
							}
							$output .= '</div><div class="um-clear"></div>';
						}
					}
				}
				$output .= '</div>';
			}
		}
	}
	return $output;
}

?>
