<?php
// to do el codigo funciona

$con=mysqli_connect("localhost","root","","sombrerosoficina");
// Check connection
if (mysqli_connect_errno())
{
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

function readCSV($csvFile){
    $file_handle = fopen($csvFile, 'r');
    while (!feof($file_handle) ) {
        $line_of_text[] = fgetcsv($file_handle, 1024);
    }
    fclose($file_handle);
    return $line_of_text;
}

// Set path to CSV file
//$csvFile = 'test_data.csv';
$csvFile = 'contacts.csv';

//calling the function
$csv = readCSV($csvFile);
if(!empty($csv)){
    foreach($csv as $file){
        //inserting into database
        $query_insert = "insert into contacts set
            contact_first    =   '".$file[0]."',
            contact_last   =   '".$file[1]."',
            contact_email =  '".$file[2]."'";



        echo "la consulta es: " . $query_insert;
        $insert = mysqli_query($con,$query_insert);
    }
}else{
    echo 'Csv is empty';

}

?>