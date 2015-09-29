var http = require('http'),
    Sequelize = require('sequelize')
  , sequelize = new Sequelize('lego', 'root', ''),
  cheerio = require('cheerio');
 
var toyworld = sequelize.define('Toyworld', {
  lego_id: {type: Sequelize.INTEGER, unique: true},
  image: Sequelize.STRING,
  link: Sequelize.STRING,
  title: Sequelize.STRING,
  price: Sequelize.DECIMAL(10, 2)
 },{tableName: 'Toyworld'}),
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
	

	for (i = 1; i <= 3 ; i++)
	{
		(function (item) {
			setTimeout(function() {
				getPage(item);
			}, 2000*item);
		})(i)
		
	}
	 
})

function saveToyworldData(data) {
	console.log('Saving '+data.lego_id+' :: '+data.title);
    var ph = {
        lego_id: data.lego_id,
        price: data.price,
        source: 'toyworld'
    };
    pricehistory.findOrCreate({lego_id: ph.lego_id, source: ph.source, price: ph.price}, ph).success(function (obj, created) {
            if (!created) { obj.save(); }
        });
	toyworld.findOrCreate({ lego_id: data.lego_id }, data).success(function (row) {
		
		row.price = data.price;
		row.save();
	});
}
function getPage(page) {

	page = page ? page : 1;



	grabURL(
		'www.toyworld.co.nz',
		'/category/building-sets-and-blocks/lego/?limit=168&p='+page,
		function (str) {
			console.log(' - Loaded! Page '+page+' .. processing');
			processPage(str);

		}
	);
	

}
function processPage(data) {
	var $ = cheerio.load(data),
        items = $('.item'),
        item, 
        lego_id;
    for (i = 0; i < items.length; i++)
	{
		item = {};
		item.title = items.eq(i).find('.product-name').text();
		item.image = items.eq(i).find('img').eq(0).attr('src');
		item.link = items.eq(i).find('a').eq(0).attr('href');
		item.price = items.eq(i).find('.special-price').length ? items.eq(i).find('.special-price').text() : items.eq(i).find('.regular-price').text();
		item.price = item.price.trim().substr(3); // price is NZ$0.00
		lego_id = /([0-9]{4,5})/.exec(item.title)
		item.lego_id = lego_id ? lego_id[0] : null;
		if (item.lego_id) {
			saveToyworldData(item);
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

