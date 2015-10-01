var http = require('http'),
    cheerio = require('cheerio'),
    url = require('url'),
    BASEURL = 'www.thewarehouse.co.nz';

    
    var pages = [
        /*'/red/catalog/toys/lego/city',
        '/red/catalog/toys/lego/classic',
        '/red/catalog/toys/lego/creator',
        '/red/catalog/toys/lego/disney-princess',
        '/red/catalog/toys/lego/duplo',
        '/red/catalog/toys/lego/elves',
        '/red/catalog/toys/lego/exclusives',
        '/red/catalog/toys/lego/friends',
        '/red/catalog/toys/lego/juniors',
        '/red/catalog/toys/lego/ninjago',
        '/red/catalog/toys/lego/pirates',
        '/red/catalog/toys/lego/scooby-doo',
        '/red/catalog/toys/lego/speed-champions',
        '/red/catalog/toys/lego/technic',
        '/red/catalog/toys/lego/ultra-agents',
        '/red/catalog/toys/lego/star-wars',
        '/red/catalog/toys/lego/marvel-super-heroes',
        '/red/catalog/toys/lego/dc-super-heroes',*/
        'search.thewarehouse.co.nz/search?p=KK&srid=S10-AUSYDR02&lbc=thewarehouse&ts=custom&isort=score&view=grid&w=Lego&rk=1&cnt=100',
        'search.thewarehouse.co.nz/search?p=KK&srid=S10-AUSYDR02&lbc=thewarehouse&ts=custom&isort=score&view=grid&w=Lego&rk=1&cnt=100&srt=100',
        'search.thewarehouse.co.nz/search?p=KK&srid=S10-AUSYDR02&lbc=thewarehouse&ts=custom&isort=score&view=grid&w=Lego&rk=1&cnt=100&srt=200',
        'search.thewarehouse.co.nz/search?p=KK&srid=S10-AUSYDR02&lbc=thewarehouse&ts=custom&isort=score&view=grid&w=Lego&rk=1&cnt=100&srt=300',
        'search.thewarehouse.co.nz/search?p=KK&srid=S10-AUSYDR02&lbc=thewarehouse&ts=custom&isort=score&view=grid&w=Lego&rk=1&cnt=100&srt=400',
        'search.thewarehouse.co.nz/search?p=KK&srid=S10-AUSYDR02&lbc=thewarehouse&ts=custom&isort=score&view=grid&w=Lego&rk=1&cnt=100&srt=500',

    ];
    for (i = 0; i < pages.length ; i++)
    {
        (function (page, item) {
            setTimeout(function() {
                getPage(page);
            }, 2000*item);
        })(pages[i],i)
        
    }
     

function getPage(page) {

	page = page ? page : 1;

    var host = BASEURL;
    if (page.indexOf('search.thewarehouse.co.nz') >= 0) {
        host = 'search.thewarehouse.co.nz';
        page = page.replace(host, '');
    }

	grabURL(
        host,
		page,
		function (str) {
			console.log(' - Loaded! Page '+page+' .. processing');
			processPage(str);

		}
	);
	

}
function processPage(data) {
	var $ = cheerio.load(data),
        //items = $('.horizontal'),
        items = $('.sli_grid_result'),
        item,
        lego_id;
    for (i = 0; i < items.length; i++)
	{
		item = {};
		//item.title = items.eq(i).find('.description').text().trim();
		item.title = items.eq(i).find('.sli_h2').text().trim();
        if (item.title.indexOf('...') >= 0) {
            //item.title = items.eq(i).find('.product img').eq(0).attr('alt');
            item.title = items.eq(i).find('.sli_grid_image a').eq(0).attr('title');
        }
		//item.image = BASEURL+items.eq(i).find('.product img').eq(0).attr('src');
		item.image = items.eq(i).find('.sli_grid_image img').eq(0).attr('src');
		//item.link = BASEURL+items.eq(i).find('a').eq(0).attr('href');
		item.link = items.eq(i).find('.sli_h2 a').eq(0).attr('href');
        var q = url.parse(item.link).query;
        item.link = q && q.url ? q.url : item.link;
		//item.price = items.eq(i).find('.price').text();
		item.price = items.eq(i).find('.sli_grid_price').text();
		item.price = item.price.toUpperCase().replace('NOW', '').replace('$','').trim();
		lego_id = /([0-9]{4,5})/.exec(item.title);
		item.set_id = lego_id ? lego_id[0] : null;
        // check if in stock ...
        item.in_stock = false;
        if (items.eq(i).find('.sli_cart_button').find('input').length) {
            item.in_stock = false;
        }
        if (item.set_id) {
            item.store = 'warehouse';
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

