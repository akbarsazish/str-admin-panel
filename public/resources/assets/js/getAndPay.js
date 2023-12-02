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
                    $("#receiveListBody").append(`<tr class="factorTablRow" onclick="getGetAndPayBYS(this,'receiveListBodyBYS',${element.SerialNoHDS})"  class="factorTablRow">
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
                                                <td> <input type="checkbox" checked value="${rowCount+1}" name="byss[]"/> ${(rowCount+1)} </td>
                                                <td> 0 </td>
                                                <td> ${description} </td>
                                                <td> ${parseInt(rials).toLocaleString("en-us")} </td>
                                                <td>  </td>
                                                <td>  </td>
                                                <td>  </td>
                                                <td> <input type="text" value="1" name="DocTypeBys${rowCount+1}" class=""/> </td>
                                                <td> <input type="text" value="${rials}" name="Price${rowCount+1}" class=""/> </td>
                                                <td> <input type="text" value=" " name="ChequeDate${rowCount+1}" class=""/> </td>
                                                <td> <input type="text" value="0" name="ChequeNo${rowCount+1}" class=""/> </td>
                                                <td> <input type="text" value="0" name="AccBankNo${rowCount+1}" class=""/> </td>
                                                <td> <input type="text" value=" " name="Owener${rowCount+1}" class=""/> </td>
                                                <td> <input type="text" value="0" name="SnBank${rowCount+1}" class=""/> </td>
                                                <td> <input type="text" value="0" name="SnChequeBook${rowCount+1}" class=""/> </td>
                                                <td> <input type="text" value="${description}" name="DocDescBys${rowCount+1}" class=""/> </td>
                                                <td> <input type="text" value="0" name="SnAccBank${rowCount+1}" class=""/> </td>
                                                <td> <input type="text" value="0" name="CashNo${rowCount+1}" class=""/> </td>
                                                <td> <input type="text" value="0" name="NoPayanehKartKhanBYS${rowCount+1}" class=""/> </td>
                                                <td> <input type="text" value="0" name="SnPeopelPay${rowCount+1}" class=""/> </td>
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
        let checkSarRasidDateDar=$("#checkSarRasidDateDar").val();
        let bankNameDar=$("#bankNameDar").val();
        let moneyChequeDar=$("#moneyChequeDar").val();
        let shobeBankChequeDar=$("#shobeBankChequeDar").val();
        let hisabNoChequeDar=$("#hisabNoChequeDar").val();
        let sayyadiNoChequeDar=$("#sayyadiNoChequeDar").val();
        let sabtBeNameChequeDar=$("#sabtBeNameChequeDar").val();
        let malikChequeDar=$("#malikChequeDar").val();
        let repeateChequeDar=$("#repeateChequeDar").val();
        let distanceMonthChequeDar=$("#distanceMonthChequeDar").val();
        let distanceDarChequeDar=$("#distanceDarChequeDar").val();
        let descChequeDar=$("#descChequeDar").val();
        let rowCount=$("#addedDaryaftListBody tr").length;
        $("#addedDaryaftListBody").append(`<tr  ondblclick="editDaryaftItem('chequeInfoModalEdit',this)">
                                            <td> <input type="checkbox" checked value="${rowCount+1}" name="byss[]"/> 1 </td>
                                            <td> ${chequeNoCheqeDar} </td>
                                            <td> بعدا اضافه شود </td>
                                            <td> ${parseInt(moneyChequeDar).toLocaleString("en-us")} </td>
                                            <td> 0 </td>
                                            <td> ${sayyadiNoChequeDar} </td>
                                            <td> ${sabtBeNameChequeDar} </td>
                                            <td> <input type="text" value="2" name="DocTypeBys${rowCount+1}" class=""/> </td>
                                            <td> <input type="text" value="${moneyChequeDar}" name="Price${rowCount+1}" class=""/> </td>
                                            <td> <input type="text" value="${checkSarRasidDateDar}" name="ChequeDate${rowCount+1}" class=""/> </td>
                                            <td> <input type="text" value="${chequeNoCheqeDar}" name="ChequeNo${rowCount+1}" class=""/> </td>
                                            <td> <input type="text" value="${hisabNoChequeDar}" name="AccBankNo${rowCount+1}" class=""/> </td>
                                            <td> <input type="text" value="${malikChequeDar}" name="Owener${rowCount+1}" class=""/> </td>
                                            <td> <input type="text" value="${bankNameDar}" name="SnBank${rowCount+1}" class=""/> </td>
                                            <td> <input type="text" value="0" name="SnChequeBook${rowCount+1}" class=""/> </td>
                                            <td> <input type="text" value="${descChequeDar}" name="DocDescBys${rowCount+1}" class=""/> </td>
                                            <td> <input type="text" value="0" name="SnAccBank${rowCount+1}" class=""/> </td>
                                            <td> <input type="text" value="0" name="NoPayanehKartKhanBYS${rowCount+1}" class=""/> </td>
                                            <td> <input type="text" value="0" name="SnPeopelPay${rowCount+1}" class=""/> </td>
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
                <td> <input type="checkbox" checked value="${rowCount+1}" name="byss[]"/> ${rowCount+1} </td>
                <td> 0 </td>
                <td> بعدا اضافه شود </td>
                <td> ${parseInt(monyAmountHawalaDar).toLocaleString("en-us")} </td>
                <td> 0 </td>
                <td>  </td>
                <td>  </td>
                <td> <input type="text" value="3" name="DocTypeBys${rowCount+1}" class=""/> </td>
                <td> <input type="text" value="${monyAmountHawalaDar}" name="Price${rowCount+1}" class=""/> </td>
                <td> <input type="text" value="${hawalaDateHawalaDar}" name="ChequeDate${rowCount+1}" class=""/> </td>
                <td> <input type="text" value="0" name="ChequeNo${rowCount+1}" class=""/> </td>
                <td> <input type="text" value="${bankAccNoHawalaDar}" name="AccBankNo${rowCount+1}" class=""/> </td>
                <td> <input type="text" value=" " name="Owener${rowCount+1}" class=""/> </td>
                <td> <input type="text" value="0" name="SnBank${rowCount+1}" class=""/> </td>
                <td> <input type="text" value="0" name="SnChequeBook${rowCount+1}" class=""/> </td>
                <td> <input type="text" value="${discriptionHawalaDar}" name="DocDescBys${rowCount+1}" class=""/> </td>
                <td> <input type="text" value="0" name="SnAccBank${rowCount+1}" class=""/> </td>
                <td> <input type="text" value="0" name="CashNo${rowCount+1}" class=""/> </td>
                <td> <input type="text" value="${payanehKartKhanNoHawalaDar}" name="NoPayanehKartKhanBYS${rowCount+1}" class=""/> </td>
                <td> <input type="text" value="0" name="SnPeopelPay${rowCount+1}" class=""/> </td>
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
                                                <td> <input type="checkbox" checked value="${rowCount+1}" name="byss[]"/> ${rowCount+1} </td>
                                                <td> 0 </td>
                                                <td> بعدااضافه شود </td>
                                                <td> ${takhfifMoneyDar} </td>
                                                <td> 0 </td>
                                                <td>  </td>
                                                <td>  </td>
                                                <td> <input type="text" value="4" name="DocTypeBys${rowCount+1}" class=""/> </td>
                                                <td> <input type="text" value="${takhfifMoneyDar}" name="Price${rowCount+1}" class=""/> </td>
                                                <td> <input type="text" value=" " name="ChequeDate${rowCount+1}" class=""/> </td>
                                                <td> <input type="text" value="0" name="ChequeNo${rowCount+1}" class=""/> </td>
                                                <td> <input type="text" value="0" name="AccBankNo${rowCount+1}" class=""/> </td>
                                                <td> <input type="text" value=" " name="Owener${rowCount+1}" class=""/> </td>
                                                <td> <input type="text" value="0" name="SnBank${rowCount+1}" class=""/> </td>
                                                <td> <input type="text" value="0" name="SnChequeBook${rowCount+1}" class=""/> </td>
                                                <td> <input type="text" value="${discriptionTakhfifDar}" name="DocDescBys${rowCount+1}" class=""/> </td>
                                                <td> <input type="text" value="0" name="SnAccBank${rowCount+1}" class=""/> </td>
                                                <td> <input type="text" value="0" name="CashNo${rowCount+1}" class=""/> </td>
                                                <td> <input type="text" value="0" name="NoPayanehKartKhanBYS${rowCount+1}" class=""/> </td>
                                                <td> <input type="text" value="0" name="SnPeopelPay${rowCount+1}" class=""/> </td>
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
        case "hawalaInfoModalEdit":
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
        case "spentChequeModalEdit":
            {

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
        let getAndPay=respond.response[0];
        if(getAndPay.StatusHDS==0){

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
                alert(getAndPay.INforCode)
                $("#inforTypeDaryaftEdit").val(getAndPay.InforHDS);
                $("#inforTypeCodeDarEdit").val(getAndPay.INforCode);
                $("#daryaftHdsDescEdit").val(getAndPay.DocDescHDS);
                $("#totalNetPriceHDSDarEdit").val(getAndPay.NetPriceHDS);
                $("#netPriceDarEdit").text(parseInt(getAndPay.NetPriceHDS).toLocaleString('en-us'));
                $("#addedDaryaftListBodyEdit").empty();
                getAndPay.BYS.forEach((element,index)=>{
                    $("#addedDaryaftListBodyEdit").append(`<tr onclick="setAddedDaryaftItemStuff(this,${element.SerialNoBYS})" ondblclick="editAddedDaryaftItem(this,${element.DocTypeBYS},${element.SerialNoBYS})">
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