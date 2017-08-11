 #include <stdio.h>
#include <winsock2.h>
int sacco(char x[200]);


int main()

{
  // Initialize Winsock
  WSADATA wsaData;

  int iResult = WSAStartup(MAKEWORD(2,2), &wsaData);

  if (iResult != NO_ERROR)

    printf("Client: Error at WSAStartup().\n");

  else

    printf("Client: WSAStartup() is OK.\n");
  // Create a SOCKET for connecting to server
  SOCKET ConnectSocket;
  ConnectSocket = socket(AF_INET, SOCK_STREAM, IPPROTO_TCP);
  if (ConnectSocket == INVALID_SOCKET)
  {
    printf("Client: Error at socket(): %ld.\n", WSAGetLastError());
    WSACleanup();
    return 0;
  }
  else
    printf("Client: socket() is OK.\n");
  // The sockaddr_in structure specifies the address family,
  // IP address, and port of the server to be connected to.
 struct sockaddr_in clientService;
  clientService.sin_family = AF_INET;
  clientService.sin_addr.s_addr = inet_addr("127.0.0.1");
  clientService.sin_port = htons(55555);
  // Connect to server.
  if (connect(ConnectSocket, (SOCKADDR*)&clientService, sizeof(clientService)) == SOCKET_ERROR)
  {
    printf("Client: Failed to connect.\n");
    WSACleanup();
    return 0;
  }
  else
    printf("Client: connect() is OK.\n");
  // Declare and initialize variables.
 
  int bytesSent;
  int bytesRecv ;
  
char x[20]; 
char username[30];
char pasword[30];
char first[30];
char set;
printf("You are required to enter any of the following commands\n" );
printf("contribution amount date receipt_number memberId\n" );
printf("contribution check \n" );
printf("benefits check\n" );
printf("loan_request amount date memberId \n" );
printf("loan status\n" );
printf("loan_repayment paymentAmount date loanId\n");
printf("idea ideaname date capital and memberId\n" );

  printf("Enter your commands \n");
while(1)
  {
	  char firstslot[13];
      char secondslot[60];
      char date[20];
      char person_name[20];
      long long int Receipt_number;
      long long int loan_amount;
      char idea_name[50];
      long long int idea_capital;
      char idea_description[100];

	char check[15];
	//char message[200];
	char sendbuf[200];
	char benefitsCheck[200];
	char loanrequest[200];
	char loanstatus[200];
	char benefits[200];
	char command[200];
	int v=sacco(command);
	printf("Dear member enter your command:\n");
	 gets(command);
	 
	 //contribution check
	if((strcmp(command,"contribution check")==0)){
	strcpy(sendbuf,command);
	bytesSent = send(ConnectSocket, sendbuf, strlen(sendbuf), 0);
	if (bytesSent == 0 || bytesSent == WSAECONNRESET)
    {
      printf("Client: Connection Closed.\n");
      break;
    }
   else
    {
       printf("Client: send() is OK.\n");
	   printf("Client: client sent:%s\n",sendbuf);
	   
    }
	char recvbuf[200] = "";
    bytesRecv = recv(ConnectSocket, recvbuf, 200, 0);
    if (bytesRecv == 0 || bytesRecv == WSAECONNRESET)
    {
      printf("Client: Connection Closed.\n");
    }
    else
    {
       printf("Client: recv() is OK.\n");
	   printf("Client: server said: %s\n",recvbuf);	   
       printf("Client: Bytes received: %ld\n", bytesRecv);
    }
	
        }
		
		
		//contribution amount
		else if((strncmp(command,"contribution",12)==0)&&(v>4)){
        strcpy(sendbuf,command);
	bytesSent = send(ConnectSocket,sendbuf, strlen(sendbuf), 0);
	if (bytesSent == 0 || bytesSent == WSAECONNRESET)
    {
      printf("Client: Connection Closed.\n");
      break;
    }
   else
    {
       printf("Client: send() is OK.\n");
	   printf("Client: client sent:%s\n",sendbuf);
    }
	char recvbuf[200] = "";
    bytesRecv = recv(ConnectSocket, recvbuf, 200, 0);
    if (bytesRecv == 0 || bytesRecv == WSAECONNRESET)
    {
      printf("Client: Connection Closed.\n");
      break;
    }
    else
    {
       printf("Client: recv() is OK.\n");
	   printf("Client: server said: %s\n",recvbuf);	   
       printf("Client: Bytes received: %1d\n", bytesRecv);
    }
	
        }
		
		//loan status		
	else if(strcmp(command,"loan status")==0)
        {
		strcpy(sendbuf,command);
	bytesSent = send(ConnectSocket, sendbuf, strlen(sendbuf), 0);
	if (bytesSent == 0 || bytesSent == WSAECONNRESET)
    {
      printf("Client: Connection Closed.\n");
      break;
    }
   else
    {
       printf("Client: send() is OK.\n");
	   
    }
	char recvbuf[200] = "";
    bytesRecv = recv(ConnectSocket, recvbuf, 200, 0);
    if (bytesRecv == 0 || bytesRecv == WSAECONNRESET)
    {
      printf("Client: Connection Closed.\n");
      break;
    }
    else
    {
       printf("Client: recv() is OK.\n");
	   printf("Client: server said: %s\n\n",recvbuf);	   
       printf("Client: Bytes received: %d\n", bytesRecv);
    }
       

        }
		
		//loan request
		else if((strncmp(command,"loan_request",11)==0)&&v>4){
			
            strcpy(sendbuf,command);
	bytesSent = send(ConnectSocket, sendbuf, strlen(sendbuf), 0);
	if (bytesSent == 0 || bytesSent == WSAECONNRESET)
    {
      printf("Client: Connection Closed.\n");
      break;
    }
   else
    {
       printf("Client: send() is OK.\n");
    }
	char recvbuf[200] = "";
    bytesRecv = recv(ConnectSocket, recvbuf, 200, 0);
    if (bytesRecv == 0 || bytesRecv == WSAECONNRESET)
    {
      printf("Client: Connection Closed.\n");
      break;
    }
    else
    {
       printf("Client: recv() is OK.\n");
	   printf("Client: server said: %s.\n",recvbuf);	   
       
    }

        

    }
	
	//idea
    else if((strncmp(command,"idea",4)==0)&& (v>2)){
			strcpy(sendbuf,command);
	bytesSent = send(ConnectSocket, sendbuf, strlen(sendbuf), 0);
	if (bytesSent == 0 || bytesSent == WSAECONNRESET)
    {
      printf("Client: Connection Closed.\n");
      break;
    }
   else
    {
       printf("Client: send() is OK.\n");
    }
	char recvbuf[200] = "";
    bytesRecv = recv(ConnectSocket, recvbuf, 200, 0);
    if (bytesRecv == 0 || bytesRecv == WSAECONNRESET)
    {
      printf("Client: Connection Closed.\n");
      break;
    }
    else
    {
       printf("Client: recv() is OK.\n");
	   printf("Client: server said: %s.\n",recvbuf);	   
       printf("Client: Bytes received: %ld\n", bytesRecv);
    }
        }
//benefits check
		else if((strcmp(command,"benefits check")==0))
        {
			sprintf(sendbuf,command);
	bytesSent = send(ConnectSocket, sendbuf, strlen(sendbuf), 0);
	if (bytesSent == 0 || bytesSent == WSAECONNRESET)
    {
      printf("Client: Connection Closed.\n");
      break;
    }
   else
    {
       printf("Client: send() is OK.\n");
    }
	char recvbuf[200] = "";
    bytesRecv = recv(ConnectSocket, recvbuf, 200, 0);
    if (bytesRecv == 0 || bytesRecv == WSAECONNRESET)
    {
      printf("Client: Connection Closed.\n");
      break;
    }
    else
    {
       printf("Client: recv() is OK.\n");
	   printf("Client: server said: %s.\n",recvbuf);	   
       printf("Client: Bytes received: %ld\n", bytesRecv);
    }
           

        }
        

        //loan repayment details
        else if((strcmp(command,"loan repayment details")==0))
        {
			strcpy(sendbuf,command);
	bytesSent = send(ConnectSocket, sendbuf, strlen(sendbuf), 0);
	if (bytesSent == 0 || bytesSent == WSAECONNRESET)
    {
      printf("Client: Connection Closed.\n");
      break;
    }
   else
    {
       printf("Client: send() is OK.\n");
    }
	char recvbuf[200] = "";
    bytesRecv = recv(ConnectSocket, recvbuf, 200, 0);
    if (bytesRecv == 0 || bytesRecv == WSAECONNRESET)
    {
      printf("Client: Connection Closed.\n");

      break;
    }
    else
    {
       printf("Client: recv() is OK.\n");
	   printf("Client: server said: %s.\n",recvbuf);	   
       printf("Client: Bytes received: %ld\n", bytesRecv);
    }
    
			

        }
		
		//loan repayment
		
		else if((strncmp(command,"loan_repayment",14)==0))
        {
			strcpy(sendbuf,command);
	bytesSent = send(ConnectSocket, sendbuf, strlen(sendbuf), 0);
	if (bytesSent == 0 || bytesSent == WSAECONNRESET)
    {
      printf("Client: Connection Closed.\n");
      break;
    }
   else
    {
       printf("Client: send() is OK.\n");
    }
	char recvbuf[200] = "";
    bytesRecv = recv(ConnectSocket, recvbuf, 200, 0);
    if (bytesRecv == 0 || bytesRecv == WSAECONNRESET)
    {
      printf("Client: Connection Closed.\n");

      break;
    }
    else
    {
       printf("Client: recv() is OK.\n");
	   printf("Client: server said: %s.\n",recvbuf);	   
       printf("Client: Bytes received: %ld\n", bytesRecv);
    }
           // printf("idea name:%s\nCapital:%d\ndescription:%s",secondslot,idea_capital,idea_description);
			

        }
		else if(strcmp(command,"logout")==0){
		strcpy(sendbuf,command);
	bytesSent = send(ConnectSocket, sendbuf, strlen(sendbuf), 0);
	if (bytesSent == 0 || bytesSent == WSAECONNRESET)
    {
      printf("Client: Connection Closed.\n");
      break;
    }
   else
    {
       printf("Client: send() is OK.\n");
	   
    }
	char recvbuf[200] = "";
    bytesRecv = recv(ConnectSocket, recvbuf, 200, 0);
    if (bytesRecv == 0 || bytesRecv == WSAECONNRESET)
    {
      printf("Client: Connection Closed.\n");
      break;
    }
    else
    {
       printf("Client: recv() is OK.\n");
	   printf("Client: server said: %s.\n",recvbuf);	   
       printf("Client: Bytes received: %ld\n", bytesRecv);
    }
		
		}
		
		
		
		else{
		
		printf("please enter the right command\n");
		}
	
    }
	
	WSACleanup();

  return 0;
	}
	
	int sacco(char x[200]){
	int i;
	int count;
	char *spaces="\t \r \n \f";
	char *ptok;
	char names[200];
	strcpy(names,x);
	ptok=strtok(names,spaces);
	while(ptok!=NULL){
	if(strlen(ptok)>0)
	count++;
	ptok=strtok(NULL,spaces);
	
	}
	return count;
	}
	




