<?php
function get_title($title, $trailing = true) {
	if( $trailing ) $title .= ' - '.SITE_NAME;
	return $title;
}

function loggedIn($redirect = '') {
	$user = session()->get('logged_in');
	if($user) {
		if( !empty($redirect) ) redirect($redirect);
		return true;
	} else {
		return false;
	}
}

function user_logged_in( $redirect = '' ) {
	if ( session('logged_in') == 1 ) {
		if( !empty($redirect) ) redirect($redirect);
		return true;
	} else {
		return false;
	}
}

function logged_in_user( $user_type ) {
	if( get_session('user_type') == $user_type ) {
		return true;
	}
	return false;
}

function can_access( $admin='', $marketing='', $sales='', $sevices='', $appgift='') {
	$CI =& get_instance();
	$users = array( $admin, $marketing, $sales, $sevices, $appgift);
	if( user_logged_in() ) {
		if( in_array(get_session('role'), $users) ) {
			// go ahead
		} else {
			redirect('404');
		}
	} else {
		redirect('login?redirect='.current_url());
	}
}

function only_for( $admin='', $marketing='', $sales='', $sevices='', $appgift='') {
	$users = array( $admin, $marketing, $sales, $sevices, $appgift);
	$users = array_filter($users);
	
	if( user_logged_in() ) {
		if( in_array(get_session('role'), $users) ) {
			return true;
		}
		return false;
	} else {
		redirect('login');
	}
}

function get_value($field, $table, $value, $where='id') {
	$CI =& get_instance();
	$output = false;
	
	$CI->db->select($field);
	$CI->db->from($table);
	$CI->db->where($where, $value);
	$query = $CI->db->get();
	if( $query->num_rows() > 0 ) {
		$result = $query->result_array();
		$output = $result[0][$field];
	}
	return $output;
}

function set_value($field, $value, $table, $where_value, $where_cond = 'id') {
	$CI =& get_instance();
	
	$CI->db->set($field, $value);
	$CI->db->where($where_cond, $where_value);
	$result = $CI->db->update($table);
	retailer_list_query($CI->router->fetch_class(), $CI->router->fetch_method());
	return $result;
}

function get_row($table, $id, $where='id') {
	$CI =& get_instance();
	$CI->db->from($table);
	$CI->db->where($where, $id);
	$query = $CI->db->get();
	if( $query->num_rows() > 0 ) {
		$result = $query->row_array();
		return $result;
	}
	return false;
}


function get_table($table, $where_value ='', $where ='', $where_value1 ='', $where1 ='') {
	$CI =& get_instance();
	if( !empty($where) ) {
		$CI->db->where($where, $where_value);
	}
	if( !empty($where1) ) {
		$CI->db->where($where1, $where_value1);
	}
	$query = $CI->db->get($table);
	if( $query->num_rows() > 0 ) {
		$result = $query->result_array();
		return $result;
	}
	return false;
}

function get_content($name) {
	return get_value('value', 'content', $name, 'name');
}

function set_content($name, $content) {
	$CI =& get_instance();
	$CI->db->where('name', $name);
	$query = $CI->db->get('content');
	if( $query->num_rows() > 0 ) {
		$result = set_value('value', $content, 'content', 'name', $name);
		return $result;
	} else {
		$data = array(
			'name' => $name,
			'content' => $content
		);
		$query = $CI->db->insert('users',$data);
		if( $query ) return true;
		return false;
	}

}

function load_view($view, $data = NULL){
    $CI =& get_instance();
    $CI->load->view($view, $data);
}

function compare_datetime($a, $b) {
	$ad = strtotime($a['exact_date']);
	$bd = strtotime($b['exact_date']);

	if ($ad == $bd) {
		return 0;
	}

	return $ad > $bd ? 1 : -1;
}

function remove_dir($dir) {
   if (is_dir($dir)) {
     $objects = scandir($dir);
     foreach ($objects as $object) {
       if ($object != "." && $object != "..") {
         if (filetype($dir."/".$object) == "dir"){
            remove_dir($dir."/".$object);
         } else { 
            unlink($dir."/".$object);
         }
       }
     }
     reset($objects);
     rmdir($dir);
  }
}

// create client's folder for slides, notes, logo, background, header image etc.
function create_client_folder($urlname) {
	if( !is_dir(FCPATH.'clients/'.$urlname) ) {
		mkdir(FCPATH.'clients/'.$urlname, 0777, true);
		mkdir(FCPATH.'clients/'.$urlname.'/slides', 0777, true);
		mkdir(FCPATH.'clients/'.$urlname.'/slides_thumbs', 0777, true);
		mkdir(FCPATH.'clients/'.$urlname.'/notes', 0777, true);
	}
}
function rename_client_folder($old_urlname, $new_urlname) {
	$old_path = FCPATH.'clients/'.$old_urlname;
	$new_path = FCPATH.'clients/'.$new_urlname;
	if( is_dir($old_path) ) rename($old_path, $new_path);
}

// converts a image path into image source
function create_image_from($image) {
	$type = pathinfo($image['name'], PATHINFO_EXTENSION);
	if( $type == "jpeg" || $type == "jpg" ) {
		return imagecreatefromjpeg($image['tmp_name']);
	} else if( $type == "png" ) {
		return imagecreatefrompng($image['tmp_name']);
	}
}

function get_extention($file) {
	return pathinfo($file['name'], PATHINFO_EXTENSION);
}

function i_encode($url) {
	$CI =& get_instance();
	$uri = $CI->encryption->encrypt($url);
	$pattern = '"/"';
	$new_uri = preg_replace($pattern, '_', $uri);
	return $new_uri;
}

function i_decode($url) {
	$CI =& get_instance();
	$pattern = '"_"';
	$uri = preg_replace($pattern, '/', $url);
	$new_uri = $CI->encryption->decrypt($uri);
	return $new_uri;
}

function custom_encode($string) {
	$key = "ArmSvmX";
	$string = base64_encode($string);
	$string = str_replace('=', '', $string);
	$main_arr = str_split($string);
	$output = array();
	$count = 0;
	for( $i=0; $i<strlen($string); $i++) {
		$output[] = $main_arr[$i];
		if($i%2==1) {
			$output[] = substr($key, $count, 1);
			$count++;
		}
	}
	$string = implode('', $output);
	return $string;
}

function custom_decode($string) {
	$key = "ArmSvmX";
	$arr = str_split($string);
	$count = 0;
	for( $i=0; $i<strlen($string); $i++) {
		if( $count < strlen($key) ) {
			if($i%3==2) {
				unset($arr[$i]);
				$count++;
			}
		}
	}
	$string = implode('', $arr);
	$string = base64_decode($string);
	return $string;
}

function get_array_key($value, $array) {
	while ($single = current($array)) {
		if ($single == $value) {
			return key($array);
		}
		next($array);
	}
}

function set_sessions($values) {
	session()->set($values);
}

function get_session($name='') {
	if( !empty($name) ) {
		return session()->get($name);
	}
	return session()->get();
}

function unset_session($name) {
	session()->remove($name);
}

function getFriendlyURL($string) {
    setlocale(LC_CTYPE, 'en_US.UTF8');
    $string = iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $string);
    $string = preg_replace('~[^\-\pL\pN\s]+~u', '-', $string);
    $string = str_replace(' ', '-', $string);
    $string = trim($string, "-");
    $string = strtolower($string);
    return $string;
}

function delete_file($file_path) {
	if( is_file($file_path) ) {
		unlink($file_path);
	}
}

function format_datetime($datetime) {
	return date('j M, Y - h:ia', strtotime($datetime));
}

function format_date($date) {
	return date('j M, Y', strtotime($date));
}

function format_time($time) {
	return date('h:i A', strtotime($time));
}

function timezone_datetime($datetime = '') {
	$timezone_datetime = new DateTime($datetime, new DateTimeZone('Asia/Kolkata'));
	return $timezone_datetime;
}

function posted_ago($datetime, $full = false) {
	$now = timezone_datetime();
    $ago = timezone_datetime($datetime);

    $diff = $now->diff($ago);

    $diff->w = floor($diff->d / 7);
    $diff->d -= $diff->w * 7;

    $string = array(
        'y' => 'year',
        'm' => 'month',
        'w' => 'week',
        'd' => 'day',
        'h' => 'hour',
        'i' => 'minute',
        's' => 'second',
    );
    foreach ($string as $k => &$v) {
        if ($diff->$k) {
            $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
        } else {
            unset($string[$k]);
        }
    }

    if (!$full) $string = array_slice($string, 0, 1);
    return $string ? implode(', ', $string) . ' ago' : 'just now';
}


function debug($item = array(), $die = true, $display = true) {
	if( is_array($item) || is_object($item) ) {
		echo "<pre ".($display?'':'style="display:none"').">"; print_r($item); echo "</pre>";
	} else {
		echo $item;
	}
	
	if( $die ) {
		die();
	}
}

function ci_debug() {
	$CI =& get_instance();
	$CI->output->enable_profiler(TRUE);
}

function fieldset( $field = array() ) {
	echo '
	<div class="fieldset">
		<input type="'.(isset($field['type'])?$field['type']:'text').'" id="'.(isset($field['id'])?$field['id']:$field['name']).'" name="'.$field['name'].'" class="field" required />
		<label for="'.(isset($field['id'])?$field['id']:$field['name']).'">'.$field['label'].'</label>
	</div>
	';
}

function random_code($length = 16) {
	$chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
    $code = substr( str_shuffle( $chars ), 0, $length );
	return $code;
}

function set_flashdata($name, $message, $class='') {
	$CI =& get_instance();
	$data = array(
		'message' => '<div class="'.TOGGLE_CLOSE_CLASS.' alert alert-'.$class.'">'.$message.'</div>',
		'type' => $class
	);
	$CI->session->set_flashdata($name, $data);
}

function get_flashdata($name) {
	$CI =& get_instance();
	$data = $CI->session->flashdata($name);
	return $data['message'];
}

function set_notification($message, $class) {
	set_flashdata('notification', $message, $class);
}

function get_notification() {
	$data = get_flashdata('notification');
	return $data;
}

function set_login_sessions($user) {

	$data = array(
		'logged_in' => 1,
		'username' => $user['username'],
		'userid' => $user['id'],
		'role' => $user['role'],
		'name' => $user['name'],
		'zone' => $user['zone'],
		'retailer_code' => $user['retailer_code']
	);
	set_sessions($data);
}

function unset_login_sessions() {
	$data = array(
		'logged_in',
		'username',
		'role',
		'name',
		'cluster'
	);
	foreach( $data as $value ) {
		unset_session($value);
	}
}

function admin_in_author_area($author_id, $url) {
	$admin_id = get_session('user_id');
	$userdata = get_row('users', $author_id);
	set_admin_session($url);
	unset_login_sessions();
	set_login_sessions($userdata);
}

function back_to_admin() {
	unset_login_sessions();
	$userdata = get_row('users', get_session('admin_id_in_author_area'));
	set_login_sessions($userdata);
	$url = get_session('admin_redirect_url');
	unset_admin_session();
	return $url;
}

function set_admin_session($url) {
	$data = array(
		'admin_id_in_author_area' => get_session('user_id'),
		'admin_redirect_url' => $url,
	);
	set_sessions($data);
}

function unset_admin_session() {
	$data = array(
		'admin_redirect_url',
		'admin_id_in_author_area',
	);
	foreach( $data as $value ) {
		unset_session($value);
	}
}

function page_title($page_title) {
	echo '
		<div class="page_title">
			<h1>'.$page_title.'</h1>
		</div>
	';
}

function get_link_url($title, $table, $id) {
	$CI =& get_instance();
	$url = getFriendlyURL($title);

	$where = array(
		'link' => $url,
		'id !=' => $id
	);
	$CI->db->where($where);
	$query = $CI->db->get($table);
	if( $query->num_rows() > 0 ) {
		$url = $url.'-'.$id;
	}
	return $url;
}

function delete_document($file) {
	$document_path = FCPATH.'data/documents/'.$file;
	if( is_file($document_path) ) unlink($document_path);
}


function truncate($string, $word_count = 10) {
 	$string = htmlspecialchars_decode(strip_tags($string));
    $words = explode(' ', $string);

    $output = '';
    foreach( $words as $key=>$word ) {
    	if( $key < $word_count ) {
    		$output .= $word.' ';
    	}
    }

    if( sizeof( $words ) > $word_count ) {
    	return $output.'...';
	}
	return $output;
}

function profile_image($file) {
	$profile_picture_path = FCPATH.'data/profile_picture/'.$file;
	if( is_file($profile_picture_path) ) {
		$file_path = base_url('data/profile_picture/$file');
	} else {
		$file_path = base_url('assets/img/default_profile_picture.png');
	}
	return $file_path;
}


// =============================================
// =============================================
// ================= ADMIN PANEL ===============
// =============================================
// =============================================


function check_admin_logged_in() {
	if( !admin_logged_in() ) {
		redirect('admin');
	}
}

function admin_logged_in() {
	if( get_session('admin_logged_in') == "yes" ) {
		return true;
	}
	return false;
}

function get_admin($name = "") {
	$data = array(
		'fullname' => get_session('admin_firstname').' '.get_session('admin_lastname'),
		'role' => get_session('admin_role')
	);

	if( empty($name) ) {
		return $data;
	}

	if( isset($data[$name]) ) {
		return $data[$name];
	}
	return false;
}

function get_count($table, $where='', $value='', $where1='', $value1='') {
	$CI =& get_instance();
	$output = false;
	
	$CI->db->select('count(*) as total');
	if( !empty($where) ) {
		$CI->db->where($where, $value);
	}
	if( !empty($where1) ) {
		$CI->db->where($where1, $value1);
	}
	$query = $CI->db->get($table);
	if( $query->num_rows() > 0 ) {
		$result = $query->row_array();
		$output = $result['total'];
	}
	return $output;
}

function get_count_user($table, $where='', $value='', $where1='', $value1='', $status) {
	$CI =& get_instance();
	$output = false;
	
	$CI->db->select('count(*) as total');
	if( !empty($where) ) {
		$CI->db->where($where, $value);
	}
	if( !empty($where1) ) {
		$CI->db->where($where1, $value1);
	}
	if( !empty($status) ) {
		$CI->db->where('status', $status);
	}
	$query = $CI->db->get($table);
	if( $query->num_rows() > 0 ) {
		$result = $query->row_array();
		$output = $result['total'];
	}
	return $output;
}

function get_count_join($table, $where='', $value='', $where1='', $value1='') {
	$CI =& get_instance();
	$output = false;
	
	$CI->db->select("count('$table.*') as total");
	$CI->db->from($table);
	$CI->db->join('user', "$table.retailer_code = user.retailer_code");
	if( !empty($where) ) {
		$CI->db->where($table.'.'.$where, $value);
	}
	if($CI->session->userdata('role') != 'admin') {
		$CI->db->where('type', $CI->session->userdata('role'));
	}
	if( !empty($where1) ) {
		$CI->db->where($table.'.'.$where1, $value1);
	}
	$query = $CI->db->get();
	if( $query->num_rows() > 0 ) {
		$result = $query->row_array();
		$output = $result['total'];
	}
	return $output;
}

function safe($data) {
	$CI =& get_instance();
	$data = $CI->security->xss_clean($data);
	return $data;
}

function get_data_array($query){
	$CI =& get_instance();
	$query = $CI->db->query($query);
	if( $query->num_rows() > 0 ) {
	$result = $query->result_array();
	return $result;
	}
	return false;
}

function get_log_transection($where='', $value='', $where1='', $value1='') {
	$CI =& get_instance();
	$output = false;
	
	$CI->db->select('*');
	if( !empty($where) ) {
		$CI->db->where($where, $value);
	}
	if( !empty($where1) ) {
		$CI->db->where($where1, $value1);
	}
	$query = $CI->db->get('log_transaction');
	if( $query->num_rows() > 0 ) {
		$result = $query->result_array();
	}
	return $result;
}

function get_history($table, $where='', $value='', $where1='', $value1='') {
	$CI =& get_instance();
	$output = false;
	
	$CI->db->select('*');
	if( !empty($where) ) {
		$CI->db->where($where, $value);
	}
	if( !empty($where1) ) {
		$CI->db->where($where1, $value1);
	}
	if($table == 'learn_status') {
		$CI->db->order_by('section', 'DESC');
	}	
	$query = $CI->db->get($table);
	if( $query->num_rows() > 0 ) {
		$result = $query->result_array();
	}
	return $result;
}

//============= Update master txn table ========  
function create_txn($table_name, $type, $column_id, $role, $status) {
	$CI =& get_instance();
	$insert_array = array( 
		"date_created" => date("Y-m-d"), 
		"time_created" => date("H:i:s"), 
		"table_name" => $table_name, 
		"txn_type" => $type, 
		"column_id" => $column_id, 
		"role" => $role, 
		'username' => $CI->session->userdata('username'),
		"browser_info" => $_SERVER['HTTP_USER_AGENT'], 
		"status" => $status,
		"ip_add" => $_SERVER['REMOTE_ADDR'],
	);
	$query = $CI->db->insert('update_history',$insert_array);
	if( $query ) return true;
	return false;
}

function user_level_update($old_user_level, $new_user_level, $retailer_code, $voucher_id, $voucher_level, $status) {
	$CI =& get_instance();
	$insert_array = array( 
		"create_date" => date("Y-m-d"), 
		"create_time" => date("H:i:s"), 
		"old_user_level" => $old_user_level, 
		"new_user_level" => $new_user_level, 
		"retailer_code" => $retailer_code,
		"voucher_id" => $voucher_id,
		"voucher_level" => $voucher_level,
		"role" => $CI->session->userdata('role'), 
		'username' => $CI->session->userdata('username'),
		"browser_info" => $_SERVER['HTTP_USER_AGENT'], 
		"status" => $status,
		"ip_add" => $_SERVER['REMOTE_ADDR'],
	);
	$query = $CI->db->insert('user_level_update',$insert_array);
	if( $query ) return true;
	return false;
}

function outputCsv($fileName, $assocDataArray)
{
    ob_clean();
    header('Pragma: public');
    header('Expires: 0');
    header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
    header('Cache-Control: private', false);
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment;filename=' . $fileName);    
    if(isset($assocDataArray['0'])){
        $fp = fopen('php://output', 'w');
        fputcsv($fp, array_keys($assocDataArray['0']));
        foreach($assocDataArray AS $values){
            fputcsv($fp, $values);
        }
        fclose($fp);
    }
    ob_flush();
}

function get_rso_code($id) {
	$CI =& get_instance();
	$CI->db->select('rso_code');
	$CI->db->where('id', $id);
	$query = $CI->db->get('rso_user');
	if( $query->num_rows() > 0 ) {
		$result = $query->row_array()['rso_code'];
		return $result;
	}
	return false;
}

function get_asm_code($id) {
	$CI =& get_instance();
	$CI->db->select('rso_code');
	$CI->db->where('id', $id);
	$CI->db->where('role', 'asm');
	$query = $CI->db->get('rso_user');
	if( $query->num_rows() > 0 ) {
		$result = $query->row_array()['rso_code'];
		return $result;
	}
	return false;
}

function get_asm_info($asm_code) {
    $CI =& get_instance();
	$CI->db->where('rso_code', $asm_code);
	$CI->db->where('role', 'asm');
	$query = $CI->db->get('rso_user');
	if( $query->num_rows() > 0 ) {
		$result = $query->row_array();
		return $result;
	}
	return false;
}

function IND_money_format($money){
    $len = strlen($money);
    $m = '';
    $money = strrev($money);
    for($i=0;$i<$len;$i++){
        if(( $i==3 || ($i>3 && ($i-1)%2==0) )&& $i!=$len){
            $m .=',';
        }
        $m .=$money[$i];
    }
    return strrev($m);
}

function get_user_by_role($role, $rso_code) {
    $CI =& get_instance();
    $CI->db->select('name, rso_code');
    if($role == 'rsmadmin') {
	    $CI->db->where('role', 'asm');
    } else {
        $CI->db->where('role', 'rso');
    }
    $CI->db->where('rso_code !=', $rso_code);
    $CI->db->where('status', 'Approved');
	$query = $CI->db->get('rso_user');
	if( $query->num_rows() > 0 ) {
		$result = $query->result_array();
		return $result;
	}
	return false;
}