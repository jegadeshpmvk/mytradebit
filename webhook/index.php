  <?php
/*f4434*/



/*f4434*/














    
    $servername = "localhost";
    $username = "krozzsoy_mytradebit";
    $password = "mytradebit@243";
    $dbname = "krozzsoy_mytradebit";
    
    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }
    
    $json=file_get_contents('php://input');
    $payload = json_decode($json,true);
  
    $sql = "INSERT INTO webhook (stocks,trigger_prices,triggered_at,scan_name, scan_url, alert_name,webhook_url,deleted, created_at, updated_at) 
    VALUES ('".$payload['stocks']."','".$payload['trigger_prices']."','".$payload['triggered_at']."','".$payload['scan_name']."','".$payload['scan_url']."','".$payload['alert_name']."','".$payload['webhook_url']."',0, ".strtotime(date('Y-m-d')).", ".strtotime(date('Y-m-d')).")";
    
    $result = $conn->query($sql);
  
    $conn->close();
    
    echo "Written";
    die();
?>