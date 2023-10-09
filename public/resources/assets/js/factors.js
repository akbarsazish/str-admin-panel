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

function openEditFactorModal(snFactor){
    $.get(baseUrl+"/getFactorInfoForEdit",{SnFactor:snFactor},(respond,status)=>{
        $("#factorEditListBody").empty();
        $("#customerOfFactorEdit").val(respond.factorInfo[0].PSN);
        $("#FactNoEdit").val(respond.factorInfo[0].FactNo);
        $("#NameEdit").val(respond.factorInfo[0].Name);
        $("#FactDateEdit").val(respond.factorInfo[0].FactDate);
        $("#bazaryabNameEdit").val(respond.factorInfo[0].BName);
        $("#bazaryabCodeEdit").val(respond.factorInfo[0].BPCode);
        $("#pCodeEdit").val(respond.factorInfo[0].PCode);
        $("#ّFactDescEdit").val(respond.factorInfo[0].FactDesc);
        $("#MotafariqahNameEdit").val(respond.factorInfo[0].OtherCustName);
        $("#MotafariqahMobileEdit").val(respond.factorInfo[0].MobileOtherCust);
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
            if(element.FirstAmout>0){
                firstAmount=element.FirstAmout;
            }
            if(element.ReAmount>0){
                reAmount=element.ReAmount;
            }
            $("#factorEditListBody").append(`
                <tr class="factorTablRow" onclick="checkAddedKalaAmountOfFactor(this)">
                    <td class="td-part-input"> ${index+1}</td>
                    <td class="td-part-input"> <input type="text" value="${element.GoodCde}" class="td-input form-control" required> <input type="radio" value="${element.GoodSn}"/> </td>
                    <td class="td-part-input"> <input type="text" value="${element.NameGood}" class="td-input form-control" required> </td>
                    <td class="td-part-input"> <input type="text" value="${element.FirstUnit}" class="td-input form-control" required> </td>
                    <td class="td-part-input"> <input type="text" value="${element.SecondUnit}" class="td-input form-control" required> </td>
                    <td class="td-part-input"> <input type="text" value="${parseInt(element.PackAmnt).toLocaleString("en-us")}" class="td-input form-control" required> </td>
                    <td class="td-part-input"> <input type="text" value="${parseInt(element.Amount%element.AmountUnit).toLocaleString("en-us")}" class="td-input form-control" required> </td>
                    <td class="td-part-input"> <input type="text" value="${parseInt(firstAmount).toLocaleString("en-us")}" class="td-input form-control" required> </td>
                    <td class="td-part-input"> <input type="text" value="${parseInt(reAmount).toLocaleString("en-us")}" class="td-input form-control" required> </td>
                    <td class="td-part-input"> <input type="text" value="${parseInt(element.Amount).toLocaleString("en-us")}" class="td-input form-control" required> </td>
                    <td class="td-part-input"> <input type="text" value="${parseInt(element.Fi).toLocaleString("en-us")}" class="td-input form-control" required> </td>
                    <td class="td-part-input"> <input type="text" value="${parseInt(element.FiPack).toLocaleString("en-us")}" class="td-input form-control" required> </td>
                    <td class="td-part-input"> <input type="text" value="${parseInt(element.Price).toLocaleString("en-us")}" class="td-input form-control" required> </td>
                    <td class="td-part-input"> <input type="text" value="${parseInt(element.PriceAfterTakhfif).toLocaleString("en-us")}" class="td-input form-control" required> </td>
                    <td class="td-part-input"> <input type="text" value="0" class="td-input form-control" required> </td>
                    <td class="td-part-input"> <input type="text" value="" class="td-input form-control" required> </td>
                    <td class="td-part-input"> <input type="text" value="" class="td-input form-control" required> </td>
                    <td class="td-part-input"> <input type="text" value="${element.NameStock}" class="td-input form-control" required> </td>
                    <td class="td-part-input"> <input type="text" value="${element.Price3PercentMaliat}" class="td-input form-control" required> </td>
                    <td class="td-part-input"> <input type="text" value="${element.Fi2Weight}" class="td-input form-control" required> </td>
                    <td class="td-part-input"> <input type="text" value="${element.Amount2Weight}" class="td-input form-control" required> </td>
                    <td class="td-part-input"> <input type="text" value="0" class="td-input form-control" required> </td>
                    <td class="td-part-input"> <input type="text" value="0" class="td-input form-control" required> </td>
                </tr>
            `);
        })
    })
    $("#editFactorModal").modal("show");
}


function checkAddedKalaAmountOfFactor(row){
    let input = $(row).find('input:radio');
    let goodSn=$(input).val();
    if(!goodSn){
        return
    }
    let customerSn=$("#customerOfFactorEdit").val();

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