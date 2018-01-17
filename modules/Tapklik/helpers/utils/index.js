function Utils() {
    return this;
}

Utils.prototype.getUuidLength = function (uuid, length, startAt) {
    if(!startAt) startAt = 0;

    return uuid.slice(startAt, length);
}

Utils.prototype.getDate = function (days) {
    const toTwoDigits = num => num < 10 ? '0' + num : num;
    let today =  new Date();
    let date = new Date();
    date.setDate(today.getDate() + days);
    let year = date.getFullYear();
    let month = toTwoDigits(date.getMonth() + 1);
    let day = toTwoDigits(date.getDate()); 
    return `${year}-${month}-${day}`;
}

exports.install = function (vue, config)
{
    Vue.prototype.$utils = new Utils();
}
