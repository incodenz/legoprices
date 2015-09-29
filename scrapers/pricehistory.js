var pricehistory = sequelize.define(
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