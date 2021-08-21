#! /bin/sh
/bin/systemctl stop apache2
rm -fr /var/www/html/smarter-payouts/*
/bin/systemctl start apache2
