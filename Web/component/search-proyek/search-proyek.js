$(function () {
//    $('#messagefieldmax').hide();
//    itemTerm();
//    var getOption = $.parseJSON('{"mDec": 0}');
//    $('#txt_get_loan').autoNumeric('init', getOption);


    listItem(0);


});


//
//function listItem(tambah) {
//    var param = $('#sys_txt_keyword').val();
//    $('#showmoreresults').html('Loading...');
//
//    $.ajax({
//        type: "get",
//        url: "index2.php",
//        data: 'content=search-proyek&parameter=' + param + '&more=0',
//     //   dataType: 'json',
//        success: function (data) {
//        alert(data);
//            $('#listsearchjax').append(data);
//        }
//    });
//    return false;
//}


function listItem(tambah) {
    var param = $('#sys_txt_keyword').val();
    $('#showmoreresults').html('Loading...');

    $.ajax({
        type: "get",
        url: "index2.php",
        data: 'content=search-proyek&parameter=' + param + '&more=0',
        dataType: 'json',
        success: function (data) {
        //    alert("tes");
            //    alert(data);
            $('#showmoreresults').html('Tunjukkan hasil yang lain');
            var totalitem = data.length;
       //     alert(totalitem);
            $('#recordall').html(totalitem);
            var include = '<div class="list-project-result" id="list-search-ajax">';

            var nextitem = $('#nextitem').val();
            var previtem = $('#previtem').val();

            var nextfield = parseFloat(nextitem) + parseFloat(tambah);
            $('#nextitem').val(nextfield);
            var next = $('#nextitem').val();

            var prevfield = parseFloat(previtem) + parseFloat(tambah);
            $('#previtem').val(prevfield);
            var prev = $('#previtem').val();
            //  alert(data);
            //    for (var i = prev; i < next; i++) {
            //       var no = parseInt(i) + parseInt(1);

            //          $.each(data, function (i, n) {
            //             var no = parseFloat(i) + 1;
            
         //   var totalitems = $('#totalitem').val();
           
            if(next > totalitem){
                next = totalitem;
             
            }
            for (var i = prev; i < next; i++) {
                var no = parseInt(i) + parseInt(1);
                var item = data[i];
                //  alert(item.smallImage);

                include = include + '<div class="project-short larger">';
                include = include + '<div class="top-project-info">';
                include = include + '<div class="content-info-short clearfix">';
                include = include + '<a class="thumb-img" href="?content=project&id=' + item.id + '">';
                include = include + '<img alt="$TITLE" src="' + item.smallImage + '">';
                include = include + '</a>';
                include = include + '<div class="wrap-short-detail">';
                include = include + '<h3 class="rs acticle-title"><a href="?content=project&id=' + item.id + '" class="be-fc-orange">' + item.title + '</a></h3>';
                include = include + '<p class="rs tiny-desc">oleh <a class="fw-b fc-gray be-fc-orange" href="?content=profile&id=' + item.ownerId + '">' + item.ownerName + '</a> in <span class="fw-b fc-gray">' + item.location + ', ' + item.province + '</span></p>';
                include = include + '<p class="rs title-description">' + item.shortDescription + '</p>';
                include = include + '</div>';
                include = include + '<p class="rs clearfix comment-view">';
                include = include + '<a class="fc-gray be-fc-orange" href="#">75 Komentar</a>';
                include = include + '<span class="sep">|</span>';
                include = include + '<a class="fc-gray be-fc-orange" href="#">378 Dilihat</a>';
                include = include + '</p>';
                include = include + '</div>';
                include = include + '</div>';
                include = include + '<div class="bottom-project-info clearfix">';
                include = include + '<div class="project-progress sys_circle_progress" data-percent="' + item.pledgedPersentage + '">';
                include = include + '<div class="sys_holder_sector"></div>';
                include = include + '</div>';
                include = include + '<div class="group-fee clearfix">';
                include = include + '<div class="fee-item">';
                include = include + '<p class="rs lbl">Investor</p>';
                include = include + '<span class="val">270</span>';
                include = include + '</div>';
                include = include + '<div class="sep"></div>';
                include = include + '<div class="fee-item">';
                include = include + '<p class="rs lbl">Target</p>';
                include = include + '<span class="val">Rp. ' + moneyFormats(item.principal) + '</span>';
                include = include + '</div>';
                include = include + '<div class="sep"></div>';
                include = include + '<div class="fee-item">';
                include = include + '<p class="rs lbl">Hari Tersisa</p>';
                include = include + ' <span class="val">' + item.remainingDay + '</span>';
                include = include + '</div>';
                include = include + '</div>';
                include = include + '<a href="?content=project&id=' + item.id + '" class="btn btn-red btn-buck-project">Buck Proyek Ini</a>';
                include = include + '<div class="clear"></div>';
                include = include + '</div>';
                include = include + '</div>';
                
               
                if (no == next) {
                    break;
                } else {

                }

            }
            include = include + '</div>';
            
            $('#listsearchjax').append(include);
             progress();
        }
    });
    //  alert(next);


    return false;
}



function progress(){
  //  alert("masuk");
    var values = [];
    $(".sys_circle_progress").each(function () {
		if (!$(this).find('.sys_holder_sector').text()) {
			var getDonePercent = parseInt($(this).attr("data-percent"));
			var getPendingPercent = 100 - getDonePercent;
			if(getPendingPercent==0){
				values[0] = getDonePercent;
			}else{
				values[0] = getPendingPercent;
				values[1]=getDonePercent;
			}
			Raphael($(this).find(".sys_holder_sector")[0], 78, 78).pieChart(39, 39, 39, values, "#cecece");
			$(this).append('<span class="val-progress">' + $(this).attr("data-percent") + '%</span>');
		}
    });
}
