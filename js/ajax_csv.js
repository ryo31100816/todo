$(function(){

    $('#csv').submit(function(event){
        event.preventDefault();
        let $form = $(this);
        console.log($form.serialize());
        let $button = $('#request');
        $.ajax({
            url: '../../bin/output_csv.php', //実行するviewからみたパス
            type: 'POST', //送信方法\
            dataType: 'text',
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
            let status_check;
            function startTimer(){
                status_check = setInterval(function(){
                    $.ajax({
                        url: './check_csv_status.php', //実行するviewからみたパス
                        type: 'POST', //送信方法\
                        dataType: 'text',
                        data: '',
                        timeout: 10000,
                    })
                    .done(function(result, textStatus, jqXHR){
                        console.log('通信成功');
                        console.log(result);
                        stopTimer();
                    })
                    .fail(function(jqXHR, textStatus, errorThrown){
                        console.log('通信失敗');
                        console.log("jqXHR          : " + jqXHR.status); 
                        console.log("textStatus     : " + textStatus);
                        console.log("errorThrown    : " + errorThrown.message);
                        stopTimer();
                    })
                }, 1000);
            }
            function stopTimer(){
                clearInterval(status_check);
            }

            startTimer();
      
        })
        // Ajax通信が失敗した時
        .fail(function(jqXHR, textStatus, errorThrown){
            console.log('通信失敗');
            console.log("jqXHR          : " + jqXHR.status); 
            console.log("textStatus     : " + textStatus);
            console.log("errorThrown    : " + errorThrown.message);
        })
    }); //#ajax click end
   
}); //END