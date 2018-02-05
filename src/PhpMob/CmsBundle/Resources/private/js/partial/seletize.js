PhpMobCms.inits.push(function (scope) {
    if (typeof ChangMinChooser !== 'undefined') {
        ChangMinChooser('[data-chooser]', scope);
    }
});

window['user_avatar_render'] = function (data) {
    data.item.picture = PhpMobCms.getApiLink(data.item, 'picture_70x70') || PhpMobCms['gif64'];

    return ('<div class="media user-option-render">'
    + '     <div class="d-flex mr-3 avatar"><img class="img-avatar img-avatar-user" src="{item.picture}"/></div>'
    + '     <div class="media-body">'
    + '         <h5 class="mt-0 mb-1">{item.username}</h5>'
    + '         {item.display_name}'
    + '     </div>'
    + '</div>').xTemplate(data);
};
