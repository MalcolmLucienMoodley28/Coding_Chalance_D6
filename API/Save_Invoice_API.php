<?php
include('connection.php');
$data = json_decode(file_get_contents('php://input'), true);


if (!empty($data["Head_Company_Name_V"])) 
{
    $Company_Name ="Error";
    $Address1 ="Error";
    $Address2 ="Error";
    $Phone ="Error";
    $Fax ="Error";
    $Website ="Error";
    $Bill_Name ="Error";
    $Bill_Company ="Error";
    $Bill_Street ="Error";
    $Bill_City ="Error";
    $Bill_Phone ="Error";
    $Head_Date ="Error";
    $Head_Customer_ID="Error";
    $Head_Due ="Error";

    $INV_Other_Comments ="Error";
    $INV_Sub_total ="Error";
    $INV_Taxable_Total ="Error";
    $INV_Tax_Rate ="Error";
    $INV_Taxable_Out ="Error";
    $INV_Other_Charge ="Error";
    $INV_Final_T ="Error";
    $INV_Contact_Info ="Error";

    $Company_Name =$data["Head_Company_Name_V"];
    $Address1 =$data["Head_Company_Add1_V"];//Head_Company_Add1_V
    $Address2 =$data["Head_Company_Add2_V"];//
    $Phone =$data["Head_Company_Phone_V"];//
    $Fax =$data["Head_Company_Fax_V"];//
    $Website =$data["Head_Company_Website_V"];//
    $Bill_Name =$data["Bill_Name_V"];//
    $Bill_Company =$data["Bill_Company_Name_V"];//
    $Bill_Street =$data["Bill_Street_V"];//
    $Bill_City =$data["Bill_City_V"];//
    $Bill_Phone =$data["Bill_Phone_V"];//
    $Head_Date =$data["Head_Date_V"];//
    $Head_Customer_ID =$data["Head_Customer_Id_V"];//
    $Head_Due =$data["Head_Due_Date_V"];//

    $INV_Other_Comments =$data["Item_Comments_V"];//
    $INV_Sub_total =$data["Item_Sub_T_V"];//
    $INV_Taxable_Total =$data["Item_Taxable_T_V"];//
    $INV_Tax_Rate =$data["Item_Tax_Rate_V"];//
    $INV_Taxable_Out =$data["Item_Taxable_Out_V"];//
    $INV_Other_Charge =$data["Item_Other_Charge_V"];//
    $INV_Final_T =$data["Item_Final_T_V"];//
    $INV_Contact_Info =$data["Item_Contact_Info_V"];//




    $conn = OpenCon();
    $stmt1 = $conn->prepare("insert into `invoice_entry`(Company_Name,Company_Add1,Company_Add2,Company_Phone,Company_Fax,Company_Website,Bill_Name,Bill_Company,Bill_Street,Bill_City,Bill_Phone,INV_Date,Customer_ID,INV_Due_Date,Other_Comments,Sub_Total,Taxable,Tax_Rate,Tax_Due,Other,Total,INV_Contact_Information) values (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
    $stmt1->bind_param("sssssssssssssssdddddds",$Company_Name,$Address1,$Address2,$Phone,$Fax,$Website,$Bill_Name,$Bill_Company,$Bill_Street,$Bill_City,$Bill_Phone,$Head_Date,$Head_Customer_ID,$Head_Due,$INV_Other_Comments,$INV_Sub_total,$INV_Taxable_Total,$INV_Tax_Rate,$INV_Taxable_Out,$INV_Other_Charge,$INV_Final_T,$INV_Contact_Info);
    $stmt1->execute();
    $Invoice_Number = $conn->insert_id;
    CloseCon($conn);

    response($Invoice_Number,$Company_Name,$Address1,$Address2,$Phone,$Fax,$Website,$Bill_Name,$Bill_Company,$Bill_Street,$Bill_City,$Bill_Phone,$Head_Date,$Head_Customer_ID,$Head_Due,$INV_Other_Comments,$INV_Sub_total,$INV_Taxable_Total,$INV_Tax_Rate,$INV_Taxable_Out,$INV_Other_Charge,$INV_Final_T,$INV_Contact_Info);
}
else
{
	response(NULL, NULL, 400,"Invalid Request");
}

function response($Invoice_Number,$Company_Name,$Address1,$Address2,$Phone,$Fax,$Website,$Bill_Name,$Bill_Company,$Bill_Street,$Bill_City,$Bill_Phone,$Head_Date,$Head_Customer_ID,$Head_Due,$INV_Other_Comments,$INV_Sub_total,$INV_Taxable_Total,$INV_Tax_Rate,$INV_Taxable_Out,$INV_Other_Charge,$INV_Final_T,$INV_Contact_Info)
{
	$response['Invoice_Number'] = $Invoice_Number;
    $response['Company_Name'] = $Company_Name;//Company_Name
    $response['Address1'] = $Address1;//Address1
    $response['Address2'] = $Address2;//
    $response['Phone'] = $Phone;//
    $response['Fax'] = $Fax;//
    $response['Website'] = $Website;//
    $response['Bill_Name'] = $Bill_Name;//
    $response['Bill_Company'] = $Bill_Company;//
    $response['Bill_Street'] = $Bill_Street;//
    $response['Bill_City'] = $Bill_City;//
    $response['Bill_Phone'] = $Bill_Phone;//
    $response['Head_Date'] = $Head_Date;//
    $response['Head_Customer_ID'] = $Head_Customer_ID;//
    $response['Head_Due'] = $Head_Due;//
    $response['INV_Other_Comments'] = $INV_Other_Comments;//
    $response['INV_Sub_total'] = $INV_Sub_total;//
    $response['INV_Taxable_Total'] = $INV_Taxable_Total;//
    $response['INV_Tax_Rate'] = $INV_Tax_Rate;//
    $response['INV_Taxable_Out'] = $INV_Taxable_Out;//
    $response['INV_Other_Charge'] = $INV_Other_Charge;//
    $response['INV_Final_T'] = $INV_Final_T;//
    $response['INV_Contact_Info'] = $INV_Contact_Info;//
	$json_response = json_encode($response);
	echo $json_response;
}
?>