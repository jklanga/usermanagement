<title dir="ltr">Kuthula Langa's Test</title>
<meta name="description" content="">
{{ HTML::style('/css/bootstrap.min.css') }}
{{ HTML::style('/css/jquery-ui-1.8.23.custom.css') }}
{{ HTML::style('/css/main.css') }}
{{ HTML::style('/css/jquery.dataTables.min.css') }}
{{ HTML::style('/css/dataTables.bootstrap.min.css') }}

<script src="{{ URL::to('js/jquery-1.8.0.min.js') }}"></script>
<script src="{{ URL::to('js/jquery-ui-1.8.23.custom.min.js') }}"></script>
<script src="{{ URL::to('js/bootstrap.js') }}"></script>
<script src="{{ URL::to('js/tab.js') }}"></script>
<script src="{{ URL::to('js/jquery.fs.shifter.js') }}"></script>
<script src="{{ URL::to('js/jquery.dataTables.min.js') }}"></script>
<script src="{{ URL::to('js/scripts.js') }}"></script>

<script>
	$(document).ready(function() {
		$.shifter({
			maxWidth: Infinity
		});
	});
</script>

<!-- on click display -->

<script language="javascript" type="text/javascript">
function showHide(shID) {
   if (document.getElementById(shID)) {
      if (document.getElementById(shID+'-show').style.display != 'none') {
         document.getElementById(shID+'-show').style.display = 'none';
         document.getElementById(shID).style.display = 'block';
      }
      else {
         document.getElementById(shID+'-show').style.display = 'inline';
         document.getElementById(shID).style.display = 'none';
      }
   }
}
</script>

<!-- end on click -->