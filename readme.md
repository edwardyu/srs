#Installation

##Server
Follow these steps to install the server, so we have the same things running on our development and production servers. Tested on Ubuntu 14.04.

`sudo apt-get update`

`sudo apt-get install lamp-server^`

When it prompts you to enter a MySQL root password, enter the one in the `passwords.xlsx` file in Dropbox.

##Application
Install composer: `curl -sS https://getcomposer.org/installer | php`

Get the app: `git clone https://github.com/edwardyu/srs`

Install dependencies: `php composer.phar install`

Copy files to `/var/www/html`