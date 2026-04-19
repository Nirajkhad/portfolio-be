#!/bin/bash

# Security Configuration Test Script
# This script tests the security features of your Laravel API

echo "🔒 Security Configuration Test"
echo "================================"
echo ""

# Colors
GREEN='\033[0;32m'
RED='\033[0;31m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

# API URL
API_URL="${1:-http://localhost:8000}"
TEST_ENDPOINT="${API_URL}/api/v1/posts"

echo "Testing API at: ${TEST_ENDPOINT}"
echo ""

# Test 1: Security Headers
echo "Test 1: Security Headers"
echo "------------------------"
RESPONSE=$(curl -s -I "${TEST_ENDPOINT}" 2>/dev/null)

check_header() {
    HEADER=$1
    if echo "$RESPONSE" | grep -iq "$HEADER"; then
        echo -e "${GREEN}✓${NC} $HEADER present"
    else
        echo -e "${RED}✗${NC} $HEADER missing"
    fi
}

check_header "X-Frame-Options"
check_header "X-Content-Type-Options"
check_header "X-XSS-Protection"
check_header "Referrer-Policy"
echo ""

# Test 2: CORS Headers
echo "Test 2: CORS Headers"
echo "--------------------"
CORS_RESPONSE=$(curl -s -I -X OPTIONS "${TEST_ENDPOINT}" \
  -H "Origin: http://localhost:3000" \
  -H "Access-Control-Request-Method: GET" 2>/dev/null)

if echo "$CORS_RESPONSE" | grep -iq "Access-Control-Allow-Origin"; then
    echo -e "${GREEN}✓${NC} CORS headers present"
    echo "$CORS_RESPONSE" | grep -i "access-control"
else
    echo -e "${RED}✗${NC} CORS headers missing"
fi
echo ""

# Test 3: Rate Limiting
echo "Test 3: Rate Limiting"
echo "---------------------"
echo "Making 5 requests to test rate limiting..."
for i in {1..5}; do
    STATUS=$(curl -s -o /dev/null -w "%{http_code}" "${TEST_ENDPOINT}" 2>/dev/null)
    RATE_LIMIT=$(curl -s -I "${TEST_ENDPOINT}" 2>/dev/null | grep -i "X-RateLimit" || echo "")
    
    if [ "$STATUS" = "429" ]; then
        echo -e "${YELLOW}Request $i:${NC} HTTP $STATUS (Throttled)"
    else
        echo -e "${GREEN}Request $i:${NC} HTTP $STATUS"
    fi
done
echo ""

# Test 4: API Endpoint
echo "Test 4: API Endpoint Response"
echo "------------------------------"
API_RESPONSE=$(curl -s "${TEST_ENDPOINT}" 2>/dev/null)

if echo "$API_RESPONSE" | grep -q "success"; then
    echo -e "${GREEN}✓${NC} API responding correctly"
    echo "$API_RESPONSE" | head -c 200
    echo "..."
else
    echo -e "${RED}✗${NC} API response unexpected"
    echo "$API_RESPONSE"
fi
echo ""
echo ""

# Summary
echo "================================"
echo "Test Complete!"
echo ""
echo "💡 Tips:"
echo "  - Ensure your Laravel dev server is running (php artisan serve)"
echo "  - Check .env file for security configuration"
echo "  - Review SECURITY_SETUP.md for detailed documentation"
echo ""
echo "📚 Test production security at:"
echo "  - https://securityheaders.com/"
echo "  - https://observatory.mozilla.org/"
