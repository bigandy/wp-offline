<!DOCTYPE html>
<!--[if IE 9]> <html class="ie9" lang="en" > <![endif]-->
<!--[if gt IE 9]><!--> <html lang="en" > <!--<![endif]-->
	<head>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge" />
		<?php wp_head(); ?>
	</head>
	<body>
		<header>
			<div class="row">
				<div class="large-12 columns">
					<?php
					// only output the menu if there is an admin menu assigned to the 'Primary Navigation'
					if ( has_nav_menu( 'primary' ) ) {
						$primary_menu_args = array(
							'theme_location'  => 'primary',
							'container'       => false,
							'menu_class'      => 'header__top-nav list--inline',
							'menu_id'		  => '',
						);
						wp_nav_menu( $primary_menu_args );
					}
					?>
				</div>
			</div>
		</header>
