$(function(){
    
 $(".delete_btn").click(function() {
    const todo_id = $(this).data('id');
    alert("削除します");
    // alert(todo_id);
    window.location.href = "./index.php?action=delete&todo_id=" + todo_id;
 });

 $(document).ready(function(){
    $('.task').fadeIn(1500);
 });





});