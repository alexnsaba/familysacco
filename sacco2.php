<?php
include_once("sacco1.php");
$con=mysqli_connect("localhost","root","");
//creating the database famillysacco
mysqli_query($con,"CREATE DATABASE famillysacco");
mysqli_select_db($con,"famillysacco");
mysqli_query($con,"CREATE TABLE usual_member(memberId int(20) primary key not null auto_increment,
firstName varchar(30),lastName varchar(30),username varchar(30),password varchar(10))");

mysqli_query($con,"CREATE TABLE administrator(memberId int(20) primary key not null auto_increment,
firstName varchar(30),lastName varchar(30),username varchar(30),password varchar(10),adminNumber int(20))");

mysqli_query($con,"CREATE TABLE contribution(contributionId int(20) primary key not null auto_increment,
contributionAmount int(20),dateOfContribution varchar(10),receiptNumber int(20),memberId int(20))");

mysqli_query($con,"CREATE TABLE ideaFollowUp(followUpId int(20) primary key not null auto_increment,
profit int(20),loss int(20),dateOfPost varchar(10),memberId int(20),investmentNumber int(20))");

mysqli_query($con,"CREATE TABLE investment_suggestion(memberId int(20) primary key not null,
investmentNumber int(20),dateOfSuggestion varchar(10))");

mysqli_query($con,"CREATE TABLE investmentDetails(investmentNumber int(20) primary key not null auto_increment,
businessIdea varchar(30),dateOfPost varchar(10),initialInvestmentPrice int(20),status varchar(10),memberId int(20))");


mysqli_query($con,"CREATE TABLE loan(loanId int(20) primary key not null auto_increment,
loanAmount int(20),interest int(20),repayTime int(20),date varchar(10),totalToBePaid int(20),memberId int(20))");

mysqli_query($con,"CREATE TABLE loanRepayment(repaymentId int(20) primary key not null auto_increment,
paymentAmount int(20),dateOfPayment varchar(10),balance int(20),loanId int(20))");

mysqli_query($con,"CREATE TABLE share(shareId int(20) primary key not null auto_increment,
share int(20),date varchar(10),memberId int(20))");

$act=$_REQUEST['action'];
 
?>
<table border=0>
    <tr>
        <td>
        <div style="border:5px solid navy;padding:5px 5px;border-radius:15px;height:6.5in;background:gainsboro">

<center style="font-size:45px;color:navy">FAMILY SACCO</center>
<a href="?action=overview"><p style="margin-left:8in">LOGIN</p></a>
<center><p><img src="nsaba.jpg"width="150"height="150"><img src="index2.jpg"width="150"height="150">
<img src="inde.jpg"width="150"height="150"><img src="index3.jpg"width="150"height="150">
<img src="index.jpg"width="150"height="150">
    <img src="index1.jpg"width="150"height="150"></p></center>
<p style="margin-left:5in;font-size:30px">with our Family SACCO you can save and get loans.</p>
<p style="margin-left:5in;font-size:30px">let us save together and we develove together<p>
<center><footer style="color:purple;background:deepskyblue; margin-top:1.5in;font-size:20px">
&copy family sacco 2017</footer></center>
</div>
    </td>
       <td>
            <?php
            
            if($act=="overview")
            {
                overview();
            }
            else 
                
                if($act=="admin"){
                    // checking if the name of submit button is login
                    
if(isset($_POST['login']))
{
   //checking if username and password fields are not empty
    if(!empty($_POST['username'])&&($_POST['password']))
    {
        $username=$_POST['username'];
        $password=$_POST['password'];
        $sel="select * from administrator where username='$username' AND password='$password' ";
        $a=mysqli_query($con,$sel);
        $row=mysqli_num_rows($a);
        if($row==1)
        {
            $_SESSION['login_user']=$username;
             login();
            }
        else
        {
            echo"<p style=color:red>Either username or password is incorrect</p>";
            overview();
            
        }
    }
    else
    {
         echo"<p style=color:red>please fill the blanks</p>";
        overview();
    }
}
                   
                }
           
           else 
                if($act=="member"){
                    add_member();
                }
            else 
                if($act=="loan"){
                    loans();
                }
           else 
                if($act=="getfile")
                {
                $file=fopen("nsaba.txt","r");
                $files=file('nsaba.txt');
                    foreach($files as $key=>$file)
                    {
                        echo"<p>".$file,checking()."</p>";
						 if(isset($_POST['accept']))
				  {
				  list($command,$a,$b,$c,$d)=explode(" ",$file,5);
					  if($command=="contribution"){
				   $que=mysqli_query($con,"INSERT INTO contribution(contributionAmount,dateOfContribution,receiptNumber,memberId)VALUES('$a','$b','$c','$d')");
				  if($que)
				  {
				   echo"<p style='color:blue'>data has been saved successfully</p>";
                //calculating the shareAmount of each member after contribution
           
                 $b=mysqli_query($con,"SELECT *,SUM(contributionAmount) as total FROM contribution");
           if(mysqli_num_rows($b)>0)
           {
              while($row=mysqli_fetch_array($b))
              {
              $totalContr=$row['total'];
              $date=$row['dateOfContribution'];
              $memberid=$row['memberId'];   
              $contr=$row['contributionAmount'];
              $share=(($contr/$totalContr)*100);
              mysqli_query($con,"INSERT INTO share(share,date,memberId)VALUES('$share'
               ,'$date','$memberid')");
			   
			   }
           }
				  }
				  else{
				   echo"<p 'color:red'>failed to insert data</p>";
				  }
                      deleting("nsaba.txt",$file); //deleting a line after inserting it
				  }
				  //adding accepted loan requests into loan table
				        if($command=="loan_request"){
                      //selecting the sum of total contribution 
                       $quer=mysqli_query($con,"SELECT SUM(contributionAmount) as total FROM contribution");
				       $row=mysqli_fetch_array($quer);
                      $total=$row['total'];
                      //checking if the loan request amount is not greater than 1/2 of the total contribution
                      if($a<=(0.5*$total)){
                      $interest =($a*(3/100)); //calculating the intrest of the loan
				  $totalToBePaid = $a + $interest;  //calculating the total amount to be paid per loan
				$que=mysqli_query($con,"INSERT INTO loan(loanAmount,interest,repayTime,date,totalToBePaid,memberId)VALUES('$a','$interest',6,'$b','$totalToBePaid','$c')");
				  if($que)
				  {
				 echo"<p style='color:blue'>data has been saved successfully</p>";
				  }
                      }
				  else{
				   echo"<p 'color:red'>failed to insert data</p>";
				  }
                           deleting("nsaba.txt",$file); //deleting a line after inserting it
				  }
				  // adding accepted investment ideas into investmentDetails table
				                if($command=="idea"){
                       $quer=mysqli_query($con,"SELECT SUM(contributionAmount) as total FROM contribution");
				       $row=mysqli_fetch_array($quer);
                      $total=$row['total'];
                      // checking if the inestment idea requires less than 1/2 of the available money 
                      if($c<(0.5*$total))
                      {
				  $que=mysqli_query($con,"INSERT INTO investmentDetails(businessIdea,dateOfPost,initialInvestmentPrice,status,memberId)VALUES('$a','$b','$c','APPROOVED','$d')");
                if($que)
				  {
				 echo"<p style='color:blue'>data has been saved successfully</p>";
				  }
                      }
				  else{
				   echo"<p 'color:red'>failed to insert data</p>";
				  }
                          deleting("nsaba.txt",$file); //deleting a line after inserting it
				  }
        //adding loan repayment data from the file into loanRepayment relation
                   
                      if($command=="loan_repayment")
                      {           
				      //selecting totalAmounToBePaid from the loan table to determine the balance
             $querry=mysqli_query($con,"SELECT * FROM loan WHERE loanId='$c' ");
                          $row=mysqli_fetch_array($querry);
                          $totalToBePaid=$row['totalToBePaid'];
                          $balance = $totalToBePaid-$a;
                         $qr= mysqli_query($con,"INSERT INTO loanrepayment(paymentAmount,dateOfPayment,
                          balance,loanId)
                          VALUES($a,'$b','$balance','$c')");
                       if($qr)
				  {
				 echo"<p style='color:blue'>data has been saved successfully</p>";
				  }
                      
				  else{
				   echo"<p 'color:red'>failed to insert data</p>";
				  }
                          deleting("nsaba.txt",$file); //deleting a line after inserting it
                      }
                             
            //processing the destribution of profits to members
		   $q=mysqli_query($con,"SELECT *,SUM(profit) as totalprofit FROM ideaFollowUp");
		   while($rows=mysqli_fetch_array($q))
		   {
			$profit=$rows['totalprofit'];
			if($totalprofit>0)
			{
		   
          // checking the number of members that are to share the 65%profits
          $m=mysqli_query($con,"SELECT * FROM usual_members");
          $num=mysqli_num_rows($m);
          //deviding by the number of rows(number of members) found in usual_member table
          $profit_share=(($profit*(65/100))/$num);
		   
		   //selecting the contribution table to get members contriution
           $n=mysqli_query($con,"SELECT * FROM contribution");
           $row=mysqli_fetch_array($n);
           $contri=$row['contributionAmount'];
           $newContribution=$contri + $profit_share;
		    mysqli_query($con,"UPDATE contribution SET contributionAmount='$newContribution'WHERE contributionAmount='$contri'");
			
                // selecting a member with the highest number of share
                $s=mysqli_query($con,"SELECT memberId,MAX(share) as maximum FROM share");
                $row=mysqli_fetch_array($s);
                $maximum=$row['maximum'];
                $mem=$row['memberId'];
                $highShare=($profit*(5/100));
               
                //reselecting contribution table to reupdate the amount of a member with high share
                $st =mysqli_query($con,"SELECT * FROM contribution WHERE memberId='$mem' ");
                $rw=mysqli_fetch_array($st);
                $maxshare=$rw['contributionAmount'];
                $maxContribution=$maxshare+$highShare;
              
                // updating the contribution amount of the member with max shares
              mysqli_query($con,"UPDATE contribution SET contributionAmount='$maxContribution'WHERE memberId='$mem'");  
            }
			}
                }
				// deleting the line of a textfile that is not accepted
                if(isset($_POST['delete']))
				{
				deleting("nsaba.txt",$file); 
				} 
         
       }
                }
              else 
                if($act=="reports"){
                    reporting();
                }

          
           if(isset($_POST['member']))
{
    //checking if firstname,lastname,username and password fields are not empty
    if(!empty($_POST['firstName'])&&($_POST['lastName'])&&($_POST['username'])&&($_POST['password']))
    {
        $firstName=$_POST['firstName'];
        $lastName=$_POST['lastName'];
        $username=$_POST['username'];
        $password=$_POST['password'];
        $ins="INSERT INTO usual_member(firstName,lastName,username,password)
        VALUES('$firstName', '$lastName', '$username','$password')";
        $b=mysqli_query($con,$ins);
        if($b)
        {
            //redirecting a user to inserting member page
           
            echo"data has been saved successfully";
        }
        else
        {
             
            echo"failed to insert data";
        }
    }
    else
    {
        
        echo"please fill all the fields before submitting";
    }
}
           if(isset($_POST['report']))
           {
               $field=$_POST['field'];
$attribute=$_POST['attribute'];
$operator=$_POST['operator'];
$condition=$_POST['condition'];
 //creating report about administrator table
if($_POST["relation"]=="administrator")
   {
$a=mysqli_query($con,"SELECT $field  FROM administrator WHERE $attribute $operator $condition");
if(mysqli_num_rows($a)>0)
{
    echo"<table border=1 style= 'background-color:gainsboro'>";
    echo"<tr style= 'background-color:green'>";
    echo"<td>MEMBER ID</td>";
    echo"<td>FIRST NAME</td>";
    echo"<td>LAST NAME</td>";
    echo"<td>username</td>";
    echo"<td>password</td>";
    echo"<td>ADMIN NUMBER</td>";
    echo"</tr>";
    while($row=mysqli_fetch_array($a))
    {
        echo"<tr>";
        echo"<td>".$row['memberId']."</td>";
        echo"<td>".$row['firstName']."</td>";
        echo"<td>".$row['lastName']."</td>";
        echo"<td>".$row['username']."</td>";
        echo"<td>".$row['password']."</td>";
        echo"<td>".$row['adminNumber']."</td>";
        echo"</tr>";
    }
    echo"</table>";
}
}
    //creating report about contribution table
if($_POST["relation"]=="contribution")
{
$a=mysqli_query($con,"SELECT $field  FROM contribution WHERE $attribute $operator $condition");
if(mysqli_num_rows($a)>0)
{
    echo"<table border=1 style= 'background-color:gainsboro'>";
    echo"<tr style= 'background-color:green'>";
    echo"<td>CONTRIBUTION ID</td>";
    echo"<td>CONTRIBUTION AMOUNT</td>";
    echo"<td>DATE OF CONTRIBUTION</td>";
    echo"<td>RECEIPT NUMBER</td>";
    echo"<td>MEMBER ID</td>";
    echo"</tr>";
    while($row=mysqli_fetch_array($a))
    {
        echo"<tr>";
        echo"<td>".$row['contributionId']."</td>";
        echo"<td>".$row['contributionAmount']."</td>";
        echo"<td>".$row['dateOfContribution']."</td>";
        echo"<td>".$row['receiptNumber']."</td>";
        echo"<td>".$row['memberId']."</td>";
        echo"</tr>";
    }
    echo"</table>";
}
}
    //creating report about ideaFollowUp table
if($_POST["relation"]=="ideaFollowUp")
{
$a=mysqli_query($con,"SELECT $field  FROM ideaFollowUp WHERE $attribute $operator $condition");
if(mysqli_num_rows($a)>0)
{
    echo"<table border=1 style= 'background-color:gainsboro'>";
    echo"<tr style= 'background-color:green'>";
    echo"<td>FOLLOWUP ID</td>";
    echo"<td>PROFIT</td>";
    echo"<td>LOSS</td>";
    echo"<td>DATE OF POST</td>";
    echo"<td>MEMBER ID</td>";
    echo"<td>INVESTMENT NUMBER</td>";
    echo"</tr>";
    while($row=mysqli_fetch_array($a))
    {
        echo"<tr>";
        echo"<td>".$row['followUpId']."</td>";
        echo"<td>".$row['profit']."</td>";
        echo"<td>".$row['loss']."</td>";
        echo"<td>".$row['dateOfPost']."</td>";
        echo"<td>".$row['memberId']."</td>";
         echo"<td>".$row['investmentNumber']."</td>";
        echo"</tr>";
    }
    echo"</table>";
}
}
    //creating report about investment_suggestion table
if($_POST["relation"]=="investment_suggestion")
{
$a=mysqli_query($con,"SELECT $field  FROM investment_suggestion WHERE $attribute $operator $condition");
if(mysqli_num_rows($a)>0)
{
    echo"<table border=1 style= 'background-color:gainsboro'>";
    echo"<tr style= 'background-color:green'>";
    echo"<td>MEMBER ID</td>";
    echo"<td>INVESTMENT NUMBER</td>";
    echo"<td>DATE OF SUGGESTION</td>";
    echo"</tr>";
    while($row=mysqli_fetch_array($a))
    {
        echo"<tr>";
        echo"<td>".$row['memberId']."</td>";
        echo"<td>".$row['investmentNumber']."</td>";
        echo"<td>".$row['dateOfSuggestion']."</td>";
        echo"</tr>";
    }
    echo"</table>";
}
}
    //creating report about investmentDetails table
if($_POST["relation"]=="investmentDetails")
{
$a=mysqli_query($con,"SELECT $field  FROM investmentDetails WHERE $attribute $operator $condition");
if(mysqli_num_rows($a)>0)
{
    echo"<table border=1 style= 'background-color:gainsboro'>";
    echo"<tr style= 'background-color:green'>";
    echo"<td>INVESTMENT NUMBER</td>";
    echo"<td>BUSINESS IDEA</td>";
    echo"<td>DATE OF POST</td>";
    echo"<td>INITIAL INVESTMENT PRICE</td>";
    echo"<td>STATUS</td>";
    echo"<td>MEMBER ID</td>";
    echo"</tr>";
    while($row=mysqli_fetch_array($a))
    {
        echo"<tr>";
        echo"<td>".$row['investmentNumber']."</td>";
        echo"<td>".$row['businessIdea']."</td>";
        echo"<td>".$row['dateOfPost']."</td>";
        echo"<td>".$row['initialInvestmentPrice']."</td>";
        echo"<td>".$row['status']."</td>";
        echo"<td>".$row['memberId']."</td>";
        echo"</tr>";
    }
    echo"</table>";
}
}
    //creating report about loan table
if($_POST["relation"]=="loan")
{
$a=mysqli_query($con,"SELECT $field  FROM loan WHERE $attribute $operator $condition");
if(mysqli_num_rows($a)>0)
{
    echo"<table border=1 style= 'background-color:gainsboro'>";
    echo"<tr style= 'background-color:green'>";
    echo"<td>LOAN ID</td>";
    echo"<td>LOAN AMOUNT</td>";
    echo"<td>INTEREST</td>";
    echo"<td>REPAY TIME</td>";
    echo"<td>DATE</td>";
    echo"<td>TOTAL TO BE PAID</td>";
    echo"<td>MEMBER ID</td>";
    echo"</tr>";
    while($row=mysqli_fetch_array($a))
    {
        echo"<tr>";
        echo"<td>".$row['loanId']."</td>";
        echo"<td>".$row['loanAmount']."</td>";
        echo"<td>".$row['interest']."</td>";
        echo"<td>".$row['repayTime']."</td>";
        echo"<td>".$row['date']."</td>";
          echo"<td>".$row['totalToBePaid']."</td>";
      echo"<td>".$row['memberId']."</td>";
        echo"</tr>";
    }
    echo"</table>";
}
}
    //creating report about loanRepayment table
if($_POST["relation"]=="loanRepayment")
{
$a=mysqli_query($con,"SELECT $field  FROM loanRepayment WHERE $attribute $operator $condition");
if(mysqli_num_rows($a)>0)
{
    echo"<table border=1 style= 'background-color:gainsboro'>";
    echo"<tr style= 'background-color:green'>";
    echo"<td>REPAYMENT ID</td>";
    echo"<td>PAYMENT AMOUNT</td>";
    echo"<td>DATE OF PAYMENT</td>";
    echo"<td>BALANCE</td>";
    echo"<td>LOAN ID</td>";
    echo"</tr>";
    while($row=mysqli_fetch_array($a))
    {
        echo"<tr>";
        echo"<td>".$row['repaymentId']."</td>";
        echo"<td>".$row['paymentAmount']."</td>";
        echo"<td>".$row['dateOfPayment']."</td>";
        echo"<td>".$row['balance']."</td>";
        echo"<td>".$row['loanId']."</td>";
        echo"</tr>";
    }
    echo"</table>";
}
}
   //creating report about share table
if($_POST["relation"]=="share")
{
$a=mysqli_query($con,"SELECT $field  FROM share WHERE $attribute $operator $condition");
if(mysqli_num_rows($a)>0)
{
    echo"<table border=1 style= 'background-color:gainsboro'>";
    echo"<tr style= 'background-color:green'>";
    echo"<td>SHARE ID</td>";
    echo"<td>SHARE</td>";
    echo"<td>DATE</td>";
    echo"<td>MEMBER ID</td>";
    echo"</tr>";
    while($row=mysqli_fetch_array($a))
    {
        echo"<tr>";
        echo"<td>".$row['shareId']."</td>";
        echo"<td>".$row['share']."</td>";
        echo"<td>".$row['date']."</td>";
        echo"<td>".$row['memberId']."</td>";
        echo"</tr>";
    }
    echo"</table>";
}
}
   //creating report about usual_member table
if($_POST["relation"]=="usual_member")
   {
$a=mysqli_query($con,"SELECT $field  FROM usual_member WHERE $attribute $operator $condition");
if(mysqli_num_rows($a)>0)
{
    echo"<table border=1 style= 'background-color:gainsboro'>";
    echo"<tr style= 'background-color:green'>";
    echo"<td>MEMBER ID</td>";
    echo"<td>FIRST NAME</td>";
    echo"<td>LAST NAME</td>";
    echo"<td>username</td>";
    echo"<td>password</td>";
    echo"</tr>";
    while($row=mysqli_fetch_array($a))
    {
        echo"<tr>";
        echo"<td>".$row['memberId']."</td>";
        echo"<td>".$row['firstName']."</td>";
        echo"<td>".$row['lastName']."</td>";
        echo"<td>".$row['username']."</td>";
        echo"<td>".$row['password']."</td>";
        echo"</tr>";
    }
    echo"</table>";
}
}
           }
         
           ?>
        </td>
    </tr>
</table>
<?php
?>
