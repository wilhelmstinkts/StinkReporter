#!/bin/sh

cd $(dirname "$0")

tavern-ci ./test_errors.tavern.yaml
if [ $? != 0 ]; then exit 1; fi
tavern-ci ./test_use_case.tavern.yaml
if [ $? != 0 ]; then exit 1; fi
