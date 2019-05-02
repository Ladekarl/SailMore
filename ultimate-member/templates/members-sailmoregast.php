<?php /* Template: SailMore Gast */ ?>
<div class="mec-wrap sm-members-wrap">
	<div class="um <?php echo $this->get_class( $mode ); ?> um-<?php echo $form_id; ?>">
		<div class="um-form">
			<?php do_action( 'um_members_directory_search', $args ); ?>
			<?php do_action( 'um_members_directory_head', $args ); ?>
		</div>
	</div>
	<div class="mec-event-grid-classic">
		<?php $i = 0;
		foreach ( array_chunk( um_members( 'users_per_page' ), 4, true ) as $members ) {
			$i++;
			echo '<div class="row">';
			foreach ( $members as $member ) {
				um_fetch_user( $member ); ?>
				<div class="col-md-3 col-sm-3">
					<article data-style="" class="mec-event-article sm-event-article mec-clear ">
						<div class="mec-event-image sm-event-image">
							<a href="<?php echo um_user_profile_url(); ?>"
							   title="<?php echo esc_attr( um_user( 'display_name' ) ); ?>"><?php echo get_avatar( um_user( 'ID' ), $default_size ); ?></a>
						</div>
						<div class="mec-event-content sm-event-content">
							<div class="mec-event-date mec-bg-color sm-event-date-wrapper">
								<div class="sm-event-date">
									<div class="sm-event-date-top">
										<?php
										$key = 'sejlperiode_start';
										$value = um_filtered_value( $key );
										if ( $value )
											$piecesStart = explode( " ", $value );
										if ( $piecesStart ) {
											echo '<span class="sm-event-date-num">';
											_e( trim( $piecesStart[0] ), 'ultimate-member' );
											echo '</span>';
											echo '<span class="sm-event-date-month">';
											_e( trim( $piecesStart[1] ), 'ultimate-member' );
											echo '</span> -</br>';
										}
										$key = 'sejlperiode_slut';
										$value = um_filtered_value( $key );
										if ( $value )
											$piecesSlut = explode( " ", $value );
										if ( $piecesSlut ) {
											echo '<span class="sm-event-date-num">';
											_e( trim( $piecesSlut[0] ), 'ultimate-member' );
											echo '</span>';
											echo '<span class="sm-event-date-month">';
											_e( trim( $piecesSlut[1] ), 'ultimate-member' );
										}
										?>
									</div>
								</div>
								<div class="sm-event-loc">
									<i class="mec-sl-location-pin sm-location-pin-um"></i>
									<div class="sm-loc-text">
										<div class="sm-loc-header-label-um">
											Sejlområde
										</div>
										<div class="sm-loc-header-um">
											<?php
											$key = 'sejlomraade';
											$value = um_filtered_value( $key );
											if ( $value )
												_e( $value, 'ultimate-member' );
											?>
										</div>
										<div class="sm-loc-header-label-um">
											Sejlerfaring
										</div>
										<div class="sm-loc-header-um">
											<?php
											$key = 'sejlerfaring_select';
											$value = um_filtered_value( $key );
											if ( $value )
												_e( $value, 'ultimate-member' );
											?>
										</div>
										<div class="sm-loc-body">
										</div>
									</div>
								</div>
							</div>
							<h4 class="mec-event-title sm-event-title"><a class="mec-color-hover" data-event-id="2570"
																		  href="<?php echo um_user_profile_url(); ?>">
									<?php
									$key = 'description';
									$value = um_filtered_value( $key );
									if ( $value )
										_e( trim( str_replace( array( "<p>", "</p>" ), "", $value ) ), 'ultimate-member' );
									?>
								</a></h4>
							<span class="sm-event-post-content-um">
							<?php
							$key = 'beskriv_dig_selv_som_gast';
							$value = um_filtered_value( $key );
							if ( $value )
								_e( $value, 'ultimate-member' );
							?>
					</span>
						</div>
						<div class="mec-event-footer sm-event-footer">
							<ul class="mec-event-sharing-wrap sm-event-sharing-wrap">
								<li class="mec-event-share">
									<a href="#" class="mec-event-share-icon">
										<i class="mec-sl-share"></i>
									</a>
								</li>
								<ul class="mec-event-sharing"></ul>
							</ul>
							<a class="mec-booking-button sm-booking-button" data-event-id="2570"
							   href="<?php echo '/user/' . um_filtered_value( 'user_login' ) ?>" target="_self">LÆS
								MERE</a>
						</div>
					</article>
				</div>
			<?php }
			echo '</div>';
		}
		?>
	</div>
</div>
