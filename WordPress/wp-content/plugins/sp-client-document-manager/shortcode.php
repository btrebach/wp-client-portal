<?php
function sp_cdm_display_project_shortcode($atts)
{
    global $wpdb, $current_user, $user_ID;
    $pid       = $atts['project'];
    $date      = $atts['date'];
    $order     = $atts['order'];
    $direction = $atts['direction'];
    $limit     = $atts['limit'];
    if ($order == "") {
        $order = 'name';
    } else {
        $order = $order;
    }
    if ($limit != "") {
        $limit = ' LIMIT ' . $limit . '';
    } else {
        $limit = '';
    }
    if ($pid == '') {
        $content .= '<p style="color:red">No project selected</p>';
    } else {
        $r = $wpdb->get_results("SELECT *  FROM " . $wpdb->prefix . "sp_cu   where pid = '" . $pid . "'  order by " . $order . " " . $direction . " " . $limit . "", ARRAY_A);
        $content .= '<ul>';
        for ($i = 0; $i < count($r); $i++) {
            if ($date == 1) {
                $inc_date = '<em style="font-size:10px"> - ' . date("F Y g:i A", strtotime($r[$i]['date'])) . '</em>';
            } else {
                $inc_date = '';
            }
            $content .= '<li><a href="' . SP_CDM_PLUGIN_URL . 'download.php?fid=' . base64_encode($r[$i]['id'].'|'.$r[$i]['date'].'|'.$r[$i]['file']) . '">' . stripslashes($r[$i]['name']) . '</a> ' . $inc_date . ' </li>';
        }
        $content .= '</ul>';
    }
    return $content;
}
add_shortcode('cdm-project', 'sp_cdm_display_project_shortcode');
function sp_cdm_file_link_shortcode($atts)
{
    global $wpdb, $current_user, $user_ID;
    $fid  = $atts['file'];
    $date = $atts['date'];
    $real = $atts['real'];
    if ($fid == '') {
        $content = '<a href="#" style="color:red">No file  selected</a>';
    } else {
        $r = $wpdb->get_results("SELECT *  FROM " . $wpdb->prefix . "sp_cu   where id = '" . $fid . "'  order by date desc", ARRAY_A);
        if ($real == 1) {
            return '' . SP_CDM_UPLOADS_DIR_URL . '' . $r[0]['uid'] . '/' . $r[0]['file'] . '';
        } else {
            if ($date == 1) {
                $inc_date = '<em  style="font-size:10px"> - ' . date("F Y g:i A", strtotime($r[0]['date'])) . '</em>';
            } else {
                $inc_date = '';
            }
            $content = '<a href="' . SP_CDM_PLUGIN_URL . 'download.php?fid=' . base64_encode($r[0]['id'].'|'.$r[0]['date'].'|'.$r[0]['file']) . '" >' . stripslashes($r[0]['name']) . '</a> ' . $inc_date . ' </a>';
        }
        return $content;
    }
}
add_shortcode('cdm-link', 'sp_cdm_file_link_shortcode');
function display_sp_thumbnails2($r)
{
    global $wpdb, $current_user, $user_ID;
	$content = '';
    if (get_option('sp_cu_wp_folder') == '') {
        $wp_con_folder = '/';
    } else {
        $wp_con_folder = get_option('sp_cu_wp_folder');
    }
    $content .= '

	

	<script type="text/javascript">

	

	function sp_cdm_sort(sort,pid){

	if(pid != ""){

		var pidurl = "&pid=" + pid;

	}else{

		var pidurl = "&cid=" + pid;	

	}

		jQuery("#cmd_file_thumbs").load("' . SP_CDM_PLUGIN_URL . 'ajax.php?function=file-list&uid=' . $user_ID . '&sort=" + sort + "" + pidurl);	

}



	

	function sp_cdm_loading_image(){

		jQuery("#cmd_file_thumbs").html(\'<div style="padding:100px; text-align:center"><img src="' . SP_CDM_PLUGIN_URL . 'images/loading.gif"></div>\');		

	}

	function sp_cdm_load_file_manager(){

		sp_cdm_loading_image();

	jQuery("#cmd_file_thumbs").load("' . SP_CDM_PLUGIN_URL . 'ajax.php?function=file-list&uid=' . $user_ID . '");	

	cdm_ajax_search();

	}

	

	jQuery(document).ready( function() {

			
var pid = jQuery.cookie("pid");

	if(pid != 0){
	sp_cdm_load_project(pid)
	}else{
	sp_cdm_load_file_manager();	
	}
			

		

		 



			

		});

		

		

		function sp_cdm_load_project(pid){

			sp_cdm_loading_image();
	jQuery("#cdm_current_folder").val(pid);
	
	jQuery(".cdm_premium_pid_field").attr("value", pid);
	jQuery.cookie("pid", pid, { expires: 7 });
	
			if(pid != 0 && jQuery("#cdm_premium_sub_projects").val() != 1){
				jQuery(".cdm_add_folder_button").hide();	
			
				}else{
				jQuery(".cdm_add_folder_button").show();
			
				}
	    cdm_check_folder_perms(pid);
		  cdm_check_file_perms(pid);
		  jQuery(".cdm_premium_pid_field").val(pid);
		jQuery("#cmd_file_thumbs").load("' . SP_CDM_PLUGIN_URL . 'ajax.php?function=file-list&uid=' . $user_ID . '&pid=" + pid);	

		

		}

		

		

		function sp_cdm_showFile(file){

			

		  var url = "' . SP_CDM_PLUGIN_URL . 'ajax.php?function=view-file&id=" + file;

		  

		 

            // show a spinner or something via css

            var dialog = jQuery(\'<div style="display:none" class="loading viewFileDialog"></div>\').appendTo(\'body\');

          

		  



     var fileArray = new Array();      

	 var obj_file_info =   jQuery.getJSON("' . SP_CDM_PLUGIN_URL . 'ajax.php?function=get-file-info&type=name&id=" + file, function(data) {

   



	

		

  	fileArray[name] =data.name;

	var final_title = fileArray[name];

       });

		 



		 

		 var final_title = fileArray[name];

		

		      dialog.dialog({

               

                close: function(event, ui) {

                    // remove div with all data and events

                    dialog.remove();

                },

                modal: true,
				autoResize:true,

				height:"auto",

				width:850,

				title: final_title 

            });

			

			 // load remote content

            dialog.load(

                url, 

                {}, // omit this param object to issue a GET request instead a POST request, otherwise you may provide post parameters within the object

                function (responseText, textStatus, XMLHttpRequest) {

                    // remove the loading class

                    dialog.removeClass(\'loading\');

                }

            );

			

			

		



		}

	</script>
';
$content .='<form id="cdm_wrapper_form">';
$extra_js = '';

$extra_js = apply_filters('sp_cdm_uploader_above',$extra_js);


$content .='
	'.$extra_js.'
	
  <input type="hidden" name="cdm_current_folder" id="cdm_current_folder" value="0">
	<div id="cdm_wrapper">

	<div id="cmd_file_thumbs">

	<div style="padding:100px; text-align:center"><img src="' . SP_CDM_PLUGIN_URL . 'images/loading.gif"></div>	

	

	</div>

	<div style="clear:both"></div>

	</div>
</form>
	';
    return $content;
}
function display_sp_thumbnails($r)
{
    global $wpdb, $current_user, $user_ID;
    if (get_option('sp_cu_wp_folder') == '') {
        $wp_con_folder = '/';
    } else {
        $wp_con_folder = get_option('sp_cu_wp_folder');
    }
    $html .= '<script type="text/javascript" src="' . plugins_url('js/jqueryFileTree/jqueryFileTree.js', __FILE__) . '"></script>

			<link rel="stylesheet" type="text/css" media="all" href="' . plugins_url('js/jqueryFileTree/jqueryFileTree.css', __FILE__) . '" />

		';
    $html .= "

	<div class=\"sp_cu_filetree\">

	<script type=\"text/javascript\">

	

	

	function cdm_load_simple_file_manager(){

		

		var cdm_search = jQuery('#search_files').val();

		

		

	jQuery('#file_manager').fileTree({

        root: '" . SP_CDM_UPLOADS_DIR_URL . "" . $user_ID . "/',

        script: '" . SP_CDM_PLUGIN_URL . "ajax.php?function=file-tree&uid=" . $user_ID . "&search=' + cdm_search,

        expandSpeed: 100,

        collapseSpeed: 100,

        multiFolder: false

    }, function(file) {

       // alert(file);

	   

	   

	   	  var url = '" . SP_CDM_PLUGIN_URL . "ajax.php?function=view-file&id=' + file;

		 //alert( url);

            // show a spinner or something via css

            var dialog = jQuery('<div style=\"display:none\" class=\"loading viewFileDialog\"></div>').appendTo('body');

            // open the dialog

            dialog.dialog({

                // add a close listener to prevent adding multiple divs to the document

                close: function(event, ui) {

                    // remove div with all data and events

                    dialog.remove();

                },

                modal: true,

				height:'auto',

				width:850

            });

            // load remote content

            dialog.load(

                url, 

                {}, // omit this param object to issue a GET request instead a POST request, otherwise you may provide post parameters within the object

                function (responseText, textStatus, XMLHttpRequest) {

                    // remove the loading class

                    dialog.removeClass('loading');

                }

            );

	   

	   

	   

	   

	   //end functions

	   

    });	

		

	}

	

	

	jQuery(document).ready( function() {

		cdm_load_simple_file_manager();

    

});

	</script>

	

	<div id=\"file_manager\">

	

	</div></div>

	";
    return $html;
}
if (!function_exists('display_sp_upload_form')) {
    function display_sp_upload_form()
    {
		$html = '';
        global $wpdb, $current_user;
        $hidden .= '

<script type="text/javascript">





function sp_cdm_change_indicator(){

	



jQuery(".sp_change_indicator_button").hide();

jQuery(".sp_change_indicator").slideDown();







jQuery(\'.sp_change_indicator\').html(\'<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,40,0"  width="204" height="16"  id="mymoviename"><param name="movie" value="' . SP_CDM_PLUGIN_URL . 'image_138464.swf" /><param name="quality" value="high" /><param name="bgcolor" value="#ffffff" /><embed src="' . SP_CDM_PLUGIN_URL . 'image_138464.swf" quality="high" bgcolor="#ffffff" width="204" height="16" name="mymoviename" align="" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer"></embed></object><br><em>Please wait, your file is currently uploading! </em>\');

document.forms["sp_upload_form"].submit();

return true;



}





jQuery(document).ready(function() {

	jQuery("#upload_form").simpleValidate({

	  errorElement: "em",

	  ajaxRequest: false,

	  errorText: "' . __("Required", "sp-cdm") . '",

	   completeCallback: function() {

   

	  sp_cdm_change_indicator();

	  }

	});

});





function sp_cu_add_project(){

	

	jQuery.ajax({

   type: "POST",

   url: "' . SP_CDM_PLUGIN_URL . 'ajax.php?function=save-category",

   data: "name=" + jQuery("#sub_category_name").val() + "&uid=" +  jQuery("#sub_category_uid").val()+ "&parent=" +  jQuery("#sub_category_parent").val(),

   success: function(msg){

  

   jQuery("#sp_cu_add_project").dialog("close");
cdm_ajax_search();


	

	jQuery(".pid_select").append(jQuery("<option>", { 

    value: msg, 

    text : jQuery("#sub_category_name").val(),

	selected : "selected"

 	 }

	 ));

  

   }

 });

}

</script>';

 $hidden.='
<div style="display:none">';
        $add_project = '<div  id="sp_cu_add_project">

		<input type="hidden" id="sub_category_uid" name="uid" value="' . $current_user->ID . '">
		
		

		'.sp_cdm_folder_name() .' ' . __("Name", "sp-cdm") . ' <input  id="sub_category_name" type="text" name="project-name"  style="width:200px !important"> 

		<input type="submit" value="' . __("Add", "sp-cdm") . ' '.sp_cdm_folder_name() .'" name="add-project" onclick="sp_cu_add_project()">

	

	</div>';
        $add_project = apply_filters('sp_cdm_add_project_form', $add_project);
        $hidden .= '' . $add_project . '

	

<div id="sp_cu_confirm_delete">

<p>' . get_option('sp_cu_delete') . '</p>

</div>



<div id="sp_cu_thankyou">

<p>' . get_option('sp_cu_thankyou') . '</p>

</div>





		



</div>';

$html .='



<form  action="' . $_SERVER['REQUEST_URI'] . '" method="post" enctype="multipart/form-data" id="upload_form" name="sp_upload_form" >';
        $html .= '<div>

			<p>' . stripslashes(get_option('sp_cu_form_instructions')) . '</p>

				  <table width="100%" cellpadding="2" cellspacing="2" style="border:none;padding:0px;margin:0px;">

  <tr>

    <td>' . __("File Name:", "sp-cdm") . '</td>

    <td><input  type="text" name="dlg-upload-name" class="required"></td>

  </tr>

  

  ';
  
  
  		
        $html .= sp_cdm_display_projects();
      
	    if (@CU_PREMIUM == 1) {
            $html .= sp_cdm_display_categories();
        }
		
		
        $html .= '

  <tr>

    <td>' . __("File:", "sp-cdm") . '</td>

    <td>	<div id="cdm_upload_fields">    <input id="file_upload" name="dlg-upload-file[]" type="file" class="required">

<div id="upload_list"></div></div>

							</td>

  </tr>';
        if (@CU_PREMIUM == 1) {
            if (get_option('sp_cu_enable_tags') == 1) {
                $html .= '

  <tr>

    <td>' . __("Tags:", "sp-cdm") . '</td>

    <td><textarea id="tags" name="tags"  style="width:90%;height:30px"></textarea></td>

  </tr>';
            }
            $html .= display_sp_cdm_form();
        } else {
            $html .= '<tr>

    <td>' . __("Notes:", "sp-cdm") . '</td>

    <td><textarea style="width:90%;height:50px" name="dlg-upload-notes"></textarea></td>

  </tr>

  ';
        }
		
		$spcdm_form_upload_fields = '';
		$spcdm_form_upload_fields .= apply_filters('spcdm_form_upload_fields',$spcdm_form_upload_fields);
		$html .= $spcdm_form_upload_fields;
		
		
        $html .= '

  <tr>

    <td>&nbsp;</td>

    <td>

						<div class="sp_change_indicator_button"><input id="dlg-upload"  type="submit" name="submit" value="Upload" ></div>

						<div class="sp_change_indicator" ></div>	

							</td>

  </tr>';
        $html .= '

</table></div>';
        $html .= '



	</form>

	

	

	';
	
	if (class_exists('cdmPremiumUploader') && get_option('sp_cu_free_uploader') != 1) {
		   global $cdmPremiumUploader;
        $premium_uploader = $cdmPremiumUploader->construct();
		return $premium_uploader. $hidden;
	}else{
        return $html. $hidden;
	}
    }
    function check_folder_sp_client_upload()
    {
        global $user_ID;
        $dir = '' . SP_CDM_UPLOADS_DIR . '' . $user_ID . '/';
        if (!is_dir($dir)) {
            mkdir($dir, 0777);
        }
    }
	
	
    function sp_cu_process_email($id, $email)
    {
        global $wpdb;
        $r = $wpdb->get_results("SELECT *  FROM " . $wpdb->prefix . "sp_cu   where id = '" . $id . "'  order by date desc", ARRAY_A);
        if ($r[0]['pid'] != "") {
            $r_project = $wpdb->get_results("SELECT *  FROM " . $wpdb->prefix . "sp_cu_project   where id = " . $r[0]['pid'] . "", ARRAY_A);
        }
        if ($r[0]['cid'] != "") {
            $r_cats = $wpdb->get_results("SELECT *  FROM " . $wpdb->prefix . "sp_cu_cats   where id = " . $r[0]['cid'] . "", ARRAY_A);
        }
        if (@CU_PREMIUM == 1) {
            $notes = stripslashes(sp_cdm_get_form_fields($r[0]['id']));
        } else {
            $notes = stripslashes($r[0]['notes']);
        }
        $user_info = get_userdata($r[0]['uid']);
        $message   = nl2br($email);
        $message = apply_filters('sp_cdm_shortcode_email_before',$message,$r ,$r_project,$r_cats);	
	    $message   = str_replace('[file]', '<a href="' . SP_CDM_PLUGIN_URL . 'download.php?fid=' . base64_encode($r[$i]['id'].'|'.$r[$i]['date'].'|'.$r[$i]['file'])  . '">' . $r[0]['file'] . '</a>', $message);
        $message   = str_replace('[file_name]',$r[0]['file'], $message);
		$message   = str_replace('[file_real_path]', '' . SP_CDM_UPLOADS_DIR_URL . '' . $r[0]['uid'] . '/' . $r[0]['file'] . '', $message);
		$message   = str_replace('[notes]', $notes, $message);
        $message   = str_replace('[user]', $user_info->display_name , $message);
         $message   = str_replace('[uid]', $user_info->ID, $message);
	    $message   = str_replace('[project]', stripslashes($r_project[0]['name']), $message);
        $message   = str_replace('[category]', stripslashes($r_cats[0]['name']), $message);
        $message   = str_replace('[user_profile]', '<a href="' . admin_url('user-edit.php?user_id=' . $r[0]['uid'] . '') . '">' . admin_url('user-edit.php?user_id=' . $r[0]['uid'] . '') . '</a>', $message);
        $message   = str_replace('[client_documents]', '<a href="' . admin_url('admin.php?page=sp-client-document-manager') . '">' . admin_url('admin.php?page=sp-client-document-manager') . '</a>', $message);
         $message = apply_filters('sp_cdm_shortcode_email_after',$message,$r ,$r_project,$r_cats);	
	    return $message;
    }
    function display_sp_client_upload_process()
    {
        global $wpdb;
        global $user_ID;
        global $current_user;
        if ($_GET['dlg-delete-file'] != "") {
            $r = $wpdb->get_results("SELECT *  FROM " . $wpdb->prefix . "sp_cu   where  id = " . $_GET['dlg-delete-file'] . "", ARRAY_A);
            unlink('' . SP_CDM_UPLOADS_DIR . '' . $r[0]['uid'] . '/' . $r[0]['file'] . '');
            $wpdb->query("

	DELETE FROM " . $wpdb->prefix . "sp_cu WHERE id = " . $_GET['dlg-delete-file'] . "

	");
        }
        if ($_POST['submit'] != "") {
            $data       = $_POST;
            $files      = $_FILES;
            $a['uid']   = $user_ID;
            $a['name']  = $data['dlg-upload-name'];
            $a['pid']   = $data['pid'];
            $a['cid']   = $data['cid'];
            $a['tags']  = $data['tags'];
            $a['notes'] = $data['dlg-upload-notes'];
            check_folder_sp_client_upload();
            if ($files['dlg-upload-file']['name'] != "") {
                $a['file'] = sp_uploadFile($files);
				$a['date'] =  date("Y-m-d G:i:s",current_time( 'timestamp' ));
             
			
			    $wpdb->insert("" . $wpdb->prefix . "sp_cu", $a);
                $file_id = $wpdb->insert_id;
                add_user_meta($user_ID, 'last_project', $a['pid']);
                if (@CU_PREMIUM == 1) {
                    process_sp_cdm_form_vars($data['custom_forms'], $file_id);
                }
                $to = get_option('admin_email');
                if (get_option('sp_cu_admin_email') != "") {
                    $headers[] = "" . __("From:", "sp-cdm") . " " . $current_user->user_firstname . " " . $current_user->user_lastname . " <" . $current_user->user_email . ">\r\n";
                    if (get_option('sp_cu_additional_admin_cc') != "") {
                        $cc_admin = explode(",", get_option('sp_cu_additional_admin_cc'));
                        foreach ($cc_admin as $key => $email) {
                            if ($email != "") {
                                $pos = strpos($email, '@');
                                if ($pos === false) {
                                    $role_emails = sp_cdm_find_users_by_role($email);
                                    foreach ($role_emails as $keys => $role_email) {
                                        $headers[] = 'Cc: ' . $role_email . '';
                                    }
                                } else {
                                    $headers[] = 'Cc: ' . $email . '';
                                }
                            }
                        }
                    }
                    $message = sp_cu_process_email($file_id, get_option('sp_cu_admin_email'));
                  
                    $subject =  sp_cu_process_email($file_id, get_option('sp_cu_admin_email_subject'));
                     add_filter( 'wp_mail_content_type', 'set_html_content_type' );
					wp_mail($to, $subject, $message, $headers, $attachments);
					 remove_filter( 'wp_mail_content_type', 'set_html_content_type' );
                    unset($headers);
                    unset($pos);
                }
                if (get_option('sp_cu_user_email') != "") {
      
					$subject =  sp_cu_process_email($file_id, get_option('sp_cu_user_email_subject'));
                    $message = sp_cu_process_email($file_id, get_option('sp_cu_user_email'));
                    $to      = $current_user->user_email;
                    if (get_option('sp_cu_additional_user_emails') != "") {
                        $cc_user = explode(",", get_option('sp_cu_additional_user_emails'));
                        foreach ($cc_user as $key => $user_email) {
                            if ($user_email != "") {
                                $pos = strpos($user_email, '@');
                                if ($pos === false) {
                                    $role_user_emails = sp_cdm_find_users_by_role($user_email);
                                    foreach ($role_user_emails as $keys => $role_user_email) {
                                        $user_headers[] = 'Cc: ' . $role_user_email . '';
                                    }
                                } else {
                                    $user_headers[] = 'Cc: ' . $user_email . '';
                                }
                            }
                        }
                    }
			$message = apply_filters('spcdm_user_email_message',$message,$post, $uid);
			$to = apply_filters('spcdm_user_email_to',$to,$post, $uid);
			$subject = apply_filters('spcdm_user_email_subject',$subject,$post, $uid);
			$attachments = apply_filters('spcdm_user_email_attachments',$attachments,$post, $uid);
			$user_headers = apply_filters('spcdm_user_email_headers',$user_headers,$post, $uid);
			
						 add_filter( 'wp_mail_content_type', 'set_html_content_type' );
                    wp_mail($to, $subject, $message, $user_headers, $attachments);
					 remove_filter( 'wp_mail_content_type', 'set_html_content_type' );
                }
                $html .= '<script type="text/javascript">





jQuery(document).ready(function() {

 sp_cu_dialog("#sp_cu_thankyou",400,200);

});

</script>';
            } else {
                $html .= '<p style="color:red">' . __("Please upload a file!", "sp-cdm") . '</p>';
            }
        }
        echo $html;
    }
    function display_sp_client_upload($atts)
    {
        global $wpdb;
        global $user_ID;
        global $current_user;
		$html = '';
        get_currentuserinfo();
        if (is_user_logged_in()) {
            $r = $wpdb->get_results("SELECT *  FROM " . $wpdb->prefix . "sp_cu   where uid = $user_ID  order by date desc", ARRAY_A);
            //show uploaded documents
            $html .= '
<input type="hidden" value="'.SP_CDM_PLUGIN_URL.'ajax.php" id="sp_cu_ajax_url" class="sp_cu_ajax_url" name="sp_cu_ajax_url">
	<div class="sp_client_document_manager_wrapper">
    <div style="display:none">
	 <div id="cp_cdm_upload_form">

 	 ' . display_sp_upload_form() . '

  </div>
  </div>

  





	

	<div >



 

';
            if (get_option('sp_cu_user_projects_thumbs') == 1) {
                $html .= '

	<script type="text/javascript">

	

	function cdm_ajax_search(){

		sp_cdm_loading_image();

	var cdm_search = jQuery("#search_files").val();

	jQuery("#cmd_file_thumbs").load("' . SP_CDM_PLUGIN_URL . 'ajax.php?function=thumbnails&uid=' . $user_ID . '&search=" + cdm_search);		

		

	}

	</script>

	

	';
            } else {
                $html .= '

	<script type="text/javascript">

	

	function cdm_ajax_search(){

		sp_cdm_loading_image();

	var cdm_search = jQuery("#search_files").val();

	jQuery("#cmd_file_thumbs").load("' . SP_CDM_PLUGIN_URL . 'ajax.php?function=file-list&uid=' . $user_ID . '&search=" + cdm_search);		

		

	}

	</script>

	

	';
            }
			
			  $html .= '<div id="cdm_nav_buttons">';
			if (get_option('sp_cu_user_disable_search') == 1) {
            $hide_search = ';display:none;';
			}
			// do_action('cdm_add_hidden_html');
          
			  $html .= '<div style="padding:10px'.$hide_search.'">Search: <input  onkeyup="cdm_ajax_search()" type="text" name="search" id="search_files"></div>';
			
		   
		   
		    if (cdm_user_can_add($current_user->ID) == true)
			 {
                if (class_exists('cdmPremiumUploader') && get_option('sp_cu_free_uploader') != 1) {
                    global $premium_add_file_link;
                    $link = $premium_add_file_link;
                 
                } else {
                    $link = 'javascript:sp_cu_dialog(\'#cp_cdm_upload_form\',700,600)';
                }
                $html .= '  <a href="' . $link . '"  class="sp_cdm_add_file hide_add_file_permission">' . __("Add File", "sp-cdm") . '</a> ';
               if(get_option('sp_cu_user_projects') == 1  or current_user_can( 'manage_options' )){	
			    $html .= '  <a href="javascript:sp_cu_dialog(\'#sp_cu_add_project\',500,200);" class="sp_cdm_add_folder hide_add_folder_permission">' . __("Add Folder", "sp-cdm") . '</a> </span> ';
				}
				$morebuttons = '';
                $morebuttons .= apply_filters('sp_cdm_more_buttons', $morebuttons);
                $html .= $morebuttons;
                $html .= '   <a href="javascript:cdm_ajax_search()"  class="sp_cdm_refresh">' . __("Refresh", "sp-cdm") . '</a> ';
            }
			
			$html .='<div style="clear:both"></div></div>';
            if (get_option('sp_cu_user_projects_thumbs') == 1 && @CU_PREMIUM == 1) {
                $html .= display_sp_cdm_thumbnails($r);
            } else {
                $html .= display_sp_thumbnails2($r);
            }
		  $html .= '</div>';
        } else {
            return '<script type="text/javascript">

<!--

window.location = "' . wp_login_url($_SERVER['REQUEST_URI']) . '"

//-->

</script>';
        }
		$html .='</div>
		
			';
        return $html;
    }
}
function sp_cu_add_file_link_free()
{
    $add_file_link = 'javascript:sp_cu_dialog(\'#cp_cdm_upload_form\',700,600)';
}


add_action('sp_cu_add_file_link', 'sp_cu_add_file_link_free', 5);
add_shortcode('sp-client-media-manager', 'display_sp_client_upload');
add_shortcode('sp-client-document-manager', 'display_sp_client_upload');
add_action('wp_footer', 'display_sp_client_upload_process');

?>