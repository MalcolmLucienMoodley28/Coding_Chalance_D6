<?php
/*header("Content-Type:application/json");*/
if (isset($_GET['Bill_Customer_ID']) && $_GET['Bill_Customer_ID']!="") 
{
	include('connection.php');
    /*include 'connection.php';*/
	$Bill_Customer_id = $_GET['Bill_Customer_ID'];
    $Bill_Name ="Error";
    $Bill_Company ="Error";
    $Bill_Street ="Error";
    $Bill_City ="Error";
    $Bill_Zip ="Error";
    $Bill_Phone ="Error";
    
    $conn = OpenCon();
    $stmt1 = $conn->prepare("select * from `customer_details` where Bill_Customer_ID = ?");
    $stmt1->bind_param("s",$Bill_Customer_id);
    $stmt1->execute();
    $stmt_result1 = $stmt1->get_result();
    $data1=$stmt_result1->fetch_assoc();


    if($stmt_result1 >0)
    {
        //read data and display
        if($data1['Bill_Name'] === null)
        {
            $Bill_Name ="";
        }
        else
        {
            $Bill_Name = $data1['Bill_Name'];
        }
        if($data1['Bill_Company'] === null)
        {
            $Bill_Company ="";
        }
        else
        {
            $Bill_Company = $data1['Bill_Company'];
        }
        if($data1['Bill_Street'] === null)
        {
            $Bill_Street ="";
        }
        else
        {
            $Bill_Street = $data1['Bill_Street'];
        }
        if($data1['Bill_City'] === null)
        {
            $Bill_City ="";
        }
        else
        {
            $Bill_City = $data1['Bill_City'];
        }
        if($data1['Bill_Zip'] === null)
        {
            $Bill_Zip ="";
        }
        else
        {
            $Bill_Zip = $data1['Bill_Zip'];
        }
        if($data1['Bill_Phone'] === null)
        {
            $Bill_Phone ="";
        }
        else
        {
            $Bill_Phone = $data1['Bill_Phone'];
        }
    }
    else
    {
        /*echo "<script>location.href='Invoice'</script>";*/
    }
    CloseCon($conn);

    response($Bill_Customer_id,$Bill_Name,$Bill_Company,$Bill_Street,$Bill_City,$Bill_Zip,$Bill_Phone);
}
else
{
	response(NULL, NULL, 400,"Invalid Request");
}

function response($Bill_Customer_id,$Bill_Name,$Bill_Company,$Bill_Street,$Bill_City,$Bill_Zip,$Bill_Phone)
{
	$response['Bill_Customer_ID'] = $Bill_Customer_id;
	$response['Bill_Name'] = $Bill_Name;
	$response['Bill_Company'] = $Bill_Company;
	$response['Bill_Street'] = $Bill_Street;
	$response['Bill_City'] = $Bill_City;
    $response['Bill_Zip'] = $Bill_Zip;
    $response['Bill_Phone'] = $Bill_Phone;
	$json_response = json_encode($response);
	echo $json_response;
}
?>