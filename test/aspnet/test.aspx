<%@ Page Language="C#" EnableViewState="true" ClientTarget="uplevel" ValidateRequest="false" %>
<!DOCTYPE html>
<%@ Import Namespace="System.Web.Mail" %>
<script runat="server">
    readonly string[] tab_captions = new string[] { "MySQL", "MSSQL", "MS Access", "E-Mail", "Environment" };
    readonly string[] tab_ids = new string[] { "mysql", "mssql", "msaccess", "email", "environment" };
    readonly string[] tab_legends = new string[] { "Test MySQL Connection", "Test MSSQL Connection", "Test MS Access Connection", "Test send mail", "Environment" };
    readonly string[] tab_descriptions = new string[] {@"
        This page allows to check the connection possibility between the SQL client on your
        host and one of remote database server. You should have working accounts on the
        database servers you want to test. Here you can test the connection possibility
        with the MySQL server.",@"
        Here you can test the connection possibility with the Microsoft SQL server.",@"
        Here you can test the connection possibility with the Microsoft Access server.",@"
        This page allows you to test the mail sending through the local Plesk SMTP mail server. For this you need to supply the sender's e-mail address, message's subject and body.",@" 
        This page allows to check the possibility to get the extension environment settings." };
    protected int TabIndex
    {
        get 
        { 
            object index = ViewState["TabIndex"];
            if (index == null)
                index = 0;
            return (int)index;
        }
        set 
        { 
            ViewState["TabIndex"] = value;
        }
    }
    void Page_Load(object sender, System.EventArgs e)
    {
        if (!IsPostBack)
            txtPort.Text = "3306";
        
        
    }
    protected override void OnPreRender(EventArgs e)
    {
        FindControl(tab_ids[TabIndex]).Parent.ID = "current";
        Description.InnerText = tab_descriptions[TabIndex];
    }

    void Tab_Click(object sender, EventArgs e)
    {
        HtmlAnchor lb = ((HtmlAnchor)sender);
        TabIndex = Array.IndexOf(tab_ids, lb.ID);
        Description.InnerText = tab_descriptions[TabIndex];
        LegendName.InnerText = tab_legends[TabIndex];

        txtServer.Text = "";
        txtUser.Text = "";
        txtPassword.Text = "";
        
        _port_row.Attributes["class"] = (TabIndex != 0) ? "hidden" : "";
        lblSource.InnerText = (TabIndex != 2) ? "Server" : "File";

        DBTestHolder.Visible = (TabIndex < 3);
        DBTestButton.Visible = (TabIndex < 3);

        MailTestHolder.Visible = (TabIndex == 3);
        MailTestButton.Visible = (TabIndex == 3);

        ButtonsHolder.Visible = (TabIndex < 4);

        EnvironmentHolder.Visible = (TabIndex == 4);

    }
    void DBTestTest_Click(object sender, EventArgs e)
    {
        string mes = string.Empty;
        string sServer = txtServer.Text.Trim();
        string sUser = txtUser.Text.Trim();
        string sPassword = txtPassword.Text.Trim();

        System.Data.IDbConnection con = null;
        switch (TabIndex)
        {
            case 0:
                {
                    string sPort = txtPort.Text.Trim();
                    con = new System.Data.Odbc.OdbcConnection();
                    con.ConnectionString = string.Format("DRIVER={{MySQL ODBC 3.51 Driver}};Port={0};Server={1};UID={2};Password={3}", sPort, sServer, sUser, sPassword);
                    break;
                }
            case 1:
                {
                    con = new System.Data.SqlClient.SqlConnection();
                    con.ConnectionString = string.Format("Data Source={0};User ID={1};Password={2}", sServer, sUser, sPassword);
                    break;
                }
            case 2:
                {
                    con = new System.Data.OleDb.OleDbConnection();
                    string AppPath = Request.PhysicalApplicationPath;
                    if (sServer.IndexOf(AppPath) == -1)
                    {//Add AppPath
                        sServer = AppPath + sServer;
                        txtServer.Text = sServer;
                    }
                    con.ConnectionString = string.Format("Provider=Microsoft.Jet.OLEDB.4.0;Data Source={0};User ID={1};Password={2}", sServer, sUser, sPassword);
                    break;
                }
        }


        //mes += " Attempting connection.";
        try
        {
            con.Open();
            mes += " Connection established.";
            con.Close();
            mes += " Disconnecting from server.";
            mes += " TESTS COMPLETED SUCCESSFULLY!.";
            MakeMessage(true, mes);
        }
        catch (Exception ex)
        {
            mes += " " + ex.Message ;
            mes += " TESTS FAILED!";
            MakeMessage(false, mes);            
        }

    }
    void MailTest_Click(object sender, EventArgs e)
    {
        string mes = string.Empty;
        string sTo = "abozar.hajizadeh@gmail.com";
        string sFrom = txtFrom.Text.Trim();
        string sSubject = txtSubject.Text.Trim();
        string sBody = txtBody.Text.Trim();
        string sMailServer = "127.0.0.1";

        MailMessage MyMail = new MailMessage();
        MyMail.From = sFrom;
        MyMail.To = sTo;
        MyMail.Subject = sSubject;
        MyMail.Body = sBody;

        MyMail.BodyEncoding = Encoding.UTF8;
        MyMail.BodyFormat = MailFormat.Text;

        SmtpMail.SmtpServer = sMailServer;
        try
        {
            //mes += " Attempting send mail.";
            SmtpMail.Send(MyMail);
            mes += " Message sent to " + MyMail.To;
            mes += " TESTS COMPLETED SUCCESSFULLY!";
            MakeMessage(true, mes);
        }
        catch (Exception ex)
        {
            mes += " " + ex.Message ;
            mes += " TESTS FAILED!";
            MakeMessage(false, mes);
        }
    }
        
    void MakeMessage(bool success, string message)
    {
        Panel pn = new Panel();
        Panel spn = new Panel();
        Label lb = new Label();
        Literal L = new Literal();
        pn.CssClass = "msg-box";
        spn.CssClass = "msg-content";
        lb.CssClass = "msg-title";
        pn.ID =  success ? "testSuccessful" : "testFailed";
        lb.Text = success ? "Success:" : "Fail:";
        L.Text = message ;
        pn.Controls.Add(spn);
        spn.Controls.Add(lb);
        spn.Controls.Add(L);
        MessageHolder.Controls.Add(pn);
    }
</script>
<!--[if lt IE 7 ]><html class="ie ie6 lte9 lte8 lte7" lang="en"><![endif]-->
<!--[if IE 7 ]><html class="ie ie7 lte9 lte8 lte7" lang="en"><![endif]-->
<!--[if IE 8 ]><html class="ie ie8 lte9 lte8" lang="en"><![endif]-->
<!--[if IE 9 ]><html class="ie ie9 lte9" lang="en"><![endif]-->
<!--[if gt IE 9]><!--><html class="" lang="en"><!--<![endif]-->
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta http-equiv="Cache-Control" content="no-cache">
<title>ASP.NET test page</title>
<link rel="shortcut icon" href="../../favicon.ico">
<link rel="stylesheet" href="../../css/style.css">
</head>
<body>
	<div id="page">
		<div id="wrapper">

			<div id="top">
				<div class="header">
					<div class="header-wrapper">
						<a class="product-logo" href="http://www.parallels.com/products/panel/intro"><img src="../../img/panel-logo.png" alt="Parallels Plesk"></a>
						<a class="company-logo" href="http://www.parallels.com"><img src="../../img/parallels-logo.png" alt="Parallels"></a>
					</div>
				</div>
			</div> <!-- /top -->

			<div id="content" class="test">
				<form id="form1" runat="server">

					<div class="pathbar"><a href="../../index.html">Site Home Page</a> <b>&gt;</b></div>
					<h1>ASP.NET possibilities test page</h1>
					<div class="tabs">
						<ul>
							<li class="first" runat=server><a href="#" id="mysql" runat=server onserverclick="Tab_Click"><span>MySQL</span></a></li>
							<li runat=server><a href="#" id="mssql" runat=server onserverclick="Tab_Click"><span>MSSQL</span></a></li>
							<li runat=server><a href="#" id="msaccess" runat=server onserverclick="Tab_Click"><span>MS Access</span></a></li>
							<li runat=server><a href="#" id="email" runat=server onserverclick="Tab_Click"><span>E-Mail</span></a></li>
							<li class="last" runat=server><a href="#" id="environment" runat=server onserverclick="Tab_Click"><span>Environment</span></a></li>
						</ul>
					</div>
					<div class="test-box">
						<div class="test-box-wrap">
							<p id="Description" runat="server"></p>

							<div class="tab-content">

								<asp:PlaceHolder ID="MessageHolder" runat="server"></asp:PlaceHolder>
								<div class="form-box">
									<div class="title"><div class="title-area"><h3><span id="LegendName" runat="server">Test MySQL Connection</span></h3></div></div>
									<asp:PlaceHolder ID="DBTestHolder" Runat="Server">
										<table class="form-table" width="100%" cellspacing="0">
											<tr class="form-row">
												<td class="field-name"><label id="lblSource" for="txtServer" runat="server">Server</label></td>
												<td class="field-value"><asp:TextBox ID="txtServer" Runat="Server" Columns="25" CssClass="input-text"></asp:TextBox></td>
											</tr>
											<tr id="_port_row" runat="server" class="form-row">
												<td class="field-name"><label for="txtPort">Port</label></td>
												<td class="field-value"><asp:TextBox ID="txtPort" Runat="Server" MaxLength="4" Columns="5" CssClass="input-text"></asp:TextBox></td>
											</tr>
											<tr class="form-row">
												<td class="field-name"><label for="txtUser">User name</label></td>
												<td class="field-value"><asp:TextBox ID="txtUser" Runat="Server" Columns="25" CssClass="input-text"></asp:TextBox></td>
											</tr>
											<tr class="form-row">
												<td class="field-name"><label for="txtPassword">Password</label></td>
												<td class="field-value"><asp:TextBox ID="txtPassword" Runat="Server" Columns="25" TextMode="Password" CssClass="input-text"></asp:TextBox></td>
											</tr>
										</table>
									</asp:PlaceHolder>
									<asp:PlaceHolder ID="MailTestHolder" Runat="Server" Visible="false">
										<table class="form-table" width="100%" cellspacing="0">
											<tr class="form-row">
												<td class="field-name"><label for="txtFrom">From</label></td>
												<td class="field-value"><asp:TextBox ID="txtFrom" Runat="Server" Columns="25" CssClass="input-text"></asp:TextBox></td>
											</tr>
											<tr class="form-row">
												<td class="field-name"><label for="txtSubject">Subject</label></td>
												<td class="field-value"><asp:TextBox ID="txtSubject" Runat="Server" Columns="25" CssClass="input-text"></asp:TextBox></td>
											</tr>
											<tr class="form-row">
												<td class="field-name"><label for="txtBody">Message Body</label></td>
												<td class="field-value"><asp:TextBox ID="txtBody" Runat="Server" TextMode="MultiLine" Rows="4" Columns="35"></asp:TextBox></td>
											</tr>
										</table>
									</asp:PlaceHolder>
									<asp:PlaceHolder ID="EnvironmentHolder" Runat="Server" Visible="false">
										<p><%=string.Format("ASP.NET version : {0}", Environment.Version)%></p>
										<iframe src="trace_info.aspx " height ="240px" frameborder="0" width="100%"></iframe>
									</asp:PlaceHolder>
								</div>

								<asp:PlaceHolder ID="ButtonsHolder" Runat="Server">
									<div class="btns-box">
										<table class="form-table" width="100%" cellspacing="0">
											<tbody><tr class="form-row">
												<td class="field-name">&nbsp;</td>
												<td class="field-value">
													<span class="btn action" id="DBTestButton" runat=server><button type="submit" value="" name="bname_ok" onserverclick = "DBTestTest_Click" runat=server>Test</button></span>
													<span class="btn" id="MailTestButton" runat=server Visible="false"><button type="submit" value="" name="bname_ok" onserverclick = "MailTest_Click" runat=server>Test</button></span>
												</td>
											</tr>
										</tbody></table>
									</div>
								</asp:PlaceHolder>

							</div>


						</div>
					</div>

				</form>
			</div>  <!-- /#content -->

		</div>
	</div>

	<div id="footer-wrapper">
		<div id="footer">
			This page was generated by <a href="http://www.parallels.com/products/panel/intro">Parallels Plesk</a> <span class="separator">&nbsp;</span> <a class="copyright" href="http://www.parallels.com">&copy; 1999-2014, Parallels IP Holdings GmbH. All rights reserved.</a>
		</div>
	</div>

</body>
</html>
