var http = require('http'),
  cheerio = require('cheerio');





	var pages = [
		'/toys/lego-construction/SortingAttribute-ArrivalDate-desc-PageSize-100',
		'/toys/lego-construction/Page-1-SortingAttribute-ArrivalDate-desc-PageSize-100',
		'/toys/lego-construction/Page-2-SortingAttribute-ArrivalDate-desc-PageSize-100',
		'/toys/lego-construction/Page-3-SortingAttribute-ArrivalDate-desc-PageSize-100',
		'/toys/lego-construction/Page-4-SortingAttribute-ArrivalDate-desc-PageSize-100',
		'/toys/lego-construction/Page-5-SortingAttribute-ArrivalDate-desc-PageSize-100',
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
		'www.farmers.co.nz',
		page,
		function (str) {
			//console.log(' - Loaded! Page '+page+' .. processing');
			processPage(str);

		}
	);
	

}
function processPage(data) {
	var $ = cheerio.load(data),
        items = $('.ish-productList-item'),
        item, 
        lego_id;
    for (i = 0; i < items.length; i++)
	{
		item = {};
		item.title = items.eq(i).find('.ish-productTitle').text().trim();
		item.image = items.eq(i).find('.ish-product-photo img').eq(0).attr('src');
		item.link = items.eq(i).find('a').eq(0).attr('href');
		item.price = items.eq(i).find('.ish-priceContainer-salePrice .new-price').text();
		if (!item.price) {
			item.price = items.eq(i).find('.ish-priceContainer-salePrice .intro-new-price').text().toUpperCase().replace('NOW', '');
		}
		if (!item.price) {
			item.price = items.eq(i).find('.ish-priceContainer-salePrice .std-price').text();
		}
		if (!item.price) {
			item.price = items.eq(i).find('.ish-priceContainer-salePrice').text();
		}
		item.price = item.price.replace('$','').trim();
		lego_id = /([0-9]{4,5})/.exec(item.title)
		item.set_id = lego_id ? lego_id[0] : null;
		item.store = 'farmers';
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

