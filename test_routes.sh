#!/bin/bash

# Colors for output
RED='\033[0;31m'
GREEN='\033[0;32m'
NC='\033[0m' # No Color

echo "Testing Laravel Application Routes..."
echo "======================================"

test_route() {
    local method=$1
    local path=$2
    local description=$3
    
    echo -n "Testing $description... "
    response=$(curl -s -w "\n%{http_code}" "$path" 2>&1 | tail -1)
    
    if [[ $response =~ ^[23][0-9]{2}$ ]]; then
        echo -e "${GREEN}OK (HTTP $response)${NC}"
    else
        echo -e "${RED}FAILED (HTTP $response)${NC}"
    fi
}

# Test public routes
test_route "GET" "http://localhost:8000/" "Welcome page"
test_route "GET" "http://localhost:8000/login" "Login page"

# The following require authentication - they'll redirect
echo ""
echo "Authenticated Routes (should redirect to login):"
test_route "GET" "http://localhost:8000/dashboard" "Dashboard"
test_route "GET" "http://localhost:8000/books" "Books list"
test_route "GET" "http://localhost:8000/borrowings" "Borrowing list"
test_route "GET" "http://localhost:8000/fines" "Fines list"

echo ""
echo "======================================"
echo "Route testing complete!"
