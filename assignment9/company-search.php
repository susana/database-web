#!/usr/local/bin/php
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>
			Company Search
		</title>
		<link href="http://schoolwebserver.edu/idef/db/asg9/default.css" rel="stylesheet" type="text/css" /> 
	</head>


	<body>
		<div id="container">
			<div id="header">
				<h2>Search for a Company</h2>
			</div>
			
			<div id="nav"> 
				<a href="http://schoolwebserver.edu/idef/db/asg9/welcome.html">Home</a> - 
				<a href="http://schoolwebserver.edu/cgi-bin/cgiwrap/idef/company-search.php">Search for a company</a> - 
				<a href="http://schoolwebserver.edu/cgi-bin/cgiwrap/idef/game-search.php">Search for a game</a> - 
				<a href="http://schoolwebserver.edu/cgi-bin/cgiwrap/idef/data-entry.php">Data entry for video game table</a> - 
				<a href="http://schoolwebserver.edu/idef/db/asg9/future.html">Coming Soon</a>
			</div>
			
			<div id="content">
				<p>
					
				</p>
				
				<form id="company-search-choices" name="company-search-choices" method="post" action="http://schoolwebserver.edu/cgi-bin/cgiwrap/idef/company-search-narrowed.php">
					<label>Choose a field to search by.
					<select name="searchChoices">
						<option value="name">Name</option>
						<option value="type">Company Type</option>
						<option value="city">Headquarters City</option>
						<option value="country">Headquarters Country</option>
					</select>
					</label>

					<p><input type="submit" value="Submit" name="submit"/></p>
				</form>
			</div>
		</div>
	</body> 
</html>