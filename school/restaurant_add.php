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
  $insertSQL = sprintf("INSERT INTO restaurant (foodid, foodname, foodprice, fooddate, foodimf) VALUES (%s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['foodid'], "int"),
                       GetSQLValueString($_POST['foodname'], "text"),
                       GetSQLValueString($_POST['foodprice'], "int"),
                       GetSQLValueString($_POST['fooddate'], "date"),
                       GetSQLValueString($_POST['foodimf'], "text"));

  mysql_select_db($database_conn, $conn);
  $Result1 = mysql_query($insertSQL, $conn) or die(mysql_error());

  $insertGoTo = "restaurant.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

mysql_select_db($database_conn, $conn);
$query_Recordset1 = "SELECT * FROM restaurant";
$Recordset1 = mysql_query($query_Recordset1, $conn) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>無標題文件</title>
</head>

<body>
<form method="post" name="form1" action="<?php echo $editFormAction; ?>">
  <table align="center">
    <tr valign="baseline">
      <td nowrap align="right">Foodid:</td>
      <td><input type="text" name="foodid" value="" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Foodname:</td>
      <td><input type="text" name="foodname" value="" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Foodprice:</td>
      <td><input type="text" name="foodprice" value="" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Fooddate:</td>
      <td><input type="date" name="fooddate" value="" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Foodimf:</td>
      <td><input type="text" name="foodimf" value="" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">&nbsp;</td>
      <td><input type="submit" value="插入記錄"></td>
    </tr>
  </table>
  <input type="hidden" name="MM_insert" value="form1">
</form>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($Recordset1);
mysql_query("SET NAMES UTF8");
?>
