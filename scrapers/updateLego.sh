#!/bin/sh
cd /home/bruce/Workspace/lego/
node toyworld.js
node warehouse.js
node farmers.js
node trademe.js
mysql lego < updateMainTable.sql
