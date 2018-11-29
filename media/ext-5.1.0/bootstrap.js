(function(){
	var scripts = document.getElementsByTagName('script'),
	localhostTests = [
        /^localhost$/,
        /\b(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)(:\d{1,5})?\b/ // IP v4
    ],
    host = window.location.hostname,
    isDevelopment = null,
	queryString = window.location.search,
	test, path, i, ln, scriptSrc, match;

	for (i = 0, ln = scripts.length; i < ln; i++) {
        scriptSrc = scripts[i].src;
        match = scriptSrc.match(/bootstrap\.js$/);

        if (match) {
            path = scriptSrc.substring(0, scriptSrc.length - match[0].length);
            app.EXT_URL = path;
            break;
        }
    }

    if (queryString.match('(\\?|&)debug') !== null) {
        isDevelopment = true;
    } else {
        isDevelopment = false;
    }

    if (isDevelopment === null) {
        for (i = 0, ln = localhostTests.length; i < ln; i++) {
            test = localhostTests[i];

            if (host.search(test) !== -1) {
                isDevelopment = true;
                break;
            }
        }
    }

    if (isDevelopment === null && window.location.protocol === 'file:') {
        isDevelopment = true;
    }

    document.write('<script type="text/javascript" charset="UTF-8" src="' + 
        path + 'ext-all' + (isDevelopment ? '-debug' : '') + '.js"></script>');

    document.write('<script type="text/javascript" charset="UTF-8" src="' + 
        path + 'packages/ext-locale/build/ext-locale-id' + (isDevelopment ? '-debug' : '') + '.js"></script>');

    // document.write('<script type="text/javascript" charset="UTF-8" src="' + 
    //     path + 'packages/ext-theme-neptune-touch/build/ext-theme-neptune-touch' + (isDevelopment ? '-debug' : '') + '.js"></script>');

    // document.write('<link href="' + 
    //     path + 'packages/ext-theme-neptune-touch/build/resources/ext-theme-neptune-touch-all' + (isDevelopment ? '-debug' : '') + '.css" rel="stylesheet">');

    document.write('<script type="text/javascript" charset="UTF-8" src="' + 
        path + 'packages/ext-theme-classic/build/ext-theme-classic' + (isDevelopment ? '-debug' : '') + '.js"></script>');

    document.write('<link href="' + 
        path + 'packages/ext-theme-classic/build/resources/ext-theme-classic-all' + (isDevelopment ? '-debug' : '') + '.css" rel="stylesheet">');
})();