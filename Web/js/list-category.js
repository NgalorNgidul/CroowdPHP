$(function () {
//    console.log('Init List Category');
    $.ajax({
        type: "get",
        url: "http://api.croowd.co.id/prospect/categories/info",
        dataType: 'json',
        success: function (data) {
            var ln = data.length;
            
            var include = '';
            for (var i = 0; i < ln; i++) {
                var item = data[i];
                include = include + '<li>';
                include = include + '<a href="#">';
                include = include + item.name;
                include = include + '<span class="count-val">('+ item.iInfo +')</span>';
                include = include + '<i class="icon iPlugGray"></i>';
                include = include + '</a>';
                include = include + '</li>';
            }
            $('#list-cat').append(include);
        }
    });
});
