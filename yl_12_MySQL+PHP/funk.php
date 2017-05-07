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


function kuva_puurid(){
	if (isset($_SESSION['username'])) {
		header("Location: loomaaed.php?page=login");
	} else {
	global $connection;
		$puurid = array();
		$result = mysqli_query($connection, "SELECT DISTINCT puur as p FROM Jkindl_loomaaed order by puur asc") or die("");
		foreach ($result as $value) {
			$loomad = mysqli_query($connection, "SELECT id, nimi, vanus, liik FROM Jkindl_loomaaed WHERE puur = ".$value['p']) or die("");
		foreach ($loomad as $loom) {
		$puurid[$value['p']][] = $loom;
		}
	}
	include_once('views/puurid.html');
	}
}

function logi(){
	// siia on vaja funktsionaalsust (13. nädalal)
	global  $connection;
	if (!empty($_SESSION["user"])) {
		header("Location: ?page=loomad");
	} else {
		$errors = array();
		if ($_SERVER['REQUEST_METHOD'] == 'POST'){
			if ($_POST["user"] != "" && $_POST["pass"] != "") {
				$u = mysqli_real_escape_string($connection, $_POST["user"]);
				$p = mysqli_real_escape_string($connection, $_POST["pass"]);
				$sql = "SELECT id from pploom_kylastajad WHERE username = '$u' AND passw = SHA1('$p')";
				$result = mysqli_query($connection, $sql);
				if (mysqli_num_rows($result)) {
					$_SESSION["user"] = $_POST["user"];
					header("Location: ?page=loomad");
				} else {
					$errors[] = "Vale kasutajanimi või parool";
				}
			} else {
				$errors[] = "Kasutajanimi või parool on täitmata!";
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

function lisa(){
	// siia on vaja funktsionaalsust (13. nädalal)
	global  $connection;
	if (empty($_SESSION["user"])) {
		header("Location: ?page=login");
	} else {
		if ($_SERVER['REQUEST_METHOD'] == 'POST'){
			if ($_POST["nimi"] == "" && $_POST["puur"] == "") {
				$errors[] = "Nimi või puur on täitmata!";
			} elseif (upload("liik") == ""){
				$errors[] = "Faili saatmine ebaõnnestus";
			} else {
				$nimi = mysqli_real_escape_string($connection, $_POST["nimi"]);
				$puur = mysqli_real_escape_string($connection, $_POST["puur"]);
				$liik = mysqli_real_escape_string($connection, upload("liik"));
				$sql = "INSERT INTO pploom_loomaaed(nimi, puur, liik) VALUES ('$nimi', '$puur', '$liik')";
				$result = mysqli_query($connection, $sql);
				if (mysqli_insert_id($connection)) {
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
	$ss = explode(".", $_FILES[$name]["name"]);
	$extension = end($ss);

	if ( in_array($_FILES[$name]["type"], $allowedTypes)
		&& ($_FILES[$name]["size"] < 100000)
		&& in_array($extension, $allowedExts)) {
    // fail õiget tüüpi ja suurusega
		if ($_FILES[$name]["error"] > 0) {
			$_SESSION['notices'][]= "Return Code: " . $_FILES[$name]["error"];
			return "";
		} else {
      // vigu ei ole
			if (file_exists("pildid/" . $_FILES[$name]["name"])) {
        // fail olemas ära uuesti lae, tagasta failinimi
				$_SESSION['notices'][]= $_FILES[$name]["name"] . " juba eksisteerib. ";
				return "pildid/" .$_FILES[$name]["name"];
			} else {
        // kõik ok, aseta pilt
				move_uploaded_file($_FILES[$name]["tmp_name"], "pildid/" . $_FILES[$name]["name"]);
				return "pildid/" .$_FILES[$name]["name"];
			}
		}
	} else {
		return "";
	}
}

?>