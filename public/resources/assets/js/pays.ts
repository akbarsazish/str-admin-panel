
function addNaghdMoneyPayAdd(){
    const monyInput: HTMLInputElement = document.getElementById("rialNaghdPayAddInputAdd") as HTMLInputElement;
    const money: number = Number(monyInput.value);
    const naghdMoneyDescriptionInput: HTMLInputElement = document.getElementById("descNaghdPayAddInputAdd") as HTMLInputElement;
    const description: string = naghdMoneyDescriptionInput.value;
    const payBys = new PayBys(1,0,description,money,0,0,'',0,'',0,0,0,0,0,0,0,0,0,0,'');
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
    const payBys = new PayBys(2,0,'',moneyCheque,radifInCheque,sayyadiNo,sarRasidDate,chequeNumber,hisabNo,0,0,0,0,0,0,0,0,inVajhChequePSN,0,'');
    payBys.addPayBys();
    closeAddPayPartAddModal('addPayChequeInfoAddModal');
}

function addHawalaFromBoxAddPayAdd(){
    const addHawalaFromBoxAddNumberInput:HTMLInputElement=document.getElementById("addHawalaFromBoxAddInputNumber") as HTMLInputElement;
    const addHawalaFromBoxAddDateInput:HTMLInputElement=document.getElementById("addHawalaFromBoxAddDateInput") as HTMLInputElement;
    const addHawalaFromBoxAddMoneyInput:HTMLInputElement=document.getElementById("addHawalaFromBoxAddMoneyInput") as HTMLInputElement;
    const addHawalaFromBoxAddKarmozdInput:HTMLInputElement=document.getElementById("addHawalaFromBoxAddKarmozdInput") as HTMLInputElement;
    const addHawalaFromBoxAddNumberHisabInput:HTMLInputElement=document.getElementById("addHawalaFromBoxAddNumberHisabInput") as HTMLInputElement;
    const addHawalaFromBoxAddBankNameInput:HTMLInputElement=document.getElementById("addHawalaFromBoxAddBankNameInput") as HTMLInputElement;
    const addHawalaFromBoxAddBranchSnInput:HTMLInputElement=document.getElementById("addHawalaFromBoxAddBranchSnInput") as HTMLInputElement;
    const addHawalaFromBoxAddDescInput:HTMLInputElement=document.getElementById("addHawalaFromBoxAddDescInput") as HTMLInputElement;

    const boxNo:number=Number(addHawalaFromBoxAddNumberInput.value);
    const hawalaDate:String=String(addHawalaFromBoxAddDateInput.value);
    const money:number=Number(addHawalaFromBoxAddMoneyInput.value);
    const addHawalaFromBoxAddKarmozd:number=Number(addHawalaFromBoxAddKarmozdInput.value);
    const hisabNo:String=String(addHawalaFromBoxAddNumberHisabInput.value);
    const addHawalaFromBoxAddBankName:string=String(addHawalaFromBoxAddBankNameInput.value);
    const addHawalaFromBoxAddBranchSn:number=Number(addHawalaFromBoxAddBranchSnInput.value);
    const description:string=String(addHawalaFromBoxAddDescInput.value);
    const payBys = new PayBys(3,0,description,money,0,0,hawalaDate,0,hisabNo,0,0,0,0,0,0,0,boxNo,0,addHawalaFromBoxAddKarmozd,'');
    payBys.addPayBys();
    closeAddPayPartAddModal('AddPayHawalaFromBoxAddModal');
}

function addTakhfifAddPayAdd(){
    const takhfifMoneyInputAddPayAdd:HTMLInputElement=document.getElementById("takhfifMoneyInputAddPayAdd") as HTMLInputElement;
    const takhfif:number=Number(takhfifMoneyInputAddPayAdd.value);
    const discriptionTakhfifInputAddPayAdd:HTMLInputElement=document.getElementById("discriptionTakhfifInputAddPayAdd") as HTMLInputElement;
    const descTakhfif:string=discriptionTakhfifInputAddPayAdd.value;
    const payBys = new PayBys(4,0,descTakhfif,takhfif,0,0,'',0,'',0,0,0,0,0,0,0,0,0,0,'');
    payBys.addPayBys();
    closeAddPayPartAddModal('AddPayTakhfifAddModal');
}



function deletePayBys(payBysIndex: number){
    let rowIndex:number=Number(payBysIndex);
    let payBys: PayBys = new PayBys(0,rowIndex,'',0,0,0,'',0,'',0,0,0,0,0,0,0,0,0,0,'');
    
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
            rowData.forEach((td,index)=>{
                if(td.children.item(0)){
                    switch (index) {
                        case 10://
                            addFromHisabNoEditInput.value=String(td.children.item(0)?.getAttribute('value'));
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
                        case 1:
                            addToHisabNoEditInput.value=String(td.children.item(0)?.getAttribute('value'));
                            break;
                        case 6:
                            addToBankEditInput.value=String(td.children.item(0)?.getAttribute('value'));
                            break;
                        case 7:
                            addToHisabOwnerEditInput.value=String(td.children.item(0)?.getAttribute('value'));
                            break;
                        case 8:
                            addToBankShobeEditInput.value=String(td.children.item(0)?.getAttribute('value'));
                            break;
                        case 9:
                            addDescEditInput.value=String(td.children.item(0)?.getAttribute('value'));
                            break;
                    }
                }
            })
        }
            openAddPayHawalaFromBankEditModal()
            break;
        case 4:
            openAddPayTakhfifEditModal()
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
    const addPayHawalaFromBankAddHawalaNo:number=Number(addPayHawalaFromBankAddHawalaNoInput.value);
    const hawalaDate:String=String(addPayHawalaFromBankAddHawalaDateInput.value);
    const hisabNo:String=String(addPayHawalaFromBankAddHawalaHisabNoInput.value);
    const addPayHawalaFromBankAddBankName:string=String(addPayHawalaFromBankAddBankNameInput.value);
    const addPayHawalaFromBankAddMalikHisabName:string=String(addPayHawalaFromBankAddMalikHisabNameInput.value);
    const addPayHawalaFromBankAddShobeSn:number=Number(addPayHawalaFromBankAddShobeSnInput.value);
    const description:string=String(addPayHawalaFromBankAddDescInput.value);
    const addHawalaFromBankAddMoney:number=Number(addHawalaFromBankAddMoneyInput.value);
    const addHawalaFromBankAddKarmozd:number=Number(addHawalaFromBankAddKarmozdInput.value);
    const payBys = new PayBys(3,0,description,addHawalaFromBankAddMoney,0,0,hawalaDate,0,hisabNo,0,0,bankHisabSn,0,0,0,0,0,0,0,'');
    payBys.addPayBys();
    closeAddPayPartAddModal('AddPayHawalaFromBankAddModal');
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
    bankSn:number;
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

    constructor(payBYSType:number,payBYSIndex: number, payBYSDesc: string, payBYSMoney: number, payBYSRadifInChequeBook: number, sayyadiNoCheque: number
        ,checkSarRasidDate:String,chequeNoCheqe:number,accBankNo:String,
        bankSn:number,SnChequeBook:number,snAccBank:number,noPayanehKartKhanBYS:number,
        snPeopelPay:number,repeateCheque:number,distanceMonthCheque:number,cashNo:number,inVajhPeopelSn:number,Karmozd:number,branchName:String){
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
    }

    addPayBys(){
        let tableBody : HTMLTableSectionElement = document.getElementById("paysAddTableBody") as HTMLTableSectionElement;
        let tableRow = document.createElement('tr');
        let rowNumber: number = tableBody.childElementCount;
        tableRow.setAttribute("onclick", `setAddedPayBysStuff(this,`+this.payBYSType+`)`);
        for(let i = 0; i < 21; i++){
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
                        tableData.innerHTML = `<input type="text" class="form-check-input" value="${rowNumber}" name="BysType${rowNumber}"/>`;
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
                        tableData.innerHTML = `<input type="text" value="${this.checkSarRasidDate}" name="checkSarRasidDate${rowNumber}"`;
                    }
                    break;
                case 9:
                    {
                        tableData.setAttribute("class", "d-none");
                        tableData.innerHTML = `<input type="text" value="${this.chequeNoCheqe}" name="chequeNoCheqe${rowNumber}"`;
                    }
                    break;
                case 10:
                    {
                        tableData.setAttribute("class", "d-none");
                        tableData.innerHTML = `<input type="text" value="${this.AccBankNo}" name="hisabNoCheque${rowNumber}"`;
                    }
                    break;
                    case 11:
                        {
                        tableData.setAttribute("class", "d-none");
                        tableData.innerHTML = `<input type="text" value="${this.bankSn}" name="SnBank${rowNumber}"`;
                    }
                    break;
                    case 12:
                        {
                        tableData.setAttribute("class", "d-none");
                        tableData.innerHTML = `<input type="text" value="${this.SnChequeBook}" name="SnChequeBook${rowNumber}" class=""/>`;
                    }
                    break;
                    case 13:
                        {
                            tableData.setAttribute("class", "d-none");
                            tableData.innerHTML = `<input type="text" value="${this.descBYS}" name="DocDescBys${rowNumber}" class=""/>`;
                        }
                    break;
                    case 14:
                        {
                            tableData.setAttribute("class", "d-none");
                            tableData.innerHTML = `<input type="text" value="${this.snAccBank}" name="SnAccBank${rowNumber}" class=""/> `;
                        }
                    break;
                    case 15:
                        {
                        tableData.setAttribute("class", "d-none");
                        tableData.innerHTML = `<input type="text" value="${this.noPayanehKartKhanBYS}" name="NoPayanehKartKhanBYS${rowNumber}" class=""/>`;
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
                            tableData.innerHTML = `<input type="text" value="${this.payBYSMoney}" name="distanceYearCheque${rowNumber}"/>`;
                        }
                    break;
                    case 20:
                        {
                            tableData.setAttribute("class", "d-none");
                            tableData.innerHTML = `<input type="text" value="${this.SnMainPeopel}" name="distanceMonthCheque${rowNumber}"/>`;
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