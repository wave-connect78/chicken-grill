$(function(){
    $('.fa-search').on('click',function(){
        if ($('.search-content').hasClass('activeSearch')) {
            //console.log('test0');
            $('.search-content').hide(300);
            $('.search-content').removeClass('activeSearch');
        } else {
            $('.search-content').show(300);
            $('.search-content').addClass('activeSearch');
            //console.log('test1');
        }
    });
    $('header .menu').on('click',function(){
        if ($('.navi-content').hasClass('activeNav')) {
            //console.log('test0');
            $('.navi-content').hide(300);
            $('.navi-content').removeClass('activeNav');
        } else {
            $('.navi-content').show(300);
            $('.navi-content').addClass('activeNav');
            //console.log('test1');
        }
    });
})