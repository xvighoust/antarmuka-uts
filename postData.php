<?php include 'conn.php' ?>

<?php


    if(!empty($_POST['sensor1']) || !empty($_POST['sensor2']) || !empty($_POST['sensor3']) || !empty($_POST['sensor4']) || !empty($_POST['sensor5']))
    {
    	$sensorData1 = $_POST['sensor1'];
    	$sensorData2 = $_POST['sensor2'];
      $sensorData3 = $_POST['sensor3'];
      $sensorData4 = $_POST['sensor4'];
      $sensorData5 = $_POST['sensor5'];


	    $sql = "INSERT INTO logs (suhu,kelembaban,api,gas,pir) VALUES ('".$sensorData1."', '".$sensorData2."', '".$sensorData3."', '".$sensorData4."', '".$sensorData5."')";


		if ($conn->query($sql) === TRUE) {
		    echo "OK";
		} else {
		    echo "Error: " . $sql . "<br>" . $conn->error;
		}
	}

	$conn->close();
?>
