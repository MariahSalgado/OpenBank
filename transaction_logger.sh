#!/bin/bash

USER="USERNAME"
PASSWORD="PASSWORD"
DATABASE="banking"
LOGFILE="/home/USER/CPSC254_Project/transactions.log"


mysql -u"$USER" -p"$PASSWORD" -D"$DATABASE" -e "SELECT * FROM Transactions;" > "$LOGFILE"
