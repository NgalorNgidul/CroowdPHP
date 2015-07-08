$(function () {
    drawPage(0);
});

$("#all-paging li").click(function () {
    var icl = "";
    $('#all-project').html(icl);
    var start = $(this).attr('id');
//    alert(this.id); // id of clicked li by directly accessing DOMElement property
//    alert(); // jQuery's .attr() method, same but more verbose
//    alert($(this).html()); // gets innerHTML of clicked li
//    alert($(this).text()); // gets text contents of clicked li
    drawPage(start);
});

function drawPage(index) {
//    console.log("Draw Page with index " + index);
    $.ajax({
        type: "get",
        url: "http://api.croowd.co.id/prospect/listall/" + index,
        dataType: 'json',
        success: function (data) {
            var ln = data.prospects.length;
            var include = '<div class="grid_12 wrap-title">';
            include += '<h3 class="common-title" style="margin-bottom: 10px;">Semua <span class="fc-orange">Project</span></h3>';
            include += '</div>';

            for (var i = 0; i < ln; i++) {
                var item = data.prospects[i];
                include = include + '<div class="grid_4">';
                include = include + '<div class="project-short sml-thumb">';
                //TOP SECTION
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
                //TOP END, BOTTOM START
                include = include + '<div class="bottom-project-info clearfix">';
                include = include + '<div class="line-progress">';
                include = include + '<div class="bg-progress">';
                include = include + '<span  style="width: ' + item.pledgedPersentage + '%"></span>';
                include = include + '</div>';
                include = include + '</div>';
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
                include = include + '<span class="val">' + item.remainingDay + '</span>';
                include = include + '</div>';
                include = include + '</div>';
                include = include + '</div>';

                include = include + '</div>';
                include = include + '</div>';
            }

            $('#all-project').append(include);
        }
    });
}
