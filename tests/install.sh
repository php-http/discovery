#!/bin/bash

gethash() {
    if hash md5sum 2>/dev/null; then
         echo -n "$@" | md5sum | awk '{print $1}'
    else
         echo -n "$@" | md5 | awk '{print $1}'
    fi
}

HASH=`gethash $@`
BUILD_DIR=build/`echo ${HASH::7}`

echo "Using directory: ${BUILD_DIR}"
# Prepare a folder
#rm -rf $BUILD_DIR
mkdir -p $BUILD_DIR

# Init composer
composer init --working-dir $BUILD_DIR --no-interaction
composer req --working-dir $BUILD_DIR php-http/discovery --no-update

# Define packages from arguments
composer req --working-dir $BUILD_DIR $3

# Copy the current version of php-http/discovery
cp -R src $BUILD_DIR/vendor/php-http/discovery
cd $BUILD_DIR

# Run PHP and check exit code
php -r "require 'vendor/autoload.php'; ${2}" > /dev/null
PHP_EXIT_CODE=$?

# Print result
echo ""
echo ""
if [ $PHP_EXIT_CODE -eq 0 ]; then
    echo "We found a package"
else
    echo "We did not find anything"
fi

echo ""
if [ "$1" = "will-find" ]; then
    exit $PHP_EXIT_CODE;
elif [ $PHP_EXIT_CODE -ne 0 ]; then
    exit 0
fi

echo "We did find a class but we were not supposed to"
echo ""
exit 1
