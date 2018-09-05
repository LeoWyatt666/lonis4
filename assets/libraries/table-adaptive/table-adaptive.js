$(document).ready(function() {
  var headertext = [],
  th = document.querySelectorAll("table thead th"),
  td = document.querySelectorAll("table tbody td"),
  tbody = document.querySelector("table tbody"),
  thlength = 0, thtext = '', thwidth = 0;

  if(th.length && td.length && tbody.length) {

    for(var i = 0; i < th.length; i++) {
      var current = th[i];
      headertext.push(current.textContent.replace(/\r?\n|\r/,""));

      curthlength = current.textContent.length
      if(thlength < curthlength) {
        thlength = curthlength;
        thtext = current.textContent;
      }
    }
    
    thwidth = parseInt(getTextWidth(thtext).toFixed())+10;

    for (var i = 0, row; row = tbody.rows[i]; i++) {
      for (var j = 0, col; col = row.cells[j]; j++) {
        col.setAttribute("data-th", headertext[j]);
      } 
    }

    $('head').append('<style> \
      @media screen and (max-width: 767px) { \
        table tbody td:before { width: '+thwidth+'pt; } \
      } \
    </style>');

  }

});

function getTextWidth(text, font) {
  var canvas = getTextWidth.canvas || (getTextWidth.canvas = document.createElement("canvas"));
  var context = canvas.getContext("2d");
  context.font = font;
  var metrics = context.measureText(text);
  return metrics.width;
}