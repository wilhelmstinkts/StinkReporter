#!/bin/bash
docker exec mysql mysql -uroot -ptotallyunsafe --execute="\. /commands/create_tables.sql"