#!/bin/bash
# Build the LTPP-CODE-RUN single-file binary.
# Requires PHP 8.2 with phar.readonly=0 on the build host.
php webman build:bin 8.2
php webman build:bin 8.2
./sh/bin_up.sh
