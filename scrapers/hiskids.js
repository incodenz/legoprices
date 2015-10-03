var http = require('http'),
  cheerio = require('cheerio');





	var pages = [
		'/LEGO-Architecture®',
		'/LEGO-Bricks-and-more',
		'/LEGO-City',
		'/LEGO-Creator',
		'/LEGO-Duplo',
		'/LEGO-Education',
		'/LEGO-Exclusives',
		'/LEGO-Friends',
		'/LEGO-Mindstorms',
	//	'/LEGO-Minifigures',
	//	'/LEGO-Parts',
		'/LEGO-Power-Functions',
		'/LEGO-Star-Wars™',
		'/LEGO-Technic',
		'/LEGO-The-Hobbit™',
		'/LEGO-Trains',
	];
	for (i = 0; i < pages.length ; i++)
	{
		(function (page, item) {
			setTimeout(function() {
				getPage(page);
			}, 2000*item);
		})(pages[i],i);
	}



function getPage(page) {

	page = page ? page : 1;



	grabURL(
		'www.hiskidsbricks.co.nz',
		page,
		function (str) {
			//console.log(' - Loaded! Page '+page+' .. processing');
			processPage(str);

		}
	);
	

}
function processPage(data) {
	var $ = cheerio.load(data),
        items = $('.product-list .three.mobile-two.columns'),
        item, 
        lego_id;
    for (i = 0; i < items.length; i++)
	{
		item = {};
		item.title = items.eq(i).find('.name').text().trim();
		item.image = items.eq(i).find('.img').eq(0).attr('src');
		item.link = items.eq(i).find('a').eq(0).attr('href');
		item.price = items.eq(i).find('.price-new').text();
		if (!item.price) {
			item.price = items.eq(i).find('.price').text();
		}

		item.price = item.price.replace('$','').replace('NZD', '').trim();
		lego_id = /([0-9]{4,5})/.exec(item.title)
		item.set_id = lego_id ? lego_id[0] : null;
		item.store = 'hiskids';

		item.in_stock = items.eq(i).find('.stock').text().indexOf('In stock') >= 0;
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

