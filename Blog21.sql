-- MySQL dump 10.13  Distrib 5.7.12, for osx10.11 (x86_64)
--
-- Host: localhost    Database: BlogSpace
-- ------------------------------------------------------
-- Server version	5.7.12-debug

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `BlogTable`
--

DROP TABLE IF EXISTS `BlogTable`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `BlogTable` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(150) NOT NULL,
  `timestamp` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `BlogTable`
--

LOCK TABLES `BlogTable` WRITE;
/*!40000 ALTER TABLE `BlogTable` DISABLE KEYS */;
INSERT INTO `BlogTable` VALUES (1,'Forms Explained.','2016-06-23 19:05:01'),(2,'What is REST?','2016-06-23 20:06:45'),(3,'Escaping dynamic values and user input','2016-06-23 20:09:32'),(4,'A Croatian Microadventure','2016-06-23 20:24:58'),(5,'Some login tricks','2016-06-23 20:26:54'),(6,'Some login tricks with more info!!!','2016-06-23 20:30:14'),(7,'HTTPS is HTTP secure','2016-06-23 20:30:35'),(8,'Cookie options','2016-06-23 20:33:02'),(9,'Location header','2016-06-23 20:35:50'),(10,'User Agent','2016-06-23 20:40:21');
/*!40000 ALTER TABLE `BlogTable` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `CommentTable`
--

DROP TABLE IF EXISTS `CommentTable`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `CommentTable` (
  `comment` text NOT NULL,
  `paraid` int(11) NOT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `timestamp` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `paraid_idx` (`paraid`),
  CONSTRAINT `paraid` FOREIGN KEY (`paraid`) REFERENCES `ParaTable` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `CommentTable`
--

LOCK TABLES `CommentTable` WRITE;
/*!40000 ALTER TABLE `CommentTable` DISABLE KEYS */;
INSERT INTO `CommentTable` VALUES ('This is temp comment. This is temp comment. This is temp comment.',5,1,'2016-06-23 21:17:47'),('This is temp comment.',5,2,'2016-06-23 21:17:47'),('This is temp comment. This is temp comment.',7,3,'2016-06-23 21:17:47'),('This is temp comment. This is temp comment. This is temp comment.',23,4,'2016-06-23 21:21:00'),('This is temp comment.',24,5,'2016-06-23 21:21:00'),('This is temp comment. This is temp comment.',22,6,'2016-06-23 21:21:00'),('This is temp comment. This is temp comment. This is temp comment.',12,7,'2016-06-23 21:21:21'),('This is temp comment.',13,8,'2016-06-23 21:21:21'),('This is temp comment. This is temp comment. This is temp comment.',1,9,'2016-06-23 21:25:13'),('This is temp comment. This is temp comment. This is temp comment.',10,10,'2016-06-23 21:25:28'),('This is temp comment.',11,11,'2016-06-23 21:25:28');
/*!40000 ALTER TABLE `CommentTable` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ParaTable`
--

DROP TABLE IF EXISTS `ParaTable`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ParaTable` (
  `paratext` text NOT NULL,
  `blogid` int(11) NOT NULL,
  `parano` int(11) NOT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`blogid`,`parano`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  KEY `id_idx` (`blogid`,`parano`),
  CONSTRAINT `blogid` FOREIGN KEY (`blogid`) REFERENCES `BlogTable` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ParaTable`
--

LOCK TABLES `ParaTable` WRITE;
/*!40000 ALTER TABLE `ParaTable` DISABLE KEYS */;
INSERT INTO `ParaTable` VALUES ('In your favorite browser, this form will appear with a text box to fill in and a press-button labeled \"OK\". If you fill in \'1905\' and press the OK button, your browser will then create a new URL to get for you. The URL will get \"junk.cgi?birthyear=1905&press=OK\" appended to the path part of the previous URL.',1,1,1),('If the original form was seen on the page \"www.hotmail.com/when/birth.html\", the second page you\'ll get will become \"www.hotmail.com/when/junk.cgi?birthyear=1905&press=OK\".',1,2,2),('REST, or in the full form, Representational State Transfer has become the standard design architecture for developing web APIs. At its heart REST is a stateless client-server relationship; this means that unlike many other approaches there is no client context being stored server side (no Sessions). To counteract that, each request contains all the information necessary for the server to authenticate the user, and any session state data that must be sent as well.',2,1,3),('By creating URI endpoints that utilize these operations, a RESTful API is quickly assembled.',2,2,4),('In the previous two example queries, I manually placed the values I passed to the database in the query - the user name and email in the INSERT query, and the user id in the SELECT query. If we replace those values with variables that contain unknown values, and especially user input, we need to escape it properly. There are a few characters - notably quotation marks and carriage returns - that will break our query, and in the case of user input allow an attacker to compromise our database (an attack referred to as SQL injection).',3,1,5),('For that purpose, we\'ll use the mysqli_real_escape_string() function. Since it needs a database connection, we\'ll go ahead and wrap it in its own function. In addition, since we only need to escape strings, we might as well quote the value at the same time.',3,2,6),('If we are not sure of the type of value we pass to the database, it\'s always best to treat it as a string, escape and quote it.',3,3,7),('Al certainly didn\'t invent going fast and light, but he brought a very marketable, inspirational form to the idea, one that can nudge and pull and push against inertia. \"Microadventure? I have time for that.\"',4,1,8),('In this one, Humphreys and Temujin Doran zip to Croatia for a single night and pack as much as they can in. The \"we did this\" and \"then we did this\" narration gets a little old, but it\'s a fun romp to a cool place that should serve as impetus to get out there yourself.',4,2,9),('While not strictly just HTTP related, it still cause a lot of people problems so here\'s the executive run-down of how the vast majority of all login forms work and how to login to them using curl.',5,1,10),('It can also be noted that to do this properly in an automated fashion, you will most certainly need to script things and do multiple curl invokes etc.\n\nFirst, servers mostly use cookies to track the logged-in status of the client, so you will need to capture the cookies you receive in the responses. Then, many sites also set a special cookie on the login page (to make sure you got there through their login page) so you should make a habit of first getting the login-form page to capture the cookies set there.\n\nSome web-based login systems features various amounts of javascript, and sometimes they use such code to set or modify cookie contents. Possibly they do that to prevent programmed logins, like this manual describes how to... Anyway, if reading the code isn\'t enough to let you repeat the behavior manually, capturing the HTTP requests done by your browsers and analyzing the sent cookies is usually a working method to work out how to shortcut the javascript need.\n\nIn the actual <form> tag for the login, lots of sites fill-in random/session or otherwise secretly generated hidden tags and you may need to first capture the HTML code for the login form and extract all the hidden fields to be able to do a proper login POST. Remember that the contents need to be URL encoded when sent in a normal POST.',5,2,11),('While not strictly just HTTP related, it still cause a lot of people problems so here\'s the executive run-down of how the vast majority of all login forms work and how to login to them using curl.',6,1,12),('It can also be noted that to do this properly in an automated fashion, you will most certainly need to script things and do multiple curl invokes etc.',6,2,13),('First, servers mostly use cookies to track the logged-in status of the client, so you will need to capture the cookies you receive in the responses. Then, many sites also set a special cookie on the login page (to make sure you got there through their login page) so you should make a habit of first getting the login-form page to capture the cookies set there.',6,3,14),('Some web-based login systems features various amounts of javascript, and sometimes they use such code to set or modify cookie contents. Possibly they do that to prevent programmed logins, like this manual describes how to... Anyway, if reading the code isn\'t enough to let you repeat the behavior manually, capturing the HTTP requests done by your browsers and analyzing the sent cookies is usually a working method to work out how to shortcut the javascript need.',6,4,15),('In the actual <form> tag for the login, lots of sites fill-in random/session or otherwise secretly generated hidden tags and you may need to first capture the HTML code for the login form and extract all the hidden fields to be able to do a proper login POST. Remember that the contents need to be URL encoded when sent in a normal POST.',6,5,16),('There are a few ways to do secure HTTP transfers. The by far most common protocol for doing this is what is generally known as HTTPS, HTTP over SSL. SSL encrypts all the data that is sent and received over the network and thus makes it harder for attackers to spy on sensitive information.',7,1,17),('SSL (or TLS as the latest version of the standard is called) offers a truckload of advanced features to allow all those encryptions and key infrastructure mechanisms encrypted HTTP requires.',7,2,18),('Curl supports encrypted fetches when built to use a TLS library and it can be built to use one out of a fairly large set of libraries - \"curl -V\" will show which one your curl was built to use (if any!).',7,3,19),('Cookies are sent as common HTTP headers. This is practical as it allows curl to record cookies simply by recording headers.',8,1,20),('(Take note that the --cookie-jar option described below is a better way to store cookies.)',8,2,21),('Curl has a full blown cookie parsing engine built-in that comes to use if you want to reconnect to a server and use cookies that were stored from a previous connection (or hand-crafted manually to fool the server into believing you had a previous connection).',8,3,22),('Curl\'s \"cookie engine\" gets enabled when you use the --cookie option. If you only want curl to understand received cookies, use --cookie with a file that doesn\'t exist. Example, if you want to let curl understand cookies from a page and follow a location (and thus possibly send back cookies it received), you can invoke it.',8,4,23),('Curl has the ability to read and write cookie files that use the same file format that Netscape and Mozilla once used. It is a convenient way to share cookies between scripts or invokes. The --cookie (-b) switch automatically detects if a given file is such a cookie file and parses it, and by using the --cookie-jar (-c) option you\'ll make curl write a new cookie file at the end of an operation',8,5,24),('When a resource is requested from a server, the reply from the server may include a hint about where the browser should go next to find this page, or a new page keeping newly generated output. The header that tells the browser to redirect is Location:.',9,1,25),('Curl does not follow Location: headers by default, but will simply display such pages in the same manner it display all HTTP replies. It does however feature an option that will make it attempt to follow the Location: pointers.',9,2,26),('If you use curl to POST to a site that immediately redirects you to another page, you can safely use --location (-L) and --data/--form together. Curl will only use POST in the first request, and then revert to GET in the following operations.',9,3,27),('Very similar to the referer field, all HTTP requests may set the User-Agent field. It names what user agent (client) that is being used. Many applications use this information to decide how to display pages. Silly web programmers try to make different pages for users of different browsers to make them look the best possible for their particular browsers. They usually also do different kinds of javascript, vbscript etc.',10,1,28),('At times, you will see that getting a page with curl will not return the same page that you see when getting the page with your browser. Then you know it is time to set the User Agent field to fool the server into thinking you\'re one of those browsers.',10,2,29);
/*!40000 ALTER TABLE `ParaTable` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-06-24  9:58:35
