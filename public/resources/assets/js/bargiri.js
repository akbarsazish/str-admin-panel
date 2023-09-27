var baseUrl = "http://192.168.10.24:8080";
function getFactorOrders(element,factorSn){
    $("tr").removeClass("selected");
    $(element).addClass("selected");
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

function openBargiriModal(){
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

    let selectedRowBargiri = 0;
localStorage.setItem("scrollTop",0);
$(document).on("keydown",function(e){
    if (e.which === 40 || e.which === 38) {
        e.preventDefault();
        let tableBody=$("#bargiriDriverTable");
        let element;
        let snFact;
        Mousetrap.bind('down', function (e) {
            var rowCount = $("#bargiriDriverListBody tr:last").index() + 1;
            if (selectedRowBargiri >= 0) {
                $("#bargiriDriverListBody tr").eq(selectedRowBargiri).css('background-color', '');
            }
            if(selectedRowBargiri!=0){
                selectedRowBargiri = Math.min(selectedRowBargiri + 1, rowCount - 1); 
                $("#bargiriDriverListBody tr").eq(selectedRowBargiri).css('background-color', "rgb(0,142,201)"); 
            }else{
                selectedRowBargiri = Math.min(1, rowCount - 1); 
                $("#bargiriDriverListBody tr").eq(selectedRowBargiri).css('background-color', "rgb(0,142,201)"); 
            }
            element=$("#bargiriDriverListBody tr").eq(selectedRowBargiri)
            snFact=$(element).find('input[type="radio"]').val();
            getDriverFactors(element,snFact)
            let topTr = $("#bargiriDriverListBody tr").eq(selectedRowBargiri).position().top;
            let bottomTr =topTr+50;
            let trHieght =50;
            if(topTr > 0 && bottomTr < 450){
            }else{
                let newScrollTop =trHieght+ parseInt(localStorage.getItem("scrollTop"));
                tableBody.scrollTop(parseInt(newScrollTop));
                localStorage.setItem("scrollTop",newScrollTop);
            }
        });

        Mousetrap.bind('up', function (e) {
            if (selectedRowBargiri >= 0) {
                $("#bargiriDriverListBody tr").eq(selectedRowBargiri).css('background-color','');
            }
            selectedRowBargiri = Math.max(selectedRowBargiri - 1, 0); 
            $("#bargiriDriverListBody tr").eq(selectedRowBargiri).css('background-color', 'rgb(0,142,201)'); 
            element=$("#bargiriDriverListBody tr").eq(selectedRowBargiri)
            snFact=$(element).find('input[type="radio"]').val();
            
            getDriverFactors(element,snFact)
            let topTr = $("#bargiriDriverListBody tr").eq(selectedRowBargiri).position().top;
            let bottomTr =topTr+parseInt($("#bargiriDriverListBody tr").eq(selectedRowBargiri).height());
            let trHieght =50;
            if(topTr >117 && bottomTr < 450){
            }else{
                let newScrollTop = parseInt(localStorage.getItem("scrollTop"))-(trHieght);
                tableBody.scrollTop(parseInt(newScrollTop));
                localStorage.setItem("scrollTop",newScrollTop);
            }
        });

        Mousetrap.bind("enter",()=>{
            $("#searchCustomerSabtBtn").trigger("click");
            localStorage.setItem("scrollTop",0);
        });
    }
})
    
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
                 <td> ${i} </td>
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
        for (const element of respond.bankKarts) {
            $("#allKartKhanBanks").append(`<option value="${element.SerialNoAcc}">${element.AccNo}</option>`);
            $("#allVarizBeHisabBanks").append(`<option value="${element.SerialNoAcc}">${element.AccNo}</option>`);
        }
    });

$("#addFactorToBargiriModal").modal("show");

}
function editFactorsOfBargiri(snMasterBar){
    $.get(baseUrl+"/getMasterBarInfo",{snMasterBar:snMasterBar},(respond,status)=>{
        $("#factorDriverEdit").empty();
        console.log(respond)
        let selectedDriverSnDriver;
        let paperDate;
        let paperNo;
        selectedDriverSnDriver=respond.masterInfo[0].SnDriver;
        paperDate=respond.masterInfo[0].DatePeaper;
        paperNo=respond.masterInfo[0].NoPaper;
        $("#bargiriPaperDateEdit").val(paperDate);
        $("#bargiriPaperNoEdit").val(paperNo);
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
    });
    $.get(baseUrl+"/allBanks",(respond,status)=>{
        $("#allKartKhanBanksEdit").empty();
        $("#allVarizBeHisabBanksEdit").empty();
        for (const element of respond.bankKarts) {
            $("#allKartKhanBanksEdit").append(`<option value="${element.SerialNoAcc}">${element.AccNo}</option>`);
            $("#allVarizBeHisabBanksEdit").append(`<option value="${element.SerialNoAcc}">${element.AccNo}</option>`);
        }
    });
    $("#editFactorsOfBargiriModal").modal("show");
}
function deleteFactorsOfBargiri(SnMasterBar){
    swal({
        title: 'اخطار!',
        text: 'آیا می خواهید حذف کنید؟',
        icon: 'warning',
        buttons: true
    }).then(function (willAdd) {
        if (willAdd) {
            $.get(baseUrl+"/deleteBargiriHDS",{snMasterBar:SnMasterBar},(respond,status)=>{

            })
        }});
}

function searchFactorForAddToBargiri(){
    $("#searchFoactorForAddToBargiriModal").modal("show");
    $.get(baseUrl+"/getMantiqasOfFactors",(respond,status)=>{
        $("#factorsMantiqasBodyList").empty();
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

function addSelectFactorsToBargiri(){
    let selectFactorsSn=[];
    $('input[name="factorToadd[]"]:checked').map(function () {
        selectFactorsSn.push($(this).val());
    });
    alert(selectFactorsSn.length);
    $("#mantiqasFactorForBargiriBody").empty();
    $.get(baseUrl+"/getFactorsInfoToBargiriTbl",{allFactors:selectFactorsSn},(respond,status)=>{
        console.log(respond[0])
        $("#factorsToAddToBargiriBody").empty();
        let i=0;
        for (const element of respond) {
            i+=1;
            $("#factorsToAddToBargiriBody").append(`<tr class="factorTablRow">
                <td > ${i} </td>
                <td   class="td-part-input"> <input type="text" value="${element.FactNo}" class="td-input form-control" required> </td>
                <td   class="td-part-input"> <input type="text" value="${element.FactDate}" class="td-input form-control" required> </td>
                <td   class="td-part-input"> <input type="text" value="${element.PCode}" class="td-input form-control" required> </td>
                <td   class="td-part-input"> <input type="text" value="${element.Name}" class="td-input form-control" required> </td>
                <td   class="td-part-input"> <input type="text" value="${element.NetPriceHDS}" class="td-input form-control" required> </td>
                <td   class="td-part-input"> <input type="text" value="${element.NaghdPrice}" class="td-input form-control" required> </td>
                <td   class="td-part-input"> <input type="text" value="${element.KartPrice}" class="td-input form-control"> </td>
                <td   class="td-part-input"> <input type="text" value="${element.VarizPrice}" class="td-input form-control"> </td>
                <td   class="td-part-input"> <input type="text" value="${element.TakhfifPriceBar}" class="td-input form-control"> </td>
                <td   class="td-part-input"> <input type="text" value="${element.DifPrice}" class="td-input form-control"> </td>
                <td   class="td-part-input"> <input type="text" value="${element.FactDesc}" class="td-input form-control"> </td>
                <td   class="td-part-input"> <input type="text" value="${element.OtherAddress}" class="td-input form-control"> </td>
                <td   class="td-part-input"> <input type="text" value="${element.PhoneStr}" class="td-input form-control"> </td>
            </tr>`);
        }
        });
    //for adding factors to Bargiri
    $.get(baseUrl+"/addFactorToBargiri",{allFactors:selectFactorsSn},(respond,status)=>{
        console.log(respond)
    })
}

$("#selectAllFactorsForBarigiCheckbox").on("change",(respond,status)=>{
    if($("#selectAllFactorsForBarigiCheckbox").is(":checked")){
        $(".selectAllFactorToBargiri").prop("checked",true);
    }else{
        $(".selectAllFactorToBargiri").prop("checked",false);
    }
})

function selectFactorToBargiri(element){
$("tr").removeClass("selected");
$(element).addClass("selected");
$(element).find('input').prop("checked",true);
}

$("#bargiriPaperDate").persianDatepicker({
    cellWidth: 32,
    cellHeight: 22,
    fontSize: 14,
    formatDate: "YYYY/0M/0D",
    endDate: "1440/05/05",
});

let selectedRow = 0;
localStorage.setItem("scrollTop",0);
$(document).on("keydown",function(e){
    if (e.which === 40 || e.which === 38) {
        e.preventDefault();
        let tableBody=$("#factorTable");
        Mousetrap.bind('down', function (e) {
            var rowCount = $("#factorListBody tr:last").index() + 1;
            if (selectedRow >= 0) {
                $("#factorListBody tr").eq(selectedRow).css('background-color', 'rgb(232, 22, 144)');
            }
            if(selectedRow!=0){
                selectedRow = Math.min(selectedRow + 1, rowCount - 1); 
                $("#factorListBody tr").eq(selectedRow).css('background-color', "rgb(0,142,201)"); 
            }else{
                selectedRow = Math.min(1, rowCount - 1); 
                $("#factorListBody tr").eq(selectedRow).css('background-color', "rgb(0,142,201)"); 
            }
            selectFactorForBargiri(133,$("#factorListBody tr").eq(selectedRow));
            let topTr = $("#factorListBody tr").eq(selectedRow).position().top;
            let bottomTr =topTr+50;
            let trHieght =50;
            if(topTr > 0 && bottomTr < 450){
            }else{
                let newScrollTop =trHieght+ parseInt(localStorage.getItem("scrollTop"));
                tableBody.scrollTop(parseInt(newScrollTop));
                localStorage.setItem("scrollTop",newScrollTop);
            }
        });

        Mousetrap.bind('up', function (e) {
            if (selectedRow >= 0) {
                $("#factorListBody tr").eq(selectedRow).css('background-color','rgb(232, 22, 144)');
            }
            selectedRow = Math.max(selectedRow - 1, 0); 
            $("#factorListBody tr").eq(selectedRow).css('background-color', 'rgb(0,142,201)'); 
            selectFactorForBargiri(123,$("#factorListBody tr").eq(selectedRow));
            let topTr = $("#factorListBody tr").eq(selectedRow).position().top;
            let bottomTr =topTr+parseInt($("#factorListBody tr").eq(selectedRow).height());
            let trHieght =50;
            if(topTr >117 && bottomTr < 450){
            }else{
                let newScrollTop = parseInt(localStorage.getItem("scrollTop"))-(trHieght);
                tableBody.scrollTop(parseInt(newScrollTop));
                localStorage.setItem("scrollTop",newScrollTop);
            }
        });

        Mousetrap.bind("enter",()=>{
            $("#searchCustomerSabtBtn").trigger("click");
            localStorage.setItem("scrollTop",0);
        });
    }
})
  
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

