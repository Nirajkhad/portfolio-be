#!/bin/sh
set -e

# Load environment variables from .env file
if [ -f .env ]; then
  set -a
  . ./.env
  set +a
fi

# Export current user UID/GID
export APPLICATION_UID=$(id -u)
export APPLICATION_GID=$(id -g)

echo "Using APPLICATION_UID=$APPLICATION_UID and APPLICATION_GID=$APPLICATION_GID for docker-compose"

# Stop and remove all containers (ignore error if no containers exist)
docker stop $(docker ps -aq) 2>/dev/null || true

# Run docker-compose with arguments passed to this script
docker compose -f .docker/local/compose.yml up --build