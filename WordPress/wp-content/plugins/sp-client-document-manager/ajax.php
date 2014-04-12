<?php


require( '../../../wp-load.php' );
	
	
$upload_dir = wp_upload_dir();	
	
	
	$function = $_GET['function'];
	
	
	
	
	switch($function){
		
		case "check-file-permissions":
		
		echo cdm_file_permissions($_GET['pid']);
		break;
		case "check-folder-permissions":
		
		echo cdm_folder_permissions($_GET['pid']);
		break;
		  case "reload-project-dropdown":
		echo $spcdm_ajax->project_dropdown();
		break;
		case "delete-file":
		echo $spcdm_ajax->delete_file();	
		break;
		case "get-file-info":
		echo $spcdm_ajax->get_file_info();
		break;
		case "remove-category":
		
		echo $spcdm_ajax->remove_cat();
	
		break;	
		
		case "save-category":
		echo $spcdm_ajax->save_cat($_REQUEST['uid']);
		
		break;
		
		case"view-file":
		echo $spcdm_ajax->view_file();	
		break;
		
		case "file-list":
		
		echo $spcdm_ajax->file_list();		
		
		break;
		
		case "thumbnails":
		
		echo $spcdm_ajax->thumbnails();		
		
		break;
		
		case "download-project":
			
		echo $spcdm_ajax->download_project();		
		
		break;
		case "download-archive":
		
			echo $spcdm_ajax->download_archive();		
		
		break;
	
	case"email-vendor":

		echo $spcdm_ajax->email_vendor();		
	break;	
		
		
		
	}

?>