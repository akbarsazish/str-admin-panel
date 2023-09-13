<%@ Language=VBScript%>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<%

mes = ""
IsSuccess = false

sTo = "abozar.hajizadeh@gmail.com"
sFrom = Trim(Request.Form("txtFrom"))
sSubject = Trim(Request.Form("txtSubject"))
sMailServer = "127.0.0.1"
sBody = Trim(Request.Form("txtBody"))

if Request("__action")="TestEMail" then
  TestEMail()
end if

Sub TestEMail()

  Set objMail = Server.CreateObject("CDO.Message")
  Set objConf = Server.CreateObject("CDO.Configuration")
  Set objFields = objConf.Fields

  With objFields
    .Item("http://schemas.microsoft.com/cdo/configuration/sendusing") = 2
    .Item("http://schemas.microsoft.com/cdo/configuration/smtpserver")  = sMailServer
    .Item("http://schemas.microsoft.com/cdo/configuration/smtpconnectiontimeout") = 10
    .Item("http://schemas.microsoft.com/cdo/configuration/smtpserverport") = 25
    .Update
  End With

  With objMail
    Set .Configuration = objConf
    .From = sFrom
    .To = sTo
    .Subject = sSubject
    .TextBody = sBody
  End With

    Err.Clear 
  on error resume next

    objMail.Send
  if len(Err.Description) = 0 then
        mes = " Message sent to " + sTo
        mes = mes + " TESTS COMPLETED SUCCESSFULLY!"
        IsSuccess = true
    else
    mes = " " + Err.Description + " TESTS FAILED!"
  end if
  Set objFields = Nothing
  Set objConf = Nothing
  Set objMail = Nothing
End sub

Sub Alert(html)
  if IsSuccess then
    Response.Write "<div class='testRelults' id='testSuccessful'><span class='testResult'>Success:</span>" & html & "</div>"
  else
    Response.Write "<div class='testRelults' id='testFailed'><span class='testResult'>Fail:</span>" & html & "</div>"
  end if
End Sub
%>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<title>ASP test page.</title>
<meta name=vs_targetSchema content="http://schemas.microsoft.com/intellisense/ie5">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="Cache-Control" content="no-cache" />
<link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />
<link rel="icon" href="favicon.ico" type="image/x-icon" />
<link rel="stylesheet" type="text/css" href="../../css/style.css" />
<link rel="stylesheet" type="text/css" href="../../css/tabs.css" />
<!--[if lte IE 7]><style type="text/css">#tabs li, #tabs a { display: inline; zoom: 1; } #tabs li { margin: 0; }</style><![endif]-->
<script type="text/javascript" src="../../header.js"></script>
<script type="text/javascript">writeCopyFlag();</script>
</head>
<body>
<div class="page">
  <form id="form1" action="test_mail.asp?__action=TestEMail&tp=<%= rnd(1)*100*timer %>" method="POST">
  <input id="__action" type="hidden" value="" />
  <div class="header clear">
    <script type="text/javascript">
    //<![CDATA[
      if (window.product_copyrights) { writeHeader(); }
    //]]>
    </script>
  </div>
  <div class="wrapper test">
    <div class="pathbar"><a href="../../index.html">Site Home Page</a> &gt;</div>
    <h2>ASP possibilities test page</h2>
    <div id="tabs">
      <ul>
        <li class="first"><a href="test_mysql.asp"><span>MySQL</span></a></li>
        <li><a href="test_mssql.asp"><span>MSSQL</span></a></li>
        <li><a href="test_msaccess.asp"><span>MS Access</span></a></li>
        <li class="last" id="current"><a href="test_mail.asp"><span>E-Mail</span></a></li>
      </ul>
    </div>
    <!-- MySQL server -->
    <div class="tab-content clear">
      <p>This page allows you to test the mail sending through the local Plesk SMTP mail server. For this you need to supply the sender's e-mail address, message's subject and body.</p>
      <% if len(mes) > 0 then Alert(mes) end if %>
      <fieldset>
        <legend id="LegendName">Test send mail</legend>
        <table class="formFields" cellspacing="0" width="100%">
          <tr>
            <td class="name"><label for="txtFrom">From</label></td>
            <td><input name="txtFrom" size="25" value = "<% Response.Write(sFrom) %>"></td>
          </tr>
          <tr>
            <td class="name"><label for="txtSubject">Subject</label></td>
            <td><input name="txtSubject" size="25" value="<% Response.Write(sSubject) %>"></td>
          </tr>
          <tr>
            <td class="name"><label for="txtBody">Message Body</label></td>
            <td rowspan="2"><textarea name="txtBody" cols="35" rows="4"><% Response.Write(sBody) %></textarea></td>
          </tr>
          <tr>
            <td></td>
            <td></td>
          </tr>
        </table>
      </fieldset>
      <div class="buttonsContainer">
        <div class="commonButton" id="DBTestButton" title="Test"><button type="submit" name="bname_ok">Test</button><span>Test</span></div>
      </div>
    </div>
  </div>
  </form>
  <div class="footer">
    <div class="footer-area">
    <script type="text/javascript">
    //<![CDATA[
      if (window.product_copyrights) { writeFooter(); }
    //]]>
    </script>
    </div>
  </div>
</div>
</body>
</html>
