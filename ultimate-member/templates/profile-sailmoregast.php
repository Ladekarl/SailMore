<?php /* Template: SailMore Gast */ ?>
	<div class="um <?php echo $this->get_class( $mode ); ?> um-<?php echo esc_attr( $form_id ); ?> um-role-<?php echo um_user( 'role' ); ?> ">
		<div class="um-meta-text">
			<?php
			sm_fetch_user();
			$description = get_user_meta( um_user( 'ID' ), 'description', true );
			echo esc_html( $description );
			?>
		</div>

		<div class="um-form sm-profile-container">
			<?php
			extract( $args );

			if ( !UM()->options()->get( 'profile_tab_main' ) && !isset( $_REQUEST['um_action'] ) )
				return;

			$can_view = apply_filters( 'um_profile_can_view_main', -1, um_profile_id() );

			$profile = UM()->user()->profile;

			if ( $can_view == -1 ) {
				sm_profile_header( $profile );
				sm_profile_content_main( $profile );
			} else { ?>
				<div class="um-profile-note"><span><i class="um-faicon-lock"></i><?php echo $can_view; ?></span></div>
			<?php }
			?>
		</div>
	</div>

<?php
function sm_profile_header( $profile )
{
	?>
	<div class="um-header no-cover">
		<div class="um-profile-photo" data-user_id="<?php echo um_profile_id(); ?>">
			<?php echo um_user( 'cover_photo' ); ?>
		</div>
		<?php
		$uris = [];
		if ( isset( $profile['billede_af_person_1'] ) ) {
			array_push( $uris, UM()->files()->get_download_link( 2756, 'billede_af_person_1', um_user( 'ID' ) ) );
		}
		if ( isset( $profile['billede_af_person_2'] ) ) {
			array_push( $uris, UM()->files()->get_download_link( 2756, 'billede_af_person_2', um_user( 'ID' ) ) );
		}
		if ( isset( $profile['billede_af_person_3'] ) ) {
			array_push( $uris, UM()->files()->get_download_link( 2756, 'billede_af_person_3', um_user( 'ID' ) ) );
		}
		if ( isset( $profile['billede_af_person_4'] ) ) {
			array_push( $uris, UM()->files()->get_download_link( 2756, 'billede_af_person_4', um_user( 'ID' ) ) );
		}

		?>

		<div class="sm-profile-description">
			<div class="sm-photo-container">
				<?php
				foreach ( $uris as $uri ) {
					if ( isset( $uri ) ) {
						echo '<div class="um-photo"><a href="#" class="um-photo-modal" data-src="' . esc_attr( $uri ) . '"><img src="' . esc_attr( $uri ) . '" /></a></div>';
					}
				}
				?>
			</div>
			<div class="sm-profile-description-title">
				Lidt om mig ...
			</div>
			<div class="sm-profile-description-header-content">
				<?php
				echo $profile['beskriv_dig_selv_som_gast']
				?>
			</div>
			<div class="sm-contact-container">
				<a class="sm-profile-contact-button" href="<?php echo fep_query_url('newmessage', array('to' => um_user( 'ID' ) ) ); ?>">
					Kontakt mig
				</a>
			</div>
		</div>
		<div class="um-clear"></div>
	</div>
	<?php
}

function sm_profile_content_main( $profile )
{
	$periods = [];

	if ( isset( $profile['sejlperiode_start'] ) && isset( $profile['sejlperiode_slut'] ) ) {
		array_push( $periods, date( 'd/m/Y', strtotime( $profile['sejlperiode_start'] ) ) . ' - ' . date( 'd/m/Y', strtotime( $profile['sejlperiode_slut'] ) ) );
	}
	if ( isset( $profile['sejlperiode_start_2'] ) && isset( $profile['sejlperiode_slut_2'] ) ) {
		array_push( $periods, date( 'd/m/Y', strtotime( $profile['sejlperiode_start_2'] ) ) . ' - ' . date( 'd/m/Y', strtotime( $profile['sejlperiode_slut_2'] ) ) );
	}
	if ( isset( $profile['sejlperiode_start_3'] ) && isset( $profile['sejlperiode_slut_3'] ) ) {
		array_push( $periods, date( 'd/m/Y', strtotime( $profile['sejlperiode_start_3'] ) ) . ' - ' . date( 'd/m/Y', strtotime( $profile['sejlperiode_slut_3'] ) ) );
	}

	?>
	<div class="sm-profile-content sm-profile-description">
		<?php
		if ( isset( $profile['sejlerfaring_select_gast'] ) )
			add_content( 'Sejlerfaring', $profile['sejlerfaring_select_gast'] );
		if ( isset( $profile['gast_eller_gaest'] ) )
			add_content( 'Gast eller gæst?', extract_content( $profile['gast_eller_gaest'] ), 'jeg vil gerne rejse med som' );
		if ( isset( $profile['sejlomraade'] ) )
			add_content( 'Sejlområder', extract_content( $profile['sejlomraade'] ), 'jeg vil gerne sejle i' );
		if ( isset( $profile['sejlomraade'] ) )
			add_content( 'Sejlområder', $periods, 'jeg kan sejle med' );
		if ( isset( $profile['rejselaengde'] ) )
			add_content( 'Rejselængde', extract_content( $profile['rejselaengde'] ), 'jeg kan sejle med i' );
		if ( isset( $profile['sejladstype'] ) )
			add_content( 'Sejladstype', extract_content( $profile['sejladstype'] ), 'jeg vil helst sejle' );
		if ( isset( $profile['skills'] ) )
			add_content( 'Mine skills', extract_content( $profile['skills'] ), 'jeg kan bidrage med' );
		if ( isset( $profile['aktiviteter'] ) )
			add_content( 'Aktiviteter', extract_content( $profile['aktiviteter'] ), 'jeg er glad for' );
		?>
	</div>
	<?php
}

function add_content( $title, $content, $description = null )
{
	?>
	<div class="sm-profile-description-title">
		<?php
		echo $title
		?>
	</div>
	<?php if ( isset( $description ) ) { ?>
	<div class="sm-profile-description-text">
		<?php
		echo $description;
		?>
	</div>
<?php } ?>
	<div class="sm-profile-description-content-wrapper">
		<?php
		if ( is_array( $content ) ) {
			foreach ( $content as $cont ) {
				?>
				<div class="sm-profile-description-content">
					<?php
					echo $cont;
					?>
				</div>
				<?php
			}
		} else {
			?>
			<div class="sm-profile-description-content">
				<?php
				echo $content;
				?>
			</div>
			<?php
		}
		?>
	</div>
	<?php
}

function extract_content( $arr )
{
	$explodedArr = explode( '"', $arr );
	$contentArr = [];
	for ( $i = 0; $i < count( $explodedArr ); $i++ ) {
		if ( ( $i % 2 ) - 1 == 0 ) {
			array_push( $contentArr, $explodedArr[$i] );
		}
	}
	return $contentArr;
}

function sm_fetch_user()
{
	if ( um_queried_user() ) {
		if ( UM()->options()->get( 'permalink_base' ) == 'user_login' ) {

			$user_id = username_exists( um_queried_user() );
			//Try
			if ( !$user_id ) {
				$permalink_base = UM()->options()->get( 'permalink_base' );

				// Search by Profile Slug
				$args = array(
					"fields" => 'ids',
					'meta_query' => array(
						array(
							'key' => 'um_user_profile_url_slug_' . $permalink_base,
							'value' => strtolower( um_queried_user() ),
							'compare' => '='
						)
					),
					'number' => 1
				);


				$ids = new \WP_User_Query( $args );
				if ( $ids->total_users > 0 ) {
					$user_id = current( $ids->get_results() );
				}
			}

			// Try nice name
			if ( !$user_id ) {
				$slug = um_queried_user();
				$slug = str_replace( '.', '-', $slug );
				$the_user = get_user_by( 'slug', $slug );
				if ( isset( $the_user->ID ) ) {
					$user_id = $the_user->ID;
				}

				if ( !$user_id )
					$user_id = UM()->user()->user_exists_by_email_as_username( um_queried_user() );

				if ( !$user_id )
					$user_id = UM()->user()->user_exists_by_email_as_username( $slug );

			}

		}

		if ( UM()->options()->get( 'permalink_base' ) == 'user_id' ) {
			$user_id = UM()->user()->user_exists_by_id( um_queried_user() );
		}

		if ( in_array( UM()->options()->get( 'permalink_base' ), array( 'name', 'name_dash', 'name_dot', 'name_plus' ) ) ) {
			$user_id = UM()->user()->user_exists_by_name( um_queried_user() );
		}

		/** USER EXISTS SET USER AND CONTINUE **/

		if ( $user_id ) {
			um_set_requested_user( $user_id );
			sm_access_profile( $user_id );
		} else {
			exit( wp_redirect( um_get_core_page( 'user' ) ) );
		}

	}
}

function sm_access_profile( $user_id )
{
	um_fetch_user( $user_id );

	$account_status = um_user( 'account_status' );

	if ( !in_array( $account_status, array( 'approved' ) ) ) {
		um_redirect_home();
	}
}
