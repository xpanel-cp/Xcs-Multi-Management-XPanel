c#!/bin/bash

RED="\e[31m"
GREEN="\e[32m"
YELLOW="\e[33m"
BLUE="\e[34m"
CYAN="\e[36m"
ENDCOLOR="\e[0m"

if [ "$EUID" -ne 0 ]
then echo "Please run as root"
exit
fi

# php7.x is End of life https://www.php.net/supported-versions.php ubuntu bellow 20 is not supported by php8.1 in 2023
if [ "$(uname)" == "Linux" ]; then
    version_info=$(lsb_release -rs)
    # Check if it's Ubuntu and version is below 20
    if [ "$(lsb_release -is)" == "Ubuntu" ] && [ "$(echo "$version_info < 20" | bc)" -eq 1 ]; then
        echo "This Script is using php8.1 and only supported in ubuntu 20 and above"
        exit
    fi
fi

adminuser=$(mysql -N -e "use Xcs; select username from admins where permission='admin';")
adminpass=$(mysql -N -e "use Xcs; select username from admins where permission='admin';")
clear
echo -e "${YELLOW}************ Select Xcs Version ************"
echo -e "${GREEN}  1)Xcs v 1.0"
echo -ne "${GREEN}\nSelect Version : ${ENDCOLOR}" ;read n
if [ "$n" != "" ]; then
if [ "$n" == "1" ]; then
linkd=https://api.github.com/repos/xpanel-cp/Xcs-Multi-Management-XPanel/releases/tags/xcsv1-0
fi
else
linkd=https://api.github.com/repos/xpanel-cp/Xcs-Multi-Management-XPanel/releases/tags/xcsv1-0
fi

echo -e "\nPlease input IP Server"
printf "IP: "
read ip
if [ -n "$ip" -a "$ip" == " " ]; then
echo -e "\nPlease input IP Server"
printf "IP: "
read ip
fi
adminusername=admin
echo -e "\nPlease input Panel admin user."
printf "Default user name is \e[33m${adminusername}\e[0m, let it blank to use this user name: "
read usernametmp
if [[ -n "${usernametmp}" ]]; then
adminusername=${usernametmp}
fi
adminpassword=123456
echo -e "\nPlease input Panel admin password."
printf "Default password is \e[33m${adminpassword}\e[0m, let it blank to use this password : "
read passwordtmp
if [[ -n "${passwordtmp}" ]]; then
adminpassword=${passwordtmp}
fi

ipv4=$ip

if command -v apt-get >/dev/null; then

sudo NEETRESTART_MODE=a apt-get update --yes
sudo apt-get -y install software-properties-common
apt-get install -y stunnel4 && apt-get install -y cmake && apt-get install -y screenfetch && apt-get install -y openssl
sudo apt-get -y install software-properties-common
sudo add-apt-repository ppa:ondrej/php -y
apt-get install apache2 zip unzip net-tools curl mariadb-server -y
apt-get install php php-cli php-mbstring php-dom php-pdo php-mysql -y
apt-get install npm -y
sudo apt-get install coreutils
wait
phpv=$(php -v)
if [[ $phpv == *"8.1"* ]]; then

apt autoremove -y
  echo "PHP Is Installed :)"
else
rm -fr /etc/php/7.4/apache2/conf.d/00-ioncube.ini
sudo apt-get purge '^php7.*' -y
apt remove php* -y
apt remove php -y
apt autoremove -y
apt install php8.1 php8.1-mysql php8.1-xml php8.1-curl cron -y
fi
curl -sS https://getcomposer.org/installer | sudo php -- --install-dir=/usr/local/bin --filename=composer    

link=$(sudo curl -Ls "$linkd" | grep '"browser_download_url":' | sed -E 's/.*"([^"]+)".*/\1/')
sudo wget -O /var/www/html/update.zip $link
sudo unzip -o /var/www/html/update.zip -d /var/www/html/ &
wait
echo 'www-data ALL=(ALL:ALL) NOPASSWD:/usr/bin/curl' | sudo EDITOR='tee -a' visudo &
wait
echo 'www-data ALL=(ALL:ALL) NOPASSWD:/usr/bin/crontab' | sudo EDITOR='tee -a' visudo &
wait
echo 'www-data ALL=(ALL:ALL) NOPASSWD:/usr/bin/mysqldump' | sudo EDITOR='tee -a' visudo &
wait
sudo a2enmod rewrite
wait
sudo service apache2 restart
wait
sudo systemctl restart apache2
wait
sudo service apache2 restart
wait
sudo sed -i "s/AllowOverride None/AllowOverride All/g" /etc/apache2/apache2.conf &
wait
sudo service apache2 restart
wait
clear
# Random port number generator to prevent xcs detection by potential attackers
randomPort=""
# Check if $RANDOM is available in the shell
if [ -z "$RANDOM" ]; then
  # If $RANDOM is not available, use a different random number generation method
  random_number=$(od -A n -t d -N 2 /dev/urandom | tr -d ' ')
else
  # Generate a random number between 0 and 63000 using $RANDOM
  random_number=$((RANDOM % 63001))
fi

# Add 2000 to the random number to get a range between 2000 and 65000
randomPort=$((random_number + 2000))

# Use port 8081 if the random_number is zero (in case $RANDOM was not available and port 8081 was chosen)
if [ "$random_number" -eq 0 ]; then
  randomPort=8081
fi


echo -e "\nPlease input Panel admin Port, or leave blank to use randomly generated port"
printf "Random port \033[33m$randomPort:\033[0m "
read porttmp
if [[ -n "${porttmp}" ]]; then
#Get the server port number from my settings file
serverPort=${porttmp}
echo $serverPort
else
serverPort=$randomPort
echo $serverPort
fi
##Get just the port number from the settings variable I just grabbed
serverPort=${serverPort##*=}
##Remove the "" marks from the variable as they will not be needed
serverPort=${serverPort//'"'}
echo "<VirtualHost *:80>
    ServerAdmin webmaster@localhost
    DocumentRoot /var/www/html/example
    ErrorLog /error.log
    CustomLog /access.log combined
    <Directory '/var/www/html/example'>
    AllowOverride All
    </Directory>
</VirtualHost>

<VirtualHost *:$serverPort>
    # The ServerName directive sets the request scheme, hostname and port that
    # the server uses to identify itself. This is used when creating
    # redirection URLs. In the context of virtual hosts, the ServerName
    # specifies what hostname must appear in the request's Host: header to
    # match this virtual host. For the default virtual host (this file) this
    # value is not decisive as it is used as a last resort host regardless.
    # However, you must set it for any further virtual host explicitly.
    #ServerName www.example.com

    ServerAdmin webmaster@localhost
    DocumentRoot /var/www/html/cp

    # Available loglevels: trace8, ..., trace1, debug, info, notice, warn,
    # error, crit, alert, emerg.
    # It is also possible to configure the loglevel for particular
    # modules, e.g.
    #LogLevel info ssl:warn

    ErrorLog ${APACHE_LOG_DIR}/error.log
    CustomLog ${APACHE_LOG_DIR}/access.log combined

    # For most configuration files from conf-available/, which are
    # enabled or disabled at a global level, it is possible to
    # include a line for only one particular virtual host. For example the
    # following line enables the CGI configuration for this host only
    # after it has been globally disabled with "a2disconf".
    #Include conf-available/serve-cgi-bin.conf
    <Directory '/var/www/html/cp'>
    AllowOverride All
    </Directory>

</VirtualHost>

# vim: syntax=apache ts=4 sw=4 sts=4 sr noet" > /etc/apache2/sites-available/000-default.conf
wait
##Replace 'Virtual Hosts' and 'List' entries with the new port number
sudo  sed -i.bak 's/.*NameVirtualHost.*/NameVirtualHost *:'$serverPort'/' /etc/apache2/ports.conf
echo "Listen 80
Listen $serverPort
<IfModule ssl_module>
    Listen $serverPort
    Listen 443
</IfModule>

<IfModule mod_gnutls.c>
    Listen $serverPort
    Listen 443
</IfModule>" > /etc/apache2/ports.conf
wait
##Restart the apache server to use new port
sudo /etc/init.d/apache2 reload
sudo service apache2 restart
chown www-data:www-data /var/www/html/cp/* &
wait
systemctl restart mariadb &
wait
systemctl enable mariadb &
wait
sudo phpenmod curl
PHP_INI=$(php -i | grep /.+/php.ini -oE)
sed -i 's/extension=intl/;extension=intl/' ${PHP_INI}

systemctl restart httpd
systemctl enable httpd
fi
mysql -e "create database Xcs;" &
wait
mysql -e "CREATE USER '${adminusername}'@'localhost' IDENTIFIED BY '${adminpassword}';" &
wait
mysql -e "GRANT ALL ON *.* TO '${adminusername}'@'localhost';" &
wait
mysql -e "ALTER USER '${adminusername}'@'localhost' IDENTIFIED BY '${adminpassword}';" &
wait
sed -i "s/DB_USERNAME=.*/DB_USERNAME=$adminusername/g" /var/www/html/app/.env
sed -i "s/DB_PASSWORD=.*/DB_PASSWORD=$adminpassword/g" /var/www/html/app/.env
cd /var/www/html/app
php artisan migrate
if [ -n "$adminuser" -a "$adminuser" != "NULL" ]
then
 mysql -e "USE Xcs; UPDATE admins SET username = '${adminusername}' where permission='admin';"
 mysql -e "USE Xcs; UPDATE admins SET password = '${adminpassword}' where permission='admin';"
 mysql -e "USE Xcs; UPDATE settings SET ssh_port = '1' where id='1';"
else
mysql -e "USE Xcs; INSERT INTO admins (username, password, permission, credit, status) VALUES ('${adminusername}', '${adminpassword}', 'admin', '', 'active');"
mysql -e "USE Xcs; INSERT INTO settings (ssh_port, tls_port, t_token, t_id, language, multiuser, ststus_multiuser, home_url) VALUES ('1', '1', '', '', '', 'active', '', 'localhost');"
fi
sudo chown -R www-data:www-data /var/www/html/app
crontab -r
wait
multiin=$(echo "http://${ipv4}:$serverPort/fixer/exp")
cat > /var/www/html/cron.sh << ENDOFFILE
#!/bin/bash
#By Alireza
i=0
while [ 1i -lt 20 ]; do
cmd=(bbh '$multiin')
echo cmd &
sleep 30
i=(( i + 1 ))
done
ENDOFFILE
wait
sudo sed -i 's/(bbh/$(curl -v -H "A: B"/' /var/www/html/cron.sh
wait
sudo sed -i 's/cmd/$cmd/' /var/www/html/cron.sh
wait
sudo sed -i 's/1i/$i/' /var/www/html/cron.sh
wait
sudo sed -i 's/((/$((/' /var/www/html/cron.sh
wait
chmod +x /var/www/html/cron.sh
wait
(crontab -l | grep . ; echo -e "* * * * * /var/www/html/cron.sh") | crontab -
wait
chown www-data:www-data /var/www/html/example/index.php
clear

echo -e "************ Xcs ************ \n"
echo -e "Xcs Link : http://${ipv4}:$serverPort/login"
echo -e "Username : ${adminusername}"
echo -e "Password : ${adminpassword}"
