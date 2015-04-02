$(function () {
  


});

function tabMenu(idmen){
  //  alert('masuksini');
    $('#menu'+idmen).siblings().removeClass("active").end().addClass("active");
    
    return false;
}