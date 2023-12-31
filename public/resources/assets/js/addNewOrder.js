var baseUrl = "http://192.168.10.26:8080";
function openNewOrderModal(){
    setActiveForm("addsefarishtbl");
    if (!($('.modal.in').length)) {
        $('.modal-dialog').css({
            top: 0,
            left: 0
        });
    }
    $('.modal-dialog').draggable({
        handle: ".modal-header"
    });

    $.get(baseUrl+"/getCustomerList",{},(respond,status)=>{
        $("#customerForSefarishId").empty();
        $("#customerForSefarishId").append(`<option class="customerForSefarishId"> </option>`);
        for (const customer of respond) {
            $("#customerForSefarishId").append(`<option class="customerForSefarishId" value="${customer.PSN}"> ${customer.Name} </option>`);
        }
    });

    $("#newOrder").modal("show");
}

$(document).ready(function () {
    localStorage.setItem("scrollTop",0);
});

$("#editPCode").on("keyup",()=>{
    let code=$("#editPCode").val();
    $.get(baseUrl+"/getCustomerByCode",{PCode:code},function(data,status){
        $("#editName").empty();
        let dataOptions=data.map(element=>`<option value="`+element.PSN+`">`+element.Name+`</option>`);
        $("#CustomerNameEditInput").val(data[0].Name);
        $("#editName").append(dataOptions);
        $("#editName").trigger("change");
        $("#editAddress").empty();
        let addressOptions=data.map(element=>{
            if(element.AddressPeopel){
                return `<option value="`+element.AddressPeopel+`_`+element.SnPeopelAddress+`">`+element.AddressPeopel+`</option>`
            }else{
                return `<option value="`+element.peopeladdress+`_0">`+element.peopeladdress+`</option>`   
            }
        });
        $("#editAddress").append(addressOptions);

        $("#lastCustomerStatus").text(data[0].TotalPrice);
    })
})

$("#editName").on("change",()=>{
    let psn=$("#editName").val();
    $.get(baseUrl+"/getCustomerByID",{PSN:psn},function(data,status){
        $("#editAddress").empty();
        let addressOptions=data.map(element=>{
            if(element.AddressPeopel){
                return `<option value="`+element.AddressPeopel+`_`+element.SnPeopelAddress+`">`+element.AddressPeopel+`</option>`
                }else{
                    return `<option value="`+element.peopeladdress+`_0">`+element.peopeladdress+`</option>`   
                }
        })
        $("#editAddress").append(addressOptions);
    });

    $("#editedCustomerSn").css("display","block");

})

$("#editedCustomerSn").on("click",function(event){
    let psn=$("#editName").val();
    let snHDS=$("#EditHDSSn").val();
    let address=$("#editAddress").val();

    $.get(baseUrl+"/doEditOrder",{psn:psn,SnHDS:snHDS,address:address},function(respond,status){
        if(status=='success'){
            window.location.reload();
        }

    });
})
function getCustomerByCode(code) {
    $.get(baseUrl+"/getCustomerByCode",{PCode:code},function(data,status){
        if(data.length>0){
            $("#customerForSefarishId").empty();
            $("#searchCustomerNameInput").val(data[0].Name);
            let dataOptions=data.map(element=>`<option value="`+element.PSN+`">`+element.Name+`</option>`);
            $("#customerForSefarishId").append(dataOptions);
            $("#customerForSefarishId").change();
            $("#customerAddressForSefarish").empty();
            let addressOptions=data.map(element=>{
                if(element.AddressPeopel){
                    return `<option value="`+element.AddressPeopel+`_`+element.SnPeopelAddress+`">`+element.AddressPeopel+`</option>`
                }else{
                    return `<option value="`+element.peopeladdress+`_0">`+element.peopeladdress+`</option>`   
                }
            });
            $("#customerAddressForSefarish").append(addressOptions);
            $("#lastCustomerStatus").text(data[0].TotalPrice||0);
            
        }else{
            $("#customerForSefarishId").empty();
            $("#customerAddressForSefarish").empty();
            $("#searchCustomerNameInput").val("");
            $("#lastCustomerStatus").text(0);
        }
    });
}

function addAmelToSefarish(){
    $("#addAmelModal").modal("hide");
    $("#hamlMoney").val($("#hamlMoneyModal").val().replace(/,/g, ''));
    $("#hamlDesc").val($("#hamlDescModal").val());
    $("#nasbMoney").val($("#nasbMoneyModal").val().replace(/,/g, ''));
    $("#nasbDesc").val($("#nasbDescModal").val());
    $("#motafariqaMoney").val($("#motafariqaMoneyModal").val().replace(/,/g, ''));
    $("#motafariqaDesc").val($("#motafariqaDescModal").val());
    $("#bargiriMoney").val($("#bargiriMoneyModal").val().replace(/,/g, ''));
    $("#bargiriDesc").val($("#bargiriDescModal").val());
    $("#tarabariMoney").val($("#tarabariMoneyModal").val().replace(/,/g, ''));
    $("#tarabariDesc").val($("#tarabariDescModal").val());
    let hamlMoney=0;
    let nasbMoney=0;
    let motafariqaMoney=0;
    let bargiriMoney=0;
    let tarabariMoney=0;
    if(!isNaN(parseInt($("#hamlMoney").val()))){
        hamlMoney=parseInt($("#hamlMoney").val());
    }
    if(!isNaN(parseInt($("#nasbMoney").val()))){
        nasbMoney=parseInt($("#nasbMoney").val());
    }
    if(!isNaN(parseInt($("#motafariqaMoney").val()))){
        motafariqaMoney=parseInt($("#motafariqaMoney").val());
    }
    if(!isNaN(parseInt($("#bargiriMoney").val()))){
        bargiriMoney=parseInt($("#bargiriMoney").val());
    }
    if(!isNaN(parseInt($("#tarabariMoney").val()))){
        tarabariMoney=parseInt($("#tarabariMoney").val());
    }

    let allAmel=hamlMoney+nasbMoney+motafariqaMoney+bargiriMoney+tarabariMoney;
    $("#allAmelMoney").text(parseInt(allAmel).toLocaleString("en-us"));
}
$("#hamlMoneyModal").on("keyup",(e)=>{
    checkNumberInput(e);
    if(e.keyCode==13 || e.keyCode==9){
        $("#hamlDescModal").focus();
    }
})
$("#nasbMoneyModal").on("keyup",(e)=>{
    checkNumberInput(e);
    if(e.keyCode==13 || e.keyCode==9){
        $("#nasbDescModal").focus();
    }
})
$("#motafariqaMoneyModal").on("keyup",(e)=>{
    checkNumberInput(e);
    if(e.keyCode==13 || e.keyCode==9){
        $("#motafariqaDescModal").focus();
    } 
})
$("#bargiriMoneyModal").on("keyup",(e)=>{
    checkNumberInput(e);
    if(e.keyCode==13 || e.keyCode==9){
        $("#bargiriDescModal").focus();
    }
})
$("#tarabariMoneyModal").on("keyup",(e)=>{
    checkNumberInput(e);
    if(e.keyCode==13 || e.keyCode==9){
        $("#tarabariDescModal").focus();
    }
})
$("#hamlDescModal").on("keyup",(e)=>{
    if(e.keyCode==13 || e.keyCode==9){
        $("#nasbMoneyModal").focus();
    }
})
$("#nasbDescModal").on("keyup",(e)=>{
    if(e.keyCode==13 || e.keyCode==9){
        $("#motafariqaMoneyModal").focus();
    }
})
$("#motafariqaDescModal").on("keyup",(e)=>{
    if(e.keyCode==13 || e.keyCode==9){
        $("#bargiriMoneyModal").focus();
    }
})
$("#bargiriDescModal").on("keyup",(e)=>{
    if(e.keyCode==13 || e.keyCode==9){
        $("#tarabariMoneyModal").focus();
    }
});

$("#tarabariDescModal").on("keyup",(e)=>{
    if(e.keyCode==13 || e.keyCode==9){
        let allAmel=checkWantToaddedAmel();
        if(allAmel>0){
            swal({
                text: "می خواهید این هزینه ها اضافه شوند؟",
                icon: "warning",
                buttons: true,
                dangerMode: true,
                }).then((willAdd) => {
                    if(willAdd){
                        $("#sabtAmelButton").trigger("click");
                }
            });
        }
    }
});

function checkNumberInput(e){
    if(((e.keyCode>=48 && e.keyCode<=57 || (e.keyCode==13 || e.keyCode==9)) || ((e.keyCode>=96 && e.keyCode<=105)|| e.keyCode==8))){
        if(e.target.value.length>0){
            e.target.value=parseInt(e.target.value.replace(/,/g, '')).toLocaleString("en-us")
        }
    }else{
        e.target.focus();
        e.target.value="";
    }
}



function checkWantToaddedAmel(){
    let hamlMoney=0;
    let nasbMoney=0;
    let motafariqaMoney=0;
    let bargiriMoney=0;
    let tarabariMoney=0;
    if(!isNaN(parseInt($("#hamlMoneyModal").val()))){
        hamlMoney=parseInt($("#hamlMoneyModal").val());
    }
    if(!isNaN(parseInt($("#nasbMoneyModal").val()))){
        nasbMoney=parseInt($("#nasbMoneyModal").val());
    }
    if(!isNaN(parseInt($("#motafariqaMoneyModal").val()))){
        motafariqaMoney=parseInt($("#motafariqaMoneyModal").val());
    }
    if(!isNaN(parseInt($("#bargiriMoneyModal").val()))){
        bargiriMoney=parseInt($("#bargiriMoneyModal").val());
    }
    if(!isNaN(parseInt($("#tarabariMoneyModal").val()))){
        tarabariMoney=parseInt($("#tarabariMoneyModal").val());
    }
    let allAmel=hamlMoney+nasbMoney+motafariqaMoney+bargiriMoney+tarabariMoney;
    return allAmel;
}

$("#cancelAmelButton").on("click",(e)=>{
    let allAmel=checkWantToaddedAmel();
    if(allAmel>0){
        swal({
            text: "می خواهید این هزینه ها اضافه نشوند؟",
            icon: "warning",
            buttons: true,
            dangerMode: true,
            }).then((willAdd) => {
                if(willAdd){
                    $("#addAmelModal").modal("hide");
                }
        }   );
    }
})

$("#sendDateFromSefarishPage").persianDatepicker({
    cellWidth: 32,
    cellHeight: 22,
    fontSize: 14,
    formatDate: "YYYY/0M/0D",
});

$("#sendDateFromSefarishPageEdit").persianDatepicker({
    cellWidth: 32,
    cellHeight: 22,
    fontSize: 14,
    formatDate: "YYYY/0M/0D",
});

$(document).on("keyup",".td-inputCodeName", (e)=>{
    if((e.keyCode>=65 && e.keyCode<=90) || ((e.keyCode>=48 && e.keyCode<=57) || (e.keyCode>=96 && e.keyCode<=105))){
        setActiveTableOrder("kalaForAddToSefarish")
        setActiveForm("")
        $("#rowTaker").val($(e.target).parents("tr").index()+1)
        if (!($('.modal.in').length)) {
            $('.modal-dialog').css({
                top: 0,
                left: 0
            });
        }
        $('#searchGoodsModalAdd').modal({
            backdrop: false,
            show: true
        });

        $('.modal-dialog').draggable({
            handle: ".modal-header"
        });
        $("#searchKalaForAddToSefarishByName").val();
        $("#searchForAddItemLabel").text("نام کالا")
        $("#searchKalaForAddToSefarishByName").val("");
        $("#searchKalaForAddToSefarishByName").val($(e.target).val());
        $("#searchKalaForAddToSefarishByCode").hide();
        $("#searchKalaForAddToSefarishByName").show();
        $("#searchGoodsModalAdd").modal("show");
        $('#searchGoodsModalAdd').on('shown.bs.modal', function() {
        $("#searchKalaForAddToSefarishByName").focus();
        });
    }else{
        if(e.keyCode ==13 || e.keyCode ==9){
            var $currentInput = $(e.target);
            var $nextInput = $currentInput.closest('td').next('td').find('input');
            if ($nextInput.length > 0) {
                $nextInput.focus();
            }
        }
    }
})

$(document).on("keyup",".td-inputFirstUnit", (e)=>{
    if(e.keyCode ==13 || e.keyCode ==9){
        var $currentInput = $(e.target);
        var $nextInput = $currentInput.closest('td').next('td').find('input');
        if ($nextInput.length > 0) {
            $nextInput.focus();
        }
    }
});

$(document).on("keyup",".td-inputSecondUnit", (e)=>{
    if(e.keyCode ==13 || e.keyCode ==9){
        var $currentInput = $(e.target);
        var $nextInput = $currentInput.closest('td').next('td').find('input');
        if ($nextInput.length > 0) {
            $nextInput.focus();
        }
    }
});

$(document).on('keyup', '#searchCustomerNameInput',function(e){
    if(((e.keyCode>=65 && e.keyCode<=90)|| (e.key).match(/[آ-ی]/)) || ((e.keyCode>=48 && e.keyCode<=57) || (e.keyCode>=96 && e.keyCode<=105))){
        
        setActiveTableOrder("foundCusotmerForOrderBody")
        setActiveForm("")
        if (!($('.modal.in').length)) {
            $('.modal-dialog').css({
                top: 0,
                left: 0
            });
        }
        $('.modal-dialog').draggable({
            handle: ".modal-header"
        });
        $("#customerForSefarishModal").modal("show");
        $("#customerNameForOrder").val($('#searchCustomerNameInput').val());
        $("#customerNameForOrder").focus();
        $('#customerForSefarishModal').on('shown.bs.modal', function() {
            $(this).find('[autofocus]').focus();
        });
    }
});



$("#customerForSefarishId").on("change",function(){
    $.get(baseUrl+"/getCustomerByID",{PSN:$(this).val()},function(data,status){
        $("#customerAddressForSefarish").empty();
        let addressOptions=data.map(element=>{
            if(element.AddressPeopel){
                return `<option value="`+element.AddressPeopel+`_`+element.SnPeopelAddress+`">`+element.AddressPeopel+`</option>`
                }else{
                    return `<option value="`+element.peopeladdress+`_0">`+element.peopeladdress+`</option>`   
                }
        })
        $("#customerAddressForSefarish").append(addressOptions);
    })
})

$("#customerForSefarishIdEdit").on("change",function(){
    $.get(baseUrl+"/getCustomerByID",{PSN:$(this).val()},function(data,status){
        $("#customerAddressForSefarishEdit").empty();
        let addressOptions=data.map(element=>{
            if(element.AddressPeopel){
                return `<option value="`+element.SnPeopelAddress+`_`+element.AddressPeopel+`">`+element.AddressPeopel+`</option>`
            }else{
                return `<option value="0_`+element.peopeladdress+`">`+element.peopeladdress+`</option>`   
            }
        })
        $("#customerAddressForSefarishEdit").append(addressOptions);
    })
})

$("#customerNameForOrder").on("keyup", function (event){
    let name=$("#customerNameForOrder").val();
    if(event.keyCode!=40){
        if(event.keyCode!=13){
    let searchByPhone="";
    if($("#seachByPhoneNumberCheckBox").is(":checked")){
        searchByPhone="on";
    }else{
        searchByPhone="";
    }
    $.get("/getCustomerForOrder",{namePhone:name,searchByPhone:searchByPhone},(data,status)=>{
        localStorage.setItem("scrollTop",0);
        $("#foundCusotmerForOrderBody").empty();
        let tableBody=$("#foundCusotmerForOrderBody");
        let i=0;
        for (let customer of data){
            i++;
            if(i!=1){
                tableBody.append(`<tr onclick="selectCustomerForOrder(${customer.PSN},this)">
                                                        <td> ${(i)}   <input type="radio" value="${customer.PSN}" class="d-none"/></td>
                                                        <td> ${customer.PCode} </td>
                                                        <td> ${customer.Name} </td>
                                                        <td> ${customer.countBuy} </td>
                                                        <td> ${customer.countSale} </td>
                                                        <td> ${customer.chequeCountReturn} </td>
                                                        <td> ${customer.chequeMoneyReturn} </td>
                                                    </tr>`);
            }else{
                tableBody.append(`<tr onclick="selectCustomerForOrder(${customer.PSN},this)">
                    <td> ${(i)}   <input type="radio" value="${customer.PSN}" class="d-none"/></td>
                    <td> ${customer.PCode} </td>
                    <td> ${customer.Name} </td>
                    <td> ${customer.countBuy} </td>
                    <td> ${customer.countSale} </td>
                    <td> ${customer.chequeCountReturn} </td>
                    <td> ${customer.chequeMoneyReturn} </td>
                </tr>`);
                $("#foundCusotmerForOrderBody tr").eq(0).css("background-color", "rgb(0,142,201)"); 
                const selectedPSN = data[0].PSN;
                selectCustomerForOrder(selectedPSN,0)
            }
        }


        Mousetrap.bind("enter",()=>{
            $("#searchCustomerSabtBtn").trigger("click");
            localStorage.setItem("scrollTop",0);
        });
    })  
    }else{
        $("#searchCustomerSabtBtn").trigger("click");
        localStorage.setItem("scrollTop",0);
    }
}else{
    $(this).blur();
    $("#foundCusotmerForOrderTble").focus();
    localStorage.setItem("scrollTop",0);
} 
});






function selectCustomerForOrder(psn,element){
    if(isNaN(element)){
        $("tr").removeClass('selected');
        $("#foundCusotmerForOrderBody tr").css('background-color', '');
        $(element).addClass("selected")
    }else{
        $("tr").removeClass('selected');
    }
    $("#searchCustomerSabtBtn").prop("disabled",false);
    $("#searchCustomerSabtBtn").val(psn);
}

function chooseCustomerForOrder(psn){
    $.get("/getInfoOfOrderCustomer",{psn:psn},(respond,status)=>{
        if(localStorage.getItem("editCustomerName")!=1){
            $("#customerForSefarishId").append(`<option selected value="${respond[0].PSN}"> ${respond[0].Name} </option>`);
            $("#customerForSefarishId").trigger("change");
            $("#searchCustomerNameInput").val(respond[0].Name);
            $("#customerCodeInput").val(respond[0].PCode);
            $("#lastCustomerStatus").text(parseInt(respond[0].TotalPrice)||0);
        }else{
            $("#editName").append(`<option selected value="${respond[0].PSN}"> ${respond[0].Name} </option>`);
            $("#editName").trigger("change");
            $("#CustomerNameEditInput").val(respond[0].Name);
            $("#editPCode").val(respond[0].PCode);
            localStorage.setItem("editCustomerName",0);
        }
    });
    $("#customerForSefarishModal").modal("hide");
}

$("#CustomerNameEditInput").on("keyup",function(e){
    if(((e.keyCode>=65 && e.keyCode<=90)|| (e.key).match(/[آ-ی]/)) || ((e.keyCode>=48 && e.keyCode<=57) || (e.keyCode>=96 && e.keyCode<=105))){
        if (!($('.modal.in').length)) {
            $('.modal-dialog').css({
                top: 0,
                left: 0
            });
        }
        $('.modal-dialog').draggable({
            handle: ".modal-header"
        });
        $("#customerForSefarishModal").modal("show");
        localStorage.setItem("editCustomerName",1);
        $("#customerNameForOrder").val($('#searchCustomerNameInput').val());
        $("#customerNameForOrder").focus();
        $('#customerForSefarishModal').on('shown.bs.modal', function() {
            $(this).find('[autofocus]').focus();
        });
    }
})

$("#searchCustomerCancelBtn").on("click",()=>{
    localStorage.setItem("scrollTop",0);
    $("#customerForSefarishModal").modal("hide");
});

$(document).on("keyup",".td-inputCode", (e)=>{
    if((e.keyCode>=65 && e.keyCode<=90) || ((e.keyCode>=48 && e.keyCode<=57) || (e.keyCode>=96 && e.keyCode<=105))){
        setActiveTableOrder("kalaForAddToSefarish")
        setActiveForm("")
        $("#rowTaker").val($(e.target).parents("tr").index()+1)

        if (!($('.modal.in').length)) {
            $('.modal-dialog').css({
                top: 0,
                left: 0
            });
        }

        $('#searchGoodsModalAdd').modal({
            backdrop: false,
            show: true
        });

        $('.modal-dialog').draggable({
            handle: ".modal-header"
        });

        $("#searchKalaForAddToSefarishByName").val();
        $("#searchForAddItemLabel").text("کد کالا")
        $("#searchKalaForAddToSefarishByCode").val($(".td-inputCode").val());
        $("#searchKalaForAddToSefarishByName").hide();
        $("#searchKalaForAddToSefarishByCode").show();
        $("#searchGoodsModalAdd").modal("show");
        $('#searchGoodsModalAdd').on('shown.bs.modal', function() {
            $("#searchKalaForAddToSefarishByCode").focus();
            $("#searchKalaForAddToSefarishByCode").select().trigger("keyup");
        });
    }else{
        if(e.keyCode ==13 || e.keyCode ==9){
            var $currentInput = $(e.target);
            var $nextInput = $currentInput.closest('td').next('td').find('input');
            if ($nextInput.length > 0) {
                $nextInput.focus();
            }
        }
    }
});

function showAmelModal(){

    $("#addAmelModal").modal("show");

}
function showAmelModalEdit(){

    $("#addAmelModalEdit").modal("show");

}

$("#searchKalaForAddToSefarishByName").on("keyup",function(event){
    let tableBody=$("#kalaForAddToSefarish");
    if(event.keyCode!=40){
        if(event.keyCode!=13){
            $.get(baseUrl+'/getKalaByName',{name:$(this).val()},function (data,status) {
                if(status=='success'){
                    tableBody.empty();
                    let i=0;
                    for (const element of data) {
                        i++;
                        if(i!=1){
                            tableBody.append(`<tr onclick="setAddedTosefarishKalaStuff(this,`+element.GoodSn+`)"> <td>`+(i)+`<input type="radio" value="${element.GoodSn}" class="d-none"/></td> <td> `+element.GoodCde+` </td><td> `+element.GoodName+`</td> <td>...</td> </tr>`);
                        }else{
                            tableBody.append(`<tr onclick="setAddedTosefarishKalaStuff(this,`+element.GoodSn+`)"> <td>`+(i)+`<input type="radio" value="${element.GoodSn}" class="d-none"/></td> <td> `+element.GoodCde+` </td><td> `+element.GoodName+`</td> <td>...</td> </tr>`);
                            $("#kalaForAddToSefarish tr").eq(0).css('background-color', 'rgb(0,142,201)'); 
                            const selectedGoodSn = data[0].GoodSn;
                            setAddedTosefarishKalaStuff(0,selectedGoodSn)
                        }
                    }

                    Mousetrap.bind("enter",()=>{
                        $("#selectKalaToSefarishBtn").trigger("click");
                    });

                    Mousetrap.bind("esc",()=>{
                        $("#searchGoodsModalAdd").modal("hide");
                    });
                }
            })
    }else{
        $("#selectKalaToSefarishBtn").trigger("click");
    }
}else{
    $(this).blur(); // Remove focus from the input
    $("#kalaForAddToSefarishTble").focus();
}
});

function closeNewOrderModal(){
    var rowCount = $("#newSefarishTbl tr").length-1;
    let allMoney=0;
    for(let i=1;i<=rowCount;i++){
       let rowMoney= $('#addsefarishtbl tr:nth-child('+i+') td:nth-child(11)').children('input').val();
       if((rowMoney.replace(/,/g, ''))>0){
            rowMoney=parseInt(rowMoney.replace(/,/g, ''));
            allMoney+=rowMoney;
       }
    }
    if(allMoney>0){
        swal({
            text: "می خواهید بدون ذخیره ببندید؟",
            icon: "warning",
            buttons: true,
            dangerMode: true,
            })
            .then((willDelete) => {
            if (willDelete) {
                window.location.reload();
                $("#newOrder").modal("hide");
            }});
    }else{
        $("#newOrder").modal("hide");
    }
}

$("#deleteOrderItemBtn").on("click",function(e){
    let rowToDelete=$("#deleteOrderItemBtn").val();
    if(rowToDelete){
        swal({
            title: "آیا مطمئین هستید؟",
            text: "اگر حذف شد، دیگر قادر به بازیابی دیتا نیستید!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
            })
            .then((willDelete) => {
                if(willDelete){
                    rowToDelete.remove();
                }
        });
        $(this).val($("#newSefarishTbl tr:last"))
    }else{
        $("#newSefarishTbl tr:last").remove();
    }
    calculateNewOrderMoney();
});


$("#searchKalaForAddToSefarishByCode").on("keyup", function (event) {

    if(event.keyCode!=40){
        if(event.keyCode!=13){
            let goodCode=$("#searchKalaForAddToSefarishByCode").val();
            let tableBody=$("#kalaForAddToSefarish");
            $.get(baseUrl + '/searchKalaByCode', { code: goodCode }, function (data, status) {
                if (status == 'success') {
                    tableBody.empty();
                    let i=0;
                    for (const element of data) {
                        i++;
                        if(i!=1){
                            tableBody.append(`<tr onclick="setAddedTosefarishKalaStuff(this,`+element.GoodSn+`)"> <td>`+(i)+`<inpu type="radio" value="${element.GoodSn}" class="d-none"/></td> <td> `+element.GoodCde+` </td><td> `+element.GoodName+`</td> <td>...</td> </tr>`);
                        }else{
                            tableBody.append(`<tr onclick="setAddedTosefarishKalaStuff(this,`+element.GoodSn+`)"> <td>`+(i)+`<inpu type="radio" value="${element.GoodSn}" class="d-none"/></td> <td> `+element.GoodCde+` </td><td> `+element.GoodName+`</td> <td>...</td> </tr>`);
                            
                            $("#kalaForAddToSefarish tr").eq(0).css('background-color', 'rgb(0,142,201)'); 
                            const selectedGoodSn = data[0].GoodSn;
                            setAddedTosefarishKalaStuff(0,selectedGoodSn)
                        }
                    }

                

                    
                    Mousetrap.bind("enter",()=>{
                        $("#selectKalaToSefarishBtn").trigger("click");
                    });
                }
            });
        }else{
            $("#selectKalaToSefarishBtn").trigger("click");
        }
    }else{
        $(this).blur(); // Remove focus from the input
        $("#kalaForAddToSefarishTble").focus();
    }
});








function setAddedTosefarishKalaStuff(element,goodSn){
    
    if(isNaN(element)){
        $("tr").removeClass('selected');
        $("#kalaForAddToSefarish tr").css('background-color', '');
        $(element).addClass("selected")
    }else{
        $("tr").removeClass('selected');
    }
    
 if($("#selectKalaToSefarishBtn")){
    $("#selectKalaToSefarishBtn").val(goodSn)
 }
 let customerSn=$("#customerForSefarishId").val();
 $.ajax({
    method: 'get',
    async: true,
    url: baseUrl + "/getSendItemInfo",
    data: {
        goodSn: goodSn,
        stockId: 23,
        customerSn: customerSn
    },
    success: function (response) {
        if(response[0][0]){
            
            if (!isNaN(parseInt(response[0][0].Amount))) {
                let amount=0
                if(response[0][0].Amount>1){
                    amount=response[0][0].Amount;
                }
                $("#StockExistanceOrderAdd").text(parseInt(amount).toLocaleString("en-us"));
            } else {
                $("#StockExistanceOrderAdd").text(0);
            }
        }else {
            $("#StockExistanceOrderAdd").text(0);
        }
        if(response[1][0]){

            if (!isNaN(parseInt(response[1][0].Price3))) {
                let price=0
                if(response[1][0].Price3>1){
                    price=response[1][0].Price3
                }
                $("#SalePriceOrderAdd").text(parseInt(price/ 10).toLocaleString("en-us"));
            } else {
                $("#SalePriceOrderAdd").text(0);
            }
        } else {
            $("#SalePriceOrderAdd").text(0);
        }

        if (response[2][0]) {

            if (!isNaN(parseInt(response[2][0].Fi))) {
                $("#AddLastPriceCustomer").text(parseInt(response[2][0].Fi / 10).toLocaleString("en-us"));
            } else {
                $("#AddLastPriceCustomer").text(0);
            }
        }else {
            $("#AddLastPriceCustomer").text(0);
        }

        if([3][0]){
            if (!isNaN(parseInt(response[3][0].Fi))) {
                $("#PriceOrderAdd").text(parseInt(response[3][0].Fi / 10).toLocaleString("en-us"));
            } else {
                $("#PriceOrderAdd").text(0);
            }
        }else {
            $("#PriceOrderAdd").text(0);
        }
    },
    error: function (error) {
        //alert("get item existance error found");
    }
})
}

$("#selectKalaToSefarishBtn").on("click",function(){
    var rowCount = $("#newSefarishTbl tr").length-1;
    let allMoney=0;
    for(let i=1;i<=rowCount;i++){
       let rowGoodSn= $('#addsefarishtbl tr:nth-child('+i+') td:nth-child(15)').children('input').val();
       if(rowGoodSn==$(this).val()){
        alert("کالای انتخاب شده قبلا اضافه شده است.")
        return
       }
    }
    
$.get(baseUrl+"/searchKalaByID",{goodSn:$(this).val()},function(data,status){
    if(status=="success"){
        let row=data.map((element,index)=> `<tr  onclick="checkAddedKalaToSefarishAmount(this)">
                                                <td style="width:30px!important;">`+($("#rowTaker").val())+`</td>
                                                <td style="width:40px!important;" class="td-part-input"> <input  type="number" value="`+element.GoodCde+`" class="td-input td-inputCode form-control"></td>
                                                <td style="width:130px!important;" class="td-part-input"> <input  type="text" value="`+element.GoodName+`" class="td-input td-inputCodeName form-control"></td>
                                                <td style="width:50px!important;" class="td-part-input"> <input  type="text" value="`+element.firstUnit+`" class="td-input td-inputFirstUnit form-control"></td>
                                                <td style="width:70px!important;" class="td-part-input"> <input  type="text" value="`+element.secondUnit+`" class="td-input td-inputSecondUnit form-control"></td>
                                                <td style="width:70px!important;" class="td-part-input"> <input name="packAmount${$("#rowTaker").val()}" type="number"  class="td-input td-inputSecondUnitAmount form-control"></td>
                                                <td style="width:50px!important;" class="td-part-input"> <input value="0" class="td-input td-inputEachFirstUnitAmount form-control"></td>
                                                <td style="width:70px!important;" class="td-part-input"> <input name="firstUnitAmount${$("#rowTaker").val()}" type="number" class="td-input td-inputFirstUnitAmount form-control"></td>
                                                <td style="width:70px!important;" class="td-part-input"> <input name="Price3${$("#rowTaker").val()}" type="text"  value="`+parseInt(element.Price3).toLocaleString("en-us")+`" class="td-input td-inputFirstUnitPrice form-control"></td>
                                                <td style="width:70px!important;" class="td-part-input"> <input name="packPrice${$("#rowTaker").val()}" type="text" class="td-input td-inputSecondUnitPrice form-control"></td>
                                                <td style="width:70px!important;" class="td-part-input"> <input name="allPrice${$("#rowTaker").val()}" type="text" class="td-input td-inputAllPrice form-control"></td>
                                                <td style="width:70px!important;" class="td-part-input"> <input type="text" class="td-input td-inputErsalType form-control"></td>
                                                <td style="width:52px!important;" class="td-part-input"> <input name="description${$("#rowTaker").val()}" type="text" class="td-input td-inputDescription form-control"></td>
                                                <td class="td-part-input d-none"> <input type="text" value="`+element.AmountUnit+`" class="td-input form-control"></td>
                                                <td class="td-part-input d-none"> 
                                                    <input type="radio" value="`+element.GoodSn+`" class="td-input form-control">
                                                    <input name="goodSn${$("#rowTaker").val()}" type="text" value="`+element.GoodSn+`" class="td-input form-control">
                                                </td>
                                                <td class="td-part-input d-none"> 
                                                    <input type="text" value="`+element.lastBuyFi+`" class="td-input form-control">
                                                </td>
                                            </tr>`)
        $(`#addsefarishtbl tr:nth-child(`+$("#rowTaker").val()+`)`).replaceWith(row);
        $(`#addsefarishtbl tr:nth-child(`+$("#rowTaker").val()+`) td:nth-child(6) input`).focus();
        $(`#addsefarishtbl tr:nth-child(`+$("#rowTaker").val()+`) td:nth-child(6) input`).select();

        
        checkAddedKalaToSefarishAmountAfterAdd(data[0].GoodSn);
        }
    });

    $("#searchGoodsModalAdd").modal("hide");
});

$("#addNewOrderForm").on("keydown",function(event){

    if (event.keyCode == 13) {
        event.preventDefault();
    }
})                  
                    

$(document).on("keyup",".td-inputDescription",(e)=>{
    if((e.keyCode === 9 ||e.keyCode === 13)  && ($(e.target).parents("tr").index()+1)==$("#addsefarishtbl tr").length && ($('#addsefarishtbl tr:nth-child('+($(e.target).parents("tr").index()+1)+') td:nth-child(2)').children('input').val().length)>0){
            let row=`<tr onclick="checkAddedKalaToSefarishAmount(this)">
                        <td style="width:30px!important;">`+($(e.target).parents("tr").index()+2)+`</td>
                        <td style="width:40px!important;" class="td-part-input"> <input type="text"  class="td-input td-inputCode form-control"></td>
                        <td style="width:130px!important;" class="td-part-input"> <input type="text" class="td-input td-inputCodeName form-control"></td>
                        <td style="width:50px!important;" class="td-part-input"> <input type="text"  class="td-input td-inputFirstUnit form-control"></td>
                        <td style="width:70px!important;" class="td-part-input"> <input type="text"  class="td-input td-inputFirstUnit form-control"></td>
                        <td style="width:70px!important;" class="td-part-input"> <input type="text"  class="td-input td-inputSecondUnitAmount form-control"></td>
                        <td style="width:50px!important;" class="td-part-input"> <input type="text"  class="td-input td-inputEachFirstUnitAmount form-control"></td>
                        <td style="width:70px!important;" class="td-part-input"> <input type="text"  class="td-input td-inputFirstUnitAmount form-control"></td>
                        <td style="width:70px!important;" class="td-part-input"> <input type="text"  class="td-input td-inputFirstUnitPrice form-control"></td>
                        <td style="width:70px!important;" class="td-part-input"> <input type="text"  class="td-input td-inputSecondUnitPrice form-control"></td>
                        <td style="width:70px!important;" class="td-part-input"> <input type="text"  class="td-input td-inputAllPrice form-control"></td>
                        <td style="width:70px!important;" class="td-part-input"> <input type="text"  class="td-input td-inputErsalType form-control"></td>
                        <td style="width:52px!important;" class="td-part-input"> <input type="text"  class="td-input td-inputDescription form-control"></td>
                        <td class="td-part-input d-none"><input type="text" value="1" class="td-input form-control"><input type="checkbox" name="orderBYSs[]" value="" class="td-input form-control" checked></td>
                        <td  class="td-part-input d-none"><input type="text" value="0" class="td-input form-control"></td>
                    </tr>`;
    $("#addsefarishtbl").append(row);

    } 
    if(e.keyCode===9 || e.keyCode===13){
        var $currentInput = $(e.target);
        var $currentTd = $currentInput.closest('td');
        var $currentTr = $currentTd.closest('tr');
        var $nextTr = $currentTr.next('tr');
        if ($nextTr.length > 0) {
          var $nextTd = $nextTr.find('td:eq(1)');
          var $nextInput = $nextTd.find('input');
          if ($nextInput.length > 0) {
            $nextInput.focus();
          }
        }
    }
});

$(document).on("keyup",".td-inputSecondUnitAmount", (e)=>{
    if(($('#addsefarishtbl tr:nth-child('+$('#addsefarishtbl tr').length+') td:nth-child(2)').children('input').val().length)<1){
        $(`#addsefarishtbl tr:nth-child(`+$('#addsefarishtbl tr').length+`)`).replaceWith('');
    }
    let rowindex=$(e.target).parents("tr").index()+1
    let packAmount=$(e.target).val().replace(/,/g, '')
    let subPackUnits=parseInt($('#addsefarishtbl tr:nth-child('+rowindex+') td:nth-child(7)').children('input').val().replace(/,/g, ''));
    let GoodSn=parseInt($('#addsefarishtbl tr:nth-child('+rowindex+') td:nth-child(15)').children('input').val());
    let amountUnit=$($('#addsefarishtbl tr:nth-child('+rowindex+') td:nth-child(14)').children('input')).val().replace(/,/g, '');
    let price=$($('#addsefarishtbl tr:nth-child('+rowindex+') td:nth-child(9)').children('input')).val().replace(/,/g, '');
    let allAmountUnit=(packAmount*amountUnit)+subPackUnits;

    if(allAmountUnit>parseInt($("#goodAmountInStock").text().replace(/,/g, ''))){
        swal({
            title: "به این اندازه موجودی ندارد.",
            text:"میخواهید ثبت شود؟",
            icon: "warning",
            buttons: true,
            dangerMode: true,
            }).then((willDelete) => {
                if(willDelete){
                    let allPrice=allAmountUnit*price;
                    let packPrice=amountUnit*price;
                    $('#addsefarishtbl tr:nth-child('+rowindex+') td:nth-child(8)').children('input').val(parseInt(allAmountUnit).toLocaleString("en-us"));
                    $('#addsefarishtbl tr:nth-child('+rowindex+') td:nth-child(11)').children('input').val(parseInt(allPrice).toLocaleString("en-us"));
                    $('#addsefarishtbl tr:nth-child('+rowindex+') td:nth-child(10)').children('input').val(parseInt(packPrice).toLocaleString("en-us"));
                    $('#addsefarishtbl tr:nth-child('+rowindex+') td:nth-child(14) input[type="checkbox"]').val(GoodSn+'_'+packAmount+'_'+allAmountUnit+'_'+allPrice+'_'+packPrice+'_'+price);
                    var $currentInput = $(e.target);
                    var $currentTd = $currentInput.closest('td');
                    var $nextTd = $currentTd.next('td');
                    var $nextInput = $nextTd.find('input');
                        $($nextInput).focus();
                }else{
                    var $currentInput = $(e.target);
                    $($currentInput).focus();

                }
            })
    }else{
        let allPrice=allAmountUnit*price;
        let packPrice=amountUnit*price;
        $('#addsefarishtbl tr:nth-child('+rowindex+') td:nth-child(8)').children('input').val(parseInt(allAmountUnit).toLocaleString("en-us"));
        $('#addsefarishtbl tr:nth-child('+rowindex+') td:nth-child(11)').children('input').val(parseInt(allPrice).toLocaleString("en-us"));
        $('#addsefarishtbl tr:nth-child('+rowindex+') td:nth-child(10)').children('input').val(parseInt(packPrice).toLocaleString("en-us"));
        $('#addsefarishtbl tr:nth-child('+rowindex+') td:nth-child(14) input[type="checkbox"]').val(GoodSn+'_'+packAmount+'_'+allAmountUnit+'_'+allPrice+'_'+packPrice+'_'+price);
    }

    calculateNewOrderMoney();
    if(e.keyCode==9 || e.keyCode==13){
        var $currentInput = $(e.target);
        if(($currentInput.val()>0)){
            var $nextInput = $currentInput.closest('td').next('td').find('input');
            
            if($nextInput.length > 0) {
                $nextInput.focus();
            }
        }else{

            alert("مقدار کالا را وارد کنید.")

        }
    }
});

$(document).on("keyup",".td-inputEachFirstUnitAmount", (e)=>{
    if(($('#addsefarishtbl tr:nth-child('+$('#addsefarishtbl tr').length+') td:nth-child(2)').children('input').val().replace(/,/g, '').length)<1){
        $(`#addsefarishtbl tr:nth-child(`+$('#addsefarishtbl tr').length+`)`).replaceWith('');
    }
    let rowindex=$(e.target).parents("tr").index()+1
    let packAmount=parseInt($('#addsefarishtbl tr:nth-child('+rowindex+') td:nth-child(6)').children('input').val().replace(/,/g, ''));
    let subPackUnits=parseInt($(e.target).val().replace(/,/g, ''))
    let amountUnit=$($('#addsefarishtbl tr:nth-child('+rowindex+') td:nth-child(14)').children('input')).val().replace(/,/g, '');
    let price=$($('#addsefarishtbl tr:nth-child('+rowindex+') td:nth-child(9)').children('input')).val().replace(/,/g, '');

    let allAmountUnit=(packAmount*amountUnit)+subPackUnits;
    packAmount=parseInt(allAmountUnit/amountUnit);
    subPackUnits=allAmountUnit%amountUnit;
    let allPrice=allAmountUnit*price;
    $('#addsefarishtbl tr:nth-child('+rowindex+') td:nth-child(8)').children('input').val(parseInt(allAmountUnit).toLocaleString("en-us"));
    $('#addsefarishtbl tr:nth-child('+rowindex+') td:nth-child(11)').children('input').val(parseInt(allPrice).toLocaleString("en-us"));
    $('#addsefarishtbl tr:nth-child('+rowindex+') td:nth-child(6)').children('input').val(packAmount)
    $(e.target).val(subPackUnits)
    if(e.keyCode==9 || e.keyCode==13){
        var $currentInput = $(e.target);
        var $nextInput = $currentInput.closest('td').next('td').find('input');
        if ($nextInput.length > 0) {
        $nextInput.focus();
        }
    }
});

$(document).on("keydown",".td-inputFirstUnitPrice", (e)=>{
    let rowindex=$(e.target).parents("tr").index()+1
    if((e.keyCode>=65 && e.keyCode<=90)|| ((e.keyCode>=48 && e.keyCode<=57) || (e.keyCode>=96 && e.keyCode<=105))){

                if(($('#addsefarishtbl tr:nth-child('+$('#addsefarishtbl tr').length+') td:nth-child(2)').children('input').val().length)<1){
                    $(`#addsefarishtbl tr:nth-child(`+$('#addsefarishtbl tr').length+`)`).replaceWith('');
                }
                
                let packAmount=parseInt($('#addsefarishtbl tr:nth-child('+rowindex+') td:nth-child(6)').children('input').val().replace(/,/g, ''));
                let price=parseInt($(e.target).val().replace(/,/g, ''))
                let subPackUnits=parseInt($('#addsefarishtbl tr:nth-child('+rowindex+') td:nth-child(7)').children('input').val().replace(/,/g, ''));
                let amountUnit=$($('#addsefarishtbl tr:nth-child('+rowindex+') td:nth-child(14)').children('input')).val().replace(/,/g, '');
                // let price=$($('#addsefarishtbl tr:nth-child('+rowindex+') td:nth-child(9)').children('input')).val();
                let allAmountUnit=(packAmount*amountUnit)+subPackUnits;
                let allPrice=allAmountUnit*price;
                let packPrice=amountUnit*price;
                $('#addsefarishtbl tr:nth-child('+rowindex+') td:nth-child(8)').children('input').val(allAmountUnit);
                $('#addsefarishtbl tr:nth-child('+rowindex+') td:nth-child(11)').children('input').val(allPrice);
                $('#addsefarishtbl tr:nth-child('+rowindex+') td:nth-child(10)').children('input').val(packPrice);
                
            
        }else{
            if(($('#addsefarishtbl tr:nth-child('+$('#addsefarishtbl tr').length+') td:nth-child(2)').children('input').val().length)<1){
                $(`#addsefarishtbl tr:nth-child(`+$('#addsefarishtbl tr').length+`)`).replaceWith('');
            }
            let packAmount=parseInt($('#addsefarishtbl tr:nth-child('+rowindex+') td:nth-child(6)').children('input').val().replace(/,/g, ''));
            let price=parseInt($(e.target).val().replace(/,/g, ''))
            let subPackUnits=parseInt($('#addsefarishtbl tr:nth-child('+rowindex+') td:nth-child(7)').children('input').val().replace(/,/g, ''));
            let amountUnit=$($('#addsefarishtbl tr:nth-child('+rowindex+') td:nth-child(14)').children('input')).val().replace(/,/g, '');
            // let price=$($('#addsefarishtbl tr:nth-child('+rowindex+') td:nth-child(9)').children('input')).val();
            let allAmountUnit=(packAmount*amountUnit)+subPackUnits;
            let allPrice=allAmountUnit*price;
            let packPrice=amountUnit*price;
            $('#addsefarishtbl tr:nth-child('+rowindex+') td:nth-child(8)').children('input').val(allAmountUnit);
            $('#addsefarishtbl tr:nth-child('+rowindex+') td:nth-child(11)').children('input').val(allPrice);
            $('#addsefarishtbl tr:nth-child('+rowindex+') td:nth-child(10)').children('input').val(packPrice);
        }
    if(e.keyCode==9 || e.keyCode==13){
        let lastBuyFi=parseInt($('#addsefarishtbl tr:nth-child('+rowindex+') td:nth-child(16)').children('input').val().replace(/,/g, ''));
        
        let givenFi=parseInt($(e.target).val().replace(/,/g, ''))
        if(givenFi<lastBuyFi){
            swal({
                title: "توجه!",
                text:"قیمت وارد شده نسبت به قیمت خرید بیشتر است. می خواهید ثبت کنید؟",
                icon: "warning",
                buttons: true,
                dangerMode: true,
                }).then(

                (willAdd)=>{
                    if(!willAdd){
                        $(e.target).focus()
                        if(($('#addsefarishtbl tr:nth-child('+$('#addsefarishtbl tr').length+') td:nth-child(2)').children('input').val().length)<1){
                            $(`#addsefarishtbl tr:nth-child(`+$('#addsefarishtbl tr').length+`)`).replaceWith('');
                        }
                        let rowindex=$(e.target).parents("tr").index()+1
                        let packAmount=parseInt($('#addsefarishtbl tr:nth-child('+rowindex+') td:nth-child(6)').children('input').val().replace(/,/g, ''));
                        let price=parseInt($(e.target).val().replace(/,/g, ''))
                        let subPackUnits=parseInt($('#addsefarishtbl tr:nth-child('+rowindex+') td:nth-child(7)').children('input').val().replace(/,/g, ''));
                        let amountUnit=$($('#addsefarishtbl tr:nth-child('+rowindex+') td:nth-child(14)').children('input')).val().replace(/,/g, '');
                        // let price=$($('#addsefarishtbl tr:nth-child('+rowindex+') td:nth-child(9)').children('input')).val();
                        let allAmountUnit=(packAmount*amountUnit)+subPackUnits;
                        let allPrice=allAmountUnit*price;
                        let packPrice=amountUnit*price;
                        $('#addsefarishtbl tr:nth-child('+rowindex+') td:nth-child(8)').children('input').val(allAmountUnit);
                        $('#addsefarishtbl tr:nth-child('+rowindex+') td:nth-child(11)').children('input').val(allPrice);
                        $('#addsefarishtbl tr:nth-child('+rowindex+') td:nth-child(10)').children('input').val(packPrice);
                    }else{
                        let packAmount=parseInt($('#addsefarishtbl tr:nth-child('+rowindex+') td:nth-child(6)').children('input').val().replace(/,/g, ''));
                        let price=parseInt($(e.target).val().replace(/,/g, ''))
                        let subPackUnits=parseInt($('#addsefarishtbl tr:nth-child('+rowindex+') td:nth-child(7)').children('input').val().replace(/,/g, ''));
                        let amountUnit=$($('#addsefarishtbl tr:nth-child('+rowindex+') td:nth-child(14)').children('input')).val().replace(/,/g, '');
                        // let price=$($('#addsefarishtbl tr:nth-child('+rowindex+') td:nth-child(9)').children('input')).val();
                        let allAmountUnit=(packAmount*amountUnit)+subPackUnits;
                        let allPrice=allAmountUnit*price;
                        let packPrice=amountUnit*price;
                        $('#addsefarishtbl tr:nth-child('+rowindex+') td:nth-child(8)').children('input').val(allAmountUnit);
                        $('#addsefarishtbl tr:nth-child('+rowindex+') td:nth-child(11)').children('input').val(allPrice);
                        $('#addsefarishtbl tr:nth-child('+rowindex+') td:nth-child(10)').children('input').val(packPrice);
                        var currentInput = $(e.target);
                        var nextInput = currentInput.closest('td').next('td').find('input');
                        
                        $(nextInput).focus();
                    }
                }
            )
        }
        var $currentInput = $(e.target);
        var $nextInput = $currentInput.closest('td').next('td').find('input');
        if ($nextInput.length > 0) {
        $nextInput.focus();
        }
    }

});


$(document).on("keyup",".td-inputAllPrice", (e)=>{

    if(($('#addsefarishtbl tr:nth-child('+$('#addsefarishtbl tr').length+') td:nth-child(2)').children('input').val().length)<1){
        $(`#addsefarishtbl tr:nth-child(`+$('#addsefarishtbl tr').length+`)`).replaceWith('');
    }
    let rowindex=$(e.target).parents("tr").index()+1
    let packAmount=parseInt($('#addsefarishtbl tr:nth-child('+rowindex+') td:nth-child(6)').children('input').val());
    if(!$(e.target).val()){
        $(e.target).val(0)
    }
    let allPrice=parseInt($(e.target).val().replace(/,/g, ''))
    let subPackUnits=parseInt($('#addsefarishtbl tr:nth-child('+rowindex+') td:nth-child(7)').children('input').val());
    let amountUnit=$($('#addsefarishtbl tr:nth-child('+rowindex+') td:nth-child(14)').children('input')).val();
    let price=$($('#addsefarishtbl tr:nth-child('+rowindex+') td:nth-child(9)').children('input')).val().replace(/,/g, '');
    // $($('#addsefarishtbl tr:nth-child('+rowindex+') td:nth-child(9)').children('input')).val(price);
    let allAmountUnit=allPrice/price;
    $('#addsefarishtbl tr:nth-child('+rowindex+') td:nth-child(8)').children('input').val(allAmountUnit);
    packAmount=parseInt(allAmountUnit/amountUnit)
    subPackUnits=allAmountUnit%amountUnit;
    $('#addsefarishtbl tr:nth-child('+rowindex+') td:nth-child(11)').children('input').val(parseInt(allPrice).toLocaleString("en-us"));
    $('#addsefarishtbl tr:nth-child('+rowindex+') td:nth-child(7)').children('input').val(subPackUnits)
    $('#addsefarishtbl tr:nth-child('+rowindex+') td:nth-child(6)').children('input').val(packAmount)
    if(e.keyCode==9 || e.keyCode==13){
        var $currentInput = $(e.target);
        var $nextInput = $currentInput.closest('td').next('td').find('input');
        
        if ($nextInput.length > 0) {
        $nextInput.focus();
        }
    }

});


$(document).on("keyup",".td-inputFirstUnitAmount", (e)=>{
    if((e.keyCode>=65 && e.keyCode<=90)|| ((e.keyCode>=48 && e.keyCode<=57) || (e.keyCode>=96 && e.keyCode<=105))){

        let rowindex=$(e.target).parents("tr").index()+1
        // let packAmount=parseInt($('#addsefarishtbl tr:nth-child('+rowindex+') td:nth-child(6)').children('input').val().replace(/,/g, ''));
        let price=$($('#addsefarishtbl tr:nth-child('+rowindex+') td:nth-child(9)').children('input')).val().replace(/,/g, '');
        //let subPackUnits=parseInt($('#addsefarishtbl tr:nth-child('+rowindex+') td:nth-child(7)').children('input').val().replace(/,/g, ''));
        let amountUnit=$($('#addsefarishtbl tr:nth-child('+rowindex+') td:nth-child(14)').children('input')).val().replace(/,/g, '');
        // let price=$($('#addsefarishtbl tr:nth-child('+rowindex+') td:nth-child(9)').children('input')).val();
        let allAmountUnit=parseInt($(e.target).val().replace(/,/g, ''));
        let packAmount=parseInt(allAmountUnit/amountUnit);
        let subPackUnits=allAmountUnit%amountUnit;
        let allPrice=allAmountUnit*price;
        let packPrice=amountUnit*price;
        $('#addsefarishtbl tr:nth-child('+rowindex+') td:nth-child(8)').children('input').val(allAmountUnit);
        $('#addsefarishtbl tr:nth-child('+rowindex+') td:nth-child(11)').children('input').val(allPrice);
        $('#addsefarishtbl tr:nth-child('+rowindex+') td:nth-child(10)').children('input').val(packPrice);
        $('#addsefarishtbl tr:nth-child('+rowindex+') td:nth-child(6)').children('input').val(packAmount);
        $('#addsefarishtbl tr:nth-child('+rowindex+') td:nth-child(7)').children('input').val(subPackUnits);
    }
    if(e.keyCode==9 || e.keyCode==13){
        var $currentInput = $(e.target);
        var $nextInput = $currentInput.closest('td').next('td').find('input');
        if ($nextInput.length > 0) {
        $nextInput.focus();
        }
    }
})

$(document).on("keyup",".td-inputSecondUnitPrice", (e)=>{
    if(e.keyCode==9 || e.keyCode==13){
        var $currentInput = $(e.target);
        var $nextInput = $currentInput.closest('td').next('td').find('input');
        if ($nextInput.length > 0) {
            $nextInput.focus();
        }
    }
})


$(document).on("keyup",".td-inputErsalType", (e)=>{
    if(e.keyCode==9 || e.keyCode==13){
        var $currentInput = $(e.target);
        var $nextInput = $currentInput.closest('td').next('td').find('input');
        
        if ($nextInput.length > 0) {
        $nextInput.focus();
        }
    }
});

$("#checkExitanceForAddToSefarish").on("change",()=>{
    let customerSn=$("#customerForSefarishId").val();
    if($("#checkExitanceForAddToSefarish").is(":checked")){
        if(customerSn==undefined || customerSn==null){
            alert("مشتری را انتخاب کنید!");
            $("#checkExitanceForAddToSefarish").prop("checked",false);
        }
    }
});

function checkAddedKalaToSefarishAmount(row){
    $("#deleteOrderItemBtn").val(row);
    $(row).find('input:radio').prop('checked', true);
    let input = $(row).find('input:radio');
    let goodSn=$(input).val();
    if(!goodSn){
        return
    }
    let customerSn=$("#customerForSefarishId").val();
    if($("#checkExitanceForAddToSefarish").is(":checked")){
        $.get(baseUrl+"/getGoodInfoForAddOrderItem",{
            goodSn: goodSn,
            customerSn:customerSn,
            stockId: 23
        },(respond,status)=>{
            if(respond[1][0]){
                if(!isNaN(respond[1][0].Amount)){
                    let amount=0;
                    if(respond[1][0].Amount>=1){
                        amount=respond[1][0].Amount
                    }
                    $("#goodAmountInStock").text(parseInt(amount).toLocaleString("en-us"));

                }else{
                    $("#goodAmountInStock").text(0);

                }

            }else{
                $("#goodAmountInStock").text(0);

            }

            if(respond[2][0]){
                if(!isNaN(respond[2][0].Price3)){
                    let price=0;
                    if(respond[2][0].Price3>=1){
                        price=respond[2][0].Price3;
                    }
                    $("#goodPriceAddSefarish").text(parseInt(price).toLocaleString("en-us"));

                }else{
                    $("#goodPriceAddSefarish").text(0);

                }
            }else{
                $("#goodPriceAddSefarish").text(0);

            }
            if(respond[4][0]){
                if(!isNaN(respond[4][0].Fi)){
                    $("#lastSalePriceAddSefarish").text(parseInt(respond[4][0].Fi).toLocaleString("en-us"));

                }else{
                    $("#lastSalePriceAddSefarish").text(0);

                }
            }else{
                $("#lastSalePriceAddSefarish").text(0);

            }

            if(respond[3][0]){
                if(!isNaN(respond[3][0].Price3)){
                    $("#lastSalePriceToThisCustomerAddSefarish").text(parseInt(respond[3][0].Price3).toLocaleString("en-us"));
                }else{
                    $("#lastSalePriceToThisCustomerAddSefarish").text(0);
                }
            }else{
                $("#lastSalePriceToThisCustomerAddSefarish").text(0);
            }
            

        })
    }else{
        $("#goodAmountInStock").text(0);

        $("#goodPriceAddSefarish").text(0);

        $("#lastSalePriceToThisCustomerAddSefarish").text(0);

        $("#lastSalePriceAddSefarish").text(0);
    }
    const previouslySelectedRow = document.querySelector('.selected');
    if(previouslySelectedRow) {
        previouslySelectedRow.classList.remove('selected');
        //previouslySelectedRow.children().classList.remove('selected');
    }
    row.classList.add('selected');
}

function checkAddedKalaToSefarishAmountAfterAdd(goodSn){

    if(!goodSn){
        return
    }

    let customerSn=$("#customerForSefarishId").val();

    if($("#checkExitanceForAddToSefarish").is(":checked")){
        $.get(baseUrl+"/getGoodInfoForAddOrderItem",{
            goodSn: goodSn,
            customerSn:customerSn,
            stockId: 23
        },(respond,status)=>{
            console.log(respond)
            if(respond[1][0]){
                if(!isNaN(respond[1][0].Amount)){
                    let amount=0;
                    if(respond[1][0].Amount>=1){
                        amount=respond[1][0].Amount;
                    }
                    $("#goodAmountInStock").text(parseInt(amount).toLocaleString("en-us"));

                }else{
                    $("#goodAmountInStock").text(0);

                }

            }else{
                $("#goodAmountInStock").text(0);

            }

            if(respond[2][0]){
                if(!isNaN(respond[2][0].Price3)){
                    let price=0;
                    if(respond[2][0].Price3>0){
                        price=respond[2][0].Price3;
                    }
                    $("#goodPriceAddSefarish").text(parseInt(price).toLocaleString("en-us"));

                }else{
                    $("#goodPriceAddSefarish").text(0);

                }
            }else{
                $("#goodPriceAddSefarish").text(0);

            }
            if(respond[4][0]){
                if(!isNaN(respond[4][0].Fi)){
                    let fi=0;
                    if(respond[4][0].Fi>0){
                        fi=respond[4][0].Fi;
                    }
                    $("#lastSalePriceAddSefarish").text(parseInt(fi).toLocaleString("en-us"));

                }else{
                    $("#lastSalePriceAddSefarish").text(0);

                }
            }else{
                $("#lastSalePriceAddSefarish").text(0);

            }

            if(respond[3][0]){
                if(!isNaN(respond[3][0].Price3)){
                    let price=0;
                    if(respond[3][0].Price3>0){
                        price=respond[3][0].Price3
                    }
                    $("#lastSalePriceToThisCustomerAddSefarish").text(parseInt(price).toLocaleString("en-us"));
                }else{
                    $("#lastSalePriceToThisCustomerAddSefarish").text(0);
                }
            }else{
                $("#lastSalePriceToThisCustomerAddSefarish").text(0);
            }
            

        })
    }else{
        $("#goodAmountInStock").text(0);

        $("#goodPriceAddSefarish").text(0);

        $("#lastSalePriceToThisCustomerAddSefarish").text(0);

        $("#lastSalePriceAddSefarish").text(0);
    }
    const previouslySelectedRow = document.querySelector('.selected');
    if(previouslySelectedRow) {
        previouslySelectedRow.classList.remove('selected');
        //previouslySelectedRow.children().classList.remove('selected');
    }
}

function checkAddedKalaAmountToSefarishEdit(goodSn){

    if(!goodSn){
        return
    }

    let customerSn=$("#customerForSefarishIdEdit").val();

    if($("#checkExitanceForAddToSefarishEdit").is(":checked")){
        $.get(baseUrl+"/getGoodInfoForAddOrderItem",{
            goodSn: goodSn,
            customerSn:customerSn,
            stockId: 23
        },(respond,status)=>{
            console.log(respond)
            if(respond[1][0]){
                if(!isNaN(respond[1][0].Amount)){
                    let amount=0;
                    if(respond[1][0].Amount<1){
                        amount=0;
                    }else{
                        amount=respond[1][0].Amount;
                    }
                    $("#goodAmountInStockEdit").text(parseInt(amount).toLocaleString("en-us"));

                }else{
                    $("#goodAmountInStockEdit").text(0);

                }

            }else{
                $("#goodAmountInStockEdit").text(0);

            }

            if(respond[2][0]){
                if(!isNaN(respond[2][0].Price3)){
                    let price=0;
                    if(respond[2][0].Price3<1){
                        price=0;
                    }else{
                        price=respond[2][0].Price3;
                    }
                    $("#goodPriceAddSefarishEdit").text(parseInt(price).toLocaleString("en-us"));
                }else{
                    $("#goodPriceAddSefarishEdit").text(0);
                }
            }else{
                $("#goodPriceAddSefarishEdit").text(0);
            }
            if(respond[4][0]){
                if(!isNaN(respond[4][0].Fi)){
                    $("#lastSalePriceAddSefarishEdit").text(parseInt(respond[4][0].Fi).toLocaleString("en-us"));
                }else{
                    $("#lastSalePriceAddSefarishEdit").text(0);
                }
            }else{
                $("#lastSalePriceAddSefarishEdit").text(0);
            }

            if(respond[3][0]){
                if(!isNaN(respond[3][0].Price3)){
                    let price=0;
                    if(respond[3][0].Price3<1){
                        price=0;
                    }else{
                        price=respond[3][0].Price3;
                    }
                    $("#lastSalePriceToThisCustomerAddSefarishEdit").text(parseInt(price).toLocaleString("en-us"));
                }else{
                    $("#lastSalePriceToThisCustomerAddSefarishEdit").text(0);
                }
            }else{
                $("#lastSalePriceToThisCustomerAddSefarishEdit").text(0);
            }
            

        })
    }else{
        $("#goodAmountInStockEdit").text(0);

        $("#goodPriceAddSefarishEdit").text(0);

        $("#lastSalePriceToThisCustomerAddSefarishEdit").text(0);

        $("#lastSalePriceAddSefarishEdit").text(0);
    }
    const previouslySelectedRow = document.querySelector('.selected');
    if(previouslySelectedRow) {
        previouslySelectedRow.classList.remove('selected');
        //previouslySelectedRow.children().classList.remove('selected');
    }
}

$("#newSefarishTbl").on("keyup",function(e){
    calculateNewOrderMoney();
})

function calculateNewOrderMoney(){
    var rowCount = $("#newSefarishTbl tr").length-1;
    let allMoney=0;
    for(let i=1;i<=rowCount;i++){
       let rowMoney= $('#addsefarishtbl tr:nth-child('+i+') td:nth-child(11)').children('input').val();
       if((rowMoney.replace(/,/g, ''))>0){
        allMoney+=parseInt(rowMoney.replace(/,/g, ''));
       }
    }
    $("#allMoneyTillEndRow").text(parseInt(allMoney).toLocaleString("en-us"));
    return parseInt(allMoney);
}



$("#newOrderTakhfifInput").on("keyup",function(e){
    let moneyAfterTakhfif=(parseInt(calculateNewOrderMoney())-parseInt($("#newOrderTakhfifInput").val()))
    $("#sumAllRowMoneyAfterTakhfif").text(parseInt(moneyAfterTakhfif).toLocaleString("en-us"));
    
})


$("#editOrderBtn").on("click", () => {
    $.ajax({
        method: 'get',
        url: baseUrl + '/getOrderDetail',
        async: true,
        data: {
            orderSn: $("#editOrderBtn").val()
        },
        success: function (response) {
            setActiveForm("addsefarishtblEdit")
            $("#editFactorNo").val(response[1][0].OrderNo);
            $("#customerForSefarishIdEdit").empty();
            $("#customerForSefarishIdEdit").append(`<option value='${response[1][0].PSN}'>${response[1][0].Name}</option>`);
            $("#customerAddressForSefarishEdit").empty();
            $("#SnHDSEdit").val(response[1][0].SnOrder);

            let amelInfo=response[9];
            let allAmel=0;
            amelInfo.forEach((element,index)=>{
                allAmel+=parseInt(element.Price);
                switch(element.SnAmel){
                    case '142':
                        {
                            $("#hamlMoneyModalEdit").val(parseInt(element.Price).toLocaleString("en-us"));
                            $("#hamlDescModalEdit").val(element.DescItem);
                        }
                        break;
                    case '143':
                        {
                            $("#nasbMoneyModalEdit").val(parseInt(element.Price).toLocaleString("en-us"));
                            $("#nasbDescModalEdit").val(element.DescItem);
                        }
                        break;
                    case '144':
                        {
                            $("#motafariqaMoneyModalEdit").val(parseInt(element.Price).toLocaleString("en-us"));
                            $("#motafariqaDescModalEdit").val(element.DescItem);
                        }
                        break;
                    case '168':
                        {
                            $("#bargiriMoneyModalEdit").val(parseInt(element.Price).toLocaleString("en-us"));
                            $("#bargiriDescModalEdit").val(element.DescItem);
                        }
                        break;
                    case '188':
                        {
                            $("#tarabariMoneyModalEdit").val(parseInt(element.Price).toLocaleString("en-us"));
                            $("#tarabariDescModalEdit").val(element.DescItem);
                        }
                        break;
                }
            });

            $("#allAmelMoneyEdit").text(parseInt(allAmel).toLocaleString("en-us"))

            if(response[5].length>0){
                response[5].forEach((element)=>{
                    if(element.AddressPeopel!=response[1][0].OrderAddress){
                        $("#customerAddressForSefarishEdit").append(`<option value="`+element.SnPeopelAddress+`_`+element.AddressPeopel+`">` + element.AddressPeopel + `</option>`);
                    }else{
                        $("#customerAddressForSefarishEdit").append(`<option value="`+element.SnPeopelAddress+`_`+element.AddressPeopel+`" selected>` + element.AddressPeopel + `</option>`);
                    
                    }
                })
            }else{
                $("#customerAddressForSefarishEdit").append(`<option value="0_`+response[1][0].OrderAddress+`" selected>` + response[1][0].OrderAddress + `</option>`);
                }
            $("#sendDateFromSefarishPageEdit").val(response[1][0].OrderDate);
            $("#customerCodeInputEdit").val(response[1][0].PCode);
            $("#searchCustomerNameInputEdit").val(response[1][0].Name);
            $("#phoneStrInputEdit").val(response[1][0].PhoneStr);
            
            let bdbsState=" تسویه "
            let bdbsColor="white"
            if(response[1][0].CustomerStatus>0){
                bdbsState="  بستانکار"
                bdbsColor="black"
            }
            if(response[1][0].CustomerStatus<0){
                bdbsState="  بدهکار" 
                bdbsColor="red"
            }
            $("#lastCustomerStatusEdit").text(parseInt(response[1][0].CustomerStatus).toLocaleString("en-us")+bdbsState);
            $("#lastCustomerStatusEdit").css("color","red")
            $(`#addsefarishtblEdit`).empty();
            let totalMoney=0;
            let takhfif=response[1][0].Takhfif;
            response[0].forEach((element,index) => {
                totalMoney+=parseInt(element.PriceAfterTakhfif)
                $("#addsefarishtblEdit").append(`<tr  onclick="checkAddedKalaOfOrderAmount(this)">
                                                <td style="width:30px!important;">`+(index+1)+`</td>
                                                <td style="width:40px!important;" class="td-part-input"> <input type="checkbox" name="editables[]" class="d-none" value="${element.GoodSn}" checked/> <input type="number" value="`+element.GoodCde+`" class="td-input td-inputCodeEdit form-control"></td>
                                                <td style="width:130px!important;" class="td-part-input"> <input  type="text" value="`+element.GoodName+`" class="td-input td-inputCodeNameEdit form-control"></td>
                                                <td style="width:50px!important;" class="td-part-input"> <input  type="text" value="`+element.firstUnit+`" class="td-input td-inputFirstUnitEdit form-control"></td>
                                                <td style="width:70px!important;" class="td-part-input"> <input  type="text" value="`+element.secondUnit+`" class="td-input td-inputSecondUnitEdit form-control"></td>
                                                <td style="width:70px!important;" class="td-part-input"> <input name="packAmount${element.GoodSn}" value="${parseInt(element.PackAmount).toLocaleString("en-us")}" type="text"  class="td-input td-inputSecondUnitAmountEdit form-control"></td>
                                                <td style="width:50px!important;" class="td-part-input"> <input name="JozeAmount${element.GoodSn}" value="${element.Amount%element.AmountUnit}" class="td-input td-inputEachFirstUnitAmountEdit form-control"></td>
                                                <td style="width:70px!important;" class="td-part-input"> <input name="Amount${element.GoodSn}" value="${parseInt(element.Amount).toLocaleString("en-us")}" type="text" class="td-input td-inputFirstUnitAmountEdit form-control"></td>
                                                <td style="width:70px!important;" class="td-part-input"> <input name="Fi${element.GoodSn}" type="text"  value="${parseInt(element.Fi).toLocaleString("en-us")}" class="td-input td-inputFirstUnitPriceEdit form-control"></td>
                                                <td style="width:70px!important;" class="td-part-input"> <input name="PackPrice${element.GoodSn}" type="text" value="${parseInt(element.FiPack).toLocaleString("en-us")}" class="td-input td-inputSecondUnitPriceEdit form-control"></td>
                                                <td style="width:70px!important;" class="td-part-input"> <input name="AllPrice${element.GoodSn}" type="text" value="${parseInt(element.PriceAfterTakhfif).toLocaleString("en-us")}" class="td-input td-inputAllPriceEdit form-control"></td>
                                                <td style="width:70px!important;" class="td-part-input"> <input name="ErsalType${element.GoodSn}" type="text" value=" " class="td-input td-inputErsalTypeEdit form-control"></td>
                                                <td style="width:52px!important;" class="td-part-input"> <input name="Description${element.GoodSn}" value="${element.DescRecord}" type="text" class="td-input td-inputDescriptionEdit form-control"></td>
                                                <td class="td-part-input d-none"> <input type="text" value="`+element.AmountUnit+`" class="td-input form-control"></td>
                                                <td class="td-part-input d-none"> 
                                                    <input type="radio" value="`+element.GoodSn+`" class="td-input form-control">
                                                    <input name="goodSn${element.GoodSn}" type="text" value="`+element.GoodSn+`" class="td-input form-control">
                                                </td>
                                                <td class="td-part-input d-none"> 
                                                    <input type="text" value="`+element.lastBuyFi+`" class="td-input form-control">
                                                </td>
                                            </tr>`)
                                    });
                $("#allMoneyTillEndRowEdit").text(parseInt(totalMoney).toLocaleString("en-us"));
                $("#sumAllRowMoneyAfterTakhfifEdit").text(((parseInt(totalMoney)+parseInt(allAmel))-parseInt(takhfif)).toLocaleString("en-us"));
                checkAddedKalaAmountToSefarishEdit(response[0][0].GoodSn);
                },
                error: function (error) {
                }
            });
            
            let hamlMoneyEdit=$("#hamlMoneyEdit").val();
            let nasbMoneyEdit=$("#nasbMoneyEdit").val();
            let motafariqaMoneyEdit=$("#motafariqaMoneyEdit").val();
            let bargiriMoneyEdit=$("#bargiriMoneyEdit").val();
            let tarabariMoneyEdit=$("#tarabariMoneyEdit").val();

            let allAmelMoneyEdit=parseInt(hamlMoneyEdit)+parseInt(nasbMoneyEdit)+parseInt(motafariqaMoneyEdit)+parseInt(bargiriMoneyEdit)+parseInt(tarabariMoneyEdit);
            $("#allAmelMoneyEdit").text(allAmelMoneyEdit);

            if (!($('.modal.in').length)) {
                $('.modal-dialog').css({
                    top: 0,
                    left: 0
                });
            }
            $('#editOrder').modal({
                backdrop: false,
                show: true
            });

            $('.modal-dialog').draggable({
                handle: ".modal-header"
            });
            Mousetrap.bind("down")
        });
$("#editNewOrderForm").on("keydown",function(e){
    if(e.keyCode==13){
        e.preventDefault();
    }
})

/* */
$(document).on("keyup",".td-inputCodeEdit", (e)=>{
    if((e.keyCode>=65 && e.keyCode<=90) || ((e.keyCode>=48 && e.keyCode<=57) || (e.keyCode>=96 && e.keyCode<=105))){

        $("#rowTaker").val($(e.target).parents("tr").index()+1)
        setActiveTableOrder("kalaForAddToOrderEdit")
        setActiveForm("")
        if (!($('.modal.in').length)) {
            $('.modal-dialog').css({
                top: 0,
                left: 0
            });
        }

        $('#searchGoodsModalEdit').modal({
            backdrop: false,
            show: true
        });

        $('.modal-dialog').draggable({
            handle: ".modal-header"
        });

        $("#searchKalaForAddToSefarishByNameEdit").val();
        $("#searchForAddItemLabelEdit").text("کد کالا")
        $("#searchKalaForAddToSefarishByCodeEdit").val($(".td-inputCode").val());
        $("#searchKalaForAddToSefarishByNameEdit").hide();
        $("#searchKalaForAddToSefarishByCodeEdit").show();
        $("#searchGoodsModalEdit").modal("show");
        $('#searchGoodsModalEdit').on('shown.bs.modal', function() {
            $("#searchKalaForAddToSefarishByCodeEdit").focus();
            $("#searchKalaForAddToSefarishByCodeEdit").select().trigger("keyup");
        });
    }else{
        if(e.keyCode ==13 || e.keyCode ==9){
            var $currentInput = $(e.target);
            var $nextInput = $currentInput.closest('td').next('td').find('input');
            if ($nextInput.length > 0) {
                $nextInput.focus();
            }
        }
    }
});

$(document).on("keyup",".td-inputCodeNameEdit", (e)=>{
    if((e.keyCode>=65 && e.keyCode<=90) || ((e.keyCode>=48 && e.keyCode<=57) || (e.keyCode>=96 && e.keyCode<=105))){
        $("#rowTaker").val($(e.target).parents("tr").index()+1)
        setActiveTableOrder("kalaForAddToOrderEdit")
        setActiveForm("")
        if (!($('.modal.in').length)) {
            $('.modal-dialog').css({
                top: 0,
                left: 0
            });
        }
        $('#searchGoodsModalEdit').modal({
            backdrop: false,
            show: true
        });

        $('.modal-dialog').draggable({
            handle: ".modal-header"
        });
        $("#searchKalaForAddToSefarishByNameEdit").val();
        $("#searchForAddItemLabelEdit").text("نام کالا")
        $("#searchKalaForAddToSefarishByNameEdit").val("");
        $("#searchKalaForAddToSefarishByNameEdit").val($(e.target).val());
        $("#searchKalaForAddToSefarishByCodeEdit").hide();
        $("#searchKalaForAddToSefarishByNameEdit").show();
        $("#searchGoodsModalEdit").modal("show");
        $('#searchGoodsModalEdit').on('shown.bs.modal', function() {
        $("#searchKalaForAddToSefarishByNameEdit").focus();
        });
    }else{
        if(e.keyCode ==13 || e.keyCode ==9){
            var $currentInput = $(e.target);
            var $nextInput = $currentInput.closest('td').next('td').find('input');
            if ($nextInput.length > 0) {
                $nextInput.focus();
            }
        }
    }
})

$(document).on("keyup",".td-inputFirstUnitEdit", (e)=>{
    if(e.keyCode ==13 || e.keyCode ==9){
        var $currentInput = $(e.target);
        var $nextInput = $currentInput.closest('td').next('td').find('input');
        if ($nextInput.length > 0) {
            $nextInput.focus();
        }
    }
});

$(document).on("keyup",".td-inputSecondUnitEdit", (e)=>{
    if(e.keyCode ==13 || e.keyCode ==9){
        var $currentInput = $(e.target);
        var $nextInput = $currentInput.closest('td').next('td').find('input');
        
        if ($nextInput.length > 0) {
            $nextInput.focus();
        }
    }
});
$(document).on("keyup",".td-inputDescriptionEdit",(e)=>{
    if((e.keyCode === 9 ||e.keyCode === 13)  && ($(e.target).parents("tr").index()+1)==$("#addsefarishtblEdit tr").length && ($('#addsefarishtblEdit tr:nth-child('+($(e.target).parents("tr").index()+1)+') td:nth-child(2)').children('input').val().length)>0){
            let row=`<tr onclick="checkAddedKalaOfOrderAmount(this)">
                        <td style="width:30px!important;">`+($(e.target).parents("tr").index()+2)+`</td>
                        <td style="width:40px!important;" class="td-part-input"> <input type="text"  class="td-input td-inputCodeEdit form-control"></td>
                        <td style="width:130px!important;" class="td-part-input"> <input type="text" class="td-input td-inputCodeNameEdit form-control"></td>
                        <td style="width:50px!important;" class="td-part-input"> <input type="text"  class="td-input td-inputFirstUnitEdit form-control"></td>
                        <td style="width:70px!important;" class="td-part-input"> <input type="text"  class="td-input td-inputFirstUnitEdit form-control"></td>
                        <td style="width:70px!important;" class="td-part-input"> <input type="text"  class="td-input td-inputSecondUnitAmountEdit form-control"></td>
                        <td style="width:50px!important;" class="td-part-input"> <input type="text"  class="td-input td-inputEachFirstUnitAmountEdit form-control"></td>
                        <td style="width:70px!important;" class="td-part-input"> <input type="text"  class="td-input td-inputFirstUnitAmountEdit form-control"></td>
                        <td style="width:70px!important;" class="td-part-input"> <input type="text"  class="td-input td-inputFirstUnitPriceEdit form-control"></td>
                        <td style="width:70px!important;" class="td-part-input"> <input type="text"  class="td-input td-inputSecondUnitPriceEdit form-control"></td>
                        <td style="width:70px!important;" class="td-part-input"> <input type="text"  class="td-input td-inputAllPriceEdit form-control"></td>
                        <td style="width:70px!important;" class="td-part-input"> <input type="text"  class="td-input td-inputErsalTypeEdit form-control"></td>
                        <td style="width:52px!important;" class="td-part-input"> <input type="text"  class="td-input td-inputDescriptionEdit form-control"></td>
                        <td class="td-part-input d-none"><input type="text" value="1" class="td-input form-control"><input type="checkbox" name="orderBYSs[]" value="" class="td-input form-control" checked></td>
                        <td  class="td-part-input d-none"><input type="text" value="0" class="td-input form-control"></td>
                    </tr>`;
    $("#addsefarishtblEdit").append(row);

    } 
    if(e.keyCode===9 || e.keyCode===13){
        var $currentInput = $(e.target);
        var $currentTd = $currentInput.closest('td');
        var $currentTr = $currentTd.closest('tr');
        var $nextTr = $currentTr.next('tr');
        if ($nextTr.length > 0) {
          var $nextTd = $nextTr.find('td:eq(1)');
          var $nextInput = $nextTd.find('input');
          if ($nextInput.length > 0) {
            $nextInput.focus();
          }
        }
    }
});

$(document).on("keyup",".td-inputSecondUnitAmountEdit",(e)=>{
    if(($('#addsefarishtblEdit tr:nth-child('+$('#addsefarishtblEdit tr').length+') td:nth-child(2)').children('input').val().length)<1){
        $(`#addsefarishtblEdit tr:nth-child(`+$('#addsefarishtblEdit tr').length+`)`).replaceWith('');
    }
    let rowindex=$(e.target).parents("tr").index()+1
    let packAmount=$(e.target).val().replace(/,/g, '')
    let subPackUnits=parseInt($('#addsefarishtblEdit tr:nth-child('+rowindex+') td:nth-child(7)').children('input').val().replace(/,/g, ''));
    let GoodSn=parseInt($('#addsefarishtblEdit tr:nth-child('+rowindex+') td:nth-child(15)').children('input').val());
    let amountUnit=$($('#addsefarishtblEdit tr:nth-child('+rowindex+') td:nth-child(14)').children('input')).val().replace(/,/g, '');
    let price=$($('#addsefarishtblEdit tr:nth-child('+rowindex+') td:nth-child(9)').children('input')).val().replace(/,/g, '');
    let allAmountUnit=0;
    if(!isNaN(subPackUnits)){
        allAmountUnit=(packAmount*amountUnit)+subPackUnits
    }else{
        allAmountUnit=(packAmount*amountUnit)
    }

    if(allAmountUnit>parseInt($("#goodAmountInStockEdit").text().replace(/,/g, ''))){
        swal({
            title: "به این اندازه موجودی ندارد.",
            text:"میخواهید ثبت شود؟",
            icon: "warning",
            buttons: true,
            dangerMode: true,
            }).then((willAdd) => {
                if(willAdd){
                    let allPrice=allAmountUnit*price;
                    let packPrice=amountUnit*price;
                    $('#addsefarishtblEdit tr:nth-child('+rowindex+') td:nth-child(8)').children('input').val(parseInt(allAmountUnit).toLocaleString("en-us"));
                    $('#addsefarishtblEdit tr:nth-child('+rowindex+') td:nth-child(11)').children('input').val(parseInt(allPrice).toLocaleString("en-us"));
                    $('#addsefarishtblEdit tr:nth-child('+rowindex+') td:nth-child(10)').children('input').val(parseInt(packPrice).toLocaleString("en-us"));
                    $('#addsefarishtblEdit tr:nth-child('+rowindex+') td:nth-child(14) input[type="checkbox"]').val(GoodSn+'_'+packAmount+'_'+allAmountUnit+'_'+allPrice+'_'+packPrice+'_'+price);
                    var $currentInput = $(e.target);
                    var $currentTd = $currentInput.closest('td');
                    var $nextTd = $currentTd.next('td');
                    var $nextInput = $nextTd.find('input');
                        $($nextInput).focus();
                }else{
                    var $currentInput = $(e.target);
                    $($currentInput).focus();

                }
            })
    }else{
        let allPrice=allAmountUnit*price;
        let packPrice=amountUnit*price;
        $('#addsefarishtblEdit tr:nth-child('+rowindex+') td:nth-child(8)').children('input').val(parseInt(allAmountUnit).toLocaleString("en-us"));
        $('#addsefarishtblEdit tr:nth-child('+rowindex+') td:nth-child(11)').children('input').val(parseInt(allPrice).toLocaleString("en-us"));
        $('#addsefarishtblEdit tr:nth-child('+rowindex+') td:nth-child(10)').children('input').val(parseInt(packPrice).toLocaleString("en-us"));
        $('#addsefarishtblEdit tr:nth-child('+rowindex+') td:nth-child(14) input[type="checkbox"]').val(GoodSn+'_'+packAmount+'_'+allAmountUnit+'_'+allPrice+'_'+packPrice+'_'+price);
    }

    calculateNewOrderMoney();
    if(e.keyCode==9 || e.keyCode==13){
        var $currentInput = $(e.target);
        if(($currentInput.val()>0)){
            var $nextInput = $currentInput.closest('td').next('td').find('input');
            
            if($nextInput.length > 0) {
                $nextInput.focus();
            }
        }else{

            alert("مقدار کالا را وارد کنید.")

        }
    }
});

$(document).on("keyup",".td-inputEachFirstUnitAmountEdit", (e)=>{
    if(($('#addsefarishtblEdit tr:nth-child('+$('#addsefarishtblEdit tr').length+') td:nth-child(2)').children('input').val().replace(/,/g, '').length)<1){
        $(`#addsefarishtblEdit tr:nth-child(`+$('#addsefarishtblEdit tr').length+`)`).replaceWith('');
    }
    let rowindex=$(e.target).parents("tr").index()+1
    let packAmount=parseInt($('#addsefarishtblEdit tr:nth-child('+rowindex+') td:nth-child(6)').children('input').val().replace(/,/g, ''));
    let subPackUnits=parseInt($(e.target).val().replace(/,/g, ''))
    let amountUnit=$($('#addsefarishtblEdit tr:nth-child('+rowindex+') td:nth-child(14)').children('input')).val().replace(/,/g, '');
    let price=$($('#addsefarishtblEdit tr:nth-child('+rowindex+') td:nth-child(9)').children('input')).val().replace(/,/g, '');

    let allAmountUnit=(packAmount*amountUnit)+subPackUnits;
    packAmount=parseInt(allAmountUnit/amountUnit);
    subPackUnits=allAmountUnit%amountUnit;
    let allPrice=allAmountUnit*price;
    $('#addsefarishtblEdit tr:nth-child('+rowindex+') td:nth-child(8)').children('input').val(parseInt(allAmountUnit).toLocaleString("en-us"));
    $('#addsefarishtblEdit tr:nth-child('+rowindex+') td:nth-child(11)').children('input').val(parseInt(allPrice).toLocaleString("en-us"));
    $('#addsefarishtblEdit tr:nth-child('+rowindex+') td:nth-child(6)').children('input').val(packAmount)
    $(e.target).val(subPackUnits)
    if(e.keyCode==9 || e.keyCode==13){
        var $currentInput = $(e.target);
        var $nextInput = $currentInput.closest('td').next('td').find('input');
        if ($nextInput.length > 0) {
        $nextInput.focus();
        }
    }
});

$(document).on("keydown",".td-inputFirstUnitPriceEdit", (e)=>{
    let rowindex=$(e.target).parents("tr").index()+1
    if((e.keyCode>=65 && e.keyCode<=90)|| ((e.keyCode>=48 && e.keyCode<=57) || (e.keyCode>=96 && e.keyCode<=105))){
        
            if(($('#addsefarishtblEdit tr:nth-child('+$('#addsefarishtblEdit tr').length+') td:nth-child(2)').children('input').val().length)<1){
                $(`#addsefarishtblEdit tr:nth-child(`+$('#addsefarishtblEdit tr').length+`)`).replaceWith('');
            }
            
            let packAmount=parseInt($('#addsefarishtblEdit tr:nth-child('+rowindex+') td:nth-child(6)').children('input').val().replace(/,/g, ''));
            let price=parseInt($(e.target).val().replace(/,/g, ''))
            let subPackUnits=parseInt($('#addsefarishtblEdit tr:nth-child('+rowindex+') td:nth-child(7)').children('input').val().replace(/,/g, ''));
            let amountUnit=$($('#addsefarishtblEdit tr:nth-child('+rowindex+') td:nth-child(14)').children('input')).val().replace(/,/g, '');
            // let price=$($('#addsefarishtblEdit tr:nth-child('+rowindex+') td:nth-child(9)').children('input')).val();
            let allAmountUnit=(packAmount*amountUnit)+subPackUnits;
            let allPrice=allAmountUnit*price;
            let packPrice=amountUnit*price;
            $('#addsefarishtblEdit tr:nth-child('+rowindex+') td:nth-child(8)').children('input').val(allAmountUnit);
            $('#addsefarishtblEdit tr:nth-child('+rowindex+') td:nth-child(11)').children('input').val(allPrice);
            $('#addsefarishtblEdit tr:nth-child('+rowindex+') td:nth-child(10)').children('input').val(packPrice);
        
    }
    if(e.keyCode==9 || e.keyCode==13){
        let lastBuyFi=parseInt($('#addsefarishtblEdit tr:nth-child('+rowindex+') td:nth-child(16)').children('input').val().replace(/,/g, ''));
        
        let givenFi=parseInt($(e.target).val().replace(/,/g, ''))
        if(givenFi<lastBuyFi){
            swal({
                title: "توجه!",
                text:"قیمت وارد شده نسبت به قیمت خرید بیشتر است. می خواهید ثبت کنید؟",
                icon: "warning",
                buttons: true,
                dangerMode: true,
                }).then(

                (willAdd)=>{
                    if(!willAdd){
                        $(e.target).focus()
                        if(($('#addsefarishtblEdit tr:nth-child('+$('#addsefarishtblEdit tr').length+') td:nth-child(2)').children('input').val().length)<1){
                            $(`#addsefarishtblEdit tr:nth-child(`+$('#addsefarishtblEdit tr').length+`)`).replaceWith('');
                        }
                        let rowindex=$(e.target).parents("tr").index()+1
                        let packAmount=parseInt($('#addsefarishtblEdit tr:nth-child('+rowindex+') td:nth-child(6)').children('input').val().replace(/,/g, ''));
                        let price=parseInt($(e.target).val().replace(/,/g, ''))
                        let subPackUnits=parseInt($('#addsefarishtblEdit tr:nth-child('+rowindex+') td:nth-child(7)').children('input').val().replace(/,/g, ''));
                        let amountUnit=$($('#addsefarishtblEdit tr:nth-child('+rowindex+') td:nth-child(14)').children('input')).val().replace(/,/g, '');
                        // let price=$($('#addsefarishtblEdit tr:nth-child('+rowindex+') td:nth-child(9)').children('input')).val();
                        let allAmountUnit=(packAmount*amountUnit)+subPackUnits;
                        let allPrice=allAmountUnit*price;
                        let packPrice=amountUnit*price;
                        $('#addsefarishtblEdit tr:nth-child('+rowindex+') td:nth-child(8)').children('input').val(allAmountUnit);
                        $('#addsefarishtblEdit tr:nth-child('+rowindex+') td:nth-child(11)').children('input').val(allPrice);
                        $('#addsefarishtblEdit tr:nth-child('+rowindex+') td:nth-child(10)').children('input').val(packPrice);
                    }else{
                        let packAmount=parseInt($('#addsefarishtblEdit tr:nth-child('+rowindex+') td:nth-child(6)').children('input').val().replace(/,/g, ''));
                        let price=parseInt($(e.target).val().replace(/,/g, ''))
                        let subPackUnits=parseInt($('#addsefarishtblEdit tr:nth-child('+rowindex+') td:nth-child(7)').children('input').val().replace(/,/g, ''));
                        let amountUnit=$($('#addsefarishtblEdit tr:nth-child('+rowindex+') td:nth-child(14)').children('input')).val().replace(/,/g, '');
                        // let price=$($('#addsefarishtblEdit tr:nth-child('+rowindex+') td:nth-child(9)').children('input')).val();
                        let allAmountUnit=(packAmount*amountUnit)+subPackUnits;
                        let allPrice=allAmountUnit*price;
                        let packPrice=amountUnit*price;
                        $('#addsefarishtblEdit tr:nth-child('+rowindex+') td:nth-child(8)').children('input').val(allAmountUnit);
                        $('#addsefarishtblEdit tr:nth-child('+rowindex+') td:nth-child(11)').children('input').val(allPrice);
                        $('#addsefarishtblEdit tr:nth-child('+rowindex+') td:nth-child(10)').children('input').val(packPrice);
                        var currentInput = $(e.target);
                        var nextInput = currentInput.closest('td').next('td').find('input');
                        
                        $(nextInput).focus();
                    }
                }
            )
        }
        var currentInput = $(e.target);
        var nextInput = currentInput.closest('td').next('td').find('input');
        
            $(nextInput).focus();
    }

});



$(document).on("keyup",".td-inputAllPriceEdit", (e)=>{

    if(($('#addsefarishtblEdit tr:nth-child('+$('#addsefarishtblEdit tr').length+') td:nth-child(2)').children('input').val().length)<1){
        $(`#addsefarishtblEdit tr:nth-child(`+$('#addsefarishtblEdit tr').length+`)`).replaceWith('');
    }
    let rowindex=$(e.target).parents("tr").index()+1
    let packAmount=parseInt($('#addsefarishtblEdit tr:nth-child('+rowindex+') td:nth-child(6)').children('input').val());
    if(!$(e.target).val()){
        $(e.target).val(0)
    }
    let allPrice=parseInt($(e.target).val().replace(/,/g, ''))
    let subPackUnits=parseInt($('#addsefarishtblEdit tr:nth-child('+rowindex+') td:nth-child(7)').children('input').val());
    let amountUnit=$($('#addsefarishtblEdit tr:nth-child('+rowindex+') td:nth-child(14)').children('input')).val();
    let price=$($('#addsefarishtblEdit tr:nth-child('+rowindex+') td:nth-child(9)').children('input')).val().replace(/,/g, '');
    // $($('#addsefarishtblEdit tr:nth-child('+rowindex+') td:nth-child(9)').children('input')).val(price);
    let allAmountUnit=allPrice/price;
    $('#addsefarishtblEdit tr:nth-child('+rowindex+') td:nth-child(8)').children('input').val(allAmountUnit);
    packAmount=parseInt(allAmountUnit/amountUnit)
    subPackUnits=allAmountUnit%amountUnit;
    $('#addsefarishtblEdit tr:nth-child('+rowindex+') td:nth-child(11)').children('input').val(parseInt(allPrice).toLocaleString("en-us"));
    $('#addsefarishtblEdit tr:nth-child('+rowindex+') td:nth-child(7)').children('input').val(subPackUnits)
    $('#addsefarishtblEdit tr:nth-child('+rowindex+') td:nth-child(6)').children('input').val(packAmount)
    if(e.keyCode==9 || e.keyCode==13){
        var $currentInput = $(e.target);
        var $nextInput = $currentInput.closest('td').next('td').find('input');
        
        if ($nextInput.length > 0) {
        $nextInput.focus();
        }
    }

});


$(document).on("keyup",".td-inputFirstUnitAmountEdit", (e)=>{
    if((e.keyCode>=65 && e.keyCode<=90)|| ((e.keyCode>=48 && e.keyCode<=57) || (e.keyCode>=96 && e.keyCode<=105))){

        let rowindex=$(e.target).parents("tr").index()+1
        // let packAmount=parseInt($('#addsefarishtblEdit tr:nth-child('+rowindex+') td:nth-child(6)').children('input').val().replace(/,/g, ''));
        let price=$($('#addsefarishtblEdit tr:nth-child('+rowindex+') td:nth-child(9)').children('input')).val().replace(/,/g, '');
        //let subPackUnits=parseInt($('#addsefarishtblEdit tr:nth-child('+rowindex+') td:nth-child(7)').children('input').val().replace(/,/g, ''));
        let amountUnit=$($('#addsefarishtblEdit tr:nth-child('+rowindex+') td:nth-child(14)').children('input')).val().replace(/,/g, '');
        // let price=$($('#addsefarishtblEdit tr:nth-child('+rowindex+') td:nth-child(9)').children('input')).val();
        let allAmountUnit=parseInt($(e.target).val().replace(/,/g, ''));
        let packAmount=parseInt(allAmountUnit/amountUnit);
        let subPackUnits=allAmountUnit%amountUnit;
        let allPrice=allAmountUnit*price;
        let packPrice=amountUnit*price;
        $('#addsefarishtblEdit tr:nth-child('+rowindex+') td:nth-child(8)').children('input').val(allAmountUnit);
        $('#addsefarishtblEdit tr:nth-child('+rowindex+') td:nth-child(11)').children('input').val(allPrice);
        $('#addsefarishtblEdit tr:nth-child('+rowindex+') td:nth-child(10)').children('input').val(packPrice);
        $('#addsefarishtblEdit tr:nth-child('+rowindex+') td:nth-child(6)').children('input').val(packAmount);
        $('#addsefarishtblEdit tr:nth-child('+rowindex+') td:nth-child(7)').children('input').val(subPackUnits);
    }
    if(e.keyCode==9 || e.keyCode==13){
        var $currentInput = $(e.target);
        var $nextInput = $currentInput.closest('td').next('td').find('input');
        if ($nextInput.length > 0) {
        $nextInput.focus();
        }
    }
})

$(document).on("keyup",".td-inputSecondUnitPriceEdit", (e)=>{
    if(e.keyCode==9 || e.keyCode==13){
        var $currentInput = $(e.target);
        var $nextInput = $currentInput.closest('td').next('td').find('input');
        if ($nextInput.length > 0) {
            $nextInput.focus();
        }
    }
})


$(document).on("keyup",".td-inputErsalTypeEdit", (e)=>{
    if(e.keyCode==9 || e.keyCode==13){
        var $currentInput = $(e.target);
        var $nextInput = $currentInput.closest('td').next('td').find('input');
        
        if ($nextInput.length > 0) {
        $nextInput.focus();
        }
    }
});

function closeEditNewOrderModal(){
    swal({
        title:"می خواهید بدون ذخیره خارج شوید؟",
        icon:"warning",
        buttons:true
    }).then((willCancel)=>{
        if(willCancel){
            $("#editOrder").modal("hide")
        }
    })
    
}

function checkAddedKalaOfOrderAmount(row){
    $(row).find('input:radio').prop('checked', true);
    let rowindex=$(row).index()+1
    let totalMoneyTillRow=0;

    for (let index = 1; index <=rowindex; index++) {
        totalMoneyTillRow+=parseInt($('#addsefarishtblEdit tr:nth-child('+index+') td:nth-child(11)').children('input').val().replace(/,/g, ''));
    }

    let input = $(row).find('input:radio');
    let goodSn=$(input).val();
    if(!goodSn){
        return
    }

    let customerSn=$("#customerForSefarishIdEdit").val();

    $("#allMoneyTillThisRowEdit").text(parseInt(totalMoneyTillRow).toLocaleString("en-us"));
    if($("#checkExitanceForAddToSefarish").is(":checked")){
        $.get(baseUrl+"/getGoodInfoForAddOrderItem",{
            goodSn: goodSn,
            customerSn:customerSn,
            stockId: 23
        },(respond,status)=>{
            
            if(respond[1][0]){
                if(!isNaN(respond[1][0].Amount)){
                    let amount=0;
                    if(respond[1][0].Amount>=1){
                        amount=respond[1][0].Amount
                    }
                    $("#goodAmountInStockEdit").text(parseInt(amount).toLocaleString("en-us"));
                }else{
                    $("#goodAmountInStockEdit").text(0);
                }
            }else{
                $("#goodAmountInStockEdit").text(0);
            }

            if(respond[2][0]){
                if(!isNaN(respond[2][0].Price3)){
                    let price=0;
                    if(respond[2][0].Price3>=1){
                        price=respond[2][0].Price3
                    }
                    $("#goodPriceAddSefarishEdit").text(parseInt(price).toLocaleString("en-us"));
                }else{
                    $("#goodPriceAddSefarishEdit").text(0);
                }
            }else{
                $("#goodPriceAddSefarishEdit").text(0);
            }
            if(respond[4][0]){
                if(!isNaN(respond[4][0].Fi)){
                    let fi=0;
                    if(respond[4][0].Fi>=1){
                        fi=respond[4][0].Fi;                       
                    }
                    $("#lastSalePriceAddSefarishEdit").text(parseInt(fi).toLocaleString("en-us"));
                }else{
                    $("#lastSalePriceAddSefarishEdit").text(0);
                }
            }else{
                $("#lastSalePriceAddSefarishEdit").text(0);
            }

            if(respond[3][0]){
                if(!isNaN(respond[3][0].Price3)){
                    let price=0;
                    if(respond[3][0].Price3>=1){
                        price=respond[3][0].Price3
                    }
                    $("#lastSalePriceToThisCustomerAddSefarishEdit").text(parseInt(price).toLocaleString("en-us"));
                }else{
                    $("#lastSalePriceToThisCustomerAddSefarishEdit").text(0);
                }
            }else{
                $("#lastSalePriceToThisCustomerAddSefarishEdit").text(0);
            }
            

        })
    }else{
        $("#goodAmountInStockEdit").text(0);

        $("#goodPriceAddSefarishEdit").text(0);

        $("#lastSalePriceToThisCustomerAddSefarishEdit").text(0);

        $("#lastSalePriceAddSefarishEdit").text(0);
    }
    const previouslySelectedRow = document.querySelector('.selected');
    if(previouslySelectedRow) {
        previouslySelectedRow.classList.remove('selected');
    }
    row.classList.add('selected');
}

$("#searchKalaForAddToSefarishByNameEdit").on("keyup",function(event){
    let tableBody=$("#kalaForAddToOrderEdit");
    if(event.keyCode!=40){
        if(event.keyCode!=13){
            $.get(baseUrl+'/getKalaByName',{name:$(this).val()},function (data,status) {
                if(status=='success'){
                    tableBody.empty();
                    let i=0;
                    for (const element of data) {
                        i++;
                        if(i!=1){
                            tableBody.append(`<tr onclick="setAddedToOrderEditKalaStuff(this,`+element.GoodSn+`)"> <td>`+(i)+`<input type="radio" value="${element.GoodSn}" class="d-none"/></td> <td> `+element.GoodCde+` </td><td> `+element.GoodName+`</td> <td>...</td> </tr>`);
                        }else{
                            tableBody.append(`<tr onclick="setAddedToOrderEditKalaStuff(this,`+element.GoodSn+`)"> <td>`+(i)+`<input type="radio" value="${element.GoodSn}" class="d-none"/></td> <td> `+element.GoodCde+` </td><td> `+element.GoodName+`</td> <td>...</td> </tr>`);
                            $("#kalaForAddToOrderEdit tr").eq(0).css('background-color', 'rgb(0,142,201)'); 
                            const selectedGoodSn = data[0].GoodSn;
                            setAddedToOrderEditKalaStuff(0,selectedGoodSn)
                        }
                    }

                    // Mousetrap.bind("enter",()=>{
                    //     $("#selectKalaToFactorEditBtn").trigger("click");
                    // });

                }
            })
    }else{
        $("#selectKalaToFactorEditBtn").trigger("click");
    }
}else{
    $(this).blur(); // Remove focus from the input
    $("#kalaForAddToFactorEditTble").focus();
}
});

$("#searchKalaForAddToSefarishByCodeEdit").on("keyup", function (event) {

    if(event.keyCode!=40){
        if(event.keyCode!=13){
            let goodCode=$("#searchKalaForAddToSefarishByCodeEdit").val();
            let tableBody=$("#kalaForAddToOrderEdit");
            $.get(baseUrl + '/searchKalaByCode', { code: goodCode }, function (data, status) {
                if (status == 'success') {
                    tableBody.empty();
                    let i=0;
                    for (const element of data) {
                        i++;
                        if(i!=1){
                            tableBody.append(`<tr onclick="setAddedToOrderEditKalaStuff(this,`+element.GoodSn+`)"> <td>`+(i)+`<input type="radio" value="${element.GoodSn}" class="d-none"/></td> <td> `+element.GoodCde+` </td><td> `+element.GoodName+`</td> <td>...</td> </tr>`);
                        }else{
                            tableBody.append(`<tr onclick="setAddedToOrderEditKalaStuff(this,`+element.GoodSn+`)"> <td>`+(i)+`<input type="radio" value="${element.GoodSn}" class="d-none"/></td> <td> `+element.GoodCde+` </td><td> `+element.GoodName+`</td> <td>...</td> </tr>`);
                            
                            $("#kalaForAddToOrderEdit tr").eq(0).css('background-color', 'rgb(0,142,201)'); 
                            const selectedGoodSn = data[0].GoodSn;
                            setAddedToOrderEditKalaStuff(0,selectedGoodSn)
                        }
                    }

                    Mousetrap.bind("enter",()=>{
                        $("#selectKalaToSefarishBtn").trigger("click");
                    });
                }
            });
        }else{
            $("#selectKalaToSefarishBtn").trigger("click");
        }
    }else{
        $(this).blur(); // Remove focus from the input
        $("#kalaForAddToSefarishTble").focus();
    }
});

$("#selectKalaToSefarishBtnEdit").on("click",function(){
    var rowCount = $("#newSefarishTblEdit tr").length-1;
    let allMoney=0;
    for(let i=1;i<=rowCount;i++){
       let rowGoodSn= $('#newSefarishTblEdit tr:nth-child('+i+') td:nth-child(15)').children('input').val();
       if(rowGoodSn==$(this).val()){
        alert("کالای انتخاب شده قبلا اضافه شده است.")
        return
       }
    }
    
$.get(baseUrl+"/searchKalaByID",{goodSn:$(this).val()},function(data,status){
    if(status=="success"){
        let row=data.map((element,index)=> `<tr  onclick="checkAddedKalaOfOrderAmount(this)">
                                                <td style="width:30px!important;">`+($("#rowTaker").val())+`</td>
                                                <td style="width:40px!important;" class="td-part-input"> <input type="checkbox" name="editables[]" class="d-none" value="${element.GoodSn}" checked/> <input  type="number" value="`+element.GoodCde+`" class="td-input td-inputCodeEdit form-control"></td>
                                                <td style="width:130px!important;" class="td-part-input"><input type="text" value="`+element.GoodName+`" class="td-input td-inputCodeNameEdit form-control"></td>
                                                <td style="width:50px!important;" class="td-part-input"> <input  type="text" value="`+element.firstUnit+`" class="td-input td-inputFirstUnitEdit form-control"></td>
                                                <td style="width:70px!important;" class="td-part-input"> <input  type="text" value="`+element.secondUnit+`" class="td-input td-inputSecondUnitEdit form-control"></td>
                                                <td style="width:70px!important;" class="td-part-input"> <input name="packAmount${element.GoodSn}" type="number"  class="td-input td-inputSecondUnitAmountEdit form-control"></td>
                                                <td style="width:50px!important;" class="td-part-input"> <input name="JozeAmount${element.GoodSn}" value="0" class="td-input td-inputEachFirstUnitAmountEdit form-control"></td>
                                                <td style="width:70px!important;" class="td-part-input"> <input name="Amount${element.GoodSn}" type="number" class="td-input td-inputFirstUnitAmountEdit form-control"></td>
                                                <td style="width:70px!important;" class="td-part-input"> <input name="Fi${element.GoodSn}" type="text"  value="`+parseInt(element.Price3).toLocaleString("en-us")+`" class="td-input td-inputFirstUnitPriceEdit form-control"></td>
                                                <td style="width:70px!important;" class="td-part-input"> <input name="PackPrice${element.GoodSn}" type="text" class="td-input td-inputSecondUnitPriceEdit form-control"></td>
                                                <td style="width:70px!important;" class="td-part-input"> <input name="AllPrice${element.GoodSn}" type="text" class="td-input td-inputAllPriceEdit form-control"></td>
                                                <td style="width:70px!important;" class="td-part-input"> <input name="ErsalType${element.GoodSn}" type="text" class="td-input td-inputErsalTypeEdit form-control"></td>
                                                <td style="width:52px!important;" class="td-part-input"> <input name="Description${element.GoodSn}" value="" type="text" class="td-input td-inputDescriptionEdit form-control"></td>
                                                <td class="td-part-input d-none"> <input type="text" value="`+element.AmountUnit+`" class="td-input form-control"></td>
                                                <td class="td-part-input d-none"> 
                                                    <input type="radio" value="`+element.GoodSn+`" class="td-input form-control">
                                                    <input name="goodSn${element.GoodSn}" type="text" value="`+element.GoodSn+`" class="td-input form-control">
                                                </td>
                                                <td class="td-part-input d-none"> 
                                                    <input type="text" value="`+element.lastBuyFi+`" class="td-input form-control">
                                                </td>
                                            </tr>`)
        $(`#addsefarishtblEdit tr:nth-child(`+$("#rowTaker").val()+`)`).replaceWith(row);
        $(`#addsefarishtblEdit tr:nth-child(`+$("#rowTaker").val()+`) td:nth-child(6) input`).focus();
        $(`#addsefarishtblEdit tr:nth-child(`+$("#rowTaker").val()+`) td:nth-child(6) input`).select();

        
        checkAddedKalaAmountToSefarishEdit(data[0].GoodSn);
        }
    });

    $("#searchGoodsModalEdit").modal("hide");
});



function setAddedToOrderEditKalaStuff(element,goodSn){
    
    if(isNaN(element)){
        $("tr").removeClass('selected');
        $("#kalaForAddToSefarish tr").css('background-color', '');
        $(element).addClass("selected")
    }else{
        $("tr").removeClass('selected');
    }
     $("#selectKalaToSefarishBtnEdit").val(goodSn)
     if($("#selectKalaToOrderBtnEdit")){
        $("#selectKalaToOrderBtnEdit").val(goodSn)
     }
     let customerSn=$("#customerForSefarishIdEdit").val();
     $.ajax({
        method: 'get',
        async: true,
        url: baseUrl + "/getSendItemInfo",
        data: {
            goodSn: goodSn,
            stockId: 23,
            customerSn: customerSn
        },
        success: function (response) {
            if(response[0][0]){
                if (!isNaN(parseInt(response[0][0].Amount))) {
                    $("#StockExistanceOrderEdit").text(parseInt(response[0][0].Amount).toLocaleString("en-us"));
                } else {
                    $("#StockExistanceOrderEdit").text(0);
                }
            }else {
                $("#StockExistanceOrderEdit").text(0);
            }
            if(response[1][0]){
                if (!isNaN(parseInt(response[1][0].Price3))) {
                    $("#SalePriceOrderEdit").text(parseInt(response[1][0].Price3 / 10).toLocaleString("en-us"));
                } else {
                    $("#SalePriceOrderEdit").text(0);
                }
            } else {
                $("#SalePriceOrderEdit").text(0);
            }
    
            if (response[2][0]) {
                if (!isNaN(parseInt(response[2][0].Fi))) {
                    $("#PriceOrderEdit").text(parseInt(response[2][0].Fi / 10).toLocaleString("en-us"));
                } else {
                    $("#PriceOrderEdit").text(0);
                }
            }else {
                $("#PriceOrderEdit").text(0);
            }
    
            if([3][0]){
                if (!isNaN(parseInt(response[3][0].Fi))) {
                    $("#LastPriceCustomerOrderEdit").text(parseInt(response[3][0].Fi / 10).toLocaleString("en-us"));
                } else {
                    $("#LastPriceCustomerOrderEdit").text(0);
                }
            }else {
                $("#LastPriceCustomerOrderEdit").text(0);
            }
        },
        error: function (error) {
            //alert("get item existance error found");
        }
    })
}

$("#deleteOrderItemBtnEdit").on("click",function(e){
    swal({
        title:"می خواهید حذف کنید؟",
        buttons:true,
        dangerMode:true,
    }).then((willDelete)=>{
        if(willDelete){
            $('#addsefarishtblEdit tr.selected').remove();
        }
    })
    
})


$("#editNewOrderForm").on("submit",function(e){
    e.preventDefault();
    $.ajax({
        method:"POST",
        url: $(this).attr('action'),
        data: new FormData(this),
        processData: false,
        contentType: false,
        success: function (respond) {
            console.log(respond)
            if(respond=="done"){
                $("#editOrder").modal("hide");
            }
        },
        error:function(error){

        }
    });
})

function addAmelToSefarishEdit(){
    $("#addAmelModalEdit").modal("hide");
    $("#hamlMoneyEdit").val($("#hamlMoneyModalEdit").val().replace(/,/g, ''));
    $("#hamlDescEdit").val($("#hamlDescModalEdit").val());
    $("#nasbMoneyEdit").val($("#nasbMoneyModalEdit").val().replace(/,/g, ''));
    $("#nasbDescEdit").val($("#nasbDescModalEdit").val());
    $("#motafariqaMoneyEdit").val($("#motafariqaMoneyModalEdit").val().replace(/,/g, ''));
    $("#motafariqaDescEdit").val($("#motafariqaDescModalEdit").val());
    $("#bargiriMoneyEdit").val($("#bargiriMoneyModalEdit").val().replace(/,/g, ''));
    $("#bargiriDescEdit").val($("#bargiriDescModalEdit").val());
    $("#tarabariMoneyEdit").val($("#tarabariMoneyModalEdit").val().replace(/,/g, ''));
    $("#tarabariDescEdit").val($("#tarabariDescModalEdit").val());

    let hamlMoneyEdit=0;
    let nasbMoneyEdit=0;
    let motafariqaMoneyEdit=0;
    let bargiriMoneyEdit=0;
    let tarabariMoneyEdit=0;
    if(!isNaN(parseInt($("#hamlMoneyEdit").val()))){
        hamlMoneyEdit=parseInt($("#hamlMoneyEdit").val());
    }
    if(!isNaN(parseInt($("#nasbMoneyEdit").val()))){
        nasbMoneyEdit=parseInt($("#nasbMoneyEdit").val());
    }
    if(!isNaN(parseInt($("#motafariqaMoneyEdit").val()))){
        motafariqaMoneyEdit=parseInt($("#motafariqaMoneyEdit").val());
    }
    if(!isNaN(parseInt($("#bargiriMoneyEdit").val()))){
        bargiriMoneyEdit=parseInt($("#bargiriMoneyEdit").val());
    }
    if(!isNaN(parseInt($("#tarabariMoneyEdit").val()))){
        tarabariMoneyEdit=parseInt($("#tarabariMoneyEdit").val());
    }

    let allAmelEdit=hamlMoneyEdit+nasbMoneyEdit+motafariqaMoneyEdit+bargiriMoneyEdit+tarabariMoneyEdit;
    $("#allAmelMoneyEdit").text(parseInt(allAmelEdit).toLocaleString("en-us"));
}
$("#hamlMoneyModalEdit").on("keyup",(e)=>{
    checkNumberInput(e);
    if(e.keyCode==13 || e.keyCode==9){
        $("#hamlDescModalEdit").focus();
    }
})
$("#nasbMoneyModalEdit").on("keyup",(e)=>{
    checkNumberInput(e);
    if(e.keyCode==13 || e.keyCode==9){
        $("#nasbDescModalEdit").focus();
    }
})
$("#motafariqaMoneyModalEdit").on("keyup",(e)=>{
    checkNumberInput(e);
    if(e.keyCode==13 || e.keyCode==9){
        $("#motafariqaDescModalEdit").focus();
    } 
})
$("#bargiriMoneyModalEdit").on("keyup",(e)=>{
    checkNumberInput(e);
    if(e.keyCode==13 || e.keyCode==9){
        $("#bargiriDescModalEdit").focus();
    }
})
$("#tarabariMoneyModalEdit").on("keyup",(e)=>{
    checkNumberInput(e);
    if(e.keyCode==13 || e.keyCode==9){
        $("#tarabariDescModalEdit").focus();
    }
})
$("#hamlDescModalEdit").on("keyup",(e)=>{
    if(e.keyCode==13 || e.keyCode==9){
        $("#nasbMoneyModalEdit").focus();
    }
})
$("#nasbDescModalEdit").on("keyup",(e)=>{
    if(e.keyCode==13 || e.keyCode==9){
        $("#motafariqaMoneyModalEdit").focus();
    }
})
$("#motafariqaDescModalEdit").on("keyup",(e)=>{
    if(e.keyCode==13 || e.keyCode==9){
        $("#bargiriMoneyModalEdit").focus();
    }
})
$("#bargiriDescModalEdit").on("keyup",(e)=>{
    if(e.keyCode==13 || e.keyCode==9){
        $("#tarabariMoneyModalEdit").focus();
    }
});

$("#tarabariDescModalEdit").on("keyup",(e)=>{
    if(e.keyCode==13 || e.keyCode==9){
        let allAmelEdit=checkWantToaddedAmel();
        if(allAmelEdit>0){
            swal({
                text: "می خواهید این هزینه ها اضافه شوند؟",
                icon: "warning",
                buttons: true,
                dangerMode: true,
                }).then((willAdd) => {
                    if(willAdd){
                        $("#sabtAmelButtonEdit").trigger("click");
                }
            });
        }
    }
});

$(document).on('keyup', '#searchCustomerNameInputEdit',function(e){
    if(((e.keyCode>=65 && e.keyCode<=90)|| (e.key).match(/[آ-ی]/)) || ((e.keyCode>=48 && e.keyCode<=57) || (e.keyCode>=96 && e.keyCode<=105))){
        setActiveTableOrder("foundCusotmerForOrderBodyEdit")
        setActiveForm("")
        if (!($('.modal.in').length)) {
            $('.modal-dialog').css({
                top: 0,
                left: 0
            });
        }
        $('.modal-dialog').draggable({
            handle: ".modal-header"
        });
        $("#customerForSefarishModalEdit").modal("show");
        $("#customerNameForOrderEdit").val($('#searchCustomerNameInputEdit').val());
        $("#customerNameForOrderEdit").focus();
        $('#customerForSefarishModalEdit').on('shown.bs.modal', function() {
            $(this).find('[autofocus]').focus();
        });
    }
});


$("#customerNameForOrderEdit").on("keyup", function (event){
    let name=$("#customerNameForOrderEdit").val();
    if(event.keyCode!=40){
        if(event.keyCode!=13){
    let searchByPhone="";
    if($("#seachByPhoneNumberCheckBoxEdit").is(":checked")){
        searchByPhone="on";
    }else{
        searchByPhone="";
    }
    $.get("/getCustomerForOrder",{namePhone:name,searchByPhone:searchByPhone},(data,status)=>{
        localStorage.setItem("scrollTop",0);
        $("#foundCusotmerForOrderBodyEdit").empty();
        let tableBody=$("#foundCusotmerForOrderBodyEdit");
        let i=0;
        for (let customer of data){
            i++;
            if(i!=1){
                tableBody.append(`<tr onclick="selectCustomerForOrderEdit(${customer.PSN},this)">
                                                        <td> ${(i)} <input type="radio" value="${customer.PSN}" class="d-none"/> </td>
                                                        <td> ${customer.PCode} </td>
                                                        <td> ${customer.Name} </td>
                                                        <td> ${customer.countBuy} </td>
                                                        <td> ${customer.countSale} </td>
                                                        <td> ${customer.chequeCountReturn} </td>
                                                        <td> ${customer.chequeMoneyReturn} </td>
                                                    </tr>`);
            }else{
                tableBody.append(`<tr onclick="selectCustomerForOrderEdit(${customer.PSN},this)">
                    <td> ${(i)}  <input type="radio" value="${customer.PSN}" class="d-none"/></td>
                    <td> ${customer.PCode} </td>
                    <td> ${customer.Name} </td>
                    <td> ${customer.countBuy} </td>
                    <td> ${customer.countSale} </td>
                    <td> ${customer.chequeCountReturn} </td>
                    <td> ${customer.chequeMoneyReturn} </td>
                </tr>`);
                $("#foundCusotmerForOrderBodyEdit tr").eq(0).css("background-color", "rgb(0,142,201)"); 
                const selectedPSN = data[0].PSN;
                selectCustomerForOrder(selectedPSN,0)
            }
        }
        Mousetrap.bind("enter",()=>{
            $("#searchCustomerSabtBtnEdit").trigger("click");
            localStorage.setItem("scrollTop",0);
        });
    })  
    }else{
        $("#searchCustomerSabtBtnEdit").trigger("click");
        localStorage.setItem("scrollTop",0);
    }
}else{
    $(this).blur();
    $("#foundCusotmerForOrderTbleEdit").focus();
    localStorage.setItem("scrollTop",0);
} 
});

function selectCustomerForOrderEdit(psn,element){
    
    if(isNaN(element)){
        $("tr").removeClass('selected');
        $("#foundCusotmerForOrderBodyEdit tr").css('background-color', '');
        $(element).addClass("selected")
    }else{
        $("tr").removeClass('selected');
    }
    $("#searchCustomerSabtBtnEdit").prop("disabled",false);
    $("#searchCustomerSabtBtnEdit").val(psn);
}

function chooseCustomerForOrderEdit(psn){
    $.get("/getInfoOfOrderCustomer",{psn:psn},(respond,status)=>{
        $("#customerForSefarishIdEdit").append(`<option selected value="${respond[0].PSN}"> ${respond[0].Name} </option>`);
        $("#customerForSefarishIdEdit").trigger("change");
        $("#searchCustomerNameInputEdit").val(respond[0].Name);
        $("#customerCodeInputEdit").val(respond[0].PCode);
        $("#lastCustomerStatusEdit").text(parseInt(respond[0].TotalPrice).toLocaleString("en-us")||0);
    });
    $("#customerForSefarishModalEdit").modal("hide");
}
let activeForm="";
$(document).keydown((event)=>{
    if(event.keyCode==40){
        event.preventDefault();
        switch (activeForm) {
            case "addsefarishtblEdit":
                {
                    let rowindex=$(event.target).parents("tr").index()+1
                    let goodSn=parseInt($('#addsefarishtblEdit tr:nth-child('+rowindex+') td:nth-child(15)').children('input').val());
                    
                    if(goodSn==0){
                        return
                    }
                    $("#addsefarishtblEdit").append(`<tr onclick="checkAddedKalaOfOrderAmount(this)">
                        <td style="width:30px!important;">`+($(event.target).parents("tr").index()+1)+`</td>
                        <td style="width:40px!important;" class="td-part-input"> <input type="text"  class="td-input td-inputCodeEdit form-control"></td>
                        <td style="width:130px!important;" class="td-part-input"> <input type="text" class="td-input td-inputCodeNameEdit form-control"></td>
                        <td style="width:50px!important;" class="td-part-input"> <input type="text"  class="td-input td-inputFirstUnitEdit form-control"></td>
                        <td style="width:70px!important;" class="td-part-input"> <input type="text"  class="td-input td-inputFirstUnitEdit form-control"></td>
                        <td style="width:70px!important;" class="td-part-input"> <input type="text"  class="td-input td-inputSecondUnitAmountEdit form-control"></td>
                        <td style="width:50px!important;" class="td-part-input"> <input type="text"  class="td-input td-inputEachFirstUnitAmountEdit form-control"></td>
                        <td style="width:70px!important;" class="td-part-input"> <input type="text"  class="td-input td-inputFirstUnitAmountEdit form-control"></td>
                        <td style="width:70px!important;" class="td-part-input"> <input type="text"  class="td-input td-inputFirstUnitPriceEdit form-control"></td>
                        <td style="width:70px!important;" class="td-part-input"> <input type="text"  class="td-input td-inputSecondUnitPriceEdit form-control"></td>
                        <td style="width:70px!important;" class="td-part-input"> <input type="text"  class="td-input td-inputAllPriceEdit form-control"></td>
                        <td style="width:70px!important;" class="td-part-input"> <input type="text"  class="td-input td-inputErsalTypeEdit form-control"></td>
                        <td style="width:52px!important;" class="td-part-input"> <input type="text"  class="td-input td-inputDescriptionEdit form-control"></td>
                        <td class="td-part-input d-none"><input type="text" value="1" class="td-input form-control"><input type="checkbox" name="orderBYSs[]" value="" class="td-input form-control" checked></td>
                        <td  class="td-part-input d-none"><input type="text" value="0" class="td-input form-control"></td>
                    </tr>`);
                    $("#newSefarishTblEdit tr:last td:nth-child(2)").children('input').focus();
                    $("#newSefarishTblEdit tr").removeClass("selected");
                    $("#newSefarishTblEdit tr:last").addClass("selected");
                }
                break;
            case "addsefarishtbl":
                {
                    let rowindex=$(event.target).parents("tr").index()+1
                    let goodSn=parseInt($('#addsefarishtbl tr:nth-child('+rowindex+') td:nth-child(15)').children('input').val());
                    
                    if(goodSn==0){
                        return
                    }
                    $("#addsefarishtbl").append(`<tr onclick="checkAddedKalaToSefarishAmount(this)">
                                        <td style="width:30px!important;">`+($(event.target).parents("tr").index()+1)+`</td>
                                        <td style="width:40px!important;" class="td-part-input"> <input type="text"  class="td-input td-inputCode form-control"></td>
                                        <td style="width:130px!important;" class="td-part-input"> <input type="text" class="td-input td-inputCodeName form-control"></td>
                                        <td style="width:50px!important;" class="td-part-input"> <input type="text"  class="td-input td-inputFirstUnit form-control"></td>
                                        <td style="width:70px!important;" class="td-part-input"> <input type="text"  class="td-input td-inputFirstUnit form-control"></td>
                                        <td style="width:70px!important;" class="td-part-input"> <input type="text"  class="td-input td-inputSecondUnitAmount form-control"></td>
                                        <td style="width:50px!important;" class="td-part-input"> <input type="text"  class="td-input td-inputEachFirstUnitAmount form-control"></td>
                                        <td style="width:70px!important;" class="td-part-input"> <input type="text"  class="td-input td-inputFirstUnitAmount form-control"></td>
                                        <td style="width:70px!important;" class="td-part-input"> <input type="text"  class="td-input td-inputFirstUnitPrice form-control"></td>
                                        <td style="width:70px!important;" class="td-part-input"> <input type="text"  class="td-input td-inputSecondUnitPrice form-control"></td>
                                        <td style="width:70px!important;" class="td-part-input"> <input type="text"  class="td-input td-inputAllPrice form-control"></td>
                                        <td style="width:70px!important;" class="td-part-input"> <input type="text"  class="td-input td-inputErsalType form-control"></td>
                                        <td style="width:52px!important;" class="td-part-input"> <input type="text"  class="td-input td-inputDescription form-control"></td>
                                        <td class="td-part-input d-none"><input type="text" value="1" class="td-input form-control"><input type="checkbox" name="orderBYSs[]" value="" class="td-input form-control" checked></td>
                                        <td  class="td-part-input d-none"><input type="text" value="0" class="td-input form-control"></td>
                                    </tr>`);
                    $("#newSefarishTbl tr:last td:nth-child(2)").children('input').focus();
                    $("#newSefarishTbl tr").removeClass("selected");
                    $("#newSefarishTbl tr:last").addClass("selected");
                }
                break;
        
            default:
                break;
        }
    }

    if(event.keyCode==38){
        switch (activeForm) {
            case "addsefarishtblEdit":
                {
                    let rowindex=$(event.target).parents("tr").index()
                    let goodSn=parseInt($('#addsefarishtblEdit tr:nth-child('+rowindex+') td:nth-child(15)').children('input').val());
                    if(goodSn==0){
                        $("#newSefarishTblEdit tr:last").remove();
                        $("#newSefarishTblEdit tr:last td:nth-child(2)").children('input').focus();
                        $("#newSefarishTblEdit tr").removeClass("selected");
                        $("#newSefarishTblEdit tr:last").addClass("selected");
                    }
                }
                break;
            case "addsefarishtbl":
                {
                    let rowindex=$(event.target).parents("tr").index()
                    let goodSn=parseInt($('#addsefarishtbl tr:nth-child('+rowindex+') td:nth-child(15)').children('input').val());
                    if(goodSn==0){
                        $("#newSefarishTbl tr:last").remove();
                        $("#newSefarishTbl tr:last td:nth-child(2)").children('input').focus();
                        $("#newSefarishTbl tr").removeClass("selected");
                        $("#newSefarishTbl tr:last").addClass("selected");
                    }
                }
                break;
        
            default:
                break;
        }
    }

});

function setActiveForm(activeFormId){
    activeForm=activeFormId;
}

let activeTableOrder="";
let selectedRowOrder=0;
$(document).keydown((event)=>{
    if(event.keyCode==40){
        event.preventDefault();
        switch (activeTableOrder) {
            case "foundCusotmerForOrderBody":
                {
                    var rowCount = $("#foundCusotmerForOrderBody tr:last").index() + 1;
                    let tableBody=$("#foundCusotmerForOrderBody");
                    if (selectedRowOrder >= 0) {
                        $("#foundCusotmerForOrderBody tr").eq(selectedRowOrder).css('background-color', '');
                    }
                    if(selectedRowOrder!=0){
                        selectedRowOrder = Math.min(selectedRowOrder + 1, rowCount - 1); 
                        $("#foundCusotmerForOrderBody tr").eq(selectedRowOrder).css('background-color', "rgb(0,142,201)"); 
                    }else{
                        selectedRowOrder = Math.min(1, rowCount - 1); 
                        $("#foundCusotmerForOrderBody tr").eq(selectedRowOrder).css('background-color', "rgb(0,142,201)"); 
                    }
                    element=$("#foundCusotmerForOrderBody tr").eq(selectedRowOrder)
                    let custerSn=$(element).find('input[type="radio"]').val();
                    selectCustomerForOrder(custerSn,element)
                    let topTr = $("#foundCusotmerForOrderBody tr").eq(selectedRowOrder).position().top;
                    let bottomTr =topTr+50;
                    let trHieght =50;
                    if(topTr > 0 && bottomTr < 450){
                    }else{
                        let newScrollTop =trHieght+ parseInt(localStorage.getItem("scrollTop"));
                        tableBody.scrollTop(parseInt(newScrollTop));
                        localStorage.setItem("scrollTop",newScrollTop);
                    }
                }
                break;
            case "kalaForAddToSefarish":
                {
                    var rowCount = $("#kalaForAddToSefarish tr:last").index() + 1;
                    let tableBody=$("#kalaForAddToSefarish");
                    if (selectedRowOrder >= 0) {
                        $("#kalaForAddToSefarish tr").eq(selectedRowOrder).css('background-color', '');
                    }
                    if(selectedRowOrder!=0){
                        selectedRowOrder = Math.min(selectedRowOrder + 1, rowCount - 1); 
                        $("#kalaForAddToSefarish tr").eq(selectedRowOrder).css('background-color', "rgb(0,142,201)"); 
                    }else{
                        selectedRowOrder = Math.min(1, rowCount - 1); 
                        $("#kalaForAddToSefarish tr").eq(selectedRowOrder).css('background-color', "rgb(0,142,201)"); 
                    }
                    element=$("#kalaForAddToSefarish tr").eq(selectedRowOrder)
                    let snOrder=$(element).find('input[type="radio"]').val();
                    setAddedTosefarishKalaStuff(element,snOrder)
                    let topTr = $("#kalaForAddToSefarish tr").eq(selectedRowOrder).position().top;
                    let bottomTr =topTr+50;
                    let trHieght =50;
                    if(topTr > 0 && bottomTr < 450){
                    }else{
                        let newScrollTop =trHieght+ parseInt(localStorage.getItem("scrollTop"));
                        tableBody.scrollTop(parseInt(newScrollTop));
                        localStorage.setItem("scrollTop",newScrollTop);
                    }
                }
                break;
            case "foundCusotmerForOrderBodyEdit":
                {
                    var rowCount = $("#foundCusotmerForOrderBodyEdit tr:last").index() + 1;
                    let tableBody=$("#foundCusotmerForOrderBodyEdit");
                    if (selectedRowOrder >= 0) {
                        $("#foundCusotmerForOrderBodyEdit tr").eq(selectedRowOrder).css('background-color', '');
                    }
                    if(selectedRowOrder!=0){
                        selectedRowOrder = Math.min(selectedRowOrder + 1, rowCount - 1); 
                        $("#foundCusotmerForOrderBodyEdit tr").eq(selectedRowOrder).css('background-color', "rgb(0,142,201)"); 
                    }else{
                        selectedRowOrder = Math.min(1, rowCount - 1); 
                        $("#foundCusotmerForOrderBodyEdit tr").eq(selectedRowOrder).css('background-color', "rgb(0,142,201)"); 
                    }
                    element=$("#foundCusotmerForOrderBodyEdit tr").eq(selectedRowOrder)
                    let custerSn=$(element).find('input[type="radio"]').val();
                    
                    selectCustomerForOrderEdit(custerSn,element)
                    let topTr = $("#foundCusotmerForOrderBodyEdit tr").eq(selectedRowOrder).position().top;
                    let bottomTr =topTr+50;
                    let trHieght =50;
                    if(topTr > 0 && bottomTr < 450){
                    }else{
                        let newScrollTop =trHieght+ parseInt(localStorage.getItem("scrollTop"));
                        tableBody.scrollTop(parseInt(newScrollTop));
                        localStorage.setItem("scrollTop",newScrollTop);
                    }
                }
                break;
            case "kalaForAddToOrderEdit":
                {
                    var rowCount = $("#kalaForAddToOrderEdit tr:last").index() + 1;
                    let tableBody=$("#kalaForAddToOrderEdit");
                    if (selectedRowOrder >= 0) {
                        $("#kalaForAddToOrderEdit tr").eq(selectedRowOrder).css('background-color', '');
                    }
                    if(selectedRowOrder!=0){
                        selectedRowOrder = Math.min(selectedRowOrder + 1, rowCount - 1); 
                        $("#kalaForAddToOrderEdit tr").eq(selectedRowOrder).css('background-color', "rgb(0,142,201)"); 
                    }else{
                        selectedRowOrder = Math.min(1, rowCount - 1); 
                        $("#kalaForAddToOrderEdit tr").eq(selectedRowOrder).css('background-color', "rgb(0,142,201)"); 
                    }
                    
                    element=$("#kalaForAddToOrderEdit tr").eq(selectedRowOrder)
                    let goodSn=$(element).find('input[type="radio"]').val();
                    setAddedToOrderEditKalaStuff(element,goodSn)
                    
                    let topTr = $("#kalaForAddToOrderEdit tr").eq(selectedRowOrder).position().top;
                    let bottomTr =topTr+50;
                    let trHieght =50;
                    if(topTr > 0 && bottomTr < 450){
                    }else{
                        let newScrollTop =trHieght+ parseInt(localStorage.getItem("scrollTop"));
                        tableBody.scrollTop(parseInt(newScrollTop));
                        localStorage.setItem("scrollTop",newScrollTop);
                    }
                }
                break;
        }
    }
    if(event.keyCode==38){
        event.preventDefault();
        switch (activeTableOrder) {
            case "foundCusotmerForOrderBody":
                {
                    var rowCount = $("#foundCusotmerForOrderBody tr:last").index() + 1;
                    let tableBody=$("#foundCusotmerForOrderBody");
                    if (selectedRowOrder >= 0) {
                        $("#foundCusotmerForOrderBody tr").eq(selectedRowOrder).css('background-color', '');
                    }
                    if(selectedRowOrder!=0){
                        selectedRowOrder = Math.max(selectedRowOrder  - 1, 0); 
                        $("#foundCusotmerForOrderBody tr").eq(selectedRowOrder).css('background-color', "rgb(0,142,201)"); 
                    }else{
                        selectedRowOrder = Math.min(1, rowCount - 1); 
                        $("#foundCusotmerForOrderBody tr").eq(selectedRowOrder).css('background-color', "rgb(0,142,201)"); 
                    }
                    element=$("#foundCusotmerForOrderBody tr").eq(selectedRowOrder)
                    let custerSn=$(element).find('input[type="radio"]').val();
                    selectCustomerForOrderEdit(custerSn,element)
                    let topTr = $("#foundCusotmerForOrderBody tr").eq(selectedRowOrder).position().top;
                    let bottomTr =topTr+50;
                    let trHieght =50;
                    if(topTr > 0 && bottomTr < 450){
                    }else{
                        let newScrollTop =trHieght+ parseInt(localStorage.getItem("scrollTop"));
                        tableBody.scrollTop(parseInt(newScrollTop));
                        localStorage.setItem("scrollTop",newScrollTop);
                    }
                }
                break;
            case "kalaForAddToSefarish":
                {
                    var rowCount = $("#kalaForAddToSefarish tr:last").index() + 1;
                    let tableBody=$("#kalaForAddToSefarish");
                    if (selectedRowOrder >= 0) {
                        $("#kalaForAddToSefarish tr").eq(selectedRowOrder).css('background-color', '');
                    }
                    if(selectedRowOrder!=0){
                        selectedRowOrder = Math.max(selectedRowOrder  - 1, 0); 
                        $("#kalaForAddToSefarish tr").eq(selectedRowOrder).css('background-color', "rgb(0,142,201)"); 
                    }else{
                        selectedRowOrder = Math.min(1, rowCount - 1); 
                        $("#kalaForAddToSefarish tr").eq(selectedRowOrder).css('background-color', "rgb(0,142,201)"); 
                    }
                    element=$("#kalaForAddToSefarish tr").eq(selectedRowOrder)
                    let snOrder=$(element).find('input[type="radio"]').val();
                    setAddedTosefarishKalaStuff(element,snOrder)
                    let topTr = $("#kalaForAddToSefarish tr").eq(selectedRowOrder).position().top;
                    let bottomTr =topTr+50;
                    let trHieght =50;
                    if(topTr > 0 && bottomTr < 450){
                    }else{
                        let newScrollTop =trHieght+ parseInt(localStorage.getItem("scrollTop"));
                        tableBody.scrollTop(parseInt(newScrollTop));
                        localStorage.setItem("scrollTop",newScrollTop);
                    }
                }
                break;
            case "foundCusotmerForOrderBodyEdit":
                {
                    var rowCount = $("#foundCusotmerForOrderBodyEdit tr:last").index() + 1;
                    let tableBody=$("#foundCusotmerForOrderBodyEdit");
                    if (selectedRowOrder >= 0) {
                        $("#foundCusotmerForOrderBodyEdit tr").eq(selectedRowOrder).css('background-color', '');
                    }
                    if(selectedRowOrder!=0){
                        selectedRowOrder = Math.max(selectedRowOrder  - 1, 0); 
                        $("#foundCusotmerForOrderBodyEdit tr").eq(selectedRowOrder).css('background-color', "rgb(0,142,201)"); 
                    }else{
                        selectedRowOrder = Math.min(1, rowCount - 1); 
                        $("#foundCusotmerForOrderBodyEdit tr").eq(selectedRowOrder).css('background-color', "rgb(0,142,201)"); 
                    }
                    element=$("#foundCusotmerForOrderBodyEdit tr").eq(selectedRowOrder)
                    let custerSn=$(element).find('input[type="radio"]').val();
                    selectCustomerForOrderEdit(custerSn,element)
                    let topTr = $("#foundCusotmerForOrderBodyEdit tr").eq(selectedRowOrder).position().top;
                    let bottomTr =topTr+50;
                    let trHieght =50;
                    if(topTr > 0 && bottomTr < 450){
                    }else{
                        let newScrollTop =trHieght+ parseInt(localStorage.getItem("scrollTop"));
                        tableBody.scrollTop(parseInt(newScrollTop));
                        localStorage.setItem("scrollTop",newScrollTop);
                    }
                }
                break;
            case "kalaForAddToOrderEdit":
                {
                    var rowCount = $("#kalaForAddToOrderEdit tr:last").index() + 1;
                    let tableBody=$("#kalaForAddToOrderEdit");
                    if (selectedRowOrder >= 0) {
                        $("#kalaForAddToOrderEdit tr").eq(selectedRowOrder).css('background-color', '');
                    }
                    if(selectedRowOrder!=0){
                        selectedRowOrder = Math.min(selectedRowOrder - 1, 0); 
                        $("#kalaForAddToOrderEdit tr").eq(selectedRowOrder).css('background-color', "rgb(0,142,201)"); 
                    }else{
                        selectedRowOrder = Math.min(1, rowCount - 1); 
                        $("#kalaForAddToOrderEdit tr").eq(selectedRowOrder).css('background-color', "rgb(0,142,201)"); 
                    }
                    element=$("#kalaForAddToOrderEdit tr").eq(selectedRowOrder)
                    let goodSn=$(element).find('input[type="radio"]').val();
                    setAddedToOrderEditKalaStuff(element,goodSn)
                    let topTr = $("#kalaForAddToOrderEdit tr").eq(selectedRowOrder).position().top;
                    let bottomTr =topTr+50;
                    let trHieght =50;
                    if(topTr > 0 && bottomTr < 450){
                    }else{
                        let newScrollTop =trHieght+ parseInt(localStorage.getItem("scrollTop"));
                        tableBody.scrollTop(parseInt(newScrollTop));
                        localStorage.setItem("scrollTop",newScrollTop);
                    }
                }
                break;
        
            default:
                break;
        }
    }
});

function setActiveTableOrder(orderTableId){
    activeTableOrder=orderTableId;
}



