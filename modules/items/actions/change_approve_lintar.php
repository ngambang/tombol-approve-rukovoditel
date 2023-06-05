<?php
global $app_session_token, $alerts;
if(($_POST['form_session_token']!=$app_session_token))
{
    exit();
}

switch($app_module_action)
{
    case 'change_parent':
        $sql_data = array();
        $sql_data['date_updated'] = time();
        $sql_data['date_added'] = time();
        $sql_data['parent_item_id'] = $_POST['parent_item_id'];
        $sql_data['field_'.$_POST['field_kategori']] = $_POST['description'];
        $sql_data['field_'.$_POST['field_status']] = $_POST['status_approve'];
        $sql_data['created_by'] = $app_user['id'];
		db_perform("app_entity_".$_POST['entities_parent_id'],$sql_data);
		
        redirect_to('items/info', 'path=' . $_POST['app_path']);
        break;
}
