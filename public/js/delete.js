$(function() {
    $('.btn-danger').click(function(event){
        event.preventDefault(); // デフォルトのフォーム送信を防ぐ

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
                url: action,
                dataType: 'json',
                data: {'product': product}
            })
            .done(function(response) {
                console.log('削除通信成功');
                deleteTarget.remove();
                alert('商品が削除されました。');
            })
            .fail(function(xhr) {
                console.log('通信後失敗');
                alert('削除に失敗しました。再試行してください。');
            });
        } 
    });
});
