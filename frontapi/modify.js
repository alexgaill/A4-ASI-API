$id = window.location.href.split("=")[1];

$.ajax({
    url:"../apiecommerce/product/"+$id,
    method:"GET",
    dataType:"json",
    success:function(response){
        $("[name=name]").val(response.data.name);
        $("[name=infos]").val(response.data.infos);
        $("[name=buyPrice]").val(response.data.buyPrice);
        $("[name=sellPrice]").val(response.data.sellPrice);
    }
})

$("#modifyProduct button").click(function(e){
    e.preventDefault();
    const data = $("#modifyProduct").serializeArray();
    $.ajax({
        url:"../apiecommerce/product/"+$id,
        method:"PUT",
        data: data,
        dataType:"json",
        success:function(response){
            console.log(response)
        },
        fail:function(response){
            console.log(response)
        }
    })
})