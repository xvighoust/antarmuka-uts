<!doctype html>
<html lang="en">
  <head>
   <title>Data Sensor</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="style.css">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

   <body>
     <?php include 'conn.php' ?>

      <?php
         echo "<center>";
echo
'<div class="jumbotron">
  <h3 class="display-6">DATA SENSOR</h3>
</div>' ;

$sql = "SELECT * from logs order by waktu desc limit 50";
$result = mysqli_query($conn, $sql);
$nomor = 0;

if (mysqli_num_rows($result) > 0) {
?>
    <table id="customers">
        <tr>
            <th>No</th>
            <th>Waktu dan Tanggal</th>
            <th>Data Suhu</th>
            <th>Kelembaban</th>
            <th>Api</th>
            <th>Gas</th>
            <th>Pir</th>
        </tr>
        <?php
        while ($row = mysqli_fetch_assoc($result)) {
          $nomor = $nomor+1;
        ?>
            <tr>
              <td><?php echo $nomor; ?></td>
                <td><?php echo $row['waktu']; ?></td>
                <td><?php echo $row['suhu']; ?></td>
                <td><?php echo $row['kelembaban']; ?></td>
                <td><?php echo $row['api']; ?></td>
                <td><?php echo $row['gas']; ?></td>
                <td><?php echo $row['pir']; ?></td>
            </tr>
    <?php
        }
    } else {
        echo 'DATA TIDAK DITEMUKAN';
    }
    $conn->close();
    ?>
    </table>

       <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  </body>
</html>
</html>
