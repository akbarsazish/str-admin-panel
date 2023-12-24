<tr onclick="setAddedDaryaftItemStuff(this, 107889)" ondblclick="editAddedDaryaftItem(this,2,107889)" class="selected">
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
    <td class="d-none"> <input type="text" value="${hisabNoChequeDar}" name="AccBankNo${currentIndex+1}"> </td>
    <td class="d-none"> <input type="text" value="${chequekOwner}" name="Owener${currentIndex+1}"> </td>
    <td class="d-none"> <input type="text" value="${bankName}" name="SnBank${currentIndex+1}"> </td>
    <td class="d-none"> <input type="text" value="0" name="SnChequeBook${currentIndex+1}"> </td>
    <td class="d-none"> <input type="text" value="${chequeDescription}" name="DocDescBys${currentIndex+1}"> </td>
    <td class="d-none"> <input type="text" value="${bankSn}" name="SnAccBank${currentIndex+1}"> </td>
    <td class="d-none"> <input type="text" value="" name="CashNo${currentIndex+1}"> </td>
    <td class="d-none"> <input type="text" value="0" name="NoPayanehKartKhanBYS${currentIndex+1}"> </td>
    <td class="d-none"> <input type="text" value="0" name="SnPeopelPay${currentIndex+1}"> </td>
    <td class="d-none"> <input type="text" value="0" name="SerialNoBYS${currentIndex+1}"> </td>
</tr>

<td class="addEditVagheNaqd-1"> <input  type="checkbox" checked value="${currentIndex+i}" name="byss[]"/></td>

<td class="d-none"> <input type="text" value="${sarRasedDate}" name="ChequeDate${currentIndex+1}" class=""/> </td>
<td class="d-none"> <input type="text" value="${chequeNo+i}" name="ChequeNo${currentIndex+1}" class=""/> </td>
<td class="d-none"> <input type="text" value="${hisabNoChequeDar}" name="AccBankNo${currentIndex+1}" class=""/> </td>
<td class="d-none"> <input type="text" value="${chequekOwner}" name="Owener${currentIndex+1}" class=""/> </td>
<td class="d-none"> <input type="text" value="${bankName}" name="SnBank${currentIndex+1}" class=""/> </td>
<td class="d-none"> <input type="text" value="0" name="SnChequeBook${currentIndex+1}" class=""/> </td>
<td class="d-none"> <input type="text" value="${chequeDescription}" name="DocDescBys${currentIndex+1}" class=""/> </td>
<td class="d-none"> <input type="text" value="${bankSn}" name="SnAccBank${currentIndex+1}" class=""/> </td>
<td class="d-none"> <input type="text" value="0" name="NoPayanehKartKhanBYS${currentIndex+1}" class=""/> </td>
<td class="d-none"> <input type="text" value="0" name="SnPeopelPay${currentIndex+1}" class=""/> </td>
<td class="d-none"> <input type="text" value="${repeateChequeDar}" name="repeatChequDar${currentIndex+1}" class=""/> </td>
<td class="d-none"> <input type="text" value="${sarRasedDistanceMonth}" name="dueDateMonth${currentIndex+1}" class=""/> </td>
<td class="d-none"> <input type="text" value="${sarRasedDistanceDay}" name="dueDateDat${currentIndex+1}" class=""/> </td>
<td class="d-none"> <input type="text" value="${chequekDateForLater}" name="laterDate${currentIndex+1}" class=""/> </td>