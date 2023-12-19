//const baseUrl:string = 'http://192.168.10.26:8080';
function addNaghdMoneyPayAdd() {
    var monyInput = document.getElementById("rialNaghdPayAddInputAdd");
    var money = Number(monyInput.value);
    var naghdMoneyDescriptionInput = document.getElementById("descNaghdPayAddInputAdd");
    var description = naghdMoneyDescriptionInput.value;
    var payBys = new PayBys(1, 0, description, money, 0, 0, '', 0, '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '', '', 0);
    payBys.addPayBys();
    closeAddPayPartAddModal('addPayVajhNaghdAddModal');
}
function openAddPayPartAddModal(modalId) {
    var modal = document.getElementById(modalId);
    modal.style.display = "block";
    if (modalId == 'addPayChequeInfoAddModal') {
        fetch(baseUrl + '/allBanks', {
            method: 'GET'
        })
            .then(function (response) { return response.json(); })
            .then(function (data) {
            data.bankKarts.forEach(function (bank) {
                var option = document.createElement("option");
                option.text = bank.bsn;
                option.value = String(bank.SerialNoAcc);
                var selectBox = document.getElementById('hisabNoChequeInputAddPayAdd');
                selectBox.add(option);
            });
        });
        var customerNamePayHDSInput = document.getElementById('customerNamePayInput');
        var inVajhChequeNameInput = document.getElementById('inVajhChequeInputAddPayAdd');
        inVajhChequeNameInput.value = customerNamePayHDSInput.value;
        var customerIdPayHDSInput = document.getElementById('customerIdPayInput');
        var inVajhChequePSN = document.getElementById('inVajhChequePSNInputAddPayAdd');
        inVajhChequePSN.value = customerIdPayHDSInput.value;
    }
    if (modalId == 'AddPayHawalaFromBoxAddModal') {
        var bankNameSelect_1 = document.getElementById("addHawalaFromBoxAddBankNameInput");
        bankNameSelect_1.innerHTML = '';
        fetch(baseUrl + '/getBankList', {
            method: 'GET'
        })
            .then(function (response) { return response.json(); })
            .then(function (data) {
            data.forEach(function (bank) {
                var option = document.createElement("option");
                option.text = bank.NameBsn;
                option.value = String(bank.SerialNoBSN);
                bankNameSelect_1.add(option);
            });
        });
    }
    if (modalId == 'AddPayHawalaFromBankAddModal') {
        var selectHisabSn_1 = document.getElementById("addPayHawalaFromBankAddSelectHisabSn");
        selectHisabSn_1.innerHTML = '';
        selectHisabSn_1.add(new Option('', ''));
        fetch(baseUrl + '/allBanks', {
            method: 'GET'
        })
            .then(function (response) { return response.json(); })
            .then(function (data) {
            data.bankKarts.forEach(function (bank) {
                var option = document.createElement("option");
                option.text = bank.bsn;
                option.value = String(bank.SerialNoAcc);
                selectHisabSn_1.add(option);
            });
        });
        var bankNameSelect_2 = document.getElementById("addPayHawalaFromBankAddBankName");
        bankNameSelect_2.innerHTML = '';
        bankNameSelect_2.add(new Option('', ''));
        fetch(baseUrl + '/getBankList', {
            method: 'GET'
        })
            .then(function (response) { return response.json(); })
            .then(function (data) {
            data.forEach(function (bank) {
                var option = document.createElement("option");
                option.text = bank.NameBsn;
                option.value = String(bank.SerialNoBSN);
                bankNameSelect_2.add(option);
            });
        });
    }
}
function closeAddPayPartAddModal(modalId) {
    var modal = document.getElementById(modalId);
    modal.style.display = "none";
}
function openPaysModal(modalId) {
    var modal = document.getElementById(modalId);
    modal.style.display = "block";
    var selectBox = document.getElementById('boxPaysSelect');
    var boxSn = Number(selectBox.value);
    var boxIdPayInput = document.getElementById('boxIdPayInput');
    boxIdPayInput.value = String(boxSn);
    var boxModal = document.getElementById('selectBoxPaysModal');
    if (boxModal) {
        boxModal.style.display = "none";
    }
}
function addPayHawalaFromBankAdd() {
    var addPayHawalaFromBankAddInputInfoInput = document.getElementById("addPayHawalaFromBankAddInputInfo");
    var addPayHawalaFromBankAddSelectHisabSnInput = document.getElementById("addPayHawalaFromBankAddSelectHisabSn");
    var addPayHawalaFromBankAddHawalaNoInput = document.getElementById("addPayHawalaFromBankAddHawalaNo");
    var addPayHawalaFromBankAddHawalaDateInput = document.getElementById("addPayHawalaFromBankAddHawalaDate");
    var addPayHawalaFromBankAddHawalaHisabNoInput = document.getElementById("addPayHawalaFromBankAddHawalaHisabNo");
    var addPayHawalaFromBankAddBankNameInput = document.getElementById("addPayHawalaFromBankAddBankName");
    var addPayHawalaFromBankAddMalikHisabNameInput = document.getElementById("addPayHawalaFromBankAddMalikHisabName");
    var addPayHawalaFromBankAddShobeSnInput = document.getElementById("addPayHawalaFromBankAddShobeSn");
    var addPayHawalaFromBankAddDescInput = document.getElementById("addPayHawalaFromBankAddDesc");
    var addHawalaFromBankAddMoneyInput = document.getElementById("addHawalaFromBankAddMoneyInput");
    var addHawalaFromBankAddKarmozdInput = document.getElementById("addHawalaFromBankAddKarmozdInput");
    var addPayHawalaFromBankAddInputInfo = Number(addPayHawalaFromBankAddInputInfoInput.value);
    var bankHisabSn = Number(addPayHawalaFromBankAddSelectHisabSnInput.value);
    var hawalaNo = Number(addPayHawalaFromBankAddHawalaNoInput.value);
    var hawalaDate = String(addPayHawalaFromBankAddHawalaDateInput.value);
    var hisabNo = String(addPayHawalaFromBankAddHawalaHisabNoInput.value);
    var snBank = Number(addPayHawalaFromBankAddBankNameInput.value);
    var malikName = String(addPayHawalaFromBankAddMalikHisabNameInput.value);
    var addShobeName = String(addPayHawalaFromBankAddShobeSnInput.value);
    var description = String(addPayHawalaFromBankAddDescInput.value);
    var money = Number(addHawalaFromBankAddMoneyInput.value);
    var karmozd = Number(addHawalaFromBankAddKarmozdInput.value);
    var payBys = new PayBys(3, 0, description, money, 0, 0, hawalaDate, 0, hisabNo, snBank, 0, bankHisabSn, 0, 0, 0, 0, 0, 0, karmozd, addShobeName, malikName, hawalaNo);
    payBys.addPayBys();
    closeAddPayPartAddModal('AddPayHawalaFromBankAddModal');
}
function addTakhfifAddPayAdd() {
    var takhfifMoneyInputAddPayAdd = document.getElementById("takhfifMoneyInputAddPayAdd");
    var takhfif = Number(takhfifMoneyInputAddPayAdd.value);
    var discriptionTakhfifInputAddPayAdd = document.getElementById("discriptionTakhfifInputAddPayAdd");
    var descTakhfif = discriptionTakhfifInputAddPayAdd.value;
    var payBys = new PayBys(4, 0, descTakhfif, takhfif, 0, 0, '', 0, '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '', '', 0);
    payBys.addPayBys();
    closeAddPayPartAddModal('AddPayTakhfifAddModal');
}
function deletePayBys(payBysIndex) {
    var rowIndex = Number(payBysIndex);
    var payBys = new PayBys(0, rowIndex, '', 0, 0, 0, '', 0, '', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '', '', 0);
    swal({
        text: 'می خواهید این پرداخت را حذف کنید؟',
        buttons: ['cancel', 'delete'],
        dangerMode: true,
        icon: 'warning'
    }).then(function (willDelete) {
        if (willDelete) {
            payBys.deletePayBys(rowIndex);
        }
    });
}
function addChequeBtnAddPayAdd() {
}
function setAddedPayBysStuff(tableRow, type) {
    var editPayBYSButton = document.getElementById("editPayBYSButton");
    var deletePayBys = document.getElementById("deletePayBysButton");
    editPayBYSButton.value = "".concat(type);
    var tbody = document.querySelector('#paysAddTableBody');
    if (tbody) {
        var rows = tbody.querySelectorAll('tr');
        rows.forEach(function (row) {
            row.classList.remove('selected');
        });
    }
    tableRow.classList.add("selected");
    if (tbody) {
        var rows = tbody.querySelectorAll('tr');
        var index = Array.from(rows).indexOf(tableRow);
        deletePayBys.setAttribute('value', "".concat(index));
    }
}
function openSelectedBysModal(type) {
    var typeNumber = Number(type);
    var selectedElements = document.querySelectorAll('.selected');
    var selectedRow = selectedElements[0];
    var rowData = selectedRow.querySelectorAll('td');
    switch (typeNumber) {
        case 1:
            {
                var monyInput_1 = document.getElementById("rialNaghdPayAddInputEdit");
                var descInput_1 = document.getElementById("descNaghdPayAddInputEdit");
                rowData.forEach(function (td, index) {
                    var _a, _b;
                    if (td.children.item(0)) {
                        switch (index) {
                            case 19:
                                monyInput_1.value = String((_a = td.children.item(0)) === null || _a === void 0 ? void 0 : _a.getAttribute('value'));
                                break;
                            case 13:
                                descInput_1.value = String((_b = td.children.item(0)) === null || _b === void 0 ? void 0 : _b.getAttribute('value'));
                                break;
                        }
                    }
                });
                openAddPayVajhNaghdEditModal();
            }
            break;
        case 2:
            var chequeNoCheqeInputAddPayEdit = document.getElementById("chequeNoCheqeInputAddPayEdit");
            var checkSarRasidDateInputAddPayEdit = document.getElementById("checkSarRasidDateInputAddPayEdit");
            var daysAfterChequeDateInputAddPayEdit = document.getElementById("daysAfterChequeDateInputAddPayEdit");
            var shobeBankChequeInputAddPayEdit = document.getElementById("shobeBankChequeInputAddPayEdit");
            var SnBankInput = document.getElementById("bankNameSelectAddPayEdit");
            var moneyChequeInputAddPayEdit = document.getElementById("moneyChequeInputAddPayEdit");
            var malikChequeInputAddPayEdit = document.getElementById("malikChequeInputAddPayEdit");
            var sayyadiNoChequeInputAddPayEdit = document.getElementById("sayyadiNoChequeInputAddPayEdit");
            var descChequeInputAddPayEdit = document.getElementById("descChequeInputAddPayEdit");
            openAddPayChequeInfoEditModal();
            break;
        case 3:
            {
                var addFromHisabNoEditInput_1 = document.getElementById("addFromHisabNoEditInput");
                var addFromHisabNoEditSelect_1 = document.getElementById("addFromHisabNoEditSelect");
                var addHawalaNoEditInput_1 = document.getElementById("addHawalaNoEditInput");
                var addHawalaDateEditInput_1 = document.getElementById("addHawalaDateEditInput");
                var addToHisabNoEditInput_1 = document.getElementById("addToHisabNoEditInput");
                var addToBankEditInput_1 = document.getElementById("addToBankEditInput");
                var addToHisabOwnerEditInput_1 = document.getElementById("addToHisabOwnerEditInput");
                var addToBankShobeEditInput_1 = document.getElementById("addToBankShobeEditInput");
                var addDescEditInput_1 = document.getElementById("addDescEditInput");
                var addHawalaFromBankMoneyInput_1 = document.getElementById("addHawalaFromBankMoneyInput");
                var addHawalaFromBankKarmozdInput_1 = document.getElementById("addHawalaFromBankKarmozdInput");
                rowData.forEach(function (td, index) {
                    var _a, _b, _c, _d, _e, _f, _g, _h, _j, _k, _l;
                    if (td.children.item(0)) {
                        switch (index) {
                            case 14: //
                                {
                                    fetch(baseUrl + "/allBanks", {
                                        method: 'GET',
                                    }).then(function (res) {
                                        return res.json();
                                    }).then(function (data) {
                                        addFromHisabNoEditSelect_1.innerHTML = '';
                                        addFromHisabNoEditSelect_1.innerHTML = "<option value=\"0\">\u0627\u0646\u062A\u062E\u0627\u0628 \u06A9\u0646\u06CC\u062F</option>";
                                        data.bankKarts.forEach(function (hisab) {
                                            var _a;
                                            if (hisab.SerialNoAcc == String((_a = td.children.item(0)) === null || _a === void 0 ? void 0 : _a.getAttribute('value'))) {
                                                addFromHisabNoEditSelect_1.innerHTML += "<option selected value=\"".concat(hisab.SerialNoAcc, "\">").concat(hisab.bsn, "</option>");
                                                addFromHisabNoEditInput_1.value = String(hisab.AccNo);
                                            }
                                            else {
                                                addFromHisabNoEditSelect_1.innerHTML += "<option value=\"".concat(hisab.SerialNoAcc, "\">").concat(hisab.bsn, "</option>");
                                            }
                                        });
                                    });
                                }
                                break;
                            case 2:
                                addFromHisabNoEditSelect_1.value = String((_a = td.children.item(0)) === null || _a === void 0 ? void 0 : _a.getAttribute('value'));
                                break;
                            case 9: //
                                addHawalaNoEditInput_1.value = String((_b = td.children.item(0)) === null || _b === void 0 ? void 0 : _b.getAttribute('value'));
                                break;
                            case 8: //
                                addHawalaDateEditInput_1.value = String((_c = td.children.item(0)) === null || _c === void 0 ? void 0 : _c.getAttribute('value'));
                                break;
                            case 10:
                                addToHisabNoEditInput_1.value = String((_d = td.children.item(0)) === null || _d === void 0 ? void 0 : _d.getAttribute('value'));
                                break;
                            case 11:
                                {
                                    fetch(baseUrl + "/getBankList", {
                                        method: 'GET',
                                    }).then(function (res) {
                                        return res.json();
                                    }).then(function (data) {
                                        addToBankEditInput_1.innerHTML = '';
                                        addToBankEditInput_1.innerHTML = "<option value=\"0\">\u0627\u0646\u062A\u062E\u0627\u0628 \u06A9\u0646\u06CC\u062F</option>";
                                        data.forEach(function (bank) {
                                            var _a;
                                            if (bank.SerialNoBSN == String((_a = td.children.item(0)) === null || _a === void 0 ? void 0 : _a.getAttribute('value'))) {
                                                addToBankEditInput_1.innerHTML += "<option selected value=\"".concat(bank.SerialNoBSN, "\">").concat(bank.NameBsn, "</option>");
                                            }
                                            else {
                                                addToBankEditInput_1.innerHTML += "<option value=\"".concat(bank.SerialNoBSN, "\">").concat(bank.NameBsn, "</option>");
                                            }
                                        });
                                    });
                                }
                                break;
                            case 21:
                                addToHisabOwnerEditInput_1.value = String((_e = td.children.item(0)) === null || _e === void 0 ? void 0 : _e.getAttribute('value'));
                                break;
                            case 8:
                                // addToBankEditInput.value=String(td.children.item(0)?.getAttribute('value'));
                                break;
                            case 21:
                                addToHisabOwnerEditInput_1.value = String((_f = td.children.item(0)) === null || _f === void 0 ? void 0 : _f.getAttribute('value'));
                                break;
                            case 8:
                                //addToBankShobeEditInput.value=String(td.children.item(0)?.getAttribute('value'));
                                break;
                            case 13:
                                addDescEditInput_1.value = String((_g = td.children.item(0)) === null || _g === void 0 ? void 0 : _g.getAttribute('value'));
                                break;
                            case 22:
                                addHawalaNoEditInput_1.value = String((_h = td.children.item(0)) === null || _h === void 0 ? void 0 : _h.getAttribute('value'));
                                break;
                            case 23:
                                {
                                    addToBankShobeEditInput_1.value = String((_j = td.children.item(0)) === null || _j === void 0 ? void 0 : _j.getAttribute('value'));
                                }
                                break;
                            case 19:
                                {
                                    addHawalaFromBankMoneyInput_1.value = String((_k = td.children.item(0)) === null || _k === void 0 ? void 0 : _k.getAttribute('value'));
                                }
                                break;
                            case 24:
                                {
                                    addHawalaFromBankKarmozdInput_1.value = String((_l = td.children.item(0)) === null || _l === void 0 ? void 0 : _l.getAttribute('value'));
                                }
                                break;
                        }
                    }
                });
            }
            openAddPayHawalaFromBankEditModal();
            break;
        case 4:
            {
                var takhfifInput_1 = document.getElementById("takhfifMoneyInputAddPayEdit");
                var discriptionInput_1 = document.getElementById("discriptionTakhfifInputAddPayEdit");
                rowData.forEach(function (td, index) {
                    var _a, _b;
                    if (td.children.item(0)) {
                        switch (index) {
                            case 19:
                                takhfifInput_1.value = String((_a = td.children.item(0)) === null || _a === void 0 ? void 0 : _a.getAttribute('value'));
                                break;
                            case 13:
                                discriptionInput_1.value = String((_b = td.children.item(0)) === null || _b === void 0 ? void 0 : _b.getAttribute('value'));
                                break;
                        }
                    }
                });
                openAddPayTakhfifEditModal();
            }
            break;
        case 5:
            {
                var boxNoInput_1 = document.getElementById("addHawalaFromBoxBoxNoEditInput");
                var hawalaDateInput_1 = document.getElementById("addHawalaFromBoxDateEditInput");
                var moneyInput_1 = document.getElementById("addHawalaFromBoxMoneyInput");
                var karmozdInput_1 = document.getElementById("addHawalaFromBoxKarmozdInput");
                var hisabNoInput_1 = document.getElementById("addHawalaFromBoxHisabNoInput");
                var hisabOwnerInput_1 = document.getElementById("addHawalaFromBoxOwnerNameInput");
                var bankInput_1 = document.getElementById("addHawalaFromBoxBankSnInput");
                var descInput_2 = document.getElementById("addHawalaFromBoxDescInput");
                var bankShobeInput_1 = document.getElementById("addHawalaFromBoxBranchNameInput");
                rowData.forEach(function (td, index) {
                    var _a, _b, _c, _d, _e, _f, _g, _h;
                    if (td.children.item(0)) {
                        switch (index) {
                            case 9: //
                                boxNoInput_1.value = String((_a = td.children.item(0)) === null || _a === void 0 ? void 0 : _a.getAttribute('value'));
                                break;
                            case 8: //
                                hawalaDateInput_1.value = String((_b = td.children.item(0)) === null || _b === void 0 ? void 0 : _b.getAttribute('value'));
                                break;
                            case 11:
                                {
                                    fetch(baseUrl + "/getBankList", {
                                        method: 'GET',
                                    }).then(function (res) {
                                        return res.json();
                                    }).then(function (data) {
                                        bankInput_1.innerHTML = '';
                                        bankInput_1.innerHTML = "<option value=\"0\">\u0627\u0646\u062A\u062E\u0627\u0628 \u06A9\u0646\u06CC\u062F</option>";
                                        data.forEach(function (bank) {
                                            var _a;
                                            if (bank.SerialNoBSN == String((_a = td.children.item(0)) === null || _a === void 0 ? void 0 : _a.getAttribute('value'))) {
                                                bankInput_1.innerHTML += "<option selected value=\"".concat(bank.SerialNoBSN, "\">").concat(bank.NameBsn, "</option>");
                                            }
                                            else {
                                                bankInput_1.innerHTML += "<option value=\"".concat(bank.SerialNoBSN, "\">").concat(bank.NameBsn, "</option>");
                                            }
                                        });
                                    });
                                }
                                break;
                            case 8:
                                // addToBankEditInput.value=String(td.children.item(0)?.getAttribute('value'));
                                break;
                            case 21:
                                hisabOwnerInput_1.value = String((_c = td.children.item(0)) === null || _c === void 0 ? void 0 : _c.getAttribute('value'));
                                break;
                            case 8:
                                //addToBankShobeEditInput.value=String(td.children.item(0)?.getAttribute('value'));
                                break;
                            case 13:
                                descInput_2.value = String((_d = td.children.item(0)) === null || _d === void 0 ? void 0 : _d.getAttribute('value'));
                                break;
                            case 10:
                                hisabNoInput_1.value = String((_e = td.children.item(0)) === null || _e === void 0 ? void 0 : _e.getAttribute('value'));
                                break;
                            case 23:
                                {
                                    bankShobeInput_1.value = String((_f = td.children.item(0)) === null || _f === void 0 ? void 0 : _f.getAttribute('value'));
                                }
                                break;
                            case 19:
                                {
                                    moneyInput_1.value = String((_g = td.children.item(0)) === null || _g === void 0 ? void 0 : _g.getAttribute('value'));
                                }
                                break;
                            case 24:
                                {
                                    karmozdInput_1.value = String((_h = td.children.item(0)) === null || _h === void 0 ? void 0 : _h.getAttribute('value'));
                                }
                                break;
                        }
                    }
                });
                openAddPayHawalaFromBoxEditModal();
            }
            break;
    }
}
var addPayHawalaFromBankAddSelectHisabSn = document.getElementById("addPayHawalaFromBankAddSelectHisabSn");
var addPayHawalaFromBankAddInputInfo = document.getElementById("addPayHawalaFromBankAddInputInfo");
if (addPayHawalaFromBankAddSelectHisabSn) {
    addPayHawalaFromBankAddSelectHisabSn.addEventListener("change", function () {
        var hisabNo = Number(addPayHawalaFromBankAddSelectHisabSn.value);
        var url = new URLSearchParams();
        url.append("bankSn", String(hisabNo));
        fetch(baseUrl + "/getBankInfo?".concat(url.toString()), {
            method: 'GET',
        }).then(function (response) {
            return response.json();
        }).then(function (respond) {
            addPayHawalaFromBankAddInputInfo.value = String(respond[0].AccNo);
        });
    });
}
function addHawalaFromBoxAddPayAdd() {
    var hawalaNoInput = document.getElementById("addHawalaFromBoxAddInputNumber");
    var deateInput = document.getElementById("addHawalaFromBoxAddDateInput");
    var moneyInput = document.getElementById("addHawalaFromBoxAddMoneyInput");
    var karmozdInput = document.getElementById("addHawalaFromBoxAddKarmozdInput");
    var hisabNoInput = document.getElementById("addHawalaFromBoxAddNumberHisabInput");
    var bankNameInput = document.getElementById("addHawalaFromBoxAddBankNameInput");
    var branchNameInput = document.getElementById("addHawalaFromBoxAddBranchSnInput");
    var addHawalaFromBoxAddDescInput = document.getElementById("addHawalaFromBoxAddDescInput");
    var ownerNameInput = document.getElementById("addHawalaFromBoxAddMalikNameInput");
    var hawalaNo = Number(hawalaNoInput.value);
    var hawalaDate = String(deateInput.value);
    var money = Number(moneyInput.value);
    var addHawalaFromBoxAddKarmozd = Number(karmozdInput.value);
    var hisabNo = String(hisabNoInput.value);
    var bankSn = Number(bankNameInput.value);
    var branchName = String(branchNameInput.value);
    var description = String(addHawalaFromBoxAddDescInput.value);
    var ownerName = String(ownerNameInput.value);
    var payBys = new PayBys(3, 0, description, money, 0, 0, hawalaDate, 0, hisabNo, bankSn, 0, 0, 0, 0, 0, 0, hawalaNo, 0, addHawalaFromBoxAddKarmozd, branchName, ownerName, 0);
    payBys.addPayBys();
    closeAddPayPartAddModal('AddPayHawalaFromBoxAddModal');
}
function addChequePayAdd() {
    var chequeNumberInput = document.getElementById("chequeNoCheqeInputAddPayAdd");
    var sarRasidInput = document.getElementById("checkSarRasidDateInputAddPayAdd");
    var moneyChequeInputAddPayAdd = document.getElementById("moneyChequeInputAddPayAdd");
    var hisabNoChequeInputAddPayAdd = document.getElementById("hisabNoChequeInputAddPayAdd");
    var sayyadiNoChequeInputAddPayAdd = document.getElementById("sayyadiNoChequeInputAddPayAdd");
    var radifInChequeBookSelect = document.getElementById("radifInChequeBookSelectAddPayAdd");
    var inVajhChequeInputAddPayAdd = document.getElementById("inVajhChequeInputAddPayAdd");
    var chequeNumber = Number(chequeNumberInput.value);
    var sarRasidDate = String(sarRasidInput.value);
    var moneyCheque = Number(moneyChequeInputAddPayAdd.value);
    var hisabNo = String(hisabNoChequeInputAddPayAdd.value);
    var sayyadiNo = Number(sayyadiNoChequeInputAddPayAdd.value);
    var radifInCheque = Number(radifInChequeBookSelect.value);
    var inVajhChequePSN = Number(inVajhChequeInputAddPayAdd.value);
    var payBys = new PayBys(2, 0, '', moneyCheque, radifInCheque, sayyadiNo, sarRasidDate, chequeNumber, hisabNo, 0, 0, 0, 0, 0, 0, 0, 0, inVajhChequePSN, 0, '', '', 0);
    payBys.addPayBys();
    closeAddPayPartAddModal('addPayChequeInfoAddModal');
}
var PayBys = /** @class */ (function () {
    function PayBys(payBYSType, payBYSIndex, payBYSDesc, payBYSMoney, payBYSRadifInChequeBook, sayyadiNoCheque, checkSarRasidDate, chequeNoCheqe, accBankNo, bankSn, SnChequeBook, snAccBank, noPayanehKartKhanBYS, snPeopelPay, repeateCheque, distanceMonthCheque, cashNo, inVajhPeopelSn, Karmozd, branchName, ownerName, hawalaNo) {
        this.payBYSType = payBYSType;
        this.payBYSIndex = payBYSIndex;
        this.payBYSDesc = payBYSDesc;
        this.payBYSMoney = payBYSMoney;
        this.payBYSRadifInChequeBook = payBYSRadifInChequeBook;
        this.sayyadiNoCheque = sayyadiNoCheque;
        this.payBYSType = payBYSType;
        this.checkSarRasidDate = checkSarRasidDate;
        this.chequeNoCheqe = chequeNoCheqe;
        this.bankSn = bankSn;
        this.SnChequeBook = SnChequeBook;
        this.descBYS = payBYSDesc;
        this.snAccBank = snAccBank;
        this.noPayanehKartKhanBYS = noPayanehKartKhanBYS;
        this.snPeopelPay = snPeopelPay;
        this.repeateCheque = repeateCheque;
        this.distanceMonthCheque = distanceMonthCheque;
        this.cashNo = cashNo;
        this.SnMainPeopel = inVajhPeopelSn;
        this.AccBankNo = String(accBankNo);
        this.Karmozd = Karmozd;
        this.BranchName = String(branchName);
        this.ownerName = String(ownerName);
        this.hawalaNo = hawalaNo;
    }
    PayBys.prototype.addPayBys = function () {
        var tableBody = document.getElementById("paysAddTableBody");
        var tableRow = document.createElement('tr');
        var rowNumber = tableBody.childElementCount;
        var modalTypeFlag = 0;
        if (this.snAccBank == 0 && this.payBYSType == 3) {
            modalTypeFlag = 5;
        }
        else {
            modalTypeFlag = this.payBYSType;
        }
        tableRow.setAttribute("onclick", "setAddedPayBysStuff(this," + modalTypeFlag + ")");
        for (var i = 0; i < 25; i++) {
            var tableData = document.createElement('td');
            switch (i) {
                case 0:
                    {
                        tableData.setAttribute("class", "text-center");
                        tableData.innerText = "".concat(rowNumber + 1);
                    }
                    break;
                case 1:
                    {
                        tableData.setAttribute("class", "text-center");
                        tableData.innerText = "".concat(this.payBYSDesc);
                    }
                    break;
                case 2:
                    {
                        tableData.setAttribute("class", "text-center");
                        tableData.innerText = "".concat(this.payBYSMoney);
                    }
                    break;
                case 3:
                    {
                        tableData.setAttribute("class", "text-center");
                        tableData.innerText = "";
                    }
                    break;
                case 4:
                    {
                        tableData.setAttribute("class", "text-center");
                        tableData.innerText = "";
                    }
                    break;
                case 5:
                    {
                        tableData.setAttribute("class", "d-none");
                        tableData.innerHTML = "<input type=\"checkbox\" class=\"form-check-input\" value=\"".concat(rowNumber, "\" name=\"BYSs[]\"/>");
                    }
                    break;
                case 6:
                    {
                        tableData.setAttribute("class", "d-none");
                        tableData.innerHTML = "<input type=\"text\" class=\"form-check-input\" value=\"".concat(this.payBYSType, "\" name=\"BysType").concat(rowNumber, "\"/>");
                    }
                    break;
                case 7:
                    {
                        tableData.setAttribute("class", "d-none");
                        tableData.innerHTML = "<input type=\"text\" value=\"".concat(this.sayyadiNoCheque, "\" name=\"sayyadiNoCheque").concat(rowNumber, "\"/>");
                    }
                    break;
                case 8:
                    {
                        tableData.setAttribute("class", "d-none");
                        tableData.innerHTML = "<input type=\"text\" value=\"".concat(this.checkSarRasidDate, "\" name=\"checkSarRasidDate").concat(rowNumber, "\"/>");
                    }
                    break;
                case 9:
                    {
                        tableData.setAttribute("class", "d-none");
                        tableData.innerHTML = "<input type=\"text\" value=\"".concat(this.chequeNoCheqe, "\" name=\"chequeNoCheqe").concat(rowNumber, "\"/>");
                    }
                    break;
                case 10:
                    {
                        tableData.setAttribute("class", "d-none");
                        tableData.innerHTML = "<input type=\"text\" value=\"".concat(this.AccBankNo, "\" name=\"hisabNoCheque").concat(rowNumber, "\"/>");
                    }
                    break;
                case 11:
                    {
                        tableData.setAttribute("class", "d-none");
                        tableData.innerHTML = "<input type=\"text\" value=\"".concat(this.bankSn, "\" name=\"SnBank").concat(rowNumber, "\"/>");
                    }
                    break;
                case 12:
                    {
                        tableData.setAttribute("class", "d-none");
                        tableData.innerHTML = "<input type=\"text\" value=\"".concat(this.SnChequeBook, "\" name=\"SnChequeBook").concat(rowNumber, "\"/>");
                    }
                    break;
                case 13:
                    {
                        tableData.setAttribute("class", "d-none");
                        tableData.innerHTML = "<input type=\"text\" value=\"".concat(this.descBYS, "\" name=\"DocDescBys").concat(rowNumber, "\"/>");
                    }
                    break;
                case 14:
                    {
                        tableData.setAttribute("class", "d-none");
                        tableData.innerHTML = "<input type=\"text\" value=\"".concat(this.snAccBank, "\" name=\"SnAccBank").concat(rowNumber, "\"/> ");
                    }
                    break;
                case 15:
                    {
                        tableData.setAttribute("class", "d-none");
                        tableData.innerHTML = "<input type=\"text\" value=\"".concat(this.noPayanehKartKhanBYS, "\" name=\"NoPayanehKartKhanBYS").concat(rowNumber, "\"/>");
                    }
                    break;
                case 16:
                    {
                        tableData.setAttribute("class", "d-none");
                        tableData.innerHTML = "<input type=\"text\" value=\"".concat(this.snPeopelPay, "\" name=\"SnPeopelPay").concat(rowNumber, "\"/>");
                    }
                    break;
                case 17:
                    {
                        tableData.setAttribute("class", "d-none");
                        tableData.innerHTML = "<input type=\"text\" value=\"".concat(this.repeateCheque, "\" name=\"repeatChequ").concat(rowNumber, "\"/>");
                    }
                    break;
                case 18:
                    {
                        tableData.setAttribute("class", "d-none");
                        tableData.innerHTML = "<input type=\"text\" value=\"".concat(this.distanceMonthCheque, "\" name=\"distanceMonthCheque").concat(rowNumber, "\"/>");
                    }
                    break;
                case 19:
                    {
                        tableData.setAttribute("class", "d-none");
                        tableData.innerHTML = "<input type=\"text\" value=\"".concat(this.payBYSMoney, "\" name=\"price").concat(rowNumber, "\"/>");
                    }
                    break;
                case 20:
                    {
                        tableData.setAttribute("class", "d-none");
                        tableData.innerHTML = "<input type=\"text\" value=\"".concat(this.SnMainPeopel, "\" name=\"SnMainPeopel").concat(rowNumber, "\"/>");
                    }
                    break;
                case 21:
                    {
                        tableData.setAttribute("class", "d-none");
                        tableData.innerHTML = "<input type=\"text\" value=\"".concat(this.ownerName, "\" name=\"ownerName").concat(rowNumber, "\"/>");
                    }
                    break;
                case 22:
                    {
                        tableData.setAttribute("class", "d-none");
                        tableData.innerHTML = "<input type=\"text\" value=\"".concat(this.hawalaNo, "\" name=\"hawalaNo").concat(rowNumber, "\"/>");
                    }
                    break;
                case 23:
                    {
                        tableData.setAttribute("class", "d-none");
                        tableData.innerHTML = "<input type=\"text\" value=\"".concat(this.BranchName, "\" name=\"hawalaDate").concat(rowNumber, "\"/>");
                    }
                    break;
                case 24:
                    {
                        tableData.setAttribute("class", "d-none");
                        tableData.innerHTML = "<input type=\"text\" value=\"".concat(this.Karmozd, "\" name=\"hawalaDate").concat(rowNumber, "\"/>");
                    }
                    break;
            }
            tableRow.appendChild(tableData);
        }
        tableBody.appendChild(tableRow);
    };
    PayBys.prototype.deletePayBys = function (rowIndex) {
        var tableBody = document.getElementById("paysAddTableBody");
        tableBody.deleteRow(rowIndex);
    };
    PayBys.prototype.consoleBYS = function (payBys) {
        console.log(payBys);
    };
    return PayBys;
}());
var daysAfterChequeDateAddInput = document.getElementById("daysAfterChequeDateInputAddPayAdd");
if (daysAfterChequeDateAddInput) {
    daysAfterChequeDateAddInput.addEventListener("keyup", function (e) {
        var daysLater = daysAfterChequeDateAddInput.value;
        if (parseInt(daysLater) > 0) {
            var chequeSarRasidDateInput = document.getElementById("checkSarRasidDateInputAddPayAdd");
            var chequeDate = chequeSarRasidDateInput.getAttribute("data-gdate");
            if (chequeDate) {
                var laterChequeDate = new Date(chequeDate);
                var newDate = new Date().setDate(new Date(laterChequeDate).getDate() + parseInt(daysLater));
                var updateDateHijri = new Intl.DateTimeFormat('fa-IR', { year: 'numeric', month: '2-digit', day: '2-digit' }).format(newDate);
                chequeSarRasidDateInput.value = updateDateHijri;
            }
        }
        else {
            var chequeSarRasidDateInput = document.getElementById("checkSarRasidDateInputAddPayAdd");
            var chequeDate = chequeSarRasidDateInput.getAttribute("data-gdate");
            if (chequeDate) {
                var laterChequeDate = new Date(chequeDate);
                var newDate = new Date().setDate(new Date(laterChequeDate).getDate() + 0);
                var updateDateHijri = new Intl.DateTimeFormat('fa-IR', { year: 'numeric', month: '2-digit', day: '2-digit' }).format(newDate);
                chequeSarRasidDateInput.value = updateDateHijri;
            }
        }
    });
}
var moneyChequeInput = document.getElementById("moneyChequeInputAddPayAdd");
if (moneyChequeInput) {
    moneyChequeInput.addEventListener("keyup", function (e) {
        var money = moneyChequeInput.value;
        changeNumberToLetter(moneyChequeInput, "moneyInLettersAddAdd", money);
    });
}
