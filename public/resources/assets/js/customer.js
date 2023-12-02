var baseUrl = "http://192.168.10.26:8080";
function renewCustomerGardish(){
    let psn=document.querySelector("#customerIdGardish").value;
    let firstDate=document.querySelector("#firstDateCustomerGardish").value;
    let secondDate=document.querySelector("#secondDateCustomerGardish").value;
    $.get(baseUrl+"/getCustomerGardish",{psn:psn,firstDate:firstDate,secondDate:secondDate},function(respond,status){
        
        $("#customerGardishListBody").empty();
        
        respond.customerGardish.forEach((element,index)=>{
            let trClass="";
            switch (element.state) {
                case "4":
                    trClass="daryaft"
                    break;
                case "5":
                    trClass="pardakht"
                    break;
                case "1":
                    trClass="sales"
                    break;
                case "7":
                        trClass="buy"
                        break;
            }
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
            let NetPriceHDS=0;
            if(element.NetPriceHDS>0){
                NetPriceHDS=element.NetPriceHDS;
            }
            let amountUnit=0;
            if(element.AmountUnit>0){
                amountUnit=element.AmountUnit;
            }
            let fi=0;
            if(element.Fi>0){
                fi=element.Fi;
            }
            $("#customerGardishListBody").append(`
                 <tr class="${trClass}">
                    <td class="customerCirculation-1"> ${element.DocDate}  </td>
                    <td class="customerCirculation-1 RizAsnad"> ${element.GoodCde||''}  </td>
                    <td class="customerCirculation-2"> ${element.FactDesc} </td>
                    <td class="customerCirculation-2 RizAsnad"> ${element.GoodUnit} </td>
                    <td class="customerCirculation-2 RizAsnad"> ${parseInt(amountUnit).toLocaleString("en-us")} </td>
                    <td class="customerCirculation-2 RizAsnad"> ${parseInt(fi).toLocaleString("en-us")} </td>
                    <td class="customerCirculation-2 RizAsnad"> ${''} </td>
                    <td class="customerCirculation-2"> ${parseInt(NetPriceHDS).toLocaleString("en-us")} </td>
                    <td class="customerCirculation-3"> ${element.tasviyeh} </td>
                    <td class="customerCirculation-4"> ${bestankar>0?parseInt(bestankar).toLocaleString("en-us"):''} </td>
                    <td class="customerCirculation-5"> ${bedehkar>0?parseInt(bedehkar).toLocaleString("en-us"):''} </td>
                    <td class="customerCirculation-6"> ${element.bdbsState=='bidehkar' ? 'بد' : (element.bdbsState=='bidstankar' ? 'بس':(element.bdbsState=='tasviyah'? '--':''))} </td>
                    <td class="customerCirculation-7 d-none"> ${element.StatusHDS} </td>
                    <td class="customerCirculation-7"> ${remain!=1?parseInt(remain).toLocaleString('en-us'):''} </td>
                </tr>`);
                makeTableColumnsResizable("customerCirculationTable")
            });

            let salesListCheckBox=document.querySelector("#rizAsnadFroshCheckBox") ;
            let buyListCheckBox=document.querySelector("#rizAsnadKharidCheckBox") ;
            let getListCheckBox=document.querySelector("#rizAsnadDaryaftCheckBox");
            let payListCheckBox=document.querySelector("#rizAsnadPardakhtCheckBox");
            if(getListCheckBox.checked){
                const trDetails=document.querySelectorAll(".daryaft");
                for (let index = 0; index < trDetails.length; index++) {
                    trDetails[index].style.setProperty('display', '', 'important');
                }
            }else{
                const trDetails=document.querySelectorAll(".daryaft");
                for (let index = 0; index < trDetails.length; index++) {
                    trDetails[index].style.setProperty('display', 'none', 'important');
                }
            }
            if(payListCheckBox.checked){
                const trDetails=document.querySelectorAll(".pardakht");
                for (let index = 0; index < trDetails.length; index++) {
                    trDetails[index].style.setProperty('display', '', 'important');
                }
            }else{
                const trDetails=document.querySelectorAll(".pardakht");
                for (let index = 0; index < trDetails.length; index++) {
                    trDetails[index].style.setProperty('display', 'none', 'important');
                }
            }

            if(salesListCheckBox.checked){
                const tdList = document.querySelectorAll('td.RizAsnad');
                const thList =document.querySelectorAll('th.RizAsnad');
                const trDetails=document.querySelectorAll(".sales");
                for (let index = 0; index < trDetails.length; index++) {
                    trDetails[index].style.setProperty('display', '', 'important');
                }
                for (let i = 0; i < thList.length; i++) {
                    thList[i].style.setProperty('display', '', 'important');
                }

                for (let i = 0; i < tdList.length; i++) {
                    tdList[i].style.setProperty('display', '', 'important');
                }
            }else{
                const tdList = document.querySelectorAll('td.RizAsnad');
                const thList =document.querySelectorAll('th.RizAsnad');
                const trDetails=document.querySelectorAll(".sales");
                for (let index = 0; index < trDetails.length; index++) {
                    trDetails[index].style.setProperty('display', 'none', 'important');
                }
                for (let i = 0; i < thList.length; i++) {
                    thList[i].style.setProperty('display', 'none', 'important');
                }

                for (let i = 0; i < tdList.length; i++) {
                    tdList[i].style.setProperty('display', 'none', 'important');
                }
            }

            if(buyListCheckBox.checked){
                const tdList = document.querySelectorAll('td.RizAsnad');
                const thList =document.querySelectorAll('th.RizAsnad');
                const trDetails=document.querySelectorAll(".buy");
                for (let index = 0; index < trDetails.length; index++) {
                    trDetails[index].style.setProperty('display', '', 'important');
                }
                for (let i = 0; i < thList.length; i++) {
                    thList[i].style.setProperty('display', '', 'important');
                }

                for (let i = 0; i < tdList.length; i++) {
                    tdList[i].style.setProperty('display', '', 'important');
                }
            }else{
                const tdList = document.querySelectorAll('td.RizAsnad');
                const thList =document.querySelectorAll('th.RizAsnad');
                const trDetails=document.querySelectorAll(".buy");
                for (let index = 0; index < trDetails.length; index++) {
                    trDetails[index].style.setProperty('display', 'none', 'important');
                }
                for (let i = 0; i < thList.length; i++) {
                    thList[i].style.setProperty('display', 'none', 'important');
                }

                for (let i = 0; i < tdList.length; i++) {
                    tdList[i].style.setProperty('display', 'none', 'important');
                }
            }
    })
}

function openCustomerGardishModal(psn){

    $.get(baseUrl+"/getCustomerByID",{PSN:psn},(respond,status)=>{ 

        document.querySelector("#customerIdGardish").value=respond[0].PSN;

        document.querySelector("#customerNameGardish").value=respond[0].Name;
        document.querySelector("#customerCodeGardish").value=respond[0].PCode;
    })
    renewCustomerGardish(psn);
    $("#customerGardishModal").modal("show");
    
}


$("#closeCustomerGardishModalBtn").on("click",function(){
    
    $("#customerGardishModal").modal("hide");
});


$("#firstDateCustomerGardish").persianDatepicker({
    cellWidth: 32,
    cellHeight: 22,
    fontSize: 14,
    formatDate: "YYYY/0M/0D",
    endDate: "1440/5/5",
});

$("#secondDateCustomerGardish").persianDatepicker({
    cellWidth: 32,
    cellHeight: 22,
    fontSize: 14,
    formatDate: "YYYY/0M/0D",
    endDate: "1440/5/5",
});