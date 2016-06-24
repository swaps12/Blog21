# Blog21

Setup Instruction
------------------

Clone the repo and follow the below mentioned steps.


Database Setup

----------------------------- Creating Database -----------------------------------------------------


1. Create a db on mysql prompt using the following command.

mysql> create database Blog21;

2. Quit the mysql prompt. Change terminal directory to the path where Blog21 is cloned.

3. Using Blog21.sql, create the tables and dump data.

$ mysql -u[UserName] -p[Password] Blog21 < Blog21.sql

The database is prefilled with some data to test listing of blogs. 

-----------------------------------------------------------------------------------------------------

Config Changes

---------------------------------------------------------------------------------------------------------

1. Open the config.ini file in editor of your choice.
2. Replace values for DB_USERNAME, DB_PASSWORD with approprite value.

---------------------------------------------------------------------------------------------------------

Start the php webser.

-----------------------------------------------------------------------------------------------------

1. php -S localhost:8000 -t [Clone Path]/blog21

-----------------------------------------------------------------------------------------------------

Testing

-----------------------------------------------------------------------------------------------------

Below are some test cases using curl. 

Create directory response to create all responses in a folder. 
- mkdir response

1.Blog listing

curl -o  response/response1.txt -H "Content-Type: application/json" -X POST -d '{"start": 1,"count": 5}' http://localhost:8000/getBlogs.php

curl -o  response/response2.txt -H "Content-Type: application/json" -X POST -d '{"start": 15,"count": 5}' http://localhost:8000/getBlogs.php

curl -o  response/response3.txt -H "Content-Type: application/json" -X POST -d '{"start": 5,"count": 5}' http://localhost:8000/getBlogs.php

2.Add Blog

curl -o  response/response4.txt  -H "Content-Type: application/json" -X POST -d '{"title":"Tell Git who you are","blog":"Configure the author name and email address to be used with your commits.\\n\\nNote that Git strips some characters (for example trailing periods) from user.name."}' http://localhost:8000/addblog.php

curl -o  response/response5.txt  -H "Content-Type: application/json" -X POST -d '{"title":"SFTP / SCP","blog":"This is similar to FTP, but you can use the --key option to specify a private key to use instead of a password.\\n\\nNote that the private key may itself be protected by a password that is unrelated to the login password of the remote system; this password is specified using the --pass option.\\n\\nTypically, curl will automatically extract the public key from the private key file, but in cases where curl does not have the proper library support, a matching public key file must be specified using the --pubkey option."}' http://localhost:8000/addblog.php


curl -o  response/response6.txt  -H "Content-Type: application/json" -X POST -d '{"title":"HTTP", "blog":" HTTP offers many different methods of authentication and curl supports several: Basic, Digest, NTLM and Negotiate (SPNEGO). Without telling which method to use, curl defaults to Basic. You can also ask curl to pick the most secure ones out of the ones that the server accepts for the given URL, by using --anyauth.\\n\\nNOTE! According to the URL specification, HTTP URLs can not contain a user and password, so that style will not work when using curl via a proxy, even though curl allows it at other times. When using a proxy, you _must_ use the -u style for user and password."}' http://localhost:8000/addblog.php


3.Add Comments.

curl -o  response/response7.txt -H "Content-Type: application/json" -X POST -d '{"blogid" : 10,
 "comments": [{"paraid" : 29, "comment": "This is temp comment"} , {"paraid" : 28, "comment": "This is temp comment"}]
 }' http://localhost:8000/addComment.php

curl -o  response/response8.txt -H "Content-Type: application/json" -X POST -d '{"blogid" : 11,
 "comments": [{"paraid" : 30, "comment": "This is temp comment"} , {"paraid" : 30, "comment": "This is temp comment"}]
 }' http://localhost:8000/addComment.php


 curl -o  response/response9.txt -H "Content-Type: application/json" -X POST -d '{"blogid" : 11,
 "comments": [{"paraid" : 30, "comment": "This is temp comment"} , {"paraid" : 30, "comment": "This is temp comment"}, {"paraid" : 30, "comment": "This is temp comment"}]}' http://localhost:8000/addComment.php