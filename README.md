# php-svn-lister

List all your SVN repos in one url and allows to edit the repo description on your browser. Mainly for intranets/vpn's.

The folder must be www-data writable (descriptions are stored on a .txt file)

```bash
mkdir /var/www/html/repos
git clone https://github.com/davidjimenez75/php-svn-lister.git /var/www/html/repos
cd /var/www/html/repos
cp config-dist.php config.php
chown www-data:www-data /var/www/html/repos -R
```
Edit the config.php with your SVN repo url and folder.

```
$url_svn   = 'http://YOUR_SVN_WEBSERVER_HERE/svn/'; // url to you svn webserver
$dir       = '/var/lib/svn';			                  // folder with svn repos
```

Now you can click edit the right side of every folder on your browser with descriptions, press Enter to save.

