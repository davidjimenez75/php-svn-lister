# php-svn-lister

List all your SVN repositories and allow you to edit descriptions on your browser. Mainly for intranets/vpn's.



# INSTALLATION

IMPORTANT: The folder must be www-data writable (descriptions are stored on a *.txt files)

## OPTION 1: LIST YOUR SVN REPOSITORIES

```bash
mkdir /var/www/html/repos
git clone https://github.com/davidjimenez75/php-svn-lister.git /var/www/html/repos
cd /var/www/html/repos
cp config-dist-svn.php config.php
chown www-data:www-data /var/www/html/repos -R
```

Edit the config.php with your SVN repo url and folder.

```
$url_svn    = 'http://'.$_SERVER['SERVER_NAME'].'/svn/';         // url to you webserver
$url_suffix = '';                                                // add any suffix string to the url?
$dir        = '/var/lib/svn';                                    // folder with svn repos
```

Load in you browser: http://YOURSERVER/repos/



## OPTION 2: LIST YOUR FOLDER AS RELATIVES TO SERVER

```bash
cd /var/www/html
git clone https://github.com/davidjimenez75/php-svn-lister.git /var/www/html
cp config-dist-apache2.php config.php
chown www-data:www-data /var/www/html -R
```

Edit the config.php if you want to change the root folder:

```
$url_svn    = 'http://'.$_SERVER['SERVER_NAME'].'/';            // url to you webserver
$url_suffix = '';                                               // add any suffix string to the url?
$dir        = '/var/www/html';                                  // folder with svn repos
```

Load in you browser: http://YOURSERVER/


## OPTION 3: LIST YOUR FOLDERS AS SUBDOMAINS

```bash
cd /var/www/html
git clone https://github.com/davidjimenez75/php-svn-lister.git /var/www/html
cp config-dist-apache2.php config.php
chown www-data:www-data /var/www/html -R
```

Edit the config.php with your url_suffix and folder.

```
$url_svn    = 'http://'.$_SERVER['SERVER_NAME'];         // url to you webserver
$url_suffix = '.domain.com';                             // add any suffix string to the url?
$dir        = '/var/www/html';                           // folder with svn repos
```

Load in you browser: http://YOURSERVER/


# USE

Click on the right column of every folder to edit the description, press Enter to save.

Press Ctrl + F5 to verify is the descriptions are being stored on *.txt files.




# FAQ





