$(function(){

    $('#csv').submit(function(event){
        event.preventDefault();
        let $form = $(this);
        console.log($form.serialize());
        let $button = $('#request');
        $.ajax({
            url: '../todo/output_csv.php', //送信先
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
        .done( function(todo_data, textStatus, jqXHR) {
            console.log('通信成功');
            console.log(todo_data);
            const header_line = Object.keys(todo_data[0]) + '\n';
            let csv_line = header_line;
            let line = '';
            for(i = 0; i < todo_data.length; i++){
                line += todo_data[i].id + ',';
                line += todo_data[i].title + ',';
                line += todo_data[i].detail + ',';
                line += todo_data[i].status + ',';
                line += todo_data[i].user_id + ',';
                line += todo_data[i].completed_at + ',';
                line += todo_data[i].created_at + ',';
                line += todo_data[i].updated_at + ',';
                line += todo_data[i].deleted_at + '\n';
                csv_line += line;
                line = '';
            }
            console.log(csv_line);
            const a = document.createElement('a');
            document.body.appendChild(a);
            a.style = "display:none";
            const blob = new Blob([csv_line], { type: 'octet/stream' });
            const url = window.URL.createObjectURL(blob);
            a.href = url;
            a.download = 'todo_list.csv';
            a.click();
            window.URL.revokeObjectURL(url);
            a.parentNode.removeChild(a);

            // $("#success-msg").text(data);
            // $("#success-msg").slideToggle(200);
            // $("#success-msg").delay(5000).slideToggle(200);
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