#!/bin/bash
# Install test framework
pip install tavern

# Start local php server as a background thread
nohup php -S localhost:8080 ../source/lib/public/index.php &> /dev/null &
phpServerId=$!

# Run the tests
tavern-ci ./test_errors.tavern.yaml

# Stop the server
kill -3 $phpServerId
