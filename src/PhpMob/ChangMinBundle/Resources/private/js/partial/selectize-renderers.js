window['user_avatar_render'] = function (data) {
    return ('<div class="media user-option-render">'
    + '     <div class="d-flex mr-3 avatar"><img class="img-avatar img-avatar-user"/></div>'
    + '     <div class="media-body">'
    + '         <h5 class="mt-0 mb-1">{item.username}</h5>'
    + '         {item.email}'
    + '     </div>'
    + '</div>').xTemplate(data);
};
