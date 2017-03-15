<?php

// Return Email HTML Template
function getEmailTemplate( $title, $content, $username, $password ) {
	return '<table border="0" cellpadding="0" cellspacing="0" style="margin:0 auto;background-color:#fdfdfd;border:1px solid #dcdcdc;border-radius:3px!important">
		<tbody>
			<tr>
				<td align="center" valign="top" >
					<table border="0" cellpadding="0" cellspacing="0" style="width:100%;background-color:#d71a68;border-radius:3px 3px 0 0!important;color:#ffffff;border-bottom:0;font-weight:bold;line-height:100%;vertical-align:middle;font-family:&quot;Helvetica Neue&quot;,Helvetica,Roboto,Arial,sans-serif" >
						<tbody>
							<tr>
								<td style="padding:36px 48px;display:block" >
									<h1 style="color:#ffffff;font-family:&quot;Helvetica Neue&quot;,Helvetica,Roboto,Arial,sans-serif;font-size:30px;font-weight:300;line-height:150%;margin:0;text-align:left" >'.$title.'</h1>
								</td>
							</tr>
						</tbody>
					</table>
	
				</td>
			</tr>
			<tr>
				<td align="center" valign="top">
					<table border="0" cellpadding="0" cellspacing="0" width="600">
						<tbody>
							<tr>
								<td valign="top" style="background-color:#fdfdfd">
									<table border="0" cellpadding="20" cellspacing="0" width="100%" >
										<tbody>
											<tr>
												<td valign="top" style="padding:48px" >
													<div style="color:#737373;font-family:&quot;Helvetica Neue&quot;,Helvetica,Roboto,Arial,sans-serif;font-size:14px;line-height:150%;text-align:left" >
														<p style="margin:0 0 16px">'.$content.'</p>
	
														<h2 style="color:#d71a68;display:block;font-family:&quot;Helvetica Neue&quot;,Helvetica,Roboto,Arial,sans-serif;font-size:18px;font-weight:bold;line-height:130%;margin:16px 0 8px;text-align:left" >Login Credentials</h2>
														<ul>
															<li>
																<span>Username: </span>
																<strong style="color:#505050;font-family:&quot;Helvetica Neue&quot;,Helvetica,Roboto,Arial,sans-serif">'.$username.'</strong>
															</li>
															<li>
																<span>Password: </span>
																<strong style="color:#505050;font-family:&quot;Helvetica Neue&quot;,Helvetica,Roboto,Arial,sans-serif">'.$password.'</strong>
															</li>
														</ul>
														<p style="margin:0 0 16px">You can access the Love School using <a href="'.get_home_url( 2 ).'/login/">this link.</a></p>
														<p style="margin:0 0 16px">If you lose your password, you can always get another email with a new password in the Login page, as many times as you need.</p>
														<p style="margin:0 0 16px>You can also change your password in your profile page.</p>
													</div>
												</td>
											</tr>
										</tbody>
									</table>
								</td>
							</tr>
						</tbody>
					</table>
				</td>
			</tr>
	
			<tr>
				<td align="center" valign="top" >
					<table border="0" cellpadding="10" cellspacing="0" width="600">
						<tbody>
							<tr>
								<td valign="top" style="padding:0">
									<table border="0" cellpadding="10" cellspacing="0" width="100%" >
										<tbody>
											<tr>
												<td colspan="2" valign="middle" style="padding:0 48px 48px 48px;border:0;color:#c698b8;font-family:Arial;font-size:12px;line-height:125%;text-align:center">
													<p>AdinaRivers LoveSchool</p>
												</td>
											</tr>
										</tbody>
									</table>
								</td>
							</tr>
						</tbody>
					</table>
				</td>
			</tr>
		</tbody>
	</table>';
}

?>

