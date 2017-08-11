#include <stdio.h>
#include <winsock2.h>
#include<mysql.h>
int sacco(char x[200]);
 void finish_with_error(MYSQL *conn)
{
    fprintf(stderr,"%s\n",mysql_error(conn));
    mysql_close(conn);
    exit(1);
}

int main(void)
{
WORD wVersionRequested;

WSADATA wsaData;

MYSQL *query;
MYSQL_ROW row;


/*initialising connection*/
MYSQL *conn=mysql_init(NULL);
if(conn==NULL)
{
printf("failed to initialise connection to mysql\n\n");
exit(1);
}
else
{
printf("mysql connection is initialised\n\n");
}

/* connecting to the server*/
 if(mysql_real_connect(conn,"localhost","root","","famillysacco",0,NULL,0)==NULL)
{
printf("failed to connect to mysql database\n\n");
mysql_close(conn);
exit(1);
}
else
{
printf("connected to mysql database\n\n");
}


int wsaerr;
// Using MAKEWORD macro, Winsock version request 2.2
wVersionRequested = MAKEWORD(2, 2);
wsaerr = WSAStartup(wVersionRequested, &wsaData);
if (wsaerr != 0)

{

    /* Tell the user that we could not find a usable WinSock DLL.*/
    printf("Server: The Winsock dll not found!\n");
    return 0;
}
else
{
       printf("Server: The Winsock dll found!\n");

       printf("Server: The status: %s.\n", wsaData.szSystemStatus);
}
/* Confirm that the WinSock DLL supports 2.2.*/

if (LOBYTE(wsaData.wVersion) != 2 || HIBYTE(wsaData.wVersion) != 2 )

{

    /* Tell the user that we could not find a usable WinSock DLL.*/

    printf("Server: The dll do not support the Winsock version %u.%u!\n", LOBYTE(wsaData.wVersion), HIBYTE(wsaData.wVersion));

    WSACleanup();

    return 0;

}

else

{

       printf("Server: The dll supports the Winsock version %u.%u!\n", LOBYTE(wsaData.wVersion), HIBYTE(wsaData.wVersion));

       printf("Server: The highest version this dll can support: %u.%u\n", LOBYTE(wsaData.wHighVersion), HIBYTE(wsaData.wHighVersion));
}

//Create a SOCKET object called m_socket.
SOCKET m_socket;
// Call the socket function and return its value to the m_socket variable.
// For this application, use the Internet address family, streaming sockets, and
// the TCP/IP protocol.
// using AF_INET family, TCP socket type and protocol of the AF_INET - IPv4
m_socket = socket(AF_INET, SOCK_STREAM, IPPROTO_TCP);
// Check for errors to ensure that the socket is a valid socket.
if (m_socket == INVALID_SOCKET)
{
    printf("Server: Error at socket(): %ld\n", WSAGetLastError());
    WSACleanup();
    return 0;

}

else

{

    printf("Server: socket() is OK!\n");
}

// Create a sockaddr_in object and set its values.
struct sockaddr_in service;
// AF_INET is the Internet address family.

service.sin_family = AF_INET;
// "127.0.0.1" is the local IP address to which the socket will be bound.
service.sin_addr.s_addr = inet_addr("127.0.0.1");

// 55555 is the port number to which the socket will be bound.

service.sin_port = htons(55555);
// Call the bind function, passing the created socket and the sockaddr_in structure as parameters.

// Check for general errors.

if (bind(m_socket, (SOCKADDR*)&service, sizeof(service)) == SOCKET_ERROR)

{

    printf("Server: bind() failed: %ld.\n", WSAGetLastError());

    closesocket(m_socket);

    return 0;

}

else

{

    printf("Server: bind() is OK!\n");

}
// Call the listen function, passing the created socket and the maximum number of allowed

// connections to accept as parameters. Check for general errors.

if (listen(m_socket, 10) == SOCKET_ERROR)

   printf("Server: listen(): Error listening on socket %ld.\n", WSAGetLastError());

else

{

   printf("Server: listen() is OK, I'm waiting for connections...\n");

}

 

// Create a temporary SOCKET object called AcceptSocket for accepting connections.

SOCKET AcceptSocket;

 

// Create a continuous loop that checks for connections requests. If a connection

// request occurs, call the accept function to handle the request.

printf("Server: Waiting for a client to connect...\n" );

printf("***Hint: Server is ready...run your client program...***\n");
int c;
int bytesSent;
int bytesRecv = SOCKET_ERROR;
//char sendbuf[200] = "This string is a test data from server";
// initialize to empty data...
//char recvbuf[200] = "";
c=sizeof(struct sockaddr_in);


// Do some verification...
    while( (AcceptSocket = accept(m_socket, (struct sockaddr *)&service,&c)) != INVALID_SOCKET ){
        puts("Connection accepted");		
// Receives some test string from client...and client
// must send something lol...

while(1){
char recvbuf[200]="";
bytesRecv = recv(AcceptSocket, recvbuf, 200, 0);
if (bytesRecv == 0 || bytesSent == WSAECONNRESET)
{
	printf("Server: Connection Closed.\n");
	break;
}
else
{
       printf("Server: recv() is OK.\n");
       printf("Server: Received data is:%s\n", recvbuf);
       printf("Server: Bytes received: %d\n", bytesRecv);
	   
	   //file
	   FILE *file=fopen("nsaba.txt","a");
       fprintf(file,"%s\n\n\n",recvbuf);
       fclose(file);

	   
}
int v=sacco(recvbuf);
char sendbuf[200];
//contribution check
if(strcmp(recvbuf,"contribution check")==0){
if(mysql_query(conn,"SELECT * FROM contribution")){
       finish_with_error(conn);
    }
    MYSQL_RES *result=mysql_store_result(conn);
    if(result==NULL)
    {
       finish_with_error(conn); 
    }
    int num_fields=mysql_num_fields(result);
    MYSQL_ROW row;


while((row=mysql_fetch_row(result)))
    {
       for(int i=0;i<num_fields;i++)
        {
            
			printf("%s ",row[i]?row[i]:"NULL");
			sprintf(sendbuf,"%s ",row[i]?row[i]:"NULL");
			bytesSent = send(AcceptSocket, sendbuf, strlen(sendbuf), 0);
			
        }
        printf("\n\n");
  }


if (bytesSent == 0 || bytesSent == WSAECONNRESET)
{
	 printf("Server: Connection Closed.\n");
	 break;
}
else
{
       printf("Server: send() is OK.\n");
       printf("Server: Bytes Sent: %d.\n", bytesSent);
}
}


//loan status

else if((strcmp(recvbuf,"loan status")==0)){

if(mysql_query(conn,"SELECT * FROM loan")){
       finish_with_error(conn);
    }
    MYSQL_RES *result=mysql_store_result(conn);
    if(result==NULL)
    {
       finish_with_error(conn); 
    }
    int num_fields=mysql_num_fields(result);
    MYSQL_ROW row;


while((row=mysql_fetch_row(result)))
    {
       for(int i=0;i<num_fields;i++)
        {
            
			printf("%s ",row[i]?row[i]:"NULL");
			sprintf(sendbuf,"%s ",row[i]?row[i]:"NULL");
			bytesSent = send(AcceptSocket, sendbuf, strlen(sendbuf), 0);
			
        }
        printf("\n\n");
  }


if (bytesSent == 0 || bytesSent == WSAECONNRESET)
{
	 printf("Server: Connection Closed.\n");
	 break;
}
else
{
       printf("Server: send() is OK.\n");
       printf("Server: Bytes Sent: %d\n", bytesSent);
}
}


 

// contribution amount

else 
		if((strncmp(recvbuf,"contribution",12)==0)&& v>4){
sprintf(sendbuf,"contribution submitted");
bytesSent = send(AcceptSocket, sendbuf, strlen(sendbuf), 0);
if (bytesSent == 0 || bytesSent == WSAECONNRESET)
{
	 printf("Server: Connection Closed.\n");
	 break;
}
else
{
       printf("Server: send() is OK.\n");
       printf("Server: Bytes Sent: %d.\n", bytesSent);
}
}
//loan request
else if((strncmp(recvbuf,"loan_request",12)==0)&&(v>4)){
sprintf(sendbuf, "loan being requested");
bytesSent = send(AcceptSocket, sendbuf, strlen(sendbuf), 0);
if (bytesSent == 0 || bytesSent == WSAECONNRESET)
{
	 printf("Server: Connection Closed.\n");
	 break;
}
else
{
       printf("Server: send() is OK.\n");
       printf("Server: Bytes Sent: %d.\n", bytesSent);
}
}

//idea
else if((strncmp(recvbuf,"idea",3)==0)&&(v>4)){
sprintf(sendbuf, "your idea has been submitted");
bytesSent = send(AcceptSocket, sendbuf, strlen(sendbuf), 0);
if (bytesSent == 0 || bytesSent == WSAECONNRESET)
{
	 printf("Server: Connection Closed.\n");
	 break;
}
else
{
       printf("Server: send() is OK.\n");
       printf("Server: Bytes Sent: %d.\n", bytesSent);
}
}

//benefits check
else if((strcmp(recvbuf,"benefits check")==0)){

if(mysql_query(conn,"SELECT * FROM ideaFollowUp")){
       finish_with_error(conn);
    }
    MYSQL_RES *result=mysql_store_result(conn);
    if(result==NULL)
    {
       finish_with_error(conn); 
    }
    int num_fields=mysql_num_fields(result);
    MYSQL_ROW row;


while((row=mysql_fetch_row(result)))
    {
       for(int i=0;i<num_fields;i++)
        {
            
			printf("%s ",row[i]?row[i]:"NULL");
			sprintf(sendbuf,"%s ",row[i]?row[i]:"NULL");
			bytesSent = send(AcceptSocket, sendbuf, strlen(sendbuf), 0);
			
        }
        printf("\n\n");
  }
if (bytesSent == 0 || bytesSent == WSAECONNRESET)
{
	 printf("Server: Connection Closed.\n");
	 break;
}
else
{
       printf("Server: send() is OK.\n");
       printf("Server: Bytes Sent: %d.\n", bytesSent);
}
}
//loan repayment details
else if((strcmp(recvbuf,"loan repayment details")==0)){

if(mysql_query(conn,"SELECT * FROM loanRepayment")){
       finish_with_error(conn);
    }
    MYSQL_RES *result=mysql_store_result(conn);
    if(result==NULL)
    {
       finish_with_error(conn); 
    }
    int num_fields=mysql_num_fields(result);
    MYSQL_ROW row;


while((row=mysql_fetch_row(result)))
    {
       for(int i=0;i<num_fields;i++)
        {
            
			printf("%s ",row[i]?row[i]:"NULL");
			sprintf(sendbuf,"%s ",row[i]?row[i]:"NULL");
			bytesSent = send(AcceptSocket, sendbuf, strlen(sendbuf), 0);
			
        }
        printf("\n\n");
  }
bytesSent = send(AcceptSocket, sendbuf, strlen(sendbuf), 0);
if (bytesSent == 0 || bytesSent == WSAECONNRESET)
{
	 printf("Server: Connection Closed.\n");
	 break;
}
else
{
       printf("Server: send() is OK.\n");
       printf("Server: Bytes Sent: %d.\n", bytesSent);
}
}
//loan repayment
else if((strncmp(recvbuf,"loan_repayment",14)==0)){
sprintf(sendbuf, "your request was successful");
bytesSent = send(AcceptSocket, sendbuf, strlen(sendbuf), 0);
if (bytesSent == 0 || bytesSent == WSAECONNRESET)
{
	 printf("Server: Connection Closed.\n");
	 break;
}
else
{
       printf("Server: send() is OK.\n");
       printf("Server: Bytes Sent: %d.\n", bytesSent);
}
}
else if(recvbuf,"logout"){
sprintf(sendbuf, "you have successfully logged out");
	bytesSent = send(AcceptSocket, sendbuf, strlen(sendbuf), 0);
	if (bytesSent == 0 || bytesSent == WSAECONNRESET)
    {
      printf("Server: Connection Closed.\n");
      break;
    }
   else
    {
       printf("server send(): send() is OK.\n");
	   
    }
	
}
else{

sprintf(sendbuf, "enter the correct command"); 
	bytesSent = send(AcceptSocket, sendbuf, strlen(sendbuf), 0);
	if (bytesSent == 0 || bytesSent == WSAECONNRESET)
    {
      printf("Server: Connection Closed.\n");
      break;
    }
   else
    {
       printf("server send(): send() is OK.\n");
	   
    }




}
	}
WSACleanup();
}
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