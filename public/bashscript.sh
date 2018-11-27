#!/bin/bash
PASSWORD=123456
PGPASSWORD=${PASSWORD} pg_restore -h localhost -U postgres -d test -c -O -x -p 5432 --role=tax < surya_muner.backup 2>&1