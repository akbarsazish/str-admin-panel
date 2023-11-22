$(document).ready(function () {
    var baseUrl = "https://starfoods.ir";
    $('#listKala tr').on('click', function () {
        $(this).find('input:radio').prop('checked', true);
        let inp = $(this).find('input:radio:checked');
        $('td.selected').removeClass("selected");
        $(this).children('td').addClass('selected');
        $("#kalaIdForEdit1").val(inp.val().split("_")[0]);

        $("#firstPrice").val(parseInt(inp.val().split("_")[1]).toLocaleString("en-US"));
        $("#secondPrice").val(parseInt(inp.val().split("_")[2]).toLocaleString("en-US"));
        // $("#kalaId").val(parseInt(inp.val().split("_")[0]));

        if (document.querySelector("#editKalaList")) {
            document.querySelector("#editKalaList").disabled = false;
        }

    });

    $("#deleteKalaPictureButton").on("click", () => {
        deleteKalaPicture($("#deleteKalaPictureButton").val(), $("#deleteKalaPictureButton"));
    })
    $("#openEditKalaModal").on("click", () => {
        const kalaId = $("#kalaIdForEdit").val();
        $("#kalaIdForAddStock").val(kalaId);
        $("#kalaIdSpecialRest").val(kalaId);
        $("#kalaIdEdit").val(kalaId);
        $("#kalaIdDescription").val(kalaId);
        $("#kalaIdSameKala").val(kalaId);
        $.get(baseUrl + '/resources/assets/images/kala/' + kalaId + '_1.jpg')
            .done(function () {
                $('#mainPicEdit').attr('src', baseUrl + '/resources/assets/images/kala/' + kalaId + '_1.jpg');
                $("#deleteKalaPictureButton").show();
                $("#deleteKalaPictureButton").val(kalaId);
            }).fail(function () {
                $('#mainPicEdit').attr('src', '');
                $("#deleteKalaPictureButton").hide();
            })

        $("#kalaIdChangePic").val(kalaId);
        $.ajax({
            method: "get",
            dataType: "json",
            url: baseUrl + "/getKalaInfoForEdit",
            data: {
                _token: "{{ csrf_token() }}",
                kalaId: kalaId
            },
            async: true,
            success: function (data) {
                let kala = data[0];
                let maingroupList = data[1];
                let stocks = data[2];
                let sameKala = data[3];
                let addedStocks = data[4];
                let costInfo = data[5];
                let kalaPriceCycle = data[6];
                $("#original").text(kala.NameGRP);
                $("#editKalaTitle").text("ویرایش :  " + "  " + kala.GoodName);
                $("#subsidiary").text(kala.NameGRP);
                $("#mainPrice").text(parseInt(kala.mainPrice).toLocaleString("en-us"));
                $("#overLinePrice").text(parseInt(kala.overLinePrice).toLocaleString("en-us"));
                $("#costLimit").val(kala.costLimit);
                $("#costContent").val(kala.costError);
                $("#costAmount").val(kala.costAmount);
                $("#existanceAlarm").val(kala.alarmAmount);
                $("#descriptionKala").text(kala.descProduct);
				$("#kalaTags").val(kala.senonym);
                $("#minSaleValue").text(kala.minSale + " " + kala.secondUnit + " " + " تعیین شده است ");
                $("#maxSaleValue").text(kala.maxSale + " " + kala.secondUnit + " " + " تعیین شده است ");

                $("#maingroupTableBody").empty();
                maingroupList.forEach((element, index) => {
                    let bgColor = "";
                    if (element.exist === 'ok') {
                        bgColor = "red";
                    }

                    $("#maingroupTableBody").append(`
                     <tr id="grouptableRow" class="forActiveTr" style="background-color: `+ bgColor + `">
                        <td>`+ (index + 1) + `</td>
                        <td>`+ element.title + `</td>
                        <td><input type="checkBox" class="form-check-input" disabled `+ (element.exist === 'ok' ? 'checked' : 'unchecked') + ` ></td>
                        <td>
                            <input class="mainGroupId form-check-input" type="radio" value="`+ element.id + `_` + kala.GoodSn + `" name="IDs[]" id="flexCheckChecked">
                            <input class="mainGroupId" type="text" value="`+ kala.GoodSn + `" name="ProductId" id="GoodSn" style="display: none">
                        </td>
                    </tr>`
                    );


                    $("#costTypeInfo").empty();
                    costInfo.forEach((element, index) => {
                        $("#costTypeInfo").append(`
                <option `+ (kala.inforsType == element.SnInfor ? "selected" : " ") + ` value="` + element.SnInfor + `">` + element.InforName + `</option> 
            `)
                    });

                    // while check takhsis Anbar Checkbox it will append to the bottome table 
                    $("#allStockForList").empty();
                    stocks.forEach((element, index) => {
                        $("#allStockForList").append(`
                    <tr>
                        <td>`+ (index + 1) + `</td>
                        <td>`+ element.NameStock + `</td>
                        <td>
                            <input class="form-check-input" name="stock[]" type="checkbox" value="`+ element.SnStock + '_' + element.NameStock + `" id="stockId">
                        </td>
                    </tr>
                 `)
                    });



                    $(document).on('click', '#removeStocksFromWeb', (function () {
                        $('tr').find('input:checkbox:checked').attr("name", "removeStocksFromWeb[]");
                        $('tr').has('input:checkbox:checked').hide();
                    }));


                    $(document).on('click', '#addStockToWeb', (function () {
                        var kalaListID = [];
                        $('input[name="allStocks[]"]:checked').map(function () {
                            kalaListID.push($(this).val());
                        });

                        $('input[name="allStocks[]"]:checked').parents('tr').css('color', 'white');
                        $('input[name="allStocks[]"]:checked').parents('tr').children('td').css('background-color', 'red');
                        $('input[name="allStocks[]"]:checked').prop("disabled", true);
                        $('input[name="allStocks[]"]:checked').prop("checked", false);

                        for (let i = 0; i < kalaListID.length; i++) {
                            $('#addedStocks').prepend(`
                    <tr class="addedTrStocks" onclick="checkCheckBox(this,event)">
                        <td>` + kalaListID[i].split('_')[0] + `</td>
                        <td>` + kalaListID[i].split('_')[1] + `</td>
                        <td>
                            <input class="form-check-input" name="addedStocksToWeb[]" type="checkbox" value="` + kalaListID[i].split('_')[0] + `_` + kalaListID[i].split('_')[1] + `" id="kalaIds" checked>
                        </td>
                    </tr>`);
                        }
                    }));


                    // the following code assign Anbar to the left table 
                    $("#allstockOfList").empty();

                    addedStocks.forEach((element, index) => {
                        $("#allstockOfList").append(`
                    <tr onclick="checkCheckBox(this)">
                      <td>`+ (index + 1) + `</td>
                        <td>`+ element.NameStock + `</td>
                        <td>
                        <input  class="addStockToList form-check-input" name="addedStockToList[]" type="checkbox" value="`+ element.SnStock + `">
                        </td>
                    </tr>`)
                    });

                    //for setting minimam saling of kala
                    $(document).on('click', '.setMinSale', (function () {
                        var amountUnit = $(this).val().split('_')[0];
                        var productId = $(this).val().split('_')[1];
                        $.ajax({
                            type: "get",
                            url: baseUrl + "/setMinimamSaleKala",
                            data: { _token: "{{ csrf_token() }}", kalaId: productId, amountUnit: amountUnit },
                            dataType: "json",
                            success: function (msg) {
                                $("#minSaleValue").text(msg + " " + kala.secondUnit + " " + " تعیین شده است ");
                            },
                            error: function (msg) {
                                console.log(msg);
                            }
                        });
                    }));


                    //for setting maximam saling of kala
                    $(document).on('click', '.setMaxSale', (function () {
                        var amountUnit = $(this).val().split('_')[0];
                        var productId = $(this).val().split('_')[1];
                        $.ajax({
                            type: "get",
                            url: baseUrl + "/setMaximamSaleKala",
                            data: { _token: "{{ csrf_token() }}", kalaId: productId, amountUnit: amountUnit },
                            dataType: "json",
                            success: function (msg) {
                                $("#maxSaleValue").text(msg + " " + kala.secondUnit + " " + " تعیین شده است ");
                            },
                            error: function (msg) {
                                console.log(msg);
                            }
                        });
                    }));




                    $(document).on("click", "#submitSubGroup", () => {
                        var addableStuff = [];
                        let kalaId = $("#kalaIdEdit").val();
                        $('input[name="addables[]"]:checked').map(function () {
                            addableStuff.push($(this).val());
                        });
                        var removableStuff = [];
                        $('input[name="removables[]"]:not(:checked)').map(function () {
                            removableStuff.push($(this).val());
                        });
                        $.ajax({
                            type: "get",
                            url: baseUrl + "/addOrDeleteKalaFromSubGroup",
                            data: {
                                _token: "{{ csrf_token() }}",
                                addableStuff: addableStuff,
                                removableStuff: removableStuff,
                                kalaId: kalaId
                            },
                            dataType: "json",
                            success: function (msg) {
                                $('#submitSubGroup').prop("disabled", true);
                                $("#stockSubmit").css("display", "none");
                                $("#kalaRestictionbtn").css("display", "none");
                                $("#completDescriptionbtn").css("display", "none");
                                $("#addToListSubmit").css("display", "none");
                                $("#submitChangePic").css("display", "none");
                            },
                            error: function (msg) {
                                console.log(msg);
                            }
                        });
                    });



                    // following function show the kala restriction button
                    $(".restriction").on("click", () => {
                        $("#kalaRestictionbtn").css("display", "block");
                        $("#stockSubmit").css("display", "none");
                        $("#completDescriptionbtn").css("display", "none");
                        $("#addToListSubmit").css("display", "none");
                        $("#submitChangePic").css("display", "none");
                        $("#submitSubGroup").css("display", "none");
                    });

                    // following function show the kala restriction button
                    $(".keyRestriction").on("keydown", () => {
                        $("#kalaRestictionbtn").css("display", "block");
                        $("#stockSubmit").css("display", "none");
                        $("#completDescriptionbtn").css("display", "none");
                        $("#addToListSubmit").css("display", "none");
                        $("#submitChangePic").css("display", "none");
                        $("#submitSubGroup").css("display", "none");
                    });


                    // for added sameKala 
                    $("#allKalaOfList").empty();
                    sameKala.forEach((element, index) => {
                        $("#allKalaOfList").append(`
                      <tr class="addedTrList">
                            <td>`+ (index + 1) + `</td>
                            <td>`+ element.GoodName + `</td>
                            <td>
                            <input class="form-check-input" style="" name="" type="checkbox" value="`+ element.GoodSn + '_' + element.GoodName + `" id="kalaIds">
                            </td>
                      </tr>
                  `)
                    });

                    $("#priceCycle").empty();
                    kalaPriceCycle.forEach((element, index) => {
                        $("#priceCycle").append(`
                            <tr class="tableRow">
                                <td>`+ (index + 1) + `</td>
                                <td>`+ element.name + ' ' + element.lastName + `</td>
                                <td>`+ element.application + `</td>
                                <td>`+ element.changedate + `</td>
                                <td>`+ element.firstPrice + `</td>
                                <td>`+ element.changedFirstPrice + `</td>
                                <td>`+ element.secondPrice + `</td>
                                <td>`+ element.changedSecondPrice + `</td>
                                <td>
                                    <input class="mainGroupId  form-check-input" type="radio"
                                        value="`+ maingroupList.id + '_' + kala.GoodSn + `" name="IDs[]" id="flexCheckChecked">
                                    <input class="mainGroupId" type="text" value="`+ kala.GoodSn + `"
                                        name="ProductId" id="GoodSn" style="display: none">
                                </td>
                            </tr>`)
                    });

                    $(".kalaEditbtn").on("click", () => {
                        $("#submitChangePic").css("display", "block");
                        $("#stockSubmit").css("display", "none");
                        $('#completDescriptionbtn').css('display', 'none');
                        $("#kalaRestictionbtn").css("display", "none");
                        $("#addToListSubmit").css("display", "none");
                        $("#submitSubGroup").css("display", "none");
                    });




                    // chech or uncheck the kala restriction 
                    if (kala.callOnSale == 1) {
                        $('#callOnSale').prop('checked', true);
                    } else {
                        $('#callOnSale').prop('checked', false);
                    }

                    if (kala.zeroExistance == 1) {
                        $('#zeroExistance').prop('checked', true);
                    } else {
                        $('#zeroExistance').prop('checked', false);
                    }

                    if (kala.showTakhfifPercent == 1) {
                        $('#showTakhfifPercent').prop('checked', true);
                    } else {
                        $('#showTakhfifPercent').prop('checked', false);
                    }

                    if (kala.overLine == 1) {
                        $('#showFirstPrice').prop('checked', true);
                    } else {
                        $('#showFirstPrice').prop('checked', false);
                    }

                    if (kala.hideKala == 1) {
                        $('#inactiveAll').prop('checked', true);
                    } else {
                        $('#inactiveAll').prop('checked', false);
                    }

                    if (kala.freeExistance == 1) {
                        $('#freeExistance').prop('checked', true);
                    } else {
                        $('#freeExistance').prop('checked', false);
                    }

                    if (kala.activePishKharid == 1) {
                        $('#activePreBuy').prop('checked', true);
                    } else {
                        $('#activePreBuy').prop('checked', false);
                    }


                });

                // while onclick on radio button adding subgroup to left table 
                $(".mainGroupId").on("click", () => {

                    $.ajax({
                        type: 'get',
                        async: true,
                        dataType: 'text',
                        url: baseUrl + "/subGroupsEdit",
                        data: {
                            _token: "{{ csrf_token() }}",
                            id: $('.mainGroupId:checked').val().split('_')[0],
                            kalaId: $('.mainGroupId:checked').val().split('_')[1]
                        },
                        success: function (answer) {
                            data = $.parseJSON(answer);
                            $('#subGroup1').empty();
                            data.forEach((element, index) => {

                                $('#subGroup1').append(
                                    `<tr id="subgroupTableRow" onClick="addOrDeleteKala(this)">
                                <td>` + (index + 1) + `</td>
                                <td>` + element.title + `</td>
                                <td>
                                   <input class="subGroupId form-check-input" name="subGroupId[]" value="` + element.id + `_` + element.selfGroupId + `" type="checkBox" id="flexCheckChecked` + index + `">
                               </td>
                        </tr>`);
                                if (element.exist == 'ok') {
                                    $('#flexCheckChecked' + index).prop('checked', true);
                                } else {
                                    $('#flexCheckChecked' + index).prop('checked', false);
                                }
                            }
                            );
                        },
                        error: function (erorr) {
                            alert("data server side error")
                        }
                    });
                });

                $("#groupSubgoupCategory").on("submit", function (e) {

                    var addableStuff = [];
                    let kalaId = $("#kalaIdEdit").val();

                    $('input[name="addables[]"]:checked').map(function () {
                        addableStuff.push($(this).val());
                    });

                    var removableStuff = [];
                    $('input[name="removables[]"]:not(:checked)').map(function () {
                        removableStuff.push($(this).val());
                    });
                    $.ajax({
                        type: "get",
                        url: baseUrl + "/addOrDeleteKalaFromSubGroup",
                        data: {
                            _token: "{{ csrf_token() }}",
                            addables: addableStuff,
                            removables: removableStuff,
                            ProductId: kalaId
                        },
                        dataType: "json",
                        success: function (msg) {
                            console.log(msg);
                            $('#submitSubGroup').prop("disabled", true);
                        },
                        error: function (msg) {
                            console.log(msg);
                        }
                    });
                    e.preventDefault();
                });


                $("#stockTakhsis").change(() => {
                    if ($("#stockTakhsis").is(":checked")) {
                        $("#allStock").css("display", "flex");
                        $("#addAndDeleteStock").css("display", "flex");
                        $("#stockSubmit").css("display", "block");
                        $("#submitSubGroup").css("display", "none");
                        $("#kalaRestictionbtn").css("display", "none");
                        $("#completDescriptionbtn").css("display", "none");
                        $("#addToListSubmit").css("display", "none");
                        $("#submitChangePic").css("display", "none");
                        $("#displayTakhisAnbarTables").css("display", "grid");
                    } else {
                        $("#stockSubmit").css("display", "none");
                        $("#kalaRestictionbtn").css("display", "none");
                        $("#completDescriptionbtn").css("display", "none");
                        $("#addToListSubmit").css("display", "none");
                        $("#submitChangePic").css("display", "none");
                        $("#submitSubGroup").css("display", "block");
                    }
                });
                if (!($('.modal.in').length)) {
                    $('.modal-dialog').css({
                        top: 0,
                        left: 0
                    });
                }
                $('#editingListKala').modal({
                    backdrop: false,
                    show: true
                });

                $('.modal-dialog').draggable({
                    handle: ".modal-header"
                });

                $("#editingListKala").modal("show");
                checkActivation();
            },

            error: function (data) {
                alert("Some thing went to wrong in editing kala modal");
            }
        });

    });


    //برای افزودن انبار به لیست دست چپ
    $(document).on('click', '#addStockToList', (function () {
        var stockListID = [];
        $('input[name="stock[]"]:checked').map(function () {
            stockListID.push($(this).val());
        });

        $("#stockSubmit").prop("disabled", false);
        $('input[name="stock[]"]:checked').parents('tr').css('color', 'white');
        $('input[name="stock[]"]:checked').parents('tr').children('td').css('background-color', 'red');
        $('input[name="stock[]"]:checked').prop("disabled", true);
        $('input[name="stock[]"]:checked').prop("checked", false);
        for (let i = 0; i < stockListID.length; i++) {
            $('#allstockOfList').append(`
                    <tr>
                        <td>` + (i + 1) + `</td>
                        <td>` + stockListID[i].split('_')[1] + `</td>
                        <td>
                             <input class="addStockToList form-check-input" name="addedStockToList[]" type="checkbox" value="` + stockListID[i].split('_')[0] + `" id="kalaIds" checked>
                        </td>
                    </tr>
                    `);
        }
    }));


    function checkCheckBox(element, event) {
        if (event.target.type == "checkbox") {
            e.stopPropagation();
        } else {
            if ($(element).find('input:checkbox').prop('disabled') == false) {
                if ($(element).find('input:checkbox').prop('checked') == false) {
                    $(element).find('input:checkbox').prop('checked', true);

                } else {
                    $(element).find('input:checkbox').prop('checked', false);
                    $(element).find('td.selected').removeClass("selected");
                }
            }
        }
    }

    //سبمیت انبار
    $('#submitStockToList').on('submit', function (e) {
        e.preventDefault();
        $.ajax({
            url: $(this).attr('action'),
            type: $(this).attr('method'),
            dataType: 'json',
            data: $(this).serialize(),
            success: function (data) {
                $("#allStock").css("display", "none");
                $("#addAndDeleteStock").css("display", "none");
                $("#stockSubmit").css("display", "none");
                $("#stockTakhsis").prop("checked", false);
                $('#completDescriptionbtn').css('display', 'none');
                $("#kalaRestictionbtn").css("display", "none");
                $("#addToListSubmit").css("display", "none");
                $("#submitChangePic").css("display", "none");
                $("#submitSubGroup").css("display", "block");
            },
            error: function (xhr, err) {
                alert('Anbar is not submiting');
            }
        });
    });

    //حذف انبار
    $(document).on('click', '#removeStockFromList', (function () {
        $('tr').find('input:checkbox:checked').attr("name", "removeStockFromList[]");
        $('tr').has('input:checkbox:checked').hide();
        $("#stockSubmit").prop("disabled", false);
        $('#completDescriptionbtn').css('display', 'none');
        $("#kalaRestictionbtn").css("display", "none");
        $("#addToListSubmit").css("display", "none");
        $("#submitChangePic").css("display", "none");
        $("#submitSubGroup").css("display", "none");
    }));


    // the following function make false the disabled property for restriction kala button 
    $(".restiction").on("change", () => {
        $("#submitSubGroup").css("display", "none");
        $("#kalaRestictionbtn").css('display', 'block');
        $("#kalaRestictionbtn").prop('disabled', false);
    })


    //سبمیت محدودیت ها روی کالا
    $("#restrictFormStuff").on('submit', function (event) {

        event.preventDefault();
        if (!($("#inactiveAll").is(':checked'))) {

            let inputElements = document.getElementsByTagName('input');
            let len = inputElements.length;

            for (let i = 0; i < len; i++) {
                inputElements[i].disabled = false;
            }

            let buttonElements = document.getElementsByTagName('button');
            let buttonLen = buttonElements.length;
            for (let i = 0; i < buttonLen; i++) {
                buttonElements[i].disabled = false;
            }
            let selectElements = document.getElementsByTagName('select');
            let selectLen = selectElements.length;

            for (let i = 0; i < selectLen; i++) {
                selectElements[i].disabled = false;
            }
            let textAreaElements = document.getElementsByTagName('textArea');
            let textAreaLen = textAreaElements.length;

            for (let i = 0; i < textAreaLen; i++) {
                textAreaElements[i].disabled = false;
            }

        } else {
            document.querySelector("#zeroExistance").checked = false;
            document.querySelector("#showTakhfifPercent").checked = false;
            document.querySelector("#showFirstPrice").checked = false;
            document.querySelector("#freeExistance").checked = false;
            document.querySelector("#activePreBuy").checked = false;
        }

        $.ajax({
            url: $(this).attr('action'),
            type: $(this).attr('method'),
            dataType: 'json',
            data: $(this).serialize(),

            success: function (data) {
                if (data == 1) {

                    let inputElements = document.getElementsByTagName('input');
                    let len = inputElements.length;

                    for (let i = 0; i < len; i++) {
                        inputElements[i].disabled = true;
                    }
                    let buttonElements = document.getElementsByTagName('button');
                    let buttonLen = buttonElements.length;

                    for (let i = 0; i < buttonLen; i++) {
                        buttonElements[i].disabled = true;
                    }
                    let selectElements = document.getElementsByTagName('select');
                    let selectLen = selectElements.length;

                    for (let i = 0; i < selectLen; i++) {
                        selectElements[i].disabled = true;
                    }
                    let textAreaElements = document.getElementsByTagName('textArea');
                    let textAreaLen = textAreaElements.length;

                    for (let i = 0; i < textAreaLen; i++) {
                        textAreaElements[i].disabled = true;
                    }
                    document.querySelector("#inactiveAll").disabled = false;
                    $("#restrictStuffId").prop("disabled", true);
                }
            },
            error: function (xhr, err) {
                alert("kala restriction doesn't work");
            }
        });

        return false;
    });


    // for display save button of kala description 
    $('#descriptionKala').on('keydown', () => {
        $('#completDescriptionbtn').css('display', 'block');
        $("#kalaRestictionbtn").css("display", "none");
        $("#stockSubmit").css("display", "none");
        $("#addToListSubmit").css("display", "none");
        $("#submitChangePic").css("display", "none");
        $("#submitSubGroup").css("display", "none");
    });
	
	    $('#kalaTags').on('keydown', () => {
        $('#completDescriptionbtn').css('display', 'block');
        $("#kalaRestictionbtn").css("display", "none");
        $("#stockSubmit").css("display", "none");
        $("#addToListSubmit").css("display", "none");
        $("#submitChangePic").css("display", "none");
        $("#submitSubGroup").css("display", "none");
    });


    // for submiting description kala data 
    $("#completDescription").submit(function (e) {
        $.ajax({
            url: $(this).attr('action'),
            type: $(this).attr('method'),
            dataType: 'json',
            data: $(this).serialize(),
            success: function (data) {
                $('#completDescriptionbtn').css('display', 'none');
                $("#kalaRestictionbtn").css("display", "none");
                $("#stockSubmit").css("display", "none");
                $("#addToListSubmit").css("display", "none");
                $("#submitChangePic").css("display", "none");
                $("#submitSubGroup").css("display", "block");
            },
            error: function (xhr, err) {
                alert('description Kala is not submited');
            }

        });
        e.preventDefault();
    });


    $("#sameKalaList").change(function () {
        if ($("#sameKalaList").is(':checked')) {
            $("#addKalaToList").css("display", "flex");
            $("#addAndDelete").css("display", "flex");
            $("#addedList").css("display", "flex");
            $("#addToListSubmit").css("display", "block");
            $("#displaySameKalaTables").css("display", "grid");

            $("#submitChangePic").prop('disabled', false);
            $("#stockSubmit").css("display", "none");
            $('#completDescriptionbtn').css('display', 'none');
            $("#kalaRestictionbtn").css("display", "none");
            $("#addToListSubmit").css("display", "block");
            $("#submitSubGroup").css("display", "none");

            let mainKalaId = $("#mainKalaId").val();
            $.ajax({
                method: 'get',
                url: baseUrl + "/getAllKalas",
                data: { _token: "{{ csrf_token() }}", mainKalaId: mainKalaId },
                dataType: "json",
                async: true,
                success: function (arrayed_result) {
                    $('#allKalaForList').empty();
                    for (var i = 0; i <= arrayed_result.length - 1; i++) {
                        $('#allKalaForList').append(`
                <tr>
                    <td>` + (i + 1) + `</td>
                    <td>` + arrayed_result[i].GoodName + `</td>
                    <td>
                    <input class="form-check-input" name="kalaListForList[]" type="checkbox" value="` +
                            arrayed_result[i].GoodSn + `_` + arrayed_result[i]
                                .GoodName + `" id="kalaId">
                    </td>
                </tr>
                `);
                    }
                },
                error: function (data) { }
            });


        } else {
            $("#addKalaToList").css("display", "none");
            $("#addAndDelete").css("display", "none");
            $("#addToListSubmit").css("display", "none");
        }
    });

    $('#mainPic').on('change', () => {
        $("#submitChangePic").prop('disabled', false);
        $("#stockSubmit").css("display", "none");
        $('#completDescriptionbtn').css('display', 'none');
        $("#kalaRestictionbtn").css("display", "none");
        $("#addToListSubmit").css("display", "none");
        $("#submitSubGroup").css("display", "none");
    });


    //used for adding kala to List to the left side(kalaList)
    $(document).on('click', '#addDataToList', (function () {
        var kalaListID = [];
        $('input[name="kalaListForList[]"]:checked').map(function () {
            kalaListID.push($(this).val());
        });
        $("#addToListSubmit").prop("disabled", false);
        $('input[name="kalaListForList[]"]:checked').parents('tr').css('color', 'white');
        $('input[name="kalaListForList[]"]:checked').parents('tr').children('td').css('background-color', 'red');
        $('input[name="kalaListForList[]"]:checked').prop("disabled", true);
        $('input[name="kalaListForList[]"]:checked').prop("checked", false);
        for (let i = 0; i < kalaListID.length; i++) {
            $('#allKalaOfList').append(
                `<tr class="addedTrList">
                         <td>` + (i + 1) + `</td>
                         <td>` + kalaListID[i].split('_')[1] + `</td>
                         <td>
                            <input class="addKalaToList form-check-input" name="addedKalaToList[]" type="checkbox" value="` + kalaListID[i].split('_')[0] + `_` + kalaListID[i].split('_')[1] + `" id="kalaIds" checked>
                         </td>
                      </tr>`
            );
        }
    }));


    // for submiting Samekala form 
    $('#sameKalaForm').on('submit', function (e) {

        $.ajax({
            url: $(this).attr('action'),
            type: $(this).attr('method'),
            dataType: 'json',
            data: $(this).serialize(),
            success: function (data) {
                console.log(data);
                $("#stockSubmit").css("display", "none");
                $('#completDescriptionbtn').css('display', 'none');
                $("#kalaRestictionbtn").css("display", "none");
                $("#addToListSubmit").css("display", "none");
                $("#submitSubGroup").css("display", "block");


                $("#addKalaToList").css("display", "none");
                $("#addAndDelete").css("display", "none");
                $("#sameKalaList").prop("checked", false);
            },

            error: function (xhr, err) {
                alert('same Kala is not submited');
            }

        });

        e.preventDefault();

    });

});


$("#kalaListRadio").on("change", () => {
    $(".listkalarStaff").css("display", "block")
    $(".requestedKalaStaff").css("display", "none")
    $(".fastKalaStaff").css("display", "none")
    $(".pishKaridStaff").css("display", "none")
    $(".brandStaff").css("display", "none")
    $(".alarmedKalaStaff").css("display", "none")
    $(".kalaCategoryStaff").css("display", "none")
    $("#addKalaToGroup").css("display", "none")
})

$("#customerRequestRadio").on("change", () => {
    $(".requestedKalaStaff").css("display", "table")
    $(".listkalarStaff").css("display", "none")
    $(".fastKalaStaff").css("display", "none")
    $(".pishKaridStaff").css("display", "none")
    $(".brandStaff").css("display", "none")
    $(".alarmedKalaStaff").css("display", "none")
    $(".kalaCategoryStaff").css("display", "none")
    $("#addKalaToGroup").css("display", "none")
})

$("#fastKalaRadio").on("change", () => {
    $(".fastKalaStaff").css("display", "block")
    $(".listkalarStaff").css("display", "none")
    $(".requestedKalaStaff").css("display", "none")
    $(".pishKaridStaff").css("display", "none")
    $(".brandStaff").css("display", "none")
    $(".alarmedKalaStaff").css("display", "none")
    $(".kalaCategoryStaff").css("display", "none")
    $("#addKalaToGroup").css("display", "none")
})


$("#pishKharidRadio").on("change", () => {
    $(".pishKaridStaff").css("display", "inline")
    $(".fastKalaStaff").css("display", "none")
    $(".listkalarStaff").css("display", "none")
    $(".requestedKalaStaff").css("display", "none")
    $(".brandStaff").css("display", "none")
    $(".alarmedKalaStaff").css("display", "none")
    $(".kalaCategoryStaff").css("display", "none")
    $("#addKalaToGroup").css("display", "none")
})

$("#brandsRadio").on("change", () => {
    $(".brandStaff").css("display", "block")
    $(".pishKaridStaff").css("display", "none")
    $(".fastKalaStaff").css("display", "none")
    $(".listkalarStaff").css("display", "none")
    $(".requestedKalaStaff").css("display", "none")
    $(".alarmedKalaStaff").css("display", "none")
    $(".kalaCategoryStaff").css("display", "none")
    $("#addKalaToGroup").css("display", "none")
})
$("#alarmedKalaListRadio").on("change", () => {
    $(".alarmedKalaStaff").css("display", "table")
    $(".brandStaff").css("display", "none")
    $(".pishKaridStaff").css("display", "none")
    $(".fastKalaStaff").css("display", "none")
    $(".listkalarStaff").css("display", "none")
    $(".requestedKalaStaff").css("display", "none")
    $(".kalaCategoryStaff").css("display", "none")
    $("#addKalaToGroup").css("display", "none")
})

$("#categorykalaRadio").on("change", () => {
    $(".kalaCategoryStaff").css("display", "flex")
    $(".alarmedKalaStaff").css("display", "none")
    $(".brandStaff").css("display", "none")
    $(".pishKaridStaff").css("display", "none")
    $(".fastKalaStaff").css("display", "none")
    $(".listkalarStaff").css("display", "none")
    $(".requestedKalaStaff").css("display", "none")
    $("#addKalaToBrand").css("display", "none")
})