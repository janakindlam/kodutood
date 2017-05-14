<?php


function connect_db(){
	global $connection;
	$host="localhost";
	$user="test";
	$pass="t3st3r123";
	$db="test";
	$connection = mysqli_connect($host, $user, $pass, $db) or die("ei saa ühendust mootoriga- ".mysqli_error());
	mysqli_query($connection, "SET CHARACTER SET UTF8") or die("Ei saanud baasi utf-8-sse - ".mysqli_error($connection));
}

function logi(){
	global $connection;
	if(!empty($_SESSION["user"])) {
		header("Location: ?page=loomad");
	} else {
	if($_SERVER['REQUEST_METHOD'] == 'POST') {
	if($_POST["pass"] == '' || $_POST["user"] == '') {
		$errors =array();
	if(empty($_POST["user"])) {
		$errors[] = "Sisestage palun kasutajanimi!";
		}
		if(empty($_POST["pass"]))
		$errors[] = "Sisestage palun parool!";
	} else {
		$kasutaja = mysqli_real_escape_string ($connection, $_POST["user"]);
		$parool = mysqli_real_escape_string ($connection, $_POST["pass"]);
		$sql = "SELECT id FROM Jkindl_kylastajad WHERE username='$kasutaja' AND passw=SHA1('$parool')";
		$result = mysqli_query($connection, $sql);
		$row = mysqli_num_rows($result);
	
	if($row == 1) {
		$_SESSION['user'] = $username
		header("Location: loomaaed.php");
	} else {
		global $errors;
		$errors[] = "kasutajanimi või parool vale!";
			}
		}
	}
	include_once('views/login.html');
}
			
function logout(){
	$_SESSION=array();
	session_destroy();
	header("Location: ?");
}

function kuva_puurid(){
	if (isset($_SESSION['user'])) {
	
	global $connection;
	header("Location: ?page=login");
	} else {
	$p=mysqli_query($connection, "select distinct(puur) as puur from Jkindl_loomaaed order by puur asc");
	$puurid=array();
	while ($r=mysqli_fetch_assoc($p)){
		$l=mysqli_query($connection, "SELECT * FROM Jkindl_loomaaed WHERE puur=".mysqli_real_escape_string($connection, $r['puur']));
		while ($row=mysqli_fetch_assoc($l)) {
			$puurid[$r['puur']][]=$row;
			}
		}
	}
	include_once('views/puurid.html');
	
}

function lisa(){
	global $errors;
	
	global $connection;
	if(empty($_SESSION["user"])) {
		header("Location: ?page=login");
	} else {
		if($_SERVER['REQUEST_METHOD'] == 'POST') {
			if($_POST["puur"] == '' || $_POST["nimi"] == '' ) {
				$errors = array();
				if(empty($_POST["nimi"])) {
					$errors[] = "Sisestage nimi!";
				}
				if(empty($_POST["puur"])) {
					$errors[] = "Sisestage puuri number!";
				}
				} else {
					upload('liik');
					$nimi = mysqli_real_escape_string ($connection, $_POST["nimi"]);
					$puur = mysqli_real_escape_string ($connection, $_POST["puur"]);
					$liik = mysqli_real_escape_string ($connection, "pildid/".$_FILES["liik"]["name"]);
					$sql = "INSERT INTO Jkindl_loomaaed (nimi, puur, liik) VALUES ('$nimi','$puur','$liik')";
					$result = mysqli_query($connection, $sql);
					$id = mysqli_insert_id($connection);
					if($id) {
						header("Location: ?page=loomad");
					} else {
						header("Location: ?page=loomavorm");
					}
				}
			}
		}
	include_once('views/loomavorm.html');
}

function upload($name){
	$allowedExts = array("jpg", "jpeg", "gif", "png");
	$allowedTypes = array("image/gif", "image/jpeg", "image/png","image/pjpeg");
	$extension = end(explode(".", $_FILES[$name]["name"]));

	if ( in_array($_FILES[$name]["type"], $allowedTypes)
		&& ($_FILES[$name]["size"] < 100000) //100 kb
		&& in_array($extension, $allowedExts)) {
		//fail ]iget tüüpi ja suurusega
	if ($_FILES[$name]["error"] > 0) {
			$_SESSION['notices'][]= "Return Code: " . $_FILES[$name]["error"];
			return "";
		} else {
		//vigu ei ole
	if (file_exists("pildid/" . $_FILES[$name]["name"])) {
		//fail on olemas, ära uuesti lae, tagasta failinimi
			$_SESSION['notices'][]= $_FILES[$name]["name"] . " juba eksisteerib. ";
				return "pildid/" .$_FILES[$name]["name"];
			} else {
		//kõik OK, aseta pilt
			move_uploaded_file($_FILES[$name]["tmp_name"], "pildid/" . $_FILES[$name]["name"]);
				return "pildid/" .$_FILES[$name]["name"];
			}
		}
	} else {
		return "";
	}
}

?>