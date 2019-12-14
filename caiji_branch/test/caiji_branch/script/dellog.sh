#!/bin/bash
find   /var/log/bat/   -name  "*.log"   -type f -mtime +1   -exec rm -f  {} \;
