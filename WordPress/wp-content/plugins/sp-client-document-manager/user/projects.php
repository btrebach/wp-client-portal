<?php





if(!function_exists('sp_cdm_display_projects')){

function sp_cdm_replace_project_select($pid_selected){
	
	
	global $wpdb,$current_user;



$html = '';



if(@$_GET['id'] != '' && user_can($current_user->ID,'manage_options')){

	$uid = @$_GET['id'];	

}else{

	$uid = $current_user->ID;

}



if(@$_POST['add-project'] != ""){

	

			$insert['name'] = $_POST['project-name'];

			$insert['uid'] = $uid;

	$wpdb->insert( "".$wpdb->prefix . "sp_cu_project",$insert );

}





if (@CU_PREMIUM == 1){  	

		$find_groups = cdmFindGroups($uid,'_project');

			 }else{
				$find_groups = ''; 
			 }






$r_projects_query = "SELECT *

	

									 FROM ".$wpdb->prefix."sp_cu_project

									WHERE  ( uid = '".$uid ."' ".$find_groups.")  

									 ";
			$r_projects_query = apply_filters('sp_cdm_projects_query_dropdown', $r_projects_query ,$uid);							 
			$r_projects_query .="

										ORDER by name";						 
  $projects = $wpdb->get_results($r_projects_query, ARRAY_A);	





  if(count($projects) > 0 or get_option('sp_cu_user_projects') == 1 or get_option('sp_cu_user_projects_required') ==1){



	
if(get_option('sp_cu_user_projects_required') == 1){
	$requird = ' required';	
	}else{
		$requird = '';	
  }

	

	if(get_option('sp_cu_user_projects_required') == 0){	

	$select_dropdown .='<option name="" selected="selected">'.__("No","sp-cdm").' '.sp_cdm_folder_name() .'</option>';	

	}

		for($i=0; $i<count($projects); $i++){

								

		if($pid_selected == $projects[$i]['id'] ){	

			$required = ' selected="selected" '	;

		}else{

			$required = ''	;

		}

		

		if($projects[$i]['name'] != ''){

	 $select_dropdown .='<option value="'.$projects[$i]['id'].'" '.$required.'>'.stripslashes($projects[$i]['name']).'</option>';	

		}

		}

	



	

	$select_dropdown =  apply_filters('wpfh_sub_projects', $select_dropdown ); 	

	$html  .= $select_dropdown;

	

	
	
	  

  }



	return $html;

	
	
	
}


function sp_cdm_display_projects(){

	

	

	global $wpdb,$current_user;



$html = '';



if(@$_GET['id'] != '' && user_can($current_user->ID,'manage_options')){

	$uid = @$_GET['id'];	

}else{

	$uid = $current_user->ID;

}



if(@$_POST['add-project'] != ""){

	

			$insert['name'] = $_POST['project-name'];

			$insert['uid'] = $uid;

	$wpdb->insert( "".$wpdb->prefix . "sp_cu_project",$insert );

}





if (@CU_PREMIUM == 1){  	

		$find_groups = cdmFindGroups($uid,'_project');

			 }else{
				$find_groups = ''; 
			 }






$r_projects_query = "SELECT *

	

									 FROM ".$wpdb->prefix."sp_cu_project

									WHERE  ( uid = '".$uid ."' ".$find_groups.")  

									 ";
			$r_projects_query = apply_filters('sp_cdm_projects_query_dropdown', $r_projects_query ,$uid);							 
			$r_projects_query .="

										ORDER by name";						 
  $projects = $wpdb->get_results($r_projects_query, ARRAY_A);	





  if(count($projects) > 0 or get_option('sp_cu_user_projects') == 1 or get_option('sp_cu_user_projects_required') ==1){

	  $html .= ' <tr>

    <td><strong>'.sp_cdm_folder_name() .'</strong>

	



	

	

	</td>

    <td>';

	
if(get_option('sp_cu_user_projects_required') == 1){
	$requird = ' required';	
	}else{
		$requird = '';	
  }

	$select_dropdown .='

	<select name="pid" class="pid_select'.$requird.'" >';

	

	if(get_option('sp_cu_user_projects_required') == 0){	

	$select_dropdown .='<option name="" selected="selected">'.__("No","sp-cdm").' '.sp_cdm_folder_name() .'</option>';	

	}

		for($i=0; $i<count($projects); $i++){

								

		if($current_user->last_project == $projects[$i]['id'] ){	

			$required = ' selected="selected" '	;

		}else{

			$required = ''	;

		}

		

		if($projects[$i]['name'] != ''){

	 $select_dropdown .='<option value="'.$projects[$i]['id'].'" '.$required.'>'.stripslashes($projects[$i]['name']).'</option>';	

		}

		}

	

	$select_dropdown .='</select>';

	

	$select_dropdown =  apply_filters('wpfh_sub_projects', $select_dropdown ); 	

	$html  .= $select_dropdown;

	

	if(get_option('sp_cu_user_projects') == 1  or current_user_can( 'manage_options' )){

		

		$html .= '<a href="javascript:sp_cu_dialog(\'#sp_cu_add_project\',550,130)" class="button" style="margin-left:15px">'.__("Add","sp-cdm").' '.sp_cdm_folder_name() .'</a>

		

	

		

		';

		

	}

	$html .='</td>

  </tr>';

	  

  }



	return $html;

	

}


function sp_cdm_display_projects_select($id){

	

	

	global $wpdb,$current_user;



$html = '';



if(@$_GET['id'] != '' && user_can($current_user->ID,'manage_options')){

	$uid = @$_GET['id'];	

}else{

	$uid = $current_user->ID;

}



if(@$_POST['add-project'] != ""){

	

			$insert['name'] = $_POST['project-name'];

			$insert['uid'] = $uid;

	$wpdb->insert( "".$wpdb->prefix . "sp_cu_project",$insert );

}





if (@CU_PREMIUM == 1){  	

		$find_groups = cdmFindGroups($uid,'_project');

			 }else{
				$find_groups = ''; 
			 }






$r_projects_query = "SELECT *

	

									 FROM ".$wpdb->prefix."sp_cu_project

									WHERE  ( uid = '".$uid ."' ".$find_groups.")  

									 ";
			$r_projects_query = apply_filters('sp_cdm_projects_query_dropdown', $r_projects_query ,$uid);							 
			$r_projects_query .="

										ORDER by name";						 
  $projects = $wpdb->get_results($r_projects_query, ARRAY_A);	





  if(count($projects) > 0 or get_option('sp_cu_user_projects') == 1){

	  $html .= ' <tr>

    <td><strong>'.sp_cdm_folder_name() .'</strong>

	



	

	

	</td>

    <td>';

	

	$select_dropdown .='

	<select name="pid" class="pid_select">';

	

	if(get_option('sp_cu_user_projects_required') == 0){	

	$select_dropdown .='<option name="" selected="selected">'.__("No","sp-cdm").' '.sp_cdm_folder_name() .'</option>';	

	}

		for($i=0; $i<count($projects); $i++){

								

		if($current_user->last_project == $projects[$i]['id'] ){	

			$required = ' selected="selected" '	;

		}else{

			$required = ''	;

		}

		

		if($projects[$i]['name'] != ''){

	 $select_dropdown .='<option value="'.$projects[$i]['id'].'" '.$required.'>'.stripslashes($projects[$i]['name']).'</option>';	

		}

		}

	

	$select_dropdown .='</select>';

	

	$select_dropdown =  apply_filters('wpfh_sub_projects', $select_dropdown ); 	

	$html  .= $select_dropdown;

	

	if(get_option('sp_cu_user_projects') == 1  or current_user_can( 'manage_options' )){

		

		$html .= '<a href="javascript:sp_cu_dialog(\'#sp_cu_add_project\',550,130)" class="button" style="margin-left:15px">'.__("Add","sp-cdm").' '.sp_cdm_folder_name() .'</a>

		

	

		

		';

		

	}

	$html .='</td>

  </tr>';

	  

  }



	return $html;

	

}



}



?>