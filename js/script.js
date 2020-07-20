$(function(){
    
 $(".delete-btn").click(function() {
    const todo_id = $(this).data('id');
    alert("削除します");
    window.location.href = "./index.php?action=delete&todo_id=" + todo_id;
 });

 $(document).ready(function(){
    $('.task').fadeIn(1500);
 });

 let where = document.getElementById('from-new').value;

if(where === 'from-new'){
   $('#complete').removeClass('hide').delay(5000).queue(function(next){
      $(this).addClass('hide');
      next();
   });
}

});