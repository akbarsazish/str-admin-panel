<%@ Language=VBScript%>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<%
mes=""
IsSuccess = false

sServer = Trim(Request.Form("txtServer"))
sPort = Trim(Request.Form("txtPort"))
sUser = Trim(Request.Form("txtUser"))
sPassword = Trim(Request.Form("txtPassword"))

if Request("__action")="TestDB" then
  TestDB()
end if

Sub TestDB()

  Err.Clear()
  on error resume next
  Set objConn = Server.CreateObject("ADODB.Connection")
  if len(Err.Description)<>0 then
    mes = " " & Err.Description & " MySQL connection can't be established!"
  else
    objConn.ConnectionString = _
    "DRIVER={MySQL ODBC 3.51 Driver};PORT=" & sPort & _
    ";SERVER=" & sServer & _
    ";UID=" & sUser & _
    ";PWD=" & sPassword
    objConn.Open
    if len(Err.Description)<>0 then
      mes = " " & Err.Description & " MySQL connection can't be established!"
    else
      mes = " MySQL connection succesfull established!"
      IsSuccess = true
    end if
  end if
  Set objConn = Nothing
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
  <form id="form1" action="test_mysql.asp?__action=TestDB&tp=<%= rnd(1)*100*timer %>" method="POST">
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
        <li class="first" id="current"><a href="test_mysql.asp"><span>MySQL</span></a></li>
        <li><a href="test_mssql.asp"><span>MSSQL</span></a></li>
        <li><a href="test_msaccess.asp"><span>MS Access</span></a></li>
        <li class="last"><a href="test_mail.asp"><span>E-Mail</span></a></li>
      </ul>
    </div>
    <!-- MySQL server -->
    <div class="tab-content clear">
      <p>This page allows to check the connection possibility between the SQL client on your host and one of remote database server. You should have working accounts on the database servers you want to test. Here you can test the connection possibility with the MySQL server.</p>
      <% if len(mes) > 0 then	Alert(mes) end if %>
      <fieldset>
        <legend id="LegendName">Test MySQL Connection</legend>
        <table class="formFields" cellspacing="0" width="100%">
          <tr>
            <td class="name"><label id="lblSource" for="txtServer">Server</label></td>
            <td><input type = text name="txtServer" size = "25" value = "<% Response.Write(sServer) %>"></td>
          </tr>
          <tr>
            <td class="name"><label for="txtPort">Port</label></td>
            <td><input type = text name="txtPort" MaxLength="4" size="5" value="<% if len(sPort)=0 then Response.Write("3306") else Response.Write(sPort) end if%>"></td>
          </tr>
          <tr>
            <td class="name"><label for="txtUser">User name</label></td>
            <td><input type = text name="txtUser" size="25" value = "<% Response.Write(sUser) %>"></td>
          </tr>
          <tr>
            <td class="name"><label for="txtPassword">Password</label></td>
            <td><input type = password  name="txtPassword" size="25"></td>
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
