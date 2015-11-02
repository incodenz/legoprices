var http = require('https'),
	dimensions = require('./dimensions');
  cheerio = require('cheerio');
 

 


	for (i = 1; i <= 1 ; i++)
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
		'shop.jbhifi.co.nz',
		'/support.aspx?q=lego%20dimensions&source=all&sort=&plow=0&phigh=0&len=50&instock=0&onsale=0&page='+page,
		function (str) {
			console.log(' - Loaded! Page '+page+' .. processing');
			processPage(str);

		}
	);
	

}

function processPage(data) {
	var $ = cheerio.load(data),
        items = $('.product_list'),
        item, 
        lego_id;
    for (i = 0; i < items.length; i++)
	{
		item = {};
		item.title = items.eq(i).find('.title_list').text().trim();
		item.image = items.eq(i).find('img').eq(0).attr('src');
		item.link = 'https://shop.jbhifi.co.nz'+items.eq(i).find('a').eq(0).attr('href');
		item.price = items.eq(i).find('.price_list').text();
		var re = /\$[\s]*([0-9\.]+)/;
		item.price = item.price.trim().match(re)[1];

		// check to see if we have a dimensions product
		item.title = dimensions.reformatTitle(item.title);
		
		lego_id = /([0-9]{4,5})/.exec(item.title)
		item.set_id = lego_id ? lego_id[0] : null;
        item.store = 'jbhifi';
		/*item.in_stock = false;
		if (items.eq(i).find('.delivery').text().indexOf('In stock') >= 0) { // instock
			item.in_stock = true;
		}*/

			if (item.set_id) {
				console.log(
					JSON.stringify(item)
				);
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

