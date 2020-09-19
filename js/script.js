$(function(){
    
 $(".delete-btn").click(function() {
    const todo_id = $(this).data('id');
    window.location.href = "./index.php?action=delete&todo_id=" + todo_id;
 });

 $(".complete-btn").click(function() {
   const todo_id = $(this).data('id');
   window.location.href = "./index.php?action=complete&todo_id=" + todo_id;
});

$("#request").click(function() {
   $("#dl-btn").removeClass('hide');
});

 $(document).ready(function(){
    $('.task').fadeIn(1500);
 });

function toArray(nodeList) {
   return Array.prototype.slice.call(nodeList, 0);
 }
 let elements = document.querySelectorAll('.complete-status');
 toArray(elements).forEach(function(element) {
   let status = element.getAttribute('value');
   console.log(status);
   if(status === "1"){
      element.parentNode.classList.add('completed');
      element.previousElementSibling.classList.add('done');
   }
 });

 let msg = document.getElementById('success-msg').value;
if(typeof msg !== 'undefined' && msg !== ''){
   $('#complete').removeClass('hide').delay(5000).queue(function(next){
      $(this).addClass('hide');
      next();
   });
}

});