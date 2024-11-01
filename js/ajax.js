function online_visitor()
{
    $.ajax({
        url : my_ajax_url.ajax_url,
        type : 'post',
        data : {
            action : 'ajax_online_visitor'
        },
        success : function(response)
        {
            $('.online_visitor').text(response);
        }
    });
}


window.setInterval(function(){
    online_visitor();
}, 5000);


function todays_hit()
{
    $.ajax({
        url : my_ajax_url.ajax_url,
        type : 'post',
        data : {
            action : 'ajax_todays_hit'
        },
        success : function(response)
        {
            $('.todays_hit').text(response);
        }
    });
}


window.setInterval(function(){
    todays_hit();
}, 5000);


function total_hit()
{
    $.ajax({
        url : my_ajax_url.ajax_url,
        type : 'post',
        data : {
            action : 'ajax_total_hit'
        },
        success : function(response)
        {
            $('.total_hit').text(response);
        }
    });
}


window.setInterval(function(){
    total_hit();
}, 5000);

