#!/bin/bash
set -e

COMPOSE_FILE=".docker/local/compose.yml"
PROJECT_NAME="portfolio_be"

echo "🐳 Checking Docker containers..."

if docker compose -f "$COMPOSE_FILE" -p "$PROJECT_NAME" ps --quiet 2>/dev/null | grep -q .; then
    echo "🛑 Containers are running. Stopping them..."
    docker compose -f "$COMPOSE_FILE" -p "$PROJECT_NAME" down
else
    echo "✅ No running containers found."
fi

echo "🚀 Starting Docker containers..."
docker compose --env-file .env -f "$COMPOSE_FILE" -p "$PROJECT_NAME" up --build -d

echo "📦 Container status:"
docker compose -f "$COMPOSE_FILE" -p "$PROJECT_NAME" ps
