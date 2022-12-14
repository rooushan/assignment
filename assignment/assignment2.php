<?php
/* Author: Roushan
Date: 02-09-22
Version: 1.0
Description: This file consists of php code to get a response from DB and export the data into CSV file.
*/
include('connection.php'); //DB COnnection
//Create query to get the required data
$sql = "Select type, MAX(price) AS max_price, AVG(price) as avg_price, SUM(participants) as total_participants FROM activities GROUP BY type;";
$result = $conn->query($sql);
$data = array();
$data = [['Type', 'Max Price', 'Average Price', 'Total Participants' ]]; //Defining First Column or heading of CSV
//Create an array of all the data from DB 
$count = 1; //Assign a counter
while($row = $result->fetch_assoc()) {
  foreach($row as $key=>$value){
      if($key=='max_price' || $key=='avg_price'){
        $value = round($value,1); //round numbers upto 1 digit after decimal
      }
      $data[$count][]=$value; //Creating array of data in required format
  }
  $count ++;
}
//Close DB connection
$conn->close();
//Remove Old file if exist and Export data into new csv file
if(file_exists("test.txt")){
  unlink('records.csv');
}
$fp = fopen('records.csv', 'w');
foreach ($data as $row) {
    fputcsv($fp, $row);
}
fclose($fp);
echo "File generated by the name 'records.csv'";
?>
