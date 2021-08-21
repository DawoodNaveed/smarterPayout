#! /bin/sh
cd /var/www/html/smarter-payouts
#sudo -u deploy-user /usr/bin/php bin/console assets:install --symlink
sudo -u www-data /usr/bin/php bin/console doctrine:schema:update --complete --force
sudo -u www-data /usr/bin/php bin/console cache:clear