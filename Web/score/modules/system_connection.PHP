<?

//------------------------------------------------------------------------------
#Function Connect_AS400(){
#  GLOBAL $ASuser,$ASpass,$ASnamesystem ;
#  $EnDecryptText = new EnDecryptText();
#  $conn = &ADONewConnection("db2");
#  $dsn = "DRIVER={Client Access ODBC Driver (32-bit)};SYSTEM=$ASnamesystem;CMT=0;NAM=0;DFT=0;DSP=0;TFT=0;TSP=0;DEC=0;XDYNAMIC=0;RECBLOCK=0;BLOCKSIZE=8;SCROLLABLE=0;TRANSLATE=0;LAZYCLOSE=0;LIBVIEW=0;REMARKS=0;CONNTYPE=0;SORTTYPE=0;LANGUAGEID=ENU;SORTWEIGHT=0;PREFETCH=0;MGDSN=0;".
#         "uid=".$EnDecryptText->Decrypt_Text($ASuser)."; pwd=".$EnDecryptText->Decrypt_Text($ASpass).";";
#  $conn->Connect($dsn) or die('Sorry My System to connect was Failure... please Call Administrator');

#  RETURN $conn;
#}
//------------------------------------------------------------------------------
FUNCTION LibDB_Connect(){
//error_reporting(0);
	GLOBAL $SQLDBName, $SQLUser, $SQLPass, $SQLHost;

	#$EnDecryptText = new EnDecryptText();
	#echo "<li>".$EnDecryptText->Encrypt_Text("sa");
	#$DB_CONNECT = mssql_connect($SQLHost, $EnDecryptText->Decrypt_Text($SQLUser), $EnDecryptText->Decrypt_Text($SQLPass)) or die("<b>..::: Maaf DataBase Sedang Mengalami Gangguan Di Server :::..<b>");
  //$DB_CONNECT = mssql_connect($SQLHost, $SQLUser, $SQLPass) or die("<b>..::: Maaf DataBase Sedang Mengalami Gangguan Di Server :::..<b>");
  //$DB_SELECT = mssql_select_db($SQLDBName,$DB_CONNECT)or die("<b>..::: Maaf DataBase Sedang Mengalami Gangguan Di Server :::..<b>");

  //print "yan"; //exit();
  $connectionInfo = array( "Database"=>$SQLDBName, "UID"=>$SQLUser, "PWD"=>$SQLPass );
  return sqlsrv_connect( $SQLHost, $connectionInfo);

  /*if( $conn ) {
     //echo "Connection established.<br />";
     return $conn;
  }else{
     echo "Connection could not be established.<br />";
     die( print_r( sqlsrv_errors(), true));
} */

//error_reporting(1);
}
//------------------------------------------------------------------------------
Function IP_USER(){
  RETURN $_SERVER['REMOTE_ADDR'];
}
//------------------------------------------------------------------------------
Function EXECUTE_QUERY($iSQL){
  print $iSQL;
  GLOBAL $connectionInfo, $SQLHost;
  $conn = sqlsrv_connect( $SQLHost, $connectionInfo);
  $hasil = sqlsrv_query($conn,$iSQL);  
  //$hasil = mssql_query($iSQL);
  IF($hasil==""){
      error_log("INVALID QUERY [".$iSQL."]");
      die(print_r(sqlsrv_errors(),true));
  }
  echo "<li>==".$hasil;
RETURN $hasil;
}

function exeQuery($sql){
   GLOBAL $SQLDBName, $SQLUser, $SQLPass, $SQLHost;
   $connectionInfo = array( "Database"=>$SQLDBName, "UID"=>$SQLUser, "PWD"=>$SQLPass );
   $conn 	= sqlsrv_connect( $SQLHost, $connectionInfo);
   $query 	= sqlsrv_query($conn,$sql);
   $data	= sqlsrv_fetch_array( $query, SQLSRV_FETCH_ASSOC);
   return $data;

}
//------------------------------------------------------------------------------

?>
