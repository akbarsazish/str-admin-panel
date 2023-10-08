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
alert(snFactor)
    $.get(baseUrl+"/getFactorInfoForEdit",{SnFactor:snFactor},(respond,status)=>{
        $("#factorEditListBody").empty();
        respond.forEach((element,index)=>{
            $("#factorEditListBody").append(`
                <tr class="factorTablRow">
                    <td class="td-part-input"> ${index+1} </td>
                    <td class="td-part-input"> <input type="text" value="${element.GoodCde}" class="td-input form-control" required> </td>
                    <td class="td-part-input"> <input type="text" value="${element.NameGood}" class="td-input form-control" required> </td>
                    <td class="td-part-input"> <input type="text" value="${element.FirstUnit}" class="td-input form-control" required> </td>
                    <td class="td-part-input"> <input type="text" value="${element.SecondUnit}" class="td-input form-control" required> </td>
                    <td class="td-part-input"> <input type="text" value="${element.PackAmnt}" class="td-input form-control" required> </td>
                    <td class="td-part-input"> <input type="text" value="${element.Amount%element.AmountUnit}" class="td-input form-control" required> </td>
                    <td class="td-part-input"> <input type="text" value="${element.FirstAmout}" class="td-input form-control" required> </td>
                    <td class="td-part-input"> <input type="text" value="${element.ReAmount}" class="td-input form-control" required> </td>
                    <td class="td-part-input"> <input type="text" value="${element.Amount}" class="td-input form-control" required> </td>
                    <td class="td-part-input"> <input type="text" value="${element.Fi}" class="td-input form-control" required> </td>
                    <td class="td-part-input"> <input type="text" value="${element.FiPack}" class="td-input form-control" required> </td>
                    <td class="td-part-input"> <input type="text" value="${element.Price}" class="td-input form-control" required> </td>
                    <td class="td-part-input"> <input type="text" value="${element.PriceAfterTakhfif}" class="td-input form-control" required> </td>
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