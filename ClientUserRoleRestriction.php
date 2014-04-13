/* Restrict access for client user role */ 

function restrict_access_admin_panel()
{
	global $current_user;
	get_currentuserinfo();
	if ($current_user->user_level < 5)
	{
	wp_redirect( get_bloginfo('url') );
	exit;
	}
}

add_action('admin_init', 'restrict_access_admin_panel', 1);