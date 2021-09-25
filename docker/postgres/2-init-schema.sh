#!/bin/bash
set -e

psql -v ON_ERROR_STOP=1 --username "$DB_USER_NAME" --dbname "$DB_NAME" <<-EOSQL
    CREATE TABLE categories
    (
        id         serial PRIMARY KEY,
        title      VARCHAR(12) UNIQUE NOT NULL,
        e_id       INT                NULL,
        created_on TIMESTAMP          NOT NULL DEFAULT NOW()
    );

    CREATE TABLE products
    (
        id         serial PRIMARY KEY,
        e_id       INT                NULL,
        title      VARCHAR(12) UNIQUE NOT NULL,
        price      real               NOT NULL,
        created_on TIMESTAMP          NOT NULL DEFAULT NOW()
    );

    CREATE TABLE categories_products
    (
        category_id int NOT NULL,
        product_id int NOT NULL,
        PRIMARY KEY (category_id, product_id),
        FOREIGN KEY (category_id) REFERENCES categories (id) ON UPDATE CASCADE,
        FOREIGN KEY (product_id) REFERENCES products (id) ON UPDATE CASCADE
    );

EOSQL