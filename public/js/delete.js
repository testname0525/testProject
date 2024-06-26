$(function() {
    $(document).on('click', '.btn-delete', function(event){
        event.preventDefault(); 
  
        var deleteConfirm = confirm('削除してよろしいでしょうか？');
        if(deleteConfirm) {
            console.log('削除非同期開始');
            var clickEle = $(this);
            var product = clickEle.data('product_id'); 
            var deleteTarget = clickEle.closest('tr');
            var action = clickEle.closest('form').attr('action');
  
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'DELETE',
                url: "/products/" + product,
                dataType: 'json',
            })
            .done(function(response) {
                console.log('削除通信成功');
                deleteTarget.remove();
                alert(response.message);
                $("#fav-table").trigger("update");
                window.location.href = response.redirect;

            })
            .fail(function(xhr) {
                console.log('通信後失敗');
                alert('削除に失敗しました。再試行してください。');
            });
        } 
    });
});
