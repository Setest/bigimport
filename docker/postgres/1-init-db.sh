#!/bin/bash
set -e

psql -v ON_ERROR_STOP=1 --username "$POSTGRES_USER" --dbname "$POSTGRES_DB" <<-EOSQL
    CREATE USER $DB_USER_NAME WITH ENCRYPTED PASSWORD '$DB_USER_PASSWORD';

    CREATE DATABASE "$DB_NAME";

    GRANT ALL PRIVILEGES ON DATABASE $DB_NAME TO $DB_USER_NAME;

EOSQL