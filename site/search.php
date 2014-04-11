<?PHP
	require "../kshop/include.php";

	$query = '';
	$redirect = true;
	if     (array_key_exists('searchquery', $_POST))   $query = (string) $_POST['searchquery'];
	elseif (array_key_exists('searchquery', $_GET))  { $query = (string) $_GET['searchquery']; $redirect = false; }
	
	if ($redirect){
		header('Location: ?searchquery=' . urlencode($query));
		exit(0);
	}
	
	
	Layout::drawHeader();
	Layout::openCanvasAndSidebar('canvassearch');
	Bladermenu::drawBladermenu();
	Layout::closeSidebar();
	
	searchsysteem::search($query);
	
	Layout::closeCanvas();
	Layout::drawFooter();