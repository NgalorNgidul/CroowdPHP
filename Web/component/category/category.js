$(function () {
    var icl = "";
    $('#all-project-cat').html(icl);
    $('#all-paging-cat').html(icl);
    var type = window.location.hash.substr(1);
    var cat = getUrlParameter('cat');
    if (type === "") {
        type = 0;
    }

    drawPage(cat, type);
});

$("#all-paging-cat").on('click', 'li', function () {
//    alert('test');
    var icl = "";
    $('#all-project-cat').html(icl);
    $('#all-paging-cat').html(icl);
    var start = $(this).attr('id');
    var cat = getUrlParameter('cat');
    drawPage(cat, start);
});

function getUrlParameter(sParam)
{
    var sPageURL = window.location.search.substring(1);
    var sURLVariables = sPageURL.split('&');
    for (var i = 0; i < sURLVariables.length; i++)
    {
        var sParameterName = sURLVariables[i].split('=');
        if (sParameterName[0] == sParam)
        {
            return sParameterName[1];
        }
    }
}


function drawPage(cat, index) {
//    console.log("Draw Page with index " + index);
    $.ajax({
        type: "get",
        url: "http://api.croowd.co.id/prospect/listallbycat/" + cat + "/" + index,
        dataType: 'json',
        success: function (data) {
            var ln = data.prospects.length;
            var ctPages = data.pages.length;
            var pageLast = data.pages.length - 1;
            var include = '<div class="grid_12 wrap-title">';
            include += '<h3 class="common-title" style="margin-bottom: 10px;">Kategori <span class="fc-orange"> ' + cat + ' </span></h3>';
            include += '</div>';
            var pages = '';

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

            pages = pages + '<li id="' + data.pages[0].start + '"><a href="#' + data.pages[0].start + '">First</a></li>';
            for (var j = 0; j < ctPages; j++) {
                var page = data.pages[j];

                pages = pages + '<li id="' + page.start + '"><a href="#' + page.start + '">' + page.page + '</a></li>';

            }
            pages = pages + '<li id="' + data.pages[pageLast].start + '"><a href="#' + data.pages[pageLast].start + '">Last</a></li>';

            $('#all-project-cat').append(include);
            $('#all-paging-cat').append(pages);
        }
    });
}
