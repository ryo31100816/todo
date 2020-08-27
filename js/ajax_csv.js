$(function(){

    $('#csv').submit(function(event){
        event.preventDefault();
        let $form = $(this);
        console.log($form.serialize());
        let $button = $('#request');
        $.ajax({
            url: '../app/bin/output_csv.php', //送信先
            type: 'POST', //送信方法\
            dataType: 'json',
            data: $form.serialize(),
            timeout: 10000,
            //重複送信を避けるためにボタンを無効化
            beforeSend: function(xhr, settings) {
                $button.attr('disabled', true);
            },
            //完了後ボタンを押せるように
            complete: function(xhr, textStatus) {
                $button.attr('disabled', false);
            }
        })// Ajax通信が成功した時
        .done( function(result, textStatus, jqXHR) {
            console.log('通信成功');
            console.log(result);
           
        })
        // Ajax通信が失敗した時
        .fail( function(jqXHR, textStatus, errorThrown) {
            console.log('通信失敗');
            console.log("jqXHR          : " + jqXHR.status); 
            console.log("textStatus     : " + textStatus);
            console.log("errorThrown    : " + errorThrown.message);
        })
    }); //#ajax click end
   
}); //END