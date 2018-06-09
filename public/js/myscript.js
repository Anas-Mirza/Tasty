$(function () {
    $('form').on('submit', function (e) {
          $.ajax({
           type: 'post',
            url: '/planner/addremove',
            data: $(form).serialize(),
            success: function () {   
             
              
            }
    });
   e.preventDefault();
});
});