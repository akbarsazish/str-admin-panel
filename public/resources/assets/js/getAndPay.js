
    var baseUrl = "http://192.168.10.26:8080";
    var csrf = document.querySelector("meta[name='csrf-token']").getAttribute('content');
    function getGetAndPayBYS(element,tableBodyId,snGetAndPay){
        $("tr").removeClass("selected");
        $(element).addClass("selected");
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
                            <td> ${element.ChequeRecNo} </td>
                        </tr>`
                    );
                });
            }
        })

        $("#deleteGetAndPayBYSBtn").prop("disabled",false);
        $("#deleteGetAndPayBYSBtn").val(snGetAndPay);
        $("#editGetAndPayBYSBtn").prop("disabled",false);
        $("#editGetAndPayBYSBtn").val(snGetAndPay);
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

    function closeTakhfifModalEdit(){
        $("#takhfifModalEdit").modal("hide")
    }

    function openVarizToOthersHisbModal(){
        $("#daryaftAddVarizToOthersHisbModal").modal("show");
    }

    function closeVarizToOthersHisbModal(){
        $("#daryaftAddVarizToOthersHisbModal").modal("hide");
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
  
       
    // var distanceMonth = document.getElementById('distanceMonthChequeDar');
    // var distanceDay = document.getElementById('distanceDarChequeDar');

    // let monthValue;
    // let dayValue;

    // distanceMonth.addEventListener('input', () => {
    //     if (distanceMonth.value.length > 0) {
    //         distanceDay.value = 0;
    //         monthValue = parseInt(distanceMonth.value);
    //     }
    // });

    // distanceDay.addEventListener('input', () => {
    //     if (distanceDay.value.length > 0) {
    //         dayValue = parseInt(distanceDay.value);
    //         distanceMonth.value = 0;
    //     }
    // });

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
            
        if (repeateChequeDar > 1) {
            for (let i = 0; i < repeateChequeDar; i++) {
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
                        <td class="d-none"> <input type="checkbox" checked value="${rowCount+i}" name="byss[]"/> 1 </td>
                        <td class="dayaftAddTd-1"> ${i+1} </td>
                        <td class="dayaftAddTd-2"> 0 </td>
                        <td class="dayaftAddTd-3"> چک بانک ${bankName} به شماره ${chequeNoCheqeDar + i} تاریخ ${updateDateHijri} </td>
                        <td class="dayaftAddTd-4"> ${parseInt(moneyChequeDar).toLocaleString("en-us")} </td>
                        <td class="dayaftAddTd-5"> 0 </td>
                        <td class="dayaftAddTd-6"> ${sayyadiNoChequeDar} </td>
                        <td class="dayaftAddTd-7 d-none"> <input type="text" value="2" name="DocTypeBys${rowCount+1}" class=""/> </td>
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
        makeTableColumnsResizable("addHawalaTable")
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
    


    function addTakhfifDar(){
        let takhfifMoneyDar=$("#takhfifMoneyDar").val();
        let discriptionTakhfifDar=$("#discriptionTakhfifDar").val();
        let rowCount=$("#addedDaryaftListBody tr").length;
        $("#addedDaryaftListBody").append(`
                <tr onclick="addEditDaryaftItem(this);" ondblclick="editDaryaftItem('takhfifModalEdit',this)">
                    <td class="d-none"> <input type="checkbox" checked value="${rowCount+1}" name="byss[]"/> ${rowCount+1} </td>
                    <td> ${rowCount + 1} </td>
                    <td> 0 </td>
                    <td> تخفیف </td>
                    <td> ${takhfifMoneyDar} </td>
                    <td> 0 </td>
                    <td> 0 </td>
                    <td class="d-none"> <input type="text" value="4" name="DocTypeBys${rowCount+1}" class=""/> </td>
                    <td>  </td>
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
    
        document.querySelector("#addedDaryaftListBody > tr:first-child > td:nth-child(4)").textContent = takhfifDesc;
        document.querySelector("#addedDaryaftListBody > tr:first-child > td:nth-child(5)").textContent = takhffiMoney;
    
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
    let rowCount=$("#addedDaryaftListBody tr").length;
    $("#addedDaryaftListBody").append(`
       <tr ondblclick="editDaryaftItem('varizToOthersHisbModalEdit',this)">
            <td> <input type="checkbox" checked value="${rowCount+1}" name="byss[]"/> ${rowCount+1} </td>
            <td> 0 </td>
            <td> بعدااضافه شود </td>
            <td> ${moneyVarizToOtherHisabDar} </td>
            <td> 0 </td>
            <td>  </td>
            <td>  </td>
            <td> <input type="text" value="6" name="DocTypeBys${rowCount+1}" class=""/> </td>
            <td> <input type="text" value="${moneyVarizToOtherHisabDar}" name="Price${rowCount+1}" class=""/> </td>
            <td> <input type="text" value=" " name="ChequeDate${rowCount+1}" class=""/> </td>
            <td> <input type="text" value="0" name="ChequeNo${rowCount+1}" class=""/> </td>
            <td> <input type="text" value="${cartNoVarizToOtherDar}" name="AccBankNo${rowCount+1}" class=""/> </td>
            <td> <input type="text" value=" " name="Owener${rowCount+1}" class=""/> </td>
            <td> <input type="text" value="0" name="SnBank${rowCount+1}" class=""/> </td>
            <td> <input type="text" value="0" name="SnChequeBook${rowCount+1}" class=""/> </td>
            <td> <input type="text" value="${discriptionOtherHisabDar}" name="DocDescBys${rowCount+1}" class=""/> </td>
            <td> <input type="text" value="0" name="SnAccBank${rowCount+1}" class=""/> </td>
            <td> <input type="text" value="0" name="CashNo${rowCount+1}" class=""/> </td>
            <td> <input type="text" value="0" name="NoPayanehKartKhanBYS${rowCount+1}" class=""/> </td>
            <td> <input type="text" value="${varizBehisabDigariCustomerPSNDar}" name="SnPeopelPay${rowCount+1}" class=""/> </td>
        </tr>`);
    $("#daryaftAddVarizToOthersHisbModal").modal("hide")
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

$("#deleteGetAndPayBYSBtn").on("click",(e)=>{
    deleteGetAndPays($("#deleteGetAndPayBYSBtn").val());
})

function deleteGetAndPays(snHDS){
    swal({
        title:" آیا می خواهید حذف کنید؟",
        buttons:true
    }).then((willDelete)=>{
        if(willDelete){
            $.get(baseUrl+"/deleteGetAndPays",{snHDS:snHDS},(respond,status)=>{
                window.location.reload();
            })
        }
    })
}

function openDaryaftEditModal(snGetAndPay){
    $.get(baseUrl+"/getGetAndPayInfo",{snGetAndPay:snGetAndPay},(respond,status)=>{
        if(respond.response[0].SnFactForTasviyeh>0){
            swal({
                text:`به علت رسیدگی قادر به اصلاح نمی باشید!`,
                buttons:true
            });

        }else{
            if(getAndPay.SnFactForTasviyeh>0){

                swal({
                    text:` سند مورد نظر مربوط به فاکتور فروش به شماره xxx می باشد.
                     قادر به اصلاح/حذف نمی باشید.
                    جهت اصلاح/حذف فقط کافیست مبالغ از داخل فاکتور مربوطه حذف کنید. `,
                    buttons:true
                });

            }else{
                $("#editDaryaftDate").val(getAndPay.DocDate);
                if(getAndPay.DocTypeHDS==0){
                    $("#DocTypeCustomerHDSStateDarEdit").prop("checked",true);
                }else{
                    $("#DocTypeDarAmadHDSStateDarEdit").prop("checked",true);
                }
                $("#customerCodeDaryaftEdit").val(getAndPay.PCode);
                $("#customerNameDaryaftEdit").val(getAndPay.Name);
                $("#customerIdDaryaftEdit").val(getAndPay.PeopelHDS);
               
                $("#inforTypeDaryaftEdit").val(getAndPay.InforHDS);
                $("#inforTypeCodeDarEdit").val(getAndPay.INforCode);
                $("#daryaftHdsDescEdit").val(getAndPay.DocDescHDS);
                $("#totalNetPriceHDSDarEdit").val(getAndPay.NetPriceHDS);
                $("#netPriceDarEdit").text(parseInt(getAndPay.NetPriceHDS).toLocaleString('en-us'));
                $("#addedDaryaftListBodyEdit").empty();
                getAndPay.BYS.forEach((element,index)=>{
                    $("#addedDaryaftListBodyEdit").append(`
                        <tr onclick="setAddedDaryaftItemStuff(this,${element.SerialNoBYS})" ondblclick="editAddedDaryaftItem(this,${element.DocTypeBYS},${element.SerialNoBYS})">
                            <td>${index+1}</td>
                            <td>${element.ChequeNo}</td>
                            <td>${element.bankDesc}</td>
                            <td>${parseInt(element.Price).toLocaleString('en-us')}</td>
                            <td>${element.RadifInDaftarCheque}</td>
                            <td>${element.NoSayyadi}</td>
                            <td>${element.NameSabtShode}</td>
                            <td class="d-none"> <input type="text" value="${element.DocTypeBYS}" name="DocTypeBys${index+1}"/> </td>
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
                        </tr>`);
                })

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

function setAddedDaryaftItemStuff(element,bysSn){
    $("#addedDaryaftListBodyEdit tr").removeClass("selected");
    $(element).addClass("selected");
    $("#editaddedGetAndPayBtn").prop("disabled",false)
    $("#deleteaddedGetAndPayBtn").prop("disabled",false)
    $("#editaddedGetAndPayBtn").val(bysSn);
    $("#deleteaddedGetAndPayBtn").val(bysSn);
}

function openEditAddedGetAndPay(bysSn){
    alert(bysSn)
}

function deleteEditAddedGetAndPay(bysSn){
    alert(bysSn)
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
let rowCount=$("#addedDaryaftListBody tr").length;
    console.log("row clicked", rowCount)

    const modalTypeValue = $("#addedDaryaftListBody > tr.selected > td:nth-child(8) > input").val();
    
    $("#editDaryaftItemBtn").val(modalTypeValue);
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
    
}

function EditaddNaghdMoneyDar() {
    var currentIndex = $("#addedDaryaftListBody tr").length;
    let descriptionEd = $("#descNaghdDarEd").val();
    let rialsEd = $("#rialNaghdDarEd").val();

    $(`#addedDaryaftListBody tr:nth-child(${currentIndex}) td:nth-child(3)`).text(descriptionEd);
    $(`#addedDaryaftListBody tr:nth-child(${currentIndex}) td:nth-child(4)`).text(rialsEd);
    

    $("#addDaryaftVajhNaghdEditModal").modal("hide");

    // Recalculate netPriceHDS
    let netPriceHDS = 0;
    for (let index = 1; index <= currentIndex; index++) {
        netPriceHDS += parseInt($(`#addedDaryaftListBody tr:nth-child(${index}) td:nth-child(5)`).text().replace(/,/g, ''));
    }
    $("#netPriceDar").text(parseInt(netPriceHDS).toLocaleString("en-us"));
    $("#totalNetPriceHDSDar").val(netPriceHDS);
}


function editAddChequeDar() {
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
        netPriceHDS += parseInt($(`#addedDaryaftListBody tr:nth-child(${index}) td:nth-child(4)`).text().replace(/,/g, ''));
    }
    $("#netPriceDar").text(parseInt(netPriceHDS).toLocaleString("en-us"));
    $("#totalNetPriceHDSDar").val(netPriceHDS);
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

function openPaysModal() {
    const modal = new bootstrap.Modal(document.getElementById('payModal'));
    modal.show();
}

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
                        $("#customerIdPayInput").val(customer.Id);
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
                        <td>    </td>
                        <td>    </td>
                        <td>    </td>
                        <td>    </td>
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

function openAddPayVajhNaghdAddModal(){
    const modal = new bootstrap.Modal(document.getElementById('addPayVajhNaghdAddModal'));
    modal.show();
}
function closeAddPayVajhNaghdAddModal(){
    $("#addPayVajhNaghdAddModal").hide();
}

function openAddPayChequeInfoAddModal(){
    const modal = new bootstrap.Modal(document.getElementById('addPayChequeInfoAddModal'));
    modal.show();
}
function closAddPayChequeInfoAddModal(){
    $("#addPayChequeInfoAddModal").hide();  
}
function openaddSpentChequeAddModal(){
    const modal = new bootstrap.Modal(document.getElementById('addSpentChequeAddModal'));
    modal.show();
}
function closeAddSpentChequeAddModal(){
    $("#addSpentChequeAddModal").hide();
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
function closeAddPayChequeInfoEditModal(){
    $("#addPayChequeInfoEditModal").hide();
}
function openaddSpentChequeEditModal(){
    const modal = new bootstrap.Modal(document.getElementById('addSpentChequeAddModal'));
    modal.show();
}
function closeAddSpentChequeAddModal(){
    $("#addSpentChequeAddModal").hide();
}

function openAddPayTakhfifAddModal(){
    const modal = new bootstrap.Modal(document.getElementById('AddPayTakhfifAddModal'));
    modal.show();
}
function closeAddPayTakhfifAddModal(){
    $("#AddPayTakhfifAddModal").hide();
}


