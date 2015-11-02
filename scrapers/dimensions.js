/**
 * Created by brucealdridge on 2/11/15.
 */
var mysql = require('mysql'),
    fs    = require('fs'),
    sets = [];


var dbFile;
try {
    fs.accessSync('../config/prod/db.php');
    dbFile = fs.readFileSync('../config/prod/db.php', {encoding: 'utf8'});
} catch (err) {
    dbFile = fs.readFileSync('../config/dev/db.php', {encoding: 'utf8'});
}

var re = {
    host: /host=([^;]*)/,
    name: /dbname=([^"]*)/,
    user: /username([^>]*)>\s?'([^']*)/,
    pass: /password([^>]*)>\s?'([^']*)/
};



var dbConfig = {
    host: dbFile.match(re.host)[1],
    name: dbFile.match(re.name)[1],
    user: dbFile.match(re.user)[2],
    pass: dbFile.match(re.pass)[2]
};

var connection = mysql.createConnection({
    host     : dbConfig.host,
    user     : dbConfig.user,
    password : dbConfig.pass,
    database : dbConfig.name
});
connection.connect();

connection.query('SELECT ls.code, ls.title FROM lego_set ls INNER JOIN theme t ON t.id=ls.theme_id WHERE t.description LIKE "%dimensions%"', function(err, results) {
    if (!err) {
        for(var r in results) {
            if (results.hasOwnProperty(r)) {

                sets.push({
                    set_id: results[r].code,
                    title: results[r].title,
                    cleanTitle: results[r].title.toLowerCase().replace(':', '')
                });
            }
        }
        return;
    }
    console.log(err);
});

exports.reformatTitle = function (title) {
    if (!sets.length) {
        return false;
    }
    var lowerTitle = title.toLowerCase(),
        titleParts = [],
        i,
        j,
        foundAll;

    if (lowerTitle.indexOf('dimensions') >=0 && lowerTitle.indexOf('lego') >= 0) {

        for(i = 0; i < sets.length; i++) {

            titleParts = sets[i].cleanTitle.split(' ');
            foundAll = titleParts.length > 1;


                for (j = 0; j < titleParts.length; j++) {

                    if (lowerTitle.indexOf(titleParts[j]) >= 0) {
                        foundAll = foundAll && true;
                    } else {
                        foundAll = false;
                    }
                }
                if (foundAll) {
                    return sets[i].set_id + ' ' + sets[i].title;
                }

        }
    }
    return title;
};