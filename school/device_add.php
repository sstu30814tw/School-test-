<?php require_once('Connections/conn.php'); ?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO device (devID, devName, model, price, purchaseDate, specification, depart, manager) VALUES (%s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['devID'], "int"),
                       GetSQLValueString($_POST['devName'], "text"),
                       GetSQLValueString($_POST['model'], "text"),
                       GetSQLValueString($_POST['price'], "int"),
                       GetSQLValueString($_POST['purchaseDate'], "date"),
                       GetSQLValueString($_POST['specification'], "text"),
                       GetSQLValueString($_POST['depart'], "text"),
                       GetSQLValueString($_POST['manager'], "text"));

  mysql_select_db($database_conn, $conn);
  $Result1 = mysql_query($insertSQL, $conn) or die(mysql_error());

  $insertGoTo = "device.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}
?>
<!doctype html>
<html>
<head>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Untitled Document</title>
    <!-- Bootstrap -->
	<link href="css/bootstrap.css" rel="stylesheet">
<meta charset="utf-8">
<title>新增</title>
</head>

<body>
<div class="container">
<h1>新增資料</h1>
<form method="post" name="form1" action="<?php echo $editFormAction; ?>">
  <table align="center">
    <tr valign="baseline">
      <td nowrap align="right">DevID:</td>
      <td><input type="text" name="devID" value="" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">設備名稱:</td>
      <td><input type="text" name="devName" value="" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">型號規格:</td>
      <td><input type="text" name="model" value="" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">價格:</td>
      <td><input type="text" name="price" value="" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">日期:</td>
      <td><input type="date" name="purchaseDate" value="<?php echo date("Y-m-d");?>" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">詳細規格:</td>
      <td><input type="text" name="specification" value="" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">保管單位:</td>
      <td><input type="text" name="depart" value="" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">保管人:</td>
      <td><input type="text" name="manager" value="" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">&nbsp;</td>
      <td><input type="submit" value="確定新增"></td>
    </tr>
  </table>
  <input type="hidden" name="MM_insert" value="form1">
</form>
<p>&nbsp;</p>
 <script src="js/jquery-1.11.3.min.js"></script>

	<!-- Include all compiled plugins (below), or include individual files as needed --> 
	<script src="js/bootstrap.js"></script>  
</div>
</body>
</html>