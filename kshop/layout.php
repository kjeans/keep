<?PHP

	class Layout {
	
		public static function drawFooter() {
?>

		</div>
		<div class="footer">
			<p>&copy; Copyright 2014 | Kate Schirm</p>
		</div>
		
<script type="text/javascript">
            $(function() {
                var d=1000;
                $('#menu span').each(function(){
                    $(this).stop().animate({
                        'top':'0px'
                    },d+=250);
                });

                $('#menu > li').hover(
                function () {
                    var $this = $(this);
                    $('a',$this).addClass('hover');
                    $('span',$this).stop().animate({'top':'-60px'},300).css({'zIndex':'10'});
                },
                function () {
                    var $this = $(this);
                    $('a',$this).removeClass('hover');
                    $('span',$this).stop().animate({'top':'0px'},800).css({'zIndex':'-1'});
                }
            );
            });
</script>
		
	</body>
</html>
<?PHP
		}
	
		public static function drawHeader() {
			?><!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<meta name="viewport" content="width=device-width" />
		<title>Keep in Touch!</title>
		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
		<script type="text/javascript" src="scripts/jquery-ui-1.7.2.custom.js"></script>
		<script type="text/javascript" src="scripts/jquery.ddslick.min.js"></script>
		<script type="text/javascript" src="scripts/jquery.tinycarousel.min.js"></script>
        <script type="text/javascript" src="scripts/fancybox/jquery.fancybox.pack.js"></script>
		<script type="text/javascript" src="scripts/hogan.js"></script>
		<script type="text/javascript" src="scripts/typeahead.min.js"></script>
		
		<link rel="stylesheet" type="text/css" href="css/style.css">

<script type="text/javascript">
            $(document).ready(function() {
										
				$('.typeahead').typeahead([{
					name: 'search',
					remote: 'searchresults.php?search=%QUERY',
					template: '<div class="xxx"><img src="{{image}}"><span class="searchlabel">{{label}}</span></div>',
					engine: Hogan
				}]);
				
				$('.beheerfoto').click(function(event){
					$(this).find('input').trigger('click');
				});
			
				$('#mediaslider').tinycarousel({duration: 500});
				
				$('.sortchanger').change(function(){
					$('#sortform').submit();
				});
			
                $('.ddslick').ddslick({
					truncateDescription: true, 
					height: 175,
					showSelectedHTML: true,
					onSelected: function(ddslickBox){
						$('#' + ddslickBox.original[0].id + '_target').val(ddslickBox.selectedData.value);
					}	
				});
				
				$('.extrareminder').change(function(event){
					if ($(this).is(':checked')) {
						$('tr.datum').show();
						$('tr.tijd').show();
					} else {
						$('tr.datum').hide();
						$('tr.tijd').hide();
					}
				});
				if ($('.extrareminder').is(':checked')) {
						$('tr.datum').show();
						$('tr.tijd').show();
				} else {
						$('tr.datum').hide();
						$('tr.tijd').hide();
				}	
            });
</script>
	</head>
<?PHP
				printf('<body>');
								
				printf('<div class="outside">');
				printf('  <div class="header">');
				printf('		<a href="home.php" class="keep">Keep in Touch!<img src="images/notesicon.png"/></a>');
				printf('		<a href="beheernote.php" class="toevoegen"><img src="images/noteplus1.png"></a>');
				printf('		<a href="home.php">Meest recent</a>');
				printf('		<a href="home.php?reminder=1">Herinnering</a>');
				printf('		<a href="home.php?archived=1">Afgerond</a>');
				printf('		<a href="home.php?favorite=1">Favorieten</a>');
				printf('		<select>');
				printf('			<option value="1">Contactpersoon oplopend</option>');
				printf('			<option value="2">Contactpersoon aflopend</option>');
				printf('		</select>');
							
				printf('      <div class="search">');
				printf('      	<form action="search.php" method="POST">');
				printf('      		<div class="searchbox"><input name="searchquery" class="typeahead searchbar" type="text" placeholder="Zoeken in notities"><input class="searchbutton" type="image" src="images/search/search.png" alt="Zoeken"></div>');
				printf('      	</form>');
				printf('      </div>');
				
				printf('</div>');
		}
		
		public static function openCanvasAndSidebar($pageclass) {
			printf('<table class="all %s">', $pageclass);
			echo '<tr>';
			echo '<td class="sidebar">';
		}
		
		public static function closeSidebar() {
			echo '</td>';
			echo '<td class="canvasO">';
			echo '<div class="canvas">';
		}
		
		public static function closeCanvas() {
			echo '</div>';
			echo '&nbsp;';
			echo '</td>';
			echo '</tr>';
			echo '</table>';
		}
	}