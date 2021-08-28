function addToCart(product_id){
    $.ajax({
        "url": "server.php",
        type:"POST",
        dataType:"json",
        data:{
            "product_id" : product_id,
            "add_to_cart" : 1
        },
        success:function(response){
            $("#messages").empty()
            $("#messages").append(`<div class="alert alert-primary alert-dismissible fade show" role="alert">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
              <strong>Uspeh!</strong> ${response.msg} 
            </div>`)
            $("#cartCount").text(response.count)
            console.log(response)
        },
        error:function(response){
            console.log(response)
        }
    })
}
function removeFromCart(product_id){
    $.ajax({
        "url": "server.php",
        type:"POST",
        dataType:"json",
        data:{
            "product_id" : product_id,
            "remove_from_cart" : 1
        },
        success:function(response){
            $("#messages").empty()
            $("#messages").append(`<div class="alert alert-primary alert-dismissible fade show" role="alert">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
              <strong>Uspeh!</strong> ${response.msg} 
            </div>`)
            $("#cartCount").text(response.count)
            console.log(response)
            location.reload()

        },
        error:function(response){
            console.log(response)
        }
    })
}
function emptyCart(){
    $.ajax({
        "url": "server.php",
        type:"POST",
        dataType:"json",
        data:{
            "empty_cart" : 1
        },
        success:function(response){
            $("#messages").empty()
            $("#messages").append(`<div class="alert alert-primary alert-dismissible fade show" role="alert">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
              <strong>Uspeh!</strong> ${response.msg} 
            </div>`)
            $("#cartCount").text(0)
            console.log(response)
            location.reload()
        },
        error:function(response){
            console.log(response)
        }
    })
}
function removeProduct(product_id){
     $.ajax({
        "url": "server.php",
        type:"POST",
        dataType:"json",
        data:{
            "remove_product" : 1,
            "product_id" : product_id
        },
        success:function(response){
            $("#messages").empty()
            $("#messages").append(`<div class="alert alert-primary alert-dismissible fade show" role="alert">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
              <strong>Uspeh!</strong> ${response} 
            </div>`)
            console.log(response)
            setTimeout(() => {
                location.reload()
            }, 750);
        },
        error:function(response){
            console.log(response)
        }
    })
}