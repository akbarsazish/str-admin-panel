
//const baseUrl:string = 'http://192.168.10.26:8080';

const accSelects=document.querySelectorAll(".accSn");
if(accSelects){
    accSelects.forEach(element => {
        const accSelect:HTMLSelectElement=element as HTMLSelectElement;
        accSelect.innerHTML="";
        accSelect.add(new Option(" ", ''));
        fetch(baseUrl+'/allBanks', {
            method: 'GET'
        })
       .then(response=>response.json())
       .then(data=>{
        data.bankKarts.forEach(bank=>{
            const option = document.createElement("option");
            option.text = bank.bsn;
            option.value = String(bank.SerialNoAcc);
            accSelect.add(option);
        })
       })
    });
}

function changeHisabNo(element:HTMLSelectElement,hisabNoId:string){
    const hisabNoInput:HTMLInputElement=document.getElementById(hisabNoId) as HTMLInputElement;
    let hisabSN:number=Number(element.value);
    let url=new URLSearchParams();
    url.append("bankSn",String(hisabSN));
    fetch(baseUrl+`/getBankInfo?${url.toString()}`, {
        method: 'GET',
      }).then(response=>{
        return response.json();
    }).then(respond=>{
        hisabNoInput.value=String(respond[0].AccNo);
    })
}
const paynetPriceHDSAdd=document.getElementById("paynetPriceHDSAdd") as HTMLInputElement;
function addNaghdMoneyPayAdd(){
    const monyInput: HTMLInputElement = document.getElementById("rialNaghdPayAddInputAdd") as HTMLInputElement;
    const money: number = Number(monyInput.value);
    const naghdMoneyDescriptionInput: HTMLInputElement = document.getElementById("descNaghdPayAddInputAdd") as HTMLInputElement;
    const description: string = naghdMoneyDescriptionInput.value;
    const payBys = new PayBys(1,0,description,money,0,0,'',0,'',0,0,0,0,0,0,0,0,0,0,'','',0,0);
    payBys.addPayBys();
    closeAddPayPartAddModal('addPayVajhNaghdAddModal');
    paynetPriceHDSAdd.value = String(Number(paynetPriceHDSAdd.value)+money);
}

function openAddPayPartAddModal(modalId: string) {
    const modal = document.getElementById(modalId) as HTMLElement;
    modal.style.display = "block";
    if(modalId=='addPayChequeInfoAddModal'){
       const customerNamePayHDSInput=document.getElementById('customerNamePayInput') as HTMLInputElement ;
       const inVajhChequeNameInput=document.getElementById('inVajhChequeInputAddPayAdd') as HTMLInputElement ;
       inVajhChequeNameInput.value=customerNamePayHDSInput.value;
       const customerIdPayHDSInput=document.getElementById('customerIdPayInput') as HTMLInputElement ;
       const inVajhChequePSN=document.getElementById('inVajhChequePSNInputAddPayAdd') as HTMLInputElement ;
       inVajhChequePSN.value=customerIdPayHDSInput.value;
    }

    if(modalId=='AddPayHawalaFromBoxAddModal'){
        const bankNameSelect: HTMLSelectElement = document.getElementById("addHawalaFromBoxAddBankNameInput") as HTMLSelectElement;
        bankNameSelect.innerHTML='';
        fetch(baseUrl+'/getBankList', {
            method: 'GET'
        })
       .then(response=>response.json())
       .then(data=>{
        data.forEach(bank=>{
            const option = document.createElement("option");
            option.text = bank.NameBsn;
            option.value = String(bank.SerialNoBSN);
            bankNameSelect.add(option);
        })
       })
    }
    if(modalId=='AddPayHawalaFromBankAddModal'){
       const bankNameSelect: HTMLSelectElement = document.getElementById("addPayHawalaFromBankAddBankName") as HTMLSelectElement;
       bankNameSelect.innerHTML='';
       bankNameSelect.add(new Option('',''));
       fetch(baseUrl+'/getBankList', {
            method: 'GET'
        })
       .then(response=>response.json())
       .then(data=>{
        data.forEach(bank=>{
            const option = document.createElement("option");
            option.text = bank.NameBsn;
            option.value = String(bank.SerialNoBSN);
            bankNameSelect.add(option);
        })
       })

    }
}

function closeAddPayPartAddModal(modalId: string) {
    const modal = document.getElementById(modalId) as HTMLElement;
    modal.style.display = "none";
}

function closeEditPayPartEditModal(modalId: string){
    const modal = document.getElementById(modalId) as HTMLElement;
    modal.style.display = "none";
}

function openPaysModal(modalId: string) {
    const modal = document.getElementById(modalId) as HTMLElement;
    modal.style.display = "block";
    const selectBox=document.getElementById('boxPaysSelect') as HTMLSelectElement;
    let boxSn:number=Number(selectBox.value);
    const boxIdPayInput=document.getElementById('boxIdPayInput') as HTMLInputElement ;
    boxIdPayInput.value=String(boxSn);
    const boxModal=document.getElementById('selectBoxPaysModal') as HTMLElement;
    if(boxModal){
        boxModal.style.display = "none";
    }
}



function addPayHawalaFromBankAdd(){
    const addPayHawalaFromBankAddInputInfoInput:HTMLInputElement=document.getElementById("addPayHawalaFromBankAddInputInfo") as HTMLInputElement;
    const addPayHawalaFromBankAddSelectHisabSnInput:HTMLSelectElement=document.getElementById("addPayHawalaFromBankAddSelectHisabSn") as HTMLSelectElement;
    const addPayHawalaFromBankAddHawalaNoInput:HTMLInputElement=document.getElementById("addPayHawalaFromBankAddHawalaNo") as HTMLInputElement;
    const addPayHawalaFromBankAddHawalaDateInput:HTMLInputElement=document.getElementById("addPayHawalaFromBankAddHawalaDate") as HTMLInputElement;
    const addPayHawalaFromBankAddHawalaHisabNoInput:HTMLInputElement=document.getElementById("addPayHawalaFromBankAddHawalaHisabNo") as HTMLInputElement;
    const addPayHawalaFromBankAddBankNameInput:HTMLInputElement=document.getElementById("addPayHawalaFromBankAddBankName") as HTMLInputElement;
    const addPayHawalaFromBankAddMalikHisabNameInput:HTMLInputElement=document.getElementById("addPayHawalaFromBankAddMalikHisabName") as HTMLInputElement;
    const addPayHawalaFromBankAddShobeSnInput:HTMLInputElement=document.getElementById("addPayHawalaFromBankAddShobeSn") as HTMLInputElement;
    const addPayHawalaFromBankAddDescInput:HTMLInputElement=document.getElementById("addPayHawalaFromBankAddDesc") as HTMLInputElement;
    const addHawalaFromBankAddMoneyInput:HTMLInputElement=document.getElementById("addHawalaFromBankAddMoneyInput") as HTMLInputElement;
    const addHawalaFromBankAddKarmozdInput:HTMLInputElement=document.getElementById("addHawalaFromBankAddKarmozdInput") as HTMLInputElement;

    const addPayHawalaFromBankAddInputInfo:number=Number(addPayHawalaFromBankAddInputInfoInput.value);
    const bankHisabSn:number=Number(addPayHawalaFromBankAddSelectHisabSnInput.value);
    const hawalaNo:Number=Number(addPayHawalaFromBankAddHawalaNoInput.value);
    const hawalaDate:String=String(addPayHawalaFromBankAddHawalaDateInput.value);
    const hisabNo:String=String(addPayHawalaFromBankAddHawalaHisabNoInput.value);
    const snBank:Number=Number(addPayHawalaFromBankAddBankNameInput.value);
    const malikName:string=String(addPayHawalaFromBankAddMalikHisabNameInput.value);
    const addShobeName:String=String(addPayHawalaFromBankAddShobeSnInput.value);
    const description:string=String(addPayHawalaFromBankAddDescInput.value);
    const money:number=Number(addHawalaFromBankAddMoneyInput.value);
    const karmozd:number=Number(addHawalaFromBankAddKarmozdInput.value);
    const payBys = new PayBys(3,0,description,money,0,0,hawalaDate,0,hisabNo,snBank,0,bankHisabSn,0,0,0,0,0,0,karmozd,addShobeName,malikName,hawalaNo,0);
    payBys.addPayBys();
    closeAddPayPartAddModal('AddPayHawalaFromBankAddModal');
    paynetPriceHDSAdd.value = String(Number(paynetPriceHDSAdd.value)+money);
}

function addTakhfifAddPayAdd(){
    const takhfifMoneyInputAddPayAdd:HTMLInputElement=document.getElementById("takhfifMoneyInputAddPayAdd") as HTMLInputElement;
    const money:number=Number(takhfifMoneyInputAddPayAdd.value);
    const discriptionTakhfifInputAddPayAdd:HTMLInputElement=document.getElementById("discriptionTakhfifInputAddPayAdd") as HTMLInputElement;
    const descTakhfif:string=discriptionTakhfifInputAddPayAdd.value;
    const payBys = new PayBys(4,0,descTakhfif,money,0,0,'',0,'',0,0,0,0,0,0,0,0,0,0,'','',0,0);
    payBys.addPayBys();
    closeAddPayPartAddModal('AddPayTakhfifAddModal');
    paynetPriceHDSAdd.value = String(Number(paynetPriceHDSAdd.value)+money);
}


function deletePayBys(payBysIndex: number){
    let rowIndex:number=Number(payBysIndex);
    let payBys: PayBys = new PayBys(0,rowIndex,'',0,0,0,'',0,'',0,0,0,0,0,0,0,0,0,0,'','',0,0);
    
    swal({
        text:'می خواهید این پرداخت را حذف کنید؟',
        buttons: ['cancel', 'delete'],
        dangerMode: true,
        icon: 'warning'
    }).then((willDelete) => {
        if (willDelete) {
            payBys.deletePayBys(rowIndex);
        }
    });
}
function deletePayBysEditEdit(payBysIndex:number){
    
    let rowIndex:number=Number(payBysIndex);
    let payBys: PayBys = new PayBys(0,rowIndex,'',0,0,0,'',0,'',0,0,0,0,0,0,0,0,0,0,'','',0,0);
    
    swal({
        text:'می خواهید این پرداخت را حذف کنید؟',
        buttons: ['cancel', 'delete'],
        dangerMode: true,
        icon: 'warning'
    }).then((willDelete) => {
        if (willDelete) {
            payBys.deletePayBysEdit(rowIndex);
        }
    });
}

function addChequeBtnAddPayAdd(){

}

function setAddedPayBysStuff(tableRow: HTMLTableRowElement, type: number){
    let editPayBYSButton: HTMLButtonElement = document.getElementById("editPayBYSButton") as HTMLButtonElement;
    let deletePayBys: HTMLButtonElement = document.getElementById("deletePayBysButton") as HTMLButtonElement;
    editPayBYSButton.value=`${type}`;
    const tbody = document.querySelector('#paysAddTableBody');
    if (tbody) {
        const rows = tbody.querySelectorAll('tr');
        rows.forEach(row => {
            row.classList.remove('selected');
        });
    }
    tableRow.classList.add("selected");
    if(tbody){
        const rows = tbody.querySelectorAll('tr');
        const index = Array.from(rows).indexOf(tableRow);
        deletePayBys.setAttribute('value', `${index}`);
    }
}

function openSelectedBysModal(type:number){
    let typeNumber: number = Number(type);
    const selectedElements = document.querySelectorAll('.selected');
    const selectedRow = selectedElements[0];
    const rowData = selectedRow.querySelectorAll('td');
    switch (typeNumber) {
        case 1:
            {// نقدی
                const monyInput:HTMLInputElement=document.getElementById("rialNaghdPayAddInputEdit") as HTMLInputElement;
                const descInput:HTMLInputElement=document.getElementById("descNaghdPayAddInputEdit") as HTMLInputElement;
                console.log(rowData)
                rowData.forEach((td,index)=>{
                    if(td.children.item(0)){
                        switch (index) {
                            case 19:
                                {
                                    monyInput.value=String(td.children.item(0)?.getAttribute('value'));
                                }
                                break;
                                
                            case 13:
                                descInput.value=String(td.children.item(0)?.getAttribute('value'));
                                break;
                        }

                    }
                })
                openAddPayVajhNaghdEditModal()
            }
            break;
        case 2:
            {//چک
                const chequeNumberInput: HTMLInputElement = document.getElementById("chequeNoCheqeInputAddPayEdit") as HTMLInputElement;
                const sarRasidInput: HTMLInputElement = document.getElementById("checkSarRasidDateInputAddPayEdit") as HTMLInputElement;
                const moneyChequeInput: HTMLInputElement = document.getElementById("moneyChequeInputAddPayEdit") as HTMLInputElement;
                const sayyadiNoChequeInputAddPayAdd:HTMLInputElement=document.getElementById("sayyadiNoChequeInputAddPayEdit") as HTMLInputElement;
                const docDescInput:HTMLInputElement=document.getElementById("inVajhChequeInputAddPayEdit") as HTMLInputElement;
                var accNo:number=0
                rowData.forEach((td,index)=>{
                    if(td.children.item(0)){
                        switch (index) {
                            case 10://
                            {
                                const hisabNoChequeInputAddPayAdd:HTMLSelectElement=document.getElementById("hisabNoChequeInputAddPayEdit") as HTMLSelectElement;
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
                                    const hisabNo:HTMLSelectElement=document.getElementById("hisabNoChequeInputAddPayEdit") as HTMLSelectElement;
                                    const radifInChequeBookSelect:HTMLSelectElement=document.getElementById("radifInChequeBookSelectAddPayEdit") as HTMLSelectElement;
                                    fetch(baseUrl+`/cheque/getChequesByAcc/${hisabNo}`).then(res=>{
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
                            // case 20:{

                            // }
                            // break;
                            
                            
                        }}
                    });
                    
                openAddPayChequeInfoEditModal()
            }
            break;
        case 3:
        {//حواله
            const addFromHisabNoEditInput:HTMLInputElement=document.getElementById("addFromHisabNoEditInput") as HTMLInputElement;
            const addFromHisabNoEditSelect:HTMLSelectElement=document.getElementById("addFromHisabNoEditSelect") as HTMLSelectElement;
            const addHawalaNoEditInput:HTMLInputElement=document.getElementById("addHawalaNoEditInput") as HTMLInputElement;
            const addHawalaDateEditInput:HTMLInputElement=document.getElementById("addHawalaDateEditInput") as HTMLInputElement;
            const addToHisabNoEditInput:HTMLInputElement=document.getElementById("addToHisabNoEditInput") as HTMLInputElement;
            const addToBankEditInput:HTMLInputElement=document.getElementById("addToBankEditInput") as HTMLInputElement;
            const addToHisabOwnerEditInput:HTMLInputElement=document.getElementById("addToHisabOwnerEditInput") as HTMLInputElement;
            const addToBankShobeEditInput:HTMLInputElement=document.getElementById("addToBankShobeEditInput") as HTMLInputElement;
            const addDescEditInput:HTMLInputElement=document.getElementById("addDescEditInput") as HTMLInputElement;
            const addHawalaFromBankMoneyInput:HTMLInputElement=document.getElementById("addHawalaFromBankMoneyInput") as HTMLInputElement;
            const addHawalaFromBankKarmozdInput:HTMLInputElement=document.getElementById("addHawalaFromBankKarmozdInput") as HTMLInputElement;
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
                        case 21:
                            addToHisabOwnerEditInput.value=String(td.children.item(0)?.getAttribute('value'));
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
        }
            openAddPayHawalaFromBankEditModal()
            break;
        case 4:
            {//تخفیف
                const takhfifInput=document.getElementById("takhfifMoneyInputAddPayEdit") as HTMLInputElement;
                const discriptionInput=document.getElementById("discriptionTakhfifInputAddPayEdit") as HTMLInputElement;
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
                openAddPayTakhfifEditModal()
            }
            break;
        case 5:
            {//حواله از صندوق
                const hawalaNoInput=document.getElementById("addHawalaFromBoxHawalaNoEditInput") as HTMLInputElement;
                const hawalaDateInput=document.getElementById("addHawalaFromBoxDateEditInput") as HTMLInputElement;
                const moneyInput=document.getElementById("addHawalaFromBoxMoneyInput") as HTMLInputElement;
                const karmozdInput=document.getElementById("addHawalaFromBoxKarmozdInput") as HTMLInputElement;
                const hisabNoInput=document.getElementById("addHawalaFromBoxHisabNoInput") as HTMLInputElement;
                const hisabOwnerInput=document.getElementById("addHawalaFromBoxOwnerNameInput") as HTMLInputElement;
                const bankInput=document.getElementById("addHawalaFromBoxBankSnInput") as HTMLInputElement;
                const descInput=document.getElementById("addHawalaFromBoxDescInput") as HTMLInputElement;
                const bankShobeInput=document.getElementById("addHawalaFromBoxBranchNameInput") as HTMLInputElement;
                rowData.forEach((td,index)=>{
                    if(td.children.item(0)){
                        switch (index) {
                            case 22://
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
                openAddPayHawalaFromBoxEditModal();
            }
        break;
    }
}



const hisabNoChequeInputEditPayEditInput=document.getElementById("hisabNoChequeInputAddEditPayEdit") as HTMLInputElement;
const radifInChequeBookSelectAddEditPayEdit=document.getElementById("radifInChequeBookSelectAddEditPayEdit") as HTMLSelectElement;
const startChequeNumberAddEditEdit=document.getElementById("startChequeNumberAddEditEdit") as HTMLElement;
const endChequeNumberAddEditEdit=document.getElementById("endChequeNumberAddEditEdit") as HTMLElement;
if(radifInChequeBookSelectAddEditPayEdit){
    
    radifInChequeBookSelectAddEditPayEdit.addEventListener("change",()=>{
        chequeBookSelectAddPayAddInput.innerHTML='';
        fetch(baseUrl+`/cheque/getChequesByAcc/${hisabNoChequeInputEditPayEditInput.value}`,{
            method:'GET',
        }).then(res=>{
            return res.json();
        }).then(data=>{
            data.forEach((element) => {
                startChequeNumberAddEditEdit.textContent=String(element.FirstSerialNo);
                endChequeNumberAddEditEdit.textContent=String(element.EndSerialNo);
                const option = document.createElement("option");
                option.text = element.ChequeBookName;
                option.value = String(element.SnChequeBook);
                chequeBookSelectAddPayAddInput.add(option);
            });
        })
    })
}

const hisabNoChequeInputAddEditPayEditInput=document.getElementById("hisabNoChequeInputAddEditPayEdit") as HTMLInputElement;
const chequeBookSelectAddEditPayEditInput=document.getElementById("radifInChequeBookSelectAddEditPayEdit") as HTMLSelectElement;
const startChequeNumberAddEditEditEdit=document.getElementById("startChequeNumberAddEditEdit") as HTMLElement;
const endChequeNumberAddEditEditEdit=document.getElementById("endChequeNumberAddEditEdit") as HTMLElement;
if(hisabNoChequeInputAddEditPayEditInput){
    hisabNoChequeInputAddEditPayEditInput.addEventListener("change",()=>{
        chequeBookSelectAddEditPayEditInput.innerHTML='';
        fetch(baseUrl+`/cheque/getChequesByAcc/${hisabNoChequeInputAddEditPayEditInput.value}`,{
            method:'GET',
        }).then(res=>{
            return res.json();
        }).then(data=>{
            data.forEach((element) => {
                startChequeNumberAddEditEditEdit.textContent=String(element.FirstSerialNo);
                endChequeNumberAddEditEditEdit.textContent=String(element.EndSerialNo);
                const option = document.createElement("option");
                option.text = element.ChequeBookName;
                option.value = String(element.SnChequeBook);
                chequeBookSelectAddEditPayEditInput.add(option);
            });
        })
    })
}


function changeChequeHisabNo(hisabNoInput:HTMLInputElement,chequeSelectId:string,startCheqNoId:string,endChequeNoId:string){
    //alert("Good")
    const hisabNoChequeInputAddPayAddInput=hisabNoInput;
    const chequeBookSelectAddPayAddInput=document.getElementById(chequeSelectId) as HTMLSelectElement;
    const startChequeNumberAdd=document.getElementById(startCheqNoId) as HTMLElement;
    const endChequeNumberAdd=document.getElementById(endChequeNoId) as HTMLElement;
    chequeBookSelectAddPayAddInput.innerHTML='';
    fetch(baseUrl+`/cheque/getChequesByAcc/${hisabNoChequeInputAddPayAddInput.value}`,{
        method:'GET',
    }).then(res=>{
        return res.json();
    }).then(data=>{
        data.forEach((element) => {
            startChequeNumberAdd.textContent=String(element.FirstSerialNo);
            endChequeNumberAdd.textContent=String(element.EndSerialNo);
            const option = document.createElement("option");
            option.text = element.ChequeBookName;
            option.value = String(element.SnChequeBook);
            chequeBookSelectAddPayAddInput.add(option);
        });
    })
}

function chequeBookChange(chequeBookSelectAddPayAddInput:HTMLSelectElement,startInputId:string,endInputId:string){
    let startChequeSerial:HTMLElement=document.getElementById(startInputId) as HTMLElement;
    let endChequeSerial:HTMLElement=document.getElementById(endInputId) as HTMLElement;
    if(chequeBookSelectAddPayAddInput){
        chequeBookSelectAddPayAddInput.addEventListener("change",()=>{
            startChequeSerial.textContent='';
            endChequeSerial.textContent='';
            fetch(baseUrl+`/cheque/${chequeBookSelectAddPayAddInput.value}`,{
                method:'GET',
            }).then(res=>{
                return res.json();
            }).then(data=>{
                console.log(data);
                startChequeSerial.textContent=String(data.FirstSerialNo);
                endChequeSerial.textContent=String(data.EndSerialNo);
            })
        })
    }
}

function checkChequeNumber(element:HTMLInputElement,chequeSelecId:string,spanId:string){
        const chequeSnSelect:HTMLSelectElement=document.getElementById(chequeSelecId) as HTMLSelectElement;
        const spanAlert:HTMLElement=document.getElementById(spanId) as HTMLElement;
        let chequeNo:number=Number(element.value);
        let snCheque=chequeSnSelect.value;
        if(chequeNo>0){
            fetch(baseUrl+`/cheque/checkChequeNo/${snCheque}/${chequeNo}`).then(res=>res.json()).then(res=>{
            if(res.result=='Not Exist'){
                    spanAlert.textContent='کد شناسه چک یافت نشد';
            }
            if(res.result=='Exist'){
                    spanAlert.textContent='';
            }
            if(res.result=='Used'){
                    spanAlert.textContent='کد شناسه چک استفاده شده است';
            }
            })
        }else{
            spanAlert.textContent='';
        }
}

function addHawalaFromBoxAddPayAdd(){
    const hawalaNoInput:HTMLInputElement=document.getElementById("addHawalaFromBoxAddInputNumber") as HTMLInputElement;
    const deateInput:HTMLInputElement=document.getElementById("addHawalaFromBoxAddDateInput") as HTMLInputElement;
    const moneyInput:HTMLInputElement=document.getElementById("addHawalaFromBoxAddMoneyInput") as HTMLInputElement;
    const karmozdInput:HTMLInputElement=document.getElementById("addHawalaFromBoxAddKarmozdInput") as HTMLInputElement;
    const hisabNoInput:HTMLInputElement=document.getElementById("addHawalaFromBoxAddNumberHisabInput") as HTMLInputElement;
    const bankNameInput:HTMLInputElement=document.getElementById("addHawalaFromBoxAddBankNameInput") as HTMLInputElement;
    const branchNameInput:HTMLInputElement=document.getElementById("addHawalaFromBoxAddBranchSnInput") as HTMLInputElement;
    const addHawalaFromBoxAddDescInput:HTMLInputElement=document.getElementById("addHawalaFromBoxAddDescInput") as HTMLInputElement;
    const ownerNameInput:HTMLInputElement=document.getElementById("addHawalaFromBoxAddMalikNameInput") as HTMLInputElement;

    const hawalaNo:number=Number(hawalaNoInput.value);
    const hawalaDate:String=String(deateInput.value);
    const money:number=Number(moneyInput.value);
    const addHawalaFromBoxAddKarmozd:number=Number(karmozdInput.value);
    const hisabNo:String=String(hisabNoInput.value);
    const bankSn:Number=Number(bankNameInput.value);
    const branchName:String=String(branchNameInput.value);
    const description:string=String(addHawalaFromBoxAddDescInput.value);
    const ownerName:String=String(ownerNameInput.value);
    const payBys = new PayBys(3,0,description,money,0,0,hawalaDate,0,hisabNo,bankSn,0,0,0,0,0,0,0,0,addHawalaFromBoxAddKarmozd,branchName,ownerName,hawalaNo,0);
    payBys.addPayBys();
    closeAddPayPartAddModal('AddPayHawalaFromBoxAddModal');
    paynetPriceHDSAdd.value = String(Number(paynetPriceHDSAdd.value)+money);
}

function addChequePayAdd(){
    const chequeNumberInput: HTMLInputElement = document.getElementById("chequeNoCheqeInputAddPayAdd") as HTMLInputElement;
    const sarRasidInput: HTMLInputElement = document.getElementById("checkSarRasidDateInputAddPayAdd") as HTMLInputElement;
    const moneyChequeInputAddPayAdd: HTMLInputElement = document.getElementById("moneyChequeInputAddPayAdd") as HTMLInputElement;
    const hisabNoChequeInputAddPayAdd:HTMLInputElement=document.getElementById("hisabNoChequeInputAddPayAdd") as HTMLInputElement;
    const sayyadiNoChequeInputAddPayAdd:HTMLInputElement=document.getElementById("sayyadiNoChequeInputAddPayAdd") as HTMLInputElement;
    const radifInChequeBookSelect:HTMLSelectElement=document.getElementById("radifInChequeBookSelectAddPayAdd") as HTMLSelectElement;
    const inVajhChequeInputAddPayAdd:HTMLInputElement=document.getElementById("inVajhChequeInputAddPayAdd") as HTMLInputElement;
    const snChequeBook:number=Number(radifInChequeBookSelect.value);
    
    const chequeNumber:number=Number(chequeNumberInput.value);
    const sarRasidDate:String=String(sarRasidInput.value);
    const money:number=Number(moneyChequeInputAddPayAdd.value);
    const hisabNo:String=String(hisabNoChequeInputAddPayAdd.value);
    const sayyadiNo:number=Number(sayyadiNoChequeInputAddPayAdd.value);
    const radifInCheque=Number(radifInChequeBookSelect.value);
    const inVajhChequePerson:string=String(inVajhChequeInputAddPayAdd.value);
    
    const payBys = new PayBys(2,0,inVajhChequePerson,money,0,sayyadiNo,sarRasidDate,chequeNumber,hisabNo,0,snChequeBook,0,0,0,0,0,0,0,0,'','',0,0);
    payBys.addPayBys();
    closeAddPayPartAddModal('addPayChequeInfoAddModal');
    paynetPriceHDSAdd.value = String(Number(paynetPriceHDSAdd.value)+money);
}


class PayBys{
    payBYSType:number;
    payBYSIndex:number;
    payBYSDesc:string;
    payBYSMoney:number;
    payBYSRadifInChequeBook:number;
    sayyadiNoCheque:number;
    checkSarRasidDate:String;
    chequeNoCheqe:number;
    bankSn:Number;
    SnChequeBook:number;
    descBYS:string;
    snAccBank:number;
    noPayanehKartKhanBYS:number;
    snPeopelPay:number;
    repeateCheque:number;
    distanceMonthCheque:number;
    cashNo:number;
    SnMainPeopel:number;
    AccBankNo:String;
    Karmozd:number;
    BranchName:String;
    ownerName:String;
    hawalaNo:Number;
    SerialNoBYS:Number;
    constructor(payBYSType:number,payBYSIndex: number, payBYSDesc: string, payBYSMoney: number, payBYSRadifInChequeBook: number, sayyadiNoCheque: number
        ,checkSarRasidDate:String,chequeNoCheqe:number,accBankNo:String,
        bankSn:Number,SnChequeBook:number,snAccBank:number,noPayanehKartKhanBYS:number,
        snPeopelPay:number,repeateCheque:number,distanceMonthCheque:number,cashNo:number,inVajhPeopelSn:number,Karmozd:number,branchName:String,ownerName:String,hawalaNo:Number,serialNoBYS:Number){
        this.payBYSType = payBYSType;
        this.payBYSIndex = payBYSIndex;
        this.payBYSDesc = payBYSDesc;
        this.payBYSMoney = payBYSMoney;
        this.payBYSRadifInChequeBook = payBYSRadifInChequeBook;
        this.sayyadiNoCheque = sayyadiNoCheque;
        this.payBYSType = payBYSType;
        this.checkSarRasidDate=checkSarRasidDate;
        this.chequeNoCheqe=chequeNoCheqe;
        this.bankSn=bankSn;
        this.SnChequeBook=SnChequeBook;
        this.descBYS=payBYSDesc;
        this.snAccBank=snAccBank;
        this.noPayanehKartKhanBYS=noPayanehKartKhanBYS;
        this.snPeopelPay=snPeopelPay;
        this.repeateCheque=repeateCheque;
        this.distanceMonthCheque=distanceMonthCheque;
        this.cashNo=cashNo;
        this.SnMainPeopel=inVajhPeopelSn;
        this.AccBankNo=String(accBankNo);
        this.Karmozd=Karmozd;
        this.BranchName=String(branchName);
        this.ownerName=String(ownerName);
        this.hawalaNo=hawalaNo;
        this.SerialNoBYS=serialNoBYS;
    }

    addPayBys(){
        let tableBody : HTMLTableSectionElement = document.getElementById("paysAddTableBody") as HTMLTableSectionElement;
        let tableRow = document.createElement('tr');
        let rowNumber: number = tableBody.childElementCount;
        let modalTypeFlag=0;
        if(this.snAccBank==0 && this.payBYSType==3){
            modalTypeFlag=5
        }else{
            modalTypeFlag=this.payBYSType;
        }
        tableRow.setAttribute("onclick", `setAddedPayBysStuff(this,`+modalTypeFlag+`)`);
        for(let i = 0; i < 25; i++){
            const tableData = document.createElement('td');

            switch (i) {
                case 0:
                    {
                        tableData.setAttribute("class", "text-center");
                        tableData.innerText = `${rowNumber+1}`;

                    }
                    break;
                case 1:
                    {
                        tableData.setAttribute("class", "text-center");
                        tableData.innerText= `${this.payBYSDesc}`;
                    }
                    break;
                case 2:
                    {
                        tableData.setAttribute("class", "text-center");
                        tableData.innerText = `${this.payBYSMoney}`;
                    }
                    break;
                case 3:
                    {
                        tableData.setAttribute("class", "text-center");
                        tableData.innerText = ``;
                    }
                    break;
                case 4:
                    {
                        tableData.setAttribute("class", "text-center");
                        tableData.innerText = ``;
                    }
                    break;
                case 5:
                    {
                        tableData.setAttribute("class", "d-none");
                        tableData.innerHTML = `<input type="checkbox" checked class="form-check-input" value="${rowNumber}" name="BYSs[]"/>`;
                    }
                    break;
                case 6:
                    {
                        tableData.setAttribute("class", "d-none");
                        tableData.innerHTML = `<input type="text" class="form-check-input" value="${this.payBYSType}" name="BysType${rowNumber}"/>`;
                    }
                    break;
                case 7:
                    {
                        tableData.setAttribute("class", "d-none");
                        tableData.innerHTML = `<input type="text" value="${this.sayyadiNoCheque}" name="sayyadiNoCheque${rowNumber}"/>`;
                    }
                    break;
                case 8:
                    {

                        tableData.setAttribute("class", "d-none");
                        tableData.innerHTML = `<input type="text" value="${this.checkSarRasidDate}" name="checkSarRasidDate${rowNumber}"/>`;
                    }
                    break;
                case 9:
                    {
                        tableData.setAttribute("class", "d-none");
                        tableData.innerHTML = `<input type="text" value="${this.chequeNoCheqe}" name="chequeNoCheqe${rowNumber}"/>`;
                    }
                    break;
                case 10:
                    {
                        tableData.setAttribute("class", "d-none");
                        tableData.innerHTML = `<input type="text" value="${this.AccBankNo}" name="AccBankNo${rowNumber}"/>`;
                    }
                    break;
                    case 11:
                        {
                        tableData.setAttribute("class", "d-none");
                        tableData.innerHTML = `<input type="text" value="${this.bankSn}" name="SnBank${rowNumber}"/>`;
                    }
                    break;
                    case 12:
                        {
                        tableData.setAttribute("class", "d-none");
                        tableData.innerHTML = `<input type="text" value="${this.SnChequeBook}" name="SnChequeBook${rowNumber}"/>`;
                    }
                    break;
                    case 13:
                        {
                            tableData.setAttribute("class", "d-none");
                            tableData.innerHTML = `<input type="text" value="${this.descBYS}" name="DocDescBys${rowNumber}"/>`;
                        }
                    break;
                    case 14:
                        {
                            tableData.setAttribute("class", "d-none");
                            tableData.innerHTML = `<input type="text" value="${this.snAccBank}" name="SnAccBank${rowNumber}"/> `;
                        }
                    break;
                    case 15:
                        {
                        tableData.setAttribute("class", "d-none");
                        tableData.innerHTML = `<input type="text" value="${this.noPayanehKartKhanBYS}" name="NoPayanehKartKhanBYS${rowNumber}"/>`;
                    }
                    break;
                    case 16:
                        {
                        tableData.setAttribute("class", "d-none");
                        tableData.innerHTML = `<input type="text" value="${this.snPeopelPay}" name="SnPeopelPay${rowNumber}"/>`;
                    }
                    break;
                    case 17:
                        {
                            tableData.setAttribute("class", "d-none");
                            tableData.innerHTML = `<input type="text" value="${this.repeateCheque}" name="repeatChequ${rowNumber}"/>`;
                        }
                    break;
                    case 18:
                        {
                            tableData.setAttribute("class", "d-none");
                            tableData.innerHTML = `<input type="text" value="${this.distanceMonthCheque}" name="distanceMonthCheque${rowNumber}"/>`;
                        }
                    break;
                    case 19:
                        {
                            tableData.setAttribute("class", "d-none");
                            tableData.innerHTML = `<input type="text" value="${this.payBYSMoney}" name="Price${rowNumber}"/>`;
                        }
                    break;
                    case 20:
                        {
                            tableData.setAttribute("class", "d-none");
                            tableData.innerHTML = `<input type="text" value="${this.SnMainPeopel}" name="SnMainPeopel${rowNumber}"/>`;
                        }
                    break;
                    case 21:
                        {
                            tableData.setAttribute("class", "d-none");
                            tableData.innerHTML = `<input type="text" value="${this.ownerName}" name="ownerName${rowNumber}"/>`;
                        }
                    break;
                    case 22:
                        {
                            tableData.setAttribute("class", "d-none");
                            tableData.innerHTML = `<input type="text" value="${this.hawalaNo}" name="hawalaNo${rowNumber}"/>`;
                        }
                    break;
                    case 23:
                        {
                            tableData.setAttribute("class", "d-none");
                            tableData.innerHTML = `<input type="text" value="${this.BranchName}" name="Branch${rowNumber}"/>`;
                        }
                    break;
                    case 24:
                        {
                            tableData.setAttribute("class", "d-none");
                            tableData.innerHTML = `<input type="text" value="${this.Karmozd}" name="Karmozd${rowNumber}"/>`;
                        }
                    break;
                    case 25:
                        {
                            tableData.setAttribute("class", "d-none");
                            tableData.innerHTML = `<input type="text" value="${this.SerialNoBYS}" name="SerialNoBYS${rowNumber}"/>`;
                        }
                    break;
            }
            tableRow.appendChild(tableData);
        }
        tableBody.appendChild(tableRow);
    }

    editPayBys(){
        let tableBody : HTMLTableSectionElement = document.getElementById("paysAddTableBody") as HTMLTableSectionElement;
        const selectedRow : HTMLElement = tableBody.getElementsByClassName('selected')[0] as HTMLElement;
        let tableRow = document.createElement('tr');
        let rowNumber : number = Number(selectedRow.ariaRowIndex);
        let modalTypeFlag=0;
        if(this.snAccBank==0 && this.payBYSType==3){
            modalTypeFlag=5
        }else{
            modalTypeFlag=this.payBYSType;
        }
        tableRow.setAttribute("onclick", `setAddedPayBysStuff(this,`+modalTypeFlag+`)`);
        for(let i = 0; i < 25; i++){
            const tableData = document.createElement('td');

            switch (i) {
                case 0:
                    {
                        tableData.setAttribute("class", "text-center");
                        if(rowNumber!=0){

                            tableData.innerText = `${rowNumber}`;
                        }else{
                            tableData.innerText = `${rowNumber+1}`;
                        }

                    }
                    break;
                case 1:
                    {
                        tableData.setAttribute("class", "text-center");
                        tableData.innerText= `${this.payBYSDesc}`;
                    }
                    break;
                case 2:
                    {
                        tableData.setAttribute("class", "text-center");
                        tableData.innerText = `${this.payBYSMoney}`;
                    }
                    break;
                case 3:
                    {
                        tableData.setAttribute("class", "text-center");
                        tableData.innerText = ``;
                    }
                    break;
                case 4:
                    {
                        tableData.setAttribute("class", "text-center");
                        tableData.innerText = ``;
                    }
                    break;
                case 5:
                    {
                        tableData.setAttribute("class", "d-none");
                        tableData.innerHTML = `<input type="checkbox" checked class="form-check-input" value="${rowNumber}" name="BYSs[]"/>`;
                    }
                    break;
                case 6:
                    {
                        tableData.setAttribute("class", "d-none");
                        tableData.innerHTML = `<input type="text" class="form-check-input" value="${this.payBYSType}" name="BysType${rowNumber}"/>`;
                    }
                    break;
                case 7:
                    {
                        tableData.setAttribute("class", "d-none");
                        tableData.innerHTML = `<input type="text" value="${this.sayyadiNoCheque}" name="sayyadiNoCheque${rowNumber}"/>`;
                    }
                    break;
                case 8:
                    {

                        tableData.setAttribute("class", "d-none");
                        tableData.innerHTML = `<input type="text" value="${this.checkSarRasidDate}" name="checkSarRasidDate${rowNumber}"/>`;
                    }
                    break;
                case 9:
                    {
                        tableData.setAttribute("class", "d-none");
                        tableData.innerHTML = `<input type="text" value="${this.chequeNoCheqe}" name="chequeNoCheqe${rowNumber}"/>`;
                    }
                    break;
                case 10:
                    {
                        tableData.setAttribute("class", "d-none");
                        tableData.innerHTML = `<input type="text" value="${this.AccBankNo}" name="AccBankNo${rowNumber}"/>`;
                    }
                    break;
                    case 11:
                        {
                        tableData.setAttribute("class", "d-none");
                        tableData.innerHTML = `<input type="text" value="${this.bankSn}" name="SnBank${rowNumber}"/>`;
                    }
                    break;
                    case 12:
                        {
                        tableData.setAttribute("class", "d-none");
                        tableData.innerHTML = `<input type="text" value="${this.SnChequeBook}" name="SnChequeBook${rowNumber}"/>`;
                    }
                    break;
                    case 13:
                        {
                            tableData.setAttribute("class", "d-none");
                            tableData.innerHTML = `<input type="text" value="${this.descBYS}" name="DocDescBys${rowNumber}"/>`;
                        }
                    break;
                    case 14:
                        {
                            tableData.setAttribute("class", "d-none");
                            tableData.innerHTML = `<input type="text" value="${this.snAccBank}" name="SnAccBank${rowNumber}"/> `;
                        }
                    break;
                    case 15:
                        {
                        tableData.setAttribute("class", "d-none");
                        tableData.innerHTML = `<input type="text" value="${this.noPayanehKartKhanBYS}" name="NoPayanehKartKhanBYS${rowNumber}"/>`;
                    }
                    break;
                    case 16:
                        {
                        tableData.setAttribute("class", "d-none");
                        tableData.innerHTML = `<input type="text" value="${this.snPeopelPay}" name="SnPeopelPay${rowNumber}"/>`;
                    }
                    break;
                    case 17:
                        {
                            tableData.setAttribute("class", "d-none");
                            tableData.innerHTML = `<input type="text" value="${this.repeateCheque}" name="repeatChequ${rowNumber}"/>`;
                        }
                    break;
                    case 18:
                        {
                            tableData.setAttribute("class", "d-none");
                            tableData.innerHTML = `<input type="text" value="${this.distanceMonthCheque}" name="distanceMonthCheque${rowNumber}"/>`;
                        }
                    break;
                    case 19:
                        {
                            tableData.setAttribute("class", "d-none");
                            tableData.innerHTML = `<input type="text" value="${this.payBYSMoney}" name="Price${rowNumber}"/>`;
                        }
                    break;
                    case 20:
                        {
                            tableData.setAttribute("class", "d-none");
                            tableData.innerHTML = `<input type="text" value="${this.SnMainPeopel}" name="SnMainPeopel${rowNumber}"/>`;
                        }
                    break;
                    case 21:
                        {
                            tableData.setAttribute("class", "d-none");
                            tableData.innerHTML = `<input type="text" value="${this.ownerName}" name="ownerName${rowNumber}"/>`;
                        }
                    break;
                    case 22:
                        {
                            tableData.setAttribute("class", "d-none");
                            tableData.innerHTML = `<input type="text" value="${this.hawalaNo}" name="hawalaNo${rowNumber}"/>`;
                        }
                    break;
                    case 23:
                        {
                            tableData.setAttribute("class", "d-none");
                            tableData.innerHTML = `<input type="text" value="${this.BranchName}" name="Branch${rowNumber}"/>`;
                        }
                    break;
                    case 24:
                        {
                            tableData.setAttribute("class", "d-none");
                            tableData.innerHTML = `<input type="text" value="${this.Karmozd}" name="Karmozd${rowNumber}"/>`;
                        }
                    break;
                    case 25:
                        {
                            tableData.setAttribute("class", "d-none");
                            tableData.innerHTML = `<input type="text" value="${this.SerialNoBYS}" name="SerialNoBYS${rowNumber}"/>`;
                        }
                    break;
            }
            tableRow.appendChild(tableData);
        }
        tableRow.classList.add("selected");
        tableBody.appendChild(tableRow);
        tableBody.replaceChild(tableRow, selectedRow);
    }

    editEditPayBys(){
        let tableBody : HTMLTableSectionElement = document.getElementById("payEditTableBodyBys") as HTMLTableSectionElement;
        const selectedRow : HTMLTableRowElement = tableBody.getElementsByClassName('selected')[0] as HTMLTableRowElement;
        //let tableRow = document.createElement('tr');
        let rowNumber : number = Number(selectedRow.rowIndex-1);
        alert(rowNumber)
        let modalTypeFlag=0;
        if(this.snAccBank==0 && this.payBYSType==3){
            modalTypeFlag=5
        }else{
            modalTypeFlag=this.payBYSType;
        }
        selectedRow.setAttribute("onclick", `setAddedPayBysStuff(this,`+modalTypeFlag+`)`);
        for(let i = 0; i < 25; i++){
            //const tableData = document.createElement('td');
            const tableData = selectedRow.cells[i] || selectedRow.insertCell(i);
            switch (i) {
                case 0:
                    {
                        tableData.setAttribute("class", "text-center");
                        if(rowNumber!=0){
                            tableData.innerText = `${rowNumber}`;
                        }else{
                            tableData.innerText = `${rowNumber+1}`;
                        }

                    }
                    break;
                case 1:
                    {
                        tableData.setAttribute("class", "text-center");
                        tableData.innerText= `${this.payBYSDesc}`;
                    }
                    break;
                case 2:
                    {
                        tableData.setAttribute("class", "text-center");
                        tableData.innerText = `${this.payBYSMoney}`;
                    }
                    break;
                case 6:
                    {
                        tableData.setAttribute("class", "d-none");
                        tableData.innerHTML = `<input type="text" class="form-check-input" value="${this.payBYSType}" name="BysType${rowNumber}"/>`;
                    }
                    break;
                case 7:
                    {
                        tableData.setAttribute("class", "d-none");
                        tableData.innerHTML = `<input type="text" value="${this.sayyadiNoCheque}" name="sayyadiNoCheque${rowNumber}"/>`;
                    }
                    break;
                case 8:
                    {

                        tableData.setAttribute("class", "d-none");
                        tableData.innerHTML = `<input type="text" value="${this.checkSarRasidDate}" name="checkSarRasidDate${rowNumber}"/>`;
                    }
                    break;
                case 9:
                    {
                        tableData.setAttribute("class", "d-none");
                        tableData.innerHTML = `<input type="text" value="${this.chequeNoCheqe}" name="chequeNoCheqe${rowNumber}"/>`;
                    }
                    break;
                case 10:
                    {
                        tableData.setAttribute("class", "d-none");
                        tableData.innerHTML = `<input type="text" value="${this.AccBankNo}" name="AccBankNo${rowNumber}"/>`;
                    }
                    break;
                    case 11:
                        {
                        tableData.setAttribute("class", "d-none");
                        tableData.innerHTML = `<input type="text" value="${this.bankSn}" name="SnBank${rowNumber}"/>`;
                    }
                    break;
                    case 12:
                        {
                        tableData.setAttribute("class", "d-none");
                        tableData.innerHTML = `<input type="text" value="${this.SnChequeBook}" name="SnChequeBook${rowNumber}"/>`;
                    }
                    break;
                    case 13:
                        {
                            tableData.setAttribute("class", "d-none");
                            tableData.innerHTML = `<input type="text" value="${this.descBYS}" name="DocDescBys${rowNumber}"/>`;
                        }
                    break;
                    case 14:
                        {
                            tableData.setAttribute("class", "d-none");
                            tableData.innerHTML = `<input type="text" value="${this.snAccBank}" name="SnAccBank${rowNumber}"/> `;
                        }
                    break;
                    case 15:
                        {
                        tableData.setAttribute("class", "d-none");
                        tableData.innerHTML = `<input type="text" value="${this.noPayanehKartKhanBYS}" name="NoPayanehKartKhanBYS${rowNumber}"/>`;
                    }
                    break;
                    case 16:
                        {
                        tableData.setAttribute("class", "d-none");
                        tableData.innerHTML = `<input type="text" value="${this.snPeopelPay}" name="SnPeopelPay${rowNumber}"/>`;
                    }
                    break;
                    case 17:
                        {
                            tableData.setAttribute("class", "d-none");
                            tableData.innerHTML = `<input type="text" value="${this.repeateCheque}" name="repeatChequ${rowNumber}"/>`;
                        }
                    break;
                    case 18:
                        {
                            tableData.setAttribute("class", "d-none");
                            tableData.innerHTML = `<input type="text" value="${this.distanceMonthCheque}" name="distanceMonthCheque${rowNumber}"/>`;
                        }
                    break;
                    case 19:
                        {
                            tableData.setAttribute("class", "d-none");
                            tableData.innerHTML = `<input type="text" value="${this.payBYSMoney}" name="Price${rowNumber}"/>`;
                        }
                    break;
                    case 20:
                        {
                            tableData.setAttribute("class", "d-none");
                            tableData.innerHTML = `<input type="text" value="${this.SnMainPeopel}" name="SnMainPeopel${rowNumber}"/>`;
                        }
                    break;
                    case 21:
                        {
                            tableData.setAttribute("class", "d-none");
                            tableData.innerHTML = `<input type="text" value="${this.ownerName}" name="ownerName${rowNumber}"/>`;
                        }
                    break;
                    case 22:
                        {
                            tableData.setAttribute("class", "d-none");
                            tableData.innerHTML = `<input type="text" value="${this.hawalaNo}" name="hawalaNo${rowNumber}"/>`;
                        }
                    break;
                    case 23:
                        {
                            tableData.setAttribute("class", "d-none");
                            tableData.innerHTML = `<input type="text" value="${this.BranchName}" name="Branch${rowNumber}"/>`;
                        }
                    break;
                    case 24:
                        {
                            tableData.setAttribute("class", "d-none");
                            tableData.innerHTML = `<input type="text" value="${this.Karmozd}" name="Karmozd${rowNumber}"/>`;
                        }
                    break;
            }
        }
        // tableRow.classList.add("selected");
        // tableBody.appendChild(tableRow);
        // tableBody.replaceChild(tableRow, selectedRow);
    }

    addEditEditPayBys(){
        let tableBody : HTMLTableSectionElement = document.getElementById("payEditTableBodyBys") as HTMLTableSectionElement;
        let tableRow = document.createElement('tr');
        let rowNumber: number = tableBody.childElementCount;
        let modalTypeFlag=0;
        if(this.snAccBank==0 && this.payBYSType==3){
            modalTypeFlag=5
        }else{
            modalTypeFlag=this.payBYSType;
        }
        tableRow.setAttribute("onclick", `setPayBYSStuff(this,`+modalTypeFlag+`)`);
        for(let i = 0; i < 26; i++){
            const tableData = document.createElement('td');
            switch (i) {
                case 0:
                    {
                        tableData.setAttribute("class", "text-center");
                        tableData.innerText = `${rowNumber+1}`;

                    }
                    break;
                case 1:
                    {
                        tableData.setAttribute("class", "text-center");
                        tableData.innerText= `${this.payBYSDesc}`;
                    }
                    break;
                case 2:
                    {
                        tableData.setAttribute("class", "text-center");
                        tableData.innerText = `${this.payBYSMoney}`;
                    }
                    break;
                case 3:
                    {
                        tableData.setAttribute("class", "text-center");
                        tableData.innerText = ``;
                    }
                    break;
                case 4:
                    {
                        tableData.setAttribute("class", "text-center");
                        tableData.innerText = ``;
                    }
                    break;
                case 5:
                    {
                        tableData.setAttribute("class", "d-none");
                        tableData.innerHTML = `<input type="checkbox" checked class="form-check-input" value="${rowNumber}" name="BYSs[]"/>`;
                    }
                    break;
                case 6:
                    {
                        tableData.setAttribute("class", "d-none");
                        tableData.innerHTML = `<input type="text" class="form-check-input" value="${this.payBYSType}" name="BysType${rowNumber}"/>`;
                    }
                    break;
                case 7:
                    {
                        tableData.setAttribute("class", "d-none");
                        tableData.innerHTML = `<input type="text" value="${this.sayyadiNoCheque}" name="sayyadiNoCheque${rowNumber}"/>`;
                    }
                    break;
                case 8:
                    {

                        tableData.setAttribute("class", "d-none");
                        tableData.innerHTML = `<input type="text" value="${this.checkSarRasidDate}" name="checkSarRasidDate${rowNumber}"/>`;
                    }
                    break;
                case 9:
                    {
                        tableData.setAttribute("class", "d-none");
                        tableData.innerHTML = `<input type="text" value="${this.chequeNoCheqe}" name="chequeNoCheqe${rowNumber}"/>`;
                    }
                    break;
                case 10:
                    {
                        tableData.setAttribute("class", "d-none");
                        tableData.innerHTML = `<input type="text" value="${this.AccBankNo}" name="AccBankNo${rowNumber}"/>`;
                    }
                    break;
                    case 11:
                        {
                        tableData.setAttribute("class", "d-none");
                        tableData.innerHTML = `<input type="text" value="${this.bankSn}" name="SnBank${rowNumber}"/>`;
                    }
                    break;
                    case 12:
                        {
                        tableData.setAttribute("class", "d-none");
                        tableData.innerHTML = `<input type="text" value="${this.SnChequeBook}" name="SnChequeBook${rowNumber}"/>`;
                    }
                    break;
                    case 13:
                        {
                            tableData.setAttribute("class", "d-none");
                            tableData.innerHTML = `<input type="text" value="${this.descBYS}" name="DocDescBys${rowNumber}"/>`;
                        }
                    break;
                    case 14:
                        {
                            tableData.setAttribute("class", "d-none");
                            tableData.innerHTML = `<input type="text" value="${this.snAccBank}" name="SnAccBank${rowNumber}"/> `;
                        }
                    break;
                    case 15:
                        {
                        tableData.setAttribute("class", "d-none");
                        tableData.innerHTML = `<input type="text" value="${this.noPayanehKartKhanBYS}" name="NoPayanehKartKhanBYS${rowNumber}"/>`;
                    }
                    break;
                    case 16:
                        {
                        tableData.setAttribute("class", "d-none");
                        tableData.innerHTML = `<input type="text" value="${this.snPeopelPay}" name="SnPeopelPay${rowNumber}"/>`;
                    }
                    break;
                    case 17:
                        {
                            tableData.setAttribute("class", "d-none");
                            tableData.innerHTML = `<input type="text" value="${this.repeateCheque}" name="repeatChequ${rowNumber}"/>`;
                        }
                    break;
                    case 18:
                        {
                            tableData.setAttribute("class", "d-none");
                            tableData.innerHTML = `<input type="text" value="${this.distanceMonthCheque}" name="distanceMonthCheque${rowNumber}"/>`;
                        }
                    break;
                    case 19:
                        {
                            tableData.setAttribute("class", "d-none");
                            tableData.innerHTML = `<input type="text" value="${this.payBYSMoney}" name="Price${rowNumber}"/>`;
                        }
                    break;
                    case 20:
                        {
                            tableData.setAttribute("class", "d-none");
                            tableData.innerHTML = `<input type="text" value="${this.SnMainPeopel}" name="SnMainPeopel${rowNumber}"/>`;
                        }
                    break;
                    case 21:
                        {
                            tableData.setAttribute("class", "d-none");
                            tableData.innerHTML = `<input type="text" value="${this.ownerName}" name="ownerName${rowNumber}"/>`;
                        }
                    break;
                    case 22:
                        {
                            tableData.setAttribute("class", "d-none");
                            tableData.innerHTML = `<input type="text" value="${this.hawalaNo}" name="hawalaNo${rowNumber}"/>`;
                        }
                    break;
                    case 23:
                        {
                            tableData.setAttribute("class", "d-none");
                            tableData.innerHTML = `<input type="text" value="${this.BranchName}" name="Branch${rowNumber}"/>`;
                        }
                    break;
                    case 24:
                        {
                            tableData.setAttribute("class", "d-none");
                            tableData.innerHTML = `<input type="text" value="${this.Karmozd}" name="Karmozd${rowNumber}"/>`;
                        }
                    break;
                    case 25:
                        {
                            tableData.setAttribute("class", "d-none");
                            tableData.innerHTML = `<input type="text" value="${this.SerialNoBYS}" name="SerialNoBYS${rowNumber}"/>`;
                        }
                    break;
            }
            tableRow.appendChild(tableData);
        }
        tableBody.appendChild(tableRow);
    }

    deletePayBys(rowIndex:number){
        let tableBody : HTMLTableSectionElement = document.getElementById("paysAddTableBody") as HTMLTableSectionElement;
        tableBody.deleteRow(rowIndex);
    }

    deletePayBysEdit(rowIndex:number){
        let tableBody : HTMLTableSectionElement = document.getElementById("payEditTableBodyBys") as HTMLTableSectionElement;
        tableBody.deleteRow(rowIndex-1);
    }
    
}
const daysAfterChequeDateAddInput:HTMLInputElement=document.getElementById("daysAfterChequeDateInputAddPayAdd") as HTMLInputElement;
if(daysAfterChequeDateAddInput){
    daysAfterChequeDateAddInput.addEventListener("keyup",function(e){
        let daysLater=daysAfterChequeDateAddInput.value;
        if(parseInt(daysLater)>0){
            const chequeSarRasidDateInput:HTMLInputElement=document.getElementById("checkSarRasidDateInputAddPayAdd") as HTMLInputElement;
            let chequeDate=chequeSarRasidDateInput.getAttribute("data-gdate");
            if(chequeDate){
                let laterChequeDate=new Date(chequeDate);
                let newDate=new Date().setDate(new Date(laterChequeDate).getDate() + parseInt(daysLater))
                let updateDateHijri=new Intl.DateTimeFormat('fa-IR', { year: 'numeric', month: '2-digit', day: '2-digit' }).format(newDate);
                chequeSarRasidDateInput.value=updateDateHijri;
            }
        }else{
            const chequeSarRasidDateInput:HTMLInputElement=document.getElementById("checkSarRasidDateInputAddPayAdd") as HTMLInputElement;
            let chequeDate=chequeSarRasidDateInput.getAttribute("data-gdate");
            if(chequeDate){
                let laterChequeDate=new Date(chequeDate);
                let newDate=new Date().setDate(new Date(laterChequeDate).getDate() + 0)
                let updateDateHijri=new Intl.DateTimeFormat('fa-IR', { year: 'numeric', month: '2-digit', day: '2-digit' }).format(newDate);
                chequeSarRasidDateInput.value=updateDateHijri;
            }
        }
})
}

function addToChequeDate(daysAfter:number,chequeDateInputId:string){
    let daysLater:number=Number(daysAfter);
    if(daysLater>0){
        const chequeSarRasidDateInput:HTMLInputElement=document.getElementById(chequeDateInputId) as HTMLInputElement;
        let chequeDate=chequeSarRasidDateInput.getAttribute("data-gdate");
        if(chequeDate){
            let laterChequeDate=new Date(chequeDate);
            let newDate=new Date().setDate(new Date(laterChequeDate).getDate() + daysLater)
            let updateDateHijri=new Intl.DateTimeFormat('fa-IR', { year: 'numeric', month: '2-digit', day: '2-digit' }).format(newDate);
            chequeSarRasidDateInput.value=updateDateHijri;
        }
    }else{
        const chequeSarRasidDateInput:HTMLInputElement=document.getElementById(chequeDateInputId) as HTMLInputElement;
        let chequeDate=chequeSarRasidDateInput.getAttribute("data-gdate");
        if(chequeDate){
            let laterChequeDate=new Date(chequeDate);
            let newDate=new Date().setDate(new Date(laterChequeDate).getDate() + 0)
            let updateDateHijri=new Intl.DateTimeFormat('fa-IR', { year: 'numeric', month: '2-digit', day: '2-digit' }).format(newDate);
            chequeSarRasidDateInput.value=updateDateHijri;
        }
    }
}

const moneyChequeInput=document.getElementById("moneyChequeInputAddPayAdd") as HTMLInputElement;
if(moneyChequeInput){
    moneyChequeInput.addEventListener("keyup",function(e){
        let money=moneyChequeInput.value;
        changeNumberToLetter(moneyChequeInput,"moneyInLettersAddAdd",money)
    })
}


const addPayPartForm=document.getElementById("addPayPartForm") as HTMLFormElement;
if(addPayPartForm){
        $("#addPayPartForm").on("submit",function(e){
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
    });
}
const editPayHDSForm=document.getElementById("editPayHDSForm") as HTMLFormElement;
if(editPayHDSForm){
    $("#editPayHDSForm").on("submit",function(e){
        e.preventDefault();
        $.ajax({
            method:"POST",
            url: $(this).attr('action'),
            data: new FormData(this),
            processData: false,
            contentType: false,
            success: function (data) {
                console.info(data);
                //window.location.reload();
            },
            error:function(error){}
        });
    });
}

function deleteGetAndPays(getAndPayId:number){
    swal({
        text:"آیا می خواهید حذف شود؟",
        icon:"warning",
        buttons:true,
        dangerMode:true,
        closeOnClickOutside:false,
        closeOnEsc:true
    }).then(willDelete=>{
        if(willDelete){
            fetch(baseUrl+`/getAndPayHDS/delete/${getAndPayId}`, {
                method: "DELETE",
                headers: {
                  "Content-Type": "application/json",
                  "X-CSRF-TOKEN": ""+csrf,
                }}).then(res=>res.json()).then(res=>{
                if(res.result){
                    swal({
                        text:"حذف شد",
                        icon:"success",
                        button:false,
                        timer:1500
                    }).then(()=>{
                        window.location.reload();
                    })
                }
            })
        }
    })
}

function addNaghdMoneyPayEdit(){
    const monyInput: HTMLInputElement = document.getElementById("rialNaghdPayAddInputEdit") as HTMLInputElement;
    const money: number = Number(monyInput.value);
    const naghdMoneyDescriptionInput: HTMLInputElement = document.getElementById("descNaghdPayAddInputEdit") as HTMLInputElement;
    const description: string = naghdMoneyDescriptionInput.value;
    const payBys = new PayBys(1,0,description,money,0,0,'',0,'',0,0,0,0,0,0,0,0,0,0,'','',0,0);
    payBys.editPayBys();
    closeAddPayPartAddModal('addPayVajhNaghdEditModal');
    paynetPriceHDSAdd.value = String(Number(paynetPriceHDSAdd.value)+money);
}



function addChequePayEdit(){
    const chequeNumberInput: HTMLInputElement = document.getElementById("chequeNoCheqeInputAddPayEdit") as HTMLInputElement;
    const sarRasidInput: HTMLInputElement = document.getElementById("checkSarRasidDateInputAddPayEdit") as HTMLInputElement;
    const moneyChequeInputAddPayAdd: HTMLInputElement = document.getElementById("moneyChequeInputAddPayEdit") as HTMLInputElement;
    const hisabNoChequeInputAddPayAdd:HTMLInputElement=document.getElementById("hisabNoChequeInputAddPayEdit") as HTMLInputElement;
    const sayyadiNoChequeInputAddPayAdd:HTMLInputElement=document.getElementById("sayyadiNoChequeInputAddPayEdit") as HTMLInputElement;
    const radifInChequeBookSelect:HTMLSelectElement=document.getElementById("radifInChequeBookSelectAddPayEdit") as HTMLSelectElement;
    const inVajhChequeInput:HTMLInputElement=document.getElementById("inVajhChequeInputAddPayEdit") as HTMLInputElement;
    const chequeNumber:number=Number(chequeNumberInput.value);
    const sarRasidDate:String=String(sarRasidInput.value);
    const money:number=Number(moneyChequeInputAddPayAdd.value);
    const hisabNo:String=String(hisabNoChequeInputAddPayAdd.value);
    const sayyadiNo:number=Number(sayyadiNoChequeInputAddPayAdd.value);
    const radifInCheque=Number(radifInChequeBookSelect.value);
    const inVajhChequeName:string=String(inVajhChequeInput.value);
    const payBys = new PayBys(2,0,inVajhChequeName,money,radifInCheque,sayyadiNo,sarRasidDate,chequeNumber,hisabNo,0,0,0,0,0,0,0,0,0,0,'','',0,0);
    payBys.editPayBys();
    closeAddPayPartAddModal('addPayChequeInfoEditModal');
    paynetPriceHDSAdd.value = String(Number(paynetPriceHDSAdd.value)+money);
}

function addHawalaFromBoxAddPayEdit(){
    const hawalaNoInput:HTMLInputElement=document.getElementById("addHawalaFromBoxHawalaNoEditInput") as HTMLInputElement;
    const deateInput:HTMLInputElement=document.getElementById("addHawalaFromBoxDateEditInput") as HTMLInputElement;
    const moneyInput:HTMLInputElement=document.getElementById("addHawalaFromBoxMoneyInput") as HTMLInputElement;
    const karmozdInput:HTMLInputElement=document.getElementById("addHawalaFromBoxKarmozdInput") as HTMLInputElement;
    const hisabNoInput:HTMLInputElement=document.getElementById("addHawalaFromBoxHisabNoInput") as HTMLInputElement;
    const bankNameInput:HTMLInputElement=document.getElementById("addHawalaFromBoxBankSnInput") as HTMLInputElement;
    const branchNameInput:HTMLInputElement=document.getElementById("addHawalaFromBoxBranchNameInput") as HTMLInputElement;
    const addHawalaFromBoxAddDescInput:HTMLInputElement=document.getElementById("addHawalaFromBoxDescInput") as HTMLInputElement;
    const ownerNameInput:HTMLInputElement=document.getElementById("addHawalaFromBoxOwnerNameInput") as HTMLInputElement;
    const hawalaNo:number=Number(hawalaNoInput.value);
    const hawalaDate:String=String(deateInput.value);
    const money:number=Number(moneyInput.value);
    const addHawalaFromBoxAddKarmozd:number=Number(karmozdInput.value);
    const hisabNo:String=String(hisabNoInput.value);
    const bankSn:Number=Number(bankNameInput.value);
    const branchName:String=String(branchNameInput.value);
    const description:string=String(addHawalaFromBoxAddDescInput.value);
    const ownerName:String=String(ownerNameInput.value);
    const payBys = new PayBys(3,0,description,money,0,0,hawalaDate,0,hisabNo,bankSn,0,0,0,0,0,0,0,0,addHawalaFromBoxAddKarmozd,branchName,ownerName,hawalaNo,0);
    payBys.editPayBys();
    closeAddPayPartAddModal('AddPayHawalaFromBoxEditModal');
    paynetPriceHDSAdd.value = String(Number(paynetPriceHDSAdd.value)+money);
}
function addTakhfifAddPayEdit(){
    const takhfifMoneyInputAddPayAdd:HTMLInputElement=document.getElementById("takhfifMoneyInputAddPayEdit") as HTMLInputElement;
    const money:number=Number(takhfifMoneyInputAddPayAdd.value);
    const discriptionTakhfifInputAddPayAdd:HTMLInputElement=document.getElementById("discriptionTakhfifInputAddPayEdit") as HTMLInputElement;
    const descTakhfif:string=discriptionTakhfifInputAddPayAdd.value;
    const payBys = new PayBys(4,0,descTakhfif,money,0,0,'',0,'',0,0,0,0,0,0,0,0,0,0,'','',0,0);
    payBys.editPayBys();
    closeAddPayPartAddModal('AddPayTakhfifEditModal');
    paynetPriceHDSAdd.value = String(Number(paynetPriceHDSAdd.value)+money);
}
function addPayHawalaFromBankEdit(){
    const addPayHawalaFromBankAddSelectHisabSnInput:HTMLSelectElement=document.getElementById("addFromHisabNoEditSelect") as HTMLSelectElement;
    const addPayHawalaFromBankAddHawalaNoInput:HTMLInputElement=document.getElementById("addHawalaNoEditInput") as HTMLInputElement;
    const addPayHawalaFromBankAddHawalaDateInput:HTMLInputElement=document.getElementById("addHawalaDateEditInput") as HTMLInputElement;
    const addPayHawalaFromBankAddHawalaHisabNoInput:HTMLInputElement=document.getElementById("addToHisabNoEditInput") as HTMLInputElement;
    const addPayHawalaFromBankAddBankNameInput:HTMLInputElement=document.getElementById("addToBankEditInput") as HTMLInputElement;
    const addPayHawalaFromBankAddMalikHisabNameInput:HTMLInputElement=document.getElementById("addToHisabOwnerEditInput") as HTMLInputElement;
    const addPayHawalaFromBankAddShobeSnInput:HTMLInputElement=document.getElementById("addToBankShobeEditInput") as HTMLInputElement;
    const addPayHawalaFromBankAddDescInput:HTMLInputElement=document.getElementById("addDescEditInput") as HTMLInputElement;
    const addHawalaFromBankAddMoneyInput:HTMLInputElement=document.getElementById("addHawalaFromBankMoneyInput") as HTMLInputElement;
    const addHawalaFromBankAddKarmozdInput:HTMLInputElement=document.getElementById("addHawalaFromBankKarmozdInput") as HTMLInputElement;
    
    const bankHisabSn:number=Number(addPayHawalaFromBankAddSelectHisabSnInput.value);
    const hawalaNo:Number=Number(addPayHawalaFromBankAddHawalaNoInput.value);
    const hawalaDate:String=String(addPayHawalaFromBankAddHawalaDateInput.value);
    const hisabNo:String=String(addPayHawalaFromBankAddHawalaHisabNoInput.value);
    const snBank:Number=Number(addPayHawalaFromBankAddBankNameInput.value);
    const malikName:string=String(addPayHawalaFromBankAddMalikHisabNameInput.value);
    const addShobeName:String=String(addPayHawalaFromBankAddShobeSnInput.value);
    const description:string=String(addPayHawalaFromBankAddDescInput.value);
    const money:number=Number(addHawalaFromBankAddMoneyInput.value);
    const karmozd:number=Number(addHawalaFromBankAddKarmozdInput.value);
    const payBys = new PayBys(3,0,description,money,0,0,hawalaDate,0,hisabNo,snBank,0,bankHisabSn,0,0,0,0,0,0,karmozd,addShobeName,malikName,hawalaNo,0);
    payBys.editPayBys();
    closeAddPayPartAddModal('AddPayHawalaFromBankEditModal');
    paynetPriceHDSAdd.value = String(Number(paynetPriceHDSAdd.value)+money);
}

function editEditNaghdMoneyPayEdit(){
    const monyInput: HTMLInputElement = document.getElementById("rialNaghdPayEditEditInputEdit") as HTMLInputElement;
    const money: number = Number(monyInput.value);
    const naghdMoneyDescriptionInput: HTMLInputElement = document.getElementById("descNaghdPayEditEditInputEdit") as HTMLInputElement;
    const description: string = naghdMoneyDescriptionInput.value;
    const payBys = new PayBys(1,0,description,money,0,0,'',0,'',0,0,0,0,0,0,0,0,0,0,'','',0,0);
    payBys.editEditPayBys();
    closeAddPayPartAddModal('editEditPayVajhNaghdEditModal');
    paynetPriceHDSAdd.value = String(Number(paynetPriceHDSAdd.value)+money);
}
function addEditNaghdMoneyPayEdit(){
    const monyInput: HTMLInputElement = document.getElementById("rialNaghdPayAddEditInputEdit") as HTMLInputElement;
    const money: number = Number(monyInput.value);
    const naghdMoneyDescriptionInput: HTMLInputElement = document.getElementById("descNaghdPayAddEditInputEdit") as HTMLInputElement;
    const description: string = naghdMoneyDescriptionInput.value;
    const payBys = new PayBys(1,0,description,money,0,0,'',0,'',0,0,0,0,0,0,0,0,0,0,'','',0,0);
    payBys.addEditEditPayBys();
    closeAddPayPartAddModal('addEditPayVajhNaghdEditModal');
    paynetPriceHDSAdd.value = String(Number(paynetPriceHDSAdd.value)+money);
}

function editChequePayEdit(){
    const chequeNumberInput: HTMLInputElement = document.getElementById("chequeNoCheqeInputEditPayEdit") as HTMLInputElement;
    const sarRasidInput: HTMLInputElement = document.getElementById("checkSarRasidDateInputEditPayEdit") as HTMLInputElement;
    const moneyChequeInputAddPayAdd: HTMLInputElement = document.getElementById("moneyChequeInputEditPayEdit") as HTMLInputElement;
    const hisabNoChequeInputAddPayAdd:HTMLInputElement=document.getElementById("hisabNoChequeInputEditPayEdit") as HTMLInputElement;
    const sayyadiNoChequeInputAddPayAdd:HTMLInputElement=document.getElementById("sayyadiNoChequeInputEditPayEdit") as HTMLInputElement;
    const radifInChequeBookSelect:HTMLSelectElement=document.getElementById("radifInChequeBookSelectEditPayEdit") as HTMLSelectElement;
    const inVajhChequeInput:HTMLInputElement=document.getElementById("inVajhChequeInputEditPayEdit") as HTMLInputElement;
    const chequeNumber:number=Number(chequeNumberInput.value);
    const sarRasidDate:String=String(sarRasidInput.value);
    const money:number=Number(moneyChequeInputAddPayAdd.value);
    const hisabNo:String=String(hisabNoChequeInputAddPayAdd.value);
    const sayyadiNo:number=Number(sayyadiNoChequeInputAddPayAdd.value);
    const radifInCheque=Number(radifInChequeBookSelect.value);
    const inVajhChequeName:string=String(inVajhChequeInput.value);
    const payBys = new PayBys(2,0,inVajhChequeName,money,radifInCheque,sayyadiNo,sarRasidDate,chequeNumber,hisabNo,0,0,0,0,0,0,0,0,0,0,'','',0,0);
    payBys.editEditPayBys();
    closeAddPayPartAddModal('editEditPayChequeInfoEditModal');
    paynetPriceHDSAdd.value = String(Number(paynetPriceHDSAdd.value)+money);
}
function addEditChequePayEdit(){
    const chequeNumberInput: HTMLInputElement = document.getElementById("chequeNoCheqeInputAddEditPayEdit") as HTMLInputElement;
    const sarRasidInput: HTMLInputElement = document.getElementById("checkSarRasidDateInputAddEditPayEdit") as HTMLInputElement;
    const moneyChequeInputAddPayAdd: HTMLInputElement = document.getElementById("moneyChequeInputAddEditPayEdit") as HTMLInputElement;
    const hisabNoChequeInputAddPayAdd:HTMLInputElement=document.getElementById("hisabNoChequeInputAddEditPayEdit") as HTMLInputElement;
    const sayyadiNoChequeInputAddPayAdd:HTMLInputElement=document.getElementById("sayyadiNoChequeInputAddEditPayEdit") as HTMLInputElement;
    const radifInChequeBookSelect:HTMLSelectElement=document.getElementById("radifInChequeBookSelectAddEditPayEdit") as HTMLSelectElement;
    const inVajhChequeInput:HTMLInputElement=document.getElementById("inVajhChequeInputAddEditPayEdit") as HTMLInputElement;
    const chequeNumber:number=Number(chequeNumberInput.value);
    const sarRasidDate:String=String(sarRasidInput.value);
    const money:number=Number(moneyChequeInputAddPayAdd.value);
    const hisabNo:String=String(hisabNoChequeInputAddPayAdd.value);
    const sayyadiNo:number=Number(sayyadiNoChequeInputAddPayAdd.value);
    const radifInCheque=Number(radifInChequeBookSelect.value);
    const inVajhChequeName:string=String(inVajhChequeInput.value);
    const payBys = new PayBys(2,0,inVajhChequeName,money,radifInCheque,sayyadiNo,sarRasidDate,chequeNumber,hisabNo,0,0,0,0,0,0,0,0,0,0,'','',0,0);
    payBys.addEditEditPayBys();
    closeAddPayPartAddModal('addEditPayChequeInfoEditModal');
    paynetPriceHDSAdd.value = String(Number(paynetPriceHDSAdd.value)+money);
}

function editHawalaFromBoxEditPayEdit(){
    const hawalaNoInput:HTMLInputElement=document.getElementById("editHawalaFromBoxEditInputNumber") as HTMLInputElement;
    const deateInput:HTMLInputElement=document.getElementById("editHawalaFromBoxEditDateInput") as HTMLInputElement;
    const moneyInput:HTMLInputElement=document.getElementById("editHawalaFromBoxEditMoneyInput") as HTMLInputElement;
    const karmozdInput:HTMLInputElement=document.getElementById("editHawalaFromBoxEditKarmozdInput") as HTMLInputElement;
    const hisabNoInput:HTMLInputElement=document.getElementById("editHawalaFromBoxEditNumberHisabInput") as HTMLInputElement;
    const bankNameInput:HTMLInputElement=document.getElementById("editHawalaFromBoxEditBankNameInput") as HTMLInputElement;
    const branchNameInput:HTMLInputElement=document.getElementById("editHawalaFromBoxEditBranchSnInput") as HTMLInputElement;
    const addHawalaFromBoxAddDescInput:HTMLInputElement=document.getElementById("editHawalaFromBoxEditDescInput") as HTMLInputElement;
    const ownerNameInput:HTMLInputElement=document.getElementById("editHawalaFromBoxEditMalikNameInput") as HTMLInputElement;
    const hawalaNo:number=Number(hawalaNoInput.value);
    const hawalaDate:String=String(deateInput.value);
    const money:number=Number(moneyInput.value);
    const addHawalaFromBoxAddKarmozd:number=Number(karmozdInput.value);
    const hisabNo:String=String(hisabNoInput.value);
    const bankSn:Number=Number(bankNameInput.value);
    const branchName:String=String(branchNameInput.value);
    const description:string=String(addHawalaFromBoxAddDescInput.value);
    const ownerName:String=String(ownerNameInput.value);
    const payBys = new PayBys(3,0,description,money,0,0,hawalaDate,0,hisabNo,bankSn,0,0,0,0,0,0,0,0,addHawalaFromBoxAddKarmozd,branchName,ownerName,hawalaNo,0);
    payBys.editEditPayBys();
    closeAddPayPartAddModal('editEditPayHawalaFromBoxEditModal');
    paynetPriceHDSAdd.value = String(Number(paynetPriceHDSAdd.value)+money);
}
function addEditHawalaFromBoxPayEdit(){
    const hawalaNoInput:HTMLInputElement=document.getElementById("addHawalaFromBoxHawalaNoEditInputEdit") as HTMLInputElement;
    const deateInput:HTMLInputElement=document.getElementById("addHawalaFromBoxDateEditInputEdit") as HTMLInputElement;
    const moneyInput:HTMLInputElement=document.getElementById("addHawalaFromBoxMoneyEditInputEdit") as HTMLInputElement;
    const karmozdInput:HTMLInputElement=document.getElementById("addHawalaFromBoxKarmozdEditInputEdit") as HTMLInputElement;
    const hisabNoInput:HTMLInputElement=document.getElementById("addHawalaFromBoxHisabNoEditInputEdit") as HTMLInputElement;
    const bankNameInput:HTMLInputElement=document.getElementById("addHawalaFromBoxBankSnEditInputEdit") as HTMLInputElement;
    const branchNameInput:HTMLInputElement=document.getElementById("addHawalaFromBoxBranchNameEditInputEdit") as HTMLInputElement;
    const addHawalaFromBoxAddDescInput:HTMLInputElement=document.getElementById("addHawalaFromBoxDescEditInputEdit") as HTMLInputElement;
    const ownerNameInput:HTMLInputElement=document.getElementById("addHawalaFromBoxOwnerNameEditInputEdit") as HTMLInputElement;
    const hawalaNo:number=Number(hawalaNoInput.value);
    const hawalaDate:String=String(deateInput.value);
    const money:number=Number(moneyInput.value);
    const addHawalaFromBoxAddKarmozd:number=Number(karmozdInput.value);
    const hisabNo:String=String(hisabNoInput.value);
    const bankSn:Number=Number(bankNameInput.value);
    const branchName:String=String(branchNameInput.value);
    const description:string=String(addHawalaFromBoxAddDescInput.value);
    const ownerName:String=String(ownerNameInput.value);
    const payBys = new PayBys(3,0,description,money,0,0,hawalaDate,0,hisabNo,bankSn,0,0,0,0,0,0,0,0,addHawalaFromBoxAddKarmozd,branchName,ownerName,hawalaNo,0);
    payBys.addEditEditPayBys();
    closeAddPayPartAddModal('addEditPayHawalaFromBoxEditModal');
    paynetPriceHDSAdd.value = String(Number(paynetPriceHDSAdd.value)+money);
}
function editTakhfifPayEdit(){
    const takhfifMoneyInputAddPayAdd:HTMLInputElement=document.getElementById("takhfifMoneyInputEditEditPayEdit") as HTMLInputElement;
    const money:number=Number(takhfifMoneyInputAddPayAdd.value);
    const discriptionTakhfifInputAddPayAdd:HTMLInputElement=document.getElementById("discriptionTakhfifInputEditEditPayEdit") as HTMLInputElement;
    const descTakhfif:string=discriptionTakhfifInputAddPayAdd.value;
    const payBys = new PayBys(4,0,descTakhfif,money,0,0,'',0,'',0,0,0,0,0,0,0,0,0,0,'','',0,0);
    payBys.editEditPayBys();
    closeAddPayPartAddModal('editEditPayTakhfifEditModal');
    paynetPriceHDSAdd.value = String(Number(paynetPriceHDSAdd.value)+money);
}

function addEditTakhfifPayEdit(){
    const takhfifMoneyInputAddPayAdd:HTMLInputElement=document.getElementById("takhfifMoneyInputAddEditPayEdit") as HTMLInputElement;
    const money:number=Number(takhfifMoneyInputAddPayAdd.value);
    const discriptionTakhfifInputAddPayAdd:HTMLInputElement=document.getElementById("discriptionTakhfifInputAddEditPayEdit") as HTMLInputElement;
    const descTakhfif:string=discriptionTakhfifInputAddPayAdd.value;
    const payBys = new PayBys(4,0,descTakhfif,money,0,0,'',0,'',0,0,0,0,0,0,0,0,0,0,'','',0,0);
    payBys.addEditEditPayBys();
    closeAddPayPartAddModal('addEditPayTakhfifEditModal');
    paynetPriceHDSAdd.value = String(Number(paynetPriceHDSAdd.value)+money);
}

function editPayHawalaFromBankEdit(){
    const addPayHawalaFromBankAddSelectHisabSnInput:HTMLSelectElement=document.getElementById("editFromHisabNoEditSelect") as HTMLSelectElement;
    const addPayHawalaFromBankAddHawalaNoInput:HTMLInputElement=document.getElementById("editHawalaNoEditInput") as HTMLInputElement;
    const addPayHawalaFromBankAddHawalaDateInput:HTMLInputElement=document.getElementById("editHawalaDateEditInput") as HTMLInputElement;
    const addPayHawalaFromBankAddHawalaHisabNoInput:HTMLInputElement=document.getElementById("editToHisabNoEditInput") as HTMLInputElement;
    const addPayHawalaFromBankAddBankNameInput:HTMLInputElement=document.getElementById("editToBankEditInput") as HTMLInputElement;
    const addPayHawalaFromBankAddMalikHisabNameInput:HTMLInputElement=document.getElementById("editToHisabOwnerEditInput") as HTMLInputElement;
    const addPayHawalaFromBankAddShobeSnInput:HTMLInputElement=document.getElementById("editToBankShobeEditInput") as HTMLInputElement;
    const addPayHawalaFromBankAddDescInput:HTMLInputElement=document.getElementById("editDescEditInput") as HTMLInputElement;
    const addHawalaFromBankAddMoneyInput:HTMLInputElement=document.getElementById("editHawalaFromBankMoneyInput") as HTMLInputElement;
    const addHawalaFromBankAddKarmozdInput:HTMLInputElement=document.getElementById("editHawalaFromBankKarmozdInput") as HTMLInputElement;
    const bankHisabSn:number=Number(addPayHawalaFromBankAddSelectHisabSnInput.value);
    const hawalaNo:Number=Number(addPayHawalaFromBankAddHawalaNoInput.value);
    const hawalaDate:String=String(addPayHawalaFromBankAddHawalaDateInput.value);
    const hisabNo:String=String(addPayHawalaFromBankAddHawalaHisabNoInput.value);
    const snBank:Number=Number(addPayHawalaFromBankAddBankNameInput.value);
    const malikName:string=String(addPayHawalaFromBankAddMalikHisabNameInput.value);
    const addShobeName:String=String(addPayHawalaFromBankAddShobeSnInput.value);
    const description:string=String(addPayHawalaFromBankAddDescInput.value);
    const money:number=Number(addHawalaFromBankAddMoneyInput.value);
    const karmozd:number=Number(addHawalaFromBankAddKarmozdInput.value);
    const payBys = new PayBys(3,0,description,money,0,0,hawalaDate,0,hisabNo,snBank,0,bankHisabSn,0,0,0,0,0,0,karmozd,addShobeName,malikName,hawalaNo,0);
    payBys.editEditPayBys();
    closeAddPayPartAddModal('editEditPayHawalaFromBankEditModal');
    paynetPriceHDSAdd.value = String(Number(paynetPriceHDSAdd.value)+money);
}

const bankSnSelects=document.querySelectorAll(".banksn");
if(bankSnSelects){
    bankSnSelects.forEach(element => {
        const selectElement:HTMLSelectElement=element as HTMLSelectElement;
        
        selectElement.innerHTML='';
            fetch(baseUrl+'/getBankList', {
                method: 'GET'
            })
           .then(response=>response.json())
           .then(data=>{
            data.forEach(bank=>{
                const option = document.createElement("option");
                option.text = bank.NameBsn;
                option.value = String(bank.SerialNoBSN);
                selectElement.add(option);
            })
           })
    });
}


function addEditPayHawalaFromBankEdit(){
    const addPayHawalaFromBankAddSelectHisabSnInput:HTMLSelectElement=document.getElementById("addFromHisabNoEditSelectEdit") as HTMLSelectElement;
    const addPayHawalaFromBankAddHawalaNoInput:HTMLInputElement=document.getElementById("addHawalaNoEditInputEdit") as HTMLInputElement;
    const addPayHawalaFromBankAddHawalaDateInput:HTMLInputElement=document.getElementById("addHawalaDateEditInputEdit") as HTMLInputElement;
    const addPayHawalaFromBankAddHawalaHisabNoInput:HTMLInputElement=document.getElementById("addToHisabNoEditInputEdit") as HTMLInputElement;
    const addPayHawalaFromBankAddBankNameInput:HTMLInputElement=document.getElementById("addToBankEditInputEdit") as HTMLInputElement;
    const addPayHawalaFromBankAddMalikHisabNameInput:HTMLInputElement=document.getElementById("addToHisabOwnerEditInputEdit") as HTMLInputElement;
    const addPayHawalaFromBankAddShobeSnInput:HTMLInputElement=document.getElementById("addToBankShobeEditInputEdit") as HTMLInputElement;
    const addPayHawalaFromBankAddDescInput:HTMLInputElement=document.getElementById("addDescEditInputEdit") as HTMLInputElement;
    const addHawalaFromBankAddMoneyInput:HTMLInputElement=document.getElementById("addHawalaFromBankMoneyEditInputEdit") as HTMLInputElement;
    const addHawalaFromBankAddKarmozdInput:HTMLInputElement=document.getElementById("addHawalaFromBankKarmozdEditInputEdit") as HTMLInputElement;
    
    const bankHisabSn:number=Number(addPayHawalaFromBankAddSelectHisabSnInput.value);
    const hawalaNo:Number=Number(addPayHawalaFromBankAddHawalaNoInput.value);
    const hawalaDate:String=String(addPayHawalaFromBankAddHawalaDateInput.value);
    const hisabNo:String=String(addPayHawalaFromBankAddHawalaHisabNoInput.value);
    const snBank:Number=Number(addPayHawalaFromBankAddBankNameInput.value);
    const malikName:string=String(addPayHawalaFromBankAddMalikHisabNameInput.value);
    const addShobeName:String=String(addPayHawalaFromBankAddShobeSnInput.value);
    const description:string=String(addPayHawalaFromBankAddDescInput.value);
    const money:number=Number(addHawalaFromBankAddMoneyInput.value);
    const karmozd:number=Number(addHawalaFromBankAddKarmozdInput.value);
    const payBys = new PayBys(3,0,description,money,0,0,hawalaDate,0,hisabNo,snBank,0,bankHisabSn,0,0,0,0,0,0,karmozd,addShobeName,malikName,hawalaNo,0);
    payBys.addEditEditPayBys();
    closeAddPayPartAddModal('addEditPayHawalaFromBankEditModal');
    paynetPriceHDSAdd.value = String(Number(paynetPriceHDSAdd.value)+money);
}

function deleteSelectedBysItem(){
    const selectedRow=document.querySelectorAll(".selected");
    selectedRow.forEach(element => {
        
    });
}




