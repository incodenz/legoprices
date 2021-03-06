var http = require('https'),
	dimensions = require('./dimensions');
  cheerio = require('cheerio');
 

 


	for (i = 1; i <= 12 ; i++)
	{
		(function (item) {
			setTimeout(function() {
				getNormalPage(item);
			}, 2000*item);
		})(i)
		
	}
	for (i = 1; i <= 2 ; i++)
	{
		(function (item) {
			setTimeout(function() {
				getDimesionPage(item);
			}, 2500*item);
		})(i)

	}

function getNormalPage(page) {

	page = page ? page : 1;



	grabURL(
		'www.mightyape.co.nz',
		'/Toys/LEGO/All?page='+page,
		function (str) {
			console.log(' - Loaded! Page '+page+' .. processing');
			processPage(str);

		}
	);
	

}
function getDimesionPage(page) {
	page = page ? page : 1;
	grabURL(
		'www.mightyape.co.nz',
		'/Games/Xbox-One/LEGO-Dimensions-Characters/All?page='+page,
		function (str) {
			console.log(' - Loaded! Page '+page+' .. processing');
			processPage(str);

		}
	);
}
function processPage(data) {
	var $ = cheerio.load(data),
        items = $('.products .product'),
        item, 
        lego_id;
    for (i = 0; i < items.length; i++)
	{
		item = {};
		item.title = items.eq(i).find('a.title').text().trim();
		if (item.title == 'LEGO Legends of Chima - Lion Tribe (70224)') {
			item.title = 'LEGO Legends of Chima - Lion Tribe (70229)';
		}
		item.image = items.eq(i).find('img').eq(0).attr('src');
		item.link = 'https://www.mightyape.co.nz'+items.eq(i).find('a').eq(0).attr('href');
		item.price = items.eq(i).find('.price .price').text();
		item.price = item.price.trim().substr(1); // price is $0.00

		// check to see if we have a dimensions product
		item.title = dimensions.reformatTitle(item.title);

		lego_id = /([0-9]{4,5})/.exec(item.title)
		item.set_id = lego_id ? lego_id[0] : null;
        item.store = 'mightyape';
		item.in_stock = false;
		if (items.eq(i).find('.delivery').text().indexOf('In stock') >= 0) { // instock
			item.in_stock = true;
		}
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

