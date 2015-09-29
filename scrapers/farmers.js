var http = require('http'),
    Sequelize = require('sequelize')
  , sequelize = new Sequelize('lego', 'root', ''),
  cheerio = require('cheerio');
 
var farmers = sequelize.define('Farmers', {
  lego_id: {type: Sequelize.INTEGER, unique: true},
  image: Sequelize.STRING,
  link: Sequelize.STRING,
  title: Sequelize.STRING,
  price: Sequelize.DECIMAL(10, 2)
 },{tableName: 'Farmers'}),
    pricehistory = sequelize.define(
    'PriceHistory', 
    {
        lego_id: Sequelize.INTEGER,
        source: Sequelize.STRING,
        price: Sequelize.DECIMAL(10, 2)
    },
    {
        tableName: 'PriceHistory'
    }
);
 
sequelize.sync().success(function() {
	
	var pages = [
		'/toys/GroupSize.ManufacturerName-0-ManufacturerName-Lego?SearchTerm=%22Lego%22',
	];
	for (i = 0; i < pages.length ; i++)
	{
		(function (page, item) {
			setTimeout(function() {
				getPage(page);
			}, 2000*item);
		})(pages[i],i)
		
	}
	 
})

function savefarmersData(data) {
	console.log('Saving '+data.lego_id+' :: '+data.title);
    var ph = {
        lego_id: data.lego_id,
        price: data.price,
        source: 'farmers'
    };
    pricehistory.findOrCreate({lego_id: ph.lego_id, source: ph.source, price: ph.price}, ph).success(function (obj, created) {
            if (!created) { obj.save(); }
        });
	farmers.findOrCreate({ lego_id: data.lego_id }, data).success(function (row) {
		
		row.price = data.price;
		row.save();
	});
}
function getPage(page) {

	page = page ? page : 1;



	grabURL(
		'www.farmers.co.nz',
		page,
		function (str) {
			console.log(' - Loaded! Page '+page+' .. processing');
			processPage(str);

		}
	);
	

}
function processPage(data) {
	var $ = cheerio.load(data),
        items = $('.product-list-item'),
        item, 
        lego_id;
    for (i = 0; i < items.length; i++)
	{
		item = {};
		item.title = items.eq(i).find('.ish-productTitle').text().trim();
		item.image = items.eq(i).find('.ish-product-photo img').eq(0).attr('src');
		item.link = items.eq(i).find('a').eq(0).attr('href');
		item.price = items.eq(i).find('.ish-priceContainer-salePrice').text();
		item.price = item.price.replace('$','').trim();
		lego_id = /([0-9]{4,5})/.exec(item.title)
		item.lego_id = lego_id ? lego_id[0] : null;
		if (item.lego_id) {
			savefarmersData(item);
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

