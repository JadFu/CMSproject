This is the final update of my CMS project before deadline

1. database is called gch_server
    an sql file name same as server name has been include in the folder

2.  the connect.php use 
    jadmin as user name 
        and 
    fyz2436! as password
    the code I used to set up was:

        CREATE DATABASE gch_server;
        CREATE USER 'jadmin'@'localhost' IDENTIFIED BY 'fyz2436!';
        GRANT SELECT, INSERT, UPDATE, DELETE, CREATE, DROP, ALTER
        ON gch_server.* TO 'jadmin'@'localhost';

3. the only admin and passward in system are all lower case:
        firstuser
        firstpass
    one of the normal user is:
        jad
        jad2436

4. an copy of the Web Dev 2 Project Tracking_Rubric has been include
    all the code I've been working on after class has been mark as maybe(I think I didn't miss anything)

5. all commits have been saved on github under "JadFu/CMSproject"
    it has been set as public, I have uploaded the same file to the last commit just in case if anything not working here