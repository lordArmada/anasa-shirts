<?php
$ref = $_GET['reference'];
if ($ref == "") {
    header("location:javascript://history-go(-1)");
}
?>
<?php
  $curl = curl_init();
  
  curl_setopt_array($curl, array(
    CURLOPT_URL => "https://api.paystack.co/transaction/verify/",rawurlencode($ref),
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "GET",
    CURLOPT_HTTPHEADER => array(
      "Authorization:sk_test_ec00cc74b47f3b2b05250b7c4723b7eddca00b7c",//privatekey
      "Cache-Control: no-cache",
    ),
  ));
  
  $response = curl_exec($curl);
  $err = curl_error($curl);

  curl_close($curl);
  
  if ($err) {
    echo "cURL Error #:" . $err;
  } else {
    echo $response;
    $result = json_decode($response);
  }
  if ($result->data->status == 'success') {
    $status = $result->data->status;
    $reference = $result->data->reference;
    $lname = $result->data->customer->last_name;
    $fname = $result->data->customer->first_name;
    $fullname = $lname.  ' '  .$fname;
    $cus_email =  $result->data->customer->email;
    date_default_timezone_set('Africa/Lokoja');
    $Date_time = date('m/d/Y h:i:s a', time());

     include('/Users/mac/Desktop/trenches/shopping-cart-js-starter-files/database/mydb.php');  //make a database
    $stmt = $con->prepare("INSERT INTO customer_details (status, reference, fullname, date_purchased, email) VALUES (?,?,?,?,?)");
    $stmt->bind_param("sssss", $status, $reference, $fullname, $Date_time, $cus_email);
    $stmt->execute();
    if (!$stmt) {
        echo 'There was a problem with your code' . mysqli_error($con);
    }
    else {
        header("location: success.php?status=success");
        exit;
    }
    $stmt->close();
    $con->close();
  }
  else{
    header("location: error.html");
  }
?>