$(function () {
    console.log('Init Popular Project');
    $.ajax({
        type: "get",
        url: "http://api.croowd.co.id/prospect/popular",
        dataType: 'json',
        success: function (data) {
            var ln = data.length;
            var ct = ln < 4 ? ln : 4;
            
            var include = '';
            for (var i = 0; i < ct; i++) {
                var item = data[i];
                include = include + '<div class="grid_3">';
                include = include + '<div class="project-short sml-thumb">';
                //Top Info
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
                include = include + item.location + ', '+ item.province;
                include = include + '</p>';
                include = include + '</div>';
                include = include + '</div>';
                include = include + '</div>';
                //bottom Info
                include = include + '<div class="bottom-project-info clearfix">';
                include = include + '<div class="line-progress">';
                include = include + '<div class="bg-progress">';
                include = include + '<span  style="width: ' + item.pledgedPersentage + '%"></span>';
                include = include + '</div></div>';

                include = include + '<div class="group-fee clearfix">';
                include = include + '<div class="fee-item">';
                include = include + '<p class="rs lbl">Inv</p>';
                include = include + '<span class="val">' + item.pledgedPersentage + '%</span>';
                include = include + '</div>';
                include = include + '<div class="sep"></div>';
                include = include + '<div class="fee-item">';
                include = include + '<p class="rs lbl">Target</p>';
                include = include + '<span class="val">Rp ' + item.principal.toString() + '</span>';
                include = include + '</div>';
                include = include + '<div class="sep"></div>';
                include = include + '<div class="fee-item">';
                include = include + '<p class="rs lbl">Hari</p>';
                include = include + '<span class="val"> ' + item.remainingDay + '</span>';
                include = include + '</div>';
                include = include + '</div>';
                include = include + '</div>';
                //End Container
                include = include + '</div>';
                include = include + '</div>';
            }

            include = include + '<div class="clear"></div>';
            include = include + '</div>';

            $('#popular-project').append(include);
        }
    });
});
