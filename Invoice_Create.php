<?php 
/* ID below can be controled based on the entity logged in as the system is designed to manage multiple entities on the same architecture
For simplicity i have set the ID to 1 which is 
the first set of data i have prepopulated in the database table.*/
$IDS = "1";
$Company_Name ="Error";
$Address1 ="Error";
$Address2 ="Error";
$Address3 ="Error";
$Phone ="Error";
$Fax ="Error";
$Website ="Error";
$Contact_Name ="Error";
$Email ="Error";

$url = "https://mnlconsultants.co.za/1TEST/API/My_Company_Details_API.php?Company_ID=".$IDS;	
$client = curl_init($url);
curl_setopt($client,CURLOPT_RETURNTRANSFER,true);
$response = curl_exec($client);	
$result = json_decode($response);

$Company_Name =$result->Company_Name;
$Address1 =$result->Address1;
$Address2 =$result->Address2;
$Address3 =$result->Address3;
$Phone =$result->Phone;
$Fax =$result->Fax;
$Website =$result->Website;
$Contact_Name =$result->Contact_Name;
$Email =$result->Email;
?>








<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Malcolm Moodley and copyright to Malcolm-Lucien Moodley">
    <title>Create Invoices</title>
    
    <link href="assets/css/style.css" rel="stylesheet">
    
    <script>
      //Controls for table
      function addField(Master_INV_Table,o)//master add item button
      {
        //get and insert row data
        let Item_New_Des = document.getElementById("Item_Description_New").value;//item description
        let Item_New_Tax = document.getElementById("Item_Tax_New").value;//
        if(Item_New_Tax == 1)
        {
          Item_New_Tax = "X";
        }
        else
        {
          Item_New_Tax = "";
        }
        let Item_New_Amount = document.getElementById("Item_Amt_New").value;//



        //delete current
        var p=o.parentNode.parentNode;
        p.parentNode.removeChild(p);


        Add_Entry(Master_INV_Table,Item_New_Des,Item_New_Tax,Item_New_Amount);
        Add_New_Row(Master_INV_Table);
      }
      function SomeDeleteRowFunction(o,Master_INV_Table) //delete current row
      {
        var p=o.parentNode.parentNode;
        p.parentNode.removeChild(p);
        Calculate_M(Master_INV_Table);
      }
      function Add_New_Row(Master_INV_Table) //Add input entry row
      {
        var tableRef = document.getElementById(Master_INV_Table);
        var newRow   = tableRef.insertRow(-1);
        //desc
        var newCell = newRow.insertCell(0);
        var newElem = document.createElement( 'input' );
        newElem.setAttribute("name", "description");
        newElem.setAttribute("type", "text");
        newElem.setAttribute("id", "Item_Description_New");
        newCell.appendChild(newElem);
        //tax
        newCell = newRow.insertCell(1);
        newElem = document.createElement( 'SELECT' );
        newElem.setAttribute("id", "Item_Tax_New");
        var Drop_Opt = [
                { OpId: 1, Name: "X"},
                { OpId: 2, Name: " "}
            ];
        //Add the Options to the DropDownList.
        for (var i = 0; i < Drop_Opt.length; i++) 
        {
            var option = document.createElement("OPTION");
            option.innerHTML = Drop_Opt[i].Name;
            option.value = Drop_Opt[i].OpId;
            newElem.options.add(option);
          
        }
        newCell.appendChild(newElem);
        //amt
        newCell = newRow.insertCell(2);
        newElem = document.createElement( 'input' );
        newElem.setAttribute("name", "amount");
        newElem.setAttribute("type", "number");
        newElem.setAttribute("value", "0.00");
        newElem.setAttribute("id", "Item_Amt_New");
        newElem.setAttribute("onchange", "Calculate_M('"+Master_INV_Table+"')");
        newElem.setAttribute("onkeyup", "Calculate_M('"+Master_INV_Table+"')");
        newCell.appendChild(newElem);

        //Add  btn
        newCell = newRow.insertCell(3);
        newElem = document.createElement( 'input' );
        newElem.setAttribute("type", "button");
        newElem.setAttribute("value", "Add item");
        newElem.setAttribute("class", "button");//class="button"
        newElem.setAttribute("onclick", "addField('"+Master_INV_Table+"',this)");
        newCell.appendChild(newElem);

        //Cal total
        Calculate_M(Master_INV_Table);
      }
      function Add_Entry(Master_INV_Table,Item_Description,Item_Tax,Item_Amt) //insert input fields to table
      {
        //insert new
        var tableRef = document.getElementById(Master_INV_Table);
        var newRow   = tableRef.insertRow(-1);

        //desc
        var newCell = newRow.insertCell(0);
        newCell.innerHTML = Item_Description ;//Item_Description

        //tax
        newCell = newRow.insertCell(1);
        newCell.innerHTML =Item_Tax;//


        //amt
        newCell = newRow.insertCell(2);
        newCell.innerHTML =Item_Amt;//

        //update btn
        var newElem = document.createElement( 'input' );
        newCell = newRow.insertCell(3);
        newElem = document.createElement( 'input' );
        newElem.setAttribute("type", "button");
        newElem.setAttribute("value", "Update");
        newElem.setAttribute("class", "button");//class="button"
        newElem.setAttribute("onclick", "Update_M(this,'"+Master_INV_Table+"')");
        newCell.appendChild(newElem);

        //delete btn
        newCell = newRow.insertCell(4);
        newElem = document.createElement( 'input' );
        newElem.setAttribute("type", "button");
        newElem.setAttribute("value", "Delete");
        newElem.setAttribute("class", "button");//class="button"
        newElem.setAttribute("onclick", "SomeDeleteRowFunction(this,'"+Master_INV_Table+"')");
        newCell.appendChild(newElem);
      }
      function Calculate_M(Master_INV_Table) // calc total method
      {
        //input
        var Tax_Rate = 0;
        if(document.getElementById("Tax_Rate_Input").value == "")
        {
          Tax_Rate= 0;//
        }
        else
        {
          Tax_Rate=parseFloat(document.getElementById("Tax_Rate_Input").value);//
        }
        
        


        var Other_Charge_In =0.00;//Other_Charge
        if(document.getElementById("Other_Charge").value == "")
        {
          Other_Charge_In= 0;//
        }
        else
        {
          Other_Charge_In=parseFloat(document.getElementById("Other_Charge").value);//
        }


        //Calc fields
        var Total = 0.00;
        var Tax_AMT = 0.00;
        let Row_Count = 0;

        var table = document. getElementById(Master_INV_Table);
        let total_Rows = table.rows.length-1;

        for (let row of table.rows) 
        {
          if(Row_Count > 0 && Row_Count < total_Rows)//
          {
            let Col_Count = 0;
            let item_tax_check = false;
            for(let cell of row.cells) 
            {
              if(Col_Count == 1)
              {
                let val = cell.innerHTML;
                if(val == "X")
                {
                  item_tax_check = true;
                }
              }
              if(Col_Count == 2)
              {
                //Total Amt
                let val = cell.innerHTML; // Calc Amount Column
                Total=Total+parseFloat(val);

                //Total Sub  with tax
                if(item_tax_check == true)
                {
                  Tax_AMT=Tax_AMT+parseFloat(val);
                }
                




              }
              Col_Count=Col_Count+1;
            }
          }
          Row_Count=Row_Count+1;
        }

        document.getElementById('Sub_Total').innerHTML = Total;
        document.getElementById('Taxable_Total').innerHTML = Tax_AMT;//Taxable_Total
        
        if(Tax_Rate == 0)
        {
          document.getElementById('Taxable_Out').innerHTML = Tax_AMT;//Taxable_Out
        }
        else
        {
          document.getElementById('Taxable_Out').innerHTML = Tax_AMT*Tax_Rate/100;//Taxable_Out
        }
        document.getElementById('Final_Total').innerHTML = Total+(Tax_AMT*Tax_Rate/100)+Other_Charge_In;//Other_Charge_In
      }
      function Update_M(o,Master_INV_Table)
      {
        var rollno=document.sample.rollno1.value; 
        var name=document.sample.name1.value; 
        var s = stud.parentNode.parentNode;
        var tr = document.createElement('tr');
        
        var td1 = tr.appendChild(document.createElement('td'));
        var td2 = tr.appendChild(document.createElement('td'));
        var td3 = tr.appendChild(document.createElement('td'));
        var td4 = tr.appendChild(document.createElement('td'));
        
        
        td1.innerHTML='<input type="button" name="del" value="Delete" onclick="delStudent(this);" class="btn btn-danger">';
        td2.innerHTML='<input type="button" name="del" value="Delete" onclick="delStudent(this);" class="btn btn-danger">';
        td3.innerHTML='<input type="button" name="del" value="Delete" onclick="delStudent(this);" class="btn btn-danger">'
        td4.innerHTML='<input type="button" name="up" value="Update" onclick="UpStud(this);" class="btn btn-primary">'

        document.getElementById(Master_INV_Table).replaceChild(tr, s);


        var tableRef = document.getElementById(Master_INV_Table);
        var newRow   = tableRef.insertRow(-1);

        //Update F1
        var newCell = newRow.insertCell(0);
        newCell.innerHTML = Item_Description ;//Item_Description


        //add edit fields
        var newCell = newRow.insertCell(0);
        var newElem = document.createElement( 'input' );
        newElem.setAttribute("name", "description");
        newElem.setAttribute("type", "text");
        newElem.setAttribute("id", "Item_Description_New");
        newCell.appendChild(newElem);
      }

     
      //customer details formulated based on ID entered to read database using (Bill_Customer_API).
      async function Bill_Client_Details() 
      {
				let customer_id = document.getElementById('Customer_ID_Input').value;
				try 
        {
					const res = await fetch("https://mnlconsultants.co.za/1TEST/API/Bill_Customer_Details_API.php?Bill_Customer_ID="+customer_id);
					const response = await res.json();
          if(response.Bill_Name == "")
          {
            document.getElementById('Customer_Bill_Name').innerHTML = "No Customer Found";
            document.getElementById('Customer_Bill_Company').innerHTML = "No Customer Found";
            document.getElementById('Customer_Bill_Street').innerHTML = "No Customer Found";
            document.getElementById('Customer_Bill_City').innerHTML = "No Customer Found";
            document.getElementById('Customer_Bill_Phone').innerHTML = "No Customer Found";
          }
          else
          {
            document.getElementById('Customer_Bill_Name').innerHTML = response.Bill_Name;
            document.getElementById('Customer_Bill_Company').innerHTML = response.Bill_Company;
            document.getElementById('Customer_Bill_Street').innerHTML =  response.Bill_Street;
            document.getElementById('Customer_Bill_City').innerHTML =  response.Bill_City;
            document.getElementById('Customer_Bill_Phone').innerHTML = response.Bill_Zip;
          }
				} 
        catch (err) 
        {
          document.getElementById('Customer_Bill_Name').innerHTML = "ERROR";
          document.getElementById('Customer_Bill_Company').innerHTML = "ERROR";
          document.getElementById('Customer_Bill_Street').innerHTML = "ERROR";
          document.getElementById('Customer_Bill_City').innerHTML = "ERROR";
          document.getElementById('Customer_Bill_Phone').innerHTML = "ERROR";
        }
			}


      //Save function for  invoice
      var Error_1 = false;
      var Error_2 = false;
      var Error_3 = false;
      function Validate_Before_Save()
      {
          ///////////////PERFORM DATA VALIDATION AND CHECKS BEFORE SAVING DATA ////////////////////////////
      }
      async function Insert_Main_Invoice()
      {
        /*
        //////////////// Retrieve field data/////////////
        //head data AREA
        var Comp_Name =  document.getElementById("Head_Company_Name").innerText;
        var Comp_Add1 =  document.getElementById("Head_Company_Add1").innerText;
        var Comp_Add2 =  document.getElementById("Head_Company_Add2").innerText;
        var Comp_Phone =  document.getElementById("Head_Company_Phone").innerText;
        var Comp_Fax =  document.getElementById("Head_Company_Fax").innerText;
        var Comp_Website =  document.getElementById("Head_Company_Website").innerText;

        //gen AREA
        var Head_Date =  document.getElementById("Head_Date").innerText;
        var Customer_ID_Input =  document.getElementById("Customer_ID_Input").value;
        var Due_Date_Input =  document.getElementById("Due_Date").value;

        //Bill AREA
        var Bill_Name_Input =  document.getElementById("Customer_Bill_Name").innerText;
        var Bill_Name_Company =  document.getElementById("Customer_Bill_Company").innerText;
        var Bill_Name_Street =  document.getElementById("Customer_Bill_Street").innerText;
        var Bill_Name_City =  document.getElementById("Customer_Bill_City").innerText;
        var Bill_Name_Phone =  document.getElementById("Customer_Bill_Phone").innerText;

        //invoice details
        var INV_Other_Comments =  document.getElementById("Other_Notes_Comments").value;
        var INV_Sub_Total =  document.getElementById("Sub_Total").innerText;
        var INV_Taxable_Total =  document.getElementById("Taxable_Total").innerText;
        var INV_Tax_Rate =  document.getElementById("Tax_Rate_Input").value;
        var INV_Taxable_Out =  document.getElementById("Taxable_Out").innerText;
        var INV_Other_Charge =  document.getElementById("Other_Charge").value;
        var INV_FInal_Total =  document.getElementById("Final_Total").innerText;
        var INV_Contact_Info =  document.getElementById("Contact_Information").innerText;




        
        ////////////////POST DATA TO API - Insert Main Invoice Details/////////////
				try 
        {
					const res = await fetch("https://mnlconsultants.co.za/1TEST/API/Save_Invoice_API.php",{
            method: 'POST',
            headers:{
              "Content-type": "application/json; charset=UTF-8"
            },
            body: JSON.stringify({
              Head_Company_Name_V : Comp_Name,
              Head_Company_Add1_V : Comp_Add1,
              Head_Company_Add2_V :Comp_Add2,
              Head_Company_Phone_V :Comp_Phone,
              Head_Company_Fax_V :Comp_Fax,
              Head_Company_Website_V :Comp_Website,
              Head_Date_V :Head_Date,
              Head_Customer_Id_V :Customer_ID_Input,
              Head_Due_Date_V :Due_Date_Input,
              Bill_Name_V :Bill_Name_Input,
              Bill_Company_Name_V :Bill_Name_Company,
              Bill_Street_V :Bill_Name_Street,
              Bill_City_V :Bill_Name_City,
              Bill_Phone_V :Bill_Name_Phone,
              Item_Comments_V :INV_Other_Comments,
              Item_Sub_T_V :INV_Sub_Total,
              Item_Taxable_T_V :INV_Taxable_Total,
              Item_Tax_Rate_V :INV_Tax_Rate,
              Item_Taxable_Out_V :INV_Taxable_Out,
              Item_Other_Charge_V :INV_Other_Charge,
              Item_Final_T_V :INV_FInal_Total,
              Item_Contact_Info_V :INV_Contact_Info
            })
          })
					const response = await res.json();
          Inv_ID = response.Invoice_Number;
				} 
        catch(err) 
        {
          Inv_ID = "N/A";
          Error_1 = true;
          //insert into error log to handle errors
        }
        */
      }
      async function Insert_Invoice_Items(Inv_ID,Master_INV_Table)
      {
        ////////////////POST DATA TO API - Insert Each Item Entry/////////////
        try
        {
          if(Error_1 == false)
          {
            try 
            {
              var table = document. getElementById(Master_INV_Table);
              let total_Rows = table.rows.length-1;
              let Row_Count = 0;
              for (let row of table.rows) 
              {
                if(Row_Count > 0 && Row_Count < total_Rows)//
                {

                  let Col_Count = 0;
                  let item_tax_check = false;

                  let DescriptionItem = "";
                  let TaxItem = "";
                  let AmountItem = 0.0;
                  for(let cell of row.cells) 
                  {
                   

                    if(Col_Count == 0)
                    {
                      let val = cell.innerHTML;
                      DescriptionItem = val;
                    }
                    if(Col_Count == 1)
                    {
                      let val = cell.innerHTML;
                      if(val == "X")
                      {
                        TaxItem = "X";
                      } 
                    }
                    if(Col_Count == 2)
                    {
                      //Total Amt
                      let val = cell.innerHTML; //
                      AmountItem=parseFloat(val);
                    }
                    Col_Count=Col_Count+1;
                  }

                  const res = await fetch("https://mnlconsultants.co.za/1TEST/API/Save_Invoice_Items_API.php",{
                      method: 'POST',
                      headers:{
                        "Content-type": "application/json; charset=UTF-8"
                      },
                      body: JSON.stringify({
                        Invoice_IV : Inv_ID,
                        Description_IV : DescriptionItem,
                        Tax_Check_IV : TaxItem,
                        AMT_IV : AmountItem
                      })
                    })
                    const response = await res.json();



                }
                Row_Count=Row_Count+1;
            }

              
            } 
            catch(err) 
            {
              Inv_ID = "N/A";
              Error_3 = true;
              //insert into error log to handle errors

            }
          }
        }
        catch(errr)
        {
          Error_2 = true;
          //insert into error log to handle errors

        }  
      }
      async function Save_Invoice(Master_INV_Table) 
      {
        Validate_Before_Save();

        //////////////// Retrieve field data/////////////
        //head data AREA
        var Comp_Name =  document.getElementById("Head_Company_Name").innerText;
        var Comp_Add1 =  document.getElementById("Head_Company_Add1").innerText;
        var Comp_Add2 =  document.getElementById("Head_Company_Add2").innerText;
        var Comp_Phone =  document.getElementById("Head_Company_Phone").innerText;
        var Comp_Fax =  document.getElementById("Head_Company_Fax").innerText;
        var Comp_Website =  document.getElementById("Head_Company_Website").innerText;

        //gen AREA
        var Head_Date =  document.getElementById("Head_Date").innerText;
        var Customer_ID_Input =  document.getElementById("Customer_ID_Input").value;
        var Due_Date_Input =  document.getElementById("Due_Date").value;

        //Bill AREA
        var Bill_Name_Input =  document.getElementById("Customer_Bill_Name").innerText;
        var Bill_Name_Company =  document.getElementById("Customer_Bill_Company").innerText;
        var Bill_Name_Street =  document.getElementById("Customer_Bill_Street").innerText;
        var Bill_Name_City =  document.getElementById("Customer_Bill_City").innerText;
        var Bill_Name_Phone =  document.getElementById("Customer_Bill_Phone").innerText;

        //invoice details
        var INV_Other_Comments =  document.getElementById("Other_Notes_Comments").value;
        var INV_Sub_Total =  document.getElementById("Sub_Total").innerText;
        var INV_Taxable_Total =  document.getElementById("Taxable_Total").innerText;
        var INV_Tax_Rate =  document.getElementById("Tax_Rate_Input").value;
        var INV_Taxable_Out =  document.getElementById("Taxable_Out").innerText;
        var INV_Other_Charge =  document.getElementById("Other_Charge").value;
        var INV_FInal_Total =  document.getElementById("Final_Total").innerText;
        var INV_Contact_Info =  document.getElementById("Contact_Information").innerText;

        var Inv_ID = "";


        
        ////////////////POST DATA TO API - Insert Main Invoice Details/////////////
				try 
        {
					const res = await fetch("https://mnlconsultants.co.za/1TEST/API/Save_Invoice_API.php",{
            method: 'POST',
            headers:{
              "Content-type": "application/json; charset=UTF-8"
            },
            body: JSON.stringify({
              Head_Company_Name_V : Comp_Name,
              Head_Company_Add1_V : Comp_Add1,
              Head_Company_Add2_V :Comp_Add2,
              Head_Company_Phone_V :Comp_Phone,
              Head_Company_Fax_V :Comp_Fax,
              Head_Company_Website_V :Comp_Website,
              Head_Date_V :Head_Date,
              Head_Customer_Id_V :Customer_ID_Input,
              Head_Due_Date_V :Due_Date_Input,
              Bill_Name_V :Bill_Name_Input,
              Bill_Company_Name_V :Bill_Name_Company,
              Bill_Street_V :Bill_Name_Street,
              Bill_City_V :Bill_Name_City,
              Bill_Phone_V :Bill_Name_Phone,
              Item_Comments_V :INV_Other_Comments,
              Item_Sub_T_V :INV_Sub_Total,
              Item_Taxable_T_V :INV_Taxable_Total,
              Item_Tax_Rate_V :INV_Tax_Rate,
              Item_Taxable_Out_V :INV_Taxable_Out,
              Item_Other_Charge_V :INV_Other_Charge,
              Item_Final_T_V :INV_FInal_Total,
              Item_Contact_Info_V :INV_Contact_Info
            })
          })
					const response = await res.json();
          Inv_ID = response.Invoice_Number;
				} 
        catch(err) 
        {
          Inv_ID = "N/A";
          Error_1 = true;
          //insert into error log to handle errors
        }

        
        Insert_Invoice_Items(Inv_ID,Master_INV_Table);

        //output successful
        if(Error_1 == true || Error_2 == true || Error_3 == true)
        {
          alert("ERROR : An error has occured. Please retry saving data or contact support.");
        }
        else
        {
          alert("Successfully saved invoice. Invoice #: "+Inv_ID);
        }
        
			}
    </script>





    
    <!--  -->
  </head>

  <body>

    <!--Menu Bar-->
    <div class="topnav">
      <a onclick="Save_Invoice('Master_INV_Table')">+ Save</a>
      <!--<a href="Invoices.html" target="_blank">Preview</a>-->
      <!--<a href="Invoices.html" target="_blank">Preview</a>-->
    </div>

    <!--Invoice head-->
    <div class="row">
      <div class="column_Head txtleft">
        <h2 class="Header1" id="Head_Company_Name"> <?php echo $Company_Name ?></h2>
        <p id="Head_Company_Add1"><?php echo $Address1 ?></p>
        <p id="Head_Company_Add2"><?php echo $Address2 .','. $Address3 ?></p>
        <p id="Head_Company_Phone"><?php echo $Phone ?></p>
        <p id="Head_Company_Fax">Fax: <?php echo $Fax ?></p>
        <p id="Head_Company_Website"><?php echo $Website ?></p>
      </div>

      <div class="column_Head txtright">
        <h2 class="Header2">INVOICE</h2>
        <table align="right">
          <tr>
            <td> DATE </td>
            <td class="head" id="Head_Date"><script> document.write(new Date().toLocaleDateString()); </script></td>
          </tr>
          <tr>
            <td> INVOICE # </td>
            <td class="head"> Pending</td>
          </tr>
          <tr>
            <td> CUSTOMER ID </td>
            <td class="head"><input type="text" class="input_foot" id="Customer_ID_Input" name="Customer_ID_Input" value="" onchange="Bill_Client_Details()" onkeyup="Bill_Client_Details()" required></td>
            <td> <button type="button" class="button" >+</button> </td>
             
            <!--
              
            -->
          </tr>
          <tr>
            <td> DUE DATE </td>
            <td class="head"> <input type="date" id="Due_Date" name="Due_Date" required> </td>
          </tr>
        </table>
      </div>
    </div>



    <!--Invoice bill too-->
    <div class="row">
      <div class="column_bill txtleft">
        <table align="left" width="50%">
          <tr>
            <th class="bill">BILL TO        (Select a customer ID)</th>
          </tr>
          <tr>
            <td class="bill" id="Customer_Bill_Name"></td>
          </tr>
          <tr>
            <td class="bill" id="Customer_Bill_Company"></td>
          </tr>
          <tr>
            <td class="bill" id="Customer_Bill_Street"></td>
          </tr>
          <tr>
            <td class="bill" id="Customer_Bill_City"></td>
          </tr>
          <tr>
            <td class="bill" id="Customer_Bill_Phone"></td>
          </tr>
        </table>
      </div>
    </div>


<!-- Main Item area-->
    <div class="row">
      <div class="column_inv txtleft">
        <table align="left" width="100%" id="Master_INV_Table">
          
        <tr>
            <th class="inv">DESCRIPTION</th>
            <th class="inv">TAXED</th>
            <th class="inv">AMOUNT</th>
            <th class="inv"></th>
            <th class="inv"></th>
          </tr>
          
          <tr class="inv">
            <td class="inv"> <input type="text" name = "description" id = "Item_Description_New"></td>
            <td class="inv"> 
              <select id = "Item_Tax_New"> 
              <option value="1" selected>X</option>
              <option value="2"></option>
              </select> </td>
            <td class="inv"><input type="number" name = "amount" value="0.00" id = "Item_Amt_New"></td>
            <td><button class="button" onclick="addField('Master_INV_Table',this)">+ Add item</button></td>
            <td></td>
          </tr>
          <!--
          <tr class="inv">
            <td class="inv">2</td>
            <td class="inv">Test item gjuccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccccchhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhh</td>
            <td class="inv">X</td>
            <td class="inv">100.00</td>
            <td><a style="text-decoration: none;color:#35497F;"><u>Update</u></a></td>
            <td><a style="text-decoration: none;color:#35497F;"onclick="SomeDeleteRowFunction(this)"><u>Delete</u></a></td>
            <td><a style="text-decoration: none;color:#35497F;"><u>Edit</u></a></td>
            <td><a style="text-decoration: none;color:#35497F;"onclick="SomeDeleteRowFunction(this)"><u>Delete</u></a></td>
          </tr>
        -->
        </table>
      </div>
    </div>






<!-- Invoice Foot-->
<div class="row">
      <div class="column_Head txtleft">
        <table align="right" width="100%">
          <tr>
            <th class="bill">OTHER COMMENTS</th>
          </tr>
          <tr>
            <td class="head"> <textarea rows = "8" cols="120" style="max-width:100%;" id="Other_Notes_Comments">1. Total payment due 30 days
              2. Please include the invoice number on your check</textarea> </td>
          </tr> 
        </table>
      </div>
      




      <div class="column_Head txtright">
        <table align="right" id="Total_Table">
        <tr>
            <td> Sub total </td>
            <td id="Sub_Total"> 0.00</td>
          </tr>
          <tr>
            <td> Taxable </td>
            <td id="Taxable_Total"> 0.00</td>
          </tr>
          <tr>
            <td> Tax rate</td>
            <td class="head"><input type="text" class="input_foot" id="Tax_Rate_Input" name="Tax_Rate_Input" value="15.0" onchange="Calculate_M('Master_INV_Table')" onkeyup="Calculate_M('Master_INV_Table')" required></td>
          </tr>
          <tr>
            <td> Tax due </td>
            <td id = "Taxable_Out"> 0.00</td>
          </tr>
          <tr>
            <td> OTHER </td>
            <td class="head"><input type="text" class="input_foot" id="Other_Charge" name="Other_Charge" value="0.00" onchange="Calculate_M('Master_INV_Table')" onkeyup="Calculate_M('Master_INV_Table')"></td>
          </tr>
          <tr>
            <td><h3> TOTAL </h3></td>
            <td class="footT" id="Final_Total"> 0.00 </td>
          </tr>


          <tr>
            <td></td>
            <td>Mark all checks payable to</td>
          </tr>
          <tr>
            <td></td>
            <td><?php echo $Company_Name?></td>
          </tr>


        </table>
      </div>
    </div>
    
    
    
    <div class="row">
      <div class="column_bill txtleft">
        <table align="center" width="100%">
          <tr>
            <td class="foot">If you have any questions about this invoice, please contact</td>
          </tr>
          <tr>
            <td class="foot" id = "Contact_Information"><?php echo $Contact_Name .','.$Phone.','.$Email?></td>
          </tr>
          <tr>
            <td class="foot"> <h2>Thank You For Your Business!</h2></td>
          </tr>
        </table>
      </div>
    </div>

<!-- POP UPS -->





  </body>
</html>

