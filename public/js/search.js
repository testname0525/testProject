$(function() {

  $("#fav-table").tablesorter();

  $('#search-form').on('submit', function(event) {
      event.preventDefault(); 

      var name = $('input[name="search"]').val();
      var company = $('select[name="companyId"]').val();
      var minPrice = $('input[name="min_price"]').val();
      var maxPrice = $('input[name="max_price"]').val();
      var minStock = $('input[name="min_stock"]').val();
      var maxStock = $('input[name="max_stock"]').val();
      
      $.ajax({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          type: "get",
          url: "/products/search",
          datatype: "json",
          data: {
              search: name,
              companyId: company,
              min_price: minPrice,
              max_price: maxPrice,
              min_stock: minStock,
              max_stock: maxStock
          }
      })
      .done(function(data) {
          console.log('検索成功');
          var $result = $('#product-list');
          $result.empty(); 

          $.each(data.products, function(index, product) {
              var companyName = product.company ? product.company.company_name : 'N/A';
              var imagePath = product.img_path ? product.img_path : '/path/to/default/image.jpg'; 
              var html = `
                  <tr>
                      <td>${product.product_name}</td>
                      <td>${companyName}</td>
                      <td>${product.price}</td>
                      <td>${product.stock}</td>
                      <td>${product.comment}</td>
                      <td><img src="${imagePath}" alt="商品画像" width="100"></td>
                      <td>
                          <a href="/products/${product.id}" class="btn btn-info btn-sm mx-1">詳細表示</a>
                          <a href="/products/${product.id}/edit" class="btn btn-primary btn-sm mx-1">編集</a>
                          <button class="btn btn-danger btn-sm mx-1 btn-delete" data-product_id="${product.id}">削除</button>
                      </td>
                  </tr>
              `;
              $result.append(html);
          });
          $("#fav-table").trigger("update");
      })
      .fail(function(data) {
          console.log('検索失敗');
          alert('検索に失敗しました。再試行してください。');
      });
  });

  // $(document).on('click', '.btn-delete', function(event){
  //     event.preventDefault(); 

  //     var deleteConfirm = confirm('削除してよろしいでしょうか？');
  //     if(deleteConfirm) {
  //         console.log('削除非同期開始');
  //         var clickEle = $(this);
  //         var product = clickEle.data('product-id'); 
  //         var deleteTarget = clickEle.closest('tr');
  //         var action = clickEle.closest('form').attr('action');

  //         $.ajax({
  //             headers: {
  //                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  //             },
  //             type: 'DELETE',
  //             url: "/products/" + product,
  //             dataType: 'json',
  //         })
  //         .done(function(response) {
  //             console.log('削除通信成功');
  //             deleteTarget.remove();
  //             alert('商品が削除されました。');
  //             $("#fav-table").trigger("update");
  //         })
  //         .fail(function(xhr) {
  //             console.log('通信後失敗');
  //             alert('削除に失敗しました。再試行してください。');
  //         });
  //     } 
  // });
});
