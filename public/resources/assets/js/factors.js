
var baseUrl = "http://192.168.10.21:8000";
function getFactorOrders(element,factorSn){
    $("tr").removeClass("selected");
    $(element).addClass("selected");
    if($("#deleteFactorBtn")){
        $("#deleteFactorBtn").prop("disabled",false);
        $("#deleteFactorBtn").val(factorSn);
    }

    if($("#editFactorButton")){
        $("#editFactorButton").prop("disabled",false);
        $("#editFactorButton").val(factorSn);
    }

$.get(baseUrl+"/getFactorBYSInfo",{snFact:factorSn},(respond,status)=>{
    $("#FactorDetailBody").empty();
    let i=0;
    for (let element of respond) {
        i=i+1;
        $("#FactorDetailBody").append(`<tr>
        <td> ${i} </td>
        <td> ${element.GoodCode}</td>
        <td style="width:160px;"> ${element.GoodName} </td>
        <td> ${element.FirstUnit} </td>
        <td> ${element.SecondUnit} </td>
        <td> ${parseInt(element.PackAmnt||0).toLocaleString("en-us")} </td>
        <td> ${parseInt(element.Amount).toLocaleString("en-us")} </td>
        <td>  ${parseInt(element.CalcTakhfif).toLocaleString("en-us")}  </td>
        <td> ${parseInt(element.Fi).toLocaleString("en-us")} </td>
        <td> ${parseInt(element.FiPack).toLocaleString("en-us")}</td>
        <td> ${parseInt(element.Price).toLocaleString("en-us")}  </td>
        <td> ${parseInt(element.CalcTakhfif).toLocaleString("en-us")} </td>
        <td> ${element.DescRecord} </td>
        <td> وضعیت بارگیری </td>
        <td> بار میکروبی </td>
       </tr>`);
    }
})
}
function selectCustomerForFactor(psn,element){
    if(isNaN(element)){
        $("tr").removeClass('selected');
        $("#foundCusotmerForFactorBody tr").css('background-color', '');
        $(element).addClass("selected")
    }else{
        $("tr").removeClass('selected');
    }
    $("#addCustomerFactSabtBtn").prop("disabled",false);
    $("#addCustomerFactSabtBtn").val(psn);
}
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
                if(element.StatusFact==1){
                    trStyle="background-color:#ff8040";
                }
                if(element.TotalPricePorsant>0){
                    bazaryabPorsant=element.TotalPricePorsant;
                }
                if(element.payedMoney>0){
                    payedAmount=element.payedMoney;
                }
                $("#factorListBody").append(`
                    <tr class="factorTablRow"  ondblclick="openFactorViewModal(${element.SerialNoHDS})" style="${trStyle}" onclick="getFactorOrders(this,${element.SerialNoHDS})">
                        <td> ${index+1} <input type="radio" value="${element.SerialNoHDS}" class="d-none"/></td>
                        <td> ${element.FactNo} </td>
                        <td> ${element.FactDate} </td>
                        <td> ${element.FactDesc} </td>
                        <td> ${element.PCode} </td>
                        <td> ${element.Name} </td>
                        <td> ${parseInt(element.NetPriceHDS).toLocaleString("en-us")} </td>
                        <td> ${parseInt(payedAmount).toLocaleString("en-us")} </td>
                        <td> ${element.setterName} </td>
                        <td> حضوری </td>
                        <td> </td>
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

function factorHistory(historyWord) {
    $.get(baseUrl+"/getFactorHistory",{historyWord:historyWord,factType:3},(respond,status)=>{
        
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
                if(element.payedMoney>0){
                    payedAmount=element.payedMoney;
                }
                $("#factorListBody").append(`
                    <tr style="${trStyle}" onclick="getFactorOrders(this,${element.SerialNoHDS})">
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
                        <td> </td>
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
    })
}



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
$("#addFactorForm").on("keydown",function(e){
    if(e.keyCode==13){
        e.preventDefault();
    }
})

$("#editFactorForm").on("submit",function(e){
    e.preventDefault();
    $.ajax({
        method:"POST",
        url: $(this).attr('action'),
        data: new FormData(this),
        processData: false,
        contentType: false,
        success: function (data) {
            window.location.reload();
            $("#editFactorModal").modal("hide")
        },
        error:function(error){}
    });
})

$("#addFactorForm").on("submit",function(e){
    e.preventDefault();
    $.ajax({
        method:"POST",
        url: $(this).attr('action'),
        data: new FormData(this),
        processData: false,
        contentType: false,
        success: function (data) {
            window.location.reload();
        },
        error:function(error){
        }
    });
})



function openEditFactorModal(snFactor){
    $.get(baseUrl+"/getFactorInfoForEdit",{SnFactor:snFactor},(respond,status)=>{
        if(respond.factorInfo[0].StatusFact==1){
            swal({
                text:"این فاکتور بسته شده و قابل ویرایش نمی باشد.",
                confirm:true,
                dangerMode:true
            })
            return;
        }
        setActiveFormFactor("factorEditListBody")
        $("#customerForFactorId").val(respond.factorInfo[0].PSN);
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
        $("#customerForFactorEdit").empty();
        $("#customerForFactorEdit").append(`<option value="${respond.factorInfo[0].PSN}">${respond.factorInfo[0].Name}</option>`);
        let amelInfo=respond.amelInfo;
        let allAmel=0;
        amelInfo.forEach((element,index)=>{
            allAmel+=parseInt(element.Price);
            switch(element.SnAmel){
                case '142':
                    {
                        $("#hamlMoneyModalFEdit").val(parseInt(element.Price).toLocaleString("en-us"));
                        $("#hamlDescModalFEdit").val(element.DescItem);
                    }
                    break;
                case '143':
                    {
                        $("#nasbMoneyModalFEdit").val(parseInt(element.Price).toLocaleString("en-us"));
                        $("#nasbDescModalFEdit").val(element.DescItem);
                    }
                    break;
                case '144':
                    {
                        $("#motafariqaMoneyModalFEdit").val(parseInt(element.Price).toLocaleString("en-us"));
                        $("#motafariqaDescModalFEdit").val(element.DescItem);
                    }
                    break;
                case '168':
                    {
                        $("#bargiriMoneyModalFEdit").val(parseInt(element.Price).toLocaleString("en-us"));
                        $("#bargiriDescModalFEdit").val(element.DescItem);
                    }
                    break;
                case '188':
                    {
                        $("#tarabariMoneyModalFEdit").val(parseInt(element.Price).toLocaleString("en-us"));
                        $("#tarabariDescModalFEdit").val(element.DescItem);
                    }
                    break;
            }
        });
        $("#allAmelMoneyFEdit").text(allAmel.toLocaleString("en-us"));
        let bdbsState=" تسویه "
        let bdbsColor="white"
        if(respond.factorInfo[0].CustomerStatus>0){
            bdbsState="  بستانکار"
            bdbsColor="black"
        }
        if(respond.factorInfo[0].CustomerStatus<0){
            bdbsState="  بدهکار" 
            bdbsColor="red"
        }
        $("#lastCustomerStatusFEdit").text(parseInt(respond.factorInfo[0].CustomerStatus).toLocaleString("en-us")+bdbsState);
        $("#allMoneyTillEndRowFEdit").text(parseInt(respond.factorInfo[0].NetPriceHDS).toLocaleString("en-us"));
        $("#newOrderTakhfifInputFEdit").val(parseInt(respond.factorInfo[0].Takhfif).toLocaleString("en-us"))
        $("#sumAllRowMoneyAfterTakhfifFEdit").text(parseInt(respond.factorInfo[0].TotalPriceHDS).toLocaleString("en-us"))
        $("#factorAddressEdit").empty();
        respond.phones.forEach((element,index)=>{
            if(element.AddressPeopel != respond.factorInfo[0].OtherAddress){
                $("#factorAddressEdit").append(`<option value='${element.SnPeopelAddress}_${element.AddressPeopel}'> ${element.AddressPeopel} </option>`);
            }else{
                $("#factorAddressEdit").append(`<option value='${element.SnPeopelAddress}_${element.AddressPeopel}' selected> ${element.AddressPeopel} </option>`);
            }
         })
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
        $("#factorEditListBody").empty();
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
                <tr onclick="checkAddedKalaAmountOfFactor(this)">
                    <td class="editFactorTd-1"> ${index+1} <input type="radio" value="${element.Amount}" style="display:none" /> </td>
                    <td class="editFactorTd-2"> <input type="text" name="GoodCde${element.GoodSn}" value="${element.GoodCde}" class="td-input td-inputCodeFEdit form-control" required> <input type="radio" value="`+element.AmountUnit+`" class="td-input form-control"> <input type="checkbox" name="editableGoods[]" checked style="display:none" value="${element.GoodSn}"/> </td>
                    <td class="editFactorTd-3"> <input type="text" name="NameGood${element.GoodSn}"  style="width:auto!important;" value="${element.NameGood}" class="td-input td-inputCodeNameFEdit form-control" required> </td>
                    <td class="editFactorTd-4"> <input type="text" name="FirstUnit${element.GoodSn}" value="${element.FirstUnit}" class="td-input td-inputFirstUnitFEdit form-control" required> </td>
                    <td class="editFactorTd-5"> <input type="text" name="SecondUnit${element.GoodSn}" value="${element.SecondUnit}" class="td-input td-inputSecondUnitFEdit form-control" required> </td>
                    <td class="editFactorTd-6"> <input type="text" name="PackAmnt${element.GoodSn}" value="${parseInt(packAmount).toLocaleString("en-us")}" class="td-input  td-inputSecondUnitAmountFEdit form-control" required> </td>
                    <td class="editFactorTd-7"> <input type="text" name="JozeAmountEdit${element.GoodSn}" value="${parseInt(element.Amount%element.AmountUnit).toLocaleString("en-us")}" class="td-input td-inputJozeAmountFEdit form-control" required> </td>
                    <td class="editFactorTd-8"> <input type="text" name="FirstAmount${element.GoodSn}" value="${parseInt(firstAmount).toLocaleString("en-us")}" class="td-input td-inputFirstAmountFEdit form-control" required> </td>
                    <td class="editFactorTd-9"> <input type="text" name="ReAmount${element.GoodSn}" value="${parseInt(reAmount).toLocaleString("en-us")}" class="td-input td-inputReAmountFEdit form-control" required> </td>
                    <td class="editFactorTd-10"> <input type="text" name="Amount${element.GoodSn}" value="${parseInt(element.Amount).toLocaleString("en-us")}" class="td-input  td-AllAmountFEdit form-control" required> </td>
                    <td class="editFactorTd-11"> <input type="text" name="Fi${element.GoodSn}" value="${parseInt(element.Fi).toLocaleString("en-us")}" class="td-input td-inputFirstUnitPriceFEdit form-control" required> </td>
                    <td class="editFactorTd-12"> <input type="text" name="FiPack${element.GoodSn}" value="${parseInt(element.FiPack).toLocaleString("en-us")}" class="td-input td-inputSecondUnitPriceFEdit form-control" required> </td>
                    <td class="editFactorTd-13"> <input type="text" sytle="width:100%!important;" size="" name="Price${element.GoodSn}" value="${parseInt(element.Price).toLocaleString("en-us")}" class="td-input td-inputAllPriceFEdit form-control" required> </td>
                    <td class="editFactorTd-14"> <input type="text" name="PriceAfterTakhfif${element.GoodSn}" value="${parseInt(element.PriceAfterTakhfif).toLocaleString("en-us")}" class="td-input td-inputAllPriceAfterTakhfifFEdit  form-control" required> </td>
                    <td class="editFactorTd-15"> <input type="text" name="" value="0" class="td-input td-inputFactorNumFEdit form-control" required> </td>
                    <td class="editFactorTd-16"> <input type="text" name="" value="0" class="td-input td-inputFactorDateFEdit form-control" required> </td>
                    <td class="editFactorTd-17"> <input type="text" name="" value="0" class="td-input td-inputFactorDescFEdit form-control" required> </td>
                    <td class="editFactorTd-18"> <input type="text" name="NameStock${element.GoodSn}" value="0" class="td-input td-inputStockFEdit form-control" required> </td>
                    <td class="editFactorTd-19"> <input type="text" name="Price3PercentMaliat${element.GoodSn}" value="${element.Price3PercentMaliat}" class="td-input td-inputMaliatFEdit form-control" required> </td>
                    <td class="editFactorTd-20"> <input type="text" name="Fi2Weight${element.GoodSn}" value="${element.Fi2Weight}" class="td-input td-inputWeightUnitFEdit form-control" required> </td>
                    <td class="editFactorTd-21"> <input type="text" name="Amount2Weight${element.GoodSn}" value="${element.Amount2Weight}" class="td-input td-inputAllWeightFEdit form-control" required> </td>
                    <td class="editFactorTd-22"> <input type="text" name="Service${element.GoodSn}" value="0" class="td-input  td-inputInserviceFEdit form-control" required> </td>
                    <td class="editFactorTd-23"> <input type="text" name="PercentMaliat${element.GoodSn}" value="0" class="td-input  td-inputPercentMaliatFEdit form-control" required> </td>
                    <td class="editFactorTd-24 d-none"> 
                        <input type="text" value="`+element.lastBuyFi+`" class="td-input form-control">
                    </td>
                </tr>
            `);
           
        })
        $("#editFactorModal").modal("show");
        makeTableColumnsResizable("factorEidtTable")
    })
    
}

function openCustomerGardishModal(psn){
    
    $.get(baseUrl+"/getCustomerGardish",{psn:psn},function(respond,status){
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

            $("#customerGardishListBody").append(`
                 <tr>
                    <td class="customerCirculation-1"> ${element.DocDate} </td>
                    <td class="customerCirculation-2"> ${element.FactDesc} </td>
                    <td class="customerCirculation-3"> ${element.tasviyeh} </td>
                    <td class="customerCirculation-4"> ${parseInt(bestankar).toLocaleString("en-us")} </td>
                    <td class="customerCirculation-5"> ${parseInt(bedehkar).toLocaleString("en-us")} </td>
                    <td class="customerCirculation-6"> ${element.bdbsState==0 ? 0 : "--"} </td>
                    <td class="customerCirculation-7"> ${parseInt(remain).toLocaleString("en-us")} </td>
                </tr>`);
                makeTableColumnsResizable("customerCirculationTable")
            });

        $("#customerGardishModal").modal("show");
    })
}

$("#closeCustomerGardishModalBtn").on("click",function(){
    $("#customerGardishModal").modal("hide");
})

function openKalaGardish(){
    
    $.get(baseUrl+"/getGardishKala",{goodSn:$("#selectedGoodSn").val()},function(respond,status){
        $("#kalaGardishListBody").empty();
        respond.kalaGardish.forEach((element,index)=>{
            let exported=0;
            let imported=0;
            let fi=0;
            if(element.export>0){
                exported=element.export;
            }
            if(element.import>0){
                imported=element.import;
            }
            if(element.Fi>0){
                fi=element.Fi;
            }
            $("#kalaGardishListBody").append(`
               <tr>
                <td class="addGardish-1"> ${index+1} </td>
                <td class="addGardish-2"> ${element.FactDate} </td>
                <td class="addGardish-3"> ${element.DescRec} </td>
                <td class="addGardish-4"> ${element.FactNo} </td>
                <td class="addGardish-5"> ${parseFloat(exported).toLocaleString("en-us")} </td>
                <td class="addGardish-6"> ${parseFloat(imported).toLocaleString("en-us")} </td>
                <td class="addGardish-7"> ${element.Exist} </td>
                <td class="addGardish-8"> ${element.SnStockIn} </td>
                <td class="addGardish-9"> ${element.Name} </td>
                <td class="addGardish-10"> ${element.PackAmount} </td>
                <td class="addGardish-11"> ${parseInt(fi).toLocaleString("en-us")} </td>
                <td class="addGardish-12"> ${element.username} </td>
                <td class="addGardish-13"> ${element.TimeStamp} </td>
                <td class="addGardish-14"> ${element.SerialNoBYS} </td>
                <td class="addGardish-15"> ${element.SerialNoHDS} </td>
            </tr>  `);
          makeTableColumnsResizable("addFactorGardishKalaTable");

        });


        $("#kalaGardishListBody").append(`
            <tr>
                <td>  </td>
                <td>  </td>
                <td>  </td>
                <td>  </td>
                <td> مجموع خروج </td>
                <td> مجموع ورود </td>
                <td> موجودی نهایی </td>
                <td>  </td>
                <td>  </td>
                <td>  </td>
                <td>  </td>
                <td>  </td>
                <td>  </td>
                <td>  </td>
                <td>  </td>
            </tr>`);
    })
    $("#kalaGardishModal").modal("show");
}


function openLastTenBuysModal(){
    $("#lastTenBuysModal").modal("show");
    let goodSn=$("#selectedGoodSn").val();
    $("#lastTenBuysListBody").empty();
    $.get(baseUrl+"/getlastTenBuys",{goodSn:goodSn},(respond,status)=>{
        respond.forEach((element,index)=>{
            $("#lastTenBuysListBody").append(`
                <tr class="factorTablRow">
                    <td id="tenLasthBuy-1"> ${ index+1 } </td>
                    <td id="tenLasthBuy-2"> ${ element.FactDate } </td>
                    <td id="tenLasthBuy-3"> ${ element.FactNo } </td>
                    <td id="tenLasthBuy-4"> ${ element.Name } </td>
                    <td id="tenLasthBuy-5"> ${ parseInt(element.Amount).toLocaleString("en-us") } </td>
                    <td id="tenLasthBuy-6"> ${ parseInt(element.Fi).toLocaleString("en-us") } </td>
                    <td id="tenLasthBuy-7">  </td>
                    <td id="tenLasthBuy-8"> ${ element.DescRecord } </td>
                </tr>`);
        })
    })
}

function openLastTenSalesModal(){
    let goodSn=$("#selectedGoodSn").val();
    $("#lastTenSalesListBody").empty();
    $.get(baseUrl+"/getlastTenSales",{goodSn:goodSn},(respond,status)=>{
        respond.forEach((element,index)=>{
            $("#lastTenSalesListBody").append(`
                <tr >
                    <td class="tenLastBuy-1"> ${ index+1 } </td>
                    <td class="tenLastBuy-2"> ${ element.FactDate } </td>
                    <td class="tenLastBuy-3"> ${ element.FactNo } </td>
                    <td class="tenLastBuy-4"> ${ element.Name } </td>
                    <td class="tenLastBuy-5"> ${ parseInt(element.Amount).toLocaleString("en-us") } </td>
                    <td class="tenLastBuy-6"> ${ parseInt(element.Fi).toLocaleString("en-us") } </td>
                    <td class="tenLastBuy-7">  </td>
                    <td class="tenLastBuy-8"> ${ element.DescRecord } </td>
                </tr>`);
                makeTableColumnsResizable("tenLastBuy")
        })

        $("#lastTenSalesModal").modal("show");

    })
}

function openNotSentOrdersModal(){
    
    let goodSn=$("#selectedGoodSn").val();
    $("#unSentOrdersListBody").empty();
    $.get(baseUrl+"/getUnSentOrders",{goodSn:goodSn},(respond,status)=>{
        respond.forEach((element,index)=>{
            $("#unSentOrdersListBody").append(`
                    <tr>
                        <td class="notSentOrder-1"> ${ index+1 } </td>
                        <td class="notSentOrder-2"> ${ element.OrderNo } </td>
                        <td class="notSentOrder-3"> ${ element.OrderDate } </td>
                        <td class="notSentOrder-4"> ${ element.PCode } </td>
                        <td class="notSentOrder-5"> ${ element.Name } </td>
                        <td class="notSentOrder-6"> ${ element.GoodCde } </td>
                        <td class="notSentOrder-7"> ${ element.GoodName } </td>
                        <td class="notSentOrder-8"> ${ element.secondUnit } </td>
                        <td class="notSentOrder-9"> ${ element.Amount } </td>
                    </tr>`);
                    makeTableColumnsResizable("notSentOrderTable")
        })
        $("#unSentOrdersModal").modal("show");
    })
}

$("#selectKalaToFactorBtn").on("click",function(){
    var rowCount = $("#factorEditListBody tr").length;
    let allMoney=0;
    for(let i=1;i<=rowCount;i++){
       let rowGoodSn= $('#factorEditListBody tr:nth-child('+i+')').find('input:checkbox').val();
       if(rowGoodSn==$(this).val()){
        swal({title:"قبلا اضافه شده است",
              text:"کالای انتخاب شده قبلا اضافه شده است",
              icon:"warning",
              buttons:true});
        return
       }
    }

$.get(baseUrl+"/searchKalaByID",{goodSn:$(this).val()},function(data,status){
    if(status=="success"){
        let row=data.map((element,index)=> `
                                            <tr class="factorTablRow" onclick="checkAddedKalaAmountOfFactor(this)">
                                            <td class="td-part-input"> ${index+1}</td>
                                            <td class="td-part-input"> <input type="text" name="GoodCde${element.GoodSn}" value="${element.GoodCde}" class="td-input td-inputCodeFEdit form-control" required> <input type="radio" value="`+element.AmountUnit+`" class="td-input form-control"> <input type="checkbox" name="editableGoods[]" checked style="display:none" value="${element.GoodSn}"/> </td>
                                            <td class="td-part-input"> <input type="text" name="NameGood${element.GoodSn}" value="${element.GoodName}" class="td-input td-inputCodeNameFEdit form-control" required> </td>
                                            <td class="td-part-input"> <input type="text" name="FirstUnit${element.GoodSn}" value="${element.firstUnit}" class="td-input td-inputFirstUnitFEdit form-control" required> </td>
                                            <td class="td-part-input"> <input type="text" name="SecondUnit${element.GoodSn}" value="${element.secondUnit}" class="td-input td-inputSecondUnitFEdit form-control" required> </td>
                                            <td class="td-part-input"> <input type="text" name="PackAmnt${element.GoodSn}" value="" class="td-input  td-inputSecondUnitAmountFEdit form-control" required> </td>
                                            <td class="td-part-input"> <input type="text" name="JozeAmountEdit${element.GoodSn}" value="" class="td-input td-inputJozeAmountFEdit form-control" required> </td>
                                            <td class="td-part-input"> <input type="text" name="FirstAmount${element.GoodSn}" value="" class="td-input td-inputFirstAmountFEdit form-control" required> </td>
                                            <td class="td-part-input"> <input type="text" name="ReAmount${element.GoodSn}" value="" class="td-input td-inputReAmountFEdit form-control" required> </td>
                                            <td class="td-part-input"> <input type="text" name="Amount${element.GoodSn}" value="" class="td-input  td-AllAmountFEdit form-control" required> </td>
                                            <td class="td-part-input"> <input type="text" name="Fi${element.GoodSn}" value="${parseInt(element.Price3).toLocaleString("en-us")}" class="td-input td-inputFirstUnitPriceFEdit form-control" required> </td>
                                            <td class="td-part-input"> <input type="text" name="FiPack${element.GoodSn}" value="" class="td-input td-inputSecondUnitPriceFEdit form-control" required> </td>
                                            <td class="td-part-input"> <input type="text" name="Price${element.GoodSn}" value="" class="td-input td-inputAllPriceFEdit form-control" required> </td>
                                            <td class="td-part-input"> <input type="text" name="PriceAfterTakhfif${element.GoodSn}" value="" class="td-input td-inputAllPriceAfterTakhfifFEdit  form-control" required> </td>
                                            <td class="td-part-input"> <input type="text" name="" value="0" class="td-input td-inputFactorNumFEdit form-control" required> </td>
                                            <td class="td-part-input"> <input type="text" name="" value="0" class="td-input td-inputFactorDateFEdit form-control" required> </td>
                                            <td class="td-part-input"> <input type="text" name="" value="0" class="td-input td-inputFactorDescFEdit form-control" required> </td>
                                            <td class="td-part-input"> <input type="text" name="NameStock${element.GoodSn}" value="0" class="td-input td-inputStockFEdit form-control" required> </td>
                                            <td class="td-part-input"> <input type="text" name="Price3PercentMaliat${element.GoodSn}" value="0" class="td-input td-inputMaliatFEdit form-control" required> </td>
                                            <td class="td-part-input"> <input type="text" name="Fi2Weight${element.GoodSn}" value="0" class="td-input td-inputWeightUnitFEdit form-control" required> </td>
                                            <td class="td-part-input"> <input type="text" name="Amount2Weight${element.GoodSn}" value="0" class="td-input td-inputAllWeightFEdit form-control" required> </td>
                                            <td class="td-part-input"> <input type="text" name="Service${element.GoodSn}" value="0" class="td-input  td-inputInserviceFEdit form-control" required> </td>
                                            <td class="td-part-input"> <input type="text" name="PercentMaliat${element.GoodSn}" value="0" class="td-input  td-inputPercentMaliatFEdit form-control" required> </td>
                                            <td class="td-part-input d-none"> 
                                                <input type="text" value="`+element.lastBuyFi+`" class="td-input form-control">
                                            </td>
                                        </tr>
                                        `)
        $(`#factorEditListBody tr:nth-child(`+$("#rowTaker").val()+`)`).replaceWith(row);
        $(`#factorEditListBody tr:nth-child(`+$("#rowTaker").val()+`) td:nth-child(6) input`).focus();
        $(`#factorEditListBody tr:nth-child(`+$("#rowTaker").val()+`) td:nth-child(6) input`).select();
        checkAddedKalaAmountOfFactorEdit(data[0].GoodSn);
        }
    });

    $("#searchGoodsModalEditFactor").modal("hide");
});
function checkAddedKalaAmountOfFactorEdit(goodSn){
    if(!goodSn){
        return
    }

    let customerSn=$("#customerForFactorEdit").val();

        $.get(baseUrl+"/getGoodInfoForAddOrderItem",{
            goodSn: goodSn,
            customerSn:customerSn,
            stockId: 23
        },(respond,status)=>{
            if(respond[1][0]){
                if(!isNaN(respond[1][0].Amount)){
                    let amount=0;
                    if(respond[1][0].Amount<1){
                        amount=0;
                    }else{
                        amount=respond[1][0].Amount;
                    }
                    $("#firstEditExistInStock").text(parseInt(amount).toLocaleString("en-us"));

                }else{
                    $("#firstEditExistInStock").text(0);

                }

            }else{
                $("#firstEditExistInStock").text(0);

            }

            if(respond[2][0]){
                if(!isNaN(respond[2][0].Price3)){
                    let price=0;
                    if(respond[2][0].Price3<1){
                        price=0;
                    }else{
                        price=respond[2][0].Price3;
                    }
                    $("#firstEditPrice").text(parseInt(price).toLocaleString("en-us"));
                }else{
                    $("#firstEditPrice").text(0);
                }
            }else{
                $("#firstEditPrice").text(0);
            }
            if(respond[4][0]){
                if(!isNaN(respond[4][0].Fi)){
                    $("#firstEditLastPrice").text(parseInt(respond[4][0].Fi).toLocaleString("en-us"));
                }else{
                    $("#firstEditLastPrice").text(0);
                }
            }else{
                $("#firstEditLastPrice").text(0);
            }

            if(respond[3][0]){
                if(!isNaN(respond[3][0].Price3)){
                    let price=0;
                    if(respond[3][0].Price3<1){
                        price=0;
                    }else{
                        price=respond[3][0].Price3;
                    }
                    $("#firstEditLastPriceCustomer").text(parseInt(price).toLocaleString("en-us"));
                }else{
                    $("#firstEditLastPriceCustomer").text(0);
                }
            }else{
                $("#firstEditLastPriceCustomer").text(0);
            }
            

        })
    const previouslySelectedRow = document.querySelector('.selected');
    if(previouslySelectedRow) {
        previouslySelectedRow.classList.remove('selected');
        //previouslySelectedRow.children().classList.remove('selected');
    }
}
function setAddedToFactorKalaStuffEdit(element,goodSn){
    
    if(isNaN(element)){
        $("tr").removeClass('selected');
        $("#kalaForAddToFactor tr").css('background-color', '');
        $(element).addClass("selected")
    }else{
        $("tr").removeClass('selected');
    }
 $("#selectKalaToFactorBtn").val(goodSn)
 if($("#selectKalaToFactorBtn")){
    $("#selectKalaToFactorBtn").val(goodSn)
 }
 let customerSn=$("#customerForFactorEdit").val();
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
                $("#StockExistanceFactorEdit").text(parseInt(amount).toLocaleString("en-us"));
            } else {
                $("#StockExistanceFactorEdit").text(0);
            }
        }else {
            $("#StockExistanceFactorEdit").text(0);
        }
        if(response[1][0]){

            if (!isNaN(parseInt(response[1][0].Price3))) {
                let price=0
                if(response[1][0].Price3>1){
                    price=response[1][0].Price3
                }
                $("#SalePriceFactorEdit").text(parseInt(price/ 10).toLocaleString("en-us"));
            } else {
                $("#SalePriceFactorEdit").text(0);
            }
        } else {
            $("#SalePriceFactorEdit").text(0);
        }

        if (response[2][0]) {

            if (!isNaN(parseInt(response[2][0].Fi))) {
                $("#LastPriceCustomerFactorEdit").text(parseInt(response[2][0].Fi / 10).toLocaleString("en-us"));
            } else {
                $("#LastPriceCustomerFactorEdit").text(0);
            }
        }else {
            $("#LastPriceCustomerFactorEdit").text(0);
        }

        if([3][0]){
            if (!isNaN(parseInt(response[3][0].Fi))) {
                $("#LastPriceFactorEdit").text(parseInt(response[3][0].Fi / 10).toLocaleString("en-us"));
            } else {
                $("#LastPriceFactorEdit").text(0);
            }
        }else {
            $("#LastPriceFactorEdit").text(0);
        }
    },
    error: function (error) {
        //alert("get item existance error found");
    }
})
}

$(document).on("keyup","#searchKalaForEditToFactorByName",function(event){

    let tableBody=$("#kalaForEditToFactorEditBody");
    if(event.keyCode!=40){
        if(event.keyCode!=13){
            $.get(baseUrl+'/getKalaByName',{name:$(this).val()},function (data,status) {
                if(status=='success'){
                    tableBody.empty();
                    let i=0;
                    for (const element of data) {
                        i++;
                        if(i!=1){
                            tableBody.append(`<tr onclick="setAddedToFactorKalaStuffEdit(this,`+element.GoodSn+`)"> <td>`+(i)+`<input type="radio" value="${element.GoodSn}" class="d-none"/></td> <td> `+element.GoodCde+` </td><td> `+element.GoodName+`</td> <td>...</td> </tr>`);
                            
                        }else{
                            tableBody.append(`<tr onclick="setAddedToFactorKalaStuffEdit(this,`+element.GoodSn+`)"> <td>`+(i)+`<input type="radio" value="${element.GoodSn}" class="d-none"/></td> <td> `+element.GoodCde+` </td><td> `+element.GoodName+`</td> <td>...</td> </tr>`);
                            $("#kalaForEditToFactorEditBody tr").eq(0).css('background-color', 'rgb(0,142,201)'); 
                            const selectedGoodSn = data[0].GoodSn;
                            setAddedToFactorKalaStuffEdit(0,selectedGoodSn)
                        }
                    }

                    Mousetrap.bind("enter",()=>{
                        $("#selectKalaToFactorBtn").trigger("click");
                    });

                    Mousetrap.bind("esc",()=>{
                        $("#searchGoodsModalAdd").modal("hide");
                    });

                }
            })
    }else{
        $("#selectKalaToFactorBtn").trigger("click");
    }
}else{
    $(this).blur(); // Remove focus from the input
    $("#kalaForAddToFactorTble").focus();
}

});

$(document).on("keyup","#searchKalaForEditToFactorByCode",function(event){

    let tableBody=$("#kalaForEditToFactorEditBody");
    if(event.keyCode!=40){
        if(event.keyCode!=13){
            $.get(baseUrl + '/searchKalaByCode', { code: $("#searchKalaForEditToFactorByCode").val() },function (data,status) {
                if(status=='success'){
                    tableBody.empty();
                    let i=0;
                    for (const element of data) {
                        i++;
                        if(i!=1){
                            tableBody.append(`<tr onclick="setAddedToFactorKalaStuffEdit(this,`+element.GoodSn+`)"> <td>`+(i)+`<input type="radio" value="${element.GoodSn}" class="d-none"/></td> <td> `+element.GoodCde+` </td><td> `+element.GoodName+`</td> <td>...</td> </tr>`);
                        }else{
                            tableBody.append(`<tr onclick="setAddedToFactorKalaStuffEdit(this,`+element.GoodSn+`)"> <td>`+(i)+`<input type="radio" value="${element.GoodSn}" class="d-none"/></td> <td> `+element.GoodCde+` </td><td> `+element.GoodName+`</td> <td>...</td> </tr>`);
                            $("#kalaForEditToFactorEditBody tr").eq(0).css('background-color', 'rgb(0,142,201)'); 
                            const selectedGoodSn = data[0].GoodSn;
                            setAddedToFactorKalaStuffEdit(0,selectedGoodSn)
                        }
                    }
                    

                    

                    Mousetrap.bind("enter",()=>{
                        $("#selectKalaToFactorBtn").trigger("click");
                    });

                    Mousetrap.bind("esc",()=>{
                        $("#searchGoodsModalAdd").modal("hide");
                    });

                }
            })
    }else{
        $("#selectKalaToFactorBtn").trigger("click");
    }
}else{
    $(this).blur(); // Remove focus from the input
    $("#kalaForAddToFactorTble").focus();
}

});


$(document).on("keyup",".td-inputCodeFEdit",function(e){
    if((e.keyCode>=65 && e.keyCode<=90) || ((e.keyCode>=48 && e.keyCode<=57) || (e.keyCode>=96 && e.keyCode<=105))){
        setActiveTable("kalaForEditToFactorEditBody")
        checkNumberInput(e);
        $("#rowTaker").val($(e.target).parents("tr").index()+1)
        if (!($('.modal.in').length)) {
            $('.modal-dialog').css({
                top: 0,
                left: 0
            });
        }
        $('#searchGoodsModalEditFactor').modal({
            backdrop: false,
            show: true
        });

        $('.modal-dialog').draggable({
            handle: ".modal-header"
        });
        $("#searchKalaForEditToFactorByCode").val("");
        $("#searchForEditItemLabel").text("کد کالا")
        $("#searchKalaForEditToFactorByCode").val("");
        $("#searchKalaForEditToFactorByCode").val($(e.target).val());
        $("#searchKalaForEditToFactorByCode").show();
        $("#searchKalaForEditToFactorByName").hide();
        $("#searchGoodsModalEditFactor").modal("show");
        $('#searchGoodsModalEditFactor').on('shown.bs.modal', function() {
        $("#searchKalaForEditToFactorByCode").focus();
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

$(document).on("keyup",".td-inputCodeNameFEdit",function(e){
    if((e.keyCode>=65 && e.keyCode<=90) || ((e.keyCode>=48 && e.keyCode<=57) || (e.keyCode>=96 && e.keyCode<=105))){
        setActiveTable("kalaForEditToFactorEditBody")
        $("#rowTaker").val($(e.target).parents("tr").index()+1)
        if (!($('.modal.in').length)) {
            $('.modal-dialog').css({
                top: 0,
                left: 0
            });
        }
        $('#searchGoodsModalEditFactor').modal({
            backdrop: false,
            show: true
        });

        $('.modal-dialog').draggable({
            handle: ".modal-header"
        });
        $("#searchKalaForEditToFactorByName").val();
        $("#searchForEditItemLabel").text("نام کالا")
        $("#searchKalaForEditToFactorByName").val("");
        $("#searchKalaForEditToFactorByName").val($(e.target).val());
        $("#searchKalaForEditToFactorByCode").hide();
        $("#searchKalaForEditToFactorByName").show();
        $("#searchGoodsModalEditFactor").modal("show");
        $('#searchGoodsModalEditFactor').on('shown.bs.modal', function() {
        $("#searchKalaForEditToFactorByName").focus();
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
$(document).on("keyup",".td-inputFirstUnitFEdit",function(e){
    if(e.keyCode ==13 || e.keyCode ==9){
        var currentInput = $(e.target);
        var nextInput = currentInput.closest('td').next('td').find('input');
        if (nextInput.length > 0) {
            nextInput.focus();
        }
    }
})
$(document).on("keyup",".td-inputSecondUnitFEdit",function(e){
    if(e.keyCode ==13 || e.keyCode ==9){
        var $currentInput = $(e.target);
        var $nextInput = $currentInput.closest('td').next('td').find('input');
        if ($nextInput.length > 0) {
            $nextInput.focus();
        }
    }
})
$(document).on("keyup",".td-inputSecondUnitAmountFEdit",function(e){

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
                    $('#factorEditListBody tr:nth-child('+rowindex+') td:nth-child(7)').children('input').val(0);
                    $('#factorEditListBody tr:nth-child('+rowindex+') td:nth-child(8)').children('input').val(0);
                    $('#factorEditListBody tr:nth-child('+rowindex+') td:nth-child(9)').children('input').val(0);
                    $('#factorEditListBody tr:nth-child('+rowindex+') td:nth-child(14) input[type="checkbox"]').val(GoodSn+'_'+packAmount+'_'+allAmountUnit+'_'+allPrice+'_'+packPrice+'_'+price);
                    var $currentInput = $(e.target);
                    var $currentTd = $currentInput.closest('td');
                    var $nextTd = $currentTd.next('td');
                    var $nextInput = $nextTd.find('input');
                        $($nextInput).focus();
                }else{
                    var $currentInput = $(e.target);
                    $($currentInput).focus();
                    $('#factorEditListBody tr:nth-child('+rowindex+') td:nth-child(7)').children('input').val(0);
                    $('#factorEditListBody tr:nth-child('+rowindex+') td:nth-child(8)').children('input').val(0);
                    $('#factorEditListBody tr:nth-child('+rowindex+') td:nth-child(9)').children('input').val(0);

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
$(document).on("keyup",".td-inputJozeAmountFEdit",function(e){
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
$(document).on("keyup",".td-inputFirstAmountFEdit",function(e){
    if(e.keyCode ==13 || e.keyCode ==9){
        var $currentInput = $(e.target);
        var $nextInput = $currentInput.closest('td').next('td').find('input');
        if ($nextInput.length > 0) {
            $nextInput.focus();
        }
    }
})
$(document).on("keyup",".td-inputReAmountFEdit",function(e){
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
$(document).on("keyup",".td-AllAmountFEdit",function(e){
    
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
$(document).on("keyup",".td-inputFirstUnitPriceFEdit",function(e){
    let rowindex=$(e.target).parents("tr").index()+1
    if((e.keyCode>=65 && e.keyCode<=90)|| ((e.keyCode>=48 && e.keyCode<=57) || (e.keyCode>=96 && e.keyCode<=105))){

        if(($('#factorEditListBody tr:nth-child('+$('#factorEditListBody tr').length+') td:nth-child(2)').children('input').val().length)<1){
            $(`#factorEditListBody tr:nth-child(`+$('#factorEditListBody tr').length+`)`).replaceWith('');
        }
        
        let subPackUnits=parseInt($('#factorEditListBody tr:nth-child('+rowindex+') td:nth-child(7)').children('input').val().replace(/,/g, ''));
        let amountUnit=$($('#factorEditListBody tr:nth-child('+rowindex+') td:nth-child(2)').find('input:radio')).val().replace(/,/g, '');
        let price=parseInt($(e.target).val().replace(/,/g, ''));
        

        let allAmountUnit=$($('#factorEditListBody tr:nth-child('+rowindex+') td:nth-child(10)').children('input')).val().replace(/,/g, '');
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
    }else{
        if(($('#factorEditListBody tr:nth-child('+$('#factorEditListBody tr').length+') td:nth-child(2)').children('input').val().length)<1){
            $(`#factorEditListBody tr:nth-child(`+$('#factorEditListBody tr').length+`)`).replaceWith('');
        }
        let subPackUnits=parseInt($('#factorEditListBody tr:nth-child('+rowindex+') td:nth-child(7)').children('input').val().replace(/,/g, ''));
        let amountUnit=$($('#factorEditListBody tr:nth-child('+rowindex+') td:nth-child(2)').find('input:radio')).val().replace(/,/g, '');
        let price=parseInt($(e.target).val().replace(/,/g, ''));
        

        let allAmountUnit=$($('#factorEditListBody tr:nth-child('+rowindex+') td:nth-child(10)').children('input')).val().replace(/,/g, '');
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
    let lastBuyFi=parseInt($('#factorEditListBody tr:nth-child('+rowindex+') td:nth-child(24)').children('input').val().replace(/,/g, ''));
    
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
                }else{
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
})
$(document).on("keyup",".td-inputSecondUnitPriceFEdit",function(e){
    if(e.keyCode ==13 || e.keyCode ==9){
        var $currentInput = $(e.target);
        var $nextInput = $currentInput.closest('td').next('td').find('input');
        if ($nextInput.length > 0) {
            $nextInput.focus();
        }
    }
})
$(document).on("keyup",".td-inputAllPriceFEdit",function(e){
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

$(document).on("keyup",".td-inputAllPriceAfterTakhfifFEdit",function(e){
    if(e.keyCode ==13 || e.keyCode ==9){
        var $currentInput = $(e.target);
        var $nextInput = $currentInput.closest('td').next('td').find('input');
        if ($nextInput.length > 0) {
            $nextInput.focus();
        }
    }
})
$(document).on("keyup",".td-inputFactorNumFEdit",function(e){
    if(e.keyCode ==13 || e.keyCode ==9){
        var $currentInput = $(e.target);
        var $nextInput = $currentInput.closest('td').next('td').find('input');
        if ($nextInput.length > 0) {
            $nextInput.focus();
        }
    }
})
$(document).on("keyup",".td-inputFactorDateFEdit",function(e){
    if(e.keyCode ==13 || e.keyCode ==9){
        var $currentInput = $(e.target);
        var $nextInput = $currentInput.closest('td').next('td').find('input');
        if ($nextInput.length > 0) {
            $nextInput.focus();
        }
    }
})
$(document).on("keyup",".td-inputFactorDescFEdit",function(e){
    if(e.keyCode ==13 || e.keyCode ==9){
        var $currentInput = $(e.target);
        var $nextInput = $currentInput.closest('td').next('td').find('input');
        if ($nextInput.length > 0) {
            $nextInput.focus();
        }
    }
})
$(document).on("keyup",".td-inputStockFEdit",function(e){
    if(e.keyCode ==13 || e.keyCode ==9){
        var $currentInput = $(e.target);
        var $nextInput = $currentInput.closest('td').next('td').find('input');
        if ($nextInput.length > 0) {
            $nextInput.focus();
        }
    }
})
$(document).on("keyup",".td-inputMaliatFEdit",function(e){
    if(e.keyCode ==13 || e.keyCode ==9){
        var $currentInput = $(e.target);
        var $nextInput = $currentInput.closest('td').next('td').find('input');
        if ($nextInput.length > 0) {
            $nextInput.focus();
        }
    }
})
$(document).on("keyup",".td-inputWeightUnitFEdit",function(e){
    if(e.keyCode ==13 || e.keyCode ==9){
        var $currentInput = $(e.target);
        var $nextInput = $currentInput.closest('td').next('td').find('input');
        if ($nextInput.length > 0) {
            $nextInput.focus();
        }
    }
})
$(document).on("keyup",".td-inputAllWeightFEdit",function(e){
    if(e.keyCode ==13 || e.keyCode ==9){
        var $currentInput = $(e.target);
        var $nextInput = $currentInput.closest('td').next('td').find('input');
        if ($nextInput.length > 0) {
            $nextInput.focus();
        }
    }
})
$(document).on("keyup",".td-inputInserviceFEdit",function(e){
    if(e.keyCode ==13 || e.keyCode ==9){
        var $currentInput = $(e.target);
        var $nextInput = $currentInput.closest('td').next('td').find('input');
        if ($nextInput.length > 0) {
            $nextInput.focus();
        }
    }
})
$(document).on("keyup",".td-inputPercentMaliatFEdit",function(e){
    let goodSn=$('#factorEditListBody tr:nth-child('+($(e.target).parents("tr").index()+1)+') td:nth-child(2)').children('input').val().length
    if((e.keyCode === 9 ||e.keyCode === 13)  && (($(e.target).parents("tr").index()+1)==$("#factorEditListBody tr").length) && goodSn>0){
        checkNumberInput(e);
        let row=`<tr class="factorTablRow" onclick="checkAddedKalaAmountOfFactor(this)">
        <td class="td-part-input"> </td>
        <td class="td-part-input"> <input type="text" value="" class="td-input td-inputCodeFEdit form-control"> <input type="radio" style="display:none" value=""/> </td>
        <td class="td-part-input"> <input type="text" value="" class="td-input td-inputCodeNameFEdit form-control"> </td>
        <td class="td-part-input"> <input type="text" value="" class="td-input td-inputFirstUnitFEdit form-control"> </td>
        <td class="td-part-input"> <input type="text" value="" class="td-input td-inputSecondUnitFEdit form-control"> </td>
        <td class="td-part-input"> <input type="text" value="" class="td-input  td-inputSecondUnitAmountFEdit form-control"> </td>
        <td class="td-part-input"> <input type="text" value="" class="td-input td-inputJozeAmountFEdit form-control"> </td>
        <td class="td-part-input"> <input type="text" value="" class="td-input td-inputFirstAmountFEdit form-control"> </td>
        <td class="td-part-input"> <input type="text" value="" class="td-input td-inputReAmountFEdit form-control"> </td>
        <td class="td-part-input"> <input type="text" value="" class="td-input  td-AllAmountFEdit form-control"> </td>
        <td class="td-part-input"> <input type="text" value="" class="td-input td-inputFirstUnitPriceFEdit form-control"> </td>
        <td class="td-part-input"> <input type="text" value="" class="td-input td-inputSecondUnitPriceFEdit form-control"> </td>
        <td class="td-part-input"> <input type="text" value="" class="td-input td-inputAllPriceFEdit form-control"> </td>
        <td class="td-part-input"> <input type="text" value="" class="td-input td-inputAllPriceAfterTakhfifFEdit  form-control"> </td>
        <td class="td-part-input"> <input type="text" value="" class="td-input td-inputFactorNumFEdit form-control"> </td>
        <td class="td-part-input"> <input type="text" value="" class="td-input td-inputFactorDateFEdit form-control"> </td>
        <td class="td-part-input"> <input type="text" value="" class="td-input td-inputFactorDescFEdit form-control"> </td>
        <td class="td-part-input"> <input type="text" value="" class="td-input td-inputStockFEdit form-control"> </td>
        <td class="td-part-input"> <input type="text" value="" class="td-input td-inputMaliatFEdit form-control"> </td>
        <td class="td-part-input"> <input type="text" value="" class="td-input td-inputWeightUnitFEdit form-control"> </td>
        <td class="td-part-input"> <input type="text" value="" class="td-input td-inputAllWeightFEdit form-control"> </td>
        <td class="td-part-input"> <input type="text" value="" class="td-input  td-inputInserviceFEdit form-control"> </td>
        <td class="td-part-input"> <input type="text" value="" class="td-input  td-inputPercentMaliatFEdit form-control"> </td>
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
    $("#selectedGoodSn").val(goodSn);
    if(!goodSn){
        return
    }
    let customerSn=$("#customerForFactorEdit").val();

    let rowindex=$(row).index()+1
    let totalMoneyTillRow=0;

    for (let index = 1; index <=rowindex; index++) {

        totalMoneyTillRow+=parseInt($('#factorEditListBody tr:nth-child('+index+') td:nth-child(14)').children('input').val().replace(/,/g, ''));
    
    }
    $("#allMoneyTillThisRowFEdit").text(parseInt(totalMoneyTillRow).toLocaleString("en-us"));

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
                $("#firstEditExistInStock").text(parseInt(amount).toLocaleString("en-us"));
            }else{
                $("#firstEditExistInStock").text(0);
            }

        }else{
            $("#firstEditExistInStock").text(0);
        }

        if(respond[2][0]){
            if(!isNaN(respond[2][0].Price3)){
                let price=0;
                if(respond[2][0].Price3>=1){
                    price=respond[2][0].Price3
                }
                $("#firstEditPrice").text(parseInt(price).toLocaleString("en-us"));
            }else{
                $("#firstEditPrice").text(0);
            }

        }else{
            $("#firstEditPrice").text(0);
        }

        if(respond[4][0]){
            if(!isNaN(respond[4][0].Fi)){
                let fi=0;
                if(respond[4][0].Fi>=1){
                    fi=respond[4][0].Fi;
                }
                $("#firstEditLastPriceCustomer").text(parseInt(fi).toLocaleString("en-us"));
            }else{
                $("#firstEditLastPriceCustomer").text(0);                
            }
        }else{
            $("#firstEditLastPriceCustomer").text(0);
        }

        if(respond[3][0]){
            if(!isNaN(respond[3][0].Fi)){
                let fi=0;
                if(respond[3][0].Fi>=1){
                    fi=respond[3][0].Fi
                }
                $("#firstEditLastPrice").text(parseInt(fi).toLocaleString("en-us"));
            }else{
                $("#firstEditLastPrice").text(0);  
            }
        }else{
            $("#firstEditLastPrice").text(0);
        }
    });
    const previouslySelectedRow = document.querySelector('.selected');
    if(previouslySelectedRow) {
        previouslySelectedRow.classList.remove('selected');
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
// let d = new persianDate();
$("#FactDateAdd").persianDatepicker({
    cellWidth: 32,
    cellHeight: 22,
    fontSize: 14,
    formatDate: "YYYY/0M/0D",
    startDate: p.now().addDay(0).toString("YYYY/MM/DD"),
    endDate: "1440/05/05",
});

$("#NameEdit").on("keyup",function(e){
    if(((e.keyCode>=65 && e.keyCode<=90)|| (e.key).match(/[آ-ی]/)) || ((e.keyCode>=48 && e.keyCode<=57) || (e.keyCode>=96 && e.keyCode<=105))){
        setActiveTable("foundCusotmerForFactorBodyEdit");
        if (!($('.modal.in').length)) {
            $('.modal-dialog').css({
                top: 0,
                left: 0
            });
        }
        $('.modal-dialog').draggable({
            handle: ".modal-header"
        });
        $("#customerForFactorModalEdit").modal("show");
        $("#customerNameForFactorEdit").val($('#NameEdit').val());
        $("#customerNameForFactorEdit").focus();
        $('#customerForFactorModalEdit').on('shown.bs.modal', function() {
            $(this).find('[autofocus]').focus();
        });
    }
});

$("#customerNameForFactorEdit").on("keyup", function (event){
    let name=$("#customerNameForFactorEdit").val();
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
                tableBody.append(`<tr onclick="selectCustomerForFactorEdit(${customer.PSN},this)">
                                                        <td> ${(i)} <input type="radio" value="${customer.PSN}" class="d-none"/> </td>
                                                        <td> ${customer.PCode} </td>
                                                        <td> ${customer.Name} </td>
                                                        <td> ${customer.countBuy} </td>
                                                        <td> ${customer.countSale} </td>
                                                        <td> ${customer.chequeCountReturn} </td>
                                                        <td> ${customer.chequeMoneyReturn} </td>
                                                    </tr>`);
            }else{
                tableBody.append(`<tr onclick="selectCustomerForFactorEdit(${customer.PSN},this)">
                    <td> ${(i)}  <input type="radio" value="${customer.PSN}" class="d-none"/></td>
                    <td> ${customer.PCode} </td>
                    <td> ${customer.Name} </td>
                    <td> ${customer.countBuy} </td>
                    <td> ${customer.countSale} </td>
                    <td> ${customer.chequeCountReturn} </td>
                    <td> ${customer.chequeMoneyReturn} </td>
                </tr>`);
                $("#foundCusotmerForOrderBody tr").eq(0).css("background-color", "rgb(0,142,201)"); 
                const selectedPSN = data[0].PSN;
                selectCustomerForFactorEdit(selectedPSN,0)
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

function selectCustomerForFactorEdit(psn,element){

    if(isNaN(element)){
        $("tr").removeClass('selected');
        $("#foundCusotmerForFactorBodyEdit tr").css('background-color', '');
        $(element).addClass("selected")
    }else{
        $("tr").removeClass('selected');
    }
    $("#searchCustomerSabtBtnEdit").prop("disabled",false);
    $("#searchCustomerSabtBtnEdit").val(psn);
}

function chooseCustomerForFactorEdit(psn){
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
    $("#customerForFactorModalEdit").modal("hide");
}

$("#searchCustomerCancelFBtn").on("click",()=>{
    localStorage.setItem("scrollTop",0);
    $("#customerForSefarishModalEdit").modal("hide");
});

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

$("#addFactorBtn").on("click",function(e){
    // makeTableColumnsResizable("addFactorTable");
    setActiveFormFactor("factorAddListBody")
    $("#addFactorModal").modal("show");
})
$("#deleteFactorBtn").on("click",function(e){
    swal({
        title:"می خواهید حذف کنید؟",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    }).then((willDelete)=>{
        if(willDelete){
            $.get(baseUrl+"/deleteFactor",{FactSn:$(this).val(),function(respond,status){
                $("tr.selected").remove();
            }})
        }
    })
})

$("#NameAdd").on("keyup",function(e){
    if(((e.keyCode>=65 && e.keyCode<=90)|| (e.key).match(/[آ-ی]/)) || ((e.keyCode>=48 && e.keyCode<=57) || (e.keyCode>=96 && e.keyCode<=105))){
        setActiveTable("foundCusotmerForFactorBody");
        if (!($('.modal.in').length)) {
            $('.modal-dialog').css({
                top: 0,
                left: 0
            });
        }
        $('.modal-dialog').draggable({
            handle: ".modal-header"
        });
        $("#customerForFactorModal").modal("show");
        $("#customerNameForFactor").val($('#NameAdd').val());
        $("#customerNameForFactor").focus();
        $('#customerForFactorModal').on('shown.bs.modal', function() {
            $(this).find('[autofocus]').focus();
        });
    }
});



$("#customerNameForFactor").on("keyup", function (event){
    let name=$("#customerNameForFactor").val();
    if(event.keyCode!=40){
        if(event.keyCode!=13){
    let searchByPhone="";
    if($("#searchByPhoneNumberCheckBox").is(":checked")){
        searchByPhone="on";
    }else{
        searchByPhone="";
    }
    $.get("/getCustomerForOrder",{namePhone:name,searchByPhone:searchByPhone},(data,status)=>{
        localStorage.setItem("scrollTop",0);
        $("#foundCusotmerForFactorBody").empty();
        let tableBody=$("#foundCusotmerForFactorBody");
        let i=0;
        for (let customer of data){
            i++;
            if(i!=1){
                tableBody.append(`<tr onClick="selectCustomerForFactor(${customer.PSN},this)">
                                                        <td> ${(i)} <input type="radio" value="${customer.PSN}" class="d-none"/></td>
                                                        <td> ${customer.PCode} </td>
                                                        <td> ${customer.Name} </td>
                                                        <td> ${customer.PhoneStr} </td>
                                                        <td> ${customer.countBuy} </td>
                                                        <td> ${customer.countSale} </td>
                                                        <td> ${customer.chequeCountReturn} </td>
                                                        <td> ${customer.chequeMoneyReturn} </td>
                                                    </tr>`);
            }else{
                tableBody.append(`<tr onClick="selectCustomerForFactor(${customer.PSN},this)">
                    <td> ${(i)} <input type="radio" value="${customer.PSN}" class="d-none"/></td>
                    <td> ${customer.PCode} </td>
                    <td> ${customer.Name} </td>
                    <td> ${customer.PhoneStr} </td>
                    <td> ${customer.countBuy} </td>
                    <td> ${customer.countSale} </td>
                    <td> ${customer.chequeCountReturn} </td>
                    <td> ${customer.chequeMoneyReturn} </td>
                </tr>`);
                $("#foundCusotmerForFactorBody tr").eq(0).css("background-color", "rgb(0,142,201)"); 
                
                selectCustomerForFactor(customer.PSN,0)
            }
        }
    })  
    }else{
        $("#searchCustomerSabtBtn").trigger("click");
        localStorage.setItem("scrollTop",0);
    }
}else{
    $(this).blur();
    $("#foundCusotmerForFactorTble").focus();
    localStorage.setItem("scrollTop",0);
} 
});


$("#customerNameForFactorEdit").on("keyup", function (event){
    let name=$("#customerNameForFactorEdit").val();
    if(event.keyCode!=40){
        if(event.keyCode!=13){
    let searchByPhone="";
    if($("#searchByPhoneNumberCheckBoxEdit").is(":checked")){
        searchByPhone="on";
    }else{
        searchByPhone="";
    }
    $.get("/getCustomerForOrder",{namePhone:name,searchByPhone:searchByPhone},(data,status)=>{
        localStorage.setItem("scrollTop",0);
        $("#foundCusotmerForFactorBodyEdit").empty();
        let tableBody=$("#foundCusotmerForFactorBodyEdit");
        let i=0;
        for (let customer of data){
            i++;
            if(i!=1){
                tableBody.append(`<tr onClick="selectCustomerForFactor(${customer.PSN},this)">
                                                        <td> ${(i)} <input type="radio" value="${customer.PSN}" class="d-none"/></td>
                                                        <td> ${customer.PCode} </td>
                                                        <td> ${customer.Name} </td>
                                                        <td> ${customer.PhoneStr} </td>
                                                        <td> ${customer.countBuy} </td>
                                                        <td> ${customer.countSale} </td>
                                                        <td> ${customer.chequeCountReturn} </td>
                                                        <td> ${customer.chequeMoneyReturn} </td>
                                                    </tr>`);
            }else{
                tableBody.append(`<tr onClick="selectCustomerForFactor(${customer.PSN},this)">
                    <td> ${(i)}  <input type="radio" value="${customer.PSN}" class="d-none"/></td>
                    <td> ${customer.PCode} </td>
                    <td> ${customer.Name} </td>
                    <td> ${customer.PhoneStr} </td>
                    <td> ${customer.countBuy} </td>
                    <td> ${customer.countSale} </td>
                    <td> ${customer.chequeCountReturn} </td>
                    <td> ${customer.chequeMoneyReturn} </td>
                </tr>`);
                $("#foundCusotmerForFactorBodyEdit tr").eq(0).css("background-color", "rgb(0,142,201)"); 
                selectCustomerForFactorEdit(customer.PSN,0)
            }
        }
    })  
    }else{
        $("#searchCustomerSabtBtnEdit").trigger("click");
        localStorage.setItem("scrollTop",0);
    }
}else{
    $(this).blur();
    $("#foundCusotmerForFactorTbleEdit").focus();
    localStorage.setItem("scrollTop",0);
} 
});

function chooseCustomerForFactorAdd(psn){
    $.get("/getInfoOfOrderCustomer",{psn:psn},(respond,status)=>{
        if(localStorage.getItem("editCustomerName")!=1){
            $("#customerForFactorAdd").append(`<option selected value="${respond[0].PSN}"> ${respond[0].Name} </option>`);
            $("#customerForFactorAdd").trigger("change");
            $("#NameAdd").val(respond[0].Name);
            $("#pCodeAdd").val(respond[0].PCode);
            $("#lastCustomerStatus").text(parseInt(respond[0].TotalPrice)||0);
        }else{
            $("#customerForFactorAdd").append(`<option selected value="${respond[0].PSN}"> ${respond[0].Name} </option>`);
            $("#customerForFactorAdd").trigger("change");
            $("#NameAdd").val(respond[0].Name);
            $("#pCodeAdd").val(respond[0].PCode);
            localStorage.setItem("editCustomerName",0);
        }
    });
    $("#customerForFactorModal").modal("hide");
}

$("#TahvilTypeAdd").on("change",function(e){
    if($("#TahvilTypeAdd").val() == "ersal"){
        $("#sendTimeDivAdd").css({"display":"inline"});
        $("#factorAddressDivAdd").css({"display":"inline"});
    }else{
        $("#sendTimeDivAdd").css("display","none");
        $("#factorAddressDivAdd").css("display","none");
    }
});

$("#customerForFactorAdd").on("change",function(){
    $.get(baseUrl+"/getCustomerByID",{PSN:$(this).val()},function(data,status){
        $("#factorAddressAdd").empty();
        let addressOptions=data.map(element=>{
            if(element.AddressPeopel){
                return `<option value="`+element.AddressPeopel+`_`+element.SnPeopelAddress+`">`+element.AddressPeopel+`</option>`
                }else{
                    return `<option value="`+element.peopeladdress+`_0">`+element.peopeladdress+`</option>`   
                }
        })
        $("#factorAddressAdd").append(addressOptions);
    })
})
$("#MotafariqahNameAdd").on("keyup",function(e){
    if($("#MotafariqahNameAdd").val().length>0){
        $("#motafariqahfactorAddressDivAdd").css({"display":"block"});
        $("#mobileNumberDivAdd").css({"display":"block"});
    }else{
        $("#motafariqahfactorAddressDivAdd").css({"display":"none"});        
        $("#mobileNumberDivAdd").css({"display":"none"});        
    }
})

$("#selectKalaToAddFactorBtn").on("click",function(){
    var rowCount = $("#factorAddListBody tr").length;
    for(let i=1;i<=rowCount;i++){
        let rowGoodSn= $('#factorAddListBody tr:nth-child('+i+')').find('input:checkbox').val();
        if(rowGoodSn==$(this).val()){
            swal({title:"قبلا اضافه شده است",
            text:"کالای انتخاب شده قبلا اضافه شده است",
            icon:"warning",
            buttons:true});
            return
        }
    }
    
   
$.get(baseUrl+"/searchKalaByID",{goodSn:$(this).val()},function(data,status){
    if(status=="success"){
        let row=data.map((element,index)=> `
                <tr onclick="checkAddedKalaAmountOfFactorItem(this)">
                    <td class="addFactorTd-1"> ${index+1}</td>
                    <td class="addFactorTd-2"> <input type="text" name="GoodCde${element.GoodSn}" value="${element.GoodCde}" class="td-input td-inputCodeAdd form-control" required> <input type="radio" value="`+element.AmountUnit+`" class="td-input form-control"> <input type="checkbox" name="addableGoods[]" checked style="display:none" value="${element.GoodSn}"/> </td>
                    <td class="addFactorTd-3"> <input type="text" name="NameGood${element.GoodSn}" value="${element.GoodName}" class="td-input td-inputCodeNameAdd form-control" required> </td>
                    <td class="addFactorTd-4"> <input type="text" name="FirstUnit${element.GoodSn}" value="${element.firstUnit}" class="td-input td-inputFirstUnitAdd form-control" required> </td>
                    <td class="addFactorTd-5"> <input type="text" name="SecondUnit${element.GoodSn}" value="${element.secondUnit}" class="td-input td-inputSecondUnitAdd form-control" required> </td>
                    <td class="addFactorTd-6"> <input type="text" name="PackAmnt${element.GoodSn}" value="" class="td-input  td-inputSecondUnitAmountAdd form-control" required> </td>
                    <td class="addFactorTd-7"> <input type="text" name="JozeAmountEdit${element.GoodSn}" value="" class="td-input td-inputJozeAmountAdd form-control" required> </td>
                    <td class="addFactorTd-8"> <input type="text" name="FirstAmount${element.GoodSn}" value="" class="td-input td-inputFirstAmountAdd form-control" required> </td>
                    <td class="addFactorTd-9"> <input type="text" name="ReAmount${element.GoodSn}" value="" class="td-input td-inputReAmountAdd form-control" required> </td>
                    <td class="addFactorTd-10"> <input type="text" name="Amount${element.GoodSn}" value="" class="td-input  td-AllAmountAdd form-control" required> </td>
                    <td class="addFactorTd-11"> <input type="text" name="Fi${element.GoodSn}" value="${parseInt(element.Price3).toLocaleString("en-us")}" class="td-input td-inputFirstUnitPriceAdd form-control" required> </td>
                    <td class="addFactorTd-12"> <input type="text" name="FiPack${element.GoodSn}" value="" class="td-input td-inputSecondUnitPriceAdd form-control" required> </td>
                    <td class="addFactorTd-13"> <input type="text" name="Price${element.GoodSn}" value="" class="td-input td-inputAllPriceAdd form-control" required> </td>
                    <td class="addFactorTd-14"> <input type="text" name="PriceAfterTakhfif${element.GoodSn}" value="" class="td-input td-inputAllPriceAfterTakhfifAdd  form-control" required> </td>
                    <td class="addFactorTd-15"> <input type="text" name="" value="0" class="td-input td-inputFactorNumAdd form-control" required> </td>
                    <td class="addFactorTd-16"> <input type="text" name="" value="0" class="td-input td-inputFactorDateAdd form-control" required> </td>
                    <td class="addFactorTd-17"> <input type="text" name="" value="0" class="td-input td-inputFactorDescAdd form-control" required> </td>
                    <td class="addFactorTd-18"> <input type="text" name="NameStock${element.GoodSn}" value="0" class="td-input td-inputStockAdd form-control" required> </td>
                    <td class="addFactorTd-19"> <input type="text" name="Price3PercentMaliat${element.GoodSn}" value="0" class="td-input td-inputMaliatAdd form-control" required> </td>
                    <td class="addFactorTd-20"> <input type="text" name="Fi2Weight${element.GoodSn}" value="0" class="td-input td-inputWeightUnitAdd form-control" required> </td>
                    <td class="addFactorTd-21"> <input type="text" name="Amount2Weight${element.GoodSn}" value="0" class="td-input td-inputAllWeightAdd form-control" required> </td>
                    <td class="addFactorTd-22"> <input type="text" name="Service${element.GoodSn}" value="0" class="td-input  td-inputInserviceAdd form-control" required> </td>
                    <td class="addFactorTd-23"> <input type="text" name="PercentMaliat${element.GoodSn}" value="0" class="td-input  td-inputPercentMaliatAdd form-control" required> </td>
                    <td class="addFactorTd-24 d-none"> 
                        <input type="text" value="`+element.lastBuyFi+`" class="td-input form-control">
                    </td>
                </tr>
                `);
                            
        $(`#factorAddListBody tr:nth-child(`+$("#factorRowTaker").val()+`)`).replaceWith(row);
        $(`#factorAddListBody tr:nth-child(`+$("#factorRowTaker").val()+`) td:nth-child(6) input`).focus();
        $(`#factorAddListBody tr:nth-child(`+$("#factorRowTaker").val()+`) td:nth-child(6) input`).select();
        checkAddedKalaAmountOfFactorAdd(data[0].GoodSn);
        }
        makeTableColumnsResizable("addFactorTable");
    });

    $("#searchGoodsModalAddFactor").modal("hide");
});
function checkAddedKalaAmountOfFactorAdd(goodSn){

        if(!goodSn){
            return
        }
    
        let customerSn=$("#customerForFactorAdd").val();

            $.get(baseUrl+"/getGoodInfoForAddOrderItem",{
                goodSn: goodSn,
                customerSn:customerSn,
                stockId: 23
            },(respond,status)=>{
                if(respond[1][0]){
                    if(!isNaN(respond[1][0].Amount)){
                        let amount=0;
                        if(respond[1][0].Amount<1){
                            amount=0;
                        }else{
                            amount=respond[1][0].Amount;
                        }
                        $("#AddedToFactorExistInStock").text(parseInt(amount).toLocaleString("en-us"));
    
                    }else{
                        $("#AddedToFactorExistInStock").text(0);
    
                    }
    
                }else{
                    $("#AddedToFactorExistInStock").text(0);
    
                }
    
                if(respond[2][0]){
                    if(!isNaN(respond[2][0].Price3)){
                        let price=0;
                        if(respond[2][0].Price3<1){
                            price=0;
                        }else{
                            price=respond[2][0].Price3;
                        }
                        $("#AddedToFactorPrice").text(parseInt(price).toLocaleString("en-us"));
                    }else{
                        $("#AddedToFactorPrice").text(0);
                    }
                }else{
                    $("#AddedToFactorPrice").text(0);
                }
                if(respond[4][0]){
                    if(!isNaN(respond[4][0].Fi)){
                        $("#AddedToFactorLastPrice").text(parseInt(respond[4][0].Fi).toLocaleString("en-us"));
                    }else{
                        $("#AddedToFactorLastPrice").text(0);
                    }
                }else{
                    $("#AddedToFactorLastPrice").text(0);
                }
    
                if(respond[3][0]){
                    if(!isNaN(respond[3][0].Price3)){
                        let price=0;
                        if(respond[3][0].Price3<1){
                            price=0;
                        }else{
                            price=respond[3][0].Price3;
                        }
                        $("#AddedToFactorLastPriceCustomer").text(parseInt(price).toLocaleString("en-us"));
                    }else{
                        $("#AddedToFactorLastPriceCustomer").text(0);
                    }
                }else{
                    $("#AddedToFactorLastPriceCustomer").text(0);
                }
                
    
            })
        const previouslySelectedRow = document.querySelector('.selected');
        if(previouslySelectedRow) {
            previouslySelectedRow.classList.remove('selected');
            //previouslySelectedRow.children().classList.remove('selected');
        }
}


$(document).on("keyup",".td-inputCodeAdd",function(e){
    $("#rowTaker").val($(e.target).parents("tr").index()+1)
    if((e.keyCode>=65 && e.keyCode<=90) || ((e.keyCode>=48 && e.keyCode<=57) || (e.keyCode>=96 && e.keyCode<=105))){
        setActiveTable("kalaForAddToFactor");
        checkNumberInput(e);
        $("#factorRowTaker").val($(e.target).parents("tr").index()+1)
        if (!($('.modal.in').length)) {
            $('.modal-dialog').css({
                top: 0,
                left: 0
            });
        }
        $('#searchGoodsModalAddFactor').modal({
            backdrop: false,
            show: true
        });

        $('.modal-dialog').draggable({
            handle: ".modal-header"
        });
        $("#searchKalaForAddToFactorByName").val("");
        $("#searchForAddToFactorItemLabel").text("کد کالا")
        $("#searchKalaForAddToFactorByName").val("");
        $("#searchKalaForAddToFactorByCode").val($(e.target).val());
        $("#searchKalaForAddToFactorByCode").show();
        $("#searchKalaForAddToFactorByName").hide();
        $("#searchGoodsModalAddFactor").modal("show");
        $('#searchGoodsModalAddFactor').on('shown.bs.modal', function() {
        $("#searchKalaForAddToFactorByCode").focus();
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
$(document).on("keyup",".td-inputCodeNameAdd",function(e){
    $("#rowTaker").val($(e.target).parents("tr").index()+1)
    if((e.keyCode>=65 && e.keyCode<=90) || ((e.keyCode>=48 && e.keyCode<=57) || (e.keyCode>=96 && e.keyCode<=105))){
        setActiveTable("kalaForAddToFactor");
        $("#factorRowTaker").val($(e.target).parents("tr").index()+1)
        if (!($('.modal.in').length)) {
            $('.modal-dialog').css({
                top: 0,
                left: 0
            });
        }
        $('#searchGoodsModalAddFactor').modal({
            backdrop: false,
            show: true
        });

        $('.modal-dialog').draggable({
            handle: ".modal-header"
        });
        $("#searchKalaForAddToFactorByName").val();
        $("#searchForAddToFactorItemLabel").text("نام کالا")
        $("#searchKalaForAddToFactorByName").val("");
        $("#searchKalaForAddToFactorByName").val($(e.target).val());
        $("#searchKalaForAddToFactorByCode").hide();
        $("#searchKalaForAddToFactorByName").show();
        $("#searchGoodsModalAddFactor").modal("show");
        $('#searchGoodsModalAddFactor').on('shown.bs.modal', function() {
        $("#searchKalaForAddToFactorByName").focus();
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
$(document).on("keyup",".td-inputFirstUnitAdd",function(e){
    if(e.keyCode ==13 || e.keyCode ==9){
        var currentInput = $(e.target);
        var nextInput = currentInput.closest('td').next('td').find('input');
        if (nextInput.length > 0) {
            nextInput.focus();
        }
    }
})
$(document).on("keyup",".td-inputSecondUnitAdd",function(e){
    if(e.keyCode ==13 || e.keyCode ==9){
        var $currentInput = $(e.target);
        var $nextInput = $currentInput.closest('td').next('td').find('input');
        if ($nextInput.length > 0) {
            $nextInput.focus();
        }
    }
})
$(document).on("keyup",".td-inputSecondUnitAmountAdd",function(e){

    // نوعیت اعداد چک شود و محاسبات انجام شود
    checkNumberInput(e)
    
    let subPackUnitAmount=0;
    if(($('#factorAddListBody tr:nth-child('+$('#factorAddListBody tr').length+') td:nth-child(2)').children('input').val().length)<1){
        $(`#factorAddListBody tr:nth-child(`+$('#factorAddListBody tr').length+`)`).replaceWith('');
    }
    let rowindex=$(e.target).parents("tr").index()+1
    let packAmount=$(e.target).val().replace(/,/g, '')
    let subPackUnits=parseInt($('#factorAddListBody tr:nth-child('+rowindex+') td:nth-child(7)').children('input').val().replace(/,/g, ''));
    let GoodSn=parseInt($('#factorAddListBody tr:nth-child('+rowindex+') td:nth-child(2)').find('input:checkbox').val());
    let amountUnit=$($('#factorAddListBody tr:nth-child('+rowindex+') td:nth-child(2)').find('input:radio')).val().replace(/,/g, '');
    let price=$($('#factorAddListBody tr:nth-child('+rowindex+') td:nth-child(11)').children('input')).val().replace(/,/g, '');
    if(!isNaN(subPackUnits)){
        subPackUnitAmount=subPackUnits;
    }
    
    let allAmountUnit=(packAmount*amountUnit)+subPackUnitAmount;
    if( allAmountUnit > parseInt($("#AddedToFactorExistInStock").text().replace(/,/g,'')) ){
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
                    $('#factorAddListBody tr:nth-child('+rowindex+') td:nth-child(8)').children('input').val(parseInt(allAmountUnit).toLocaleString("en-us"));
                    $('#factorAddListBody tr:nth-child('+rowindex+') td:nth-child(11)').children('input').val(parseInt(allPrice).toLocaleString("en-us"));
                    $('#factorAddListBody tr:nth-child('+rowindex+') td:nth-child(10)').children('input').val(parseInt(packPrice).toLocaleString("en-us"));
                    $('#factorAddListBody tr:nth-child('+rowindex+') td:nth-child(7)').children('input').val(0);
                    $('#factorAddListBody tr:nth-child('+rowindex+') td:nth-child(8)').children('input').val(0);
                    $('#factorAddListBody tr:nth-child('+rowindex+') td:nth-child(9)').children('input').val(0);
                    $('#factorAddListBody tr:nth-child('+rowindex+') td:nth-child(14) input[type="checkbox"]').val(GoodSn+'_'+packAmount+'_'+allAmountUnit+'_'+allPrice+'_'+packPrice+'_'+price);
                    var $currentInput = $(e.target);
                    var $currentTd = $currentInput.closest('td');
                    var $nextTd = $currentTd.next('td');
                    var $nextInput = $nextTd.find('input');
                        $($nextInput).focus();
                }else{
                    var $currentInput = $(e.target);
                    $($currentInput).focus();
                    $('#factorAddListBody tr:nth-child('+rowindex+') td:nth-child(7)').children('input').val(0);
                    $('#factorAddListBody tr:nth-child('+rowindex+') td:nth-child(8)').children('input').val(0);
                    $('#factorAddListBody tr:nth-child('+rowindex+') td:nth-child(9)').children('input').val(0);
                }
            })
    }else{
        let allPrice=allAmountUnit*price;
        let packPrice=amountUnit*price;
        $('#factorAddListBody tr:nth-child('+rowindex+') td:nth-child(10)').children('input').val(parseInt(allAmountUnit).toLocaleString("en-us"));
        $('#factorAddListBody tr:nth-child('+rowindex+') td:nth-child(13)').children('input').val(parseInt(allPrice).toLocaleString("en-us"));
        $('#factorAddListBody tr:nth-child('+rowindex+') td:nth-child(14)').children('input').val(parseInt(allPrice).toLocaleString("en-us"));
        $('#factorAddListBody tr:nth-child('+rowindex+') td:nth-child(12)').children('input').val(parseInt(packPrice).toLocaleString("en-us"));
        $('#factorAddListBody tr:nth-child('+rowindex+') td:nth-child(7)').children('input').val(0);
        $('#factorAddListBody tr:nth-child('+rowindex+') td:nth-child(8)').children('input').val(0);
        $('#factorAddListBody tr:nth-child('+rowindex+') td:nth-child(9)').children('input').val(0);
        //$('#factorAddListBody tr:nth-child('+rowindex+') td:nth-child(14) input[type="checkbox"]').val(GoodSn+'_'+packAmount+'_'+allAmountUnit+'_'+allPrice+'_'+packPrice+'_'+price);
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
$(document).on("keyup",".td-inputJozeAmountAdd",function(e){
    checkNumberInput(e);
    if(($('#factorAddListBody tr:nth-child('+$('#factorAddListBody tr').length+') td:nth-child(2)').children('input').val().replace(/,/g, '').length)<1){
        $(`#factorAddListBody tr:nth-child(`+$('#factorAddListBody tr').length+`)`).replaceWith('');
    }
    let rowindex=$(e.target).parents("tr").index()+1
    let packAmount=parseInt($('#factorAddListBody tr:nth-child('+rowindex+') td:nth-child(6)').children('input').val().replace(/,/g, ''));
    let subPackUnits=parseInt($(e.target).val().replace(/,/g, ''))
    let amountUnit=$($('#factorAddListBody tr:nth-child('+rowindex+') td:nth-child(2)').find('input:radio')).val().replace(/,/g, '');
    let price=$($('#factorAddListBody tr:nth-child('+rowindex+') td:nth-child(11)').children('input')).val().replace(/,/g, '');

    let allAmountUnit=0;
    if(packAmount>0){
        allAmountUnit=(packAmount*amountUnit)+subPackUnits;
    }else{
        allAmountUnit=subPackUnits;
    }
    packAmount=parseInt(allAmountUnit/amountUnit);
    subPackUnits=allAmountUnit%amountUnit;
    let allPrice=allAmountUnit*price;
    $('#factorAddListBody tr:nth-child('+rowindex+') td:nth-child(10)').children('input').val(parseInt(allAmountUnit).toLocaleString("en-us"));
    $('#factorAddListBody tr:nth-child('+rowindex+') td:nth-child(13)').children('input').val(parseInt(allPrice).toLocaleString("en-us"));
    $('#factorAddListBody tr:nth-child('+rowindex+') td:nth-child(6)').children('input').val(packAmount)
    $(e.target).val(subPackUnits)
    if(e.keyCode ==13 || e.keyCode ==9){
        var $currentInput = $(e.target);
        var $nextInput = $currentInput.closest('td').next('td').find('input');
        if ($nextInput.length > 0) {
            $nextInput.focus();
        }
    }
})
$(document).on("keyup",".td-inputFirstAmountAdd",function(e){
    if(e.keyCode ==13 || e.keyCode ==9){
        var $currentInput = $(e.target);
        var $nextInput = $currentInput.closest('td').next('td').find('input');
        if ($nextInput.length > 0) {
            $nextInput.focus();
        }
    }
})
$(document).on("keyup",".td-inputReAmountAdd",function(e){
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

        let price=$($('#factorAddListBody tr:nth-child('+rowindex+') td:nth-child(11)').children('input')).val().replace(/,/g, '');
        let amountUnit=$($('#factorAddListBody tr:nth-child('+rowindex+') td:nth-child(2)').find('input:radio')).val().replace(/,/g, '');
        allAmountSabit=$($('#factorAddListBody tr:nth-child('+rowindex+') td:nth-child(1)').find('input:radio')).val().replace(/,/g, '');
        reAmount=parseInt($(e.target).val().replace(/,/g, ''));
        firstAmount=$($('#factorAddListBody tr:nth-child('+rowindex+') td:nth-child(8)').children('input')).val().replace(/,/g, '');
        allAmount=$($('#factorAddListBody tr:nth-child('+rowindex+') td:nth-child(10)').children('input')).val().replace(/,/g, '');
        
        
        jozeAmount=$($('#factorAddListBody tr:nth-child('+rowindex+') td:nth-child(7)').children('input')).val().replace(/,/g, '');
        packAmount=$($('#factorAddListBody tr:nth-child('+rowindex+') td:nth-child(6)').children('input')).val().replace(/,/g, '');
        newAllAmount=allAmountSabit-reAmount;
        firstAmount=allAmountSabit;
        packAmount=parseInt(newAllAmount/amountUnit);
        jozeAmount=parseInt(newAllAmount%amountUnit);

        allPrice=newAllAmount*price;



        $($('#factorAddListBody tr:nth-child('+rowindex+') td:nth-child(8)').children('input')).val(parseInt(firstAmount).toLocaleString("en-us"));
        $($('#factorAddListBody tr:nth-child('+rowindex+') td:nth-child(10)').children('input')).val(parseInt(newAllAmount).toLocaleString("en-us"));
        $($('#factorAddListBody tr:nth-child('+rowindex+') td:nth-child(7)').children('input')).val(parseInt(jozeAmount).toLocaleString("en-us"));
        $('#factorAddListBody tr:nth-child('+rowindex+') td:nth-child(13)').children('input').val(parseInt(allPrice).toLocaleString("en-us"));
        $($('#factorAddListBody tr:nth-child('+rowindex+') td:nth-child(6)').children('input')).val(parseInt(packAmount).toLocaleString("en-us"));
    }
    if(e.keyCode ==13 || e.keyCode ==9){
        var $currentInput = $(e.target);
        var $nextInput = $currentInput.closest('td').next('td').find('input');
        if ($nextInput.length > 0) {
            $nextInput.focus();
        }
    }
    

})
$(document).on("keyup",".td-AllAmountAdd",function(e){
    let rowindex=$(e.target).parents("tr").index()+1
    if((e.keyCode>=65 && e.keyCode<=90)|| ((e.keyCode>=48 && e.keyCode<=57) || (e.keyCode>=96 && e.keyCode<=105))){
        checkNumberInput(e);

        let subPackUnits=parseInt($('#factorAddListBody tr:nth-child('+rowindex+') td:nth-child(7)').children('input').val().replace(/,/g, ''));
        let amountUnit=$($('#factorAddListBody tr:nth-child('+rowindex+') td:nth-child(2)').find('input:radio')).val().replace(/,/g, '');
        let price=$($('#factorAddListBody tr:nth-child('+rowindex+') td:nth-child(11)').children('input')).val().replace(/,/g, '');

        let allAmountUnit=parseInt($(e.target).val().replace(/,/g, ''));
        let packAmount=parseInt(allAmountUnit/amountUnit);
        subPackUnits=parseInt(allAmountUnit%amountUnit);
        let allPrice=allAmountUnit*price;
        let packPrice=amountUnit*price;
        $('#factorAddListBody tr:nth-child('+rowindex+') td:nth-child(10)').children('input').val(parseInt(allAmountUnit).toLocaleString("en-us"));
        $('#factorAddListBody tr:nth-child('+rowindex+') td:nth-child(13)').children('input').val(parseInt(allPrice).toLocaleString("en-us"));
        $('#factorAddListBody tr:nth-child('+rowindex+') td:nth-child(14)').children('input').val(parseInt(allPrice).toLocaleString("en-us"));
        $('#factorAddListBody tr:nth-child('+rowindex+') td:nth-child(12)').children('input').val(parseInt(packPrice).toLocaleString("en-us"));
        $('#factorAddListBody tr:nth-child('+rowindex+') td:nth-child(6)').children('input').val(parseInt(packAmount).toLocaleString("en-us"));
        $('#factorAddListBody tr:nth-child('+rowindex+') td:nth-child(7)').children('input').val(parseInt(subPackUnits).toLocaleString("en-us"));
    }
    if(e.keyCode==9 || e.keyCode==13){
        var $currentInput = $(e.target);
        var $nextInput = $currentInput.closest('td').next('td').find('input');
        if ($nextInput.length > 0) {
        $nextInput.focus();
        }
    }
})

$(document).on("keyup",".td-inputFirstUnitPriceAdd",function(e){
    let rowindex=$(e.target).parents("tr").index()+1
    if((e.keyCode>=65 && e.keyCode<=90)|| ((e.keyCode>=48 && e.keyCode<=57) || (e.keyCode>=96 && e.keyCode<=105))){

        if(($('#factorAddListBody tr:nth-child('+$('#factorAddListBody tr').length+') td:nth-child(2)').children('input').val().length)<1){
            $(`#factorAddListBody tr:nth-child(`+$('#factorAddListBody tr').length+`)`).replaceWith('');
        }
        
        let subPackUnits=parseInt($('#factorAddListBody tr:nth-child('+rowindex+') td:nth-child(7)').children('input').val().replace(/,/g, ''));
        let amountUnit=$($('#factorAddListBody tr:nth-child('+rowindex+') td:nth-child(2)').find('input:radio')).val().replace(/,/g, '');
        let price=parseInt($(e.target).val().replace(/,/g, ''));
        

        let allAmountUnit=$($('#factorAddListBody tr:nth-child('+rowindex+') td:nth-child(10)').children('input')).val().replace(/,/g, '');
        let packAmount=parseInt(allAmountUnit/amountUnit);
        subPackUnits=parseInt(allAmountUnit%amountUnit);
        let allPrice=allAmountUnit*price;
        let packPrice=amountUnit*price;
        $('#factorAddListBody tr:nth-child('+rowindex+') td:nth-child(10)').children('input').val(parseInt(allAmountUnit).toLocaleString("en-us"));
        $('#factorAddListBody tr:nth-child('+rowindex+') td:nth-child(13)').children('input').val(parseInt(allPrice).toLocaleString("en-us"));
        $('#factorAddListBody tr:nth-child('+rowindex+') td:nth-child(14)').children('input').val(parseInt(allPrice).toLocaleString("en-us"));
        $('#factorAddListBody tr:nth-child('+rowindex+') td:nth-child(12)').children('input').val(parseInt(packPrice).toLocaleString("en-us"));
        $('#factorAddListBody tr:nth-child('+rowindex+') td:nth-child(6)').children('input').val(parseInt(packAmount).toLocaleString("en-us"));
        $('#factorAddListBody tr:nth-child('+rowindex+') td:nth-child(7)').children('input').val(parseInt(subPackUnits).toLocaleString("en-us"));
        
    
}else{
    if(($('#factorAddListBody tr:nth-child('+$('#factorAddListBody tr').length+') td:nth-child(2)').children('input').val().length)<1){
        $(`#factorAddListBody tr:nth-child(`+$('#factorAddListBody tr').length+`)`).replaceWith('');
    }
    let subPackUnits=parseInt($('#factorAddListBody tr:nth-child('+rowindex+') td:nth-child(7)').children('input').val().replace(/,/g, ''));
    let amountUnit=$($('#factorAddListBody tr:nth-child('+rowindex+') td:nth-child(2)').find('input:radio')).val().replace(/,/g, '');
    let price=parseInt($(e.target).val().replace(/,/g, ''));
    

    let allAmountUnit=$($('#factorAddListBody tr:nth-child('+rowindex+') td:nth-child(10)').children('input')).val().replace(/,/g, '');
    let packAmount=parseInt(allAmountUnit/amountUnit);
    subPackUnits=parseInt(allAmountUnit%amountUnit);
    let allPrice=allAmountUnit*price;
    let packPrice=amountUnit*price;
    $('#factorAddListBody tr:nth-child('+rowindex+') td:nth-child(10)').children('input').val(parseInt(allAmountUnit).toLocaleString("en-us"));
    $('#factorAddListBody tr:nth-child('+rowindex+') td:nth-child(13)').children('input').val(parseInt(allPrice).toLocaleString("en-us"));
    $('#factorAddListBody tr:nth-child('+rowindex+') td:nth-child(14)').children('input').val(parseInt(allPrice).toLocaleString("en-us"));
    $('#factorAddListBody tr:nth-child('+rowindex+') td:nth-child(12)').children('input').val(parseInt(packPrice).toLocaleString("en-us"));
    $('#factorAddListBody tr:nth-child('+rowindex+') td:nth-child(6)').children('input').val(parseInt(packAmount).toLocaleString("en-us"));
    $('#factorAddListBody tr:nth-child('+rowindex+') td:nth-child(7)').children('input').val(parseInt(subPackUnits).toLocaleString("en-us"));
}
if(e.keyCode==9 || e.keyCode==13){
let lastBuyFi=parseInt($('#factorAddListBody tr:nth-child('+rowindex+') td:nth-child(24)').children('input').val().replace(/,/g, ''));

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
            }else{
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
})

$(document).on("keyup",".td-inputSecondUnitPriceAdd",function(e){
    if(e.keyCode ==13 || e.keyCode ==9){
        var $currentInput = $(e.target);
        var $nextInput = $currentInput.closest('td').next('td').find('input');
        if ($nextInput.length > 0) {
            $nextInput.focus();
        }
    }
})
$(document).on("keyup",".td-inputAllPriceAdd",function(e){
    checkNumberInput(e);
    let subPackUnitAmount=0;
    if(($('#factorAddListBody tr:nth-child('+$('#factorAddListBody tr').length+') td:nth-child(2)').children('input').val().length)<1){
        $(`#factorAddListBody tr:nth-child(`+$('#factorAddListBody tr').length+`)`).replaceWith('');
    }
    let rowindex=$(e.target).parents("tr").index()+1
    let packAmount=parseInt($('#factorAddListBody tr:nth-child('+rowindex+') td:nth-child(6)').children('input').val());
    if(!$(e.target).val()){
        $(e.target).val(0)
    }
    let allPrice=parseInt($(e.target).val().replace(/,/g, ''))
    let subPackUnits=parseInt($('#factorAddListBody tr:nth-child('+rowindex+') td:nth-child(7)').children('input').val());
    let amountUnit=$($('#factorAddListBody tr:nth-child('+rowindex+') td:nth-child(2)').find('input:radio')).val().replace(/,/g, '');
    let price=$($('#factorAddListBody tr:nth-child('+rowindex+') td:nth-child(11)').children('input')).val().replace(/,/g, '');
    if(!isNaN(subPackUnits)){
        subPackUnitAmount=subPackUnits;
    }
    let allAmountUnit=allPrice/price;
    packAmount=parseInt(allAmountUnit/amountUnit)
    subPackUnitAmount=allAmountUnit%amountUnit;
    let packPrice=amountUnit*price;
    $('#factorAddListBody tr:nth-child('+rowindex+') td:nth-child(7)').children('input').val(parseInt(subPackUnitAmount).toLocaleString("en-us"))
    $('#factorAddListBody tr:nth-child('+rowindex+') td:nth-child(6)').children('input').val(parseInt(packAmount).toLocaleString("en-us"))
    $('#factorAddListBody tr:nth-child('+rowindex+') td:nth-child(10)').children('input').val(parseInt(allAmountUnit).toLocaleString("en-us"));
    $('#factorAddListBody tr:nth-child('+rowindex+') td:nth-child(13)').children('input').val(parseInt(allPrice).toLocaleString("en-us"));
    $('#factorAddListBody tr:nth-child('+rowindex+') td:nth-child(14)').children('input').val(parseInt(allPrice).toLocaleString("en-us"));
    $('#factorAddListBody tr:nth-child('+rowindex+') td:nth-child(12)').children('input').val(parseInt(packPrice).toLocaleString("en-us"));
    
    if(e.keyCode ==13 || e.keyCode ==9){
        var $currentInput = $(e.target);
        var $nextInput = $currentInput.closest('td').next('td').find('input');
        if ($nextInput.length > 0) {
            $nextInput.focus();
        }
    }
})

$(document).on("keyup",".td-inputAllPriceAfterTakhfifAdd",function(e){
    if(e.keyCode ==13 || e.keyCode ==9){
        var $currentInput = $(e.target);
        var $nextInput = $currentInput.closest('td').next('td').find('input');
        if ($nextInput.length > 0) {
            $nextInput.focus();
        }
    }
})
$(document).on("keyup",".td-inputFactorNumAdd",function(e){
    if(e.keyCode ==13 || e.keyCode ==9){
        var $currentInput = $(e.target);
        var $nextInput = $currentInput.closest('td').next('td').find('input');
        if ($nextInput.length > 0) {
            $nextInput.focus();
        }
    }
})
$(document).on("keyup",".td-inputFactorDateAdd",function(e){
    if(e.keyCode ==13 || e.keyCode ==9){
        var $currentInput = $(e.target);
        var $nextInput = $currentInput.closest('td').next('td').find('input');
        if ($nextInput.length > 0) {
            $nextInput.focus();
        }
    }
})
$(document).on("keyup",".td-inputFactorDescAdd",function(e){
    if(e.keyCode ==13 || e.keyCode ==9){
        var $currentInput = $(e.target);
        var $nextInput = $currentInput.closest('td').next('td').find('input');
        if ($nextInput.length > 0) {
            $nextInput.focus();
        }
    }
})
$(document).on("keyup",".td-inputStockAdd",function(e){
    if(e.keyCode ==13 || e.keyCode ==9){
        var $currentInput = $(e.target);
        var $nextInput = $currentInput.closest('td').next('td').find('input');
        if ($nextInput.length > 0) {
            $nextInput.focus();
        }
    }
})
$(document).on("keyup",".td-inputMaliatAdd",function(e){
    if(e.keyCode ==13 || e.keyCode ==9){
        var $currentInput = $(e.target);
        var $nextInput = $currentInput.closest('td').next('td').find('input');
        if ($nextInput.length > 0) {
            $nextInput.focus();
        }
    }
})
$(document).on("keyup",".td-inputWeightUnitAdd",function(e){
    if(e.keyCode ==13 || e.keyCode ==9){
        var $currentInput = $(e.target);
        var $nextInput = $currentInput.closest('td').next('td').find('input');
        if ($nextInput.length > 0) {
            $nextInput.focus();
        }
    }
})
$(document).on("keyup",".td-inputAllWeightAdd",function(e){
    if(e.keyCode ==13 || e.keyCode ==9){
        var $currentInput = $(e.target);
        var $nextInput = $currentInput.closest('td').next('td').find('input');
        if ($nextInput.length > 0) {
            $nextInput.focus();
        }
    }
})
$(document).on("keyup",".td-inputInserviceAdd",function(e){
    if(e.keyCode ==13 || e.keyCode ==9){
        var $currentInput = $(e.target);
        var $nextInput = $currentInput.closest('td').next('td').find('input');
        if ($nextInput.length > 0) {
            $nextInput.focus();
        }
    }
})

function checkAddedKalaAmountOfFactorItem(row){
    $("#deleteFactorItemBtnAdd").val(row);
    let input = $(row).find('input:checkbox');
    let goodSn=$(input).val();
    
    $("#selectedGoodSn").val(goodSn);
    if(!goodSn){
        return
    }
    let customerSn=$("#customerForFactorAdd").val();
    
    $.get(baseUrl+"/getGoodInfoForAddOrderItem",{
        goodSn: goodSn,
        customerSn:customerSn,
        stockId: 23
    },(respond,status)=>{
        
        if(respond[1][0]){
            if(!isNaN(respond[1][0].Amount)){
                let amount=0
                if(respond[1][0].Amount>=1){
                    amount=respond[1][0].Amount
                }
                $("#AddedToFactorExistInStock").text(parseInt(amount).toLocaleString("en-us"));
            }else{
                $("#AddedToFactorExistInStock").text(0);
            }
        }else{
            $("#AddedToFactorExistInStock").text(0);
        }

        if(respond[2][0]){
            if(!isNaN(respond[2][0].Price3)){
                let price=0
                if(respond[2][0].Price3>=1){
                    price=respond[2][0].Price3
                }
                $("#AddedToFactorPrice").text(parseInt(price)).toLocaleString("en-us");
            }else{
                $("#AddedToFactorPrice").text(0);
            }
        }else{
            $("#AddedToFactorPrice").text(0);
        }
        if(respond[4][0]){
            if(!isNaN(respond[4][0].Fi)){
                let fi=0
                if(respond[4][0].Fi>=1){
                    fi=respond[4][0].Fi
                }
                $("#AddedToFactorLastPriceCustomer").text(parseInt(respond[4][0].Fi).toLocaleString("en-us"));
            }else{
                $("#AddedToFactorLastPriceCustomer").text(0);
            }
        }else{
            $("#AddedToFactorLastPriceCustomer").text(0);
        }

        if(respond[3][0]){
            if(!isNaN(respond[3][0].Fi)){
                let fi=0
                if(respond[3][0].Fi>=1){
                    fi=respond[3][0].Fi
                }
                $("#AddedToFactorLastPrice").text(parseInt(respond[3][0].Fi).toLocaleString("en-us"));
            }else{
                $("#AddedToFactorLastPrice").text(0);
            }
        }else{
            $("#AddedToFactorLastPrice").text(0);
        }
        
    });
    let rowindex=$(row).index()+1
    let countRow = $("#factorAddListBody tr").length-1;;
    let totalMoneyTillRow=0;

    for (let index = 1; index <=rowindex; index++) {

        totalMoneyTillRow+=parseInt($('#factorAddListBody tr:nth-child('+index+') td:nth-child(14)').children('input').val().replace(/,/g, ''));
    
    }
    $("#allMoneyTillThisRowAdd").text(parseInt(totalMoneyTillRow).toLocaleString("en-us"));

    let totalMoneyTillEndRow=0;

    for (let index = 1; index <=countRow; index++) {

        totalMoneyTillEndRow+=parseInt($('#factorAddListBody tr:nth-child('+index+') td:nth-child(14)').children('input').val().replace(/,/g, ''));

    }

$("#allMoneyTillEndRowAdd").text(parseInt(totalMoneyTillEndRow).toLocaleString("en-us"));
    const previouslySelectedRow = document.querySelector('.selected');
    if(previouslySelectedRow) {
        previouslySelectedRow.classList.remove('selected');
        //previouslySelectedRow.children().classList.remove('selected');
    }
    row.classList.add('selected');
}
$(document).on("keyup",".td-inputPercentMaliatAdd",function(e){
    let goodSn=$('#factorAddListBody tr:nth-child('+($(e.target).parents("tr").index()+1)+') td:nth-child(2)').children('input').val().length
    if((e.keyCode === 9 ||e.keyCode === 13)  && (($(e.target).parents("tr").index()+1)==$("#factorAddListBody tr").length) && goodSn>0){
        checkNumberInput(e);
        let row=`<tr class="factorTablRow" onclick="checkAddedKalaAmountOfFactorItem(this)">
        <td class="addFactorTd-1"> </td>
        <td class="addFactorTd-2"> <input type="text" value="" class="td-input td-inputCodeAdd form-control"> <input type="radio" style="display:none" value=""/> </td>
        <td class="addFactorTd-3"> <input type="text" value="" class="td-input td-inputCodeNameAdd form-control"> </td>
        <td class="addFactorTd-4"> <input type="text" value="" class="td-input td-inputFirstUnitAdd form-control"> </td>
        <td class="addFactorTd-5"> <input type="text" value="" class="td-input td-inputSecondUnitAdd form-control"> </td>
        <td class="addFactorTd-6"> <input type="text" value="" class="td-input td-inputSecondUnitAmountAdd form-control"> </td>
        <td class="addFactorTd-7"> <input type="text" value="" class="td-input td-inputJozeAmountAdd form-control"> </td>
        <td class="addFactorTd-8"> <input type="text" value="" class="td-input td-inputFirstAmountAdd form-control"> </td>
        <td class="addFactorTd-9"> <input type="text" value="" class="td-input td-inputReAmountAdd form-control"> </td>
        <td class="addFactorTd-10"> <input type="text" value="" class="td-input td-AllAmountAdd form-control"> </td>
        <td class="addFactorTd-11"> <input type="text" value="" class="td-input td-inputFirstUnitPriceAdd form-control"> </td>
        <td class="addFactorTd-12"> <input type="text" value="" class="td-input td-inputSecondUnitPriceAdd form-control"> </td>
        <td class="addFactorTd-13"> <input type="text" value="" class="td-input td-inputAllPriceAdd form-control"> </td>
        <td class="addFactorTd-14"> <input type="text" value="" class="td-input td-inputAllPriceAfterTakhfifAdd  form-control"> </td>
        <td class="addFactorTd-15"> <input type="text" value="" class="td-input td-inputFactorNumAdd form-control"> </td>
        <td class="addFactorTd-16"> <input type="text" value="" class="td-input td-inputFactorDateAdd form-control"> </td>
        <td class="addFactorTd-17"> <input type="text" value="" class="td-input td-inputFactorDescAdd form-control"> </td>
        <td class="addFactorTd-18"> <input type="text" value="" class="td-input td-inputStockAdd form-control"> </td>
        <td class="addFactorTd-19"> <input type="text" value="" class="td-input td-inputMaliatAdd form-control"> </td>
        <td class="addFactorTd-20"> <input type="text" value="" class="td-input td-inputWeightUnitAdd form-control"> </td>
        <td class="addFactorTd-21"> <input type="text" value="" class="td-input td-inputAllWeightAdd form-control"> </td>
        <td class="addFactorTd-22"> <input type="text" value="" class="td-input  td-inputInserviceAdd form-control"> </td>
        <td class="addFactorTd-23"> <input type="text" value="" class="td-input  td-inputPercentMaliatAdd form-control"> </td>
    </tr>`;
$("#factorAddListBody").append(row);

let rowindex=$(row).index()+1

let totalMoneyTillEndRow=0;

for (let index = 1; index <=rowindex; index++) {

    totalMoneyTillEndRow+=parseInt($('#factorAddListBody tr:nth-child('+index+') td:nth-child(14)').children('input').val().replace(/,/g, ''));

}

$("#allMoneyTillEndRowAdd").text(parseInt(totalMoneyTillEndRow).toLocaleString("en-us"));
$("#sumAllRowMoneyAfterTakhfifAdd").text(parseInt(totalMoneyTillEndRow-parseInt($("#sumAllRowMoneyAfterTakhfifAdd").val().replace(/,/g, ''))).toLocaleString("en-us"))

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

$("#searchKalaForAddToFactorByName").on("keyup",function(event){
    let tableBody=$("#kalaForAddToFactor");
    if(event.keyCode!=40){
        if(event.keyCode!=13){
            $.get(baseUrl+'/getKalaByName',{name:$(this).val()},function (data,status) {
                if(status=='success'){
                    tableBody.empty();
                    let i=0;
                    for (const element of data) {
                        i++;
                        if(i!=1){
                            tableBody.append(`<tr onclick="setAddedToFactorKalaStuff(this,`+element.GoodSn+`)">  <td>`+(i)+`<input type="radio" value="${element.GoodSn}" class="d-none"/></td> <td> `+element.GoodCde+` </td><td> `+element.GoodName+`</td> <td>...</td> </tr>`);
                        }else{
                            tableBody.append(`<tr onclick="setAddedToFactorKalaStuff(this,`+element.GoodSn+`)">  <td>`+(i)+`<input type="radio" value="${element.GoodSn}" class="d-none"/></td> <td> `+element.GoodCde+` </td><td> `+element.GoodName+`</td> <td>...</td> </tr>`);
                            $("#kalaForAddToFactor tr").eq(0).css('background-color', 'rgb(0,142,201)'); 
                            const selectedGoodSn = data[0].GoodSn;
                            setAddedToFactorKalaStuff(0,selectedGoodSn)
                        }
                    }

                    Mousetrap.bind("enter",()=>{
                        $("#selectKalaToFactorBtn").trigger("click");
                    });

                    Mousetrap.bind("esc",()=>{
                        $("#addOrderItem1").modal("hide");
                    });

                }
            })
    }else{
        $("#selectKalaToFactorBtn").trigger("click");
    }
}else{
    $(this).blur(); // Remove focus from the input
    $("#kalaForAddToFactorTble").focus();
}
});

$("#searchKalaForAddToFactorByCode").on("keyup",function(event){
    if(event.keyCode!=40){
        if(event.keyCode!=13){
            let goodCode=$("#searchKalaForAddToFactorByCode").val();
            let tableBody=$("#kalaForAddToFactor");
            $.get(baseUrl + '/searchKalaByCode', { code: goodCode }, function (data, status) {
                if (status == 'success') {
                    tableBody.empty();
                    let i=0;
                    for (const element of data) {
                        i++;
                        if(i!=1){
                            tableBody.append(`<tr onclick="setAddedToFactorKalaStuff(this,`+element.GoodSn+`)">  <td>`+(i)+`<input type="radio" value="${element.GoodSn}" class="d-none"/></td> <td> `+element.GoodCde+` </td><td> `+element.GoodName+`</td> <td>...</td> </tr>`);
                        }else{
                            tableBody.append(`<tr onclick="setAddedToFactorKalaStuff(this,`+element.GoodSn+`)">  <td>`+(i)+`<input type="radio" value="${element.GoodSn}" class="d-none"/></td> <td> `+element.GoodCde+` </td><td> `+element.GoodName+`</td> <td>...</td> </tr>`);
                            
                            $("#kalaForAddToFactor tr").eq(0).css('background-color', 'rgb(0,142,201)'); 
                            const selectedGoodSn = data[0].GoodSn;
                            setAddedToFactorKalaStuff(0,selectedGoodSn)
                        }
                    }
                    Mousetrap.bind("enter",()=>{
                        $("#selectKalaToFactorBtn").trigger("click");
                    });
                }
            });
        }else{
            $("#selectKalaToFactorBtn").trigger("click");
        }
    }else{
        $(this).blur(); // Remove focus from the input
        $("#kalaForAddToFactorTble").focus();
    }
});


function setAddedToFactorKalaStuff(element,goodSn){
    if(isNaN(element)){
        $("tr").removeClass('selected');
        $("#kalaForAddToFactor tr").css('background-color', '');
        $(element).addClass("selected")
    }else{
        $("tr").removeClass('selected');
    }
 if($("#selectKalaToAddFactorBtn")){
    
    $("#selectKalaToAddFactorBtn").val(goodSn)
 }
 let customerSn=$("#customerForFactorAdd").val();

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
                $("#StockExistanceAddFactor").text(parseInt(response[0][0].Amount).toLocaleString("en-us"));
            } else {
                $("#StockExistanceAddFactor").text(0);
            }
        }else {
            $("#StockExistanceAddFactor").text(0);
        }
        if(response[1][0]){
            if (!isNaN(parseInt(response[1][0].Price3))) {
                $("#SalePriceAddFactor").text(parseInt(response[1][0].Price3 / 10).toLocaleString("en-us"));
            } else {
                $("#SalePriceAddFactor").text(0);
            }
        } else {
            $("#SalePriceAddFactor").text(0);
        }

        if (response[2][0]) {
            if (!isNaN(parseInt(response[2][0].Fi))) {
                $("#LastPriceCustomerAddFactor").text(parseInt(response[2][0].Fi / 10).toLocaleString("en-us"));
            } else {
                $("#LastPriceCustomerAddFactor").text(0);
            }
        }else {
            $("#LastPriceCustomerAddFactor").text(0);
        }

        if([3][0]){
            if (!isNaN(parseInt(response[3][0].Fi))) {
                $("#LastPriceAddFactor").text(parseInt(response[3][0].Fi / 10).toLocaleString("en-us"));
            } else {
                $("#LastPriceAddFactor").text(0);
            }
        }else {
            $("#LastPriceAddFactor").text(0);
        }
    },
    error: function (error) {
        //alert("get item existance error found");
    }
})
}

function cancelAddFactor(){
    let firstGoodSn=$('#factorAddListBody tr:nth-child(1) td:nth-child(2)').children('input').val();
    if(firstGoodSn){
        swal({
            title:"می خواهید بدون ذخیره خارج شوید؟",
            icon:"warning",
            buttons:true
        }).then((willCancel)=>{
            if(willCancel){
                $("#addFactorModal").modal("hide");
            }
        })
    }else{
        $("#addFactorModal").modal("hide");
    }
}

$("#deleteFactorItemBtnAdd").on("click",function(e){
        swal({
            title: "آیا مطمئین هستید؟",
            text: "اگر حذف شد، دیگر قادر به بازیابی دیتا نیستید!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
            })
            .then((willDelete) => {
                if(willDelete){
                    $('#factorAddListBody tr.selected').remove();
                }
        });
    calculateNewFactorMoney();
})

$("#deleteFactorItemBtnFEdit").on("click",function(e){
    swal({
        title: "آیا مطمئین هستید؟",
        text: "اگر حذف شد، دیگر قادر به بازیابی دیتا نیستید!",
        icon: "warning",
        buttons: true,
        dangerMode: true,
        })
        .then((willDelete) => {
            if(willDelete){
                $('#factorEditListBody tr.selected').remove();
            }
    });
calculateNewFactorMoney();
})

function showAmelModalFEdit(){
    if (!$(".modal.in").length) {
        $(".modal-dialog").css({
            top: 0,
            left: 0,
        });
    }
    $(".modal-dialog").draggable({
        handle: ".modal-header",
    });
    $("#addAmelModalFEdit").modal("show")
}

function showAmelModalFAdd(){
    if (!$(".modal.in").length) {
        $(".modal-dialog").css({
            top: 0,
            left: 0,
        });
    }
    $(".modal-dialog").draggable({
        handle: ".modal-header",
    });
    $("#addAmelModalFAdd").modal("show")
}

function addAmelToFactorFAdd(){
    $("#addAmelModalFAdd").modal("hide");
    if($("#hamlMoneyModalFAdd").val().replace(/,/g, '')){
        $("#hamlMoneyFAdd").val($("#hamlMoneyModalFAdd").val().replace(/,/g, ''));
    }
    if($("#hamlDescModalFAdd").val()){
        $("#hamlDescFAdd").val($("#hamlDescModalFAdd").val());
    }
    if($("#nasbMoneyModalFAdd").val().replace(/,/g, '')){
        $("#nasbMoneyFAdd").val($("#nasbMoneyModalFAdd").val().replace(/,/g, ''));
    }
    if($("#nasbDescModalFAdd").val()){
        $("#nasbDescFAdd").val($("#nasbDescModalFAdd").val());
    }
    if($("#motafariqaMoneyModalFAdd").val().replace(/,/g, '')){
        $("#motafariqaMoneyFAdd").val($("#motafariqaMoneyModalFAdd").val().replace(/,/g, ''));
    }
    if($("#motafariqaDescModalFAdd").val()){
        $("#motafariqaDescFAdd").val($("#motafariqaDescModalFAdd").val());
    }
    if($("#bargiriMoneyModalFAdd").val().replace(/,/g, '')){
        $("#bargiriMoneyFAdd").val($("#bargiriMoneyModalFAdd").val().replace(/,/g, ''));
    }
    if($("#bargiriDescModalFAdd").val()){
        $("#bargiriDescFAdd").val($("#bargiriDescModalFAdd").val());
    }
    if($("#tarabariMoneyModalFAdd").val().replace(/,/g, '')){
        $("#tarabariMoneyFAdd").val($("#tarabariMoneyModalFAdd").val().replace(/,/g, ''));
    }
    if($("#tarabariDescModalFAdd").val()){
        $("#tarabariDescFAdd").val($("#tarabariDescModalFAdd").val());
    }

    let hamlMoney=0;
    let nasbMoney=0;
    let motafariqaMoney=0;
    let bargiriMoney=0;
    let tarabariMoney=0;
    if(!isNaN(parseInt($("#hamlMoneyFAdd").val()))){
        hamlMoney=parseInt($("#hamlMoneyFAdd").val());
    }
    if(!isNaN(parseInt($("#nasbMoneyFAdd").val()))){
        nasbMoney=parseInt($("#nasbMoneyFAdd").val());
    }
    if(!isNaN(parseInt($("#motafariqaMoneyFAdd").val()))){
        motafariqaMoney=parseInt($("#motafariqaMoneyFAdd").val());
    }
    if(!isNaN(parseInt($("#bargiriMoneyFAdd").val()))){
        bargiriMoney=parseInt($("#bargiriMoneyFAdd").val());
    }
    if(!isNaN(parseInt($("#tarabariMoneyFAdd").val()))){
        tarabariMoney=parseInt($("#tarabariMoneyFAdd").val());
    }

    let allAmel=hamlMoney+nasbMoney+motafariqaMoney+bargiriMoney+tarabariMoney;
    $("#allAmelMoneyFAdd").text(parseInt(allAmel).toLocaleString("en-us"));
}
$("#hamlMoneyModalFAdd").on("keyup",(e)=>{
    checkNumberInput(e);
    if(e.keyCode==13 || e.keyCode==9){
        $("#hamlDescModalFAdd").focus();
    }
})
$("#nasbMoneyModalFAdd").on("keyup",(e)=>{
    checkNumberInput(e);
    if(e.keyCode==13 || e.keyCode==9){
        $("#nasbDescModalFAdd").focus();
    }
})
$("#motafariqaMoneyModalFAdd").on("keyup",(e)=>{
    checkNumberInput(e);
    if(e.keyCode==13 || e.keyCode==9){
        $("#motafariqaDescModalFAdd").focus();
    } 
})
$("#bargiriMoneyModalFAdd").on("keyup",(e)=>{
    checkNumberInput(e);
    if(e.keyCode==13 || e.keyCode==9){
        $("#bargiriDescModalFAdd").focus();
    }
})
$("#tarabariMoneyModalFAdd").on("keyup",(e)=>{
    checkNumberInput(e);
    if(e.keyCode==13 || e.keyCode==9){
        $("#tarabariDescModalFAdd").focus();
    }
})
$("#hamlDescModalFAdd").on("keyup",(e)=>{
    if(e.keyCode==13 || e.keyCode==9){
        $("#nasbMoneyModalFAdd").focus();
    }
})
$("#nasbDescModalFAdd").on("keyup",(e)=>{
    if(e.keyCode==13 || e.keyCode==9){
        $("#motafariqaMoneyModalFAdd").focus();
    }
})
$("#motafariqaDescModalFAdd").on("keyup",(e)=>{
    if(e.keyCode==13 || e.keyCode==9){
        $("#bargiriMoneyModalFAdd").focus();
    }
})
$("#bargiriDescModalFAdd").on("keyup",(e)=>{
    if(e.keyCode==13 || e.keyCode==9){
        $("#tarabariMoneyModalFAdd").focus();
    }
});

$("#tarabariDescModalFAdd").on("keyup",(e)=>{
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


function addAmelToFactorFEdit(){
    $("#addAmelModalFEdit").modal("hide");
    if($("#hamlMoneyModalFEdit").val().replace(/,/g, '')){
        $("#hamlMoneyFEdit").val($("#hamlMoneyModalFEdit").val().replace(/,/g, ''));
    }
    if($("#hamlDescModalFEdit").val()){
        $("#hamlDescFEdit").val($("#hamlDescModalFEdit").val());
    }
    if($("#nasbMoneyModalFEdit").val().replace(/,/g, '')){
        $("#nasbMoneyFEdit").val($("#nasbMoneyModalFEdit").val().replace(/,/g, ''));
    }
    if($("#nasbDescModalFEdit").val()){
        $("#nasbDescFEdit").val($("#nasbDescModalFEdit").val());
    }
    if($("#motafariqaMoneyModalFEdit").val().replace(/,/g, '')){
        $("#motafariqaMoneyFEdit").val($("#motafariqaMoneyModalFEdit").val().replace(/,/g, ''));
    }
    if($("#motafariqaDescModalFEdit").val()){
        $("#motafariqaDescFEdit").val($("#motafariqaDescModalFEdit").val());
    }
    if($("#bargiriMoneyModalFEdit").val().replace(/,/g, '')){
        $("#bargiriMoneyFEdit").val($("#bargiriMoneyModalFEdit").val().replace(/,/g, ''));
    }
    if($("#bargiriDescModalFEdit").val()){
        $("#bargiriDescFEdit").val($("#bargiriDescModalFEdit").val());
    }
    if($("#tarabariMoneyModalFEdit").val().replace(/,/g, '')){
        $("#tarabariMoneyFEdit").val($("#tarabariMoneyModalFEdit").val().replace(/,/g, ''));
    }
    if($("#tarabariDescModalFEdit").val()){
        $("#tarabariDescFEdit").val($("#tarabariDescModalFEdit").val());
    }

    let hamlMoney=0;
    let nasbMoney=0;
    let motafariqaMoney=0;
    let bargiriMoney=0;
    let tarabariMoney=0;
    if(!isNaN(parseInt($("#hamlMoneyFEdit").val()))){
        hamlMoney=parseInt($("#hamlMoneyFEdit").val());
    }
    if(!isNaN(parseInt($("#nasbMoneyFEdit").val()))){
        nasbMoney=parseInt($("#nasbMoneyFEdit").val());
    }
    if(!isNaN(parseInt($("#motafariqaMoneyFEdit").val()))){
        motafariqaMoney=parseInt($("#motafariqaMoneyFEdit").val());
    }
    if(!isNaN(parseInt($("#bargiriMoneyFEdit").val()))){
        bargiriMoney=parseInt($("#bargiriMoneyFEdit").val());
    }
    if(!isNaN(parseInt($("#tarabariMoneyFEdit").val()))){
        tarabariMoney=parseInt($("#tarabariMoneyFEdit").val());
    }

    let allAmel=hamlMoney+nasbMoney+motafariqaMoney+bargiriMoney+tarabariMoney;
    $("#allAmelMoneyFEdit").text(parseInt(allAmel).toLocaleString("en-us"));
}
$("#hamlMoneyModalFEdit").on("keyup",(e)=>{
    checkNumberInput(e);
    if(e.keyCode==13 || e.keyCode==9){
        $("#hamlDescModalFEdit").focus();
    }
})
$("#nasbMoneyModalFEdit").on("keyup",(e)=>{
    checkNumberInput(e);
    if(e.keyCode==13 || e.keyCode==9){
        $("#nasbDescModalFEdit").focus();
    }
})
$("#motafariqaMoneyModalFEdit").on("keyup",(e)=>{
    checkNumberInput(e);
    if(e.keyCode==13 || e.keyCode==9){
        $("#motafariqaDescModalFEdit").focus();
    } 
})
$("#bargiriMoneyModalFEdit").on("keyup",(e)=>{
    checkNumberInput(e);
    if(e.keyCode==13 || e.keyCode==9){
        $("#bargiriDescModalFEdit").focus();
    }
})
$("#tarabariMoneyModalFEdit").on("keyup",(e)=>{
    checkNumberInput(e);
    if(e.keyCode==13 || e.keyCode==9){
        $("#tarabariDescModalFEdit").focus();
    }
})
$("#hamlDescModalFEdit").on("keyup",(e)=>{
    if(e.keyCode==13 || e.keyCode==9){
        $("#nasbMoneyModalFEdit").focus();
    }
})
$("#nasbDescModalFEdit").on("keyup",(e)=>{
    if(e.keyCode==13 || e.keyCode==9){
        $("#motafariqaMoneyModalFEdit").focus();
    }
})
$("#motafariqaDescModalFEdit").on("keyup",(e)=>{
    if(e.keyCode==13 || e.keyCode==9){
        $("#bargiriMoneyModalFEdit").focus();
    }
})
$("#bargiriDescModalFEdit").on("keyup",(e)=>{
    if(e.keyCode==13 || e.keyCode==9){
        $("#tarabariMoneyModalFEdit").focus();
    }
});

$("#tarabariDescModalFEdit").on("keyup",(e)=>{
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

var activeTable="";
let selectedRow=0;
$(document).keydown((event) => {
    switch(activeTable){
        case "factorListBody":
            {
                if(event.keyCode==40){
                    event.preventDefault();
                    var rowCount = $("#factorListBody tr:last").index() + 1;
                    let tableBody=$("#factorListBody");
                    if (selectedRow >= 0) {
                        $("#factorListBody tr").eq(selectedRow).css('background-color', '');
                    }
                    if(selectedRow!=0){
                        selectedRow = Math.min(selectedRow + 1, rowCount - 1); 
                        $("#factorListBody tr").eq(selectedRow).css('background-color', "rgb(0,142,201)"); 
                    }else{
                        selectedRow = Math.min(1, rowCount - 1); 
                        $("#factorListBody tr").eq(selectedRow).css('background-color', "rgb(0,142,201)"); 
                    }
                    element=$("#factorListBody tr").eq(selectedRow)
                    snFact=$(element).find('input[type="radio"]').val();
                    getFactorOrders(element,snFact)
                    let topTr = $("#factorListBody tr").eq(selectedRow).position().top;
                    let bottomTr =topTr+50;
                    let trHieght =50;
                    if(topTr > 0 && bottomTr < 450){
                    }else{
                        let newScrollTop =trHieght+ parseInt(localStorage.getItem("scrollTop"));
                        tableBody.scrollTop(parseInt(newScrollTop));
                        localStorage.setItem("scrollTop",newScrollTop);
                    }
                }

                if(event.keyCode==38){
                    
                    event.preventDefault();
                    var rowCount = $("#factorListBody tr:last").index() + 1;
                    let tableBody=$("#factorListBody");
                    if (selectedRow >= 0) {
                        $("#factorListBody tr").eq(selectedRow).css('background-color', '');
                    }
                    if(selectedRow!=0){
                        selectedRow = Math.max(selectedRow  - 1, 0); 
                        $("#factorListBody tr").eq(selectedRow).css('background-color', "rgb(0,142,201)"); 
                    }else{
                        selectedRow = Math.min(1, rowCount - 1); 
                        $("#factorListBody tr").eq(selectedRow).css('background-color', "rgb(0,142,201)"); 
                    }
                    element=$("#factorListBody tr").eq(selectedRow)
                    snFact=$(element).find('input[type="radio"]').val();
                    getFactorOrders(element,snFact)
                    let topTr = $("#factorListBody tr").eq(selectedRow).position().top;
                    let bottomTr =topTr+50;
                    let trHieght =50;
                    if(topTr > 0 && bottomTr < 450){
                    }else{
                        let newScrollTop =trHieght+ parseInt(localStorage.getItem("scrollTop"));
                        tableBody.scrollTop(parseInt(newScrollTop));
                        localStorage.setItem("scrollTop",newScrollTop);
                    }
                }
            }
        break;
        case "kalaForEditToFactorEditBody":
            {
                if(event.keyCode==40){
                    event.preventDefault();
                    var rowCount = $("#kalaForEditToFactorEditBody tr:last").index() + 1;
                    let tableBody=$("#kalaForEditToFactorEditBody");
                    if (selectedRow >= 0) {
                        $("#kalaForEditToFactorEditBody tr").eq(selectedRow).css('background-color', '');
                    }
                    if(selectedRow!=0){
                        selectedRow = Math.min(selectedRow + 1, rowCount - 1); 
                        $("#kalaForEditToFactorEditBody tr").eq(selectedRow).css('background-color', "rgb(0,142,201)"); 
                    }else{
                        selectedRow = Math.min(1, rowCount - 1); 
                        $("#kalaForEditToFactorEditBody tr").eq(selectedRow).css('background-color', "rgb(0,142,201)"); 
                    }
                    element=$("#kalaForEditToFactorEditBody tr").eq(selectedRow)
                    let selectedGoodSn=$(element).find('input[type="radio"]').val();
                    
                    setAddedToFactorKalaStuffEdit(0,selectedGoodSn)
                    let topTr = $("#kalaForEditToFactorEditBody tr").eq(selectedRow).position().top;
                    let bottomTr =topTr+50;
                    let trHieght =50;
                    if(topTr > 0 && bottomTr < 450){
                    }else{
                        let newScrollTop =trHieght+ parseInt(localStorage.getItem("scrollTop"));
                        tableBody.scrollTop(parseInt(newScrollTop));
                        localStorage.setItem("scrollTop",newScrollTop);
                    }
                }

                if(event.keyCode==38){
                    event.preventDefault();
                    var rowCount = $("#kalaForEditToFactorEditBody tr:last").index() + 1;
                    let tableBody=$("#kalaForEditToFactorEditBody");
                    if (selectedRow >= 0) {
                        $("#kalaForEditToFactorEditBody tr").eq(selectedRow).css('background-color', '');
                    }
                    if(selectedRow!=0){
                        selectedRow = Math.max(selectedRow  - 1, 0); 
                        $("#kalaForEditToFactorEditBody tr").eq(selectedRow).css('background-color', "rgb(0,142,201)"); 
                    }else{
                        selectedRow = Math.min(1, rowCount - 1); 
                        $("#kalaForEditToFactorEditBody tr").eq(selectedRow).css('background-color', "rgb(0,142,201)"); 
                    }
                    element=$("#kalaForEditToFactorEditBody tr").eq(selectedRow)
                    let selectedGoodSn=$(element).find('input[type="radio"]').val();
                    setAddedToFactorKalaStuffEdit(0,selectedGoodSn)
                    let topTr = $("#kalaForEditToFactorEditBody tr").eq(selectedRow).position().top;
                    let bottomTr =topTr+50;
                    let trHieght =50;
                    if(topTr > 0 && bottomTr < 450){
                    }else{
                        let newScrollTop =trHieght+ parseInt(localStorage.getItem("scrollTop"));
                        tableBody.scrollTop(parseInt(newScrollTop));
                        localStorage.setItem("scrollTop",newScrollTop);
                    }
                }
            }
            break
        case "foundCusotmerForFactorBodyEdit":
            {     
            if(event.keyCode==40){
                event.preventDefault();
                var rowCount = $("#foundCusotmerForFactorBodyEdit tr:last").index() + 1;
                let tableBody=$("#foundCusotmerForFactorBodyEdit");
                if (selectedRow >= 0) {
                    $("#foundCusotmerForFactorBodyEdit tr").eq(selectedRow).css('background-color', '');
                }
                if(selectedRow!=0){
                    selectedRow = Math.min(selectedRow + 1, rowCount - 1); 
                    $("#foundCusotmerForFactorBodyEdit tr").eq(selectedRow).css('background-color', "rgb(0,142,201)"); 
                }else{
                    selectedRow = Math.min(1, rowCount - 1); 
                    $("#foundCusotmerForFactorBodyEdit tr").eq(selectedRow).css('background-color', "rgb(0,142,201)"); 
                }
                element=$("#foundCusotmerForFactorBodyEdit tr").eq(selectedRow)
                let selectedPSN=$(element).find('input[type="radio"]').val();
                selectCustomerForFactorEdit(selectedPSN,0)
                let topTr = $("#foundCusotmerForFactorBodyEdit tr").eq(selectedRow).position().top;
                let bottomTr =topTr+50;
                let trHieght =50;
                if(topTr > 0 && bottomTr < 450){
                }else{
                    let newScrollTop =trHieght+ parseInt(localStorage.getItem("scrollTop"));
                    tableBody.scrollTop(parseInt(newScrollTop));
                    localStorage.setItem("scrollTop",newScrollTop);
                }
            }
            if(event.keyCode==38){
                event.preventDefault();
                var rowCount = $("#foundCusotmerForFactorBodyEdit tr:last").index() + 1;
                let tableBody=$("#foundCusotmerForFactorBodyEdit");
                if (selectedRow >= 0) {
                    $("#foundCusotmerForFactorBodyEdit tr").eq(selectedRow).css('background-color', '');
                }
                if(selectedRow!=0){
                    selectedRow = Math.max(selectedRow  - 1, 0); 
                    $("#foundCusotmerForFactorBodyEdit tr").eq(selectedRow).css('background-color', "rgb(0,142,201)"); 
                }else{
                    selectedRow = Math.min(1, rowCount - 1); 
                    $("#foundCusotmerForFactorBodyEdit tr").eq(selectedRow).css('background-color', "rgb(0,142,201)"); 
                }
                element=$("#foundCusotmerForFactorBodyEdit tr").eq(selectedRow)
                let selectedPSN=$(element).find('input[type="radio"]').val();
                selectCustomerForFactorEdit(selectedPSN,0)
                let topTr = $("#foundCusotmerForFactorBodyEdit tr").eq(selectedRow).position().top;
                let bottomTr =topTr+50;
                let trHieght =50;
                if(topTr > 0 && bottomTr < 450){
                }else{
                    let newScrollTop=trHieght+ parseInt(localStorage.getItem("scrollTop"));
                    tableBody.scrollTop(parseInt(newScrollTop));
                    localStorage.setItem("scrollTop",newScrollTop);
                }
            }
        }
            break;
        case "foundCusotmerForFactorBody":
            {     
                if(event.keyCode==40){
                    event.preventDefault();
                    var rowCount = $("#foundCusotmerForFactorBody tr:last").index() + 1;
                    let tableBody=$("#foundCusotmerForFactorBody");
                    if (selectedRow >= 0) {
                        $("#foundCusotmerForFactorBody tr").eq(selectedRow).css('background-color', '');
                    }
                    if(selectedRow!=0){
                        selectedRow = Math.min(selectedRow + 1, rowCount - 1); 
                        $("#foundCusotmerForFactorBody tr").eq(selectedRow).css('background-color', "rgb(0,142,201)"); 
                    }else{
                        selectedRow = Math.min(1, rowCount - 1); 
                        $("#foundCusotmerForFactorBody tr").eq(selectedRow).css('background-color', "rgb(0,142,201)"); 
                    }
                    element=$("#foundCusotmerForFactorBody tr").eq(selectedRow)
                    let selectedPSN=$(element).find('input[type="radio"]').val();
                    selectCustomerForFactor(selectedPSN,0)
                    let topTr = $("#foundCusotmerForFactorBody tr").eq(selectedRow).position().top;
                    let bottomTr =topTr+50;
                    let trHieght =50;
                    if(topTr > 0 && bottomTr < 450){
                    }else{
                        let newScrollTop =trHieght+ parseInt(localStorage.getItem("scrollTop"));
                        tableBody.scrollTop(parseInt(newScrollTop));
                        localStorage.setItem("scrollTop",newScrollTop);
                    }
                }
    
                if(event.keyCode==38){
                    event.preventDefault();
                    var rowCount = $("#foundCusotmerForFactorBody tr:last").index() + 1;
                    let tableBody=$("#foundCusotmerForFactorBody");
                    if (selectedRow >= 0) {
                        $("#foundCusotmerForFactorBody tr").eq(selectedRow).css('background-color', '');
                    }
                    if(selectedRow!=0){
                        selectedRow = Math.max(selectedRow  - 1, 0); 
                        $("#foundCusotmerForFactorBody tr").eq(selectedRow).css('background-color', "rgb(0,142,201)"); 
                    }else{
                        selectedRow = Math.min(1, rowCount - 1); 
                        $("#foundCusotmerForFactorBody tr").eq(selectedRow).css('background-color', "rgb(0,142,201)"); 
                    }
                    element=$("#foundCusotmerForFactorBody tr").eq(selectedRow)
                    let selectedPSN=$(element).find('input[type="radio"]').val();
                    selectCustomerForFactor(selectedPSN,0)
                    let topTr = $("#foundCusotmerForFactorBody tr").eq(selectedRow).position().top;
                    let bottomTr =topTr+50;
                    let trHieght =50;
                    if(topTr > 0 && bottomTr < 450){
                    }else{
                        let newScrollTop=trHieght+ parseInt(localStorage.getItem("scrollTop"));
                        tableBody.scrollTop(parseInt(newScrollTop));
                        localStorage.setItem("scrollTop",newScrollTop);
                    }
                }
            }
            break;
        case "kalaForAddToFactor":
            {                
                if(event.keyCode==40){
                event.preventDefault();
                var rowCount = $("#kalaForAddToFactor tr:last").index() + 1;
                let tableBody=$("#kalaForAddToFactor");
                if (selectedRow >= 0) {
                    $("#kalaForAddToFactor tr").eq(selectedRow).css('background-color', '');
                }
                if(selectedRow!=0){
                    selectedRow = Math.min(selectedRow + 1, rowCount - 1); 
                    $("#kalaForAddToFactor tr").eq(selectedRow).css('background-color', "rgb(0,142,201)"); 
                }else{
                    selectedRow = Math.min(1, rowCount - 1); 
                    $("#kalaForAddToFactor tr").eq(selectedRow).css('background-color', "rgb(0,142,201)"); 
                }
                element=$("#kalaForAddToFactor tr").eq(selectedRow)
                let selectedGoodSn=$(element).find('input[type="radio"]').val();
                setAddedToFactorKalaStuff(0,selectedGoodSn)
                let topTr = $("#kalaForAddToFactor tr").eq(selectedRow).position().top;
                let bottomTr =topTr+50;
                let trHieght =50;
                if(topTr > 0 && bottomTr < 450){
                }else{
                    let newScrollTop =trHieght+ parseInt(localStorage.getItem("scrollTop"));
                    tableBody.scrollTop(parseInt(newScrollTop));
                    localStorage.setItem("scrollTop",newScrollTop);
                }
            }

            if(event.keyCode==38){
                event.preventDefault();
                var rowCount = $("#kalaForAddToFactor tr:last").index() + 1;
                let tableBody=$("#kalaForAddToFactor");
                if (selectedRow >= 0) {
                    $("#kalaForAddToFactor tr").eq(selectedRow).css('background-color', '');
                }
                if(selectedRow!=0){
                    selectedRow = Math.max(selectedRow  - 1, 0); 
                    $("#kalaForAddToFactor tr").eq(selectedRow).css('background-color', "rgb(0,142,201)"); 
                }else{
                    selectedRow = Math.min(1, rowCount - 1); 
                    $("#kalaForAddToFactor tr").eq(selectedRow).css('background-color', "rgb(0,142,201)"); 
                }
                element=$("#kalaForAddToFactor tr").eq(selectedRow)
                let selectedGoodSn=$(element).find('input[type="radio"]').val();
                setAddedToFactorKalaStuff(0,selectedGoodSn)
                let topTr = $("#kalaForAddToFactor tr").eq(selectedRow).position().top;
                let bottomTr =topTr+50;
                let trHieght =50;
                if(topTr > 0 && bottomTr < 450){
                }else{
                    let newScrollTop =trHieght+ parseInt(localStorage.getItem("scrollTop"));
                    tableBody.scrollTop(parseInt(newScrollTop));
                    localStorage.setItem("scrollTop",newScrollTop);
                }
            }
        }
            break;
        }
    })

function setActiveTable(tableBodyId) {

    if(activeTable){

        activeTable="";

    }

    activeTable = tableBodyId;

}

setActiveTable("");
let activeFormF=""
$(document).keydown((event)=>{
    if(event.keyCode==40){
        switch (activeFormF) {
            case "factorEditListBody":
                {
                    let rowindex=$(event.target).parents("tr").index()+1
                    let goodSn=parseInt($('#factorEditListBody tr:nth-child('+rowindex+') td:nth-child(2)').children("input[type='checkbox']").val());
                    
                    if(isNaN(goodSn)){
                        return
                    }
                    $("#factorEditListBody").append(`
                     <tr class="factorTablRow" onclick="checkAddedKalaAmountOfFactor(this)">
                        <td class="editFactorTd-1"> </td>
                        <td class="editFactorTd-2"> <input type="text" value="" class="td-input td-inputCodeFEdit form-control"> <input type="radio" style="display:none" value=""/> </td>
                        <td class="editFactorTd-3"> <input type="text" value="" class="td-input td-inputCodeNameFEdit form-control"> </td>
                        <td class="editFactorTd-4"> <input type="text" value="" class="td-input td-inputFirstUnitFEdit form-control"> </td>
                        <td class="editFactorTd-5"> <input type="text" value="" class="td-input td-inputSecondUnitFEdit form-control"> </td>
                        <td class="editFactorTd-6"> <input type="text" value="" class="td-input  td-inputSecondUnitAmountFEdit form-control"> </td>
                        <td class="editFactorTd-7"> <input type="text" value="" class="td-input td-inputJozeAmountFEdit form-control"> </td>
                        <td class="editFactorTd-8"> <input type="text" value="" class="td-input td-inputFirstAmountFEdit form-control"> </td>
                        <td class="editFactorTd-9"> <input type="text" value="" class="td-input td-inputReAmountFEdit form-control"> </td>
                        <td class="editFactorTd-10"> <input type="text" value="" class="td-input  td-AllAmountFEdit form-control"> </td>
                        <td class="editFactorTd-11"> <input type="text" value="" class="td-input td-inputFirstUnitPriceFEdit form-control"> </td>
                        <td class="editFactorTd-12"> <input type="text" value="" class="td-input td-inputSecondUnitPriceFEdit form-control"> </td>
                        <td class="editFactorTd-13"> <input type="text" value="" class="td-input td-inputAllPriceFEdit form-control"> </td>
                        <td class="editFactorTd-14"> <input type="text" value="" class="td-input td-inputAllPriceAfterTakhfifFEdit  form-control"> </td>
                        <td class="editFactorTd-15"> <input type="text" value="" class="td-input td-inputFactorNumFEdit form-control"> </td>
                        <td class="editFactorTd-16> <input type="text" value="" class="td-input td-inputFactorDateFEdit form-control"> </td>
                        <td class="editFactorTd-17"> <input type="text" value="" class="td-input td-inputFactorDescFEdit form-control"> </td>
                        <td class="editFactorTd-18"> <input type="text" value="" class="td-input td-inputStockFEdit form-control"> </td>
                        <td class="editFactorTd-19"> <input type="text" value="" class="td-input td-inputMaliatFEdit form-control"> </td>
                        <td class="editFactorTd-20"> <input type="text" value="" class="td-input td-inputWeightUnitFEdit form-control"> </td>
                        <td class="editFactorTd-21"> <input type="text" value="" class="td-input td-inputAllWeightFEdit form-control"> </td>
                        <td class="editFactorTd-22"> <input type="text" value="" class="td-input  td-inputInserviceFEdit form-control"> </td>
                        <td class="editFactorTd-23"> <input type="text" value="" class="td-input  td-inputPercentMaliatFEdit form-control"> </td>
                    </tr>`);

                    makeTableColumnsResizable("factorEidtTable")

                $("#factorEditListBody tr:last td:nth-child(2)").children('input').focus();
                $("#factorEditListBody tr").removeClass("selected");
                $("#factorEditListBody tr:last").addClass("selected");

                }
                break;
            case "factorAddListBody":
                {
                    let rowindex=$(event.target).parents("tr").index()+1
                    let goodSn=parseInt($('#addsefarishtbl tr:nth-child('+rowindex+') td:nth-child(15)').children('input').val());
                    
                    if(goodSn==0){
                        return
                    }
                    $("#factorAddListBody").append(`
                      <tr onclick="checkAddedKalaAmountOfFactorItem(this)">
                        <td class="addFactorTd-1"> </td>
                        <td class="addFactorTd-2"> <input type="text" value="" class="td-input td-inputCodeAdd form-control"> <input type="radio" style="display:none" value=""/> </td>
                        <td class="addFactorTd-3"> <input type="text" value="" class="td-input td-inputCodeNameAdd form-control"> </td>
                        <td class="addFactorTd-4"> <input type="text" value="" class="td-input td-inputFirstUnitAdd form-control"> </td>
                        <td class="addFactorTd-5"> <input type="text" value="" class="td-input td-inputSecondUnitAdd form-control"> </td>
                        <td class="addFactorTd-6"> <input type="text" value="" class="td-input td-inputSecondUnitAmountAdd form-control"> </td>
                        <td class="addFactorTd-7"> <input type="text" value="" class="td-input td-inputJozeAmountAdd form-control"> </td>
                        <td class="addFactorTd-8"> <input type="text" value="" class="td-input td-inputFirstAmountAdd form-control"> </td>
                        <td class="addFactorTd-9"> <input type="text" value="" class="td-input td-inputReAmountAdd form-control"> </td>
                        <td class="addFactorTd-10"> <input type="text" value="" class="td-input td-AllAmountAdd form-control"> </td>
                        <td class="addFactorTd-11"> <input type="text" value="" class="td-input td-inputFirstUnitPriceAdd form-control"> </td>
                        <td class="addFactorTd-12"> <input type="text" value="" class="td-input td-inputSecondUnitPriceAdd form-control"> </td>
                        <td class="addFactorTd-13"> <input type="text" value="" class="td-input td-inputAllPriceAdd form-control"> </td>
                        <td class="addFactorTd-14"> <input type="text" value="" class="td-input td-inputAllPriceAfterTakhfifAdd  form-control"> </td>
                        <td class="addFactorTd-15"> <input type="text" value="" class="td-input td-inputFactorNumAdd form-control"> </td>
                        <td class="addFactorTd-16"> <input type="text" value="" class="td-input td-inputFactorDateAdd form-control"> </td>
                        <td class="addFactorTd-17"> <input type="text" value="" class="td-input td-inputFactorDescAdd form-control"> </td>
                        <td class="addFactorTd-18"> <input type="text" value="" class="td-input td-inputStockAdd form-control"> </td>
                        <td class="addFactorTd-19"> <input type="text" value="" class="td-input td-inputMaliatAdd form-control"> </td>
                        <td class="addFactorTd-20"> <input type="text" value="" class="td-input td-inputWeightUnitAdd form-control"> </td>
                        <td class="addFactorTd-21"> <input type="text" value="" class="td-input td-inputAllWeightAdd form-control"> </td>
                        <td class="addFactorTd-22"> <input type="text" value="" class="td-input  td-inputInserviceAdd form-control"> </td>
                        <td class="addFactorTd-23"> <input type="text" value="" class="td-input  td-inputPercentMaliatAdd form-control"> </td>
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
            case "factorEditListBody":
                {
                    let rowindex=$(event.target).parents("tr").index()
                    let goodSn=parseInt($('#factorEditListBody tr:nth-child('+rowindex+') td:nth-child(2)').children("input[type='checkbox']").val());
                    if(isNaN(goodSn)){
                        $("#factorEditListBody tr:last").remove();
                        $("#factorEditListBody tr:last td:nth-child(2)").children('input').focus();
                        $("#factorEditListBody tr").removeClass("selected");
                        $("#factorEditListBody tr:last").addClass("selected");
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

function setActiveFormFactor(activeFormId){
    activeFormF=activeFormId;
}

function openFactorViewModal(factorId){
    $.get(baseUrl+"/getFactorInfoForEdit",{SnFactor:factorId},(respond,status)=>{
        $("#customerForFactorIdView").val(respond.factorInfo[0].PSN);
        $("#FactNoView").val(respond.factorInfo[0].FactNo);
        $("#SerialNoHDSView").val(respond.factorInfo[0].SerialNoHDS);
        $("#NameView").val(respond.factorInfo[0].Name);
        $("#FactDateView").val(respond.factorInfo[0].FactDate);
        $("#bazaryabNameView").val(respond.factorInfo[0].BName);
        $("#bazaryabCodeView").val(respond.factorInfo[0].BPCode);
        $("#pCodeView").val(respond.factorInfo[0].PCode);
        $("#ّFactDescView").val(respond.factorInfo[0].FactDesc);
        $("#MotafariqahNameView").val(respond.factorInfo[0].OtherCustName);
        $("#MotafariqahMobileView").val(respond.factorInfo[0].MobileOtherCust);
        $("#customerForFactorView").empty();
        $("#customerForFactorView").append(`<option value="${respond.factorInfo[0].PSN}">${respond.factorInfo[0].Name}</option>`);
        let amelInfo=respond.amelInfo;
        let allAmel=0;
        amelInfo.forEach((element,index)=>{
            allAmel+=parseInt(element.Price);
            switch(element.SnAmel){
                case '142':
                    {
                        $("#hamlMoneyModalFView").val(parseInt(element.Price).toLocaleString("en-us"));
                        $("#hamlDescModalFView").val(element.DescItem);
                    }
                    break;
                case '143':
                    {
                        $("#nasbMoneyModalFView").val(parseInt(element.Price).toLocaleString("en-us"));
                        $("#nasbDescModalFView").val(element.DescItem);
                    }
                    break;
                case '144':
                    {
                        $("#motafariqaMoneyModalFView").val(parseInt(element.Price).toLocaleString("en-us"));
                        $("#motafariqaDescModalFView").val(element.DescItem);
                    }
                    break;
                case '168':
                    {
                        $("#bargiriMoneyModalFView").val(parseInt(element.Price).toLocaleString("en-us"));
                        $("#bargiriDescModalFView").val(element.DescItem);
                    }
                    break;
                case '188':
                    {
                        $("#tarabariMoneyModalFView").val(parseInt(element.Price).toLocaleString("en-us"));
                        $("#tarabariDescModalFView").val(element.DescItem);
                    }
                    break;
            }
        });
        $("#allAmelMoneyFView").text(allAmel.toLocaleString("en-us"));
        let bdbsState=" تسویه "
        let bdbsColor="white"
        if(respond.factorInfo[0].CustomerStatus>0){
            bdbsState="  بستانکار"
            bdbsColor="black"
        }
        if(respond.factorInfo[0].CustomerStatus<0){
            bdbsState="  بدهکار" 
            bdbsColor="red"
        }
        $("#lastCustomerStatusFView").text(parseInt(respond.factorInfo[0].CustomerStatus).toLocaleString("en-us")+bdbsState);
        $("#allMoneyTillEndRowFView").text(parseInt(respond.factorInfo[0].NetPriceHDS).toLocaleString("en-us"));
        $("#newOrderTakhfifInputFView").val(parseInt(respond.factorInfo[0].Takhfif).toLocaleString("en-us"))
        $("#sumAllRowMoneyAfterTakhfifFView").text(parseInt(respond.factorInfo[0].TotalPriceHDS).toLocaleString("en-us"))
        $("#factorAddressView").empty();
        respond.phones.forEach((element,index)=>{
            if(element.AddressPeopel != respond.factorInfo[0].OtherAddress){
                $("#factorAddressView").append(`<option value='${element.SnPeopelAddress}_${element.AddressPeopel}'> ${element.AddressPeopel} </option>`);
            }else{
                $("#factorAddressView").append(`<option value='${element.SnPeopelAddress}_${element.AddressPeopel}' selected> ${element.AddressPeopel} </option>`);
            }
         })
        if(respond.factorInfo[0].SnAmel==142){
            $("#ّtakeKerayahView").prop("checked",true)
        }
        
        $("#sockView").empty()
        respond.stocks.forEach((element,index)=>{
            if(element.SnStock!= respond.factorInfo[0].SnStockIn){
                $("#stockView").append(`<option value="${element.SnStock}">${element.NameStock}</option>`);
            }else{
                $("#stockView").append(`<option value="${element.SnStock}" selected>${element.NameStock}</option>`);
            }
        })
        $("#factorViewListBody").empty();
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
            $("#factorViewListBody").append(`
                <tr class="factorTablRow" onclick="checkAddedKalaAmountOfFactorView(this)">
                    <td class="td-part-input"> ${index+1} <input type="radio" value="${element.Amount}" style="display:none" /> </td>
                    <td class="td-part-input"> <input type="text" name="GoodCde${element.GoodSn}" value="${element.GoodCde}" class="td-input td-inputCodeFView form-control" required> <input type="radio" value="`+element.AmountUnit+`" class="td-input form-control"> <input type="checkbox" name="editableGoods[]" checked style="display:none" value="${element.GoodSn}"/> </td>
                    <td class="td-part-input"> <input type="text" name="NameGood${element.GoodSn}"  style="width:auto!important;" value="${element.NameGood}" class="td-input td-inputCodeNameFView form-control" required> </td>
                    <td class="td-part-input"> <input type="text" name="FirstUnit${element.GoodSn}" value="${element.FirstUnit}" class="td-input td-inputFirstUnitFView form-control" required> </td>
                    <td class="td-part-input"> <input type="text" name="SecondUnit${element.GoodSn}" value="${element.SecondUnit}" class="td-input td-inputSecondUnitFView form-control" required> </td>
                    <td class="td-part-input"> <input type="text" name="PackAmnt${element.GoodSn}" value="${parseInt(packAmount).toLocaleString("en-us")}" class="td-input  td-inputSecondUnitAmountFView form-control" required> </td>
                    <td class="td-part-input"> <input type="text" name="JozeAmountView${element.GoodSn}" value="${parseInt(element.Amount%element.AmountUnit).toLocaleString("en-us")}" class="td-input td-inputJozeAmountFView form-control" required> </td>
                    <td class="td-part-input"> <input type="text" name="FirstAmount${element.GoodSn}" value="${parseInt(firstAmount).toLocaleString("en-us")}" class="td-input td-inputFirstAmountFView form-control" required> </td>
                    <td class="td-part-input"> <input type="text" name="ReAmount${element.GoodSn}" value="${parseInt(reAmount).toLocaleString("en-us")}" class="td-input td-inputReAmountFView form-control" required> </td>
                    <td class="td-part-input"> <input type="text" name="Amount${element.GoodSn}" value="${parseInt(element.Amount).toLocaleString("en-us")}" class="td-input  td-AllAmountFView form-control" required> </td>
                    <td class="td-part-input"> <input type="text" name="Fi${element.GoodSn}" value="${parseInt(element.Fi).toLocaleString("en-us")}" class="td-input td-inputFirstUnitPriceFView form-control" required> </td>
                    <td class="td-part-input"> <input type="text" name="FiPack${element.GoodSn}" value="${parseInt(element.FiPack).toLocaleString("en-us")}" class="td-input td-inputSecondUnitPriceFView form-control" required> </td>
                    <td class="td-part-input"> <input type="text" sytle="width:100%!important;" size="" name="Price${element.GoodSn}" value="${parseInt(element.Price).toLocaleString("en-us")}" class="td-input td-inputAllPriceFView form-control" required> </td>
                    <td class="td-part-input"> <input type="text" name="PriceAfterTakhfif${element.GoodSn}" value="${parseInt(element.PriceAfterTakhfif).toLocaleString("en-us")}" class="td-input td-inputAllPriceAfterTakhfifFView  form-control" required> </td>
                    <td class="td-part-input"> <input type="text" name="" value="0" class="td-input td-inputFactorNumFView form-control" required> </td>
                    <td class="td-part-input"> <input type="text" name="" value="0" class="td-input td-inputFactorDateFView form-control" required> </td>
                    <td class="td-part-input"> <input type="text" name="" value="0" class="td-input td-inputFactorDescFView form-control" required> </td>
                    <td class="td-part-input"> <input type="text" name="NameStock${element.GoodSn}" value="0" class="td-input td-inputStockFView form-control" required> </td>
                    <td class="td-part-input"> <input type="text" name="Price3PercentMaliat${element.GoodSn}" value="${element.Price3PercentMaliat}" class="td-input td-inputMaliatFView form-control" required> </td>
                    <td class="td-part-input"> <input type="text" name="Fi2Weight${element.GoodSn}" value="${element.Fi2Weight}" class="td-input td-inputWeightUnitFView form-control" required> </td>
                    <td class="td-part-input"> <input type="text" name="Amount2Weight${element.GoodSn}" value="${element.Amount2Weight}" class="td-input td-inputAllWeightFView form-control" required> </td>
                    <td class="td-part-input"> <input type="text" name="Service${element.GoodSn}" value="0" class="td-input  td-inputInserviceFView form-control" required> </td>
                    <td class="td-part-input"> <input type="text" name="PercentMaliat${element.GoodSn}" value="0" class="td-input  td-inputPercentMaliatFView form-control" required> </td>
                    <td class="td-part-input d-none"> 
                        <input type="text" value="`+element.lastBuyFi+`" class="td-input form-control">
                    </td>
                </tr>
            `);
        })
        $('#factorViewModal').modal({
            backdrop: false,
            show: true
        });
    })

    if (!($('.modal.in').length)) {
        $('.modal-dialog').css({
            top: 0,
            left: 0
        });
    }


    $('.modal-dialog').draggable({
        handle: ".modal-header"
    });
}

function closeFactoViewModal(){
    $("#factorViewModal").modal("hide")
}

function checkAddedKalaAmountOfFactorView(row){
    let input = $(row).find('input:checkbox');
    let goodSn=$(input).val();
    $("#selectedGoodSn").val(goodSn);
    if(!goodSn){
        return
    }
    let customerSn=$("#customerForFactorView").val();

    let rowindex=$(row).index()+1
    let totalMoneyTillRow=0;

    for (let index = 1; index <=rowindex; index++) {

        totalMoneyTillRow+=parseInt($('#factorViewListBody tr:nth-child('+index+') td:nth-child(14)').children('input').val().replace(/,/g, ''));
    
    }
    $("#allMoneyTillThisRowFView").text(parseInt(totalMoneyTillRow).toLocaleString("en-us"));

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
                $("#firstViewExistInStock").text(parseInt(amount).toLocaleString("en-us"));
            }else{
                $("#firstViewExistInStock").text(0);
            }

        }else{
            $("#firstViewExistInStock").text(0);
        }

        if(respond[2][0]){
            if(!isNaN(respond[2][0].Price3)){
                let price=0;
                if(respond[2][0].Price3>=1){
                    price=respond[2][0].Price3
                }
                $("#firstViewPrice").text(parseInt(price).toLocaleString("en-us"));
            }else{
                $("#firstViewPrice").text(0);
            }

        }else{
            $("#firstViewPrice").text(0);
        }

        if(respond[4][0]){
            if(!isNaN(respond[4][0].Fi)){
                let fi=0;
                if(respond[4][0].Fi>=1){
                    fi=respond[4][0].Fi;
                }
                $("#firstViewLastPriceCustomer").text(parseInt(fi).toLocaleString("en-us"));
            }else{
                $("#firstViewLastPriceCustomer").text(0);                
            }
        }else{
            $("#firstViewLastPriceCustomer").text(0);
        }

        if(respond[3][0]){
            if(!isNaN(respond[3][0].Fi)){
                let fi=0;
                if(respond[3][0].Fi>=1){
                    fi=respond[3][0].Fi
                }
                $("#firstViewLastPrice").text(parseInt(fi).toLocaleString("en-us"));
            }else{
                $("#firstViewLastPrice").text(0);  
            }
        }else{
            $("#firstViewLastPrice").text(0);
        }
    });
    const previouslySelectedRow = document.querySelector('.selected');
    if(previouslySelectedRow) {
        previouslySelectedRow.classList.remove('selected');
    }
    row.classList.add('selected');
}

function showAmelModalFView(){
    if (!$(".modal.in").length) {
        $(".modal-dialog").css({
            top: 0,
            left: 0,
        });
    }
    $(".modal-dialog").draggable({
        handle: ".modal-header",
    });
    $("#addAmelModalFView").modal("show")
}

function closeAmelView(){
    $("#addAmelModalFView").modal("hide")
}
function closeGardishKalaModal(){
    $("#kalaGardishModal").modal("hide")   
}

function closeLastTenBuyModal(){
    $("#lastTenBuysModal").modal("hide")
}

function closeLastTenSalesModal(){
    $("#lastTenSalesModal").modal("hide")
}
function closeUnsentOrderModal(){
    $("#unSentOrdersModal").modal("hide")
}

$("#filterRFactorsForm").on("submit",function(e){
    e.preventDefault();
    $.ajax({
        method: $(this).attr('method'),
        url: $(this).attr('action'),
        data:$(this).serialize(),
        processData: false,
        contentType: false,
        success: function (respond) {
            $("#factorRListBody").empty();
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
                if(element.StatusFact==1){
                    trStyle="background-color:#ff8040";
                }
                if(element.TotalPricePorsant>0){
                    bazaryabPorsant=element.TotalPricePorsant;
                }
                if(element.payedMoney>0){
                    payedAmount=element.payedMoney;
                }
                $("#factorRListBody").append(`<tr class="factorTablRow"  ondblclick="openFactorViewModal(${element.SerialNoHDS})" style="${trStyle}" onclick="getFactorOrders(this,${element.SerialNoHDS})">
                                                <td> ${index+1} <input type="radio" value="${element.SerialNoHDS}" class="d-none"/></td>
                                                <td> ${element.FactNo} </td>
                                                <td> ${element.FactDate} </td>
                                                <td> ${element.FactDesc} </td>
                                                <td> ${element.PCode} </td>
                                                <td> ${element.Name} </td>
                                                <td> ${parseInt(element.NetPriceHDS).toLocaleString("en-us")} </td>
                                                <td> ${parseInt(payedAmount).toLocaleString("en-us")} </td>
                                                <td> ${element.setterName} </td>
                                                <td> حضوری </td>
                                                <td> </td>
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
function factorHistoryR(historyWord) {
    $.get(baseUrl+"/getFactorHistory",{historyWord:historyWord,factType:4},(respond,status)=>{
            $("#factorRListBody").empty();
            respond.forEach((element,index) =>{
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
                if(element.payedMoney>0){
                    payedAmount=element.payedMoney;
                }
                $("#factorRListBody").append(`
                                            <tr class="factorTablRow" style="${trStyle}" ondblclick="openFactorViewModal(${element.SerialNoHDS})" onclick="getFactorOrders(this,${element.SerialNoHDS})">
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
                                                <td> </td>
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
    })
}

$("#filterBuyFactorsForm").on("submit",function(e){
    e.preventDefault();
    $.ajax({
        method: $(this).attr('method'),
        url: $(this).attr('action'),
        data:$(this).serialize(),
        processData: false,
        contentType: false,
        success: function (respond) {
            $("#factorBListBody").empty();
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
                if(element.StatusFact==1){
                    trStyle="background-color:#ff8040";
                }
                if(element.TotalPricePorsant>0){
                    bazaryabPorsant=element.TotalPricePorsant;
                }
                if(element.payedMoney>0){
                    payedAmount=element.payedMoney;
                }
                $("#factorBListBody").append(`<tr class="factorTablRow"  ondblclick="openFactorViewModal(${element.SerialNoHDS})" style="${trStyle}" onclick="getFactorOrders(this,${element.SerialNoHDS})">
                                                <td> ${index+1} <input type="radio" value="${element.SerialNoHDS}" class="d-none"/></td>
                                                <td> ${element.FactNo} </td>
                                                <td> ${element.FactDate} </td>
                                                <td> ${element.FactDesc} </td>
                                                <td> ${element.PCode} </td>
                                                <td> ${element.Name} </td>
                                                <td> ${parseInt(element.NetPriceHDS).toLocaleString("en-us")} </td>
                                                <td> ${parseInt(payedAmount).toLocaleString("en-us")} </td>
                                                <td> ${element.setterName} </td>
                                                <td> حضوری </td>
                                                <td> </td>
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

$("#filterRBuyFactorsForm").on("submit",function(e){
    e.preventDefault();
    $.ajax({
        method: $(this).attr('method'),
        url: $(this).attr('action'),
        data:$(this).serialize(),
        processData: false,
        contentType: false,
        success: function (respond) {
            $("#factorRBListBody").empty();
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
                if(element.StatusFact==1){
                    trStyle="background-color:#ff8040";
                }
                if(element.TotalPricePorsant>0){
                    bazaryabPorsant=element.TotalPricePorsant;
                }
                if(element.payedMoney>0){
                    payedAmount=element.payedMoney;
                }
                $("#factorRBListBody").append(`<tr class="factorTablRow"  ondblclick="openFactorViewModal(${element.SerialNoHDS})" style="${trStyle}" onclick="getFactorOrders(this,${element.SerialNoHDS})">
                                                <td> ${index+1} <input type="radio" value="${element.SerialNoHDS}" class="d-none"/></td>
                                                <td> ${element.FactNo} </td>
                                                <td> ${element.FactDate} </td>
                                                <td> ${element.FactDesc} </td>
                                                <td> ${element.PCode} </td>
                                                <td> ${element.Name} </td>
                                                <td> ${parseInt(element.NetPriceHDS).toLocaleString("en-us")} </td>
                                                <td> ${parseInt(payedAmount).toLocaleString("en-us")} </td>
                                                <td> ${element.setterName} </td>
                                                <td> حضوری </td>
                                                <td> </td>
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

function factorHistoryBuy(historyWord) {
    $.get(baseUrl+"/getFactorHistory",{historyWord:historyWord,factType:1},(respond,status)=>{
        
            $("#factorBListBody").empty();
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
                if(element.payedMoney>0){
                    payedAmount=element.payedMoney;
                }
                $("#factorBListBody").append(`
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
                                                <td> </td>
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
    })
}

function factorHistoryRBuy(historyWord) {
    $.get(baseUrl+"/getFactorHistory",{historyWord:historyWord,factType:2},(respond,status)=>{
        $("#factorRBListBody").empty();
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
            if(element.payedMoney>0){
                payedAmount=element.payedMoney;
            }
            $("#factorRBListBody").append(`
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
                                            <td> </td>
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
    })
}
