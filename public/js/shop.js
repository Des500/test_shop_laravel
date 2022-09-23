;(function($, undefined) {


    function getToken () {
        return document.querySelector('head meta[name="csrf-token"]').getAttribute('content');
    }
    function getProduct_id (item) {
        return item.id.split('_')[1];
    }

    function setPostData (item) {
        product_id = getProduct_id(item);
        token = getToken();
        t_input = document.querySelector('#input_'+product_id);
        product_quantity = t_input.value;
        if (product_quantity<=0) {
            t_input.value = 1;
            product_quantity = 1;
        };
        post_data = {
            _token: token,
            product_id: product_id,
            product_quantity: product_quantity
        }
        console.log(post_data);
        return post_data;
    }

    $(document).ready(function () {

        document.querySelectorAll(".product .product_quantity").forEach(function (item) {
            item.addEventListener("change", function () {
                post_data = setPostData(item);
                $.post('/public/getprice', post_data, function(data) {
                        data_array = JSON.parse(data);
                        if (data_array != null) {
                            document.querySelector('#product_'+product_id+' .product_price').textContent =
                                data_array['summa'];
                        }
                    }
                );
            })
        })

        // добавление в корзину
        document.querySelectorAll(".product .cart_add_button").forEach(function (item) {
            item.addEventListener("click", function () {
                post_data = setPostData(item);
                $.post('/public/addcart', post_data, function(data){
                        data_array = JSON.parse(data);
                        if (data_array != null) {
                            console.log(data_array);
                            document.querySelector('#input_'+product_id).value = 1;
                            document.querySelector('#product_'+product_id+' .product_price').textContent =
                                data_array['cart'][product_id]['price'];
                            console.log(data_array['summa']);
                            document.querySelector('.cart span').textContent = data_array['summa']+' руб.';
                            dialog_form=document.querySelector('#dialog');
                            dialog_form.innerHTML = 'Товар <b>'
                                + document.querySelector('#product_'+product_id+' .product_title').textContent
                                + '</b> был добавлен в корзину';
                            // document.querySelector('body').addEventListener('mousedown', function (e) {
                            //     dialog_form.style.top = e.offsetY+"px";
                            //     dialog_form.style.left = e.offsetX+"px";
                            //     console.log(e.offsetY+"px");
                            // });
                            dialog_form.className = 'form_open alert alert-success';
                            setTimeout( function () {
                                dialog_form.className = 'form_close';
                            }, 1000);
                            setTimeout( function () {
                                dialog_form.className = 'form_closed';
                                document.querySelector('#dialog').innerHTML = '';
                            }, 2000);
                        }
                    }
                );
            })
        })

        // изменение количества в строке корзины
        document.querySelectorAll(".product_cart .product_quantity").forEach(function (item) {
            item.addEventListener("change", function () {
                post_data = setPostData(item);
                $.post('/public/setquantity', post_data, function(data){
                        data_array = JSON.parse(data);
                        if (data_array != null) {
                            console.log(data_array);
                            document.querySelector('#product_'+product_id+' .product_price').textContent =
                                data_array['cart'][product_id]['summa'];
                            document.querySelector('.cart span').textContent = data_array['summa']+' руб.';
                            document.querySelector('.cart_buy_button span').textContent = data_array['summa'];
                        }
                    }
                )
            })
        });

        // удаление товара в строке корзины
        document.querySelectorAll(".product_cart .cart_del_button").forEach(function (item) {
            item.addEventListener("click", function () {
                post_data = setPostData(item);
                $.post('/public/delcart', post_data, function(data){
                        data_array = JSON.parse(data);
                        if (data_array != null) {
                            console.log(data_array);
                            if(data_array['summa_quantity'] == 0)
                                location.reload();
                            document.querySelector('#product_'+product_id+' ~ hr').outerHTML = '';
                            document.querySelector('#product_'+product_id).remove();
                            document.querySelector('.cart span').textContent = data_array['summa']+' руб.';
                            document.querySelector('.cart_buy_button span').textContent = data_array['summa'];
                        }
                    }
                );
            })
        })
    })

    // сокрытие информационных билбордов
    document.querySelectorAll('.alert_block div').forEach(function (item) {
        let original_class = item.className;
        setTimeout( function () {
            item.className = original_class+' form_close';
        }, 10000);
        setTimeout( function () {
            item.className = 'form_closed';
            item.innerHTML = '';
        }, 11000);
    });


    function showAdressSelection (id) {
        let token = getToken();
        let post_data = {
            _token: token,
            id: id
        }
        $.post('/adresses-showajax', post_data, function(data) {
            let data_array = JSON.parse(data);
            if (data_array != null) {
                console.log(data_array);
                document.querySelector('#contact_phone').innerHTML = '<b>Телефон: </b>' + data_array['contact_phone'];
                document.querySelector('#contact_adress').innerHTML = '<b> Адрес: </b>' + data_array['contact_adress'];
            }
        })

    }

    document.querySelector('.select_adress select[name="adress_id"]').addEventListener('change', function () {
        showAdressSelection(this.value);
    })
    document.addEventListener('DOMContentLoaded', function(){
        showAdressSelection(document.querySelector('.select_adress select[name="adress_id"]').value);
    });



    })(jQuery);

