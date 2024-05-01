#!/bin/bash

USER="USERNAME"
PASSWORD="PASSWORD"
DATABASE="banking"
BACKUP_FILE="/home/USER/CPSC254_Project/backup.sql"

mysqldump -u "$USER" -p"$PASSWORD" $DATABASE > "$BACKUP_FILE"