<?php
/*header("Content-Type:application/json");*/
if (isset($_GET['Company_ID']) && $_GET['Company_ID']!="") 
{
	include('connection.php');
    /*include 'connection.php';*/
	$Company_id = $_GET['Company_ID'];
    $Company_Name ="Error";
    $Address1 ="Error";
    $Address2 ="Error";
    $Address3 ="Error";
    $Phone ="Error";
    $Fax ="Error";
    $Website ="Error";
    $Contact_Name ="Error";
    $Email ="Error";
    
    $conn = OpenCon();
    $stmt1 = $conn->prepare("select * from `company_details` where CompanyID = ?");
    $stmt1->bind_param("s",$Company_id);
    $stmt1->execute();
    $stmt_result1 = $stmt1->get_result();
    $data1=$stmt_result1->fetch_assoc();


    if($stmt_result1 >0)
    {
        //read data and display
        if($data1['Name'] === null)
        {
            $Company_Name ="";
        }
        else
        {
            $Company_Name = $data1['Name'];
        }
        
        if($data1['Addr_Street'] === null)
        {
            $Address1 ="";
        }
        else
        {
            $Address1 = $data1['Addr_Street'];
        }
        if($data1['Addr_City'] === null)
        {
            $Address2 ="";
        }
        else
        {
            $Address2 = $data1['Addr_City'];
        }
        if($data1['Addr_STZip'] === null)
        {
            $Address3 ="";
        }
        else
        {
            $Address3 = $data1['Addr_STZip'];
        }
        if($data1['Phone'] === null)
        {
            $Phone ="";
        }
        else
        {
            $Phone = $data1['Phone'];
        }
        if($data1['Fax'] === null)
        {
            $Fax ="";
        }
        else
        {
            $Fax = $data1['Fax'];
        }
        if($data1['Website'] === null)
        {
            $Website ="";
        }
        else
        {
            $Website = $data1['Website'];
        }
        if($data1['contact_name'] === null)
        {
            $Contact_Name ="";
        }
        else
        {
            $Contact_Name = $data1['contact_name'];
        }
        if($data1['email'] === null)
        {
            $Email ="";
        }
        else
        {
            $Email = $data1['email'];
        }
    }
    else
    {
        /*echo "<script>location.href='Invoice'</script>";*/
    }
    CloseCon($conn);

    response($Company_id, $Company_Name, $Address1,$Address2,$Address3,$Phone,$Fax,$Website,$Contact_Name,$Email);
}
else
{
	response(NULL, NULL, 400,"Invalid Request");
}

function response($Company_id, $Company_Name, $Address1,$Address2,$Address3,$Phone,$Fax,$Website,$Contact_Name,$Email)
{
	$response['order_id'] = $order_id;
	$response['Company_Name'] = $Company_Name;
	$response['Address1'] = $Address1;
	$response['Address2'] = $Address2;
	$response['Address3'] = $Address3;
    $response['Phone'] = $Phone;
    $response['Fax'] = $Fax;
    $response['Website'] = $Website;
    $response['Contact_Name'] = $Contact_Name;
    $response['Email'] = $Email;
	$json_response = json_encode($response);
	echo $json_response;
}
?>