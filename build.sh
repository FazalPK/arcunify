#!/bin/sh
# Concatenate CSS sources. No toolchain required.
# Usage: sh build.sh   (run from the theme folder)
set -e
cd "$(dirname "$0")/assets/css"
cat src/0*.css > theme.css
cat src/home-*.css src/pages-*.css > sections.css
echo "Built assets/css/theme.css ($(wc -c < theme.css) bytes) and sections.css ($(wc -c < sections.css) bytes)"
