var http = require('http'),

  cheerio = require('cheerio');
 

 


	for (i = 1; i <= 18 ; i++)
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
		'sego.co.nz',
		'/lego-sets.html?limit=25&p='+page,
		function (str) {
			console.log(' - Loaded! Page '+page+' .. processing');
			processPage(str);

		}
	);
	

}
function processPage(data) {
	var $ = cheerio.load(data),
        items = $('li.item'),
        item, 
        lego_id;
    for (i = 0; i < items.length; i++)
	{
		item = {};
		item.title = items.eq(i).find('.product-name').text().trim();
		item.image = items.eq(i).find('img').eq(0).attr('src');
		item.link = items.eq(i).find('a').eq(0).attr('href');
		item.price = items.eq(i).find('.special-price').length ? items.eq(i).find('.special-price .price').text() : items.eq(i).find('.regular-price').text();

		item.price = item.price.trim().substr(3); // price is NZ$0.00
		lego_id = /([0-9]{4,5})/.exec(item.title)
		item.set_id = lego_id ? lego_id[0] : null;
        item.store = 'sego';
		item.in_stock = true;
		if (items.eq(i).text().indexOf('Out of stock') >= 0) {
			item.in_stock = false;
		}
		if (
			item.title.indexOf('set of 16') >= 0 // remove minifigure sets
		) {
			item.set_id = false;
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

