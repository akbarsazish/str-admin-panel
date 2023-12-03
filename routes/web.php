<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\App;
use App\Http\Controllers\Message;
use App\Http\Controllers\Basket;
use App\Http\Controllers\Cheque;
use App\Http\Controllers\Admin;
use App\Http\Controllers\Kala;
use App\Http\Controllers\Group;
use App\Http\Controllers\Home;
use App\Http\Controllers\Brand;
use App\Http\Controllers\Customer;
use App\Http\Controllers\Lottery;
use App\Http\Controllers\Game;
use App\Http\Controllers\NazarSanji;
use App\Http\Controllers\Order;
use App\Http\Controllers\Factor;
use App\Http\Controllers\PayOnline;
use App\Http\Controllers\Notification;
use App\Http\Controllers\TakhfifCode;
use App\Http\Controllers\Target;
use App\Http\Controllers\Driver;
use App\Http\Controllers\Bank;
use App\Http\Controllers\Masir;
use App\Http\Controllers\Bargiri;
use App\Http\Controllers\Box;
use App\Http\Controllers\Payment;
use App\Http\Controllers\Infors;
Route::get('/messages',[Message::class,'messages'])->middleware('checkAdmin');
Route::get('/getTakhfifCode',[TakhfifCode::class,'index'])->middleware('checkAdmin');
Route::get('/getReplayedMessages',[Message::class,'getReplayedMessages'])->middleware('checkAdmin');
Route::get('/getUnreadMessages',[Message::class,'getUnreadMessages'])->middleware('checkAdmin');
Route::get('/getReadMessages',[Message::class,'getReadMessages'])->middleware('checkAdmin');
Route::get('/getUnReplayedMessages',[Message::class,'getUnReplayedMessages'])->middleware('checkAdmin');
Route::get('/getMessages',[Message::class,'getMessages'])->middleware('checkAdmin');
Route::get('/getAllMessages',[Message::class,'getAllMessages'])->middleware('checkAdmin');
Route::get('/getLastTenMessages',[Message::class,'getLastTenMessages'])->middleware('checkAdmin');
Route::get('/adminPage',[Admin::class,'index'])->middleware('checkAdmin');
Route::post('/customerProfile',[Admin::class,'customerProfile'])->middleware('checkAdmin');
Route::get('/dashboardAdmin',[Admin::class,'index'])->middleware('checkAdmin');
Route::get('/listKarbaran',[Admin::class,'listKarbaran'])->middleware('checkAdmin');
Route::get('/controlMainPage',[Home::class,'controlMainPage'])->middleware('checkAdmin');
Route::get('/addNewGroup',[Home::class,'addNewPart'])->middleware('checkAdmin');
Route::post('/doAddAdmin',[Admin::class,'doAddAdmin'])->middleware('checkAdmin');
Route::post('/editAdmin',[Admin::class,'editAdmin'])->middleware('checkAdmin');
Route::post('/doEditAdmin',[Admin::class,'doEditAdmin'])->middleware('checkAdmin');
Route::get('/webSpecialSettings',[App::class,'webSpecialSettings'])->middleware('checkAdmin');
Route::post('/doUpdatewebSpecialSettings',[App::class,'doUpdatewebSpecialSettings'])->middleware('checkAdmin');
Route::get('/loginAdmin',[Admin::class,'loginAdmin']);
Route::post('/checkAdmin',[Admin::class,'checkAdmin']);
Route::get('/notifyUser',[Admin::class,'notifyUser']);
Route::post('/regularLogin',[Customer::class,'regularLogin'])->middleware('checkAdmin');
Route::post('/regularLogOut',[Customer::class,'regularLogOut'])->middleware('checkAdmin');
Route::get('/searchCustomer',[Customer::class,'searchCustomer'])->middleware('checkAdmin');
Route::get('/addCustomer', [Customer::class, 'addCustomer'])->middleware('checkUser');
Route::post('/doAddCustomer', [Customer::class, 'doAddCustomer'])->middleware('checkUser');
Route::get('/listCustomers',[Customer::class,'listCustomers'])->middleware('checkAdmin');
Route::get('/filterCustomers',[Customer::class,'filterCustomers'])->middleware('checkAdmin');
Route::post('/editCustomer',[Customer::class,'editCustomer'])->middleware('checkAdmin');
Route::get('/afterEditCustomer',[Customer::class,'afterEditCustomer'])->middleware('checkAdmin');
Route::get('/restrictCustomer',[Customer::class,'restrictCustomer'])->middleware('checkAdmin');
Route::get('/customerAdd/{id}', [Customer::class, 'haqiqiCustomerAdd'])->middleware('checkUser');
Route::get('/haqiqiCustomerAdmin/{id}', [Customer::class, 'haqiqiCustomerAdmin'])->middleware('checkAdmin');
Route::post('/storeHaqiqiCustomer', [Customer::class, 'storeHaqiqiCustomer'])->middleware('checkUser');
Route::post('/storeHaqiqiCustomerAdmin', [Customer::class, 'storeHaqiqiCustomerAdmin'])->middleware('checkAdmin');
Route::post('/storeHoqoqiCustomerAdmin', [Customer::class, 'storeHoqoqiCustomerAdmin'])->middleware('checkAdmin');
Route::get('/hoqoqiCustomerAdd', [Customer::class,'hoqoqiCustomerAdd'])->middleware('checkUser');
Route::post('/storeHoqoqiCustomer', [Customer::class, 'storeHoqoqiCustomer'])->middleware('checkUser');
Route::get('/searchCustomerByAddressMNM', [Customer::class, 'searchCustomerByAddressMNM'])->middleware('checkAdmin');
Route::get('/searchCustomerByNameMNM', [Customer::class, 'searchCustomerByNameMNM'])->middleware('checkAdmin');
Route::get('/searchCustomerAddedAddressMNM', [Customer::class, 'searchCustomerAddedAddressMNM'])->middleware('checkAdmin');
Route::get('/searchCustomerAddedNameMNM', [Customer::class, 'searchCustomerAddedNameMNM'])->middleware('checkAdmin');
Route::get('/addCustomerToMantiqah', [Customer::class, 'addCustomerToMantiqah'])->middleware('checkAdmin');
Route::get('/removeCustomerFromMantiqah', [Customer::class, 'removeCustomerFromMantiqah'])->middleware('checkAdmin');
Route::get("/customerDashboard",[Customer::class,'customerDashboard'])->middleware('checkAdmin');
Route::post("/updateChangedPrice",[Kala::class,'updateChangedPrice'])->middleware('checkUser');
Route::get("/getCustomerByCode",[Customer::class,'getCustomerByCode'])->middleware('checkAdmin');
Route::get("/getCustomerByID",[Customer::class,'getCustomerByID'])->middleware('checkAdmin');
Route::get("/getFactorDetail",[Customer::class,'getFactorDetail'])->middleware('checkAdmin');
Route::get("/searchCustomerForNotify",[Customer::class,"searchCustomerForNotify"])->middleware('checkAdmin');
Route::get("/searchCustomerForSMS",[Customer::class,"searchCustomerSMS"])->middleware('checkAdmin');
Route::get("/getProductFactorsByCustomer",[Customer::class,"getProductFactorsByCustomer"])->middleware('checkAdmin');
Route::get("/getFirstComment",[Customer::class,"getFirstComment"])->middleware('checkAdmin');
Route::get('/getAllCustomersToMNM',[Customer::class, 'getAllCustomersToMNM'])->middleware('checkAdmin');
Route::get("/setCommentProperty",[Customer::class,"setCommentProperty"])->middleware('checkAdmin');
Route::get('/profile', [Customer::class,'getProfile'])->middleware('checkUser');
Route::get('/inviteCode', [Customer::class,'inviteCode'])->middleware('checkUser');
Route::get('/',[Home::class,'index']);
Route::get('/home',[Home::class,'index']);
Route::get('/listFavorits',[Kala::class,'getFavorite'])->middleware('checkUser');
Route::get('/messageList',[Message::class,'index'])->middleware('checkUser');
Route::get('/replayMessage',[Message::class,'replayMessage'])->middleware('checkAdmin');
Route::get('/carts',[Basket::class,'index'])->middleware('checkUser');
Route::post('/assignTakhfif',[Customer::class,'assignSpecialTakhfifPercentage'])->middleware('checkAdmin');
Route::get('/bagCash',[Lottery::class,'index'])->middleware('checkUser');
Route::get("/removeTakhfifCaseNotify",[App::class,"removeNotify"])->middleware('checkAdmin');
Route::get('/logout',[Customer::class,'logout']);
Route::get('/adminLogout',[Admin::class,'logout']);
Route::any('/login',[Customer::class,'login']);
Route::any('/Login',[Customer::class,'login']);
Route::post('/checkUser',[Customer::class,'checkUser']);
Route::post('/addpicture',[Kala::class,'changeKalaPicture'])->middleware('checkAdmin');
Route::get('/getUnits',[Kala::class,'getUnits'])->middleware('checkUser');
Route::get('/getUnitsForPishKharid',[Kala::class,'getUnitsForPishKharid'])->middleware('checkUser');
Route::get('/getUnitsForUpdatePishKharid',[Kala::class,'getUnitsForUpdatePishKharid'])->middleware('checkUser');
Route::get('/getUnitsForUpdate',[Kala::class,'getUnitsForUpdate'])->middleware('checkUser');
Route::get('/updateOrderBYS',[Basket::class,'updateBasketItem'])->middleware('checkUser');
Route::post('/deleteBYS',[Basket::class,'deleteBasketItem'])->middleware('checkUser');
Route::post('/editKala',[Kala::class,'editKala'])->middleware('checkAdmin');
Route::post('/addMainGroup',[Group::class,'addGroup'])->middleware('checkAdmin');
Route::post('/deleteMainGroup',[Group::class,'deleteMainGroup'])->middleware('checkAdmin');
Route::post('/editMainGroup',[Group::class,'editMainGroup'])->middleware('checkAdmin');
Route::get('/listGroup',[Group::class,'index'])->middleware('checkAdmin');
Route::get('/editGroup',[Group::class,'editGroup'])->middleware('checkAdmin');
Route::get('/deleteGroup',[Group::class,'deleteMainGroup'])->middleware('checkAdmin');
Route::post('/deleteSubGroup',[Group::class,'deleteSubGroup'])->middleware('checkAdmin');
Route::get('/descKala/{groupId}/itemCode/{id}',[Kala::class,'describeKala'])->middleware('checkUser');
Route::post('/shipping',[Basket::class,'sendBasket'])->middleware('checkUser');
Route::post('/addOrder',[Order::class,'addOrder'])->middleware('checkUser');
Route::get('/starfoodFrom',[Order::class,'getPaymentForm'])->middleware('checkUser');
Route::get('/sucessPay',[Order::class,'finalizePayAndOrder'])->middleware('checkUser');

Route::get('/wallet',[Customer::class,'wallet'])->middleware('checkUser');
Route::post('/factorView',[Factor::class,'factorView'])->middleware('checkUser');
Route::get('/allGroups',[Group::class,'index'])->middleware('checkUser');
Route::get('/listKala',[Kala::class,'index'])->middleware('checkAdmin');
Route::get('/listKalaFromPart/{id}/partPic/{picId}',[Kala::class,'listKalaOfPicture'])->middleware('checkUser');
Route::get('/listKala/groupId/{id}',[Kala::class,'getMainGroupKalaForFront'])->middleware('checkUser');
Route::get('/subGroups',[Group::class,'getSubGroups'])->middleware('checkAdmin');
Route::post('/addSubGroup',[Group::class,'addSubGroup'])->middleware('checkAdmin');
Route::post('/editSubgroup',[Group::class,'editSubGroup'])->middleware('checkAdmin');
Route::get('/getKalaGroups',[Group::class,'getAllMainGroups'])->middleware('checkAdmin');
Route::get('/subGroupsEdit',[Group::class,'getSubGroupAndCheckKala'])->middleware('checkAdmin');
Route::get('/addKalaToSubGroups',[Group::class,'addKalaToSubGroups'])->middleware('checkAdmin');
Route::get('/getListKala',[Kala::class,'getListKala'])->middleware('checkAdmin');
Route::get('/getListBrand',[Brand::class,'getListOfBrands'])->middleware('checkAdmin');
Route::post('/addKalaToGroup',[Kala::class,'addKalaToGroup'])->middleware('checkAdmin');
Route::get('/restrictKala',[Kala::class,'restrictKala'])->middleware('checkAdmin');
Route::get('/changeKalaPartPriority',[Kala::class,'changeKalaPartPriority'])->middleware('checkAdmin');
Route::get('/changeBrandPartPriority',[Brand::class,'changeBrandPartPriority'])->middleware('checkAdmin');
Route::get('/changeGroupsPartPriority',[Group::class,'changeGroupsPartPriority'])->middleware('checkAdmin');
Route::get('/getSelectedListKala',[Kala::class,'getSelectedListKala'])->middleware('checkAdmin');
Route::get('/buySomething',[Basket::class,'addToBasket'])->middleware('checkUser');
Route::get('/buySomethingFromHome',[Basket::class,'addToBasketFromHomePage'])->middleware('checkUser');
Route::get('/preBuySomethingFromHome',[Kala::class,'preBuySomethingFromHome'])->middleware('checkUser');
Route::get('/updateOrderBYSFromHome',[Basket::class,'updateBasketItemFromHomePage'])->middleware('checkUser');
Route::get('/updatePreOrderBYSFromHome',[Kala::class,'updatePreOrderBYSFromHome'])->middleware('checkUser');
Route::get('/pishKharidSomething',[Kala::class,'pishKharidSomething'])->middleware('checkUser');
Route::get('/updateOrderPishKharid',[Kala::class,'updateOrderPishKharid'])->middleware('checkUser');
Route::get('/setFavorite',[Kala::class,'setFavorite'])->middleware('checkUser');
Route::post('/doEditGroupPart',[Home::class,'updatePart'])->middleware('checkAdmin');
Route::get('/getListGroup',[Group::class,'getAllMainGroups']);// این میتود در هرجاییکه هست نباید مدلویر بگیرد
Route::get('/addKalaToPart',[Home::class,'addKalaToPart'])->middleware('checkAdmin');
Route::post('/editParts',[Home::class,'showEditPartsForm'])->middleware('checkAdmin');
Route::get('/changePriority',[Home::class,'changePriority'])->middleware('checkAdmin');
Route::get('/getAllKala/{id}',[Home::class,'getAllKalaForHomePageFront'])->middleware('checkUser');
Route::get('/getGroupSearch',[Group::class,'getMainGroupById'])->middleware('checkUser');
Route::get('/getSearchGroups',[Group::class,'getAllMainGroups']);
Route::get('/searchKalaByName',[Kala::class,'searchKalaByName'])->middleware('checkAdmin');
Route::get('/getSubGroupList',[Group::class,'getSubGroups'])->middleware('checkAdmin');
Route::get('/searchKalaBySubGroup',[Kala::class,'searchKalaBySubGroup'])->middleware('checkUser');
Route::get('/deletePart',[Home::class,'deletePart'])->middleware('checkAdmin');
Route::get('/getListKalaOnePic',[Kala::class,'getListKalaForPictures'])->middleware('checkAdmin');
Route::post('/addPart',[Home::class,'addPart'])->middleware('checkAdmin');
Route::get('/getKalasSearch',[Kala::class,'getKalasSearch'])->middleware('checkAdmin');
Route::get('/getKalasSearchSubGroup',[Kala::class,'getKalasSearchSubGroup'])->middleware('checkAdmin');
Route::get('/searchKalas',[Kala::class,'searchKalas'])->middleware('checkAdmin');
Route::get('/searchKala/{name}',[Kala::class,'searchKala'])->middleware('checkUser');
Route::get('/changePicturesKalaPriority',[Kala::class,'changePicturesKalaPriority'])->middleware('checkUser');
Route::get('/deleteKalaFromSubGroups',[Group::class,'deleteKalaFromSubGroups'])->middleware('checkUser');
Route::get('/getFilteredSecondSubGroup/{groupId}/subGroup/{subGroupId}',[Group::class,'getSubGroupKalaForFront'])->middleware('checkUser');
Route::get('/addMessage',[Message::class,'addMessage'])->middleware('checkUser');
Route::get('/doAddMessage',[Message::class,'doAddMessage'])->middleware('checkUser');
Route::post('/addDescKala',[Kala::class,'setDescribeKala'])->middleware('checkAdmin');
Route::get('/customerConfirmation',[Customer::class,'customerConfirmation']);
Route::post('/logOutConfirm',[Customer::class,'logOutConfirm']);
Route::post('/addIntroducerCode',[Customer::class,'addIntroducerCode']);
Route::get('/getSubGroupKala',[Kala::class,'getSubGroupKala'])->middleware('checkAdmin');
Route::get('/getMainGroupList',[Group::class,'getMainGroupByTitle'])->middleware('checkAdmin');
Route::get('/getListOfSubGroup',[Kala::class,'getKalaForSubGroup'])->middleware('checkAdmin');
Route::get('/appendSubGroupKala',[Kala::class,'getSubGroupKalaForFront'])->middleware('checkUser');
Route::get('/tempRoute',[Kala::class,'tempRoute'])->middleware('checkAdmin');
Route::get('/changeMainGroupPriority',[Group::class,'changeMainGroupPriority'])->middleware('checkAdmin');
Route::get('/changeSubGroupPriority',[Group::class,'changeSubGroupPriority'])->middleware('checkAdmin');
Route::get('/searchSubGroupKala',[Group::class,'getSubGroupKalaByName'])->middleware('checkAdmin');
Route::get('/getUnitsForSettingMinSale',[Kala::class,'getUnitsForSettingMinSale'])->middleware('checkAdmin');
Route::get('/getUnitsForSettingMaxSale',[Kala::class,'getUnitsForSettingMaxSale'])->middleware('checkAdmin');
Route::get('/setMinimamSaleKala',[Kala::class,'setMinimamSaleKala'])->middleware('checkAdmin');
Route::get('/setMaximamSaleKala',[Kala::class,'setMaximamSaleKala'])->middleware('checkAdmin');
Route::get('/getAllKalas',[Kala::class,'getAllKalas'])->middleware('checkAdmin');
Route::get('/addKalaToList',[Kala::class,'addOrDeleteAssame'])->middleware('checkAdmin');
Route::post('/addStockToList',[Kala::class,'addStockToList'])->middleware('checkAdmin');
Route::get('/addOrDeleteKalaFromSubGroup',[Kala::class,'addOrDeleteKalaFromSubGroup'])->middleware('checkAdmin');
Route::get('/getKalaWithPic/{id}',[Kala::class,'getKalaWithPic'])->middleware('checkAdmin');
Route::get('/getGoodPictureState',[Kala::class,'getGoodPictureState'])->middleware('checkAdmin');
Route::get('/changePriceKala',[Kala::class,'changePriceKala'])->middleware('checkAdmin');
Route::get('/getStocks',[Kala::class,'getStocks'])->middleware('checkAdmin');
Route::get('/searchKalaByStock',[Kala::class,'searchKalaByStock'])->middleware('checkAdmin');
Route::get('/getMainGroups',[Group::class,'getAllMainGroups'])->middleware('checkAdmin');
Route::get('/getKalaBySubGroups',[Kala::class,'getKalaBySubGroups'])->middleware('checkAdmin');
Route::get("/getProductMainGroups",[Group::class,'getAllMainGroups'])->middleware('checkAdmin');
Route::get("/getSubGroups",[Group::class,"getSubGroups"])->middleware('checkAdmin');
Route::get("/filterAllKala",[Kala::class,"filterAllKala"])->middleware('checkAdmin');
Route::get('/listKala/brandCode/{code}',[Kala::class,'getKalaBybrandItem'])->middleware('checkUser');
Route::post('/addBrand',[Brand::class,'addBrand'])->middleware('checkAdmin');
Route::post('/editBrand',[Brand::class,'editBrand'])->middleware('checkAdmin');
Route::post('/deleteBrand',[Brand::class,'deleteBrand'])->middleware('checkAdmin');
Route::get('/getBrandKala',[Brand::class,'getBrandKala'])->middleware('checkAdmin');
Route::get('/addKalaToBrand',[Brand::class,'addKalaToBrand'])->middleware('checkAdmin');
Route::get('/getKala',[Brand::class,'getKalaForBrand'])->middleware('checkAdmin');
Route::get('/getOrders',[Basket::class,'getUnSentBasketItems']);
Route::get('/deleteOrderPishKharid',[Basket::class,'deletePishKharidBasketItem']);
Route::post('/sendFactorToApp',[Order::class,'addPishkharidBasketsToOrder']);
Route::post('/listOrders', [Order::class, 'orderView'])->middleware('checkUser');
Route::get('/deleteKalaFromPart', [Home::class, 'deleteKalaFromPart'])->middleware('checkAdmin');
Route::get('/getPrebuyAbles', [Kala::class, 'getPreBuyAbles'])->middleware('checkAdmin');
Route::get('/aboutUs', [App::class, 'aboutUs'])->middleware('checkUser');
Route::get('/policy', [App::class, 'policy'])->middleware('checkUser');
Route::get('/contactUs', [App::class, 'contactUs'])->middleware('checkUser');
Route::get('/privacy', [App::class, 'privacy'])->middleware('checkUser');
Route::get('/addRequestedProduct', [Kala::class, 'addRequestedProduct'])->middleware('checkUser');
Route::get('/searchPreBuyAbleKalas',[Kala::class,'searchPreBuyAbleKalas'])->middleware('checkAdmin');
Route::get('/displayRequestedKala', [Kala::class, 'displayRequestedKala'])->middleware('checkAdmin');
Route::get('/respondKalaRequest', [Kala::class, 'respondKalaRequest'])->middleware('checkAdmin');
Route::get('/cancelRequestedProduct', [Kala::class, 'cancelRequestedProduct'])->middleware('checkUser');
Route::get('/removeRequestedKala', [Kala::class, 'removeRequestedKala'])->middleware('checkAdmin');
Route::get('/searchRequestedKala', [Kala::class, 'searchRequestedKala'])->middleware('checkAdmin');
Route::get('/searchKalaByID', [Kala::class, 'searchKalaByID'])->middleware('checkAdmin');
Route::get('/crmLogin', [Customer::class, 'crmLogin']);
Route::get('/searchByMantagha', [Admin::class, 'searchByMantagha'])->middleware('checkAdmin');
Route::get('/searchByCity', [Admin::class, 'searchByCity'])->middleware('checkAdmin');
Route::get('/searchCustomerByCode', [Admin::class,'searchCustomerByCode'])->middleware('checkAdmin');
Route::get('/searchCustomerByActivation', [Admin::class,'searchCustomerByActivation'])->middleware('checkAdmin');
Route::get('/searchCustomerLocationOrNot', [Admin::class,'searchCustomerLocationOrNot'])->middleware('checkAdmin');
Route::get('/searchMantagha', [Masir::class, 'searchMantagha'])->middleware('checkAdmin');
Route::get('/addMantiqah', [Masir::class, 'addMantiqah'])->middleware('checkAdmin');
Route::get('/addMasir', [Masir::class, 'addMasir'])->middleware('checkAdmin');
Route::get('/getMasirs', [Masir::class, 'getMantiqasByCityId'])->middleware('checkAdmin');
Route::get('/takhsisMasirs', [Customer::class, 'takhsisMasirs'])->middleware('checkAdmin');
Route::get('/searchCustomerByName', [Admin::class, 'searchCustomerByName'])->middleware('checkAdmin');
Route::get('/orderCustomers', [Admin::class, 'orderCustomers'])->middleware('checkAdmin');
Route::get('/getCityInfo', [Masir::class, 'getCityInfo'])->middleware('checkAdmin');
Route::get('/editCity', [Masir::class, 'editCity'])->middleware('checkAdmin');
Route::get('/addNewCity', [Masir::class, 'addCity'])->middleware('checkAdmin');
Route::get('/deleteCity', [Masir::class, 'deleteCity'])->middleware('checkAdmin');
Route::get('/getMantaghehInfo', [Masir::class, 'getMantaghehInfo'])->middleware('checkAdmin');
Route::get('/editMantagheh', [Masir::class, 'editMantagheh'])->middleware('checkAdmin');
Route::get('/deleteMantagheh', [Masir::class, 'deleteMantagheh'])->middleware('checkAdmin');
Route::get("/getTenLastSales",[Kala::class,'getTenLastSales'])->middleware('checkAdmin');
Route::get("/getAdminInfo",[Admin::class,'getAdminInfo'])->middleware('checkAdmin');
Route::get('/callUs',[App::class,'callUs'])->middleware('checkUser');
Route::get('/downloadApk',[App::class,'downloadApk']);
Route::get('/appguide',[App::class,'guide']);
Route::get('/getKalaInfoForEdit',[Kala::class,'getKalaInfoForEdit'])->middleware('checkAdmin');
Route::get('/saveEarth/{gameId}',[Game::class,'index'])->middleware('checkUser');
Route::get('/cronaGame', function() {  return view('game.radius.index'); })->middleware('checkUser');
Route::get('/planetSave', function() {  return view('game.planetDefense.planet');})->middleware('checkUser');
Route::get('/addGameScore',[Game::class,'addGameScore'])->middleware('checkUser');
Route::post('/addGamePrize',[Game::class,'addGamePrize'])->middleware('checkAdmin');
Route::get('/emptyGame',[Admin::class,'emptyGame'])->middleware('checkAdmin');
Route::get('/baseBonusSettings',[Target::class,'index'])->middleware('checkAdmin');
Route::get('/getTargetInfo',[Target::class,'getTargetInfo'])->middleware('checkAdmin');
Route::get("/editTarget",[Target::class,"editTarget"])->middleware('checkAdmin');
Route::get("/setCustomerLotteryHistory",[Lottery::class,"setCustomerLotteryHistory"])->middleware('checkUser');
Route::get("/editLotteryPrize",[Lottery::class,"editLotteryPrize"])->middleware('checkAdmin');
Route::get("/getLotteryInfo",[Lottery::class,"getLotteryPrizes"])->middleware('checkAdmin');
Route::get("/lotteryResult",[Lottery::class,"lotteryResult"])->middleware('checkAdmin');
Route::post("/tasviyeahLottery",[Lottery::class,"tasviyeahLottery"])->middleware('checkAdmin');
Route::get("/setFactorSessions",[Order::class,"setPayOnlineSessions"])->middleware('checkUser');
Route::get('/strayMaster',[Game::class,'strayMaster'])->middleware('checkUser');
Route::get('/hextrisGame',[Game::class,'hextrisGame'])->middleware('checkUser');
Route::get("/salesOrder",[Order::class,"index"])->middleware('checkAdmin');
Route::get("/getOrderDetail",[Order::class,"getOrderDetail"])->middleware('checkAdmin');
Route::get("/getSendItemInfo",[Order::class,"getSendItemInfo"])->middleware('checkAdmin');
Route::post("/addToFactorHisabdari",[Factor::class,"addFactor"])->middleware('checkAdmin');
Route::get("/distroyOrder",[Order::class,"distroyOrder"])->middleware('checkAdmin');
Route::get("/deleteOrderItem",[Order::class,"deleteOrderItem"])->middleware('checkAdmin');
Route::get("/searchItemForAddToOrder",[Order::class,"searchItemForAddToOrder"])->middleware('checkAdmin');
Route::get("/getGoodInfoForAddOrderItem",[Order::class,"getGoodInfoForAddOrderItem"])->middleware('checkAdmin');
Route::get("/addToOrderItems",[Order::class,"addToOrderItems"])->middleware('checkAdmin');
Route::get("/getOrderItemInfo",[Order::class,"getOrderItemInfo"])->middleware('checkAdmin');
Route::get("/editOrderItem",[Order::class,"editOrderItem"])->middleware('checkAdmin');
Route::get("/filterAllSefarishat",[Order::class,"filterAllSefarishat"])->middleware('checkAdmin');
Route::get("/checkOrderExistance",[Order::class,"checkOrderExistance"])->middleware('checkAdmin');
Route::get("/getAllTodayOrders",[Order::class,"getOrdersHistory"])->middleware('checkAdmin');
Route::get("/editorderSendState",[Order::class,"editorderSendState"])->middleware('checkAdmin');
Route::post("/addSefarishToList",[Order::class,"addSefarishToList"])->middleware('checkAdmin');
Route::get("/addMoneyToCase",[Customer::class,"addMoneyToCase"])->middleware('checkUser');
Route::get("/addNazarSanji",[NazarSanji::class,"addNazarSanji"])->middleware('checkAdmin');
Route::get("/editNazar",[NazarSanji::class,"editNazar"])->middleware('checkAdmin');
Route::get("/editQuestion",[NazarSanji::class,"editQuestion"])->middleware('checkAdmin');
Route::get("/updateQuestion",[NazarSanji::class,"updateQuestion"])->middleware('checkAdmin');
Route::get("/getQAnswers",[NazarSanji::class,"getQAnswers"])->middleware('checkAdmin');
Route::get("/getPaymentInfo",[PayOnline::class,"getPaymentInfo"])->middleware('checkAdmin');
Route::get("/payedOnline",[PayOnline::class,"index"])->middleware('checkAdmin');
Route::get("/getPayOnlineHistory",[PayOnline::class,"getPayOnlineHistory"])->middleware('checkAdmin');
Route::get("/getPayedOnline",[PayOnline::class,"filterPayedOnline"])->middleware('checkAdmin');
Route::get("/notification",[Notification::class,"index"])->middleware('checkAdmin');
Route::get("addNotificationMessage",[Notification::class,"sendNotificationToAndroid"])->middleware('checkAdmin');
Route::get("serachNotificationsByDate",[Notification::class,"serachNotificationsByDate"])->middleware('checkAdmin');
Route::get('/deleteCustomerRequest',[Kala::class,'deleteCustomerRequest'])->middleware('checkAdmin');
Route::get('/getOtherRequestedKalas',[Kala::class,'getRequestedKalaByCustomer'])->middleware('checkAdmin');
Route::get('/discountCode',[TakhfifCode::class,'getTakhfifCodeHistory'])->middleware('checkAdmin');
Route::get("/setWeeklyPresent",[Customer::class,'setWeeklyPresent'])->middleware('checkUser');
Route::get("/discountCodeReceiver/{modelSn}/{sabtDate}",[TakhfifCode::class,'getTakhfifCodeReciverByDate']);
Route::get("/addSMSModel",[TakhfifCode::class,"addTakhfifCodeModel"])->middleware('checkAdmin');
Route::get("/EditSMSModel",[TakhfifCode::class,"updateTakhfifCodeModel"])->middleware('checkAdmin');
Route::get("/getSMSModel",[TakhfifCode::class,"getTakhfifCodeModel"])->middleware('checkAdmin');
Route::get("/sendSMSModel",[TakhfifCode::class,"sendTakhfifCode"])->middleware('checkAdmin');
Route::get("/filterSMS",[TakhfifCode::class,"filterTakhfifCodes"])->middleware('checkAdmin');
Route::get("/getSMSHistory",[TakhfifCode::class,"getTakhfifCodeHistoryByDay"])->middleware('checkAdmin');
Route::get("/checkTakhfifCodeState",[TakhfifCode::class,"checkTakhfifCodeReliablity"])->middleware('checkUser');
Route::get("/getCustomerSMS",[TakhfifCode::class,"getCustomerTakhfifCodes"])->middleware('checkAdmin');
Route::get("/getsmsModelsHistoryByDate",[TakhfifCode::class,"getTakhfifCodeHistoryByDate"])->middleware('checkAdmin');
Route::get("/removeTakhfifCodeNotify",[TakhfifCode::class,"removeNotify"])->middleware('checkAdmin');
Route::get("/deleteNotificationHistory",[Notification::class,"deleteNotificationHistory"])->middleware('checkAdmin');
Route::get("/deleteShegeftImage",[Home::class,"deleteShegeftImage"])->middleware('checkAdmin');
Route::get('/discountAndPrize',[TakhfifCode::class,'index'])->middleware('checkUser');
Route::get("/searchKalaOnChange",[Kala::class,"publicSearch"])->middleware('checkUser');
Route::get("/requestCheck",[Cheque::class,'showRequestForm'])->middleware('checkUser');
Route::post("/addRequestCheck",[Cheque::class,"addRequestCheck"])->middleware('checkUser');
Route::get("/showCheckReqInfo",[Cheque::class,"showCheckReqInfo"])->middleware('checkAdmin');
Route::get("/changeCheckReqState",[Cheque::class,"changeCheckReqState"])->middleware('checkAdmin');
Route::get("/filterReqCheques",[Cheque::class,"filterReqCheques"])->middleware('checkAdmin');
Route::get("/getPartType",[Home::class,"getPartType"])->middleware('checkAdmin');
Route::get("/deletePlayedGamePeriod",[Game::class,"deletePlayedGamePeriod"])->middleware('checkAdmin');
Route::get("/getCustomerForOrder",[Customer::class,"getCustomerForOrder"])->middleware('checkAdmin');
Route::get("/getInfoOfOrderCustomer",[Customer::class,"getInfoOfOrderCustomer"])->middleware('checkAdmin');
Route::get("/doEditOrder",[Order::class,"doEditOrder"])->middleware('checkAdmin');
Route::get("/getKalaByName",[Kala::class,"getKalaByName"])->middleware('checkAdmin');
Route::get('/searchKalaByCode',[Kala::class,'getKalaByCode'])->middleware('checkAdmin');
Route::get('/salesFactors',[Factor::class,'salesFactors'])->middleware('checkAdmin');
Route::get('/getFactorBYSInfo',[Factor::class,'getFactorBYSInfo'])->middleware('checkAdmin');
Route::get("/getDriverFactors",[Factor::class,'getDriverFactors'])->middleware('checkAdmin');
Route::get("/getDrivers",[Driver::class,'allDrivers'])->middleware('checkAdmin');
Route::get("/allBanks",[Bank::class,'allBanks'])->middleware('checkAdmin');
Route::get("/getMasterBarInfo",[Bargiri::class,'getMasterBarInfo'])->middleware('checkAdmin');
Route::get("/getMantiqasOfFactors",[Masir::class,'getMantiqasOfFactors'])->middleware('checkAdmin');
Route::get("/getMantiqasFactorForBargiri",[Masir::class,'getMantiqasFactorForBargiri'])->middleware('checkAdmin');
Route::get("/addFactorToBargiri",[Bargiri::class,'addFactorToBargiri'])->middleware('checkAdmin');
Route::get("/getFactorsInfoToBargiriTbl",[Bargiri::class,'getFactorsInfoToBargiriTbl'])->middleware('checkAdmin');
Route::get("/addFactorsToBargiri",[Bargiri::class,'addFactorsToBargiri'])->middleware('checkAdmin');
Route::get("/doEditBargiriFactors",[Bargiri::class,'doEditBargiriFactors'])->middleware('checkAdmin');
Route::get("/deleteBargiriHDS",[Bargiri::class,'deleteBargiriHDS'])->middleware('checkAdmin');
Route::get("/filterFactors",[Factor::class,'filterFactors'])->middleware('checkAdmin');
Route::get("/getFactorInfoForEdit",[Factor::class,'getFactorInfoForEdit'])->middleware('checkAdmin');
Route::post("/doEditFactor",[Factor::class,'doEditFactor'])->middleware('checkAdmin');
Route::post("/addFactor",[Factor::class,'addFactorFromAdmin'])->middleware('checkAdmin');
Route::get("/getCustomerGardish",[Customer::class,'getCustomerGardish'])->middleware('checkAdmin');
Route::get("/getGardishKala",[Kala::class,'getGardishKala'])->middleware('checkAdmin');
Route::get("/getlastTenBuys",[Kala::class,'getlastTenBuys'])->middleware('checkAdmin');
Route::get("/getlastTenSales",[Kala::class,'getlastTenSales'])->middleware('checkAdmin');
Route::get("/getUnSentOrders",[Kala::class,'getUnSentOrders'])->middleware('checkAdmin');
Route::get("/getGameHistory",[Game::class,"getGameHistory"])->middleware("checkAdmin");
Route::get("/getFactorHistory",[Factor::class,"getFactorHistory"])->middleware("checkAdmin");
Route::get("/deleteFactor",[Factor::class,"deleteFactor"])->middleware("checkAdmin");
Route::get("/checkAddedKalaPrice",[Kala::class,"checkAddedKalaPrice"])->middleware("checkAdmin");
Route::post("/doUpdateOrder",[Order::class,"doUpdateOrder"])->middleware("checkAdmin");
Route::get("/getBankInfo",[Bank::class,"getBankInfo"])->middleware("checkAdmin");
Route::get("/returnedFactors",[Factor::class,"returnedFactors"])->middleware("checkAdmin");
Route::get("/filterRFactors",[Factor::class,"filterRFactors"])->middleware("checkAdmin");
Route::get("/getRFactorHistory",[Factor::class,"getRFactorHistory"])->middleware("checkAdmin");
Route::get("/buyFactors",[Factor::class,"buyFactors"])->middleware("checkAdmin");
Route::get("/returnedBuyFactors",[Factor::class,"buyReturnedFactors"])->middleware("checkAdmin");
Route::get("/receives",[Box::class,'index'])->middleware("checkAdmin");
Route::get("/getGetAndPayBYS",[Box::class,'getGetAndPayBYS'])->middleware("checkAdmin");
Route::get("/filterGetPays",[Box::class,'filterGetPays'])->middleware("checkAdmin");
Route::get('/getCustomerInofByCode', [Customer::class, 'getCustomerInofByCode'])->middleware("checkAdmin");
Route::get('/getInforTypeInfo', [Infors::class, 'getInforTypeInfo'])->middleware("checkAdmin");
Route::get('/getFactorInfoByFactNo', [Factor::class, 'getFactorInfoByFactNo'])->middleware("checkAdmin");
Route::get('/getFactorInfoBySnFactor', [Factor::class, 'getFactorInfoBySnFactor'])->middleware("checkAdmin");
Route::get('/getAllShobeBanks', [Bank::class, 'getAllShobeBanks'])->middleware("checkAdmin");
Route::get('/getSandoghs', [Box::class, 'getSandoghs'])->middleware("checkAdmin");
Route::post('/addDaryaft', [Box::class, 'addDaryaft'])->middleware("checkAdmin");
Route::get('/getGetAndPayInfo', [Box::class, 'getGetAndPayInfo'])->middleware("checkAdmin");
Route::get("/pays",[Box::class,'pays'])->middleware("checkAdmin");
Route::get('/getFiscalYears', [App::class, 'getFiscalYears'])->middleware("checkAdmin");