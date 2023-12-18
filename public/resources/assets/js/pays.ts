
//const baseUrl:string = 'http://192.168.10.26:8080';
function addNaghdMoneyPayAdd(){
    const monyInput: HTMLInputElement = document.getElementById("rialNaghdPayAddInputAdd") as HTMLInputElement;
    const money: number = Number(monyInput.value);
    const naghdMoneyDescriptionInput: HTMLInputElement = document.getElementById("descNaghdPayAddInputAdd") as HTMLInputElement;
    const description: string = naghdMoneyDescriptionInput.value;
    const payBys = new PayBys(1,0,description,money,0,0,'',0,'',0,0,0,0,0,0,0,0,0,0,'','',0);
    payBys.addPayBys();
    closeAddPayPartAddModal('addPayVajhNaghdAddModal');
}

function openAddPayPartAddModal(modalId: string) {
    const modal = document.getElementById(modalId) as HTMLElement;
    modal.style.display = "block";
    if(modalId=='addPayChequeInfoAddModal'){
        fetch(baseUrl+'/allBanks', {
            method: 'GET'
        })
       .then(response=>response.json())
       .then(data=>{
        data.bankKarts.forEach(bank=>{
            const option = document.createElement("option");
            option.text = bank.bsn;
            option.value = String(bank.SerialNoAcc);
            const selectBox=document.getElementById('hisabNoChequeInputAddPayAdd') as HTMLSelectElement;
            selectBox.add(option);
        })
       })

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
        const selectHisabSn:HTMLSelectElement = document.getElementById("addPayHawalaFromBankAddSelectHisabSn") as HTMLSelectElement;
         selectHisabSn.innerHTML='';
         selectHisabSn.add(new Option('',''));
        fetch(baseUrl+'/allBanks', {
            method: 'GET'
        })
       .then(response=>response.json())
       .then(data=>{
        data.bankKarts.forEach(bank=>{
            const option = document.createElement("option");
            option.text = bank.bsn;
            option.value = String(bank.SerialNoAcc);
            selectHisabSn.add(option);
        })
       })
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
    const payBys = new PayBys(3,0,description,money,0,0,hawalaDate,0,hisabNo,snBank,0,bankHisabSn,0,0,0,0,0,0,karmozd,addShobeName,malikName,hawalaNo);
    payBys.addPayBys();
    closeAddPayPartAddModal('AddPayHawalaFromBankAddModal');
}

function addTakhfifAddPayAdd(){
    const takhfifMoneyInputAddPayAdd:HTMLInputElement=document.getElementById("takhfifMoneyInputAddPayAdd") as HTMLInputElement;
    const takhfif:number=Number(takhfifMoneyInputAddPayAdd.value);
    const discriptionTakhfifInputAddPayAdd:HTMLInputElement=document.getElementById("discriptionTakhfifInputAddPayAdd") as HTMLInputElement;
    const descTakhfif:string=discriptionTakhfifInputAddPayAdd.value;
    const payBys = new PayBys(4,0,descTakhfif,takhfif,0,0,'',0,'',0,0,0,0,0,0,0,0,0,0,'','',0);
    payBys.addPayBys();
    closeAddPayPartAddModal('AddPayTakhfifAddModal');
}



function deletePayBys(payBysIndex: number){
    let rowIndex:number=Number(payBysIndex);
    let payBys: PayBys = new PayBys(0,rowIndex,'',0,0,0,'',0,'',0,0,0,0,0,0,0,0,0,0,'','',0);
    
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
            {
                const monyInput:HTMLInputElement=document.getElementById("rialNaghdPayAddInputEdit") as HTMLInputElement;
                const descInput:HTMLInputElement=document.getElementById("descNaghdPayAddInputEdit") as HTMLInputElement;
                rowData.forEach((td,index)=>{
                    if(td.children.item(0)){
                        switch (index) {
                            case 19:
                                monyInput.value=String(td.children.item(0)?.getAttribute('value'));
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
            const chequeNoCheqeInputAddPayEdit=document.getElementById("chequeNoCheqeInputAddPayEdit") as HTMLInputElement;
            const checkSarRasidDateInputAddPayEdit=document.getElementById("checkSarRasidDateInputAddPayEdit") as HTMLInputElement;
            const daysAfterChequeDateInputAddPayEdit=document.getElementById("daysAfterChequeDateInputAddPayEdit") as HTMLInputElement;
            const shobeBankChequeInputAddPayEdit=document.getElementById("shobeBankChequeInputAddPayEdit") as HTMLInputElement;
            const SnBankInput=document.getElementById("bankNameSelectAddPayEdit") as HTMLInputElement;
            const moneyChequeInputAddPayEdit=document.getElementById("moneyChequeInputAddPayEdit") as HTMLInputElement;
            const malikChequeInputAddPayEdit=document.getElementById("malikChequeInputAddPayEdit") as HTMLInputElement;
            const sayyadiNoChequeInputAddPayEdit=document.getElementById("sayyadiNoChequeInputAddPayEdit") as HTMLInputElement;
            const descChequeInputAddPayEdit=document.getElementById("descChequeInputAddPayEdit") as HTMLInputElement;
            
            openAddPayChequeInfoEditModal()
            break;
        case 3:
        {
            
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
            {
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
            {
                const boxNoInput=document.getElementById("addHawalaFromBoxBoxNoEditInput") as HTMLInputElement;
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
                            case 9://
                            
                                boxNoInput.value=String(td.children.item(0)?.getAttribute('value'));
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

const addPayHawalaFromBankAddSelectHisabSn = document.getElementById("addPayHawalaFromBankAddSelectHisabSn") as HTMLSelectElement;
const addPayHawalaFromBankAddInputInfo= document.getElementById("addPayHawalaFromBankAddInputInfo") as HTMLInputElement;

if(addPayHawalaFromBankAddSelectHisabSn){
    addPayHawalaFromBankAddSelectHisabSn.addEventListener("change", () => {
        let hisabNo:number=Number(addPayHawalaFromBankAddSelectHisabSn.value);
        let url=new URLSearchParams();
        url.append("bankSn",String(hisabNo));
        fetch(baseUrl+`/getBankInfo?${url.toString()}`, {
            method: 'GET',
          }).then(response=>{
            return response.json();
        }).then(respond=>{
            addPayHawalaFromBankAddInputInfo.value=String(respond[0].AccNo);
        })
    });
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
    const payBys = new PayBys(3,0,description,money,0,0,hawalaDate,0,hisabNo,bankSn,0,0,0,0,0,0,hawalaNo,0,addHawalaFromBoxAddKarmozd,branchName,ownerName,0);
    payBys.addPayBys();
    closeAddPayPartAddModal('AddPayHawalaFromBoxAddModal');
}

function addChequePayAdd(){
    const chequeNumberInput: HTMLInputElement = document.getElementById("chequeNoCheqeInputAddPayAdd") as HTMLInputElement;
    const sarRasidInput: HTMLInputElement = document.getElementById("checkSarRasidDateInputAddPayAdd") as HTMLInputElement;
    const moneyChequeInputAddPayAdd: HTMLInputElement = document.getElementById("moneyChequeInputAddPayAdd") as HTMLInputElement;
    const hisabNoChequeInputAddPayAdd:HTMLInputElement=document.getElementById("hisabNoChequeInputAddPayAdd") as HTMLInputElement;
    const sayyadiNoChequeInputAddPayAdd:HTMLInputElement=document.getElementById("sayyadiNoChequeInputAddPayAdd") as HTMLInputElement;
    const radifInChequeBookSelect:HTMLSelectElement=document.getElementById("radifInChequeBookSelectAddPayAdd") as HTMLSelectElement;
    const inVajhChequeInputAddPayAdd:HTMLInputElement=document.getElementById("inVajhChequeInputAddPayAdd") as HTMLInputElement;

    const chequeNumber:number=Number(chequeNumberInput.value);
    const sarRasidDate:String=String(sarRasidInput.value);
    const moneyCheque:number=Number(moneyChequeInputAddPayAdd.value);
    const hisabNo:String=String(hisabNoChequeInputAddPayAdd.value);
    const sayyadiNo:number=Number(sayyadiNoChequeInputAddPayAdd.value);
    const radifInCheque=Number(radifInChequeBookSelect.value);
    const inVajhChequePSN:number=Number(inVajhChequeInputAddPayAdd.value);
    const payBys = new PayBys(2,0,'',moneyCheque,radifInCheque,sayyadiNo,sarRasidDate,chequeNumber,hisabNo,0,0,0,0,0,0,0,0,inVajhChequePSN,0,'','',0);
    payBys.addPayBys();
    closeAddPayPartAddModal('addPayChequeInfoAddModal');
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
    constructor(payBYSType:number,payBYSIndex: number, payBYSDesc: string, payBYSMoney: number, payBYSRadifInChequeBook: number, sayyadiNoCheque: number
        ,checkSarRasidDate:String,chequeNoCheqe:number,accBankNo:String,
        bankSn:Number,SnChequeBook:number,snAccBank:number,noPayanehKartKhanBYS:number,
        snPeopelPay:number,repeateCheque:number,distanceMonthCheque:number,cashNo:number,inVajhPeopelSn:number,Karmozd:number,branchName:String,ownerName:String,hawalaNo:Number){
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
                        tableData.innerHTML = `<input type="checkbox" class="form-check-input" value="${rowNumber}" name="BYSs[]"/>`;
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
                        tableData.innerHTML = `<input type="text" value="${this.AccBankNo}" name="hisabNoCheque${rowNumber}"/>`;
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
                            tableData.innerHTML = `<input type="text" value="${this.payBYSMoney}" name="price${rowNumber}"/>`;
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
                            tableData.innerHTML = `<input type="text" value="${this.BranchName}" name="hawalaDate${rowNumber}"/>`;
                        }
                    break;
                    case 24:
                        {
                            tableData.setAttribute("class", "d-none");
                            tableData.innerHTML = `<input type="text" value="${this.Karmozd}" name="hawalaDate${rowNumber}"/>`;
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
    consoleBYS(payBys : PayBys){
        console.log(payBys);
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
const moneyChequeInput=document.getElementById("moneyChequeInputAddPayAdd") as HTMLInputElement;
if(moneyChequeInput){
    moneyChequeInput.addEventListener("keyup",function(e){
        let money=moneyChequeInput.value;
        changeNumberToLetter(moneyChequeInput,"moneyInLettersAddAdd",money)
    })
}