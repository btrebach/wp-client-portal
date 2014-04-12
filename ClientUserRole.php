/* Add client user role */

add_role('client', 'Client', array(
    'read' => true,
    'edit_posts' => false,
    'delete_posts' => false,
));