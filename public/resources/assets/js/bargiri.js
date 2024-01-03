
var baseUrl = "http://192.168.10.21:8000";

function openBargiriModal(){
    setActiveTable("bargiriDriverListBody")
    $("#bargiriModal").modal("show");

    if (!$(".modal.in").length) {
        $(".modal-dialog").css({
            top: -11,
            left: 0,
        });
    }
    $("#bargiriModal").modal({
        backdrop: false,
        show: true,
    });

    $(".modal-dialog").draggable({
        handle: ".modal-header",
    });
}

function getDriverFactors(element,snMasterBar){
    $("tr").removeClass("selected");
    $(element).addClass("selected");
    $.get(baseUrl+"/getDriverFactors",{SnMasterBar:snMasterBar},(respond,status)=>{
        $("#editDriverFactorBtn").prop("disabled",false);
        $("#editDriverFactorBtn").val(snMasterBar);
        $("#deletDriverFactorBtn").prop("disabled",false);
        $("#deletDriverFactorBtn").val(snMasterBar);
       $("#bargiriFactorLisBody").empty();
       let i=0;
       for (const element of respond.factors) {
        let naghdPrice=element.NaghdPrice;
        let kartPrice=element.KartPrice;
        let varizPrice=element.VarizPrice;
        let difPrice=element.DifPrice;
        let takhfifPriceBar=element.TakhfifPriceBar;
        if(element.NaghdPrice<1){
            naghdPrice=0;
        }
        if(element.KartPrice<1){
            kartPrice=0;
        }
        if(element.VarizPrice<1){
            varizPrice=0;
        }
        if(element.DifPrice<1){
            difPrice=0;
        }
        if(element.TakhfifPriceBar<1){
            takhfifPriceBar=0;
        }

        i+=1;
        $("#bargiriFactorLisBody").append(`
            <tr class="factorTablRow">
                <td> ${i} </td>
                <td> ${element.FactNo} </td>
                <td> ${element.FactDate} </td>
                <td> ${element.PCode} </td>
                <td> ${element.Name} </td>
                <td> ${parseInt(element.NetPriceHDS).toLocaleString("en-us")} </td>
                <td> ${element.FactDesc} </td>
                <td> ${parseInt(naghdPrice).toLocaleString("en-us")} </td>
                <td> ${parseInt(kartPrice).toLocaleString("en-us")} </td>
                <td> ${parseInt(varizPrice).toLocaleString("en-us")} </td>
                <td> ${parseInt(takhfifPriceBar).toLocaleString("en-us")} </td>
                <td> ${parseInt(difPrice).toLocaleString("en-us")} </td>
                <td> ${element.peopeladdress} </td>
                <td> ${element.PhoneStr} </td>
            </tr>`);
        } 
// کالاهایش
        $("#bargiriKalaLisBody").empty();
        let j=0;
        for (const element of respond.kalas) {
            let packAmnt=element.packAmnt;
            let joze=element.joze;
            if(element.packAmnt<1){
                packAmnt=0;
            }
            if(element.joze<1){
                joze=0;
            }
            j+=1;
            $("#bargiriKalaLisBody").append(`
                <tr class="factorTablRow">
                    <td> ${j} </td>
                    <td> ${element.GoodCde} </td>
                    <td> ${element.GoodName} </td>
                    <td> ${parseInt(packAmnt).toLocaleString("en-us")} </td>
                    <td> ${element.SecondUnitName} </td>
                    <td> ${parseInt(joze).toLocaleString("en-us")} </td>
                    <td> ${element.FirstUnitName} </td>
                    <td> ${parseInt(element.allAmount).toLocaleString("en-us")} </td>
                    <td> ${element.SumFewWeight} </td>
                    <td> ${element.countFactor} </td>
                </tr>`);
            }
        })
    }

function addFactorToBargiri(){
    $.get(baseUrl+"/getDrivers",(respond,status)=>{
        $("#factorDriver").empty();
        for (const element of respond.drivers) {
            $("#factorDriver").append(`<option value="${element.SnDriver}">${element.NameDriver}</option>`);
        }
    });

    $.get(baseUrl+"/allBanks",(respond,status)=>{
        $("#allKartKhanBanks").empty();
        $("#allVarizBeHisabBanks").empty();
        $("#allKartKhanBanks").append(`<option></option>`);
        $("#allVarizBeHisabBanks").append(`<option></option>`);
        for (const element of respond.bankKarts) {
            $("#allKartKhanBanks").append(`<option value="${element.SerialNoAcc}">${element.bsn}</option>`);
            $("#allVarizBeHisabBanks").append(`<option value="${element.SerialNoAcc}">${element.bsn}</option>`);
        }
    });

$("#addFactorToBargiriModal").modal("show");

}
function editFactorsOfBargiri(snMasterBar){
    $.get(baseUrl+"/getMasterBarInfo",{snMasterBar:snMasterBar},(respond,status)=>{

        $("#factorDriverEdit").empty();
        let selectedDriverSnDriver;
        let paperDate;
        let paperNo;
        let paperDesc="";
        let mashinNo="";
        $("#SnMasterBarEdit").val(snMasterBar);
        if(respond.masterInfo[0].MashinNo.length>0){
            mashinNo=respond.masterInfo[0].MashinNo;
        }
        if(respond.masterInfo[0].DescPeaper.length>0){
            paperDesc=respond.masterInfo[0].DescPeaper;
        }
        selectedDriverSnDriver=respond.masterInfo[0].SnDriver;
        paperDate=respond.masterInfo[0].DatePeaper;
        paperNo=respond.masterInfo[0].NoPaper;
        
        $("#bargiriPaperDateEdit").val(paperDate);
        $("#bargiriPaperNoEdit").val(paperNo);
        $("#paperdescEdit").val(paperDesc);
        $("#mashinNoEdit").val(mashinNo);
        $("#factorsToAddToBargiriBodyEdit").empty();
        respond.masterInfo.forEach((element,index) => {
            let kartPrice=0;
            let naghdPrice=0;
            let varizPrice=0;
            let difPrice=0;
            let takhfifPriceBar=0;
            if(element.KartPrice>0){
                kartPrice=element.KartPrice;
            }
            if(element.NaghdPrice>0){
                naghdPrice=element.NaghdPrice;
            }
            if(element.VarizPrice>0){
                varizPrice=element.VarizPrice;
            }
            if(element.DifPrice>0){
                difPrice=element.DifPrice;
            }
            if(element.TakhfifPriceBar>0){
                takhfifPriceBar=element.TakhfifPriceBar;
            }

            $("#factorsToAddToBargiriBodyEdit").append(`<tr class="factorTablRow" onclick="setFactorInfoForEdit(this)">
                                                            <td> ${(index+1)} <input type="checkbox" name="FactSns[]" value="${element.SerialNoHDS}" checked style="display:none"/></td>
                                                            <td   class="td-part-input"> <input type="text" value="${element.FactNo}" class="td-inputFactEdit form-control" required> </td>
                                                            <td   class="td-part-input"> <input type="text" value="${element.FactDate}" class="td-inputFactEdit form-control" required> </td>
                                                            <td   class="td-part-input"> <input type="text" value="${element.PCode}" class="td-inputFactEdit form-control" required> </td>
                                                            <td   class="td-part-input"> <input type="text" value="${element.Name}" class="td-inputFactEdit form-control" required> </td>
                                                            <td   class="td-part-input"> <input type="text" name="NetPrice${element.SerialNoHDS}" value="${parseInt(element.NetPriceHDS).toLocaleString('en-us')}" class="td-inputFactEdit form-control" required> </td>
                                                            <td   class="td-part-input"> <input type="text" name="NaghdPrice${element.SerialNoHDS}" value="${parseInt(naghdPrice).toLocaleString('en-us')}" class="td-inputFactEdit form-control" required> </td>
                                                            <td   class="td-part-input"> <input type="text" name="KartPrice${element.SerialNoHDS}" value="${parseInt(kartPrice).toLocaleString('en-us')}" class="td-inputFactEdit form-control"> </td>
                                                            <td   class="td-part-input"> <input type="text" name="VarizPrice${element.SerialNoHDS}" value="${parseInt(varizPrice).toLocaleString('en-us')}" class="td-inputFactEdit form-control"> </td>
                                                            <td   class="td-part-input"> <input type="text" name="TakhfifPriceBar${element.SerialNoHDS}" value="${parseInt(takhfifPriceBar).toLocaleString('en-us')}" class="td-inputFactEdit form-control"> </td>
                                                            <td   class="td-part-input"> <input type="text" name="DifPrice${element.SerialNoHDS}" value="${parseInt(difPrice).toLocaleString('en-us')}" class="td-inputFactEdit form-control"> </td>
                                                            <td   class="td-part-input"> <input type="text" value="${element.FactDesc}" class="td-inputFactEdit form-control"> </td>
                                                            <td   class="td-part-input"> <input type="text" value="${element.OtherAddress}" class="td-inputFactEdit form-control"> </td>
                                                            <td   class="td-part-input"> <input type="text" value="${element.PhoneStr}" class="td-inputFactEdit form-control"> </td>
                                                        </tr>`);
        });
        
        $.get(baseUrl+"/getDrivers",(respond,status)=>{
            $("#factorDriverEdit").empty();
            for (const element of respond.drivers) {
                if(element.SnDriver!=selectedDriverSnDriver){
                    $("#factorDriverEdit").append(`<option value="${element.SnDriver}">${element.NameDriver}</option>`);
                }else{
                    $("#factorDriverEdit").append(`<option selected value="${element.SnDriver}">${element.NameDriver}</option>`);
                }
            }
        });

        let serNoAccVariz=0;
        let serNoAccKartKhan=0;
        $("#KartKhan_SnAccBankEdit").val("");
        $("#Variz_SnAccBankEdit").val("");
        $("#Bargiri_NoPayanehEdit").val("");
        $("#mashinNoEdit").val("")
        if(respond.masterInfo[0].Bargiri_VarizSnAccBank){
            serNoAccVariz=respond.masterInfo[0].Bargiri_VarizSnAccBank;
        }
        if(respond.masterInfo[0].Bargiri_SnAccBank){
            serNoAccKartKhan=respond.masterInfo[0].Bargiri_SnAccBank;
        }
        if(respond.masterInfo[0].Bargiri_NoPayaneh){
            $("#Bargiri_NoPayanehEdit").val(respond.masterInfo[0].Bargiri_NoPayaneh);
        }

        if(respond.masterInfo[0].BarMashinNo){
            $("#mashinNoEdit").val(respond.masterInfo[0].BarMashinNo);
        }


    
        $.get(baseUrl+"/allBanks",(respond,status)=>{
            $("#allKartKhanBanksEdit").empty();
            $("#allVarizBeHisabBanksEdit").empty();
            $("#allKartKhanBanksEdit").append(`<option></option>`);
            $("#allVarizBeHisabBanksEdit").append(`<option></option>`);
            for (const element of respond.bankKarts) {
                if(serNoAccKartKhan!=element.SerialNoAcc){
                    $("#allKartKhanBanksEdit").append(`<option value="${element.SerialNoAcc}">${element.bsn}</option>`);
                }else{
                    $("#KartKhan_SnAccBankEdit").val(element.AccNo);
                    $("#allKartKhanBanksEdit").append(`<option selected value="${element.SerialNoAcc}">${element.bsn}</option>`);
                }
                
                if(serNoAccVariz!=element.SerialNoAcc){
                    $("#allVarizBeHisabBanksEdit").append(`<option value="${element.SerialNoAcc}">${element.bsn}</option>`);
                }else{
                    $("#Variz_SnAccBankEdit").val(element.AccNo);
                    $("#allVarizBeHisabBanksEdit").append(`<option selected value="${element.SerialNoAcc}">${element.bsn}</option>`);
                }
            }
        });

    });


    $("#editFactorsOfBargiriModal").modal("show");
}

$("#allVarizBeHisabBanksEdit").on("change",function(e){
    $.get(baseUrl+"/getBankInfo",{bankSn:$(this).val()},function(respond,status){
        $("#Variz_SnAccBankEdit").val(respond[0].AccNo);
    })
})

$("#allKartKhanBanksEdit").on("change",function(e){
    $.get(baseUrl+"/getBankInfo",{bankSn:$(this).val()},function(respond,status){
        $("#KartKhan_SnAccBankEdit").val(respond[0].AccNo);
    })
})
$("#allVarizBeHisabBanks").on("change",function(e){
    $.get(baseUrl+"/getBankInfo",{bankSn:$(this).val()},function(respond,status){
        $("#Variz_SnAccBank").val(respond[0].AccNo);
    })
})

$("#allKartKhanBanks").on("change",function(e){
    $.get(baseUrl+"/getBankInfo",{bankSn:$(this).val()},function(respond,status){
        $("#KartKhan_SnAccBank").val(respond[0].AccNo);
    })
})

function setFactorInfoForEdit(element){
    let snFact= $(element).find('input[type="checkbox"]').val();
    $("#editModalEditFactorBtn").val(snFact);
    $("#editModalEditFactorBtn").prop("disabled",false);
    $("#addModalEditFactorBtn").val(snFact);
}

function deleteFactorsOfBargiri(snMasterBar){
    swal({
        title: 'اخطار!',
        text: 'آیا می خواهید حذف کنید؟',
        icon: 'warning',
        buttons: true
    }).then(function (willAdd) {
        if (willAdd) {
            $.get(baseUrl+"/deleteBargiriHDS",{SnMasterBar:snMasterBar},(respond,status)=>{
                $("#bargiriDriverListBody").empty();
                respond.todayDrivers.forEach((element,index) => {
                    $("#bargiriDriverListBody").append(`<tr onclick="getDriverFactors(this,${element.SnMasterBar})">
                                        <td> ${index+1} </td>
                                        <td> ${element.NoPaper} </td>
                                        <td> ${element.DatePeaper} </td>
                                        <td> ${element.driverName} </td>
                                        <td> ${element.MashinNo} </td>
                                        <td> ${element.DescPeaper} <input type="radio" style="display:none" value="${element.SnMasterBar}"/>  </td>
                                    </tr>`);
                });
            })
        }});
}


$("#addFactorsBargiriForm").on("submit",function(e){
    e.preventDefault();
    $.ajax({
        method: $(this).attr('method'),
        url: $(this).attr('action'),
        data:$(this).serialize(),
        processData: false,
        contentType: false,
        success: function (respond) {
            $("#bargiriDriverListBody").empty();
            respond.todayDrivers.forEach((element,index) => {
                $("#bargiriDriverListBody").append(`<tr onclick="getDriverFactors(this,${element.SnMasterBar})">
                                    <td> ${index+1} </td>
                                    <td> ${element.NoPaper} </td>
                                    <td> ${element.DatePeaper} </td>
                                    <td> ${element.driverName} </td>
                                    <td> ${element.MashinNo} </td>
                                    <td> ${element.DescPeaper} <input type="radio" style="display:none" value="${element.SnMasterBar}"/>  </td>
                                </tr>`);
            });
            $("#addFactorToBargiriModal").modal("hide");
        },
        error:function(error){

        }
    });
})

$("#doEditBargiriFactorsForm").on("keydown",function(e){
    if(e.keyCode==13){
        e.preventDefault();
    }
});

$("#doEditBargiriFactorsForm").on("submit",function(e){
    e.preventDefault();
    $.ajax({
        method: $(this).attr('method'),
        url: $(this).attr('action'),
        data:$(this).serialize(),
        processData: false,
        contentType: false,
        success: function (respond) {
            $("#bargiriDriverListBody").empty();
            respond.todayDrivers.forEach((element,index) => {
                $("#bargiriDriverListBody").append(`<tr onclick="getDriverFactors(this,${element.SnMasterBar})">
                                    <td> ${index+1} </td>
                                    <td> ${element.NoPaper} </td>
                                    <td> ${element.DatePeaper} </td>
                                    <td> ${element.driverName} </td>
                                    <td> ${element.MashinNo} </td>
                                    <td> ${element.DescPeaper} <input type="radio" style="display:none" value="${element.SnMasterBar}"/>  </td>
                                </tr>`);
            });
            $("#editFactorsOfBargiriModal").modal("hide");
        },
        error:function(error){

        }
    });
});


function searchFactorForAddToBargiri(){
    $("#searchFoactorForAddToBargiriModal").modal("show");
    setActiveTable("mantiqasFactorForBargiriBody")
    $.get(baseUrl+"/getMantiqasOfFactors",(respond,status)=>{
        $("#factorsMantiqasBodyList").empty();
        $("#mantiqasFactorForBargiriBody").empty();
        $("#selectAllFactorsForBarigiCheckbox").prop("checked",false);
        let i=0;
        for (const element of respond.mantiqas) {
            i++;
            $("#factorsMantiqasBodyList").append(`<tr onclick="getMantiqasFactorForBargiri(this,${element.SnMNM})" class="factorTablRow">
            <td>${i}</td>
            <td>${element.NameRec}</td>
            <td>${element.countFactor}</td>
        </tr>`);
        }
    });
}
function searchFactorForAddToBargiriEdit(){
    $("#searchFoactorForAddToBargiriModalEdit").modal("show");
    $.get(baseUrl+"/getMantiqasOfFactors",(respond,status)=>{
        $("#factorsMantiqasBodyListEdit").empty();
        let i=0;
        for (const element of respond.mantiqas) {
            i++;
            $("#factorsMantiqasBodyListEdit").append(`<tr onclick="getMantiqasFactorForBargiriEdit(this,${element.SnMNM})" class="factorTablRow">
            <td>${i}</td>
            <td>${element.NameRec}</td>
            <td>${element.countFactor}</td>
        </tr>`);
        }
    });
}

function getMantiqasFactorForBargiri(elementTr,snMantagheh){
    $("tr").removeClass("selected");
    $(elementTr).addClass("selected");
    $.get(baseUrl+"/getMantiqasFactorForBargiri",{SnMantagheh:snMantagheh},(respond,status)=>{
        $("#mantiqasFactorForBargiriBody").empty();
        let i=0;
        for (const element of respond.factors) {
            i++
            $("#mantiqasFactorForBargiriBody").append(`<tr onclick="selectFactorToBargiri(this)" class="factorTablRow">
                <td> ${i} </td>
                <td> ${element.FactNo} </td>
                <td> ${element.FactDate} </td>
                <td> ${element.PCode}</td>
                <td> ${element.Name}</td>
                <td> ${parseInt(element.NetPriceHDS).toLocaleString("en-us")} </td>
                <td> ${element.OtherAddress} </td>
                <td> ${element.PhoneStr} </td>
                <td> ${element.LatPers} </td>
                <td> ${element.LonPers} </td>
                <td> ${element.NameRec} <input type="checkbox" class="form-check-input selectAllFactorToBargiri" value="${element.SerialNoHDS}" name="factorToadd[]"/> </td>
            </tr>`);
        }
    })
}

function getMantiqasFactorForBargiriEdit(elementTr,snMantagheh){
    $("#selectAllFactorsForBarigiCheckboxEdit").prop("checked",false);
    $("tr").removeClass("selected");
    $(elementTr).addClass("selected");
    $.get(baseUrl+"/getMantiqasFactorForBargiri",{SnMantagheh:snMantagheh},(respond,status)=>{
        $("#mantiqasFactorForBargiriBodyEdit").empty();
        let i=0;
        for (const element of respond.factors) {
            i++
            $("#mantiqasFactorForBargiriBodyEdit").append(`<tr onclick="selectFactorToBargiriEdit(this)" class="factorTablRow">
                <td> ${i} </td>
                <td> ${element.FactNo} </td>
                <td> ${element.FactDate} </td>
                <td> ${element.PCode}</td>
                <td> ${element.Name}</td>
                <td> ${parseInt(element.NetPriceHDS).toLocaleString("en-us")} </td>
                <td> ${element.OtherAddress} </td>
                <td> ${element.PhoneStr} </td>
                <td> ${element.LatPers} </td>
                <td> ${element.LonPers} </td>
                <td> ${element.NameRec} <input type="checkbox" class="form-check-input selectAllFactorToBargiriEdit" value="${element.SerialNoHDS}" name="factorToadd[]"/> </td>
            </tr>`);
        }
    })
}

function addSelectFactorsToBargiri(){
    let selectFactorsSn=[];
    $('input[name="factorToadd[]"]:checked').map(function () {
        selectFactorsSn.push($(this).val());
    });

    $.get(baseUrl+"/getFactorsInfoToBargiriTbl",{allFactors:selectFactorsSn},(respond,status)=>{

        let i=$("#factorsToAddToBargiriBody tr").length;
        for (const element of respond) {
            let netPriceHDS=0;
            let naghdPrice=0;
            let kartPrice=0;
            let varizPrice=0;
            let takhfifPriceBar=0;
            let difPrice=0;
            if(element.NetPriceHDS>0){
                netPriceHDS=element.NetPriceHDS;
            }
            if(element.NaghdPrice>0){
                naghdPrice=element.NaghdPrice;
            }
            if(element.KartPrice>0){
                kartPrice=element.KartPrice;
            }
            if(element.VarizPrice>0){
                varizPrice=element.VarizPrice;
            }
            if(element.TakhfifPriceBar>0){
                takhfifPriceBar=element.TakhfifPriceBar;
            }
            if(element.DifPrice>0){
                difPrice=element.DifPrice;
            }
            i+=1;
            $("#factorsToAddToBargiriBody").append(`<tr class="factorTablRow">
                <td> ${i} <input type="checkbox" name="FactSns[]" value="${element[0].SerialNoHDS}" checked style="display:none"/> </td>
                <td   class="td-part-input"> <input type="text" name="" value="${element[0].FactNo}" class="td-input form-control" required> </td>
                <td   class="td-part-input"> <input type="text" name="" value="${element[0].FactDate}" class="td-input form-control" required> </td>
                <td   class="td-part-input"> <input type="text" name="" value="${element[0].PCode}" class="td-input form-control" required> </td>
                <td   class="td-part-input"> <input type="text" name="" value="${element[0].Name}" class="td-input form-control" required> </td>
                <td   class="td-part-input"> <input type="text" name="" value="${parseInt(netPriceHDS).toLocaleString("en-us")}" class="td-input form-control" required> </td>
                <td   class="td-part-input"> <input type="text" name="" value="${parseInt(naghdPrice).toLocaleString("en-us")}" class="td-input form-control" required> </td>
                <td   class="td-part-input"> <input type="text" name="" value="${parseInt(kartPrice).toLocaleString("en-us")}" class="td-input form-control"> </td>
                <td   class="td-part-input"> <input type="text" name="" value="${parseInt(varizPrice).toLocaleString("en-us")}" class="td-input form-control"> </td>
                <td   class="td-part-input"> <input type="text" name="" value="${parseInt(takhfifPriceBar).toLocaleString("en-us")}" class="td-input form-control"> </td>
                <td   class="td-part-input"> <input type="text" name="" value="${parseInt(difPrice).toLocaleString("en-us")}" class="td-input form-control"> </td>
                <td   class="td-part-input"> <input type="text" name="" value="${element[0].FactDesc}" class="td-input form-control"> </td>
                <td   class="td-part-input"> <input type="text" name="" value="${element[0].OtherAddress}" class="td-input form-control"> </td>
                <td   class="td-part-input"> <input type="text" name="" value="${element[0].PhoneStr}" class="td-input form-control"> </td>
            </tr>`);
        }
    //  $("#mantiqasFactorForBargiriBody").empty();
        $("#searchFoactorForAddToBargiriModal").modal("hide");
        });
    //for adding factors to Bargiri
    $.get(baseUrl+"/addFactorToBargiri",{allFactors:selectFactorsSn},(respond,status)=>{
        console.log(respond)
    })
}

$(document).on("keyup",".td-inputFactEdit",function(e){
    var currentInput = $(e.target);
    var row = $(currentInput).closest("tr");
    let rowIdx=row.index()+1;
    let netPriceHDS=$(`#factorsToAddToBargiriBodyEdit tr:nth-child(${rowIdx}) td:nth-child(6) input`).val().replace(/,/g, '');
    let naghdPrice=$(`#factorsToAddToBargiriBodyEdit tr:nth-child(${rowIdx}) td:nth-child(7) input`).val().replace(/,/g, '');
    let kartPrice=$(`#factorsToAddToBargiriBodyEdit tr:nth-child(${rowIdx}) td:nth-child(8) input`).val().replace(/,/g, '');
    let varizPrice=$(`#factorsToAddToBargiriBodyEdit tr:nth-child(${rowIdx}) td:nth-child(9) input`).val().replace(/,/g, '');
    let takhfifPriceBar=$(`#factorsToAddToBargiriBodyEdit tr:nth-child(${rowIdx}) td:nth-child(10) input`).val().replace(/,/g, '');
    let difPrice=parseInt(netPriceHDS)-(parseInt(naghdPrice)+parseInt(kartPrice)+parseInt(varizPrice)+parseInt(takhfifPriceBar));
    $(`#factorsToAddToBargiriBodyEdit tr:nth-child(${rowIdx}) td:nth-child(11) input`).val(parseInt(difPrice).toLocaleString("en-us"));
    
    if(e.keyCode==13){
        $("#bargiriFactorsEditBtn").prop("disabled",false);
        var nextInput = currentInput.closest('td').next('td').find('input');
        if (nextInput.length > 0) {
            nextInput.focus();
        }
    }
    
});

function addSelectFactorsToBargiriEdit(){
    let selectFactorsSn=[];
    $('input[name="factorToadd[]"]:checked').map(function () {
        selectFactorsSn.push($(this).val());
    });
    $.get(baseUrl+"/getFactorsInfoToBargiriTbl",{allFactors:selectFactorsSn},(respond,status)=>{
        
        let i=$("#factorsToAddToBargiriBodyEdit tr").length;
        for (const element of respond) {
            let netPriceHDS=0;
            let naghdPrice=0;
            let kartPrice=0;
            let varizPrice=0;
            let takhfifPriceBar=0;
            let difPrice=0;
            if(element[0].NetPriceHDS>0){
                netPriceHDS=element[0].NetPriceHDS;
            }
            if(element[0].NaghdPrice>0){
                naghdPrice=element[0].NaghdPrice;
            }
            if(element[0].KartPrice>0){
                kartPrice=element[0].KartPrice;
            }
            if(element[0].VarizPrice>0){
                varizPrice=element[0].VarizPrice;
            }
            if(element[0].TakhfifPriceBar>0){
                takhfifPriceBar=element[0].TakhfifPriceBar;
            }
            if(element[0].DifPrice>0){
                difPrice=element[0].DifPrice;
            }
            let serialNoHDS=element[0].SerialNoHDS;
            
            i+=1;
            $("#factorsToAddToBargiriBodyEdit").append(`<tr class="factorTablRow">
                <td> ${i} <input type="checkbox" name="FactSnsEdit[]" value="${serialNoHDS}" checked style="display:none"/> </td>
                <td   class="td-part-input"> <input type="text" name="" value="${element[0].FactNo}" class="td-input form-control" required> </td>
                <td   class="td-part-input"> <input type="text" name="" value="${element[0].FactDate}" class="td-input form-control" required> </td>
                <td   class="td-part-input"> <input type="text" name="" value="${element[0].PCode}" class="td-input form-control" required> </td>
                <td   class="td-part-input"> <input type="text" name="" value="${element[0].Name}" class="td-input form-control" required> </td>
                <td   class="td-part-input"> <input type="text" name="NetPriceHDS${serialNoHDS}" value="${parseInt(netPriceHDS).toLocaleString("en-us")}" class="td-input form-control" required> </td>
                <td   class="td-part-input"> <input type="text" name="NaghdPrice${serialNoHDS}" value="${parseInt(naghdPrice).toLocaleString("en-us")}" class="td-input form-control" required> </td>
                <td   class="td-part-input"> <input type="text" name="KartPrice${serialNoHDS}" value="${parseInt(kartPrice).toLocaleString("en-us")}" class="td-input form-control"> </td>
                <td   class="td-part-input"> <input type="text" name="VarizPrice${serialNoHDS}" value="${parseInt(varizPrice).toLocaleString("en-us")}" class="td-input form-control"> </td>
                <td   class="td-part-input"> <input type="text" name="TakhfifPriceBar${serialNoHDS}" value="${parseInt(takhfifPriceBar).toLocaleString("en-us")}" class="td-input form-control"> </td>
                <td   class="td-part-input"> <input type="text" name="DifPrice${serialNoHDS}" value="${parseInt(difPrice).toLocaleString("en-us")}" class="td-input form-control"> </td>
                <td   class="td-part-input"> <input type="text" name="" value="${element[0].FactDesc}" class="td-input form-control"> </td>
                <td   class="td-part-input"> <input type="text" name="" value="${element[0].OtherAddress}" class="td-input form-control"> </td>
                <td   class="td-part-input"> <input type="text" name="" value="${element[0].PhoneStr}" class="td-input form-control"> </td>
            </tr>`);
        }
    //  $("#mantiqasFactorForBargiriBody").empty();
        $("#bargiriFactorsEditBtn").prop("disabled",false);
        $("#searchFoactorForAddToBargiriModalEdit").modal("hide");
        });
}

function cancelBargiriFactorEdit(){
    swal({
        text: "می خواهید بدون ذخیره خارج شوید؟",
        icon: "warning",
        buttons: true,
        dangerMode: true,
        }).then((willAdd) =>{
            if(willAdd){
                $("#editFactorsOfBargiriModal").modal("hide");
            }
        });
}

function cancelAddingFactorToBargiri(){
    swal({
        text: "می خواهید بدون ذخیره خارج شوید؟",
        icon: "warning",
        buttons: true,
        dangerMode: true,
        }).then((willAdd) =>{
            if(willAdd){
                $("#factorsToAddToBargiriBody").empty();
                $("#addFactorToBargiriModal").modal("hide");
                setActiveTable("")
            }else{
                $("#addFactorToBargiriModal").modal("show");
            }
        });
}
function cancelAddingSearchedFactorToBargiri(){
    swal({
        text: "می خواهید بدون افزودن خارج شوید؟",
        icon: "warning",
        buttons: true,
        dangerMode: true,
        }).then((willCancel) => {
            if(willCancel){
                $("#searchFoactorForAddToBargiriModal").modal("hide");

            }else{
                $("#searchFoactorForAddToBargiriModal").modal("show");

            }
        }); 
}

function cancelAddingSearchedFactorToBargiriEdit(){
    swal({
        text: "می خواهید بدون افزودن خارج شوید؟",
        icon: "warning",
        buttons: true,
        dangerMode: true,
        }).then((willCancel) => {
            if(willCancel){
                $("#searchFoactorForAddToBargiriModalEdit").modal("hide");
            }
        }); 
}

$("#selectAllFactorsForBarigiCheckbox").on("change",(respond,status)=>{
    if($("#selectAllFactorsForBarigiCheckbox").is(":checked")){
        $(".selectAllFactorToBargiri").prop("checked",true);
    }else{
        $(".selectAllFactorToBargiri").prop("checked",false);
    }
})

$("#selectAllFactorsForBarigiCheckboxEdit").on("change",(respond,status)=>{
    if($("#selectAllFactorsForBarigiCheckboxEdit").is(":checked")){
        $(".selectAllFactorToBargiriEdit").prop("checked",true);
    }else{
        $(".selectAllFactorToBargiriEdit").prop("checked",false);
    }
})

function selectFactorToBargiriEdit(element){
    //$("#mantiqasFactorForBargiriBodyEdit tr").removeClass("selected");
   //$(element).addClass("selected");
    if($(element).hasClass("selected")){
        $(element).removeClass("selected");
    }else{
        $(element).addClass("selected");
    }
    let checkBox=$(element).find('input:checkbox');
    if($(checkBox).is(":checked")){
        $(checkBox).prop("checked",false);
        $("#selectAllFactorsForBarigiCheckboxEdit").prop("checked",false);
    }else{
        $(checkBox).prop("checked",true);
    }
}

function selectFactorToBargiri(element){
    //$("#mantiqasFactorForBargiriBody tr").removeClass("selected");
    if($(element).hasClass("selected")){
        $(element).removeClass("selected");
    }else{
        $(element).addClass("selected");
    }
    let checkBox=$(element).find('input:checkbox');
    if($(checkBox).is(":checked")){
        $(checkBox).prop("checked",false);
        $("#selectAllFactorsForBarigiCheckbox").prop("checked",false);
    }else{
        $(checkBox).prop("checked",true);
    }
}

$("#bargiriPaperDate").persianDatepicker({
    cellWidth: 32,
    cellHeight: 22,
    fontSize: 14,
    formatDate: "YYYY/0M/0D",
    endDate: "1440/05/05",
});

// let selectedRow = 0;
// localStorage.setItem("scrollTop",0);
// $(document).on("keydown",function(e){
//     if (e.which === 40 || e.which === 38) {
//         e.preventDefault();
//         let tableBody=$("#factorTable");
//         Mousetrap.bind('down', function (e) {
//             var rowCount = $("#factorListBody tr:last").index() + 1;
//             if (selectedRow >= 0) {
//                 $("#factorListBody tr").eq(selectedRow).css('background-color', 'rgb(232, 22, 144)');
//             }
//             if(selectedRow!=0){
//                 selectedRow = Math.min(selectedRow + 1, rowCount - 1); 
//                 $("#factorListBody tr").eq(selectedRow).css('background-color', "rgb(0,142,201)"); 
//             }else{
//                 selectedRow = Math.min(1, rowCount - 1); 
//                 $("#factorListBody tr").eq(selectedRow).css('background-color', "rgb(0,142,201)"); 
//             }
//             selectFactorForBargiri(133,$("#factorListBody tr").eq(selectedRow));
//             let topTr = $("#factorListBody tr").eq(selectedRow).position().top;
//             let bottomTr =topTr+50;
//             let trHieght =50;
//             if(topTr > 0 && bottomTr < 450){
//             }else{
//                 let newScrollTop =trHieght+ parseInt(localStorage.getItem("scrollTop"));
//                 tableBody.scrollTop(parseInt(newScrollTop));
//                 localStorage.setItem("scrollTop",newScrollTop);
//             }
//         });

//         Mousetrap.bind('up', function (e) {
//             if (selectedRow >= 0) {
//                 $("#factorListBody tr").eq(selectedRow).css('background-color','rgb(232, 22, 144)');
//             }
//             selectedRow = Math.max(selectedRow - 1, 0); 
//             $("#factorListBody tr").eq(selectedRow).css('background-color', 'rgb(0,142,201)'); 
//             selectFactorForBargiri(123,$("#factorListBody tr").eq(selectedRow));
//             let topTr = $("#factorListBody tr").eq(selectedRow).position().top;
//             let bottomTr =topTr+parseInt($("#factorListBody tr").eq(selectedRow).height());
//             let trHieght =50;
//             if(topTr >117 && bottomTr < 450){
//             }else{
//                 let newScrollTop = parseInt(localStorage.getItem("scrollTop"))-(trHieght);
//                 tableBody.scrollTop(parseInt(newScrollTop));
//                 localStorage.setItem("scrollTop",newScrollTop);
//             }
//         });

//         Mousetrap.bind("enter",()=>{
//             $("#searchCustomerSabtBtn").trigger("click");
//             localStorage.setItem("scrollTop",0);
//         });
//     }
// })
  
function selectFactorForBargiri(snFact,element){
    if(isNaN(element)){
        $("tr").removeClass('selected');
        $("#factorListBody tr").css('background-color', 'rgb(232, 22, 144)');
        $(element).addClass("selected")
    }else{
        $("tr").removeClass('selected');
    }
    // $("#searchCustomerSabtBtn").prop("disabled",false);
    // $("#searchCustomerSabtBtn").val(snFact);
}

let selectedRowDriver=0;
$(document).keyup( (event) => {
    switch(activeTable){
        case "bargiriDriverListBody":
            {
                if(event.keyCode==40){
                    event.preventDefault();
                    var rowCount = $("#bargiriDriverListBody tr:last").index() + 1;
                    let tableBody=$("#bargiriDriverListBody");
                    if (selectedRowDriver >= 0) {
                        $("#bargiriDriverListBody tr").eq(selectedRowDriver).css('background-color', '');
                    }
                    if(selectedRowDriver!=0){
                        selectedRowDriver = Math.min(selectedRowDriver + 1, rowCount - 1); 
                        $("#bargiriDriverListBody tr").eq(selectedRowDriver).css('background-color', "rgb(0,142,201)"); 
                    }else{
                        selectedRowDriver = Math.min(1, rowCount - 1); 
                        $("#bargiriDriverListBody tr").eq(selectedRowDriver).css('background-color', "rgb(0,142,201)"); 
                    }
                    element=$("#bargiriDriverListBody tr").eq(selectedRowDriver)
                    snFact=$(element).find('input[type="radio"]').val();
                    
                    getDriverFactors(element,snFact)
                    let topTr = $("#bargiriDriverListBody tr").eq(selectedRowDriver).position().top;
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
                    var rowCount = $("#bargiriDriverListBody tr:last").index() + 1;
                    let tableBody=$("#bargiriDriverListBody");
                    if (selectedRowDriver >= 0) {
                        $("#bargiriDriverListBody tr").eq(selectedRowDriver).css('background-color', '');
                    }
                    if(selectedRowDriver!=0){
                        selectedRowDriver = Math.max(selectedRowDriver  - 1, 0); 
                        $("#bargiriDriverListBody tr").eq(selectedRowDriver).css('background-color', "rgb(0,142,201)"); 
                    }else{
                        selectedRowDriver = Math.min(1, rowCount - 1); 
                        $("#bargiriDriverListBody tr").eq(selectedRowDriver).css('background-color', "rgb(0,142,201)"); 
                    }
                    element=$("#bargiriDriverListBody tr").eq(selectedRowDriver)
                    snFact=$(element).find('input[type="radio"]').val();
                    
                    getDriverFactors(element,snFact)
                    let topTr = $("#bargiriDriverListBody tr").eq(selectedRowDriver).position().top;
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

