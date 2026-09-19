#!/bin/bash
set -e

# Ensure we are in the project root directory
PROJECT_ROOT="$(cd "$(dirname "${BASH_SOURCE[0]}")/.." && pwd)"
cd "$PROJECT_ROOT"

docker rm -f wp-db-test || true
docker run --name wp-db-test -e MYSQL_ALLOW_EMPTY_PASSWORD=yes -e MYSQL_DATABASE=wordpress_test -p 33066:3306 -d mysql:8.0

echo "Waiting for mysql to start..."
sleep 15

curl -O https://raw.githubusercontent.com/wp-cli/scaffold-command/main/templates/install-wp-tests.sh
chmod +x install-wp-tests.sh

docker run --rm --link wp-db-test:mysql -v "$PROJECT_ROOT":/app -w /app php:8.1-cli bash -c "
apt-get update && apt-get install -y subversion default-mysql-client default-libmysqlclient-dev && docker-php-ext-install mysqli pdo pdo_mysql && \
curl -sS https://getcomposer.org/installer | php && \
php composer.phar install && \
bash install-wp-tests.sh wordpress_test root '' mysql:3306 latest && \
vendor/bin/phpunit
"

docker rm -f wp-db-test
