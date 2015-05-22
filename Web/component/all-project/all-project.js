$(function () {
    console.log('Init Latest Project');
    $.ajax({
        type: "get",
        url: "http://api.croowd.co.id/prospect/newcomer",
        dataType: 'json',
        success: function (data) {
            var ln = data.length;
            var ct = ln < 4 ? ln : 4;

            var include = '<div class="lst-popular-project clearfix" style="margin:0px 0px -50px 0px !important;">';
            for (var i = 0; i < ct; i++) {
                var item = data[i];
                include = include + '<div class="grid_3">';
                include = include + '<div class="project-short sml-thumb">';
                include = include + '<div class="top-project-info">';
                include = include + '<div class="content-info-short clearfix">';
                include = include + '<a href="?content=project&id=' + item.id + '" class="thumb-img">';
                include = include + '<img alt="$TITLE" src="' + item.smallImage + '" width="292" height="204" style="height:135px !important;width:204px !important">';
                include = include + '</a>';
                include = include + '<div class="wrap-short-detail">';
                include = include + '<h3 class="rs acticle-title"><a href="?content=project&id=' + item.id + '" class="be-fc-orange">' + item.title + '</a></h3>';
                include = include + '<p class="rs tiny-desc">oleh <a class="fw-b fc-gray be-fc-orange" href="?content=profile&id=' + item.ownerId + '">' + item.ownerName + '</a>';
                include = include + '<p class="rs project-location">';
                include = include + '<i class="icon iLocation"></i>';
                include = include + item.location + ', ' + item.province;
                include = include + '</p>';
                include = include + '</div>';
                include = include + '</div>';
                include = include + '</div>';
                include = include + '</div>';
                include = include + '</div>';
            }

            include = include + '<div class="clear"></div>';
            include = include + '</div>';

            $('#latest-project').append(include);
        }
    });
});
