<?php
//this page contain functions
function overview(){
?>
    <div style="border:5px solid green;padding:5px 5px;border-radius:15px;background:gainsboro">
<center>
    <form method="post"action="sacco2.php?action=admin">
<p>login As <select><option>Adminstrator</option><option>Usual member</option></select></p>
<p><table>
<tr>
<td>username<br/>password</td>
<td><input type="text"placeholder="enter your username"name="username"><br/>
<input type="password" placeholder="enter your password"name="password"></td>
</tr>
</table>
</p>
<center><input type="submit"value="Login"name="login"></center>
     </form>
</center>
</div>
<?php
}
function login(){
    ?>
    <form action="sacco2.php?action=member?action=loan?action=getfile?action=reports" method="post">
<div style="border:5px solid purple;padding:5px 5px;background:gainsboro">
    <p><a href="?action=member"><input style="background-color:green;font-size:28px"type="button" value="ADD MEMBERS"></a>
        <a href="?action=getfile"><input style="background-color:green;font-size:28px"type="button" value="SUBMISSIONS OF MEMBERS"></a>
     <a href="?action=reports"><input style="background-color:green;font-size:28px"type="button"value="REPORTS"</a><p>
</div>
        </form>
<?php
}
function reporting(){
    ?>
    <form action="sacco2.php"method="post">
<h1><center>REPORT BUILDER</center></h1>
<div style="border:5px solid purple;padding:5px 5px;background:gainsboro">
<p style="font-size:20px">SELECT<input style="font-size:20px"type="text"name="field">FROM
<select style="font-size:15px"name="relation"><option>administrator</option><option>contribution</option>
    <option>usual_member</option><option>investment_suggestion</option>
<option>investmentDetails</option><option>loan</option><option>share</option><option>loanRepayment</option>
<option>ideaFollowUp</option></select>WHERE<input style="font-size:15px"type="text"name="attribute">
<select style="font-size:20px"name="operator"><option>=</option><option><</option><option>></option>
<option>>=</option><option><=</option></select><input style="font-size:15px"type="text"name="condition"></p>
<center><input style="font-size:20px;background-color:blue"type="submit" name="report"value="submit"></center>
</div>
    </form>
<?php
}
function add_member(){
    ?>
    <div style="background-color: gainsboro; padding-left: 20px; padding: 8px; margin: 60px; padding-bottom: 10px; border-radius: 10px; width: 700px; height: 435px;text-align: border="1" ">
<form  id="form1"  method="post" action="sacco2.php">

    <p align="left" style="color:gainsboro;"><strong style="color:black;">Family Sacco System  </strong>.........................................................................................................................<leble><input type="button" value="-"></leble><leble><input type="button" value="x"></leble></p><div class="mo">
    
    
    <table border="0" width="500" class="fob"  onmousemove="display();" id="samir">
            <tbody>
                <tr>
                    <td></td>
                    <td style="color:red">Add member</td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td align="left">Member ID</td>
                    <td><leble><input type="textfield"  name="text"></leble></td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td align="left">FirstName</td>
                    <td><leble><input type="textfield"  name="firstName"></leble></td>
                </tr>
				
				 <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>LastName</td>
                    <td><leble><input type="textfield"  name="lastName"></leble></td>
                </tr>
				 <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td align="left">User Name</td>
                    <td><leble><input type="textfield" placeholder="Enter username" name="username" ></leble></td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td align="left">Password</td>
                    <td><leble><input type="textfield" placeholder="Enter password" name="password" ></leble></td>
                </tr>
               
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td align="left">Member category</td>
                    <td></td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td align="right"><leble><input type="radio" name="radio"></leble></td>
                    <td>Regular</td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td align="right"><leble><input type="radio" name="radio"></leble></td>
					<td>Non regular</td>
                </tr>
                
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                
                </tbody>
            </table>
    
          <p align="right" style="color:white"><label><input type="submit" name="member" id="submit1" value="submit"></label>
          <label><input type="reset" name="reset" value="reset"></label>
          <label><input type="button" name="cancel" value="cancal"></label>.<br/>.</p>
    
    </div>
    </form>
    </div>
<?php
}
//function that reads a text file
function checking(){
    ?>
	
        <form method="post">
		<table>
           <tr>
                    <td><input style="background-color:green" type="submit"name="accept"value="ACCEPT"></td>
                     <td><input style="background-color:red" type="submit"name="delete"value="DELETE"></td>
               </tr>
			   </table>
         <?php
}
// the function that cuts the data on a file after inserting it in the database
function deleting($file_name,$line_i){
    $strip_return=FALSE;
    $filedata=file($file_name);
    $f=fopen($file_name,"w");
    $count=count($filedata);
    foreach( $filedata as $line_i){
        if($line_i){
         $skip=$count-1;
        }
        else
        {
         $skip= $line_i-1; 
        }
        for($i=0;$i<$count;$i++)
            if($i!=$skip)
                fputs($f,$filedata[$i]);
        else
           $strip_return=TRUE; 
        return $strip_return;
    }
    ?>
            
     <?php
}
function loans(){
    ?>
 <form action="sacco2.php" method="post">
        <table border="0" style="border-width:thick; border-color:lightblue;" align="center">  <thead></thead><tbody>     <tr><td style="background-color:cyan;" align="left"><strong>FAMILY SACCO SYSTEM<br/>Administrator</strong><br/><input type="button" value="Home"></td><td align="center"></td><td align="right">22 May 2017 Monday</td></tr><tr style="background-color:lightblue;"><td> <table border="0" style="border-color:blue; border-width:thin; margin-left:10px;margin-right:10px; margin-color:lightblue;"><thead></thead>
        <tbody style="background-color:lightgrey;">
        
            
            <tr><th colspan="2">Current Loan requests(1 of 4)</th><th colspan="2">Accepted Loans</th><th colspan="2">Loan repayment details</th></tr>
            <tr><td>Member ID</td><td><input type="text" placeholder="124"></td><td>Member ID</td><td><input type="text" placeholder="111"></td>
                
                <td>Member ID</td><td><input type="text" placeholder="U1224"></td></tr>
            <tr><td>Person Name</td><td><input type="text" value="Samir Habib"></td><td>Person Name</td><td><input type="text" placeholder="+25670 4668 050"></td><td>Person Name</td><td><select><option selected>Kusasira Mamuke</option></select></td></tr>
            <tr><td>Loan Request amount</td><td><input type="text" value="shs 500,000"></td><td>Amount Loaned</td><td><select><option selected>150,000</option></select></td><td></td><td></td></tr>
            <tr><td>Status</td><td><select><option selected>Regular</option></select></td><td></td><td></td><td>Amount Loaned</td><td><input type="text" value="100,000"/></td></tr>
            <tr><td></td><td></td><td></td><td></td><td>Amount to be payed back</td><td><input type="text" value="103,000"/></td></tr>
            <tr><td></td><td></td><td></td><td></td><td>Required monthly pay</td><td><input type="text" value="8,600"/></td></tr>
            <tr><td colspan="2" align="center"><input type="button" value="Accept"/><input type="reset" value="Deny"/><input type="button" value="Next"/></td>
                
                <td colspan="2"> <table><thead></thead><tbody></tbody><tr><td colspan="3"><input type="button" value="Previous"/><input type="button" value="Next"/><input type="button" value="LIST"/></td></tr></table></td>
                
                
                <td rowspan="4" colspan="2"><table border="0" border-width="thin"><thead></thead><tbody><tr><th>Manage Remainders</th></tr><tr><td colspan="4" ><label>Repeats</label><select  name="repeat">
            <option selected>Monthly</option></select><br><br>
                <tr><td><label>Starts On<input type="button" name="date" value="6/6/2017"></label><br><br><label>Ends <input name="end" type="radio" value="never">Never</label><br><label>Ends <input name="end" type="radio" value="never">After<select><option selected>Payment</option></select></label></td><td><label>Notifications <input name="note" type="checkbox" value="sms">SMS<br><label><input name="note" type="checkbox" value="mail">Email</label><br><label><input name="note" type="checkbox" value="alerts">Alerts</label></label><br><input type="button" value="Save" style="margin-color:skyblue;"><input type="button" name="Close" value="Close"></td></tr><br>
                </td></tr></tbody></table></td></tr>
            <tr><td></td><td></td><td></td><td></td><td></td></tr>
            <tr><td></td><td></td><td></td><td></td><td></td></tr>
            <tr><td></td><td></td><td></td><td></td><td></td></tr>
            
            
            
            <tr><th colspan="6">Regular Members</th></tr>
            <tr><th colspan="1">Member ID</th><th colspan="2">Member Name</th><th colspan="1">Duration</th><th colspan="2">Loan Request Status</th></tr>
            <tr><td colspan="2">124</td><td>Samir Habib</td><td><input type="text" value="8 months"/></td><td>Pending</td><td>shs 500,000</td></tr>
            <tr><td colspan="2">34</td><td>Chepkurui Jacob</td><td><input type="text" value="6 months"/></td><td>Pending</td><td>shs 400,000</td></tr>
            <tr><td colspan="2">3</td><td>Alex Niyonsaba</td><td><input type="text" value="12 months"/></td><td>Not Requested</td><td>00</td></tr>
            <tr><td></td><td></td><td></td><td></td><td></td><td></td></tr>
            <tr><td></td><td></td><td></td><td></td><td></td><td></td></tr>
            <tr>
            </tbody>
        </table></td></tr></tbody></table>
            <p><input type="submit"name="submit"></p>
        </form>
    
<?php
}


