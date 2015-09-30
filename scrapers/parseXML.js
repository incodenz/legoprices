/**
 * Created by brucealdridge on 30/09/15.
 */
var parser = require('xml2json');
var fs = require('fs');

var xml = fs.readFileSync('test.xml', "utf8");
xml = "<?xml version='1.0' standalone='yes'?>\n"+xml;
var json = parser.toJson(xml); //returns a string containing the JSON structure by default
console.log(json);