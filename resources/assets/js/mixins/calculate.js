module.exports = {
    methods: {
        calculate(weight, from_country, to_country, priceList) {
            let price,
                _pList = _(priceList).find({
                    from: from_country,
                    to: to_country
                });
            let pList = _pList.prices;

            price = _(pList).find((p)=>{
                return Number(p.from) <= weight && Number(p.to) > weight;
            });

            let p = price.price * weight;

            console.log(_pList.minPrice, p);
            if(p < _pList.minPrice) p = _pList.minPrice;
            return parseInt(p * 100)/100;
        },

        calcDelivery(weight, priceList) {
            let price;
            price = _(priceList).find((p)=>{
                return Number(p.from) <= weight && Number(p.to) > weight;
            });

            return price.price;
        },

        getListByCountries(from, to, list) {
            return _(list).find({
                from: from,
                to: to
            });
        }
    }
};