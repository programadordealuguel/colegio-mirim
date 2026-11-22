<?php
/**
 * Permite entrar no painel com o usuário suporte@pda.
 * O WordPress remove o @ antes de procurar o login.
 */

add_filter(
	'authenticate',
	function ( $user, $username, $password ) {
		if ( $user instanceof WP_User || '' === (string) $password ) {
			return $user;
		}

		$typed = isset( $_POST['log'] ) ? wp_unslash( $_POST['log'] ) : $username;
		if ( 'suporte@pda' !== $typed && 'suportepda' !== $username ) {
			return $user;
		}

		$found = get_user_by( 'login', 'suporte@pda' );
		if ( $found && wp_check_password( $password, $found->user_pass, $found->ID ) ) {
			return $found;
		}

		return $user;
	},
	20,
	3
);
