#!/usr/local/bin/php
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>
      Video Game Search
    </title>
    <link href="http://schoolwebserver.edu/idef/db/asg9/default.css" rel="stylesheet" type="text/css" /> 
  </head>

   
  <body>
    <div id="container">
      <div id="header">
        <h2>
          Search for a Game
        </h2>
      </div>
	  
      <div id="nav"> 
        <a href="http://schoolwebserver.edu/idef/db/asg9/welcome.html">Home</a> - 
        <a href="http://schoolwebserver.edu/cgi-bin/cgiwrap/idef/company-search.php">Search for a company</a> - 
        <a href="http://schoolwebserver.edu/cgi-bin/cgiwrap/idef/game-search.php">Search for a game</a> - 
        <a href="http://schoolwebserver.edu/cgi-bin/cgiwrap/idef/data-entry.php">Data entry for video game table</a> - 
        <a href="http://schoolwebserver.edu/idef/db/asg9/future.html">Coming Soon</a>
      </div>
	  
      <div id="content">		
        <form id="game-search-choices" name="game-search-choices" method="post" action="http://schoolwebserver.edu/cgi-bin/cgiwrap/idef/game-search-narrowed.php">
		<label>Choose a field to search by.
         <select name="searchChoices">
            <option value="title">Title</option>
            <option value="series">Series</option>
            <option value="exp_or_dlc">Game Type</option>
            <option value="genres">Genres</option>
            <option value="modes">Modes</option>
            <option value="languages">Languages</option>
            <option value="platforms">Platforms</option>
          </select>
        </label>
          <p><input type="submit" value="Submit" name="submit"/></p>
        </form>
      </div>
	</div>
  </body> 
</html>