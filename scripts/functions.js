function liveSearch(){
  $('input.typeahead').typeahead({
    name: 'typeahead',
    remote: 'search.php?key=%QUERY',
    limit: 10
  });
}
