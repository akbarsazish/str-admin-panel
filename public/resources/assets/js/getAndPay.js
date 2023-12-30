    var baseUrl = "http://192.168.10.26:8080";
    var csrf = document.querySelector("meta[name='csrf-token']").getAttribute('content');
    function getGetAndPayBYS(element,tableBodyId,snGetAndPay){
        $("tr").removeClass("selected");
        $(element).addClass("selected");
        const editPayInput=document.getElementById("EditPayInput");
        if(editPayInput){
            editPayInput.value=snGetAndPay;
        }
        const editGetInput=document.getElementById("EditGetInput");
        if(editGetInput){
            editGetInput.value=snGetAndPay;
        }
        $.get(baseUrl+"/getGetAndPayBYS",{snGetAndPay:snGetAndPay},function(respond,status){
            if(tableBodyId=='receiveListBodyBYS'){
                $("#"+tableBodyId).empty();
                respond.forEach((element,index) => {
                    $("#"+tableBodyId).append(`
                        <tr>
                            <td class="receiveDetailsTd-1"> ${(index+1)} </td>
                            <td class="receiveDetailsTd-2"> ${element.docTypeName} </td>
                            <td class="receiveDetailsTd-3"> ${element.ChequeRecNo} </td>
                            <td class="receiveDetailsTd-4"> ${element.bankDesc} </td>
                            <td class="receiveDetailsTd-5"> ${parseInt(element.Price).toLocaleString("en-us")} </td>
                            <td class="receiveDetailsTd-6"> ${element.ChequeNo} </td>
                            <td class="receiveDetailsTd-7"> ${element.ChequeDate} </td>
                            <td class="receiveDetailsTd-8"> ${element.SnBank} </td>
                            <td class="receiveDetailsTd-9"> ${element.Branch} </td>
                            <td class="receiveDetailsTd-10"> ${element.AccBankno} </td>
                            <td class="receiveDetailsTd-11"> ${element.Owner} </td>
                            <td class="receiveDetailsTd-12"> ${element.DocDescBYS} </td>
                            <td class="receiveDetailsTd-13"> ${element.NoSayyadi} </td>
                            <td class="receiveDetailsTd-14"> ${element.NameSabtShode} </td>
                        </tr>`);
                        makeTableColumnsResizable("receiveDetialsTable")
                    });
                    
                }else{
                    $("#"+tableBodyId).empty();
                respond.forEach((element,index) => {
                    $("#"+tableBodyId).append(`
                        <tr>
                            <td>${index+1}</td>
                            <td> ${element.docTypeName} </td>
                            <td> ${element.bankDesc} </td>
                        </tr>`
                    );
                });
            }
        })

        $("#deleteGetAndPayBYSBtn").prop("disabled",false);
        $("#editGetAndPayBYSBtn").prop("disabled",false);
        $("#deletePaysHDSBtn").val(snGetAndPay);
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
                    $("#receiveListBody").append(`
                        <tr class="factorTablRow" onclick="getGetAndPayBYS(this,'receiveListBodyBYS',${element.SerialNoHDS})"  class="factorTablRow">
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
                left: 10
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

        $('#addDaryaftModal').modal({
            backdrop: false,
            show: true
        });

        $('.modal-dialog').draggable({
            handle: ".modal-header"
        });
    }

    function closeDaryaftModal() {
        $("#addDaryaftModal").modal("hide");   
    }

    function closeDaryaftModalEdit() {
        $("#daryaftModalEdit").modal("hide");        
    }

    function openDaryaftVajhNaghdModal(){
        $("#addDaryaftVajhNaghdModal").modal("show");
    }

    function closeDaryaftVajhNaghdModal(){
        $("#addDaryaftVajhNaghdModal").modal("hide")
    }

    function closeDaryaftVajhNaghdModalEdit(){
        $("#daryaftVajhNaghdModalEdit").modal("hide")
    }

    function openChequeInfoModal() {
        $("#daryafAddChequeInfo").modal("show")
    }

    function closeChequeInfoModal() {
        $("#daryafAddChequeInfo").modal("hide")
    }

    function closeChequeInfoModalEdit() {
        $("#chequeInfoModalEdit").modal("hide")
    }

    function closeAddDaryaftVajhNaghdEdi() {
        $("#addDaryaftVajhNaghdEditModal").modal("hide")
    }
  
    function closeEditChequeInfoModal() {
        $("#editDaryafAddChequeInfo").modal("hide")
    }

    function openeditAddEditVagheNaghdmodal(){
        $("#editAddEditVagheNaghdmodal").modal("show");
    }
    function closeEditAddEditVagheNaghdmodal(){
        $("#editAddEditVagheNaghdmodal").modal("hide");
    }

    function openEditAddDaryafAddChequeInfo(){
        $("#editAddDaryafAddChequeInfo").modal("show");
    }
    function closeEditAddDaryafAddChequeInfo(){
        $("#editAddDaryafAddChequeInfo").modal("hide");
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
        $("#daryafAddHawalaInfoModal").modal("show");
    }

    
    function closeHawalaInfoModal() {
        $("#daryafAddHawalaInfoModal").modal("hide")
    }

    function closetHawalaInfoModalEdit() {
        $("#daryaftHawalaInfoModalEdit").modal("hide")
    }

    function openSpentChequeModal(){
        $("#addSpentChequeModal").modal("show");
    }

    function closeSpentChequeModal(){
        $("#addSpentChequeModal").modal("hide");
    }

    function closeSpentChequeModalEdit(){
        $("#spentChequeModalEdit").modal("hide");
    }

    function openTakhfifModal(){
        $("#daryaftAddTakhfifModal").modal("show")
    }

    function closeTakhfifModal(){
        $("#daryaftAddTakhfifModal").modal("hide")
    }

    function closeTakhfifModalEdit() {
        var modal = document.getElementById("takhfifModalEdit");
        if (modal) {
            modal.style.display = "none";
        }
    }

    function openVarizToOthersHisbModal(){
        $("#daryaftAddVarizToOthersHisbModal").modal("show");
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

    function closeCustomerGardishModal(){
        $("#customerGardishModal").modal("hide")
    }

    function openRasDaryaftItemModal(){
        $("#rasDaryaftItemModal").modal("show")
    }
    function closeRasDaryaftItemModal(){
        $("#rasDaryaftItemModal").modal("hide")
    }

    const openReceiveModals = (modalId) => {
        if(modalId === "editAddHawalaModal"){
            $.get(baseUrl+"/allBanks",(respond,status)=>{
                $("#editAddBankAccNoHawalaDar").empty();
                $("#editAddBankAccNoHawalaDar").append(`<option></option>`);
                for (const element of respond.bankKarts) {
                    $("#editAddBankJustAccNoHawalaDar").val(element.AccNo);
                    $("#editAddBankAccNoHawalaDar").append(`<option selected value="${element.AccNo}"> ${element.bsn} </option>`);
                }
            });
            $(`#${modalId}`).modal("show");
        }

        if(modalId === "editAddEditHawalaModal"){
            $.get(baseUrl+"/allBanks",(respond,status)=>{
                $("#editAddEditBankAccNoHawalaDar").empty();
                $("#editAddEditBankAccNoHawalaDar").append(`<option></option>`);
                for (const element of respond.bankKarts) {
                    $("#editAddEditBankAccNoHawalaDar").append(`<option selected value="${element.AccNo}"> ${element.bsn} </option>`);
                }
            });
            $(`#${modalId}`).modal("show");
        }

        $(`#${modalId}`).modal("show"); 
    };
    
    const closeReceiveModals = (modalId) => {
        $(`#${modalId}`).modal("hide");
    };
    



    const persianDateInputs=document.querySelectorAll(".persianDate");
    if(persianDateInputs){
        persianDateInputs.forEach(element=>{
            persianDateInput=element;
            $(persianDateInput).persianDatepicker({
                cellWidth: 32,
                cellHeight: 22,
                fontSize: 14,
                formatDate: "YYYY/0M/0D",
                endDate: "1440/5/5",
            });
        })
    }

    $("#checkSarRasidDateInputAddEditPayEdit").persianDatepicker({
        cellWidth: 32,
        cellHeight: 22,
        fontSize: 14,
        formatDate: "YYYY/0M/0D",
        endDate: "1440/5/5",
    });

    $("#addHawalaFromBoxAddDateInput").persianDatepicker({
        cellWidth: 32,
        cellHeight: 22,
        fontSize: 14,
        formatDate: "YYYY/0M/0D",
        endDate: "1440/5/5",
    });
    $("#addHawalaFromBoxDateEditInputEdit").persianDatepicker({
        cellWidth: 32,
        cellHeight: 22,
        fontSize: 14,
        formatDate: "YYYY/0M/0D",
        endDate: "1440/5/5",
    });

    $("#checkSarRasidDateInputEditPayEdit").persianDatepicker({
        cellWidth: 32,
        cellHeight: 22,
        fontSize: 14,
        formatDate: "YYYY/0M/0D",
        endDate: "1440/5/5",
    });

    $("#customerCodeDaryaft").on("keyup",function(e){
        $.get(baseUrl+"/getCustomerInfoByCode",{pcode:$("#customerCodeDaryaft").val()},function(respond,status){
          
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
                        $("#customerForDaryaftListBody").append(`
                           <tr onclick="setDaryaftCustomerStuff(this,${element.PSN})">
                                <td>  ${i}  </td>
                                <td>  ${element.Name}  </td>
                                <td>  ${element.PhoneStr}  </td>
                                <td>   </td>
                                <td>   </td>
                                <td>   </td>
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
                $("#searchedFactorForDarListBody").append(`
                    <tr onclick="selecFactorForAddToDar(this,${element.SerialNoHDS})">
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
                $("#addedFactorsToDarListBoday").append(`
                <tr onclick="selectAddedFactorForDarStuff(this,${element.SerialNoHDS})">
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

        $("#addedDaryaftListBody").append(` 
             <tr onclick="addEditDaryaftItem(this);" ondblclick="editDaryaftItem('daryaftVajhNaghdModalEdit',this)">
                <td class="d-none"> <input type="checkbox" checked value="${rowCount+1}" name="byss[]"/> ${(rowCount+1)}  </td>
                <td class="dayaftAddTd-1"> ${rowCount+1} </td>
                <td class="dayaftAddTd-2"> </td>
                <td class="dayaftAddTd-3"> ${description}  </td>
                <td class="dayaftAddTd-4"> ${parseInt(rials).toLocaleString("en-us")} </td>
                <td class="dayaftAddTd-5"> </td>
                <td class="dayaftAddTd-6"> </td> 
               
                <td> <input type="text" value="1" name="DocTypeBys${rowCount+1}" class="d-none"/> </td>
                <td class="d-none"> <input type="text" value="${rials}" name="Price${rowCount+1}" class="d-none"/> </td>
                <td class="d-none"> <input type="text" value="0" name="ChequeDate${rowCount+1}" class="d-none"/> </td>
                <td class="d-none"> <input type="text" value="0" name="ChequeNo${rowCount+1}" class="d-none"/> </td>
                <td class="d-none"> <input type="text" value="0" name="AccBankNo${rowCount+1}" class="d-none"/> </td>
                <td class="d-none"> <input type="text" value="0" name="Owener${rowCount+1}" class="d-none"/> </td>
                <td class="d-none"> <input type="text" value="0" name="SnBank${rowCount+1}" class="d-none"/> </td>
                <td class="d-none"> <input type="text" value="0" name="SnChequeBook${rowCount+1}" class="d-none"/> </td>
                <td class="d-none"> <input type="text" value="${description}" name="DocDescBys${rowCount+1}" class="d-none"/> </td>
                <td class="d-none"> <input type="text" value="0" name="SnAccBank${rowCount+1}" class="d-none"/> </td>
                <td class="d-none"> <input type="text" value="0" name="CashNo${rowCount+1}" class="d-none"/> </td>
                <td class="d-none"> <input type="text" value="0" name="NoPayanehKartKhanBYS${rowCount+1}" class="d-none"/> </td>
                <td class="d-none"> <input type="text" value="0" name="SnPeopelPay${rowCount+1}" class="d-none"/> </td>
            </tr>`);

        $("#addDaryaftVajhNaghdModal").modal("hide");

        makeTableColumnsResizable("daryaftAddTable")

        let netPriceHDS=0;
        for (let index = 1; index <= rowCount+1; index++) {
            netPriceHDS+= parseInt($(`#addedDaryaftListBody tr:nth-child(${index}) td:nth-child(5)`).text().replace(/,/g, ''));
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

    $("#addPayHawalaFromBankAddHawalaDate").persianDatepicker({
        cellWidth: 32,
        cellHeight: 22,
        fontSize: 14,
        formatDate: "YYYY/0M/0D",
        endDate: "1440/5/5"});

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

    function changeNumberOfInputToLetter(element,alertId){
        let moneyAmount=element.value;
        changeNumberToLetter(element,alertId,moneyAmount);
    }

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
  

    let dayValue;
    let monthValue;

    const distanceMonth = document.getElementById('distanceMonthChequeDar');
    const distanceDay = document.getElementById('distanceDarChequeDar');
if(distanceMonth){
    distanceMonth.addEventListener('keyup', () => {
        if (distanceMonth.value.length > 0) {
            distanceDay.value = "";
            monthValue = parseInt(distanceMonth.value);
        }
    });
}

if(distanceDay){
    distanceDay.addEventListener('keyup', () => {
        if (distanceDay.value.length > 0) {
            dayValue = parseInt(distanceDay.value);
            distanceMonth.value = "";
        }
    });
}

    function addChequeDar(){
        let checkSarRasidDateDar = $("#checkSarRasidDateDar").val();
        let chequeNoCheqeDar=$("#chequeNoCheqeDar").val();
        let bankNameDar=$("#bankNameDar").val();
        let moneyChequeDar=$("#moneyChequeDar").val();
        let shobeBankChequeDar=$("#shobeBankChequeDar").val();
        let hisabNoChequeDar=$("#hisabNoChequeDar").val();
        let sayyadiNoChequeDar=$("#sayyadiNoChequeDar").val();
        let sabtBeNameChequeDar=$("#sabtBeNameChequeDar").val();
        let malikChequeDar=$("#malikChequeDar").val();
        let repeateChequeDar=parseInt($("#repeateChequeDar").val());
        let distanceMonthChequeDar=$("#distanceMonthChequeDar").val();
        let distanceDarChequeDar=$("#distanceDarChequeDar").val();
        let descChequeDar=$("#descChequeDar").val();
        var bankName = $("#bankNameDar option:selected").text();


        let rowCount = $("#addedDaryaftListBody tr").length;
            // console.log("lets chekc the the value of day and month", dayValue , monthValue)
        if (repeateChequeDar > 1) {
            for (let i = 0; i < repeateChequeDar; i++) {
                let updateDateHijri;

                if (dayValue > 0 || monthValue > 0) {
                    let chequeDate = $("#checkSarRasidDateDar").data("gdate");
                    let laterChequeDate = new Date(chequeDate);

                    if (parseInt(dayValue) > 0) {
                        laterChequeDate.setDate(laterChequeDate.getDate() + dayValue * i);
                    }

                    if (parseInt(monthValue) > 0) {
                        laterChequeDate.setMonth(laterChequeDate.getMonth() + monthValue * i);
                    }

                    updateDateHijri = new Intl.DateTimeFormat('fa-IR', { year: 'numeric', month: '2-digit', day: '2-digit' }).format(laterChequeDate);
                } else {
                    let chequeDate = $("#checkSarRasidDateDar").data("gdate");
                    let laterChequeDate = new Date(chequeDate);
                        updateDateHijri = new Intl.DateTimeFormat('fa-IR', { year: 'numeric', month: '2-digit', day: '2-digit' }).format(laterChequeDate);
                }

                $("#addedDaryaftListBody").append(`
                    <tr onclick="addEditDaryaftItem(this);" ondblclick="editDaryaftItem('chequeInfoModalEdit',this)">
                        <td class="d-none"> <input type="checkbox" checked value="${rowCount+i}" name="byss[]"/> 1 </td>
                        <td class="dayaftAddTd-1"> ${i+1} </td>
                        <td class="dayaftAddTd-2"> 0 </td>
                        <td class="dayaftAddTd-3"> چک بانک ${bankName} به شماره ${chequeNoCheqeDar + i} تاریخ ${updateDateHijri} </td>
                        <td class="dayaftAddTd-4"> ${parseInt(moneyChequeDar).toLocaleString("en-us")} </td>
                        <td class="d-none dayaftAddTd-5"> 0 </td>
                        <td class="dayaftAddTd-6"> ${sayyadiNoChequeDar} </td>
                        <td class="d-none dayaftAddTd-7"> <input type="text" value="2" name="DocTypeBys${rowCount+1}" class=""/> </td>
                        <td class="dayaftAddTd-8"> ${sabtBeNameChequeDar}  </td>

                        <td class="d-none"> <input type="text" value="${sayyadiNoChequeDar}" name="sayyadiNoChequeDar${rowCount+1}"/> </td>
                        <td class="d-none"> <input type="text" value="${sabtBeNameChequeDar}" name="sabtBeNameChequeDar${rowCount+1}"/> </td>
                        <td class="d-none"> <input type="text" value="${moneyChequeDar}" name="Price${rowCount+1}" class=""/> </td>
                        <td class="d-none"> <input type="text" value="${checkSarRasidDateDar}" name="ChequeDate${rowCount+1}" class=""/> </td>
                        <td class="d-none"> <input type="text" value="${chequeNoCheqeDar}" name="ChequeNo${rowCount+1}" class=""/> </td>
                        <td class="d-none"> <input type="text" value="${hisabNoChequeDar}" name="AccBankNo${rowCount+1}" class=""/> </td>
                        <td class="d-none"> <input type="text" value="${malikChequeDar}" name="Owener${rowCount+1}" class=""/> </td>
                        <td class="d-none"> <input type="text" value="${bankNameDar}" name="SnBank${rowCount+1}" class=""/> </td>
                        <td class="d-none"> <input type="text" value="0" name="SnChequeBook${rowCount+1}" class=""/> </td>
                        <td class="d-none"> <input type="text" value="${descChequeDar}" name="DocDescBys${rowCount+1}" class=""/> </td>
                        <td class="d-none"> <input type="text" value="0" name="SnAccBank${rowCount+1}" class=""/> </td>
                        <td class="d-none"> <input type="text" value="0" name="NoPayanehKartKhanBYS${rowCount+1}" class=""/> </td>
                        <td class="d-none"> <input type="text" value="0" name="SnPeopelPay${rowCount+1}" class=""/> </td>
                        <td class="d-none"> <input type="text" value="${repeateChequeDar}" name="repeatChequDar${rowCount+1}" class=""/> </td>
                        <td class="d-none"> <input type="text" value="${distanceMonthChequeDar}" name="dueDateMonth${rowCount+1}" class=""/> </td>
                        <td class="d-none"> <input type="text" value="${distanceDarChequeDar}" name="dueDateDat${rowCount+1}" class=""/> </td>
                    </tr>`);
            }
        } else {
            let updateDateHijri;

                if (parseInt(dayValue) > 0 || parseInt(monthValue) > 0) {
                    let chequeDate = $("#checkSarRasidDateDar").data("gdate");
                    let laterChequeDate = new Date(chequeDate);

                    if (parseInt(dayValue) > 0) {
                        laterChequeDate.setDate(laterChequeDate.getDate() + parseInt(dayValue) * i);
                    }

                    if (parseInt(monthValue) > 0) {
                        laterChequeDate.setMonth(laterChequeDate.getMonth() + parseInt(monthValue) * i);
                    }

                    updateDateHijri = new Intl.DateTimeFormat('fa-IR', { year: 'numeric', month: '2-digit', day: '2-digit' }).format(laterChequeDate);
                } else {
                    let chequeDate = $("#checkSarRasidDateDar").data("gdate");
                    let laterChequeDate = new Date(chequeDate);
                        updateDateHijri = new Intl.DateTimeFormat('fa-IR', { year: 'numeric', month: '2-digit', day: '2-digit' }).format(laterChequeDate);
                }

            $("#addedDaryaftListBody").append(`
                <tr onclick="addEditDaryaftItem(this);" ondblclick="editDaryaftItem('chequeInfoModalEdit',this)">
                    <td class="d-none"> <input type="checkbox" checked value="${rowCount+1}" name="byss[]"/> 1 </td>
                    <td class="dayaftAddTd-1"> ${rowCount+1} </td>
                    <td class="dayaftAddTd-2"> 0 </td>
                    <td class="dayaftAddTd-3"> چک بانک ${bankName} به شماره ${chequeNoCheqeDar + i} تاریخ ${updateDateHijri} </td>
                    <td class="dayaftAddTd-4"> ${parseInt(moneyChequeDar).toLocaleString("en-us")} </td>
                    <td class="dayaftAddTd-5"> 0 </td>
                    <td class="dayaftAddTd-6"> ${sayyadiNoChequeDar} </td>
                    <td class="dayaftAddTd-7" class="d-none"> <input type="text" value="2" name="DocTypeBys${rowCount+1}" class=""/> </td>
                    <td class="dayaftAddTd-8"> ${sabtBeNameChequeDar}  </td>
                    <td class="d-none"> <input type="text" value="${sayyadiNoChequeDar}" name="sayyadiNoChequeDar${rowCount+1}"/> </td>
                    <td class="d-none"> <input type="text" value="${sabtBeNameChequeDar}" name="sabtBeNameChequeDar${rowCount+1}"/> </td>
                    <td class="d-none"> <input type="text" value="${moneyChequeDar}" name="Price${rowCount+1}" class=""/> </td>
                    <td class="d-none"> <input type="text" value="${checkSarRasidDateDar}" name="ChequeDate${rowCount+1}" class=""/> </td>
                    <td class="d-none"> <input type="text" value="${chequeNoCheqeDar}" name="ChequeNo${rowCount+1}" class=""/> </td>
                    <td class="d-none"> <input type="text" value="${hisabNoChequeDar}" name="AccBankNo${rowCount+1}" class=""/> </td>
                    <td class="d-none"> <input type="text" value="${malikChequeDar}" name="Owener${rowCount+1}" class=""/> </td>
                    <td class="d-none"> <input type="text" value="${bankNameDar}" name="SnBank${rowCount+1}" class=""/> </td>
                    <td class="d-none"> <input type="text" value="0" name="SnChequeBook${rowCount+1}" class=""/> </td>
                    <td class="d-none"> <input type="text" value="${descChequeDar}" name="DocDescBys${rowCount+1}" class=""/> </td>
                    <td class="d-none"> <input type="text" value="0" name="SnAccBank${rowCount+1}" class=""/> </td>
                    <td class="d-none"> <input type="text" value="0" name="NoPayanehKartKhanBYS${rowCount+1}" class=""/> </td>
                    <td class="d-none"> <input type="text" value="0" name="SnPeopelPay${rowCount+1}" class=""/> </td>
                    <td class="d-none"> <input type="text" value="${repeateChequeDar}" name="repeatChequDar${rowCount+1}" class=""/> </td>
                    <td class="d-none"> <input type="text" value="${distanceMonthChequeDar}" name="dueDateMonth${rowCount+1}" class=""/> </td>
                    <td class="d-none"> <input type="text" value="${distanceDarChequeDar}" name="dueDateDat${rowCount+1}" class=""/> </td>
                </tr>`);
            }
            $("#daryafAddChequeInfo").modal("hide");
            
            makeTableColumnsResizable("daryaftAddTable")
        let netPriceHDS=0;
        for (let index = 1; index <= rowCount+1; index++) {
            netPriceHDS+= parseInt($(`#addedDaryaftListBody tr:nth-child(${index}) td:nth-child(5)`).text().replace(/,/g, ''));
        }
        $("#netPriceDar").text(parseInt(netPriceHDS).toLocaleString("en-us"));
        $("#totalNetPriceHDSDar").val(netPriceHDS);
}

// modal to add hawala
    function addHawalaDar(){
        let hawalaNoHawalaDar=$("#hawalaNoHawalaDar").val();
        let bankAccNoHawalaDar=$("#bankAccNoHawalaDar").val();
        let payanehKartKhanNoHawalaDar=$("#payanehKartKhanNoHawalaDar").val();
        let monyAmountHawalaDar=$("#monyAmountHawalaDar").val();
        let hawalaDateHawalaDar=$("#hawalaDateHawalaDar").val();
        let discriptionHawalaDar=$("#discriptionHawalaDar").val();
        let bankName = $("#bankAccNoHawalaDar option:selected").text();

        let rowCount=$("#addedDaryaftListBody tr").length;

        $("#addedDaryaftListBody").append(`
            <tr onclick="addEditDaryaftItem(this)" ondblclick="editDaryaftItem('daryaftHawalaInfoModalEdit',this)">
                <td class="d-none"> <input type="checkbox" checked value="${rowCount+1}" name="byss[]"/> ${rowCount+1} </td>
                <td class="dayaftAddTd-1"> ${rowCount+1} </td>
                <td class="dayaftAddTd-2"> 0 </td>
                <td class="dayaftAddTd-3"> حواله به ${bankName} به شماره   ${hawalaNoHawalaDar} تاریخ  ${hawalaDateHawalaDar}  </td>
                <td class="dayaftAddTd-4"> ${parseInt(monyAmountHawalaDar).toLocaleString("en-us")} </td>
                <td class="dayaftAddTd-5"> 0 </td>
                <td class="dayaftAddTd-6"> </td>
                <td class="d-none dayaftAddTd-7 d-none"> <input type="text" value="3" name="DocTypeBys${rowCount+1}" class=""/> </td>
                <td class="dayaftAddTd-8"> </td>
                <td class="d-none"> <input type="text" value="${monyAmountHawalaDar}" name="Price${rowCount+1}" class=""/> </td>
                <td class="d-none"> <input type="text" value="${hawalaDateHawalaDar}" name="ChequeDate${rowCount+1}" class=""/> </td>
                <td class="d-none"> <input type="text" value="0" name="ChequeNo${rowCount+1}" class=""/> </td>
                <td class="d-none"> <input type="text" value="${bankAccNoHawalaDar}" name="AccBankNo${rowCount+1}" class=""/> </td>
                <td class="d-none"> <input type="text" value=" " name="Owener${rowCount+1}" class=""/> </td>
                <td class="d-none"> <input type="text" value="0" name="SnBank${rowCount+1}" class=""/> </td>
                <td class="d-none"> <input type="text" value="0" name="SnChequeBook${rowCount+1}" class=""/> </td>
                <td class="d-none"> <input type="text" value="${discriptionHawalaDar}" name="DocDescBys${rowCount+1}" class=""/> </td>
                <td class="d-none"> <input type="text" value="0" name="SnAccBank${rowCount+1}" class=""/> </td>
                <td class="d-none"> <input type="text" value="0" name="CashNo${rowCount+1}" class=""/> </td>
                <td class="d-none"> <input type="text" value="${payanehKartKhanNoHawalaDar}" name="NoPayanehKartKhanBYS${rowCount+1}" class=""/> </td>
                <td class="d-none"> <input type="text" value="0" name="SnPeopelPay${rowCount+1}" class=""/> </td>
                <td class="d-none"> <input type="text" value="حواله به ${bankName} به شماره   ${hawalaNoHawalaDar}" class=""/> </td>
                <td class="d-none"> <input type="text" value="${hawalaNoHawalaDar}" class=""/> </td>
            </tr>`);

         $("#daryafAddHawalaInfoModal").modal("hide");
         makeTableColumnsResizable("addHawalaTable");

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

    $("#bankAccNoHawalaDarEd").on("change", (e)=> {
        $("#bankJustAccNoHawalaDarEd").val($("#bankAccNoHawalaDarEd").val());
    })

// Modal for edit hawala
    function addEditHawalaDar(){
        let hawalaNoHawalaDar=$("#hawalaNoHawalaDarEd").val();
        let bankAccNoHawalaDar=$("#bankAccNoHawalaDarEd").val();
        let payanehKartKhanNoHawalaDar=$("#payanehKartKhanNoHawalaDarEd").val();
        let monyAmountHawalaDar=$("#monyAmountHawalaDarEd").val();
        let hawalaDateHawalaDar=$("#hawalaDateHawalaDarEd").val();
        let discriptionHawalaDar=$("#discriptionHawalaDarEd").val();
        let bankName = $("#bankAccNoHawalaDarEd option:selected").text();
        let rowCount=$("#addedDaryaftListBody tr").length;

        $("#addedDaryaftListBody > tr > td.dayaftAddTd-1").text(rowCount+1)
        $("#addedDaryaftListBody > tr > td.dayaftAddTd-1").text(0)
        $("#addedDaryaftListBody > tr > td.dayaftAddTd-3").text(`حواله به ${bankName} به شماره   ${hawalaNoHawalaDar} تاریخ  ${hawalaDateHawalaDar} `)
        $("#addedDaryaftListBody > tr > td.dayaftAddTd-4").text(monyAmountHawalaDar)
        
        $("#addedDaryaftListBody > tr > td:nth-child(10) > input[type=text]").val(monyAmountHawalaDar)
        $("#addedDaryaftListBody > tr > td:nth-child(11) > input[type=text]").val(hawalaDateHawalaDar)
        $("#addedDaryaftListBody > tr > td:nth-child(17) > input[type=text]").val(discriptionHawalaDar)
        $("#addedDaryaftListBody > tr > td:nth-child(20) > input[type=text]").val(payanehKartKhanNoHawalaDar)
        $("#addedDaryaftListBody > tr > td:nth-child(23) > input[type=text]").val(hawalaNoHawalaDar)

        $("#daryaftHawalaInfoModalEdit").modal("hide");
        makeTableColumnsResizable("addHawalaTable");

        let netPriceHDS=0;
        for (let index = 1; index <= rowCount+1; index++) {
            netPriceHDS+= parseInt($(`#addedDaryaftListBody tr:nth-child(${index}) td:nth-child(5)`).text().replace(/,/g, '')); 
        }
        $("#netPriceDar").text(parseInt(netPriceHDS).toLocaleString("en-us"));
        $("#totalNetPriceHDSDar").val(netPriceHDS);
    }

    $("#hawalaDateHawalaDarEd").persianDatepicker({
        cellWidth: 32,
        cellHeight: 22,
        fontSize: 14,
        formatDate: "YYYY/0M/0D",
        endDate: "1440/5/5",
    });
    $("#checkSarRasidDateInputAddPayAdd").persianDatepicker({
        cellWidth: 32,
        cellHeight: 22,
        fontSize: 14,
        formatDate: "YYYY/0M/0D",
        endDate: "1440/5/5",
    });
    $("#addHawalaFromBoxAddDateInput").persianDatepicker({
        cellWidth: 32,
        cellHeight: 22,
        fontSize: 14,
        formatDate: "YYYY/0M/0D",
        endDate: "1440/5/5",
    });

    function addTakhfifDar(){
        let takhfifMoneyDar=$("#takhfifMoneyDar").val();
        let discriptionTakhfifDar=$("#discriptionTakhfifDar").val();
        let rowCount=$("#addedDaryaftListBody tr").length;
        $("#addedDaryaftListBody").append(`
                <tr onclick="addEditDaryaftItem(this);" ondblclick="editDaryaftItem('takhfifModalEdit',this)">
                    <td class="d-none"> <input type="checkbox" checked value="${rowCount+1}" name="byss[]"/> ${rowCount+1} </td>
                    <td class="dayaftAddTd-1"> ${rowCount + 1} </td>
                    <td class="dayaftAddTd-2"> 0 </td>
                    <td class="dayaftAddTd-3"> تخفیف </td>
                    <td class="dayaftAddTd-4"> ${takhfifMoneyDar} </td>
                    <td class="dayaftAddTd-5"> 0 </td>
                    <td class="dayaftAddTd-6"> 0 </td>
                    <td class="d-none"> <input type="text" value="4" name="DocTypeBys${rowCount+1}" class=""/> </td>
                    <td dayaftAddTd-7>  </td>
                    <td class="d-none"> <input type="text" value="${takhfifMoneyDar}" name="Price${rowCount+1}" class=""/> </td>
                    <td class="d-none"> <input type="text" value=" " name="ChequeDate${rowCount+1}" class=""/> </td>
                    <td class="d-none"> <input type="text" value="0" name="ChequeNo${rowCount+1}" class=""/> </td>
                    <td class="d-none"> <input type="text" value="0" name="AccBankNo${rowCount+1}" class=""/> </td>
                    <td class="d-none"> <input type="text" value=" " name="Owener${rowCount+1}" class=""/> </td>
                    <td class="d-none"> <input type="text" value="0" name="SnBank${rowCount+1}" class=""/> </td>
                    <td class="d-none"> <input type="text" value="0" name="SnChequeBook${rowCount+1}" class=""/> </td>
                    <td class="d-none"> <input type="text" value="${discriptionTakhfifDar}" name="DocDescBys${rowCount+1}" class=""/> </td>
                    <td class="d-none"> <input type="text" value="0" name="SnAccBank${rowCount+1}" class=""/> </td>
                    <td class="d-none"> <input type="text" value="0" name="CashNo${rowCount+1}" class=""/> </td>
                    <td class="d-none"> <input type="text" value="0" name="NoPayanehKartKhanBYS${rowCount+1}" class=""/> </td>
                    <td class="d-none"> <input type="text" value="0" name="SnPeopelPay${rowCount+1}" class=""/> </td>
                </tr>`);
        $("#daryaftAddTakhfifModal").modal("hide");
        makeTableColumnsResizable("addHawalaTable");
        let netPriceHDS=0;
        for (let index = 1; index <= rowCount+1; index++) {
            netPriceHDS+= parseInt($(`#addedDaryaftListBody tr:nth-child(${index}) td:nth-child(5)`).text().replace(/,/g, ''));
            
        }
        $("#netPriceDar").text(parseInt(netPriceHDS).toLocaleString("en-us"));
        $("#totalNetPriceHDSDar").val(netPriceHDS);
    }


    const addTakhfifDarEdit = () => {
        let rowLength = document.querySelectorAll("#addedDaryaftListBody tr").length;
    
        let takhfifDesc = document.getElementById("discriptionTakhfifDarEdit").value;
        let takhffiMoney = document.getElementById("takhfifMoneyDarEdit").value;
    
        document.querySelector(`#addedDaryaftListBody > tr:nth-child(${rowLength}) > td:nth-child(4)`).textContent = takhfifDesc;
        document.querySelector(`#addedDaryaftListBody > tr:nth-child(${rowLength}) > td:nth-child(5)`).textContent = takhffiMoney;
        

        var modal = document.getElementById("takhfifModalEdit");
        if (modal) {
            modal.style.display = "none";
        }
    
        // Recalculate netPriceHDS
        let netPriceHDS = 0;
        for (let index = 1; index <= rowLength; index++) {
            netPriceHDS += parseInt(document.querySelector(`#addedDaryaftListBody tr:nth-child(${index}) td:nth-child(5)`).textContent.replace(/,/g, ''), 10);
        }
        console.log("net price", netPriceHDS);
    
        document.getElementById("netPriceDar").textContent = netPriceHDS.toLocaleString("en-us");
        document.getElementById("totalNetPriceHDSDar").value = netPriceHDS;
    };


   
$("#varizBehisabDigariCustomerCodeDar").on("keyup",function(e){
    $.get(baseUrl+"/getCustomerInfoByCode",{pcode:$("#varizBehisabDigariCustomerCodeDar").val()},function(respond,status){
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
                    $("#customerForDaryaftOtherHisabVarizListBody").append(`
                       <tr onclick="setDaryaftCustomerOtherHisabStuff(this,${element.PSN})">
                        <td> ${i} </td>
                        <td> ${element.Name} </td>
                        <td> ${element.PhoneStr} </td>
                        <td>  </td>
                        <td>  </td>
                        <td>  </td>
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

    let rowCount = $("#addedDaryaftListBody tr").length;

    $("#addedDaryaftListBody").append(`
       <tr  onclick="addEditDaryaftItem(this)" ondblclick="editDaryaftItem('varizToOthersHisbModalEdit',this)">
            <td class="d-none"> <input type="checkbox" checked value="${rowCount+1}" name="byss[]"/> ${rowCount+1} </td>
            <td class="dayaftAddTd-1"> ${rowCount + 1} </td>
            <td class="dayaftAddTd-2"> 0 </td>
            <td class="dayaftAddTd-3"> 0 </td>
            <td class="dayaftAddTd-4"> ${moneyVarizToOtherHisabDar} </td>
            <td class="dayaftAddTd-5">  </td>
            <td class="dayaftAddTd-6">  </td>
            <td class="d-none"> <input type="text" value="6" name="DocTypeBys${rowCount+1}" class=""/> </td>
            <td class="dayaftAddTd-7">  </td>
            <td class="d-none"> <input type="text" value="${moneyVarizToOtherHisabDar}" name="Price${rowCount+1}" class=""/> </td>
            <td class="d-none"> <input type="text" value=" " name="ChequeDate${rowCount+1}" class=""/> </td>
            <td class="d-none"> <input type="text" value="0" name="ChequeNo${rowCount+1}" class=""/> </td>
            <td class="d-none"> <input type="text" value="${cartNoVarizToOtherDar}" name="AccBankNo${rowCount+1}" class=""/> </td>
            <td class="d-none"> <input type="text" value=" " name="Owener${rowCount+1}" class=""/> </td>
            <td class="d-none"> <input type="text" value="0" name="SnBank${rowCount+1}" class=""/> </td>
            <td class="d-none"> <input type="text" value="0" name="SnChequeBook${rowCount+1}" class=""/> </td>
            <td class="d-none"> <input type="text" value="${discriptionOtherHisabDar}" name="DocDescBys${rowCount+1}" class=""/> </td>
            <td class="d-none"> <input type="text" value="0" name="SnAccBank${rowCount+1}" class=""/> </td>
            <td class="d-none"> <input type="text" value="0" name="CashNo${rowCount+1}" class=""/> </td>
            <td class="d-none"> <input type="text" value="0" name="NoPayanehKartKhanBYS${rowCount+1}" class=""/> </td>
            <td class="d-none"> <input type="text" value="${varizBehisabDigariCustomerPSNDar}" name="SnPeopelPay${rowCount+1}" class=""/> </td>
            <td class="d-none"> <input type="text" value="${benamOtherHisabDar}" name="banameOther${rowCount+1}" class=""/> </td>
            <td class="d-none"> <input type="text" value="${paygiriOtherHisabDar}" name="payGeri${rowCount+1}" class=""/> </td>
            <td class="d-none"> <input type="text" value="${varizBehisabDigariCustomerCodeDar}" name="payGeri${rowCount+1}" class=""/> </td>
        </tr>`);

    $("#daryaftAddVarizToOthersHisbModal").modal("hide");

        makeTableColumnsResizable("addHawalaTable")

    let netPriceHDS=0;
    for (let index = 1; index <= rowCount+1; index++) {
        netPriceHDS+= parseInt($(`#addedDaryaftListBody tr:nth-child(${index}) td:nth-child(5)`).text().replace(/,/g, ''));
    }

    $("#netPriceDar").text(parseInt(netPriceHDS).toLocaleString("en-us"));
    $("#totalNetPriceHDSDar").val(netPriceHDS);
}


// edit varize ba hesab 
 
const addVarizToOtherHisabEdit = () => {
    let varizMoney = document.getElementById("moneyVarizToOtherHisabDarEdit").value;
    let varizeToOther = document.getElementById("cartNoVarizToOtherDarEdit").value;
    let varizeBahesab = document.getElementById("varizBehisabDigariCustomerCodeDarEdit").value;
    let payGeri = document.getElementById("paygiriOtherHisabDarEdit").value;
    let banameTaraf = document.getElementById("benamOtherHisabDarEdit").value;
    let varizeDesc = document.getElementById("discriptionOtherHisabDarEdit").value;
    let customerName = document.getElementById("varizBehisabDigariCustomerNameDarEdit").value;

    document.querySelector("#addedDaryaftListBody > tr > td:nth-child(5)").textContent = varizMoney;
    document.querySelector("#addedDaryaftListBody > tr > td:nth-child(4)").textContent = `پرداخت به ${customerName} واریز به ${varizeToOther} به نام ${banameTaraf} به شماره پیگیری ${payGeri} ${varizeDesc}`;

    let editVarizeModal = document.getElementById("varizToOthersHisbModalEdit");
    if(editVarizeModal){
        editVarizeModal.style.display = "none";
    }
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
            console.log("for customer Id", data)
            window.location.reload();
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
              $("#rialNaghdDarEdit").val($(element).find("td:eq(3)").text().replace(/,/g, ''))
              $("#descNaghdDarEdit").val($(element).find("td:eq(2)").text());
            }
            break;

        case "chequeInfoModalEdit":
            {
                $("#chequeNoCheqeDarEdit").val();
                $("#checkSarRasidDateDarEdit").val();
                $("#daysAfterChequeDateDarEdit").val();
                $("#shobeBankChequeDarEdit").val();
                $("#bankNameDarEdit").select();
                $("#moneyChequeDarEdit").val($(element).find("td:eq(3)").text().replace(/,/g, ''));
                $("#sayyadiNoChequeDarEdit").val();
                $("#sabtBeNameChequeDarEdit").val();
                $("#malikChequeDarEdit").val();
            }
            break;

        case "daryaftHawalaInfoModalEdit":
            {
                $("#hawalaNoHawalaDarEdit").val();
                $("#payanehKartKhanNoHawalaDarEdit").val();
                $("#bankJustAccNoHawalaDarEdit").val();
                $("#bankAccNoHawalaDarEdit").select();
                $("#monyAmountHawalaDarEdit").val($(element).find("td:eq(3)").text().replace(/,/g, ''));
                $("#hawalaDateHawalaDarEdit").val();
                $("#discriptionHawalaDarEdit").val();
            }
            break;

        case "takhfifModalEdit":
            {
                $("#takhfifMoneyDarEdit").val($(element).find("td:eq(3)").text().replace(/,/g, ''))
                $("#discriptionTakhfifDarEdit").val($(element).find("td:eq(2)").text())
            }
            break;

        case "varizToOthersHisbModalEdit":
            {
                $("#moneyVarizToOtherHisabDarEdit").val($(element).find("td:eq(3)").text().replace(/,/g, ''));
                $("#cartNoVarizToOtherDarEdit").val();
                $("#varizBehisabDigariCustomerCodeDarEdit").val();
                $("#varizBehisabDigariCustomerNameDarEdit").val();
                $("#benamOtherHisabDarEdit").val();
                $("#paygiriOtherHisabDarEdit").val();
                $("#discriptionOtherHisabDarEdit").val($(element).find("td:eq(2)").text());
            }
            break;

        case "spentChequeModalEdit":  {
         }
        break;
    }
}


$("#DocTypeCustomerHDSStateDar").on("change",()=>{
    if($("#DocTypeCustomerHDSStateDar").is(":checked")){
        enableCustomerInfo("customerCodeDaryaft","customerNameDaryaft","customerIdDaryaft")
    }else{
        disableCustomerInfo("customerCodeDaryaft","customerNameDaryaft","customerIdDaryaft");
    }
})

$("#DocTypeDarAmadHDSStateDar").on("change",()=>{
    if($("#DocTypeDarAmadHDSStateDar").is(":checked")){
        disableCustomerInfo("customerCodeDaryaft","customerNameDaryaft","customerIdDaryaft")
    }else{
        enableCustomerInfo("customerCodeDaryaft","customerNameDaryaft","customerIdDaryaft");
    }
})

function disableCustomerInfo(codeInputId,nameInputId,idInputId){
    $("#"+codeInputId).val("");
    $("#"+nameInputId).val("");
    $("#"+idInputId).val("");
    $("#"+codeInputId).prop("disabled",true);
    $("#"+nameInputId).prop("disabled",true);
    $("#"+idInputId).prop("disabled",true);
}

function enableCustomerInfo(codeInputId,nameInputId,idInputId){
    $("#"+codeInputId).val("");
    $("#"+nameInputId).val("");
    $("#"+idInputId).val("");

    $("#"+codeInputId).prop("disabled",false);
    $("#"+nameInputId).prop("disabled",false);
    $("#"+idInputId).prop("disabled",false);
}





function openDaryaftEditModal(snGetAndPay) {
    fetch(baseUrl + "/getGetAndPayInfo?snGetAndPay=" + snGetAndPay)
        .then(response => response.json())
        .then(respond => {
            
        if(respond.response[0].StatusHDS === 1){
            swal({
                text:`به علت رسیدگی قادر به اصلاح نمی باشید!`,
                buttons:true
            });

        }else{
            if(respond.response[0].SnFactForTasviyeh>0){
                swal({
                    text:` سند مورد نظر مربوط به فاکتور فروش به شماره xxx می باشد.
                     قادر به اصلاح/حذف نمی باشید.
                    جهت اصلاح/حذف فقط کافیست مبالغ از داخل فاکتور مربوطه حذف کنید. `,
                    buttons:true
                });
            }else{
                  document.getElementById("editDaryaftDate").value = respond.response[0].DocDate;
                if(respond.response[0].DocTypeHDS==0){
                    document.getElementById("DocTypeCustomerHDSStateDarEdit").checked = true;
                }else{
                    document.getElementById("DocTypeDarAmadHDSStateDarEdit").checked = true
                }
                document.getElementById("SerialNoHDSDaryaftEdit").value = respond.response[0].SerialNoHDS;
                document.getElementById("customerCodeDaryaftEdit").value = respond.response[0].PCode;
                document.getElementById("customerNameDaryaftEdit").value = respond.response[0].Name;
                document.getElementById("customerIdDaryaftEdit").value = respond.response[0].PeopelHDS;
                document.getElementById("sandoghIdDarEdit").value = respond.response[0].SnCashMaster;//آی دی صندوق
                document.getElementById("inforTypeDaryaftEdit").value = respond.response[0].InforHDS;
                document.getElementById("inforTypeCodeDarEdit").value = respond.response[0].INforCode;
                document.getElementById("daryaftHdsDescEdit").value = respond.response[0].DocDescHDS;
                document.getElementById("totalNetPriceHDSDarEdit").value = respond.response[0].NetPriceHDS;

                document.getElementById("editAddEditDaryafTotal").innerText = parseInt(respond.response[0].NetPriceHDS).toLocaleString('en-us');
               
                $("#addedDaryaftListBodyEdit").empty();
                document.getElementById("addedDaryaftListBodyEdit").innerHTML = "";

                respond.response[0].BYS.forEach((element, index) => {
                   
                  const tableRow = document.createElement("tr");
                     tableRow.setAttribute("onclick", `setAddedDaryaftItemStuff(this,${element.SerialNoBYS})`);
                     tableRow.setAttribute("ondblclick", `editAddedDaryaftItem(this,${element.DocTypeBYS},${element.SerialNoBYS})`);
                     tableRow.innerHTML = `
                        <td class="addEditVagheNaqd-1"><input type="checkbox" value="${index+1}" name="BYSS[]" checked/>${index + 1}</td>
                        <td class="addEditVagheNaqd-2"> 0 </td>
                        <td class="addEditVagheNaqd-3"> ${element.bankDesc} </td>
                        <td class="addEditVagheNaqd-4"> ${parseInt(element.Price).toLocaleString('en-us')} </td>
                        <td class="addEditVagheNaqd-5"> 0 </td>
                        <td class="addEditVagheNaqd-6"> 0 </td>
                        <td class="addEditVagheNaqd-7"> 0 </td>
                        <td class="d-none"> <input type="text" value="${element.DocTypeBYS}" name="DocTypeBys${index + 1}"/> </td>
                        <td class="d-none"> <input type="text" value="${element.Price}" name="Price${index+1}"/> </td>
                        <td class="d-none"> <input type="text" value="${element.ChequeDate}" name="ChequeDate${index+1}"/> </td>
                        <td class="d-none"> <input type="text" value="${element.ChequeNo}" name="ChequeNo${index+1}"/> </td>
                        <td class="d-none"> <input type="text" value="${element.AccBankno}" name="AccBankNo${index+1}"/> </td>
                        <td class="d-none"> <input type="text" value="${element.Owner}" name="Owener${index+1}"/> </td>
                        <td class="d-none"> <input type="text" value="${element.SnBank}" name="SnBank${index+1}"/> </td>
                        <td class="d-none"> <input type="text" value="${element.SnChequeBook}" name="SnChequeBook${index+1}"/> </td>
                        <td class="d-none"> <input type="text" value="${element.DocDescBYS}" name="DocDescBys${index+1}"/> </td>
                        <td class="d-none"> <input type="text" value="${element.SnAccBank}" name="SnAccBank${index+1}"/> </td>
                        <td class="d-none"> <input type="text" value="${element.CashNo}" name="CashNo${index+1}"/> </td>
                        <td class="d-none"> <input type="text" value="${element.NoPayaneh_KartKhanBys}" name="NoPayanehKartKhanBYS${index+1}"/> </td>
                        <td class="d-none"> <input type="text" value="${element.SnPeopelPay}" name="SnPeopelPay${index+1}"/> </td>
                        <td class="d-none"> <input type="text" value="${element.SerialNoBYS}" name="SerialNoBYS${index+1}"/> </td>
                    `;
                    
                    document.getElementById("addedDaryaftListBodyEdit").appendChild(tableRow);
                });

                if (!($('.modal.in').length)) {
                    $('.modal-dialog').css({
                        top: 0,
                        left: 0
                    });
                }
                $('#daryaftEditModal').modal({
                    backdrop: false,
                    show: true
                });
            
                $('.modal-dialog').draggable({
                    handle: ".modal-header"
                });
            }
        }
    });
}



function closeDaryaftEditModal(){
    $("#daryaftEditModal").modal("hide")
}

function paysModal(){
    if (!($('.modal.in').length)) {
        $('.modal-dialog').css({
            top: 0,
            left: 10
        });
    }
    $('#payModal').modal({
        backdrop: false,
        show: true
    });

    $('.modal-dialog').draggable({
        handle: ".modal-header"
    });
    $("#payModal").modal("show")
}



function setAddedDaryaftItemStuff(element, bysSn) {
    var selectedRow = document.querySelector("#addedDaryaftListBodyEdit > tr.selected");

    if (selectedRow && selectedRow.classList.contains("selected")) {
        selectedRow.classList.remove("selected");
    }

    element.classList.add("selected");
    document.getElementById("editaddedGetAndPayBtn").disabled = false;
    document.getElementById("deleteReceiveItemBtn").disabled = false;

    if (bysSn === 0) {
        var modalTypeValue = selectedRow.querySelector("td:nth-child(8) > input").value;
            document.getElementById("editaddedGetAndPayBtn").value = modalTypeValue;
            document.getElementById("deleteReceiveItemBtn").value = modalTypeValue;
    } else {
            document.getElementById("editaddedGetAndPayBtn").value = bysSn;
            document.getElementById("deleteReceiveItemBtn").value = bysSn;
    }
}




function editAddedDaryaftItem(element,bysType,bysSn){
    $("#addedDaryaftListBodyEdit tr").removeClass("selected");
    $(element).addClass("selected");
    alert(`should open addedEdit modal with type ${bysType} and id ${bysSn}`);
}


// get the DocTypeBys and add the value type to Edit button
function addEditDaryaftItem(element){
    $("tr").removeClass("selected");
    $(element).addClass("selected");
    $("#editDaryaftItemBtn").prop("disabled",false)
    $("#deleteDaryaftItemBtn").prop("disabled",false)

    const modalTypeValue = $("#addedDaryaftListBody > tr.selected > td:nth-child(8) > input").val();
    $("#editDaryaftItemBtn").val(modalTypeValue);
    $("#deleteDaryaftItemBtn").val(modalTypeValue);
}

const editDaryaftItemType = (typeValue)=> {
    let modalType = parseInt(typeValue);

    if(modalType===1){
        let darVajhNaghdMoney = $('#addedDaryaftListBody tr.selected  td:nth-child(9)').find('input').val();
        let money = $('#addedDaryaftListBody tr.selected td:nth-child(9)').find('input').val();
        let description = $('#addedDaryaftListBody tr.selected td:nth-child(16)').find('input').val();
        $("#rialNaghdDarEd").val(money);
        $("#descNaghdDarEd").val(description);
        $("#addDaryaftVajhNaghdEditModal").modal("show");
    }

    if(modalType===2){
        let sayadinNo = $('#addedDaryaftListBody tr.selected td:nth-child(10)').find('input').val();
        let sbatBaNam = $('#addedDaryaftListBody tr.selected td:nth-child(11)').find('input').val();
        let money = $('#addedDaryaftListBody tr.selected td:nth-child(12)').find('input').val();
        let ChequeDate = $('#addedDaryaftListBody tr.selected td:nth-child(13)').find('input').val();
        let chequeNo = $('#addedDaryaftListBody tr.selected td:nth-child(14)').find('input').val();
        let AccBankNo = $('#addedDaryaftListBody tr.selected td:nth-child(15)').find('input').val();
        let Owener = $('#addedDaryaftListBody tr.selected td:nth-child(16)').find('input').val();
        let SnBank = $('#addedDaryaftListBody tr.selected td:nth-child(17)').find('input').val();
        let SnChequeBook = $('#addedDaryaftListBody tr.selected td:nth-child(18)').find('input').val();
        let description = $('#addedDaryaftListBody tr.selected td:nth-child(19)').find('input').val();
        let docDesc = $('#addedDaryaftListBody tr.selected td:nth-child(20)').find('input').val();
        let CashNo = $('#addedDaryaftListBody tr.selected td:nth-child(21)').find('input').val();
        let NoPayanehKartKhanBYS = $('#addedDaryaftListBody tr.selected td:nth-child(22)').find('input').val();
        let repeatCheque = $('#addedDaryaftListBody tr.selected td:nth-child(23)').find('input').val();
        let dueDateMonth = $('#addedDaryaftListBody tr.selected td:nth-child(24)').find('input').val();
        let dueDateDay = $('#addedDaryaftListBody tr.selected td:nth-child(25)').find('input').val();
        let newdDate = $('#addedDaryaftListBody > tr.selected > td.dayaftAddTd-3').text();
        const startIndex = newdDate.indexOf("تاریخ") + 5;
        const endIndex = startIndex + 11;
        const splitedDate = newdDate.substring(startIndex, endIndex);

        $("#editMoneyChequeDar").val(money)
        $("#editDaysAfterChequeDateDar").val()
        $("#editChequeNoCheqeDar").val(chequeNo)
        $("#editHisabNoChequeDar").val(AccBankNo)
        $("#editMalikChequeDar").val(Owener)
        $("#editCheckSarRasidDateDar").val(splitedDate)
        $("#editBankNameDar").select(SnBank)
        $("#editShobeBankChequeDar").val(SnBank)
        $("#editMoneyInLetters").val(SnChequeBook)
        $("#editSayyadiNoChequeDar").val(sayadinNo)
        $("#editSabtBeNameChequeDar").val(sbatBaNam)
        $("#editDescChequeDar").val(description)
        $("#editRepeateChequeDar").val(repeatCheque)
        $("#editDistanceMonthChequeDar").val(dueDateMonth)
        $("#editDistanceDarChequeDar").val(dueDateDay)
        $("#editDaryafAddChequeInfo").modal("show");
    }

    if(modalType===3){
        let money = $('#addedDaryaftListBody > tr > td.dayaftAddTd-4').text();
        let hawalaNo = $("#addedDaryaftListBody > tr > td:nth-child(23) > input[type=text]").val();
        let hawalaDate = $('#addedDaryaftListBody > tr > td:nth-child(11) > input[type=text]').val();
        let hawalBankAcc = $('#addedDaryaftListBody > tr > td:nth-child(13) > input[type=text]').val();
        let hawalSharh = $('#addedDaryaftListBody > tr > td:nth-child(17) > input[type=text]').val();
        let sharh = $('#addedDaryaftListBody > tr > td:nth-child(22) > input[type=text]').val();
        let payanahKartKhanNo = $('#addedDaryaftListBody > tr > td:nth-child(20) > input[type=text]').val();

        $("#hawalaNoHawalaDarEd").val(hawalaNo)
        $("#bankJustAccNoHawalaDarEd").val(hawalBankAcc)
        $("#bankAccNoHawalaDarEd").val(sharh)
        $("#payanehKartKhanNoHawalaDarEd").val(payanahKartKhanNo)
        $("#monyAmountHawalaDarEd").val(money)
        $("#hawalaDateHawalaDarEd").val(hawalaDate)
        $("#discriptionHawalaDarEd").val(hawalSharh)

        $.get(baseUrl+"/allBanks",(respond,status)=>{
            $("#bankAccNoHawalaDarEd").empty();
            $("#bankAccNoHawalaDarEd").append(`<option></option>`);
            for (const element of respond.bankKarts) {
                $("#bankJustAccNoHawalaDar").val(element.AccNo);
                $("#bankAccNoHawalaDarEd").append(`<option selected value="${element.AccNo}">${element.bsn}</option>`);
            }
        });
        
      $("#daryaftHawalaInfoModalEdit").modal("show");
    }

    if (modalType === 4) {
        let selectedRow = document.querySelector('#addedDaryaftListBody tr.selected');
        
        if (selectedRow) {
            let takhfifDesc = selectedRow.querySelector('td:nth-child(4)').textContent;
            let money = selectedRow.querySelector('td:nth-child(5)').textContent;
    
            document.getElementById("takhfifMoneyDarEdit").value = money;
            document.getElementById("discriptionTakhfifDarEdit").value = takhfifDesc;
    
            document.getElementById("takhfifModalEdit").style.display = "block";
        }
    }


  if (modalType === 6){
    // get values and text form table 
    let selectedRow = document.querySelector('#addedDaryaftListBody tr.selected');
    let vairzMoblagh = selectedRow.querySelector("td:nth-child(5)").textContent;
    let bankAccount = selectedRow.querySelector("td:nth-child(13) > input[type=text]").value;
    let description = selectedRow.querySelector("td:nth-child(17) > input[type=text]").value;
    let tarafHesab = selectedRow.querySelector("td:nth-child(24) > input[type=text]").value;
    let payGeriNo = selectedRow.querySelector("td:nth-child(23) > input[type=text]").value;
    let baName = selectedRow.querySelector("td:nth-child(22) > input[type=text]").value;

    // by onkeyp get the taraf hesab
    $("#varizBehisabDigariCustomerCodeDarEdit").on("keyup",function(e){
        $.get(baseUrl+"/getCustomerInfoByCode",{pcode:$("#varizBehisabDigariCustomerCodeDarEdit").val()},function(respond,status){
            $("#varizBehisabDigariCustomerNameDarEdit").val(respond[0].Name);
            $("#varizBehisabDigariCustomerPSNDar").val(respond[0].PSN);
        })
    })
    
    // insert data to input field
    document.getElementById("moneyVarizToOtherHisabDarEdit").value = vairzMoblagh;
    document.getElementById("cartNoVarizToOtherDarEdit").value = bankAccount;
    document.getElementById("varizBehisabDigariCustomerCodeDarEdit").value = tarafHesab;
    document.getElementById("paygiriOtherHisabDarEdit").value = payGeriNo;
    document.getElementById("benamOtherHisabDarEdit").value = baName;
    document.getElementById("discriptionOtherHisabDarEdit").value = description;

    // open modal
    document.getElementById("varizToOthersHisbModalEdit").style.display = "block";
  }
}


 
function addEditAddChequeDar() {
    var currentIndex = $("#addedDaryaftListBody tr").length;
    let money = $("#editMoneyChequeDar").val()
    let checquDate = $("#editDaysAfterChequeDateDar").val()
    let chequeNo = $("#editChequeNoCheqeDar").val()
    let hesabNo = $("#editHisabNoChequeDar").val()
    let malik = $("#editMalikChequeDar").val()
    let sarRased = $("#editCheckSarRasidDateDar").val()
    var bankName = $("#editBankNameDar option:selected").text();
    let bankBranch = $("#editShobeBankChequeDar").val()
    let moneyToLetter = $("#editMoneyInLetters").val()
    let sayadiNo = $("#editSayyadiNoChequeDar").val()
    let sabtBaName = $("#editSabtBeNameChequeDar").val()
    let descCheque = $("#editDescChequeDar").val()
    let repeatCheque = $("#editRepeateChequeDar").val()
    let distanceMonth = $("#editDistanceMonthChequeDar").val()
    let distanceDay = $("#editDistanceDarChequeDar").val()
    let checkDescription = $("#addedDaryaftListBody > tr:nth-child(5) > td.dayaftAddTd-3").text();
    $(`#addedDaryaftListBody tr:nth-child(${currentIndex}) td:nth-child(3)`).text(0);
    $(`#addedDaryaftListBody tr:nth-child(${currentIndex}) td:nth-child(4)`).text(checkDescription);
    $(`#addedDaryaftListBody tr:nth-child(${currentIndex}) td:nth-child(5)`).text(money);
    $(`#addedDaryaftListBody tr:nth-child(${currentIndex}) td:nth-child(6)`).text(0);
    $(`#addedDaryaftListBody tr:nth-child(${currentIndex}) td:nth-child(7)`).text(sayadiNo);
    // input 8 has default value of 2
    $(`#addedDaryaftListBody tr:nth-child(${currentIndex}) td:nth-child(9)`).text(sabtBaName);

    // set values to input fields 
    $(`#addedDaryaftListBody > tr > td:nth-child(10) > input[type=text]`).val(sayadiNo);
    $(`#addedDaryaftListBody > tr > td:nth-child(11) > input[type=text]`).val(sabtBaName);
    $(`#addedDaryaftListBody > tr > td:nth-child(12) > input[type=text]`).val(money);
    $(`#addedDaryaftListBody > tr > td:nth-child(13) > input[type=text]`).val(checquDate);
    $(`#addedDaryaftListBody > tr > td:nth-child(14) > input[type=text]`).val(chequeNo);
    $(`#addedDaryaftListBody > tr > td:nth-child(15) > input[type=text]`).val(hesabNo);
    $(`#addedDaryaftListBody > tr > td:nth-child(16) > input[type=text]`).val(malik);
    $(`#addedDaryaftListBody > tr > td:nth-child(17) > input[type=text]`).val(bankBranch);
    $(`#addedDaryaftListBody > tr > td:nth-child(18) > input[type=text]`).val(moneyToLetter);
    $(`#addedDaryaftListBody > tr > td:nth-child(19) > input[type=text]`).val(descCheque);
    $(`#addedDaryaftListBody > tr > td:nth-child(20) > input[type=text]`).val(bankName);
    $(`#addedDaryaftListBody > tr > td:nth-child(21) > input[type=text]`).val(0);
    $(`#addedDaryaftListBody > tr > td:nth-child(22) > input[type=text]`).val(repeatCheque);
    $(`#addedDaryaftListBody > tr > td:nth-child(23) > input[type=text]`).val(distanceMonth);
    $(`#addedDaryaftListBody > tr > td:nth-child(24) > input[type=text]`).val(distanceDay);
    
    $("#editDaryafAddChequeInfo").modal("hide");

    // Recalculate netPriceHDS
    let netPriceHDS = 0;
    for (let index = 1; index <= currentIndex; index++) {
        netPriceHDS += parseInt($(`#addedDaryaftListBody tr:nth-child(${index}) td:nth-child(5)`).text().replace(/,/g, ''));
    }
    $("#netPriceDar").text(parseInt(netPriceHDS).toLocaleString("en-us"));
    $("#totalNetPriceHDSDar").val(netPriceHDS);
}


// eidt part of the daryaft

function EditaddNaghdMoneyDar() {
    let reials = document.getElementById("editAddRialNaghdDar").value.replace(/,/g, '');
    let description = document.getElementById("editAddDescNaghdDar").value;

    const currentIndex = document.querySelectorAll("#addedDaryaftListBodyEdit tr").length;

    const tableRow = document.createElement("tr");
    tableRow.setAttribute("onclick", `setAddedDaryaftItemStuff(this,0)`);
    tableRow.setAttribute("ondblclick", `editAddedDaryaftItem(this, 0, 0)`);

    tableRow.innerHTML = `
        <td class="d-none"> <input type="checkbox" checked value="${currentIndex+1}" name="byss[]"/> </td>
        <td class="addEditVagheNaqd-1"> ${currentIndex+1} </td>
        <td class="addEditVagheNaqd-2"> </td>
        <td class="addEditVagheNaqd-3"> وجه نقد </td>
        <td class="addEditVagheNaqd-4"> ${parseInt(reials).toLocaleString("en-us")} </td>
        <td class="addEditVagheNaqd-5"> </td>
        <td class="addEditVagheNaqd-6"> </td> 
        <td> <input type="text" value="1" name="DocTypeBys${currentIndex+1}" class="d-none"/> </td>
        <td class="d-none"> <input type="text" value="${reials}" name="Price${currentIndex+1}" class="d-none"/> </td>
        <td class="d-none"> <input type="text" value="0" name="ChequeDate${currentIndex+1}" class="d-none"/> </td>
        <td class="d-none"> <input type="text" value="0" name="ChequeNo${currentIndex+1}" class="d-none"/> </td>
        <td class="d-none"> <input type="text" value="0" name="AccBankNo${currentIndex+1}" class="d-none"/> </td>
        <td class="d-none"> <input type="text" value="0" name="Owener${currentIndex+1}" class="d-none"/> </td>
        <td class="d-none"> <input type="text" value="" name="SnBank${currentIndex+1}" class="d-none"/> </td>
        <td class="d-none"> <input type="text" value="0" name="SnChequeBook${currentIndex+1}" class="d-none"/> </td>
        <td class="d-none"> <input type="text" value="${description}" name="DocDescBys${currentIndex+1}" class="d-none"/> </td>
        <td class="d-none"> <input type="text" value="0" name="SnAccBank${currentIndex+1}" class="d-none"/> </td>
        <td class="d-none"> <input type="text" value="0" name="CashNo${currentIndex+1}" class="d-none"/> </td>
        <td class="d-none"> <input type="text" value="0" name="NoPayanehKartKhanBYS${currentIndex+1}" class="d-none"/> </td>
        <td class="d-none"> <input type="text" value="0" name="SnPeopelPay${currentIndex+1}" class="d-none"/> </td>
    `
    document.getElementById("addedDaryaftListBodyEdit").appendChild(tableRow);
    makeTableColumnsResizable("addedEditDaryaftable");

    $("#editAddEditVagheNaghdmodal").modal("hide");

    // Recalculate netPriceHDS
    let netPriceHDS = 0;

    for (let index = 1; index <= currentIndex; index++) {
        let element = document.querySelector(`#addedDaryaftListBody tr:nth-child(${index}) td:nth-child(5)`);
        if (element) {
            netPriceHDS += parseInt(element.textContent.replace(/,/g, ''), 10) || 0;
        }
    }

   document.getElementById("editAddEditDaryafMoblagh").textContent = parseInt(reials).toLocaleString("en-us");
   document.getElementById("editAddEditDaryafTotal").textContent  = netPriceHDS;
}


$("#editAddDaysAfterChequeDateDar").on("keyup",function(e){
    let daysLater=$("#editAddDaysAfterChequeDateDar").val();
    if(parseInt(daysLater)>0){
        let chequeDate=$("#editAddCheckSarRasidDateDar").data("gdate");
        let laterChequeDate=new Date(chequeDate);
        let newDate=new Date().setDate(laterChequeDate.getDate() + parseInt(daysLater))
        let updateDateHijri=new Intl.DateTimeFormat('fa-IR', { year: 'numeric', month: '2-digit', day: '2-digit' }).format(newDate);
        $("#editAddCheckSarRasidDateDar").val(updateDateHijri);
    }else{
        let chequeDate=$("#editAddCheckSarRasidDateDar").data("gdate");
        let laterChequeDate=new Date(chequeDate);
        let newDate=new Date().setDate(laterChequeDate.getDate() + parseInt(0))
        let updateDateHijri=new Intl.DateTimeFormat('fa-IR', { year: 'numeric', month: '2-digit', day: '2-digit' }).format(newDate);
        $("#editAddCheckSarRasidDateDar").val(updateDateHijri);
    }
})


$("#editAddMoneyChequeDar").on("keyup",()=>{
    let moneyAmount=$("#editAddMoneyChequeDar").val();
    changeNumberToLetter($("#editAddMoneyChequeDar"),"editAddMoneyInLetters",moneyAmount)
})

$("#editAddShobeBankChequeDar").on("click",()=>{
    $.get(baseUrl+"/getAllShobeBanks",function(respond,status){
        $("#shobeBankChequeDarBody").empty();
        respond.forEach((element,index)=>{
            $("#shobeBankChequeDarBody").append(`<tr onclick="selectShobeBankForChequeDar(this,${element.snbranch})" ><td>${(index+1)}</td><td>${element.namebranch}</td></tr>`);
        })
        $("#shobeBankChequeDarMadal").modal("show");
    })
})

// add event listener 

    let dayValueEd;
    let monthValueEd;

    const distanceMonthEd = document.getElementById('editAddDistanceMonthChequeDar');
    const distanceDayEd = document.getElementById('editAddDistanceDarChequeDar');
if(distanceMonthEd){

    distanceMonthEd.addEventListener('keyup', () => {
        if (distanceMonthEd.value.length > 0) {
            distanceDayEd.value = "";
            monthValueEd = parseInt(distanceMonthEd.value);
        }
    });
        
}
if(distanceDayEd){
    distanceDayEd.addEventListener('keyup', () => {
        if (distanceDayEd.value.length > 0) {
            dayValueEd = parseInt(distanceDayEd.value);
            distanceMonthEd.value = "";
        }
    });
}


    function editAddChequeDar(){
        let currentIndex = document.querySelectorAll("#addedDaryaftListBodyEdit tr").length;

        let chequeNo = document.getElementById('editAddChequeNoCheqeDar').value;
        let sarRasedDate = document.getElementById('editAddCheckSarRasidDateDar').value;
        let chequekDateForLater = document.getElementById('editAddDaysAfterChequeDateDar').value;
        let selectElement = document.getElementById('editAddBankNameDar');
        let selectedOption = selectElement.options[selectElement.selectedIndex];
        let bankName = selectedOption.textContent || selectedOption.innerText;
        let bankSn =  document.getElementById('editAddBankNameDar').value;
        let bankBranch = document.getElementById('editAddShobeBankChequeDar').value;
        let chequeAmount = document.getElementById('editAddMoneyChequeDar').value;
        let accountNo = document.getElementById('editAddHisabNoChequeDar').value;
        let chequekOwner = document.getElementById('editAddMalikChequeDar').value;
        let seyadiNo = document.getElementById('editAddSayyadiNoChequeDar').value;
        let sabtShoudaBeName = document.getElementById('editAddSabtBeNameChequeDar').value;
        let chequeDescription = document.getElementById('editAddDescChequeDar').value;
        let chequeRepeate = document.getElementById('editAddRepeateChequeDar').value;
        let sarRasedDistanceMonth = document.getElementById('editAddDistanceMonthChequeDar').value;
        let sarRasedDistanceDay = document.getElementById('editAddDistanceDarChequeDar').value;
   

        let updateDateHijri;

        if (chequeRepeate > 1) {
            for (let i = 0; i < chequeRepeate; i++) {

                if (dayValueEd > 0 || monthValueEd > 0) {
                    let chequeDate = $("#editAddCheckSarRasidDateDar").data("gdate");
                    let laterChequeDate = new Date(chequeDate);
                    
                    if (dayValueEd > 0) {
                        laterChequeDate.setDate(laterChequeDate.getDate() + dayValueEd * i);
                    }
        
                    if (monthValueEd > 0) {
                        laterChequeDate.setMonth(laterChequeDate.getMonth() + monthValueEd * i);
                    }
                    updateDateHijri = new Intl.DateTimeFormat('fa-IR', { year: 'numeric', month: '2-digit', day: '2-digit' }).format(laterChequeDate);
                } else {
                    let chequeDate = $("#editAddCheckSarRasidDateDar").data("gdate");
                    let laterChequeDate = new Date(chequeDate);
                        updateDateHijri = new Intl.DateTimeFormat('fa-IR', { year: 'numeric', month: '2-digit', day: '2-digit' }).format(laterChequeDate);
                }

                let tableRow = document.createElement('tr');
                    tableRow.setAttribute("onclick", `setAddedDaryaftItemStuff(this,0)`);
                    tableRow.setAttribute("ondblclick", `editAddedDaryaftItem(this, 0, 0)`);

                    currentIndex++;

                tableRow.innerHTML=`
                        <td class="d-none"> <input type="checkbox" checked value="${currentIndex+i}" name="byss[]"/></td>
                        <td class="addEditVagheNaqd-1"> ${currentIndex} </td>
                        <td class="addEditVagheNaqd-2"> 0 </td>
                        <td class="addEditVagheNaqd-3"> چک بانک ${bankName} به شماره ${accountNo + i} تاریخ ${updateDateHijri} </td>
                        <td class="addEditVagheNaqd-4"> ${parseInt(chequeAmount).toLocaleString("en-us")} </td>
                        <td class="addEditVagheNaqd-5"> 0 </td>
                        <td class="addEditVagheNaqd-6"> ${seyadiNo} </td>
                        <td class="addEditVagheNaqd-7 d-none"> <input type="text" value="2" name="DocTypeBys${currentIndex+1}" class=""/> </td>
                        <td class="addEditVagheNaqd-8"> ${sabtShoudaBeName}  </td>
                        <td class="d-none"> <input type="text" value="${seyadiNo}" name="sayyadiNoChequeDar${currentIndex+1}"/> </td>
                        <td class="d-none"> <input type="text" value="${sabtShoudaBeName}" name="sabtBeNameChequeDar${currentIndex+1}"/> </td>
                        <td class="d-none"> <input type="text" value="${chequeAmount}" name="Price${currentIndex+1}" class=""/> </td>
                        <td class="d-none"> <input type="text" value="${sarRasedDate}" name="ChequeDate${currentIndex+1}" class=""/> </td>
                        <td class="d-none"> <input type="text" value="${chequeNo+i}" name="ChequeNo${currentIndex+1}" class=""/> </td>
                        <td class="d-none"> <input type="text" value="${hisabNoChequeDar}" name="AccBankNo${currentIndex+1}" class=""/> </td>
                        <td class="d-none"> <input type="text" value="${chequekOwner}" name="Owener${currentIndex+1}" class=""/> </td>
                        <td class="d-none"> <input type="text" value="${bankName}" name="SnBank${currentIndex+1}" class=""/> </td>
                        <td class="d-none"> <input type="text" value="0" name="SnChequeBook${currentIndex+1}" class=""/> </td>
                        <td class="d-none"> <input type="text" value="${chequeDescription}" name="DocDescBys${currentIndex+1}" class=""/> </td>
                        <td class="d-none"> <input type="text" value="${bankSn}" name="SnAccBank${currentIndex+1}" class=""/> </td>
                        <td class="d-none"> <input type="text" value="0" name="NoPayanehKartKhanBYS${currentIndex+1}" class=""/> </td>
                        <td class="d-none"> <input type="text" value="0" name="SnPeopelPay${currentIndex+1}" class=""/> </td>
                        <td class="d-none"> <input type="text" value="${repeateChequeDar}" name="repeatChequDar${currentIndex+1}" class=""/> </td>
                        <td class="d-none"> <input type="text" value="${sarRasedDistanceMonth}" name="dueDateMonth${currentIndex+1}" class=""/> </td>
                        <td class="d-none"> <input type="text" value="${sarRasedDistanceDay}" name="dueDateDat${currentIndex+1}" class=""/> </td>
                        <td class="d-none"> <input type="text" value="${chequekDateForLater}" name="laterDate${currentIndex+1}" class=""/> </td>
                 `
                   document.getElementById("addedDaryaftListBodyEdit").appendChild(tableRow);

                }} else {
                    let tableRow = document.createElement('tr');
                        tableRow.setAttribute("onclick", `setAddedDaryaftItemStuff(this,0)`);
                        tableRow.setAttribute("ondblclick", `editAddedDaryaftItem(this, 0, 0)`);
                        currentIndex++;
                        tableRow.innerHTML=`
                            <td class="d-none"> <input type="checkbox" checked value="${currentIndex+i}" name="byss[]"/></td>
                            <td class="addEditVagheNaqd-1"> ${currentIndex} </td>
                            <td class="addEditVagheNaqd-2"> 0 </td>
                            <td class="addEditVagheNaqd-3"> چک بانک ${bankName} به شماره ${accountNo + i} تاریخ ${updateDateHijri}</td>
                            <td class="addEditVagheNaqd-4"> ${parseInt(chequeAmount).toLocaleString("en-us")} </td>
                            <td class="addEditVagheNaqd-5"> 0 </td>
                            <td class="addEditVagheNaqd-6"> ${seyadiNo} </td>
                            <td class="addEditVagheNaqd-7 d-none"> <input type="text" value="2" name="DocTypeBys${currentIndex+1}" class=""/> </td>
                            <td class="addEditVagheNaqd-8"> ${sabtShoudaBeName}  </td>

                            <td class="d-none"> <input type="text" value="${seyadiNo}" name="sayyadiNoChequeDar${currentIndex+1}"/> </td>
                            <td class="d-none"> <input type="text" value="${sabtShoudaBeName}" name="sabtBeNameChequeDar${currentIndex+1}"/></td>
                            <td class="d-none"> <input type="text" value="${chequeAmount}" name="Price${currentIndex+1}" class=""/> </td>
                            <td class="d-none"> <input type="text" value="${sarRasedDate}" name="ChequeDate${currentIndex+1}" class=""/> </td>
                            <td class="d-none"> <input type="text" value="${chequeNoCheqeDar}" name="ChequeNo${currentIndex+1}" class=""/> </td>
                            <td class="d-none"> <input type="text" value="${chequeNo}" name="AccBankNo${currentIndex+1}" class=""/> </td>
                            <td class="d-none"> <input type="text" value="${chequekOwner}" name="Owener${currentIndex+1}" class=""/> </td>
                            <td class="d-none"> <input type="text" value="${bankNameDar}" name="SnBank${currentIndex+1}" class=""/> </td>
                            <td class="d-none"> <input type="text" value="0" name="SnChequeBook${currentIndex+1}" class=""/> </td>
                            <td class="d-none"> <input type="text" value="${chequeDescription}" name="DocDescBys${currentIndex+1}" class=""/> </td>
                            <td class="d-none"> <input type="text" value="${bankSn}" name="SnAccBank${currentIndex+1}" class=""/> </td>
                            <td class="d-none"> <input type="text" value="0" name="NoPayanehKartKhanBYS${currentIndex+1}" class=""/> </td>
                            <td class="d-none"> <input type="text" value="0" name="SnPeopelPay${currentIndex+1}" class=""/> </td>
                            <td class="d-none"> <input type="text" value="${repeateChequeDar}" name="repeatChequDar${currentIndex+1}" class=""/> </td>
                            <td class="d-none"> <input type="text" value="${sarRasedDistanceMonth}" name="dueDateMonth${currentIndex+1}" class=""/> </td>
                            <td class="d-none"> <input type="text" value="${sarRasedDistanceDay}" name="dueDateDat${currentIndex+1}" class=""/> </td>
                    `
                  document.getElementById("addedDaryaftListBodyEdit").appendChild(tableRow);
                }
        $("#editAddDaryafAddChequeInfo").modal("hide");
        
        makeTableColumnsResizable("addedEditDaryaftable");

        let netPriceHDS = 0;
        let rows = document.getElementById("addedDaryaftListBodyEdit").querySelectorAll("tr");
      
        for (let index = 0; index < rows.length; index++) {
            netPriceHDS += parseInt(rows[index].querySelector("td:nth-child(5)").textContent.replace(/,/g, ''));
        }

        $("#editAddEditDaryafTotal").text(parseInt(netPriceHDS).toLocaleString("en-us"));
        $("#editAddAmountRemained").text(parseInt(netPriceHDS).toLocaleString("en-us"));
        $("#editAddEditDaryafTotal").val(netPriceHDS);
    }


    $("#editAddCheckSarRasidDateDar ").persianDatepicker({
        cellWidth: 32,
        cellHeight: 22,
        fontSize: 14,
        formatDate: "YYYY/0M/0D",
        endDate: "1440/5/5",
    });

    
    
// add hawalah in edit daryaft
    function editAddHawalaDar(){
        let hawalNo = document.getElementById("eidtAddHawalaNoHawalaDar").value;
       let bankAccount = document.getElementById("editAddBankJustAccNoHawalaDar").value;

       let selectElement = document.getElementById("editAddBankAccNoHawalaDar");
       let selectedOption = selectElement.options[selectElement.selectedIndex];
       let bankName = selectedOption.textContent;

       let payanahKartKhanNo = document.getElementById("editAddPayanehKartKhanNoHawalaDar").value;
       let money = document.getElementById("editAddMonyAmountHawalaDar").value;
      
       let hawalaDate = document.getElementById("editAddHawalaDateHawalaDar").value;
       let discription = document.getElementById("editAddDiscriptionHawalaDar").value;
       
       let rowCount=$("#addedDaryaftListBodyEdit tr").length;

       let newRow = document.createElement("tr");
           newRow.setAttribute("onclick","setAddedDaryaftItemStuff(this, 0)" );
           newRow.setAttribute("ondblclick","editAddedDaryaftItem('daryaftHawalaInfoModalEdit',this)");
           newRow.innerHTML = `
                <td class="d-none"> <input type="checkbox" checked value="${rowCount+1}" name="byss[]"/> ${rowCount+1} </td>
                <td class="addEditVagheNaqd-1"> ${rowCount+1} </td>
                <td class="addEditVagheNaqd-2"> 0 </td>
                <td class="addEditVagheNaqd-3"> حواله به ${bankName} به شماره   ${hawalNo} تاریخ  ${hawalaDate}  </td>
                <td class="addEditVagheNaqd-4"> ${parseInt(money).toLocaleString("en-us")} </td>
                <td class="addEditVagheNaqd-5"> 0 </td>
                <td class="addEditVagheNaqd-6"> </td>
                <td class="d-none addEditVagheNaqd-7 d-none"> <input type="text" value="3" name="DocTypeBys${rowCount+1}" class=""/> </td>
                <td class="addEditVagheNaqd-8"> </td>
                <td class="d-none"> <input type="text" value="${money}" name="Price${rowCount+1}" class=""/> </td>
                <td class="d-none"> <input type="text" value="${hawalaDate}" name="ChequeDate${rowCount+1}" class=""/> </td>
                <td class="d-none"> <input type="text" value="0" name="ChequeNo${rowCount+1}" class=""/> </td>
                <td class="d-none"> <input type="text" value="${bankAccount}" name="AccBankNo${rowCount+1}" class=""/> </td>
                <td class="d-none"> <input type="text" value=" " name="Owener${rowCount+1}" class=""/> </td>
                <td class="d-none"> <input type="text" value="0" name="SnBank${rowCount+1}" class=""/> </td>
                <td class="d-none"> <input type="text" value="0" name="SnChequeBook${rowCount+1}" class=""/> </td>
                <td class="d-none"> <input type="text" value="${discription}" name="DocDescBys${rowCount+1}" class=""/> </td>
                <td class="d-none"> <input type="text" value="0" name="SnAccBank${rowCount+1}" class=""/> </td>
                <td class="d-none"> <input type="text" value="0" name="CashNo${rowCount+1}" class=""/> </td>
                <td class="d-none"> <input type="text" value="${payanahKartKhanNo}" name="NoPayanehKartKhanBYS${rowCount+1}" class=""/> </td>
                <td class="d-none"> <input type="text" value="0" name="SnPeopelPay${rowCount+1}" class=""/> </td>
                <td class="d-none"> <input type="text" value="حواله به ${bankName} به شماره   ${hawalaNoHawalaDar}" class=""/> </td>
                <td class="d-none"> <input type="text" value="${hawalaNoHawalaDar}" class=""/> </td>
            `
            document.getElementById("addedDaryaftListBodyEdit").appendChild(newRow);

         $("#editAddHawalaModal").modal("hide");
         
         makeTableColumnsResizable("addedEditDaryaftable");

    for (let index = 1; index <= rowCount; index++) {
        let element = document.querySelector(`#addedDaryaftListBodyEdit tr:nth-child(${index}) td:nth-child(5)`);
        if (element) {
            netPriceHDS += parseInt(element.textContent.replace(/,/g, ''), 10) || 0;
        }
    }

    $("#totalNetPriceHDSDarEdit").text(parseInt(netPriceHDS).toLocaleString("en-us"));
    $("#totalNetPriceHDSDar").val(netPriceHDS);
}

    $("#editAddHawalaDateHawalaDar").persianDatepicker({
        cellWidth: 32,
        cellHeight: 22,
        fontSize: 14,
        formatDate: "YYYY/0M/0D",
        endDate: "1440/5/5",
    });

    $("#editAddBankAccNoHawalaDar").on("change",(e)=>{
      $("#editAddBankJustAccNoHawalaDar").val($("#editAddBankAccNoHawalaDar").val());
    })


// add takhfif in edit daryaft
function editAddTakhfifDar(){
    let takhfifAmount = $("#editAddtakhfifMoneyDar").val();
    let takhfifDesc = $("#edtiAdddiscriptionTakhfifDar").val();
    let newRow = document.createElement("tr");
        newRow.setAttribute("onclick", "setAddedDaryaftItemStuff(this,0)");
        newRow.setAttribute("ondblclick", "editAddedDaryaftItem(this, 0, 0)")
    let rowCount = $("#addedDaryaftListBodyEdit tr").length;

        newRow.innerHTML = `
                <td class="d-none"> <input type="checkbox" checked value="${rowCount+1}" name="byss[]"/> ${rowCount+1} </td>
                <td class="addEditVagheNaqd-1"> ${rowCount + 1} </td>
                <td class="addEditVagheNaqd-2"> 0 </td>
                <td class="addEditVagheNaqd-3"> تخفیف </td>
                <td class="addEditVagheNaqd-4"> ${takhfifAmount} </td>
                <td class="addEditVagheNaqd-5"> 0 </td>
                <td class="addEditVagheNaqd-6"> 0 </td>
                <td class="d-none"> <input type="text" value="4" name="DocTypeBys${rowCount+1}" class=""/> </td>
                <td addEditVagheNaqd-7> </td>
                <td class="d-none"> <input type="text" value="${takhfifAmount}" name="Price${rowCount+1}" class=""/> </td>
                <td class="d-none"> <input type="text" value="0" name="ChequeDate${rowCount+1}" class=""/> </td>
                <td class="d-none"> <input type="text" value="0" name="ChequeNo${rowCount+1}" class=""/> </td>
                <td class="d-none"> <input type="text" value="0" name="AccBankNo${rowCount+1}" class=""/> </td>
                <td class="d-none"> <input type="text" value="0" name="Owener${rowCount+1}" class=""/> </td>
                <td class="d-none"> <input type="text" value="0" name="SnBank${rowCount+1}" class=""/> </td>
                <td class="d-none"> <input type="text" value="0" name="SnChequeBook${rowCount+1}" class=""/> </td>
                <td class="d-none"> <input type="text" value="${takhfifDesc}" name="DocDescBys${rowCount+1}" class=""/> </td>
                <td class="d-none"> <input type="text" value="0" name="SnAccBank${rowCount+1}" class=""/> </td>
                <td class="d-none"> <input type="text" value="0" name="CashNo${rowCount+1}" class=""/> </td>
                <td class="d-none"> <input type="text" value="0" name="NoPayanehKartKhanBYS${rowCount+1}" class=""/> </td>
                <td class="d-none"> <input type="text" value="0" name="SnPeopelPay${rowCount+1}" class=""/> </td>
           `
        document.getElementById("addedDaryaftListBodyEdit").appendChild(newRow);

       $("#editAddTakhfifModal").modal("hide");

       makeTableColumnsResizable("addedEditDaryaftable");

       let netPriceHDS=0;
        for (let index = 1; index <= rowCount+1; index++) {
            netPriceHDS+= parseInt($(`#addedDaryaftListBodyEdit tr:nth-child(${index}) td:nth-child(5)`).text().replace(/,/g, ''));
            
            console.log("I love to code faster", netPriceHDS);
        }
        $("#editAddEditDaryafTotal").text(parseInt(netPriceHDS).toLocaleString("en-us"));
        $("#totalNetPriceHDSDar").val(netPriceHDS);
}


$("#editAddVarizBehisabDigariCustomerCode").on("keyup",function(e){
    $.get(baseUrl+"/getCustomerInfoByCode",{pcode:$("#editAddVarizBehisabDigariCustomerCode").val()},function(respond,status){
        $("#editAddVarizBehisabDigariCustomerName").val(respond[0].Name);
        $("#").val(respond[0].PSN);
    })
})

$("#customerNameDaryaft").on("keyup",function(respond,status){
    $("#searchCustomerDaryaftModal").modal("show")
})


function editAddVarizeBeHesab(){
    let varizMoblagh = document.getElementById("editAddVarizeBeHesabMoney").value;
    let varizCartNo = document.getElementById("editAddVarizeBeHesabAccount").value;
    let tarafHesab = document.getElementById("editAddVarizBehisabDigariCustomerCode").value;
    let tarafHesabName = document.getElementById("editAddVarizBehisabDigariCustomerName").value;
    let baName = document.getElementById("editAddBenamOtherHisab").value;
    let payGeriNo = document.getElementById("editAddPaygiriOtherHisab").value;
    let varizDesc = document.getElementById("editAddDiscriptionOtherHisab").value;
    

    let newRow= document.createElement("tr");
        newRow.setAttribute("onclick", `setAddedDaryaftItemStuff(this,0)`);
        newRow.setAttribute("ondblclick", `editAddedDaryaftItem(this, 0, 0)`);
      
    let rowCount = document.getElementById("addedDaryaftListBodyEdit").rows.length;
        newRow.innerHTML = `
            <td class="d-none"> <input type="checkbox" checked value="${rowCount+1}" name="byss[]"/> ${rowCount+1} </td>
            <td class="addEditVagheNaqd-1"> ${rowCount + 1} </td>
            <td class="addEditVagheNaqd-2"> 0 </td>
            <td class="addEditVagheNaqd-3"> 0 </td>
            <td class="addEditVagheNaqd-4"> ${varizMoblagh} </td>
            <td class="addEditVagheNaqd-5"> </td>
            <td class="addEditVagheNaqd-6">  </td>
            <td class="d-none"> <input type="text" value="6" name="DocTypeBys${rowCount+1}" class=""/> </td>
            <td class="addEditVagheNaqd-7">  </td>
            <td class="d-none"> <input type="text" value="${varizMoblagh}" name="Price${rowCount+1}" class=""/> </td>
            <td class="d-none"> <input type="text" value=" " name="ChequeDate${rowCount+1}" class=""/> </td>
            <td class="d-none"> <input type="text" value="0" name="ChequeNo${rowCount+1}" class=""/> </td>
            <td class="d-none"> <input type="text" value="${varizCartNo}" name="AccBankNo${rowCount+1}" class=""/> </td>
            <td class="d-none"> <input type="text" value="0" name="Owener${rowCount+1}" class=""/> </td>
            <td class="d-none"> <input type="text" value="0" name="SnBank${rowCount+1}" class=""/> </td>
            <td class="d-none"> <input type="text" value="0" name="SnChequeBook${rowCount+1}" class=""/> </td>
            <td class="d-none"> <input type="text" value="${varizDesc}" name="DocDescBys${rowCount+1}" class=""/> </td>
            <td class="d-none"> <input type="text" value="0" name="SnAccBank${rowCount+1}" class=""/> </td>
            <td class="d-none"> <input type="text" value="0" name="CashNo${rowCount+1}" class=""/> </td>
            <td class="d-none"> <input type="text" value="0" name="NoPayanehKartKhanBYS${rowCount+1}" class=""/> </td>
            <td class="d-none"> <input type="text" value="${tarafHesabName}" name="SnPeopelPay${rowCount+1}" class=""/> </td>
            <td class="d-none"> <input type="text" value="${baName}" name="banameOther${rowCount+1}" class=""/> </td>
            <td class="d-none"> <input type="text" value="${payGeriNo}" name="payGeri${rowCount+1}" class=""/> </td>
            <td class="d-none"> <input type="text" value="${tarafHesab}" name="payGeri${rowCount+1}" class=""/> </td>
        `
        document.getElementById("addedDaryaftListBodyEdit").appendChild(newRow);
        $("#editAddVarizeBeHesabDegaran").modal("hide");

        makeTableColumnsResizable("addedEditDaryaftable")

    // let netPriceHDS=0;
    // for (let index = 1; index <= rowCount+1; index++) {
    //     netPriceHDS+= parseInt($(`#addedDaryaftListBodyEdit tr:nth-child(${index}) td:nth-child(5)`).text().replace(/,/g, ''));
    // }

    // $("#editAddEditDaryafTotal").text(parseInt(netPriceHDS).toLocaleString("en-us"));
    // $("#totalNetPriceHDSDar").val(netPriceHDS);
}



$("#editAddEditCheckSarRasidDate").persianDatepicker({
    cellWidth: 32,
    cellHeight: 22,
    fontSize: 14,
    formatDate: "YYYY/0M/0D",
    endDate: "1440/5/5",
});

$("#editAddEditMoneyCheque").on("keyup",()=>{
    let moneyAmount=$("#editAddEditMoneyCheque").val();
    changeNumberToLetter($("#editAddEditMoneyCheque"),"editAddEditMoneyInLetters",moneyAmount)
})

function openEditAddedGetAndPay(recordTypeValue){
    let editButton = document.getElementById("editaddedGetAndPayBtn");
    if (editButton) {
        editButton.disabled = false;
    }

    let byssValue = parseInt(recordTypeValue)
    let selectedRow = document.querySelector('#addedDaryaftListBodyEdit tr.selected');

    switch (byssValue) {
        case 1:{
                if (selectedRow) {
                    let vajheNaqdMoblagh = selectedRow.querySelector('td:nth-child(9) > input').value;
                    let vajheNaqdDes = selectedRow.querySelector('td:nth-child(16) > input').value;
                    document.getElementById("editAddEditRialNaghdDar").value = vajheNaqdMoblagh;
                    document.getElementById("editAddEditDescNaghdDar").value = vajheNaqdDes;
                }

                $("#editAddEditEditVagheNaghdmodal").modal("show");
              break;
            }

        case 2: {
                if (selectedRow) {
                    const checkNo = selectedRow.querySelector('td:nth-child(14) > input').value;
                    const sarRasedDate = selectedRow.querySelector('td:nth-child(13) > input').value;
                    //const laterDate = selectedRow.querySelector('td:nth-child(26) > input').value;
                    const bankName = selectedRow.querySelector('td:nth-child(17) > input').value;
                    const moblaghCheck = selectedRow.querySelector('td:nth-child(12) > input').value;
                    const accountNo = selectedRow.querySelector('td:nth-child(20) > input').value;
                    const chequeOwner = selectedRow.querySelector('td:nth-child(16) > input').value;
                    const seyadiNo = selectedRow.querySelector('td:nth-child(10) > input').value;
                    const sabtShoudaBeName = selectedRow.querySelector('td:nth-child(11) > input').value;
                    const description = selectedRow.querySelector('td:nth-child(19) > input').value;
                    const bankBssn = selectedRow.querySelector('td:nth-child(15) > input').value;
                
                    $.get(baseUrl+"/allBanks",(respond,status)=>{
                        $("#editAddEditBankName").empty();
                        $("#editAddEditBankName").append(`<option></option>`);
                        for (const element of respond.bankKarts) {
                    
                            if(element.SerialNoBSN==bankBssn){
                                $("#editAddEditBankName").append(`<option selected value="${element.AccNo}">${element.bsn}</option>`);
                            }else {
                                $("#editAddEditBankName").append(`<option value="${element.AccNo}">${element.bsn}</option>`);
                            }
                        }
                    });
                   
                    document.getElementById("editAddEditChequeNoCheqe").value = checkNo;
                    document.getElementById("editAddEditCheckSarRasidDate").value = sarRasedDate;
                   // document.getElementById("editAddEditDaysAfterChequeDate").value = laterDate;
                    document.getElementById("editAddBankNameDar").value = bankName;
                    document.getElementById("editAddEditMoneyCheque").value = moblaghCheck;
                    document.getElementById("editAddEditHisabNoCheque").value = accountNo;
                    document.getElementById("editAddEditMalikCheque").value = chequeOwner;
                    document.getElementById("editAddEditSayyadiNoCheque").value = seyadiNo;
                    document.getElementById("editAddEditSabtBeNameCheque").value = sabtShoudaBeName;
                    document.getElementById("editAddEditDescCheque").value = description;
                }
                $("#editAddEditDaryafAddChequeInfo").modal("show");
              break;
            }


         case 3:{
          if (selectedRow) {
            let money = selectedRow.querySelector('td.addEditVagheNaqd-4').textContent;
            let hawalaNo = selectedRow.querySelector("td:nth-child(23) > input").value;
            let hawalaDate = selectedRow.querySelector('td:nth-child(11) > input').value;
            let hawalBankAcc = selectedRow.querySelector('td:nth-child(13) > input').value;
            let hawalSharh = selectedRow.querySelector('td:nth-child(17) > input').value;
            let sharh = selectedRow.querySelector('td:nth-child(22) > input').value;
            let payanahKartKhanNo = selectedRow.querySelector('td:nth-child(20) > input').value;

            $.get(baseUrl+"/allBanks",(respond,status)=>{
                $("#editAddEditBankAccNoHawalaEdit").empty();
                $("#editAddEditBankAccNoHawalaEdit").append(`<option></option>`);
                for (const element of respond.bankKarts) {
                    if(element.SerialNoBSN==hawalBankAcc){
                        $("#editAddEditBankAccNoHawalaEdit").append(`<option selected value="${element.AccNo}">${element.bsn}</option>`);
                    }else {
                        $("#editAddEditBankAccNoHawalaEdit").append(`<option value="${element.AccNo}">${element.bsn}</option>`);
                    }
                }
            });
    
            $("#eidtAddEditHawalaNoHawalaEdit").val(hawalaNo)
            $("#editAddEditBankAccNoHawalaEdit").val(hawalBankAcc)
            $("#bankAccNoHawalaDarEd").val(sharh)
            $("#editAddEditPayanehKartKhanNoHawalaEdit").val(payanahKartKhanNo)
            $("#editAddEditMonyAmountHawalaEdit").val(money)
            $("#editAddEditHawalaDateHawalaEdit").val(hawalaDate)
            $("#editAddEditDiscriptionHawalaEdit").val(hawalSharh)
    
            $.get(baseUrl+"/allBanks",(respond,status)=>{
                $("#bankAccNoHawalaDarEd").empty();
                $("#bankAccNoHawalaDarEd").append(`<option></option>`);
                for (const element of respond.bankKarts) {
                    $("#bankJustAccNoHawalaDar").val(element.AccNo);
                    $("#bankAccNoHawalaDarEd").append(`<option selected value="${element.AccNo}">${element.bsn}</option>`);
                }
            });
            
          $("#editAddEditHawalaModalEdit").modal("show");

          break;
           
         }
     } 

     case 4: {
        let takhfifAmount = document.querySelector("#addedDaryaftListBodyEdit > tr.selected > td:nth-child(10) > input").value;
        let takhfiDesc = document.querySelector("#addedDaryaftListBodyEdit > tr.selected > td:nth-child(17) > input").value;
        
        document.getElementById("takhfifMoneyEdit").value = takhfifAmount;
        document.getElementById("discriptionTakhfifEdit").value = takhfiDesc;
        $("#editAddEditTakhfifModal").modal("show");
        break;
     }

     case 6: {
        let selectedRow = document.querySelector('#addedDaryaftListBodyEdit tr.selected');
        let vairzMoblagh = selectedRow.querySelector("td:nth-child(5)").textContent;
        let bankAccount = selectedRow.querySelector("td:nth-child(13) > input").value;
        let description = selectedRow.querySelector("td:nth-child(17) > input").value;
        let tarafHesab = selectedRow.querySelector("td:nth-child(24) > input").value;
        let tarafHesabName = selectedRow.querySelector("td:nth-child(21) > input").value;
        let payGeriNo = selectedRow.querySelector("td:nth-child(23) > input").value;
        let baName = selectedRow.querySelector("td:nth-child(22) > input").value;

        // by onkeyp get the taraf hesab
        $("#varizBehisabDigariCustomerCodeEdit").on("keyup",function(e){
            $.get(baseUrl+"/getCustomerInfoByCode",{pcode:$("#varizBehisabDigariCustomerCodeEdit").val()},function(respond,status){
                $("#varizBehisabDigariCustomerNameEdit").val(respond[0].Name);
                $("#varizBehisabDigariCustomerPSNEdit").val(respond[0].PSN);
            })
        })
    
        // insert data to input field
        document.getElementById("moneyVarizToOtherHisabEdit").value = vairzMoblagh;
        document.getElementById("cartNoVarizToOtherEdit").value = bankAccount;
        document.getElementById("varizBehisabDigariCustomerCodeEdit").value = tarafHesab;
        document.getElementById("varizBehisabDigariCustomerNameEdit").value = tarafHesabName;
        document.getElementById("paygiriOtherHisabEdit").value = payGeriNo;
        document.getElementById("benamOtherHisabEdit").value = baName;
        document.getElementById("discriptionOtherHisabEdit").value = description;
        $("#editAddEditVarizeBehesab").modal("show")
        break;
     }
      default: 
            {
                alert("modal not found");
            }
    }
    
}

$("#editDaryaftForm").on("submit",function(e){
    e.preventDefault();
    $.ajax({
        method:"POST",
        url: $(this).attr('action'),
        data: new FormData(this),
        processData: false,
        contentType: false,
        success: function (data) {
            console.log(data);
        }
    });
});

function editaddEditNaghdMoneyDar() {
    const currentIndex = document.querySelectorAll("#addedDaryaftListBodyEdit tr").length;

    let reials = document.getElementById("editAddEditRialNaghdDar").value.replace(/,/g, '');
    let description = document.getElementById("editAddEditDescNaghdDar").value;

    $(`#addedDaryaftListBodyEdit > tr:nth-child(${currentIndex}) > td.addEditVagheNaqd-4`).text(reials);

    let setMoblagh = document.getElementById(`addedDaryaftListBodyEdit > tr:nth-child(${currentIndex}) > td:nth-child(4)`);
    let setMoblaghVal = document.getElementById(`addedDaryaftListBodyEdit > tr:nth-child(${currentIndex}) > td:nth-child(9) > input`)
    let setDesValue = document.getElementById(`addedDaryaftListBodyEdit > tr:nth-child(${currentIndex}) > td:nth-child(16) > input`);
    if (setMoblagh && setMoblaghVal && setDesValue) {
        setMoblagh.textContent = reials;
        setMoblaghVal.value = reials;
        setDesValue.value = description;
    }

    $("#editAddEditEditVagheNaghdmodal").modal("hide");

    // Recalculate netPriceHDS
    let netPriceHDS = 0;

    for (let index = 1; index <= currentIndex; index++) {
        let element = $(`#addedDaryaftListBodyEdit > tr:nth-child(${index}) td:nth-child(5)`);
        if (element) {
            netPriceHDS += parseInt(element.text().replace(/,/g, ''), 10) || 0;
        }
    }

    document.getElementById("editAddEditDaryafMoblagh").textContent = parseInt(reials).toLocaleString("en-us");
    document.getElementById("editAddEditDaryafTotal").textContent = netPriceHDS;
}


function editAddEditCheque(){
    let selectedRow = document.querySelector('#addedDaryaftListBodyEdit tr.selected');

    let checkNo = document.getElementById("editAddEditChequeNoCheqe").value;
    let sarRasedDate = document.getElementById("editAddEditCheckSarRasidDate").value;
    let laterDate = document.getElementById("editAddEditDaysAfterChequeDate").value;
    let bankName = document.getElementById("editAddBankNameDar").value;
    let moblaghCheck = document.getElementById("editAddEditMoneyCheque").value;
    let accountNo = document.getElementById("editAddEditHisabNoCheque").value;
    let chequeOwner = document.getElementById("editAddEditMalikCheque").value;
    let seyadiNo = document.getElementById("editAddEditSayyadiNoCheque").value;
    let sabtShoudaBeName = document.getElementById("editAddEditSabtBeNameCheque").value;
    let description = document.getElementById("editAddEditDescCheque").value;
    let chequeDate = document.getElementById("editAddEditCheckSarRasidDate").value;

   

    selectedRow.querySelector('td:nth-child(1)').textContent = 0;
    selectedRow.querySelector('td:nth-child(4)').textContent = ` چک بانک ${bankName} به شماره ${accountNo} تاریخ ${chequeDate} `;
    selectedRow.querySelector('td:nth-child(5)').textContent = moblaghCheck;
    selectedRow.querySelector('td:nth-child(6)').textContent = 0;
    selectedRow.querySelector('td:nth-child(7)').textContent = seyadiNo;
    selectedRow.querySelector('td:nth-child(9)').textContent = sabtShoudaBeName;

    selectedRow.querySelector('td:nth-child(14) > input').value = checkNo;
    selectedRow.querySelector('td:nth-child(13) > input').value = sarRasedDate;
    selectedRow.querySelector('td:nth-child(26) > input').value = laterDate;
    selectedRow.querySelector('td:nth-child(17) > input').value = bankName;
    selectedRow.querySelector('td:nth-child(12) > input').value = moblaghCheck;
    selectedRow.querySelector('td:nth-child(20) > input').value = accountNo;
    selectedRow.querySelector('td:nth-child(16) > input').value = chequeOwner;
    selectedRow.querySelector('td:nth-child(10) > input').value = seyadiNo;
    selectedRow.querySelector('td:nth-child(11) > input').value = sabtShoudaBeName;
    selectedRow.querySelector('td:nth-child(19) > input').value = description;

    $("#editAddEditDaryafAddChequeInfo").modal("hide");
}


function editAddEditHawalaDar(){
    let hawalaNo=$("#eidtAddEditHawalaNoHawalaDar").val();
    let bankAccNo=$("#editAddEditBankJustAccNoHawalaDar").val();
    let payanehKartKhanNo=$("#editAddEditPayanehKartKhanNoHawalaDar").val();
    let monyAmountHawala=$("#editAddEditMonyAmountHawalaDar").val();
    let hawalaDateHawala=$("#editAddEditHawalaDateHawalaDar").val();
    let discriptionHawala=$("#editAddEditDiscriptionHawalaDar").val();
    let bankName = $("#editAddEditBankAccNoHawalaDar option:selected").text();

    let rowCount=$("#addedDaryaftListBodyEdit tr").length;

    $("#addedDaryaftListBodyEdit").append(`
        <tr onclick="setAddedDaryaftItemStuff(this, 0)" ondblclick="editAddedDaryaftItem('editAddEditHawalaModal',this)">
            <td class="d-none"> <input type="checkbox" checked value="${rowCount+1}" name="byss[]"/> ${rowCount+1} </td>
            <td class="addEditVagheNaqd-1"> ${rowCount+1} </td>
            <td class="addEditVagheNaqd-2"> 0 </td>
            <td class="addEditVagheNaqd-3"> حواله به ${bankName} به شماره   ${hawalaNo} تاریخ  ${hawalaDateHawala}  </td>
            <td class="addEditVagheNaqd-4"> ${parseInt(monyAmountHawala).toLocaleString("en-us")} </td>
            <td class="addEditVagheNaqd-5"> 0 </td>
            <td class="addEditVagheNaqd-6"> </td>
            <td class="d-none addEditVagheNaqd-7 d-none"> <input type="text" value="3" name="DocTypeBys${rowCount+1}" class=""/> </td>
            <td class="addEditVagheNaqd-8"> </td>
            <td class="d-none"> <input type="text" value="${monyAmountHawala}" name="Price${rowCount+1}" class=""/> </td>
            <td class="d-none"> <input type="text" value="${hawalaDateHawala}" name="ChequeDate${rowCount+1}" class=""/> </td>
            <td class="d-none"> <input type="text" value="0" name="ChequeNo${rowCount+1}" class=""/> </td>
            <td class="d-none"> <input type="text" value="${bankAccNo}" name="AccBankNo${rowCount+1}" class=""/> </td>
            <td class="d-none"> <input type="text" value="" name="Owener${rowCount+1}" class=""/> </td>
            <td class="d-none"> <input type="text" value="0" name="SnBank${rowCount+1}" class=""/> </td>
            <td class="d-none"> <input type="text" value="0" name="SnChequeBook${rowCount+1}" class=""/> </td>
            <td class="d-none"> <input type="text" value="${discriptionHawala}" name="DocDescBys${rowCount+1}" class=""/> </td>
            <td class="d-none"> <input type="text" value="0" name="SnAccBank${rowCount+1}" class=""/> </td>
            <td class="d-none"> <input type="text" value="0" name="CashNo${rowCount+1}" class=""/> </td>
            <td class="d-none"> <input type="text" value="${payanehKartKhanNo}" name="NoPayanehKartKhanBYS${rowCount+1}" class=""/> </td>
            <td class="d-none"> <input type="text" value="0" name="SnPeopelPay${rowCount+1}" class=""/> </td>
            <td class="d-none"> <input type="text" value="حواله به ${bankName} به شماره   ${hawalaNo}" class=""/> </td>
            <td class="d-none"> <input type="text" value="${hawalaNo}" class=""/> </td>
        </tr>`);

     $("#editAddEditHawalaModal").modal("hide");
     makeTableColumnsResizable("addedEditDaryaftable");
}

    $("#editAddEditHawalaDateHawalaDar").persianDatepicker({
        cellWidth: 32,
        cellHeight: 22,
        fontSize: 14,
        formatDate: "YYYY/0M/0D",
        endDate: "1440/5/5",
    });

    $("#editAddEditBankAccNoHawalaDar").on("change",(e)=>{
        $("#editAddEditBankJustAccNoHawalaDar").val($("#editAddEditBankAccNoHawalaDar").val());
   })



function editAddEditHawalaEdit() {
    let hawalaNo = document.getElementById("eidtAddEditHawalaNoHawalaEdit").value;
    let bankAccNo = document.getElementById("editAddEditBankJustAccNoHawalaEdit").value;
    let payanehKartKhanNo = document.getElementById("editAddEditPayanehKartKhanNoHawalaEdit").value;
    let monyAmountHawala = document.getElementById("editAddEditMonyAmountHawalaEdit").value;
    let hawalaDateHawala = document.getElementById("editAddEditHawalaDateHawalaEdit").value;
    let discriptionHawala = document.getElementById("editAddEditDiscriptionHawalaEdit").value;
    let bankName = document.getElementById('editAddEditBankAccNoHawalaDar').querySelector('option').textContent;

    let selectedRow = document.querySelector('#addedDaryaftListBodyEdit tr.selected');

    selectedRow.querySelector("td.addEditVagheNaqd-1").textContent = 0;
    selectedRow.querySelector("td.addEditVagheNaqd-3").textContent = `حواله به ${bankName} به شماره   ${hawalaNo} تاریخ  ${hawalaDateHawala} `
    selectedRow.querySelector("td.addEditVagheNaqd-4").textContent = monyAmountHawala;
    
    selectedRow.querySelector("td:nth-child(10) > input").value = monyAmountHawala;
    selectedRow.querySelector("td:nth-child(11) > input").value = hawalaDateHawala;
    selectedRow.querySelector("td:nth-child(17) > input").value = discriptionHawala;
    selectedRow.querySelector("td:nth-child(20) > input").value = payanehKartKhanNo;
    selectedRow.querySelector("td:nth-child(23) > input").value = hawalaNo;

     $("#editAddEditHawalaModalEdit").modal("hide");

     makeTableColumnsResizable("addedEditDaryaftable");
}

$("#editAddEditHawalaDateHawalaDar").persianDatepicker({
    cellWidth: 32,
    cellHeight: 22,
    fontSize: 14,
    formatDate: "YYYY/0M/0D",
    endDate: "1440/5/5",
});

$("#editAddEditBankAccNoHawalaEdit").on("change",(e)=>{
    $("#editAddEditBankJustAccNoHawalaEdit").val($("#editAddEditBankAccNoHawalaEdit").val());
})


function editAddEditTakhfif(){
    let takhfifMoney= document.getElementById("takhfifMoneyEdit").value;
    let discriptionTakhfifDar= document.getElementById("discriptionTakhfifEdit").value;
    
    let currentRow = document.querySelector('#addedDaryaftListBodyEdit tr.selected');
    currentRow.querySelector('td.addEditVagheNaqd-4').textContent = takhfifMoney;
    currentRow.querySelector('td:nth-child(10) > input').value = takhfifMoney;
    currentRow.querySelector('td:nth-child(17) > input').value = discriptionTakhfifDar;
    $("#editAddEditTakhfifModal").modal("hide");
    makeTableColumnsResizable("addedEditDaryaftable");
}


const editAddEditVarizBehesabSave = () => {
    let varizMoney = document.getElementById("moneyVarizToOtherHisabEdit").value;
    let cardNo = document.getElementById("cartNoVarizToOtherEdit").value;
    let tarafHesabCode = document.getElementById("varizBehisabDigariCustomerCodeEdit").value;
    let trafHesabName = document.getElementById("varizBehisabDigariCustomerNameEdit").value;
    let beName = document.getElementById("benamOtherHisabEdit").value;
    let payGeriNo = document.getElementById("paygiriOtherHisabEdit").value;
    let varizeDesc = document.getElementById("discriptionOtherHisabEdit").value;
    
    let currentRow =  document.querySelector("#addedDaryaftListBodyEdit > tr.selected")
    currentRow.querySelector("td.addEditVagheNaqd-4").textContent = varizMoney;
    currentRow.querySelector("td:nth-child(10) > input").textContent = varizMoney;
    currentRow.querySelector("td:nth-child(13) > input").textContent = cardNo;
    currentRow.querySelector("td:nth-child(17) > input").textContent = varizeDesc;
    currentRow.querySelector("td:nth-child(21) > input").textContent = trafHesabName;
    currentRow.querySelector("td:nth-child(22) > input").textContent = beName;
    currentRow.querySelector("td:nth-child(23) > input").textContent = payGeriNo;
    currentRow.querySelector("td:nth-child(24) > input").textContent = tarafHesabCode;
    
    $("#editAddEditVarizeBehesab").modal("hide")
}

// ////////////////// I love  working part //////////////////////

function deleteRow(targetTr){
    let deleteBtnValue = parseInt(targetTr);
    let selectedRow = document.querySelector('#addedDaryaftListBody tr.selected');

    switch(deleteBtnValue) {
        case 1: {
             swal({text:"آیا میخواهید وجه نقد را حذف نمایید!",
              buttons:true,
            }).then((willDelete)=>{
                if(willDelete){
                    selectedRow.parentNode.removeChild(selectedRow);
                }
            })
            break;
        }

        case 2: {
            swal({text:"آیا میخواهید چک را حذف نمایید!",
             buttons:true,
           }).then((willDelete)=>{
               if(willDelete){
                   selectedRow.parentNode.removeChild(selectedRow);
               }
           })
           break;
       }

        case 3: {
            swal({text:"آیا میخواهید حواله را حذف نمایید!",
             buttons:true,
           }).then((willDelete)=>{
               if(willDelete){
                   selectedRow.parentNode.removeChild(selectedRow);
               }
           })
           break;
       }

        case 4: {
            swal({text:"آیا میخواهید تخفیف را حذف نمایید!",
             buttons:true,
           }).then((willDelete)=>{
               if(willDelete){
                   selectedRow.parentNode.removeChild(selectedRow);
               }
           })
           break;
       }

        case 6: {
            swal({text:"آیا میخواهید واریزی را حذف نمایید!",
             buttons:true,
           }).then((willDelete)=>{
               if(willDelete){
                   selectedRow.parentNode.removeChild(selectedRow);
               }
           })
           break;
       }


      default: {
        alert("ریکار مشخص برای حذف وجود ندارد");
      }
    }
    makeTableColumnsResizable("addHawalaTable");
}


function deleteEditAddedGetAndPay(deleteTargetTr){
    let deleteBtnValue = parseInt(deleteTargetTr);
    let selectedRow = document.querySelector('#addedDaryaftListBodyEdit tr.selected');

    switch(deleteBtnValue) {
        case 1: {
             swal({text:"آیا میخواهید وجه نقد را حذف نمایید!",
              buttons:true,
            }).then((willDelete)=>{
                if(willDelete){
                    selectedRow.parentNode.removeChild(selectedRow);
                }
            })
            break;
        }

        case 2: {
            swal({text:"آیا میخواهید چک را حذف نمایید!",
             buttons:true,
           }).then((willDelete)=>{
               if(willDelete){
                   selectedRow.parentNode.removeChild(selectedRow);
               }
           })
           break;
       }

        case 3: {
            swal({text:"آیا میخواهید حواله را حذف نمایید!",
             buttons:true,
           }).then((willDelete)=>{
               if(willDelete){
                   selectedRow.parentNode.removeChild(selectedRow);
               }
           })
           break;
       }

        case 4: {
            swal({text:"آیا میخواهید تخفیف را حذف نمایید!",
             buttons:true,
           }).then((willDelete)=>{
               if(willDelete){
                   selectedRow.parentNode.removeChild(selectedRow);
               }
           })
           break;
       }

        case 6: {
            swal({text:"آیا میخواهید واریزی را حذف نمایید!",
             buttons:true,
           }).then((willDelete)=>{
               if(willDelete){
                   selectedRow.parentNode.removeChild(selectedRow);
               }
           })
           break;
       }

      default: {
        swal({
            text: "آیا مطمئن هستید که می‌خواهید حذف کنید؟",
            buttons: true,
        }).then((willDelete) => {
            if (willDelete) {
                selectedRow.parentNode.removeChild(selectedRow);
            }
        });
        break;
      }
    }
    makeTableColumnsResizable("addHawalaTable");
}



function showCustomerGardish(element,elementId){
        if(element.checked){
            switch (elementId) {
                case "showFromLastZeroRemainReportRadio":
                    {
                        let rows=document.querySelectorAll("#customerGardishListBody tr");
                        //rows.style.display="none"
                        let showTrState="show";
                        for (let index = (rows.length)-1; index >=0; index--) {
                            let lastTdValue=1;
                            if(!isNaN(parseInt(rows[index].querySelector('td:last-child').textContent.trim()))){
                                lastTdValue = parseInt(rows[index].querySelector('td:last-child').textContent.trim());
                            }
                            if(showTrState=="hide"){
                                rows[index].style.setProperty('display', 'none', 'important');
                            }

                            if(lastTdValue===0){
                                showTrState="hide"
                            }
                        }
                    }
                    break;
                case "showFromLastControlledReportRadio":
                    {
                        let rows=document.querySelectorAll("#customerGardishListBody tr");
                        //rows.style.display="none"
                        let showTrState="show";
                        for (let index = (rows.length)-1; index >=0; index--) {
                            let lastTdValue=2;
                            if(!isNaN(parseInt(rows[index].querySelector('td:nth-child(7)').textContent.trim()))){
                                lastTdValue = parseInt(rows[index].querySelector('td:nth-child(7)').textContent.trim());
                            }

                            if(showTrState=="hide"){
                                rows[index].style.setProperty('display', 'none', 'important');
                               
                            }else{
                                rows[index].style.setProperty('display', '', 'important');
                            }

                            if(lastTdValue===1){
                                showTrState="hide"
                            }
                        }
                    }
                    break;
                default:
                    {
                        let rows=document.querySelectorAll("#customerGardishListBody tr");
                        //rows.style.display="none"
                        for (let index = rows.length-1; index >=0; index--) {
                           rows[index].style.setProperty('display', '', 'important');
                        }
                    }
                    break;
            }
        }else{
            switch (elementId) {
                case value:
                    {

                    }
                    break;
                case value:
                    {
                        
                    }
                    break;
                
                default:
                    break;
            }
        }
}

$("#filterPaysForm").on("submit",function(e){
    e.preventDefault();
    $.ajax({
        method: $(this).attr('method'),
        url: $(this).attr('action'),
        data:$(this).serialize(),
        processData: false,
        contentType: false,
        success: function (respond) {
            $("#paysListBody").empty();
            respond.forEach((element,index) => {
                $("#paysListBody").append(`
                    <tr class="factorTablRow" onclick="getGetAndPayBYS(this,'paysDetailsBody',${element.SerialNoHDS})"  class="factorTablRow">
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

let customerCodePayInput = document.getElementById('customerCodePayInput');
if(customerCodePayInput){
    customerCodePayInput.addEventListener('keyup', function(e) {
        
        let customerCode = customerCodePayInput.value;
        if(customerCode.length>0){
            $.ajax({
                method: "GET",
                url: baseUrl+"/getCustomerInfoByCode",
                data: {pcode:customerCode},
                success: function (respond) {
                    if(respond.length>0){
                        let customer = respond[0];
                        $("#customerNamePayInput").val(customer.Name);
                        $("#customerIdPayInput").val(customer.PSN);
                    }
                },
                error:function(error){
                    console.log(error)
                }
            });
        }else{
            $("#customerNamePayInput").val("");
            $("#customerIdPayInput").val("");
            $("#customerCodePayInput").val("");
        }
    })
}
const babatPayInput=document.getElementById("babatPayInput");
if(babatPayInput){
    babatPayInput.addEventListener('change', function(e) {
        let babat = babatPayInput.value;
        if(babat.length>0){
            $.ajax({
                method: "GET",
                url: baseUrl+"/getInforTypeInfo",
                data: {SnInfor:babat},
                success: function (respond) {
                    if(respond.length>0){
                        let infor = respond[0];
                        $("#babatCodePay").val(infor.InforCode);
                        $("#babatIdPayInput").val(infor.SnInfor);
                    }
                },
                error:function(error){
                }
            });
        }else{
            $("#babatIdPayInput").val("");
            $("#babatCodePay").val(infor.InforCode);
        }
    })
}

const personalPaysRadio=document.getElementById("personalPaysRadio");
if(personalPaysRadio){
    personalPaysRadio.addEventListener('change', function(e) {
        let personalPays = personalPaysRadio.checked;

        if(personalPays==false){
            $("#customerCodePayInput").prop("disabled", true);
            $("#customerNamePayInput").prop("disabled", true);
            $("#customerIdPayInput").prop("disabled", true);
            $("#customerCodePayInput").val("");
            $("#customerNamePayInput").val("");
            $("#customerIdPayInput").val("");
        }else{
            $("#customerCodePayInput").prop("disabled", false);
            $("#customerNamePayInput").prop("disabled", false);
            $("#customerIdPayInput").prop("disabled", false);
        }
    })
}

const hazinaPaysRadio=document.getElementById("hazinahPaysRadio");
if(hazinaPaysRadio){
    hazinaPaysRadio.addEventListener('change', function(e) {
        let hazinaPays = hazinaPaysRadio.checked;
        if(hazinaPays==true){
            $("#customerCodePayInput").prop("disabled", true);
            $("#customerNamePayInput").prop("disabled", true);
            $("#customerIdPayInput").prop("disabled", true);
            $("#customerCodePayInput").val("");
            $("#customerNamePayInput").val("");
            $("#customerIdPayInput").val("");
        }else{
            $("#customerCodePayInput").prop("disabled", false);
            $("#customerNamePayInput").prop("disabled", false);
            $("#customerIdPayInput").prop("disabled", false);
            $("#customerCodePayInput").val("");
            $("#customerNamePayInput").val("");
            $("#customerIdPayInput").val("");
        }
    })
}

const sadirDatePaysInput=document.getElementById("sadirDatePaysInput");
if(sadirDatePaysInput){
    $("#sadirDatePaysInput").persianDatepicker({
        cellWidth: 32,
        cellHeight: 22,
        fontSize: 14,
        formatDate: "YYYY/0M/0D",
        endDate: "1440/5/5",});
}


const customerNamePayInput=document.getElementById("customerNamePayInput");
if(customerNamePayInput){
    customerNamePayInput.addEventListener('keyup', function(e) {
        let customerName = customerNamePayInput.value;
        if(customerName.length>0){
            openSearchCustomerForPayModal(customerName);
        }
    })
}

function openSearchCustomerForPayModal(customerName){
    const customerNameSearchPayInput=document.getElementById("customerNameSearchPay");
    customerNameSearchPayInput.value=customerName;
    const modal = new bootstrap.Modal(document.getElementById('searchCustomerForPayModal'));
    modal.show();
    customerNameSearchPayInput.focus();
}

function closeSearchCustomerPaysModal(){
    if($("#searchCustomerForPayModal")){
        $("#searchCustomerForPayModal").hide();
    }
}

const customerNameSearchPayInput=document.getElementById("customerNameSearchPay");
if(customerNameSearchPayInput){
    customerNameSearchPayInput.addEventListener('keyup', function(e) {
        let customerName = customerNameSearchPayInput.value;
        const params = new URLSearchParams();
        params.append('namePhone', customerName);
        const byPhoneSearchPayInput=document.getElementById("byPhoneSearchPay");
        if(byPhoneSearchPayInput.checked==true){
            params.append('searchByPhone', 'on');
        }else{
            params.append('searchByPhone', '');
        }
        
        if(customerName.length>0){
            fetch(baseUrl+`/getCustomerForOrder?${params.toString()}`, {
                method: 'GET',
              }).then(response => response.json()).then(data => {
                if(data.length>0){
                    console.log(data)
                    let customers = data;
                    let customersHtml = "";
                    customers.forEach((customer,index) => {
                        customersHtml += `
                        <tr onclick="selectCustomerForPay('${customer.PSN}',this)">
                            <td>  ${customer.PCode}  </td>
                            <td>  ${customer.Name}  </td>
                            <td>   </td>
                            <td>   </td>
                            <td>   </td>
                            <td>   </td>
                        </tr>
                        `;
                    });
                    $("#customerForPaysListBody").html(customersHtml);
                }else{
                     $("#customerForPaysListBody").html("");
                }
              });
        }else{
            $("#customersForPay").html("");
        }
    })
}

function selectCustomerForPay(customerId,element){
    $("#selectCustomerForPaysBtn").val(customerId);
    $("tr").removeClass("selected");
    $(element).addClass("selected");
}

function chooseCustomerForPay(customerId) {
    params = new URLSearchParams();
    params.append('PSN', customerId);
    fetch(baseUrl+`/getCustomerByID?${params.toString()}`, {
        method: 'GET',
      }).then(response => response.json()).then(data => {
        if(data.length>0){
            let customer = data[0];
            $("#customerCodePayInput").val(customer.PCode);
            $("#customerNamePayInput").val(customer.Name);
            $("#customerIdPayInput").val(customer.PSN);
            $("#searchCustomerForPayModal").hide();
        }
    });
}

function openAddEditPayChequeInfoEditModal(){
    const modal = new bootstrap.Modal(document.getElementById('addEditPayChequeInfoEditModal'));
    modal.show();
    const selectBox=document.getElementById('hisabNoChequeInputAddEditPayEdit') ;
    selectBox.innerHTML = '';
    selectBox.add(new Option(" ", ''));
    fetch(baseUrl+'/allBanks', {
        method: 'GET'
    })
   .then(response=>response.json())
   .then(data=>{
    data.bankKarts.forEach(bank=>{
        const option = document.createElement("option");
        option.text = bank.bsn;
        option.value = String(bank.SerialNoAcc);
        selectBox.add(option);
    })
   })

   const customerNamePayHDSInput=document.getElementById('editPayName') ;
   const inVajhChequeNameInput=document.getElementById('inVajhChequeInputAddEditPayEdit') ;
   inVajhChequeNameInput.value=customerNamePayHDSInput.value;

}

function openAddPayVajhNaghdEditModal(){
    const modal = new bootstrap.Modal(document.getElementById('addPayVajhNaghdEditModal'));
    modal.show();
}
function closeAddPayVajhNaghdEditModal(){
    $("#addPayVajhNaghdEditModal").hide();
}
function openAddPayChequeInfoEditModal(){
    const modal = new bootstrap.Modal(document.getElementById('addPayChequeInfoEditModal'));
    modal.show();
}
function closAddPayChequeInfoEditModal(){
    
    $("#addPayChequeInfoEditModal").hide();
}
function openaddSpentChequeEditModal(){
    const modal = new bootstrap.Modal(document.getElementById('addSpentChequeEditModal'));
    modal.show();
}
function closeAddSpentChequeEditModal(){
    $("#addSpentChequeEditModal").hide();
}
function openAddPayTakhfifEditModal(){
    const modal = new bootstrap.Modal(document.getElementById('AddPayTakhfifEditModal'));
    modal.show();
}
function closeAddPayTakhfifEditModal(){
    $("#AddPayTakhfifEditModal").hide();
}

function openAddPayHawalaFromBoxEditModal(){
    const modal = new bootstrap.Modal(document.getElementById('AddPayHawalaFromBoxEditModal'));
    modal.show();
}
function closeAddPayHawalaFromBoxEditModal(){
    $("#AddPayHawalaFromBoxEditModal").hide();
}
function openAddPayHawalaFromBankEditModal(){
    const modal = new bootstrap.Modal(document.getElementById('AddPayHawalaFromBankEditModal'));
    modal.show();
}
function closeAddPayHawalaFromBankEditModal(){
    $("#AddPayHawalaFromBankEditModal").hide();
}
// add edit edit 
function openAddEditPayVajhNaghdEditModal(){
    const modal = new bootstrap.Modal(document.getElementById('addEditPayVajhNaghdEditModal'));
    modal.show();
}
function closeAddEditPayVajhNaghdEditModal(){
    $("#addEditPayVajhNaghdEditModal").hide();
}

function closAddEditPayChequeInfoEditModal(){
    
    $("#addEditPayChequeInfoEditModal").hide();
}
function openAddEditSpentChequeEditModal(){
    const modal = new bootstrap.Modal(document.getElementById('addEditSpentChequeEditModal'));
    modal.show();
}
function closeAddEditSpentChequeEditModal(){
    $("#addEditSpentChequeEditModal").hide();
}
function openAddEditPayTakhfifEditModal(){
    const modal = new bootstrap.Modal(document.getElementById('addEditPayTakhfifEditModal'));
    modal.show();
}
function closeAddEditPayTakhfifEditModal(){
    $("#addEditPayTakhfifEditModal").hide();
}

function openAddEditPayHawalaFromBoxEditModal(){
    const modal = new bootstrap.Modal(document.getElementById('addEditPayHawalaFromBoxEditModal'));
    modal.show();
}
function closeAddEditPayHawalaFromBoxEditModal(){
    $("#addEditPayHawalaFromBoxEditModal").hide();
}
function openAddEditPayHawalaFromBankEditModal(){
    const modal = new bootstrap.Modal(document.getElementById('addEditPayHawalaFromBankEditModal'));
    modal.show();
}
function closeAddEditPayHawalaFromBankEditModal(){
    $("#addEditPayHawalaFromBankEditModal").hide();
}
// edit edit edit modal
function openEditEditPayVajhNaghdEditModal(){
    const modal = new bootstrap.Modal(document.getElementById('editEditPayVajhNaghdEditModal'));
    modal.show();
}
function closeEditEditPayVajhNaghdEditModal(){
    $("#editEditPayVajhNaghdEditModal").hide();
}
function openEditEditPayChequeInfoEditModal(){
    const modal = new bootstrap.Modal(document.getElementById('editEditPayChequeInfoEditModal'));
    modal.show();
}
function closEditEditPayChequeInfoEditModal(){
    
    $("#editEditPayChequeInfoEditModal").hide();
}
function openEditEditSpentChequeEditModal(){
    const modal = new bootstrap.Modal(document.getElementById('editEditSpentChequeEditModal'));
    modal.show();
}
function closeEditEditSpentChequeEditModal(){
    $("#editEditSpentChequeEditModal").hide();
}
function openEditEditPayTakhfifEditModal(){
    const modal = new bootstrap.Modal(document.getElementById('editEditPayTakhfifEditModal'));
    modal.show();
}
function closeEditEditPayTakhfifEditModal(){
    $("#editEditPayTakhfifEditModal").hide();
}

function openEditEditPayHawalaFromBoxEditModal(){
    const modal = new bootstrap.Modal(document.getElementById('editEditPayHawalaFromBoxEditModal'));
    modal.show();
}
function closeEditEditPayHawalaFromBoxEditModal(){
    $("#editEditPayHawalaFromBoxEditModal").hide();
}
function openEditEditPayHawalaFromBankEditModal(){
    const modal = new bootstrap.Modal(document.getElementById('editEditPayHawalaFromBankEditModal'));
    modal.show();
}
function closeEditEditPayHawalaFromBankEditModal(){
    $("#editEditPayHawalaFromBankEditModal").hide();
}

function getAndPayHistory(historyFlag,tableBodyId,bysTableBodyId,getOrPay){
    params=new URLSearchParams();
    params.append("historyFlag",historyFlag);
    params.append("getOrPay",getOrPay);
    fetch(baseUrl+`/getAndPayHistory?${params.toString()}`).then(response=>response.json()).then((data)=>{
        
        $("#"+tableBodyId).empty();
        data.forEach((element,index) => {
            $("#"+tableBodyId).append(`
                <tr class="factorTablRow" onclick="getGetAndPayBYS(this,'`+bysTableBodyId+`',${element.SerialNoHDS})"  class="factorTablRow">
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
    })
}
function openEditPayModal(snGetAndPayHDS){
    params=new URLSearchParams();
    params.append("snGetAndPay",snGetAndPayHDS);
    fetch(baseUrl+`/getGetAndPayInfo?${params.toString()}`).then(response=>response.json()).then((data)=>{
        let payOrGet=data.response[0];
        $("#editPayModal").find("#editPayDocNoHDS").val(payOrGet.FactNo);
        $("#editPayModal").find("#editPayDocDate").val(payOrGet.DocDate);
        $("#editPayModal").find("#editPayName").val(payOrGet.Name);
        $("#editPayModal").find("#editPayCode").val(payOrGet.PCode);
        const editPayPSN=document.getElementById("editPayPSN");
        editPayPSN.value=payOrGet.PeopelHDS;
        $("#editPayModal").find("#editPayNetPriceHDS").val(payOrGet.NetPriceHDS);
        $("#editPayModal").find("#editPayDocDescHDS").val(payOrGet.DocDescHDS);
        $("#editPayModal").find("#editPaySerialNoHDS").val(payOrGet.SerialNoHDS);
        $("#editPayModal").find("#editPayCashName").val(payOrGet.cashName);
        $("#editPayModal").find("#editPayUserName").val(payOrGet.userName);
        let personalEditPaysRadio = document.getElementById("personalEditPaysRadio");
        let hazinahEditPaysRadio = document.getElementById("hazinahEditPaysRadio");
        if(payOrGet.PeopelHDS>0){
            personalEditPaysRadio.checked = true;
        }else{
            hazinahEditPaysRadio.checked = true;
        }
        if(payOrGet.InForHDS>0){
            const editBabatPayCode = document.getElementById('editBabatCodePay');
            editBabatPayCode.value = payOrGet.InForHDS;
            const select = document.getElementById('editBabatIdPaySelect');
            for (let i = 0; i < select.options.length; i++) {
                if (select.options[i].value === payOrGet.InForHDS) {
                    select.options[i].selected = true;
                    break;
                }
            }
        }
        if(personalEditPaysRadio.checked===true){
            $("#editPayModal").find("#editPayName").attr("disabled",false);
            $("#editPayModal").find("#editPayCode").attr("disabled",false);
        }else{
            $("#editPayModal").find("#editPayName").attr("disabled",true);
            $("#editPayModal").find("#editPayCode").attr("disabled",true);
        }
        const bys=data.response[0].BYS;
        const bysTableBody=document.getElementById("payEditTableBodyBys");
        bysTableBody.innerHTML="";
        let bysTableTr="";
        let rowNumber=0;
        console.log(bys)
        for (const element of bys) {
            
            bysTableTr+=`<tr onclick="setPayBYSStuff(this,${element.SerialNoBYS})"><td>${rowNumber}</td><td>${element.DocDescBYS}</td><td>${element.Price}</td><td>${element.RadifInDaftarCheque}</td><td>${element.NoSayyadi}</td>
            <td class="d-none" ><input type="checkbox" checked class="form-check-input" value="${(rowNumber)}" name="BYSs[]"/></td>
            <td class="d-none" ><input type="text" class="form-check-input" value="${element.DocTypeBYS}" name="BysType${rowNumber}"/></td>
            <td class="d-none" ><input type="text" value="${element.NoSayyadi}" name="sayyadiNoCheque${rowNumber}"/></td>
            <td class="d-none" ><input type="text" value="${element.ChequeDate}" name="checkSarRasidDate${rowNumber}"/></td>
            <td class="d-none" ><input type="text" value="${element.ChequeNo}" name="chequeNoCheqe${rowNumber}"/></td>
            <td class="d-none" ><input type="text" value="${element.AccBankno}" name="AccBankNo${rowNumber}"/></td>
            <td class="d-none" ><input type="text" value="${element.SnBank}" name="SnBank${rowNumber}"/></td>
            <td class="d-none" ><input type="text" value="${element.SnChequeBook}" name="SnChequeBook${rowNumber}"/></td>
            <td class="d-none" ><input type="text" value="${element.DocDescBYS}" name="DocDescBys${rowNumber}"/></td>
            <td class="d-none" ><input type="text" value="${element.SnAccBank}" name="SnAccBank${rowNumber}"/></td>
            <td class="d-none" ><input type="text" value="${element.NoPayaneh_KartKhanBys}" name="NoPayanehKartKhanBYS${rowNumber}"/></td>
            <td class="d-none" ><input type="text" value="${element.SnPeopelPay}" name="SnPeopelPay${rowNumber}"/></td>
            <td class="d-none" ><input type="text" value="0"/></td>
            <td class="d-none" ><input type="text" value="0"/></td>
            <td class="d-none" ><input type="text" value="${element.Price}" name="Price${rowNumber}"/></td>
            <td class="d-none" ><input type="text" value="${element.SnMainPeopel}" name="SnMainPeopel${rowNumber}"/></td>
            <td class="d-none" ><input type="text" value="${element.Owner}" name="ownerName${rowNumber}"/></td>
            <td class="d-none" ><input type="text" value="${element.ChequeNo}" name="hawalaNo${rowNumber}"/></td>
            <td class="d-none" ><input type="text" value="${element.Branch}" name="Branch${rowNumber}"/></td>
            <td class="d-none" ><input type="text" value="${element.KarMozdPriceBys}" name="Karmozd${rowNumber}"/></td>
            <td class="d-none" ><input type="text" value="${element.SerialNoBYS}" name="SerialNoBYS${rowNumber}"/></td>
            </tr>`;
            rowNumber++;
        }
        bysTableBody.innerHTML=bysTableTr;
        const modal = new bootstrap.Modal(document.getElementById('editPayModal'));
        modal.show();})
}

function setPayBYSStuff(seletedTr,serialNoBYS){
    const tr = document.querySelectorAll('tr');
    for (let index = 0; index < tr.length; index++) {
        const element = tr[index];
        element.classList.remove('selected');
    }

    seletedTr.classList.add('selected');
    const openEditEditPayEditBtn = document.getElementById("openEditEditPayEditBtn");
    openEditEditPayEditBtn.value=serialNoBYS;
}

function openEditEditPayEditModal(serialNoBYS){
    if(serialNoBYS!=0){
        params=new URLSearchParams();
        params.append("SerialNoBYS",serialNoBYS);
        fetch(baseUrl+`/getBYSInfo?${params.toString()}`).then(response=>response.json()).then((data)=>{
            checkEditEditPayEditModal(data.response[0].DocTypeBYS);
        })
    }else{
        checkEditEditPayEditModal(1)
    }
}

function checkEditEditPayEditModal(docTypeBYS){

    const selectedElements = document.querySelectorAll('.selected');
    const selectedRow = selectedElements[0];
    const rowData = selectedRow.querySelectorAll('td');
    if(docTypeBYS==3 && rowData[14].children.item(0)?.getAttribute('value')==0){
        docTypeBYS="5";
    }
    switch(docTypeBYS){
        case "1":
            {//وجه نقد
                let modal = new bootstrap.Modal(document.getElementById('editEditPayVajhNaghdEditModal'));
                const rialNaghdPayEditEditInputEdit=document.getElementById('rialNaghdPayEditEditInputEdit');
                const descNaghdPayEditEditInputEdit=document.getElementById('descNaghdPayEditEditInputEdit');
                rowData.forEach((td,index)=>{
                    if(td.children.item(0)){
                        switch(index){
                            case 19:
                            {
                                rialNaghdPayEditEditInputEdit.value=td.children.item(0)?.getAttribute("value");
                            }
                            break;
                            case 13:{
                                descNaghdPayEditEditInputEdit.value=td.children.item(0)?.getAttribute("value");
                            }
                            break;
                        }

                    }
                })
                modal.show();
            }
            break;
        case "2":
            {//چک
                let modal = new bootstrap.Modal(document.getElementById('editEditPayChequeInfoEditModal'));
                const chequeNumberInput = document.getElementById("chequeNoCheqeInputEditPayEdit");
                const sarRasidInput = document.getElementById("checkSarRasidDateInputEditPayEdit");
                const moneyChequeInput = document.getElementById("moneyChequeInputEditPayEdit");
                const sayyadiNoChequeInputAddPayAdd=document.getElementById("sayyadiNoChequeInputEditPayEdit");
                const docDescInput=document.getElementById("inVajhChequeInputEditPayEdit");
                var accNo=0
                rowData.forEach((td,index)=>{
                    if(td.children.item(0)){
                        switch (index) {
                            case 10://
                            {
                                const hisabNoChequeInputAddPayAdd=document.getElementById("hisabNoChequeInputEditPayEdit");
                                accNo=Number(td.children.item(0)?.getAttribute('value'));
                                fetch(baseUrl+`/bankAcc/index`,{
                                    method:'GET',
                                }).then(res=>{
                                    return res.json();
                                }).then(data=>{
                                    data.forEach((element) => {
                                        const option = document.createElement("option");
                                        option.text = element.AccNo;
                                        option.value = String(element.SerialNoAcc);
                                        if(element.SerialNoAcc==accNo){
                                            option.selected=true;
                                        }
                                        hisabNoChequeInputAddPayAdd.add(option);
                                    });
                                })
                            }
                            break;
                            case 12:
                                {
                                    const hisabNo=document.getElementById("hisabNoChequeInputEditPayEdit");
                                    const radifInChequeBookSelect=document.getElementById("radifInChequeBookSelectEditPayEdit");
                                    fetch(baseUrl+`/cheque/getChequesByAcc/${accNo}`).then(res=>{
                                        return res.json();
                                    }).then((data)=>{
                                        console.log(data);
                                        radifInChequeBookSelect.innerHTML='';
                                        data.forEach((element) => {
                                            const option = document.createElement("option");
                                            option.text = element.ChequeBookName;
                                            option.value = String(element.SnChequeBook);
                                            if(element.SnChequeBook==td.children.item(0)?.getAttribute('value')){
                                                option.selected=true;
                                            }
                                            radifInChequeBookSelect.add(option);
                                        });
                                        const event = new Event('change');
                                        radifInChequeBookSelect.dispatchEvent(event);
                                    })
                                }
                            break;
                            case 13:
                                {
                                    docDescInput.value=String(td.children.item(0)?.getAttribute('value'));
                                }
                                break;
                            case 7:
                                {
                                    sayyadiNoChequeInputAddPayAdd.value=String(td.children.item(0)?.getAttribute('value'))
                                }
                                break;
                            case 8:
                                {
                                    sarRasidInput.value=String(td.children.item(0)?.getAttribute('value'))
                                }
                                break;
                            case 9:{
                                    chequeNumberInput.value=String(td.children.item(0)?.getAttribute('value'))
                                }
                                break;
                            case 19:{
                                    moneyChequeInput.value=String(td.children.item(0)?.getAttribute('value'))
                                }
                                break;
                            
                        }}
                    });
                modal.show();
            }
            break;
        case "6":
            {//چک خرج شده
                let modal = new bootstrap.Modal(document.getElementById('editEditSpentChequeEditModal'));
                modal.show();
            }
            break;
        case "4":
            {// تخفیف
                let modal = new bootstrap.Modal(document.getElementById('editEditPayTakhfifEditModal'));
                const takhfifInput=document.getElementById("takhfifMoneyInputEditEditPayEdit");
                const discriptionInput=document.getElementById("discriptionTakhfifInputEditEditPayEdit");
                rowData.forEach((td,index)=>{
                    if(td.children.item(0)){
                        switch (index){
                        case 19:
                            takhfifInput.value=String(td.children.item(0)?.getAttribute('value'));
                            break;
                        case 13:
                            discriptionInput.value=String(td.children.item(0)?.getAttribute('value'));
                            break;
                        }
                    }
                })
                modal.show();
            }
            break;
        case "5":
            {// hawal from Box
                alert('it is hawala from box;')
                let modal = new bootstrap.Modal(document.getElementById('editEditPayHawalaFromBoxEditModal'));
                const hawalaNoInput=document.getElementById("editHawalaFromBoxEditInputNumber");
                const hawalaDateInput=document.getElementById("editHawalaFromBoxEditDateInput");
                const moneyInput=document.getElementById("editHawalaFromBoxEditMoneyInput");
                const karmozdInput=document.getElementById("editHawalaFromBoxEditKarmozdInput");
                const hisabNoInput=document.getElementById("editHawalaFromBoxEditNumberHisabInput");
                const hisabOwnerInput=document.getElementById("editHawalaFromBoxEditMalikNameInput");
                const bankInput=document.getElementById("editHawalaFromBoxEditBankNameInput");
                const descInput=document.getElementById("editHawalaFromBoxEditDescInput");
                const bankShobeInput=document.getElementById("editHawalaFromBoxEditBranchSnInput");
                rowData.forEach((td,index)=>{
                    if(td.children.item(0)){
                        switch (index) {
                            case 9://
                            hawalaNoInput.value=String(td.children.item(0)?.getAttribute('value'));
                                break;
                            case 8://
                                hawalaDateInput.value=String(td.children.item(0)?.getAttribute('value'));
                                break;
                            case 11:
                                {
                                    fetch(baseUrl+`/getBankList`,{
                                        method:'GET',
                                    }).then(res=>{
                                        return res.json();
                                    }).then(data=>{
                                        bankInput.innerHTML='';
                                        bankInput.innerHTML=`<option value="0">انتخاب کنید</option>`;
                                        data.forEach(bank=>{
                                            if(bank.SerialNoBSN==String(td.children.item(0)?.getAttribute('value'))){
                                                bankInput.innerHTML+=`<option selected value="${bank.SerialNoBSN}">${bank.NameBsn}</option>`;
                                            }else{
                                                bankInput.innerHTML+=`<option value="${bank.SerialNoBSN}">${bank.NameBsn}</option>`;
                                            }
                                        })
                                    })
                                }
                                break;
                            case 8:
                                   // addToBankEditInput.value=String(td.children.item(0)?.getAttribute('value'));
                                break;
                            case 21:
                                hisabOwnerInput.value=String(td.children.item(0)?.getAttribute('value'));
                                break;
                            case 8:
                                //addToBankShobeEditInput.value=String(td.children.item(0)?.getAttribute('value'));
                                break;
                            case 13:
                                descInput.value=String(td.children.item(0)?.getAttribute('value'));
                                break;
                            case 10:
                                hisabNoInput.value=String(td.children.item(0)?.getAttribute('value'));
                                break;
                            case 23:
                                {
                                    bankShobeInput.value=String(td.children.item(0)?.getAttribute('value'));
                                }
                                break;
                            case 19:
                                {
                                    moneyInput.value=String(td.children.item(0)?.getAttribute('value'));
                                }
                                break;
                            case 24:
                                {
                                    karmozdInput.value=String(td.children.item(0)?.getAttribute('value'));
                                }
                                break;
                        }
                    }
                })
                modal.show();
            }
            break;
        case "3":
            {// hawala from Bank
                let modal = new bootstrap.Modal(document.getElementById('editEditPayHawalaFromBankEditModal'));
                const addFromHisabNoEditInput=document.getElementById("editFromHisabNoEditInput");
                const addFromHisabNoEditSelect=document.getElementById("editFromHisabNoEditSelect");
                const addHawalaNoEditInput=document.getElementById("editHawalaNoEditInput");
                const addHawalaDateEditInput=document.getElementById("editHawalaDateEditInput");
                const addToHisabNoEditInput=document.getElementById("editToHisabNoEditInput");
                const addToBankEditInput=document.getElementById("editToBankEditInput");
                const addToHisabOwnerEditInput=document.getElementById("editToHisabOwnerEditInput");
                const addToBankShobeEditInput=document.getElementById("editToBankShobeEditInput");
                const addDescEditInput=document.getElementById("editDescEditInput");
                const addHawalaFromBankMoneyInput=document.getElementById("editHawalaFromBankMoneyInput");
                const addHawalaFromBankKarmozdInput=document.getElementById("editHawalaFromBankKarmozdInput");
                rowData.forEach((td,index)=>{
                    if(td.children.item(0)){
                        switch (index) {
                            case 14://
                            {
                                fetch(baseUrl+`/allBanks`,{
                                    method:'GET',
                                }).then(res=>{
                                    return res.json();
                                }).then(data=>{
                                    addFromHisabNoEditSelect.innerHTML='';
                                    addFromHisabNoEditSelect.innerHTML=`<option value="0">انتخاب کنید</option>`;
                                    data.bankKarts.forEach(hisab=>{
                                        if(hisab.SerialNoAcc==String(td.children.item(0)?.getAttribute('value'))){
                                        
                                            addFromHisabNoEditSelect.innerHTML+=`<option selected value="${hisab.SerialNoAcc}">${hisab.bsn}</option>`;
                                            addFromHisabNoEditInput.value=String(hisab.AccNo);
    
                                        }else{
    
                                            addFromHisabNoEditSelect.innerHTML+=`<option value="${hisab.SerialNoAcc}">${hisab.bsn}</option>`;
                                        
                                        }
                                    })
                                })
                            }
                                break;
                            case 2:
                                addFromHisabNoEditSelect.value=String(td.children.item(0)?.getAttribute('value'));
                                break;
                            case 9://
                            
                                addHawalaNoEditInput.value=String(td.children.item(0)?.getAttribute('value'));
                                break;
                            case 8://
                                addHawalaDateEditInput.value=String(td.children.item(0)?.getAttribute('value'));
                                break;
                            case 10:
                                addToHisabNoEditInput.value=String(td.children.item(0)?.getAttribute('value'));
                                break;
                            case 11:
                                {
                                    fetch(baseUrl+`/getBankList`,{
                                        method:'GET',
                                    }).then(res=>{
                                        return res.json();
                                    }).then(data=>{
                                        addToBankEditInput.innerHTML='';
                                        addToBankEditInput.innerHTML=`<option value="0">انتخاب کنید</option>`;
                                        data.forEach(bank=>{
                                            if(bank.SerialNoBSN==String(td.children.item(0)?.getAttribute('value'))){
    
                                                addToBankEditInput.innerHTML+=`<option selected value="${bank.SerialNoBSN}">${bank.NameBsn}</option>`;
                                            }else{
    
                                                addToBankEditInput.innerHTML+=`<option value="${bank.SerialNoBSN}">${bank.NameBsn}</option>`;
    
                                            }
                                        })
                                    })
                                }
                                break;
                            case 21:
                                addToHisabOwnerEditInput.value=String(td.children.item(0)?.getAttribute('value'));
                                break;
                            case 8:
                                   // addToBankEditInput.value=String(td.children.item(0)?.getAttribute('value'));
                                
                                break;
                            case 8:
                                //addToBankShobeEditInput.value=String(td.children.item(0)?.getAttribute('value'));
                                break;
                            case 13:
                                addDescEditInput.value=String(td.children.item(0)?.getAttribute('value'));
                                break;
                            case 22:
                                addHawalaNoEditInput.value=String(td.children.item(0)?.getAttribute('value'));
                                break;
                            case 23:
                                {
                                    addToBankShobeEditInput.value=String(td.children.item(0)?.getAttribute('value'));
                                }
                                break;
                            case 19:
                                {
                                    addHawalaFromBankMoneyInput.value=String(td.children.item(0)?.getAttribute('value'));
                                }
                                break;
                            case 24:
                                {
                                    addHawalaFromBankKarmozdInput.value=String(td.children.item(0)?.getAttribute('value'));
                                }
                                break;
                            
                        }
                    }
                })
                modal.show();
            }
            break;
    }
}

let personalEditPaysRadio = document.getElementById("personalEditPaysRadio");
let hazinahEditPaysRadio = document.getElementById("hazinahEditPaysRadio");
if(personalEditPaysRadio){
    personalEditPaysRadio.addEventListener('change', function(){
    if(personalEditPaysRadio.checked===true){
        $("#editPayModal").find("#editPayName").attr("disabled",false);
        $("#editPayModal").find("#editPayCode").attr("disabled",false);
        $("#editPayModal").find("#editPayPSN").val("");
    }else{
        $("#editPayModal").find("#editPayName").attr("disabled",true);
        $("#editPayModal").find("#editPayCode").attr("disabled",true);
    }})
}
if(hazinahEditPaysRadio){
    hazinahEditPaysRadio.addEventListener('change', function(){
    if(hazinahEditPaysRadio.checked===true){
        $("#editPayModal").find("#editPayName").attr("disabled",true);
        $("#editPayModal").find("#editPayCode").attr("disabled",true);
    }else{
        $("#editPayModal").find("#editPayName").attr("disabled",false);
        $("#editPayModal").find("#editPayCode").attr("disabled",false);
        $("#editPayModal").find("#editPayPSN").val("");
    }})
}

const editPayCode=document.getElementById("editPayCode");
if(editPayCode){
    editPayCode.addEventListener('keyup', function(){
        params=new URLSearchParams();
        params.append("pcode",editPayCode.value);
        fetch(baseUrl+`/getCustomerInfoByCode?${params.toString()}`).then(response=>response.json()).then((data)=>{
            if(data.length>0){
                let customer=data[0];
                $("#editPayModal").find("#editPayName").val(customer.Name);
                $("#editPayModal").find("#editPayPSN").val(customer.PSN);
            }else{
                $("#editPayModal").find("#editPayName").val("");
                $("#editPayModal").find("#editPayPSN").val("");
            }
        })
    })
}

const editPayName=document.getElementById("editPayName");
if(editPayName){
    editPayName.addEventListener('keyup', function(){
        
        let customerName = editPayName.value;
        if(customerName.length>0){
            alert("openSearchCustomerForPayModal");
            openSearchCustomerForPayEditModal(customerName);
        }
    })
}

function openSearchCustomerForPayEditModal(customerName){
    alert("openSearchCustomerForPayEditModal");
    modal = new bootstrap.Modal(document.getElementById('searchCustomerForPayEditModal'));
    modal.show();
}
function closeSearchCustomerForPayEditModal(){
    $("#searchCustomerForPayEditModal").hide();
}

function closeEditPayModal(){
    $("#editPayModal").hide();
}
const editBabatIdPaySelect=document.getElementById("editBabatIdPaySelect");
if(editBabatIdPaySelect){
    editBabatIdPaySelect.addEventListener('change', function(){
        let babatId = editBabatIdPaySelect.value;
        if(babatId>0){
            params=new URLSearchParams();
            params.append("SnInfor",babatId);
            fetch(baseUrl+`/getInforTypeInfo?${params.toString()}`).then(response=>response.json()).then((data)=>{
                if(data.length>0){
                    $("#editBabatCodePay").val(data[0].InforCode);
                }
            })
        }
    })
}

function closEditPayChequeInfoEditModal(){
    $("#editEditPayChequeInfoEditModal").modal("hide");
}