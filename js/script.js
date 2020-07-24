$(function(){
    
 $(".delete-btn").click(function() {
    const todo_id = $(this).data('id');
    alert("削除します");
    window.location.href = "./index.php?action=delete&todo_id=" + todo_id;
 });

 $(document).ready(function(){
    $('.task').fadeIn(1500);
 });

 let msg = document.getElementById('success-msg').value;

if(typeof msg !== 'undefined' && msg !== ''){
   $('#complete').removeClass('hide').delay(5000).queue(function(next){
      $(this).addClass('hide');
      next();
   });
}

});