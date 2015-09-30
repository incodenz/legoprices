var http = require('https'),

  cheerio = require('cheerio');
 

 


	for (i = 1; i <= 30 ; i++)
	{
		(function (item) {
			setTimeout(function() {
				getPage(item);
			}, 2000*item);
		})(i)
		
	}


function getPage(page) {

	page = page ? page : 1;



	grabURL(
		'www.toyco.co.nz',
		'/lego?brand=7&page='+page+'&q=false&sort=popularity',
		function (str) {
			console.log(' - Loaded! Page '+page+' .. processing');
			processPage(str);

		}
	);
	

}
function processPage(data) {
	var $ = cheerio.load(data),
        items = $('.categ-item'),
        item, 
        lego_id;
    for (i = 0; i < items.length; i++)
	{
		item = {};
		item.title = items.eq(i).find('.cutoff.centertext').text().trim();
		item.image = items.eq(i).find('img').eq(0).attr('src');
		item.link = 'https://www.toyco.co.nz'+items.eq(i).find('a').eq(0).attr('href');
		item.price = items.eq(i).find('.centertext .red').length ? items.eq(i).find('.centertext .red').text() : items.eq(i).find('.grey').text();
		item.price = item.price.trim().substr(1); // price is $0.00
		lego_id = /([0-9]{4,5})/.exec(item.title)
		item.set_id = lego_id ? lego_id[0] : null;
        item.store = 'toyco';
		if (items.eq(i).find('.addtocart')) { // instock
			if (item.set_id) {
				console.log(
					JSON.stringify(item)
				);
			}
		}
	}
	
}
function grabURL(host, path, cb, params) {
    params = params ? params : {};
    http.request({
        host: host,
        path: path
    }, function (res) {
        var str = '';
        if (res.statusCode != 200) {
            console.log('Error: response '+res.statusCode);
            console.log('HEADERS: ' + JSON.stringify(res.headers));
        }
        res.on('data', function (chunk) { str += chunk; });
        res.on('end', function () { cb(str, params); });
    }).end();
}

