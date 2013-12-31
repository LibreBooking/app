#!/bin/sh
#
# Copyright (c) 2012 Alois Schloegl, IST Austria
# Copyright (c) 2012 Moritz Schepp, IST Austria

alias json-decode="php -r 'print_r(json_decode(file_get_contents(\"php://stdin\")));' ";

### this can be used to extract the the reference number
alias get_rn="php -r 'print_r(json_decode(file_get_contents(\"php://stdin\")));' | awk '/reference_number/  { print \$3 } '";

for arg in $@; do
        case $arg in
        -h | --help )
                echo '\nschedule_test.sh is a testing tool for creating and deleting ical events in Booked Scheduler without a web interface';
		echo 'The properties of each event need to be set in the source code of this script.'
		echo 'The return argument is a JSON encoded string.\n'
                echo 'Usage: test.sh {optional arguments}';
                echo '\t -h, --help\n\t\t\tthis information' ;
                echo '\t test.sh create\n\t\treturns a "reference_number"; this number must be set RN=## test delete, in order to do a delete or update ';
                echo '\t RN=## test.sh delete\n\t\tdeletes event with reference_number ##';
                echo '\t RN=## test.sh update\n\t\tdeletes event with reference_number ##';
                exit;
                ;;
#        -p | -r | -R | --real | --production )
#                FLAG_PRODUCTION=1;;
#        -* )    ## ignore these
#                ;;
#        * )     ## set YYYY-MM
#               YYYYMM=$arg;;
        esac;
done;


# internal key to protect communication
URL="https://intranet.ist.local/scheduleit3/Web"
IKEY=
USER=`whoami`

#echo -e '\n-------------- send request "'$@'" --------------\n'
if [ $# -eq 0 ]; then
    echo 'missing arguments';

elif [ $1 = 'create' ]; then
    curl -k -i \
	-F "username=$USER" \
	-F "starts_at=2013-03-14 10:00:00" \
	-F "ends_at=2013-03-14 11:00:00" \
	-F "summary=Create successful" \
	-F "description=Really great " \
	-F "contact_info=test@room.ist.ac.at" \
	-F "ikey=$IKEY" \
	$URL/import/create.php;

elif [ $1 = 'delete' ]; then
    ssh -t root@lserv01 /root/backup_scheduleit.sh /root/backup_scheduleit.sh
    curl -k -i \
	-F "username=$USER" \
	-F "rn=$RN" \
	-F "ikey=$IKEY" \
	$URL/import/delete.php

elif [ $1 = 'update' ]; then
    ssh -t root@lserv01 /root/backup_scheduleit.sh /root/backup_scheduleit.sh
    curl -k -i \
        -F "rn=5075292d1e3a3" \
        -F "username=$USER" \
	-F "starts_at=2013-03-17 12:00:00" \
	-F "ends_at=2013-03-17 14:00:00" \
        -F "rn=$RN" \
        -F "summary=update successful" \
        -F "description=Really great " \
        -F "contact_info=test@room.ist.ac.at" \
	-F "ikey=$IKEY" \
        $URL/import/update.php

elif [ $1 = 'import' ]; then
    ssh -t root@lserv01 /root/backup_scheduleit.sh /root/backup_scheduleit.sh
    curl -k -i \
    	-f "filename=MyCal.ics"
        -F "username=$USER" \
        -F "contact_info=test@room.ist.ac.at" \
	-F "ikey=$IKEY" \
        $URL/import/icsimport.php
else
    echo $@;

fi
#echo '\n-------------- end request ---------------------\n'


