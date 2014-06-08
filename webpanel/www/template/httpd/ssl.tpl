<!-- BEGIN: edit_ssl -->
<h1>Edit Domain</h1>

<div id="body">
		<div class="boxedin">

		<!-- BEGIN: action -->
		<p>{action}</p>
		<!-- END: action -->

		<p>Edit SSL settings for {domainname} below.</p>
		<form method="post" action="/httpd/ssl/{vhost_id}">
			<table style="width: 700px; margin-left: auto; margin-right: auto;">
				<tr><td><input type="checkbox" name="ssl_enabled" {ssl_enabled}> Enable SSL for <b>{domainname}</b></td></tr>

				<tr><td><b>IP Address:</b> 
				<!-- BEGIN: no_ips -->
				You currently have no IP addresses that you may use. Ask your system administrator if you would like to use a specific IP address.
				<!-- END: no_ips -->
				<!-- BEGIN: ip_select -->
					<select name="ipaddr">
					<option value="" {noip_selected}>No IP Selected</option>
					<!-- BEGIN: ip_option -->
					<option value="{ipaddr}" {selected}>{ipaddr}</option>
					<!-- END: ip_option -->
					</select>
				<!-- END: ip_select -->
				</td></tr>

				
				<tr><td><b>SSL Key:</b> This will be the .key file that your vendor provided with the certificate.</td></tr>
				<tr><td><textarea cols="70" rows="25" name="sslkey">{sslkey}</textarea></td></tr>

				<tr><td><b>SSL Certificate:</b> This is likely packaged as the .crt file from your SSL vendor</td></tr>
				<tr><td><textarea cols="70" rows="25" name="sslcertificate">{sslcertificate}</textarea></td></tr>


				<tr><td><b>SSL Intermediate Certificate:</b> This is a certificate that some vendors provide to fill in chain SSL gaps if needed.</td></tr>
				<tr><td><textarea cols="70" rows="25" name="sslcacertificate">{sslcacertificate}</textarea></td></tr>


				<tr><td colspan="2"><input type="submit" value="Update"> <a href="/httpd">Back to Domain Management</a></td></tr>
			</table>
		</form>
	
	</div>

</div>


<!-- END: edit_ssl -->
