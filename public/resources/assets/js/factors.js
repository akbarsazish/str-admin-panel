var baseUrl = "http://192.168.10.26:8080";
$("#filterFactorsForm").on("submit",function(e){
    e.preventDefault();
    $.ajax({
        method: $(this).attr('method'),
        url: $(this).attr('action'),
        data:$(this).serialize(),
        processData: false,
        contentType: false,
        success: function (respond) {
            $("#factorListBody").empty();
            respond.forEach((element,index) => {
                let bargiriyState='شده';
                let payedAmount=0;
                let bazaryabPorsant=0;
                let trStyle="";
                if(element.bargiriyState!='YES'){
                    bargiriyState="نشده";
                }
                if(element.tasviyehState=='NO'){
                    trStyle="background-color:rgb(232, 22, 144)";
                }
                if(element.TotalPricePorsant>0){
                    bazaryabPorsant=element.TotalPricePorsant;
                }
                if(element.payedAmount>0){
                    payedAmount=element.payedAmount;
                }
                $("#factorListBody").append(`
                                            <tr class="factorTablRow" style="${trStyle}" onclick="getFactorOrders(this,${element.SerialNoHDS})">
                                                <td> ${index+1} </td>
                                                <td> ${element.FactNo} </td>
                                                <td> ${element.FactDate} </td>
                                                <td> ${element.FactDesc} </td>
                                                <td> ${element.PCode} </td>
                                                <td> ${element.Name} </td>
                                                <td> ${parseInt(element.NetPriceHDS).toLocaleString("en-us")} </td>
                                                <td> ${parseInt(payedAmount).toLocaleString("en-us")} </td>
                                                <td> ${element.setterName} </td>
                                                <td> حضوری </td>
                                                <td> حضوری </td>
                                                <td> ${element.stockName} </td>
                                                <td> ${element.CountPrint} </td>
                                                <td> ${parseInt(bazaryabPorsant).toLocaleString("en-us")} </td>
                                                <td> ${bargiriyState} </td>
                                                <td> ${element.takhfif} </td>
                                                <td>  </td>
                                                <td> ${element.DateEelamBeAnbar} </td>
                                                <td> ${element.TimeEelamBeAnbar} </td>
                                                <td> ${element.DateBargiri} </td>
                                                <td> ${element.TimeBargiri} </td>
                                                <td> ${element.BarNameNo} </td>
                                                <td> ${element.FactTime} </td>
                                                <td> خیر </td>
                                                <td> ${(element.bargiriNo||"")} </td>
                                                <td> ${(element.driverTahvilDate || "")} </td>
                                                <td> ${(element.driverName || "")} </td>
                                            </tr>`);
            });
        },
        error:function(error){

        }
    });
});

$("#customerCode").on("keyup",function(){
    $.get(baseUrl+"/getCustomerByCode",{PCode:$("#customerCode").val()},(respond,status)=>{
        $("#customerName").val("");
        $("#customerName").val(respond[0].Name);
    });
})

$("#editFactorForm").on("keydown",function(e){
    if(e.keyCode==13){
        e.preventDefault();
    }
})

function openEditFactorModal(snFactor){
    $.get(baseUrl+"/getFactorInfoForEdit",{SnFactor:snFactor},(respond,status)=>{
        $("#factorEditListBody").empty();
        $("#customerForSefarishId").val(respond.factorInfo[0].PSN);
        $("#FactNoEdit").val(respond.factorInfo[0].FactNo);
        $("#SerialNoHDSEdit").val(respond.factorInfo[0].SerialNoHDS);
        $("#NameEdit").val(respond.factorInfo[0].Name);
        $("#FactDateEdit").val(respond.factorInfo[0].FactDate);
        $("#bazaryabNameEdit").val(respond.factorInfo[0].BName);
        $("#bazaryabCodeEdit").val(respond.factorInfo[0].BPCode);
        $("#pCodeEdit").val(respond.factorInfo[0].PCode);
        $("#ّFactDescEdit").val(respond.factorInfo[0].FactDesc);
        $("#MotafariqahNameEdit").val(respond.factorInfo[0].OtherCustName);
        $("#MotafariqahMobileEdit").val(respond.factorInfo[0].MobileOtherCust);
        
        if(respond.factorInfo[0].SnAmel==142){
            $("#ّtakeKerayahEdit").prop("checked",true)
        }
        
        $("#sockEdit").empty()
        respond.stocks.forEach((element,index)=>{
            if(element.SnStock!= respond.factorInfo[0].SnStockIn){
                $("#stockEdit").append(`<option value="${element.SnStock}">${element.NameStock}</option>`);
            }else{
                $("#stockEdit").append(`<option value="${element.SnStock}" selected>${element.NameStock}</option>`);
            }
        })
        respond.factorInfo.forEach((element,index)=>{
            let firstAmount=0;
            let reAmount=0;
            let packAmount=0;
            if(element.FirstAmout>0){
                firstAmount=element.FirstAmout;
            }
            if(element.ReAmount>0){
                reAmount=element.ReAmount;
            }
            if(element.PackAmnt>0){
                packAmount=element.PackAmnt;
            }
            $("#factorEditListBody").append(`
                <tr class="factorTablRow" onclick="checkAddedKalaAmountOfFactor(this)">
                    <td class="td-part-input"> ${index+1} <input type="radio" value="${element.Amount}" style="display:none" /> </td>
                    <td class="td-part-input"> <input type="text" name="GoodCde${element.GoodSn}" value="${element.GoodCde}" class="td-input td-inputCodeEdit form-control" required> <input type="radio" value="`+element.AmountUnit+`" class="td-input form-control"> <input type="checkbox" name="editableGoods[]" checked style="display:none" value="${element.GoodSn}"/> </td>
                    <td class="td-part-input"> <input type="text" name="NameGood${element.GoodSn}" value="${element.NameGood}" class="td-input td-inputCodeNameEdit form-control" required> </td>
                    <td class="td-part-input"> <input type="text" name="FirstUnit${element.GoodSn}" value="${element.FirstUnit}" class="td-input td-inputFirstUnitEdit form-control" required> </td>
                    <td class="td-part-input"> <input type="text" name="SecondUnit${element.GoodSn}" value="${element.SecondUnit}" class="td-input td-inputSecondUnitEdit form-control" required> </td>
                    <td class="td-part-input"> <input type="text" name="PackAmnt${element.GoodSn}" value="${parseInt(packAmount).toLocaleString("en-us")}" class="td-input  td-inputSecondUnitAmountEdit form-control" required> </td>
                    <td class="td-part-input"> <input type="text" name="JozeAmountEdit${element.GoodSn}" value="${parseInt(element.Amount%element.AmountUnit).toLocaleString("en-us")}" class="td-input td-inputJozeAmountEdit form-control" required> </td>
                    <td class="td-part-input"> <input type="text" name="FirstAmount${element.GoodSn}" value="${parseInt(firstAmount).toLocaleString("en-us")}" class="td-input td-inputFirstAmountEdit form-control" required> </td>
                    <td class="td-part-input"> <input type="text" name="ReAmount${element.GoodSn}" value="${parseInt(reAmount).toLocaleString("en-us")}" class="td-input td-inputReAmountEdit form-control" required> </td>
                    <td class="td-part-input"> <input type="text" name="Amount${element.GoodSn}" value="${parseInt(element.Amount).toLocaleString("en-us")}" class="td-input  td-AllAmountEdit form-control" required> </td>
                    <td class="td-part-input"> <input type="text" name="Fi${element.GoodSn}" value="${parseInt(element.Fi).toLocaleString("en-us")}" class="td-input td-inputFirstUnitPriceEdit form-control" required> </td>
                    <td class="td-part-input"> <input type="text" name="FiPack${element.GoodSn}" value="${parseInt(element.FiPack).toLocaleString("en-us")}" class="td-input td-inputSecondUnitPriceEdit form-control" required> </td>
                    <td class="td-part-input"> <input type="text" sytle="width:100%!important;" size="" name="Price${element.GoodSn}" value="${parseInt(element.Price).toLocaleString("en-us")}" class="td-input td-inputAllPriceEdit form-control" required> </td>
                    <td class="td-part-input"> <input type="text" name="PriceAfterTakhfif${element.GoodSn}" value="${parseInt(element.PriceAfterTakhfif).toLocaleString("en-us")}" class="td-input td-inputAllPriceAfterTakhfifEdit  form-control" required> </td>
                    <td class="td-part-input"> <input type="text" name="" value="0" class="td-input td-inputSefarishNumEdit form-control" required> </td>
                    <td class="td-part-input"> <input type="text" name="" value="0" class="td-input td-inputSefarishDateEdit form-control" required> </td>
                    <td class="td-part-input"> <input type="text" name="" value="0" class="td-input td-inputSefarishDescEdit form-control" required> </td>
                    <td class="td-part-input"> <input type="text" name="NameStock${element.GoodSn}" value="0" class="td-input td-inputStockEdit form-control" required> </td>
                    <td class="td-part-input"> <input type="text" name="Price3PercentMaliat${element.GoodSn}" value="${element.Price3PercentMaliat}" class="td-input td-inputMaliatEdit form-control" required> </td>
                    <td class="td-part-input"> <input type="text" name="Fi2Weight${element.GoodSn}" value="${element.Fi2Weight}" class="td-input td-inputWeightUnitEdit form-control" required> </td>
                    <td class="td-part-input"> <input type="text" name="Amount2Weight${element.GoodSn}" value="${element.Amount2Weight}" class="td-input td-inputAllWeightEdit form-control" required> </td>
                    <td class="td-part-input"> <input type="text" name="Service${element.GoodSn}" value="0" class="td-input  td-inputInserviceEdit form-control" required> </td>
                    <td class="td-part-input"> <input type="text" name="PercentMaliat${element.GoodSn}" value="0" class="td-input  td-inputPercentMaliatEdit form-control" required> </td>
                </tr>
            `);
        })
    })
    $("#editFactorModal").modal("show");
}

$("#customerGardishBtn").on("click",function(e){
    $("#customerGardishModal").modal("show");
    $.get(baseUrl+"/getCustomerGardish",{psn:$("#customerForSefarishId").val()},function(respond,status){
        $("#customerGardishListBody").empty();

        respond.customerGardish.forEach((element,index)=>{
            let bestankar=0;
            let bedehkar=0;
            let remain=0;
            if(element.bestankar>0){
                bestankar=element.bestankar;
            }
            if(element.bedehkar>0){
                bedehkar=element.bedehkar;
            }
            if(element.remain!=0){
                remain=element.remain;
            }
            $("#customerGardishListBody").append(`<tr class="factorTablRow">
                                                    <td> ${element.DocDate} </td>
                                                    <td> ${element.FactDesc} </td>
                                                    <td> ${element.tasviyeh} </td>
                                                    <td> ${parseInt(bestankar).toLocaleString("en-us")} </td>
                                                    <td> ${parseInt(bedehkar).toLocaleString("en-us")} </td>
                                                    <td> ${element.bdbsState==0 ? 0 : "--"} </td>
                                                    <td> ${parseInt(remain).toLocaleString("en-us")} </td>
                                                </tr>`);
        });
    })
})
$("#closeCustomerGardishModalBtn").on("click",function(){
    $("#customerGardishModal").modal("hide");
})

$("#selectKalaToFactorBtn").on("click",function(){
    var rowCount = $("#factorEditListBody tr").length;
    let allMoney=0;
    for(let i=1;i<=rowCount;i++){
       let rowGoodSn= $('#factorEditListBody tr:nth-child('+i+')').find('input:checkbox').val();
       
       if(rowGoodSn==$(this).val()){
        swal({title:"قبلا اضافه شده است",
              text:"کالای انتخاب شده قبلا اضافه شده است",
              icon:"warning",
              buttons:ture});
        return
       }
    }
    
$.get(baseUrl+"/searchKalaByID",{goodSn:$(this).val()},function(data,status){
    if(status=="success"){
        let row=data.map((element,index)=> `
                                            <tr class="factorTablRow" onclick="checkAddedKalaAmountOfFactor(this)">
                                            <td class="td-part-input"> ${index+1}</td>
                                            <td class="td-part-input"> <input type="text" name="GoodCde${element.GoodSn}" value="${element.GoodCde}" class="td-input td-inputCodeEdit form-control" required> <input type="radio" value="`+element.AmountUnit+`" class="td-input form-control"> <input type="checkbox" name="editableGoods[]" checked style="display:none" value="${element.GoodSn}"/> </td>
                                            <td class="td-part-input"> <input type="text" name="NameGood${element.GoodSn}" value="${element.GoodName}" class="td-input td-inputCodeNameEdit form-control" required> </td>
                                            <td class="td-part-input"> <input type="text" name="FirstUnit${element.GoodSn}" value="${element.firstUnit}" class="td-input td-inputFirstUnitEdit form-control" required> </td>
                                            <td class="td-part-input"> <input type="text" name="SecondUnit${element.GoodSn}" value="${element.secondUnit}" class="td-input td-inputSecondUnitEdit form-control" required> </td>
                                            <td class="td-part-input"> <input type="text" name="PackAmnt${element.GoodSn}" value="" class="td-input  td-inputSecondUnitAmountEdit form-control" required> </td>
                                            <td class="td-part-input"> <input type="text" name="JozeAmountEdit${element.GoodSn}" value="" class="td-input td-inputJozeAmountEdit form-control" required> </td>
                                            <td class="td-part-input"> <input type="text" name="FirstAmount${element.GoodSn}" value="" class="td-input td-inputFirstAmountEdit form-control" required> </td>
                                            <td class="td-part-input"> <input type="text" name="ReAmount${element.GoodSn}" value="" class="td-input td-inputReAmountEdit form-control" required> </td>
                                            <td class="td-part-input"> <input type="text" name="Amount${element.GoodSn}" value="" class="td-input  td-AllAmountEdit form-control" required> </td>
                                            <td class="td-part-input"> <input type="text" name="Fi${element.GoodSn}" value="${parseInt(element.Price3).toLocaleString("en-us")}" class="td-input td-inputFirstUnitPriceEdit form-control" required> </td>
                                            <td class="td-part-input"> <input type="text" name="FiPack${element.GoodSn}" value="" class="td-input td-inputSecondUnitPriceEdit form-control" required> </td>
                                            <td class="td-part-input"> <input type="text" name="Price${element.GoodSn}" value="" class="td-input td-inputAllPriceEdit form-control" required> </td>
                                            <td class="td-part-input"> <input type="text" name="PriceAfterTakhfif${element.GoodSn}" value="" class="td-input td-inputAllPriceAfterTakhfifEdit  form-control" required> </td>
                                            <td class="td-part-input"> <input type="text" name="" value="0" class="td-input td-inputSefarishNumEdit form-control" required> </td>
                                            <td class="td-part-input"> <input type="text" name="" value="0" class="td-input td-inputSefarishDateEdit form-control" required> </td>
                                            <td class="td-part-input"> <input type="text" name="" value="0" class="td-input td-inputSefarishDescEdit form-control" required> </td>
                                            <td class="td-part-input"> <input type="text" name="NameStock${element.GoodSn}" value="0" class="td-input td-inputStockEdit form-control" required> </td>
                                            <td class="td-part-input"> <input type="text" name="Price3PercentMaliat${element.GoodSn}" value="0" class="td-input td-inputMaliatEdit form-control" required> </td>
                                            <td class="td-part-input"> <input type="text" name="Fi2Weight${element.GoodSn}" value="0" class="td-input td-inputWeightUnitEdit form-control" required> </td>
                                            <td class="td-part-input"> <input type="text" name="Amount2Weight${element.GoodSn}" value="0" class="td-input td-inputAllWeightEdit form-control" required> </td>
                                            <td class="td-part-input"> <input type="text" name="Service${element.GoodSn}" value="0" class="td-input  td-inputInserviceEdit form-control" required> </td>
                                            <td class="td-part-input"> <input type="text" name="PercentMaliat${element.GoodSn}" value="0" class="td-input  td-inputPercentMaliatEdit form-control" required> </td>
                                        </tr>
                                        `)
        $(`#factorEditListBody tr:nth-child(`+$("#rowTaker").val()+`)`).replaceWith(row);
        $(`#factorEditListBody tr:nth-child(`+$("#rowTaker").val()+`) td:nth-child(6) input`).focus();
        $(`#factorEditListBody tr:nth-child(`+$("#rowTaker").val()+`) td:nth-child(6) input`).select();
        checkAddedKalaAmountOfFactor(data[0].GoodSn);
        }
    });

    $("#searchGoodsModalEdit").modal("hide");
});


$(document).on("keyup",".td-inputCodeEdit",function(e){
    if((e.keyCode>=65 && e.keyCode<=90) || ((e.keyCode>=48 && e.keyCode<=57) || (e.keyCode>=96 && e.keyCode<=105))){
        checkNumberInput(e);
        $("#rowTaker").val($(e.target).parents("tr").index()+1)
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
        $("#searchKalaForAddToSefarishByName").val();
        $("#searchForAddItemLabel").text("نام کالا")
        $("#searchKalaForAddToSefarishByName").val("");
        $("#searchKalaForAddToSefarishByName").val($(e.target).val());
        $("#searchKalaForAddToSefarishByCode").hide();
        $("#searchKalaForAddToSefarishByName").show();
        $("#searchGoodsModalEdit").modal("show");
        $('#searchGoodsModalEdit').on('shown.bs.modal', function() {
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
$(document).on("keyup",".td-inputCodeNameEdit",function(e){
    if((e.keyCode>=65 && e.keyCode<=90) || ((e.keyCode>=48 && e.keyCode<=57) || (e.keyCode>=96 && e.keyCode<=105))){
        
        $("#rowTaker").val($(e.target).parents("tr").index()+1)
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
        $("#searchKalaForAddToSefarishByName").val();
        $("#searchForAddItemLabel").text("نام کالا")
        $("#searchKalaForAddToSefarishByName").val("");
        $("#searchKalaForAddToSefarishByName").val($(e.target).val());
        $("#searchKalaForAddToSefarishByCode").hide();
        $("#searchKalaForAddToSefarishByName").show();
        $("#searchGoodsModalEdit").modal("show");
        $('#searchGoodsModalEdit').on('shown.bs.modal', function() {
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
$(document).on("keyup",".td-inputFirstUnitEdit",function(e){
    if(e.keyCode ==13 || e.keyCode ==9){
        var currentInput = $(e.target);
        var nextInput = currentInput.closest('td').next('td').find('input');
        if (nextInput.length > 0) {
            nextInput.focus();
        }
    }
})
$(document).on("keyup",".td-inputSecondUnitEdit",function(e){
    if(e.keyCode ==13 || e.keyCode ==9){
        var $currentInput = $(e.target);
        var $nextInput = $currentInput.closest('td').next('td').find('input');
        if ($nextInput.length > 0) {
            $nextInput.focus();
        }
    }
})
$(document).on("keyup",".td-inputSecondUnitAmountEdit",function(e){

    // نوعیت اعداد چک شود و محاسبات انجام شود
    checkNumberInput(e)
    
    let subPackUnitAmount=0;
    if(($('#factorEditListBody tr:nth-child('+$('#factorEditListBody tr').length+') td:nth-child(2)').children('input').val().length)<1){
        $(`#factorEditListBody tr:nth-child(`+$('#factorEditListBody tr').length+`)`).replaceWith('');
    }
    let rowindex=$(e.target).parents("tr").index()+1
    let packAmount=$(e.target).val().replace(/,/g, '')
    let subPackUnits=parseInt($('#factorEditListBody tr:nth-child('+rowindex+') td:nth-child(7)').children('input').val().replace(/,/g, ''));
    let GoodSn=parseInt($('#factorEditListBody tr:nth-child('+rowindex+') td:nth-child(2)').find('input:checkbox').val());
    let amountUnit=$($('#factorEditListBody tr:nth-child('+rowindex+') td:nth-child(2)').find('input:radio')).val().replace(/,/g, '');
    let price=$($('#factorEditListBody tr:nth-child('+rowindex+') td:nth-child(11)').children('input')).val().replace(/,/g, '');
    if(!isNaN(subPackUnits)){
        subPackUnitAmount=subPackUnits;
    }
    
    let allAmountUnit=(packAmount*amountUnit)+subPackUnitAmount;
    if( allAmountUnit > parseInt($("#firstEditExistInStock").text().replace(/,/g,'')) ){
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
                    $('#factorEditListBody tr:nth-child('+rowindex+') td:nth-child(8)').children('input').val(parseInt(allAmountUnit).toLocaleString("en-us"));
                    $('#factorEditListBody tr:nth-child('+rowindex+') td:nth-child(11)').children('input').val(parseInt(allPrice).toLocaleString("en-us"));
                    $('#factorEditListBody tr:nth-child('+rowindex+') td:nth-child(10)').children('input').val(parseInt(packPrice).toLocaleString("en-us"));
                    $('#factorEditListBody tr:nth-child('+rowindex+') td:nth-child(14) input[type="checkbox"]').val(GoodSn+'_'+packAmount+'_'+allAmountUnit+'_'+allPrice+'_'+packPrice+'_'+price);
                }
            })
    }else{
        let allPrice=allAmountUnit*price;
        let packPrice=amountUnit*price;
        $('#factorEditListBody tr:nth-child('+rowindex+') td:nth-child(10)').children('input').val(parseInt(allAmountUnit).toLocaleString("en-us"));
        $('#factorEditListBody tr:nth-child('+rowindex+') td:nth-child(13)').children('input').val(parseInt(allPrice).toLocaleString("en-us"));
        $('#factorEditListBody tr:nth-child('+rowindex+') td:nth-child(14)').children('input').val(parseInt(allPrice).toLocaleString("en-us"));
        $('#factorEditListBody tr:nth-child('+rowindex+') td:nth-child(12)').children('input').val(parseInt(packPrice).toLocaleString("en-us"));
        $('#factorEditListBody tr:nth-child('+rowindex+') td:nth-child(7)').children('input').val(0);
        $('#factorEditListBody tr:nth-child('+rowindex+') td:nth-child(8)').children('input').val(0);
        $('#factorEditListBody tr:nth-child('+rowindex+') td:nth-child(9)').children('input').val(0);
        //$('#factorEditListBody tr:nth-child('+rowindex+') td:nth-child(14) input[type="checkbox"]').val(GoodSn+'_'+packAmount+'_'+allAmountUnit+'_'+allPrice+'_'+packPrice+'_'+price);
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

    if(e.keyCode ==13 || e.keyCode ==9){
        var $currentInput = $(e.target);
        var $nextInput = $currentInput.closest('td').next('td').find('input');
        if ($nextInput.length > 0) {
            $nextInput.focus();
        }
    }
})
$(document).on("keyup",".td-inputJozeAmountEdit",function(e){
    checkNumberInput(e);
    if(($('#factorEditListBody tr:nth-child('+$('#factorEditListBody tr').length+') td:nth-child(2)').children('input').val().replace(/,/g, '').length)<1){
        $(`#factorEditListBody tr:nth-child(`+$('#factorEditListBody tr').length+`)`).replaceWith('');
    }
    let rowindex=$(e.target).parents("tr").index()+1
    let packAmount=parseInt($('#factorEditListBody tr:nth-child('+rowindex+') td:nth-child(6)').children('input').val().replace(/,/g, ''));
    let subPackUnits=parseInt($(e.target).val().replace(/,/g, ''))
    let amountUnit=$($('#factorEditListBody tr:nth-child('+rowindex+') td:nth-child(2)').find('input:radio')).val().replace(/,/g, '');
    let price=$($('#factorEditListBody tr:nth-child('+rowindex+') td:nth-child(11)').children('input')).val().replace(/,/g, '');

    let allAmountUnit=0;
    if(packAmount>0){
        allAmountUnit=(packAmount*amountUnit)+subPackUnits;
    }else{
        allAmountUnit=subPackUnits;
    }
    packAmount=parseInt(allAmountUnit/amountUnit);
    subPackUnits=allAmountUnit%amountUnit;
    let allPrice=allAmountUnit*price;
    $('#factorEditListBody tr:nth-child('+rowindex+') td:nth-child(10)').children('input').val(parseInt(allAmountUnit).toLocaleString("en-us"));
    $('#factorEditListBody tr:nth-child('+rowindex+') td:nth-child(13)').children('input').val(parseInt(allPrice).toLocaleString("en-us"));
    $('#factorEditListBody tr:nth-child('+rowindex+') td:nth-child(6)').children('input').val(packAmount)
    $(e.target).val(subPackUnits)
    if(e.keyCode ==13 || e.keyCode ==9){
        var $currentInput = $(e.target);
        var $nextInput = $currentInput.closest('td').next('td').find('input');
        if ($nextInput.length > 0) {
            $nextInput.focus();
        }
    }
})
$(document).on("keyup",".td-inputFirstAmountEdit",function(e){
    if(e.keyCode ==13 || e.keyCode ==9){
        var $currentInput = $(e.target);
        var $nextInput = $currentInput.closest('td').next('td').find('input');
        if ($nextInput.length > 0) {
            $nextInput.focus();
        }
    }
})
$(document).on("keyup",".td-inputReAmountEdit",function(e){
    if((e.keyCode>=65 && e.keyCode<=90)|| ((e.keyCode>=48 && e.keyCode<=57) || (e.keyCode>=96 && e.keyCode<=105))){
        checkNumberInput(e);
        let rowindex=$(e.target).parents("tr").index()+1
        let firstAmount;
        let reAmount;
        let allPrice=0;
        let allAmountSabit=0;
        let newAllAmount;
        let jozeAmount;
        let packAmount;

        let price=$($('#factorEditListBody tr:nth-child('+rowindex+') td:nth-child(11)').children('input')).val().replace(/,/g, '');
        let amountUnit=$($('#factorEditListBody tr:nth-child('+rowindex+') td:nth-child(2)').find('input:radio')).val().replace(/,/g, '');
        allAmountSabit=$($('#factorEditListBody tr:nth-child('+rowindex+') td:nth-child(1)').find('input:radio')).val().replace(/,/g, '');
        reAmount=parseInt($(e.target).val().replace(/,/g, ''));
        firstAmount=$($('#factorEditListBody tr:nth-child('+rowindex+') td:nth-child(8)').children('input')).val().replace(/,/g, '');
        allAmount=$($('#factorEditListBody tr:nth-child('+rowindex+') td:nth-child(10)').children('input')).val().replace(/,/g, '');
        
        
        jozeAmount=$($('#factorEditListBody tr:nth-child('+rowindex+') td:nth-child(7)').children('input')).val().replace(/,/g, '');
        packAmount=$($('#factorEditListBody tr:nth-child('+rowindex+') td:nth-child(6)').children('input')).val().replace(/,/g, '');
        newAllAmount=allAmountSabit-reAmount;
        firstAmount=allAmountSabit;
        packAmount=parseInt(newAllAmount/amountUnit);
        jozeAmount=parseInt(newAllAmount%amountUnit);

        allPrice=newAllAmount*price;



        $($('#factorEditListBody tr:nth-child('+rowindex+') td:nth-child(8)').children('input')).val(parseInt(firstAmount).toLocaleString("en-us"));
        $($('#factorEditListBody tr:nth-child('+rowindex+') td:nth-child(10)').children('input')).val(parseInt(newAllAmount).toLocaleString("en-us"));
        $($('#factorEditListBody tr:nth-child('+rowindex+') td:nth-child(7)').children('input')).val(parseInt(jozeAmount).toLocaleString("en-us"));
        $('#factorEditListBody tr:nth-child('+rowindex+') td:nth-child(13)').children('input').val(parseInt(allPrice).toLocaleString("en-us"));
        $($('#factorEditListBody tr:nth-child('+rowindex+') td:nth-child(6)').children('input')).val(parseInt(packAmount).toLocaleString("en-us"));
    }
    if(e.keyCode ==13 || e.keyCode ==9){
        var $currentInput = $(e.target);
        var $nextInput = $currentInput.closest('td').next('td').find('input');
        if ($nextInput.length > 0) {
            $nextInput.focus();
        }
    }
    

})
$(document).on("keyup",".td-AllAmountEdit",function(e){
    
    if((e.keyCode>=65 && e.keyCode<=90)|| ((e.keyCode>=48 && e.keyCode<=57) || (e.keyCode>=96 && e.keyCode<=105))){
        checkNumberInput(e);
        let rowindex=$(e.target).parents("tr").index()+1
        let subPackUnits=parseInt($('#factorEditListBody tr:nth-child('+rowindex+') td:nth-child(7)').children('input').val().replace(/,/g, ''));
        let amountUnit=$($('#factorEditListBody tr:nth-child('+rowindex+') td:nth-child(2)').find('input:radio')).val().replace(/,/g, '');
        let price=$($('#factorEditListBody tr:nth-child('+rowindex+') td:nth-child(11)').children('input')).val().replace(/,/g, '');

        let allAmountUnit=parseInt($(e.target).val().replace(/,/g, ''));
        let packAmount=parseInt(allAmountUnit/amountUnit);
        subPackUnits=parseInt(allAmountUnit%amountUnit);
        let allPrice=allAmountUnit*price;
        let packPrice=amountUnit*price;
        $('#factorEditListBody tr:nth-child('+rowindex+') td:nth-child(10)').children('input').val(parseInt(allAmountUnit).toLocaleString("en-us"));
        $('#factorEditListBody tr:nth-child('+rowindex+') td:nth-child(13)').children('input').val(parseInt(allPrice).toLocaleString("en-us"));
        $('#factorEditListBody tr:nth-child('+rowindex+') td:nth-child(14)').children('input').val(parseInt(allPrice).toLocaleString("en-us"));
        $('#factorEditListBody tr:nth-child('+rowindex+') td:nth-child(12)').children('input').val(parseInt(packPrice).toLocaleString("en-us"));
        $('#factorEditListBody tr:nth-child('+rowindex+') td:nth-child(6)').children('input').val(parseInt(packAmount).toLocaleString("en-us"));
        $('#factorEditListBody tr:nth-child('+rowindex+') td:nth-child(7)').children('input').val(parseInt(subPackUnits).toLocaleString("en-us"));
    }
    if(e.keyCode==9 || e.keyCode==13){
        var $currentInput = $(e.target);
        var $nextInput = $currentInput.closest('td').next('td').find('input');
        if ($nextInput.length > 0) {
        $nextInput.focus();
        }
    }
})
$(document).on("keyup",".td-inputFirstUnitPriceEdit",function(e){
    if(e.keyCode==9 || e.keyCode==13){
        var $currentInput = $(e.target);
        var $nextInput = $currentInput.closest('td').next('td').find('input');
        localStorage.setItem("allowedChangePrice",0)
        if ($nextInput.length > 0) {
        $nextInput.focus();
        }
    }
})
$(document).on("keyup",".td-inputSecondUnitPriceEdit",function(e){
    if(e.keyCode ==13 || e.keyCode ==9){
        var $currentInput = $(e.target);
        var $nextInput = $currentInput.closest('td').next('td').find('input');
        if ($nextInput.length > 0) {
            $nextInput.focus();
        }
    }
})
$(document).on("keyup",".td-inputAllPriceEdit",function(e){
    checkNumberInput(e);
    let subPackUnitAmount=0;
    if(($('#factorEditListBody tr:nth-child('+$('#factorEditListBody tr').length+') td:nth-child(2)').children('input').val().length)<1){
        $(`#factorEditListBody tr:nth-child(`+$('#factorEditListBody tr').length+`)`).replaceWith('');
    }
    let rowindex=$(e.target).parents("tr").index()+1
    let packAmount=parseInt($('#factorEditListBody tr:nth-child('+rowindex+') td:nth-child(6)').children('input').val());
    if(!$(e.target).val()){
        $(e.target).val(0)
    }
    let allPrice=parseInt($(e.target).val().replace(/,/g, ''))
    let subPackUnits=parseInt($('#factorEditListBody tr:nth-child('+rowindex+') td:nth-child(7)').children('input').val());
    let amountUnit=$($('#factorEditListBody tr:nth-child('+rowindex+') td:nth-child(2)').find('input:radio')).val().replace(/,/g, '');
    let price=$($('#factorEditListBody tr:nth-child('+rowindex+') td:nth-child(11)').children('input')).val().replace(/,/g, '');
    if(!isNaN(subPackUnits)){
        subPackUnitAmount=subPackUnits;
    }
    let allAmountUnit=allPrice/price;
    packAmount=parseInt(allAmountUnit/amountUnit)
    subPackUnitAmount=allAmountUnit%amountUnit;
    let packPrice=amountUnit*price;
    $('#factorEditListBody tr:nth-child('+rowindex+') td:nth-child(7)').children('input').val(parseInt(subPackUnitAmount).toLocaleString("en-us"))
    $('#factorEditListBody tr:nth-child('+rowindex+') td:nth-child(6)').children('input').val(parseInt(packAmount).toLocaleString("en-us"))
    $('#factorEditListBody tr:nth-child('+rowindex+') td:nth-child(10)').children('input').val(parseInt(allAmountUnit).toLocaleString("en-us"));
    $('#factorEditListBody tr:nth-child('+rowindex+') td:nth-child(13)').children('input').val(parseInt(allPrice).toLocaleString("en-us"));
    $('#factorEditListBody tr:nth-child('+rowindex+') td:nth-child(14)').children('input').val(parseInt(allPrice).toLocaleString("en-us"));
    $('#factorEditListBody tr:nth-child('+rowindex+') td:nth-child(12)').children('input').val(parseInt(packPrice).toLocaleString("en-us"));
    
    if(e.keyCode ==13 || e.keyCode ==9){
        var $currentInput = $(e.target);
        var $nextInput = $currentInput.closest('td').next('td').find('input');
        if ($nextInput.length > 0) {
            $nextInput.focus();
        }
    }
})

$(document).on("keyup",".td-inputAllPriceAfterTakhfifEdit",function(e){
    if(e.keyCode ==13 || e.keyCode ==9){
        var $currentInput = $(e.target);
        var $nextInput = $currentInput.closest('td').next('td').find('input');
        if ($nextInput.length > 0) {
            $nextInput.focus();
        }
    }
})
$(document).on("keyup",".td-inputSefarishNumEdit",function(e){
    if(e.keyCode ==13 || e.keyCode ==9){
        var $currentInput = $(e.target);
        var $nextInput = $currentInput.closest('td').next('td').find('input');
        if ($nextInput.length > 0) {
            $nextInput.focus();
        }
    }
})
$(document).on("keyup",".td-inputSefarishDateEdit",function(e){
    if(e.keyCode ==13 || e.keyCode ==9){
        var $currentInput = $(e.target);
        var $nextInput = $currentInput.closest('td').next('td').find('input');
        if ($nextInput.length > 0) {
            $nextInput.focus();
        }
    }
})
$(document).on("keyup",".td-inputSefarishDescEdit",function(e){
    if(e.keyCode ==13 || e.keyCode ==9){
        var $currentInput = $(e.target);
        var $nextInput = $currentInput.closest('td').next('td').find('input');
        if ($nextInput.length > 0) {
            $nextInput.focus();
        }
    }
})
$(document).on("keyup",".td-inputStockEdit",function(e){
    if(e.keyCode ==13 || e.keyCode ==9){
        var $currentInput = $(e.target);
        var $nextInput = $currentInput.closest('td').next('td').find('input');
        if ($nextInput.length > 0) {
            $nextInput.focus();
        }
    }
})
$(document).on("keyup",".td-inputMaliatEdit",function(e){
    if(e.keyCode ==13 || e.keyCode ==9){
        var $currentInput = $(e.target);
        var $nextInput = $currentInput.closest('td').next('td').find('input');
        if ($nextInput.length > 0) {
            $nextInput.focus();
        }
    }
})
$(document).on("keyup",".td-inputWeightUnitEdit",function(e){
    if(e.keyCode ==13 || e.keyCode ==9){
        var $currentInput = $(e.target);
        var $nextInput = $currentInput.closest('td').next('td').find('input');
        if ($nextInput.length > 0) {
            $nextInput.focus();
        }
    }
})
$(document).on("keyup",".td-inputAllWeightEdit",function(e){
    if(e.keyCode ==13 || e.keyCode ==9){
        var $currentInput = $(e.target);
        var $nextInput = $currentInput.closest('td').next('td').find('input');
        if ($nextInput.length > 0) {
            $nextInput.focus();
        }
    }
})
$(document).on("keyup",".td-inputInserviceEdit",function(e){
    if(e.keyCode ==13 || e.keyCode ==9){
        var $currentInput = $(e.target);
        var $nextInput = $currentInput.closest('td').next('td').find('input');
        if ($nextInput.length > 0) {
            $nextInput.focus();
        }
    }
})
$(document).on("keyup",".td-inputPercentMaliatEdit",function(e){
    let goodSn=$('#factorEditListBody tr:nth-child('+($(e.target).parents("tr").index()+1)+') td:nth-child(2)').children('input').val().length
    if((e.keyCode === 9 ||e.keyCode === 13)  && (($(e.target).parents("tr").index()+1)==$("#factorEditListBody tr").length) && goodSn>0){
        checkNumberInput(e);
        let row=`<tr class="factorTablRow" onclick="checkAddedKalaAmountOfFactor(this)">
        <td class="td-part-input"> </td>
        <td class="td-part-input"> <input type="text" value="" class="td-input td-inputCodeEdit form-control" required> <input type="radio" style="display:none" value=""/> </td>
        <td class="td-part-input"> <input type="text" value="" class="td-input td-inputCodeNameEdit form-control" required> </td>
        <td class="td-part-input"> <input type="text" value="" class="td-input td-inputFirstUnitEdit form-control" required> </td>
        <td class="td-part-input"> <input type="text" value="" class="td-input td-inputSecondUnitEdit form-control" required> </td>
        <td class="td-part-input"> <input type="text" value="" class="td-input  td-inputSecondUnitAmountEdit form-control" required> </td>
        <td class="td-part-input"> <input type="text" value="" class="td-input td-inputJozeAmountEdit form-control" required> </td>
        <td class="td-part-input"> <input type="text" value="" class="td-input td-inputFirstAmountEdit form-control" required> </td>
        <td class="td-part-input"> <input type="text" value="" class="td-input td-inputReAmountEdit form-control" required> </td>
        <td class="td-part-input"> <input type="text" value="" class="td-input  td-AllAmountEdit form-control" required> </td>
        <td class="td-part-input"> <input type="text" value="" class="td-input td-inputFirstUnitPriceEdit form-control" required> </td>
        <td class="td-part-input"> <input type="text" value="" class="td-input td-inputSecondUnitPriceEdit form-control" required> </td>
        <td class="td-part-input"> <input type="text" value="" class="td-input td-inputAllPriceEdit form-control" required> </td>
        <td class="td-part-input"> <input type="text" value="" class="td-input td-inputAllPriceAfterTakhfifEdit  form-control" required> </td>
        <td class="td-part-input"> <input type="text" value="" class="td-input td-inputSefarishNumEdit form-control" required> </td>
        <td class="td-part-input"> <input type="text" value="" class="td-input td-inputSefarishDateEdit form-control" required> </td>
        <td class="td-part-input"> <input type="text" value="" class="td-input td-inputSefarishDescEdit form-control" required> </td>
        <td class="td-part-input"> <input type="text" value="" class="td-input td-inputStockEdit form-control" required> </td>
        <td class="td-part-input"> <input type="text" value="" class="td-input td-inputMaliatEdit form-control" required> </td>
        <td class="td-part-input"> <input type="text" value="" class="td-input td-inputWeightUnitEdit form-control" required> </td>
        <td class="td-part-input"> <input type="text" value="" class="td-input td-inputAllWeightEdit form-control" required> </td>
        <td class="td-part-input"> <input type="text" value="" class="td-input  td-inputInserviceEdit form-control" required> </td>
        <td class="td-part-input"> <input type="text" value="" class="td-input  td-inputPercentMaliatEdit form-control" required> </td>
    </tr>`;
$("#factorEditListBody").append(row);

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
})

function checkAddedKalaAmountOfFactor(row){
    let input = $(row).find('input:checkbox');
    let goodSn=$(input).val();
    if(!goodSn){
        return
    }
    let customerSn=$("#customerForSefarishId").val();

    $.get(baseUrl+"/getGoodInfoForAddOrderItem",{
        goodSn: goodSn,
        customerSn:customerSn,
        stockId: 23
    },(respond,status)=>{
        
        if(respond[1][0]){

            $("#firstEditExistInStock").text(parseInt(respond[1][0].Amount).toLocaleString("en-us"));

        }

        if(respond[2][0]){

            $("#firstEditPrice").text(parseInt(respond[2][0].Price3).toLocaleString("en-us"));

        }
        if(respond[4][0]){

            $("#firstEditLastPriceCustomer").text(parseInt(respond[4][0].Fi).toLocaleString("en-us"));
            
        }

        if(respond[3][0]){

            $("#firstEditLastPrice").text(parseInt(respond[3][0].Fi).toLocaleString("en-us"));

        }
        

    });
    const previouslySelectedRow = document.querySelector('.selected');
    if(previouslySelectedRow) {
        previouslySelectedRow.classList.remove('selected');
        //previouslySelectedRow.children().classList.remove('selected');
    }
    row.classList.add('selected');
}

$("#FactDateEdit").persianDatepicker({
    cellWidth: 32,
    cellHeight: 22,
    fontSize: 14,
    formatDate: "YYYY/0M/0D",
    endDate: "1440/05/05",
});

$("#NameEdit").on("keyup",function(e){
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

function chooseCustomerForّFactorEdit(psn){

    $.get("/getInfoOfOrderCustomer",{psn:psn},(respond,status)=>{
        if(localStorage.getItem("editCustomerName")!=1){
            $("#customerForFactorEdit").append(`<option selected value="${respond[0].PSN}"> ${respond[0].Name} </option>`);
            $("#customerForFactorEdit").trigger("change");
            $("#NameEdit").val(respond[0].Name);
            $("#pCodeEdit").val(respond[0].PCode);
           // $("#lastCustomerStatus").text(parseInt(respond[0].TotalPrice)||0);
        }else{
            $("#customerForFactorEdit").append(`<option selected value="${respond[0].PSN}"> ${respond[0].Name} </option>`);
            $("#customerForFactorEdit").trigger("change");
            $("#NameEdit").val(respond[0].Name);
            $("#pCodeEdit").val(respond[0].PCode);
            localStorage.setItem("editCustomerName",0);
        }
    });
    $("#customerForSefarishModal").modal("hide");
}

$("#bazaryabNameEdit").on("keyup",function(e){
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
        $("#customerForBazaryabFactEdit").modal("show");
        $("#customerNameForBazaryabFactEdit").val($('#searchCustomerNameInput').val());
        $("#customerNameForBazaryabFactEdit").focus();
        $('#customerForBazaryabFactEdit').on('shown.bs.modal', function() {
            $(this).find('[autofocus]').focus();
        });
    }
})

$("#customerNameForBazaryabFactEdit").on("keyup",function(e){
    let name=$("#customerNameForBazaryabFactEdit").val();
    if(event.keyCode!=40){
        if(event.keyCode!=13){
    let searchByPhone="";
    if($("#seachByPhoneNumberCheckBoxBazaryab").is(":checked")){
        searchByPhone="on";
    }else{
        searchByPhone="";
    }
    $.get("/getCustomerForOrder",{namePhone:name,searchByPhone:searchByPhone},(data,status)=>{
        localStorage.setItem("scrollTop",0);
        $("#foundCusotmerForOrderBodyBazarya").empty();
        let tableBody=$("#foundCusotmerForOrderBodyBazarya");
        let i=0;
        for (let customer of data){
            i++;
            if(i!=1){
                tableBody.append(`<tr onclick="selectCustomerForBazaryabFactEdit(${customer.PSN},this)">
                                                        <td> ${(i)} </td>
                                                        <td> ${customer.PCode} </td>
                                                        <td> ${customer.Name} </td>
                                                        <td> ${customer.countBuy} </td>
                                                        <td> ${customer.countSale} </td>
                                                        <td> ${customer.chequeCountReturn} </td>
                                                        <td> ${customer.chequeMoneyReturn} </td>
                                                    </tr>`);
            }else{
                tableBody.append(`<tr onclick="selectCustomerForBazaryabFactEdit(${customer.PSN},this)">
                    <td> ${(i)} </td>
                    <td> ${customer.PCode} </td>
                    <td> ${customer.Name} </td>
                    <td> ${customer.countBuy} </td>
                    <td> ${customer.countSale} </td>
                    <td> ${customer.chequeCountReturn} </td>
                    <td> ${customer.chequeMoneyReturn} </td>
                </tr>`);
                $("#foundCusotmerForOrderBodyBazarya tr").eq(0).css("background-color", "rgb(0,142,201)"); 
                const selectedPSN = data[0].PSN;
                selectCustomerForBazaryabFactEdit(selectedPSN,0)
            }
        }
        let selectedRow = 0;
        Mousetrap.bind('down', function (e) {
            if (selectedRow >= 0) {
                $("#foundCusotmerForOrderBodyBazarya tr").eq(selectedRow).css('background-color', '');
            }
            if(selectedRow!=0){
                selectedRow = Math.min(selectedRow + 1, data.length - 1); 
                $("#foundCusotmerForOrderBodyBazarya tr").eq(selectedRow).css('background-color', "rgb(0,142,201)"); 
            }else{
                selectedRow = Math.min(1, data.length - 1); 
                $("#foundCusotmerForOrderBodyBazarya tr").eq(selectedRow).css('background-color', "rgb(0,142,201)"); 
            }

            const selectedPSN = data[selectedRow].PSN;
            selectCustomerForBazaryabFactEdit(selectedPSN,selectedRow)
            let topTr = $("#foundCusotmerForOrderBodyBazarya tr").eq(selectedRow).position().top;
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
                $("#foundCusotmerForOrderBodyBazarya tr").eq(selectedRow).css('background-color','');
            }

            selectedRow = Math.max(selectedRow - 1, 0); 
            $("#foundCusotmerForOrderBodyBazarya tr").eq(selectedRow).css('background-color', 'rgb(0,142,201)'); 
            const selectedPSN = data[selectedRow].PSN;
            selectCustomerForBazaryabFactEdit(selectedPSN,selectedRow)
            let topTr = $("#foundCusotmerForOrderBodyBazarya tr").eq(selectedRow).position().top;
            let bottomTr =topTr+parseInt($("#foundCusotmerForOrderBodyBazarya tr").eq(selectedRow).height());
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
            $("#searchCustomerForBazaryabFactEditSabtBtn").trigger("click");
            localStorage.setItem("scrollTop",0);
        });
    })  
    }else{
        $("#searchCustomerForBazaryabFactEditSabtBtn").trigger("click");
        localStorage.setItem("scrollTop",0);
    }
}else{
    $(this).blur();
    $("#searchCustomerForBazaryabFactEditSabtBtn").focus();
    localStorage.setItem("scrollTop",0);
} 
});

function chooseBazaryabForFactEdit(psn){
    alert(psn)
    $.get("/getInfoOfOrderCustomer",{psn:psn},(respond,status)=>{
        
            $("#bazaryabNameEdit").val(respond[0].Name);
            $("#bazaryabCodeEdit").val(respond[0].PCode);
           // $("#lastCustomerStatus").text(parseInt(respond[0].TotalPrice)||0);
        
    });
    $("#customerForBazaryabFactEdit").modal("hide");
}

function cancelEditFactor(){
    swal({
        text: "می خواهید بدون ذخیره خارج شوید؟",
        icon: "warning",
        buttons: true,
        dangerMode: true,
        }).then((willAdd) =>{
            if(willAdd){
                $("#editFactorModal").modal("hide");
            }
        });
    
}

function selectCustomerForBazaryabFactEdit(psn,element){
    if(isNaN(element)){
        $("tr").removeClass('selected');
        $("#foundCusotmerForOrderBodyBazarya tr").css('background-color', '');
        $(element).addClass("selected")
    }else{
        $("tr").removeClass('selected');
    }
    $("#searchCustomerForBazaryabFactEditSabtBtn").prop("disabled",false);
    $("#searchCustomerForBazaryabFactEditSabtBtn").val(psn);
}

$("#TahvilTypeEdit").on("change",function(e){
    if($("#TahvilTypeEdit").val() == "ersal"){
        $("#sendTimeDivEdit").css({"display":"inline"});
        $("#factorAddressDivEdit").css({"display":"inline"});
    }else{
        $("#sendTimeDivEdit").css("display","none");
        $("#factorAddressDivEdit").css("display","none");
    }
});

$("#customerForFactorEdit").on("change",()=>{
    let psn=$("#customerForFactorEdit").val();
    $.get(baseUrl+"/getCustomerByID",{PSN:psn},function(data,status){
        $("#factorAddressEdit").empty();
        let addressOptions=data.map(element=>{
            if(element.AddressPeopel){
                return `<option value="`+element.AddressPeopel+`_`+element.SnPeopelAddress+`">`+element.AddressPeopel+`</option>`
                }else{
                    return `<option value="`+element.peopeladdress+`_0">`+element.peopeladdress+`</option>`   
                }
        })
        $("#factorAddressEdit").append(addressOptions);
    });

})

$("#MotafariqahNameEdit").on("keyup",function(e){
    if($("#MotafariqahNameEdit").val().length>0){
        $("#mobileNumberDivEdit").css({"display":"inline"});
        $("#factorAddressDivEdit").css({"display":"inline"});
    }else{
        $("#mobileNumberDivEdit").css({"display":"none"});
        $("#factorAddressDivEdit").css({"display":"none"});
    }
})