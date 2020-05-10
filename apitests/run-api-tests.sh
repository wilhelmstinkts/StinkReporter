#!/bin/bash
# Start local php server as a background thread
nohup php -S localhost:8080 ../source/index.php &> /dev/null &
phpServerId=$!

# Run the tests
tavern-ci ./test_errors.tavern.yaml
if [ $? != 0 ]; then exit 1; fi
tavern-ci ./test_use_case.tavern.yaml
if [ $? != 0 ]; then exit 1; fi

# Stop the server
kill -3 $phpServerId
