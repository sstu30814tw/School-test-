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
$query_Recordset1 = "SELECT * FROM restaurant";
$Recordset1 = mysql_query($query_Recordset1, $conn) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO books (isbn, bookname, author, publisher, pubdate, price, introduction) VALUES (%s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['isbn'], "text"),
                       GetSQLValueString($_POST['bookname'], "text"),
                       GetSQLValueString($_POST['author'], "text"),
                       GetSQLValueString($_POST['publisher'], "text"),
                       GetSQLValueString($_POST['pubdate'], "date"),
                       GetSQLValueString($_POST['price'], "int"),
                       GetSQLValueString($_POST['introduction'], "text"));

  mysql_select_db($database_conn, $conn);
  $Result1 = mysql_query($insertSQL, $conn) or die(mysql_error());
  $folder = mysql_insert_id();
if (isset($_FILES['attfiles'])){
        $errors= array();
        $dest_dir="attachment/".$folder."/";
        foreach($_FILES['attfiles']['tmp_name'] as $key => $tmp_name ){
            $file_name = $_FILES['attfiles']['name'][$key];
            $file_size = $_FILES['attfiles']['size'][$key];
            $file_tmp  = $_FILES['attfiles']['tmp_name'][$key];
            $file_type = $_FILES['attfiles']['type'][$key]; 
            if($file_size > 2097152){ $errors[]='File size must be less than 2 MB'; }  
           // $query="INSERT into upload_data (`USER_ID`,`FILE_NAME`,`FILE_SIZE`,`FILE_TYPE`) VALUES('$user_id','$file_name','$file_size','$file_type'); ";
            if(empty($errors)==true){
                if(is_dir($dest_dir)==false){
                    mkdir("$dest_dir", 0755);  // Create directory if it does not exist
                }
                if(is_dir("$dest_dir/".$file_name)==false){
                    move_uploaded_file($file_tmp, $dest_dir.$file_name);
                }else{         //rename the file if another one exist
                    $new_dir = $dest_dir.$file_name.time();
                    rename($file_tmp,$new_dir);
                }
               // mysql_query($query);   
            }else{
                    print_r($errors);
            }
        }
    }



  $insertGoTo = "books.php";
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
<meta charset="utf-8">
<title>無標題文件</title>
<script src="ckeditor/ckeditor.js"></script>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js" type="text/javascript" language="javascript"></script>
<script src="multifile-master/jquery.MultiFile.min.js"></script>
</head>

<body>
<form method="post" enctype="multipart/form-data" name="form1">
  <table align="center">
    <tr valign="baseline">
      <td nowrap align="right">Isbn:</td>
      <td><input type="text" name="isbn" value="" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Bookname:</td>
      <td><input type="text" name="bookname" value="" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Author:</td>
      <td><input type="text" name="author" value="" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Publisher:</td>
      <td><input type="text" name="publisher" value="" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Pubdate:</td>
      <td><input type="text" name="pubdate" value="" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right">Price:</td>
      <td><input type="text" name="price" value="" size="32"></td>
    </tr>
    <tr valign="baseline">
      <td nowrap align="right" valign="top">Introduction:</td>
      <td><textarea name="introduction" cols="50" rows="5"></textarea>
      <script> CKEDITOR.replace( 'introduction' ); </script>
      </td>
    </tr>
    
    <tr valign="baseline">
      <td nowrap align="right">附加檔案</td>
      <td><input type="file" class="multi" name="attfiles[]"></td>
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
?>
