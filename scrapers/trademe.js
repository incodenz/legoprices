var http = require('http'),
    Sequelize = require('sequelize')
  , sequelize = new Sequelize('lego', 'root', '')
 
var trademe = sequelize.define('Trademe', {
  trademe_id: { type: Sequelize.INTEGER.UNSIGNED, unique: true},
  lego_id: Sequelize.INTEGER,
  image: Sequelize.STRING,
  title: Sequelize.STRING,
  subtitle: Sequelize.STRING,
  price: Sequelize.DECIMAL(10, 2),
  start_price: Sequelize.DECIMAL(10, 2),
  buy_now: Sequelize.DECIMAL(10, 2),
  max_bid: Sequelize.DECIMAL(10, 2)
 }, {tableName: 'Trademe'});
 
sequelize.sync().success(function() {
	
/*
  User.create({
    username: 'sdepold',
    birthday: new Date(1986, 06, 28)
  }).success(function(sdepold) {
    console.log(sdepold.values)
  })
*/
	for (i = 1; i <= 25 ; i++)
	{
		(function (item) {
			setTimeout(function() {
				getPage(item);
			}, 2000*item);
		})(i)
		
	}
	 
})
function parseData(items) {
	for (i = 0; i < items.length; i++)
	{
		if (items[i].Title.toLowerCase().indexOf('banbao') < 0) {
			lego_id = /([0-9]{4,5})/.exec(items[i].Title)
			lego_id = lego_id ? lego_id[0] : null;
			saveTrademeData({
				trademe_id: items[i].ListingId,
				title: items[i].Title,
				subtitle: items[i].Subtitle ? items[i].Subtitle : null,
				image: items[i].PictureHref ? items[i].PictureHref : null,
				price: items[i].BuyNowPrice ? items[i].BuyNowPrice : (items[i].MaxBidAmount ? items[i].MaxBidAmount : items[i].StartPrice),
                start_price: items[i].StartPrice ? items[i].StartPrice : null,
                buy_now: items[i].BuyNowPrice ? items[i].BuyNowPrice : null,
                max_bid: items[i].MaxBidAmount ? items[i].MaxBidAmount : null,
				lego_id: lego_id
			});
		}
	}
	
}
function saveTrademeData(data) {
	console.log('Saving '+data.lego_id+' :: '+data.title);
	trademe.findOrCreate({ trademe_id: data.trademe_id }, data).success(function (row) {
		
		row.price = data.price;
        row.buy_now = data.buy_now;
        row.max_bid = data.max_bid;
		row.save();
	});;
}
function getPage(page) {

	page = page ? page : 1;

	var options = {
	  hostname: 'api.trademe.co.nz',
//	  port: app.get('port'),
	  path: '/v1/Search/General.json?category=0347-0923-1191-6804-&page='+page,
	  method: 'GET',
	  headers: { 'Content-Type': 'application/json' }
	};
	
	var resp = '',
		req = http.request(options, function(res) {
	  res.setEncoding('utf8');
	  res.on('data', function (data) {
		  resp += data;
	  });
	  res.on('end', function () {
		  console.log('Finished request for page '+page);
		  //console.log(resp);
		   var data = JSON.parse(resp);
		   if (data && data.List) {
			   parseData(data.List);
		   }
	  });
	});
	req.on('error', function(e) {
	  console.log('problem with request: ' + e.message);
	});
	req.end();
}
