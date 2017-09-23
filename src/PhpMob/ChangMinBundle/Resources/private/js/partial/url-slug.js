(function() {
    'use strict';

    function URLSlug(text, truncate) {
        // Regex for finding the nonsafe URL characters (many need escaping): & +$,:;=?@"#{}|^~[`%!'<>]./()*\
        var nonsafeChars = /[& +$,:;=?@"#{}|^~[`%!'<>\]\.\/\(\)\*\\]/g,
            urlText;

        // Note: we trim hyphens after truncating because truncating can cause dangling hyphens.
        // Example string:                                  // " ⚡⚡ Don't forget: URL fragments should be i18n-friendly, hyphenated, short, and clean."
        urlText = text.trim()
            .replace(/\'/gi, '')
            .replace(nonsafeChars, '-')
            .replace(/-{2,}/g, '-')
            .substring(0, truncate)
            .replace(/^-+|-+$/gm, '')
            .toLowerCase()
        ;

        return urlText || text;
    };

    window.URLSlug = URLSlug;
})();
