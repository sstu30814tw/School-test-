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

mysql_select_db($database_conn, $conn);
$query_Recordset1 = "SELECT * FROM device ORDER BY devID ASC";
$Recordset1 = mysql_query($query_Recordset1, $conn) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Untitled Document</title>
    <!-- Bootstrap -->
	<link href="css/bootstrap.css" rel="stylesheet">
<meta charset="utf-8">
<title>設備資料</title>
</head>

<body>
<div class="container">
<h1>設備資料</h1>
<table class="table table-striped">
  <tr>
    <td>devID</td>
    <td>設備名稱</td>
    <td>型號</td>
    <td>價格</td>
    <td>購買日期</td>
    <td>詳細規格</td>
    <td>保管單位</td>
    <td>保管人</td>
    <td><a href="device_add.php">新增</a></td>
  </tr>
  <?php do { ?>
    <tr>
      <td><?php echo $row_Recordset1['devID']; ?></td>
      <td><?php echo $row_Recordset1['devName']; ?></td>
      <td><?php echo $row_Recordset1['model']; ?></td>
      <td><?php echo $row_Recordset1['price']; ?></td>
      <td><?php echo $row_Recordset1['purchaseDate']; ?></td>
      <td><?php echo $row_Recordset1['specification']; ?></td>
      <td><?php echo $row_Recordset1['depart']; ?></td>
      <td><?php echo $row_Recordset1['manager']; ?></td>
      <td><a href="device_edit.php?devID=<?php echo $row_Recordset1['devID']; ?>">修改</a>
          <a href="device_delete.php?devID=<?php echo $row_Recordset1['devID']; ?>" onClick="return confirm('確定刪除嗎');">刪除</a>
      </td>
    </tr>
    <?php } while ($row_Recordset1 = mysql_fetch_assoc($Recordset1)); ?>
     
</table>
 <script src="js/jquery-1.11.3.min.js"></script>

	<!-- Include all compiled plugins (below), or include individual files as needed --> 
	<script src="js/bootstrap.js"></script>  
</div>
</body>
</html>
<?php
mysql_free_result($Recordset1);
?>
