<?php
	function get_login(){
		if(!isset($_SESSION['user']) && !isset($_SESSION['pass']))
			$content = login();
		if(isset($_SESSION['user']) && isset($_SESSION['pass']) ){
			$content = application_log();
			$_SESSION['app'] = $_REQUEST['app'];
		}if(isset($_SESSION['app'])){
			$content = '<script>location.href="'.PATH_INDEX_PAGE.'"</script>';
		}
		return $content;
	}
	
	//************************************************************* FUNGSI UNTUK MELAKUKAN AUTENTIKASI USER DAN PASSWORD **********************************************	
	//================================================================function login / logout======================================================================//
	//############################################################################################################################################################//
	//===============================#################################manage your page in bottom here####################=========================================// 
	
	//-----------------------------------fungsi yang digunakan untuk membuat halaman login menggunakan database----------------------------------------------------- 
	function body_login(){
		unset($_SESSION['user']);
		unset($_SESSION['pass']);
		unset($_SESSION['app']);

		$query = 'SELECT application,application FROM tb_permit GROUP BY application';
		$result = mysql_query($query);
		while($result_now = mysql_fetch_array($result)){
			$option .= '<option value="'.$result_now[0].'">'.$result_now[1].'</option>';
		}
		$select = '<select name="app" class="select">'.$option.'</select></td>';
		
		//============Old design form for login=====================================================//
		/*$content = '<table><tr><td><form method="post" action="'.PATH_INDEX.'" name="form"><table>
					<tr>
					<td><label class="label">Username : </label></td>
					<td><input type="text" name="domain" class="input"></td>
					</tr>
					<tr>
					<td><label class="label">Password : </label></td>
					<td><input type="password" name="password" class="input"></td>
					</tr>
					';	
		$content .=	'<tr>
					<td></td>
					<td><br/><input type="submit" name="submit" value="SUBMIT" class="submit"></td>
					</tr>
					</table></div>';*/

		$content = '<div class="login-page">
					  <div class="form-log">
						<form class="login-form" method="post" action="'.PATH_INDEX.'" name="form">
						  <input type="text" placeholder="username" name="domain"/>
						  <input type="password" placeholder="password" name="password"/>
						  <button>login</button>
						  <p class="message">Not registered? Contact administrator</p>
						</form>
					  </div>
					</div>';
		return $content;
	}
	
	//---------------------------fungsi untuk menampilkan aplikasi yang akan digunakan -------------------------
	function application_log(){
		if(ISSET($_REQUEST['logout'])){
			$content = logout();
		}
		
		else{
		$query = 'SELECT application,application FROM tb_permit WHERE user_p="'.$_SESSION['user'].'" GROUP BY application';
		$result = mysql_query($query);
		while($result_now = mysql_fetch_array($result)){
			$option .= '<option value="'.$result_now[0].'">'.$result_now[1].'</option>';
		}
		
		//=====================Old select application===================
		//$select = '<select name="app" class="select">'.$option.'</select></td>';
		
		/*$content = '<table><tr><td><form method="post" action="'.PATH_INDEX.'" name="form"><table>
					<tr>
					<td><label class="label">Application : </label></td>
					<td>'.$select.'</td>
					</tr>';	
		$content .=	'<tr>
					<td></td>
					<td><br/><input type="submit" name="submit" value="SUBMIT" class="submit"></td>
					</tr>
					</table></div>';*/
		
		$select = '<select name="app">'.$option.'</select></td>';
		$content = '<div class="login-page">
					  <div class="form-log">
						<form class="login-form" <form method="post" action="'.PATH_INDEX.'" name="form">
						  '.$select.'
						  <button>Select</button>
						  <p class="message">Please, Select Your Application or <a href="'.PATH_INDEX.'?logout=out">Log Out</a></p>
						</form>
					  </div>
					</div>';
		}
		
		return $content;
	}
	//-------------------------------------------------fungsi cek user pada database ------------------------------------------------------------------------------
	function cek_user_pas_db($user,$pass){
		$query = 'SELECT * FROM tb_user WHERE username="'.$user.'" AND password=SHA1("'.$pass.'")';
		$result = mysql_query($query) or die('gagal query');
		$num_row = mysql_num_rows($result);
		if ($num_row!=0){
			$result_now = mysql_fetch_array($result);
			return true;		
		}else{
			return false;
		}
	}	
	
	//-----------------------------------------------fungsi membuat form login untuk LDAP--------------------------------------------------------------------------
	function body_login_ldap(){
		unset($_SESSION['user_LDAP']);
		unset($_SESSION['pass_LDAP']);	
		$content = '<div id="dialog-form-2" title="Login Domain">
				<form name="form_LDAP">
				<fieldset>
					<label for="login">User Domain : </label>
					<input type="text" name="domain" id="domain" class="text ui-widget-content ui-corner-all" />
					<label for="pass">Password : </label>
					<input type="password" name="password" id="password" class="text ui-widget-content ui-corner-all" />
				</fieldset>
				</form>
				</div>';
		return $content;
	}	
	
	//-------------------------------------------- fungsi cek user dan password menggunakan Active Directory -------------------------------------------------------
	function cek_user_pas($user,$pass){
	/*	$query = 'SELECT * FROM tb_user WHERE username="'.$user.'" AND password="'.$pass.'"';
		$result = mysql_query($query) or die('gagal query');
		$num_row = mysql_num_rows($result);
		if ($num_row!=0){
			$result_now = mysql_fetch_array($result);
			return true;		
		}else{
			return false;
		}*/
		$ad = ldap_connect(HOST) or die( "Could not connect!" );
		ob_start();
		$bd = ldap_bind($ad, $user, $pass);
		ob_clean();
		
		//---Cek apakah memiliki akses aplikasi jika tidak maka akan logout---/
		$query = 'SELECT * FROM tb_permit WHERE user_p="'.$user.'"';
		$result = mysql_query($query);
		if(mysql_num_rows($result)==0)
			$app = 0;
		else
			$app = 1; 
		
		if ($bd==1 && $app==1 && !empty($pass)){
			return true;		
		}else{
			return false;
		}
	}	
	
	//---------------------------------------------fungsi cek user password menggunakan session ----------------------------------------------------------------------
	function login(){
	//	$content = $_SESSION['user'].' '.$_SESSION['pass'].$_SESSION['user_LDAP'].$_SESSION['pass_LDAP'].$_REQUEST['password'].$_REQUEST['domain'];
		
		if(!isset($_SESSION['user_LDAP']) && !isset($_SESSION['pass_LDAP']) && !isset($_REQUEST['password']) && !isset($_REQUEST['domain'])){
			$content = body_login();
			
		}else if((isset($_SESSION['user_LDAP']) && isset($_SESSION['pass_LDAP'])) || (isset($_REQUEST['password']) && isset($_REQUEST['domain']))){
			if(!isset($_SESSION['user_LDAP']) && !isset($_SESSION['pass_LDAP'])){
				$_SESSION['user_LDAP']=$_REQUEST['domain'];
				$_SESSION['pass_LDAP']=$_REQUEST['password'];
				//$_SESSION['app'] = $_REQUEST['app'];
			}
			//$content = $_SESSION['user_LDAP'].' '.$_SESSION['pass_LDAP'];
			
			if(isset($_SESSION['bool_LDAP'])){
				$bool_ldap = $_SESSION['bool_LDAP'];
			}else{
				$bool_ldap = cek_user_pas_db($_SESSION['user_LDAP'],$_SESSION['pass_LDAP']);
				$_SESSION['user']=$_SESSION['user_LDAP'];
				$_SESSION['pass']=$_SESSION['pass_LDAP'];
				//$_SESSION['app'] = $_SESSION['app'];
				$_SESSION['bool_LDAP'] = $bool_ldap;
			//	$content = $bool_ldap;
			}
			
			if($bool_ldap){
				$content = '<script>location.href="'.PATH_INDEX_MAIN.'";</script>'; 
				
			/*	$content .= body_login();
				if(!isset($_REQUEST['user']) && !isset($_REQUEST['pass'])){
				$content = body_login();
				//$content .= $_SESSION['user'].' '.$_SESSION['pass'].$_SESSION['user_LDAP'].$_SESSION['pass_LDAP'];
				}else if(isset($_REQUEST['user']) && isset($_REQUEST['pass'])){
					$_SESSION['user']=$_REQUEST['user'];
					$_SESSION['pass']=$_REQUEST['pass'];
					if(empty($_SESSION['user']) || empty($_SESSION['pass'])){
						session_unset();
						session_destroy();
						$content .= body_login();
						$content .= '<div style="color:red" align="center">There is an empty field</div>';
					}else{
						$bool = cek_user_pas_db($_SESSION['user'],$_SESSION['pass']);	
						if($bool){
							$content = '<script>location.href="'.PATH_INDEX_MAIN.'";</script>'; 
						}else{
							$content = body_login();
							$content .= '<div style="color:red" align="center">You have wrong username or password</div>';
						}
					}
				}*/
			}else{
				session_unset();
				session_destroy();
				$content = '<script>location.href="'.PATH_INDEX.'";</script>';
			}
			
			/*if(!isset($_REQUEST['user']) && !isset($_REQUEST['pass'])){
				$content .= body_login();
			}else if(isset($_REQUEST['user']) && isset($_REQUEST['pass'])){
				$_SESSION['user']=$_REQUEST['user'];
				$_SESSION['pass']=$_REQUEST['pass'];
				if(empty($_SESSION['user']) || empty($_SESSION['pass'])){
					session_unset();
					session_destroy();
					$content = body_login();
					$content .= '<div style="color:red" align="center">There is an empty field</div>';
				}else{
					$bool = cek_user_pas_db($_SESSION['user'],$_SESSION['pass']);	
					if($bool){
						$content = '<script>location.href="'.PATH_INDEX_MAIN.'";</script>'; 
					}else{
						session_unset();
						session_destroy();
						$content = body_login();
						$content .= '<div style="color:red" align="center">You have wrong username or password</div>';
					}
				}
			}*/
		}
		return $content;
	}
	
	//--------------------------------------------------------fungsi untuk log out dari halaman -----------------------------------------------------------------
	function logout(){
		session_unset();
		session_write_close();
		//session_destroy();
		$content = '<script>location.href="'.PATH_INDEX.'";</script>'; 
		return $content;
	}
?>