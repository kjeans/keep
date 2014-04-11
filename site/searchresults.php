<?PHP
	require "../kshop/include.php";

	$query = (string) @$_GET['search'];
	
	searchsysteem::searchJSON($query);
	