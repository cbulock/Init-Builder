function getInit()
{
  var url = 'index.php';
  var pars = Form.serialize($("data"));
  var myAjax = new Ajax.Updater( {success: 'init'}, url, { method: 'get', parameters: pars, onFailure: reportError });
}

function reportError(request)
{
  alert('Sorry. There was an error.');
}
