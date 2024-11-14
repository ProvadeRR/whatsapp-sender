#!/bin/bash
rm -f /tmp/chrome_data/SingletonLock
exec "$@"
