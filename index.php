<?php
	$serverName = "rezalearnazure.database.windows.net";
	$connectionOptions = array(
	    "Database" => "rezalearnazure",
	    "Uid" => "reza",
	    "PWD" => "Tes123qwe!@#"
	);
	//Establishes the connection
	$conn = sqlsrv_connect($serverName, $connectionOptions);

	if( $conn ) {
    
	}else{
	     echo "Connection could not be established.<br />";
	     die( print_r( sqlsrv_errors(), true));
	}

	if(isset($_POST['submit'])){
		
		$nama = $_POST['nama'];
		$alamat = $_POST['alamat'];
		

		//Insert Query
		// echo ("Inserting a new row into table" . PHP_EOL);
		$tsql= "INSERT INTO [dbo].[User] (nama, alamat) VALUES (?, ?);";
		$params = array($nama,$alamat);
		$getResults= sqlsrv_query($conn, $tsql, $params);
		$rowsAffected = sqlsrv_rows_affected($getResults);
		if ($getResults == FALSE or $rowsAffected == FALSE)
		    die(FormatErrors(sqlsrv_errors()));
		// echo ($rowsAffected. " row(s) inserted: " . PHP_EOL);

		sqlsrv_free_stmt($getResults);

		if($getResults){
		header("location:index.php");
		}else{
			echo "Gagal";
		}
	}

	function FormatErrors( $errors )
	{
	    /* Display errors. */
	    echo "Error information: ";

	    foreach ( $errors as $error )
	    {
	        echo "SQLSTATE: ".$error['SQLSTATE']."";
	        echo "Code: ".$error['code']."";
	        echo "Message: ".$error['message']."";
	    }
	}

	 
?>
<html>
<body>

	<?php

		//Read Query
		$tsql= "SELECT id, nama, alamat FROM [dbo].[User];";
		$getResults= sqlsrv_query($conn, $tsql);
		// echo ("Reading data from table" . PHP_EOL);
		if ($getResults == FALSE)
		    die(FormatErrors(sqlsrv_errors()));

		echo "
			<h1>Daftar Tamu</h1>
			<table border='1' cellpadding='4'>
				<tr>
					<td>No</td>
					<td>Nama</td>
					<td>Asal</td>
						
				</tr>";
			while ($data = sqlsrv_fetch_array($getResults, SQLSRV_FETCH_ASSOC)) {
			echo "<tr>
					<td>$data[id]</td>
					<td>$data[nama]</td>
					<td>$data[alamat]</td>
					
				</tr>
				";
			}
			echo "</table>
				</body>
				<br>";

		
		   
		
		sqlsrv_free_stmt($getResults);

	?>


	<hr>
	<h1> Silahkan Isi Buku Tamu </h1>
	<form action="" method="POST">
		<table border="0" cellpadding="10">
			<tr>
				<td>Nama</td>
				<td><input type="text" name="nama"></td>
			</tr>
			<tr>
				<td>Asal</td>
				<td><input type="text" name="alamat"></td>
			</tr>
			
			<tr>
				<td colspan="4" align="center"><input type="submit" name="submit"></td>
			</tr>
		</table>
	</form>
</body>
</html>
