$(function () {
//    $('#messagefieldmax').hide();
//    itemTerm();
//    var getOption = $.parseJSON('{"mDec": 0}');
//    $('#txt_get_loan').autoNumeric('init', getOption);
 

    listItem(0);
    

});



function listItem(tambah) {
    var param = $('#sys_txt_keyword').val();
    $('#showmoreresults').html('Loading...');
   
    $.ajax({
        type: "get",
        url: "index2.php",
        data: 'content=search-proyek&parameter='+param+'&more=0',
        //       dataType: 'json',
        success: function (data) {
            
            
             $('#showmoreresults').html('Show More Result');
            var totalitem = data;
            $('#recordall').html(totalitem);
            var include = '<div class="list-project-result" id="list-search-ajax">';

            //  var totalitem = $('#totalitem').val();
            
            var nextitem = $('#nextitem').val();
            var previtem = $('#previtem').val();

            var nextfield = parseFloat(nextitem) + parseFloat(tambah);
            $('#nextitem').val(nextfield);
            var next = $('#nextitem').val();

            var prevfield = parseFloat(previtem) + parseFloat(tambah);
            $('#previtem').val(prevfield);
            var prev = $('#previtem').val();
            //  alert(data);
            for (var i = prev; i < next; i++) {
                var no = parseInt(i) + parseInt(1);
                
//$('#listsearchjax').fadeIn("slow");

                //    include = include + '<div class="list-project-result" id="list-search-ajax">';
                include = include + '<div class="project-short larger">';
                include = include + '<div class="top-project-info">';
                include = include + '<div class="content-info-short clearfix">';
                include = include + '<a class="thumb-img" href="#">';
                include = include + '<img alt="$TITLE" src="images/gambar1.jpg">';
                include = include + '</a>';
                include = include + '<div class="wrap-short-detail">';
                include = include + '<h3 class="rs acticle-title"><a href="#" class="be-fc-orange">LYK and Bear #' + no + ': No Food Deed Unpunished</a></h3>';
                include = include + '<p class="rs tiny-desc">by <a class="fw-b fc-gray be-fc-orange" href="#">Ray Sumser</a> in <span class="fw-b fc-gray">New York, NY</span></p>';
                include = include + '<p class="rs title-description">Nam sit amet est sapien, a faucibus purus. Sed commodo facilisis tempus. Pellentesque placerat elementum adipiscing.</p>';
                include = include + '</div>';
                include = include + '<p class="rs clearfix comment-view">';
                include = include + '<a class="fc-gray be-fc-orange" href="#">75 comments</a>';
                include = include + '<span class="sep">|</span>';
                include = include + '<a class="fc-gray be-fc-orange" href="#">378 views</a>';
                include = include + '</p>';
                include = include + '</div>';
                include = include + '</div>';
                include = include + '<div class="bottom-project-info clearfix">';
                include = include + '<div class="project-progress sys_circle_progress" data-percent="53">';
                include = include + '<div class="sys_holder_sector"></div>';
                include = include + '</div>';
                include = include + '<div class="group-fee clearfix">';
                include = include + '<div class="fee-item">';
                include = include + '<p class="rs lbl">Bankers</p>';
                include = include + '<span class="val">270</span>';
                include = include + '</div>';
                include = include + '<div class="sep"></div>';
                include = include + '<div class="fee-item">';
                include = include + '<p class="rs lbl">Pledged</p>';
                include = include + '<span class="val">$38,000</span>';
                include = include + '</div>';
                include = include + '<div class="sep"></div>';
                include = include + '<div class="fee-item">';
                include = include + '<p class="rs lbl">Days Left</p>';
                include = include + ' <span class="val">25</span>';
                include = include + '</div>';
                include = include + '</div>';
                include = include + '<a href="#" class="btn btn-red btn-buck-project">Buck this project</a>';
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
        }
    });
    //  alert(next);


    return false;
}