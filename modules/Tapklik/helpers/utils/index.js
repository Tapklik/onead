function Utils() {

    return this;
}

Utils.prototype.getUuidLength = function (uuid, length, startAt) {
    if(!startAt) startAt = 0;

    return uuid.slice(startAt, length);
}

exports.install = function (vue, config)
{
    Vue.prototype.$utils = new Utils();
}
