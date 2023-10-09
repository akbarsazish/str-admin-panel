var baseUrl = "http://127.0.0.1:8000";
function openNewOrderModal(){
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

$(document).on("keyup",".td-inputCodeName", (e)=>{
    if((e.keyCode>=65 && e.keyCode<=90) || ((e.keyCode>=48 && e.keyCode<=57) || (e.keyCode>=96 && e.keyCode<=105))){
        $("#rowTaker").val($(e.target).parents("tr").index()+1)

        if (!($('.modal.in').length)) {
            $('.modal-dialog').css({
                top: 0,
                left: 0
            });
        }
        $('#addOrderItem1').modal({
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
        $("#addOrderItem1").modal("show");
        $('#addOrderItem1').on('shown.bs.modal', function() {
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
                                                        <td> ${(i)} </td>
                                                        <td> ${customer.PCode} </td>
                                                        <td> ${customer.Name} </td>
                                                        <td> ${customer.countBuy} </td>
                                                        <td> ${customer.countSale} </td>
                                                        <td> ${customer.chequeCountReturn} </td>
                                                        <td> ${customer.chequeMoneyReturn} </td>
                                                    </tr>`);
            }else{
                tableBody.append(`<tr onclick="selectCustomerForOrder(${customer.PSN},this)">
                    <td> ${(i)} </td>
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
        let selectedRow = 0;
        Mousetrap.bind('down', function (e) {
            if (selectedRow >= 0) {
                $("#foundCusotmerForOrderBody tr").eq(selectedRow).css('background-color', '');
            }
            if(selectedRow!=0){
                selectedRow = Math.min(selectedRow + 1, data.length - 1); 
                $("#foundCusotmerForOrderBody tr").eq(selectedRow).css('background-color', "rgb(0,142,201)"); 
            }else{
                selectedRow = Math.min(1, data.length - 1); 
                $("#foundCusotmerForOrderBody tr").eq(selectedRow).css('background-color', "rgb(0,142,201)"); 
            }

            const selectedPSN = data[selectedRow].PSN;
            selectCustomerForOrder(selectedPSN,selectedRow)
            let topTr = $("#foundCusotmerForOrderBody tr").eq(selectedRow).position().top;
            let bottomTr =topTr+50;
            let tbodyHeight = tableBody.height();
            let trHieght =50;
            if(topTr > 0 && bottomTr < tbodyHeight){
            }else{
                let newScrollTop =trHieght+ parseInt(localStorage.getItem("scrollTop"));
                tableBody.scrollTop(newScrollTop);
                localStorage.setItem("scrollTop",newScrollTop);
            }
        });

        Mousetrap.bind('up', function (e) {

            if (selectedRow >= 0) {
                $("#foundCusotmerForOrderBody tr").eq(selectedRow).css('background-color','');
            }

            selectedRow = Math.max(selectedRow - 1, 0); 
            $("#foundCusotmerForOrderBody tr").eq(selectedRow).css('background-color', 'rgb(0,142,201)'); 
            const selectedPSN = data[selectedRow].PSN;
            selectCustomerForOrder(selectedPSN,selectedRow)
            let topTr = $("#foundCusotmerForOrderBody tr").eq(selectedRow).position().top;
            let bottomTr =topTr+parseInt($("#foundCusotmerForOrderBody tr").eq(selectedRow).height());
            let tbodyHeight = tableBody.height();
            let trHieght =50;
            //alert(topTr)
            if(topTr >117 && bottomTr < tbodyHeight){
                
            }else{
                let newScrollTop = parseInt(localStorage.getItem("scrollTop"))-(trHieght);
                tableBody.scrollTop(newScrollTop);
                localStorage.setItem("scrollTop",newScrollTop);
            }
        });

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

        $("#rowTaker").val($(e.target).parents("tr").index()+1)

        if (!($('.modal.in').length)) {
            $('.modal-dialog').css({
                top: 0,
                left: 0
            });
        }

        $('#addOrderItem1').modal({
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
        $("#addOrderItem1").modal("show");
        $('#addOrderItem1').on('shown.bs.modal', function() {
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
                            tableBody.append(`<tr onclick="setAddedTosefarishKalaStuff(this,`+element.GoodSn+`)"> <td>`+(i)+`</td> <td> `+element.GoodCde+` </td><td> `+element.GoodName+`</td> <td>...</td> </tr>`);
                        }else{
                            tableBody.append(`<tr onclick="setAddedTosefarishKalaStuff(this,`+element.GoodSn+`)"> <td>`+(i)+`</td> <td> `+element.GoodCde+` </td><td> `+element.GoodName+`</td> <td>...</td> </tr>`);
                            $("#kalaForAddToSefarish tr").eq(0).css('background-color', 'rgb(0,142,201)'); 
                            const selectedGoodSn = data[0].GoodSn;
                            setAddedTosefarishKalaStuff(0,selectedGoodSn)
                        }
                    }

                    let selectedRow = 0;
                    Mousetrap.bind('down', function (e) {
                        if (selectedRow >= 0) {
                            $("#kalaForAddToSefarish tr").eq(selectedRow).css('background-color', '');
                        }
                    if(selectedRow!=0){
                        selectedRow = Math.min(selectedRow + 1, data.length - 1); 
                        $("#kalaForAddToSefarish tr").eq(selectedRow).css('background-color', 'rgb(0,142,201)'); 
                    }else{
                        selectedRow = Math.min( 1, data.length - 1); 
                        $("#kalaForAddToSefarish tr").eq(selectedRow).css('background-color', 'rgb(0,142,201)'); 
                    }
                    const selectedGoodSn = data[selectedRow].GoodSn;
                    setAddedTosefarishKalaStuff(selectedRow,selectedGoodSn)
                    let topTr = $("#kalaForAddToSefarish tr").eq(selectedRow).position().top;
                    let bottomTr =topTr+37;
                    let tbodyHeight = tableBody.height();
                    let trHieght =37;
                    
                    if(topTr > 0 && bottomTr < tbodyHeight){
                        
                    }else{
                        let newScrollTop =trHieght+ parseInt(localStorage.getItem("scrollTop"));
                        tableBody.scrollTop(newScrollTop);
                        localStorage.setItem("scrollTop",newScrollTop);
                    }
                    
                    });

                    Mousetrap.bind('up', function (e) {
                        if (selectedRow >= 0) {
                            $("#kalaForAddToSefarish tr").eq(selectedRow).css('background-color', '');
                        }

                        selectedRow = Math.max(selectedRow - 1, 0); 
                        $("#kalaForAddToSefarish tr").eq(selectedRow).css('background-color', 'rgb(0,142,201)'); 

                        const selectedGoodSn = data[selectedRow].GoodSn;
                        setAddedTosefarishKalaStuff(selectedRow,selectedGoodSn)
                        let topTr = $("#kalaForAddToSefarish tr").eq(selectedRow).position().top;
                        let bottomTr =topTr+parseInt($("#kalaForAddToSefarish tr").eq(selectedRow).height());
                        let tbodyHeight = tableBody.height();
                        let trHieght =39;

                        if(topTr >276 && bottomTr < tbodyHeight){
                            
                        }else{
                            let newScrollTop = parseInt(localStorage.getItem("scrollTop"))-(trHieght);
                            tableBody.scrollTop(newScrollTop);
                            localStorage.setItem("scrollTop",newScrollTop);
                        }
                    });

                    Mousetrap.bind("enter",()=>{
                        $("#selectKalaToSefarishBtn").trigger("click");
                    });

                    Mousetrap.bind("esc",()=>{
                        $("#addOrderItem1").modal("hide");
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
                            tableBody.append(`<tr onclick="setAddedTosefarishKalaStuff(this,`+element.GoodSn+`)"> <td>`+(i)+`</td> <td> `+element.GoodCde+` </td><td> `+element.GoodName+`</td> <td>...</td> </tr>`);
                        }else{
                            tableBody.append(`<tr onclick="setAddedTosefarishKalaStuff(this,`+element.GoodSn+`)"> <td>`+(i)+`</td> <td> `+element.GoodCde+` </td><td> `+element.GoodName+`</td> <td>...</td> </tr>`);
                            
                            $("#kalaForAddToSefarish tr").eq(0).css('background-color', 'rgb(0,142,201)'); 
                            const selectedGoodSn = data[0].GoodSn;
                            setAddedTosefarishKalaStuff(0,selectedGoodSn)
                        }
                    }

                    let selectedRow = 0;
                    Mousetrap.bind('down', function (e) {
                        if (selectedRow >= 0) {
                            $("#kalaForAddToSefarish tr").eq(selectedRow).css('background-color', '');
                        }
                        if(selectedRow!=0){
                            selectedRow = Math.min(selectedRow + 1, data.length - 1); 
                            $("#kalaForAddToSefarish tr").eq(selectedRow).css('background-color', 'rgb(0,142,201)'); 
                        }else{
                            selectedRow = Math.min( 1, data.length - 1); 
                            $("#kalaForAddToSefarish tr").eq(selectedRow).css('background-color', 'rgb(0,142,201)'); 
                        }
                        const selectedGoodSn = data[selectedRow].GoodSn;
                        setAddedTosefarishKalaStuff(selectedRow,selectedGoodSn)
                        let topTr = $("#kalaForAddToSefarish tr").eq(selectedRow).position().top;
                        let bottomTr =topTr+37;
                        let tbodyHeight = tableBody.height();
                        let trHieght =37;
                        if(topTr > 0 && bottomTr < tbodyHeight){
                            
                        }else{
                            let newScrollTop =trHieght+ parseInt(localStorage.getItem("scrollTop"));
                            tableBody.scrollTop(newScrollTop);
                            localStorage.setItem("scrollTop",newScrollTop);
                        }
                    
                    });

                    Mousetrap.bind('up', function (e) {
                        if (selectedRow >= 0) {
                            $("#kalaForAddToSefarish tr").eq(selectedRow).css('background-color', '');
                        }

                        selectedRow = Math.max(selectedRow - 1, 0); 
                        $("#kalaForAddToSefarish tr").eq(selectedRow).css('background-color', 'rgb(0,142,201)'); 

                        const selectedGoodSn = data[selectedRow].GoodSn;
                        setAddedTosefarishKalaStuff(selectedRow,selectedGoodSn)
                        let topTr = $("#kalaForAddToSefarish tr").eq(selectedRow).position().top;
                        let bottomTr =topTr+parseInt($("#kalaForAddToSefarish tr").eq(selectedRow).height());
                        let tbodyHeight = tableBody.height();
                        let trHieght =39;

                        if(topTr >276 && bottomTr < tbodyHeight){
                            
                        }else{
                            let newScrollTop = parseInt(localStorage.getItem("scrollTop"))-(trHieght);
                            tableBody.scrollTop(newScrollTop);
                            localStorage.setItem("scrollTop",newScrollTop);
                        }
                    });
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
 $("#selectKalaToSefarishBtn").val(goodSn)
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
            $("#AddStockExistance").text(parseInt(response[0][0].Amount).toLocaleString("en-us"));
            if (!isNaN(parseInt(response[0][0].Amount))) {
                $("#AddExistInStock").text(parseInt(response[0][0].Amount).toLocaleString("en-us"));
            } else {
                $("#AddExistInStock").text('ندارد');
            }
        }else {
            $("#AddExistInStock").text('ندارد');
        }
        if(response[1][0]){
            $("#AddPrice").text(parseInt(response[1][0].Price3).toLocaleString("en-us"));
            if (!isNaN(parseInt(response[1][0].Price3))) {
                $("#AddPrice").text(parseInt(response[1][0].Price3 / 10).toLocaleString("en-us"));
            } else {
                $("#AddPrice").text('ندارد');
            }
        } else {
            $("#AddPrice").text('ندارد');
        }

        if (response[2][0]) {
            $("#AddPriceCustomer").text(parseInt(response[2][0].Fi).toLocaleString("en-us"));
            if (!isNaN(parseInt(response[2][0].Fi))) {
                $("#AddLastPriceCustomer").text(parseInt(response[2][0].Fi / 10).toLocaleString("en-us"));
            } else {
                $("#AddLastPriceCustomer").text('ندارد');
            }
        }else {
            $("#AddLastPriceCustomer").text('ندارد');
        }

        if([3][0]){
            if (!isNaN(parseInt(response[3][0].Fi))) {
                $("#AddLastPrice").text(parseInt(response[3][0].Fi / 10).toLocaleString("en-us"));
            } else {
                $("#AddLastPrice").text('ندارد');
            }
        }else {
            $("#AddLastPrice").text('ندارد');
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
                                            </tr>`)
        $(`#addsefarishtbl tr:nth-child(`+$("#rowTaker").val()+`)`).replaceWith(row);
        $(`#addsefarishtbl tr:nth-child(`+$("#rowTaker").val()+`) td:nth-child(6) input`).focus();
        $(`#addsefarishtbl tr:nth-child(`+$("#rowTaker").val()+`) td:nth-child(6) input`).select();

        
        checkAddedKalaToSefarishAmountAfterAdd(data[0].GoodSn);
        }
    });

    $("#addOrderItem1").modal("hide");
});


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

$("#addNewOrderForm").on("keydown",function(event){

    if (event.keyCode == 13) {
        event.preventDefault();
    }
})                  
                    

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
            text: "به این اندازه موجودی ندارد.",
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
    if((e.keyCode>=65 && e.keyCode<=90)|| ((e.keyCode>=48 && e.keyCode<=57) || (e.keyCode>=96 && e.keyCode<=105))){
        if(localStorage.getItem("allowedChangePrice")==0){
        swal({
            text: "میخواهید قیمت اصلی را تغییر دهید؟",
            text:"در صورت ادامه این قیمت محاسبه خواهد شد.",
            icon: "warning",
            buttons: true,
            dangerMode: true,
            }).then(
                ()=>{

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
                localStorage.setItem("allowedChangePrice",1)
            }
        )
        }else{
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
        }
    }
    if(e.keyCode==9 || e.keyCode==13){
        var $currentInput = $(e.target);
        var $nextInput = $currentInput.closest('td').next('td').find('input');
        localStorage.setItem("allowedChangePrice",0)
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

                $("#goodAmountInStock").text(parseInt(respond[1][0].Amount).toLocaleString("en-us"));

            }

            if(respond[2][0]){

                $("#goodPriceAddSefarish").text(parseInt(respond[2][0].Price3).toLocaleString("en-us"));

            }
            if(respond[4][0]){

                $("#lastSalePriceAddSefarish").text(parseInt(respond[4][0].Fi).toLocaleString("en-us"));
                
            }

            if(respond[3][0]){

                $("#lastSalePriceToThisCustomerAddSefarish").text(parseInt(respond[3][0].Price3).toLocaleString("en-us"));

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
            
            if(respond[1][0]){

                $("#goodAmountInStock").text(parseInt(respond[1][0].Amount).toLocaleString("en-us"));

            }

            if(respond[2][0]){

                $("#goodPriceAddSefarish").text(parseInt(respond[2][0].Price3).toLocaleString("en-us"));

            }
            if(respond[4][0]){

                $("#lastSalePriceAddSefarish").text(parseInt(respond[4][0].Fi).toLocaleString("en-us"));
                
            }

            if(respond[3][0]){

                $("#lastSalePriceToThisCustomerAddSefarish").text(parseInt(respond[3][0].Price3).toLocaleString("en-us"));

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