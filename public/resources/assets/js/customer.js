
var baseUrl = "http://192.168.10.21:8000";
function renewCustomerGardish(){
    let psn=document.querySelector("#customerIdGardish").value;
    let firstDate=document.querySelector("#firstDateCustomerGardish").value;
    let secondDate=document.querySelector("#secondDateCustomerGardish").value;
    let fiscalYear=document.querySelector("#fiscalYearCustomerGardish").value;
    $.get(baseUrl+"/getCustomerGardish",{psn:psn,firstDate:firstDate,secondDate:secondDate,fiscalYear:fiscalYear},function(respond,status){
        
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
                    <td class="customerCirculation-2 RizAsnad"> ${element.GoodCde||''}  </td>
                    <td class="customerCirculation-3"> ${element.FactDesc} </td>
                    <td class="customerCirculation-4 RizAsnad"> ${element.GoodUnit} </td>
                    <td class="customerCirculation-5 RizAsnad"> ${parseInt(amountUnit).toLocaleString("en-us")} </td>
                    <td class="customerCirculation-6 RizAsnad"> ${parseInt(fi).toLocaleString("en-us")} </td>
                    <td class="customerCirculation-7 RizAsnad"> ${''} </td>
                    <td class="customerCirculation-8"> ${parseInt(NetPriceHDS).toLocaleString("en-us")} </td>
                    <td class="customerCirculation-9"> ${element.tasviyeh} </td>
                    <td class="customerCirculation-10"> ${bestankar>0?parseInt(bestankar).toLocaleString("en-us"):''} </td>
                    <td class="customerCirculation-11"> ${bedehkar>0?parseInt(bedehkar).toLocaleString("en-us"):''} </td>
                    <td class="customerCirculation-12"> ${element.bdbsState=='bidehkar' ? 'بد' : (element.bdbsState=='bidstankar' ? 'بس':(element.bdbsState=='tasviyah'? '--':''))} </td>
                    <td class="customerCirculation-13 d-none"> ${element.StatusHDS} </td>
                    <td class="customerCirculation-14"> ${remain!=1?parseInt(remain).toLocaleString('en-us'):''} </td>
                </tr>`);
                makeTableColumnsResizable("customerCirculationTable")
            });

            let salesListCheckBox=document.querySelector("#rizAsnadFroshCheckBox") ;
            let buyListCheckBox=document.querySelector("#rizAsnadKharidCheckBox") ;
            let getListCheckBox=document.querySelector("#rizAsnadDaryaftCheckBox");
            let payListCheckBox=document.querySelector("#rizAsnadPardakhtCheckBox");
            if(getListCheckBox.checked){
                const trDetails=document.querySelectorAll(".daryaft");
                if(trDetails.length>0){
                    for (let index = 0; index < trDetails.length; index++) {
                        trDetails[index].style.setProperty('display', '', 'important');
                    }
                }
            }else{
                const trDetails=document.querySelectorAll(".daryaft");
                if(trDetails.length>0){
                    for (let index = 0; index < trDetails.length; index++) {
                        trDetails[index].style.setProperty('display', 'none', 'important');
                    }
                }

            }
            if(payListCheckBox.checked){
                const trDetails=document.querySelectorAll(".pardakht");
                if(trDetails.length>0){
                    for (let index = 0; index < trDetails.length; index++) {
                        trDetails[index].style.setProperty('display', '', 'important');
                    }
                }
            }else{
                const trDetails=document.querySelectorAll(".pardakht");
                if(trDetails.length>0){
                    for (let index = 0; index < trDetails.length; index++) {
                        trDetails[index].style.setProperty('display', 'none', 'important');
                    }
                }
            }

            if(salesListCheckBox.checked){
                const trDetails=document.querySelectorAll(".sales");
                const tdList =document.querySelectorAll('td.RizAsnad');
                for (let i = 0; i < tdList.length; i++) {
                    tdList[i].style.setProperty('display', '', 'important');
                }
                if(trDetails.length>0){
                    for (let index = 0; index < trDetails.length; index++) {
                        trDetails[index].style.setProperty('display', '', 'important');
                    }
                }
            }else{
                const trDetails=document.querySelectorAll(".sales");
                const tdList =document.querySelectorAll('td.RizAsnad');
                for (let i = 0; i < tdList.length; i++) {
                    tdList[i].style.setProperty('display', '', 'important');
                }
                for (let index = 0; index < trDetails.length; index++) {
                    trDetails[index].style.setProperty('display', 'none', 'important');
                }
            }

            if(buyListCheckBox.checked){
                const trDetails=document.querySelectorAll(".buy");
                const tdList =document.querySelectorAll('td.RizAsnad');
                for (let i = 0; i < tdList.length; i++) {
                    tdList[i].style.setProperty('display', '', 'important');
                }
                for (let index = 0; index < trDetails.length; index++) {
                    trDetails[index].style.setProperty('display', '', 'important');
                }
            }else{
                const trDetails=document.querySelectorAll(".buy");
                const tdList =document.querySelectorAll('td.RizAsnad');
                for (let i = 0; i < tdList.length; i++) {
                    tdList[i].style.setProperty('display', '', 'important');
                }
                for (let index = 0; index < trDetails.length; index++) {
                    trDetails[index].style.setProperty('display', 'none', 'important');
                }
            }

            if(buyListCheckBox.checked || salesListCheckBox.checked){
                const thList =document.querySelectorAll('th.RizAsnad');
                const tdList =document.querySelectorAll('td.RizAsnad');
                for (let i = 0; i < thList.length; i++) {
                    thList[i].style.setProperty('display', '', 'important');
                }
                for (let i = 0; i < tdList.length; i++) {
                    tdList[i].style.setProperty('display', '', 'important');
                }
            }else{
                const thList =document.querySelectorAll('th.RizAsnad');
                const tdList =document.querySelectorAll('td.RizAsnad');

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

    fetch(baseUrl+"/getFiscalYears")
    .then(response => {
      if (!response.ok) {
        throw new Error(`HTTP error! Status: ${response.status}`);
      }
      return response.json();
    })
    .then((fiscalYearList) => {
        let selectYear=document.querySelector("#fiscalYearCustomerGardish");
        selectYear.innerHTML='';
        for (const element of fiscalYearList) {
            const option = document.createElement('option');
            option.selected=true;
            option.value = element.FiscalYear; // Set the value attribute
            option.text = element.FiscalYear;  // Set the text content
            selectYear.appendChild(option);
        }
    })
    .catch(error => {
      // Handle errors
      console.error('Error:', error);
    });

    $.get(baseUrl+"/getCustomerByID",{PSN:psn},(respond,status)=>{ 
        document.querySelector("#customerIdGardish").value=respond[0].PSN;
        document.querySelector("#customerNameGardish").value=respond[0].Name;
        document.querySelector("#customerCodeGardish").value=respond[0].PCode;
        renewCustomerGardish(psn);
        $("#customerGardishModal").modal("show");
    })
    
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