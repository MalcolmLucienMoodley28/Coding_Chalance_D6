<?php
include('connection.php');
$data = json_decode(file_get_contents('php://input'), true);


if (!empty($data["Invoice_IV"])) 
{
    $Invoice_No ="Error";
    $Description ="Error";
    $Tax ="Error";
    $Amount ="0.00";

    $Invoice_No =$data["Invoice_IV"];
    $Description =$data["Description_IV"];//
    $Tax =$data["Tax_Check_IV"];//
    $Amount =$data["AMT_IV"];//

    $conn = OpenCon();
    $stmt1 = $conn->prepare("insert into `invoice_items`(Invoice_Number,Item_Description,Item_Tax_Check,Item_Amount) values (?,?,?,?)");
    $stmt1->bind_param("sssd",$Invoice_No,$Description,$Tax,$Amount);
    $stmt1->execute();
    $Item_Number = $conn->insert_id;
    CloseCon($conn);

    response($Item_Number,$Invoice_No,$Description,$Tax,$Amount);
}
else
{
	response(NULL, NULL, 400,"Invalid Request");
}

function response($Item_Number,$Invoice_No,$Description,$Tax,$Amount)
{
    $response['Item_Number'] = $Item_Number;
	$response['Invoice_No'] = $Invoice_No;
    $response['Description'] = $Description;//
    $response['Tax'] = $Tax;//
    $response['Amount'] = $Amount;//
	$json_response = json_encode($response);
	echo $json_response;
}
?>