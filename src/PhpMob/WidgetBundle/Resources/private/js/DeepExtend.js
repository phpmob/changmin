var DeepExtend = function(destination, source) {
    var property;
    for (property in source) {
        if (source[property] && source[property].constructor &&
            source[property].constructor === Object) {
            destination[property] = destination[property] || {};
            DeepExtend(destination[property], source[property]);
        } else {
            destination[property] = source[property];
        }
    }

    return destination;
};
