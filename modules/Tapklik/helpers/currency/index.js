function Currency() {
    return this;
}

Currency.prototype.seperatorAtThousands = function(number) {
  return number.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,")
}

Currency.prototype.toMicroDollars = function (amount) {
    return (amount) ? amount * 1000000 : 0;
}

Currency.prototype.fromMicroDollars = function (amount) {
    return (amount) ? amount / 1000000 : 0;
}

Currency.prototype.formatNumber = function (value, decimals) {
    if(!decimals) decimals = 2;

    return value.toFixed(decimals);
}

exports.install = function (vue, config) {
    Vue.prototype.$currency = new Currency();
}
