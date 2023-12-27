<td class="addEditVagheNaqd-1"> ${currentIndex} <input class="d-none" type="checkbox" value="1" name="BYSS[]" checked=""> </td>
<td class="addEditVagheNaqd-2"> 0 </td>
<td class="addEditVagheNaqd-3"> چک بانک ${bankName} به شماره ${accountNo + i} تاریخ ${updateDateHijri} </td>
<td class="addEditVagheNaqd-4"> ${parseInt(chequeAmount).toLocaleString("en-us")} </td>
<td class="addEditVagheNaqd-5"> 0 </td>
<td class="addEditVagheNaqd-6"> ${seyadiNo} </td>
<td class="addEditVagheNaqd-7"> ${sabtShoudaBeName}  </td>
<td class="d-none"> <input type="text" value="2" name="DocTypeBys"> </td>
<td class="d-none"> <input type="text" value="${chequeAmount}" name="Price${currentIndex+1}"> </td>
<td class="d-none"> <input type="text" value="${sarRasedDate}" name="ChequeDate${currentIndex+1}"> </td>
<td class="d-none"> <input type="text" value="${chequeNo+i}" name="ChequeNo${currentIndex+1}"> </td>
<td class="d-none"> <input type="text" value="${accountNo}" name="AccBankNo${currentIndex+1}"> </td>
<td class="d-none"> <input type="text" value="${chequekOwner}" name="Owner${currentIndex+1}"> </td>
<td class="d-none"> <input type="text" value="${bankName}" name="SnBank${currentIndex+1}"> </td>
<td class="d-none"> <input type="text" value="0" name="SnChequeBook${currentIndex+1}"> </td>
<td class="d-none"> <input type="text" value="${chequeDescription}" name="DocDescBys${currentIndex+1}"> </td>
<td class="d-none"> <input type="text" value="${bankSn}" name="SnAccBank${currentIndex+1}"> </td>
<td class="d-none"> <input type="text" value="0" name="CashNo${currentIndex+1}"> </td>
<td class="d-none"> <input type="text" value="0" name="NoPayanehKartKhanBYS${currentIndex+1}"> </td>
<td class="d-none"> <input type="text" value="0" name="SnPeopelPay${currentIndex+1}"> </td>
<td class="d-none"> <input type="text" value="0" name="SerialNoBYS${currentIndex+1}"> </td>
<td class="d-none"> <input type="text" value="${sabtShoudaBeName}" name="NameSabtShode${currentIndex+1}"> </td>
<td class="d-none"> <input type="text" value="${chequekDateForLater}" name="chequeDateForLater"> </td>


<td class="d-none"> <input type="text" value="${element.DocTypeBYS}" name="DocTypeBys${index}"/> </td>
<td class="d-none"> <input type="text" value="${element.Price}" name="Price${index}"/> </td>
<td class="d-none"> <input type="text" value="${element.ChequeDate}" name="ChequeDate${index}"/> </td>
<td class="d-none"> <input type="text" value="${element.ChequeNo}" name="ChequeNo${index}"/> </td>
<td class="d-none"> <input type="text" value="${element.AccBankno}" name="AccBankNo${index}"/> </td>
<td class="d-none"> <input type="text" value="${element.Owner}" name="Owner${index}"/> </td>
<td class="d-none"> <input type="text" value="${element.SnBank}" name="SnBank${index}"/> </td>
<td class="d-none"> <input type="text" value="${element.SnChequeBook}" name="SnChequeBook${index}"/> </td>
<td class="d-none"> <input type="text" value="${element.DocDescBYS}" name="DocDescBys${index}"/> </td>
<td class="d-none"> <input type="text" value="${element.SnAccBank}" name="SnAccBank${index}"/> </td>
<td class="d-none"> <input type="text" value="${element.CashNo}" name="CashNo${index}"/> </td>
<td class="d-none"> <input type="text" value="${element.NoPayaneh_KartKhanBys}" name="NoPayanehKartKhanBYS${index}"/> </td>
<td class="d-none"> <input type="text" value="${element.SnPeopelPay}" name="SnPeopelPay${index}"/> </td>
<td class="d-none"> <input type="text" value="${element.SerialNoBYS}" name="SerialNoBYS${index}"/> </td>
<td class="d-none"> <input type="text" value="${element.NameSabtShode}" name="NameSabtShode${index}"/> </td>
<td class="d-none"> <input type="text" value="0" name="trafHesabName${index}"/> </td>

DELETE FROM Shop.dbo.GetAndPayBYS WHERE SnHDS in (SELECT SerialNoHDS FROM Shop.dbo.GetAndPayHDS WHERE PeopelHDS = 3609 AND DocTypeHDS = 0)

DELETE FROM Shop.dbo.GetAndPayBYS WHERE SnHDS in (SELECT SerialNoHDS FROM Shop.dbo.GetAndPayHDS WHERE PeopelHDS = 3609 AND DocTypeHDS = 0)

DELETE FROM Shop.dbo.GetAndPayBYS