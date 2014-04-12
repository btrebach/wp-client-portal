<?php 

require( '../../../wp-load.php' );

	

	global $wpdb;

	

if ( (is_user_logged_in() && get_option('sp_cu_user_require_login_download') == 1 ) or (get_option('sp_cu_user_require_login_download') == '' or get_option('sp_cu_user_require_login_download') == 0 )){

if(!function_exists('mime_content_type')) {



    function mime_content_type($filename) {



        $mime_types = array(



            'txt' => 'text/plain',

			

			

            'htm' => 'text/html',

            'html' => 'text/html',

			

			

            'php' => 'text/html',

            'css' => 'text/css',

            'js' => 'application/javascript',

			

			

            'json' => 'application/json',

			

			

            'xml' => 'application/xml',

            'swf' => 'application/x-shockwave-flash',

            'flv' => 'video/x-flv',



            // images

            'png' => 'image/png',

            'jpe' => 'image/jpeg',

            'jpeg' => 'image/jpeg',

            'jpg' => 'image/jpeg',

            'gif' => 'image/gif',

            'bmp' => 'image/bmp',

            'ico' => 'image/vnd.microsoft.icon',

            'tiff' => 'image/tiff',

            'tif' => 'image/tiff',

            'svg' => 'image/svg+xml',

            'svgz' => 'image/svg+xml',



            // archives

            'zip' => 'application/zip',

            'rar' => 'application/x-rar-compressed',

            'exe' => 'application/x-msdownload',

            'msi' => 'application/x-msdownload',

            'cab' => 'application/vnd.ms-cab-compressed',



            // audio/video

            'mp3' => 'audio/mpeg',

            'qt' => 'video/quicktime',

            'mov' => 'video/quicktime',



            // adobe

            'pdf' => 'application/pdf',

            'psd' => 'image/vnd.adobe.photoshop',

            'ai' => 'application/postscript',

            'eps' => 'application/postscript',

            'ps' => 'application/postscript',



            // ms office

            'doc' => 'application/msword',

            'rtf' => 'application/rtf',

            'xls' => 'application/vnd.ms-excel',

            'ppt' => 'application/vnd.ms-powerpoint',



            // open office

            'odt' => 'application/vnd.oasis.opendocument.text',

            'ods' => 'application/vnd.oasis.opendocument.spreadsheet',

			

			

			

        );



        $ext = strtolower(array_pop(explode('.',$filename)));

        if (array_key_exists($ext, $mime_types)) {

            return $mime_types[$ext];

        }

        elseif (function_exists('finfo_open')) {

            $finfo = finfo_open(FILEINFO_MIME);

            $mimetype = finfo_file($finfo, $filename);

            finfo_close($finfo);

            return $mimetype;

			

        }

        else {

            return 'application/octet-stream';

        }

    }

}

$file_decrypt = base64_decode($_GET['fid']);
$file_arr = explode("|",$file_decrypt);
$fid = $file_arr[0];
$file_date = $file_arr[1];
$file_name = $file_arr[2];
if(!is_numeric($fid)){header("HTTP/1.0 404 Not Found");exit;}
if(class_exists('cdmProductivityLog')){

$cdm_log = new cdmProductivityLog;	

$cdm_log->add($fid,$current_user->ID);	

}



	$r = $wpdb->get_results("SELECT *  FROM ".$wpdb->prefix."sp_cu   where id= '".$wpdb->escape($fid)."' AND date = '".$wpdb->escape($file_date)."'  AND file = '".$wpdb->escape($file_name)."' order by date desc", ARRAY_A);



	if(count($r) == 0){header("HTTP/1.0 404 Not Found");exit;}

$r_rev_check = $wpdb->get_results("SELECT *  FROM ".$wpdb->prefix."sp_cu   where parent= '".$r[0]['id']."'  order by date desc", ARRAY_A);

if(count($r_rev_check) > 0 && $_GET['original'] == ''){



unset($r);

$r = $wpdb->get_results("SELECT *  FROM ".$wpdb->prefix."sp_cu   where id= '".$r_rev_check[0]['id']."'  order by date desc", ARRAY_A);

}







if(get_option('sp_cu_js_redirect') == 1){

$file = ''.SP_CDM_UPLOADS_DIR_URL.''.$r[0]['uid'].'/'.$r[0]['file'].'';	

	echo '<script type="text/javascript">

<!--

window.location = "'.$file.'"

//-->

</script>';

exit;

}else{



$file = ''.SP_CDM_UPLOADS_DIR.''.$r[0]['uid'].'/'.$r[0]['file'].'';







// grab the requested file's name

$file_name = $file ;



// make sure it's a file before doing anything!

if(is_file($file_name))

{



  /*

    Do any processing you'd like here:

    1.  Increment a counter

    2.  Do something with the DB

    3.  Check user permissions

    4.  Anything you want!

  */



  // required for IE

  if(ini_get('zlib.output_compression')) { ini_set('zlib.output_compression', 'Off');  }



 $mime = mime_content_type($file_name);

 

 

 if($_GET['thumb'] == 1){

	 header('Content-Type: '.$mime); 

  readfile($file_name,filesize($filename));    // push it out

  exit(); 

 }else{

	 



  header('Pragma: public');   // required

  header('Expires: 0');    // no cache

 

  header('Cache-Control: must-revalidate, post-check=0, pre-check=0');

  header('Last-Modified: '.gmdate ('D, d M Y H:i:s', filemtime ($file_name)).' GMT');

  header('Cache-Control: private',false);











  header('Content-Type: '.$mime);

  header('Content-Disposition: attachment; filename="'.basename($file_name).'"');

  header('Content-Transfer-Encoding: binary');

  header('Content-Length: '.filesize($file_name));  // provide file size

  header('Connection: close');

  readfile($file_name,filesize($filename));    // push it out

  exit();

 }

}









}

}else{

	auth_redirect();	

	

}

?>