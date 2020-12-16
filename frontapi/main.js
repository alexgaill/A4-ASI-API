$("#login button").click((e) =>{
    e.preventDefault();
    const login = $("#login").serializeArray();
    $.ajax({
        url:"../apiecommerce/user/login",
        method:"POST",
        dataType:"json",
        data:login,
        success:function(response){
            console.log(response);
        }
    })
})

$.ajax({
    url:"../apiecommerce/product",
    method:"GET",
    dataType:"json",
    success:function(response){
        response.data.forEach(product => {
            $("#listProducts").append(`
            <li><a href='modify.html?id=${product.product_id}'>${product.name}</a></li>
            `)
        });
    }
})