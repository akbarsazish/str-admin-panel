    var baseUrl = "http://192.168.10.21:8000";
    var csrf = document.querySelector("meta[name='csrf-token']").getAttribute('content');
    function getGetAndPayBYS(element,snGetAndPay){
        $("tr").removeClass("selected");
        $(element).addClass("selected");
        $.get(baseUrl+"/getGetAndPayBYS",{snGetAndPay:snGetAndPay},function(respond,status){
            $("#receiveListBodyBYS").empty();
            respond.forEach((element,index) => {
                $("#receiveListBodyBYS").append(`
                   <tr>
                    <td> ${(index+1)} </td>
                    <td> ${element.docTypeName} </td>
                    <td> ${element.ChequeRecNo} </td>
                    <td> ${element.bankDesc} </td>
                    <td> ${parseInt(element.Price).toLocaleString("en-us")} </td>
                    <td> ${element.ChequeNo} </td>
                    <td> ${element.ChequeDate} </td>
                    <td> ${element.SnBank} </td>
                    <td> ${element.Branch} </td>
                    <td> ${element.AccBankno} </td>
                    <td> ${element.Owner} </td>
                    <td> ${element.DocDescBYS} </td>
                    <td> ${element.NoSayyadi} </td>
                    <td> ${element.NameSabtShode} </td>
                </tr>`);
            });
        })
    }

    $("#filterReceivesForm").on("submit",function(e){
        e.preventDefault();
        $.ajax({
            method: $(this).attr('method'),
            url: $(this).attr('action'),
            data:$(this).serialize(),
            processData: false,
            contentType: false,
            success: function (respond) {
                $("#receiveListBody").empty();
                respond.forEach((element,index) => {
                    $("#receiveListBody").append(`<tr class="factorTablRow" onclick="getGetAndPayBYS(this,${element.SerialNoHDS})"  class="factorTablRow">
                                                        <td> ${index+1} </td>
                                                        <td> ${element.DocNoHDS}  </td>
                                                        <td> ${element.DocDate} </td>
                                                        <td> ${element.Name}</td>
                                                        <td> ${element.DocDescHDS} </td>
                                                        <td > ${parseInt(element.NetPriceHDS).toLocaleString("en-us")}  </td>
                                                        <td> ${element.SaveTime}</td>
                                                        <td> ${element.userName}  </td>
                                                        <td > ${element.cashName} </td>
                                                        <td> ${element.DocDescHDS} </td>
                                                    </tr>`);
                })
            },
            error:function(error){

            }
        });
    })

    function openSandoghModalDar(){
        $.get(baseUrl+"/getSandoghs",{userId:12},function(respond,status){
            $("#sandoghSelectInputDar").empty();
            respond.forEach((element,index)=>{
                $("#sandoghSelectInputDar").append(`<option value="${element.SNCash}" >${element.CashName}</optiotn>`)
            })

            $("#sandoghIdDar").val($("#sandoghSelectInputDar").val());
        })

        if (!($('.modal.in').length)) {
            $('.modal-dialog').css({
                top: 0,
                left: 0
            });
        }
        $('#selectSandoghModal').modal({
            backdrop: false,
            show: true
        });

        $('.modal-dialog').draggable({
            handle: ".modal-header"
        });
    }

    function closeSandoghModalDar(){
        $('#selectSandoghModal').modal("hide");
    }

    function openDaryaftModal(){
        closeSandoghModalDar();
        if (!($('.modal.in').length)) {
            $('.modal-dialog').css({
                top: 0,
                left: 0
            });
        }
        $('#daryaftModal').modal({
            backdrop: false,
            show: true
        });

        $('.modal-dialog').draggable({
            handle: ".modal-header"
        });
    }

    function closeDaryaftModal() {
        $("#daryaftModal").modal("hide");        
    }

    function closeDaryaftModalEdit() {
        $("#daryaftModalEdit").modal("hide");        
    }

    function openDaryaftVajhNaghdModal(){
        $("#daryaftVajhNaghdModal").modal("show");
    }

    function closeDaryaftVajhNaghdModal(){
        $("#daryaftVajhNaghdModal").modal("hide")
    }

    function closeDaryaftVajhNaghdModalEdit(){
        $("#daryaftVajhNaghdModalEdit").modal("hide")
    }

    function openChequeInfoModal() {
        $("#chequeInfo").modal("show")
    }

    function closeChequeInfoModal() {
        $("#chequeInfo").modal("hide")
    }

    function closeChequeInfoModalEdit() {
        $("#chequeInfoModalEdit").modal("hide")
    }

    function openHawalaInfoModal() {
        $.get(baseUrl+"/allBanks",(respond,status)=>{
            $("#bankAccNoHawalaDar").empty();
            $("#bankAccNoHawalaDar").append(`<option></option>`);
            for (const element of respond.bankKarts) {
                
                    $("#bankJustAccNoHawalaDar").val(element.AccNo);
                    $("#bankAccNoHawalaDar").append(`<option selected value="${element.AccNo}">${element.bsn}</option>`);
                
            }
        });
        $("#hawalaInfoModal").modal("show");
    }
    function closeHawalaInfoModal() {
        $("#hawalaInfoModal").modal("hide")
    }

    function closeHawalaInfoModalEdit() {
        $("#hawalaInfoModalEdit").modal("hide")
    }

    function openSpentChequeModal(){
        $("#spentChequeModal").modal("show");
    }

    function closeSpentChequeModal(){
        $("#spentChequeModal").modal("hide");
    }

    function closeSpentChequeModalEdit(){
        $("#spentChequeModalEdit").modal("hide");
    }

    function openTakhfifModal(){
        $("#takhfifModal").modal("show")
    }

    function closeTakhfifModal(){
        $("#takhfifModal").modal("hide")
    }

    function closeTakhfifModalEdit(){
        $("#takhfifModalEdit").modal("hide")
    }

    function openVarizToOthersHisbModal(){
        $("#varizToOthersHisbModal").modal("show");
    }

    function closeVarizToOthersHisbModal(){
        $("#varizToOthersHisbModal").modal("hide");
    }

    function closeVarizToOthersHisbModalEdit(){
        $("#varizToOthersHisbModalEdit").modal("hide");
    }

    function openRelatedFactorsModal(){
        if($("#customerIdDaryaft").val().length>0){
            $("#relatedFactorsModal").modal("show");

        }else{
            swal({text:"ابتدا طرف حساب را انتخاب کنید",
                confirm:true,
                })
        }
    }

    function closeRelatedFactorsModal(){
        $("#relatedFactorsModal").modal("hide");
    }

    function openSearchFactorModal(){
        $("#searchFactorModal").modal("show")
    }

    function closeSearchFactorModal(){
        $("#searchFactorModal").modal("hide")
    }

    function openCustomerGardishModal(){
        $("#customerGardishModal").modal("show")
    }

    function closeCustomerGardishModal(){
        $("#customerGardishModal").modal("hide")
    }

    function openRasDaryaftItemModal(){
        $("#rasDaryaftItemModal").modal("show")
    }
    function closeRasDaryaftItemModal(){
        $("#rasDaryaftItemModal").modal("hide")
    }



    $("#addDaryaftDate").persianDatepicker({
        cellWidth: 32,
        cellHeight: 22,
        fontSize: 14,
        formatDate: "YYYY/0M/0D",
        endDate: "1440/5/5",
    });



    $("#customerCodeDaryaft").on("keyup",function(e){
        $.get(baseUrl+"/getCustomerInofByCode",{pcode:$("#customerCodeDaryaft").val()},function(respond,status){
            $("#customerNameDaryaft").val(respond[0].Name);
            $("#customerIdDaryaft").val(respond[0].PSN);
        })
    })

    $("#customerNameDaryaft").on("keyup",function(respond,status){
        $("#searchCustomerDaryaftModal").modal("show")
    })
    function closeSearchCustomerDaryaftModal(){
        $("#searchCustomerDaryaftModal").modal("hide")
    }
    
    $("#customerNameSearchDar").on("keyup",(event)=>{
        let name=$("#customerNameSearchDar").val();
        if(event.keyCode!=40){
            if(event.keyCode!=13){
                let searchByPhone="";
                if($("#byPhoneSearchDar").is(":checked")){
                    searchByPhone="on";
                }else{
                    searchByPhone="";
                }
                $.get("/getCustomerForOrder",{namePhone:name,searchByPhone:searchByPhone},(respond,status)=>{
                    $("#customerForDaryaftListBody").empty();
                    let i=1;
                    for (const element of respond) {
                        i+=1;
                        $("#customerForDaryaftListBody").append(`<tr onclick="setDaryaftCustomerStuff(this,${element.PSN})">
                                                                    <td>  ${i}  </td>
                                                                    <td>  ${element.Name}  </td>
                                                                    <td>  ${element.PhoneStr}  </td>
                                                                    <td>    </td>
                                                                    <td>    </td>
                                                                    <td>    </td>
                                                                </tr>`);
                    }
                })
            }
        }
    })

    function setDaryaftCustomerStuff(element,psn){
        $("tr").removeClass("selected");
        $(element).addClass("selected")
        $("#selectCustomerForDaryaftBtn").val(psn)
    }

    function chooseCustomerForDaryaft(psn){
        $.get("/getInfoOfOrderCustomer",{psn:psn},(respond,status)=>{
            $("#customerCodeDaryaft").val(respond[0].PCode);
            $("#customerNameDaryaft").val(respond[0].Name);
            $("#customerIdDaryaft").val(respond[0].PSN);
        });
        $("#searchCustomerDaryaftModal").modal("hide")
    }

    $("#inforTypeDaryaft").on("change",(element,index)=>{
        $.get(baseUrl+"/getInforTypeInfo",{SnInfor:$("#inforTypeDaryaft").val()},(respond,status)=>{
            $("#inforTypeCodeDar").val(respond[0].InforCode);
        })
    })

    $("#searchFactorToDaryaft").on("keyup",(event)=>{
        $.get(baseUrl+"/getFactorInfoByFactNo",{factNo:$("#searchFactorToDaryaft").val(),CustomerSn:$("#customerIdDaryaft").val()},(respond,status)=>{
            $("#searchedFactorForDarListBody").empty();
            let i=1;
            for (const element of respond) {
                i+=1;
                $("#searchedFactorForDarListBody").append(`<tr onclick="selecFactorForAddToDar(this,${element.SerialNoHDS})">
                                                                <td>${i}</td>
                                                                <td>${element.FactType}</td>
                                                                <td>${element.FactNo}</td>
                                                                <td>${element.FactDate}</td>
                                                                <td>${element.TotalPriceHDS}</td>
                                                                <td>${element.FactDesc}</td>
                                                            </tr>`);
            }
        })
    })

    function selecFactorForAddToDar(element,snFactor){
        $("tr").removeClass("selected");
        $(element).addClass("selected");
        $("#selectFactorForAddToDarBtn").val(snFactor);
    }

    function chooseFactorForAddToDar(snFactor){
        $.get(baseUrl+"/getFactorInfoBySnFactor",{SnFact:snFactor},(respond,status)=>{
            $("#addedFactorsToDarListBoday").empty();
            respond.forEach((element,index)=>{
                $("#addedFactorsToDarListBoday").append(`<tr onclick="selectAddedFactorForDarStuff(this,${element.SerialNoHDS})">
                                                            <td>${index}</td>
                                                            <td>${element.FactType}</td>
                                                            <td>${element.FactNo}</td>
                                                            <td>${element.FactDate}</td>
                                                            <td>${element.TotalPriceHDS}</td>
                                                            <td>${element.FactDesc}</td>
                                                        </tr>`); 
            })
        })
        $("#searchFactorModal").modal("hide")
    }
    
    function selectAddedFactorForDarStuff(element,snFact){
        $("tr").removeClass("selected");
        $(element).addClass("selected");
        $("#deleteAddedFactorForDarBtn").val(snFact)
    }

    function deleteAddedFactorForDar(){
        swal({text:"آیا می خواهدی حذف کیند؟",
              buttons:true,
            }).then((willDelete)=>{
                if(willDelete){
                    $("#addedFactorsToDarListBoday tr.selected").remove();
                }
            })
    }

    function addNaghdMoneyDar(){
        let rials=$("#rialNaghdDar").val().replace(/,/g, '');
        let description=$("#descNaghdDar").val();
        var rowCount = $("#addedDaryaftListBody tr").length;
        $("#addedDaryaftListBody").append(` <tr ondblclick="editDaryaftItem('daryaftVajhNaghdModalEdit',this)">
                                                <td> ${(rowCount+1)} </td>
                                                <td> 0 </td>
                                                <td> ${description} </td>
                                                <td> ${parseInt(rials).toLocaleString("en-us")} </td>
                                                <td>  </td>
                                                <td>  </td>
                                                <td>  </td>
                                            </tr>`);
        $("#daryaftVajhNaghdModal").modal("hide")
        let netPriceHDS=0;
        for (let index = 1; index <= rowCount+1; index++) {
            netPriceHDS+= parseInt($(`#addedDaryaftListBody tr:nth-child(${index}) td:nth-child(4)`).text().replace(/,/g, ''));
            
        }
        $("#netPriceDar").text(parseInt(netPriceHDS).toLocaleString("en-us"));
        $("#totalNetPriceHDSDar").val(netPriceHDS);
        
    }

    $("#checkSarRasidDateDar").persianDatepicker({
        cellWidth: 32,
        cellHeight: 22,
        fontSize: 14,
        formatDate: "YYYY/0M/0D",
        endDate: "1440/5/5",
        onSelect: () => {
            if ($("#checkSarRasidDateDar").val().length > 0) {
                var pd = new persianDate();
                var value = pd.parse($("#checkSarRasidDateDar").val());
                var jdf = new jDateFunctions("Y-M-d");
                $('#checkMiladiSarRasidDateDar').val(jdf.getGDate(value)._toString("YYYY-MM-DD"));
            }
        }
    });

    $("#daysAfterChequeDateDar").on("keyup",function(e){
        let daysLater=$("#daysAfterChequeDateDar").val();
        if(parseInt(daysLater)>0){
            let chequeDate=$("#checkSarRasidDateDar").data("gdate");
            let laterChequeDate=new Date(chequeDate);
            let newDate=new Date().setDate(laterChequeDate.getDate() + parseInt(daysLater))
            let updateDateHijri=new Intl.DateTimeFormat('fa-IR', { year: 'numeric', month: '2-digit', day: '2-digit' }).format(newDate);
            $("#checkSarRasidDateDar").val(updateDateHijri);
        }else{
            let chequeDate=$("#checkSarRasidDateDar").data("gdate");
            let laterChequeDate=new Date(chequeDate);
            let newDate=new Date().setDate(laterChequeDate.getDate() + parseInt(0))
            let updateDateHijri=new Intl.DateTimeFormat('fa-IR', { year: 'numeric', month: '2-digit', day: '2-digit' }).format(newDate);
            $("#checkSarRasidDateDar").val(updateDateHijri);
        }
    })

    $("#moneyChequeDar").on("keyup",()=>{
        let moneyAmount=$("#moneyChequeDar").val();
        changeNumberToLetter($("#moneyChequeDar"),"moneyInLetters",moneyAmount)
    })

    function changeNumberToLetter(element,containerId,mynumber) {
        let number=mynumber.replace(/,/g, '');
        const first = ['','یک ','دو ','سه ','چهار ', 'پنج ','شش ','هفت ','هشت ','نه ','ده ','یازده ','دوازده ','سیزده ','چهارده ','پانزده ','شانزده ','هفده ','هیجده ','نزده '];
        const tens = ['', '', 'بیست','سی','چهیل','پنجاه', 'شصت','هفتاد','هشتاد','نود'];
        const mad = ['', 'هزار', 'میلیون', 'میلیارد', 'بیلیون', 'تریلیون'];
        let word = '';

        for (let i = 0; i < mad.length; i++) {
          let tempNumber = number%(100*Math.pow(1000,i));
          if (Math.floor(tempNumber/Math.pow(1000,i)) !== 0) {
            if (Math.floor(tempNumber/Math.pow(1000,i)) < 20) {
              word = first[Math.floor(tempNumber/Math.pow(1000,i))] + mad[i] + ' ' + word;
            } else {
              word = tens[Math.floor(tempNumber/(10*Math.pow(1000,i)))] + '-' + first[Math.floor(tempNumber/Math.pow(1000,i))%10] + mad[i] + ' ' + word;
            }
          }
          tempNumber = number%(Math.pow(1000,i+1));
          if (Math.floor(tempNumber/(100*Math.pow(1000,i))) !== 0) word = first[Math.floor(tempNumber/(100*Math.pow(1000,i)))] + 'صد ' + word;
        }
        document.getElementById(containerId).textContent = word + " ریال ";
    }

    $("#shobeBankChequeDar").on("click",()=>{
        $.get(baseUrl+"/getAllShobeBanks",function(respond,status){
            $("#shobeBankChequeDarBody").empty();
            respond.forEach((element,index)=>{
                $("#shobeBankChequeDarBody").append(`<tr onclick="selectShobeBankForChequeDar(this,${element.snbranch})" ><td>${(index+1)}</td><td>${element.namebranch}</td></tr>`);
            })
            $("#shobeBankChequeDarMadal").modal("show");
        })
    })
    function closeShobeBankChequeDarMadal(){
        $("#shobeBankChequeDarMadal").modal("hide");
    }
    function selectShobeBankForChequeDar(element,snbranch){
        $("#shobeBankChequeDarBody tr").removeClass("selected");
        $(element).addClass("selected")
    }

    function addChequeDar(){
        let chequeNoCheqeDar=$("#chequeNoCheqeDar").val();
        let checkSarRasidDateDar=$("checkSarRasidDateDar").val();
        let bankNameDar=$("bankNameDar").val();
        let moneyChequeDar=$("#moneyChequeDar").val();
        let shobeBankChequeDar=$("#shobeBankChequeDar").val();
        let hisabNoChequeDar=$("#hisabNoChequeDar").val();
        let sayyadiNoChequeDar=$("#sayyadiNoChequeDar").val();
        let sabtBeNameChequeDar=$("#sabtBeNameChequeDar").val();
        let malikChequeDar=$("#malikChequeDar").val();
        let repeateChequeDar=$("#repeateChequeDar").val();
        let distanceMonthChequeDar=$("#distanceMonthChequeDar").val();
        let distanceDarChequeDar=$("#distanceDarChequeDar").val();
        let rowCount=$("#addedDaryaftListBody tr").length;
        $("#addedDaryaftListBody").append(`<tr  ondblclick="editDaryaftItem('chequeInfoModalEdit',this)">
                                            <td> 1 </td>
                                            <td> ${chequeNoCheqeDar} </td>
                                            <td> بعدا اضافه شود </td>
                                            <td> ${parseInt(moneyChequeDar).toLocaleString("en-us")} </td>
                                            <td> 0 </td>
                                            <td> ${sayyadiNoChequeDar} </td>
                                            <td> ${sabtBeNameChequeDar} </td>
                                        </tr>`);
        $("#chequeInfo").modal("hide");

        let netPriceHDS=0;
        for (let index = 1; index <= rowCount+1; index++) {
            netPriceHDS+= parseInt($(`#addedDaryaftListBody tr:nth-child(${index}) td:nth-child(4)`).text().replace(/,/g, ''));
            
        }
        $("#netPriceDar").text(parseInt(netPriceHDS).toLocaleString("en-us"));
        $("#totalNetPriceHDSDar").val(netPriceHDS);
    }

    function addHawalaDar(){
        let hawalaNoHawalaDar=$("#hawalaNoHawalaDar").val();
        let bankAccNoHawalaDar=$("#bankAccNoHawalaDar").val();
        let payanehKartKhanNoHawalaDar=$("#payanehKartKhanNoHawalaDar").val();
        let monyAmountHawalaDar=$("#monyAmountHawalaDar").val();
        let hawalaDateHawalaDar=$("#hawalaDateHawalaDar").val();
        let discriptionHawalaDar=$("#discriptionHawalaDar").val();
        let rowCount=$("#addedDaryaftListBody tr").length;
        $("#addedDaryaftListBody").append(`<tr ondblclick="editDaryaftItem('hawalaInfoModalEdit',this)">
                <td> 1 </td>
                <td> 0 </td>
                <td> بعدا اضافه شود </td>
                <td> ${parseInt(monyAmountHawalaDar).toLocaleString("en-us")} </td>
                <td> 0 </td>
                <td>  </td>
                <td>  </td>
            </tr>`);
        $("#hawalaInfoModal").modal("hide");
        let netPriceHDS=0;
        for (let index = 1; index <= rowCount+1; index++) {
            netPriceHDS+= parseInt($(`#addedDaryaftListBody tr:nth-child(${index}) td:nth-child(4)`).text().replace(/,/g, ''));
            
        }
        $("#netPriceDar").text(parseInt(netPriceHDS).toLocaleString("en-us"));
        $("#totalNetPriceHDSDar").val(netPriceHDS);
    }
    $("#hawalaDateHawalaDar").persianDatepicker({
        cellWidth: 32,
        cellHeight: 22,
        fontSize: 14,
        formatDate: "YYYY/0M/0D",
        endDate: "1440/5/5",
    });

    $("#bankAccNoHawalaDar").on("change",(e)=>{
        $("#bankJustAccNoHawalaDar").val($("#bankAccNoHawalaDar").val());
    })

    function addTakhfifDar(){
        let takhfifMoneyDar=$("#takhfifMoneyDar").val();
        let discriptionTakhfifDar=$("#discriptionTakhfifDar").val();
        let rowCount=$("#addedDaryaftListBody tr").length;
        $("#addedDaryaftListBody").append(`<tr ondblclick="editDaryaftItem('takhfifModalEdit',this)">
                                                <td> 1 </td>
                                                <td> 0 </td>
                                                <td> بعدااضافه شود </td>
                                                <td> ${takhfifMoneyDar} </td>
                                                <td> 0 </td>
                                                <td>  </td>
                                                <td>  </td>
                                            </tr>`);
        $("#takhfifModal").modal("hide");
        let netPriceHDS=0;
        for (let index = 1; index <= rowCount+1; index++) {
            netPriceHDS+= parseInt($(`#addedDaryaftListBody tr:nth-child(${index}) td:nth-child(4)`).text().replace(/,/g, ''));
            
        }
        $("#netPriceDar").text(parseInt(netPriceHDS).toLocaleString("en-us"));
        $("#totalNetPriceHDSDar").val(netPriceHDS);
    }

$("#varizBehisabDigariCustomerCodeDar").on("keyup",function(e){
    $.get(baseUrl+"/getCustomerInofByCode",{pcode:$("#varizBehisabDigariCustomerCodeDar").val()},function(respond,status){
        $("#varizBehisabDigariCustomerNameDar").val(respond[0].Name);
        $("#varizBehisabDigariCustomerPSNDar").val(respond[0].PSN);
    })
})

$("#varizBehisabDigariCustomerNameDar").on("keyup",function(event){
    $("#searchCustomerOtherHisabDaryaftModal").modal("show");
})

$("#customerNameOtherHisabSearchDar").on("keyup",function(event){
    let name=$("#customerNameOtherHisabSearchDar").val();
    if(event.keyCode!=40){
        if(event.keyCode!=13){
            let searchByPhone="";
            if($("#byPhoneSearchDar").is(":checked")){
                searchByPhone="on";
            }else{
                searchByPhone="";
            }
            $.get("/getCustomerForOrder",{namePhone:name,searchByPhone:searchByPhone},(respond,status)=>{
                $("#customerForDaryaftOtherHisabVarizListBody").empty();
                let i=1;
                for (const element of respond) {
                    i+=1;
                    $("#customerForDaryaftOtherHisabVarizListBody").append(`<tr onclick="setDaryaftCustomerOtherHisabStuff(this,${element.PSN})">
                                                                <td>  ${i}  </td>
                                                                <td>  ${element.Name}  </td>
                                                                <td>  ${element.PhoneStr}  </td>
                                                                <td>    </td>
                                                                <td>    </td>
                                                                <td>    </td>
                                                            </tr>`);
                }
            })
        }
    }
})

function setDaryaftCustomerOtherHisabStuff(element,psn){
    $("#customerForDaryaftOtherHisabVarizListBody tr").removeClass("selected");
    $(element).addClass("selected");
    $("#selectCustomerForDaryaftOtherHisabBtn").val(psn)
}

function chooseCustomerForOtherHisabDaryaft(psn){
    $.get("/getInfoOfOrderCustomer",{psn:psn},(respond,status)=>{
        $("#varizBehisabDigariCustomerCodeDar").val(respond[0].PCode);
        $("#varizBehisabDigariCustomerNameDar").val(respond[0].Name);
        $("#varizBehisabDigariCustomerPSNDar").val(respond[0].PSN);
    });
    $("#searchCustomerOtherHisabDaryaftModal").modal("hide")
}

$("#moneyVarizToOtherHisabDar").on("keyup",function(event){
    let moneyAmount=$("#moneyVarizToOtherHisabDar").val();
    changeNumberToLetter($("#moneyVarizToOtherHisabDar"),"moneyVarizToOtherHisabLetterDar",moneyAmount)
})

function addVarizToOtherHisab(){
    let moneyVarizToOtherHisabDar=$("#moneyVarizToOtherHisabDar").val();
    let cartNoVarizToOtherDar=$("#cartNoVarizToOtherDar").val();
    let moneyVarizToOtherHisabLetterDar=$("#moneyVarizToOtherHisabLetterDar").val();
    let varizBehisabDigariCustomerCodeDar=$("#varizBehisabDigariCustomerCodeDar").val();
    let varizBehisabDigariCustomerNameDar=$("#varizBehisabDigariCustomerNameDar").val();
    let varizBehisabDigariCustomerPSNDar=$("#varizBehisabDigariCustomerPSNDar").val();
    let benamOtherHisabDar=$("#benamOtherHisabDar").val();
    let paygiriOtherHisabDar=$("#paygiriOtherHisabDar").val();
    let discriptionOtherHisabDar=$("#discriptionOtherHisabDar").val();
    let rowCount=$("#addedDaryaftListBody tr").length;
    $("#addedDaryaftListBody").append(`<tr ondblclick="editDaryaftItem('varizToOthersHisbModalEdit',this)">
                                            <td> 1 </td>
                                            <td> 0 </td>
                                            <td> بعدااضافه شود </td>
                                            <td> ${moneyVarizToOtherHisabDar} </td>
                                            <td> 0 </td>
                                            <td>  </td>
                                            <td>  </td>
                                        </tr>`);
    $("#varizToOthersHisbModal").modal("hide")
    let netPriceHDS=0;
    for (let index = 1; index <= rowCount+1; index++) {
        netPriceHDS+= parseInt($(`#addedDaryaftListBody tr:nth-child(${index}) td:nth-child(4)`).text().replace(/,/g, ''));
        
    }
    $("#netPriceDar").text(parseInt(netPriceHDS).toLocaleString("en-us"));
    $("#totalNetPriceHDSDar").val(netPriceHDS);
}

$("#addDaryaftForm").on("submit",function(e){
    e.preventDefault();
    $.ajax({
        method:"POST",
        url: $(this).attr('action'),
        data: new FormData(this),
        processData: false,
        contentType: false,
        success: function (data) {
            console.info(data)
            $("#")
        },
        error:function(error){}
    });
})

function editDaryaftItem(modalId,element){
    $("#"+modalId).modal("show");
    $("tr").removeClass("selected");
    $(element).addClass("selected");
    switch (modalId) {
        case "daryaftVajhNaghdModalEdit":
            {
                $("#rialNaghdDarEdit").val();
                $("#descNaghdDarEdit").val();
            }
            break;
        case "chequeInfoModalEdit":
            {
                $("#chequeNoCheqeDarEdit").val();
                $("#checkSarRasidDateDarEdit").val();
                $("#daysAfterChequeDateDarEdit").val();
                $("#shobeBankChequeDarEdit").val();
                $("#").val();
                $("#").val();
                $("#").val();
                $("#").val();
                $("#").val();
                $("#").val();
            }
            break;
        case "hawalaInfoModalEdit":
            {

            }
            break;
        case "takhfifModalEdit":
            {

            }
            break;
        case "varizToOthersHisbModalEdit":
            {

            }
            break;
        case "spentChequeModalEdit":
            {

            }
            break;
    }
}