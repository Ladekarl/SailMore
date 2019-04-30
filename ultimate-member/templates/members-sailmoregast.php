<?php /* Template: SailMore Gast */ ?>

<!--
***
*** FOR SEARCH FORM
***

<div class="um <?php /*echo $this->get_class( $mode ); */ ?> um-<?php /*echo $form_id; */ ?>">
	<div class="um-form">
		<?php /*do_action('um_members_directory_search', $args ); */ ?>
		<?php /*do_action('um_members_directory_head', $args ); */ ?>
	</div>
</div>
-->

<div class="mec-wrap">
	<div class="mec-event-grid-classic">
		<div class="row">
			<?php $i = 0;
			foreach ( um_members( 'users_per_page' ) as $member ) {
				$i++;
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
									um_fetch_user( $member );
									foreach ( $tagline_fields as $key ) {
										if ( $key == 'sejlperiode_start' ) {
											$value = um_filtered_value( $key );
											if ( !$value )
												continue;
											$pieces = explode(" ", $value);
											?>
											<span class="sm-event-date-num">
											<?php
											_e( trim($pieces[0]), 'ultimate-member' );
											?>
											</span>
											<?php
											?>
											<span class="sm-event-date-month">
											<?php
											_e( trim($pieces[1]), 'ultimate-member' );
											?>
											</span> -</br>
											<?php
										}
										if ( $key == 'sejlperiode_slut' ) {
											$value = um_filtered_value( $key );
											if ( !$value )
												continue;
											$pieces = explode(" ", $value);
											?>
											<span class="sm-event-date-num">
											<?php
											_e( trim($pieces[0]), 'ultimate-member' );
											?>
											</span>
											<?php
											?>
											<span class="sm-event-date-month">
											<?php
											_e( trim($pieces[1]), 'ultimate-member' );
											?>
											</span>
											<?php
										}
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
											um_fetch_user( $member );
											foreach ( $tagline_fields as $key ) {
												if ( $key == 'sejlomraade' ) {
													$value = um_filtered_value( $key );
													if ( !$value )
														continue;
													_e( $value, 'ultimate-member' );

												} // end if
											} // end foreach
											?>
										</div>
										<div class="sm-loc-header-label-um">
											Sejlerfaring
										</div>
										<div class="sm-loc-header-um">
											<?php
											um_fetch_user( $member );
											foreach ( $tagline_fields as $key ) {
												if ( $key == 'sejlerfaring_select' ) {
													$value = um_filtered_value( $key );
													if ( !$value )
														continue;
													_e( $value, 'ultimate-member' );

												} // end if
											} // end foreach
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
									um_fetch_user( $member );
									foreach ( $tagline_fields as $key ) {
										if ( $key == 'description' ) {
											$value = um_filtered_value( $key );
											if ( !$value )
												continue;
											_e( trim( str_replace( array( "<p>", "</p>" ), "", $value ) ), 'ultimate-member' );

										} // end if
									} // end foreach
									?>
								</a></h4>
							<span class="sm-event-post-content-um">
							<?php
							um_fetch_user( $member );
							foreach ( $tagline_fields as $key ) {
								if ( $key == 'beskriv_dig_selv_som_gast' ) {
									$value = um_filtered_value( $key );
									if ( !$value )
										continue;
									_e( $value, 'ultimate-member' );

								} // end if
							} // end foreach
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
							   href="<?php echo um_user_profile_url(); ?>" target="_self">LÆS MERE</a>
						</div>
					</article>
				</div>
			<?php } ?>
		</div>
	</div>
</div>